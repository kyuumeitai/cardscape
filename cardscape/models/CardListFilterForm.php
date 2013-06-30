<?php

/* CardListFilterForm.php
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

class CardListFilterForm extends CFormModel {

    public $name;
    public $revision;
    public $revisionId;
    public $status;
    public $date;
    public $author;
    public $authorId;
    public $id;
    // Used for components that expect a model with primary key
    public $primaryKey;

    public function attributeLabels() {
        return array(
            'name' => Yii::t('cardscape', 'Name'),
            'revision' => Yii::t('cardscape', 'Revision'),
            'status' => Yii::t('cardscape', 'Status'),
            'author' => Yii::t('cardscape', 'Author'),
            'date' => Yii::t('cardscape', 'Date')
        );
    }

    public function search() {
        $criteria = new CDbCriteria();
        $criteria->compare('user.username', $this->author, true);
        $criteria->compare('revisions.date', $this->date, true);
        $criteria->compare('status', $this->status);

        $cards = Card::model()->with(array(
                    'revisions' => array(
                        'condition' => 'revisions.active = 1',
                        'order' => 'revisions.number DESC'
                    ),
                    'user'
                ))->findAll($criteria);

        $filtered = array();
        foreach ($cards as $card) {
            $filter = new CardListFilterForm();
            $filter->id = $card->id;
            $filter->primaryKey = $card->id;
            $filter->authorId = $card->userId;
            $filter->author = $card->user->username;
            $filter->status = $card->status;

            $revisions = $card->revisions;
            $revision = reset($revisions);
            $filter->date = strtotime($revision->date);
            $filter->revision = $revision->number;
            $filter->revisionId = $revision->id;

            $names = $card->cardAttributes(array('condition' => 'cardAttributes.identity = 1'));
            if (count($names)) {
                $nameAttribute = reset($names);
                $nameValue = RevisionAttribute::model()->find('revisionId = :rev AND attributeId = :attr', array(
                    ':rev' => $revision->id,
                    ':attr' => $nameAttribute->id));
                if ($nameValue) {
                    $filter->name = $nameValue->value;
                }
            }

            if (strlen(trim($this->name))) {
                if (mb_stripos($filter->name, $this->name, 0, 'UTF-8') !== false) {
                    $filtered[] = $filter;
                }
            } else {
                if (!strlen(trim($filter->name))) {
                    $filter->name = Yii::t('cardscape', 'Unidentified card');
                }
                $filtered[] = $filter;
            }
        }

        return new CArrayDataProvider($filtered, array(
            'sort' => array(
                'attributes' => array('name', 'revision', 'date', 'status', 'author')
            )
        ));
    }

}