<?php

/* AdministrationController.php
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
 * Controller that offers administration actions used only by administrators to 
 * customize some aspects of Cardscape.
 */
class AdministrationController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module = null);
    }

    /*public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index'),
                'users' => array('*')
            )
        );
    }*/

    /**
     * Shows the various settings forms. 
     */
    public function actionIndex() {
        $suForm = new SettingsUserForm();
        $seForm = new SettingsEmailForm();
        $ssForm = new SettingsSystemForm();

        $this->performAjaxValidation('user-form', $suForm);
        $this->performAjaxValidation('email-form', $seForm);
        $this->performAjaxValidation('system-form', $ssForm);

        //TODO: show proper success message and tab
        if (isset($_POST['SettingsUserForm'])) {
            $suForm->attributes = $_POST['SettingsUserForm'];
            if ($suForm->validate() && $suForm->save()) {
                $this->redirect(array('index'));
            }
        } else if (isset($_POST['SettingsEmailForm'])) {
            $seForm->attributes = $_POST['SettingsEmailForm'];
            if ($seForm->validate() && $seForm->save()) {
                $this->redirect(array('index'));
            }
        } else if (isset($_POST['SettingsSystemForm'])) {
            $ssForm->attributes = $_POST['SettingsSystemForm'];
            if ($ssForm->validate() && $ssForm->save()) {
                $this->redirect(array('index'));
            }
        }

        $languages = Yii::app()->params['languages'];

        $this->render('index', array(
            'suForm' => $suForm,
            'seForm' => $seForm,
            'ssForm' => $ssForm,
            'languages' => $languages
        ));
    }

}
