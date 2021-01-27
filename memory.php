<?php
//print_r($_POST['arr1']);
session_start();
$_SESSION['arr1'] = $_POST['arr1'];	

$t = $_SESSION['arr1'];
error_reporting(4);
foreach($t as $v1){
	
	foreach ($v1 as $v2){
		
		if($v2 != ''){
			echo $v2.",";
			}
		
		}
	}
?>