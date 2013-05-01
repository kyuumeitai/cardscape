<?php

/* Attribute.php
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
 * An attribute is used to add features to a card. The attribute model stores little
 * human readable information, with most of the data being fetched from the attribute 
 * i18n tables.
 * 
 * The main reason for this model is to make possible the various relations with 
 * cards, projects and other models.
 * 
 * @property integer $id The attribute's database ID
 * @property integer $multivalue Flag that identifies this attribute as having multiple values
 * @property integer $active Flag that marks this attribute as deleted
 *
 * The followings are the available model relations:
 * @property AttributeI18N[] $translations An array of attribute i18n records with the translations for this attribute
 * @property AttributeOption[] $options An array of attribute options with the multiple values for this attribute (can be null)
 * @property Project[] $projects An array of projects if this attribute is a goal for an existing project
 * @property integer useCount A relational statistical query, returns the number of cards using this attribute
 */
class Attribute extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return Attribute The static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name
     */
    public function tableName() {
        return '{{Attribute}}';
    }

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('multivalue', 'numerical', 'integerOnly' => true)
        );
    }

    /**
     * @return array Relational rules.
     */
    public function relations() {
        return array(
            'translations' => array(self::HAS_MANY, 'AttributeI18N', 'attributeId'),
            'options' => array(self::HAS_MANY, 'AttributeOption', 'attributeId'),
            'cards' => array(self::MANY_MANY, 'Card', 'CardAttribute(attributeId, cardId)'),
            'projects' => array(self::MANY_MANY, 'Project', 'ProjectAttribute(attributeId, projectId)'),
            'revisions' => array(self::MANY_MANY, 'Revision', 'RevisionAttribute(attributeId, revisionId)'),
            //stat queries
            'useCount' => array(self::STAT, 'Card', 'CardAttribute(attributeId, cardId)')
        );
    }

    /**
     * @return array Customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('cardscape', 'ID'),
            'multivalue' => Yii::t('cardscape', 'Multi-value'),
            'useCount' => Yii::t('cardscape', 'Cards')
        );
    }

}
