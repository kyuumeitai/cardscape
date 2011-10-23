<?php
/** Log in. */
function login_submit() {
	global $dbh;
	global $cfg;
	$db_conf = $cfg[ 'database' ];
	$prefix = $db_conf[ 'prefix' ];
	$salt = $db_conf[ 'salt' ];
	$cardscape_root = $cfg[ 'dirs' ][ 'cardscape_root' ];

	$query = $dbh -> prepare( 'SELECT uid,password, role FROM
		'.$prefix.'users WHERE name = ? LIMIT 1' );
	$query -> execute( array( $_POST[ 'user' ] ) );

	$data = $query -> fetch( PDO::FETCH_ASSOC );
	
	if( $data && $data[ 'password' ] == md5( $salt . $_POST[ 'pass' ] ) ) {
		$_SESSION[ 'user' ] = $_POST[ 'user' ];
		$_SESSION[ 'uid' ] = $data[ 'uid' ];
		$_SESSION[ 'role' ] = $data[ 'role' ];
		$_SESSION[ 'js_on' ] = $_POST[ 'js_on' ] == '1';
		error( 'You are now logged in.', 'notice' );
	} else 	error( 'Wrong password or username!' );
}

/** Register new user. */
function register_submit() {
	global $dbh;
	global $cfg;
	$db_conf = $cfg[ 'database' ];
	$prefix = $db_conf[ 'prefix' ];
	$salt = $db_conf[ 'salt' ];

	/* check if user already exists */
	$query = $dbh -> prepare( 'SELECT COUNT(*) FROM '.$prefix
		.'users WHERE name = ?' );
	$query -> execute( array( $_POST[ 'user' ] ) );
	if( $query -> fetchColumn() ) {
		error( 'This usermane is already taken!' );
	}

	/* TODO check captcha */
	$query = $dbh -> prepare( 'INSERT INTO '.$prefix.'users(
		name, password, mail, role ) VALUES( ?, ?, ?, ? )' );
	if( $query -> execute( array(
		htmlspecialchars( $_POST[ 'user' ] ),
		md5( $salt . $_POST[ 'pass' ] ),
		htmlspecialchars( $_POST[ 'mail' ] ),
		'user' ) ) ) {

		error( 'Registration successful! You can now log in', 'notice' );
	} else {
		$err = $query -> errorInfo();
		error( $err[ 2 ] );
	}
}
?>
