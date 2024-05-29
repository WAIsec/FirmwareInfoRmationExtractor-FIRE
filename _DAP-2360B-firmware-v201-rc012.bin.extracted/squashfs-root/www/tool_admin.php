<?
/* vi: set sw=4 ts=4: ---------------------------------------------------------*/
$MY_NAME      = "tool_admin";
$MY_MSG_FILE  = $MY_NAME.".php";
$MY_ACTION    = $MY_NAME;
$NEXT_PAGE    = "tool_admin";
set("/runtime/web/help_page",$MY_NAME);
/* --------------------------------------------------------------------------- */
if($ACTION_POST != "")
{
	require("/www/model/__admin_check.php");
	require("/www/__action.php");
	$ACTION_POST = "";
	exit;
}

/* --------------------------------------------------------------------------- */
require("/www/model/__html_head.php");
require("/www/comm/__js_ip.php");
set("/runtime/web/next_page",$first_frame);
/* --------------------------------------------------------------------------- */
// get the variable value from rgdb.
echo "<!--debug\n";
//$cfg_ipv6 = query("/inet/entry:1/ipv6/valid");
$cfg_limit_admin_status = query("/sys/adminlimit/status");
$cfg_vlan = query("/sys/vlan_state");
$cfg_mode = query("/sys/vlan_mode");
$cfg_auth = query("/wlan/inf:1/authentication");
$cfg_url = query("/wlan/inf:1/webredirect/enable");
$security_eap = "";
if($cfg_auth=="2" || $cfg_auth=="4" || $cfg_auth=="6") 
{$security_eap="1";} //eap
$limit_index = 0;
$cfg_admin_vid=query("/sys/adminlimit/vlanid");

anchor("/sys/user:1");
$cfg_user_name=query("name");

anchor("/sys/consoleprotocol");
$cfg_con_pro	= query("protocol");
$cfg_con_timeout	= query("timeout");

anchor("/sys/snmpd");
$snmp_status	= query("status");
$snmp_rocomm	= get("j","rocomm");
$snmp_rwcomm	= get("j","rwcomm");
$trap_status	= query("/sys/snmptrap/status");
$trap_server_ip = query("hostip:1");

$cfg_ping	= query("/sys/pingctl");

$cfg_sysname = get("j","/sys/systemName");
$cfg_syslocation = get("j","/sys/systemLocation");

$cfg_wtp_enable = query("/sys/wtp/enable");
$cfg_apmode=query("/wlan/inf:1/ap_mode");	
$cfg_apmode_a=query("/wlan/inf:2/ap_mode");
$cfg_ap_array_enable = query("/wlan/inf:1/aparray_enable");

$cfg_ap_array = query("/wlan/inf:1/aparray_enable");
$cfg_sw_enable = query("/sys/swcontroller/enable");
if($cfg_sw_enable != 1){$cfg_sw_enable = 0;}
$cfg_bsw_enable = query("/sys/b_swcontroller/enable");
if($cfg_bsw_enable != 1){$cfg_bsw_enable = 0;}

$cfg_led = query("/sys/led/power");
echo "-->";
/* --------------------------------------------------------------------------- */
?>

<?
echo $G_TAG_SCRIPT_START."\n";
require("/www/model/__wlan.php");
?>

var ip_list=[['index','ip_from','ip_to']
<?
for("/sys/adminlimit/ipentry/index")
{
    echo ",\n ['".$@."','".query("ippoolstart")."','".query("ippoolend")."']";
	if(query("ippoolstart") != "")
	{$limit_index++;}
}
?>
];

function on_check_div_display(obj,div_obj)
{
	var f = get_obj("frm");
	
	for(var i=0; i<obj.length; i++)
	{
		get_obj(div_obj[i]).style.display = "none";
		if(get_obj(obj[i]).checked)
		{
			get_obj(div_obj[i]).style.display = "";
		
		}
	}	
	AdjustHeight();
}
function on_check_console_status(s)
{
	var f = get_obj("frm");
	f.console_pro[0].disabled = true;
	f.console_pro[1].disabled = true;
	f.timeout.disabled = true;
	
	if(s.checked)
	{
		f.console_pro[0].disabled = false;
		f.console_pro[1].disabled = false;
		f.timeout.disabled = false;		
	}
}

function on_check_snmp_status(s)
{
	var f = get_obj("frm");
	
    if(s.checked == true)
    {
        f.snmp_public.disabled = false;
        f.snmp_private.disabled = false;
        if(f.trap_status !=null)
        {
			f.trap_status.disabled = false;
			on_check_trap_status(f.trap_status);   
		}
	}
    else
    {
        f.snmp_public.disabled = true;
        f.snmp_private.disabled = true;
        if(f.trap_status !=null)
        {
			f.trap_status.disabled = true;
		   	f.trap_server_ip.disabled = true;
    	}
    }		
}

function on_check_trap_status(s)
{
	var f = get_obj("frm");
	if(s.checked == true)
    {
    	f.trap_server_ip.disabled = false; 
    }
    else
    {
    	f.trap_server_ip.disabled = true; 
    }
}

function on_check_limit_admin_vid(s)
{
	var f = get_obj("frm");
	
	f.admin_vid.disabled = true; 
	if(s.checked)
	{
		f.admin_vid.disabled = false; 
		if("<?=$cfg_vlan?>"==1 || "<?=$cfg_mode?>"==1 || "<?=$cfg_url?>"==1)
		{
			alert("<?=$a_enable_limit_admin_status?>");
		}
	}
	
}

function on_check_limit_admin_ip(s)
{
	var f = get_obj("frm");
	f.ip_from.disabled = true; 
	f.ip_to.disabled = true; 
	f.add.disabled = true; 
	
	if(s.checked)
	{
		f.ip_from.disabled = false; 
		f.ip_to.disabled = false; 
		f.add.disabled = false; 
	}	
}

function print_rule_del(id)
{
	var str="";

	str+="&nbsp;&nbsp;<a href='javascript:list_del_confirm(\""+id+"\")'><img src='/pic/delete.jpg' border=0></a>";

	document.write(str);
}

function list_del_confirm(id)
{
	var f = get_obj("frm");

	if("<?=$limit_index?>" == "1" && ("<?=$cfg_limit_admin_status?>" == 3 || "<?=$cfg_limit_admin_status?>" == 2))
	{
		if(confirm("<?=$a_disable_limit_ip?>")==true)
		{
			f.f_list_del.value = id;
			f.f_disable_ip.value = 1;
			get_obj("frm").submit();
		}
	}
	else
	{
		f.f_list_del.value = id;
		get_obj("frm").submit();
	}
}

/* page init functoin */
function init()
{
	var f = get_obj("frm");
	if("<?=$cfg_sw_enable?>" == 1)
	{
		get_obj("normal_setting").style.display = "none";
	}
	if(f.limit_admin_vid != null)
	{
		f.limit_admin_vid.checked = false;		
	}
	if(f.limit_admin_ip != null)
	{
		f.limit_admin_ip.checked = false;	
	}
	
	if(f.limit_admin_ip != null && f.limit_admin_vid != null)
	{
		if("<?=$cfg_limit_admin_status?>" == 1)
		{
			f.limit_admin_vid.checked = true;	
		}
		else if("<?=$cfg_limit_admin_status?>" == 2)
		{
			f.limit_admin_ip.checked = true;		
		}
		else if("<?=$cfg_limit_admin_status?>" == 3)
		{
			f.limit_admin_vid.checked = true;	
			f.limit_admin_ip.checked = true;
		}
	}	
	
	if(f.limit_admin_vid != null)
	{
		on_check_limit_admin_vid(f.limit_admin_vid);
	}
	if(f.limit_admin_ip != null)
	{
		on_check_limit_admin_ip(f.limit_admin_ip);
	}
	if("<?=$TITLE?>" != "DAP-2690" && "<?=$TITLE?>" != "DAP-3690" && "<?=$TITLE?>" != "DWL-8500AP")
	{
		if(f.limit_admin_ip != null && f.limit_admin_vid != null)
		{
			if("<?=$cfg_apmode?>"==1 || "<?=$cfg_ap_array_enable?>"==1 )
			{
				f.limit_admin_vid.disabled = true;	
				f.limit_admin_ip.disabled = true;
			}
		}
	}
	else
	{
		if(f.limit_admin_ip != null && f.limit_admin_vid != null)
		{
			if("<?=$cfg_apmode?>"==1 || "<?=$cfg_apmode_a?>"==1 || "<?=$cfg_ap_array_enable?>"==1 )
			{
				f.limit_admin_vid.disabled = true;	
				f.limit_admin_ip.disabled = true;
			}
		}
	}
	if(f.admin_vid != null)
	{
		f.admin_vid.value		= "<?=$cfg_admin_vid?>";
	}
	
	if(f.sysname != null)
	{
		f.sysname.value = "<?=$cfg_sysname?>";
	}
	
	if(f.location != null)
	{
		f.location.value = "<?=$cfg_syslocation?>";
	}
	
	if(f.user_name != null)
	{
		f.user_name.value = "<?=$cfg_user_name?>";
	}
	
	if(f.console_status != null)
	{
		f.console_status.checked = <? if ($cfg_con_pro!="0") {echo "true";} else {echo "false";}?>;

		if("<?=$cfg_con_pro?>"=="2")		f.console_pro[1].checked=true;
		else 	f.console_pro[0].checked=true;	
	}	
	
	if(f.timeout != null)
	{
		select_index(f.timeout, "<?=$cfg_con_timeout?>");
	}
	
	if(f.snmp_status != null)
	{
		f.snmp_status.checked = <? if ($snmp_status=="1") {echo "true";} else {echo "false";}?>;
	}
	
	if(f.snmp_public != null)
	{
		f.snmp_public.value = "<?=$snmp_rocomm?>";
	}
	
	if(f.snmp_private != null)
	{
		f.snmp_private.value = "<?=$snmp_rwcomm?>";
	}
	
	if(f.trap_status != null)
	{
		f.trap_status.checked = <? if ($trap_status=="1") {echo "true";} else {echo "false";}?>;
	}
	
	if(f.trap_server_ip != null)
	{
		f.trap_server_ip.value	= "<?=$trap_server_ip?>";
	}
	
	if(f.ping_status != null)
	{
		f.ping_status.checked = <? if ($cfg_ping == "1") {echo "false";} else {echo "true";}?>;
	}		
	
	if(f.console_status != null)
	{
		on_check_console_status(f.console_status);
	}
	
	if(f.snmp_status != null)
	{
		on_check_snmp_status(f.snmp_status);
	}
	
	if("<?=$cfg_wtp_enable?>" == 1)
	{
		f.sysname.disabled=true;
		f.location.disabled=true;
		f.sysname_setting.checked = true;
		f.sysname_setting.disabled = true;
		on_check_div_display(['sysname_setting'],['div_sysname'])
	}
	if(f.sw_enable != null)
	{
		f.sw_enable.value = "<?=$cfg_sw_enable?>";
	}
	if(f.led_st != null)
	{
		if("<?=$cfg_led?>" == "1")
			f.led_st[0].checked = true;
		else
			f.led_st[1].checked = true;
	}
	AdjustHeight();
}

/* parameter checking */
function check()
{
	
	var f=get_obj("frm");

	if(f.limit_admin_vid != null && f.limit_admin_ip != null )
	{
		if(f.limit_admin_vid.checked == true && f.limit_admin_ip.checked == true)
		{
			f.f_limit_status.value = 3;
		}
		else if(f.limit_admin_vid.checked == true && f.limit_admin_ip.checked != true)
		{
			f.f_limit_status.value = 1;
		}
		else if(f.limit_admin_vid.checked != true && f.limit_admin_ip.checked == true)
		{
			f.f_limit_status.value = 2;
		}	
		else
		{
			f.f_limit_status.value = 0;
		}
		if(f.limit_admin_ip.checked == true && "<?=$limit_index?>" == 0)
		{
			alert("<?=$a_empty_ip_list?>");		
			f.ip_from.focus();
			return false;
		}
	}
	
	if(f.limit_admin_vid != null)
	{
		if(f.limit_admin_vid.checked == true)
		{
			if(!is_in_range(f.admin_vid.value,1,4094))
			{
				alert("<?=$a_invalid_admin_vid?>");
				if(f.admin_vid.value=="") f.admin_vid.value=1;
				field_select(f.admin_vid);
				return false;
			}			
		}
	}	
	
	if(f.sysname != null)
	{
		if(is_blank(f.sysname.value))
		{
			alert("<?=$a_empty_sysname?>");
			f.sysname.select();
			return false;
		}		
			
		if(first_blank(f.sysname.value))
		{
			alert("<?=$a_first_blank_sysname?>");
			f.sysname.select();
			return false;
		}
			
		if(strchk_unicode(f.sysname.value))
		{
			alert("<?=$a_invalid_sysname?>");
			f.sysname.select();
			return false;
		}
	}

	if(f.location != null)
	{
		if(first_blank(f.location.value))
		{
			alert("<?=$a_first_blank_location?>");
			f.location.select();
			return false;
		}
			
		if(strchk_hostname(f.location.value) == false)
		{
			alert("<?=$a_invalid_location?>");
			f.location.select();
			return false;
		}
	}
	
	if(f.user_name != null)
	{
		if(is_blank(f.user_name.value))
		{
			alert("<?=$a_empty_login_name?>");
			f.user_name.select();
			return false;
		}
		else if(strchk_hostname(f.user_name.value)==false)
		{
			alert("<?=$a_invalid_login_name?>");
			f.user_name.select();
			return false;
		}
		if(first_blank(f.user_name.value))
		{
			alert("<?=$a_first_blank_user_name?>");
			f.user_name.select();
			return false;
		}
			
		if(strchk_unicode(f.user_name.value))
		{
			alert("<?=$a_invalid_user_name?>");
			f.user_name.select();
			return false;
		}
	}
	
	
	if(f.new_password != null)
	{
		if(f.con_change.checked)
		{
			if(strchk_unicode(f.new_password.value)==true)
			{
				alert("<?=$a_invalid_new_password?>");
				f.new_password.select();
				return false;
			}
				
			if(f.new_password.value != f.confirm_password.value)
			{
				alert("<?=$a_password_not_matched?>");
				f.new_password.select();	
				return false;
			}
			f.con_change.value = 1;
		}
	}

	if(f.console_status != null)
	{
		if(f.console_status.checked)
		{
			f.f_console_pro.value = (f.console_pro[1].checked?2:1);
		}
		else
		{
			f.f_console_pro.value = 0;
		}
	}	
	
	if(f.snmp_status != null)
	{
		if(f.snmp_status.checked)
		{
			
	        if(is_blank(f.snmp_public.value))
	        {
	            alert("<?=$a_empty_snmp_public?>")
	            f.snmp_public.focus();
	            return false;
	        }	
	        if(first_blank(f.snmp_public.value))
			{
				alert("<?=$a_first_blank_public?>");
				f.snmp_public.select();
				return false;
			}
			if(strchk_unicode(f.snmp_public.value))
			{
			    alert("Invalid Value!");
			    f.snmp_public.select();
				return false;
			}
	        if(is_blank(f.snmp_private.value))
	        {
	            alert("<?=$a_empty_snmp_private?>")
	            f.snmp_private.focus();
	            return false;
	        } 
	        if(first_blank(f.snmp_private.value))
			{
				alert("<?=$a_first_blank_private?>");
				f.snmp_private.select();
				return false;
			}
			if(strchk_unicode(f.snmp_private.value))
			{
			    alert("Invalid Value!");
			    f.snmp_private.select();
				return false;
			}
	        if(f.trap_status != null)
	        {  
				if(f.trap_status.checked)
				{
					if (f.trap_server_ip.value == "")
					{
						alert("<?=$a_empty_trap_server?>");
						field_focus(f.trap_server_ip, "**");
						return false;
					}			
				}        
			}		
		}
	}
	
	if(f.ping_status != null)
	{
		if(f.ping_status.checked == true)
		{
			f.f_ping_status.value =0;
		}
		else
		{
			f.f_ping_status.value =1;	
		}
	}	
	
	if(f.snmp_status != null)
	{
		if(f.snmp_status.checked == true)
		{
			f.f_snmp_status.value =1;
		}
		else
		{
			f.f_snmp_status.value =0;	
		}
	}
	
	if(f.trap_status != null)
	{
		if(f.trap_status.checked == true)
		{
			f.f_trap_status.value =1;
		}
		else
		{
			f.f_trap_status.value =0;	
		}	
	}	
	if(f.led_st != null)
		f.f_led_st.value = (f.led_st[0].checked?1:0);
	
	fields_disabled(f, false);
	return true;
}

function on_enable_sw()
{
	var f = get_obj("frm");
	if(f.sw_enable.value == 1 && "<?=$cfg_sw_enable?>" != 1 && "<?=$cfg_ap_array?>" == 1)
		alert("<?=$a_disable_aparray?>");
}

function submit()
{
	if(check()) get_obj("frm").submit();
}

function do_add()
{
	var f	=get_obj("frm");
	var ip_f, ip_t;
	
	if("<?=$limit_index?>" == 4)
	{
		alert("<?=$a_max_ip_table?>");	
		return false;
	}
		
	if (!is_valid_ip3(f.ip_from.value, 0))
	{
		alert("<?=$a_invalid_ip?>");
		field_focus(f.ip_from, "**");
		return false;
	}	

	if (!is_valid_ip3(f.ip_to.value, 0))
	{
		alert("<?=$a_invalid_ip?>");
		field_focus(f.ip_to, "**");
		return false;
	}		
	
	ip_f = get_ip(f.ip_from.value);
	ip_t = get_ip(f.ip_to.value);	
	
	if((parseInt(ip_t[4], [10]) - parseInt(ip_f[4], [10])) < 0)
	{
		alert("<?=$a_invalid_ip_range?>");	
		field_focus(f.ip_to, "**");
		return false;
	}

	if((ip_f[1] != ip_t[1]) ||(ip_f[2] != ip_t[2]) ||(ip_f[3] != ip_t[3]))
	{
		alert("<?=$a_invalid_ip_range?>");	
		field_focus(f.ip_to, "**");
		return false;
	}
	
	for(var s=0;s<"<?=$limit_index?>";s++)
	{
		var i=s+1;
		if(f.ip_from.value == ip_list[i][1])
		{
			if(f.ip_to.value == ip_list[i][2])
			{
				alert("<?=$a_same_ip_range?>");
				field_focus(f.ip_to, "**");
				return false;
			}
		}
	}

	if("<?=$cfg_limit_admin_status?>" == 0 || "<?=$cfg_limit_admin_status?>" == 2)
	{
		f.f_limit_status.value = 2;
	}	
	else
	{
		f.f_limit_status.value = 3;
	}
	f.f_add_value.value="1";
	get_obj("frm").submit();	
}
</script>

<body <?=$G_BODY_ATTR?> onload="init();">

<form name="frm" id="frm" method="post" action="<?=$MY_NAME?>.php" onsubmit="return false;">

<input type="hidden" name="ACTION_POST" value="<?=$MY_ACTION?>">
<input type="hidden" name="f_console_pro"		  value="">
<input type="hidden" name="f_led_st"         value="">
<input type="hidden" name="f_add_value"		  value="">
<input type="hidden" name="f_list_del"		  value="">
<input type="hidden" name="f_limit_status"		  value="">
<input type="hidden" name="f_ping_status"		  value="">
<input type="hidden" name="f_snmp_status"		  value="">
<input type="hidden" name="f_trap_status"		  value="">
<input type="hidden" name="f_disable_ip"         value="">

<table id="table_frame" border="0"<?=$G_TABLE_ATTR_CELL_ZERO?>>
	<tr>
		<td valign="top">
			<table id="table_header" <?=$G_TABLE_ATTR_CELL_ZERO?>>
			<tr>
				<td id="td_header" valign="middle"><?=$m_context_title?></td>
			</tr>
			</table>
<!-- ________________________________ Main Content Start ______________________________ -->
			<table id="table_set_main"  border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
				<tbody id="normal_setting">
<? if(query("/sys/wtp/enable") =="1" /*|| $cfg_ipv6 =="1"*/)	{echo "<!--";} ?>
				<tr>
					<td colspan="2">
						<table class="table_tool" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
							<tr>
								<td class="table_tool_td" valign="middle" colspan="2">
									<b><?=$m_limit_title?></b>&nbsp;
									<?=$G_TAG_SCRIPT_START?>genCheckBox("limit_admin_setting","on_check_div_display(['limit_admin_setting'],['div_limit_admin'])");<?=$G_TAG_SCRIPT_END?>		
								</td>
							</tr>
							<tr>
								<td colspan="2">	
									<div id="div_limit_admin" style="display:none;">
									<table width="100%" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>				
										<tr>
											<td width="35%" id="td_left"><?=$m_limit_admin_vid?></td>
											<td id="td_right">
												<?=$G_TAG_SCRIPT_START?>genCheckBox("limit_admin_vid","on_check_limit_admin_vid(this)");<?=$G_TAG_SCRIPT_END?>	
												<?=$m_enable?>&nbsp;&nbsp;&nbsp;&nbsp;
												<input name="admin_vid" id="admin_vid" class="text" type="text" size="6" maxlength="4" value="">
											</td>
										</tr>							
										<tr>
											<td id="td_left"><?=$m_limit_admin_ip?></td>
											<td id="td_right">
												<?=$G_TAG_SCRIPT_START?>genCheckBox("limit_admin_ip","on_check_limit_admin_ip(this)");<?=$G_TAG_SCRIPT_END?>	
												<?=$m_enable?>
											</td>
										</tr>	
										<tr>
											<td id="td_left"><?=$m_ip_range?></td>
											<td id="td_right">
												<?=$m_from?>:
												<input name="ip_from" id="ip_from" class="text" type="text" size="15" maxlength="15" value="">
												&nbsp;&nbsp;&nbsp;&nbsp;
												<?=$m_to?>:
												<input name="ip_to" id="ip_to" class="text" type="text" size="15" maxlength="15" value="">
												&nbsp;&nbsp;
												<input type="button" id="add" name="add" value=" <?=$m_b_add?> " onclick="do_add()">
											</td>
										</tr>	
										<tr>
											<td colspan="2">
												<table width="100%" border="0"<?=$G_TABLE_ATTR_CELL_ZERO?> style="padding-left:3px;">
													<tr class="list_head" align="left">
														<td width="70">
															<?=$m_id?>
														</td>
														<td width="100">
															<?=$m_from?>
														</td>
														<td width="100">
															<?=$m_to?>
														</td>											
														<td>
															<?=$m_del?>
														</td>																																																										
													</tr>	
												</table>	
												<div class="div_tab">
													<table id="acl_tab" width="100%" border="0"<?=$G_TABLE_ATTR_CELL_ZERO?> style="padding-left:3px;">						
<?
$tmp = "";
for("/sys/adminlimit/ipentry/index")
{
	$tmp = $@%2;

	if(query("ippoolstart") !="")
	{
		if($tmp == 1)
		{
			echo "<tr align=\"left\" style=\"background:#cccccc;\">\n";
			$tmp = 0;
		}
		else
		{
			echo "<tr align=\"left\" style=\"background:#b3b3b3;\">\n";
			$tmp = 1;
		}
		echo "<td width=\"70\">".$@."</td>\n";	
		echo "<td width=\"100\">".query("ippoolstart")."</td>\n";	
		echo "<td width=\"100\">".query("ippoolend")."</td>\n";
		echo "<td>".$G_TAG_SCRIPT_START."print_rule_del(".$@.");".$G_TAG_SCRIPT_END."</td></tr></td>\n";			
		echo "</tr>\n";	
	}
}
?>
													</table>
												</div>
											</table>
											</div>
										</td>
									</tr>															
								</td>
							</tr>																														
						</table>
					</td>
				</tr>
<? if(query("/sys/wtp/enable") =="1"/* || $cfg_ipv6 =="1"*/)	{echo "-->";} ?>				
				<tr>
					<td colspan="2">
						<table class="table_tool" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
							<tr>
								<td class="table_tool_td" valign="middle" colspan="2"><b><?=$m_sysname_title?></b>&nbsp;
									<?=$G_TAG_SCRIPT_START?>genCheckBox("sysname_setting","on_check_div_display(['sysname_setting'],['div_sysname'])");<?=$G_TAG_SCRIPT_END?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div id="div_sysname" style="display:none;">
										<table width="100%" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
											<tr>
												<td width="35%" id="td_left">
													<?=$m_sysname?>
												</td>								
												<td id="td_right">
													<input name="sysname" id="sysname" class="text" type="text" size="20" maxlength="32" value="">
												</td>
											</tr>	
											<tr>
												<td id="td_left">
													<?=$m_location?>
												</td>
												<td id="td_right">
													<input name="location" id="location" class="text" type="text" size="20" maxlength="32" value="">
												</td>
											</tr>																						
										</table>
									</div>
								</td>
							</tr>
						</table>
					</td>	
				</tr>	
<? if(query("/sys/wtp/enable") =="1")	{echo "<!--";} ?>				
				<tr>
					<td colspan="2">
						<table class="table_tool" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
							<tr>
								<td class="table_tool_td" valign="middle" colspan="2">
									<b><?=$m_login_title?></b>&nbsp;
									<?=$G_TAG_SCRIPT_START?>genCheckBox("login_setting","on_check_div_display(['login_setting'],['div_login'])");<?=$G_TAG_SCRIPT_END?>
								</td>
							</tr>
							<tr>
								<td colspan="2">	
									<div id="div_login" style="display:none;">
									<table width="100%" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>				
										<tr>
											<td width="35%" id="td_left">
												<?=$m_login_name?>
											</td>
											<td id="td_right">
												<input name="user_name" id="user_name" class="text" type="text" size="20" maxlength="64" value="">
											</td>
										</tr>	
										<tr>
											<td id="td_left">
												<?=$m_new_password?>
											</td>
											<td id="td_right">
												<input name="new_password" id="new_password" class="text" type="password" size="20" maxlength="64" value="">
											</td>
										</tr>
										<tr>
											<td id="td_left">
												<?=$m_confirm_password?>
											</td>
											<td id="td_right">
												<input name="confirm_password" id="confirm_password" class="text" type="password" size="20" maxlength="64" value="">
												<input type="checkbox" id="con_change" name="con_change" value=""><?=$m_con_change?>
											</td>
										</tr>		
									</table>
									</div>
								</td>
							</tr>																												
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table class="table_tool" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
							<tr>
								<td class="table_tool_td" valign="middle" colspan="2"><b><?=$m_console_title?></b>&nbsp;
									<?=$G_TAG_SCRIPT_START?>genCheckBox("console_setting","on_check_div_display(['console_setting'],['div_console'])");<?=$G_TAG_SCRIPT_END?>
								</td>
							</tr>
							<tr>
								<td colspan="2">	
									<div id="div_console" style="display:none;">
										<table width="100%" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
											<tr>								
												<td width="35%" id="td_left"><?=$m_status?></td>
												<td id="td_right">
													<?=$G_TAG_SCRIPT_START?>genCheckBox("console_status","on_check_console_status(this)");<?=$G_TAG_SCRIPT_END?>	
													<?=$m_enable?>
												</td>
											</tr>	
											<tr>
												<td id="td_left"><?=$m_console_protocol?></td>
												<td id="td_right">
													<input type="radio" id="console_pro" name="console_pro" value="1"><?=$m_telnet?>
													<input type="radio" id="console_pro" name="console_pro" value="2"><?=$m_ssh?>
												</td>
											</tr>	
											<tr>
												<td id="td_left"><?=$m_timeout?></td>
												<td id="td_right">
													<?=$G_TAG_SCRIPT_START?>genSelect("timeout", [60,180,300,600,900,0], ["<?=$m_1min?>","<?=$m_3mins?>","<?=$m_5mins?>","<?=$m_10mins?>","<?=$m_15mins?>","<?=$m_never?>"], "");<?=$G_TAG_SCRIPT_END?>
												</td>
											</tr>													
										</table>
									</div>
								</td>
							</tr>																												
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table class="table_tool" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
							<tr>
								<td class="table_tool_td" valign="middle" colspan="2"><b><?=$m_snmp_title?></b>&nbsp;
									<?=$G_TAG_SCRIPT_START?>genCheckBox("snmp_setting","on_check_div_display(['snmp_setting'],['div_snmp'])");<?=$G_TAG_SCRIPT_END?>
								</td>
							</tr>
							<tr>
								<td colspan="2">	
									<div id="div_snmp" style="display:none;">
										<table width="100%" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
											<tr>
												<td width="35%" id="td_left"><?=$m_status?></td>
												<td id="td_right">
													<?=$G_TAG_SCRIPT_START?>genCheckBox("snmp_status","on_check_snmp_status(this)");<?=$G_TAG_SCRIPT_END?>	
													<?=$m_enable?>
												</td>
											</tr>	
											<tr>
												<td id="td_left"><?=$m_snmp_public?></td>
												<td id="td_right">
													<input name="snmp_public" id="snmp_public" class="text" type="text" size="12" maxlength="32" value="">
												</td>
											</tr>
											<tr>
												<td id="td_left"><?=$m_snmp_private?></td>
												<td id="td_right">
													<input name="snmp_private" id="snmp_private" class="text" type="text" size="12" maxlength="32" value="">
												</td>
											</tr>	
<? if(query("/sys/wtp/enable") =="1")	{echo "-->";} ?>												
<? if(query("/runtime/web/display/snmp/trap") !="1" || query("/sys/wtp/enable") =="1")	{echo "<!--";} ?>
											<tr>
												<td id="td_left"><?=$m_trap?>&nbsp;<?=$m_status?></td>
												<td id="td_right">
													<?=$G_TAG_SCRIPT_START?>genCheckBox("trap_status","on_check_trap_status(this)");<?=$G_TAG_SCRIPT_END?>	
													<?=$m_enable?>
												</td>
											</tr>	
											<tr>
												<td id="td_left"><?=$m_trap_server_ip?></td>
												<td id="td_right">
													<input name="trap_server_ip" id="trap_server_ip" class="text" type="text" size="15" maxlength="15" value="">
												</td>
											</tr>
<? if(query("/runtime/web/display/snmp/trap")!="1" || query("/sys/wtp/enable") =="1")	{echo "-->";} ?>																																					
<? if(query("/sys/wtp/enable") =="1")	{echo "<!--";} ?>	
										</table>
									</div>
								</td>
							</tr>																												
						</table>
					</td>
				</tr>
<? if(query("/sys/wtp/enable") =="1")	{echo "-->";} ?>					
<? if(query("/runtime/web/display/ping_control") !="1" || query("/sys/wtp/enable") =="1")	{echo "<!--";} ?>					
				<tr>
					<td colspan="2">
						<table class="table_tool" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
							<tr>
								<td class="table_tool_td" valign="middle" colspan="2"><b><?=$m_ping_title?></b>&nbsp;
									<?=$G_TAG_SCRIPT_START?>genCheckBox("ping_setting","on_check_div_display(['ping_setting'],['div_ping'])");<?=$G_TAG_SCRIPT_END?>
								</td>
							</tr>
							<tr>
								<td colspan="2">	
									<div id="div_ping" style="display:none;">
										<table width="100%" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
											<tr>
												<td width="35%" id="td_left"><?=$m_status?></td>
												<td id="td_right">
													<?=$G_TAG_SCRIPT_START?>genCheckBox("ping_status","");<?=$G_TAG_SCRIPT_END?>	
													<?=$m_enable?>
												</td>
											</tr>	
										</table>
									</div>
								</td>
							</tr>																												
						</table>
					</td>
				</tr>
<? if(query("/runtime/web/display/ping_control") !="1" || query("/sys/wtp/enable") =="1")	{echo "-->";} ?>	

<? if(query("/runtime/web/display/led_control") !="1")	{echo "<!--";} ?>
				<tr>
					<td colspan="2">
						<table class="table_tool" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
							<tr>
								<td class="table_tool_td" valign="middle" colspan="2"><b><?=$m_led_title?></b>&nbsp;
								<?=$G_TAG_SCRIPT_START?>genCheckBox("led_setting","on_check_div_display(['led_setting'],['div_led'])");<?=$G_TAG_SCRIPT_END?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div id="div_led" style="display:none;">
									<table width="100%" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
										<tr>
											<td width="35%" id="td_left"><?=$m_led_st?></td>
											<td>
												<input type="radio" id="led_st" name="led_st" value="1"><?=$m_on?>
												<input type="radio" id="led_st" name="led_st" value="0"><?=$m_off?>
											</td>
										</tr>
									</table>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
<? if(query("/runtime/web/display/led_control") !="1")	{echo "-->";} ?>
				</tbody>
<? if(query("/runtime/web/display/sw_ctrl") !="1")	{echo "<!--";} ?>
				<tr>
					<td colspan="2">
						<table class="table_tool" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
							<tr>
								<td class="table_tool_td" valign="middle" colspan="2"><b><?=$m_swctrl_title?></b>&nbsp;
									<?=$G_TAG_SCRIPT_START?>genCheckBox("swctrl_setting","on_check_div_display(['swctrl_setting'],['div_swctrl'])");<?=$G_TAG_SCRIPT_END?>
								</td>
							</tr>
							<tr>
								<td colspan="2">	
									<div id="div_swctrl" style="display:none;">
										<table width="100%" border="0" <?=$G_TABLE_ATTR_CELL_ZERO?>>
											<tr>
												<td width="35%" id="td_left"><?=$m_enable_sw?></td>
												<td><?=$G_TAG_SCRIPT_START?>genSelect("sw_enable", [0,1], ["<?=$m_disable?>","<?=$m_enable?>"], "on_enable_sw()");<?=$G_TAG_SCRIPT_END?></td>
											</tr>
										</table>
									</div>
								</td>
							</tr>																												
						</table>
					</td>
				</tr>		
<? if(query("/runtime/web/display/sw_ctrl") !="1")	{echo "-->";} ?>
				<tr>
					<td colspan="2">
<?=$G_APPLY_BUTTON?>
					</td>
				</tr>
			</table>
<!-- ________________________________  Main Content End _______________________________ -->
		</td>
	</tr>
</table>
</form>
</body>
</html>
				
