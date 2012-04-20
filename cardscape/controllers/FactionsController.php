<?php

class FactionsController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $filter = new Faction('search');
        $filter->unsetAttributes();

        $this->render('index', array('filter' => $filter));
    }

    public function actionCreate() {
        $this->render('edit', array('faction' => $faction));
    }

    public function actionUpdate($id) {
        
    }

    public function actionDelete($id) {
        
    }

}