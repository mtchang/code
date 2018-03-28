<?php
// ----------------------------------------
// 程式功能：系統設定檔
// 檔案名稱：config.php
//------------------------------------------
// 算累積花費時間 start
$start_date =  microtime(true);
// -------------------------------------------------------------------------------------
// 切換系統模式及資料庫
// -------------------------------------------------------------------------------------
// 請在根目錄下建立一個檔案 VERSION.txt 檔案內容放置 release or developer , 依據此變數自動判斷目前所在開發環境
$version_filepath = dirname(__FILE__)."/version.txt";
$system_mode = trim(file_get_contents($version_filepath));
// var_dump($system_mode);
$system_mode = 'developer';
// $system_mode = 'release';
global $host_url;
if($system_mode == 'developer') {
	// sql DB infomation -- for develop
	$dbhost		='127.0.0.1';
	$dbname		='pay';
	$dbuser		='pay';
	$dbpassword	='changepassword';

// -------------------------------------------------------------------------------------
}elseif($system_mode == 'release') {

}else{
	// 沒有設定 STOP
	die('system mode set error.');
}

// -------------------------------------------------------------------------------------
// 帶入常用函式庫及語言
// -------------------------------------------------------------------------------------
// 自訂函式庫
require dirname(__FILE__)."/lib.php";




?>
