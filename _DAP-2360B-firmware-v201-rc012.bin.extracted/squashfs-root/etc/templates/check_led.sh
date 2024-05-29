#!/bin/sh
#Program:
#          this script is to refresh the node value of led
#2012.8.24    christian

rgdb -i -s /runtime/stats/wireless/led11g 0
rgdb -i -s /runtime/stats/wireless/led11a 0
ath_sum=`ifconfig | grep ath | scut -n 1 | wc -l`
i=1
while [ $i -le "${ath_sum}" ]
do
  ath_name=`ifconfig | grep ath | scut -n 1 | sed -n "${i} p"`
  case $ath_name in
    ath0|ath1|ath2|ath3|ath4|ath5|ath6|ath7)
     rgdb -i -s /runtime/stats/wireless/led11g 1
    ;;
    ath16|ath17|ath18|ath19|ath20|ath21|ath22|ath23)
     rgdb -i -s /runtime/stats/wireless/led11a 1
    ;;
  esac
i=`expr $i + 1`
done

