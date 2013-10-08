<?php

class SingleI18n{
	private $obj;

	function __construct($i18n){
		$i18n->en_us = types_render_field("en-us", array("output"=>"raw", 'post_id'=>$i18n->ID));
		$i18n->zh_cn = types_render_field("zh-cn", array("output"=>"raw", 'post_id'=>$i18n->ID));
		$i18n->zh_tw = types_render_field("zh-tw", array("output"=>"raw", 'post_id'=>$i18n->ID));
		$i18n->objectName = strike_to_camel($i18n->post_name);
		$this->obj = $i18n;
	}
	function link(){
		$obj = $this->obj;
		echo '<a href="'.get_permalink($obj->ID).'" target="_blank">'.$obj->objectName.'</a>';
	}
	function getBindRule(){
		$matches = explode('_', $this->post_name);
		$rules = get_posts(array(
		  'name' => $matches[0],
		  'post_type' => 'rule',
		  'posts_per_page' => -1,
		  'order' => 'ASC'
		));
		
		$rule = new SingleRule($rules[0]);

		return $rule;
	}
	
	function __get($name){
		return $this->obj->$name;
	}
}


class I18nList{
	private $items;
	function __construct($config = array()){
		$args = array(
			'post_type' => 'i18n',
			'orderby' => 'name',
			'order' => 'ASC',
			'posts_per_page' => -1
		);
		
		$rtn = array();
		
		if($config['rule_name']){
			$args['rule_name'] = $config['rule_name'];
		}

		$i18ns = get_posts($args);
		
		if($i18ns){
			foreach($i18ns as $i18n){
				array_push($rtn, new SingleI18n($i18n));
			}
		}
		$this->items = $rtn;
	}
	function items(){
		return $this->items;
	}
}
?>