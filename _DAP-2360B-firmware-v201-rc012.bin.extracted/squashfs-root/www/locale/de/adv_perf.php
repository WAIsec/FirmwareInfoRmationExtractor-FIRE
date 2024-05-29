<?
$m_context_title = "Performance-Einstellungen";
$m_band = "Wireless band";
$m_band_2.4G = "2.4GHz";
$m_band_5G = "5GHz";
$m_wl_enable = "Drahtlos";
$m_disable = "Deaktivieren";
$m_enable  = "Aktivieren";
$m_off = "Aus";
$m_on  = "Ein";
$m_wlmode = "Funkmodus";
$m_wlmode_n_g_b = "802.11n, 802.11g und 802.11b gemischt";
$m_wlmode_n_g = "802.11n und 802.11g gemischt";
$m_wlmode_g_b = "802.11g und 802.11b gemischt";
$m_wlmode_n = "Nur 802.11n";
$m_wlmode_n_a = "802.11n und 802.11a gemischt";
$m_wlmode_a = "Nur 802.11a";
$m_rate = "Datenrate";
$m_best	= "Best (bis zu 300)";
$m_best_54	= "Best (bis zu 54)";
$m_54	= "54";
$m_48	= "48";
$m_36	= "36";
$m_24	= "24";
$m_18	= "18";
$m_12	= "12";
$m_9	= "9";
$m_6	= "6";
$m_11	= "11";
$m_5.5	= "5.5";
$m_2	= "2";
$m_1	= "1";
$m_beacon_interval	="Beacon-Intervall (25-500)";
$m_rts			="RTS-Schwellenwert (256-2346)";
$m_frag			="Fragmentierung (256-2346)";
$m_dtim			="DTIM-Intervall (1-15)";
$m_power = "Übertragungsleistung";
$m_ms = "(&micro;s)";

$m_sw_power = "SW Transmit Power";
$m_ampdu = "AMPDU";
$m_amsdu = "AMSDU";
$m_chainmask = "ChainMask";
$m_1x1 = "1x1";
$m_2x2 = "2x2";
$m_wmm = "WMM (Wi-Fi Multimedia)";
$m_shortgi = "Kurzes GI";
$m_limit_state = "Verbindungslimit";
$m_limit_num = "Benutzerlimit (0 - 64)";
$m_utilization = "Netzwerknutzung";
$m_0 = "0";
$m_10 = "10";
$m_20 = "20";
$m_30 = "30";
$m_40 = "40";
$m_50 = "50";
$m_60 = "60";
$m_70 = "70";
$m_80 = "80";
$m_90 = "90";
$m_100 = "100";
$m_180 = "180";
$m_75 = "75";
$m_25 = "25";
$m_12.5 = "12.5";
$m_igmp = "IGMP-Snooping";
$m_link_integrality="Link-Integrität";
$m_ack_timeout="Ack Time Out (Timeout für das Bestätigungspaket des Empfängers für den Sender)";
$m_mbps = "(Mbps)";
$m_multicast_rate  = "Multicast Rate ";
$m_mcast_a = "Multicast Rate for 5G Band";
$m_mcast_g = "Multicast Rate for 2.4G Band";
if(query("/runtime/web/display/ack_timeout_range")=="0")
{
$m_ack_timeout_g_msg = " (2.4GHz, 48~200)";
$m_ack_timeout_a_msg = " (5GHz, 25~200)";
	$a_invalid_ack_timeoutg ="Der Ack Timeout-Wertebereich liegt zwischen 48 und 200.";
	$a_invalid_ack_timeouta ="Der Ack Timeout-Wertebereich liegt zwischen 25 und 200.";
}
else
{
	$m_ack_timeout_g_msg = " (2.4GHz, 64~200)";
	$m_ack_timeout_a_msg = " (5GHz, 50~200)";
	$a_invalid_ack_timeoutg ="Der Ack Timeout-Wertebereich liegt zwischen 64 und 200.";
	$a_invalid_ack_timeouta ="Der Ack Timeout-Wertebereich liegt zwischen 50 und 200.";
}
$a_invalid_txswpower = "The SW Transmit Power value range is 0 ~ 30.";
$a_invalid_bi		="Der Wertebereich des Beacon-Intervalls liegt zwischen 25 und 500.";
$a_invalid_rts		="Der Wertebereich des RTS-Schwellenwerts ist 256 bis 2346.";
$a_invalid_frag		="Der Wertebereich der Fragmentierung liegt zwischen 256 und 2346.";
$a_invalid_dtim		="Der Wertebereich des DTIM-Intervalls liegt zwischen 1 und 15.";
$a_invalid_limit_num	="Der Bereich des Benutzerlimits ist 0 bis 64.";

?>
