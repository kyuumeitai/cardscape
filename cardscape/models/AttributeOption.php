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
 * An attribute option is used when an attribute can only contain a value from a 
 * set group of possibilities. Each option represents one possible value for the 
 * attribute that the user can choose from.
 *
 * @property integer $attributeOptionId The database ID
 * @property string $key The key used to identify this attribute in views
 * @property integer $attributeId The database ID for the owner attribute
 *
 * The followings are the available model relations:
 * @property Attribute $attribute The owner attribute
 * @property AttributeOptionI18N[] $translations The translated name of this attribute option
 */
class AttributeOption extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return AttributeOption The static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name
     */
    public function tableName() {
        return '{{AttributeOption}}';
    }

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('key, attributeId', 'required'),
            array('key', 'length', 'max' => 15)
        );
    }

    /**
     * @return array Relational rules.
     */
    public function relations() {
        return array(
            'attribute' => array(self::BELONGS_TO, 'Attribute', 'attributeId'),
            'translations' => array(self::HAS_MANY, 'AttributeOptionI18N', 'attributeOptionId')
        );
    }

    /**
     * @return array Customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'attributeOptionId' => 'ID',
            'key' => 'Key',
            'attributeId' => 'Attribute',
        );
    }

}