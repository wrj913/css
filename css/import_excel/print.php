<?php
//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment;Filename=document_name.xls");
//header('Content-type:text/html;charset=utf-8');
require_once 'excel_class.php';
require 'css/include/conn.php';
//定义一个excel文件
$workbook = dirname(__FILE__)."\B1.xls";
Read_Excel_File($workbook,$return);
// $result[sheet名][行][列] 的值为相应Excel Cell的值
//print_r($return['Sheet1']);
for ($i=0;$i<count($return['Sheet1']);$i++)
{

		//echo $return[Sheet1][$i][0]."cssd    <br/>";
		//echo $return[Sheet1][$i][1];
		$licence_result=mysql_query("select *from css_licenses");
		while($row = mysql_fetch_array($licence_result)){
			if($return['Sheet1'][$i][0]==$row['cssd_code']||$return['Sheet1'][$i][1]==$row['cssp_code']){
			echo "<script language=javascript>alert('licence已存在');history.back();window.opener.location.reload();</script>";
			exit();
			}
		}	
		$cssd_code=$return['Sheet1'][$i][0];
		$cssp_code=$return['Sheet1'][$i][1];
	 //echo "<br>";
	 $sql="insert into css_licenses (cssd_code,cssp_code) 
		  		  values('$cssd_code','$cssp_code');";
	// print_r($sql);
if(mysql_query($sql)==true){
//echo "<script language=javascript>alert('信息添加成功！');</script>";
	echo "添加第".$i."条"."<br/>";
}
else{
echo "<script language=javascript>alert('信息添加失败！');history.back();window.opener.location.reload();</script>";
}

}
?>