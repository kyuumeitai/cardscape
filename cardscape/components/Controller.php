<?php

class Controller extends CController {

    public $layout;
    protected $menu;
    protected $breadcrumbs;
    protected $title;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->layout = '//layouts/main';
        $this->title = 'Cardscape';

        $this->menu = array(
            //public
            array(
                'label' => 'Home',
                'url' => array('/site')
            ),
            array(
                'label' => 'Browse Cards',
                //index.php?browse=0
                'url' => array('/cards', 'catalogue' => 'all')
            ),
            array(
                'label' => 'Statistics',
                //index.php?statistics
                'url' => array('site/statistics')
            ),
            //members
            array(
                'label' => 'New Card',
                //index.php?new_card 
                'url' => array('cards/suggest'),
                'visible' => !Yii::app()->user->isGuest
            ),
            array(
                'label' => 'Recent Activity',
                //index.php?recent_activity
                'url' => array('site/recent'),
                'visible' => !Yii::app()->user->isGuest
            ),
            array(
                'label' => 'Factions',
                //index.php?logout
                'url' => array('/factions'),
                //gamemaker
                'visible' => (!Yii::app()->user->isGuest && Yii::app()->user->role >= 2)
            ),
            array(
                'label' => 'Types',
                //index.php?logout
                'url' => array('/types'),
                //gamemaker
                'visible' => (!Yii::app()->user->isGuest && Yii::app()->user->role >= 2)
            ),
            array(
                'label' => 'Users',
                //index.php?logout
                'url' => array('/users'),
                //administrator
                'visible' => (!Yii::app()->user->isGuest && Yii::app()->user->role == 3)
            )
        );
    }

    public final function performAjaxValidation($form, $model) {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === $form || (is_array($form) && in_array($_POST['ajax'], $form)))) {
            echo CActiveForm::validate($model);

            Yii::app()->end();
        }
    }

}