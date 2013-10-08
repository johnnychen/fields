<?php get_header(); ?>
	  
<?php 
	$page = new FormPageData(get_queried_object());
?>

<style type="text/css">
.color-gray{font-size:11px; color:#99;}
.toggle-all, .toggle{
	cursor: pointer;
}
</style>

<div class="container">

<div class="hero-unit">
	<h3><?=$page->post_title;?>页面</h3>
	<?=$page->post_content;?>
</div>

<table id="fields-table" class="table table-bordered table-condensed">
	<tr>
		<th width="160">字段名称</th>
		<th width="50">必填?</th>
		<th>校验规则</th>
		<th>校验类</th>
		<th width="30" class="toggle-all" data-hidden="true">
			<i class="icon-eye-open"></i>
		</th>
	</tr>
	<?
		$items = $page->items;
		// echo '<pre>';
		// print_r($items);
		// echo '</pre>';
		foreach($items as $item){
			?>
			<tr>
				<td><?=$item->description;?></td>
				<td><?if($item->required){?>
					<i class="icon-ok"></i>
					<?}?>
				</td>
				<td>
					<?=$item->field->link();?>
					<span class="color-gray"><?=$item->getJoinedRules();?></span>
				</td>
				<td>
					<?=$item->abstract_class?>
				</td>
				<td class="toggle">
					<i class="icon-eye-open"></i>
				</td>
	
			</tr>
			<tr style="display:none">
				<td colspan="5" style="background-color:#F7F7F7; padding:10px 5px; ">
					<table class="table table-bordered table-inner" style="margin:0;">
						<tr>
							<td>key</td>
							<th>英文</th>
							<th>简体中文</th>
							<th>繁体中文</th>
						</tr>
						<?
						$rules = $item->getRules();
						foreach ($rules as $rule){
						?>
							<tr>
								<th><?=$rule->objectName;?></th>
								<td><?=$rule->en_us?></td>
								<td><?=$rule->zh_cn?></td>
								<td><?=$rule->zh_tw?></td>
							</tr>
						<? 
						}
						?>
				
					</table>
				</td>
			</tr>
	<? } 
?>
</table>
<style type="text/css">
.table-inner td,
.table-inner th{
	background-color:#FAFAFA;
}
</style>
<?php
if(is_user_logged_in()){
?>
	<div id="dataTable">
		<p style="margin:15px 0 0px;"><button id="popup-confirm" class="btn btn-primary" type="button">保存表格</button></p>
	</div>

	<div id="" class="hide"></div>

	<div id="save-loading" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">提交变更</h3>
	  </div>
	  <div class="modal-body">
		<p>
			<textarea name="confirm_message" style="width:95%; height:120px;" placeholder="请输入本次变更的内容，不少于10个字符。"></textarea>
		</p>
		<p style="display:none">数据正在保存，请耐心等待。。。</p>
	  </div>
	  <div class="modal-footer">
		<button id="do-save" class="btn btn-primary">提交</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	  </div>
	</div>

	<script type="text/javascript">
	var csv_json = JSON.parse('<?=json_encode($page->grid)?>');
	$("#dataTable").handsontable({
		data: csv_json,
		colHeaders: true,
		rowHeaders: true,
		minSpareRows: 1
	}).find('table').addClass('table table-hover');
	
	$('#do-save').on('click', function(){
		var message = $.trim($('textarea[name="confirm_message"]').val());
		
		if(message.length <= 5){
			alert('备注信息必填，至少5个字符。');
			return;
		}
	
		var csv_array = $("#dataTable").handsontable('getData').slice();
		// 删除空尾行
		csv_array.length = csv_array.length - 1;
		var data = {
				action: 'save_form_page_csv',
				id: '<?=$page->ID?>',
				json: JSON.stringify(csv_array),
				message: message,
				thread_id: $('input[name="thread_id"]').val()
			};
		
		$.ajax({
			url: "/wp-admin/admin-ajax.php",
			type: 'post',
			data: data,
			success: function(response){
				// console.log(response);
				if('1' === response){
					location.reload();
				}
			}
		});
	});

	$('#popup-confirm').on('click', function(){
		$('#save-loading').modal('show');
	});

	</script>
<?php
} // End of is_logged_in
?>

<script type="text/javascript">
$(function(){
	var $table = $('#fields-table');
	$table.on('click', 'td.toggle', function(e){
		var $td = $(e.currentTarget);
		$td.parent().next().toggle();
	});
	$table.on('click', 'th.toggle-all', function(e){
		var $th = $(e.currentTarget);
		var isHidden = $th.attr('data-hidden');
		
		if(isHidden == 'true'){
			$table.find('td.toggle').parent().next().show();
			$th.attr('data-hidden', 'false')
		}else{
			$table.find('td.toggle').parent().next().hide();
			$th.attr('data-hidden', 'true')
		}
		
	});
});
</script>
</div>

<?php get_footer(); ?>
