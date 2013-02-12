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

class AttributesController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /*public function accessRules() {
        //merging with parent rules, though usually the parent just blocks everything
        return array_merge(
                        array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete'),
                        'expression' => '($user->role == 2)'
                    )
                        ), parent::accessRules()
        );
    }*/

    /**
     * Default action, lists all available (active) attributes. 
     */
    public function actionIndex() {

        $criteria = new CDbCriteria();
        $criteria->compare('active', 1);
        $data = new CActiveDataProvider('Attribute', array('criteria' => $criteria));

        $this->render('index', array('data' => $data));
    }

    public function actionCreate() {
        $this->render('create');
    }

    public function actionUpdate($id) {
        $this->render('update');
    }

    public function actionDelete($id) {
        //TODO: not implemented yet  
    }

}
