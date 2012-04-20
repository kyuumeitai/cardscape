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
        $login = new LoginForm();
        $register = new RegisterForm();

        $this->performAjaxValidation('register-form', $register);

        if (isset($_POST['LoginForm'])) {
            $login->attributes = $_POST['LoginForm'];
            if ($login->validate() && $login->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        } else if (isset($_POST['RegisterForm'])) {
            $register->attributes = $_POST['RegisterForm'];
            if ($register->validate() && $register->register()) {
                $login->email = $register->email;
                $login->password = $register->password;

                if ($login->login()) {
                    $this->redirect(Yii::app()->user->returnUrl);
                } else {
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('login', array(
            'login' => $login,
            'register' => $register
        ));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionStatistics() {
        /*
          global $dbh, $smarty, $cfg;
          $prefix = $cfg[ 'database' ][ 'prefix' ];
          $fields = $cfg[ 'database' ][ 'statistic_fields' ];

          $query = $dbh -> prepare( 'SELECT '.$fields.' FROM '.$prefix.'cards' );
          $query -> execute();

          $fields = explode( ',', $fields );

          $statistics = array();
          foreach( $fields as $field ) {
          $statistics[ $field ] = array();
          }

          while( $card_data = $query -> fetch( PDO::FETCH_ASSOC ) ) {
          foreach( $fields as $field ) {
          $val = $card_data[ $field ];
          if( isset( $statistics[ $field ][ $val ] ) ) {
          $statistics[ $field ][ $val ]++;
          } else
          $statistics[ $field ][ $val ] = 1;
          }
          }

          foreach( $fields as $field ) {
          $smarty -> assign( 'field', $field );
          $smarty -> assign( 'counts', $statistics[ $field ] );
          $smarty -> display( 'statistics.tpl' );
          }
         */
        $this->render('statistics');
    }

    public function actionRecent() {
        /*
          global $dbh, $smarty, $cfg;
          $prefix = $cfg[ 'database' ][ 'prefix' ];
          $pagesize = $cfg[ 'database' ][ 'pagesize' ];
          $display_offset = intval( $_GET[ 'recent_activity' ] );
          if( $display_offset < 0 ) $display_offset = 0;

          $query = $dbh -> prepare( 'SELECT h.date, h.action, c.id AS card_id, c.name AS card_name, u.uid AS user_id, u.name AS username
          FROM '.$prefix.'history h
          LEFT JOIN '.$prefix.'users u ON h.user = u.uid
          LEFT JOIN '.$prefix.'cards c ON h.card = c.id
          LIMIT :offset, :pagesize' );

          $query -> bindValue( ':offset', $display_offset, PDO::PARAM_INT );
          $query -> bindValue( ':pagesize', $pagesize, PDO::PARAM_INT );

          $query -> execute();

          $hist_entries = $query -> fetchAll( PDO::FETCH_ASSOC );
          $smarty -> assign( 'hist_entries', $hist_entries );
          $smarty -> assign( 'offset', $display_offset );
          $smarty -> assign( 'pagesize', $pagesize );
          $smarty -> display( 'history.tpl' );
         */
        $this->render('recent');
    }

}