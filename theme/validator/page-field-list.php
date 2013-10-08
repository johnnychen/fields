<?php get_header(); ?>

<div class="container">

<h4>所有字段</h4>

<?php 
get_template_part('field', 'taxonomy');
?>

<?php
get_template_part('field', 'list');
?>

</div>
<?php get_footer(); ?>