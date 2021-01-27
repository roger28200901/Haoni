<?php
include('connect.php');
 
$t = $_GET['step']++;
$_SESSION['step'] = $t;
echo $_SESSION['step'];
?>