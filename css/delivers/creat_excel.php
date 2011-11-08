<?php
$filename="delivers.xls";//先定义一个excel文件

header("Content-Type: application/vnd.ms-execl");
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

//在excel输出表头
echo iconv("utf-8", "gb2312", "IP地址")."\t";
echo iconv("utf-8", "gb2312", "最后心跳时间址")."\n";//注意这个要换行

//数据库为cssm 数据库用户名：root 密码为：j
//$conn = mysql_connect("localhost","root","j");
//mysql_select_db("cssm");
require '../include/conn.php';
$sql="select * from delivers"; 
$result=mysql_query($sql);
while($row =mysql_fetch_array($result)){
  echo iconv("utf-8", "gb2312", ($row['ip']))."\t";
  echo iconv("utf-8", "gb2312", $row['heartbeat_at'])."\n";
}
?>