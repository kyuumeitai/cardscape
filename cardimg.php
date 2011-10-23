<?php /* This file generates card images */
require_once( 'config.php' );
$cardscape_root = $cfg[ 'dirs' ][ 'cardscape_root' ];

$imgfile = $cardscape_root.'card_images/not_found.png';

if( isset( $_GET[ 'name' ] ) ) { //card from card pool
	$name = $_GET[ 'name' ];
	if( preg_match( '/^\w*$/', $name ) ) {
		$filename = $cardscape_root.'/card_images/'.$name.'.png';
		if( is_readable( $filename ) ) {
			$imgfile = $filename;
		}
	}
}

header(
	'Location: '.$imgfile,
	true,
	307 );
die();

/*
header( 'Content-Type: image/png' );
*/


?>
