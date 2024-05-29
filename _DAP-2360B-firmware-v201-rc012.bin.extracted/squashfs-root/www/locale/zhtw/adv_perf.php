<?
$m_context_title = "效能設定";
$m_band = "Wireless band";
$m_band_2.4G = "2.4GHz";
$m_band_5G = "5GHz";
$m_wl_enable = "無線";
$m_disable = "取消";
$m_enable  = "啟動";
$m_off = "Off";
$m_on  = "On";
$m_wlmode = "無線模式";
$m_wlmode_n_g_b = "被混合的802.11n、802.11g與802.11b";
$m_wlmode_n_g = "被混合的802.11n與802.11g";
$m_wlmode_g_b = "被混合的802.11g與802.11b";
$m_wlmode_n = "限802.11n";
$m_wlmode_n_a = "被混合的802.11n、802.11a";
$m_wlmode_a = "限802.11a";
$m_rate = "資料速率";
$m_best	= "最佳（最高300）";
$m_best_54	= "最佳（最高54）";
$m_54	= "54";
$m_48	= "48";
$m_36	= "36";
$m_24	= "24";
$m_18	= "18";
$m_12	= "12";
$m_9	= "9";
$m_6	= "6";
$m_11	= "11";
$m_5.5	= "5.5";
$m_2	= "2";
$m_1	= "1";
$m_beacon_interval	="信標時距（25-500）";
$m_rts			="RTS臨界值 (256-2346)";
$m_frag			="碎裂 (256-2346)";
$m_dtim			="數位傳輸介面模組時距（1-15）";
$m_power = "傳送功率";
$m_ms = "(&micro;s)";

$m_sw_power = "SW Transmit Power";
$m_ampdu = "AMPDU";
$m_amsdu = "AMSDU";
$m_chainmask = "ChainMask";
$m_1x1 = "1x1";
$m_2x2 = "2x2";
$m_wmm = "WMM (Wi-Fi多媒體)";
$m_shortgi = "短時空區塊編碼";
$m_limit_state = "連接上限";
$m_limit_num = "使用者上限（0-64）";
$m_utilization = "網路運用";
$m_0 = "0";
$m_10 = "10";
$m_20 = "20";
$m_30 = "30";
$m_40 = "40";
$m_50 = "50";
$m_60 = "60";
$m_70 = "70";
$m_80 = "80";
$m_90 = "90";
$m_100 = "100";
$m_180 = "180";
$m_75 = "75";
$m_25 = "25";
$m_12.5 = "12.5";
$m_igmp = "網際網路群組管理協定模擬功能";
$m_link_integrality="連結整體度";
$m_ack_timeout="確認逾時";
$m_mbps = "(Mbps)";
$m_multicast_rate  = "Multicast Rate ";
$m_mcast_a = "Multicast Rate for 5G Band";
$m_mcast_g = "Multicast Rate for 2.4G Band";
if(query("/runtime/web/display/ack_timeout_range")=="0")
{
$m_ack_timeout_g_msg = " (2.4GHz, 48~200)";
$m_ack_timeout_a_msg = " (5GHz, 25~200)";
	$a_invalid_ack_timeoutg ="Ack TimeOut值的範圍為48~200。";
	$a_invalid_ack_timeouta ="Ack TimeOut值的範圍為25~200。";
}
else
{
	$m_ack_timeout_g_msg = " (2.4GHz, 64~200)";
	$m_ack_timeout_a_msg = " (5GHz, 50~200)";
	$a_invalid_ack_timeoutg ="Ack TimeOut值的範圍為64~200。";
	$a_invalid_ack_timeouta ="Ack TimeOut值的範圍為50~200。";
}
$a_invalid_txswpower = "The SW Transmit Power value range is 0 ~ 30.";
$a_invalid_bi		="Beacon時距值的範圍為25~500。";
$a_invalid_rts		="RTS臨界值的範圍為256~2346。";
$a_invalid_frag		="碎裂值的範圍為256~2346。";
$a_invalid_dtim		="數位傳輸介面模組時距值的範圍為1~15。";
$a_invalid_limit_num	="'User Limit'的範圍為0到64。";

?>
