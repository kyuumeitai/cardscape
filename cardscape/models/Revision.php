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
 * A <em>Revision</em> represents a change in a card's data. It keeps track of 
 * every change that was made to a card since its creation at revision 1.
 * 
 * The actual value of the change will be stored in the <em>RevisionAttribute</em> 
 * entity that connects the revision with the attribute and keeps the value of that 
 * attribute in this revision.
 * 
 * A revision is created whenever anything in the card changes, even if just one 
 * of the attributes change, all are copied, with the modified attributes being 
 * the only differences from the previous revision to this one.
 * 
 * @property integer $id ID for this record.
 * @property string $date Date and time for when the revision was created, and the 
 * card's details changed.
 * 
 * @property integer $active Flag that identifies this as an non-deleted revision.
 * @property integer $cardId ID for the owner card.
 * @property integer $userId ID for the user that made the change and thus created 
 * the revision.
 * 
 * @property integer $number Keeps track of the number of revisions, manually maintained
 *
 * Relations:
 * @property Card $card The owner card.
 * @property User $user The user that created the revision.
 * @property Attribute[] $attributes A list of all existing attributes affected 
 * with this revision. Usually all attributes that existed in the card at the time 
 * of this revision creation.
 * 
 * @property RevisionAttribute[] $values All the attribute's values for this revision
 */
class Revision extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return Revision
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
            'values' => array(self::HAS_MANY, 'RevisionAttribute', 'revisionId')
        );
    }

    /**
     * @return array Customized attribute labels (name => label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('cardscape', 'ID'),
            'date' => Yii::t('cardscape', 'Date'),
            'cardId' => Yii::t('cardscape', 'Card'),
            'userId' => Yii::t('cardscape', 'User'),
            'number' => Yii::t('cardscape', 'Number')
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
            'sort' => array(
                'defaultOrder' => 'revisionId,date'
            )
        ));
    }

}
