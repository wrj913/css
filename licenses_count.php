<?php
include("./include/authcss.php");
include("./include/top_header.php");

?>
<?php
	require './css/include/conn.php';
	$sql="select count(id ) from css_licenses";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	$status = mysql_fetch_array(mysql_query("select count(status) FROM css_licenses WHERE status='1'")); 
	//print_r($status);
	?>
	
<?php
		
		echo "<table class='css_table_tr' style='width: 996px;'>
		<tr  bgcolor='#00438C'><td colspan='10' class='textHeaderDark'  style='font-size: 12px; font-weight: bold;'>License使用统计</td></tr>
		<tr bgcolor='#6d88ad' class='textSubHeaderDark' style='font-size: 12px;'>
		<th></th>
		<th>CSSD-100-SL</th>
		<th>CSSP-100-SL</th>
		<th>CSSM-100-SL</th>
		</tr>";	
		echo "<tr>";
		echo "<th class="."css_table0>"."LICENSE 总授权数</th>";
		echo "<td class="."css_table0>" . $row['count(id )'] . "</td>";
		echo "<td class="."css_table0>" . $row['count(id )'] . "</td>";
		echo "<td class="."css_table0>"  . "1" . "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th class="."css_table1>"."已使用</th>";
		echo "<td class="."css_table1>". $status['count(status)'] . "</td>";
		echo "<td class="."css_table1>" . $status['count(status)'] . "</td>";
		echo "<td class="."css_table1>" . "1" . "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th class="."css_table0>"."未使用</th>";
		echo "<td class="."css_table0>" . ($row['count(id )']-$status['count(status)']) . "</td>";
		echo "<td class="."css_table0>" . ($row['count(id )']-$status['count(status)'])  . "</td>";
		echo "<td class="."css_table0>" . "0" . "</td>";
		echo "</tr>";
		echo "</table>";
?>
	<?php mysql_close();?>
<?php

include("./include/bottom_footer.php");

?>
