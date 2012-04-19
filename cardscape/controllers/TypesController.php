<?php

class TypesController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $filter = new Type('search');
        $filter->unsetAttributes();

        $this->render('index', array('filter' => $filter));
    }

}