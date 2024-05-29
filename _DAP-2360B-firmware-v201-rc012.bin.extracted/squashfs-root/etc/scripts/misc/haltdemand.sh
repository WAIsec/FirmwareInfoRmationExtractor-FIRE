#!/bin/sh
echo [$0] ... > /dev/console
# Stop WLAN
/etc/templates/wlan.sh stop	> /dev/console
ifconfig ath0 down
# Stop WAN
/etc/templates/wan.sh stop	> /dev/console
# Stop UPNP ...
/etc/templates/upnpd.sh stop	> /dev/console
# Stop fresetd ...
killall fresetd
# Stop DNRD
#/etc/templates/dnrd.sh stop	> /dev/console
# Stop RG
#/etc/templates/rg.sh stop	> /dev/console
# Stop LAN
/etc/templates/lan.sh stop	> /dev/console
/etc/scripts/startburning.sh	> /dev/console
echo "Done ! Start burning ..."	> /dev/console

# sleep 30, to let wlan down!!!
sleep 30
