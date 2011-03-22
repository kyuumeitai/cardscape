<?php /* This file generates card images */
require_once( 'config.php' );
$cardscape_root = $cfg[ 'dirs' ][ 'cardscape_root' ];
if( true ) { //if image for card does not exist yet
	header(
		'Location: '.$cardscape_root.'card_images/not_found.png',
		true,
		307 );
	die();
}

header( 'Content-Type: image/png' );
/* TODO */


?>
