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
		htmlspecialchars( $action ) ) );
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
	$comments_tpl = 'comments';
        if( !isset( $_SESSION[ 'js_on' ] ) ) {
		$_SESSION[ 'js_on' ] = false;
	}

	$comments_tpl .= $_SESSION[ 'js_on' ]? '_javascript' : '';
	$smarty -> display( $comments_tpl . '.tpl' );


	/* now show the history */
	$query = $dbh -> prepare(
		'SELECT u.name, h.action, h.date FROM '.$prefix.'history h
		LEFT JOIN '.$prefix.'users u ON h.user = u.uid WHERE h.card = ?' );
	$query -> execute( array( $card_id ) );

	$hist_entries = $query -> fetchAll( PDO::FETCH_ASSOC );
	$smarty -> assign( 'hist_entries', $hist_entries );
	$smarty -> display( 'card_history.tpl' );
}

function show_official_card( $card_id ) {
	global $dbh, $smarty, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];
	$query = $dbh -> prepare( 'SELECT * FROM '.$prefix.'official WHERE
		id = ?' );
	$query -> execute( array( $card_id ) );
	$official_data = $query -> fetch( PDO::FETCH_ASSOC );

	$card_dev_id = $official_data[ 'dev_id' ];

	$query = $dbh -> prepare(
		'SELECT * FROM '.$prefix.'cards WHERE id = ?' );
	$query -> execute( array( $card_dev_id ) );
	$card = $query -> fetchObject( 'Card' );

	$smarty -> assign( 'official_data', $official_data );
	$smarty -> assign( 'card', $card );
	$smarty -> display( 'official_card.tpl' );

	//TODO comment board
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
		':name' => htmlspecialchars( $_POST[ 'cardname' ] ),
		':author' => $_SESSION[ 'uid' ],
		':faction' => htmlspecialchars( $_POST[ 'faction' ] ),
		':type' => htmlspecialchars( $_POST[ 'cardtype' ] ),
		':subtype' => htmlspecialchars( $_POST[ 'subtype' ] ),
		':cost' => intval( $_POST[ 'cost' ] ),
		':threshold' => intval( $_POST[ 'threshold' ] ),
		':attack' => intval( $_POST[ 'attack' ] ),
		':defense' => intval( $_POST[ 'defense' ] ),
		':rules' => htmlspecialchars( $_POST[ 'rules' ] ),
		':flavor' => htmlspecialchars( $_POST[ 'flavor' ] ),
		':image' => htmlspecialchars( $_POST[ 'imgdesc' ] ) );
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
		':text' => htmlspecialchars( $_POST[ 'reply_text' ] ) );
	if( !$query -> execute( $params ) ) {
		error( 'Your comment could not be added' );
	}
	error( 'Comment successfully added!', 'notice' );
	show_card( $card_id );
}

/** Show a form for a new revision of a card
  @param card_id the id of the card that will be revised
*/
function revise_card( $card_id, $update_only = false ) {
	global $dbh, $smarty, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];

	$query = $dbh -> prepare( 'SELECT * FROM '.$prefix.'cards
		WHERE id = ?' );
	$query -> execute( array( intval( $card_id ) ) );
	if( !$card = $query -> fetchObject( 'Card' ) ) {
		error( 'Invalid card id!' );
	}

	$smarty -> assign( 'card', $card );
	$smarty -> assign( 'typeoptions', getEnumValues( 'type' ) );
	$smarty -> assign( 'factionsoptions', getEnumValues( 'faction' ) );
	$smarty -> assign( 'statusoptions', getEnumValues( 'status' ) );
	$smarty -> display( 'new_card.tpl' );
}

/** Update a card without creation of a new revision
  This function is reserved for gamemakers */
function update_card_submit( $card_id ) {
	global $dbh, $smarty, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];

	$query = $dbh -> prepare( 'UPDATE '.$prefix.'cards SET
		status = ?,
		name = ?,
		cost = ?,
		threshold = ?,
		faction = ?,
		type = ?,
		subtype = ?,
		rules = ?,
		flavor = ?,
		image = ?,
		attack = ?,
		defense = ?
		WHERE id = ?' );
	$params = array(
		htmlspecialchars( $_POST[ 'card_status' ] ), //status
		htmlspecialchars( $_POST[ 'cardname' ] ), //name
		intval(           $_POST[ 'cost' ] ),
		intval(           $_POST[ 'threshold' ] ),
		htmlspecialchars( $_POST[ 'faction' ] ),
		htmlspecialchars( $_POST[ 'cardtype' ] ),
		htmlspecialchars( $_POST[ 'subtype' ] ),
		htmlspecialchars( $_POST[ 'rules' ] ),
		htmlspecialchars( $_POST[ 'flavor' ] ),
		htmlspecialchars( $_POST[ 'imgdesc' ] ), //image
		intval(           $_POST[ 'attack' ] ),
		intval(           $_POST[ 'defense' ] ),
		htmlspecialchars( $_GET[ 'update_card_submit' ] ) ); //id

	$query -> execute( $params );

	$uid = $_SESSION[ 'uid' ];
	$card_id = intval( $_GET[ 'update_card_submit' ] );
	$comment = htmlspecialchars( $_POST[ 'admin_update_comment' ] );
	if( strlen( $comment ) ) {
		log_entry( $uid, $card_id, $comment );
	} else {
		$status = $_POST[ 'card_status' ];
		log_entry( $uid, $card_id, 'Status ('.$status.')' );
	}

	error( 'Card has been updated', 'notice' );

	show_card( $_GET[ 'update_card_submit' ] );
}

?>
