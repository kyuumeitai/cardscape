<?php

/* index.php
 * 
 * This file is part of Cardscape.
 * Web based collaborative platform for creating Collectible Card Games.
 *
 * Copyright (c) 2011 - 2013, the Cardscape team.
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

// change the following paths if necessary, do not change any other setting, use 
// files under /cardscape/config/ or the ./debug.php file to customize your 
// Cardscape system.
$yii = dirname(__FILE__) . '/../framework/yii.php';
$config = dirname(__FILE__) . '/../cardscape/config/main.php';

// check for development debug.php file
$debug = realpath(__DIR__ . '/debug.php');
if (is_file($debug)) {
    include $debug;
}

// simple version definition, affects nothing in the system except the footer 
// text if you're using the default theme.
define('CSVersion', 'M0.2');

require_once($yii);
Yii::createWebApplication($config)->run();
