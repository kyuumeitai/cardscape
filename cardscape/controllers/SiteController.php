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

class SiteController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module = null);
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
     * Shows the login/register view and provides login and register features. 
     */
    public function actionLogin() {
        $login = new LoginForm();
        $register = new RegisterForm();

        $this->performAjaxValidation('register-form', $register);

        if (isset($_POST['LoginForm'])) {
            $login->attributes = $_POST['LoginForm'];
            if ($login->validate() && $login->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        } else if (isset($_POST['RegisterForm'])) {
            $register->attributes = $_POST['RegisterForm'];
            if ($register->validate() && $register->register()) {
                $login->email = $register->email;
                $login->password = $register->password;

                if ($login->login()) {
                    $this->redirect(Yii::app()->user->returnUrl);
                } else {
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('login', array(
            'login' => $login,
            'register' => $register
        ));
    }

    /**
     * Logs a user out of the system and redirects to the home page. 
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Allows a user to recover a lost password. 
     */
    public function actionRecover() {
        
    }

}