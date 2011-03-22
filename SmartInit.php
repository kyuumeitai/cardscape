<?php
require_once( 'smarty/Smarty.class.php' );
require_once( 'config.php' );

class SmartInit extends Smarty {
	function __construct () {
		parent::__construct();

		global $cfg;

		$smarty_home = $cfg[ 'dirs'][ 'smarty_home' ];

		$this -> template_dir = $smarty_home.'templates';
		$this -> compile_dir = $smarty_home.'templates_c';
		$this -> config_dir = $smarty_home.'configs';
		$this -> cache_dir = $smarty_home.'caches';

		//$this -> caching = true;

		$this -> assign( 'page_title', 'Cardscape' );
	}

}

?>
