<?php
// ----------------------------------------
// 程式功能：此系統中用到的自訂函式庫
// 檔案名稱：lib.php
//------------------------------------------


// -------------------------------------------------------------------------------------
// 連接資料庫的的設定,預設將 set name utf8 開啟 (第 1 組 SQL)
//
try {
	// 在 PDO 宣告的時候就要將編碼一併宣告。 ref.pdo-mysql.connection
	global $dbh;
	$dsn = "mysql:host=$dbhost;dbname=$dbname";
	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
	$dbh = new PDO($dsn, $dbuser, $dbpassword, $options);
} catch (PDOException $e) {
        print "DB connect Error!: " . $e->getMessage() . "<br/>";
        die();
}


// ---------------------------------------------------------------------
// run SQL command then return $stmt
// 使用方式 example:
// Use example:
// $sql = "SELECT * FROM `People` WHERE 1 LIMIT 0, 30 ";
// $stmt=runSQL("$sql");
// while ($result = $stmt->fetch(PDO::FETCH_OBJ)) 	{
// 		echo $result->begin_time;
// 		echo $result->Text;
// 		echo $result->LoginID;
// }
// ---------------------------------------------------------------------
// 執行 sql 回傳影響的行數. 如果為 0 則不受影響.
// 此函數用於不抓值資料的處理
function runSQL($query)
{
	global $dbh;
	try {
	$result_count = 0;
	$stmt = $dbh->prepare("$query");
	// true or false , sql 語法
	$result = $stmt->execute();
	$result_count = $stmt->rowCount();
	// $result = $stmt->fetch(PDO::FETCH_OBJ);
	} catch (PDOException $e) {
        echo "DB connect Error!: $e->getMessage()";
        die();
	}
	return($result_count);
}


// ---------------------------------------------------------------------
// run SQL command then return $result
// $result[0] --> 資料數量, 如果為 0 表示沒有變動的列
// $result[1] ~ $result[n] --> 資料內容，從第一筆開始
// 使用方式 example:
// $result = runSQLall($sql);
// var_dump($result);
// ---------------------------------------------------------------------
function runSQLall($query)
{
	global $dbh;
	try {
	$stmt = $dbh->prepare("$query");
	$stmt->execute();
	// 查詢到的數量, 放到此變數的 [0] 索引位置
	$db_dump_result_all[0] = $stmt->rowCount();
	$i=1;
	// 以物件方式存變數物件取用以 $result->var 方式取用
	while ($db_dump_result = $stmt->fetch(PDO::FETCH_OBJ))  {
		$db_dump_result_all[$i] = $db_dump_result;
		$i++;
		}
	} catch (PDOException $e) {
        return("DB connect Error!: $e->getMessage() , SQL: $query ");
        die();
	}
	return($db_dump_result_all);
}




?>
