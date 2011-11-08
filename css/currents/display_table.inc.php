<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php
  include 'css/include/conn.php';
	$pagenum=40;//定义每页显示3条记录
	$page=@$_GET['page'];//分页所传的参数page
	$query=mysql_query("select * from clients");
	$totalnum=mysql_num_rows($query);//统计表的总记录数量
	$totalpage=ceil($totalnum/$pagenum);//总分页数
	if(!isset($page))
	{
	   $page=1;//如果分页的参数不存在，则当前默认是第一页
	}
	$startcount=($page -1)*$pagenum;//分页的开始索引值
	$sql="select * from clients order by created_at desc limit $startcount,$pagenum";
	$result=mysql_query($sql);
	?>
	
<?php
		
		echo "<table class='css_table_tr' style='width: 996px;'>
		<tr><td></td><td colspan='9'  style='font-size: 12px; text-align: right;'><a href='./css/currents/creat_excel.php'>导出</a></td></tr>
		<tr bgcolor='#00438C'><td colspan='10' class='textHeaderDark'  style='font-size: 12px; font-weight: bold;'>所有终端</td></tr>
		<tr bgcolor='#6d88ad' class='textSubHeaderDark' style='font-size: 12px;'>
		<th >类型</th>
		<th >虚拟IP</th>
		<th >MAC地址</th>
		<th >ipqam</th>
		<th >使用频率</th>		
		<th >CSSD</th>
		<th >来源IP</th>
		<th >状态</th>
	  <th >登入时间</th>
		<th >登出时间</th>
		</tr>";
//		虚拟IP 	MAC地址 	类型 	使用频率 	CSSD 	IPQAM 	来源IP 	状态 	最后接入时间
		$mantissa=0;
		while($row = mysql_fetch_array($result))
		{
			if ($row['client_type']==0){
				$client_type='CSST';}
			elseif ($row['client_type']==1){
				$client_type='CSSA';
			}else{
        	$client_type='CSSG';
     }
			if ($row['state']==0)
				$state='登录中';
			elseif ($row['state']==1) 
				$state='已加速';
			elseif ($row['state']==2) 
				$state='已加速';	
		 $dec_mac=e ( $row ['mac'],16 );  
     for($j = 2; $j < 11; $j=$j+3){
        $dec_mac=str_insert($dec_mac,$j,'-');
      }
     $mantissa=$mantissa%2;			
		  echo "<tr>";
 		 echo  "<td class="."css_table"."$mantissa>" . $client_type. "</td>";  
		  echo "<td class="."css_table"."$mantissa".">" . $row['vip'] . "</td>";
		  echo  "<td class="."css_table"."$mantissa>" .$dec_mac . "</td>";
		  echo  "<td class="."css_table"."$mantissa>" . $row['ipqam_ip'] . "</td>";
		  echo  "<td class="."css_table"."$mantissa>" . $row['frequence'] . "</td>";		  
		  echo  "<td class="."css_table"."$mantissa>" . $row['deliver_ip'] . "</td>"; 		  
		  echo  "<td class="."css_table"."$mantissa>" . $row['ip'] . "</td>";
		  echo  "<td class="."css_table"."$mantissa>" . $state . "</td>";
      echo  "<td class="."css_table"."$mantissa>" . $row['login_at'] . "</td>";
		  echo  "<td class="."css_table"."$mantissa>" . $row['logout_at'] . "</td>";
		  echo "</tr>";
		  $mantissa=$mantissa+1;
  		}
		echo "</table>";
?>

	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
	    <td class='css_table0'>
		<? if($page==1)
		{?>
		首页 上页
		<? }else{
		$prev=$page -1;
		?>
		<a href="?page=1">首页</a>
		<a href="?page=<? echo $prev;?>">上页</a>
		<? }?>
				<?
		if($page<6)
		{
			for($i=1;$i<=10 && $i<=$totalpage;$i++)
			{
				if ($page==$i)
				{echo $i;}
				else {
				?>
				<a href="?page=<? echo $i;?>"><? echo $i;?></a>
			<? }}}
		 else{
			for($i=($page-5);$i<=($page+5)&& $i<=$totalpage;$i++)
			{
				if ($page==$i)
				{echo $i;}
				else {
			?>
			<a href="?page=<? echo $i;?>"><? echo $i;?></a>
			<? }}	
		}
		?>
		 <? if($page<$totalpage){
		 $next=$page+1;?>
		 <a href="?page=<? echo $next;?>">下页</a>
		 <a href="?page=<? echo $totalpage;?>"> 末页</a>
		 <? }else{?>
		 下页 末页
		 <? }?>
		  总共<? echo $totalpage;?>页 当前为第<font color="red"><? echo $page;?></font>页 共<? echo $totalnum;?>条记录 </td>
	  </tr>
	</table>
	<?php mysql_close();?>
</body>
</html>
<?php
function str_insert($str, $i, $substr) {
  for($j = 0; $j < $i; $j ++) {
      @$startstr .= $str [$j];
  }
  for($j = $i; $j < strlen ( $str ); $j ++) {
      @$laststr .= $str [$j];
  }
 @$str = ($startstr . $substr . $laststr);
  return $str;
  }
  
  function e($v,$l){
	if($v>0&&in_array($l,array(2,8,16))){
   @$x=array(0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F);
    while($v!=0){
    @$r.=($l!=16)?ceil($v%$l):$x[ceil($v%$l)];
    $v=intval($v/$l);
    }
   $r=strrev($r);
   $r=($l==2)?$r:(($l==8)?'0'.$r:$r);
   return $r;
}else{
   return $v;
} 
}
?>

