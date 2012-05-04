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
 * Form model used to login a user.
 */
class LoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    private $credentials;

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('username, password', 'required'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    /**
     * @return array Customized attribute labels (attribute name => label)
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember my login',
        );
    }

    /**
     * Used to authenticate a user that is trying to gain access to the application.
     * 
     * This methods signature matches the signature required by the framework but 
     * our implementation makes no use of the given parameters.
     * 
     * @param string $attribute Not used.
     * @param array $params Not used.
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->credentials = new Credentials($this->username, $this->password);
            if (!$this->credentials->authenticate())
                $this->addError('password', 'Incorrect username or password.');
        }
    }

    /**
     * The login action, this is where an user is really accepted and logged into 
     * the application.
     * 
     * @return boolean True if the login is successful, false otherwise.
     */
    public function login() {
        if ($this->credentials === null) {
            $this->credentials = new Credentials($this->username, $this->password);
            $this->credentials->authenticate();
        }

        if ($this->credentials->errorCode === Credentials::ERROR_NONE) {
            //remember for 7 days
            $duration = $this->rememberMe ? 3600 * 24 * 7 : 0;
            Yii::app()->user->login($this->credentials, $duration);

            return true;
        }

        return false;
    }

}
