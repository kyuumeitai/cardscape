<?php

echo 'Not implemented yet.', "\n";

//This is an old version, needs to be updated since we now have a proper backup 
//f the original database

/*
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
            foreach ($existing as $card) {
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
                $typeId = $factionId = 1;
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
                    case 'official':
                        $status = 4;
                        break;
                    case 'halt':
                        $status = 5;
                        break;
                    case 'restricted':
                        $status = 6;
                        break;
                    case 'rejected':
                        $status = 6;
                        break;
                }

                switch ($card['faction']) {
                    case 'Gaia':
                        $factionId = 1;
                        break;
                    case 'House of Nobles':
                        $factionId = 2;
                        break;
                    case 'Undead':
                        $factionId = 3;
                        break;
                    case 'Red Banner':
                        $factionId = 4;
                        break;
                    case 'Empire':
                        $factionId = 5;
                        break;
                }


                switch ($card['type']) {
                    case 'unit':
                        $typeId = 1;
                        break;
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

                $query = sprintf("
                    INSERT INTO `Card` (
                                `cardId`, 
                                `revision`, 
                                `updated`, 
                                `name`, 
                                `subtype`, 
                                `cost`,
                                `threshold`,
                                `attack`,
                                `defense`,
                                `rules`,
                                `flavor`,
                                `imagefile`,
                                `status`,
                                `userId`,
                                `factionId`,
                                `typeId`
                                )
                         VALUES (%d, '%s', '%s', '%s', '%s', %d, %d, %d, %d, '%s', '%s', '%s', %d, %d, %d, %d)"
                        , $card['id'], $card['revision'], date('Y-m-d H:i:s', strtotime($card['date']))
                        , mysql_real_escape_string($card['cardname']), $card['subtype'], $card['cost'], $card['threshold']
                        , $card['attack'], $card['defense'], mysql_real_escape_string($card['rules'])
                        , mysql_real_escape_string($card['flavor']), $card['image'], $status, $userId, $factionId, $typeId);

                if (!mysql_query($query)) {
                    echo mysql_error();
                }
            }
        } else {
            echo 'Unable to select existing cards.';
        }
    } else {
        echo 'Unable to use the database.';
    }
} else {
    echo 'Can\'t connect to the database server';
}*/