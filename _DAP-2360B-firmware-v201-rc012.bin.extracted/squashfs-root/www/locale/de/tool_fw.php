<?
$cfg_ipv6 = query("/inet/entry:1/ipv6/valid");
if($cfg_ipv6=="1")
{
	$m_context_title = "Firmware Upload";
}
else
{
$m_context_title = "Firmware- und SSL-Zertifizierung hochladen";
}
$m_upload_fw_title ="Firmware von lokaler Festplatte aktualisieren";
$m_firmware_version	="Firmware-Version";
$m_upload_firmware_file	="Firmware von Datei hochladen";	
$m_upload_lang_title ="SPRACHPAKET-UPGRADE";	
$m_upload_lang_file	="Hochladen";	
$m_upload_ssl_titles = "SSL-Zertifizierung von der lokalen Festplatte aktualisieren";
$m_upload_certificatee_file	= "Zertifikat von Datei hochladen";	
$m_upload_key_file	= "Schlüssel von Datei hochladen";	
$m_b_fw_upload = "Hochladen";
$m_upload_wapi_title = "Update AS and AP Certification From Local Hard Drive";
$m_wapi_status = "Status of Certificate :";
$m_no_cert = "No Certificate";
$m_invalid_cert = "Invalid Certificate";
$m_valid_cert = "Valid Certificate";
$m_upload_ascert_file = "Upload AS Certificate From File :";
$m_upload_apcert_file = "Upload AP Certificate From File :";
$a_blank_fw_file= "Leere Datei kann nicht akzeptiert werden!";
$a_format_error_file =" Fehler im Dateiformat. Versuchen Sie es bitte erneut!";
$a_reboot_device = "Please reboot the device for updete SSL key setting!";
$a_reboot_device_cert = "Please reboot the device for updete AP Certification setting!";
?>
