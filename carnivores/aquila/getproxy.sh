#!/bin/bash

 if [ "$1" == "" ]
 then
  echo ""
  echo SYNOPSIS
  echo " "usage $0 output_file [hide_my_ass_post]
  echo ""
  echo OPTIONS
  echo " "output_file - name of the output file \( '-' for stdout\)
  echo " "hide_my_ass_post - POST data defining the search
  echo ""
  echo NOTES
  echo " "If hide_my_ass_post is not defined, default POST value is
  echo " "used. That is china proxies, socks4/5, at least low anonimity, fast
  echo " "and no planetlab.
  exit
 fi

 #get output file name
 FILENAME="$1"

 #get POST data
 if [ "$2" == "" ]
 then
 #c[]=China&c[]=Indonesia&c[]=Venezuela&c[]=Brazil&c[]=Thailand&c[]=Russian+Federation&c[]=Iran&c[]=Kazakhstan&c[]=Ukraine&c[]=India&c[]=Turkey&c[]=Colombia&c[]=Argentina&c[]=Germany&c[]=Peru&c[]=Ecuador&c[]=Bangladesh&c[]=Egypt&c[]=France&c[]=Chile&c[]=Japan&c[]=Hong+Kong&c[]=Iraq&c[]=Korea%2C+Republic+of&c[]=Nigeria&c[]=Moldova%2C+Republic+of&c[]=United+Kingdom&c[]=Pakistan&c[]=Czech+Republic&c[]=South+Africa&c[]=Honduras&c[]=Serbia&c[]=Hungary&c[]=Taiwan&c[]=Bulgaria&c[]=Taiwan&c[]=United+Arab+Emirates&c[]=Viet+Nam&c[]=Cambodia&c[]=Malaysia&c[]=Spain&c[]=Saudi+Arabia&c[]=Slovakia&c[]=Canada&c[]=Kenya&c[]=Latvia&c[]=Philippines&c[]=Netherlands&c[]=Afghanistan&c[]=Albania&c[]=Italy&c[]=Mexico&c[]=Paraguay&c[]=Romania&c[]=Singapore&c[]=Costa+Rica&c[]=Macedonia&c[]=Uzbekistan&c[]=Azerbaijan&c[]=Cameroon&c[]=Bosnia+and+Herzegovina&c[]=Australia&c[]=Mongolia&c[]=Ireland&c[]=Austria&c[]=Namibia&c[]=Tajikistan&c[]=Lithuania&c[]=Finland&c[]=Slovenia&c[]=Zaire&c[]=Rwanda&c[]=Nepal&c[]=Trinidad+and+Tobago&c[]=Ghana&c[]=Maldives&c[]=Brunei+Darussalam&c[]=Bolivia&c[]=Armenia&c[]=Croatia&c[]=Belarus&c[]=Tanzania%2C+United+Republic+of&c[]=Sweden&c[]=Lebanon&c[]=Netherlands+Antilles&p=&pr[]=0&pr[]=1&pr[]=2&a[]=2&a[]=3&a[]=4&sp[]=3&ct[]=2&ct[]=3&s=0&o=0&pp=2&sortBy=date
  #POST="c[]=China&p=&pr[]=2&a[]=1&a[]=2&a[]=3&a[]=4&sp[]=3&ct[]=3&s=0&o=0&pp=2&sortBy=date"

 # HTTP / HTTPS / ANY PORT /  HIGH ANON / MEDIUM + FAST
  POST="c[]=China&c[]=United States&c[]=Venezuela&c[]=Indonesia&c[]=Brazil&c[]=Kazakhstan&
        c[]=Russian Federation&c[]=Iran&c[]=Colombia&c[]=Ukraine&c[]=Thailand&c[]=Germany&
        c[]=Netherlands&c[]=Poland&c[]=Argentina&c[]=Czech Republic&c[]=Bangladesh&c[]=Korea, Republic of
        &c[]=France&c[]=Ecuador&c[]=Iraq&c[]=Peru&c[]=Spain&c[]=Viet Nam&c[]=Moldova, Republic of
        &c[]=United Kingdom&c[]=Turkey&c[]=Taiwan&c[]=Hong Kong&c[]=Chile&c[]=Japan&c[]=Bulgaria
        &c[]=Kenya&c[]=Taiwan&c[]=United Arab Emirates&c[]=Malaysia&c[]=India&c[]=Egypt&c[]=Ghana
        &c[]=Macedonia&c[]=Saudi Arabia&c[]=Hungary&c[]=Canada&c[]=Cambodia&c[]=Italy&c[]=Honduras
        &c[]=Serbia&c[]=Philippines&c[]=Romania&c[]=Bosnia and Herzegovina&c[]=Croatia
        &c[]=Albania&c[]=Jordan&c[]=Mexico&c[]=Tanzania, United Republic of&c[]=Nepal&c[]=Pakistan
        &c[]=Latvia&c[]=Slovenia&c[]=Austria&c[]=Greece&c[]=South Africa&c[]=Iceland&c[]=Costa Rica&c[]=Zambia
        &c[]=Luxembourg&c[]=Macao&c[]=Belgium&c[]=Slovakia&c[]=Netherlands Antilles&c[]=Ireland&c[]=Lithuania
        &c[]=Belarus&c[]=Cyprus&c[]=Nigeria&c[]=Australia&c[]=El Salvador&c[]=Mongolia&c[]=Norway&c[]=Georgia
        &c[]=Afghanistan&c[]=Armenia&c[]=Turkmenistan&p=&pr[]=0&pr[]=1&a[]=3&a[]=4&sp[]=2&sp[]=3&ct[]=2&ct[]=3&s=0&o=0&pp=2&sortBy=date"
#  POST="c[]=China&c[]=Indonesia&c[]=Venezuela&c[]=Brazil&c[]=Thailand&c[]=Russian+Federation&c[]=Iran&c[]=Kazakhstan&c[]=Ukraine&c[]=India&c[]=Turkey&c[]=Colombia&c[]=Argentina&c[]=Germany&c[]=Peru&c[]=Ecuador&c[]=Bangladesh&c[]=Egypt&c[]=France&c[]=Chile&c[]=Japan&c[]=Hong+Kong&c[]=Iraq&c[]=Korea%2C+Republic+of&c[]=Nigeria&c[]=Moldova%2C+Republic+of&c[]=United+Kingdom&c[]=Pakistan&c[]=Czech+Republic&c[]=South+Africa&c[]=Honduras&c[]=Serbia&c[]=Hungary&c[]=Taiwan&c[]=Bulgaria&c[]=Taiwan&c[]=United+Arab+Emirates&c[]=Viet+Nam&c[]=Cambodia&c[]=Malaysia&c[]=Spain&c[]=Saudi+Arabia&c[]=Slovakia&c[]=Canada&c[]=Kenya&c[]=Latvia&c[]=Philippines&c[]=Netherlands&c[]=Afghanistan&c[]=Albania&c[]=Italy&c[]=Mexico&c[]=Paraguay&c[]=Romania&c[]=Singapore&c[]=Costa+Rica&c[]=Macedonia&c[]=Uzbekistan&c[]=Azerbaijan&c[]=Cameroon&c[]=Bosnia+and+Herzegovina&c[]=Australia&c[]=Mongolia&c[]=Ireland&c[]=Austria&c[]=Namibia&c[]=Tajikistan&c[]=Lithuania&c[]=Finland&c[]=Slovenia&c[]=Zaire&c[]=Rwanda&c[]=Nepal&c[]=Trinidad+and+Tobago&c[]=Ghana&c[]=Maldives&c[]=Brunei+Darussalam&c[]=Bolivia&c[]=Armenia&c[]=Croatia&c[]=Belarus&c[]=Tanzania%2C+United+Republic+of&c[]=Sweden&c[]=Lebanon&c[]=Netherlands+Antilles&p=&pr[]=0&pr[]=1&pr[]=2&a[]=2&a[]=3&a[]=4&sp[]=3&ct[]=2&ct[]=3&s=0&o=0&pp=2&sortBy=date"

 else
  POST="$2"
 fi

 #wget page
 PAGE1=$(wget -O- -q --post-data="$POST" http://hidemyass.com/proxy-list/)
 #
 #magic begins
 #

 #find containers with {display:none}
 NONE_CONTAINERS=$(echo $PAGE1 | tr '.' '\n' | tr ' ' '\n' | grep "{display:none}")

 #add inline display:none to containers
 for var in $NONE_CONTAINERS
 do
  ID=$(echo "$var" | sed 's/{.*}//')
  PAGE1=$(echo "$PAGE1" | sed "s/class=\"$ID\"/style=\"display:none\"/g")
 done

 #remove display:none containers
 PAGE1=$(echo "$PAGE1" | sed 's/<span style="display:none"[^\/]*\/span>//g')
 PAGE1=$(echo "$PAGE1" | sed 's/<div style="display:none"[^\/]*\/div>//g')

 #finally this fucking nightmarish page is ready
 echo "$PAGE1" > hidemyass_tmp_file
 TEXT_OUTPUT=$(links -dump hidemyass_tmp_file)
 rm hidemyass_tmp_file

 #get lines with proxies
 PROXY_LINES=$(echo "$TEXT_OUTPUT" | egrep "[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+[ ]+[0-9]+")

 #get proxies
 FORMATED_PROXIES=$(echo "$PROXY_LINES" | sed 's/.* \([0-9]\+\.[0-9]\+\.[0-9]\+\.[0-9]\+[ ]\+[0-9]\+\).*/\1/' | sed 's/[ ]\+/:/g')

 #results
 if [ "$FILENAME" == "-" ]
 then
  echo "$FORMATED_PROXIES"
 else
  echo "$FORMATED_PROXIES" > "$FILENAME"
 fi