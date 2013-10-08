<?php get_header(); ?>
	  
<?
	$i18n = new SingleI18n(get_queried_object());
	$rule = $i18n->getBindRule();

	// echo '<pre>';
	// print_r($rule);
	// echo '</pre>';
?>
<div class="container">
	<table class="table table-bordered">
		<tr>
			<th>name</th>
			<td><?=$i18n->objectName?></td>
		</tr>
		<tr>
			<th>描述</th>
			<td><?=$rule->post_content;?></td>
		</tr>
		<tr>
			<th>en-us</th>
			<td><?=$i18n->en_us;?></td>
		</tr>
		<tr>
			<th>zh-cn</th>
			<td><?=$i18n->zh_cn;?></td>
		</tr>
		<tr>
			<th>zh-tw</th>
			<td><?=$i18n->zh_tw;?></td>
		</tr>
		<tr>
			<th>校验规则</th>
			<td><?=$rule->link();?></td>
		</tr>
	</table>
	

</div>
<?php get_footer(); ?>
