<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>选项</title>
<link rel="stylesheet" href="./include/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<link rel="stylesheet" href="./include/ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" /> 
<script type="text/javascript" src="./include/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui-1.8.16.custom.min.js"></script>
<script  type="text/javascript" >
		jQuery (function ($){				
			  $("select").change(function() {			   
			   if($(this).val() == '3'){
				$("input.tStart,input.tEnd,label.sed").css("display","block")     
			   }else{
				$("input.tStart,input.tEnd,label.sed").css("display","none")     
			   }
			 });			 
			});
</script>
<script type="text/javascript" charset="utf-8">
	  jQuery(document).ready(function(){
	//	  $("#datepicker1,#datepicker2").datepicker({ altFormat: 'yy-mm-dd' });
		$( "#datepicker1,#datepicker2" ).datepicker();
	  });
	  
</script>
<style type="text/css">
		input.tStart,input.tEnd {
			display:none;
			width:70px;
		}
		input.sButton2 {
			width:150px;
			height:60px;
			font-size:16px;
		}
		label.sed {
			display:none;
		}
</style>
</head>
<body>
<form name="form1" method="post" action="">
	 <label>筛选数据</label>		
		<select name="create_time" id="sel"> 
			<option value="0" >七天内在线用户数量</option>
			<option value="1" >三十天内在线用户数量</option>
			<option value="9">所有的</option> 
			<option value="3" class="third">自定义时间</option> 
		</select>	<br /><br /><br />
		<label class="sed">起始日期:</label>
		<input name="tStart" id="datepicker1" class="tStart" type="text" readonly="readonly" />
		<label class="sed">截止日期:</label>
		<input name="tEnd" id="datepicker2" class="tEnd" type="text" readonly="readonly" /><br />
		<input type="submit" name="sButton2" id="sButton2" value=" 查询 " />
</form>

<?php
$create_time = $_POST [create_time];
$tStart = $_POST [tStart];
$tEnd = $_POST [tEnd];
print_r ( $_POST );


//	echo $_POST[create_time].$_POST[tEnd];
?>

<?php
include "./include/config.php";
if ($create_time == 0 || $create_time == 1) {
	if ($_POST [create_time] == 0) {
		$cday = time () - (60 * 60 * 24 * 7);
		$day_end = time ();
	
		echo "---7天--"."</br>";
	} else {
		$cday = time () - (60 * 60 * 24 * 30);
		$day_end = time ();
	}
} else {
	if ($create_time == 9) {
		$sql_min = mysql_query ( "SELECT min( created_at) FROM clients" );
		$min_time = mysql_fetch_array ( $sql_min );
		$cday = strtotime ( $timestamp = $min_time [0] );				
		$day_end = time ();
	} elseif ($create_time == 3) {
		$cday = strtotime( $tStart);	
		$day_end =strtotime ($tEnd );
	} else {
		;
	}
}
$count = array ();
$d = 1;
//		$today=date('Y-m-d');


while ( $cday < $day_end ) {
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
	$d ++;
	//	echo $day ."-----".$day_end."ss";
	$cday = $cday + (24 * 60 * 60);
}
//print_r($count);
?>
	
	<?php
	/*
     Example12 : A true bar graph
 */
	
	// Standard inclusions   
	include ("pChart/pData.class");
	include ("pChart/pChart.class");
	
	// Dataset definition 
	$DataSet = new pData ();
	$DataSet->AddPoint ( $count, "Serie1" );
	$DataSet->AddAllSeries ();
	$DataSet->SetAbsciseLabelSerie ();
	$DataSet->SetSerieName ( "January", "Serie1" );

	// Initialise the graph
	if ($create_time == 0 ){
	$Test = new pChart ( 700, 230 );
	$Test->setFontProperties ( "Fonts/tahoma.ttf", 8 );
	$Test->setGraphArea ( 50, 30, 680, 200 );
	//后三位是图片背景颜色
	$Test->drawFilledRoundedRectangle ( 7, 7, 693, 223, 5, 240, 240, 240 );
	// 外边框设置
	$Test->drawRoundedRectangle ( 5, 5, 695, 225, 5, 230, 230, 230 );
	$Test->drawGraphArea ( 255, 255, 255, TRUE );
	}else {
	$Test = new pChart ( 900, 430 );
	$Test->setFontProperties ( "Fonts/tahoma.ttf", 8 );
	$Test->setGraphArea ( 50, 30, 880, 400 );
	//后三位是图片背景颜色
	$Test->drawFilledRoundedRectangle ( 7, 7, 893, 423, 5, 240, 240, 240 );
	// 外边框设置
	$Test->drawRoundedRectangle ( 5, 5, 895, 425, 5, 230, 230, 230 );
	$Test->drawGraphArea ( 255, 255, 255, TRUE );
	}
	//刻度线设置 
	//function drawScale($Data,$DataDescription,$Divisions,$R,$G,$B,$DrawTicks=TRUE,$Angle = 0,$Decimals = 1,$WithMargin = FALSE,$SkipLabels=1)
	$Test->setFixedScale ( 0, 50 );
	//刻度线设置
	$Test->drawScale ( $DataSet->GetData (), $DataSet->GetDataDescription (), 10, 150, 150, 150, TRUE, 0, 2, TRUE );
	
	$Test->drawGrid ( 4, TRUE, 230, 230, 230, 50 );
	
	// Draw the 0 line
	$Test->setFontProperties ( "Fonts/tahoma.ttf", 6 );
	$Test->drawTreshold ( 0, 143, 55, 72, TRUE, TRUE );
	
	// Draw the bar graph
	$Test->drawBarGraph ( $DataSet->GetData (), $DataSet->GetDataDescription (), TRUE );
	
	// Finish the graph
	$Test->setFontProperties ( "Fonts/tahoma.ttf", 8 );
	//注释框坐标
	$Test->drawLegend ( 596, 144, $DataSet->GetDataDescription (), 255, 255, 255 );
	$Test->setFontProperties ( "Fonts/tahoma.ttf", 10 );
	$Test->drawTitle ( 50, 22, "在线用户数量", 50, 50, 50, 585 );
	// $Test->Render("lizi.png");
	

	$imageFile = "example 1.png";
	$Test->Render ( $imageFile );
	echo '<img src="' . $imageFile . '">';
	?>

</body>
</html>
	