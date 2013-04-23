<?php

/* ProjectAttribute.php
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
 * This model contains a goal for the related project. A project may need several 
 * completed goals to be considered finished and each goal will be an instance of 
 * this class.
 * 
 * This is a model/table created as a result of the ER transformation rules and 
 * contains one attribute that is part of the relation between a project and an 
 * attribute: the objective for the goal corresponding to the number of cards with 
 * a given attribute that need to exist in a complete state.
 * 
 * @property integer $id The database ID for the owner project
 * @property integer $attributeId The database ID for the owner attribute
 * @property integer $objective The number of cards with the attribute that the project needs
 */
class ProjectAttribute extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return ProjectAttribute The static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name
     */
    public function tableName() {
        return '{{ProjectAttribute}}';
    }

    /**
     * @return array Customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('cardscape', 'Project'),
            'attributeId' => Yii::t('cardscape', 'Attribute'),
            'objective' => Yii::t('cardscape', 'Objective'),
        );
    }

}
