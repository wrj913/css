<?php 
session_start();
require 'css/include/conn.php';
$id=$_POST[id];
$ipqam_ip=$_POST[ipqam_ip];
$ipqam_port=$_POST[ipqam_port];
$frequence=$_POST[frequence];
$belongs_area=$_POST[belongs_area];
$license=$_POST[license];
$updated_at=date("Y-m-d");
print_r($_POST);

if(empty($belongs_area)){
	echo '所属地不可为空';
	echo "<script language=javascript>alert('所属地不可为空,请检查！');history.back();location.href='../../../licenses_add.php';</script>";
}

elseif (!is_numeric($frequence)) {
	echo '频点必须是纯数字';
	echo "<script language=javascript>alert('频点必须是纯数字,请检查！');history.back();location.href='../../../licenses_add.php';</script>";
		}
		
elseif (strlen($frequence) < 4 ||strlen($frequence)>6) {
	echo '输入的频点位数不正确';
	echo "<script language=javascript>alert('输入的频点位数不正确,请检查！');history.back();location.href='../../../licenses_add.php';</script>";
		}
elseif (!is_numeric($ipqam_port)) {
	echo '端口号必须是纯数字';
	echo "<script language=javascript>alert('端口号必须是纯数字,请检查！');history.back();location.href='../../../licenses_add.php';</script>";
		}
else {
$sql=mysql_query("select * from licenses where id='$id'");
$license_info=mysql_fetch_array($sql);
if ($license_info['css_license_id']!=$license){
	mysql_query("update css_licenses set status='1'where id='$license'")or die('修改数据出错：'.mysql_error());
	if (!empty($license_info['css_license_id'])){
	mysql_query("update css_licenses set status='0' where id='$license_info[css_license_id]'")or die('修改licenses数据出错：'.mysql_error());
	}
}
$query="update licenses set updated_at='$updated_at',ipqam_ip='$ipqam_ip',ipqam_port='$ipqam_port',frequence='$frequence',belongs_area='$belongs_area',css_license_id='$license'where id='$id'";
 mysql_query($query) or die('添加数据出错：'.mysql_error());
echo "<script language='javascript'>alert('信息修改成功!');window.location.href='../../../licenses.php';</script>";
}
?>