<?php
function i18n_get_keys($str){
	$str = str_replace('{{display}}','dispay', $str);
	$keys = array();
	while(preg_match("/{{(.*?)}}/", $str, $matches)){
		array_push($keys, $matches[1]);
		// echo '<br/>'.$str.'<br/>';
		$str = str_replace($matches[0], 'param', $str);
		// echo '<br/>'.$str.'<br/>';
		// print_r($matches);
	}
	// echo '<br/>'.$str.'<br/>';
	return $keys;
}

// print_r(i18n_get_keys('{{haha}}, fdsf,{{display}}必须是{{min}}到{{max}}的数字'));


function cq_search_posts($search, &$query){
	if($query->query_vars['rule_name'] && $query->query_vars['post_type'] == 'i18n'){
		$search = $search." AND ((wp_posts.post_name LIKE '".$query->query_vars['rule_name']."') OR (wp_posts.post_name LIKE '".$query->query_vars['rule_name']."\_%'))";
	}
	return $search;
}
add_filter('posts_search', cq_search_posts, 10 ,3);

function rule_priority_cmp($a, $b){
	$ap = intval($a->priority);
	$bp = intval($b->priority);
	if ($ap == $bp) {
		return 0;
	}
	return ($ap < $bp) ? -1 : 1;
}

class SingleRule{
	
	private $obj;
	private $paramArray;
	
	function __construct($rule){
		$rule->objectName = strike_to_camel($rule->post_name);
		$rule->priority = types_render_field("priority", array("output"=>"raw", 'post_id'=>$rule->ID));
		$this->obj = $rule;
	}
	
	function link(){
		$obj = $this->obj;
		echo '<a href="'.get_permalink($obj->ID).'">'.$obj->objectName.'</a>';
	}
	
	function getParamArray(){
		if(!$this->paramArray){
			$rule = $this->obj;
			
			$paramArray = array();
			$params = $this->params();
			// bug case 1:  $rule->params = 0
			if(ltrim($params)!=''){
				
				$values = explode(',', $params);

				$i18ns = get_posts(array(
				  'rule_name' => $rule->post_name,
				  'post_type' => 'i18n',
				  'posts_per_page' => -1,
				  'order' => 'ASC'
				));
				
				if($i18ns){
					$i18n = $i18ns[0];
					$i18n_en = types_render_field("en-us", array("output"=>"raw", 'post_id'=>$i18n->ID));

					$keys = i18n_get_keys($i18n_en);
					
					if(count($keys)<count($values)){
						$len = count($keys);
					}else{
						$len = count($values);
					}
					
					for($i=0; $i<$len; $i++){
						$key = $keys[$i];
						$value = $values[$i];
						
						array_push($paramArray, array($key , $value));
					}
					// print_r($paramArray);
				}
			}
			$this->paramArray = $paramArray;
		}
		return $this->paramArray;
	}
	
	function params(){
		return p2p_get_meta( $this->obj->p2p_id, 'params', true );
	}
	
	function getI18ns(){
		$list = new I18nList(array(
			'rule_name' => $this->obj->post_name
		));
		return $list->items();
	}
	
	function getFields(){
		$fields = get_posts(array(
			'post_type'=> 'field',
			'connected_type' => 'fields2rules',
			'connected_items' => $this->obj->ID,
			'nopaging' => true
		));
		
		$rtn = array();
		
		foreach($fields as $field){
			array_push($rtn, new SingleField($field));
		}
		return $rtn;
	}
	
	function __get($name){
		if($name == 'paramArray'){
			return $this->paramArray;
		}
		return $this->obj->$name;
	}
}
class RuleList{
	private $list;
	function __construct(){
		
	}
}
?>