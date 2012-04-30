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

/**
 * Extends the default CWebUser class adding token validation to control expired 
 * users and allow automatic login based on cookies. 
 */
class WebUser extends CWebUser {

    public function beforeLogin($id, $states, $fromCookie) {

        if (!$fromCookie) {
            return true;
        }

        $sd = SessionData::model()->findByPk($id);
        if ($sd === null || $sd->token !== $states['token'] || strtotime($sd->tokenExpires) < time()) {
            return false;
        }

        return false;
    }

}
