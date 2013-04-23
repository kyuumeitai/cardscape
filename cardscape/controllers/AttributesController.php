<?php

/* AttributesController.php
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

class AttributesController extends CardscapeController {

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
                'deny'
            )
        );
    }

    private function loadAttributeModel($id) {
        throw new CHttpException(501, 'Not implemented yet.');
    }

    public function actionIndex() {
        $filter = new AttributeI18N('search');
        if (isset($_GET['AttributeI18N'])) {
            $filter->attributes = $_GET['AttributeI18N'];
        }

        $this->render('index', array('filter' => $filter));
    }

    public function actionCreate() {
        $this->render('create', array());
    }

    public function actionUpdate($id) {
        throw new CHttpException(501, 'Not implemented yet.');
    }

    public function actionDelete() {
        throw new CHttpException(501, 'Not implemented yet.');
    }

}
