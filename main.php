<?php
   /*
      Plugin Name: Multilingual wordpress
      Plugin URI: http://milardovich.com.ar/
      Description: The ultimate plugin for making multilingual websites with wordpress.
      Version: 0.1.2
      Author: Sergio Milardovich
      Author URI: http://milardovich.com.ar
   */

	// Defines a lo milardo(klemode = true)
	define("MLWP_PATH", dirname(__FILE__).'/', true);

	require_once MLWP_PATH.'install.php';

	// Core actions
	add_action('activate_multilingual-wordpress/main.php','install_multilingual');
	add_action('deactivate_multilingual-wordpress/main.php', 'uninstall_multilingual');

	require_once MLWP_PATH.'lib/backend.php';
	require_once MLWP_PATH.'lib/frontend.php';
	require_once MLWP_PATH.'lib/menu.php';
	require_once MLWP_PATH.'lib/init.php';

?>
