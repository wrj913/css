<?php
	header('Content-Type: text/html; charset=utf-8');
	require '../include/conn.php';
	$ip=$_GET['ip'];
	//echo $ip;
	$sql="select * from delivers where ip='$ip'";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	$available=$row['available'];
	if($available==1){
		$query="update delivers set available='0' where ip='$ip'";	
		mysql_query($query) or die('添加数据出错：'.mysql_error());
		echo "<script language='javascript'>window.location.href='../../delivers.php';</script>";	
	}elseif($available==0){
		$query="update delivers set available='1' where ip='$ip'";	
		mysql_query($query) or die('添加数据出错：'.mysql_error());
		echo "<script language='javascript'>window.location.href='../../delivers.php';</script>";	
	}
?>