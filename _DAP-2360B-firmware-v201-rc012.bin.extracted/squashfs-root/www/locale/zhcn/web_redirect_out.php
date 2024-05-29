<?
if(query("/wlan/inf:1/webredirect/auth/enable") == 1)
{
	$m_context_title	="认证成功";
}
else
{
	$m_context_title	="Notice";
}
$m_redirect_success	="认证成功";
$m_pls_cls_win ="请关闭此窗口，并重开新窗口进入因特网";
$m_pls_wait = "Web will be redirected. Please wait ... ";
$m_thank_u ="谢谢";
$m_ok ="好";

?>
