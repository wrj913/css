<?php
$filename="current_clients.xls";//先定义一个excel文件

header("Content-Type: application/vnd.ms-execl");
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

//在excel输出表头
echo iconv("utf-8", "gb2312", "虚拟IP")."\t";
echo iconv("utf-8", "gb2312", "使用频率")."\t";
echo iconv("utf-8", "gb2312", "类型 ")."\t";
echo iconv("utf-8", "gb2312", "CSSD")."\t";//注意这个要换行
echo iconv("utf-8", "gb2312", "ipqam")."\t";
echo iconv("utf-8", "gb2312", "状态 ")."\t";
echo iconv("utf-8", "gb2312", "created_at")."\t";
echo iconv("utf-8", "gb2312", "MAC地址")."\t";
echo iconv("utf-8", "gb2312", "来源IP")."\t";
echo iconv("utf-8", "gb2312", "最后接入时间")."\n";

//数据库为cssm 数据库用户名：root 密码为：j
//$conn = mysql_connect("localhost","root","j");
//mysql_select_db("cssm");
include '../include/conn.php';
//在这里我们定义一个名叫studen的表，她有id，name，age，sex四个字段
$sql="select 
			 current_clients.vip,
			 access_points.mac,
			 channels.frequence,
			 current_clients.state,
			 current_clients.client_type,
			 access_points.deliver_ip,
			 access_points.ipqam_ip,
			 current_clients.created_at,
			 current_clients.ip,
			 current_clients.updated_at
	  from 
	  		access_points,channels,current_clients
	  where 
	  		access_points.channel_id=channels.id and current_clients.access_point_id=access_points.id"; 
$result=mysql_query($sql);
while($row =mysql_fetch_array($result)){
	if ($row['client_type']==0){
				$client_type='CSST';}
			else {
				$client_type='CSSA';
			}
			if ($row['state']==0)
				$state='登录中';
			elseif ($row['state']==1) 
				$state='加速中';
			elseif ($row['state']==2) 
				$state='已注销';	
  echo iconv("utf-8", "gb2312", $row['vip'])."\t";
  echo iconv("utf-8", "gb2312", $row['frequence'])."\t";
  echo iconv("utf-8", "gb2312", $client_type)."\t";
  echo iconv("utf-8", "gb2312", $row['deliver_ip'])."\t";
  echo iconv("utf-8", "gb2312", $row['ipqam_ip'])."\t";
  echo iconv("utf-8", "gb2312", $state)."\t";
  echo iconv("utf-8", "gb2312", $row['created_at'])."\t";
  echo iconv("utf-8", "gb2312", dechex($row['mac']))."\t";
  echo iconv("utf-8", "gb2312", $row['ip'])."\t";
  echo iconv("utf-8", "gb2312", $row['updated_at'])."\n";
}
?>