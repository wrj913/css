<?php

include("./include/authcss.php");
include("./include/top_header.php");

?>
<?php @session_start();?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<head>
<title>加速终端</title>
</head>
<body>
<?php 
  	include("./css/include/conn.php");
	$query=mysql_query("select * from licenses where css_license_id='$_GET[css_license_id]'");
	$result=mysql_fetch_array($query);
	//print_r($result);
?>	
    <form name="form1" method="post" action="licenses_modifyok.php">
      <table width="600" height="432"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
           <td  align="center">授权频点ip地址：</td>
        <td width="427" height="39">
        <input name="ipqam_ip" type="text" value="<?php echo $result['ipqam_ip'];?>">
        <input name="id" type="hidden"  value="<?php echo $result['id'];?>"></td>
        </tr>
        <tr>
          <td align="center">端口号：</td>
          <td><input name="ipqam_port" type="text" value="<?php echo $result['ipqam_port'];?>"></td>
        </tr>
        <tr>
        <td align="center">授权频点：</td>
        <td><input name="frequence" type="text" value="<?php echo $result['frequence'];?>"> </td>
      </tr>
       <tr>
        <td align="center">所属区域：</td>
        <td><input name="belongs_area" type="text" value="<?php echo $result['belongs_area'];?>"> </td>
      </tr>
      <?php
  	$sql=mysql_query("select * from css_licenses where id='$_GET[css_license_id]'");
  	$info=mysql_fetch_array($sql);
  
	  ?>
		<tr>
        <td align="center">CSSD-100-SL：</td>
        <td><input name="cssd_code" type="text" value="<?php echo $info['cssd_code'];?>" style="width: 350px;"> </td>
      </tr>
        <tr>
        <td align="center">CSSP-100-SL：</td>
        <td><input name="cssp_code" type="text" value="<?php echo $info['cssp_code'];?>" style="width: 350px;"> </td>
      </tr>
        <tr>
		<td>
        <input name="Submit2" type="button" class="btn_grey" value="返回" onClick="history.back()"></td>
        </tr>
      </table>
    </form>
    <?php

include("./include/bottom_footer.php");

?>
</body>
</html>

<?php

include("./include/bottom_footer.php");

?>
