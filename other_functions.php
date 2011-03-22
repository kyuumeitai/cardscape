<?php

/** Show list of cards in drafting area. */
function browse() {
	global $dbh, $smarty, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];
	$pagesize = $cfg[ 'database' ][ 'pagesize' ];
	$display_offset = intval( $_GET[ 'browse' ] );
	if( $display_offset < 0 ) $display_offset = 0;

	$query = $dbh -> prepare( 'SELECT c.id, c.name, c.date, c.status,
		u.name AS author FROM '.$prefix.'cards c LEFT JOIN
		'.$prefix.'users u ON c.author = u.uid
		LIMIT :offset, :pagesize' );

	$query -> bindValue( ':offset', $display_offset, PDO::PARAM_INT );
	$query -> bindValue( ':pagesize', $pagesize, PDO::PARAM_INT );

	$query -> execute();

	$cards = $query -> fetchAll( PDO::FETCH_CLASS, 'Card' );
	
	$smarty -> assign( 'cards', $cards );
	$smarty -> assign( 'offset', $display_offset );
	$smarty -> assign( 'pagesize', $pagesize );
	$smarty -> display( 'browse_cards.tpl' );
}

/** Show a list of log messages for changed cards */
function recent_activity() {
	global $dbh, $smarty, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];
	$pagesize = $cfg[ 'database' ][ 'pagesize' ];
	$display_offset = intval( $_GET[ 'recent_activity' ] );
	if( $display_offset < 0 ) $display_offset = 0;

	$query = $dbh -> prepare( 'SELECT h.date, h.action, c.id AS card_id, c.name AS card_name, u.uid AS user_id, u.name AS username
		FROM '.$prefix.'history h
		LEFT JOIN '.$prefix.'users u ON h.user = u.uid
		LEFT JOIN '.$prefix.'cards c ON h.card = c.id
		LIMIT :offset, :pagesize' );

	$query -> bindValue( ':offset', $display_offset, PDO::PARAM_INT );
	$query -> bindValue( ':pagesize', $pagesize, PDO::PARAM_INT );

	$query -> execute();

	$hist_entries = $query -> fetchAll( PDO::FETCH_ASSOC );
	$smarty -> assign( 'hist_entries', $hist_entries );
	$smarty -> assign( 'offset', $display_offset );
	$smarty -> assign( 'pagesize', $pagesize );
	$smarty -> display( 'history.tpl' );
}

/** Create statistics about the cards in the DB */
function statistics() {
	global $dbh, $smarty, $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ];
	$fields = $cfg[ 'database' ][ 'statistic_fields' ];

	$query = $dbh -> prepare( 'SELECT '.$fields.' FROM '.$prefix.'cards' );
	$query -> execute();

	$fields = explode( ',', $fields );

	$statistics = array();
	foreach( $fields as $field ) {
		$statistics[ $field ] = array();
	}

	while( $card_data = $query -> fetch( PDO::FETCH_ASSOC ) ) {
		foreach( $fields as $field ) {
			$val = $card_data[ $field ];
			if( isset( $statistics[ $field ][ $val ] ) ) {
			       $statistics[ $field ][ $val ]++;
			} else
		 		$statistics[ $field ][ $val ] = 1;		
		}
	}

	foreach( $fields as $field ) {
		$smarty -> assign( 'field', $field );
		$smarty -> assign( 'counts', $statistics[ $field ] );
		$smarty -> display( 'statistics.tpl' );
	}

}
?>
