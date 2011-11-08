<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
  include("./include/authcss.php");
  include("./include/top_header.php");
  ?>
  <?php
 include("./css/include/conn.php");
 	$pagenum=30;//定义每页显示3条记录
	$page=@$_GET['page'];//分页所传的参数page
	$query=mysql_query("select * from licenses");
	$totalnum=mysql_num_rows($query);//统计表的总记录数量
	$totalpage=ceil($totalnum/$pagenum);//总分页数

	if(!isset($page))
	{
		
		$page=1;//如果分页的参数不存在，则当前默认是第一页
	}
	$startcount=($page -1)*$pagenum;//分页的开始索引值
	$num=($page-1)*30;
$sql = "SELECT * FROM licenses order by belongs_area desc limit $startcount,$pagenum"; 
$result=mysql_query($sql);
$info=mysql_fetch_array($result);
if($info==false){
?>
 <table width="100%" height="30"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="36" align="center">暂无信息！</td>
            </tr>
          </table>
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <a href="./include/licenses_add.php">添加信息</a> </td>
  </tr>
</table>
 <?php 
}else{
  ?> <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="87%">&nbsp;      </td>
<td width="13%" class='css_table0'>
      <a href="./licenses_add.php">添加信息</a></td>	  
  </tr>
</table>  
  <table class='css_table_tr' style='width: 996px;'>
  <tr bgcolor='#00438C'><td colspan='10' class='textHeaderDark'  style='font-size: 12px; font-weight: bold;'>Licenses列表</td></tr>
  <tr bgcolor='#6d88ad' class='textSubHeaderDark' style='font-size: 12px;'>
  <?php //所属区域	频点编号	授权频点IP地址	端口号	授权频点	最后使用时间?>
    <th >频点编号</th>  
    <th >所属区域</th>
    <th >授权频点IP地址</th>
    <th >端口号</th>
    <th >授权频点</th>
    <th >最后使用时间</th>
     <th colspan="2">操作</th>
  </tr>
<?php
	$mantissa=0; 

do{
	$num++;
	 $mantissa=$mantissa%2;
	?> <tr>
    <td class='css_table<?php echo "$mantissa";?>'><?php echo $num;?> </td>  
    <td class=css_table<?php echo "$mantissa";?>><a href="./licenses_info.php?css_license_id=<?php echo $info['css_license_id']; ?> "><?php echo $info['belongs_area'];?> </a></td>
    <td class=css_table<?php echo "$mantissa";?>><?php echo $info['ipqam_ip'];?> </td>
 	<td class=css_table<?php echo "$mantissa";?>><?php echo $info['ipqam_port'];?> </td>
 	<td class=css_table<?php echo "$mantissa";?>><?php echo $info['frequence'];?> </td>
 	<td class=css_table<?php echo "$mantissa";?>><?php echo $info['updated_at'];?> </td>
    <td class=css_table<?php echo "$mantissa";?> align="center"><a href="./licenses_modify.php?id=<?php echo $info['id'];?>">修改</a></td>
    <td class=css_table<?php echo "$mantissa";?> align="center"><a href="./css/licenses/licenses_del.php?id=<?php echo $info['id'];?> ">删除</a></td>
  </tr>
<?php 
	
	 $mantissa=$mantissa+1;
  }while($info=mysql_fetch_array($result));
}
?> </table>
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
			for($i=1;$i<=$i && $i<=$totalpage;$i++)
			{?>
				<a href="?page=<? echo $i;?>"><? echo $i;?></a>
			<? }}
		 else{
			for($i=($page-5);$i<=($page+5)&& $i<=$totalpage;$i++)
			{?>
			<a href="?page=<? echo $i;?>"><? echo $i;?></a>
			<? }	
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
<?php

include("./include/bottom_footer.php");

?>
