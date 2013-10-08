<?php

function my_admin_bar(){

	global $wp_admin_bar, $post;
	
	if($post){
	
		$post_name = $post->post_name;
		$title = '';
		$url = '';
		if($post_name == 'field-list'){
			$title = 'Export Fields';
			$url = 'http://form.aliui.com/json-export-fields-to-rules/';
		}else if($post_name == 'i18n-list'){
			$title = 'Export I18Ns';
			$url = 'http://form.aliui.com/json-export-rules-to-i18ns/';
		}else if($post->post_type == 'form-page'){
			$title = 'Export Java Json';
			$url = 'http://form.aliui.com/json-export-java-form-page/?post_id='.$post->ID;
		}else{
			return;
		}
		
		$wp_admin_bar->add_menu(array(
			'title' => $title,
			'href' => $url,
			'parent' => false, // false for a root menu, pass the ID value for a submenu of that menu.
			'id' => false, // defaults to a sanitized title value.
			'meta' => false
		));
	}
	
}

if(is_user_logged_in()){
	add_action( 'admin_bar_menu', 'my_admin_bar' );
}

?>