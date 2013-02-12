<?php

/* RegisterForm.php
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
 * Form model used in the user registration process. Contains validation rules 
 * for the form that the view uses and allows easy access to that validation 
 * by offering AJAX validation. 
 */
class RegisterForm extends CFormModel {

    /**
     * @var string The user's e-mail address.
     */
    public $email;

    /**
     *
     * @var string The user's password, not hashed.
     */
    public $password;

    /**
     *
     * @var string Used by the <em>compare</em> method for checking if the user 
     * entered the correct password. The <em>compare</em> method is invoked 
     * automatically by Yii because we defined a rule for field comparison.
     */
    public $password_repeat;

    /**
     *
     * @var string The username requested by this user that is going through the 
     * registration process. This field is needs to be unique in the <em>User</em> 
     * table and there is a rule in place for that. 
     */
    public $username;

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('username, email, password, password_repeat', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'className' => 'User'),
            //using default comparison features provided by the framework
            array('password', 'compare'),
            array('username', 'length', 'max' => 25),
            array('email', 'length', 'max' => 255)
        );
    }

    /**
     * @return array Customized attribute labels (attribute name => label)
     */
    public function attributeLabels() {
        return array(
            'email' => 'E-mail',
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
            'username' => 'Username'
        );
    }

    /**
     * Registers a new user if the validation was successful.
     * 
     * @return boolean True if the user was created, false otherwise.
     */
    public function register() {
        $user = new User();

        $user->email = $this->email;
        $user->password = User::hash($this->password);
        $user->username = $this->username;

        return $user->save();
    }

}
