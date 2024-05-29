<?
$MAX_RULES=query("/lan/dhcp/server/pool:1/staticdhcp/max_client");
if ($MAX_RULES==""){$MAX_RULES=25;}	
$m_context_title = "静态池设置";
$m_srv_enable = "功能启用/禁用";
$m_disable = "禁用";
$m_enable = "启用";
$m_dhcp_srv = "DHCP服务器控制";
$m_dhcp_pool = "静态池设置";
$m_computer_name = "主机名";
$m_ipaddr = "分配的IP";
$m_macaddr = "分配的MAC地址";
$m_ipmask = "子网掩码";
$m_gateway = "网关";
$m_wins = "Wins";
$m_dns = "DNS";
$m_m_domain_name = "域名";
$m_on = "开";
$m_off = "关";
$m_status_enable = "状态";
$m_mac = "MAC地址";
$m_ip = "IP地址";
$m_state = "陈述";
$m_edit = "编辑";
$m_del = "删除";

$a_invalid_host		= "无效主机名!";
$a_invalid_ip		= "无效IP地址!";
$a_invalid_mac		= "无效MAC地址!";
$a_max_mac_num = "访问控制列表的最大数值是".$MAX_RULES."!";
$a_same_ip = "已存在相同的IP地址项。请更换IP地址。";
$a_same_mac = "已有相同MAC地址的条目存在，\\n请更改MAC地址。";
$a_invalid_netmask	= "无效子网掩码!";
$a_invalid_gateway	="无效网关!";
$a_invalid_wins	= "无效Wins!";
$a_invalid_dns	="无效DNS!";
$a_invalid_domain_name	= "无效域名!";
$a_invalid_lease_time	= "无效DHCP租借时间!";
$a_entry_del_confirm = "您确定要删除该条目？";
?>
