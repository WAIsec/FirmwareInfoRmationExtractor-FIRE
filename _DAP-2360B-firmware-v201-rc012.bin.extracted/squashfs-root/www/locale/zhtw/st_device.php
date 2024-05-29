<?
$ssid_flag = query("/runtime/web/display/mssid_index4");
$m_context_title = "設備訊息";
$m_ethernet = "乙太網路";
$m_wireless = "無線網路";
$m_2.4g = "(2.4GHz)";
$m_5g = "(5GHz)";
$m_status = "設備狀態";
$m_fw_version = "韌體版本";
$m_eth_mac = "乙太網路MAC 位址";
$m_wlan_mac = "無線網路MAC位址";
$m_ap_array = "AP Arrary";
$m_role = "Role";
$m_master = "Master";
$m_backup_master = "Backup Master";
$m_slave = "Slave";
$m_location = "位置";
$m_pri = "主要的";
if($ssid_flag == "1")
{
	$m_ms	="SSID 1~3";
}
else
{
$m_ms = "SSID 1~7";
}
$m_ip = "IP位址";
$m_ipv6_ip = "IPv6 IP Address";
$m_ipv6_prefix = "IPv6 Prefix";
$m_ipv6_dns = "IPV6 DNS";
$m_ipv6_gateway = "IPv6 Gateway";
$m_link_ip = "Link-Local IP Address";
$m_link_prefix = "Link-Local Prefix";
$m_mask = "子網路遮罩";
$m_gate = "閘道器";
$m_dns = "DNS";
$m_na = "N/A";
$m_ssid = "網路名稱(SSID)";
$m_channel = "頻道";
$m_rate = "資料傳輸速率";
$m_sec = "安全";
$m_bits		= "bits";
$m_tkip		= "TKIP";
$m_aes		= "AES";
$m_cipher_auto	= "Auto";
$m_wpa		= "WPA-";
$m_wpa2		= "WPA2-";
$m_wpa_auto		= "WPA2-Auto-";
$m_eap		= "Enterprise/";
$m_psk		= "Personal /";
$m_open		="Open /";
$m_shared	="Shared Key /";
$m_disabled		="停用";
$m_cpu = "CPU使用率";
$m_memory ="記憶體使用率";
$m_none = "None";
$m_auto  ="Auto";
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
?>
