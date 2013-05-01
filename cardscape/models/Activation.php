<?php

/* Activation.php
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
 * <em>Activation</em> objects are responsible for allowing a user to activate 
 * his/her account after registration of after either the user or an administrator 
 * has requested a password reset.
 * 
 * @property integer $id ID for the database record.
 * @property string $token The identifier token string, this value is automatically 
 * generated for new <em>Activation</em> models at instantiation.
 * 
 * @property string $requestedAt Date for when the activation request was generated.
 * @property integer $administratorRequested Flag that identifies this activation 
 * record as being created by an administrator.
 * 
 * @property integer $userId The owner of the activation record.
 *
 * Relations:
 * @property User $user
 */
class Activation extends CActiveRecord {

    public function __construct($scenario = 'insert') {
        parent::__construct($scenario);

        if ($scenario == 'insert') {
            $this->token = md5(time());
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className Active record class name.
     * @return Activation The static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name
     */
    public function tableName() {
        return '{{Activation}}';
    }

    /**
     * @return array Relational rules.
     */
    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId')
        );
    }

    /**
     * @return array Customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('cardscape', 'ID'),
            'token' => Yii::t('cardscape', 'Token'),
            'requestedAt' => Yii::t('cardscape', 'Date'),
            'administratorRequested' => Yii::t('cardscape', 'Requested by administrator'),
            'userId' => Yii::t('cardscape', 'USer')
        );
    }

}
