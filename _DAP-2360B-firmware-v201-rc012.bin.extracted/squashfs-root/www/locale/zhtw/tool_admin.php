<?
$m_context_title = "管理設定";
$m_limit_title = "管理者限制";
$m_sysname_title= "系統名稱設定";
$m_login_title = "登入設定";
$m_console_title = "Console 設定";
$m_snmp_title = "SNMP Settings";
$m_ping_title = "Ping 控制設定";
$m_login_name		="登入名稱";
$m_old_password		="舊密碼";
$m_new_password		="新密碼";
$m_confirm_password	="確認密碼";
$m_status = "狀態";
$m_enable = "啟用";
$m_console_protocol = "Console 協定";
$m_telnet = "Telnet";
$m_ssh = "SSH";
$m_timeout = "逾時";
$m_1min = "1分鐘";
$m_3mins = "3分鐘";
$m_5mins = "5分鐘";
$m_10mins = "10分鐘";
$m_15mins = "15分鐘";
$m_never = "永遠";
$m_snmp_public	="共用公眾字串";
$m_snmp_private	="私人公眾字串";
$m_trap = "Trap";
$m_trap_server_ip	="Trap Server IP位址";
$m_trap_type = "Trap 類型";
$m_admin_ap_with_lan = "透過無線網路管理無線基地台";
$m_limit_admin_vid = "管理者VLAN ID 限制";
$m_limit_admin_ip = "管理者 IP限制";
$m_ip_range = "IP 範圍";
$m_b_add = "新增";
$m_id = "項目";
$m_from = "從";
$m_to = "至";
$m_del = "刪除";
$m_sysname="系統名稱";
$m_location="位置";

$url_redir=query("/runtime/web/display/url_redir");
if($url_redir==1)
{
$a_enable_limit_admin_status="If Limit Administrator Status enable , VLAN Status, Web redirection and Network Access Protection Status will be disable !";
}
else
{
	$a_enable_limit_admin_status="If Limit Administrator Status enable , VLAN Status and Network Access Protection Status will be disable !";	
}
$a_empty_ip_list = "Please add Limit Admin IP Range!";
$a_disable_limit_ip = "Limit Admin IP will be disabled if the Limit Admin IP rule list is null!";
$a_empty_login_name	="請輸入登入名稱。";
$a_invalid_login_name	="登入名稱包含無效字元。請再確認。";
$a_invalid_password = "密碼不符! \\n 請重新輸入。";
$a_invalid_new_password	="新密碼包含無效字元。請在確認。";
$a_password_not_matched	="新密碼與確認密碼不符。";
$a_empty_snmp_public ="請輸入私人公眾字串。";
$a_empty_snmp_private="請輸入共用公眾字串。";
$a_invalid_trap_server_ip ="無效IP位址!";
$a_invalid_ip ="無效IP位址!";
$a_invalid_admin_vid		="管理者VID 數值限制範圍從 1 ~ 4094。";
$a_invalid_ip_range = "IP的犯為錯誤! \\n 請再確認。";
$a_max_ip_table		= "最大的IP範圍數值為4!";
$a_empty_sysname	= "系統名稱欄位不可為空白。";
$a_invalid_sysname	= "系統名稱欄位包含一些無效的字元。請再確認。";
$a_first_blank_sysname	= "系統名稱的第一個字元不可以為空白。";
$a_empty_location	= "位置欄位不可為空白。";
$a_invalid_location	= "位置欄位包含一些無效的字元。請再確認。";
$a_first_blank_location	= "位置的第一個字元不可以為空白。";
$a_invalid_user_name	= "使用者名稱欄位包含一些無效的字元。請再確認。";
$a_first_blank_user_name	= "使用者名稱的第一個字元不可以為空白。";
$a_first_blank_public	= "The first character of Public Community String can't be blank.";
$a_first_blank_private	= "The first character of Private Community String can't be blank.";
?>
