<!DOCTYPE html>
<html>
<head>
	<title>字段管理系统</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	
	
	<link href="/wp-content/themes/validator/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="/wp-content/themes/validator/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
	<link href="/wp-content/themes/validator/css/handsontable.css" rel="stylesheet" media="screen">
	<link href="/wp-content/themes/validator/css/handsontable.bootstrap.css" rel="stylesheet" media="screen">


	<script type="text/javascript" src="/wp-content/themes/validator/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="/wp-content/themes/validator/js/handsontable.js"></script>
	
	<!--
	<script type="text/javascript" src="http://test.pupure.com/project/json2.js"></script>
	-->
</head>
<body style="padding-top:21px;">


	<?php
	// echo '<pre>';
	$URI = $_SERVER['REQUEST_URI'];
	
	$formPageCalss = 'dropdown';

	if(strpos($URI, 'i18n')>0){
		$i18nClass = 'active';
	}else if(strpos($URI, 'rule')>0){
		$ruleClass = 'active';
	}else if(strpos($URI, 'form-page')>0){
		$formPageCalss.= ' active';
	}else{
		$fieldClass = 'active';
	}
	// echo '</pre>';

	// echo strpos($URI, 'win8');
	?>

 <div class="container">
	<div class="masthead">
        <h3 class="muted">
			<a href="/" style="text-decoration:none; color:#000;">字段管理系统</a>
			<?php if(!is_user_logged_in()){	?>
				<a style="float:right" class="btn" href="<?php echo wp_login_url();?>">Log in</a>    
			<?php }	?>
		</h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav" role="navigation">
              <!--  <li class="active1"><a href="/">Home</a></li> -->
                <li class="<?=$formPageCalss?>">
					<a href="javascript:void(0);" role="button" class="dropdown-toggle" data-toggle="dropdown">
					表单页面 <b class="caret"></b>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="/form-page/solution-selector/">物流方案器</a></li>
						<li><a href="/form-page/russia/">俄罗斯专线</a></li>
						<li><a href="/form-page/port-to-port/">港到港-拼箱下单</a></li>
						<li><a href="/form-page/zhenggui/">港到港-整柜下单</a></li>
						<li><a href="/form-page/wtd-express/">仓到门-快递下单</a></li>
						<li><a href="/form-page/wtd-shipping/">仓到门-海运下单</a></li>
						
					</ul>
				</li>
                <li class="<?=$fieldClass?>"><a href="/field-list">字段</a></li>
				<li class="<?=$ruleClass?>"><a href="/rule-list/">规则</a></li>
				<li class="<?=$i18nClass?>"><a href="/i18n-list/">文案</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>
</div>

<style type="text/css">
.wp-body{min-height:600px;}
</style>

<div class="wp-body">

