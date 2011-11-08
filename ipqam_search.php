<?php
header ( 'Content-Type: text/html; charset="utf8"' ); //设置页面编码
include ("./include/authcss.php");
include ("./include/top_header.php");
require './css/ipqam_search/search_form.php';
include ("./css/include/conn.php");
$sql = "SELECT distinct ip FROM ipqams";
//!empty($_POST['username'])和 ==''基本一样，但是，并不能说，人家是非法的
//只能说人家没有填而已。
if (isset ( $_POST ['frequence'] )) {
	$frequence = $_POST ['frequence'];
	//在输出之前，为了页面安全性
	$frequence = trim ( $frequence );
	$frequence = htmlspecialchars ( $frequence );
	if (empty ( $frequence )) {
		$sql = "SELECT distinct ip FROM ipqams";
	} else {
		if (! is_numeric ( $frequence )) {
			echo '频点必须是纯数字';
			exit ();
		}
		
		if (strlen ( $frequence ) < 4 || strlen ( $frequence ) > 6) {
			echo '输入的频点位数不正确';
			exit ();
		}
		$sql = "select * from ipqams where id in (select ipqam_id from channels where frequence=$frequence)";
	}
}

$result = mysql_query ( $sql );
echo "<table class='css_table_tr' style='width: 996px;'>
		<tr bgcolor='#00438C'><td colspan='3' class='textHeaderDark'  style='font-size: 12px; font-weight: bold;'>IPQAM查询</td></tr>
		<tr bgcolor='#6d88ad' class='textSubHeaderDark' style='font-size: 12px;'>
		<th class='css_table'> IPQAM</th>
		<th class='css_table'>频点 </th>
		<th class='css_table'>vip </th>
	<!--	<th class='css_table'>vip </th>  -->
			</tr>";
//		频点 	IPQAM
$mantissa = 0;
while ( $row_ipqam = mysql_fetch_array ( $result ) ) {
	$mantissa = $mantissa % 2;
	echo "<tr>";
	if (empty ( $frequence )) {
		echo "<td class=" . "css_table" . "$mantissa" . ">" . $row_ipqam ['ip'] . "</td>";
		$sql_channels = "SELECT * 
									FROM channels 
									WHERE ipqam_id 
									in (SELECT id FROM ipqams where ip='$row_ipqam[ip]')";
		$sql_channels = mysql_query ( $sql_channels );
		echo "<td class=" . "css_table" . "$mantissa" . ">";
		echo "<table >";
		echo "<tr>";
		while ( $row_channels = mysql_fetch_array ( $sql_channels ) ) {			
			echo "<td >" . '[' . $row_channels ['frequence'] . "]</td>";	
		}
		echo "</tr>";
		echo "</table>";
		echo "</td>";
			$sql_current = "select 
			 current_clients.vip
			 from 
	  		access_points,current_clients
	  where 
	   current_clients.access_point_id=access_points.id and ipqam_ip='$row_ipqam[ip]'"; 
		$result_current = mysql_query($sql_current);
		//echo $sql_current;
		echo "<td class=" . "css_table" . "$mantissa" . ">";
		echo "<table >";
		echo "<tr>";
		while ( $row_current = mysql_fetch_array ( $result_current ) ) {			
			echo "<td >" . '[' . $row_current ['vip'] . "]</td>";	
		}
		echo "</tr>";
		echo "</table>";
		echo "</td>";
		
	} else {
		$sql_current="select 
			 current_clients.vip,
			 channels.frequence
	  from 
	  		access_points,channels,current_clients
	  where 
	  		access_points.channel_id=channels.id 
	  		and current_clients.access_point_id=access_points.id
	  		and channels.frequence='$frequence' 
	  		and access_points.ipqam_ip='$row_ipqam[ip]'";
			$result_current = mysql_query($sql_current);
		echo "<td class=" . "css_table" . "$mantissa" . ">" . $row_ipqam ['ip'] . "</td>";
		echo "<td class=" . "css_table" . "$mantissa" . ">" . $frequence . "</td>";
		echo "<td class=" . "css_table" . "$mantissa" . ">";
		echo "<table >";
		echo "<tr>";
		while ( $row_current = mysql_fetch_array ( $result_current ) ) {			
			echo "<td >" . '[' . $row_current ['vip'] . "]</td>";	
		}
		echo "</tr>";
		echo "</table>";
		echo "</td>";
	}
	echo "</tr>";
	$mantissa = $mantissa + 1;
}
echo "</table>";
?>
<?php

include ("./include/bottom_footer.php");
?>





