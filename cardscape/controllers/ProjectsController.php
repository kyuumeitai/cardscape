<?php

/* ProjectsController.php
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

class ProjectsController extends CSController {

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

    /**
     * Loads a <em>Project</em> model from the database.
     * 
     * @param integer $id The project's ID to use when searching for the record.
     * @return Project The model if a record is found.
     * 
     * @throws CHttpException 
     */
    private function loadProjectModel($id) {
        if (($project = Project::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, Yii::t('cardscape', 'Invalid project. You\'re trying to load a project that does not exist.'));
        }
        return $project;
    }

    /**
     * Lists all available projects.
     */
    public function actionIndex() {
        $filter = new Project('search');
        $filter->unsetAttributes();
        $filter->active = 1;

        if (isset($_GET['Project'])) {
            $filter->attributes = $_GET['Project'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Allows administrators to create new projects. 
     */
    public function actionCreate() {
        $project = new Project();
        $this->performAjaxValidation('project-form', $project);

        if (isset($_POST['Project'])) {
            $project->attributes = $_POST['Project'];
            if ($project->save()) {
                $this->flash('success', Yii::t('cardscape', 'New project created.'));
                $this->redirect(array('update', 'id' => $project->id));
            }
        }

        $this->render('create', array('project' => $project,));
    }

    /**
     * @param intenger $id Database ID for the project.
     */
    public function actionUpdate($id) {
        $project = $this->loadProjectModel($id);
        $this->performAjaxValidation('project-form', $project);

        if (isset($_POST['Project'])) {
            $project->attributes = $_POST['Project'];
            if ($project->save()) {
                $this->flash('error', Yii::t('cardscape', 'Project updated.'));
                $this->redirect(array('update', 'id' => $project->id));
            }
        }

        $this->render('update', array('project' => $project));
    }

    /**
     * @param integer $id Project's database ID.
     * @throws CHttpException 
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest && (($project = $this->loadProjectModel($id)) !== null)) {
            $project->active = 0;
            if ($project->save()) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false));
            }
        } else {
            throw new CHttpException(400, Yii::t('cardscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

}
