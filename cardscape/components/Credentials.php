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
 * Implements a used identity allowing custom authentication code to be injected 
 * in the standard Yii's authentication method. 
 */
class Credentials extends CBaseUserIdentity {

    private $username;
    private $password;
    private $id;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function authenticate() {
        $this->errorCode = self::ERROR_NONE;
        $user = User::model()->findByAttributes(array('username' => $this->username));

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if ($user->password !== User::hash($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->id = $user->userId;
                $this->username = $user->username;


                $sd = null;
                if (($sd = SessionData::model()->findByPk($user->userId)) === null) {
                    $sd = new SessionData();
                    $sd->userId = $user->userId;
                }

                $time = time();
                $token = md5($time . $this->id . $user->username);

                $expires = $time + (3600 * 24 * 7);

                $this->setState('token', $token);
                $this->setState('role', $user->role);

                $sd->token = $token;
                $sd->tokenExpires = date('Y-m-d H:i', $expires);
                $sd->lastActivity = date('Y-m-d H:i', $time);
                $sd->save();
            }
        }

        return !$this->errorCode;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->username;
    }

}