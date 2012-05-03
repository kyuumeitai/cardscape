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

class RecoverForm extends CFormModel {

    /**
     * @var string The e-mail address the user used for registration
     */
    public $email;

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            //rule to check if the e-mail exists in the database
            array('email', 'exist', 'className' => 'User'),
        );
    }

    /**
     * @return array Customized attribute labels (attribute name => label)
     */
    public function attributeLabels() {
        return array(
            'email' => 'Registration E-mail',
        );
    }

    /**
     * Recovery code that sends the new password to the user e-mail. 
     */
    public function recover() {
        if (($user = User::model()->findByAttributes(array('email' => $this->email))) !== null) {

            $passwordRecover = null;
            if (($passwordRecover = PasswordRecover::model()->findByPk($user->userId)) === null) {
                $passwordRecover = new PasswordRecover();
                $passwordRecover->userId = $user->userId;
            }

            //randomize (more or less) a string to use as key
            $passwordRecover->key = md5($user->email . $user->username . Yii::app()->params['hash'] . time());
            $passwordRecover->requested = date('Y-m-d H:i:s');

            if ($passwordRecover->save()) {
                $url = Yii::app()->createUrl('users/changepassword', array('key' => $passwordRecover->key));

                $email = new EmailMessage($user->email, 'Password recovery for ' . Yii::app()->name
                                , sprintf("Someone requested a password recovery at %s, if you're not the one requesting a new password just ignore this message.
                                You can set a new password using the URL: %s", Yii::app()->name, $url));
                try {
                    $email->send();

                    return true;
                } catch (phpmailerException $ex) {
                    throw new CHttpException(500, 'An error occured. Unable to send e-mail message.');
                }
            } else {
                throw new CHttpException(500, 'An error occured. Unable to save data.');
            }
        } else {
            throw new CHttpException(404, 'Invalid request. Please do not repeat this request again.');
        }

        return false;
    }

}
