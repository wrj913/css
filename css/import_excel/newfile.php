<?php
//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment;Filename=document_name.xls");
header('Content-type:text/html;charset=utf-8');
require_once 'excel_class.php';

//定义一个excel文件
$workbook = dirname(__FILE__)."\stock_2.xls";
Read_Excel_File($workbook,$return);
// $result[sheet名][行][列] 的值为相应Excel Cell的值
$data =array();
$trans = array("/" => "");
//echo "仓库库存报表\t\n";
//echo "pnumber\tcounts\t\n";
$data[0][0]="仓库库存报表";
$data[0][1]="";
$data[1][0]="pnumber";
$data[1][1]="counts";
$s=2;
for ($i=0;$i<count($return['Sheet1']);$i++)
{
	for ($j=0;$j<count($return['Sheet1'][$i]);$j++)
	{
		if($j==2 && $i>3){$str= trim($return['Sheet1'][$i][$j])."-";}
		if($j==5 && $i>3){$str.= strtr(trim($return['Sheet1'][$i][$j]),$trans)."-";}
		if(strpos($str,"M") || strpos($str,"男")){
			$n=38;
		}else{
			$n=34;
		}
		for($m=0;$m<10;$m++){
			if(($j==20+$m) && $i>3){
				if(trim($return[Sheet1][$i][$j]!="")){
					//echo $str.($n+$m)."\t".trim($return[Sheet1][$i][$j])."\t\n";
					$data[$s][0]=$str.($n+$m);
					$data[$s][1]=trim($return['Sheet1'][$i][$j]);
					$s++;
				}
			}
		}
	}

}

Create_Excel_File(dirname(__FILE__)."\ddd.xls",$data);
?>