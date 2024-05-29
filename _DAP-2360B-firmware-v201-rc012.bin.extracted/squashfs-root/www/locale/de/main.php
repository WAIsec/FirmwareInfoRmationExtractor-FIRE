<?
$basic_setting = "Grundeinstellungen";
$basic_wireless= "Drahtlos";
$basic_lan	="LAN";
$basic_ipv6	="IPv6";
$adv_setting = "Erweiterte Einstellungen";
$adv_perf = "Leistung";
$adv_group = "Gruppierung";
$adv_mssid = "Multi-SSID";
$adv_8021q = "VLAN";
$adv_tr069v3 = "Tr069v3";
$adv_rogue_ap = "Angriff";
$adv_scheduling = "Zeitplan";
$adv_arp_spoofing = "ARP Spoofing Prevention";
$adv_radiusserver = "Internal RADIUS Server";
$adv_ctrl = "Traffic Control";
$adv_ctrl_setting = "Uplink/Downlink Settings";
$adv_qos = "QoS";
$adv_ctrl_qos = "QoS";
$adv_ctrl_trafficmanage = "Traffic Manager";
$adv_wtp = "WLAN-Switch";
$bsc_capwap = "CAPWAP";
$adv_dhcp = "DHCP-Server";
$adv_dhcp_dynamic = "Dynamische Adressenpool-Einstellungen";
$adv_dhcp_static = "Statische Adressenpool-Einstellungen";
$adv_dhcp_list = "Aktuelle IP-Zuordnungsliste";
$adv_filter = "Filter";
$adv_filter_acl = "Drahtlose MAC ACL";
$adv_filter_partition = "WLAN-Partition";
$adv_radiusclient = "Radiusclient";
$adv_ap_array = "AP Array";
$adv_url_redir = "Web Redirection";
$adv_mcast = "Multicast Rate";
$st_setting = "Status";
$st_device = "Geräteinformationen";
$st_client = "Client-Informationen";
$st_wds_client = "WDS-Informationen";
$st_stats = "Statistik";
$st_stats_ethernet = "Ethernet";
$st_stats_wlan = "WLAN";
$st_log = "Protokoll";
$st_log_view = "Protokoll anzeigen";
$st_log_setting = "Protokolleinstellungen";
$tool_admin = "Administrationseinstellungen";
$cfg_ipv6 = query("/inet/entry:1/ipv6/valid");
if($cfg_ipv6==1)
{
	$tool_fw = "Firmware Upload";
}
else
{
$tool_fw = "Firmware- und SSL-Zertifizierung hochladen";
}
$tool_config = "Konfigurationsdatei";
$tool_sntp = "Uhrzeit und Datum";
$logout_msg = "&nbsp;&nbsp;Die aktuelle Browser-Verbindung wird getrennt,<br>&nbsp;&nbsp;<b>wenn Sie hier klicken.</b>.";
?>
