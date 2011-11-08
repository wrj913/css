<?php
header('Content-Type:text/html; charset=utf-8');
require 'css/include/conn.php';
$id=$_GET[id];
print_r($id);
$sql_licenses=mysql_query("select * from licenses where id = '$id'");
$info=mysql_fetch_array($sql_licenses);
$sql="delete from licenses where id='$id'";
if(!empty($info['css_license_id'])){
$sql_css_licenses=mysql_query("update css_licenses set status='0'where id=$info[css_license_id]")or die('修改licenses数据出错：'.mysql_error());}
if(mysql_query($sql)){
echo "<script language=javascript>alert('信息删除成功！');window.location.href='../../../licenses.php';</script>";
}
else{
echo "<script language=javascript>alert('信息删除失败！');window.location.href='../../../licenses.php';</script>";
}
?>
