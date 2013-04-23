<?php

/* Project.php
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
 * A project can be used to focus the development of a group of cards, grant specific 
 * permissions on only that project and related cards. It aims to provide an organization 
 * feature allowing card developers to focus on a limited pool/scope of cards.
 * 
 * @property integer $id Project database ID
 * @property string $name Project's name
 * @property string $description A description about this project
 * @property string $expires The date when the project is to be finished
 * @property integer $active Flag that marks a project as deleted
 *
 * The following are the available model relations:
 * @property Attribute[] $attributes Array of attributes that make this project's goals
 * @property ProjectAttribute[] $objectives An array of project/attribute relations with each goals' objectives
 * @property User[] $moderators Array of users that have moderation previleges on the project
 */
class Project extends CActiveRecord {

    /**
     * Returns The static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return Project The static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name
     */
    public function tableName() {
        return '{{Project}}';
    }

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 50),
            array('description', 'length', 'max' => 255),
            array('expires', 'safe'),
            // search
            array('name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array Relational rules.
     */
    public function relations() {
        return array(
            'attributes' => array(self::MANY_MANY, 'Attribute', 'ProjectAttribute(projectId, attributeId)'),
            'objectives' => array(self::HAS_MANY, 'ProjectAttribute', 'projectId'),
            'cards' => array(self::HAS_MANY, 'Card', 'ProjectCard(projectId, cardId'),
            'moderators' => array(self::MANY_MANY, 'User', 'ProjectUser(projectId, userId)'),
        );
    }

    /**
     * @return array Customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('cardscape', 'ID'),
            'name' => Yii::t('cardscape', 'Name'),
            'description' => Yii::t('cardscape', 'Description'),
            'expires' => Yii::t('cardscape', 'Expires'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * 
     * @return CActiveDataProvider The data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'name,expires'
            )
        ));
    }

}
