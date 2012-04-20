<?php

class CPanelController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $user = User::model()->findByPk(Yii::app()->user->id);

        $this->render('index', array('user' => $user));
    }

}