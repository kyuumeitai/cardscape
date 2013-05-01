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
                'actions' => array('index', 'create', 'update', 'delete', 'reset'),
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

        if (isset($_GET['User'])) {
            $filter->attributes = $_GET['User'];
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
                $activation = new Activation();
                $activation->requestedAt = date('Y-m-d H:m:s');
                $activation->userId = $user->id;
                $activation->administratorRequested = 1;

                $sent = Yii::app()->mailer->addAddress($user->email)
                                ->subject(Yii::t('cardscape', 'Account activation for {system}', array('{system}' => Yii::app()->name)))
                                ->msgHTML($this->render('activation-email', array(
                                            'user' => $user,
                                            'activation' => $activation
                                                ), true)
                                )->send();
                if (!$activation->save() || !$sent) {
                    $this->flash('warning', Yii::t('cardscape', 'Could not send activation e-mail.'));
                }

                $this->flash('success', Yii::t('cardscape', 'New user created successfully.'));
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
                $this->flash('success', Yii::t('cardscape', '{username}\'s details updated.', array('{username}' => $user->username)));
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

            if ($user->save()) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false));
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, Yii::t('cardscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    /**
     * Forces a password reset by sending a new activation e-mail and setting the 
     * user's record to be inactive.
     * 
     * @param integer $id The user's ID
     */
    public function actionReset($id) {
        $user = $this->loadUserModel($id);

        $user->activationCompleted = 0;
        if ($user->save()) {
            // invalidate any previous e-mail and activation record
            Activation::model()->deleteAll('userId = :id', array(':id' => $user->id));

            $activation = new Activation();
            $activation->requestedAt = date('Y-m-d H:m:s');
            $activation->userId = $user->id;
            $activation->administratorRequested = 1;

            $sent = Yii::app()->mailer->addAddress($user->email)
                            ->subject(Yii::t('cardscape', 'Account activation for {system}', array('{system}' => Yii::app()->name)))
                            ->msgHTML($this->render('activation-email', array(
                                        'user' => $user,
                                        'activation' => $activation
                                            ), true)
                            )->send();

            if (!$activation->save() || !$sent) {
                echo json_encode(array('success' => false));
                Yii::app()->end();
            }
        }
        echo json_encode(array('success' => true));
    }

    /**
     * Same as update but automatically uses the logged in user's ID and shows 
     * a different interface.
     */
    public function actionProfile() {
        $user = $this->loadUserModel(Yii::app()->user->id);
        $this->performAjaxValidation('user-form', $user);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                $this->flash('success', Yii::t('cardscape', 'Profile updated.'));
                $this->redirect(array('profile'));
            }
        }
        $this->render('profile', array('user' => $user));
    }

    public function actionDetails($id) {
        throw new CHttpException(501, 'Not implemented yet.');
    }

}
