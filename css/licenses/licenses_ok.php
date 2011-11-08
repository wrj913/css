<?php
require 'css/include/conn.php';
if($_POST[Submit]!=""){
$ipqam_ip=$_POST[ipqam_ip];
$ipqam_port=$_POST[ipqam_port];
$frequence=$_POST[frequence];
$belongs_area=$_POST[belongs_area];
$license=$_POST[license];
$created_at=date("Y-m-d");
//print_r($_POST);

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
	echo '频点必须是纯数字';
	echo "<script language=javascript>alert('端口号必须是纯数字,请检查！');history.back();location.href='../../../licenses_add.php';</script>";
		}
else{    
//created_at 	updated_at 	ipqam_ip 	ipqam_port 	frequence 	belongs_area 	authorization_time 	css_license_id
$sql=mysql_query("insert into licenses (created_at,updated_at,ipqam_ip,ipqam_port,frequence,belongs_area,css_license_id) 
		  		  values('$created_at','$created_at','$ipqam_ip','$ipqam_port','$frequence','$belongs_area','$license')");
$sql_licenses=mysql_query("update css_licenses set status='1'where id='$license'")or die('添加数据出错：'.mysql_error());
if($sql==true){
echo "<script language=javascript>alert('信息添加成功！');history.back();location.href='../../../licenses.php';</script>";
}
else{
echo "<script language=javascript>alert('信息添加失败！');history.back();window.opener.location.reload();</script>";
}
}
}
?>
