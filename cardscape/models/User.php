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
 * This is an ActiveRecord class for the <em>User</em> table. Besides the standard 
 * AR methods and the table's attributes, this class offers a static methods to 
 * help in user related actions (hashing passwords, getting a human readable name 
 * for a role, etc.).
 * 
 * @property integer $userId User database ID
 * @property string $username Username for display and authetication
 * @property string $password The user's password, generally blank
 * @property string $email The email used for registering this user
 * @property integer $role A role defines what permissions a user has, can be any 
 * value in 0, 1 or 2 for standard user, moderator or administrator
 * 
 * @property string $location Description text containing the user location (optional)
 * @property string $msn Description text with the user MSN contact address (optional)
 * @property string $skype Description text with the user's Skyep contact address (optional)
 * @property string $twitter Description text with the user's Twitter contact address (optional)
 * @property string $avatar The URI (file or standard URL) for the user's avatar (optional)
 * @property integer $showEmail Flag that activates the display of the user's email 
 * address to other users, doesn't prevent administrators from seeing the address
 * 
 * @property string $about Description text with a message about the user (optional)
 * @property integer $active Flag that marks this user as a deleted user
 *
 * The following are the available model relations:
 * @property Card[] $cards The cards this user created
 * @property Comment[] $comments The comments this user wrote
 * @property Project[] $projects The projects this user moderates
 * @property Revision[] $revisions The this user created
 */
class User extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className Active record class name.
     * @return User The static model class
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
            array('username, email', 'required'),
            array('role, showEmail', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'max' => 25),
            array('email, location, msn, skype, avatar, about', 'length', 'max' => 255),
            array('twitter', 'length', 'max' => 50),
            // search rules, used only when invoking the search() method
            array('username, email, role', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array Relational rules.
     */
    public function relations() {
        return array(
                //TODO: uncomment when they became available
                //'cards' => array(self::MANY_MANY, 'Card', 'CardUser(userId, cardId)'),
                //'comments' => array(self::HAS_MANY, 'Comment', 'userId'),
                'projects' => array(self::MANY_MANY, 'Project', 'ProjectUser(userId, projectId)'),
                //'revisions' => array(self::HAS_MANY, 'Revision', 'userId'),
        );
    }

    /**
     * @return array Customized attribute labels (attribute name => label)
     */
    public function attributeLabels() {
        return array(
            'userId' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'role' => 'Role',
            'location' => 'Location',
            'msn' => 'Msn',
            'skype' => 'Skype',
            'twitter' => 'Twitter',
            'avatar' => 'Avatar',
            'showEmail' => 'Show E-mail',
            'about' => 'About me'
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
        //only show active users in default searches
        $criteria->compare('active', 1);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
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
     * @return array(ID => Role name)
     */
    public final static function roleNames() {
        //Roles: 0 - user, 1 - moderator, 2 - admin
        //TODO: Add i18n support
        return array(
            0 => 'User',
            1 => 'Moderator',
            2 => 'Administrator'
        );
    }

    /**
     * Gets the name of a given role. This is just a shortcut to the <em>roleNames</em> 
     * method.
     * 
     * @param integer $role The 0 based index for the role array.
     * @return string The role name that can be used in views.
     */
    public final static function roleNameById($role) {
        $roles = self::roleNames();

        return $roles[$role];
    }

}