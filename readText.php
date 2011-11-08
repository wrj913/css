<?php
header('Content-Type: text/html; charset="utf8"');	 //设置页面编码

include("./include/authcss.php");
include("./include/top_header.php");
require "css/include/conn.php";
$file=@fopen("css/licences/B1.txt",'r') or die("打开文件失败");


// 以只读方式打开test.txt文件。
//我们打开test.txt文件，可以看到test.txt文件内容的每一行与test.xls文件的每一行相对应。
//也就是说除了第一行外，每一行就相当于表的一条记录，我们只要循环插入每一行数据到表中就行了。

	fgets($file);

//先读取文件的第一行，因为第一行不是我们要的内容。
//下面循环读取每一行，第一行已经读取了，所以从第二行开始读取。
$i=0;
while(!feof($file)){
       $val=fgets($file); 
       //下面一步很关键，用explode()将每一行转换为数组来存储每个字段的值。 
       //比如说第二行的内容是：1    伍新亭    男    电子商务;
       //转换为数组就变成array(1,"伍新亭","男","电子商务");这对于我们插入数据库就很有帮助了。
     $values=explode("\t",trim($val));  //注意用来分割的是制表符"\t"，而不是空格" " ，自己也可以输出来测试一下。
    // print_r($values);
     $licence_result=mysql_query("select *from css_licenses");
     while($row = mysql_fetch_array($licence_result)){
			if($values[0]==$row['cssd_code']||$values[1]==$row['cssp_code']){
			echo "<script language=javascript>alert('licence已存在');history.back();window.opener.location.reload();</script>";
			exit();
			}
		}	
    $i++;
    $sql="insert into css_licenses(cssd_code,cssp_code) values('$values[0]','$values[1]')";
   //print_r($sql);
      if(!empty($values[0])) 
      mysql_query($sql)or die("插入数据失败"); //因为最后一行可能是空数据，所以做了个判断。
      echo "插入第".$i."条信息成功！！！"."<br/>";   
}

fclose($file);

?>
<?php

include("./include/bottom_footer.php");

?>