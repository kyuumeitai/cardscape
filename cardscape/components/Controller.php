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
                //index.php
                'url' => array('site/index')
            ),
            array(
                'label' => 'Browse Cards',
                //index.php?browse=0
                'url' => array('cards/browse', 'catalogue' => 'all')
            ),
            array(
                'label' => 'Statistics',
                //index.php?statistics
                'url' => array('site/statistics')
            ),
            array(
                'label' => 'Login',
                //index.php?login
                'url' => array('site/login')
            ),
            //members
            array(
                'label' => 'User CP',
                //index.php?usercp
                'url' => array('/cpanel')
            ),
            array(
                'label' => 'New Card',
                //index.php?new_card 
                'url' => array('cards/suggest')
            ),
            array(
                'label' => 'Recent Activity',
                //index.php?recent_activity
                'url' => array('site/recent')
            ),
            array(
                'label' => 'Logout',
                //index.php?logout
                'url' => array('site/logout')
            )
        );
    }

}