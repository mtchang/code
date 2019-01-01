#!/bin/bash
# This script is used to check and update your GoDaddy DNS server to the IP address of your current internet connection.
# Special thanks to mfox for his ps script
# https://github.com/markafox/GoDaddy_Powershell_DDNS
# First go to GoDaddy developer site to create a developer account and get your key and secret
# https://developer.godaddy.com/getstarted
# Be aware that there are 2 types of key and secret - one for the test server and one for the production server
# Get a key and secret for the production server
# Enter vaules for all variables, Latest API call requries them.
#
# 文件參考及改寫： https://developer.godaddy.com/doc/endpoint/domains
# by mtchang 2019.1.2 update

domain="網域"                       # your domain
type="A"                                    # Record type A, CNAME, MX, etc.
name="網域名稱"                            # name of record to update
key="GODADDY的KEY"            # key for godaddy developer API
secret="GODADDY的密碼"         # secret for godaddy developer API

headers="Authorization: sso-key $key:$secret"
#echo $headers

result=$(curl -s -X GET -H "$headers" \
 "https://api.godaddy.com/v1/domains/$domain/records/$type/$name")

dnsIp=$(echo $result | grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b")
echo "dnsIp:" $dnsIp

# Get public ip address there are several websites that can do this.
ret=$(curl -s GET "http://ipinfo.io/json")
#echo $ret
currentIp=$(echo $ret | grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}\b")
 echo "currentIp:" $currentIp

if [ $dnsIp != $currentIp ];
then

# 送出 curl 到 api 
echo "IP's are not equal, updating record"
curl -X PUT "https://api.godaddy.com/v1/domains/$domain/records/$type/$name" \
-H "accept: application/json" \
-H "Content-Type: application/json" \
-H "$headers" \
-d "[ { \"data\": \"$currentIp\"  }]" 
fi

if [ $dnsIp = $currentIp ];
 then
      echo 'IP are equal, no update required'
fi

