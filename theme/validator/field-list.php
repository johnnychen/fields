<?
// echo '<pre>';
// print_r($wp_query->query_vars);

$vars = $wp_query->query_vars;
$args = array(
		'post_type'=> 'field',
		'posts_per_page' => -1,
		'field_category' => $vars['field_category'],
		'field_type' => $vars['field_type'],
		'field_tag' => $vars['field_tag'],
	);
	
// print_r($args);
// echo '</pre>';

?>
<table class="table table-bordered">
	<tr>
		<th style="width:30px">序号</th>
		<th>字段名称</th>
		<th>name</th>
		<th>rules</th>
		<th>Tags</th>
	</tr>
	<?php
	$fields = get_posts($args);
	$num = 0;
	foreach($fields as $field){
		$num ++;
		
		$rules = get_posts( array(
					'post_type'=> 'rule',
					'connected_type' => 'fields2rules',
					'connected_items' => $field->ID,
					'nopaging' => true,
				));
				
		foreach($rules as $rule){
			$rule->priority = types_render_field("priority", array("output"=>"raw", 'post_id'=>$rule->ID));
		}
		usort($rules, 'rule_priority_cmp');
		
		$simpleRules = array();
		foreach($rules as $rule){
			$ruleId = $rule->ID;
			
			$rule->ruleName = strike_to_camel($rule->post_name);
			
			$rule->params = p2p_get_meta( $rule->p2p_id, 'params', true );

			if(ltrim($rule->params)!=''){
				array_push($simpleRules, $rule->ruleName.'['.$rule->params.']');
			}else{
				array_push($simpleRules, $rule->ruleName);
			}
		}
		
		
	?>
	<tr>
		<td>
			<?=$num?>
		</td>
		<td>
			<a href="<?php echo get_permalink($field->ID); ?>"><?=$field->post_title;?></a>
		</td>
		<td>
			<?=ucfirst(strike_to_camel($field->post_name))?>
		</td>
		<td>
			<? echo join(", ",$simpleRules); ?>
		</td>
		<td>
			<?
			$terms = get_the_terms($field->ID, 'field_tag' );
			
			if(is_array($terms)){
				foreach ( $terms as $term ) {
					echo '<a href="' . get_term_link( $term->slug, 'field_tag') . '">' . $term->name . '</a> , ';
				}
			}
			?>
		</td>
	</tr>
	<? }?>
</table>
