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

class Controller extends CController {

    /**
     * @var string The name of the layout used by the controller. Defaults to 
     * //layouts/main.
     * 
     * Should not be changed unless really necessary and it's only a public 
     * attribute because it needs to be used outside this class' scope. 
     */
    public $layout;

    /**
     * @var array Contains the application menu that is passed on to the 
     * zii.widgets.CMenu class in the application's layout.
     */
    protected $menu;

    /**
     * @var string Page tile, should be overriden by each controller/view when 
     * setting the page title.
     */
    protected $title;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->layout = '//layouts/main';
        $this->title = 'Cardscape';

        //Default menu taken from the previous version, may need to be updated.
        //The commented query strings represent the request that was used before
        //and may be used as reference.
        //TODO: Uncomment menu elements when they became active
        $this->menu = array(
            //public or guest links
            array(
                'label' => 'Home',
                'url' => array('site/index')
            ),
            array(
                'label' => 'Login or Register',
                'url' => array('site/login'),
                'visible' => Yii::app()->user->isGuest
            ),
            //array(
            //    'label' => 'Browse Cards',
            //    //index.php?browse=0
            //    'url' => array('cards/index', 'catalogue' => 'all')
            //),
            //array(
            //    'label' => 'Statistics',
            //    //index.php?statistics
            //    'url' => array('site/statistics')
            //),
            //members
            //array(
            //    'label' => 'New Card',
            //    //index.php?new_card 
            //    'url' => array('cards/suggest'),
            //    'visible' => !Yii::app()->user->isGuest
            //),
            //array(
            //    'label' => 'Recent Activity',
            //    //index.php?recent_activity
            //    'url' => array('site/recent'),
            //    'visible' => !Yii::app()->user->isGuest
            //),
            array(
                'label' => 'Users',
                'url' => array('users/index'),
                //visible to administrators only
                'visible' => (!Yii::app()->user->isGuest && Yii::app()->user->role == 3)
            )
        );
    }

    /**
     * Performs AJAX validation that can be used by forms to dynamically validate 
     * user input in the server or for AJAX requests that need to validade a 
     * given model.
     * 
     * @param mixed $form
     * @param mixed $model 
     */
    public final function performAjaxValidation($form, $model) {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === $form || (is_array($form) && in_array($_POST['ajax'], $form)))) {
            echo CActiveForm::validate($model);

            Yii::app()->end();
        }
    }

    /**
     * Please see Yii's documentation about filters and particular access control 
     * filter. This method activates the use of filters in controller actions 
     * and will be used whenever an action is requested.
     * 
     * The default filter is access control that is used to limit access to certain
     * users depending on the access rules in place for the controller.
     * 
     * @return array Default action filters.
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /*
     * //NOTE: //TODO: uncomment this when authentication and access rules are in 
     * is in place else we lock everyone out of the system.
      public function accessRules() {
      return array(
      //default rule denies every action to every user
      array('deny',
      'users' => array('*'),
      )
      );
      }
     */
}