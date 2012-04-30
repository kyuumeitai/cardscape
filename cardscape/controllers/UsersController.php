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

class UsersController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function accessRules() {
        //merging with parent rules, though usually the parent just blocks everything
        return array_merge(
                        array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete'),
                        'expression' => '($user->role == 2)'
                    )
                        ), parent::accessRules()
        );
    }

    /**
     * Default action, lists all available (active) users. 
     */
    public function actionIndex() {
        $filter = new User('search');
        $filter->unsetAttributes();

        if (isset($_POST['User'])) {
            $filter->attributes = $_POST['User'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Creates a new user. This actions is only available to administrators. 
     */
    public function actionCreate() {
        //TODO: incomplete, allow for avatar upload
        $user = new User();
        $this->performAjaxValidation('user-form', $user);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                //TODO: send the password to the new user's email
                $this->redirect(array('update', 'id' => $user->userId));
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
        //TODO: incomplete, allow for avatar upload
        $user = $this->loadUserModel($id);

        $this->performAjaxValidation('user-form', $user);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save())
                $this->redirect(array('update', 'id' => $user->userId));
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

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     *
     * @param integer $id The record ID used to load the User model.
     * @return User The User model or null if the ID is invalid.
     * 
     * @throws CHttpException 
     */
    public function loadUserModel($id) {
        if (($model = User::model()->findByPk($id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

}
