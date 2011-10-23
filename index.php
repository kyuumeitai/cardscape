<?php
/**
 @file
 @section LICENSE
   This program is licensed under the GNU Affero General Public License. See the LICENSE file for details
 @section DESCRIPTION
 index.php - all the things that need to be done each time.
*/

//TODO make sure all templates escape HTML
error_reporting( E_ALL );

require( 'util.php' );
require( 'SmartInit.php' );
require( 'config.php' );
require( 'Card.php' );

session_start();

/* start smarty */
$smarty = new SmartInit();
$smarty -> assign( 'cfg', $cfg );
$smarty -> assign(
	'role', 
	( isset( $_SESSION[ 'role' ]) )? $_SESSION[ 'role' ] : 'guest' );

$smarty -> display( 'header.tpl' );

/**
Utility function to show an error message in HTML
@param message The message to show to the user
@param type the type (also CSS class) of the error box. If type is 'error' execution is halted after display of the error message
*/
function error( $message, $type = 'error' ) {
	global $smarty;
	$smarty -> assign( 'error', $message );
	$smarty -> assign( 'type', $type );
	$smarty -> display( 'error.tpl' );
	if( $type == 'error' ) die();
}

/**
  Error handler. Will later be modified to write error messages into a database so that the admin will be able to see what happend
@param errno Error number
@param errstr error message
@param errfile file in which the error occurred
@param errline line in which the error occurred
@param context state of environment variables when things went wrong
 */
function errorHandler( $errno, $errstr, $errfile, $errline, $context ) {
	error( $errstr . '<br />location: ' . $errfile . ':' . $errline );
}

/* non-critical error handler & session */
set_error_handler( 'errorHandler' );


/* start DB */
$db_cfg = $cfg[ 'database' ];

try {
	$dbh = new PDO( $db_cfg[ 'pdo_params' ],
	                $db_cfg[ 'user' ],
	                $db_cfg[ 'pass' ] );
} catch( PDOException $e ) {
	error( 'DB connection failed: ' . $e -> getMessage() );
}

/** check if a user is allowed to perform a certain action.
  @param role the minimum role required to perform the action
  @param critical If true, abort PHP processing if user is not authorized. Otherwise return true or false */
function check_permission( $role = 'user', $critical = true ) {
	if( !isset( $_SESSION[ 'role' ] ) ) {
		$_SESSION[ 'role' ] = 'guest';
	}

	$priv = false;
	switch( $_SESSION[ 'role' ] ) {
		case 'admin':     $priv |= $role == 'admin';
		case 'gamemaker': $priv |= $role == 'gamemaker';
		case 'moderator': $priv |= $role == 'moderator';
		case 'user':      $priv |= $role == 'user';
	}

	if( $priv ) return true;
	elseif( $critical ) error( 'You are not authorized to do this!' );
	return false;
}

/* the actions */
$actions = array(
		/* CARD FUNCTIONS */

	'show_card' => function() {
		show_card( $_GET[ 'show_card' ] ); },

	'show_official_card' => function() {
		show_official_card( $_GET[ 'show_official_card' ] ); },

	'new_card' => function() {
		check_permission();
		global $smarty;
		$smarty -> assign( 'card', new Card() ); //dummy card
		$smarty -> assign( 'typeoptions', getEnumValues( 'type' ) );
		$smarty -> assign( 'factionsoptions', getEnumValues( 'faction' ) );
		$smarty -> display( 'new_card.tpl' ); },

	'new_card_submit' => function() {
		check_permission();
		new_card_submit(); },

	'revise_card' => function() { //create a new modified card
		check_permission();
		revise_card( $_GET[ 'revise_card' ] ); },

	'revise_card_submit' => function() { //a small internal redirect
		check_permission();
		new_card_submit( $_GET[ 'revise_card_submit' ] ); },

	'update_card' => function() {
		check_permission( 'gamemaker' );
		revise_card( $_GET[ 'update_card' ], true ); },

	'update_card_submit' => function() {
		check_permission( 'gamemaker' );
		update_card_submit( $_GET[ 'update_card_submit' ] );
	},

	'delete_card' => function() { //TODO
		check_permission( 'moderator' );
		delete_card($_GET["id"]);},

	'comment_reply' => function() {
		check_permission();
		comment_reply( $_GET[ 'comment_reply' ] );
	},
	'comment_reply_submit' => function() {
		check_permission();
		if( !isset( $_SESSION[ 'role' ] ) ) {
			error( 'You need to be logged in to reply!' );
		}
		comment_reply_submit( $_GET[ 'comment_reply_submit' ] );
	},




	/* USER FUNCTIONS */
	'login' => function() {
		global $smarty;
		$smarty -> display( 'login.tpl' ); },

	'login_submit' => function() {
		login_submit(); },

	'logout' => function() {
		session_destroy();
		error( 'You are now logged out', 'notice' ); },

	'register' => function() {
		global $smarty;
		$smarty -> display( 'register.tpl' ); },

	'register_submit' => function() {
		register_submit(); },

	'usercp' => function() {
		check_permission();
		show_usercp(); },

	'update_user' => function() {
		check_permission( 'user' );
		if( isset( $_POST[ 'other_uid' ] ) ) {
			check_permission( 'gamemaker' );
			update_user( $_POST[ 'other_uid' ] );
		} else {
			update_user( $_SESSION[ 'uid' ] );
		}
	},

	'delete_user' => function() {
		check_permission( 'self' );
		delete_user($_GET[ 'delete_user' ] ); },

	'show_user' => function() {
		check_permission(); //keep Google out
		show_user($_GET[ 'show_user' ] ); },

	/* COMMENT FUNCTIONS */
	//'delete_comment' => function(){ //important, but I'll take care of that later
	//	delete_comment($_GET['id']);},
	//'insert_comment' => function(){
	//	insert_comment($_GET['id']);},

	/* OTHER FUNCTIONS */

	'browse' => function() {
		browse(); },

	'browse_official_cards' => function() {
		browse( true ); },

	'recent_activity' => function() {
		recent_activity(); },

	'statistics' => function() { //progress report
		statistics(); },
	'enable_js' => function() {
		$_SESSION[ 'js_on' ] = true; },
	'disable_js' => function() {
		$_SESSION[ 'js_on' ] = false; },

	);

/** A function that includes further necessary files
@param action Depending on the value of $action a spefic PHP file is included that contains the neccessary function definitons */
function requirements( $action ) {
	switch( $action ) {
		case 'show_card':
		case 'show_official_card':
		case 'new_card_submit':
		case 'revise_card':
		case 'revise_card_submit':
		case 'update_card':
		case 'delete_card':
		case 'comment_reply':
		case 'comment_reply_submit':
		case 'update_card_submit':
			require_once( 'card_functions.php' );
			break;
		case 'upload_image': case 'save_upload':
			require_once( 'image_functions.php' ); break;
		case 'login_submit': case 'logout':
		case 'register': case 'register_submit':
			require_once( 'login_functions.php' ); break;
		case 'insert_user': case 'usercp': case 'update_user':
		case 'delete_user': case 'show_user':
			require_once( 'user_functions.php' ); break;
		case 'browse': case 'browse_official_cards':
		case 'recent_activity': case 'statistics':
			require_once( 'other_functions.php' ); break;
		case 'new_card': case 'login':
		case 'enable_js': case 'disable_js':
			break; //nothing needs to be done
		default:
			error( 'No include requirements could be found' );
	}
}

/* and now decide what to do */
if( count( $_GET ) ) { //is there a specific request?
	foreach( $_GET as $key => $value ) {
		if( isset( $actions[ $key ] ) ) {
			requirements( $key );
			$actions[ $key ]();
		}
	}

} else $smarty -> display( 'index.tpl' );

$smarty -> display( 'footer.tpl' );
