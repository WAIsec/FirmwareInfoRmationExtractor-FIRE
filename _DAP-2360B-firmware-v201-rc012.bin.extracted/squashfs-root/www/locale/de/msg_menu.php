<?
// category
$m_menu_top_bsc		="Setup";
$m_menu_top_adv		="Erweiterte Funktionen";
$m_menu_top_tools	="WARTUNG UND VERWALTUNG";
$m_menu_top_st		="Status";
$m_menu_top_spt		="Support";

// basic
$m_menu_bsc_wizard      ="ASSISTENT";
$m_menu_bsc_internet	="INTERNET";
$m_menu_bsc_wlan	="FUNK-SETUP";
$m_menu_bsc_lan		="LAN-SETUP";

// advanced
$m_menu_adv_vrtsrv	="VIRTUELLER SERVER";
$m_menu_adv_port	="PORTWEITERLEITUNG";
$m_menu_adv_app		="ANWENDUNGSREGELN";
$m_menu_adv_mac_filter	="NETZWERKFILTER";
$m_menu_adv_acl		="FILTER";
$m_menu_adv_url_filter	="WEBSITE-FILTER";
$m_menu_adv_dmz		="FIREWALL-EINSTELLUNGEN";
$m_menu_adv_wlan	="LEISTUNG";
$m_menu_adv_network	="ERWEITERTES NETZWERK";
$m_menu_adv_dhcp	="DHCP-SERVER";
$m_menu_adv_mssid	="MULTI-SSID";
$m_menu_adv_group	="Benutzerlimit";
$m_menu_adv_wtp		="WLAN-Switch";
$m_menu_adv_wlan_partition	="WLAN-Partition";

// tools
$m_menu_tools_admin	="Geräteverwaltung";
$m_menu_tools_time	="ZEIT";
$m_menu_tools_system	="SYSTEM";
$m_menu_tools_firmware	="FIRMWARE";
$m_menu_tools_misc	="DIV";
$m_menu_tools_ddns	="DDNS";
$m_menu_tools_vct	="SYSTEMCHECK";
$m_menu_tools_sch	="ZEITPLÄNE";
$m_menu_tools_log_setting	="PROTOKOLLEINSTELLUNGEN";

// status
$m_menu_st_device	="GERÄTEINFO";
$m_menu_st_log		="PROTOKOLL";
$m_menu_st_stats	="Statistiken";
$m_menu_st_wlan		="CLIENT-INFO";

// support
$m_menu_spt_menu	="MENÜ";

$m_logout	="Abmelden";

$m_menu_home	="Home";
$m_menu_tool	="Wartung";
$m_menu_config	="Konfiguration";
$m_menu_sys	="System";
$m_menu_logout	="Abmelden";
$m_menu_help	="Hilfe";

$cfg_ipv6 = query("/inet/entry:1/ipv6/valid");
$m_menu_tool_admin	="Administratoreinstellungen";
if($cfg_ipv6==1)
{
	$m_menu_tool_fw	="Firmware Upload";
}
else
{
$m_menu_tool_fw	="Firmware- und SSL-Zertifikate hochladen";
}
$m_menu_tool_config	="Konfigurationsdatei";
$m_menu_tool_sntp	="SNTP";

$m_menu_config_save	="Speichern und aktivieren";
$m_menu_config_discard	="Änderungen verwerfen";

$a_config_discard ="Alle Ihre Änderungen werden verworfen. Weiter?";

?>
