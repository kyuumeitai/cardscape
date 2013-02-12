<?php

/* Comment.php
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
 * @property integer $commentId
 * @property integer $userId
 * @property integer $cardId
 * @property string $date
 * @property string $message
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Card $card
 */
class Comment extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return Comment The static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name
     */
    public function tableName() {
        return '{{Comment}}';
    }

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('message', 'required'),
            // The following rule is used by search method.
            array('userId, cardId, date, message', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array Telational rules.
     */
    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'card' => array(self::BELONGS_TO, 'Card', 'cardId'),
        );
    }

    /**
     * @return array Customized attribute labels (name => label)
     */
    public function attributeLabels() {
        return array(
            'commentId' => 'ID',
            'userId' => 'User',
            'cardId' => 'Card',
            'date' => 'Date',
            'message' => 'Message',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('userId', $this->userId, true);
        $criteria->compare('cardId', $this->cardId, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('active', 1);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['pageSize']
                    ),
                    'sort' => array(
                        'defaultOrder' => 'username,email,role'
                    )
                ));
    }

}