<?
$ssid_flag = query("/runtime/web/display/mssid_index4");
$m_context_title = "Geräteinformationen";
$m_ethernet = "Ethernet";
$m_wireless = "Drahtlos";
$m_2.4g = "(2.4GHz)";
$m_5g = "(5GHz)";
$m_status = "Gerätestatus";
$m_fw_version = "Firmware-Version";
$m_eth_mac = "Ethernet MAC-Adresse";
$m_wlan_mac = "Drahtlose MAC-Adresse";
$m_ap_array = "AP Array";
$m_role = "Role";
$m_master = "Master";
$m_backup_master = "Backup Master";
$m_slave = "Slave";
$m_location = "Standort";
$m_pri = "Primär";
if($ssid_flag == "1")
{
	$m_ms	="SSID 1~3";
}
else
{
$m_ms = "SSID 1~7";
}
$m_ip = "IP-Adresse";
$m_ipv6_ip = "IPv6 IP Address";
$m_ipv6_prefix = "IPv6 Prefix";
$m_ipv6_dns = "IPV6 DNS";
$m_ipv6_gateway = "IPv6 Gateway";
$m_link_ip = "Link-Local IP Address";
$m_link_prefix = "Link-Local Prefix";
$m_mask = "Subnetzmaske";
$m_gate = "Gateway";
$m_dns = "DNS";
$m_na = "k.A.";
$m_ssid = "Netzwerkname (SSID)";
$m_channel = "Kanal";
$m_rate = "Datenrate";
$m_sec = "Sicherheit";
$m_bits		= "Bits";
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
$m_disabled		="Deaktivieren";
$m_cpu = "CPU-Auslastung";
$m_memory = "Arbeitsspeicherauslastung";
$m_none = "Kein";
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
