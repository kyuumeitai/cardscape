<?php
/**
  @file
  @section LICENSE
   This program is licensed under the GNU Affero General Public License. See the LICENSE file for details
  @section DESCRIPTION
  Functions related to cards. Some of this functionality should be moved to Card.php to make it more portable
*/

/**
  Create a log entry
  @param user the user's id that has triggered the log entry
  @param card the card's id that's affected by the event
  @param action the action that was performend (string)
*/
function log_entry( $user, $card, $action ) {
	global $dbh;
	global $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];
	$query = $dbh -> prepare( 'INSERT INTO '.$prefix.'history (
		user, card, action ) VALUES ( ?, ?, ? )' );
	$query -> execute( array(
		intval( $user ),
		intval( $card ),
		$action ) );
}

/** A class for holding comments. Each comment may have a parent, siblings and/or children. A comment gains a child if someone writes an answer to that comment. This answer is considered a child. Therefore discussions spread out like a tree */
class CommentItem {
	public $parent = 0; ///< ID of parent. default: 0 = no parent
	public $children = array(); ///< All direct answers to this comment
	public $elder = null; ///< the ID of the next older answer to the same parent.
	public $younger = null; ///< the ID of the next newer answer to the same parent

	public $id, $date, $name, $mail, $text;
}

/**
  Get various information about a card and display it
  @param card_id The id of the card that should be displayed
*/
function show_card( $card_id ) {
	global $dbh;
	global $smarty;
	global $cfg;
	$card_id = intval( $card_id );
	$prefix = $cfg[ 'database' ][ 'prefix' ];
	$query = $dbh -> prepare( 'SELECT * FROM '.$prefix
		.'cards WHERE id = ? LIMIT 1' );

	$query -> execute( array( $card_id ) );

	if( $card = $query -> fetchObject( 'Card' ) ) {
		$smarty -> assign( 'card', $card );
		$smarty -> display( 'card.tpl' );
	} else error( 'The requested card ('.$card_id.') could not be found!',
		'notice' );


	/* show the ancestry */
	$query = $dbh -> prepare( 'SELECT id, name, status FROM '.$prefix.'cards
		WHERE id = ?' );
	
	$query -> execute( array( $card -> ancestor ) );
	$ancestor = $query -> fetchObject( 'Card' ); //may be false if no ancestor exists. This is not a bug!

	$query = $dbh -> prepare( 'SELECT id, name, status FROM '.$prefix.'cards
		WHERE ancestor = ?' );
	$query -> execute( array( $card_id ) );
	$descendants = $query -> fetchAll( PDO::FETCH_CLASS, 'Card' );

	$smarty -> assign( 'ancestor', $ancestor );
	$smarty -> assign( 'descendants', $descendants );
	$smarty -> display( 'ancestry.tpl' );


	/* now show the comments */
	$query = $dbh -> prepare( 'SELECT c.id, c.date, c.parent, u.name, u.mail,
		c.text FROM '.$prefix.'comments c LEFT JOIN '.$prefix.'users u
		ON c.user = u.uid WHERE card = ?' );
	$query -> execute( array( $card_id ) );

	$comments = array(); //mapping: id -> CommentItem

	/* push all comments into the $comments array and clarify
	   relationships between comments */
	while( $item = $query -> fetchObject( 'CommentItem' ) ) { //auto-assign parent
		$id = $item ->id; //just a shortcut
		$comments[ $id ] = $item;

		if( $item -> parent == 0 ) {
			continue; //root comment
		}

		/* tell parent about its child */
		$siblings = & $comments[ $item -> parent ] -> children;
		array_push( $siblings,  $id );
		$num_siblings = count( $siblings );
		if( $num_siblings > 1 ) { //we have brothers and sisters!
			$elder = $siblings[ $num_siblings - 2 ];
			$comments[ $elder ] -> younger = $id; //tell the elder of the younger
			$item -> elder = $siblings[ $num_siblings - 2 ]; //and the younger of the elder
		}
			

	}

	$smarty -> assign( 'comments', $comments );
	$smarty -> display( 'comments.tpl' );


	/* now show the history */
	$query = $dbh -> prepare(
		'SELECT u.name, h.action, h.date FROM '.$prefix.'history h
		LEFT JOIN '.$prefix.'users u ON h.user = u.uid WHERE h.card = ?' );
	$query -> execute( array( $card_id ) );

	$hist_entries = $query -> fetchAll( PDO::FETCH_ASSOC );
	$smarty -> assign( 'hist_entries', $hist_entries );
	$smarty -> display( 'card_history.tpl' );
}

function new_card_submit( $ancestor = 0 ) {
	global $dbh, $smarty, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];
	//echo '<pre>'; print_r( $_POST ); echo '</pre>';

	$query = $dbh -> prepare( 'INSERT INTO '.$prefix.'cards( ancestor,
		name, author, status, faction, type, subtype, cost, threshold,
		attack, defense, rules, flavor, image) VALUES( :ancestor, :name,
		:author, :status, :faction, :type, :subtype, :cost, :threshold,
		:attack, :defense, :rules, :flavor, :image )'
		);

	//TODO shouldn't this be unified?
	$values = array(
		':ancestor' => intval( $ancestor ),
		':name' => $_POST[ 'cardname' ],
		':author' => $_SESSION[ 'uid' ],
		':faction' => $_POST[ 'faction' ],
		':type' => $_POST[ 'cardtype' ],
		':subtype' => $_POST[ 'subtype' ],
		':cost' => $_POST[ 'cost' ],
		':threshold' => $_POST[ 'threshold' ],
		':attack' => $_POST[ 'attack' ],
		':defense' => $_POST[ 'defense' ],
		':rules' => $_POST[ 'rules' ],
		':flavor' => $_POST[ 'flavor' ],
		':image' => $_POST[ 'imgdesc' ] );
	$values[ ':status' ] = (isset( $_POST[ 'concept' ] ) )? 'concept':'new';
		
	if( $query -> execute( $values ) ) {
		$newestID = $dbh -> lastInsertId();//TODO race condition?
		//this returns one number too high. What's going on?

		log_entry( $_SESSION[ 'uid' ], $newestID, 'Creation ('.
			$values[ ':status' ].')' );

		//create initial comment
		comment_reply_submit( 0, $newestID );

		error( 'Card successfully created!', 'notice' );

	} else {
		print_r( $query -> errorInfo() );
	}
}

/* Get the card's id of a card's comment. Each comment is associated with a card.
   @param comment The id of the comment
*/
function get_card_id_of_comment( $comment ) {
	global $dbh, $cfg;

	$prefix = $cfg[ 'database' ][ 'prefix' ];

	$query = $dbh -> prepare( 'SELECT card FROM '.$prefix.'comments
		WHERE id = ?' );
	$query -> execute( array( $comment ) );
	if( !$card_id = $query -> fetchColumn() ) {
		error( 'Comment does not have a card associated with it!' );
	}
	return intval( $card_id );
}

/**
  Show a comment form. This includes a linear history of the last comments in the current lineage
 */
function comment_reply( $comment ) {
	//print_r( $_SESSION );
	global $dbh, $smarty, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];

	//save comment as long as it's a string
	$smarty -> assign( 'reply_to', $comment );

	//and make it an int for the SQL functions
	$comment = intval( $comment );

	/* first of all, display card again */
	$card_id = get_card_id_of_comment( $comment );

	$query = $dbh -> prepare( 'SELECT * FROM '.$prefix
		.'cards WHERE id = ? LIMIT 1' );
	$query -> execute( array( $card_id ) );

	if( $card = $query -> fetchObject( 'Card' ) ) {
		$smarty -> assign( 'card', $card );
		$smarty -> display( 'card.tpl' );
	} else error( 'The associated card could not be found!', 'notice' );


	/* and now get the lineage of the $comment */
	$query = $dbh -> prepare( 'SELECT u.name, c.date, c.text, c.parent FROM
		'.$prefix.'comments c LEFT JOIN '.$prefix.'users u
		ON c.user = u.uid WHERE c.id = ?  LIMIT 1' );


	$comments = array(); //get lineage of this comment
	while( $query -> execute( array ( $comment ) ) ) {
		$old_comment = $query -> fetch( PDO::FETCH_ASSOC );
		array_push( $comments, $old_comment );
		if( count( $comments ) > 4 ) break; //move to config?
		$comment = $old_comment['parent'];
	}
	//echo '<pre>'; print_r( $query -> errorInfo() ); echo '</pre>';

	$smarty -> assign( 'comments', $comments );
	$smarty -> display( 'commentform.tpl' );

}

/** Insert new comment.
  @param comment The text of the comment
  @param card_id The id of the card that's commented on
*/
function comment_reply_submit( $comment, $card_id = null ) {
	global $dbh, $smarty, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];
	$comment = intval( $comment );
	if( !$card_id ) $card_id = get_card_id_of_comment( $comment );

	$query = $dbh -> prepare( 'INSERT INTO '.$prefix.'comments(
		user, card, parent, text ) VALUES(
		:user, :card, :parent, :text )' );
	$params = array(
		':user' => $_SESSION[ 'uid' ],
		':card' => $card_id,
		':parent' => $comment,
		':text' => $_POST[ 'reply_text' ] );
	if( !$query -> execute( $params ) ) {
		error( 'Your comment could not be added' );
	}
	error( 'Comment successfully added!', 'notice' );
	show_card( $card_id );
}

/** Show a form for a new revision of a card
  @param card_id the id of the card that will be revised
*/
function revise_card( $card_id ) {
	global $dbh, $smarty, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];

	$query = $dbh -> prepare( 'SELECT * FROM '.$prefix.'cards
		WHERE id = ?' );
	$query -> execute( array( intval( $card_id ) ) );
	if( !$card = $query -> fetchObject( 'Card' ) ) {
		error( 'Invalid card id!' );
	}

	$smarty -> assign( 'card', $card );
	$smarty -> assign( 'typeoptions', getCardTypes() );
	$smarty -> assign( 'factionsoptions', getFactions() );
	$smarty -> display( 'new_card.tpl' );
}

?>
