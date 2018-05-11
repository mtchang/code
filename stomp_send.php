<?php
// 傳送訊息的 STOMP 範例, Broker 使用 Apache apollo
$user = getenv("APOLLO_USER"); 
if( !$user ) $user = "帳號";
$password = getenv("APOLLO_PASSWORD");
if( !$password ) $password = "密碼";
$host = getenv("APOLLO_HOST");
if( !$host ) $host = "STOMP主機";
$port = getenv("APOLLO_PORT");
if( !$port ) $port = 61613;
# topic通道
$destination  = '/topic/chat.general.demo';
# 訊息內容
$message_body = 'test_'.date(DATE_RFC2822);

try {
  $url = 'tcp://'.$host.":".$port;
  $stomp = new Stomp($url, $user, $password);
  $stomp->send($destination, $message_body);
//  $stomp->send($destination, "SHUTDOWN");

} catch(StompException $e) {
  echo $e->getMessage();
}

?>
