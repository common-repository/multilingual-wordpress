<?php
/*
*	Multilingual-wordpress - Wordpress plugin for making multilingual websites
*	Backend functions
*	------------------------------------------------------------------------
*	Copyright (C) 2010, Sergio Milardovich <deep.milardovich@gmail.com>
*	This program is Free Software.
*
*	@package	Kleophatra
*	@license	http://www.gnu.org/copyleft/gpl.html GNU/GPL License 2.0
*	@author		Sergio Milardovich <deep.milardovich@gmail.com>
*	@link		http://www.kleophatra.org
*/
	function multilingual_wordpress_add_custom_box(){
		if(function_exists('add_meta_box')){
			add_meta_box( 'multilingual-wordpress', 'Multilingual Support', 'multilingual_wordpress_add_inner_box', 'post', 'normal', 'high' );
			add_meta_box( 'multilingual-wordpress', 'Multilingual Support', 'multilingual_wordpress_add_inner_box', 'page', 'normal', 'high' );
		}
	}
	function multilingual_wordpress_add_inner_box($post){
		require_once MLWP_PATH.'data/langs.php';
		global $wpdb;
		$table = $wpdb->prefix."multilingual_refs";

		/*
		 * Language select in the admin pannel
		 */
		if($wpdb->get_var("show tables like '$table'") == $table) {
			$default = "";
			if ($post->ID) {
				$post_lang = get_post_language($post->ID);
			}
			echo '<label for="language">Post language:</label>';
			echo '<select id="language" name="language">';
			$short_lang = array_flip($langs);
			foreach($langs as $lang){
				echo '<option value="'.$short_lang[$lang].'"';
				if($post_lang == $short_lang[$lang]){
					echo ' selected';
				}
				echo '>'.$lang.'</option>';
			}
			echo '</select><br/>';
			/*
			 * Parent ID select in the admin pannel
			 */
			$postid = $post->ID;
			$check_lang = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."multilingual_refs WHERE postid = $postid", ARRAY_A);
			echo '<label for="language_parent_id">Parent ID:</label>';
			echo '<select id="language_parent_id" name="language_parent_id">';
			if($postid){
				$extend = 'AND ID != '.$postid;
			}
			$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts WHERE post_status = 'publish' $extend ORDER BY ID DESC", ARRAY_A);
			echo '<option value="0">(none)</option>';
			foreach($rows as $row){
				echo '<option value="'.$row['ID'].'"';
				if(intval($check_lang[0]['parent']) == intval($row['ID'])){
					echo ' selected';
				}
				echo '>'.$row['ID'].' - '.htmlentities(substr($row['post_title'],0,120)).'... </option>';
			}
			echo '</select>';
			
		}
	}
	function multilingual_wordpress_save_data(){
		$post_id = (int)$_POST['post_ID'];
		if(isset($_POST['language_parent_id']) && isset($_POST['language'])){
			set_post_language($post_id,$_POST['language_parent_id'],$_POST['language']);
		}
	}

	function set_post_language($postid,$parent,$lang){
		global $wpdb;
		if($row = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."multilingual_refs WHERE `unique` = $postid OR `unique` = $parent", ARRAY_A)){
			$unique = $row[0]['unique'];
		} else {
			$unique = $postid;
		}
		if($wpdb->get_results("SELECT * FROM ".$wpdb->prefix."multilingual_refs WHERE postid = $postid")){
			$wpdb->get_results("UPDATE `".$wpdb->prefix."multilingual_refs` SET `postid` = '$postid',
				`parent` = '$parent',
				`lang` = '$lang',
				`unique` = '$unique'
				 WHERE `".$wpdb->prefix."multilingual_refs`.`postid` =$postid LIMIT 1 ;");
		} else {
			$wpdb->get_results("INSERT INTO `".$wpdb->prefix."multilingual_refs` (
				`id` ,
				`postid` ,
				`parent` ,
				`lang`,
				`unique`
			) VALUES (
				NULL , '$postid', '$parent', '$lang', '$unique'
			);");
		}
	}
	function get_post_language($postid){
		global $wpdb;
		$lang = $wpdb->get_results("SELECT lang FROM ".$wpdb->prefix."multilingual_refs WHERE postid = $postid",ARRAY_A);
		return $lang[0]['lang'];
	}


?>
