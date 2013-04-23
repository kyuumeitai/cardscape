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
class SiteController extends CardscapeController {

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
                //TODO: Proper redirection
                $this->redirec('site/index');
            }
        } else if (isset($_POST['RegistrationForm'])) {
            $registration->attributes = $_POST['RegistrationForm'];
            if ($registration->register()) {
                //TODO: Proper redirection and flash messages
                $this->redirect('site/confirmregistration');
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
        throw new CHttpException(501, 'Not implemented yet.');
        //$this->render('confirm-registration');
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
        throw new CHttpException(501, 'Not implemented yet.');
        //$this->render('about');
    }

    public function actionContactus() {
        $contact = new ContactForm();

        if (isset($_POST['ContactForm'])) {
            throw new CHttpException(501, 'Not implemented yet.');
        }
        
        $this->render('contactus', array('contact' => $contact));
    }

}
