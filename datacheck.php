
// ----------------------------------------------------------.
/*
// use sample
$salt = '11223344';
// 需要傳遞的陣列
$codevalue_array = array(
  'Amt' 			=> '111',
  'MerchantOrderNo' => 'ertgyhujioiuytre'
);
// 產生
$send_code = jwtenc($salt,$codevalue_array);
var_dump($send_code);
// 解碼
$codevalue = jwtdec($salt,$send_code);
var_dump($codevalue);
*/
// ----------------------------------------------------------.
// jwtenc 傳送需要被回傳的資料, 包含驗證碼
// $salt 加密的密碼
// $codevalue_array 傳送的資料陣列
// ----------------------------------------------------------.
function jwtenc($salt, $codevalue_array, $debug =0) {
  // 將變數排序陣列
  $check_codevalue = ksort($codevalue_array);

  // 將變數使用 json + base64 encode
  $base64_codevalue =base64_encode(json_encode($codevalue_array));

  // 用 sha1 加密 , 產生檢核碼
  $checkvalue = sha1($salt . sha1($salt . $base64_codevalue));

  // 兩個碼合在一起當成變數傳遞
  $send_code = $checkvalue.'_'.$base64_codevalue;

  if($debug  == 1) {
    var_dump($check_codevalue);
    var_dump($base64_codevalue);
    var_dump($checkvalue);
    var_dump($send_code);
  }
  return($send_code);
}
// ----------------------------------------------------------.

// ----------------------------------------------------------.
// jwtdec 解開並驗證傳回的資料是否正確, 不正確為 false
// $salt 加密的密碼
// $send_code 接收到的 jwt data
// ----------------------------------------------------------.
function jwtdec($salt, $send_code, $debug =0) {
  // 將傳來的 code 拆開
  $send_code_value = explode('_', $send_code);

  // return
  $checkvalue = sha1($salt . sha1($salt . $send_code_value[1]));

  // 判斷資料是否有被竄改
  if($checkvalue == $send_code_value[0]){
    $codevalue =json_decode(base64_decode($send_code_value[1]));

  }else{
    // 資料被串改 false return
    $codevalue = false;
  }

  if($debug  == 1) {
    var_dump($send_code_value);
    var_dump($checkvalue);
    var_dump($codevalue);
  }
  return($codevalue);
}
// ----------------------------------------------------------.
加密的密碼
$salt = '11223344';
// 需要傳遞的陣列
$codevalue_array = array(
  'Amt' 			=> '111',
  'MerchantOrderNo' => 'ertgyhujioiuytre'
);
// 把包產生需要的資料
$send_code = jwtenc($salt,$codevalue_array);
var_dump($send_code);

// 把回傳回來的資料驗證解碼
$codevalue = jwtdec($salt,$send_code);
var_dump($codevalue);
