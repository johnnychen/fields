<?php

// add_action( 'init', 'cq_default_taxonomy', 100, 2 );

function cq_default_taxonomy(){
	$items = get_posts('post_type=field&posts_per_page=-1');
	// echo '<pre>';
	// print_r($items[0]);
	// echo '</pre>';
	foreach($items as $item){
		// mfields_set_default_object_terms($item->ID, $item);
	}
}

class SingleField{
	
	private $obj;
	private $rules;
	
	function __construct($field, $config = array()){
		if(!field){
			return;
		}
		$field->objectName = strike_to_camel($field->post_name);
		$this->obj = $field;
	}
	
	function getRules($required = false, $i18n = false){
		if(!$this->rules){
		
			$rules = get_posts( array(
				'post_type'=> 'rule',
				'connected_type' => 'fields2rules',
				'connected_items' => $this->ID,
				'nopaging' => true,
			));
			$rtn = array();
			foreach($rules as $rule){
				array_push($rtn, new SingleRule($rule));
			}
			if($required){
				array_unshift($rtn, new SingleRule(get_post(8)));	// ÌîÐ£Ñé id=8
			}
			
			if($i18n){
				$this->addI18n($rtn);
			}
			
			usort($rtn, 'rule_priority_cmp');
			
			$this->rules = $rtn;
		}
		return $this->rules;
		
	}
	
	private function addI18n($rules){

		$field_post_name = $this->obj->post_name;
		$field_type = $this->type();
		
		foreach($rules as $rule){
			$ruleId = $rule->ID;
			
			$list = new I18nList(array(
				'rule_name' => $rule->post_name
			));
			$i18ns = $list->items();

			$theI18n = new stdClass();
			if(count($i18ns)){
				$mapper = new stdClass();
				foreach($i18ns as $i18n){
					$i18n_name = split('_', $i18n->post_name);
					$len = count($i18n_name);
					if($len == 1){
						$mapper->defaults = $i18n;
					}elseif ($len == 2){
						$mapper->$i18n_name[1] = $i18n;
					}
				}

				if($mapper->$field_post_name){
					$theI18n = $mapper->$field_post_name;
				}else if($field_type && $mapper->$field_type){
					$theI18n = $mapper->$field_type;
				}else{
					$theI18n = $mapper->defaults;
				}
				
				$rule->i18n_name = $theI18n->objectName;;
				$rule->en_us = $theI18n->en_us;
				$rule->zh_cn = $theI18n->zh_cn;
				$rule->zh_tw = $theI18n->zh_tw;
		
			}
		}
	}
	function link(){
		$obj = $this->obj;
		if(!obj){
			return '';
		}
		return '<a href="'.get_permalink($obj->ID).'" target="_blank">'.$obj->post_title.'</a>';
	}
	function params(){
		return p2p_get_meta( $this->obj->p2p_id, 'params', true );
	}
	function type(){
		$type = $this->_type;
		if($type){
			return $type;
		}
		$type = 'untyped';
		
		$terms = get_the_terms($this->ID, 'field_type' );
		if(is_array($terms)){
			foreach($terms as $term){
				$type = $term->name;
				break;
			}
		}
		$this->_type = $type;
		return $type;
	}

	function __get($name){
		if($name == 'rules'){
			return $this->rules;
		}
		return $this->obj->$name;
	}

}
?>