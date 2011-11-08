<?php
header ( 'Content-Type: text/html; charset="utf8"' ); //设置页面编码
include ("./include/authcss.php");
include ("./include/top_header.php");
include ("./css/include/conn.php");

$sql_channels = "select  distinct frequence from channels";
$result_channels = mysql_query ( $sql_channels );

echo "<table class='css_table_tr' style='width: 996px;'>
		<tr bgcolor='#00438C'>
			<td colspan='3' class='textHeaderDark'  style='font-size: 12px; font-weight: bold;'>频点查询</td>
		</tr>
		<tr bgcolor='#6d88ad' class='textSubHeaderDark' style='font-size: 12px;'>
			<th class='css_table'>频点 </th>
			<th class='css_table'> IPQAM</th>
			<th class='css_table'>vip</th>
		</tr>";
//		频点 	IPQAM
$mantissa = 0;
while ( $row_channels = mysql_fetch_array ( $result_channels ) ) {
	$mantissa = $mantissa % 2;
	echo "<tr>";
	echo "<td class=" . "css_table" . "$mantissa" . ">" . $row_channels ['frequence'] . "</td>";
	
	//输出ipqam
	$sql_ipqams = "SELECT *
						FROM ipqams 
						WHERE id 
						in (SELECT ipqam_id FROM channels where frequence='$row_channels[frequence]')";
	$result_ipqams = mysql_query ( $sql_ipqams );
	
	echo "<td class=" . "css_table" . "$mantissa" . ">";
	echo "<table>";
	echo "<tr>";
	while ( $row_ipqams = mysql_fetch_array ( $result_ipqams ) ) {
		echo "<td class=" . "css_table" . "$mantissa" . ">[" . $row_ipqams ['ip'] . "]</td>";
	}
	echo "</tr>";
	echo "</table>";
	echo "</td>";
	
	//输出vip
		$sql_current = "select vip 
							   from current_clients
							   where access_point_id 
							   in (SELECT id FROM access_points 
							   where  channel_id in (select id from channels where frequence = '$row_channels[frequence]'))";
		$result_current = mysql_query ( $sql_current );
		echo "<td class=" . "css_table" . "$mantissa" . ">";
		echo "<table>";
		echo "<tr>";
		while ( $row_current = mysql_fetch_array ( $result_current ) ) {
			echo "<td class=" . "css_table" . "$mantissa" . ">[" . $row_current ['vip'] . "]</td>";
		}	
		echo "</tr>";
		echo "</table>";
		echo "</td>";
	echo "</tr>";
	$mantissa = $mantissa + 1;
}
echo "</table>";
?>
<?php

include ("./include/bottom_footer.php");

?>