<?php

/* RevisionAttribute.php
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
 * Relation entity, connects a <em>Revision</em> model with the <em>Attribute</em> 
 * model and stores the value for that connections.
 * 
 * This model contains the actual value of an attribute, written by the user,
 * for the related card revision.
 * 
 * @property integer $revisionId ID of the related <em>Revision</em> entity.
 * @property integer $attributeId ID of the related <em>Attribute</em> entity.
 * @property string $value Value of the attribute for the revision.
 * 
 * Relations:
 * @property Revision $revision Owner revision.
 * @property Attribute $attribute Owner attribute.
 */
class RevisionAttribute extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return RevisionAttribute The static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name
     */
    public function tableName() {
        return '{{RevisionAttribute}}';
    }

    public function relations() {
        return array(
            'attribute' => array(self::BELONGS_TO, 'Attribute', 'attributeId'),
            'revision' => array(self::BELONGS_TO, 'Revision', 'revisionId')
        );
    }

}
