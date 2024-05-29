<?
// category
$m_menu_top_bsc		="设置";
$m_menu_top_adv		="高级";
$m_menu_top_tools	="维护";
$m_menu_top_st		="状态";
$m_menu_top_spt		="支持";

// basic
$m_menu_bsc_wizard      ="向导";
$m_menu_bsc_internet	="INTERNET";
$m_menu_bsc_wlan	="无线设置";
$m_menu_bsc_lan		="LAN设置";

// advanced
$m_menu_adv_vrtsrv	="虚拟服务器";
$m_menu_adv_port	="端口转发";
$m_menu_adv_app		="应用规则";
$m_menu_adv_mac_filter	="网络过滤器";
$m_menu_adv_acl		="过滤器";
$m_menu_adv_url_filter	="站点过滤";
$m_menu_adv_dmz		="防火墙设置";
$m_menu_adv_wlan	="性能";
$m_menu_adv_network	="高级网络";
$m_menu_adv_dhcp	="DHCP服务器";
$m_menu_adv_mssid	="多个SSID";
$m_menu_adv_group	="用户限制";
$m_menu_adv_wtp		="WLAN交换";
$m_menu_adv_wlan_partition	="WLAN隔离";

// tools
$m_menu_tools_admin	="设备管理";
$m_menu_tools_time	="时间";
$m_menu_tools_system	="系统";
$m_menu_tools_firmware	="固件";
$m_menu_tools_misc	="MISC";
$m_menu_tools_ddns	="DDNS";
$m_menu_tools_vct	="系统检测";
$m_menu_tools_sch	="计划";
$m_menu_tools_log_setting	="日志设置";

// status
$m_menu_st_device	="设备信息";
$m_menu_st_log		="日志";
$m_menu_st_stats	="统计";
$m_menu_st_wlan		="客户端信息";

// support
$m_menu_spt_menu	="菜单";

$m_logout	="退出";

$m_menu_home	="主页";
$m_menu_tool	="维护";
$m_menu_config	="配置";
$m_menu_sys	="系统";
$m_menu_logout	="退出";
$m_menu_help	="帮助";

$cfg_ipv6 = query("/inet/entry:1/ipv6/valid");
$m_menu_tool_admin	="管理员设置";
if($cfg_ipv6==1)
{
	$m_menu_tool_fw	="固件上传";
}
else
{
$m_menu_tool_fw	="固件和SSL证书上传";
}
$m_menu_tool_config	="配置文件";
$m_menu_tool_sntp	="SNTP";

$m_menu_config_save	="保存并激活";
$m_menu_config_discard	="取消更改";

$a_config_discard ="将取消所有更改！继续？";

?>
