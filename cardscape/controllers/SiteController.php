<?php

/* SiteController.php
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
 * Handles most site related actions. Everything from contact forms, login,
 * registration or any other action that is not directly related to an existing 
 * AR model.
 */
class SiteController extends CSController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module = null);
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'error', 'about', 'contactus'),
                'users' => array('*'),
            ),
            array(
                'allow',
                'actions' => array('login', 'confirmregistration'),
                'users' => array('?'),
            ),
            array(
                'allow',
                'actions' => array('logout'),
                'users' => array('@'),
            ),
            array(
                'deny'
            )
        );
    }

    /**
     * Default system action.
     * Used when the user requests the base URL or home page.
     */
    public function actionIndex() {
        $this->render('index');
    }

    /**
     * Whenever an error occurs this is the action that is used to show a message
     * to the user. It makes no difference if the error is a PHP error, an 
     * exception or some HTTP error like 404.
     * 
     * If the request was made by AJAX the error is simple echoed to the 
     * requqesting agent.
     */
    public function actionError() {
        if (($error = Yii::app()->errorHandler->error)) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Shows the login and registration page allowing users to either login with 
     * an existing account or register a new account if they don't have an account 
     * yet.
     */
    public function actionLogin() {
        $login = new LoginForm();
        $registration = new RegistrationForm();
        $this->performAjaxValidation('registration-form', $registration);

        if (isset($_POST['LoginForm'])) {
            $login->attributes = $_POST['LoginForm'];
            if ($login->login()) {
                if (Yii::app()->user->returnUrl) {
                    $this->redirect(Yii::app()->user->returnUrl);
                } else {
                    $this->redirect(Yii::app()->homeUrl);
                }
            }
        } else if (isset($_POST['RegistrationForm'])) {
            $registration->attributes = $_POST['RegistrationForm'];
            if ($registration->register()) {
                $this->redirect(array('site/confirmregistration'));
            }
        }

        $this->render('login', array(
            'login' => $login,
            'registration' => $registration
        ));
    }

    /**
     * After the registration form, if the process is successfull this action 
     * shows a summary page to the user and informs him that an activation e-mail 
     * was sent in order to complete the user registration process.
     */
    public function actionConfirmRegistration() {
        $this->render('confirm-registration');
    }

    /**
     * Logs a user out of the system and redirects to the home page. 
     */
    public function actionLogout() {
        if (!Yii::app()->user->isGuest) {
            Yii::app()->user->logout();
        }
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Shows the about page. 
     */
    public function actionAbout() {
        $this->render('about');
    }

    public function actionContactus() {
        $contact = new ContactForm();

        if (isset($_POST['ContactForm'])) {
            throw new CHttpException(501, 'Not implemented yet.');
        }

        $this->render('contactus', array('contact' => $contact));
    }

    /**
     * Processes the activation request and redirects to the site/status action 
     * with the proper status code.
     * 
     * Activating a user requires just loading the activation record based on the 
     * provided key, loading the related user, changing the user's password and 
     * status and deleting the activation record.
     * 
     * @param string $key The activation token sent to the user by e-mail
     */
    public function actionActivate($key) {
        $form = null;
        if (($activation = Activation::model()->find('token = :key', array(':key' => $key)))) {
            if (isset($_POST['ActivationForm'])) {
                $form = new ActivationForm();
                $form->attributes = $_POST['ActivationForm'];
                if ($form->activate()) {
                    $this->flash('success', Yii::t('cardscape', 'Your account has been activated, please login.'));
                    $this->redirect(array('login'));
                } else {
                    $this->flash('success', Yii::t('cardscape', 'Unable to activate your account, please contact an administrator.'));
                }
            }

            if ($activation->administratorRequested) {
                $form = new ActivationForm();
            } else {
                $user = $activation->user;
                $user->activationCompleted = 1;
                if ($user->save()) {
                    $activation->delete();
                }
            }
        }

        $this->render('activate', array('form' => $form));
    }

}
