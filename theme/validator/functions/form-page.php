<?php

class FormPageDataItem{

	private $raw;
	private $hasField;
	private $field;
	private $rules;
	private $joinedRules;
	
	function __construct($raw){
		$this->raw = $raw;
		$this->parse();
	}

	private function parse(){
		$fieldClass = $this->raw->abstract_class;
		$field_slug = camel_to_strike($fieldClass);
		
		if(!$fieldClass){
			$field = new SingleField();
			$this->field = $field;
			$this->hasField = false;
			return;
		}
		$this->hasField = true;
		
		$fields = get_posts(array(
		  'name' => $field_slug,
		  'post_type' => 'field',
		  'posts_per_page' => -1,
		  'order' => 'ASC'
		));
		
		if(count($fields)){
			$field = new SingleField($fields[0]);
			$this->field = $field;
		}
	}
	
	function getRules(){
		$field = $this->field;
		if(!$this->hasField){
			return array();
		}
		if($field){
			
			if(!$this->rules){
				$this->rules = $field->getRules($this->raw->required, true);	
			}
			
			return $this->rules;
		}
	}
	
	function getJoinedRules(){
		if(!$this->hasField){
			return '';
		}
		if(!$this->joinedRules){
		
			$rules = $this->getRules();
		
			$simpleRules = array();
			
			foreach($rules as $rule){
				$params = $rule->params();
				
				if(ltrim($params)!=''){
					array_push($simpleRules, $rule->objectName.'['.$params.']');
				}else{
					array_push($simpleRules, $rule->objectName);
				}
			}
			$this->joinedRules = join($simpleRules, ',');
		}
		return $this->joinedRules;
	}
	
	function __get($name){
		if($name == 'field'){
			return $this->field;
		}
		$value = $this->raw->$name;
		if(!$value){
			$value = $this->field->$name;
		}
		return $value;
	}
}

class FormPageData{
	private $post;
	private $grid;
	private $items;
	
	function __construct($post){
		$this->post = get_post($post);
	}
	
	private function getItems(){
		if(!$this->items){
		
			$csv = $this->post->post_excerpt;
			$grid = cq_getcsv($csv);
			$items = array();
			
			if(count($grid)){
				$keymap = $grid[0];

				for($i=1; $i<count($grid); $i++){
					
					$item = new stdClass();

					for($j=0; $j<count($grid[$i]);$j++){
						$key = $keymap[$j];
						$item->$key = $grid[$i][$j];
					}
					
					array_push($items, new FormPageDataItem($item));
				}
			}
			$this->grid = $grid;
			$this->items = $items;
		}
		return $this->items;
	}

	function __get($name){
		if($name == 'grid'){
			return $this->grid;
		}else if($name == 'items'){
			return $this->getItems();
		}else{
			return $this->post->$name;
		}
	}
}

?>