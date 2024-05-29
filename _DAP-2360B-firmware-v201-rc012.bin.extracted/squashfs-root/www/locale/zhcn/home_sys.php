<?
$ssid_flag = query("/runtime/web/display/mssid_index4");
$m_context_title = "系统信息";
$m_model_name	= "型号名称";
$m_sys_time	="系统时间";
$m_up_time	="上传时间";
$m_firm_version	="固件版本";
$m_ip	="IP地址";
$m_mac	="MAC地址";
$m_ipv6_ip = "IPv6 IP地址";
$m_link_ip = "Link-Local IP地址";
if($ssid_flag == "1")
{
	$m_mssid	="SSID 1~3";
}
else
{
$m_mssid	="SSID 1~7";
}
$m_ap_mode ="操作模式";
$m_days = "日期";
$m_sysname = "系统名称";
$m_location = "地点";
$m_ap = "接入点";
$m_wireless_client = "无线客户端";
$m_wds_ap = "带AP的WDS";
$m_wds = "WDS";
$m_ap_repeater = "AP转发器";
?>
