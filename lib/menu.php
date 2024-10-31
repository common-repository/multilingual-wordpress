<?php
/*
 *	Multilingual-wordpress - Wordpress plugin for making multilingual websites
 *	Admin menu functions
 *	------------------------------------------------------------------------
 *	Copyright (C) 2010, Sergio Milardovich <deep.milardovich@gmail.com>
 *	This program is Free Software.
 *
 *	@package	Kleophatra
 *	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
 *	@author		Sergio Milardovich <deep.milardovich@gmail.com>
 *	@link		http://www.kleophatra.org
 */
	function multilingual_wordpress_admin_menu(){
		add_options_page('Multilingual options', __('Multilingual options'), '10', 'multilingual_wordpress', 'main_menu');
	}
	function main_menu(){
		$defaults = get_default_values();
		if($defaults['automatic_lang_redirection']){
			$auto_default = 'selected';
		}
		if($defaults['session_lang_redirection']){
			$sess_default = 'selected';
		}
		if($defaults['show_lang_warnings']){
			$warn_default = 'selected';
		}
		if($defaults['show_alternatives_box']){
			$alt_default = 'selected';
		}
		require_once MLWP_PATH.'views/options.php';
	}
	function get_default_values(){
		if(get_option('automatic_lang_redirection') == 'no'){
			$values['automatic_lang_redirection'] = true;
		}
		if(get_option('session_lang_redirection') == 'no'){
			$values['session_lang_redirection'] = true;
		}
		if(get_option('show_lang_warnings') == 'no'){
			$values['show_lang_warnings'] = true;
		}
		if(get_option('show_alternatives_box') == 'no'){
			$values['show_alternatives_box'] = true;
		}
		return $values;
	}
	function update_values(){
		if($_POST['session_lang_redirection']){
			if(get_option('session_lang_redirection')){
				update_option('session_lang_redirection',$_POST['session_lang_redirection']);
			} else {
				add_option('session_lang_redirection',$_POST['session_lang_redirection']);
			}
		}
		if($_POST['automatic_lang_redirection']){
			if(get_option('automatic_lang_redirection')){
				update_option('automatic_lang_redirection',$_POST['automatic_lang_redirection']);
			} else {
				add_option('automatic_lang_redirection',$_POST['automatic_lang_redirection']);
			}
		}
		if($_POST['show_lang_warnings']){
			if(get_option('show_lang_warnings')){
				update_option('show_lang_warnings',$_POST['show_lang_warnings']);
			} else {
				add_option('show_lang_warnings',$_POST['show_lang_warnings']);
			}
		}
		if($_POST['show_alternatives_box']){
			if(get_option('show_alternatives_box')){
				update_option('show_alternatives_box',$_POST['show_alternatives_box']);
			} else {
				add_option('show_alternatives_box',$_POST['show_alternatives_box']);
			}
		}
	}
?>
