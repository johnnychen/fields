<?
	$vars = $wp_query->query_vars;
	$args = array(
			'post_type'=> 'field',
			'posts_per_page' => -1,
			'field_category' => $vars['field_category'],
			'field_type' => $vars['field_type'],
			'field_tag' => $vars['field_tag'],
		);
		
	$fields = get_posts($args);
	$json = new stdClass();
	
	foreach($fields as $raw_field){
	
		$field = new SingleField($raw_field);
		
		$rules = $field->getRules();
				
		$all_rules = array();
		
		foreach($rules as $rule){

			$the_rule = $rule->objectName;

			$paramArray = $rule->getParamArray();
		
			if(count($paramArray)){
				$tmpArray = array();
				foreach($paramArray as $param){
					array_push($tmpArray, $param[0].':'.$param[1]);
				}
			
				$the_rule .= '{';
				$the_rule .= join(' ', $tmpArray);
				$the_rule .= '}';
			}
			
			array_push($all_rules, $the_rule);
		}
		
		$json_field = array();
		
		$field_class_name = ucfirst($field->objectName);
		$json_field['type'] = $field->type();
		$json_field['rule'] = join(" ",$all_rules);
		
		$json->$field_class_name = $json_field;
	}
	
	
?>


<pre id="pre"></pre>

<script type="text/javascript">
var  tmp =<?=json_encode($json);?>;

var str = JSON.stringify(tmp,'',4);
document.getElementById('pre').innerHTML = str;
</script>
