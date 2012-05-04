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
 * Form model that wrapps system settings. 
 */
class SettingsSystemForm extends CFormModel {

    /**
     * @var integer Flag to allow or disallow the use of card development projects
     */
    public $projects;

    /**
     * @var string The system language used for both default interface and card/attribute translations
     */
    public $language;

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('projects', 'numerical', 'integerOnly' => true),
            array('language', 'length', 'max' => 5)
        );
    }

    /**
     * @return array Customized attribute labels (attribute name => label)
     */
    public function attributeLabels() {
        return array(
            'projects' => 'Allow Projects',
            'language' => 'Default Language'
        );
    }

    /**
     * Overrides the default <em>init()</em> method to load existing attribute 
     * values stored in the <em>Setting</em> table. 
     */
    public function init() {
        $this->projects = 0;
        if (($setting = Setting::model()->findByPk('projects')) !== null) {
            $this->projects = intval($setting->value);
        }

        $this->language = 'en_US';
        if (($setting = Setting::model()->findByPk('language')) !== null && trim($setting->value) != '') {
            $this->language = $setting->value;
        }
    }

    /**
     * Saves changes made to the settings used by this form model.
     * @return boolean True if the changes were save, false otherwise.
     */
    public function save() {
        $success = false;

        $setting = null;
        if (($setting = Setting::model()->findByPk('projects')) === null) {
            $setting = new Setting();
            $setting->key = 'projects';
        }
        $setting->value = $this->projects;
        $success = $setting->save();

        $setting = null;
        if (($setting = Setting::model()->findByPk('language')) === null) {
            $setting = new Setting();
            $setting->key = 'language';
        }
        $setting->value = $this->language;

        return $success && $setting->save();
    }

}