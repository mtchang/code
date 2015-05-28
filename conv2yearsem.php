<?php
// 
// 日期轉成學期年(民國)  and 學期 (1 or 2)
/*
 // 使用範例：
$sem = conv2yearsem("20150231");
var_dump($sem);
// 回應值
array(2) {
  'year' =>
  int(103)
  'sem' =>
  int(2)
}
 */
function conv2yearsem($date_string) {
$date_var = strtotime("$date_string");
$today['year'] 	= (int)date("Y",$date_var);
$today['cyear']	= $today['year'] - 1911;
$today['month'] = (int)date("m",$date_var);
$today['day'] 		= (int)date("d",$date_var);
$current['year']	= $today['cyear'];
$current['sem']	= 1;

if($today['month'] >= 2 AND $today['month'] <= 7) {
	// 前一年下學期
	$current['year']	= $today['cyear'] -1;
	$current['sem']	= 2;
}else{
	// 上學期
	$current['year']	= $today['cyear'];
	$current['sem']	= 1;
	// 如果是 1 月, 年度為去年度的第1學期
	if($today['month'] == 1) {
		$current['year']	= $today['cyear']-1;
		$current['sem']	= 1;
	}
}

return($current);
}

$sem = conv2yearsem("20150231");
var_dump($sem);

?>
