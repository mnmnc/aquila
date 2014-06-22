#!/bin/bash

ip_address=$1;


traceroute -A -q 1 -n -w 2 -f 2 $ip_address > /tmp/$$_full.tmp
title=$(cat /tmp/$$_full.tmp | head -1 | cut -d " " -f 3-4 | tr -d ",");
hop_count=$(cat /tmp/$$_full.tmp | grep -v "traceroute" | grep " ms" | wc -l);
echo "999  $title $hop_count  0 ms" > /tmp/$$.tmp

cat /tmp/$$_full.tmp | tail -n +2   >> /tmp/$$.tmp

log=$(cat /tmp/$$_full.tmp | tr "\n" "^");
echo "log|$log";
while read line;
do
    id=$(echo "$line" | sed 's/  /\|/g' | cut -d "|" -f 1);
    middle=$(echo "$line" | sed 's/  /\|/g' | cut -d "|" -f 2);
    ip=$(echo "$middle" | cut -d " " -f 1);
    as=$(echo "$middle" | cut -d " " -f 2);
    delay=$(echo "$line" | sed 's/  /\|/g' | cut -d "|" -f 3| cut -d " " -f 1);
    
    if [[ $ip != "*" ]];
    then
        echo -e "$id|$ip|$as|$delay";
    else
        echo -e "$id|UNREACHABLE";
    fi
done < /tmp/$$.tmp

rm /tmp/$$.tmp
rm /tmp/$$_full.tmp