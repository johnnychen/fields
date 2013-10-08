<?php get_header(); ?>

<div class="container">

	<h4>所有规则</h4>
	
	<?php get_template_part('rule', 'taxonomy');?>
	

	<?php get_template_part('rule', 'list');?>

</div>

<?php get_footer(); ?>