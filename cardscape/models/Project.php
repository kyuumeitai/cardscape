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
 * //TODO: documentation ...
 * 
 * @property integer $projectId
 * @property string $name
 * @property string $description
 * @property string $expires
 * @property integer $active
 *
 * The following are the available model relations:
 * @property Attribute[] $attributes
 * @property ProjectCard[] $projectCards
 * @property User[] $users
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
            // search rules, used only when invoking the search() method
            array('name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array Relational rules.
     */
    public function relations() {
        return array(
            //TODO: uncomment when they became available
            //'attributes' => array(self::MANY_MANY, 'Attribute', 'ProjectAttribute(projectId, attributeId)'),
            //'projectCards' => array(self::HAS_MANY, 'ProjectCard', 'projectId'),
            'users' => array(self::MANY_MANY, 'User', 'ProjectUser(projectId, userId)'),
        );
    }

    /**
     * @return array Customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'projectId' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'expires' => 'Expires',
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
        $criteria->compare('active', 1);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

}