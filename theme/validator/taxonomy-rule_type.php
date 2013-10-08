<?php get_header(); ?>


<div class="container">
	
	<h4>类型: 
	<?
	$slug = $wp_query->query_vars['rule_type'];
	$term = get_term_by('slug', $slug, 'rule_type');
	echo $term->name;
	?> 
	</h4>
	
	<?php get_template_part('rule', 'taxonomy');?>
	
	<?php get_template_part('rule', 'list');?>

</div>

<?php get_footer(); ?>