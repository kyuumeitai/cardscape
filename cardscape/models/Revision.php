<?php

/* Revision.php
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
 * @property integer $id
 * @property string $date
 * @property integer $active
 * @property integer $cardId
 * @property integer $userId
 *
 * The followings are the available model relations:
 * @property Card $card
 * @property User $user
 * @property Attribute[] $attributes
 */
class Revision extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return Revision The static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name
     */
    public function tableName() {
        return '{{Revision}}';
    }

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('date', 'required'),
            array('active, cardId, userId', 'numerical', 'integerOnly' => true),
            //rules for the search method
            array('date, cardId, userId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array Relational rules.
     */
    public function relations() {
        return array(
            'card' => array(self::BELONGS_TO, 'Card', 'cardId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'attributes' => array(self::MANY_MANY, 'Attribute', 'RevisionAttribute(revisionId, attributeId)'),
        );
    }

    /**
     * @return array Customized attribute labels (name => label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('revision', 'ID'),
            'date' => Yii::t('revision', 'Date'),
            'cardId' => Yii::t('revision', 'Card'),
            'userId' => Yii::t('revision', 'User'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('date', $this->date, true);
        $criteria->compare('cardId', $this->cardId, true);
        $criteria->compare('userId', $this->userId, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['paginationSize']
                    ),
                    'sort' => array(
                        'defaultOrder' => 'revisionId,date'
                    )
                ));
    }

}
