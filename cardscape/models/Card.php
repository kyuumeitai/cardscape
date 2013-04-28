<?php

/* Card.php
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
 * This is the model class for table "Card".
 *
 * The followings are the available columns in table 'Card':
 * @property string $id
 * @property string $status
 * @property integer $active
 * @property integer $userId
 * @property integer $ancestorId
 * @property string $image
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Attribute[] $cardAttributes
 * @property User[] $users
 * @property Comment[] $comments
 * @property Project[] $projects
 * @property Revision[] $revisions
 * @property Card $ancestor
 * @property CardNameI18N[] $names
 */
class Card extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className active record class name.
     * @return Card the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{Card}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('userId', 'required'),
            array('active, ancestorId', 'numerical', 'integerOnly' => true),
            array('status', 'in', 'range' => array('concept', 'discussion', 'playtest', 'approved', 'rejected')),
            // search
            array('status, userId, ancestorId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'cardAttributes' => array(self::MANY_MANY, 'Attribute', 'CardAttribute(cardId, attributeId)'),
            'users' => array(self::MANY_MANY, 'User', 'CardUser(cardId, userId)'),
            'comments' => array(self::HAS_MANY, 'Comment', 'cardId'),
            'projects' => array(self::MANY_MANY, 'Project', 'ProjectCard(cardId, projectId)'),
            'revisions' => array(self::HAS_MANY, 'Revision', 'cardId', 'order' => 'number DESC'),
            'ancestor' => array(self::BELONGS_TO, 'Card', 'ancestorId'),
            'names' => array(self::HAS_MANY, 'CardNameI18N', 'cardId')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('cardscape', 'ID'),
            'status' => Yii::t('cardscape', 'Status'),
            'active' => Yii::t('cardscape', 'Active'),
            'userId' => Yii::t('cardscape', 'User'),
            'ancestorId' => Yii::t('cardscape', 'Ancestor'),
            'image' => Yii::t('cardscape', 'Image')
        );
    }

    public static function getStatusName($status) {
        $statuses = self::getCardStatusesArray();
        return (isset($statuses[$status]) ? $statuses[$status] : Yii::t('cardscape', 'Unknown status'));
    }

    public static function getCardStatusesArray() {
        return array(
            'concept' => Yii::t('cardscape', 'Concept'),
            'discussion' => Yii::t('cardscape', 'Discussion'),
            'playtest' => Yii::t('cardscape', 'Playtes'),
            'approved' => Yii::t('cardscape', 'Approved'),
            'rejected' => Yii::t('cardscape', 'Rejected')
        );
    }

}
