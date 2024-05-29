<?
$basic_setting = "基本設定";
$basic_wireless= "無線網路";
$basic_lan	="區域網路";
$basic_ipv6	="IPv6";
$adv_setting = "進階設定";
$adv_perf = "效能設定";
$adv_group = "群組";
$adv_mssid = "多重服務設定識別碼";
$adv_8021q = "虛擬區域網路";
$adv_tr069v3 = "Tr069v3";
$adv_rogue_ap = "非法入侵";
$adv_scheduling = "排程";
$adv_arp_spoofing = "ARP Spoofing Prevention";
$adv_radiusserver = "Internal RADIUS Server";
$adv_ctrl = "Traffic Control";
$adv_ctrl_setting = "Uplink/Downlink Settings";
$adv_qos = "Qos";
$adv_ctrl_qos = "QoS";
$adv_ctrl_trafficmanage = "Traffic Manager";
$adv_wtp = "WLAN Switch";
$bsc_capwap = "CAPWAP";
$adv_dhcp = "DHCP伺服器";
$adv_dhcp_dynamic = "動態模式設定";
$adv_dhcp_static = "固定模式設定";
$adv_dhcp_list = "目前IP列表";
$adv_filter = "過濾功能";
$adv_filter_acl = "無線網路實體位址限制";
$adv_filter_partition = "無線網路隔離";
$adv_radiusclient = "Radiusclient";
$adv_ap_array = "AP Array";
$adv_url_redir = "Web Redirection";
$adv_mcast = "Multicast Rate";
$st_setting = "系統資訊";
$st_device = "裝置資訊";
$st_client = "客戶端資訊";
$st_wds_client = "無線橋接訊息";
$st_stats = "狀態";
$st_stats_ethernet = "有線網路";
$st_stats_wlan = "無線區域網路";
$st_log = "Log";
$st_log_view = "檢視Log";
$st_log_setting = "Log設定";
$tool_admin = "管理設定";
$cfg_ipv6 = query("/inet/entry:1/ipv6/valid");
if($cfg_ipv6==1)
{
	$tool_fw = "Firmware Upload";
}
else
{
$tool_fw = "韌體與SSL憑證上傳";
}
$tool_config = "組態檔案";
$tool_sntp = "時間與日期";
$logout_msg = "&nbsp;&nbsp;按<b>這裡</b>之後，目前的瀏覽軟體連線將中斷。";
?>
