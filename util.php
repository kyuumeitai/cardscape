<?php

function doubleArray( $arr ) {
	$result = array();
	foreach( $arr as $e ) {
		$result[ $e ] = $e;
	}
	return $result;
}

?>
