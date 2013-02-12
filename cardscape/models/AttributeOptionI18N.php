<?php

/* AttributeOptionI18N.php
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
 * Keeps translations for the various attribute options. This model, and respective 
 * table, are similar to the <em>AttributeI18N</em> model and table with the only 
 * difference that this translation is tied to the attribute option on multi-value 
 * attributes.
 *
 * @property integer $attributeOptionI18NId The database ID
 * @property string $string The translated name of this attribute option
 * @property string $isoCode The ISO code used to identify the translation
 * @property string $attributeOptionId The database ID for the owner attribute option
 *
 * The followings are the available model relations:
 * @property AttributeOption $attributeOption The owner attribute option
 */
class AttributeOptionI18N extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return AttributeOptionI18N The static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name
     */
    public function tableName() {
        return '{{AttributeOptionI18N}}';
    }

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('string, isoCode', 'required'),
            array('string', 'length', 'max' => 150),
            array('isoCode', 'length', 'max' => 7)
        );
    }

    /**
     * @return array Relational rules.
     */
    public function relations() {
        return array(
            'attributeOption' => array(self::BELONGS_TO, 'AttributeOption', 'attributeOptionId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'attributeOptionI18NId' => 'ID',
            'string' => 'String',
            'isoCode' => 'ISO Code',
            'attributeOptionId' => 'Attribute Option',
        );
    }

}