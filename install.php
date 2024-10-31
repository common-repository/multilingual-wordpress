<?php
/*
*	Multilingual-wordpress - Wordpress plugin for making multilingual websites
*	------------------------------------------------------------------------
*	Copyright (C) 2010, Sergio Milardovich <deep.milardovich@gmail.com>
*	This program is Free Software.
*
*	@package	Kleophatra
*	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
*	@author		Sergio Milardovich <deep.milardovich@gmail.com>
*	@link		http://www.kleophatra.org
*/
	function install_multilingual(){
		global $wpdb;
		$table = $wpdb->prefix.'multilingual_refs';
		if($wpdb->get_var("show tables like '$table'") != $table){
			$sql = "CREATE TABLE `".$wpdb->prefix."multilingual_refs` (
				`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`postid` INT( 11 ) NOT NULL ,
				`parent` INT( 11 ) NOT NULL ,
				`lang` VARCHAR( 4 ) NOT NULL ,
				`unique` INT( 11 ) NOT NULL 
				) ENGINE = MYISAM ;";
			$wpdb->query($sql);
		}
	}
	function uninstall_multilingual(){
		global $wpdb;
		$table = $wpdb->prefix.'multilingual_refs';
		if($wpdb->get_var("show tables like '$table'") == $table){
			$sql = "DROP TABLE " . $table_name;
			$results = $wpdb->query($sql);
		}
	}
	
?>
