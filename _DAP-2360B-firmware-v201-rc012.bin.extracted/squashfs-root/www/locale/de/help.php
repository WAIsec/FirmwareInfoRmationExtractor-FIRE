<?
$runtime_ipv6=query("/runtime/web/display/ipv6");    
$cfg_ipv6=query("/inet/entry:1/ipv6/valid");

$head_bsc = "Grundeinstellungen";

$title_bsc_wlan ="Funkeinstellungen";
$bsc_wlan_msg ="Ermöglichen Ihnen die drahtlosen Einstellungen zu ändern, um ein existierendes Funknetz einzufügen oder Ihrem Funknetzwerk anzupassen.";
$bsc_wireless_band ="Frequenzband";
if($TITLE=="DAP-1353" || $TITLE=="DAP-2360")
{
	$bsc_wireless_band_msg ="Operating frequency band. Choose 2.4GHz for visibility to legacy devices".
	" and for longer range.";
}
else if($TITLE=="DAP-2690")
{
$bsc_wireless_band_msg ="Operating frequency band. Choose 2.4GHz for visibility to legacy devices".
" and for longer range. Choose 5GHz for least interference; interference can hurt performance. This ".
"AP will operate two band at a time.";
}
else
{
$bsc_wireless_band_msg ="Betriebsfrequenzband. Wählen Sie 2,4 GHz für die Sichtbarkeit von Legacy-Geräten und für eine größere Abdeckung. "."Wählen Sie 5 GHz für weniger Interferenzen. Diese können die Leistung beeinträchtigen. Diese AP betreibt jeweils nur ein Frequenzband gleichzeitig.";
}
$bsc_application="Application";
$bsc_application_msg="This option allows the user to choose for indoor or outdoor mode at the 5G Band.";
$bsc_mode = "Modus";
if($cfg_ipv6=="1")
{
    $bsc_mode_msg = "Select a function mode to configure your wireless network. Function modes include".
" Access Point, WDS (Wireless Distribution System) with AP, WDS,  Wireless Client(Only Support IPv4). Functio
n modes are designed to support various wireless".
" network topology and applications.";
}
else
{
	if($TITLE=="DAP-1353")
	{
	$bsc_mode_msg = "Select a function mode to configure your wireless network. Function modes include".
" Access Point, WDS (Wireless Distribution System) with AP, WDS,  Wireless Client and AP Repeater. Function modes are designed to support various wireless".
" network topology and applications.";
	}
	else
	{
$bsc_mode_msg = "Wählen Sie einen Funktionsmodus, um Ihr Funknetz zu konfigurieren. Zu den Funktionsmodi gehören AP, WDS (Wireless Distribution System) mit AP, "."WDS und Funk-Client. Funktionsmodi dienen zur Unterstützung verschiedener drahtloser Netzwerktopologien und Anwendungen.";
	}
}
$bsc_network_name = "Netzwerkname(SSID)";
$bsc_network_name_msg = "Als Service Set Identifier (SSID) oder auch Network Name (Netzwerkname) bezeichnet man ein spezifisches WLAN-Netzwerk. Die Werkeinstellung "."ist 'dlink'. Die SSID kann problemlos zur Verbindung mit einem vorhandenen Funknetzwerk geändert oder zum Aufbau eines neuen Funknetzes verwendet werden.";
$bsc_ssid_visibility = "SSID-Sichtbarkeit";
$bsc_ssid_visibility_msg = "Geben Sie an, ob die SSID Ihres Funknetzes sichtbar sein soll oder nicht. Standardmäßig ist die SSID-Sichtbarkeit auf Aktivieren gesetzt."." Das ermöglicht drahtlosen Clients das Funknetz zu erkennen. Wenn Sie diese Einstellung auf Deaktivieren setzen, "."können drahtlose Clients das Funknetz nicht mehr erkennen und sind nur in der Lage, eine Verbindung herzustellen, wenn für sie die korrekte SSID eingegeben wird.";
$bsc_auto_channel="Automatische Kanalwahl";
$bsc_auto_channel_msg="Wenn Sie die automatische Kanalsuche markieren, sucht der AP bei jedem Start automatisch nach dem zur Nutzung besten Kanal. Dies ist standardmäßig aktiviert.";
$bsc_channel="Kanal";
$bsc_channel_msg ="Geben Sie die Kanaleinstellung für den ".query("/sys/hostname")." an. Der AP ist standarmäßig auf automatische Kanalsuche eingestellt. Sie können den"." Kanal ändern, damit die Kanaleinstellung zu einem vorhandenen Funknetz passt oder um "."das drahtlose Netz Ihren Wünschen entsprechend einzurichten."; 
$bsc_channel_width="Kanalbreite";
if($TITLE == "DAP-1353" || $TITLE == "DAP-2360")
{
$bsc_channel_width_msg="Ermöglicht die Wahl der gewünschten Kanalbreite. Wählen Sie 20 MHz, wenn Sie keine 802.11n drahtlosen Clients verwenden. Auto 20/40 MHz ermöglicht "."Ihnen die Verwendung sowohl von 802.11n als auch von Nicht-802.11n Standards für drahtlose Geräte in Ihrem Netzwerk.";
}
else
{
$bsc_channel_width_msg="Allows selection of the channel width you would like to operate in.20 MHz and Auto 20/40MHz allow both 802.11n ".
"and non-802.11n wireless devices on your network when the wireless mode is Mixed 802.11 b/g/n in 2.4G and Mixed 802.11 a/n in 5G.802.11n ".
"wireless devices are allowed to transmit data using 40 MHz when the channel width is Auto 20/40 MHz";
}
$bsc_authentication="Authentifizierung";
$bsc_authentication_msg="Sie können zur zusätzlichen Sicherheit in einem Funknetz die Datenverschlüsselung aktivieren. Dazu stehen Ihnen "."mehrere Authentifizierungstypen zur Verfügung. Standardmäßig ist Open System für die Authentifizierung angegeben.";
$bsc_open_sys="Open System";
$bsc_open_sys_msg="Bei der Authentifizierung 'Open System'können nur die drahtlosen Clients mit dem gleichen WEP-Schlüssel im Funknetz miteinander kommunizieren. Der Access Point bleibt für alle Geräte im Netz sichtbar.";
$bsc_shared_key="Shared Key";
$bsc_shared_key_msg="Bei der Authentifizierung 'Shared Key' ist der Access Point im Funknetz nicht sichtbar, außer für die drahtlosen Clients, die den gleichen WEP-Schlüssel haben.";
$bsc_personal_type="WPA-Personal/WPA2-Personal/WPA-Auto-Personal";
$bsc_personal_type_msg="Wi-Fi Protected Access autorisiert und authentifiziert Benutzer im Funknetz. Zum Schutz des Netzwerks wird die TKIP-Verschlüsselung unter Verwendung eines so genannten Pre-Shared Key verwendet, einem Verschlüsselungsverfahren,"." bei dem die Schlüssel vor der Kommunikation beiden Teilnehmern bekannt sein müssen. WPA und WPA2 verwenden unterschiedliche Algorithmen. WPA-Auto erlaubt sowohl WPA als auch WPA2.";
$bsc_periodrical_change_key = "Periodical Key Change";
$bsc_periodrical_change_key_msg = "The dap-2590 supports periodical change key. Periodical change key can generate WPA random key which start at time of activated from. "."Administrator can use email to get current key and Periodical change key information.";
$bsc_enterprise_type="WPA-Enterprise/ WPA2-Enterprise/ WPA-Auto-Enterprise";
if(query("/runtime/web/display/accounting_server") == "1")
{
	$bsc_enterprise_type_msg="Wi-Fi Protected Access authorizes and authenticates users onto the wireless network.".
"WPA uses stronger security than WEP and is based on a key that changes automatically at a regular interval.".
" It requires a RADIUS server in the network. Accounting server, Backup server and Backup Accounting server are optional.WPA and WPA2 uses different algorithm. WPA-Auto allows both WPA andWPA2.";
}
else
{
$bsc_enterprise_type_msg="Wi-Fi Protected Access autorisiert und authentifiziert Benutzer im Funknetz. WPA bietet eine stärkere Sicherheit als WEP und absiert auf dynamischen Schlüsseln, "."die in regelmäßigen Zeitabständen automatisch geändert werden. Als Authentifizierungsinstanz ist dazu ein RADIUS-Server im Netz erforderlich. WPA und WPA2 verwenden unterschiedliche Algorithmen. WPA-Auto erlaubt sowohl WPA als auch WPA2.";
}
$bsc_8021x_type = "802.1x";
$bsc_8021x_type_msg = "If you use 802.1x you do not need to supply a WEP key.This is an access control system used for Ethernet and wireless networks and a key is generated automatically from a server or switch."." In order to use 802.1x you must have the system running on implementing PAE. After applying the settings and restarting the Access Point, you must choose to use a radius server or a local server or switch for Authentication. "."Use the Encryption menu to select where authentication information comes from and Key Update Interval.";
$bsc_network_access="Netzwerkzugriffschutz";
$bsc_network_access_msg="Network Access Protection (NAP) ist eine Funktion des Windows Server 2008. Der integrierte Netzwerkszugriffschutz (Network Access Protection, NAP) bewertet fortlaufend die Zustände der Clients und steuert den "."Zugriff auf Netzwerkressourcen auf der Grundlage der Identität des Client-Computers und der Einhaltung unternehmensweiter Richtlinien für eine verantwortungsvolle Unternehmensführung und -kontrolle. NAP ermöglicht es Netzwerkadministratoren, Netzwerkzugriffebenen im Detail "."festzulegen und das auf der Basis der Identität eines Client, der Gruppen, zu denen der Client gehört, und dem Maß, in dem dieser Client die Richtlinien einhält. Sollte eine Nichteinhaltung durch einen Client festgestellt werden, "."bietet NAP Möglichkeiten, den Client automatisch wieder zur Einhaltung dieser Richtlinien zu bringen und dann seinen Grad an Netzwerkzugriffsmöglichkeiten dynamisch zu steigern.";
$bsc_mac_clone = "MAC Clone";
$bsc_mac_clone_msg = "Assign a mac address to the AP which is set to APC mode, for the communication with another AP as a network card. You can entry any address or choose an address in the scan list if select \"manually\". \"Auto\" means to assign the first mac address in that AP detected.";

$title_bsc_lan = "LAN-Einstellungen";
$title_bsc_lan_msg = "Mithilfe der LAN-Einstellungen, auch als private Einstellungen bezeichnet, können Sie die LAN-Schnittstelle des ".
.query("/sys/hostname")." konfigurieren. Die LAN-IP-Adresse ist privat für Ihr internes Netzwerk und im Internet nicht sichtbar. Die Standard-IP-Adresse ist 192.168.0.50 mit einer Subnetzmaske 255.255.255.0.";
$bsc_get_ip_from = "IP abrufen von";
$bsc_get_ip_from_msg = "Die Werkseinstellung ist \"Statische IP (Manuell)\". Das ermöglicht die manuelle Konfiguration der IP-Adresse des ".
.query("/sys/hostname")." in Übereinstimmung mit dem LAN (Local Area Network). Aktivieren Sie 'Dynamische IP (DHCP)', damit der DHCP-Host dem Access Point automatisch eine IP-Adresse zuweist, die dem gegebenen Local Area Network entspricht.";
$bsc_ip_address = "IP-Adresse";
$bsc_ip_address_msg = "Die Standard-IP-Adresse ist 192.168.0.50. Sie kann zur Übereinstimmung mit einem vorhandenen LAN geändert werden. Beachten Sie bitte, dass die IP-Adresse jedes Geräts im LAN innerhalb des gleichen IP-Adressbereichs und der gleichen Subnetzmaske sein muss. So muss beispielsweise bei der Standard-IP-Adresse des ".
.query("/sys/hostname")." jede dem AP zugeordnete Station mit einer eindeutigen IP-Adresse konfiguriert sein, die in den Bereich 192.168.0.*. fällt, wobei \"*\" ein Wert von 0 bis 255 sein kann, und in diesem Fall 50 ist.";
$bsc_submask = "Subnetzmaske";
$bsc_submask_msg = "Eine Netzmaske legt fest, zu welchem Subnetz eine IP-Adresse gehört. Die Standard-Subnetzmaskeneinstellung ist 255.255.255.0.";
$bsc_gateway = "Standard-Gateway";
$bsc_gateway_msg = "Geben Sie die Gateway-IP-Adresse des lokalen Netzwerks an.";

$title_bsc_ipv6 = "IPv6 LAN Settings";
$title_bsc_ipv6_msg = "Enable IPv6 function allows you access ".query("/sys/hostname")." by an IPv6 address.";
$bsc_get_ip_from_msg_ipv6 = "The factory default setting is \"Auto\" which the host assign the AP an ipv6 address. The \"Static\" allows you to set an address manually.";
$bsc_ip_address_msg_ipv6 = "IP address can be modified here whose format is apart to eight segment by \":\". Each segment has four character: 0~9 or A~F. You can use a IPv4 address instead of the last two segment. The multicast address which starts as \"FF\" is not allowed.";
$bsc_prefix = "Prefix";
$bsc_prefix_msg = "Prefix used to determine what subnet an IP address belongs to. It must be 0~128.";
$bsc_dns_ipv6 = "DNS";
$bsc_dns_ipv6_msg = "DNS used to parse the URL to IP.";
$bsc_gateway_ipv6_msg = "Specify the gateway IP address of the local network.";

$head_adv ="Erweiterte Einstellungen";

$title_adv_per = "Leistung";
$title_adv_per_msg = "Sie können den Netzwerkfunkverkehr Ihren Erfordernissen und Wünschen anpassen, indem Sie Funkparameter im Leistungsteil entsprechend einstellen. Diese Möglichkeiten der Leistungseinstellung sind für erfahrene Benutzer gedacht, die mit 802.11 Funknetzen und Funkkonfigurationen vertraut sind.";
$adv_wireless = "Drahtlos";
$adv_wireless_msg ="Diese Option ermöglicht dem Benutzer die Aktivierung oder Deaktivierung der drahtlosen Funktion.";
$adv_wireless_mode ="Funkmodus";
if($TITLE=="DAP-1353" || $TITLE=="DAP-2360")
{
	$adv_wireless_mode_msg ="This function allows you to select different combination of clients".
	" that can be supported.Please note that when backwards compatibility is enabled for legacy ".
	"(802.11g/b) clients, degradation of 802.11n wireless performance is expected.";
}
else
{
$adv_wireless_mode_msg ="Mithilfe dieser Funktion können Sie verschiedene Client-Kombinationen auswählen. Beachten Sie bitte, dass bei Aktivierung der rückwärtigen Kompatibilität für (802.11a/g/b) Legacy-Clients eine Verschlechterung der 802.11n Funkleistung zu erwarten ist.";
}
$adv_date_rate="Datenrate";
$adv_date_rate_msg="Gibt die Grundübertragungsrate der Funkadapter im WLAN an. Der Access Point wird sie je nach der Übertragungsrate des verbundenen Geräts entsprechend anpassen. Liegen Hindernisse oder Interferenzen vor, setzt der AP die Datenrate herunter.";
$adv_beacon = "Beacon-Intervall(25-500)";
$adv_beacon_msg = "Beacon-Signale sind Datenpakete, die von einem Access Point zur Synchronisation eines Funknetzwerks gesendet werden. Setzen Sie ein höheres Beacon-Intervall, kann das helfen, den Strom eines drahtlosen Client zu sparen, "."setzen Sie es niedriger, kann das einem drahtlosen Client helfen, die Verbindung zu einem AP schneller herzustellen. Für die meisten Nutzer wird eine Einstellung von 100 Millisekunden empfohlen.";
$adv_dtim="DTIM-Intervall(1-15)";
$adv_dtim_msg="Das DTIM-Intervall gibt die Zahl der AP-Beacons zwischen jedem DTIM (Delivery Traffic Indication Message) an. Es informiert zugeordnete Stationen, Broadcast- oder Multicast-Nachrichten aufzunehmen. Sie können einen DTIM-Wertebereich von 1 bis 15 angeben. "."Der AP sendet die nächste DTIM mit dem angegebenen DTIM-Wert an Stationen, wenn irgendeine gepufferte Broadcast- oder Multicast-Nachricht vorliegt. Stationen erkennen die Beacons und werden zum Empfang dieser Nachrichten aktiviert. Standardwert für das DTIM-Intervall ist 1.";
$adv_transmit_power="Übertragungsleistung";
$adv_transmit_power_msg="Diese Einstellung legt den Leistungsgrad der drahtlosen Übertragung fest. Sie kann angepasst werden, um ein Überlagern der Funkbereichsabdeckung zwischen zwei Access Points zu eliminieren, bei denen Interferenzen Probleme bereiten. Die Optionen sind 100% (Standard), 50% (-3dB), 25% (-6dB) oder 12,5% (-9dB). Ist beispielsweise der Deckungsradius des Funknetzes für lediglich die Hälfte des Bereichs beabsichtigt, wählen Sie die Option 50%.";
$adv_wmm="WMM (Wi-Fi Multimedia)";
$adv_wmm_msg="Die Wi-Fi Multimedia-Funktion verbessert die Benutzererfahrungen für Audio-, 
und Videoanwendungen über ein Wi-Fi-Netz. WMM basiert auf einem "."Teilaspekt des IEEE 802.11e WLAN QoS-Standards. Ein Aktivieren dieser Funktion verbessert die Benutzererfahrungen für Audio- und Videoanwendungen über ein Wi-Fi-Netz.";
$adv_ack_timeout="Ack TimeOut";
if(query("/runtime/web/display/ack_timeout_range")=="0")
{
	if($TITLE=="DAP-1353" || $TITLE=="DAP-2360")
	{
		$adv_ack_timeout_msg="You can specify an Ack Timeout value range from 48~200 in 2.4GHz to effectively".
	" optimize the throughput over long distance links. The unit is in microseconds (&micro;s). The default value is set to 25&micro;s in 2.4GHz.";
	}
	else
	{
$adv_ack_timeout_msg="Sie können einen Ack Timeout-Wertebereich (Timeout für das Bestätigungspaket des Empfängers für den Sender) von 48 ~ 200 in 2,4 GHz und von 25 ~ 200 in 5 GHz Frequenzbändern "."angeben, um den Durchsatz bei Verbindungen über lange Entfernungen zu optimieren. Es handelt sich bei der Einheit um Mikrosekunden (µs). Der Standardwert ist bei 2,4 GHz Funkbändern 25 µs und bei 5 GHz Funkbändern 48 µs.";
}
}
else
{
	if($TITLE=="DAP-1353" || $TITLE=="DAP-2360")
	{
		$adv_ack_timeout_msg="You can specify an Ack Timeout value range from 64~200 in 2.4GHz to effectively".
	" optimize the throughput over long distance links. The unit is in microseconds (&micro;s). The default value is set to 64&micro;s in 2.4GHz.";
	}
else
{
	$adv_ack_timeout_msg="Sie können einen Ack Timeout-Wertebereich (Timeout für das Bestätigungspaket des Empfängers für den Sender) von 64 ~ 200 in 2,4 GHz und von 50 ~ 200 in 5 GHz Frequenzbändern "."angeben, um den Durchsatz bei Verbindungen über lange Entfernungen zu optimieren. Es handelt sich bei der Einheit um Mikrosekunden (µs). Der Standardwert ist bei 2,4 GHz Funkbändern 64 µs und bei 5 GHz Funkbändern 50 µs.";
}
}
$adv_short_gi="Kurzes GI";
$adv_short_gi_msg="Die Verwendung eines kurzen (400 ns) Guard-Intervalls kann den Durchsatz erhöhen. Sie kann jedoch aufgrund von gesteigerter Empfindlichkeit gegenüber Funkfrequenzreflektionen auch Fehlerraten in einigen Installationen erhöhen. Wählen Sie die Option, die für Ihre Installation am besten geeignet ist.";
$adv_igmp="IGMP-Snooping";
$adv_igmp_msg="IGMP (Internet Group Management Protocol) ermöglicht dem AP zwischen Routern und einem IGMP-Host (drahtlose STA) IGMP-Anfragen und Reports zu erkennen. Ist IGMP Snooping aktiviert, leitet der AP Multicast-Pakete an einen IGMP-Host basierend auf IGMP-Meldungen weiter, die den AP passieren.";
$adv_link_integrality="Link-Integrität";
$adv_link_integrality_msg="Wenn die Ethernet-Verbindung zwischen dem LAN und dem AP getrennt ist, führt das bei Aktivierung dieser Funktion dazu, dass der dem AP zugeordnete drahtlose Client automatisch von dem AP getrennt wird.";
$adv_connection_limit="Verbindungslimit";
if(query("/runtime/web/display/utilization") !="0")
{
	$utilization_string=" oder die Netzwerknutzung dieses AP übersteigt den von Ihnen angegebenen Prozentwert";
}
else
{
	$utilization_string="";
}
$adv_connection_limit_msg="Dies ist eine Option für das Load Balancing, einem System zur Lastverteilung von Netzwerkverkehr. Sie ermöglicht es, den drahtlosen Netzwerkverkehr und den Client mithilfe mehrerer ".
.query("/sys/hostname")."s gemeinsam zu nutzen. Ist diese Funktion aktiviert und die Zahl der Benutzer überschreitet das 'Benutzerlimit' ".$utilization_string.", erlaubt der AP nicht die Assoziation der Clients mit diesem AP.";
$adv_user_limit ="Benutzerlimit(0-64)";
$adv_user_limit_msg ="Geben Sie die Höchstzahl der pro Access Point zulässigen Benutzer an. Für den typischen Nutzer wird der Wert \"10\" empfohlen.";
$adv_network_utilization="Netzwerknutzung";
$adv_network_utilization_msg="Geben Sie die maximale Nutzung dieses Access Point für den Dienst an. Der ".query("/sys/hostname")." lässt keine Assoziation irgendeines neuen Client mit dem AP zu, wenn die Nutzung den vom Benutzer angegebenen Wert übersteigt. 100 % ist der empfohlene Wert.";
$adv_mcast_rate="Multicast rate";
if($TITLE=="DAP-1353" || $TITLE=="DAP-2360")
{
$adv_mcast_rate_msg="Multicast rate can adjust multicast's packet data rate. Multicast rate supports AP mode, Multi-SSID and WDS with AP mode.";
}
else
{
$adv_mcast_rate_msg="Multicast rate can adjust multicast packet data rate. Multicast rate supports".
" AP mode (2.4GHz and 5GHz), Multi-SSID and WDS with AP mode.";
}

$title_adv_mssid="Multi-SSID";
if(query("/runtime/web/display/mssid_index4")==1)
{
	$title_adv_mssid_msg="One primary SSID and at most three guest SSIDs ".
	"can be configured to allow virtual segregation stations which share the same channel.";
}
else
{
$title_adv_mssid_msg="Mehrere SSIDs werden nur im AP-Modus unterstützt. Es können eine primäre SSID und höchstens sieben Gast-SSIDs konfiguriert werden, um virtuelle Segregationsstationen zuzulassen, die sich den gleichen Kanal teilen.";
}
$adv_mssid_msg1="Darüber hinaus können Sie den VLAN-Status aktivieren, damit der ".query("/sys/hostname")." mit VLAN-unterstützten Switches oder anderen Geräten verwendet werden kann.";
$adv_mssid_msg2="Wenn die primäre SSID auf 'Open System ohne Verschlüsselung' gesetzt ist, können die Gast-SSIDs nur auf Keine Verschlüsselung, WEP, WPA-Personal oder WPA2-Personal gesetzt werden.";
$adv_mssid_msg3="Wenn die Sicherheit der primären SSID auf Open oder Shared System WEP-Schlüssel gesetzt ist, können die Gast-SSIDs 'Keine Verschlüsselung' oder drei andere WEP-Schlüssel, WPA-Personal oder WPA2-Personal verwenden.";
$adv_mssid_msg4="Wird die Sicherheit der primären SSID auf WPA-Personal, WPA2-Personal oder WPA-Auto-Personal gesetzt, werden die Slots 2 und 3 genutzt. Die Gast-SSIDs können so eingerichtet werden, dass sie 'Keine Verschlüsselung', WEP oder WPA-Personal verwenden.";
$adv_mssid_msg5="Wenn die Sicherheit der primären SSID auf WPA-Enterprise, WPA2-Enterprise oder WPA-Auto-Enterprise gesetzt wird, können die Gast-SSIDs jede Sicherheitsoption verwenden.";

$title_adv_vlan="VLAN";
$title_adv_vlan_msg="Der ".query("/sys/hostname").
" unterstützt VLANs (Virtuelle LANs). VLANs können mit einem Namen und der VID (VLAN ID) erstellt werden. Mgmt (TCP Stack), LAN, Primäre/Multi-SSID und WDS-Verbindung können einem VLAN zugeordnet werden, weil es sich bei diesen um physische Ports handelt. Jedem Datenpaket, das bei dem ".query("/sys/hostname")." ohne ein VLAN-Tag eingeht, wird ein solches in Form eines PVID zugeordnet.";

$title_adv_intrusion="Angriffsschutz im drahtlosen Datenverkehr";
$title_adv_intrusion_msg="Der".query("/sys/hostname")." bietet Benutzern die Möglichkeit, einen Angriffsschutz im drahtlosen Datenverkehr einzurichten.";

$title_adv_scheduling="Zeitplanungsoptionen";
$title_adv_scheduling_msg="Die zeitliche Planung des Funkbetriebs Ihres ".query("/sys/hostname")." kann nach Wochen oder einzelnen Tagen erfolgen.";

$title_adv_qos="QoS";
$title_adv_qos_msg="QoS steht für \"Quality of Service\" für intelligente drahtlose Stream-Handhabung, eine Technologie, die zur Verbesserung der Nutzung eines Funknetzwerks durch Priorisierung des Datenverkehrs von unterschiedlichen Anwendungen dient.";
if($TITLE == "DAP-2360" || $TITLE == "DAP-2690" || $TITLE == "DAP-3690")
{
	$adv_enable_qoS="QoS(Quality of Service)";
}
else
{
$adv_enable_qoS="QoS aktivieren";
}
$adv_enable_qoS_msg="Aktivieren Sie diese Option, wenn Sie möchten, dass QoS Ihren Datenverkehr priorisiert.";
$adv_enable_qoS_msg1="Prioritätsklassifizierer.";
$adv_http="HTTP";
$adv_http_msg="Ermöglicht dem Access Point die Erkennung von HTTP-Übertragungen für viele gebräuchliche Audio- und Video-Streams sowie deren Priorisierung über anderen Datenverkehr. Derartige Streams werden häufig von digitalen Media Playern verwendet.";
$adv_automatic="Automatisch";
$adv_automatic_msg="Wenn diese Option aktiviert ist, priorisiert der Access Point automatisch auf Basis des Verhaltens der "."Datenverkehr-Streams diejenigen Datenverkehr-Streams, die er andernfalls nicht erkennt. Dadurch wird die Priorität "."von Streams genommen, die Massenübertragungsmerkmale aufweisen, wie beispielsweise Dateiübertragungen, während "."interaktiver Datenverkehr wie Spiele oder VoIP bei normaler Priorität laufen.";
$adv_qos_rule="QoS-Regeln";
$adv_qos_rule_msg="Eine QoS-Regel identifiziert einen bestimmten Nachrichtenfluss und weist diesem Fluss eine Priorität zu. Bei den meisten "."Anwendungen gewährleisten die Prioritätsklassifizierer die richtigen Prioritäten und es sind keine spezifischen QoS-Regeln erforderlich.";
$adv_qos_rule_msg1="QoS unterstützt Überschneidungen zwischen Regeln. Wenn mehr als eine Regel für einen bestimmten Nachrichtenfluss passt, wird die Regel mit der höchsten Priorität verwendet.";
$adv_name="Name";
$adv_name_msg="Geben Sie der Regel einen aussagefähigen Namen.";
$adv_priority="Priorität";
$adv_priority_msg="Die Priorität des Nachrichtenflusses wird hier eingegeben. Es werden vier Prioritäten definiert:";
$adv_priority_msg1="* HG: Hintergrund (am wenigsten dringend).";
$adv_priority_msg2="* BE: Bestmöglich.";
$adv_priority_msg3="* VI: Video.";
$adv_priority_msg4="* VO: Sprache (höchste Priorität).";
$adv_protocol="Protokoll";
$adv_protocol_msg="Das von den Nachrichten verwendete Protokoll.";
$adv_host_1_ip="Host 1 IP-Bereich";
$adv_host_1_ip_msg="Die Regel trifft auf einen Fluss von Nachrichten zu, für den die IP-Adresse eines Computers innerhalb des hier festgelegten Bereichs liegt.";
$adv_host_1_port="Host 1 Port-Bereich";
$adv_host_1_port_msg="Die Regel trifft auf einen Fluss von Nachrichten zu, dessen Portnummer von Host 1 innerhalb des hier festgelegten Bereichs liegt.";
$adv_host_2_ip="Host 2 IP-Bereich";
$adv_host_2_ip_msg="Die Regel trifft auf einen Fluss von Nachrichten zu, für den die IP-Adresse des anderen Computers innerhalb des hier festgelegten Bereichs liegt.";
$adv_host_2_port="Host 2 Port-Bereich";
$adv_host_2_port_msg="Die Regel trifft auf einen Fluss von Nachrichten zu, dessen Portnummer von Host 2 innerhalb des hier festgelegten Bereichs liegt."; 
$title_adv_url="Web Redirection";
$title_adv_url_msg="";
$adv_enable_url="Enable Web Redirection";
$adv_enable_url_msg="This check box allows the user to enable the Web Redirection function.";
$adv_url_username="User Name";  
$adv_url_username_msg="Enter a user name to authenticate user access to the Web Redirection.";  
$adv_url_password="Password";
$adv_url_password_msg="Enter a password to authenticate user access to the Web Redirection.";
$adv_url_status="Status";
$adv_url_status_msg="Use the drop-down menu to toggle between enabling and disabling the Web Redirection.";
$adv_url_account_list="Web Redirection Account List";
$adv_url_account_list_msg="After enabling Status, enter a User Name and a Password in the Add Web Redirection Account section,".
" and then click the Save button. The newly-created Web Redirection will appear in this Web Redirection Account List.".
" Use the radio buttons to enable or disable the Web Redirection account, or click the icon in the delete column to remove the Web Redirection account.";
   

$title_adv_ap_array="AP Array";
$title_adv_ap_array_msg="An AP array is a set of devices on a network that are organized into a single group to increase ease of management.";
$adv_enable_array="Enable AP Array"; 
$adv_enable_array_msg="This check box allows the user to enable the AP array function. The three modes that are available are Master, ".
"Backup Master, and Slave. APs in the same array will use the same configuration. The configuration will sync the Master AP to the ".
"Slave AP and the Backup Master AP when a Slave AP and a Backup Master AP join the AP array.";
$adv_ap_array_name="AP Array Name";
$adv_ap_array_name_msg="Enter a user-selected name for the AP array you have created.";
$adv_ap_array_pwd="AP Array Password";
$adv_ap_array_pwd_msg="Enter a user-selected password that will be used to access the AP array you have created.";
$adv_scan_ap_array_list="Scan AP Array List";
$adv_scan_ap_array_list_msg="Click this button to initiate a scan of all the available APs currently on the network.";
$adv_ap_array_list="AP Array List";
$adv_ap_array_list_msg="This table displays the current AP array status for the following parameters: Array Name,".
" Master IP, MAC, Master, Backup Master, Slave, and Total.";
$adv_current_array_members="Current Array Members";
$adv_current_array_members_msg="This table displays all the current array members. The ".query("/sys/hostname")." AP array".
" feature supports up to eight AP array members.";
$adv_syn_parameters="Synchronized Parameters";
$adv_syn_parameters_msg="Choose Synchronized Parameters of  AP Array . Click \"Clear all \"  button to clear all Synchronized Parameters .";

$title_adv_int_radius_server="Internal RADIUS Server";
$title_adv_int_radius_server_msg="The ".query("/sys/hostname")." has a built-in RADIUS server.";
$adv_user_name="User Name";
$adv_user_name_msg="Enter a user name to authenticate user access to the internal RADIUS server.";
$adv_pwd="Password"; 
$adv_pwd_msg="Enter a password to authenticate user access to the internal RADIUS server.";
$adv_status="Status";
$adv_status_msg="Use the drop-down menu to toggle between enabling and disabling the internal RADIUS server.";
$adv_radius_account_list="RADIUS Account List";
$adv_radius_account_list_msg="After enabling Status, enter a User Name and a Password in the ".
"Add RADIUS Account section, and then click the Save button. The newly-created internal RADIUS ".
"will appear in this RADIUS Account List. Use the radio buttons to enable or disable the ".
"RADIUS account, or click the icon in the delete column to remove the RADIUS account.";    

$title_adv_arp_spoofing="ARP Spoofing Prevention";
$title_adv_arp_spoofing_msg="The ARP Spoofing Prevention feature allows users to add IP/MAC address mapping to prevent arp spoofing attack.";
$adv_arp_spoofing="ARP Spoofing Prevention";
$adv_arp_spoofing_msg="This check box allows you to enable the arp spoofing prevention function.";
$adv_gateway_ip="Gateway IP Address";
$adv_gateway_ip_msg="Enter a gateway IP address.";
$adv_gateway_mac="Gateway MAC Address";
$adv_gateway_mac_msg="Enter a gateway MAC address.";
$head_dhcp="DHCP-Server";
$head_dhcp_msg="Der DHCP (Dynamic Host Control Protocol) Server weist IP-Adressen Stationen zu, die IP-Adressen während der Anmeldung im Funknetz "."anfordern. Stationen müssen als DHCP-Clients konfiguriert werden, um IP-Adressen automatisch zu erhalten. Der Standardwert für die DHCP-Serversteuerung ist \"Deaktiviert\".";

$title_dhcp_dynamic_pool="Dynamische Adressenpool-Einstellungen";
$title_dhcp_dynamic_pool_msg="Der DHCP-Adressenpool legt den Bereich für die IP-Adressen fest, die bestimmten Stationen im Netzwerk zugeordnet werden können. Ein Pool dynamischer Adressen ermöglicht Funkstationen den Empfang einer verfügbaren IP mit Lease-Zeitkontrolle.";
$dhcp_server_control="DHCP Server Control";
$dhcp_server_control_msg="The default setting for DHCP Server is disable.";
$dhcp_ip_assigned="IP zugewiesen von";
$dhcp_ip_assigned_msg="Der Beginn der IP-Adressen im Pool, die drahtlosen Stationen zur Verfügung stehen, kann vom Benutzer vorgegeben werden.";
$dhcp_range_of_pool="Poolbereich (1-254)";
$dhcp_range_of_pool_msg="Benutzer können den verfügbaren IP-Adressenbereich angeben. IP-Adressen sind Schrittgrößen der im Feld \"IP zugewiesen von\" angegebenen IP-Adresse.";
$dhcp_submask="Subnetzmaske";
$dhcp_submask_msg="Geben Sie die Subnetzmaske der im Feld \"IP zugewiesen von\" angegebenen IP-Adresse an.";
$dhcp_gateway="Gateway";
$dhcp_gateway_msg="Geben Sie die Gateway-Adresse für das Funknetz an.";
$dhcp_wins="WINS";
$dhcp_wins_msg="Geben Sie die WINS-Adresse für das Funknetz an.";
$dhcp_dns="DNS";
$dhcp_dns_msg="Geben Sie die DNS-Adresse für das Funknetz an.";
$dhcp_domain="Domänenname";
$dhcp_domain_msg="Geben Sie die Domänennamenadresse für das Funknetz an.";
$dhcp_lease_time="Lease-Zeit";
$dhcp_lease_time_msg="Benutzer können Stationen festlegen und durch Angabe von Lease-Zeiten der IP-Adresse eine Zeitdauer zuordnen.";

$title_dhcp_static_pool="Statische Adressenpool-Einstellungen";
$title_dhcp_static_pool_msg="Der DHCP-Adressenpool legt den Bereich für die IP-Adressen fest, die bestimmten Stationen im Netzwerk zugeordnet werden können. Ein Pool statischer Adressen ermöglicht Funkstationen den Empfang einer verfügbaren IP ohne Lease-Zeitkontrolle.";
$host_name="Host Name";
$host_name_msg="Create a name for the rule that is meaningful to you.";
$dhcp_assigned_ip="Zugewiesene IP";
$dhcp_assigned_ip_msg="Geben Sie die IP-Adresse an, die einer Station mit einer MAC-Adresse zugewiesen werden soll, die im Feld \"Zugewiesene MAC-Adresse\" angegeben ist.";
$dhcp_assigned_mac="Zugewiesene MAC-Adresse";
$dhcp_assigned_mac_msg="Geben Sie die MAC-Adresse der Station an, die die Zuweisung anfordert.";

$title_dhcp_current_ip="Aktuelle IP-Zuordnung";
$title_dhcp_current_ip_msg="Eine Liste mit MAC-Adressen, IP-Adressen (von einem DHCP-Server mithilfe dynamischer oder statischer Adressen zugewiesen) und Lease-Zeiten der dem ".
.query("/sys/hostname")." zugeordneten Funkstationen.";


$head_filters="Filter";
$head_filters_msg="Die Filterfunktion umfasst MAC-Adressenfilterung und eine drahtlose LAN-Partition. Die MAC-Adressenfilterung sperrt oder akzeptiert den Zugriff "."durch Identifizierung der angegebenen MAC-Adressen. Eine drahtlose LAN-Partition kann den Zugriff von drahtlosen oder kabelgebundenen Netzen akzeptieren oder verweigern.";

$title_filters_wireless_access="Drahtlose Zugriffseinstellungen";
$filters_wireless_band="Frequenzband";
if($TITLE=="DAP-1353" || $TITLE=="DAP-2360")
{
	$filters_wireless_band_msg="Operating frequency band. Choose 2.4 GHz for visibility to legacy devices and for longer ranges. ".
	"This part will follow the basic wireless setting.";
}
else
{
$filters_wireless_band_msg="Betriebsfrequenzband. Wählen Sie 2,4 GHz, um auch Legacy-Geräte sichtbar zu machen, und für größere Reichweiten. Wählen Sie 5 GHz für weniger Interferenzen. Dieser Teil folgt der allgemeinen Funkeinstellung.";
}
$filters_acl_list="Access Control List";
$filters_acl_list_msg= "Can be configured to deny or only allow wireless stations association by filtering MAC addresses. By selecting \"Accept\"".
",can only be associated with MAC addresses listed in the Authorization table. By selecting \"Reject\",will only disassociate with MAC addresses listed.";
$filters_acl_mac = "MAC Address";
$filters_acl_mac_msg = "Enter a MAC address.";
$filters_acl_client_information="Current Client Information";
$filters_acl_client_information_msg="Displays the associated clients SSID, MAC, band, authentication method and signal strength for the ".query("/sys/hostname")." network.";
$filters_acl_upload_download="Wireless MAC ACL File Upload and Download";
$filters_acl_upload_download_msg="Browse to the ACL file from the local drive then click \"Open\" and \"Upload\" ".
"to upload the ACL list to the Access Point. You can also download the ACL file to your local drive by clicking".
" \"Download ACL File\". The first line of the ACL file indicates the access control policy (Disable/Accept/Reject). ".
"The number of the ACL entries is up to 256.";

$title_filters_wlan_partition="WLAN-Partition";
$filters_internal_station="Verbindung zwischen internen Stationen";
//$filters_internal_station_msg="Der Standardwert ist \"Aktivieren\". Dies lässt die Interkommunikation zwischen Stationen durch die Verbindung mit einem Ziel-AP zu. Drahtlose Stationen können keine Daten über den AP austauschen, wenn dies deaktiviert ist.";
if($TITLE == "DAP-2590")
{
	$filters_internal_station_msg="The default value is \"Enable\", which allows stations to inter-communicate by connecting to a target AP.<\br>".
"Enable: Allows stations to connect to other stations connected to their own SSID and other SSIDs on the access point.<\br>".
"Disable: Stations cannot connect to other stations connected to their own SSID, but can connect to stations connected to other SSIDs on the access point.<\br>".
"Guest: Stations cannot connect to other stations connected to their own SSID or other SSIDs on the access point.";
}
else
{
	$filters_internal_station_msg="The Internal Station Connection has three modes:";
}
$filters_internal_station_msg1="* Enable: Allows stations to connect to other stations connected to their own SSID and other SSIDs on the access point.";
$filters_internal_station_msg2="* Disable: Stations cannot connect to other stations connected to their own SSID, but can connect to stations connected to other &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SSIDs on the access point.";
$filters_internal_station_msg3="* Guest: Stations cannot connect to other stations connected to their own SSID or other SSIDs on the access point.";
$filters_eth_to_wlan="Ethernet-zu-WLAN-Zugriff";
$filters_eth_to_wlan_msg="Der Standardwert für Ethernet-to-WLAN-Zugriff ist \"Aktivieren\", was den Datenfluss von den Ethernet-Stationen zu den mit dem AP verbundenen Funkstationen zulässt. "."Durch Deaktivierung dieser Funktion werden Broadcast-Daten vom Ethernet zu den zugeordneten drahtlosen Geräten blockiert, während Funkstationen weiterhin über den AP Daten an das Ethernet senden können.";

$head_traffic_control="Traffic Control";
$head_traffic_control_msg="The traffic control feature allows users to manage uplink and downlink settings, Quality of Service (QoS) settings, and to enable, add, modify, and delete traffic manager rules.";

$title_traffic_updownlink_st="Uplink/Downlink Setting";
$title_traffic_updownlink_st_msg="The uplink/downlink setting allows users to customize the downlink and uplink interfaces including specifying downlink/uplink bandwidth rates in Mbits per second. These values are also used ".
"in the QoS and Traffic Manager windows.";

$title_traffic_qos="QoS";
$title_traffic_qos_msg="QoS stands for Quality of Service for Wireless Intelligent Stream Handling, a technology developed to enhance the experience of using a wireless network by prioritizing the traffic of different applications".
". The ".query("/sys/hostname")." supports four priority levels.";

$adv_priority="Priority";
$adv_priority_msg="The priority of the message flow is entered here. Four priorities are defined:";
$adv_priority_msg1="* Highest Priority (most urgent).";
$adv_priority_msg2="* Second Priority.";
$adv_priority_msg3="* Third Priority.";
$adv_priority_msg4="* Low Priority (least urgent).";
$traffic_qos_enable="Enable";
$traffic_qos_enable_msg="Tick this check box to allow QoS to prioritize your traffic. Use the drop-down menus to select the four levels of priority. Click the Save button when you are finished.";
$traffic_qos_down_banwidth="Downlink Bandwidth";
$traffic_qos_down_banwidth_msg="The downlink bandwidth in Mbits per second. This value is entered in the Uplink/Downlink Setting window.";
$traffic_qos_up_banwidth="Uplink Bandwidth";
$traffic_qos_up_banwidth_msg="The uplink bandwidth in Mbits per second. This value is entered in the Uplink/Downlink Setting window.";

$title_traffic_manager="Traffic Manager";
$title_traffic_manager_msg="The traffic manager feature allows users to create traffic management rules that specify how to deal with listed client traffic and specify ".
"downlink/uplink speed for new traffic manager rules.";

$traffic_traffic_manager="Traffic Manager";
$traffic_traffic_manager_msg="This Pull-down menu allows you to enable the traffic manager function.";
$traffic_unlisted_clients_traffic="Unlisted Clients Traffic";
$traffic_unlisted_clients_traffic_msg="Toggle the radio buttons between Deny and Forward to determine how to deal with unlisted client traffic.";
$traffic_down_bandwidth="Downlink Bandwidth";
$traffic_down_bandwidth_msg="The downlink bandwidth in Mbits per second. This value is entered in the Uplink/Downlink Setting window.";
$traffic_up_bandwidth="Uplink Bandwidth";
$traffic_up_bandwidth_msg="The uplink bandwidth in Mbits per second. This value is entered in the Uplink/Downlink Setting window.";
$traffic_name="Name";
$traffic_name_msg="Enter a name for the new traffic manager rule being defined.";
$traffic_client_ip="Client IP (optional)";
$traffic_client_ip_msg="Enter a client IP address. This is optional.";
$traffic_client_mac="Client MAC (optional)";
$traffic_client_mac_msg="Enter a client MAC address if desired. This is optional.";
$traffic_down_speed="Downlink Speed";
$traffic_down_speed_msg="Enter a downlink speed in Mbits per second.";
$traffic_up_speed="Uplink Speed";
$traffic_up_speed_msg="Enter an uplink speed in Mbits per second.";
$head_st="Statuseinstellungen";

$title_st_dev_info="Geräteinformationen";
if(query("/runtime/web/display/cpu")=="0")
{
	$title_st_dev_info_msg="This page displays the current information like firmware version, Ethernet and wireless parameters.";
}
else
{
$title_st_dev_info_msg="Diese Seite zeigt die aktuellen Informationen wie die Firmware-Version, Ethernet und drahtlosen Parameter sowie die Informationen zur CPU und Speicherauslastung.";
}

$title_st_cli_info="Client-Informationen";
$title_st_cli_info_msg="Auf dieser Seite werden die zugeordneten Clients, SSID, MAC, Frequenzband, Authentifizierungsmethode, Signalstärke und der Stromsparmodus für das ".query("/sys/hostname")."-Netzwerk angezeigt.";

$title_st_wds_info="WDS-Informationen";
$title_st_wds_info_msg="Auf dieser Seite werden die Access Points, SSID, MAC, Frequenzband, Authentifizierungsmethode, Signalstärke und der Stromsparmodus für das WDS-Netz (Wireless Distribution System) des ".query("/sys/hostname")." angezeigt.";


$head_statistics="Statistik";

$title_st_ethernet="Ethernet-Datenverkehrstatistik";
$title_st_ethernet_msg="Zeigt Datenverkehrsinformationen der kabelgebundenen Schnittstelle des Netzwerks an.";

$title_st_wlan="WLAN 802.11G Datenverkehrstatistik";
$title_st_wlan_msg="Zeigt den Datendurchsatz, übertragene Datenframes, empfangene Frames und WEP-Frame-Fehlerinformationen für das AP-Netzwerk an.";


$head_log="Protokoll";
$head_log_msg="Zeichnet Protokollereignisse auf einem Remote-System-Log-Server und einer Webseite auf.";

$title_log_view="Protokoll anzeigen";
$title_log_view_msg="Der integrierte Speicher des AP nimmt hier die Protokolle auf. Zu den erfassten Informationen zählt unter anderem Folgendes: Kaltstart des AP, Firmware-Upgrade, "."Client-Assoziation und Disassoziation mit AP und Web-Anmeldung. Die Webseite kann bis zu 500 Protokolleinträge aufnehmen.";

$title_log_set="Protokolleinstellungen";
$title_log_set_msg="Geben Sie die IP-Adresse des Protokollservers ein, an den das Protokoll gesendet werden soll. Markieren Sie Systemaktivität, Drahtlose Aktivität oder Beobachtung, um anzugeben, welcher Protokolltyp erfasst werden soll.";
$title_email="Email Notification";
$title_email_msg="Support Simple Mail Transfer Protocol for log schedule and periodical change key. It can not support Gmail SMTP port 465.".
" Please set to Gmail SMTP port 25 or 587.";
$title_email_schedule="Email Log Schedule";
$title_email_schedule_msg="Use the pull-down menu to set the e-mail log schedule.";


$head_mt="Wartung";

$title_mt_admin="Administratoreinstellungen";
$mt_limit_admin_vid="Administrator-VID einschränken";
$mt_limit_admin_vid_msg="Pakete mit VLAN-Tags, die die gleichen VID aufweisen, erlauben dem Administrator die Anmeldung.";
$mt_limit_admin_ip="Administrator-IP-Bereich einschränken";
$mt_limit_admin_ip_msg="Geben Sie einen IP-Adresspool ein, von dem aus der Administrator sich anmelden kann.";
$title_mt_sysname="Systemnameneinstellungen";
$mt_sysname="Systemname";
$mt_sysname_msg="Ein administrativ zugewiesener Name für den ".query("/sys/hostname").". ";
$mt_location="Standort";
$mt_location_msg="Der physische Standort des ".query("/sys/hostname").".";
$title_mt_login="Anmeldeeinstellungen";
$mt_username="Benutzername";
$mt_username_msg="Sie können als Administrator des ".
.query("/sys/hostname")." den Benutzernamen ändern. Der Standardbenutzername ist \"admin\". Ein Kennwort ist nicht konfiguriert.";
$mt_oldpass="Altes Kennwort";
$mt_oldpass_msg="Geben Sie das alte Kennwort ein.";
$mt_newpass="Neues Kennwort";
$mt_newpass_msg="Geben Sie ein Kennwort in diesem Feld ein. Bei der Kennworteingabe wird zwischen Groß- und Kleinschreibung unterschieden. So ist z. B. “A” eine andere Eingabe als “a.” Die Länge der Eingabe sollte zwischen 0 und 12 Zeichen sein.";
$mt_conpass="Neues Kennwort bestätigen";
$mt_conpass_msg="Geben Sie das Kennwort erneut ein, um Ihre Eingabe zu bestätigen.";
$title_mt_console="Konsoleneinstellungen";
$mt_status="Status";
$mt_status_msg="Aktivieren oder deaktivieren Sie die Konsole.";
$mt_console_protocol="Konsolenprotokoll";
$mt_console_protocol_msg="Wählen Sie Telnet oder SSH.";
$mt_timeout="Timeout";
$mt_timeout_msg="Wählen Sie den Timeout.";
$title_mt_snmp="SNMP-Einstellungen";
$mt_st_snmp="Status";
$mt_st_snmp_msg="Aktivieren oder deaktivieren Sie das Simple Network Management Protocoll (SNMP).";
$mt_public_comm="Öffentlicher Community String";
$mt_public_comm_msg="Geben Sie den Public Community String für das SNMP ein.";
$mt_private_comm="Privater Community String";
$mt_private_comm_msg="Geben Sie den Private Community String für das SNMP ein.";
$mt_trap="Trap-Status";
$mt_trap_msg="Aktivieren oder deaktivieren Sie das Versenden von Traps.";
$mt_trap_serv="Trap Server-IP";
$mt_trap_serv_msg="Die IP-Adresse des SNMP-Managers zum Empfang von Trap-Paketen, die vom drahtlosen AP gesendet wurden.";
$title_mt_pingctrl="Ping-Steuerungseinstellung";
$mt_ping_st="Status";
$mt_ping_st_msg="Ping sendet ein ICMP \"Echo Request\"-Paket an die Zieladresse des zu überprüfenden Hosts. Der Empfänger muss dann, sofern er das Protokoll unterstützt, "."laut Protokollspezifikation ein ICMP-Echo-Reply zurücksenden. Durch Deaktivierung der Ping-Steuerungseinstellung antwortet dieser AP nicht auf ICMP-Echo-Request-Pakete. Die Option ist standardmäßig aktiviert.";
if($cfg_ipv6=="1")
{
	$title_mt_fw="Firmware";
	$title_mt_fw_msg="Firmware Upload";
}
else
{
$title_mt_fw="Firmware and SSL Certification Upload";
$title_mt_fw_msg="Firmware and SSL Certification Upload";
}
$title_mt_fw_msg1="Sie können Dateien auf den Access Point hochladen.";
$mt_upload_fw="Firmware von der lokalen Festplatte hochladen";
$mt_upload_fw_msg="Die aktuelle Firmware-Version wird oberhalb des Feldes \"Dateiverzeichnis\" angezeigt. Klicken Sie nach dem Herunterladen der neuesten Fimware auf \"Durchsuchen\", um die neue Firmware-Datei auf Ihrem Computer zu suchen. "."Sobald Sie die Datei gefunden und ausgewählt haben, klicken Sie auf \"Öffnen\" und auf \"OK\", um den Aktualisierungsprozess der Firmware zu starten. Schalten Sie den Strom bitte nicht während des Upgrade-Vorgangs ab.";
$mt_upload_ssl="SSL-Zertifizierung von der lokalen Festplatte hochladen";
$mt_upload_ssl_msg="Nachdem Sie eine SSL-Zertifizierung auf Ihr lokales Laufwerk geladen haben, klicken Sie auf \"Durchsuchen\". Wählen Sie die Zertifizierung aus und klicken Sie auf \"Öffnen\" und auf \"Upload\", um den Upgrade-Vorgang fertig zu stellen.";
$mt_upload_language = "Language Pack Upgrade";
$mt_upload_language_msg = "The current Language Pack version is displayed above the file location field.. After the Language Pack ".
"is downloaded, click on the \"Browse\" button to locate the Language Pack. Once the file is selected, click on the \"Open\" and ".
"\"Upload\" button to begin updating the Language. Please don't turn the power off while upgrading.";

$_title_mt_config="Konfigurationsdatei";
$mt_config="Konfigurationsdatei hoch- bzw. herunterladen";
$mt_config_msg="Sie können Konfigurationsdateien des AP hoch- bzw. herunterladen.";
$mt_upload_config="Konfigurationsdatei hochladen";
$mt_upload_config_msg="Navigieren Sie zu der gespeicherten Konfigurationsdatei auf Ihrem lokalen Laufwerk und klicken Sie auf \"Öffnen\" und \"Upload\", um die Konfiguration zu aktualisieren.";
$mt_download_config="Konfigurationsdatei herunterladen";
$mt_download_config_msg="Klicken Sie auf \"Download\", um die aktuelle Konfigurationsdatei auf Ihrer lokalen Festplatte zu speichern. Beachten Sie, wenn Sie jetzt eine Konfigurationsdatei mit dem Kennwort des Administrators speichern, nachdem Sie Ihren ".
.query("/sys/hostname")." neu eingerichtet haben, und dann auf diese gespeicherte Konfigurationsdatei aktualisieren, dass das Kennwort verloren geht.";

$title_mt_time="Uhrzeit und Datum";
$title_mt_time_msg="Geben Sie die NTP-Server-IP ein, wählen Sie die Zeitzone und aktivieren oder deaktivieren Sie die Sommerzeit (Zeitumstellung).";
$auto_time = "Automatic Time Configuration";
$auto_time_msg = "Enable NTP get the date and time from a NTP server.";
$date_and_time_manu = "Set the Date and Time Manually";
$date_and_time_manu_msg = "You can set the date and time manually or copy your computer's time to AP.";

$head_config ="Configuration";
$config_save_activate="Save and Activate";
$config_save_activate_msg="Click\" Save and Activate  \" to save all settings and re-activate the system.";
$config_discard_change="Discard change";
$config_discard_change_msg="Click \"Discard change \" to discard the settings"; 

$head_sys = "System";
$title_sys = "Systemeinstellungen";
$sys_apply_restart = "Einstellungen übernehmen und neu starten";
$sys_apply_restart_msg = "Klicken Sie auf Neustart, um Einstellungen zu übernehmen und einen Neustart durchzuführen.";
$sys_apply_restore = "Auf Werkseinstellungen zurücksetzen.";
$sys_apply_restore_msg = "Klicken Sie auf \"Wiederherstellen\", um die Einstellungen auf die Werkseinstellungen zurückzusetzen.";
$sys_clear_language = "Clear Language pack";
$sys_clear_language_msg = "Click on clear to reset language to default settings.";
?>
