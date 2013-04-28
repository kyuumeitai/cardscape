<?php

/* UsersController.php
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

class UsersController extends CardscapeController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'create', 'update', 'delete'),
                'expression' => '(!Yii::app()->user->isGuest && $user->role == "administrator")'
            ),
            array(
                'allow',
                'actions' => array('profile', 'details'),
                'users' => array('@')
            ),
            array(
                'allow',
                'actions' => array('activate'),
                'users' => array('?')
            ),
            array(
                'deny'
            )
        );
    }

    /**
     * Loads a <em>User</em> model from the database using the provided <em>id</em> 
     * value. It should be used whenever we need to get a user record in this controller.
     * 
     * @param integer $id The record ID used to load the <em>User</em> model.
     * @return User The <em>User</em> model. No value is returned if the ID is 
     * invalid, instead an <em>CHttException</em> is thrown.
     * 
     * @throws CHttpException 
     */
    private function loadUserModel($id) {
        if (($user = User::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, Yii::t('cardscape', 'Invalid user. You\'re trying to load an user that does not exist.'));
        }

        return $user;
    }

    /**
     * Default action, lists all available (active) users. 
     */
    public function actionIndex() {
        $filter = new User('search');
        $filter->unsetAttributes();
        $filter->active = 1;

        if (isset($_POST['User'])) {
            $filter->attributes = $_POST['User'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Creates a new user. This actions is only available to administrators. 
     */
    public function actionCreate() {
        $user = new User();
        $this->performAjaxValidation('user-form', $user);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                //TODO: Create random password, send password by e-mail to the 
                //user if the proper flag was check in the user's creation interface.
                //Add proper flash messages.
                $this->redirect(array('update', 'id' => $user->id));
            }
        }

        $this->render('create', array('user' => $user));
    }

    /**
     * Allows an administrator to change a user's profile.
     * 
     * @param integer $id The user's database ID.
     */
    public function actionUpdate($id) {
        $user = $this->loadUserModel($id);
        $this->performAjaxValidation('user-form', $user);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                //TODO: Add proper flash messages.
                $this->redirect(array('update', 'id' => $user->id));
            }
        }

        $this->render('update', array('user' => $user));
    }

    /**
     * Deletes an existing user by setting its active property to be zero.
     * 
     * @param integer $id The user's database ID.
     * 
     * @throws CHttpException 
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest && (($user = $this->loadUserModel($id)) !== null)) {
            $user->active = 0;
            $user->save();
            //TODO: Add proper flash messages.

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('cardscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionActivate($key) {
        //TODO: Not implemented yet!
        throw new CHttpException(501, 'Not implemented yet.');
    }

    public function actionProfile() {
        $user = $this->loadUserModel(Yii::app()->user->id);
        //TODO: Not implemented yet!
        throw new CHttpException(501, 'Not implemented yet.');
    }

    public function actionDetails($id) {
        throw new CHttpException(501, 'Not implemented yet.');
    }

}
