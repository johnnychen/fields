<?php
	$rules = get_posts( array(
		'post_type'=> 'rule',
		'posts_per_page' => -1,
		'orderby' => 'name',
		'order' => 'ASC',
		'rule_type' => $wp_query->query_vars['rule_type'],
	));

	foreach($rules as $rule){
		$ruleId = $rule->ID;
		$rule->ruleName = strike_to_camel($rule->post_name);
		$rule->rule_type = types_render_field("rule_type", array("output"=>"raw", 'post_id'=>$ruleId));
		$rule->priority = types_render_field("priority", array("output"=>"raw", 'post_id'=>$ruleId));
		
		$i18ns = get_posts(array(
		  'rule_name' => $rule->post_name,
		  'post_type' => 'i18n',
		  'posts_per_page' => -1,
		  'order' => 'ASC'
		));
		$i18n_str = '';
		if($i18ns){
			foreach($i18ns as $i18n){
				$i18n_str .= '<a href="'.get_permalink($i18n->ID).'" target="_blank">'.strike_to_camel($i18n->post_name).'</a> , ';
			}
		}
		$rule->i18n = $i18n_str;
	}
	

	usort($rules, 'rule_priority_cmp');
	?>
	<table class="table table-bordered">
		<tr>
			<th style="width:30px">序号</th>
			<th>规则</th>
			<th>name</th>
			<th>i18n(s)</th>			
			<th>priority</th>			
		</tr>
		<?$num=0; foreach($rules as $rule){ $num ++;?>
			<tr>
				<td><?=$num?></td>
				<td><a href="<?=get_permalink($rule->ID)?>"><?=$rule->post_title?></a></td>
				<td><?=$rule->ruleName?></td>
				<td><?=$rule->i18n;?></td>
				<td><?=$rule->priority;?></td>
			</tr>
		<?}?>
	</table>
