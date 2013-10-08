<?php get_header(); ?>

<div class="container">

<h4>类型: 
<?
$slug = $wp_query->query_vars['field_type'];
$term = get_term_by('slug', $slug, 'field_type');
echo $term->name;
?> 
</h4>

<?php get_template_part('field', 'taxonomy');?>

<?php
get_template_part('field', 'list');
?>

</div>
<?php get_footer(); ?>