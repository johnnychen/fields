<?php
add_action('wp_ajax_save_form_page_csv', 'save_form_page_csv_callback');
function save_form_page_csv_callback() {
	global $wpdb, $current_user; // this is how you get access to the database
	
	$json = $_POST['json'];
	$json = str_replace('\\', '', $json);
	// echo $json;
	// $array = json_decode('["字段","是否必填","映射抽象","label(简体)","label(繁体)","label(英文)","备注"]');
	$array = json_decode($json);
	
	$csv = array();
	foreach($array as $item){
		array_push($csv, cq_putcsv($item));
	}
	$csv = join($csv,"\n");
	
	// Update post 37
	$my_post = array();
	$my_post['ID'] = $_POST['id'];
	$my_post['post_excerpt'] = $csv;
	
	$ch = curl_init();  
	$data = array(
		'short_name' => 'alibaba-form',
		'secret'=>'0d5e1f05311be8127b061189de2aa8c5',
		'message'=>$_POST['message'],
		'thread_id'=> $_POST['thread_id'],
		'author_email' => $current_user->user_email,
		'author_name' => 'SYSTEM LOGINFO: by '.$current_user->display_name
	);
		
	curl_setopt($ch, CURLOPT_URL, 'http://api.duoshuo.com/posts/create.json');  
	curl_setopt($ch, CURLOPT_POST, 1);  
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  

	$output = curl_exec($ch);  

	curl_close($ch);

	// Update the post into the database
	
	if(wp_update_post( $my_post )){
		echo 1;
	}else{
		echo 0;
	}
	
	die(); // this is required to return a proper result
}

?>