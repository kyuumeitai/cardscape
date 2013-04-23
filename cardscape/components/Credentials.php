<?php

/* Credentials.php
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

/**
 * Implements a user identity allowing custom authentication code to be injected 
 * in the standard Yii's authentication method. 
 */
class Credentials extends CBaseUserIdentity {

    private $identifier;
    private $password;
    //
    private $id;
    private $name;

    public function __construct($identifier, $password) {
        $this->identifier = $identifier;
        $this->password = $password;
    }

    public function authenticate() {
        $this->errorCode = self::ERROR_NONE;
        $criteria = new CDbCriteria();
        $criteria->compare('username', $this->identifier);
        $criteria->compare('email', $this->identifier, false, 'OR');

        $user = User::model()->find($criteria);

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if ($user->password !== User::hash($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->id = $user->id;
                $this->name = $user->username;

                $session = null;
                if (($session = SessionData::model()->findByPk((int) $this->id)) === null) {
                    $session = new SessionData();
                    $session->id = $this->id;
                }

                $time = time();
                $token = md5($time . $this->id . $this->name);

                $expires = $time + (3600 * 24 * 7);

                $this->setState('token', $token);
                $this->setState('role', $user->role);

                $session->token = $token;
                $session->tokenExpires = date('Y-m-d H:i', $expires);
                $session->lastActivity = date('Y-m-d H:i', $time);
                if (!$session->save()) {
                    Yii::log('Error while saving session data. Reason: ' + print_r($session->getErrors(), true), CLogger::LEVEL_WARNING, 'cardscape');
                }
            }
        }

        return !$this->errorCode;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

}