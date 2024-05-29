<?
$ssid_flag = query("/runtime/web/display/mssid_index4");
$m_context_title = "系統資訊";
$m_model_name	= "產品名稱";
$m_sys_time	="系統時間";
$m_up_time	="開機時間";
$m_firm_version	="韌體版本";
$m_ip	="IP位址";
$m_mac	="網路實體位址";
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
$m_ap_mode ="執行模式";
$m_days = "天";
$m_sysname = "系統名稱";
$m_location = "地區";
$m_ap = "無線基地台模式";
$m_wireless_client = "無線用戶端模式";
$m_wds_ap = "無線橋接模式與AP";
$m_wds = "無線橋接模式";
$m_ap_repeater = "AP Repeater";
?>
