<?php

class SiteController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module = null);
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionError() {
        if (($error = Yii::app()->errorHandler->error)) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    public function actionLogin() {
        $this->render('login');
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}