<?php
// 使用 php + redis server 模擬 session 的動作
// Author: mtchang.tw@gmail.com
// Date: 2016.6.26


$time_start = microtime(true);

// --------------------------------------
// 建立一個 redis client 連線
// --------------------------------------
$redis = new Redis();

// 2 秒 timeout
if($redis->connect('192.168.111.111', 6379, 2)) {
	// success
	if($redis->auth('12345678')) {
		echo 'Authentication Success';
	}else{
		die('Authentication failed');
	}
}else{
	// error
	die('Connection Failed');
}
// 選擇 DB
$redis->select(1);
echo "Server is running: ".$redis->ping();

// --------------------------------------
// 建立一個 redis 的 session 連線
// --------------------------------------
// 如果 jangmt_session 存在 user cookie 的話, 取回這個 session 的資料
if(isset($_COOKIE['jangmt_session'])) {
	$session['key'] = $_COOKIE['jangmt_session'];
	$get_session_string = $redis->get($session['key']);
	$get_session = json_decode($get_session_string);

	// 取回 session 後, 更新 cookie  and session timeout value
	// 設定 timeout 值
	$session['server_time'] = time(true);
	$session['expire']		= 300;
	$session['expire_time']	= $session['server_time']+$session['expire'];
	
	// 將編碼成為 json 的 array 寫入 redis , 以 $session['key'] 為 key , $session['expire_time'] 為 timeout
	$session_json = json_encode($session);	
	$redis->set($session['key'], $session_json);
	$redis->expireAt($session['key'], $session['expire_time']); 

	// setcookie(name,value,expire,path,domain,secure)
	$cookie['name'] = 'jangmt_session';
	$cookie['value'] = $session['key'];
	$cookie['expire'] = $session['expire_time'];
	$cookie['domain'] = 'jangmt.com';
	$cookie['secure'] = '';
	// 執行 setcookie , 如果重複就是更新 timeout value , 
	// setcookie 這行一定要是 http 第一個輸出。
	setcookie($cookie['name'], $cookie['value'], $cookie['expire']);
	echo '取回存在的 session <br>';
}else{
	// 如果沒有 cookie 的話, 註冊一個 session 
	$session['server_microtime'] = microtime(true);
	$session['key_plain']	= $session['server_microtime'].':'.$_SERVER['REMOTE_ADDR'].':'.rand();
	$session['key_id'] 		= md5("mtchang.tw@gmail.com");
	$session['key'] 		= 'jangmt_session:'.$session['key_id'].':'.md5($session['key_plain']);

	// 設定 timeout 值
	$session['server_time'] = time(true);
	$session['expire']		= 300;
	$session['expire_time']	= $session['server_time']+$session['expire'];

	// 對於使用者 browser 寫入 cookie , 並設定 timeout, 下次如果還沒 timeout 的話, 就使用這個 cookie
	// setcookie(name,value,expire,path,domain,secure)
	$cookie['name'] = 'jangmt_session';
	$cookie['value'] = $session['key'];
	$cookie['expire'] = $session['expire_time'];
	$cookie['domain'] = 'jangmt.com';
	$cookie['secure'] = '';
	// 執行, 如果重複就是更新 timeout value
	setcookie($cookie['name'], $cookie['value'], $cookie['expire']);
	
	$session_json = json_encode($session);
	// 將編碼成為 json 的 array 寫入 redis , 以 $session['key'] 為 key
	$redis->set($session['key'], $session_json);
	$redis->expireAt($session['key'], $session['expire_time']); 

	$get_session_string = $redis->get($session['key']);
	$get_session = json_decode($get_session_string);

	echo '註冊一個新的 session <br>';
}


$time_end = microtime(true);
$time = $time_end - $time_start;
echo "<p>Did nothing in $time seconds </p>";

?>
