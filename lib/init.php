<?php
/*
 *	Multilingual-wordpress - Wordpress plugin for making multilingual websites
 *	Load operations
 *	------------------------------------------------------------------------
 *	Copyright (C) 2010, Sergio Milardovich <deep.milardovich@gmail.com>
 *	This program is Free Software.
 *
 *	@package	Kleophatra
 *	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
 *	@author		Sergio Milardovich <deep.milardovich@gmail.com>
 *	@link		http://www.kleophatra.org
 */

	function multilingual_init_locale(){
		load_plugin_textdomain('multilingual', MLWP_PATH.'lang', 'multilingual-wordpress/lang');
	}


	add_action('init', 'multilingual_init_locale');
	add_action('admin_menu', 'multilingual_wordpress_add_custom_box');
	add_action('save_post', 'multilingual_wordpress_save_data');
	add_action('admin_menu', 'multilingual_wordpress_admin_menu');

	if(is_admin() && $_POST['session_lang_redirection'] && $_POST['automatic_lang_redirection']){
		update_values();
	}

	/*
	 * Create lang session
	 */
	if(isset($_GET['lang'])){
		if(strlen($_GET['lang']) == 2){
			set_session_language($_GET['lang']);
		}
	}
	/*
	 * Arbitrary/automatic redirection (BETA)
	 */
	if(get_option('automatic_lang_redirection') == 'yes'){
		add_action('the_content', 'automatic_redirection');
	}

	add_filter('the_content', 'add_default_lang_reference');
/*
	/*
	 * This feature can wait to be released...
	 *
	if(get_option('redirect_'.$_SERVER['REMOTE_ADDR'])){
		add_action('template_redirect', 'do_lang_redirection');
	}
*/
	/*
	 * Show 'warns'
	 */
	if(get_option('show_lang_warnings') == 'yes'){
		add_filter('the_content', 'warn_translation');
	}

	/*
	 * Alternatives box
	 */
	if(get_option('show_alternatives_box') == 'yes'){
		add_filter('the_content', 'get_alternatives_box');
	}


?>
