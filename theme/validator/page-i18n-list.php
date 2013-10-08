<?php get_header(); ?>

<div class="container">

	<?
	$list = new I18nList();
	$i18ns = $list->items();
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
				<td><?=$i18n->link();?></td>
				<td><?=$i18n->en_us;?></td>
				<td><?=$i18n->zh_cn;?></td>
				<td><?=$i18n->zh_tw;?></td>
			</tr>
		<? 
		}
		?>
	</table>
</div>

<?php get_footer(); ?>