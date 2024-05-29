<?
$runtime_ipv6=query("/runtime/web/display/ipv6");    
$cfg_ipv6=query("/inet/entry:1/ipv6/valid");

$head_bsc = "基本設定";

$title_bsc_wlan ="無線設定";
$bsc_wlan_msg ="讓您變更無線設定，以符合既有的一個無線網路或自訂您的無線網路。";
$bsc_wireless_band ="無線頻帶";
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
$bsc_wireless_band_msg ="作業頻帶。若要獲得有效裝置能見度及更長範圍，選擇2.4 GHz。若要干擾最少，".
"選擇5 GHz。干擾會傷害效能。這個AP一次操作一個頻帶。"; 
}
$bsc_application="Application";
$bsc_application_msg="This option allows the user to choose for indoor or outdoor mode at the 5G Band.";
$bsc_mode = "模式";
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
$bsc_mode_msg = "選擇一個功能模式來設定您的無線網路。功能模式包括AP、無線分散系統 ".
"(Wireless Distribution System) with AP、無線分散系統與無線客戶機。功能模式用來支援各種無線網路拓樸與應用。";
	}
}
$bsc_network_name = "網路名稱（服務設定識別碼）";
$bsc_network_name_msg = "亦稱為Service Set Identifier，為指定給一個特定無線區域網路的名稱。".
"出廠預設值為\"dlink\"。服務設定識別碼可被輕易變更而連接既有一個無線網路或建立一個新的無線網路。";
$bsc_ssid_visibility = "服務設定識別碼能見度";
$bsc_ssid_visibility_msg = "指示您的無線網路的服務設定識別碼是否要被廣播。服務設定識別碼能見".
"度的預設值為\"Enable\"，允許無線客戶機偵測無線網路。將設定變更為Disable時，無線客戶機無法再偵測".
"無線網路，且只有在鍵入正確服務設定識別碼後才能連線。";
$bsc_auto_channel="自動信道選擇";
$bsc_auto_channel_msg="若您選擇「自動信道掃瞄」，每次當AP開機時，AP會自動發現所要使用的最佳信道。預設值為啟動這個功能。";
$bsc_channel="信道";
$bsc_channel_msg ="顯示 ".query("/sys/hostname")."的信道設定。AP被預設為自動信道掃瞄。".
"可變更信道，以符合既有的一個無線網路的信道設定或自訂無線網路。";
$bsc_channel_width="信道寬度";
/*$bsc_channel_width_msg="讓您選擇您想工作的信道寬度。若您目前沒有在使用任何的802.11n無線客戶機，".
"選擇20MHz。Auto 20/40MHz讓您在您的網路內使用802.11n與非802.11n無線裝置。";*/
if($TITLE == "DAP-1353" || $TITLE == "DAP-2360")
{
$bsc_channel_width_msg="Allows selection of the channel width you would like to operate in.20 MHz and Auto 20/40MHz allow both 802.11n ".
"and non-802.11n wireless devices on your network when the wireless mode is Mixed 802.11 b/g/n in 2.4G.802.11n ".
"wireless devices are allowed to transmit data using 40 MHz when the channel width is Auto 20/40 MHz";
}
else
{
$bsc_channel_width_msg="Allows selection of the channel width you would like to operate in.20 MHz and Auto 20/40MHz allow both 802.11n ".
"and non-802.11n wireless devices on your network when the wireless mode is Mixed 802.11 b/g/n in 2.4G and Mixed 802.11 a/n in 5G.802.11n ".
"wireless devices are allowed to transmit data using 40 MHz when the channel width is Auto 20/40 MHz";
}
$bsc_authentication="認證";
$bsc_authentication_msg="若要在無線網路加入安全功能，可啟動資料加密。有若干認證型態可選擇。".
"認證預設值為\"Open System\"。";
$bsc_open_sys="開放系統";
$bsc_open_sys_msg="對於開放系統認證，只有WEP金鑰相同的無線客戶機可以在無線網路上通訊。".
"存取點將維持可被網路內所有裝置看見的狀態。";
$bsc_shared_key="共享金鑰";
$bsc_shared_key_msg="對於共享金鑰認證，除了具有相同WEP金鑰的無線客戶機外，存取點無法在無線網路內被看見。";
$bsc_personal_type="WPA-Personal/WPA2-Personal/WPA-Auto-Personal";
$bsc_personal_type_msg="Wi-Fi Protected Access (WPA) 授權及認證使用者登入無線網路。它使用暫時密".
"鑰完整性協定加密，以預享金鑰來保護網路。WPA與WPA2使用不同的演算式。";
$bsc_periodrical_change_key="Periodical Key Change";
$bsc_periodrical_change_key_msg="The ".query("/sys/hostname")." supports periodical change key. Periodical change key can ".
"generate WPA random key which start at time of activated from. Administrator can use email to get current key and Periodical change key information.";
$bsc_enterprise_type="WPA-Enterprise/ WPA2-Enterprise/ WPA-Auto-Enterprise";
if(query("/runtime/web/display/accounting_server") == "1")
{
	$bsc_enterprise_type_msg="Wi-Fi Protected Access authorizes and authenticates users onto the wireless network.".
"WPA uses stronger security than WEP and is based on a key that changes automatically at a regular interval.".
" It requires a RADIUS server in the network. Accounting server, Backup server and Backup Accounting server are optional.WPA and WPA2 uses different algorithm. WPA-Auto allows both WPA andWPA2.";
}
else
{
$bsc_enterprise_type_msg="Wi-Fi Protected Access (WPA) 授權及認證使用者登入無線網路。WPA使用".
"比WEP更強的安全，所依據的金鑰會自動定期改變。它需要網路內有一台遠端認證撥接使用者服務伺服器。".
"WPA與WPA2使用不同的演算式。WPA-Auto允許WPA與WPA2。";
}
$bsc_8021x_type="802.1x";
$bsc_8021x_type_msg="If you use 802.1x you do not need to supply a WEP key. This is an access control system ".
"used for Ethernet and wireless networks and a key is generated automatically from a server or switch. In ".
"order to use 802.1x you must have the system running on implementing PAE. After applying the settings and ".
"restarting the Access Point, you must choose to use a radius server or a local server or switch for ".
"Authentication. Use the Encryption menu to select where authentication information comes from and Key Update Interval.";
$bsc_network_access="網路存取防護";
$bsc_network_access_msg="網路存取防護（NAP）是Windows伺服器2008的特色之一。NAP依據客戶電腦的身份及企業".
"政策來控制對網路資源的存取。NAP允許網路管理員依據客戶是誰、客戶屬於哪個群組及客戶符合公司政策的程".
"度來定義網路存取粒度。如果客戶不符合政策，NAP提供一個機制，可自動將客戶帶回符合政策的狀態，然後動態".
"增加它的網路存取度。";
$bsc_mac_clone = "MAC Clone";
$bsc_mac_clone_msg = "Assign a mac address to the AP which is set to APC mode, for the communication with another AP as a network card. You can entry any address or choose an address in the scan list if select \"manually\". \"Auto\" means to assign the first mac address in that AP detected.";
$title_bsc_lan = "區域網路設定";
$title_bsc_lan_msg = "亦稱為專用設定。區域網路設定讓您設定區域網路的 ".query("/sys/hostname")."介面。區域網路 IP位址屬於您的內部網路所有，網路無法看見。預設的IP位址為192.168.0.50，子網路遮罩255.255.255.0。";
$bsc_get_ip_from = "取得的IP來自";
$bsc_get_ip_from_msg = "出廠預設值為\"Static IP (Manual)\"，允許".query("/sys/hostname")."的IP位址依照".
"被應用的區域網路而被人工組態。啟動\"Dynamic IP (動態主機設定通訊協定)\"可讓動態主機設定通訊協定主機".
"自動分配一個符合被應用區域網路的IP位址給存取點。";
$bsc_ip_address = "IP位址";
$bsc_ip_address_msg = "預設IP位址為192.168.0.50，可被變更以符合一個既有的區域網路。請注意，無線區域網路內".
"每個裝置的IP位址必須位在相同的IP位址範圍與子網路遮罩。以預設的".query("/sys/hostname")."的IP位址作為例子，".
"跟AP關聯的每個站台都必須配得落在0-255的192.168.0.*.\"*\"範圍內的一個獨一無二的IP位址，但在這個例子中，為50";
$bsc_submask = "子網路遮罩";
$bsc_submask_msg = "遮罩用來判定一個IP位址屬於哪個子網路。預設子網路設定值為255.255.255.0。";
$bsc_gateway = "預設閘道器";
$bsc_gateway_msg = "指定區域網路的閘道器IP位址。";

$title_bsc_ipv6 = "IPv6 LAN Settings";
$title_bsc_ipv6_msg = "Enable IPv6 function allows you access ".query("/sys/hostname")." by an IPv6 address.";
$bsc_get_ip_from_msg_ipv6 = "The factory default setting is \"Auto\" which the host assign the AP an ipv6 address. The \"Static\" allows you to set an address manually.";
$bsc_ip_address_msg_ipv6 = "IP address can be modified here whose format is apart to eight segment by \":\". Each segment has four character: 0~9 or A~F. You can use a IPv4 address instead of the last two segment. The multicast address which starts as \"FF\" is not allowed.";
$bsc_prefix = "Prefix";
$bsc_prefix_msg = "Prefix used to determine what subnet an IP address belongs to. It must be 0~128.";
$bsc_dns_ipv6 = "DNS";
$bsc_dns_ipv6_msg = "DNS used to parse the URL to IP.";
$bsc_gateway_ipv6_msg = "Specify the gateway IP address of the local network.";

$head_adv ="高階設定";

$title_adv_per = "效能";
$title_adv_per_msg = "您可以自訂網路廣播，以符合您的需求，方法是調整效能區塊內的廣播參數。效能".
"功能供熟悉802.11無線網路與廣播組態的高階使用者運用。";
$adv_wireless = "無線";
$adv_wireless_msg ="這個選項讓使用者啟動或取消無線功能。";
$adv_wireless_mode ="無線模式";
if($TITLE=="DAP-1353" || $TITLE=="DAP-2360")
{
	$adv_wireless_mode_msg ="This function allows you to select different combination of clients".
	" that can be supported.Please note that when backwards compatibility is enabled for legacy ".
	"(802.11g/b) clients, degradation of 802.11n wireless performance is expected.";
}
else
{
$adv_wireless_mode_msg ="這個功能讓您選擇可被支援的不同客戶組合。請注意當有效（802.11a/g/b）客戶機".
"的逆向相容功能被啟動時，802.11n無線效能將減損。";
}
$adv_date_rate="資料速率";
$adv_date_rate_msg="顯示無線區域網路內的無線整流器的基本傳送速率。存取點將依照被連接裝置的基本速率".
"而調整基本傳送速率。若有障礙或干擾，AP會減慢資料速率。";
$adv_beacon = "信標時距（25-500）";
$adv_beacon_msg = "Beacons是一個存取點所傳送的封包，用來讓一個無線網路同步化。設定較高的beacon時距可以".
"節省一個無線客戶機的電力；若設定較低的beacon時距，有助無線客戶機更快連接一個存取點。對多數使用者，".
"建議設定為100毫秒。";
$adv_dtim="數位傳輸介面模組時距（1-15）";
$adv_dtim_msg="數位傳輸介面模組時距指定數位傳輸介面模組（Delivery Traffic Indication Message）之間的".
"AP beacons數。它通知下個窗口的有關站台聆聽廣播及群播訊息。您可以從1到15選擇一個數字作為數位傳輸介面".
"模組值。如有緩衝廣播或群播訊息，AP會將下個數位傳輸介面模組與您所指定的數位傳輸介面模組值傳送到站台。".
"站台聽到beacons，並準備接收廣播或群播訊息。數位傳輸介面模組時距的預設值為1。";
$adv_transmit_power="傳送功率";
$adv_transmit_power_msg="這個設定決定無線傳送的功率高低。傳送功率可被調整，以消除干擾造成問題的兩個存取點".
"之間的無線區重疊。選擇有100% (預設值)、50% (-3dB)、25% (-6dB)與12.5% (-9dB)。例如，如果無線涵蓋範圍預定為".
"一半的區域，那麼選擇50%這個選項。";
$adv_wmm="WMM (Wi-Fi多媒體)";
$adv_wmm_msg="Wi-Fi多媒體功能可改善使用者在Wi-Fi網路上的影音體驗。WMM依據IEEE 802.11e 無線區域網路 網際".
"網路服務品質標準的一個子網路。啟動這個功能可改善使用者在Wi-Fi網路上的影音體驗。";
$adv_ack_timeout="確認逾時";
if(query("/runtime/web/display/ack_timeout_range")=="0")
{

	if($TITLE=="DAP-1353" || $TITLE=="DAP-2360")
	{
		$adv_ack_timeout_msg="You can specify an Ack Timeout value range from 48~200 in 2.4GHz to effectively".
	" optimize the throughput over long distance links. The unit is in microseconds (&micro;s). The default value is set to 25&micro;s in 2.4GHz.";
	}
	else
	{
$adv_ack_timeout_msg="若是2.4GHz，您可以從48~200的範圍選擇一個數字作為Ack Timeout值，但若是5GHz，則範圍".
"為25~200，以有效改善長途連結的輸貫量。單位為毫秒（ms）。預設值為25ms（2.4GHz）或48ms（5GHz）。";
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
	$adv_ack_timeout_msg="若是2.4GHz，您可以從64~200的範圍選擇一個數字作為Ack Timeout值，但若是5GHz，則範圍".
"為50~200，以有效改善長途連結的輸貫量。單位為毫秒（ms）。預設值為64ms（2.4GHz）或50ms（5GHz）。";
}

}
$adv_short_gi="短時空區塊編碼";
$adv_short_gi_msg="使用短時空區塊編碼（guard interval）（400ns）可以增加輸貫量。然而，由於對廣播頻率的".
"敏感度提高，因此亦會造成某些安裝內的錯誤率增加。選擇最適合您的安裝的選項。";
$adv_igmp="網際網路群組管理協定模擬功能";
$adv_igmp_msg="網際網路群組管理協定（Internet Group Management Protocol）模擬功能允許AP承認在路由器與網際".
"網路群組管理協定主機（無線STA）之間傳送的網際網路群組管理協定詢問與報告。當網際網路群組管理協定 模擬功能".
"被啟動時，AP會依據通過AP的網際網路群組管理協定訊息而將群播封包傳送到網際網路群組管理協定主機。";
$adv_link_integrality="連結整體度";
$adv_link_integrality_msg="如果區域網路與AP之間的乙太網路連接中斷，那麼在\"Link Integrity\"這個選項被啟動".
"下，將會造成無線客戶機自動跟AP中斷關聯。";
$adv_connection_limit="連接限制";
if(query("/runtime/web/display/utilization") !="0")
{
	$utilization_string="或當這個AP的網路運用率超過您所指定的百分比時，";
}
else
{
	$utilization_string=" ";
}
$adv_connection_limit_msg="連接上限是負載平衡的一個選項。它讓您分享無線網路流量與使用多重 ".query("/sys/hostname")."的客戶機。如果這個功能被啟動，當使用者人數超過\"user limit\"，". $utilization_string.
."AP將不允許客戶機跟這個AP產生關聯。";
$adv_user_limit ="使用者上限（0-64）";
$adv_user_limit_msg ="選擇每個存取點的可允許最大使用者人數。對典型使用者，建議設定值\"10\"。";
$adv_network_utilization="網路運用率";
$adv_network_utilization_msg="設定這個存取點的最大運用率。如果運用率超過使用者所指定的值， ".query("
/sys/hostname")."不會讓任何新客戶機跟AP產生關聯。建議設定為100%。";
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
$title_adv_mssid="多重服務設定識別碼";
if(query("/runtime/web/display/mssid_index4")==1)
{
	$title_adv_mssid_msg="One primary SSID and at most three guest SSIDs ".
	"can be configured to allow virtual segregation stations which share the same channel.";
}
else
{
$title_adv_mssid_msg="Multiple 服務設定識別碼只在AP模式內被支援。可以設定一個主要服務設定識別碼與最多".
"七個訪客服務設定識別碼，以允許分享相同信道的虛擬分離站。";
}
$adv_mssid_msg1="此外，您可以啟動虛擬區域網路狀態，讓".query("/sys/hostname")."跟虛擬區域網路交換機".
"或其他裝置工作。";
$adv_mssid_msg2="當主要服務設定識別碼被設定為Open System without encryption，訪客服務設定識別碼只能被設定為no encryption、WEP、WPA-Personal或WPA2-Personal。";
$adv_mssid_msg3="當主要服務設定識別碼的安全被設定為Open或Shared System WEP key，訪客服務設定識別碼可被設定為no encryption、use three other WEP keys、WPA-Personal或WPA2-Personal。";
$adv_mssid_msg4="當主要服務設定識別碼的安全被設定為WPA-Personal、WPA2-Personal或WPA-Auto-Personal，槽2與槽3被使用。訪客服務設定識別碼可被設定為use no encryption、WEP或WPA-Personal。";
$adv_mssid_msg5="當主要服務設定識別碼的安全被設定為WPA-Enterprise、WPA2-Enterprise或WPA-Auto-Enterprise，訪客服務設定識別碼可被設定成使用任何安全。";

$adv_mssid_msg6="The priority of SSID supports eight levels. 7 is the highest priority, and 0 is the loweset. ";
$title_adv_vlan="虛擬區域網路";
$title_adv_vlan_msg="".query("/sys/hostname")."支援虛擬區域網路。使用一個名稱與虛擬網路辨識碼可創造虛擬區".
"域網路。Mgmt (傳輸控制協議堆疊)、區域網路、主要/多重服務設定識別碼與無線分散系統 Connection可被分配給".
"虛擬區域網路，因為它們是實體埠。沒有虛擬區域網路標籤而進入 ".query("/sys/hostname")."的封包將有一個被".
"插入的虛擬區域網路與連接埠虛擬網路辨識碼。";

$title_adv_intrusion="無線入侵防護";
$title_adv_intrusion_msg="".query("/sys/hostname")."允許使用者設定無線入侵防護。";

$title_adv_scheduling="時程排定";
$title_adv_scheduling_msg="".query("/sys/hostname")."的廣播可使用週或個別星期作為單位來排定時程。";

$title_adv_qos="網際網路服務品質";
$title_adv_qos_msg="網際網路服務品質的全名為無線智慧流處理服務品質（Quality of Service for Wireless".
"Intelligent Stream Handling）。這項科技可排定不同應用的流量的優先順序因而改善無線網路使用經驗。";
if($TITLE == "DAP-2360" || $TITLE == "DAP-2690" || $TITLE == "DAP-3690")
{
	$adv_enable_qoS="QoS(Quality of Service)";
}
else
{
$adv_enable_qoS="啟動網際網路服務品質";
}
$adv_enable_qoS_msg="如果您想讓網際網路服務品質排定您的流量的優先順序，那麼啟動這個選項。";
$adv_enable_qoS_msg1="優先順位分類器。";
$adv_http="HTTP";
$adv_http_msg="讓存取點承認許多共同影音流的HTTP傳送，並給予它們高於其他流量的優先順位。這類影音流常被數位".
"媒體玩家使用。";
$adv_automatic="自動";
$adv_automatic_msg="當這個選項被啟動時，會讓存取點依據流量所展現的行為而自動嘗試排定它不承認的流量的".
"優先順序。這會取消展現大宗傳送特色的流量的優先順位，例如檔案傳送，而讓互動流量在正常優先順位上流動，".
"例如遊戲或VoIP。";
$adv_qos_rule="網際網路服務品質規則";
$adv_qos_rule_msg="一條網際網路服務品質規則會發覺一個特定的訊息流，並分配一個優先順位給該訊息流。對多數".
"應用，優先順序分類器確保優先順序正確，且特定網際網路服務品質規則不被需要。";
$adv_qos_rule_msg1="網際網路服務品質支援規則之間的重疊。如果多個規則符合一個特定的訊息流，優先順位最高的規則將被使用。";
$adv_name="名稱";
$adv_name_msg="給規則一個對您有意義的名稱。";
$adv_priority="優先順位";
$adv_qos_msg="在這裡鍵入訊息流的優先順位。四個優先順位被定義：";
$adv_qos_msg1="*BK：背景（最不緊急）。";
$adv_qos_msg2="*BE：最佳努力。";
$adv_qos_msg3="*VI：影像。";
$adv_qos_msg4="*VO：語音（最緊急）。";
$adv_protocol="協定";
$adv_protocol_msg="訊息所使用的協定。";
$adv_host_1_ip="主機1 IP範圍";
$adv_host_1_ip_msg="這條規則適用一個訊息流，且對這個訊息流，一個電腦的IP位址落在這裡所設定的範圍內。";
$adv_host_1_port="主機1埠範圍";
$adv_host_1_port_msg="這條規則適用一個訊息流，且對這個訊息流，主機1的埠數落在這裡所設定的範圍內。";
$adv_host_2_ip="主機2 IP範圍";
$adv_host_2_ip_msg="這條規則適用一個訊息流，且對這個訊息流，其他電腦的IP位址落在這裡所設定的範圍內。";   
$adv_host_2_port="主機2埠範圍";
$adv_host_2_port_msg="這條規則適用一個訊息流，且對這個訊息流，主機2的埠數落在這裡所設定的範圍內。";
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
    

$head_dhcp="動態主機設定通訊協定伺服器";
$head_dhcp_msg="動態主機設定通訊協定（Dynamic Host Control Protocol）伺服器分配IP位址給在登入無線網路時".
"要求IP位址的站台。站台必須被組態為動態主機設定通訊協定客戶機才能自動取得IP位址。動態主機設定通訊協定伺".
"服器控制的預設值為\"disabled\"。";

$title_dhcp_dynamic_pool="動態集區設定";
$title_dhcp_dynamic_pool_msg="動態主機設定通訊協定位址集區定義可被分配給網路內站台的IP位址範圍。動態集區".
"允許無線站台接收一個IP與租用時間控制。";
$dhcp_server_control="DHCP Server Control";
$dhcp_server_control_msg="The default setting for DHCP Server is disable.";
$dhcp_ip_assigned="IP分配來自";
$dhcp_ip_assigned_msg="使用者可指定無線站台可取得的IP位址集區的開始位址。";
$dhcp_range_of_pool="集區的範圍（1-254）";
$dhcp_range_of_pool_msg="使用者可指定可取用的IP位址範圍。IP位址是\"IP Assigned From\"欄內被指定IP位址的新增位址。";
$dhcp_submask="子網路遮罩";
$dhcp_submask_msg="定義\"IP Assigned From\"欄內被指定IP位址的子遮罩。";
$dhcp_gateway="閘道器";
$dhcp_gateway_msg="指定無線網路的閘道器位址。";
$dhcp_wins="微軟視窗網際絡路名稱服務";
$dhcp_wins_msg="指定無線網路的微軟視窗網際絡路名稱服務位址。";
$dhcp_dns="網域名稱系統";
$dhcp_dns_msg="指定無線網路的網域名稱系統位址。";
$dhcp_domain="網域名稱";
$dhcp_domain_msg="指定無線網路的網域名稱位址。";
$dhcp_lease_time="租用時間";
$dhcp_lease_time_msg="使用者可以定義站台關聯時間，方法是指定IP位址租用時間。";

$title_dhcp_static_pool="靜態集區設定";
$title_dhcp_static_pool_msg="動態主機設定通訊協定位址集區定義可被分配給網路內站台的IP位址範圍。靜態集區".
"允許無線站台接收一個IP而沒有時間控制。";
$host_name="Host Name";
$host_name_msg="Create a name for the rule that is meaningful to you.";
$dhcp_assigned_ip="被分配的IP";
$dhcp_assigned_ip_msg="使用「被分配的網路實際位址」欄內所指定的網路實際位址，指定要分配給一個站台的IP位址。";
$dhcp_assigned_mac="被分配的網路實際位址";
$dhcp_assigned_mac_msg="指定網路實際位址給要求關聯的站台。";

$title_dhcp_current_ip="目前的IP映射";
$title_dhcp_current_ip_msg="一份清單，內有網路實際位址、IP位址、動態主機設定通訊協定伺服器使用動態集區或".
"靜態集區而跟".query("/sys/hostname")." 發生關聯的無線站台的租用時間。";


$head_filters="過濾";
$head_filters_msg="過濾功能包括網路實際位址過濾與無線區域網路分割。網路實際位址過濾功能會發覺指定網路實".
"際位址而阻礙或接受關聯。無線區域網路分割會接受或拒絕來自無線或有線網路的存取。";

$title_filters_wireless_access="無線存取設定";
$filters_wireless_band="無線頻帶";
if($TITLE=="DAP-1353" || $TITLE=="DAP-2360")
{
	$filters_wireless_band_msg="Operating frequency band. Choose 2.4 GHz for visibility to legacy devices and for longer ranges. ".
	"This part will follow the basic wireless setting.";
}
else
{
$filters_wireless_band_msg="作業頻帶。若要獲得有效裝置能見度及更長範圍，選擇2.4GHz。若要干擾最少，選擇5GHz。".
"這個部分會追蹤基本無線設定。";
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

$title_filters_wlan_partition="無線區域網路分割";
$filters_internal_station="內部站台連接";
/*$filters_internal_station_msg="預設值為\"Enable\"，可讓站台連接一個目標AP而彼此通訊。當這個功能被設定".
"為\"disable\"時，無線站台需要透過AP交換資料。";*/
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
$filters_eth_to_wlan="乙太網路對無線區域網路的連線";
$filters_eth_to_wlan_msg="預設值為\"Enable\"，可讓乙太網路的資料流流向跟AP連接的無線站台。若將這個功能設定".
"為\"disabled\"，乙太網路對關聯無線裝置的廣播資料會被阻擋，但無線站仍可以透過AP傳送資料到乙太網路。";


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
$head_st="狀態設定";

$title_st_dev_info="裝置資訊";
$title_st_dev_info_msg="這一頁顯示目前的資訊，例如韌體版本、乙太網路與無線參數，還有CPU與記憶體運用有關資訊。";

$title_st_cli_info="客戶機資訊";
$title_st_cli_info_msg="這一頁顯示".query("/sys/hostname")."網路的關聯客戶機服務設定識別碼、網路實際位址、".
"頻帶、認證方法、信號強度及省電模式。";

$title_st_wds_info="無線分散系統資訊";
$title_st_wds_info_msg="這一頁顯示".query("/sys/hostname")."無線分散系統網路的存取點服務設定識別碼、網路".
"實際位址、頻帶、認證方法、信號強度及省電模式。";


$head_statistics="統計";

$title_st_ethernet="乙太網路流量統計";
$title_st_ethernet_msg="顯示有線介面網路流量資訊。";

$title_st_wlan="無線區域網路 802.11G流量統計";
$title_st_wlan_msg="顯示AP網路的輸貫量、被傳送的視框、被接收的視框及WEP視框錯誤資訊。";


$head_log="日誌";
$head_log_msg="記錄遠端系統日誌伺服器上的日誌事件，以及顯示網頁。";

$title_log_view="觀看日誌";
$title_log_view_msg="AP的嵌入記憶體儲存日誌。日誌資訊包括但不限於下列：冷開機AP、升級韌體、客戶機跟AP之間".
"的關聯化與去關聯，還有網站登入。網頁可儲存500筆日誌。";

$title_log_set="日誌設定";
$title_log_set_msg="輸入log server的IP 位址即可將設備log傳送至server。選擇或是不選擇您所想要紀錄的log訊息包含System Activity, Wireless Activity,或其它您想紀錄的log。";
$title_email="Email Notification";
$title_email_msg="Support Simple Mail Transfer Protocol for log schedule and periodical change key. It can not support Gmail SMTP port 465.".
" Please set to Gmail SMTP port 25 or 587.";
$title_email_schedule="Email Log Schedule";
$title_email_schedule_msg="Use the pull-down menu to set the e-mail log schedule.";

$head_mt="維護";

$title_mt_admin="管理者設定";
$mt_limit_admin_vid="管理者VID限制";
$mt_limit_admin_vid_msg="封包內包含VLAN tags,可透過相同的VID限制管理者登入管理的控制。";
$mt_limit_admin_ip="管理者IP範圍限制";
$mt_limit_admin_ip_msg="您可以透過輸入一組IP位址範圍來允許管理者登入的IP位址。";
$title_mt_sysname="系統名稱設定";
$mt_sysname="系統名稱";
$mt_sysname_msg="提供".query("/sys/hostname")."一個方便管理使用的名稱。";
$mt_location="位置";
$mt_location_msg="提供".query("/sys/hostname")."一個方便管理的設備位置。";
$title_mt_login="登入設定";
$mt_username="使用者名稱";
$mt_username_msg="您可以為".query("/sys/hostname")."設定管理者的登入使用者名稱。預設的使用者名稱為\"admin\",密碼的欄位不需要輸入。";
$mt_oldpass="舊密碼";
$mt_oldpass_msg="輸入舊的密碼。";
$mt_newpass="新密碼";
$mt_newpass_msg="輸入的密碼錯誤。密碼的文字有大小寫之分。\"A\"與\"a\"是屬於不同的字元。密碼的長度必須介於0~12個字元。";
$mt_conpass="確認新密碼";
$mt_conpass_msg="請再次輸入密碼進行確認。";
$title_mt_console="Console 設定";
$mt_status="狀態";
$mt_status_msg="啟用或停用console。";
$mt_console_protocol="Console 協定";
$mt_console_protocol_msg="選擇Telent或SSH。";
$mt_timeout="逾時";
$mt_timeout_msg="選擇逾時的週期。";
$title_mt_snmp="SNMP 設定";
$mt_st_snmp="狀態";
$mt_st_snmp_msg="啟用或停用SNMP。";
$mt_public_comm="共用公眾字串";
$mt_public_comm_msg="輸入SNMP的共用公眾字串。";
$mt_private_comm="私人公眾字串";
$mt_private_comm_msg="輸入SNMP的私人公眾字串。";
$mt_trap="Trap狀態";
$mt_trap_msg="啟用或停用Trap。";
$mt_trap_serv="Trap Server IP 位址。";
$mt_trap_serv_msg="SNMP 管理的IP位址為接收從無線基地台傳送的Trap。";
$title_mt_pingctrl="Ping 控制設定";
$mt_ping_st="狀態";
$mt_ping_st_msg="Ping 的運作方式是透過傳送ICMP\"echo packet\"封包來觸發host並且聆聽ICMP答覆的回應。";
if($cfg_ipv6=="1")
{
	$title_mt_fw="Firmware";
	$title_mt_fw_msg="Firmware Upload";
}
else
{

$title_mt_fw="韌體與SSL";
$title_mt_fw_msg="韌體與SSL憑證上傳";
}
$title_mt_fw_msg1="您可以上傳檔案到無線基地台。";
$mt_upload_fw="從局端硬碟上傳韌體";
$mt_upload_fw_msg="關於韌體的版本會顯示在檔案的位置欄位。完成最新韌體下載後,點選\"瀏覽\"按鍵選擇您所下載的最新韌體。當完成檔案的選擇,點選\"開啟\"與\"確認\"按鍵開始進行韌體的升級。在進行升級的期間請勿關閉電源。";
$mt_upload_ssl="從局端應硬碟上傳SSL 憑證";
$mt_upload_ssl_msg="在您從硬碟完成SSL認證下載後,點選\"瀏覽\"按鍵選擇您所下載的憑證。然後點選\"開啟\"與\"上傳\"按鍵開始進行升級。";
$mt_upload_language = "Language Pack Upgrade";
$mt_upload_language_msg = "The current Language Pack version is displayed above the file location field.. After the Language Pack ".
"is downloaded, click on the \"Browse\" button to locate the Language Pack. Once the file is selected, click on the \"Open\" and ".
"\"Upload\" button to begin updating the Language. Please don't turn the power off while upgrading.";

$_title_mt_config="設定組態檔案";
$mt_config="設定組態檔案上傳與下載";
$mt_config_msg="您可以從無線基地台上傳與下載設定組態檔案。";
$mt_upload_config="上傳設定組態檔案";
$mt_upload_config_msg="瀏覽選擇存放在您電腦硬碟的設定組態檔案並且點選\"開啟\"與\"上傳\"進行設定組態的上傳。";
$mt_download_config="下載設定組態檔案";
$mt_download_config_msg="點選\"下載\"儲存無線線基地台目前的設定組態檔案至您的硬碟。注意假如您所儲存的組態設定檔案是包含管理的密碼,在您重新設定您的".query("/sys/hostname")."並且更新所儲存的設定組態檔案,管理者的密碼將會消失。";

$title_mt_time="時間與日期";
$title_mt_time_msg="輸入NTP Server IP位址,選擇時區,並請選擇啟用或是停用日光節省時間。";
$auto_time = "Automatic Time Configuration";
$auto_time_msg = "Enable NTP get the date and time from a NTP server.";
$date_and_time_manu = "Set the Date and Time Manually";
$date_and_time_manu_msg = "You can set the date and time manually or copy your computer's time to AP.";

$head_config ="Configuration";
$config_save_activate="Save and Activate";
$config_save_activate_msg="Click\" Save and Activate  \" to save all settings and re-activate the system.";
$config_discard_change="Discard change";
$config_discard_change_msg="Click \"Discard change \" to discard the settings"; 

$head_sys = "系統";
$title_sys = "系統設定";
$sys_apply_restart = "確認設定並且重新開機";
$sys_apply_restart_msg = "點選\"重新開機\"確認設定並進行重新開機。";
$sys_apply_restore = "恢復原廠預設值。";
$sys_apply_restore_msg = "點選\"恢復\"將無線基地台恢復原廠預設值。";
$sys_clear_language = "Clear Language pack";
$sys_clear_language_msg = "Click on clear to reset language to default settings.";
?>
