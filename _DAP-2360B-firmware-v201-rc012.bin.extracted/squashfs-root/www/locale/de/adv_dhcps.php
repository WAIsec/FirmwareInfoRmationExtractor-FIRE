<?
$MAX_RULES=query("/lan/dhcp/server/pool:1/staticdhcp/max_client");
if ($MAX_RULES==""){$MAX_RULES=25;}	
$m_context_title = "Statische Adressenpool-Einstellungen";
$m_srv_enable = "Funktion Aktivieren/Deaktivieren";
$m_disable = "Deaktivieren";
$m_enable = "Aktivieren";
$m_dhcp_srv = "DHCP-Serversteuerung";
$m_dhcp_pool = "Statische Adressenpool-Einstellung";
$m_computer_name = "Computername";
$m_ipaddr = "Zugewiesene IP";
$m_macaddr = "Zugewiesene MAC-Adresse";
$m_ipmask = "Subnetzmaske";
$m_gateway = "Gateway";
$m_wins = "Wins";
$m_dns = "DNS";
$m_m_domain_name = "Domänenname";
$m_on = "EIN";
$m_off = "AUS";
$m_status_enable = "Status";
$m_mac = "MAC-Adresse";
$m_ip = "IP Adresse";
$m_state = "Status";
$m_edit = "Bearbeiten";
$m_del = "Löschen";

$a_invalid_host		= "Ungültiger Computername!";
$a_invalid_ip		= "Ungültige IP-Adresse!";
$a_invalid_mac		= "Ungültige MAC-Adresse!";
$a_max_mac_num = "Die maximale Anzahl von Access Control Lists (Zugriffssteuerungslisten) ist ".$MAX_RULES."!";
$a_same_ip = "There is an existent entry with the same IP Address.\\n Please change the IP Address.";
$a_same_mac = "Ein Eintrag mit derselben MAC-Adresse existiert bereits.\\n Ändern Sie bitte die MAC-Adresse.";
$a_invalid_netmask	= "Ungültige Subnetzmaske!";
$a_invalid_gateway	="Ungültiges Gateway!";
$a_invalid_wins	= "Ungültiger WINS!";
$a_invalid_dns	="Ungültiger DNS !";
$a_invalid_domain_name	= "Ungültiger Domänenname!";
$a_invalid_lease_time	= "Ungültige DHCP-Lease-Zeit!";
$a_entry_del_confirm = "Möchten Sie diesen Eintrag wirklich löschen?";
?>
