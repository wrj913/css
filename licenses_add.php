<?php
include("./include/authcss.php");
include("./include/top_header.php");
?>
<?php @session_start();?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<link href="CSS/style.css" rel="stylesheet">
</head>
<body>
<table width="776" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">

      <tr>
	<form name="form1" method="post" action="./css/licenses/include/licenses_ok.php ">
	<table width="600" height="432"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td  align="center">授权频点ip地址：</td>
        <td width="427" height="39">
          <input name="ipqam_ip" type="text">  </td>
      </tr>
      <tr>
        <td align="center">端口号：</td>
        <td><input name="ipqam_port" type="text" > </td>
      </tr>
      <tr>
        <td align="center">授权频点：</td>
        <td><input name="frequence" type="text" > </td>
      </tr>
       <tr>
        <td align="center">所属区域：</td>
        <td><input name="belongs_area" type="text" > </td>
      </tr>
      
      <tr>
        <td align="center">License：</td>
        <td>
		<select name="license" class="wenbenkuang" id="typeid">
<?php
  include("./css/include/conn.php");
  $sql=mysql_query("select * from css_licenses where status!='1'");
  $info=mysql_fetch_array($sql);
  print_r($info);
  do{
?> 		
				
          <option value="<?php echo $info['id'];?>"><?php echo '('.$info['cssd_code'].')'.'('.$info['cssp_code'].')';?></option>
<?php
		  }while($info=mysql_fetch_array($sql));
?>  </select>        </td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td><input name="Submit" type="submit" class="btn_grey" value="保存" onClick="return check(form1)">
&nbsp;
<input name="Submit2" type="button" class="btn_grey" value="返回" onClick="history.back();location.href='./licenses.php';"></td>
      </tr>
    </table>
	</form>
</tr>
</table>
<?php

include("./include/bottom_footer.php");

?>
</body>
</html>


