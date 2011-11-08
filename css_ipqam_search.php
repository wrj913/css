<?php
	header('Content-Type: text/html; charset="utf8"');	 //设置页面编码

	
	include("./include/authcss.php");
	include("./include/top_header.php");
	include("./css/ipqam_search/include/config.php");

	//!empty($_POST['username'])和 ==''基本一样，但是，并不能说，人家是非法的
	//只能说人家没有填而已。
	if (isset($_POST['frequence'])) {
		$frequence = $_POST['frequence'];
		//在输出之前，为了页面安全性
		$frequence = trim($frequence);
		$frequence = htmlspecialchars($frequence);
		if (empty($frequence)){
			$sql="
				SELECT channels.frequence, ipqams.ip
				FROM ipqams, channels
				WHERE ipqams.id = channels.ipqam_id
				ORDER BY channels.frequence
				";
		}else {
		if (!is_numeric($frequence)) {
			echo '频点必须是纯数字';
			exit;
		}
		
		if (strlen($frequence) < 4 ||strlen($frequence)>6) {
			echo '输入的频点位数不正确';
			exit;
		}
	$sql = "select ip from ipqams where id in (select ipqam_id from channels where frequence=$frequence)"; 
	}
	}		

		
		$result=mysql_query($sql);
		echo "<table border='0'  cellspacing='0'>
		<tr>
		<th>频点 </th>
		<th>IPQAM</th>
		</tr>";
//		频点 	IPQAM
		while($row = mysql_fetch_array($result))
		{			
		  echo "<tr>";
		  if (isset($row[frequence]))
		  {echo "<td>" . $row['frequence'] . "</td>";}
		  else {
		  	echo "<td>" . $frequence . "</td>";
		  }
		  echo "<td>" . $row['ip'] . "</td>";
		  echo "</tr>";
	//	print_r ($row);
  		}
		echo "</table>";
?>
<?php include("./include/bottom_footer.php");
?>





