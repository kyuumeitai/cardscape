<?php

/* AttributeI18N.php
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
 * Maintains the translations for the existing attributes.
 *
 * @property integer $id The database ID
 * @property string $string The translated attribute name
 * @property string $isoCode The ISO code for this translation
 * @property string $attributeId The database ID for the owner attribute
 *
 * The followings are the available model relations:
 * @property Attribute $attribute The owner attribute
 */
class AttributeI18N extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return AttributeI18N The static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name
     */
    public function tableName() {
        return '{{AttributeI18N}}';
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
            'attribute' => array(self::BELONGS_TO, 'Attribute', 'attributeId'),
        );
    }

    /**
     * @return array Customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'attributeI18NId' => Yii::t('cardscape', 'ID'),
            'string' => Yii::t('cardscape', 'Name'),
            'isoCode' => Yii::t('cardscape', 'ISO Code'),
            'attributeId' => Yii::t('cardscape', 'Attribute'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('string', $this->string, true);
        $criteria->compare('isoCode', 'en_US');
        $attributes = AttributeI18N::model()->with(array(
                    'attribute' => array('condition' => 'active = 1')
                ))->findAll($criteria);

        return new CArrayDataProvider($attributes, array(
            'id' => 'attributei18n',
            'sort' => array(
                'attributes' => array('string'),
                'defaultOrder' => 'string'
            )
        ));
    }

}
