<?php
$filename="css_exceptions.xls";//先定义一个excel文件

header("Content-Type: application/vnd.ms-execl");
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

//在excel输出表头
echo iconv("utf-8", "gb2312", "标题")."\t";
echo iconv("utf-8", "gb2312", "内容")."\t";
echo iconv("utf-8", "gb2312", "类型 ")."\t";
echo iconv("utf-8", "gb2312", "时间")."\n";//注意这个要换行

//数据库为cssm 数据库用户名：root 密码为：j
//$conn = mysql_connect("localhost","root","j");
//mysql_select_db("cssm");
require '../include/conn.php';
$sql="select * from css_exceptions"; 
$result=mysql_query($sql);
while($row =mysql_fetch_array($result)){
	
			if ($row['code']==100){
				$code='警告';}
			else {
				$code='错误';
			}	
  echo iconv("utf-8", "gb2312", ($row['title']))."\t";
  echo iconv("utf-8", "gb2312", $row1['content'])."\t";
  echo iconv("utf-8", "gb2312", $code)."\t";
  echo iconv("utf-8", "gb2312", $row['created_at'])."\n";
}
?>