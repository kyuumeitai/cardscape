<?php //this is only a small installer file that sets the DB up. No fancy HTML output is provided

$success = 0;

require_once( 'config.php' );
require_once( 'Card.php' );

if( !$cfg[ 'general' ][ 'accept_license' ] ) {
	die( 'You must accept the license!' );
}

$db_cfg = $cfg[ 'database' ];

$db_setup = file( 'cardscape.sql' );
if( $db_cfg[ 'prefix' ] ) {

	/* change queries to use prefix */
	$prefix = $db_cfg[ 'prefix' ];
	for( $i = 0; $i < count( $db_setup ); $i++ ) {
		$db_setup[ $i ] =
			preg_replace(
				'/CREATE TABLE /',
				'CREATE TABLE '.$prefix,
				$db_setup[ $i ] );
	}
}

//echo '<pre>'; print_r( implode( '', $db_setup ) ); echo '</pre>';

try {
	$dbh = new PDO( $db_cfg[ 'pdo_params' ],
	                $db_cfg[ 'user' ],
	                $db_cfg[ 'pass' ] );
} catch( PDOException $e ) {
	die( 'Database connection could not be established!' );
}

$query = $dbh -> prepare( implode( '', $db_setup ) );
if( $query -> execute() ) {
	echo 'basic tables successfully added<br />';
	$success++;
} else {
	echo '<pre>';
	print_r( $query -> errorInfo() );
	echo '</pre>';
}

$query = $dbh -> prepare( SQL_card_table() );
if( $query -> execute() ) {
	echo 'Game specific table(s) successfully created<br />';
	$success++;
} else {
	echo '<pre>';
	print_r( $query -> errorInfo() );
	echo '</pre>';
}

if( $success == 2 ) {
	echo '<a href="index.php">continue...</a><br />';
}
?>
