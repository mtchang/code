<?php
/*
* 安裝 fping 程式 ,  這個工具可以快速的平行 ping 很多的主機. 可以協助快速偵測主機服務是否存在。
* http://fping.org/

* 安裝 memcached sevice and php 的 mod
http://php.net/manual/en/book.memcached.php

* ping.php 程式, 使用 memcache 加速使用者重新 reload 頻繁時的查詢
*/
// -------------------------------
// 使用多執行序 fping ，快速平行的 ping 很多的主機. 並且使用 memcached 加速重複的 reload 查詢, 60秒內使用 cache 的資料。
// 搭配檔案： ping_list.txt (描述主機的資訊, 格式如下:)
// ----------------------
// 120.111.69.1,主機1
// 120.111.69.4,主機2
// ----------------------
// Write by mtchang.tw@gmail.com
// Date: 2017.2.12 update
// -------------------------------

// 算時間的函式，可以算到微秒. 準備用來看
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();


// 宣告使用 memcache 物件 , 常識連接看看. 不能連就停止.
$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Could not connect memcache !! ");
// 把結果存成一個 key in memcache
$key_alive_show = md5('device_fping');

// 取得看看記憶體中，是否有這個 key 存在, 有的話直接抓 key , 沒有的話再去 ping 主機
$get_result = $memcache->get($key_alive_show);
if(!$get_result) {
	$cmd = "echo fping -a $(cut ping_list.txt -d, -f1) | sh";
	exec($cmd,$output,$result);
	// 直接成為一個 $output 陣列, alive
	/*
	array (size=37)
	  0 => string '120.111.69.1' (length=12)
	  1 => string '120.111.69.4' (length=12)
	  2 => string '120.111.69.26' (length=13)
	  ...
	*/
	//var_dump($output);

	$alive_show_content = '
	<!-- On cells (`td` or `th`) -->
	<tr>
	  <td class="danger" colspan="3" align="center">Fping Device</td>
	</tr>
	<tr>
	  <td class="active">Desc</td>
	  <td class="success">IP</td>
	  <td class="warning">Alive</td>
	</tr>
	';

	$handle = @fopen("ping_list.txt", "r");
	if ($handle) {
		while (($buffer = fgets($handle, 4096)) !== false) {
			//echo $buffer."<br/>";
			$alive = '<span class ="glyphicon glyphicon-remove"></span>';
			$alive_color = 'danger';
			$ping_list = explode(",", $buffer);
			for ($i = 0 ; $i < count($output) ; $i++){
				if($output[$i] == $ping_list[0]){
					$alive = '<span class ="glyphicon glyphicon-ok"></span>';
					$alive_color = 'warning';
					break;
				}
			}
			$alive_show_content = $alive_show_content.'
			<tr>
			  <td class="active">'.$ping_list[1].'</td>
			  <td class="success">'.$ping_list[0].'</td>
			  <td class="'.$alive_color.'">'.$alive.'</td>
			</tr>
			';
		}
		if (!feof($handle)) {
			echo "Error: unexpected fgets() fail\n";
		}
		fclose($handle);
	}

	$alive_show = '
	<table class="table table-striped">
	'.$alive_show_content.'
	</table>
	';
	
	$time_html = "Cache Time : ".$time_html.date("Y-m-d H:i:s")."<br/>";
	$alive_show=$alive_show.$time_html;

	// 把結果準備儲存到 memcache 內, 如果沒有 timeout 的話, 下次直接拿 memcache 中的資料
	$content = $alive_show;
	
	// save to memcache
	$key_alive_show = md5('device_fping');
	$memcache->set($key_alive_show, $alive_show, false, 60) or die ("Failed to save data at the server");
	//echo "Store data in the cache (data will expire in 30 seconds)<br/>\n";	

}else{
	
	// 資料有存在記憶體中，直接取得 get from memcache
	$content = $get_result;
}


// 算處理時間
$time_end = microtime_float();
$time = $time_end - $time_start;
$time_html = "Now Time : ".date("Y-m-d H:i:s")."<br/>";
$time_html = $time_html."<p>總執行時間 $time 秒 </p>";

$content = $content.$time_html;
// -----
// 底下為顯示頁面 tmpl ，顯示 ping 的結果 $content 這個變數。
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>

<div class="container">
    <?php echo $content; ?>
</div>

</body>
</html>
