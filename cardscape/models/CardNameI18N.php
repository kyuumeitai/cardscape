<?php

/* CardNameI18N.php
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
 * This is the model class for table "CardNameI18N".
 *
 * The followings are the available columns in table 'CardNameI18N':
 * @property integer $id
 * @property string $isoCode
 * @property string $string
 * @property integer $carId
 * 
 * The followings are the available model relations:
 * @property Card $card
 */
class CardNameI18N extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className active record class name.
     * @return CardNameI18N the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{CardNameI18N}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('isoCode, string', 'required'),
            array('isoCode', 'length', 'max' => 5),
            array('string', 'length', 'max' => 150),
            // search
            array('string, isoCode, cardId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'card' => array(self::BELONGS_TO, 'Card', 'cardId')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('cardscape', 'ID'),
            'string' => Yii::t('cardscape', 'Name'),
            'isoCode' => Yii::t('cardscape', 'Language'),
            'cardId' => Yii::t('cardscape', 'Card')
        );
    }

}
