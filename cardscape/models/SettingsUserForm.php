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

class SettingsUserForm extends CFormModel {

    public $registration;
    public $captcha;
    public $minnick;

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('registraton, captcha, minnick', 'required'),
            array('registraton, captcha, minnick', 'numerical', 'integerOnly' => true)
        );
    }

    /**
     * @return array Customized attribute labels (attribute name => label)
     */
    public function attributeLabels() {
        return array(
            'registration' => 'Allow Registration',
            'captcha' => 'Use CAPTCHA',
            'minnick' => 'Min. Nick Size'
        );
    }

    /**
     * Overrides the default <em>init()</em> method to load existing attribute 
     * values stored in the <em>Setting</em> table. 
     */
    public function init() {
        $this->registration = 1;
        if (($setting = Setting::model()->findByPk('registration')) !== null) {
            $this->registration = intval($setting->value);
        }

        $this->captcha = 0;
        if (($setting = Setting::model()->findByPk('captcha')) !== null) {
            $this->captcha = intval($setting->value);
        }

        $this->minnick = 3;
        if (($setting = Setting::model()->findByPk('minnick')) !== null) {
            $this->minnick = intval($setting->value);
        }
    }

    /**
     * Saves changes made to the settings used by this form model.
     * @return boolean True if the changes were save, false otherwise.
     */
    public function save() {
        $success = false;

        $setting = null;
        if (($setting = Setting::model()->findByPk('registration')) === null) {
            $setting = new Setting();
            $setting->key = 'registration';
        }
        $setting->value = $this->registration;
        $success = $setting->save();

        $setting = null;
        if (($setting = Setting::model()->findByPk('captcha')) === null) {
            $setting = new Setting();
            $setting->key = 'captcha';
        }
        $setting->value = $this->captcha;
        $success = $success && $setting->save();

        $setting = null;
        if (($setting = Setting::model()->findByPk('minnick')) === null) {
            $setting = new Setting();
            $setting->key = 'minnick';
        }
        $setting->value = $this->minnick;

        return $success && $setting->save();
    }

}