<?php
// ref:https://stackoverflow.com/questions/18336908/php-check-if-ip-address-is-in-a-range-of-ip-addresses
// 檢查某個 ip 是否在指定的 ip 範圍內
// We need to be able to check if an ip_address in a particular range
/*
// 使用範例
// lower_range_ip_address 管制 ip 的起始
// upper_range_ip_address 管制 ip 的結束
// needle_ip_address 用來檢測是否在範圍內的 ip
// 回傳布林值 true or false

$ipaddress_range_upper = '110.111.81.254';
$ipaddress_range_lower = '110.111.68.0';
$client_ip = $_SERVER['REMOTE_ADDR'];
// 限制的 ip 區間
var_dump(ip_in_range($ipaddress_range_lower, $ipaddress_range_upper, $client_ip));

if(ip_in_range($ipaddress_range_lower, $ipaddress_range_upper, $client_ip)){
        echo 'valid';
}else{
        die("not valid");
} 
*/

function ip_in_range($lower_range_ip_address, $upper_range_ip_address, $needle_ip_address)
{
	# Get the numeric reprisentation of the IP Address with IP2long
	$min    = ip2long($lower_range_ip_address);
	$max    = ip2long($upper_range_ip_address);
	$needle = ip2long($needle_ip_address);

	# Then it's as simple as checking whether the needle falls between the lower and upper ranges
	return (($needle >= $min) AND ($needle <= $max));
}

?>
