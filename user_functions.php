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
	global $cfg, $dbh;
	$prefix = $cfg[ 'database' ][ 'prefix' ];
	//determine if this is an admin action or a user action
	if( isset( $_POST[ 'user_role' ] ) ) {
		check_permission( 'gamemaker' );
		$query = $dbh -> prepare( 'UPDATE '.$prefix.'users
			SET name = ?, role = ?  WHERE uid = ?' );
		$query -> execute( array(
			htmlspecialchars( $_POST[ 'user_name' ] ),
			htmlspecialchars( $_POST[ 'user_role' ] ),
			intval(           $_POST[ 'other_uid' ] ) ) );
		error( 'User settings changed', 'notice' );
		show_usercp();
		return;
	}



}

?>
