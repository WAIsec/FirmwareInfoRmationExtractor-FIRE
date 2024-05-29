<?
$ssid_flag = query("/runtime/web/display/mssid_index4");
$m_context_title = "设备信息";
$m_ethernet = "以太网";
$m_wireless = "无线";
$m_2.4g = "(2.4GHz)";
$m_5g = "(5GHz)";
$m_status = "设备状态";
$m_fw_version = "固件版本";
$m_eth_mac = "以太网MAC地址";
$m_wlan_mac = "无线MAC地址";
$m_ap_array = "AP Array";
$m_role = "角色";
$m_master = "主设备";
$m_backup_master = "备用设备";
$m_slave = "从设备";
$m_location = "位置";
$m_pri = "首选";
if($ssid_flag == "1")
{
	$m_ms	="SSID 1~3";
}
else
{
$m_ms = "SSID 1~7";
}
$m_ip = "IP地址";
$m_ipv6_ip = "IPv6 IP地址";
$m_ipv6_prefix = "IPv6前缀";
$m_ipv6_dns = "IPV6 DNS";
$m_ipv6_gateway = "IPv6网关";
$m_link_ip = "Link-Local IP地址";
$m_link_prefix = "Link-Local前缀";
$m_mask = "子网掩码";
$m_gate = "网关";
$m_dns = "DNS";
$m_na = "N/A";
$m_ssid = "网络名（SSID）";
$m_channel = "信道";
$m_rate = "数据速率";
$m_sec = "安全";
$m_bits		= "比特";
$m_tkip		= "TKIP";
$m_aes		= "AES";
$m_cipher_auto	= "自动";
$m_wpa		= "WPA-";
$m_wpa2		= "WPA2-";
$m_wpa_auto		= "WPA2-Auto-";
$m_eap		= "Enterprise/";
$m_psk		= "Personal /";
$m_open		="打开 /";
$m_shared	="共享密钥 /";
$m_disabled		="禁用";
$m_cpu = "CPU利用率";
$m_memory = "内存利用率";
$m_none = "无";
$m_auto  ="自动";
$m_54	= "54";
$m_48	= "48";
$m_36	= "36";
$m_24	= "24";
$m_18	= "18";
$m_12	= "12";
$m_9	= "9";
$m_6	= "6";
$m_11	= "11";
$m_5	= "5.5";
$m_2	= "2";
$m_1	= "1";
$m_swctrl = "集中WiFi管理";
$m_connect_status = "连接状态";
$m_connect = "连接";
$m_disconnect = "断开";
$m_server_ip = "服务器IP";
$m_service_port = "服务器端口";
$m_live_port = "活动端口";
$m_group_id = "群组ID";
$m_bswctrl = "备用集中WiFi管理";
?>
