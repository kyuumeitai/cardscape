<?php

/* LoginForm.php
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

class LoginForm extends CFormModel {

    public $emailOrUsername;
    public $password;

    public function rules() {
        return array(
            array('emailOrUsername, password', 'required')
        );
    }

    public function login() {
        if (!$this->validate()) {
            return false;
        }

        $credentials = new Credentials($this->emailOrUsername, $this->password);
        if (!($authenticationError = $credentials->authenticate())) {
            $this->addErrors(array(
                'emailOrUsername' => Yii::t('cardscape', 'Invalid username, e-mail or password.'),
                'password' => Yii::t('cardscape', 'Invalid username, e-mail or password.')
            ));
            return false;
        }

        //TODO: Add proper flash message
        Yii::app()->user->login($credentials);
        return true;
    }

    public function attributeLabels() {
        return array(
            'emailOrUsername' => Yii::t('cardscape', 'E-mail or username'),
            'password' => Yii::t('cardscape', 'Password')
        );
    }

}