#!/bin/bash
# by mtchang 2020.08.08 update
# This script is used to check and update your GoDaddy DNS server to the IP address of your current internet connection.

domain="網域"                  # your domain
type="A"                      # Record type A, CNAME, MX, etc.
name="網域名稱"                # name of record to update
key="GODADDY的KEY"            # key for godaddy developer API
secret="GODADDY的密碼"        # secret for godaddy developer API

headers="Authorization: sso-key ${key}:${secret}"
DNSSERVER="1.1.1.1"
thistime=$(date)

echo '' > curl_result.tmp
echo "/usr/bin/curl -s -X GET -H '${headers}' 'https://api.godaddy.com/v1/domains/${domain}/records/${type}/${name}'" | sh> curl_result.tmp
dnsIp=$(cat curl_result.tmp | cut -d, -f1 | cut -d: -f2 | cut -d'"' -f2)

# from dns ip
# dnsIp=$(host ${name}.${domain} ${DNSSERVER} | grep ${name} | cut -d' ' -f4)

echo '' > curl_result.tmp
echo "/usr/bin/curl -s GET 'https://ifconfig.me'" | sh > curl_result.tmp
currentIp=$(cat curl_result.tmp )

mesg_ipinfo="HOSTIP: $currentIp  DNSIP: $dnsIp "


if [ -n "${dnsIp}" ] && [ -n "${currentIp}" ]; then

if [ ${dnsIp} != ${currentIp} ]; then
 mesg="IP's are not equal, updating record $currentIp"
 curl -X PUT "https://api.godaddy.com/v1/domains/$domain/records/$type/$name" \
 -H "accept: application/json" \
 -H "Content-Type: application/json" \
 -H "$headers" \
 -d "[ { \"data\": \"$currentIp\"  }]" 
fi

if [ ${dnsIp} = ${currentIp} ]; then
  mesg='IP are equal, no update required'
fi

fi
echo "$thistime ,$mesg_ipinfo , $mesg , v1"



# 可以排程下去跑
#jangmt@blockchain-gateway:~$ crontab -e
# m h  dom mon dow   command
#10 * * * * /home/jangmt/ddns/ddns_update.sh >> /home/jangmt/ddns/ddns_update.log
#
#jangmt@blockchain-gateway:~$ ./ddns/ddns_update.sh 
#Sat 08 Aug 2020 09:17:54 PM CST ,HOSTIP: 1.14.172.205  DNSIP: 1.14.172.205  , IP are equal, no update required , v1


