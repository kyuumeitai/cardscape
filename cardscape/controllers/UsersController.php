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

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new User();
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->userId));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadUserModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->userId));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest && (($user = $this->loadUserModel($id)) !== null)) {
            $user->active = 0;
            $user->save();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     *
     * @param integer $id the record ID used to load the User model.
     * @return User the User model or null if the ID is invalid.
     * 
     * @throws CHttpException 
     */
    public function loadUserModel($id) {
        if (($model = User::model()->findByPk($id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    public function accessRules() {
        //merging with parent rules, though usually the parent just blocks everything
        return array_merge(
                        array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete'),
                        'users' => array('*'),
                    ),
                        //array('allow',
                        //    'actions' => array('create', 'update'),
                        //    'users' => array('@'),
                        //),
                        ), parent::accessRules()
        );
    }

}
