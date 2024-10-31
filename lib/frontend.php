<?php
/*
 *	Multilingual-wordpress - Wordpress plugin for making multilingual websites
 *	Frontend functions
 *	------------------------------------------------------------------------
 *	Copyright (C) 2010, Sergio Milardovich <deep.milardovich@gmail.com>
 *	This program is Free Software.
 *
 *	@package	frontend functions
 *	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
 *	@author		Sergio Milardovich <deep.milardovich@gmail.com>
 *	@link		http://www.milardovich.com.ar
 */

	function do_lang_redirection(){
		$redirect = get_option('redirect_'.$_SERVER['REMOTE_ADDR']);
		delete_option('redirect_'.$_SERVER['REMOTE_ADDR']);
		wp_redirect($redirect);

	}
	function automatic_redirection($content){
		global $wpdb;
		$postid = get_the_id();
		(int)$unique = get_parent_lang_unique($postid);
		if(!get_option('session_lang_'.$_SERVER['REMOTE_ADDR'])){
			$langs = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		} else {
			$langs[] = get_option('session_lang_'.$_SERVER['REMOTE_ADDR']);
		}
		foreach($langs as $lang){
			$lang = substr($lang,0,2);
			$row = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."multilingual_refs WHERE postid != $postid AND `unique` = $unique AND lang = '$lang'",ARRAY_A);
			if($row){
				foreach($row as $link){
					if(get_parent_lang($link['postid']) == get_option('session_lang_'.$_SERVER['REMOTE_ADDR'])){
						add_option('redirect_'.$_SERVER['REMOTE_ADDR'], get_permalink($link['postid']));
						break;
					}
				}
			}
		}
		return $content;
	}

	function warn_translation($content){
		global $wpdb;
		$postid = get_the_id();
		$unique = get_parent_lang_unique($postid);
		if(!get_option('session_lang_'.$_SERVER['REMOTE_ADDR'])){
			$langs = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		} else {
			$langs[] = get_option('session_lang_'.$_SERVER['REMOTE_ADDR']);
		}
		foreach($langs as $lang){
			$lang = substr($lang,0,2);
			$row = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."multilingual_refs WHERE `unique` = $unique AND lang = '$lang' AND postid != $postid",ARRAY_A);
			if($row){
					$content = __('<p>This article is also avaliable in your language. Clic ').'<a href="'.get_permalink($row[0]['postid']).'">'.__('here').'</a> '.__('to see it').'.</p>'.$content;

			}
			break;
		}
		return $content;
	}
	function set_session_language($lang){
		if(get_option('session_lang_'.$_SERVER['REMOTE_ADDR'])){
			update_option('session_lang_'.$_SERVER['REMOTE_ADDR'], $lang);			
		} else {
			add_option('session_lang_'.$_SERVER['REMOTE_ADDR'], $lang);
		}
	}
	function get_alternatives_box($content){
		$translations = get_translations(get_the_id());
		if($translations){
			$output = '<div class="languages_box">';
			$output .= __('This article is also avaliable in: ');
			foreach($translations as $translation){
			$output .= '<a href="'.$translation['link'].'"><img alt="'.$translation['lang'].'" src="'.get_option('siteurl').'/wp-content/plugins/multilingual-wordpress/media/flags/'.$translation['lang'].'.gif" /> ';
		}
			$output .= '</div>';
			$content = $content.$output;
		}
		return $content;
	}
	function get_translations($postid){
		global $wpdb;
		$unique = get_parent_lang_unique($postid);
		$rows = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."multilingual_refs` WHERE `unique` =$unique AND postid != $postid", ARRAY_A);
		$i=0;
		if($rows){
			foreach($rows as $row){
				if($row['unique'] == 0){
					break;
				}
				$output[$i]['link'] = get_permalink($row['postid']);
				$output[$i]['lang'] = $row['lang'];
				$i++;
			}
		}
		if($i !== 0){
			return $output;
		} else {
			return false;
		}
	}
	function get_parent_lang($postid){
		global $wpdb;
		$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."multilingual_refs WHERE postid = $postid", ARRAY_A);
		return $rows[0]['lang'];
	}
	function get_parent_lang_id($postid){
		global $wpdb;
		$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."multilingual_refs WHERE postid = $postid", ARRAY_A);
		return $rows[0]['parent'];
	}
	function get_parent_lang_unique($postid){
		global $wpdb;
		$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."multilingual_refs WHERE postid = $postid", ARRAY_A);
		return $rows[0]['unique'];
	}
	function add_default_lang_reference($content){
		global $wpdb;
		$postid = (int)get_the_id();
		$lang = substr(get_locale(),0,2);
		$parent = (int)get_parent_lang_id($postid);
		add_reference($postid,0,$lang);
		add_reference($parent,0,$lang);
		return $content;
	}
	function add_reference($postid,$parent,$lang,$unique=false){
		global $wpdb;
		if(!$unique){
			if($parent !== 0){
				$unique = get_parent_lang_unique($parent);
				if($unique !== 0){
					$unique = get_parent_lang_unique($postid);
				}
			}
		}
		$check = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."multilingual_refs WHERE postid = '$postid' AND parent = '$parent'",ARRAY_A);
		if(!$check){
			$query = $wpdb->get_results("INSERT INTO `".$wpdb->prefix."multilingual_refs` (
				`id` ,
				`postid` ,
				`parent` ,
				`lang`,
				`unique`
			) VALUES (
				NULL , '$postid', '$parent', '$lang','$unique'
			);");
		}
	}
