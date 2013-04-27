<?php

/* RegistrationForm.php
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
 * Form model that handles user registraion in site/login (registraion section) 
 * resource, in the <em>SiteController</em> controller class.
 */
class RegistrationForm extends CFormModel {

    public $username;
    public $password;
    public $repeatPassword;
    public $email;
    public $language;

    public function rules() {
        return array(
            array('username, email, password, repeatPassword', 'required'),
            array('username', 'length', 'max' => 25),
            array('language', 'length', 'max' => 5),
            array('email', 'length', 'max' => 255),
            array('email', 'email'),
            array('repeatPassword', 'compare', 'compareAttribute' => 'password', 'strict' => true)
        );
    }

    /**
     * Validates user's input and registers a new user record in the database if 
     * the input is valid. Also sends the neecessary e-mails with account activation 
     * details.
     * 
     * @return boolean True if the registration process was successful, false otherwise.
     */
    public function register() {
        if (!$this->validate()) {
            return false;
        }

        throw new CHttpException(501, 'Not implemented yet.');
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('cardscape', 'Username'),
            'password' => Yii::t('cardscape', 'Password'),
            'repeatPassword' => Yii::t('cardscape', 'Repeat password'),
            'email' => Yii::t('cardscape', 'E-mail'),
            'language' => Yii::t('cardscape', 'Language')
        );
    }

}
