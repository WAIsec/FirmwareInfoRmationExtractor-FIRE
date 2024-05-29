<?
// category
$m_menu_top_bsc		="設定";
$m_menu_top_adv		="進階";
$m_menu_top_tools	="維護";
$m_menu_top_st		="狀態";
$m_menu_top_spt		="支援";

// basic
$m_menu_bsc_wizard      ="精靈";
$m_menu_bsc_internet	="網際網路";
$m_menu_bsc_wlan	="無線網路設定";
$m_menu_bsc_lan		="區域網路設定";

// advanced
$m_menu_adv_vrtsrv	="虛擬伺服器";
$m_menu_adv_port	="服務埠轉傳";
$m_menu_adv_app		="應用程式規則";
$m_menu_adv_mac_filter	="網路過濾";
$m_menu_adv_acl		="過濾";
$m_menu_adv_url_filter	="網頁過濾";
$m_menu_adv_dmz		="防火牆設定";
$m_menu_adv_wlan	="效能";
$m_menu_adv_network	="進階網路";
$m_menu_adv_dhcp	="DHCP 伺服器";
$m_menu_adv_mssid	="MULTI-SSID";
$m_menu_adv_group	="使用者限制";
$m_menu_adv_wtp		="WLAN Switch";
$m_menu_adv_wlan_partition	="無線網路隔離";

// tools
$m_menu_tools_admin	="設備管理";
$m_menu_tools_time	="時間";
$m_menu_tools_system	="系統";
$m_menu_tools_firmware	="韌體";
$m_menu_tools_misc	="MISC";
$m_menu_tools_ddns	="DDNS";
$m_menu_tools_vct	="系統確認";
$m_menu_tools_sch	="排程";
$m_menu_tools_log_setting	="LOG 設定";

// status
$m_menu_st_device	="設備訊息";
$m_menu_st_log		="LOG";
$m_menu_st_stats	="狀態";
$m_menu_st_wlan		="用戶端訊息";

// support
$m_menu_spt_menu	="目錄";

$m_logout	="登出";

$m_menu_home	="首頁";
$m_menu_tool	="維護";
$m_menu_config	="設定組態";
$m_menu_sys	="系統";
$m_menu_logout	="登出";
$m_menu_help	="協助";

$cfg_ipv6 = query("/inet/entry:1/ipv6/valid");
$m_menu_tool_admin	="管理者設定";
if($cfg_ipv6==1)
{
	$m_menu_tool_fw	="Firmware Upload";
}
else
{
$m_menu_tool_fw	="韌體與SSL憑證上傳";
}
$m_menu_tool_config	="設定組態檔案";
$m_menu_tool_sntp	="SNTP";

$m_menu_config_save	="儲存與啟用";
$m_menu_config_discard	="放棄改變";

$a_config_discard ="所有您所異動的設定將會放棄!是否繼續?";

?>
