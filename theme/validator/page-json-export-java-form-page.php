<?

	$data = new FormPageData($_GET['post_id']);

	$json = new stdClass();
	
	$items = $data->items;
	
	foreach($items as $item){
		$name = $item->path_name;
		
		if(!$name) continue;
		
		$myitem = new stdClass();
		$myitem->path = $name;

		// $myitem->fieldClass = $item->abstract_class;
		
		
		$myitem->rules = array();
		$rules = $item->getRules($myitem->required, true);
		
		foreach($rules as $rule){
	
			$myrule = new stdClass();
			$myrule->rulename = $rule->objectName;
			
			$myrule->params = new stdClass();
			$params = $rule->getParamArray();
			foreach($params as $param){
				$key = $param[0];
				$value = $param[1];
				$myrule->params->$key = $value;
			}
			
			array_push($myitem->rules, $myrule);
		}
		
		
		
		$json->$name = $myitem;
	}

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<title></title>
</head>
<body>

<pre id="pre"></pre>

<script type="text/javascript">
var  tmp =<?=json_encode($json);?>;

var str = JSON.stringify(tmp,'',4);
document.getElementById('pre').innerHTML = str;
</script>

</body>
</html>