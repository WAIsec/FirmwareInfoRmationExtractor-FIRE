<?
$ssid_flag = query("/runtime/web/display/mssid_index4");
$m_context_title = "Systeminformationen";
$m_model_name	= "Modell";
$m_sys_time	="Systemzeit";
$m_up_time	="Betriebszeit";
$m_firm_version	="Firmware-Version";
$m_ip	="IP-Adresse";
$m_mac	="MAC-Adresse";
$m_ipv6_ip = "IPv6 IP Address";
$m_link_ip = "Link-Local IP Address";
if($ssid_flag == "1")
{
	$m_mssid	="SSID 1~3";
}
else
{
$m_mssid	="SSID 1~7";
}
$m_ap_mode ="Betriebsart";
$m_days = "Tage";
$m_sysname = "Systemname";
$m_location = "Standort";
$m_ap = "Access Point";
$m_wireless_client = "Drahtloser Client";
$m_wds_ap = "WDS mit AP";
$m_wds = "WDS";
$m_ap_repeater = "AP Repeater";
?>
