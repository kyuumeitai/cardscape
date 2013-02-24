<?php

/* Projects.php
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

class ProjectsController extends CardscapeController {

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
     * Lists all available projects.
     */
    public function actionIndex() {
        $filter = new Project('search');
        $filter->unsetAttributes();

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
                $this->redirect(array('update', 'id' => $project->projectId));
            }
        }

        $this->render('create', array('project' => $project,));
    }

    /**
     * Allows administrators to update existing project's information.
     * @param intenger $id Database ID for the project.
     */
    public function actionUpdate($id) {
        $project = $this->loadProjectModel($id);
        $this->performAjaxValidation('project-form', $project);

        if (isset($_POST['Project'])) {
            $project->attributes = $_POST['Project'];
            if ($project->save()) {
                $this->redirect(array('update', 'id' => $project->projectId));
            }
        }

        $this->render('update', array('project' => $project));
    }

    /**
     * Used to delete projects, currently only available in the projects list (index).
     * 
     * @param integer $id Project's database ID.
     * 
     * @throws CHttpException 
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest && (($project = $this->loadModel($id)) !== null)) {
            $project->active = 0;
            $project->save();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Loads a Project model from the database.
     * 
     * @param integer $id The project's ID to use when searching for the record.
     * @return Project The model if a record is found.
     * 
     * @throws CHttpException 
     */
    public function loadProjectModel($id) {
        if (($project = Project::model()->findByPk($id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $project;
    }

}
