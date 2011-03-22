<?php

function show_usercp() {
	global $smarty, $dbh, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];
	
	$user_roles = doubleArray( //called from util.php
		array( 'user', 'moderator', 'gamemaker', 'admin' ) );

	/* get user data */
	$query = $dbh -> prepare( 'SELECT * FROM '.$prefix.'users WHERE uid = ?' );
	$query -> execute( array( $_SESSION[ 'uid' ] ) );

	$user = $query -> fetchObject();
	$smarty -> assign( 'user', $user );
	$smarty -> assign( 'user_roles', $user_roles );
	$smarty -> display( 'usercp.tpl' );
}

function update_user( $uid ) {
	print_r( $_POST );
	error( 'this still has to be implemented' );

}

?>
