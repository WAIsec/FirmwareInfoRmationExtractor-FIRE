#!/bin/sh
echo [$0] ... > /dev/console
<? /* vi: set sw=4 ts=4: */
$captival_url_state = query("/captival/url_state");
$captival_state=0;
for("/wlan/inf")
{	
	if(query("captival/state") != 0)
	{
		$captival_state++;
	}	
}

for( "/wlan/inf:1/multi/index")
{
	if(query("captival/state") != 0 )
	{
		$captival_state++;
	}		
}

for( "/wlan/inf:2/multi/index")
{
	if(query("captival/state") != 0 )
	{
		$captival_state++;
	}		
}

if ($generate_start == 1)
{
	echo "echo captival_state ".$captival_state." captival_url_state ".$captival_url_state."\n";
    if($captival_url_state == 1 || $captival_state > 0)
    {
        echo "echo captival portal is enable \n";
        echo "rm -rf /var/captival \n";
        echo "cp -rf /usr/local/etc/captival /var/ \n";
        echo "cd /var/captival \n";
        echo "./captival_portal & \n";
        echo "cd / \n";
    }
    else
    {
        echo "echo captival portal is disable \n";
    }

}
else
{
    $start = query("/runtime/captival/start");
    if($start == 1)
    {
        echo "echo stop captival portal \n";
        echo "rgdb -is /runtime/captival/start 0 \n";
        echo "killall captival_portal \n";
        echo "rm -rf /var/captival \n";
        echo "brctl captival_portal_mode br0 0 \n"
	echo "sleep 1 \n"
    }
    else
    {
        echo "echo captival portal  already stop \n";
    }
}
?>
