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
 * From model wrapper for e-mail related settings.
 */
class SettingsEmailForm extends CFormModel {

    /**
     * @var type 
     */
    public $email;

    /**
     * @var type 
     */
    public $smtp;

    /**
     * @var type 
     */
    public $username;

    /**
     * @var type 
     */
    public $password;

    /**
     * @var type 
     */
    public $host;

    /**
     * @var type 
     */
    public $security;

    /**
     * @var type 
     */
    public $port;

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'length', 'max' => 255),
            array('port, smtp', 'numerical', 'integerOnly' => true),
            array('username, password, host, port', 'checkRequired'),
            array('security', 'validSecurity')
        );
    }

    /**
     * @return array Customized attribute labels (attribute name => label)
     */
    public function attributeLabels() {
        return array(
            'email' => 'System E-mail',
            'smtp' => 'Use SMTP',
            'username' => 'Username',
            'password' => 'Password',
            'host' => 'Host',
            'security' => 'Security',
            'port' => 'Port'
        );
    }

    /**
     * Overrides the default <em>init()</em> method to load existing attribute 
     * values stored in the <em>Setting</em> table. 
     */
    public function init() {
        $this->email = '';
        if (($setting = Setting::model()->findByPk('email')) !== null) {
            $this->email = $setting->value;
        }

        $this->smtp = 0;
        if (($setting = Setting::model()->findByPk('smtp')) !== null) {
            $this->smtp = intval($setting->value);
        }

        $this->username = '';
        if (($setting = Setting::model()->findByPk('username')) !== null) {
            $this->username = $setting->value;
        }

        $this->password = '';
        if (($setting = Setting::model()->findByPk('password')) !== null) {
            $this->password = $setting->value;
        }

        $this->host = '';
        if (($setting = Setting::model()->findByPk('host')) !== null) {
            $this->host = $setting->value;
        }

        $this->port = 25;
        if (($setting = Setting::model()->findByPk('port')) !== null) {
            $this->port = intval($setting->value);
        }

        $this->security = '';
        if (($setting = Setting::model()->findByPk('security')) !== null) {
            $this->security = $setting->value;
        }
    }

    /**
     * Saves changes made to the settings used by this form model.
     * @return boolean True if the changes were save, false otherwise.
     */
    public function save() {
        //NOTE: //TODO: could be made more "dynamic"
        $success = false;

        $setting = null;
        if (($setting = Setting::model()->findByPk('email')) === null) {
            $setting = new Setting();
            $setting->key = 'email';
        }
        $setting->value = $this->email;
        $success = $setting->save();

        $setting = null;
        if (($setting = Setting::model()->findByPk('smtp')) !== null) {
            $setting = new Setting();
            $setting->key = 'smtp';
        }
        $setting->value = $this->smtp;
        $success = $success && $setting->save();

        $setting = null;
        if (($setting = Setting::model()->findByPk('username')) !== null) {
            $setting = new Setting();
            $setting->key = 'username';
        }
        $setting->value = $this->username;
        $success = $success && $setting->save();

        $setting = null;
        if (($setting = Setting::model()->findByPk('password')) !== null) {
            $setting = new Setting();
            $setting->key = 'password';
        }
        $setting->value = $this->password;
        $success = $success && $setting->save();

        $setting = null;
        if (($setting = Setting::model()->findByPk('host')) !== null) {
            $setting = new Setting();
            $setting->key = 'host';
        }
        $setting->value = $this->host;
        $success = $success && $setting->save();

        $setting = null;
        if (($setting = Setting::model()->findByPk('port')) !== null) {
            $setting = new Setting();
            $setting->key = 'port';
        }
        $setting->value = $this->port;
        $success = $success && $setting->save();

        $setting = null;
        if (($setting = Setting::model()->findByPk('security')) !== null) {
            $setting = new Setting();
            $setting->key = 'security';
        }
        $setting->value = $this->security;

        return $success && $setting->save();
    }

    public static function securityNames() {
        return array(
            '' => 'None',
            'ssl' => 'SSL',
            'tls' => 'TLS'
        );
    }

    /**
     * @param string $attribute The name of the attribute to be validated
     * @param array $params Options specified in the validation rule
     */
    public function checkRequired($attribute, $params) {
        if ($this->smtp) {
            if (!$this->$attribute) {
                $this->addError($attribute, sprintf('If using SMTP %s is a required field.'), $attribute);
            }
        }
    }

    /**
     * @param string $attribute The name of the attribute to be validated
     * @param array $params Options specified in the validation rule
     */
    public function validSecurity($attribute, $params) {
        if ($this->security != '' && $this->security != 'ssl' && $this->security != 'tls') {
            $this->addError('security', 'Security type is invalid.');
        }
    }

}