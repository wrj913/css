<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php

include ("./include/authcss.php");
include ("./include/top_header.php");

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>选项</title>
<link rel="stylesheet"
	href="./css/php_png/include/jquery-ui-1.8.16.custom.css"
	type="text/css" media="screen" title="core css file" charset="utf-8" />
<link rel="stylesheet" href="./css/php_png/include/ui.datepicker.css"
	type="text/css" media="screen" title="core css file" charset="utf-8" />
<script type="text/javascript"
	src="./css/php_png/include/jquery-1.6.2.min.js"></script>
<script type="text/javascript"
	src="./css/php_png/include/jquery-ui-1.8.16.custom.min.js"></script>

<script type="text/javascript" charset="utf-8">
	  jQuery(document).ready(function(){
	//	  $("#datepicker1,#datepicker2").datepicker({ altFormat: 'yy-mm-dd' });
		$( "#datepicker1,#datepicker2" ).datepicker();
	  });
	  
</script>
<style type="text/css">
input.tStart,input.tEnd {
	width: 70px;
}

input.sButton2 {
	width: 150px;
	height: 60px;
	font-size: 16px;
}
</style>
</head>
<body>


<form name="form1" method="get" action="png_web.php" style="border-bottom-width: 0px; padding-bottom: 50px;">
<a href="./png_web.php?id=1">本周用户数量</a>
<a href="./png_web.php?id=2">本月用户数量</a>
<a href="./png_web.php?id=3">本年用户数量</a>
<label>起始日期:</label>
<input name="tStart" id="datepicker1" class="tStart" type="text" readonly="readonly" /> 
<label>截止日期:</label> 
<input name="tEnd" id="datepicker2" class="tEnd" type="text" readonly="readonly" />
<input type="submit" name="sButton2" id="sButton2" value=" 查询 " />
</form>

<?php
//print_r ($_GET);
?>

<?php

include "./css/include/conn.php";
if (empty($_GET['id'] )&&empty($_GET['sButton2'])){
	$w = date ( "w" );
	$cday = time () - (($w - 1) * 60 * 60 * 24);
	$day_end = time ();
	
}elseif (!empty($_GET['id'] )) {
	if ($_GET['id'] == 1) {
		$w = date ( "w" );
		$cday = time () - (($w - 1) * 60 * 60 * 24);
		$day_end = time ();
		
	//	echo "---7天--" . "</br>";
	} 
	if ($_GET['id'] == 2){
		$td = date ( "d" );
		$cday = time () - (60 * 60 * 24 * ($td - 1));
		$day_end = time ();
	}
	if ($_GET['id'] == 3) {
		$sql_min = mysql_query ( "SELECT min( created_at) FROM clients" );
		$min_time = mysql_fetch_array ( $sql_min );
		$cday = strtotime ( $timestamp = $min_time [0] );
		$day_end = time ();
   }
}else{	
	
		if (empty ($_GET ['tStart'] ) || empty ($_GET ['tEnd'])) {
			echo '时间不可为空';
			echo "<script language=javascript>alert('时间不可为空,请检查！');history.back();location.href='./png_web.php?id=1';</script>";
		}
		if (@$_GET ['tStart']>@$_GET ['tEnd']) {
			echo '时间输入错误';
			echo "<script language=javascript>alert('时间输入错误,请检查！');history.back();location.href='./png_web.php?id=1';</script>";
		}
	
   		$tStart = $_GET ['tStart'];
		$tEnd = $_GET ['tEnd'];	
			
		$cday = strtotime ( $tStart );
		$day_end = strtotime ( $tEnd );
//		echo $cday."</br>";
//		echo date("y-m-d",$cday);
//		echo "---自定义--" . "</br>";
		
	}	

$count = array ();
$params = array ();
$d = 1;
//		$today=date('Y-m-d');


while ( $cday <= $day_end ) {
//	echo date("y-m-d",$cday)."</br>";
	$day = date ( "Y-m-d ", $cday );
	$day_next = date ( "Y-m-d", ($cday + (24 * 60 * 60)) );
	$sql = "SELECT COUNT(mac)
				FROM clients where 
				(created_at
				BETWEEN '$day'
				AND '$day_next'
				)";
	//print_r($sql);								
	$result = mysql_query ( $sql );
	$row = mysql_fetch_array ( $result );
	$count [$d - 1] = $row [0];
	$params [$d - 1] = $cday;
	$d ++;
	//	echo $day ."-----".$day_end."ss";
	$cday = $cday + (24 * 60 * 60);
}
//print_r($count);
//print_r($params);
?>
	
	<?php
	/*
     Example12 : A true bar graph
 */
	
	// Standard inclusions   
	include ("./css/php_png/pChart/pData.class.php");
	include ("./css/php_png/pChart/pChart.class.php");
	// Dataset definition 
	$DataSet = new pData ();
	$DataSet->AddPoint ( $count, "Serie1" );
	$DataSet->AddPoint ( $params, "Serie2" ); //横坐标的数据
	$DataSet->AddSerie ( "Serie1" );
	$DataSet->SetAbsciseLabelSerie ( "Serie2" );
	$DataSet->SetSerieName ( "Count", "Serie1" );
	//	$DataSet->SetXAxisName("横坐标：日期"); //横坐标上显示的文字
	$DataSet->SetXAxisFormat ( "date" ); //横坐标的数据类型
	

	// Initialise the graph
	$Test = new pChart ( 900, 430 );
	$Test->setDateFormat ( 'j号' ); //横坐标显示的日期格式
	$Test->setColorPalette ( 0, 109, 136, 173 );
	
	$Test->setFontProperties ( "./css/php_png/Fonts/arialuni.ttf", 8 );
	$Test->setGraphArea ( 50, 30, 880, 400 );
	//后三位是图片背景颜色
	$Test->drawFilledRoundedRectangle ( 7, 7, 893, 423, 5, 240, 240, 240 );
	// 外边框设置
	$Test->drawRoundedRectangle ( 5, 5, 895, 425, 5, 109, 136, 173 );
	$Test->drawGraphArea ( 255, 255, 255, TRUE );
	
	//刻度线设置 
	//function drawScale($Data,$DataDescription,$Divisions,$R,$G,$B,$DrawTicks=TRUE,$Angle = 0,$Decimals = 1,$WithMargin = FALSE,$SkipLabels=1)
	$Test->setFixedScale ( 0,500,10 );
	//刻度线设置
	$Test->drawScale ( $DataSet->GetData (), $DataSet->GetDataDescription (), 50, 150, 150, 150, TRUE, 0, 2, TRUE );
	
	$Test->drawGrid ( 4, TRUE, 230, 230, 230, 50 );
	//显示柱形框的值
	 $Test->writeValues($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1");
	// Draw the 0 line
	$Test->setFontProperties ( "./css/php_png/Fonts/tahoma.ttf", 6 );
	$Test->drawTreshold ( 0, 143, 55, 72, TRUE, TRUE );
	
	// Draw the bar graph
	$Test->drawBarGraph ( $DataSet->GetData (), $DataSet->GetDataDescription (), TRUE );
	
	// Finish the graph
	$Test->setFontProperties ( "./css/php_png/Fonts/tahoma.ttf", 8 );
	//注释框坐标
	$Test->drawLegend ( 596, 8, $DataSet->GetDataDescription (), 255, 255, 255 );
	$Test->setFontProperties ( "./css/php_png/Fonts/arialuni.ttf", 10 );
	$Test->drawTitle ( 50, 22, "在线用户数量", 0, 67, 140, 585 );
	// $Test->Render("lizi.png");
	
	$word=rand(0, 10);
	$imageFile = "./png/example".time().".png";
	$Test->Render ( $imageFile );
 	echo '<img src="' . $imageFile . '">';
//	echo '<img src="./".$imageFile."?".time()>';
	
		 
?>
<?php

include ("./include/bottom_footer.php");

?>
</body>
</html>
