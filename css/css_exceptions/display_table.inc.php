<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php
	include 'css/include/conn.php';
	$pagenum=30;//定义每页显示3条记录
	$page=@$_GET['page'];//分页所传的参数page
	$query=mysql_query("select * from css_exceptions");
	$totalnum=mysql_num_rows($query);//统计表的总记录数量
	$totalpage=ceil($totalnum/$pagenum);//总分页数
	if(!isset($page))
	{
	   $page=1;//如果分页的参数不存在，则当前默认是第一页
	}
	$startcount=($page -1)*$pagenum;//分页的开始索引值
	$sql="select * from css_exceptions order by created_at desc limit $startcount,$pagenum";
	$result=mysql_query($sql);
	?>
	
<?php
		echo "<table class='css_table_tr' style='width: 996px;'>
		<tr><td></td><td colspan='9'  style='font-size: 12px; text-align: right;'><a href='./css/css_exceptions/creat_excel.php'>导出</a></td></tr>
		<tr bgcolor='#00438C'><td colspan='10'  style='font-size: 12px; font-weight: bold;' class='textHeaderDark'>异常管理</td></tr>
    <tr  bgcolor='#6d88ad' class='textSubHeaderDark' style='font-size: 12px;'>
		<th class='css_table'>标题</th>
		<th class='css_table'>内容</th>
		<th class='css_table'>类型</th>
		<th class='css_table'>时间</th>
		</tr>";
		$mantissa=0;
		while($row = mysql_fetch_array($result))
		{
			if ($row['code']==100){
				$code='警告';}
			else {
				$code='错误';
			}	
		  $mantissa=$mantissa%2;		
		  echo "<tr>";
		  echo "<td class="."css_table"."$mantissa".">" . $row['title'] . "</td>";
		  echo "<td class="."css_table"."$mantissa".">" . $row['content'] . "</td>";
		  echo "<td class="."css_table"."$mantissa".">" . $code. "</td>";
		  echo "<td class="."css_table"."$mantissa".">" . $row['created_at'] . "</td>";
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
        if ($page==$i) {
          echo $i;
          }else {
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
