<?
$m_context_title = "Administrationseinstellungen";
$m_limit_title = "Administrator einschränken";
$m_sysname_title= "Systemnameneinstellungen";
$m_login_title = "Anmeldeeinstellungen";
$m_console_title = "Konsoleneinstellungen";
$m_snmp_title = "SNMP-Einstellungen";
$m_ping_title = "Ping-Steuerungseinstellung";
$m_login_name		="Anmeldename";
$m_old_password		="Altes Kennwort";
$m_new_password		="Neues Kennwort";
$m_confirm_password	="Kennwort bestätigen";
$m_status = "Status";
$m_enable = "Aktivieren";
$m_console_protocol = "Konsolenprotokoll";
$m_telnet = "Telnet";
$m_ssh = "SSH";
$m_timeout = "Timeout";
$m_1min = "1 Min";
$m_3mins = "3 Mins";
$m_5mins = "5 Mins";
$m_10mins = "10 Mins";
$m_15mins = "15 Mins";
$m_never = "Nie";
$m_snmp_public	="Öffentlicher Community String";
$m_snmp_private	="Privater Community String";
$m_trap = "Trap";
$m_trap_server_ip	="Trap Server-IP";
$m_trap_type = "Trap-Typ";
$m_admin_ap_with_lan = "AP-Administration mit WLAN ";
$m_limit_admin_vid = "Administrator-VLAN-ID einschränken";
$m_limit_admin_ip = "Administrator-IP einschränken";
$m_ip_range = "IP-Bereich";
$m_from = "Von";
$m_to = "Bis";
$m_b_add = "Hinzufügen";
$m_id = "Element";
$m_from = "Von";
$m_to = "Bis";
$m_del = "Löschen";
$m_sysname="Systemname";
$m_location="Standort";


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
$a_empty_login_name	="Geben Sie bitte den Anmeldenamen ein.";
$a_invalid_login_name	="Der Anmeldename enthält ungültige Zeichen. Bitte prüfen Sie ihn.";
$a_invalid_password = "Kennwörter stimmen nicht überein. \\n Versuchen Sie es bitte noch einmal.";
$a_invalid_new_password	="Das neue Kennwort enthält ungültige Zeichen. Bitte prüfen Sie es.";
$a_password_not_matched	="Das neue Kennwort und das bestätigte Kennwort stimmen nicht überein.";
$a_empty_snmp_public ="Geben Sie bitte einen privaten Community String ein.";
$a_empty_snmp_private="Geben Sie bitte einen öffentlichen Community String ein.";
$a_invalid_trap_server_ip ="Ungültige IP-Adresse!";
$a_invalid_ip ="Ungültige IP-Adresse!";
$a_invalid_admin_vid		="Der VID-Wertebereich zur Einschränkung des Administrators liegt zwischen 1 und 4094.";
$a_invalid_ip_range = "Die Angabe des IP-Bereichs ist nicht korrekt.\\n Bitte überprüfen Sie Ihn.";
$a_max_ip_table		= "Die maximale Anzahl von IP-Bereichslisten ist 4!";
$a_empty_sysname	= "Das Systemnamensfeld darf nicht leer sein.";
$a_invalid_sysname	= "Das Feld 'Systemname' enthält ungültige Zeichen. Bitte überprüfen Sie ihn.";
$a_first_blank_sysname	= "Das erste Zeichen des Systemnamens darf kein Leerzeichen sein.";
$a_empty_location	= "Das Standortfeld darf nicht leer sein.";
$a_invalid_location	= "Das Standortfeld enthält ungültige Zeichen. Bitte prüfen Sie es.";
$a_first_blank_location	= "Das erste Zeichen des Standortes darf kein Leerzeichen sein.";
$a_invalid_user_name	= "Das Feld 'Benutzername' enthält ungültige Zeichen. Bitte prüfen Sie es.";
$a_first_blank_user_name	= "Das erste Zeichen des Anmeldenamens darf kein Leerzeichen sein.";
$a_first_blank_public	= "The first character of Public Community String can't be blank.";
$a_first_blank_private	= "The first character of Private Community String can't be blank.";
?>
