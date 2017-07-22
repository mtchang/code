<?php
# OpenCart2 的密碼編碼方式
# https://stackoverflow.com/questions/25042558/opencart-customer-password-encryption

# A 主機存放 salt
$salt = 'uv22W76dk';
# 使用者 sha1 加密過後的原始密碼
$sha1data_password = 'b2dc4af359e14ccba85566f9523f4cf23537a34b';


#$salt = substr(md5(uniqid(rand(), true)), 0, 9);
# 使用者密碼配合 $salt 產生 $password
$password = sha1($salt . sha1($salt . $sha1data_password));

echo '使用者輸入的密碼'.$sha1data_password;
echo "\n";
echo 'SALT'.$salt;
echo "\n";
echo '即時計算出來的密碼'.$password;
echo "\n";
echo '資料庫中的密碼 ec5f828c2349b575803611bcf57f2d77f265b3ec';
?>
