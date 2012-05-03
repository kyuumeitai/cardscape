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

class ChangeForm extends CFormModel {

    public $password;
    public $password_repeat;

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('password, password_repeat', 'required'),
            //using default comparison features provided by the framework
            array('password', 'compare')
        );
    }

    /**
     * @return array Customized attribute labels (attribute name => label)
     */
    public function attributeLabels() {
        return array(
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
        );
    }

    public function changePassword($userId) {
        if (($user = User::model()->findByPk($userId)) !== null) {
            $user->password = User::hash($this->password);
            return $user->save();
        }

        return false;
    }

}
