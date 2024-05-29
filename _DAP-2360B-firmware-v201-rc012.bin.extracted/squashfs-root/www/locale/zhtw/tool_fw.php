<?
$cfg_ipv6 = query("/inet/entry:1/ipv6/valid");
if($cfg_ipv6=="1")
{
	$m_context_title = "Firmware Upload";
}
else
{
$m_context_title = "韌體與SSL憑證上傳";
}

$m_upload_fw_title ="從局端硬碟上傳韌體";
$m_firmware_version	="韌體版本";
$m_upload_firmware_file	="從檔案上傳韌體";	
$m_upload_lang_title ="語言包昇級";	
$m_upload_lang_file	="上傳";	
$m_upload_ssl_titles = "從局端硬碟更新SSL憑證";
$m_upload_certificatee_file	= "從檔案上傳憑證";	
$m_upload_key_file	= "從檔案上傳金鑰";	
$m_b_fw_upload = "上傳";
$m_upload_wapi_title = "Update AS and AP Certification From Local Hard Drive";
$m_wapi_status = "Status of Certificate :";
$m_no_cert = "No Certificate";
$m_invalid_cert = "Invalid Certificate";
$m_valid_cert = "Valid Certificate";
$m_upload_ascert_file = "Upload AS Certificate From File :";
$m_upload_apcert_file = "Upload AP Certificate From File :";
$a_blank_fw_file= "缺少檔案是無法確認的!";
$a_format_error_file ="檔案格式錯誤!請再確認一次!";
$a_reboot_device = "Please reboot the device for update SSL key setting!";
$a_reboot_device_cert = "Please reboot the device for update AP Certification setting!";
?>
