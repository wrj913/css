<?php session_start();?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<head>
<title>加速终端</title>
</head>
<script language="javascript">
function check(form){
	if(form.name.value==""){
		alert("请输入读者姓名!");form.name.focus();return false;
	}
	if(form.paperNO.value==""){
		alert("请输入证件号码!");form.paperNO.focus();return false;
	}
}
</script>
<body>
<?php 
  	require 'css/include/conn.php';
	$query=mysql_query("select * from licenses where css_license_id='$_GET[id]'");
	$result=mysql_fetch_array($query);
?>	
    <form name="form1" method="post" action="licenses_modifyok.php">
      <table width="600" height="432"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
           <td  align="center">授权频点ip地址：</td>
        <td width="427" height="39">
        <input name="ipqam_ip" type="text" value="<?php echo $result[ipqam_ip];?>">
        <input name="id" type="hidden"  value="<?php echo $result[id];?>"></td>
        </tr>
        <tr>
          <td align="center">端口号：</td>
          <td><input name="ipqam_port" type="text" value="<?php echo $result[ipqam_port];?>"></td>
        </tr>
        <tr>
        <td align="center">授权频点：</td>
        <td><input name="frequence" type="text" value="<?php echo $result[frequence];?>"> </td>
      </tr>
       <tr>
        <td align="center">所属区域：</td>
        <td><input name="belongs_area" type="text" value="<?php echo $result[belongs_area];?>"> </td>
      </tr>
      
        <tr>
          <td align="center">License：</td>
          <td>
            <select name="license" class="wenbenkuang" id="typeid">
<?php
  $sql=mysql_query("select * from css_licenses where status!='1'or id='$_GET[id]'");
  $info=mysql_fetch_array($sql);
  do{
?>
              <option value="<?php echo $info[id];?>" <?php if($result[css_license_id]==$info[id]){?> selected<?php }?>><?php echo '('.$info[cssd_code].')'.'('.$info[cssp_code].')';?></option>
              <?php
}while($info=mysql_fetch_array($sql));
?>
                        </select>
          </td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td><input name="Submit" type="submit" class="btn_grey" value="保存" onClick="return check(form1)">
&nbsp;
        <input name="Submit2" type="button" class="btn_grey" value="返回" onClick="history.back()"></td>
        </tr>
      </table>
    </form>
</body>
</html>
