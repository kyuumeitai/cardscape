<?php

class CardsController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        
    }

    public function actionBrowse($catalogue) {
        if ($catalogue == 'official') {
            $this->render('official');
        } else {
            $this->render('listall');
        }
    }

}
