#!/bin/bash

if [[ $1 == "" || $2 == "" ]]; 
then
	echo "NULL"
	exit
else
    IP=$1
    PROXY=$2
    page=$(curl -s -m 10 -D - -x $PROXY -A "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36" "http://whatismyipaddress.com/ip/$IP")
    if [[ ${#page} -lt 10 ]];
    then
        page=$(curl -s -m 30 -D - -x $PROXY -A "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36" "http://whatismyipaddress.com/ip/$IP")
    fi
    if [[ ${#page} -lt 10 ]];
    then
        page=$(curl -s -m 60 -D - -x $PROXY -A "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36" "http://whatismyipaddress.com/ip/$IP")
    fi
    if [[ ${#page} -lt 200 ]];
    then
        echo -n "-|-|-|-|-|-";
        exit;
    fi
    httpCheck=0;
    if [[ "$page" != "" && "$page" != null ]];
    then
    	httpCheck=$(echo "$page" | head -1 | grep "200" | wc -l )
    fi
    if  [[ $httpCheck -ne 0 ]]
    then
        wafCheck=$(echo "$page" | grep "Too many queries" | wc -l)
        wafCheck_2=$(echo "$page" | grep "For API details see" | wc -l)
        if [[ $wafCheck -ne 0 || $wafCheck_2 -ne 0 ]];
        then
            echo -n "-|-|-|-|-|-";
        else
            full=$(echo "$page" | grep -A 15 "id=\"General-IP-Information\"" | tr ">" "\n")
            latitude=$(echo "$full" | grep -A 3 "Latitude:" | tail -1 | cut -d "<" -f 1 | cut -d "&" -f 1)
            longitude=$(echo "$full" | grep -A 3 "Longitude:" | tail -1 | cut -d "<" -f 1 | cut -d "&" -f 1)
            hostname=$(echo "$full" | grep -A 2 "Hostname:" | tail -1 | cut -d "<" -f 1)
 	    country=$(echo "$full" | grep -A 2 "Country:" | tail -1 | cut -d "<" -f 1)
	    city=$(echo "$full" | grep -A 2 "City:" | tail -1 | cut -d "<" -f 1 )
            echo -n "$latitude|$longitude|$hostname|$country|$city|$IP";
        fi
    else
        echo -n "-|-|-|-|-|-";
    fi
fi

