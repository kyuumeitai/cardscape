<?php

class CardsController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $filter = new Card();
        $filter->unsetAttributes();

        if ($catalogue == 'official') {
            $filter->status = 4;
        }

        $this->render('index', array('filter' => $filter));
        /*
          global $dbh, $smarty, $cfg;
          $prefix = $cfg[ 'database' ][ 'prefix' ];
          $pagesize = $cfg[ 'database' ][ 'pagesize' ];
          $display_offset = intval(
          ( $official )
          ? $_GET[ 'browse_official_cards' ]
          : $_GET[ 'browse' ] );

          if( $display_offset < 0 ) $display_offset = 0;

          $querystr ='SELECT c.id, c.name, c.date, c.status,
          u.name AS author FROM '.$prefix.'cards c LEFT JOIN
          '.$prefix.'users u ON c.author = u.uid ';
          if( $official ) { //take a different query string instead
          $querystr = 'SELECT o.id, o.revision, c.name, c.faction FROM
          '.$prefix.'official o LEFT JOIN '.$prefix.'cards c ON
          o.dev_id = c.id';
          }

          $querystr .= ' LIMIT :offset, :pagesize';

          $query = $dbh -> prepare( $querystr );

          $query -> bindValue( ':offset', $display_offset, PDO::PARAM_INT );
          $query -> bindValue( ':pagesize', $pagesize, PDO::PARAM_INT );

          $query -> execute();

          $cards = $query -> fetchAll( PDO::FETCH_CLASS, 'Card' );

          $smarty -> assign( 'cards', $cards );
          $smarty -> assign( 'offset', $display_offset );
          $smarty -> assign( 'pagesize', $pagesize );
          if( $official ) {
          $smarty -> display( 'browse_official_cards.tpl' );
          } else {
          $smarty -> display( 'browse_cards.tpl' );
          }
         */
    }

}
