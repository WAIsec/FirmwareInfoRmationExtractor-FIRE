<?
$check_band=query("/wlan/inf:2/ap_mode");
$runtime_ipv6=query("/runtime/web/display/ipv6");    
$cfg_ipv6=query("/inet/entry:1/ipv6/valid");
$head_bsc = "基本设置";

$title_bsc_cloud = "Cloud Manager";
$bsc_cloud_msg = "Enable this option allows this AP controlled by internet cloud management server. To configure and view your cloud APs, please log in at http://dlink.cloudcommand.com.";

$title_bsc_wlan ="无线设置";
$bsc_wlan_msg ="为一个现有网络或创建一个新的网络更新设备上的无线设置。";
$bsc_wireless_band ="无线频段";
if($check_band == "")
{
	$bsc_wireless_band_msg ="此为可选频段。该接入点(AP)运行在2.4GHz。2.4GHz与原有设备工作正常且适用于较长范围。";
}
else
{
	$bsc_wireless_band_msg ="此为可选频段。该接入点(AP)运行在2个频段，2.4GHz和5GHz。"."2.4GHz与原有设备工作正常且适用于较长范围。选择5GHz以获得最少的干扰和最佳的性能。";
}
$bsc_application="应用程序";
$bsc_application_msg="该选项允许用户选择在5G频段的室内或室外模式。";
$bsc_mode = "模式";
if($cfg_ipv6=="1")
{
	$bsc_mode_msg = "在接入点，带AP的无线分布系统(WDS），WDS或无线客户端模式(仅支持IPv4)几种模式中选择一种。";
}
else
{
$bsc_mode_msg = "在接入点，带AP的无线分布系统(WDS），WDS或无线客户端模式几种模式中选择一种。";
}
if($TITLE=="DAP-2310")
{
    $bsc_mode_msg = "在接入点，带AP的无线分布系统(WDS），WDS，无线客户端模式(仅支持IPv4)或AP中继器模式几种模式中选择一种。";
}
$bsc_network_name = "网络名称/服务设置标识码(SSID)";
$bsc_network_name_msg = "SSID出厂默认设备为\"dlink\"。更改SSID以连接到现有无线网络或新建一个新的无线网络。";
$bsc_ssid_visibility = "SSID可视";
$bsc_ssid_visibility_msg = "SSID可视信号默认情况为启用。选择禁用使接入点对于所有客户端设备不可见。";
$bsc_auto_channel="自动选择信道";
$bsc_auto_channel_msg="默认为启用，当设备重新启动，则自动搜索最佳可用信道。";
$bsc_channel="信道";
$bsc_channel_msg ="自动频道选择设置为默认。频道设置能被配置与现有无线网络工作或客制化一个新的无线网络。";
$bsc_channel_width="信道宽度";
if($check_band == "")
{
	$bsc_channel_width_msg="设置信道带宽。802.11n和非802.11n无线设备使用20MHz和自动20/40MHz。"."为2.4GHz频段连接混合802.11b/g/n。当使用自动20/40MHz信道设置，数据可使用40MHz传输。";
}
else
{
	$bsc_channel_width_msg="设置信道带宽。802.11n和非802.11n无线设备使用20MHz和自动20/40MHz。"."为2.4GHz频段连接混合802.11b/g/n，为5GHz频段连接混合802.11a/n。为802.11ac和非802.11ac无线设备配置自动20/40/80 MHz，"."为5GHz频段连接混合802.11ac。当使用自动20/40MHz信道设置，数据可使用40MHz传输，"."当使用自动20/40/80MHz，数据可使用80MHz传输。";
}
$bsc_captive_profile="强制配置文件";
$bsc_captive_profile_msg="此为首选SSID的前端认证方式。当在强制网站设置页面自定义后，将绑定一个强制网站策略配置到首选SSID。";
$bsc_authentication="验证";
$bsc_authentication_msg="开放系统为默认认证模式。选择数据加密方式以启用加密。";
$bsc_open_sys="开放系统";
$bsc_open_sys_msg="所有设备都被允许访问到接入点。";
$bsc_shared_key="共享密钥";
$bsc_shared_key_msg="用户必须使用相同的WEP共享密码访问在该网络上的无线接入点。";
$bsc_personal_type="WPA-个人用户/WPA2-个人用户/WPA-自动-个人用户";
$bsc_personal_type_msg="WPA(Wi-Fi保护访问）使用AES/TKIP加密以保护网络。WPA和WPA2个人版使用不同的算法。WPA自动 - 个人版同时使用WPA和WPA2认证。";
$bsc_periodrical_change_key="周期密钥更新";
$bsc_periodrical_change_key_msg="定期密钥变更从设备被启用的时间开始定期生成一个随机的WPA密钥。邮件将发送关于当前密钥和周期密码变更信息到管理员。"; 
$bsc_enterprise_type="WPA-企业用户/ WPA2-企业用户/ WPA-自动-企业用户";
$bsc_enterprise_type_msg="在无线网络中使用Wi-Fi保护放许可和用户验证。WPA基于可定期自动更换的密钥，在安全性上要高于WEP。"."该模式要求网络中有RADIUS服务器运行。WPA和WPA2的算法不同，WPA-Auto模式下可以同时使用WPA和WPA2。";
$bsc_8021x_type="802.1x";
$bsc_8021x_type_msg="802.1x是一个在以太网和无线网络上使用的访问控制系统。将从服务器或交换机上自动生成一个密钥。为了使用802.1x，"."执行PAE并重新启动无线接入点。然后AP将认证到一台RADIUS服务器，本地服务器或交换机。从加密菜单中选择其中一项以创建验证序列号和生成密钥。";
$bsc_network_access="网络访问保护";
$bsc_network_access_msg="网络访问保护(NAP)是一个Windows服务器2008的功能。NAP基于一台客户端计算机的标识控制访问到网络的资源，并符合相关政策。"."NAP允许网络管理员定义网络访问的粒度等级，基于客户端，客户端属于哪个群组及客户端符合哪种策略的程度。如果客户端不兼容，"."NAP将提供一个机制以自动将客户端向后兼容，然后动态提高它的网络访问级别。";
$bsc_mac_clone = "MAC克隆";
$bsc_mac_clone_msg = "为配置成APC模式的AP分配一个mac地址，作为网卡和其它AP进行通信。"."如果选择“手动”，您可以输入任何地址或在扫描列表中选择一个地址，“自动”表示分配AP检测到的第一个mac地址。";

$title_bsc_lan = "LAN设置";
$title_bsc_lan_msg = "默认IP地址为192.168.0.50，子网掩码为255.255.255.0。或者使用所给的参数来配置LAN设置。";
$bsc_get_ip_from = "获取IP地址从";
$bsc_get_ip_from_msg = "默认为静态IP。手动设置IP地址。为主机启用动态IP(DHCP)以自动分配IP地址。";
$bsc_ip_address = "IP地址";
$bsc_ip_address_msg = "默认IP地址为192.168.0.50。配置连接到AP的无线客户端在同一IP地址和子网掩码范围内。IP地址范围可以从1到254。";
$bsc_submask = "子网掩码";
$bsc_submask_msg = "子网掩码决定一个IP地址属于哪个子网。默认子网掩码为255.255.255.0。";
$bsc_gateway = "默认网关";
$bsc_gateway_msg = "默认网关为外部IP地址网络所使用。它由您的ISP或网络管理员提供。";
$bsc_dns = "DNS";
$bsc_dns_msg = "域名系统将域名转换为IP地址，例如dlink.com，其是计算机在网络上互相识别的标识。";
$title_bsc_ipv6 = "IPv6 LAN设置";
$title_bsc_ipv6_msg = "IPv6是IPv4的新一代IP协议。它指定数据包和地址的格式";
$bsc_get_ip_from_msg_ipv6 = "IPv6默认设置为自动。选择静态以手动配置IP地址。";
$bsc_ip_address_msg_ipv6 = "配置IPv6地址。IPv6被 \":\"分成8段。每段有4个字符： 0~9或 A~F。";
$bsc_prefix = "前缀";
$bsc_prefix_msg = "前缀介于0-128并且确定IP地址属于哪个子网。";
$bsc_dns_ipv6 = "DNS";
$bsc_dns_ipv6_msg = "DNS用于解析IP地址。";
$bsc_gateway_ipv6_msg = "为本地网络指定网关地址。";


$head_adv ="高级设置";

$title_adv_per = "性能";
$title_adv_per_msg = "通过转换无线参数自定义网络无线设置。此章节适合于熟悉802.11无线网络和无线设置的高级用户使用。";
$adv_wireless = "无线";
$adv_wireless_msg ="启用或禁用无线。";
$adv_wireless_mode ="无线模式";
if($TITLE=="DAP-1353" || $TITLE=="DAP-2360" || $TITLE=="DWP-2360")
{
$adv_wireless_mode_msg ="选择无线模式。当启用延伸无线模式 (802.11g/b)，".query("/sys/hostname")."向后兼容。预计802.11n无线优化将被降级。";
}
else
{
$adv_wireless_mode_msg ="选择无线模式。当启用延伸无线模式 (802.11a/g/b)，".query("/sys/hostname")."向后兼容。预计802.11n无线优化将被降级。";
}

$adv_date_rate="数据速率";
$adv_date_rate_msg="显示在无线本地局域网络的基准传输速率。AP基于被连接的设备性能调整传输速率。阻碍产生的干扰将影响性能。";
$adv_beacon = "信标间隔(40-500)";
$adv_beacon_msg = "信标是由接入点发出用于同步无线网络的数据包。设置较高的信标间隔有助于无线客户端的节能，当信标间隔设置较低时，"."有助于提高无线客户连AP的速率。对多数用户，建议设置为100毫秒。";
$adv_dtim="DTIM间隔(1-15)";
$adv_dtim_msg="默认DTIM时间间隔值为1.DTIM时间间隔指定每个投递传输指示信息（DTIM）之间的AP信标的数量。"."它通知相关的站点下一次侦听广播和组播信息的视窗。您可以指定一个DTIM值范围从1到15。如果有缓冲的广播或组播消息时，"."AP将发送下一次DTIM带有指定DTIM值到站点。站点侦听到信标并准备接收广播和组播消息。";
$adv_transmit_power="传输功率";
$adv_transmit_power_msg="决定无线传输功率等级。调整功率等级可消除介于两台无线接入点的无线覆盖范围的重迭。"."默认为100%，50%(-3dB), 25%(-6dB)和12.5% (-9dB) 也可用。例如，选择50%则覆盖一半的无线范围。";
$adv_wmm="WMM (Wi-Fi多媒体)";
$adv_wmm_msg="Wi-Fi多媒体特性可让用户更好地享受Wi-Fi网络中音频、视频和声音应用程序带来的体验。"."WMM是基于IEEE 802.11e无线QoS标准的子集。启用该功能可以让用户更好地享受Wi-Fi网络中音频、视频和声音应用程序带来的体验。";
$adv_ack_timeout="Ack超时";
if(query("/runtime/web/display/ack_timeout_range")=="0")
{
	if($check_band == "")
	{
		$adv_ack_timeout_msg="针对2.4GHz指定一个基于范围从48-200的ACK超时值。"."这将优化长距离的连接吞吐量。ACK超时的单位为微秒(&micro;s)。针对2.4GHz为48&micro;s。";
	}
	else
	{
		$adv_ack_timeout_msg="针对2.4GHz指定一个基于范围从48-200的ACK超时值,并且针对5GHz为25-200。"."这将优化长距离的连接吞吐量。ACK超时的单位为微秒(&micro;s)。针对2.4GHz为48&micro;s，针对5GHz为25 &micro;s 。";
	}
	
}
else
{
	if($check_band == "")
	{
		$adv_ack_timeout_msg="针对2.4GHz指定一个基于范围从64-200的ACK超时值。这将优化长距离的连接吞吐量。"."ACK超时的单位为微秒(&micro;s)。针对2.4GHz为64&micro;s。";
	}
	else
	{
		$adv_ack_timeout_msg="针对2.4GHz指定一个基于范围从64-200的ACK超时值,并且针对5GHz为50-200。"."这将优化长距离的连接吞吐量。ACK超时的单位为微秒(&micro;s)。针对2.4GHz为64&micro;s，针对5GHz为50 &micro;s 。";
	}

}

$adv_short_gi="短时保护间隔";
$adv_short_gi_msg="400ns时间间隔的短时保护间隔将增加吞吐量。";
$adv_igmp="IGMP侦听";
$adv_igmp_msg="Internet组管理协议(IGMP)侦听允许AP辨认在路由器和IGMP主机(无>线STA)之间发送的IGMP请求和报告。"."当IGMP侦听启用时，如果有IGMP信息经过AP，那么AP会向IGMP主机转发组播数据包。";
if($check_band == "")
{
	$adv_igmp_msg2="如果IGMP侦听禁用，用户可从下拉菜单中手动选择组播速率。当IGMP侦听启用，"."组播速率将被禁用且运行在建议的速率下(11Mbps)，并且不能被手动选择。";
}
else
{
	$adv_igmp_msg2="如果IGMP侦听被禁用，用户能够从下拉菜单中手动选择组播速率。当IGM侦听启用，组播速率将禁用，"."且工作在建议速率下(2.4GHz为11Mbps且5GHz为6Mbps)，而且不能够被手动选择。";
}
$adv_link_integrality="链路聚合";
$adv_link_integrality_msg="链路聚合，当启用时，从AP上终止所有的无线客户端，LAN和AP之间的以太网连接将被断开。";
$adv_connection_limit="连接限制";
if(query("/runtime/web/display/utilization") !="0")
{
	$utilization_string="或是AP的网络利用率超过事先设定的百分比时，";
}
else
{
	$utilization_string=" ";
}
$adv_connection_limit_msg="连接限制将限制客户端连接到一台指定AP。";
$adv_user_limit ="用户限制(0-64)";
$adv_user_limit_msg ="设置用户访问到每一台接入点的限制数。建议为20。";
$adv_11n_preferred = "11n优先";
$adv_11n_preferred_msg = "11n优先给予802.11n用户优先，并最大限制达到时，将拒绝非802.11n客户端访问到AP。";
$adv_network_utilization="网络利用";
$adv_network_utilization_msg="该选项设置使用该接入点的最大网络利用率。当网络利用率值超出指定值，接入点将不允许新的无线 "."客户端连接到它。默认情况下，该值为100%。";
$adv_mcast_rate="多播速率";
if($check_band == "")
{
	$adv_mcast_rate_msg="组播速率调整组播数据包速率。组播速率支持2.4GHz频段的AP模式，多SSID和带AP的WDS模式。当组播速率禁用，"."设备将运行在建议的速率上(2.4GHz为11Mbps),并且不能被手动选择。当组播速率禁用，"."设备将运行在建议的速率上(2.4GHz为11Mbps),并且不能被手动选择。";
}
else
{
	$adv_mcast_rate_msg="组播速率调整组播数据包速率。组播速率支持2.4GHz和5GHz频段的AP模式，多SSID和带AP的WDS模式。当组播速率禁用，"."设备将运行在建议的速率上(2.4GHz为11Mbps且5GHz为6Mbps),并且不能被手动选择。当组播速率禁用，"."设备将运行在建议的速率上(2.4GHz为11Mbps且5GHz为6Mbps),并且不能被手动选择。";
}
$adv_mcast_control = "组播带宽控制";
$adv_mcast_control_msg = "组播带宽控制监测从以太网接口到".query("/sys/hostname")."的组播或广播数据包流量。它降低负载从而保护AP免受未知的攻击。当启用时，组播数据包如果超出了最大组播带宽，将被丢弃。";
$adv_bandwidth_rate = "最大组播带宽";
$adv_bandwidth_rate_msg = "设置组播数据包从以太网接口到接入点的通过速率的最大带宽。";
$adv_coexistence="HT20/40共存";
$adv_coexistence_msg="默认为开启，HT20/40共存监控频道。根据环境变化，它会在20MHz和20/40MHz转换。";

$title_adv_resource = "无线资源控制";
$title_adv_resource_msg = "无线资源控制是为熟悉802.11系统的高端用户使用。";
$adv_5g_preferred = "频段转换";
$adv_5g_preferred_msg = "频段转换在2.4G信号不够强的时间，允许站点转换它的连接至更强的5G信号。";
$adv_5g_preferred_age = "频段转换寿命";
$adv_5g_preferred_age_msg = "设置周期，单位为秒。";
$adv_5g_preferred_diff = "频段转换差";
$adv_5g_preferred_diff_msg = "频段转换差值相当于所连接的5GHz无线客户端的数量减去连接2.4GHz无线客户端的数量的一个差值。"."如果有更多的5GHz客户端尝试访问网络，则他们的连接将被转换到2.4GHz。";
$adv_5g_preferred_ref = "频段转换拒绝数量";
$adv_5g_preferred_ref_msg = "该选项指定当一台无线接入点尝试连接到5GHz频段时，将被该台接入点拒绝的最大次数。";
$adv_5g_preferred_rssi = "Band Steering RSSI";
$adv_5g_preferred_rssi_msg = "Specify the Band Steering RSSI percentage threshold limit. When a 2.4GHz connection is lower than the specified percentage limit the connection is bumped up to 5GHz.";
$adv_aging_out = "老化";
$adv_aging_out_msg = "老化将限制客户端耗尽RSSI或数据速率。";
$adv_rssi_thr = "RSSI阈值";
$adv_rssi_thr_msg = "指定RSSI阈值。";
$adv_data_rate_thr = "数据速率阈值";
$adv_data_rate_thr_msg = "指定数据速率阈值。";
$adv_acl_rssi = "ACL RSSI";
$adv_acl_rssi_msg = "ACL RSSI阻止来自客户端 的RSSI低的阀值的请求。";
$adv_acl_rssi_thr = "ACL RSSI阈值";
$adv_acl_rssi_thr_msg = "指定ACL RSSI阈值。";

$title_adv_mssid="多个SSID";
/*$title_adv_mssid_msg="Multiple SSIDs are only supported in AP mode. One primary SSID and at most seven guest SSIDs ".
"can be configured to allow virtual segregation stations which share the same channel.";*/
if(query("/runtime/web/display/mssid_index4")==1)
{
$title_adv_mssid_msg="多SSID限制在一个相同的信道上只能有1个首要SSID和3个访客SSID。";
}
else
{
$title_adv_mssid_msg="多SSID限制在一个相同的信道上只能有1个首要SSID和7个访客SSID。";
}
$adv_mssid_msg1="启用".query("/sys/hostname")." 的VLAN状态，则可以与VLAN设备通讯。";
$adv_mssid_msg6="0 -7 SSID，0为最低优先级，7为最高优先级。";
//$adv_mssid_msg2="When the Primary SSID is set to Open System without encryption, the Guest SSIDs can only be set to no encryption, WEP, WPA-Personal or WPA2-Personal.";
//$adv_mssid_msg3="When the Primary SSID's security is set to Open or Shared System WEP key, the Guest SSIDs can be set to use no encryption, use three other WEP keys, WPA-Personal, or WPA2-Personal.";
//$adv_mssid_msg4="When the Primary SSID's security is set to WPA-Personal, WPA2-Personal, or WPA-Auto-Personal, slot 2 and slot 3 are used. The Guest SSIDs can be set to use no encryption, WEP, or WPA-Personal.";
//$adv_mssid_msg5="When the Primary SSID's security is set to WPA-Enterprise, WPA2-Enterprise, or WPA-Auto-Enterprise, the Guest SSIDs can be set to use any security.";

$title_adv_vlan="VLAN";
$title_adv_vlan_msg=query("/sys/hostname")."支持VLAN。可使用名称和VID创建VLAN。由于为物理端口，Mgmt（TCP堆叠），LAN，首选/多个SSID和WDS连接都可以分配给VLAN。任何一个通过".query("/sys/hostname")."，没有打VLAN标记的数据包都会插入一个PVID的VLAN标记。";

$title_adv_intrusion="无线入侵保护";
$title_adv_intrusion_msg="设置无线入侵保护。";

$title_adv_scheduling="日程表";
$title_adv_scheduling_msg="设置".query("/sys/hostname")."的日程表日期或每周时间。";

$title_adv_qos="QoS";
$title_adv_qos_msg="QoS stands for Quality of Service for Wireless Intelligent Stream Handling, a technology developed to enhance the experience of using a wireless network by".
" prioritizing the traffic of different applications.";
$adv_enable_qoS="Enable QoS";
$adv_enable_qoS_msg="Enable this option if you want to allow QoS to prioritize your traffic.";
$adv_enable_qoS_msg1="Priority Classifiers.";
$adv_http="HTTP";
$adv_http_msg="Allows the access point to recognize HTTP transfers for many common audio and video streams and prioritize them above other traffic. Such".
" streams are frequently used by digital media players.";
$adv_automatic="Automatic";
$adv_automatic_msg="When enabled, this option causes the access point to automatically attempt to prioritize traffic streams that".
" it doesn't otherwise recognize, based on the behavior that the streams exhibit. This acts to de-prioritize streams that exhibit ".
"bulk transfer characteristics, such as file transfers, while leaving interactive traffic, such as gaming or VoIP, running at a normal priority.";
$adv_qos_rule="Qos Rules";
$adv_qos_rule_msg="A QoS Rule identifies a specific message flow and assigns a priority to that flow. For most applications, the priority classifiers ".
"ensure the right priorities and specific QoS Rules are not required.";
$adv_qos_rule_msg1="QoS supports overlaps between rules. If more than one rule matches a specific message flow, the rule with the highest priority will be used.";
$adv_name="Name";
$adv_name_msg="Create a name for the rule that is meaningful to you.";
$adv_priority="Priority";
$adv_priority_msg="The priority of the message flow is entered here. Four priorities are defined:";
$adv_priority_msg1="* BK: Background (least urgent).";
$adv_priority_msg2="* BE: Best Effort.";
$adv_priority_msg3="* VI: Video.";
$adv_priority_msg4="* VO: Voice (most urgent).";
$adv_protocol="Protocol";
$adv_protocol_msg="The protocol used by the messages.";
$adv_host_1_ip="Host 1 IP Range";
$adv_host_1_ip_msg="The rule applies to a flow of messages for which one computer's IP address ".
"falls within the range set here.";
$adv_host_1_port="Host 1 Port Range";
$adv_host_1_port_msg="The rule applies to a flow of messages for which host 1's port number is within the range set here.";
$adv_host_2_ip="Host 2 IP Range";
$adv_host_2_ip_msg="The rule applies to a flow of messages for which the other computer's IP address falls within the range set here.";   
$adv_host_2_port="Host 2 Port Range";
$adv_host_2_port_msg="The rule applies to a flow of messages for which host 2's port number is within the range set here.";
$title_adv_ap_array="AP Array";
$title_adv_ap_array_msg="An AP array is a set of Access Points connected to form a single-grouped network.";
$adv_enable_array="Enable Array"; 
$adv_enable_array_msg="Click the checkbox to enable AP Array. There are 3 modes: Master, Backup Master, and Slave. The Master AP controls all AP's associated to it. "."The Backup Master AP is what the name implies, backup to the Master AP. The Slave AP syncs with the Master AP and gets all its instructions from the Master AP.";
$adv_ap_array_name="AP Array Name";
$adv_ap_array_name_msg="Enter a username for the AP Array.";
$adv_ap_array_pwd="AP Array Password";
$adv_ap_array_pwd_msg="Enter a password for the AP Array.";
$adv_scan_ap_array_list="Scan AP Array List";
$adv_scan_ap_array_list_msg="Click this button to initiate a scan of all the available APs currently on the network.";
$adv_ap_array_list="AP Array List";
$adv_ap_array_list_msg="The AP Array List displays the array status.";
$adv_current_array_members="Current Array";
$adv_current_array_members_msg="The table displays a list of all AP's within the array.";
$adv_syn_parameters="Synchronized Parameters";
$adv_syn_parameters_msg="Select parameters associated to the AP Array. Click Clear All to clear all synchronized parameters.";

$title_adv_url="Web Redirection";
$title_adv_url_msg="";
$adv_enable_web = "Enable Web Redirection";
$adv_enable_web_msg = "Click to enable Web Redirection.";
$adv_web_site = "Web Site";
$adv_web_site_msg = "Enter a domain name or IP address.";
$adv_enable_auth = "Enable Web Authentication";
$adv_enable_auth_msg = "Click to enable Web Authentication.";
$adv_enable_url="Enable Web Redirection";
$adv_enable_url_msg="This check box allows the user to enable the Web Redirection function.";
$adv_url_username="User Name";
$adv_url_username_msg="Enter a username to authenticate Web Redirection.";
$adv_url_password="Password";
$adv_url_password_msg="Enter a password to authenticate Web Redirection.";
$adv_url_status="Status";
$adv_url_status_msg="Enable or Disable Web Redirection.";
$adv_url_account_list="Web Redirection Account List";
$adv_url_account_list_msg="Enable Web Redirection, enter a Username and Password under Add Web Redirection, and click Save. The new entry appears in the Web Redirection list. "
."Click the username to edit the account, and use the Enable/Disable radio button to edit Web Redirection. Click the icon to delete the current Web Redirection account.";

$title_adv_int_radius_server="内部RADIUS服务器";
$title_adv_int_radius_server_msg=query("/sys/hostname")."支持内置的RADIUS服务器。";
$adv_user_name="用户名";
$adv_user_name_msg="为登入服务器用户输入用户名。";
$adv_pwd="密钥"; 
$adv_pwd_msg="为鉴别登入服务器的用户输入密钥。";
$adv_status="状态";
$adv_status_msg="使用下拉框启用/禁用内部RADIUS服务器。";
$adv_radius_account_list="RADIUS条目列表";
$adv_radius_account_list_msg="启用RADIUS服务器，输入用户名称和密码以添加一个RADIUS账户，然后单击保存。"."新的条目将显示在RADIUS列表中。单击用户名称以编辑此帐户，使用启用/禁用按钮以编辑RADIUS账户。单击垃圾桶图标删除当前RADIUS账户。";

$title_adv_arp_spoofing="ARP欺骗预防";
$title_adv_arp_spoofing_msg="ARP欺骗防御通过添加IP或MAC地址图表，以检测ARP欺骗攻击。";
$adv_arp_spoofing="ARP欺骗预防";
$adv_arp_spoofing_msg="单击勾选框以启用ARP欺骗防御。";
$adv_gateway_ip="网关IP地址";
$adv_gateway_ip_msg="输入一个网关IP地址。";
$adv_gateway_mac="网关MAC地址";
$adv_gateway_mac_msg="输入一个网关MAC地址。";

$title_adv_fair_air_time = "带宽优化";
$title_adv_fair_air_time_msg = "带宽优化功能允许用户管理接入点的总的上行和下行带宽。它也允许用户在每个SSID之间使用不同的分配方式平衡负载。";
$adv_downlink_and_uplink_bandwidth = "下行和上行带宽";
$adv_downlink_and_uplink_bandwidth_msg = "上行由以太网和WDS接口组成。下行包括SSID。带宽设置影响AP的吞吐量。";
$adv_add_fair_air_time_rule = "添加带宽优先规则";
$adv_add_fair_air_time_rule_msg = "不同的SSID有不同的规则。为每个SSID添加规则。";
$adv_rule_type = "规则类型";
$adv_rule_type_msg1 = "规则1 -> 平均分配上行和下行带宽速率给每个客户端。";
$adv_rule_type_msg2 = "规则2 -> 分配最大上行和下行带宽速率给每个客户端。";
$adv_rule_type_msg3 = "规则3 -> 分配上行和下行带宽给不同的无线频段(802.11a/b/g/n)。";
$adv_rule_type_msg4 = "规则4 -> 分配带宽给指定SSID的客户端。每台设备竞争带宽。";
$adv_fair_air_time_band = "频段";
if($check_band == "")
{
	$adv_fair_air_time_band_msg = "支持2.4GHz频段。";
}
else
{
	$adv_fair_air_time_band_msg = "选择2.4GHz或 5GHz频段。";
}
$adv_fair_air_time_ssid = "SSID";
$adv_fair_air_time_ssid_msg = "为每个频段选择SSID。";
$adv_downlink_speed = "下行速率";
$adv_downlink_speed_msg = "规则1,3和4监控所选择的SSID的下行速率。规则2监控每一个客户端的下行速率。";
$adv_uplink_speed = "上行速率";
$adv_uplink_speed_msg = "规则1,3和4监控所选择的SSID的上行速率。规则2监控每一个客户端的上行速率。";


$head_ap_array = "AP Array";
$head_ap_array_msg = "一个AP Array是一套接入点组合，连接形成一个单一群组网络。";
$title_array_scan = "AP Array扫描";
$adv_array_enable = "启用阵列";
$adv_array_enable_msg = "选择勾选框启用AP Array。有三种模式可以选择：主选，备用主选和从属。主选AP控制与之相关联的所有的AP。"."备用主选AP是主选AP的备用。从属AP与主选AP同步并从主选AP获取所有指令。";
$adv_array_name = "AP Array名称";
$adv_array_name_msg = "为AP Array输入一个用户名称。";
$adv_array_password = "AP Array密码";
$adv_array_password_msg = "为AP Array输入一个用户名称。";
$adv_array_scan = "扫描AP Array列表";
$adv_array_scan_msg = "单击该按钮启动扫描在网络上当前所有可用的AP。";
$adv_array_list = "AP Array列表";
$adv_array_list_msg = "AP Array列表显示阵列状态。";
$adv_array_current = "当前阵列";
$adv_array_current_msg = "表中显示在阵列中所有的AP列表。";

$title_array_config = "配置设置";
$adv_enbale_config = "启用AP Array配置";
$adv_enbale_config_msg = "启用该功能以选择参数关联至AP Array。";
$adv_array_clear = "清除所有";
$adv_array_clear_msg = "单击<strong>清除所有</strong>以清除所有同步的参数。";

$title_auto_rf = "自动射频";
$title_auto_rf_msg = "自动射频功能可以优化AP射频发射功率并引导AP Array群组中每一AP。";
$adv_enable_autorf = "启用自动射频";
$adv_enable_autorf_msg = "启用或禁用自动射频功能。如果无AP Array被配置，该选项将不生效。";
$adv_init_autorf = "启动自动射频";
$adv_init_autorf_msg = "当一个AP Array群组已经在运行，该按键将允许所有群组里的AP自动扫描其它AP使用的信道，然后在每一台AP上启动射频参数。";
$adv_auto_init = "自动启动";
$adv_auto_init_msg = "该功能将在指定的时间段内自动优化射频。在自动信道扫描期间，数据链将被中断少许时间。";
$adv_auto_period = "自动启动时间";
$adv_auto_period_msg = "允许自动启动的一个时间段。";
$adv_auto_rssi = "RSSI阈值";
$adv_auto_rssi_msg = "为了降低射频干扰，自动射频选项将降低AP的接收射频功率，但射频功率不会低于此阈值。";
$adv_report_freq = "射频报告频率";
$adv_report_freq_msg = "每个从属AP按照此频率向控制AP汇报它周围的状态。";
$adv_auto_miss = "漏失阀值";
$adv_auto_miss_msg = "如果在该阈值时间内，一个从属AP漏失报告它的环境状态，它将被识别为一个失败者。";

$title_balance = "负载均衡";
$title_balance_msg = "动态调整连接到设备上的站点数量。";
$adv_balance_enable = "启用负载均衡";
$adv_balance_enable_msg = "启用或禁用负载均衡功能。";
$adv_balance_thre = "有效阈值";
$adv_balance_thre_msg = "如果连接到一台在AP Array群中的设备上的客户端的数量大于可用阈值，则负载均衡功能将立即启动。";

$head_captive = "强制网站";
$head_captive_msg = "强制网站是一个内置的网页认证服务器。当一个站点连接到一台AP时，网络浏览器将被重新定位至网页认证页面。";
$title_authentication = "身份验证设置";
$adv_encryption_type = "加密类型";
$adv_encryption_type_msg = "此为备件认证方式。前端认证方式为网页认证。";
$adv_captive_add = "添加";
$adv_captive_add_msg = "添加已选择的加密类型到配置文件列表。";
$adv_ticket = "密码";
$adv_ticket_msg = "时效性密码。";
$adv_quantity = "密码数量";
$adv_quantity_msg = "将被添加的密码的数量。";
$adv_duration = "持续时间";
$adv_duration_msg = "密码的持续时间。";
$adv_last_active_day = "最后活动日期";
$adv_last_active_day_msg = "密码的最后期限。";
$adv_ticket_user_limit = "用户限制";
$adv_ticket_user_limit_msg = "在同一时间有多少用户能够使用连接。";
$adv_local = "用户名称/密码";
$adv_local_msg = "本地认证的用户名和密码。";
$adv_restricted_subnets = "受限制子网";
$adv_restricted_subnets_msg = "访客用户不能访问以下所列出的子网。";
$adv_local_username = "用户名";
$adv_local_username_msg = "本地规则的用户名。";
$adv_local_password = "密码";
$adv_local_password_msg = "密码符合本地规则。";
$adv_group = "群组";
$adv_group_msg = "这可为一个管理者或一个访客。访问有限制访问。";
$adv_remote_radius = "远程RADIUS";
$adv_remote_radius_msg = "RADIUS认证的RADIUS服务器。";
$adv_type = "远程RADIUS类型";
$adv_type_msg = "默认为SPAP设置。其它类型可能被用于下一版本。";
$adv_radius_server = "Radius服务器";
$adv_radius_server_msg = "Radius服务器的IP地址或域名。";
$adv_radius_port = "Radius端口";
$adv_radius_port_msg = "Radius服务器的端口号。";
$adv_radius_secret = "Radius密码";
$adv_radius_secrett_msg = "Radius服务器的共享密码。";
$adv_accouting = "计费模式";
$adv_accouting_msg = "禁用或启用计费。";
$adv_accouting_server = "计费服务器";
$adv_accouting_server_msg = "计费服务器的IP地址或域名。";
$adv_accouting_port = "计费端口";
$adv_accouting_port_msg = "计费服务器的端口号。";
$adv_accouting_secret = "计费密码";
$adv_accouting_secret_msg = "计费服务器的共享密钥。";
$adv_ldap = "LDAP";
$adv_ldap_msg = "使用LDAP服务器，例如Windows活动目录或开放LDAP。";
$adv_ldap_server = "服务器";
$adv_ldap_server_msg = "LDAP服务器的IP地址或域名。";
$adv_ldap_port = "端口";
$adv_ldap_port_msg = "LDAP服务器的端口号。";
$adv_ldap_mode = "认证模式";
$adv_ldap_mode_msg = "简单或SSL/TLS传输。";
$adv_ldap_username = "用户名";
$adv_ldap_username_msg = "LDAP服务器管理员的名称。";
$adv_ldap_password = "密码";
$adv_ldap_password_msg = "LDAP服务器管理员的密码。";
$adv_basedn = "基准DN";
$adv_basedn_msg = "LDAP服务器管理员的域名。";
$adv_account = "帐户属性";
$adv_account_msg = "LDAP属性将搜索客户端字符串。";
$adv_identity = "标识";
$adv_identity_msg = "管理员的完整路径。";
$adv_auto_copy = "自动复制";
$adv_auto_copy_msg = "使用用户名和基准DN的通用网页的完整路径。";
$adv_pop3 = "POP3";
$adv_pop3_msg = "验证被配置为使用POP3服务器。";
$adv_pop3_server = "服务器";
$adv_pop3_server_msg = "POP3服务器的IP地址或域名。";
$adv_pop3_port = "端口";
$adv_pop3_port_msg = "POP3服务器的端口号。";
$adv_connection_type = "连接类型";
$adv_connection_type_msg = "无或传输SSL/TLS。";

$title_login_upload = "登录页面上传";
$title_login_upload_msg = "自定义的登录页面能够被上传。";

$title_web_redirect = "重载入网页";
$title_web_redirect_msg = "该功能将转换URL至指定的网站。单击选项以启用该功能。";
$adv_web_site = "网站";
$adv_web_site_msg = "输入一个IP地址或一个域名。";

$head_dhcp="DHCP服务器";
$head_dhcp_msg="DHCP(动态主机控制协议)服务器分配IP地址到已连接的DHCP客户端。在 ".query("/sys/hostname")."DHCP服务器默认情况为禁用。";

$title_dhcp_dynamic_pool="动态池设置";
$title_dhcp_dynamic_pool_msg="DHCP动态池为IP地址的一个范围，使用分配IP到DHCP客户端，且带有租赁时间控制。";
$dhcp_server_control="DHCP服务器控制";
$dhcp_server_control_msg="DHCP服务器控制默认为关。";
$dhcp_ip_assigned="可分配的起始IP地址";
$dhcp_ip_assigned_msg="指定IP地址池的启始IP。";
$dhcp_range_of_pool="池范围(1-254)";
$dhcp_range_of_pool_msg="指定IP地址范围。";
$dhcp_submask="子网掩码";
$dhcp_submask_msg="在IP分配从字段中输入子网掩码。";
$dhcp_gateway="网关";
$dhcp_gateway_msg="指定无线网络网关地址。";
$dhcp_wins="WINS";
$dhcp_wins_msg="指定无线网络WINS服务器。";
$dhcp_dns="DNS";
$dhcp_dns_msg="指定无线网络DNS服务器。";
$dhcp_domain="域名";
$dhcp_domain_msg="指定无线网络域名。";
$dhcp_lease_time="租约时间";
$dhcp_lease_time_msg="定义每个IP地址的租赁时间。";

$title_dhcp_static_pool="静态池设置";
$title_dhcp_static_pool_msg="静态池设置分配IP地址至已连接的客户端。客户端接收IP地址无时间限制。";
$host_name="主机名";
$host_name_msg="为此条目录创建一个名字。";
$dhcp_assigned_ip="分配的IP";
$dhcp_assigned_ip_msg="在被分配MAC地址字段输入针对一个指定客户端的MAC地址的IP地址。";
$dhcp_assigned_mac="分配的MAC地址";
$dhcp_assigned_mac_msg="输入客户端的MAC地址。";
$dhcp_submask_static_msg="在IP分配从字段中输入子网掩码。";
$dhcp_gateway_static_msg="指定无线网络的网关。";
$dhcp_wins_static_msg="指定无线网络WINS服务器地址。";
$dhcp_dns_static_msg="指定无线网络DNS服务器。";
$dhcp_domain_static_msg="指定无线网络域名。";

$title_dhcp_current_ip="当前IP映射";
$title_dhcp_current_ip_msg="当前IP图表包含动态和静态DHCP IP地址，MAC地址和他们的租赁时间。";


$head_filters="过滤器";
$head_filters_msg="过滤配置2个部分，MAC地址过滤和无线LAN分区。基于设备的MAC地址接受或阻止客户端设备。无线LAN分区，接受或阻止客户端设备通信或无线网络。";

$title_filters_wireless_access="无线访问设置";
$filters_wireless_band="无线带宽";
if($check_band == "")
{
	$filters_wireless_band_msg=query("/sys/hostname")."运行在2个频段中。2.4GHz与原有设备正常运行，且在无干扰的环境。";
}
else
{
	$filters_wireless_band_msg=query("/sys/hostname")." 运行在2个频段中。2.4GHz与原有设备一起运正常运行，并且适用于长距离。而5GHz可运行在无干扰的环境。";
}
$filters_acl_list="访问控制列表";
$filters_acl_list_msg= "通过过滤MAC地址来允许和拒绝某个设备连接。选择'接受'，只能连接上许可列表中有MAC地址的设备。选择'拒绝'，只拒绝列表中列出的设备。";
$filters_acl_mac = "MAC地址";
$filters_acl_mac_msg = "输入一个MAC地址。";
$filters_acl_client_information="当下客户信息";
$filters_acl_client_information_msg="显示".query("/sys/hostname")."网络中客户的SSID，MAC，频段，加密方式，信号强度。";

$filters_acl_upload_download="无线MAC ACL文件上传下载";
$filters_acl_upload_download_msg="通过浏览保存的文件所在的位置更新MAC ACL列表。单击打开，选择文件并单击上传。或者单击下载ACL文件下载文件到本地硬盘。"."可以选择关闭/允许/拒绝以配置ACL文件规则。最大ACL条目为256条。";

$title_filters_wlan_partition="WLAN隔离";
$filters_internal_station="内部站点连接";
$filters_internal_station2_msg="内部站点连接有以下三种模式:";
$filters_internal_station2_msg1="* 启用: 选择该选项允许连接到相同SSID上的无线客户端之间进行通讯，也允许连接在配置该无接接入点上的不同的SSID的客户端之间进行通讯。";
$filters_internal_station2_msg2="* 禁用: 选择该选项不允许连接到相同SSID上的无线客户端之间进行通讯，但允许连接在配置该无接接入点上的不同的SSID的客户端之间进行通讯。";
$filters_internal_station2_msg3="* 访客区: 选择该选项不允许连接到相同SSID上的无线客户端之间进行通讯，也不允许连接在配置该无接接入点上的不同的SSID的客户端之间进行通讯。";
$filters_internal_station_msg="The Internal Station Connection has three modes:<\br>".
"Enable: Select this option to allow communication between wireless clients connected to the same SSID and between wireless clients connected to different SSIDs configured on this access point.<\br>".
"Disable: Select this option to disallow communication between wireless clients connected to the same SSID, but to allow communication between wireless clients connected to different SSIDs configured on this access point.<\br>".
"Guest: Select this option to disallow communication between wireless clients connected to the same SSID and between wireless clients connected to different SSIDs configured on the access point.";
$filters_eth_to_wlan="以太网至WLAN访问";
$filters_eth_to_wlan_msg="默认为启用，无线设备能够与接入点的以太网端口同步。禁用，组播和广播数据包将被丢弃，但DHCP客户端能够与无线接入点通讯。"."默认值为 \"Enable\"，这将允许从以太网到连接到AP的无线站点之间的数据流量。通过禁用该功能，"."所有从以太网到相关无线设备的组播和广播数据包将被阻止，除了DHCP数据包。";

$head_traffic_control="流量控制";
$head_traffic_control_msg="管理流量管理规则，上行/下行设置和服务质量(QoS)设置。";

$title_traffic_updownlink_st="上行/下行设置";
$title_traffic_updownlink_st_msg="自定义下行/上行接口，而且带宽速率单位为Mbits/秒。";

$title_traffic_qos="QoS";
$title_traffic_qos_msg="QoS(服务质量)将智能流量处理优先于其它应用程序传输。 ".query("/sys/hostname")."支持4个优先等级。";

$adv_priority="优先级";
$adv_priority2_msg="信息流量优先级：";
$adv_priority2_msg1="* 最高(最紧急).";
$adv_priority2_msg2="* 第二.";
$adv_priority2_msg3="* 第三.";
$adv_priority2_msg4="* 最低(最不紧急).";
$traffic_qos_enable="启用Qos";
$traffic_qos_enable_msg="单击勾选框以启用QoS。使用下拉菜单以选择一个选择级别。单击保存。";
$traffic_qos_down_banwidth="下行带宽";
$traffic_qos_down_banwidth_msg="计量单位兆比特/每秒。";
$traffic_qos_up_banwidth="上行带宽";
$traffic_qos_up_banwidth_msg="计量单位兆比特/每秒。";

$title_traffic_manager="流量管理";
$title_traffic_manager_msg="基于列出的客户端流量和/或下行/上行速率创建流量管理规则。";

$traffic_traffic_manager="流量管理";
$traffic_traffic_manager_msg="启用流量管理。";
$traffic_unlisted_clients_traffic="列表外的用户管理";
$traffic_unlisted_clients_traffic_msg="选择拒绝或转发。";
$traffic_down_bandwidth="下行带宽";
$traffic_down_bandwidth_msg="计量单位兆比特/每秒。";
$traffic_up_bandwidth="上行带宽";
$traffic_up_bandwidth_msg="计量单位兆比特/每秒。";
$traffic_name="名称";
$traffic_name_msg="给新创建的流量控制条目输入一个名称。";
$traffic_client_ip="客户IP地址(可选)";
$traffic_client_ip_msg="输入一个客户IP地址。此项可选。";
$traffic_client_mac="客户MAC地址(可选)";
$traffic_client_mac_msg="输入一个客户MAC地址。此项可选。";
$traffic_down_speed="下行速率";
$traffic_down_speed_msg="输入一个下行速率，单位兆每秒。";
$traffic_up_speed="上行速率";
$traffic_up_speed_msg="输入一个上行速率，单位兆每秒。";
$traffic_list="流量管理规则";
$traffic_list_msg="该列表显示当前流量管理规则的以下参数：名称，客户端IP，客户端MAC地址，下行速率，上行速率，编辑和删除。";

$head_st="状态设置";

$title_st_dev_info="设备信息";
if(query("/runtime/web/display/status/cpu")!="1")
{
$title_st_dev_info_msg="该页面显示当前信息，比如固件版本，以太网和无线参数。";
}
else
{
$title_st_dev_info_msg="该页面显示当前信息，比如固件版本，以太网和无线参数，以及关于CPU和内存利用率的相关信息。";
}

$title_st_cli_info="客户端信息";
$title_st_cli_info_msg="客户端信息显示客户端SSID的MAC地址，频段，信号强度和省的模式。";

$title_st_wds_info="WDS信息";
$title_st_wds_info_msg="WDS（无线分布系统）显示WDS名称，MAC地址，验证模式，信号强度及连接状态。";

$title_chan_analyze="信道分析";
$title_chan_analyze_msg="信道分析检查当前信道可用性。";

$head_statistics="统计";

$title_st_ethernet="以太网流量统计";
$title_st_ethernet_msg="显示有线接口网络流量信息。";

$title_st_wlan="WLAN流量统计";
$title_st_wlan_msg="显示吞吐量，发送的帧，接收的帧和WEP帧错误AP信息。";


$head_log="日志";
$head_log_msg="显示从远程系统注册表服务器的日志事件记录。";

$title_log_view="查看日志";
$title_log_view_msg="以下日志信息将被显示：冷启动AP，更新固件，客户端连接/断开AP和网页登录。最大可查看500条日志。";

$title_log_set="日志设置";
$title_log_set_msg="输入日志服务器的IP地址。单击选择框监控这些参数：系统活动，无线活动和通知。";
$title_email="邮件通知";
$title_email_msg="对日志排程和周期密钥更新的邮件通知支持简单邮件传输协议（SMTP）。Gmail工作在SMTP端口25和/或587。";
$title_email_schedule="邮件日程表";
$title_email_schedule_msg="设置邮件日志日程表。";


$head_mt="维护";

$title_mt_admin="管理员设置";
$mt_limit_admin_vid="限制管理员VID";
$mt_limit_admin_vid_msg="通过标识VLAN数据包至VID以限制管理员权限。";
$mt_limit_admin_ip="限制管理员IP范围";
$mt_limit_admin_ip_msg="输入IP地址清单，这将在登录时限制管理员权限。";
$title_mt_sysname="系统名称设置";
$mt_sysname="系统名称";
$mt_sysname_msg="为".query("/sys/hostname")."输入一个名称。";
$mt_location="位置";
$mt_location_msg="为".query("/sys/hostname")."输入一个物理位置。";
$title_mt_login="登陆设置";
$mt_username="用户名";
$mt_username_msg="默认登录名为admin。默认密码为空白。当然登录名称可以自定义。";
$mt_oldpass="旧密码";
$mt_oldpass_msg="输入旧密码";
$mt_newpass="新密码";
$mt_newpass_msg="输入一个新的密码，此密码介于0-64个字符且区别大小写。";
$mt_conpass="确认请密码";
$mt_conpass_msg="确认新密码。";
$mt_applypass="使用新密码";
$mt_applypass_msg="使用新密码。";
$title_mt_console="控制台设置";
$mt_status="状态";
$mt_status_msg="启用或禁用控制台。";
$mt_console_protocol="控制台协议";
$mt_console_protocol_msg="选择telnet或SSH。";
$mt_timeout="超时";
$mt_timeout_msg="选择超时时间。";
$title_mt_snmp="SNMP设置";
$mt_st_snmp="状态";
$mt_st_snmp_msg="选择启用/禁用简单网络管理协议(SNMP)。";
$mt_public_comm="公有共同体字串";
$mt_public_comm_msg="为SNMP输入一个公有共同体字串。";
$mt_private_comm="私有共同体字串";
$mt_private_comm_msg="为SNMP输入一个私有共同体字串。";
$mt_trap="捕获信息状态";
$mt_trap_msg="启用或禁用捕获信息。";
$mt_trap_serv="捕获信息服务器IP";
$mt_trap_serv_msg="输入捕获服务器的IP地址。";
$title_mt_pingctrl="ping控制设置";
$mt_ping_st="状态";
$mt_ping_st_msg="默认为启用，状态Ping控制设置通过发送Internet控制报文协议(ICMP)数据包到目标主机并且侦听ICMP应答信息来工作。当该设置禁用则无信息发送。";
$title_mt_wifimanager="集中WiFi管理";
$title_mt_wifimanager_msg="集中WiFi管理是一个管理接入点连接到网络的工具，它可管理一个有大量的设备的单个群组网络。它与集中WiFi管理工具配合使用。";
$mt_enbale_wifimanager="启用集中WiFi管理";
$mt_enbale_wifimanager_msg="单击该项以启用集中WiFi管理员。";
$mt_enbale_backup_wifimanager="启用备用集中WiFi管理";
$mt_enbale_backup_wifimanager_msg="单击该项以启用备用集中WiFi管理。";

$title_mt_fw="固件和SSL";
$title_mt_fw_msg="固件和SSL证书上传";
$title_mt_fw_msg1="上传最新固件和SSL验证证书。";
$mt_upload_fw="从本地硬盘上传固件";
$mt_upload_fw_msg="查看在文件上方区域的当前固件版本号。下载最新固件，单击浏览找到新固件，然后单击打开并且单击确定，更新至最新固件。升级时切勿关闭电源。";
$mt_upload_ssl="从本地硬盘上传SSL证书";
$mt_upload_language = "上传语言包";
$mt_upload_language_msg = "下载SSL证书，单击浏览，选择已下载的证书，然后单击打开并上传，以完成升级过程。";
$mt_upload_ssl_msg="下载SSL证书到本地硬盘后，单击'浏览'。选择该证书并单击'打开'，'上传'以完成升级。";

$_title_mt_config="配置文件";
$mt_config="配置文件上传和下载";
$mt_config_msg="上传或下载无线接入点的配置文件。";
$mt_upload_config="上传配置文件";
$mt_upload_config_msg="浏览已保存的配置文件目录，单击打开，然后上传文件以更新配置。";
$mt_download_config="下载配置文件";
$mt_download_config_msg="单击下载保存当前配置文件到本地硬盘。当重置".query("/sys/hostname")."时请记住管理员密码。否则密码将遗失，甚至您已经保存的配置文件也将丢失。";

$title_mt_time="时间和日期";
$title_mt_time_msg="选择时区。输入NTP服务IP。选择启用/禁用夏令时。";
$auto_time = "自动时间配置";
$auto_time_msg = "启用NTP以从一台NTP服务器获取日期和时间。";
$date_and_time_manu = "手动设置日期和时间";
$date_and_time_manu_msg = "您可以手动设置日期和时间或复制您的计算器上的时间到AP。";
$head_config ="配置";
$config_save_activate="保存并激活";
$config_save_activate_msg="点击\"保存并激活\"以保存所有设置并重新激活设备。";
$config_discard_change="取消更改";
$config_discard_change_msg="点击\"取消更改\"以放弃所有的设置。";

$head_sys = "系统";
$title_sys = "系统设置";
$sys_apply_restart = "应用设置和重启";
$sys_apply_restart_msg = "如要应用并重新开启".query("/sys/hostname")."，请单击重启。";
$sys_apply_restore = "恢复至出厂默认值";
$sys_apply_restore_msg = "如要重置".query("/sys/hostname")."至出厂默认值，单击复位。";
$sys_clear_language = "清除语言包";
$sys_clear_language_msg = "单击清除以重置语言至默认设置。";


?>
