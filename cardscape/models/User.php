<?php

/* User.php
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
 * This is an ActiveRecord class for the <em>User</em> table. Besides the standard 
 * AR methods and the table's attributes, this class offers a static methods to 
 * help in user related actions (hashing passwords, getting a human readable name 
 * for a role, etc.).
 * 
 * @property integer $id User database ID
 * 
 * @property string $username Username for display and authetication.
 * @property string $password The user's password, generally blank.
 * @property string $email The email used for registering this user.
 * @property integer $role A role defines what permissions a user has, can be any 
 * value in 'user', 'moderator', 'administrator' for standard user, moderator or administrator.
 * 
 * @property string $language Language used in the system and card data.
 * @property integer $active Flag that marks this user as a deleted user.
 * @property integer $activationCompleted Flag that indicates if this user has finished the 
 * activation process.
 *
 * Relations:
 * @property Card[] $cards The cards this user created.
 * @property Comment[] $comments The comments this user wrote.
 * @property Project[] $projects The projects this user moderates.
 * @property Revision[] $revisions The list of revisions this user created.
 */
class User extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className Active record class name.
     * @return User
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string The associated database table name.
     */
    public function tableName() {
        return '{{User}}';
    }

    /**
     * @return array Validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('username, email, role', 'required'),
            array('username', 'length', 'max' => 25),
            array('language', 'length', 'max' => 5),
            array('email', 'length', 'max' => 255),
            array('email', 'email'),
            array('role', 'in', 'range' => array('user', 'moderator', 'administrator')),
            array('activationCompleted', 'numerical', 'integerOnly' => true),
            // search
            array('username, email, role, activationCompleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array Relational rules.
     */
    public function relations() {
        return array(
            'cards' => array(self::MANY_MANY, 'Card', 'CardUser(userId, cardId)'),
            'comments' => array(self::HAS_MANY, 'Comment', 'userId'),
            'projects' => array(self::MANY_MANY, 'Project', 'ProjectUser(userId, projectId)'),
            'revisions' => array(self::HAS_MANY, 'Revision', 'userId'),
            'activations' => array(self::HAS_MANY, 'Activation', 'userId')
        );
    }

    /**
     * @return array Customized attribute labels (attribute name => label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('cardscape', 'ID'),
            'username' => Yii::t('cardscape', 'Username'),
            'password' => Yii::t('cardscape', 'Password'),
            'email' => Yii::t('cardscape', 'E-mail'),
            'role' => Yii::t('cardscape', 'Role'),
            'language' => Yii::t('cardscape', 'Language'),
            'activationCompleted' => Yii::t('cardscape', 'Activated')
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * 
     * @return CActiveDataProvider The data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('activationCompleted', $this->activationCompleted);
        $criteria->compare('active', 1);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'username,email,role'
            )
        ));
    }

    /**
     * Creates a hash from the given password using the correct hashing process.
     * This method should be prefered over manually hashing any password.
     * 
     * @param string $password The password you whish to hash.
     * 
     * @return string The hashed password. 
     */
    public final static function hash($password) {
        return sha1($password . Yii::app()->params['hash']);
    }

    /**
     * Provides an array with the proper names to be shown to the user when dealing 
     * with roles.
     * 
     * @return array(role => Role name)
     */
    public final static function getRolesArray() {
        return array(
            'user' => 'User',
            'moderator' => 'Moderator',
            'administrator' => 'Administrator'
        );
    }

    /**
     * Gets the name of a given role. This is just a shortcut to the method.
     * 
     * @param integer $role The 0 based index for the role array.
     * @return string The role name that can be used in views.
     */
    public function getRoleName($role) {
        $roles = self::getRolesArray();

        return isset($roles[$role]) ? $roles[$role] : Yii::t('cardscape', 'Unknown role');
    }

}
