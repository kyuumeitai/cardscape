<?php

/* Copyright (C) 2012  Cardscape project
 * Web based collaborative platform for creating Collectible Card Games
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$server = '<DB SERVER>';
$username = '<DB USER>';
$password = '<DB PASS>';
$database = '<DB NAME>';

if (($conn = mysql_connect($server, $username, $password))) {

    if (mysql_select_db($database)) {
        if (($qresult = mysql_query('SELECT * FROM wt_cs_cards'))) {
            $existing = array();
            while (($row = mysql_fetch_assoc($qresult))) {
                $existing[] = $row;
            }
            mysql_free_result($qresult);

            //1 - name
            //2 - rules
            //3 - cost
            //4 - threshold
            //5 - attack
            //6 - defense
            //7 - flavor
            //8 - subtype
            //9 - faction
            //10 - type
            if (!mysql_query("INSERT INTO Attribute (`attributeId`, `multivalue`)
                      VALUES (1, 0), (2, 0), (3, 0), (4, 0), (5, 0), (6, 0), (7, 0), (8, 0), (9, 1), (10, 1)")) {
                echo mysql_error();
                die;
            }


            if (!mysql_query("INSERT INTO AttributeI18N(`string`, `isoCode`, `attributeId`) 
                      VALUES ('Name', 'en_US', 1), ('Rules', 'en_US', 2), ('Cost', 'en_US', 3), ('Threshold', 'en_US', 4), 
                             ('Attack', 'en_US', 5), ('Defense', 'en_US', 6), ('Flavor', 'en_US', 7), ('Sub-type', 'en_US', 8), 
                             ('Faction', 'en_US', 9), ('Type', 'en_US', 10)")) {
                echo mysql_error();
                die;
            }


            if (!mysql_query("INSERT INTO AttributeOption(`attributeOptionId`, `key`, `attributeId`) 
                      VALUES (1, 'gaia', 9), (2, 'house_of_nobles', 9), (3, 'undead', 9), (4, 'red_banner', 9), (5, 'empire', 9), (6, 'unit', 10), (7, 'event', 10), (8, 'spell', 10), (9, 'enchantment', 10), (10, 'equipment', 10), (11, 'artifact', 10)")) {
                echo mysql_error();
                die;
            }

            if (!mysql_query("INSERT INTO AttributeOptionI18N(`string`, `isoCode`, `attributeOptionId`) 
                      VALUES ('Gaia', 'en_US', 1), ('House of Nobles', 'en_US', 2), ('Undead', 'en_US', 3), ('Red Banner', 'en_US', 4), 
                             ('Empire', 'en_US', 5), ('Unit', 'en_US', 6), ('Event', 'en_US', 7), ('Spell', 'en_US', 8), ('Enchantment', 'en_US', 9), 
                             ('Equipment', 'en_US', 10), ('Artifact', 'en_US', 11)")) {
                echo mysql_error();
                die;
            }

            foreach ($existing as $card) {

                //creating needed users
                $qresult = mysql_query(sprintf("SELECT userId FROM User WHERE username = '%s'", $card['author']));
                if (mysql_num_rows($qresult) == 0) {
                    mysql_query(sprintf("INSERT INTO `User`(`username`, `password`, `email`) VALUES('%s', SHA1('%s'), '%s')"
                                    , $card['author'], $card['author'], $card['author']
                            ));

                    $userId = mysql_insert_id();
                } else {
                    $userId = mysql_fetch_row($qresult);
                    $userId = intval($userId[0]);
                }


                $status = 0;
                switch ($card['status']) {
                    case 'concept':
                        $status = 0;
                        break;
                    case 'discuss':
                        $status = 1;
                        break;
                    case 'playtest':
                        $status = 2;
                        break;
                    case 'approved':
                        $status = 3;
                        break;
                    case 'rejected':
                        $status = 4;
                        break;
                }

                if (mysql_query(sprintf("INSERT INTO Card(`status`, `userId`) VALUES (%d, %d)", $status, $userId))) {
                    $cardId = mysql_insert_id();

                    for ($i = 1; $i < 11; $i++) {
                        if (!mysql_query(sprintf("INSERT INTO `CardAttribute` (`cardId`, `attributeId`) VALUES (%d, %d)", $cardId, $i))) {
                            echo mysql_error();
                            die;
                        }
                    }

                    if (mysql_query(sprintf("INSERT INTO `Revision` (`date`, `cardId`, `userId`) VALUES (NOW(), %d, %d)", $cardId, $userId))) {
                        $revisionId = mysql_insert_id();

                        //1 - name
                        if (!mysql_query(sprintf("INSERT INTO `RevisionAttribute` (`revisionId`, `attributeId`, `value`) VALUES (%d, %d, '%s')", $revisionId, 1, mysql_real_escape_string($card['cardname'])))) {
                            echo mysql_error();
                            die;
                        }
                        //2 - rules
                        if (!mysql_query(sprintf("INSERT INTO `RevisionAttribute` (`revisionId`, `attributeId`, `value`) VALUES (%d, %d, '%s')", $revisionId, 2, mysql_real_escape_string($card['rules'])))) {
                            echo mysql_error();
                            die;
                        }
                        //3 - cost
                        if (!mysql_query(sprintf("INSERT INTO `RevisionAttribute` (`revisionId`, `attributeId`, `value`) VALUES (%d, %d, '%s')", $revisionId, 3, $card['cost']))) {
                            echo mysql_error();
                            die;
                        }
                        //4 - threshold
                        if (!mysql_query(sprintf("INSERT INTO `RevisionAttribute` (`revisionId`, `attributeId`, `value`) VALUES (%d, %d, '%s')", $revisionId, 4, $card['threshold']))) {
                            echo mysql_error();
                            die;
                        }
                        //5 - attack
                        if (!mysql_query(sprintf("INSERT INTO `RevisionAttribute` (`revisionId`, `attributeId`, `value`) VALUES (%d, %d, '%s')", $revisionId, 5, $card['attack']))) {
                            echo mysql_error();
                            die;
                        }
                        //6 - defense
                        if (!mysql_query(sprintf("INSERT INTO `RevisionAttribute` (`revisionId`, `attributeId`, `value`) VALUES (%d, %d, '%s')", $revisionId, 6, $card['defense']))) {
                            echo mysql_error();
                            die;
                        }
                        //7 - flavor
                        if (!mysql_query(sprintf("INSERT INTO `RevisionAttribute` (`revisionId`, `attributeId`, `value`) VALUES (%d, %d, '%s')", $revisionId, 7, $card['flavor']))) {
                            echo mysql_error();
                            die;
                        }
                        //8 - subtype
                        if (!mysql_query(sprintf("INSERT INTO `RevisionAttribute` (`revisionId`, `attributeId`, `value`) VALUES (%d, %d, '%s')", $revisionId, 8, $card['subtype']))) {
                            echo mysql_error();
                            die;
                        }

                        //9 - faction
                        $faction = 1; //defaults to Gaia
                        switch ($card['faction']) {
                            case 'House of Nobles':
                                $faction = 2;
                                break;
                            case 'Undead':
                                $faction = 3;
                                break;
                            case 'Red Banner':
                                $faction = 4;
                                break;
                            case 'Empire':
                                $faction = 5;
                                break;
                        }
                        if (!mysql_query(sprintf("INSERT INTO `RevisionAttribute` (`revisionId`, `attributeId`, `value`) VALUES (%d, %d, '%s')", $revisionId, 9, $faction))) {
                            echo mysql_error();
                            die;
                        }

                        //10 - type
                        $type = 1; //defaults to unit
                        switch ($card['type']) {
                            case 'event':
                                $typeId = 2;
                                break;
                            case 'spell':
                                $typeId = 3;
                                break;
                            case 'enchantment':
                                $typeId = 4;
                                break;
                            case 'equipment':
                                $typeId = 5;
                                break;
                            case 'artifact':
                                $typeId = 6;
                                break;
                        }
                        if (!mysql_query(sprintf("INSERT INTO `RevisionAttribute` (`revisionId`, `attributeId`, `value`) VALUES (%d, %d, '%s')", $revisionId, 10, $type))) {
                            echo mysql_error();
                            die;
                        }
                    } else {
                        echo mysql_error() && die();
                    }
                } else {
                    echo mysql_error() && die();
                }
                //END: foreach card
            }
        } else {
            echo 'Unable to select existing cards.';
        }
    } else {
        echo 'Unable to use the database.';
    }
} else {
    echo 'Can\'t connect to the database server';
}