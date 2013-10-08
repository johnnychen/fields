<?
	$i18ns = get_posts(array(
		'post_type' => 'i18n',
		'orderby' => 'name',
		'order' => 'ASC',
		'posts_per_page' => -1
	));
	$json = array('en-us'=>array(), 'zh-cn'=>array(), 'zh-tw'=>array());
	
	if($i18ns){
		foreach($i18ns as $i18n){
			$i18n_name = strike_to_camel($i18n->post_name);
			
			$i18n->en_us = types_render_field("en-us", array("output"=>"raw", 'post_id'=>$i18n->ID));
			$json['en-us'][$i18n_name] = $i18n->en_us;
			
			$i18n->zh_cn = types_render_field("zh-cn", array("output"=>"raw", 'post_id'=>$i18n->ID));
			$json['zh-cn'][$i18n_name] = $i18n->zh_cn;
			
			$i18n->zh_tw = types_render_field("zh-tw", array("output"=>"raw", 'post_id'=>$i18n->ID));
			$json['zh-tw'][$i18n_name] = $i18n->zh_tw;
		}
	}
	
	
?>


<pre id="pre"></pre>

<script type="text/javascript">
var  tmp =<?=json_encode($json);?>;

var str = JSON.stringify(tmp,'',4);
document.getElementById('pre').innerHTML = str;
</script>
