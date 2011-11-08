<?php
$filename="Macs.xls";//先定义一个excel文件

header("Content-Type: application/vnd.ms-execl");
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

//在excel输出表头
echo iconv("utf-8", "gb2312", "Mac地址")."\t";
echo iconv("utf-8", "gb2312", "对应VIP")."\t";
echo iconv("utf-8", "gb2312", "对应频点 ")."\t";
echo iconv("utf-8", "gb2312", "创建时间")."\n";//注意这个要换行

//数据库为cssm 数据库用户名：root 密码为：j
//$conn = mysql_connect("localhost","root","j");
//mysql_select_db("cssm");
require '../include/conn.php';
$sql="select 
			 access_points.mac,
			 channels.frequence,
			 access_points.created_at,
			 access_points.id
	  from 
	  		access_points,channels
	  where 
	  		access_points.channel_id=channels.id"; 
$result=mysql_query($sql);
while($row =mysql_fetch_array($result)){
	$sql_vip="select vip from current_clients where access_point_id ='$row[id]'";	
	$info=mysql_query($sql_vip);
  echo iconv("utf-8", "gb2312", dechex($row['mac']))."\t";
     while($row1 = mysql_fetch_array($info)){
  echo iconv("utf-8", "gb2312", $row1['vip']);}
  echo "\t";
  echo iconv("utf-8", "gb2312", $row['frequence'])."\t";
  echo iconv("utf-8", "gb2312", $row['created_at'])."\n";
}
?>