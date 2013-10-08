<?php get_header(); ?>
	  
<?php 
	$field = new SingleField(get_queried_object());
?>

<div class="container">
	<table id="fields-table" class="table table-bordered" style="width:65%">
		<tr>
			<th style="width:110px">字段</th>
			<td><?=$field->post_title?></td>
		</tr>
		<tr>
			<th>name</th>
			<td><?=$field->objectName; ?></td>
		</tr>
		<tr>
			<th>字段类型</th>
			<td><?=$field->type(); ?></td>
		</tr>
		<tr>
			<th>备注</th>
			<td><?=$field->post_content?></td>
		</tr>
		
	</table>

	<?php
		$rules = $field->getRules(true, true);
	?>
	
	<table class="table table-bordered">
		<tr>
			<td>校验规则</td>
			<td>i18n name</td>
			<td>英文</td>
			<td>简体中文</td>
			<td>繁体中文</td>
			<td>参数</td>
		</tr>
		<?php foreach($rules as $rule){ ?>
		<tr>
			<td><?=$rule->link();?></td>
			<td><?=$rule->i18n_name?></td>
			<td><?=$rule->en_us?></td>
			<td><?=$rule->zh_cn?></td>
			<td><?=$rule->zh_tw?></td>
			<td><?=$rule->params()?></td>
			
		</tr>
		<?php }	?>
	</table>

</div>

<?php get_footer(); ?>
