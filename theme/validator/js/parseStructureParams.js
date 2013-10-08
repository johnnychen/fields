// 暂时保存在此，呵呵
(function(){
	var json = {},
		param = 'a[b][c][d]=1&a[b][d][]=1&b=2&c[][]=1';
		
		
	// param = decodeURIComponent($.param({
			// a:[1,2,{b:2},5],
			// b:{
				// c:1,
				// d:2,
				// e:[1,2]
			// }, 
			// products: [{a:1,b:2}, 4]
		// }));
	// param += "&products[0][v]=1&products[]=2&products[][productCNName]=1&products[][productENName]=2";
	// var pairs = param.split('&');
	// for(var i=0; i<pairs.length; i++){
		// var tmp = pairs[i].split('=');
		// parseItem(json, tmp[0], tmp[1]);
	// }
	// console.log(json);
	// document.getElementById('pre').innerHTML = param + '<br>' + JSON.stringify(json,'',4);
	// return;
	
	var  tmp = <?=json_encode($json);?>;

	$.each(tmp, function(key, value){
		parseItem(json, key, value);
	});
	
	console.log(json);
	document.getElementById('pre').innerHTML = JSON.stringify(json,'',4);
	
	function parseItem(json, name, value){
	// debugger;
		var	firstKey = '',
			path = [''];
		
		var pattern = /([^\[]*)/;
		var match = pattern.exec(name);
		path.push(match[1]);
		// console.log(match);
		
		var pattern = /\[([^\]]*)?\]/g;
		var match = pattern.exec(name);
		while(match){
			key = match[1];
			path.push(key);
			match = pattern.exec(name);
		}
		// console.log(path);
			
		var i, len = path.length;
		
		if(len>1){
			
			var a,b,c,current=json,next;

			for(var i=0; i<len-1; i++){
				
				a = path[i];
				b = path[i + 1];
				c = path[i + 2];
				
				if(i == len -2){
					if(current instanceof Array){
						// b为字母
						if(b && isNaN(b)){
							 if(current[0]){
								current[0][b] = value;
							 }else{
								var obj = {};
								obj[b] = value;
								current.push(obj);
							 }
						// b为数字或空
						}else{
							// b为数组下标的索引
							if(b){
								current[b] = value;
							// 按序存放
							}else{
								current.push(value);
							}
						}
					}else{
						current[b] = value;
					}
					
				}else{
					// current 为数组
					if(current instanceof Array){
						
						// b为字母
						if(b && isNaN(b)){
							var tmp = current[0];
							if(!tmp){
								tmp = {};
								current.push(tmp);
							}
							current = tmp;
							next = current[b];
							// c为字母，即next为对象
							if(c && isNaN(c)){
								if(!next){
									next = current[b] = {};
								};
							// c为数字或空，即next为数组
							}else{
								if(!next){
									next = current[b] = [];
								}
							}
						// b为数字或空
						}else{
						
							if(b){
								next = current[b];
							}else{
								next = current[0];
							}
							
							// c为字母，即next为对象
							if(c && isNaN(c)){
								
								if(!next){
									if(b){
										next = current[b] = {};
									}else{
										var obj = {};
										current.push(obj);
										next = obj;
									}
								};
							// c为数字或空，即next为数组
							}else{

								if(!next){
									if(b){
										next = current[b] = [];
									}else{
										var obj = [];
										current.push(obj);
										next = obj;
									}
								}
							}
						}
					// current 为对象
					}else{
						// current[b] = value;
						next = current[b];
						// c为字母，即next为对象
						if(c && isNaN(c)){
							if(!next){
								next = current[b] = {};
							};
						// c为数字或空，即next为数组
						}else{
							if(!next){
								next = current[b] = [];
							}
						}
					}
					
					current = next;
				
				}
			}
		}
	}
})();
	