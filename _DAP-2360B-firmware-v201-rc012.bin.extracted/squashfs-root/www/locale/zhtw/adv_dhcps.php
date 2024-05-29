<?
$MAX_RULES=query("/lan/dhcp/server/pool:1/staticdhcp/max_client");
if ($MAX_RULES==""){$MAX_RULES=25;}	
$m_context_title = "靜態集區設定";
$m_srv_enable = "功能啟動/取消";
$m_disable = "取消";
$m_enable = "啟動";
$m_dhcp_srv = "動態主機設定通訊協定伺服器控制";
$m_dhcp_pool = "靜態集區設定";
$m_computer_name = "電腦名稱";
$m_ipaddr = "被分配的IP";
$m_macaddr = "被分配的網路實際位址";
$m_ipmask = "子網路遮罩";
$m_gateway = "閘道器";
$m_wins = "微軟視窗網際絡路名稱服務";
$m_dns = "網域名稱系統";
$m_m_domain_name = "網域名稱";
$m_on = "開";
$m_off = "關";
$m_status_enable = "狀態";
$m_mac = "網路實際位址";
$m_ip = "IP位址";
$m_state = "狀態";
$m_edit = "編輯";
$m_del = "刪除";

$a_invalid_host		= "錯誤的電腦名稱!";
$a_invalid_ip		= "IP位址無效 !";
$a_invalid_mac		= "網路實際位址無效 !";
$a_max_mac_num = "存取控管清單的數目上限為".$MAX_RULES."!";
$a_same_ip = "There is an existent entry with the same IP Address.\\n Please change the IP Address.";
$a_same_mac = "已有相同的網路實際位址存在。\\n 請更換網路實際位址。";
$a_invalid_netmask	= "子網路遮罩無效 !";
$a_invalid_gateway	="閘道器無效 !";
$a_invalid_wins	= "微軟視窗網際絡路名稱服務無效 !";
$a_invalid_dns	="網域名稱系統無效 !";
$a_invalid_domain_name	= "網域名稱無效 !";
$a_invalid_lease_time	= "動態主機設定通訊協定租用時間無效 !";
$a_entry_del_confirm = "確定刪除這個輸入？";
?>
