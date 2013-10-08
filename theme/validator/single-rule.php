<?php get_header(); ?>
	  
<?php 
	$rule = new SingleRule(get_queried_object());
?>

<div class="container">
	<table class="table table-bordered">
		<tr>
			<th>规则</th>
			<td><?=$rule->post_title?></td>
		</tr>
		<tr>
			<th>name</th>
			<td><?=$rule->objectName?></td>
		</tr>
		<tr>
			<th>校验规则</th>
			<td><pre><?=$rule->post_excerpt?></pre></td>
		</tr>
		<tr>
			<th>描述</th>
			<td><?=$rule->post_content?></td>
		</tr>
	</table>
	
	<?
	$i18ns = $rule->getI18ns();

	if(count($i18ns)){
?>
	<table class="table table-bordered">
		<tr>
			<th>key</th>
			<th>us-en</th>
			<th>zh-cn</th>
			<th>us-tw</th>
		</tr>
		<?
		foreach($i18ns as $i18n){
		?>
			<tr>
				<td><?=strike_to_camel($i18n->post_name)?></td>
				<td><?=$i18n->en_us;?></td>
				<td><?=$i18n->zh_cn;?></td>
				<td><?=$i18n->zh_tw;?></td>
			</tr>
		<? 
		}
		?>
	</table>

	<?php
	}
		$fields = $rule->getFields();
		if(count($fields)){
	?>
		<table class="table table-bordered">
			<tr>
				<th style="width:30px;">序号</th>
				<th>关联字段</th>
				<th>参数</th>
			</tr>
		<?php
			$num = 0; 
			foreach($fields as $field){
				$num ++;
		?>
				<tr>
					<td>
						<?=$num?>
					</td>
					<td>
						<?=$field->link();?>
					</td>
					<td>
						<?=$field->params()?>
					</td>
				</tr>
			<? } ?>
		</table>
	<? }?>
	
</div>

<?php get_footer(); ?>
