<?php

class UsersController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $filter = new User('search');
        $filter->unsetAttributes();
        
        $this->render('index', array('filter' => $filter));
    }

    public function actionCreate() {
        
    }

    public function actionEdit() {
        
    }

    public function actionDelete() {
        
    }

    public function actionResetPassword() {
        
    }

}