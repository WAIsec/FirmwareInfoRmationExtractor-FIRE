<?
$m_context_title = "上行下行设定";
$m_uplink = "上行";
$m_downlink = "下行";
$m_uplink_interface = "上行设定";
$m_downlink_interface = "下行设定";
$m_uplink_bandwidth = "上行带宽";
$m_downlink_bandwidth = "下行带宽";
if($TITLE=="DAP-2590")
{
	$m_range = "(1~150)";
}
else
{
	$m_range = "(1~300)";
}
$m_band_2.4G = "2.4GHz";
$m_band_5G = "5GHz";
$m_ethernet = "有线";
$m_lan1 = "LAN1";
$m_lan2 = "LAN2";
$m_ethernet2 = "以太网2";
$m_primaryssid = "主ssid";
$m_multissid1 = "Multi-ssid1";
$m_multissid2 = "Multi-ssid2";
$m_multissid3 = "Multi-ssid3";
$m_multissid4 = "Multi-ssid4";
$m_multissid5 = "Multi-ssid5";
$m_multissid6 = "Multi-ssid6";
$m_multissid7 = "Multi-ssid7";
$m_wds1 = "WDS1";
$m_wds2 = "WDS2";
$m_wds3 = "WDS3";
$m_wds4 = "WDS4";
$m_wds5 = "WDS5";
$m_wds6 = "WDS6";
$m_wds7 = "WDS7";
$m_wds8 = "WDS8";
$a_empty_value_for_speed	="请输入速率值!";
$a_invalid_value_for_speed	="无效速率值!";
if($TITLE=="DAP-2590")
{
	$a_invalid_range_for_speed  ="下行或上行带宽范围为1~150百万bits/秒!";
}
else
{
	$a_invalid_range_for_speed  ="下行或上行带宽范围为1~300百万bits/秒!";
}
$a_w2e_larger_than_max      ="上行带宽必须比流量管理中的最大上行带宽大!";
$a_e2w_larger_than_max      ="下行带宽必须比流量管理中的最大下行带宽大!";
?>
