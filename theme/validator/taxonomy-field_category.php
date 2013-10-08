<?php get_header(); ?>

<div class="container">

<h4>分类: <?=$wp_query->query_vars['field_category']?> </h4>

<?php get_template_part('field', 'taxonomy');?>

<?php
get_template_part('field', 'list');
?>

</div>
<?php get_footer(); ?>