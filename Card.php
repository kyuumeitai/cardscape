<?php
/* WTactics specific card class definition. If you want to use Cardscape for a
   different game, you need to adjust this file */

define( 'STR', 'VARCHAR(31)' );
define( 'TEXT', 'VARCHAR(255)' );

$cardFields = array( //predefined fields: id, ancestor, date, author. [ENUM {SET
	'name' => STR,
	'cost' => 'INT',
	'threshold' => 'INT',
	'faction' => 'ENUM( "Gaia","Red Banner","Empire","Shadowguild","House of Nobles" )',
	'type' => 'ENUM( "unit","event","spell","entchantment","artifact","equipment" )',
	'subtype' => STR,
	'rules' => TEXT,
	'flavor' => TEXT,
	'image' => TEXT,
	'attack' => 'INT',
	'defense' => 'INT' ); ///< The properties of a card in WTactics

/*
	'revision' => 'INT', 'official'
*/

/** Generate SQL code to create card tables. 
  @return A string for the development table creation */
function SQL_card_table() {
	global $cfg;
	$prefix = $cfg[ 'database' ][ 'prefix' ]; ///< Table prefix
	$sql = 'CREATE TABLE '.$prefix.'cards
	( id INT AUTO_INCREMENT PRIMARY KEY,
	ancestor INT,
	date TIMESTAMP,
	author INT,
	status ENUM( "concept", "new", "discussed", "playtested", "official", "rejected", "superseded" )';

	global $cardFields;
	while( list( $name, $type ) = each( $cardFields ) ) {
		$sql .= ', '.$name.' '.$type;
	}
	return $sql.');';
}

/** A dirty function that extracts all types of cards as a list from $cardFields
 @return A list of types (as strings)  */
function getCardTypes() {
	global $cardFields;
	$types = rtrim( substr( $cardFields[ 'type' ], 7 ), ') "' );
	return doubleArray( explode( '","', $types ) );
}

/** Another dirty function that extracts all factions from $cardFields
  @return A list of factions */ //TODO summarize with function above
function getFactions() {
	global $cardFields;
	$factions = rtrim( substr( $cardFields[ 'faction' ], 7 ), ') "' );
	return doubleArray( explode( '","', $factions ) );
}

/** The Card class. Its members should be identical to those in cardFields plus 
  id, ancestor, date and author. */
class Card {
	
	public $id; ///< Database key
	public $ancestor; ///< id of ancestor
	public $date; ///< last modified date
	public $author; ///< author's id

	public $name; ///< Official name of the card
	public $cost = 1; ///< Cost in gold of the card
	public $threshold = 0; ///< Threshold value of the card's faction
	public $faction; ///< The card's faction
	public $type; ///< The card's type (unit, spell,...)
	public $subtype; ///< The subtype of the card if existant
	public $rules; ///< The ruletex of the card
	public $flavor; ///< The informal flavor text
	public $image; ///< Image description, image URL or image reference
	public $attack = 0; ///< Units only: The attack value
	public $defense = 0; ///< Units only: The defense value
	public $status; ///< Card Development Area only: The card's development status
	public $revision; ///< Official Card Area only: Revision of this card
}
?>
