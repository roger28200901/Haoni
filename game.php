<?php
include('connect.php');

$nickname = $_POST['nickname'];
$_SESSION['nickname'] = $_POST['nickname'];
$_SESSION['difficulty'] = $_POST['difficulty'];

error_reporting("E_ALL &~ E_NOTICE");

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/widgets.css" rel="stylesheet" />
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/scripts.js"></script>
<script>
		//紀錄步數
		function st(ff,tt,data_i,bc)
		{
			if(bc != 'bc') //如果不是上一步的話
			run_hanoi(startTime,endTime,ff,tt,data_i);
			
			sessionStorage.setItem('mf',JSON.stringify(ff));
			sessionStorage.setItem('mt',JSON.stringify(tt));
			sessionStorage.setItem('mdata_i',JSON.stringify(data_i));
			var fromStackId = ff;
			var toStackId= tt;
			$.ajax({
			url : 'step.php?step='+step+'&fromStackId='+fromStackId+'&toStackId='+toStackId+'&brickId='+data_i,
			success: function(data){
					$('#num').text(data);
					if($('#num').text() >= '2'){
								$('#back').prop('hidden','');
							}
						}
			})
			//處理存入session陣列		
			saveToStorage('re',ff,tt,data_i);			
			
				
			//成功		
			success();
				
		}		
		function success(){
			if($('#col3').children().length == i){
			$('.success').removeAttr('hidden');			
				}	
			}
			
		//拿出session記憶陣列
		function loadToStorage(){
			var storedArray = JSON.parse(sessionStorage.getItem("items"));	
			for (j = 1; j < storedArray.length; j++) {
				var str = String(storedArray[j]);
				str = str.split(",");	
				for(var m = 1; m<= i ; m++){
					if(str[m] != '0'){
						$("#col"+j).append('<div class="brick b'+m+'" draggable="true" id="'+m+'" ondragstart="drag(event);" data-id="'+m+'"></div>');	
						}
					}			
				console.log(str);		
			}
		}
			
		//記憶陣列存到session				
		  function saveToStorage(re,ff,tt,data_i) {
 			if(re == 're'){ //如果移動的話 存到session 陣列
				var storedArray = JSON.parse(sessionStorage.getItem("items"));
				var temp = storedArray[ff][data_i];
				storedArray[ff][data_i] = '0';
				storedArray[tt][data_i] = temp;
				sessionStorage.setItem("items",JSON.stringify(storedArray));				
				}else{ 
				//如果初始的話 將初始陣列存到session 陣列
				sessionStorage.setItem("items", JSON.stringify(st_arr));
				var storedArray = JSON.parse(sessionStorage.getItem("items"));//no brackets
				var j;				
				for (j = 1; j < storedArray.length; j++) {
				var str = String(storedArray[j]);
				str = str.split(",");
				console.log(str);
								} 						
					}
			}			
			 
</script>
    <title>河內塔</title>
</head>
<body>
    <div hidden class="success">
        <div class="container">
            <div class="message">
                遊戲成功!
                <input type="button" value="重新開始" onClick="location.href='index.php'">
            </div>
        </div>
    </div>
    <div id="container-game" class="gameRunning">
        <div class="row">
            <div class="layout">
                <h2>河內塔</h2>

                <div class="game">
                    <div class="clear colNumber">
                        <div class="col3">
                            <span>3</span>
                        </div>
                        <div class="col3">
                            <span>2</span>
                        </div>
                        <div class="col3">
                            <span>1</span>
                        </div>
                    </div>
                    <div id="col3" class="col" data-id="3" ondragover="allowdrop(event);" ondrop="drop(event);">
                      
                    </div>
                    <div id="col2" class="col" data-id="2" ondragover="allowdrop(event);" ondrop="drop(event);">
                    
                    </div>
                    <div id="col1" class="col" data-id="1" ondragover="allowdrop(event);" ondrop="drop(event);">
                      
                    </div>

                    <div class="clear moveButton">
                        <div class="col3">
                            <button id="col3_2">2</button>
                            <button id="col3_1">1</button>
                        </div>
                        <div class="col3">
                            <button id="col2_3">3</button>
                            <button id="col2_1">1</button>
                        </div>
                        <div class="col3">
                            <button id="col1_3">3</button>
                            <button id="col1_2">2</button>
                        </div>
                    </div>

                </div>
                <div class="desc left">
                    <a href="index.php" class="btn btn-secondary">回到設定頁面</a>
                </div>
            </div>
            <div class="module">
                <div class="mod">
                    <h4>暱稱</h4>
                    <h2><?=$nickname?></h2>
                </div>
                <div class="mod" id="move">
                    <h4>移動次數</h4>
                    <h2 id="num"><?=$_SESSION['step']?></h2>
                </div>
				 <div class="mod"  id="asideFuncButtons">
					<button id="back" hidden>上一步</button>
					<button id="auto">自動解答</button>
					<button id="record">重播</button>
				 </div>
            </div>
        </div>
    </div>
    
	<script type="text/javascript" language="javascript">
	
	//function 河內塔 手動處理
	//需要紀錄 時間 走的位置
		var startTime = 0;	
		var endTime = 0;
		//時間差
		var Time = new Array();
		//重播的元素陣列
		var Record = new Array();
		
		var t; //控制暫停
		function timedCount()
		{			
			endTime+=1;				
			t=setTimeout("timedCount()",1000)
		}
		timedCount();
		 
		function run_hanoi(startTime,endTime,fromStackId,toStackId,brickId){
			endTime = endTime - startTime;
			startTime = endTime;
			
			 Time.push(endTime);
			 Record.push({fromStackId,toStackId,brickId});
			 sessionStorage.setItem('Record',JSON.stringify(Record));
			 sessionStorage.setItem('endTime',JSON.stringify(Time));
			
			 }
	
	var step = <?=$_SESSION['step']?>;
	//紀錄方塊在哪邊
	var st_arr = new Array();
	var i = <?=$_SESSION['difficulty']?>;
	
	$(document).ready(function(e) {		
		//初始生成
		
		if($('#num').text() >= '2'){
								$('#back').prop('hidden','');
							}
		<?php
		if($_SESSION['reset'] == true){
			?>
			for(var k = 1;k<=i;k++){
				$('#col1').append('<div class="brick b'+k+'" draggable="true" ondragstart="drag(event);" value="'+k+'" id="'+k+'" data-id="'+k+'"></div>')
				//產生 1-n個	
				}
			for(var z=3; z>= 1;z--)
				{
			st_arr[z] = new Array();
			//產生1-n個盤子
			for(var q=1;q<=i;q++){
				if(z == 1){			
					st_arr[z][q] = String(q); 				
					}else{
					st_arr[z][q] = '0';
			
						}	
				}	
			
			}
			saveToStorage();
			<?php
			$_SESSION['reset'] = false;
			}else{
			?>
			//如果沒有重製的話
			loadToStorage();
				
			for(var z=3; z>= 1;z--)
				{
			st_arr[z] = new Array();
			//產生1-n個盤子
			
			
			for(var q=1;q<=i;q++){		
					st_arr[z][q] = String();  //拿session的值				
				}	
					
				}
			
			<?php	
				}
			?>		
		//滑鼠點擊操作事件			
			//1->3
			$('#col1_3').on('click',function(){
					var temp = $('#col1').children()
					var temp_to = $('#col3').children();
					
					var data_i = $(temp[0]).data('id')
					var data_j = $(temp_to[0]).data('id')	
					if(data_j == null  && data_i != null){					
						$('#col3').append(temp[0]);	
						step++;
						st(1,3,data_i);
					}else if(data_i > data_j){					
						console.log('false')
					}else if(data_i < data_j){
						$('#col3').prepend(temp[0]);
						step++;
						st(1,3,data_i);
						}				
		})
      			//1->2
	  		 $('#col1_2').on('click',function(){
					var temp = $('#col1').children()
					var temp_to = $('#col2').children();
					
					var data_i = $(temp[0]).data('id')
					var data_j = $(temp_to[0]).data('id')	
					if(data_j == null  && data_i != null){					
						$('#col2').append(temp[0]);
						step++;
						st(1,2,data_i);
					}else if(data_i > data_j){					
						console.log('false')
					}else if(data_i < data_j){
						$('#col2').prepend(temp[0]);
						step++;
						st(1,2,data_i);	
						}					
		})
	    
		/*---------------------------------------------*/
			
				//2->3
			$('#col2_3').on('click',function(){
					var temp = $('#col2').children()
					var temp_to = $('#col3').children();
					
					var data_i = $(temp[0]).data('id')
					var data_j = $(temp_to[0]).data('id')	
					if(data_j == null  && data_i != null){					
						$('#col3').append(temp[0]);
						step++;
						st(2,3,data_i);	
					}else if(data_i > data_j){					
						console.log('false')
					}else if(data_i < data_j){
						$('#col3').prepend(temp[0]);
						step++;
						st(2,3,data_i);	
						}				
		})
      			//2->1
	  		 $('#col2_1').on('click',function(){
					var temp = $('#col2').children()
					var temp_to = $('#col1').children();
					
					var data_i = $(temp[0]).data('id')
					var data_j = $(temp_to[0]).data('id')	
					if(data_j == null  && data_i != null){					
						$('#col1').append(temp[0]);
						step++;
						st(2,1,data_i);
					}else if(data_i > data_j){					
						console.log('false')
					}else if(data_i < data_j){
						$('#col1').prepend(temp[0]);
						step++;
						st(2,1,data_i);	
						}						
		})
		
		/*---------------------------------------------*/
			
				//3->1
			$('#col3_1').on('click',function(){
					var temp = $('#col3').children()
					var temp_to = $('#col1').children();
					
					var data_i = $(temp[0]).data('id')
					var data_j = $(temp_to[0]).data('id')	
					if(data_j == null && data_i != null){					
						$('#col1').append(temp[0]);
						step++;
						st(3,1,data_i);	
					}else if(data_i > data_j){					
						console.log('false')
					}else if(data_i < data_j){
						$('#col1').prepend(temp[0]);
						step++;
						st(3,1,data_i);	
						}				
		})
      			//3->2
	  		 $('#col3_2').on('click',function(){
					var temp = $('#col3').children()
					var temp_to = $('#col2').children();
					
					var data_i = $(temp[0]).data('id')
					var data_j = $(temp_to[0]).data('id')	
					if(data_j == null && data_i != null){					
						$('#col2').append(temp[0]);
						step++;
						st(3,2,data_i);	
					}else if(data_i > data_j){					
						console.log('false')
					}else if(data_i < data_j){
						$('#col2').prepend(temp[0]);
						step++;
						
						st(3,2,data_i);	
						}						
		})
		
		//河內塔自動解答
		$('#auto').on('click',function(){
				$('#col1').children().remove();
				$('#col2').children().remove();
				$('#col3').children().remove();
				for(var k = 1;k<=i;k++){
			$('#col1').append('<div class="brick b'+k+'" data-id="'+k+'"></div>')
				}
		
				
				hanoi(i,'#col1','#col2','#col3').forEach(function loop(move) {
				//start ---- a by ---- b end ---- c 
					//console.log(move);  //move 已經被參照成一個物件了 object.屬性
				  console.log('盤從 ' + move.from + ' 移至 ' + move.to);												  
						animation_set(move.from,move.to);				 
				  });
				animation_move();
			})
			var fr = [];
			var t = [];
			function animation_set(from,to){									
					fr.push(from);
					t.push(to);
					
				}
			function animation_move(){
			var i = 0;
			var k = setInterval(function()
			{
				
			$(t[i]).prepend($(fr[i]).children()[0]);	
			
			i++;
			
			if(i > fr.length){
			
			clearInterval(k);
			location.reload();
				}
			}
			,500);
			
			}
		///河內塔上一步
				
		$('#back').on('click',function b(){
				var xxx = JSON.parse(sessionStorage.getItem("Record"));
				var xxxlen = xxx.length;
				var p = xxx.pop();
				var ttt = JSON.parse(sessionStorage.getItem("endTime"));
				ttt.pop();
				sessionStorage.setItem("endTime",JSON.stringify(ttt));
				sessionStorage.setItem("Record",JSON.stringify(xxx));
				
				var mt = p.toStackId;
				var mf = p.fromStackId;
				var mdata_i = p.brickId;
			
				//var mdata_i = JSON.parse(sessionStorage.getItem("mdata_i"));
				step--;
				
				st(mt,mf,mdata_i,'bc');				
				window.location.reload();
				
			})	
		//function河內塔 自動處理
		function hanoi(n,a,b,c){
				//a-b
				//a-c
				//b-c
				//$(c).append($(a).children()[0]);	
			
				if(n == 1){
										
					return [{	from : a, to : c }]; //參照類別概念了 from to 都為屬性  a . c 皆為數值														
				  }else{
					  return hanoi(n-1,a,c,b).concat( hanoi(1,a,b,c), hanoi(n - 1,b ,a , c));					  
					  }							
				console.log(move.from + 'ss' + move.to );
			
			}
			//重播事件
		 $('#record').on('click',function(){
			 clearTimeout(t)
			 
			animation_run();		 
			 })   
			 
			 
			 
			 
    });	
	//河內塔重播
	function animation_run(){
	
	var et = JSON.parse(sessionStorage.getItem("endTime"));
	var g = JSON.parse(sessionStorage.getItem("Record"));	
	var len = et.length;
	var n = 0;
	console.log(et);
	console.log(g);
			$('#col1').children().remove();
			$('#col2').children().remove();
			$('#col3').children().remove(); 	
			
			
			for(var k = 1;k<=i;k++){
				$('#col1').append('<div class="brick b'+k+'" draggable="true" ondragstart="drag(event);" value="'+k+'" id="'+k+'" data-id="'+k+'"></div>')
				//產生 1-n個	
				}
			for(var z=3; z>= 1;z--)
				{
			st_arr[z] = new Array();
			//產生1-n個盤子
			for(var q=1;q<=i;q++){
				if(z == 1){			
					st_arr[z][q] = String(q); 				
					}else{
					st_arr[z][q] = '0';
			
						}	
				}	
			
			}	   
	//0 2 5
	var lk = setInterval(function gg(){
			
		console.log(n + '' +len);
		//console.log($('.brick b'+g[n].brickId));
			
	  
	  
			
	  
	  
		  var obj = document.getElementsByClassName('brick b'+g[n].brickId);
		  
			$('#col'+g[n].toStackId).prepend(obj[0]);
		
		if(n >= len-1){
		clearInterval(lk);	
		window.location.reload();
		}
		n++;
		},et[n]*1000);
	
	
	}
	
	
	
	//滑鼠拖拉操作事件	
  	function drag(event){
		
		event.dataTransfer.setData("text",event.currentTarget.id);	
	
			}
				
	function allowdrop(event){
		event.preventDefault();
		}
		
	function drop(event){
		event.preventDefault();
		var data_id = event.dataTransfer.getData("text"); //取要傳的id 的text資料型態		
		var to_obj =  event.currentTarget; //我要過去的物件  位置 
		var len = to_obj.children.length; //我要過去的物件子節點長度有多少
		var ob_data_id = document.getElementById(data_id)
		
		var from_id = ob_data_id.parentElement.getAttribute('data-id');
		var to_id = to_obj.getAttribute('data-id');
		if(len == 0){			
		event.currentTarget.prepend(document.getElementById(data_id));	
					step++;
					st(from_id,to_id,data_id);
			 }else if(to_obj.children[0].id > data_id){ //判斷可否過去
					step++;
					st(from_id,to_id,data_id);
		event.currentTarget.prepend(document.getElementById(data_id));			
					}else{
				console.log('false')	
					}

					}
		
    
    </script>


</body>

</html>