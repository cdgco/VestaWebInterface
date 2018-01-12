<?php

//////////////////////////////////////////////////////////////
//===========================================================
// hf_theme.php
//===========================================================
// SOFTACULOUS 
// Version : 1.1
// Inspired by the DESIRE to be the BEST OF ALL
// ----------------------------------------------------------
// Started by: Alons
// Date:       10th Jan 2009
// Time:       21:00 hrs
// Site:       http://www.softaculous.com/ (SOFTACULOUS)
// ----------------------------------------------------------
// Please Read the Terms of use at http://www.softaculous.com
// ----------------------------------------------------------
//===========================================================
// (c)Softaculous Inc.
//===========================================================
//////////////////////////////////////////////////////////////

if(!defined('SOFTACULOUS')){

	die('Hacking Attempt');

}

function js_url(){
	
	$js['givejs'] = func_get_args();
	return $GLOBALS['globals']['ind'].http_build_query($js).'&'.$GLOBALS['globals']['version'];
		
}

function softheader($title = '', $leftbody = true){

global $theme, $user, $logged_in, $globals, $l, $dmenus, $onload, $newslinks, $feeds, $softpanel, $iscripts, $catwise, $allcatwise, $soft, $classes_categories, $scripts, $apps, $apps_catwise, $user_sitepad, $ins_apps, $file_data, $act;
	
	if(webuzo())
	{
		$ins_apps = $softpanel->loadinsapps();
		$def_mysql = $softpanel->getConf('WU_DEFAULT_MYSQL');
		$mysql = (!empty($def_mysql) ? $softpanel->get_app_record($def_mysql) : 16);
		
		$def_web_server = $softpanel->getConf('WU_DEFAULT_SERVER');
		$web_server = (!empty($def_web_server) ? $softpanel->get_app_record($def_web_server) : 3);
		$disable_sysapps = $softpanel->is_sysapps_disable();
	}
	
	
	if(optGET('jsnohf')){
		return true;
	}
	//r_print($user['color_theme']);
	/* <script language="javascript" src="'.js_url('js/jquery.js', 'js/universal.js', 'js/suggest.js', 'js/smoothscroll.js', 'js/slider.js', 'js/dock.js').'" type="text/javascript"> </script> */
	$title = ((empty($title)) ? $globals['sn'] : $title);
	
	// Is there a Panel Header ?
	if(!empty($softpanel->pheader)){
		echo $softpanel->pheader;
	}
	
	$custom_favicon  = (!empty($globals['favicon_logo']) ? $globals['favicon_logo'] : $theme['images'].'/'.(asperapp('', 'webuzo/', 'ampps/')).'favicon.ico');
	
	//Lets echo the top headers
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset='.$globals['charset'].'" />
		<meta name="keywords" content="softaculous, software" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<title>'.$title.'</title>
		<link rel="stylesheet" type="text/css" href="'.$theme['url'].'/bootstrap/css/bootstrap.css?'.$GLOBALS['globals']['version'].'" />
		<link rel="stylesheet" type="text/css" href="'.$theme['url'].'/style.css?'.$GLOBALS['globals']['version'].'" />'.
		(file_exists($theme['path'].'/custom.css') ? '<link rel="stylesheet" type="text/css" href="'.$theme['url'].'/custom.css?'.$GLOBALS['globals']['version'].'" />' : '')
		.'<link rel="stylesheet" type="text/css" href="'.$theme['url'].'/font-awesome.css?'.$GLOBALS['globals']['version'].'" />
		<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="'.$theme['url'].'/ie7.css?'.$GLOBALS['globals']['version'].'">
		<![endif]-->
		<link rel="shortcut icon" href='.$custom_favicon.' />';
		$got_cache_js = get_cache_time();
		
		echo '<!--[if lt IE 9]>
		  <script src="'.$theme['url'].'/bootstrap/js/html5.min.js"></script>
		  <script src="'.$theme['url'].'/bootstrap/js/respond.min.js"></script>
		<![endif]-->
		<script language="javascript" src="'.$theme['url'].'/js/combined.js?'.$GLOBALS['globals']['version'].'" type="text/javascript"> </script>
		<script language="javascript" src="'.$theme['url'].'/bootstrap/js/bootstrap.min.js" type="text/javascript"> </script>
		<script language="javascript" src="'.$theme['url'].'/cache/cache.js?'.$got_cache_js.'" type="text/javascript"> </script>
		<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
		</script>';		
	echo '
	</head>
	
	<body onload="bodyonload();">';
	$ind = $globals['mode'];
		
	//This is done for the SLIDER
	$js_cat = array();
		
	foreach($allcatwise[$ind] as $cat => $softs){
		if(empty($softs)) continue;
		$js_cat[] = $cat;
	}
	
	$temp_allcatwise = $allcatwise;
							
	// Classes are only avaialable to Premium License
	if(empty($globals['disable_classes']) && !empty($globals['lictype'])){
		$temp_allcatwise['classes'] = 'Classes';
	}
	
	// Webuzo has the APPs support
	if(webuzo()){
		
		$disablesysapps = $softpanel->is_sysapps_disable();
			
		if(empty($disablesysapps)){
			$temp_allcatwise['apps'] = 'Apps';
			$allcatwise['apps'] = $apps_catwise;
		}else if($globals['mode'] == 'apps'){
			redirect('');
			return false;
		}
	}
	
	
	// Script for alert box
	if($globals['softpanel'] == 'webuzo'){
	
		//////////////-10-Sep-2015-////////////
		// 1. To use the alert box create an instance of MboxObject.
		// 2. This Constructor accepts two parameters
		//     fYes: Function to be called when user clicks on Yes Button
		//     fNo: Function to be called when user clicks on No Button
		///////////////////////////////////////
		echo '<script language="javascript" type="text/javascript">
		
		// To change show password images from combined.js
		theme = "'.$theme['images'].'";

		function MboxObject(fYes,fNo,reloadpage){
			this.reload = reloadpage,
			this.show_message = function(title, body , image) {	
				var okbutton = \'<input class="alert-butt" type="button" onclick="message_box.close_message();" value="OK" />\';
				if(image == "1"){
					var img = \'<img src="'.$theme['images'].'error.gif" />\';
				}else{
					var img = \'<img src="'.$theme['images'].'confirm.gif" />\';			
				}	
					
				if(jQuery(\'.sai_message_box\').html() === null || jQuery(\'.sai_message_box\').html() === undefined) {
					var message = \'<div class="sai_message_box"><table border="0" cellpadding="8" width="100%" height="100%"><tr ><td rowspan="2" width="40%" > \'+ img + \'</td><td width="60%" class ="msg_tr1">\' +  title + \'</td></tr><tr class ="msg_tr2"><td style="text-align:left">\' + body + \'</td></tr><tr ><td colspan="2">\' + okbutton + \'</td></tr></table></div>\';
					jQuery(document.body).append( message );								
					jQuery(\'.sai_message_box\').css(\'top\', \'40%\');
					jQuery(\'.sai_message_box\').show(\'slow\');
				}else{
					var message =\' <table border="0" width="100%" cellpadding="8" height="100%"><tr ><td rowspan="2" width="40%">\'+ img +  \'</td><td widt="60%" class ="msg_tr1">\' + title + \'</td></tr><tr class ="msg_tr2"><td style="text-align:left">\' + body + \'</td></tr><tr ><td colspan="2">\' + okbutton + \'</td></tr></table>\';
					jQuery(\'.sai_message_box\').css(\'top\', \'40%\');
					jQuery(\'.sai_message_box\').show(\'slow\');
					jQuery(\'.sai_message_box\').html( message );
				}
			},
			this.delete_message = function(title, body ,did) {
				var yesbutton = \'<input type="button" onclick="message_box.yes_close_message(\\\'\'+did+\'\\\');" value="YES" class="alert-butt"/>\';
				var nobutton = \'<input type="button" onclick="message_box.no_close_message();" value="NO" class="alert-butt"/>\';
				var img = \'<img src="'.$theme['images'].'remove_big.gif" />\';
										
				if(jQuery(\'.sai_message_box\').html() === null || jQuery(\'.sai_message_box\').html() === undefined) {
					var message = \'<div class="sai_message_box"><table border="0" cellpadding="8" width="100%" height="100%"><tr height="60%" ><td rowspan="2" width="40%" > \'+ img + \'</td><td width="60%" class ="msg_tr1" height="10%">\' +  title + \'</td></tr><tr ><td style="text-align:left" height="60%" cellpading="2" class ="msg_tr2">\' + body + \'</td></tr><tr ><td colspan="2">\' + yesbutton + \'&nbsp; &nbsp; \' + nobutton + \'</td></tr></table></div>\';				
					jQuery(document.body).append( message );								
					jQuery(\'.sai_message_box\').css(\'top\', \'40%\');
					jQuery(\'.sai_message_box\').show(\'slow\');
				}else{
					var message = \' <table  border="0" cellpadding="8" width="100%" height="100%"><tr height="60%" ><td rowspan="2" width="40%">\'+ img +  \'</td><td widt="60%" class ="msg_tr1" height="10%">\' + title + \'</td></tr><tr><td style="text-align:left" height="60%" cellpading="2" class ="msg_tr2">\' + body + \'</td></tr><tr ><td colspan="2">\' + yesbutton + \'&nbsp; &nbsp; \' + nobutton + \'</td></tr></table>\'
					jQuery(\'.sai_message_box\').css(\'top\', \'40%\');
					jQuery(\'.sai_message_box\').show(\'slow\');
					jQuery(\'.sai_message_box\').html( message );
				}
			},
			this.close_message = function() {
				jQuery(\'.sai_message_box\').hide(\'fast\');
				if(this.reload==1){ window.location=window.location;}
			},
			this.yes_close_message = function(did) {
				var escaped_did = did.replace(/[-\/()_*+?&.\#\s]/g, "\\\$&");
				$(\'#did\'+escaped_did).attr("src","'.$theme['images'].'progress.gif");						
				fYes.apply(this, arguments);
				jQuery(\'.sai_message_box\').hide(\'fast\');
			},
			this.no_close_message = function() {
				jQuery(\'.sai_message_box\').hide(\'fast\');
			}
		}
	</script>';
	
	}
	

	// Show the EULA Notice in Interworx panel
	if(empty($user['eula_accept']) && $globals['softpanel'] == 'interworx'){
		echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
	
		var message_box = function(){			
				return {
					show_message: function(title, body , image) {			
						var okbtn = \'<input  style="width:75px; margin-top:10px; background:#00A0D2; color:#FFF;" class="sai_submit" type="button" onclick="message_box.close_message(this.value);" value="Agree" name="okbtn" />\';	
						var cancelbtn = \'<input  style="width:75px; margin-top:10px; background:#00A0D2; color:#FFF;" class="sai_submit" type="button" onclick="message_box.close_message(this.value);" value="Decline" name="cancelbtn" />\';
											
						if(jQuery(\'.sai_message_box\').html() === null) {
							var message = \'<div class="sai_message_box"><table border="0" cellpadding="8" width="100%" height="100%"><tr><td width="100%" class ="msg_tr1" style="text-align:center">\' +  title + \'</td></tr><tr class ="msg_tr2"><td style="text-align:left">\' + body + \'</td></tr><tr ><td class ="msg_tr3">\' + okbtn + \' &nbsp; &nbsp; \' + cancelbtn + \'</td></tr></table></div>\';
							jQuery(document.body).append( message );								
							jQuery(\'.sai_message_box\').css(\'top\', jQuery(\'html, body\').scrollTop() + 150);
							jQuery(\'.sai_message_box\').show(\'slow\');
						}else{
							var message =\' <table border="0" width="100%" cellpadding="8" height="100%"><tr ><td widt="60%" class ="msg_tr1">\' + title + \'</td></tr><tr class ="msg_tr2"><td style="text-align:left">\' + body + \'</td></tr><tr ><td>\' + okbtn + \'</td><td>\' + cancelbtn + \'</td></tr></table>\';				
							jQuery(\'.sai_message_box\').css(\'top\', jQuery(\'html, body\').scrollTop() + 150);
							jQuery(\'.sai_message_box\').show(\'slow\');
							jQuery(\'.sai_message_box\').html( message );
						}
					},
					close_message: function(action) {
						
						jQuery(\'.sai_message_box\').hide(\'fast\');
						
						if(action == "Agree"){
				
							$.ajax({
								type: "GET",
								url: window.location+"?&eula_accept=1",
								
								// Checking for error
								success: function(data){
								},
								error: function() {
								}													
							});
							
							return false;
							
						}else{
							alert("You must not use Softaculous if you do not agree to the EULA");
						}
					}
				}
			}();
	
		$(document).ready(function(){
			// Show the eula accept message
			var agree_msg = \'<center>You must agree to the <a href="http://www.softaculous.com/softaculous/eula" target="_blank">EULA</a> before using Softaculous</center>\';
			
			message_box.show_message("<a href=\"http://www.softaculous.com/softaculous/eula\" target=\"_blank\" style=\"text-decoration:none\">End User License Agreement</a>",agree_msg,1);
			
		});
		// ]]></script>';
	}
	
	
	//Search Function
	if(webuzo()){
		
		$file_data = file_get_contents($globals['enduser'].'/webuzo_search.json');
		$file_data = json_decode($file_data, true);
		foreach($file_data as $key => $value){
			if($key == 'searchArray'){
				$searchArray = json_encode($file_data['searchArray']);
			}	
		}
	
	echo '
		<script type="text/javascript">
		var appids = ["'.implode('", "', array_keys($ins_apps)).'"];
		var tools = ["phpmyadmin","rockmongo","squirrel", "tomcat", "monsta"];
		
		function in_arrays(val, arr){
			for (var i in arr) {
				var tmp_val = arr[i].split("_");
				if(tmp_val[0] == val){
					return true;
				}
			}
			return false;
		}
		
		//checks whether the app is installed or not
		function is_app_inst(app_id, act){
			if(in_arrays(app_id, appids)){
				if(in_arrays(act, tools)){
					if(act == "tomcat"){
						window.open("http://'.$softpanel->getConf('WU_PRIMARY_DOMAIN').':8080/manager/", "_blank");
					}else{
						window.open(act+"/", "_blank");
					}
				}else{
					window.location = "index.php?act="+act;
				}
			}else{
				var r = confirm("'.$l['webuzo_install_utility'].'")
				if(r==true){
					'.(empty($disable_sysapps) ? 'window.location = "index.php?act=apps&app="+app_id;' : 'alert("'.$l['webuzo_sysapps_disabled'].'")').'
				}else{
					return true;
				}
			}			
		}
		
		//For navigating through dropdown list
		$(document).ready(function(){
			$(document).on("keyup", function(e){
				var current = $(".search_list").find("li.active");
				
				if (e.keyCode == 40) {
					if(current.next().length == 0){
						$("#search_input").focus();
					}		
					if(current.length == 0){
						$(".search_list > li").first().attr(\'class\', \'active\').children(\'a\').focus();
					}else{
						current.attr(\'class\', \'\').children(\'a\').blur();	
						current.next().attr(\'class\', \'active\').children(\'a\').focus();
					}		 
				}				
				if (e.keyCode == 38) {
					if(current.prev().length == 0){
						$("#search_input").focus();
					}
					if(current.length == 0){
						$(".search_list > li").last().attr(\'class\', \'active\').children(\'a\').focus();			
					}else{
						current.attr(\'class\', \'\').children(\'a\').blur();	
						current.prev().attr(\'class\', \'active\').children(\'a\').focus();
					}
				}
			});
		});
                
		//Returns a Single li element to used in the dropdown
		function search_result_fill(value){		
			var display_value = value.displayName;
			var act_value = value.actName;
			var app = value.app;
			var href_value = "";
			var onclick_value = "";
			var dropdown_list = "";
			
			if(app == ""){
				href_value = "href=\''.$globals['ind'].'act="+act_value+"\'";
			}else if(app == "mysql"){
				href_value = "href=\'javascript:void(0)\'";
				onclick_value = "onclick=\'is_app_inst('.$mysql.', \""+act_value+"\"); return;\'";
			}else if(app == "web_server"){
				href_value = "href=\'javascript:void(0)\'";
				onclick_value = "onclick=\'is_app_inst('.$web_server.', \""+act_value+"\"); return;\'";
			}else if(app == "filemanager"){
				var link = window.location.href;
				link = link.substring(0,link.indexOf("/index.php"));
				href_value = "href=\'" +link+ "/filemanager/\'";
			}else if(app == 3 && ("'.$def_web_server.'" == "httpd" || "'.$def_web_server.'" == "httpd2")){
				href_value = "href=\'javascript:void(0)\'";
				onclick_value = "onclick=\'is_app_inst(\"3\", \""+act_value+"\"); return;\'";
			}else if(app == 18 && "'.$def_web_server.'" == "nginx"){	
				href_value = "href=\'javascript:void(0)\'";
				onclick_value = "onclick=\'is_app_inst(\"18\", \""+act_value+"\"); return;\'";
			}else if(app == 60 && "'.$def_web_server.'" == "lighttpd"){	
				href_value = "href=\'javascript:void(0)\'";
				onclick_value = "onclick=\'is_app_inst(\"60\", \""+act_value+"\"); return;\'";
			}else{
				if($.inArray(app, [3,18,60]) == -1){
					href_value = "href=\'javascript:void(0)\'";
					onclick_value = "onclick=\'is_app_inst("+app+", \""+act_value+"\"); return;\'";
				}	
			}
			
			if(href_value != ""){
				dropdown_list = "<li class=\'\' role=\'presentation\'><a role=\'menuitem\' tabindex=\'-1\' "+href_value+" " +onclick_value+ ">" +display_value+ "</a></li>";
			}	
			return dropdown_list;
		}			
			
		//Fills the dropdown list according to input search value
		function search_function(evt){	
			input_val = evt.value.toLowerCase();
			input_val = input_val.trim();
			if(input_val == ""){
				$("#search_dropdown").attr("class", "dropdown");
				$(".search_list > li").remove();
				$(".search_list").css("display", "none");
				return false;
			}
						
			var dropdown_list = "";
			var searchArray = '.$searchArray.';
			$(".search_list > li").remove();
			var count = 0;
			var flag = false;
			
			$.each(searchArray, function(key, value){
				var display_name = value.displayName.toLowerCase();
				if(value.tagName == input_val){
					flag = true;
					dropdown_list += search_result_fill(value);
				}
				if(display_name.includes(input_val) == true && flag == false && count < 15){
					dropdown_list += search_result_fill(value);
					count++;
				}				
			});
			
			if(("squirrel".includes(input_val) == true || "webmail".includes(input_val) == true) && count < 15){
				href_value = "href=\'javascript:void(0)\'";
				onclick_value = "onclick=\'is_app_inst(36, \"squirrel\"); return;\'";					
				dropdown_list += "<li class=\'\' role=\'presentation\'><a role=\'menuitem\' tabindex=\'-1\' "+href_value+" " +onclick_value+ ">Access Email</a></li>";
			}
						
			if(dropdown_list !== ""){
				$(".dropdown-toggle").dropdown("toggle");
				$(".search_list").append(dropdown_list);
				$(".search_list").css("display", "");
				$("#search_input").focus();
			}else{
				$("#search_dropdown").attr("class", "dropdown");
			}					
		}
		</script>
		';
		
	}
	
	
	//For native UI support
	if(!empty($softpanel->pheader)){
		if(is_cp_theme('paper_lantern')){
			echo '
			<style>
			@media screen and (min-width: 320px) and (max-width: 360px){
				.soft_nav{
					margin-top:20px;
				}
			}
			</style>
			';
		}
	}
	
	$navbar_top = array();
	
	//Navigation Control Panel Link
	if(empty($globals['off_panel_link'])){
		$navbar_top['goto_control_panel']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_cpanel'].'"><a href="/vwi/panel.php">'.((!empty($softpanel->goto_cp_logo) && empty($user['user_defined_color'])) ? '<img src="'.$theme['images'].$softpanel->goto_cp_logo.'" height="25" width="25" >' : '<i class="fa sai-control_panel fa-2x"></i>').'</a></td>';
		
		$navbar_top['goto_control_panel']['responsive'] = '<li><a href="/vwi/panel.php">'.((!empty($softpanel->goto_cp_logo) && empty($user['user_defined_color'])) ? '<img src="'.$theme['images'].$softpanel->goto_cp_logo.'" height="25" width="25" >' : '<i class="fa sai-control_panel fa-2x"></i>').'&nbsp;&nbsp;'.$l['go_cpanel'].'</a></li><br />';
	}

	//Top Search Bar
	if(webuzo()){
		if(!empty($act)){
			$navbar_top['search_bar']['fullscreen'] = '<td align="center" width="40" class="someclass" title=""><div id="search_dropdown" class="dropdown"><input id="search_input" onKeyUp="search_function(this);" size="30" type="text" name="search_input" class="sai_inputs dropdown-toggle" autofocus placeholder="Search" autocomplete="off"/>
			<ul class="search_list dropdown-menu" role="menu" tabindex="0" aria-labelledby="search_input" style="width: 255px;"></ul></div></td>
			<td>&nbsp;</td>';
		}
		$navbar_top['logged_user']['fullscreen'] = '<td align="left" width="32" class="someclass" title=""><span class="label label-primary" style="font-size:12px;">'.(($softpanel->getCurrentUser() == 'root') ? $l['root_login'] : '').'</span>&nbsp;&nbsp;&nbsp;</td>';
	}
	
	
	//Navigation Webuzo Home
	if(webuzo()){
		$navbar_top['goto_webuzo_home']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_home'].'"><a href="'.$globals['ind'].'"><i class="fa sai-home fa-2x"></i></a></td>';
		
		$navbar_top['goto_webuzo_home']['responsive'] = '<li><a href="'.$globals['ind'].'"><i class="fa sai-home fa-2x"></i>&nbsp;&nbsp;'.$l['go_home'].'</a></li><br />';
	}
	
	//Navigation Webuzo Cpanel
	if(webuzo()  && (!$softpanel->is_sysapps_disable())){
		$navbar_top['goto_webuzo_cpanel']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_cpanel'].'"><a href="javascript:goto_panel();"><i class="fa sai-control_panel fa-1x" style="font-size: 1.8em;"></i></a>';
		
		$navbar_top['goto_webuzo_cpanel']['responsive'] ='<li><a href="javascript:goto_panel();"><i class="fa sai-control_panel fa-2x"></i>&nbsp;&nbsp;'.$l['go_cpanel'].'</a></li><br />';
	}
	
	//We are hiding the icons for webuzo as we are showing those in hidden dropdown.
	if(!webuzo()){
		//Navigation Add Domains
		if(aefer() && allow_adddomain()){
		$navbar_top['add_domain']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_domain'].'"><a href="'.$globals['ind'].'act=domains"><i class="fa sai-www fa-2x"></i></a></td>';
		
		$navbar_top['add_domain']['responsive'] = '<li><a href="'.$globals['ind'].'act=domains"><i class="fa sai-www fa-2x"></i>&nbsp;&nbsp;'.$l['go_domain'].'</a></li><br />';
		}
	
		//Navigation Webuzo Manage Domains
		if(webuzo()){
		$navbar_top['webuzo_manage_domains']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_domain'].'"><a href="'.$globals['ind'].'act=domainmanage"><b><i class="fa sai-www fa-2x"></i></b></a></td>';
		
		$navbar_top['webuzo_manage_domains']['responsive'] = '<li><a href="'.$globals['ind'].'act=domainmanage"><b><i class="fa sai-www fa-2x"></i>&nbsp;&nbsp;'.$l['go_domain'].'</b></a></li><br />';
		}
	
		//Navigation Demo Link
		if(empty($globals['off_demo_link'])){
		$navbar_top['goto_demo']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_demos'].'"><a href="'.$globals['ind'].'act=demos"><i class="fa sai-demo fa-1x"></i></a></td>';
		
		$navbar_top['goto_demo']['responsive'] = '<li><a href="'.$globals['ind'].'act=demos"><i class="fa sai-demo fa-1x"></i>&nbsp;&nbsp;'.$l['go_demos'].'</a></li><br />';
		}
	
		//Navigation Ratings
		if(empty($globals['off_rating_link'])){
		$navbar_top['goto_rating']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_ratings'].'"><a href="'.$globals['ind'].'act=ratings"><i class="fa sai-fullstar fa-1x"></i></a></td>';
		
		$navbar_top['goto_rating']['responsive'] = '<li><a href="'.$globals['ind'].'act=ratings"><i class="fa sai-fullstar fa-1x"></i>&nbsp;&nbsp;'.$l['go_ratings'].'</a></li><br />';
		}
	}
	
	
	//Navigation Installations
	$navbar_top['goto_installations']['fullscreen'] = '<td  align="center" width="32" class="someclass" title="'.$l['go_installations'].'"><a href="'.$globals['ind'].'act=installations"><i class="fa sai-installations fa-1x"></i></a></td>';
		
	$navbar_top['goto_installations']['responsive'] = '<li><a href="'.$globals['ind'].'act=installations"><i class="fa sai-installations fa-1x"></i>&nbsp;&nbsp;'.$l['go_installations'].'</a></li><br />';
	
	//Navigation Webuzo App Installations
	if(webuzo() && (!$softpanel->is_sysapps_disable())){
		$navbar_top['webuzo_app_installations']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_apps_installations'].'"><a href="'.$globals['ind'].'act=apps_installations"><i class="fa sai-apps fa-2x"></i></a></td>';
		
		$navbar_top['webuzo_app_installations']['responsive'] = '<li><a href="'.$globals['ind'].'act=apps_installations"><i class="fa sai-apps fa-2x"></i>&nbsp;&nbsp;'.$l['go_apps_installations'].'</a></li><br />';
	}
	
	//We are hiding the icons for webuzo as we are showing those in hidden dropdown.
	if(!webuzo()){
		//Tasklist Navigation
		$navbar_top['goto_tasklist']['fullscreen'] = '<td  align="center" width="32" class="someclass" title="'.$l['go_tasklist'].'"><a href="'.$globals['ind'].'act=eu_tasklist"><i class="fa sai-list fa-1x"></i></a></td>';
			
		$navbar_top['goto_tasklist']['responsive'] = '<li><a href="'.$globals['ind'].'act=eu_tasklist"><i class="fa sai-list fa-1x"></i>&nbsp;&nbsp;'.$l['go_tasklist'].'</a></li><br />';
			
		//Settings Navigation
		$navbar_top['goto_settings']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_settings'].'"><a href="'.$globals['ind'].'act=settings"><i class="fa sai-settings fa-1x"></i></a></td>';
		
		$navbar_top['goto_settings']['responsive'] = '<li><a href="'.$globals['ind'].'act=settings"><i class="fa sai-settings fa-1x"></i>&nbsp;&nbsp;'.$l['go_settings'].'</a></li><br />';
	
		//Navigation Backup Restore Link
		if(empty($globals['disable_backup_restore'])){
			$navbar_top['goto_backups']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_backups'].'"><a href="'.$globals['ind'].'act=backups"><i class="fa sai-backup fa-1x"></i></a></td>';
			
			$navbar_top['goto_backups']['responsive'] = '<li><a href="'.$globals['ind'].'act=backups"><i class="fa sai-backup fa-1x"></i>&nbsp;&nbsp;'.$l['go_backups'].'</a></li><br />';
		}
	
		//Navigation Email Link
		if(empty($globals['off_email_link'])){
			$navbar_top['goto_email_settings']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_email_settings'].'"><a href="'.$globals['ind'].'act=email"><i class="fa sai-mail fa-1x"></i></a></td>';
			
			$navbar_top['goto_email_settings']['responsive'] = '<li><a href="'.$globals['ind'].'act=email"><i class="fa sai-mail fa-1x"></i>&nbsp;&nbsp;'.$l['go_email_settings'].'</a></li><br />';
		}
		
		//Navigation Premium Themes
		if(!empty($globals['eu_themes_premium']) && !empty($globals['lictype'])){
			$navbar_top['goto_premium_themes']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_my_themes'].'"><a href="'.$globals['ind'].'act=my_themes"><i class="fa sai-pfx_icon fa-2x"></i></a></td>';
			
			$navbar_top['goto_premium_themes']['responsive'] = '<li><a href="'.$globals['ind'].'act=my_themes"><i class="fa sai-pfx_icon fa-2x"></i>&nbsp;&nbsp;'.$l['go_my_themes'].'</a></li><br />';
		}
	
		//Navigation Sync
		if(empty($globals['off_sync_link'])){
			$navbar_top['goto_sync']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_sync'].'"><a href="'.$globals['ind'].'act=sync"><i class="fa sai-sync fa-1x"></i></a></td>';
			
			$navbar_top['goto_sync']['responsive'] = '<li><a href="'.$globals['ind'].'act=sync"><i class="fa sai-sync fa-1x"></i>&nbsp;&nbsp;'.$l['go_sync'].'</a></li><br />';
		}
			
		//Navigation Help
		$navbar_top['goto_help']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_support'].'"><a href="'.$globals['ind'].'act=help"><i class="fa sai-question fa-1x"></i></a></td>';
		
		$navbar_top['goto_help']['responsive'] = '<li><a href="'.$globals['ind'].'act=help"><i class="fa sai-question fa-1x"></i>&nbsp;&nbsp;'.$l['go_support'].'</a></li><br />';
		
		//Navigation Logout
		$navbar_top['goto_logout']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.$l['go_logout'].'"><a href="/vwi/logout.php"><i class="fa sai-logout fa-1x"></i></a></td>';
		
		$navbar_top['goto_logout']['responsive'] = '<li><a href="/vwi/logout.php"><i class="fa sai-logout fa-1x"></i>&nbsp;&nbsp;'.$l['go_logout'].'</a></li><br />';
	}
	
	if(webuzo()){
		//Navigation Settings Dropdown
		$navbar_top['goto_userPreferences']['fullscreen'] = '<td align="center" width="32" class="someclass" title="'.(empty($softpanel->user['displayname']) ? (strlen($softpanel->user['name']) > 12 ? $softpanel->user['name'] : "") : "").'">
		  <div class="dropdown" style="border-left:1px solid #fff;">
			  <button style="color:#fff; background-color:#333; border:none; outline:none;" class="btn btn-default dropdown-toggle" type="button" id="userPreferences" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<span class="fa sai-blogs fa-lg"></span>
				&nbsp; '.(empty($softpanel->user['displayname']) ? (strlen($softpanel->user['name']) > 12 ? substr($softpanel->user['name'], 0, 12).".." : $softpanel->user['name']) : $softpanel->user['displayname']).' &nbsp;
				<span style="width:9px;" class="caret"></span>
			  </button>
			  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="userPreferences">
				<li><a href="'.$globals['ind'].'act=eu_tasklist" style="font-size:14px;"><i class="fa sai-list fa-1x" style="font-size:16px;"></i>&nbsp;&nbsp;Task List</a></li>
				<li><a href="'.$globals['ind'].'act=settings" style="font-size:14px;"><i class="fa sai-settings fa-1x" style="font-size:16px;"></i>&nbsp;&nbsp;Edit Settings</a></li>
				<li><a href="'.$globals['ind'].'act=backups" style="font-size:14px;"><i class="fa sai-backup fa-1x" style="font-size:16px;"></i>&nbsp;&nbsp;Backups and Restore</a></li>
				<li><a href="'.$globals['ind'].'act=email" style="font-size:14px;"><i class="fa sai-mail fa-1x" style="font-size:16px;"></i>&nbsp;&nbsp;Email Settings</a></li>
				<li><a href="'.$globals['ind'].'act=help" style="font-size:14px;"><i class="fa sai-question fa-1x" style="font-size:16px;"></i>&nbsp;&nbsp;Help and Support</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="'.$softpanel->theme['logout'].'" style="font-size:14px;"><i class="fa sai-logout fa-1x" style="font-size:16px;"></i>&nbsp;&nbsp;Logout</a></li>
			  </ul>
		  </div></td>';
	
		$navbar_top['goto_userPreferences']['responsive'] = '<ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="background-color:#333;"><span class="fa sai-blogs fa-lg"></span><b>
			&nbsp; '.(empty($softpanel->user['displayname']) ? $softpanel->user['name'] : $softpanel->user['displayname']).'</b> &nbsp;
			<span class="caret"></span>
			</a>
			<ul class="dropdown-menu" role="menu" style="background:#fff;z-index:11111;"><br/>
				<li><a href="'.$globals['ind'].'act=eu_tasklist"><i class="fa sai-list fa-1x"></i>&nbsp;&nbsp;Task List</a></li><br/>
				<li><a href="'.$globals['ind'].'act=settings"><i class="fa sai-settings fa-1x"></i>&nbsp;&nbsp;Edit Settings</a></li><br/>
				<li><a href="'.$globals['ind'].'act=backups"><i class="fa sai-backup fa-1x"></i>&nbsp;&nbsp;Backups and Restore</a></li><br/>
				<li><a href="'.$globals['ind'].'act=email"><i class="fa sai-mail fa-1x"></i>&nbsp;&nbsp;Email Settings</a></li><br/>
				<li><a href="'.$globals['ind'].'act=help"><i class="fa sai-question fa-1x"></i>&nbsp;&nbsp;Help and Support</a></li>
				<li role="separator" class="divider"></li><br/>
				<li><a href="'.$softpanel->theme['logout'].'"><i class="fa sai-logout fa-1x"></i>&nbsp;&nbsp;Logout</a></li>
			</ul>	
		</li></ul>';
	}
	
	$navbar_top = apply_filters('navbar_links', $navbar_top);
	
	
echo '
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="soft_nav">								
					<tr>
						<td width="'.(!empty($softpanel->leftpanel_resize) ? '192' : '220').'" id="header_logo">
							<a href="'.$globals['ind'].'" style="margin:20px;"><img src="'.($globals['softpanel'] == 'ampps' ? $theme['a_images'].'header.png' : (empty($globals['logo_url']) ? ($globals['softpanel'] == 'webuzo' ? $theme['a_images'].'header.png' : $theme['images'].'header.png') : $globals['logo_url'])).'" alt="" height="'.(!empty($softpanel->leftpanel_resize) ? '60' : '55').'" class="header_logo"/></a>
						</td>';
						$top_bar = (!empty($globals['panel_hf']) && !empty($softpanel->can_shrink_nativeui) ? '<td width="40" align="center">&nbsp;&nbsp;<a href="javascript:set_pheader();" id="pheader_view" ><img src="'.$theme['images'].(empty($_COOKIE['pheader']) || $_COOKIE['pheader'] == 'yes' ? 'expand.png" title="'.$l['expand_view'].'"' : 'collapse.png" title="'.$l['collapse_view'].'"').'></a></td>'  : '');
						$pre_selected_ind = array('php', 'perl', 'java', 'python');
						if(empty($globals['nolabels'])){
							$top_bar .= '<td align="center" width="40" '.(!empty($softpanel->pheader) ? 'height="40"' : '').'>&nbsp;&nbsp;<a href="'.$globals['ind'].'ind='.$globals['mode'].'" id="'.$globals['mode'].'" class="indtype soft_nav_selected">'.($globals['mode'] == 'js' ? 'JavaScripts' : ($globals['mode'] == 'classes'  ? 'Classes' : (asperapp(0,1,0) ? ($globals['mode'] == 'java'  ? 'JAVA' : ($globals['mode'] == 'python'  ? 'Python' :strtoupper($globals['mode']))) : strtoupper($globals['mode'])))).'</a></td>';
							foreach($temp_allcatwise as $k => $v){
								
								$top_bar .= (empty($temp_allcatwise[$k]) || $globals['mode'] == $k ? '' : '<td  align="center" width="40">&nbsp;&nbsp;<a href="'.$globals['ind'].'ind='.$k.'" class="'.($globals['mode'] == $k || (empty($_GET['act']) && empty($_GET['ind']) && in_array($k, $pre_selected_ind)) ? 'indtype soft_nav_selected' : 'indtype').'" id="'.$k.'">'.($k == 'js' ? 'JavaScripts' : ($k == 'classes' ? 'Classes' : ($k == 'java' || $k == 'apps' || $k == 'python' ? ucfirst($k) : strtoupper($k)))).'</a></td>');
							}
						}
						// AMPPS APP HEADING
		
						if($globals['softpanel'] == 'ampps'){
							$top_bar .= '<td>&nbsp;&nbsp;<a href="'.$globals['ind'].'act=ampps_apps" style="text-decoration:none;" style="margin-top:20px;" >Apps</a></td>';
						}					
						
						$top_bar .= '<td>&nbsp;</td>';
						
							echo $top_bar;
							foreach($navbar_top as $n => $v){
								echo $navbar_top[$n]['fullscreen'];
							}
							
							echo '</tr>
				</table>
			</td>
		</tr>
	</table>
	<img src="'.$theme['images'].'menu.png" alt="Left_menu" id="header_toggle_btn" class="header_toggle_btn pull-right">			
	<div class="soft_nav_mob"><br />
		<ul style="list-style-type:none; padding-left:10px;">';
			$top_bar = (!empty($globals['panel_hf']) && !empty($softpanel->can_shrink_nativeui) ? '<li style="display:inline-block;">&nbsp;&nbsp;<a href="javascript:set_pheader();" id="pheader_view" ><img src="'.$theme['images'].($_COOKIE['pheader'] == 'yes' ? 'expand.png" title="'.$l['expand_view'].'"' : 'collapse.png" title="'.$l['collapse_view'].'"').'></a></li>'  : '');
						$pre_selected_ind = array('php', 'perl', 'java', 'python');
						if(empty($globals['nolabels'])){
							$top_bar .= '<li style="display:inline-block;">&nbsp;&nbsp;<a href="'.$globals['ind'].'ind='.$globals['mode'].'" id="'.$globals['mode'].'" class="indtype soft_nav_selected">'.($globals['mode'] == 'js' ? 'JavaScripts' : ($globals['mode'] == 'classes'  ? 'Classes' : (asperapp(0,1,0) ? ($globals['mode'] == 'java'  ? 'JAVA' : ($globals['mode'] == 'python'  ? 'Python' :strtoupper($globals['mode']))) : strtoupper($globals['mode'])))).'</a></li>';
							foreach($temp_allcatwise as $k => $v){
								
								$top_bar .= (empty($temp_allcatwise[$k]) || $globals['mode'] == $k ? '' : '<li style="display:inline-block;">&nbsp;&nbsp;<a href="'.$globals['ind'].'ind='.$k.'" class="'.($globals['mode'] == $k || (empty($_GET['act']) && empty($_GET['ind']) && in_array($k, $pre_selected_ind)) ? 'indtype soft_nav_selected' : 'indtype').'" id="'.$k.'">'.($k == 'js' ? 'JavaScripts' : ($k == 'classes' ? 'Classes' : ($k == 'java' || $k == 'apps' || $k == 'python' ? ucfirst($k) : strtoupper($k)))).'</a></li>');
							}
						}
					
						echo $top_bar.'<br /><br />';
						foreach($navbar_top as $n => $v){
							echo $navbar_top[$n]['responsive'];
						}
						echo'
		</ul>
	</div><!--soft_nav_mob-->
	<script type="text/javascript">
		$(document).ready(function(){
			
			// Initialize the sai_exp
			new_theme_funcs_init();
			
			$("#left_toggle_btn").click(function(){
				if($(".left_panel").is(":visible")){
					$("#header_logo").show();
				}else{
					$("#header_logo").hide();
				}
			});';
			if(!empty($softpanel->pheader) && is_cp_theme('x3')){
				echo '$(".ver_style").css("margin-left","0px");
					$(".release_style").css("margin-left","0px");
					$(".change_style").css({"margin-left":"0px", "margin-top":"-15px"});
					$(".sai_search_left").css("width","159px");	
					$(".header_logo").css("height","55px");
					$(".header_logo").css("width","140px");
					$("#softcontent").css("padding","0px");
					$(".sai_search_img").css("margin-top","5px");';
			}
			
			if($globals['softpanel'] == 'directadmin' && $globals['panel_hf'] == 1){
				echo '$(".header_logo").css("height","53px");
					$(".header_logo").css("width","138px");
					$(".sai_search_img").css("margin-top","5px");';
			}
 echo'  });
	</script>
	<!--[if IE]>
		<style>
			.left_panel{
				 margin-top:-53px;
			}
		</style>
	<![endif]-->
	<div id="loading_soft" class="sai_loading_soft">
		<img src="'.$theme['images'].'fb_loader.gif" alt="Loading..." />
	</div>';
	echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top:-53px;"> 
		<tr>
			<img src="'.$theme['images'].'menu.png" alt="Left_menu" class="left_toggle_btn" id="left_toggle_btn">
			<td width="'.(!empty($softpanel->leftpanel_resize) ? '192' : '220').'" valign="top" class="left_panel" style="min-height:100%;">
				<!--left panel table start here-->
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center">
								<center>
									<a href="'.$globals['ind'].'"><img src="'.($globals['softpanel'] == 'ampps' ? $theme['a_images'].'header.png' : (empty($globals['logo_url']) ? ($globals['softpanel'] == 'webuzo' ? $theme['a_images'].'header.png' : $theme['images'].'header.png') : $globals['logo_url'])).'" alt="" height="'.(!empty($softpanel->leftpanel_resize) ? '60' : '70').'"/></a>
								</center>
							</td>
						</tr>';
						if($ind != 'classes'){
						echo '<tr>
							<td>
								<table cellspacing="0" cellpadding="0" border="0" align="center">
									<tr><br />
										<td align="right">
											<form accept-charset="'.$globals['charset'].'" name="search" method="post" action="'.$globals['ind'].'act=search&smode='.$globals['mode'].'" onsubmit="return checksearchform();" id="searchform">
												<input type="text" name="inputString" size="20" id="inputString" onfocus="this.value=\'\';" value="'.$l['search'].'" onblur="this.value=\''.$l['search'].'\';init();" onKeyUp="search_scripts(this.value);" autocomplete="off"  sugurl="'.$globals['index'].'&act=suggest&smode='.$globals['mode'].'" mode="'.$globals['mode'].'" class="sai_search_left" style="margin-bottom:8px;"/>
												<img src="'.$theme['images'].'search.png" class="sai_search_img" style="height:18px; width:18px;"/>
												<input type="hidden" name="hidden_cid" id="hidden_cid" />
												<div id="suggestions" class="sai_suggestions" style="position:absolute;left:0px; top:0px; display:none;"></div>
											</form>
										</td>
									</tr>
								</table>
								<!--<div class="search_suggestion" style="display:none"></div>-->
							</td>
						</tr>';
						}
						if(!empty($leftbody)){
							
							if($ind == 'classes' || optGET('act') == 'classes'){

								if(!empty($softpanel->pheader)){
									if(is_cp_theme('paper_lantern')){
										echo '
										<style>
											.row_usi_cls {
											padding-left: 50px;
											}
											
											@media screen and (min-width: 320px) and (max-width: 767px){
												.row_usi_cls {
												padding-left: 0;
												}
											}
											
											@media screen and (min-width: 768px) and (max-width: 799px){
												.row_usi_cls {
												padding-left: 180px;
												}
											}
											
											@media screen and (min-width: 800px) and (max-width: 980px){
												
											}
										</style>';
									}else{
										echo '
										<style>
											.row_usi_cls {
											padding-left: 100px;
											}
											
											@media screen and (min-width: 768px) and (max-width: 799px){
												.row_usi_cls {
												padding-left: 200px;
												}
											}
										</style>';
									}
								}

echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
								
		(function($) {
			$.extend($.fx.step,{
				backgroundPosition: function(fx) {
					if (fx.state === 0 && typeof fx.end == \'string\') {
						var start = $.curCSS(fx.elem,\'backgroundPosition\');
						if(typeof(start) == "undefined"){
							start = $.css(fx.elem, "background-position-x")+\' \'+$.css(fx.elem, "background-position-y");
						}
						start = toArray(start);
						fx.start = [start[0],start[2]];
						var end = toArray(fx.end);
						fx.end = [end[0],end[2]];
						fx.unit = [end[1],end[3]];
					}
					var nowPosX = [];
					nowPosX[0] = ((fx.end[0] - fx.start[0]) * fx.pos) + fx.start[0] + fx.unit[0];
					nowPosX[1] = ((fx.end[1] - fx.start[1]) * fx.pos) + fx.start[1] + fx.unit[1];
					fx.elem.style.backgroundPosition = nowPosX[0]+\' \'+nowPosX[1];
		
				   function toArray(strg){
					   strg = strg.replace(/left|top/g,\'0px\');
					   strg = strg.replace(/right|bottom/g,\'100%\');
					   strg = strg.replace(/([0-9\.]+)(\s|\)|$)/g,"$1px$2");
					   var res = strg.match(/(-?[0-9\.]+)(px|\%|em|pt)\s(-?[0-9\.]+)(px|\%|em|pt)/);
					   return [parseFloat(res[1],10),res[2],parseFloat(res[3],10),res[4]];
				   }
				}
			});
		})(jQuery);
		
			
		// this function will add blue arrow after clicking	
		$(function(){
			$("#cmenu li a").click(function(){
				 $(this).removeClass("softlinkscurrent");
				 $(this).addClass("softlinkscurrent");
			 })
		});
		
		
		//function to display list of classes
		function show_list(start, length, cat){
			$("#softcontent").fadeOut(0);
			$_("loading_soft").style.top = (scrolledy()+250)+"px";
			$("#loading_soft").show();
			$("#softcontent").html("");
			goto_top();	
			$.getJSON("'.$globals['api_nuphp'].'category_classes.php?cat="+cat+"&in=json&start="+start+"&length="+length+"&callback=?", 
			function (data) {
				if (typeof(data.data)!="object" || typeof data.data == "undefined"){
				  $("#loading_soft").hide();//hide fb loader
				  $("#softcontent").html("<center><span class=\'sai_newhead\'>'.$l['classes_con_failed'].'</span></center>");	
				  $("#softcontent").fadeIn(300);
				}
				var soft_classes = \'<div class="bg"><br /><div class="row row_usi_cls">\';
				var br = 1;';
				
				$list_class = ((!empty($softpanel->pheader) ? ((is_cp_theme('paper_lantern')) ? 'col-lg-6 col-md-6 col-sm-12 col-xs-12' : 'col-lg-12 col-md-12 col-sm-12 col-xs-12') : 'col-lg-4 col-md-4 col-sm-12 col-xs-12'));
				
				echo '$.each(data.data, function (i, item) {
					soft_classes += \'<div class="'.$list_class.'" style="padding-bottom: 20px;"><div class="sai_classes_boxgrid2" onclick=window.location=this.id; id="'.$globals['index'].'act=classes&cid=\'+item.cid+\'&tab=overview" ><div class="sai_classes_boxgrid"><div><h2>\'
					+item.name+
					\'</h2><p style="padding:10px;height:50px;">\'
					+item.desc+\'</p><p style="padding:10px;height:15px;"> <b>'.$l['cl_ratings'].'</b> : \'
					+parseFloat(item.ratings)+\'/5</p> </div><div style="height:200px;"><br /><h2>\'
					+item.name+
					\'</h2><p style="margin-left:10px;margin-top:20px"><b> '.$l['cl_author'].'</b> : \'
					+item.author+\'</p><p style="margin-left:10px;"><b> '.$l['cl_license'].'</b> :\'
					+item.license+\'</p><p style="margin-left:10px;"><b> '.$l['cl_version'].'</b> :\'
					+item.version+\'</p><div align="center"> <a href="'.$globals['index'].'act=classes&cid=\'+item.cid+\'&tab=install" style="margin:5px;" class="sai_cbutton"> '.$l['cl_install_but'].' </a><a href="'.$globals['index'].'act=classes&cid=\'+item.cid+\'&tab=file" style="margin:5px;"class="sai_cbutton"> '.$l['cl_show_files'].'</a></div></div></div></div></div>\';
					 
					 br += 1 ;
				});// end of each loop
		
				soft_classes += "</div></div>";
				
				$("#softcontent").append(soft_classes); 
				
				// Pagination Coding
				var p1 = 0; // Start variable for mysql api . length is set to 12
				
				// Find which is the current page
				var current = (start/length) + 1;
				var class_pagination = \'<center><div class="pagination"><ul>\';
				for (i=1; i<=data.pages; i++)
				{
					var page_class = "sai_cbutton";
					if(i == current){
						page_class += " selected_page";
					}			
					
					class_pagination += \'<li style="display:inline;font-size:18px;font-style:italic;margin-right:3px;cursor:pointer"><a class="\'+page_class+\'" style="background: #F5F5F5;color:#000;" onclick="show_list(\'+p1+\',12, \\\'\'+data.class_category+\'\\\');" href="javascript:void(0)" >\'+ i+\'</a></li>\';
					p1+=12;
				}
				
				class_pagination+= \'</ul></div></center>\';	
		
				$("#softcontent").append(class_pagination);
				$("#loading_soft").hide();//hide fb loader
				$("#softcontent").fadeIn(300);	
						
				window.location.hash = "!act=listclasses&cat="+data.class_category;	
				
				$(".sai_classes_boxgrid").hover(function(){$(this).stop().animate({top:"-200px"},{queue:false,duration:200});},function() 
				{$(this).stop().animate({top:"0px"},{queue:true,duration:200});});
				
			}); // end of get json function
		
		}//end of show list
								
// ]]></script>';
								
							}// end of $ind == 'classes'

							$theme['leftbody'] = $leftbody;
							
							echo '<tr>
								<td id="load_leftpanel_js">';
								// Only for classes menu
								if($ind=='classes'){
									
									echo '<ul class="softlinks" id="cmenu">';
									
									ksort($classes_categories);
									
									foreach ($classes_categories as $key => $value){
										
										echo '<li>
												<a onclick="show_list(0, 12, \''.$key.'\');  return false;" href="javascript:void(0)" >'.$l['classes_'.$key].'<div class="class_arrow"><img src="'.$theme['images'].'collapsed.png"></div></a>
											</li>';
									}
									
									echo '</ul>';
									
								}else{
									
									$icat = 0;
									
									$str = '<script>
									var cat_lang = new Array();
									var catimg_from_site = new Array();';
									
									foreach($allcatwise as $i_ind => $ind_type){
										
										foreach($ind_type as $cat => $softs){
											if(empty($softs)) continue;
											// If we have any cat images to be load from our website
											if(!empty($GLOBALS['catimgs'][$i_ind.'_'.$cat])){
												$str .= 'catimg_from_site[\''.$i_ind.'_'.$cat.'\'] = "'.$GLOBALS['catimgs'][$i_ind.'_'.$cat].'";';
											}
											
											$str .= 'cat_lang[\'cat_'.$i_ind.'_'.$cat.'\'] = "'.$l['cat_'.$i_ind.'_'.$cat].'";';
										}
										
									}
									
									$str .= '
									
									var iscripts = new Array("'.implode('", "', array_keys($iscripts)).'");
									var apps = new Array("'.implode('", "', array_keys($apps)).'");
									</script>';
									
									echo $str;
								}// End of ELSE (i.e for iscripts)
						
							echo '</td>
						</tr>';
						}
						
					echo '</table>
				</td>
				<td colspan="2"  valign="top">
				
<script language="javascript" type="text/javascript"><!-- // --><![CDATA[

function goto_panel(){
			
	var str = window.location; 	
	
	var port_find = str.toString().search(\'2003\'); 	

	if(port_find < 1){		
		var str_url = str.toString().replace("2002", "2004");
	}else{
		var str_url = str.toString().replace("2003", "2005");
	}
	
	var res = str_url.split("/",4);
	
	var res_out = res.join("/");	
	
	window.location = res_out+"/";	
}

function in_array(val, array){
											
	for (i=0; i <= array.length; i++){
		if (array[i] == val) {
			return true;
			// {alert(i +" -- "+ids[i]+" -- "+val);return i;}
		}
	}
	return false;
}

var ind_types_array = new Array("ind_php", "ind_perl", "ind_java", "ind_python");

var all_ind_types_array = new Array("ind_php", "ind_perl", "ind_java", "ind_apps", "ind_js", "ind_python");

$(document).ready(function(){
	var shown=false;
	
	$("#left_toggle_btn").on("click", function(e){
		shown=$(".left_panel").is(":visible");
		$(".left_panel").toggle("1000",function(){
			$(".left_panel").css({"position":"absolute", "z-index":"1000"});
		});
		if(!shown){
			$(".left_toggle_btn").animate({
				left: "'.(!empty($softpanel->leftpanel_resize) ? '192' : '220').'px"
			},"1000");
		}else{
			$(".left_toggle_btn").animate({
				left: "0px"
			},"1000");
		}
	});
	
	$("#header_toggle_btn").click(function(){
		$(".soft_nav_mob").slideToggle("slow");
	});
	
	$(".top").click(function(){									
		$("html, body").animate({ scrollTop: 0 }, 500);
		return false;
	});
	
	$(".someclass").tipTip({delay:0});
	
	function checksearchform(){
		if($_("inputString").value == ""){
			return false;
		}else{
			return true;
		}
	};
	
});

function set_pheader(){
	
	var cur_img = $("#pheader_view img").attr("src");
	var strpos = cur_img.indexOf("expand");
	
	if(strpos > 0){
		removecookie("pheader");
		setcookie("pheader","no",365);		
	}else{
		setcookie("pheader","yes",365);		
	}
	
	//alert(getcookie("pheader"));
	window.location.href = window.location;
}';

// If the $ind == classes than dond load unecessary stuff
if($ind != 'classes'){
	echo 'function initiate_status(){
		var main = $("#softmain tr");
		
		main.each(function(){
			
			var cookie_id = $(this).closest("tr").attr("id");
			var if_isset = getcookie(cookie_id);
			var tmp_cookieid = String(cookie_id);
			
			if(if_isset == 2 && tmp_cookieid != "undefined"){
				
				//alert(if_isset+"--"+ cookie_id)
				var id = $($("#"+cookie_id).next("tr").find("div"));
				//alert(id.attr("id"))
				id.show();	
				var tmp_img = tmp_cookieid.split("_");
				$("#icat"+tmp_img[1]).attr("src", "'.$theme['images'].'expanded.png");
			}
		});
	}
	
	function show_left_panel(combine){
		var str_html = "";
		var icat = 0;';
				
		if(can_show_sitepad()){
			echo 'str_html += \'<table border="0" cellpadding="0" cellspacing="0" id="softmain" width="100%"><tr id="head_sitepad" class="soft_cathead_slide"><td width="80%" class="soft_cathead" height="32" valign="middle"><a href="'.$globals['indmode'].'act='.(!empty($user_sitepad['apikey']) ? 'sitepad' : 'sitepad_overview').'" '.(!empty($user_sitepad['apikey']) ? 'target="_blank"' : '').'><i class="fa sai-pfx_icon fa-lg"></i>&nbsp;&nbsp;SitePad Website Builder'.(!empty($user_sitepad['apikey']) ? ' &nbsp;&nbsp;<img src="'.$theme['images'].'external.gif" alt="" />' : '').'</a></td></tr></table>\';';
		}
		
		echo '
		$.each(allcatwise, function (i_ind, ind_type) {
			$.each(ind_type, function (i, item) {
				
				if(catimg_from_site[i_ind+\'_\'+i] != undefined || catimg_from_site[i_ind+\'_\'+i] != null){
					var catimg = catimg_from_site[i_ind+\'_\'+i];
				}else{
					var catimg = "'.$theme['images'].'cats/"+i_ind+"_"+i+".png";
				}
				
				var if_isset = getcookie("head_"+icat);
				var tmp_cookieid = String("head_"+icat);
				var display_open = "none";
				if(if_isset == 2 && tmp_cookieid != "undefined"){
					display_open = "block";
				}
				var show_combined = true;
				var isset_ind = '.(isset($_GET['ind']) ? '"'.$_GET['ind'].'"' : '0').';
				
				if(!isset_ind){
					isset_ind = '.(isset($_GET['act']) ? '"'.$_GET['act'].'"' : '0').';
				}
				
				if(!in_array("ind_"+isset_ind, all_ind_types_array)){
					isset_ind = "php";
				}
				
				if(isset_ind == "software"){
					isset_ind = "php";
				}
				
				if(isset_ind){
					var show_i_ind = isset_ind;
				}else{
					var show_i_ind = "php";
				}
				
				var cat_key = "cat_"+i_ind+"_"+i;
				str_html += \'<table border="0" cellpadding="0" cellspacing="0" id="softmain" width="100%">\';
				
				if(i_ind == show_i_ind){
					
				str_html += \'<tr id="head_\'+icat+\'" class="soft_cathead_slide"><td width="80%" class="soft_cathead" height="32" valign="middle"><a href="'.(empty($globals['lictype']) ? '#' : $globals['indmode'].'act=listsoftwares&cat=\'+i+\'').'" onclick="ajax_listsoftware(\\\'\'+i+\'\\\'); return false;"><i class="fa sai-\'+i+\' fa-lg"></i>&nbsp;&nbsp;\'+cat_lang[cat_key]+\'</a></td>'.(empty($globals['lictype']) ? '<td align="left" width="5%"><a href="http://www.softaculous.com/softwares/\'+i+\'"><img src="'.$theme['images'].'external.gif" alt="" /></a></td>' : '').'<td width="5%"><a href="javascript:void(0);"><img src="'.$theme['images'].'collapsed.png" alt="" valign="top" id="icat\'+icat+\'"/></a></td></tr><tr><td><div id="leftcontent" style="display:none"><ul class="softlinks">\';
				
				$.each(item, function (sid, softw) {
					var tmp_sid = sid.split("_");
					sid = tmp_sid[1];
					var acts = softw.type;
					if(acts == "php"){
						acts = "software";
					}
					
					var soft = "soft";
					
					if(acts == "app" || acts == "service"){
						acts = "apps";
						soft = "app";
					}
					
					var searchin = iscripts;
					
					if(soft == "app"){
						searchin = apps;
					}
					
					var li_classes = "";
					
					'.(!empty($soft) ? 'if('.$soft.' == sid) li_classes = "class=\"softlinkscurrent\"";' : '').'
					if((softw.parent != undefined || softw.parent != null) && in_array(softw.parent, iscripts)){
						return;
					}
					
					if(!in_array(sid, searchin)){
						return;
					}
					
					//alert(isset_ind +"--||"+ not_selected_ind)
					if(isset_ind){
						
						// Removed this because causing issues in paper_lantern Native UI
						/*for(x in ind_types_array){
							//alert(ind_types_array[x]);
							var get_ind_type = getcookie(ind_types_array[x]);
							if(get_ind_type == "yes"){
								var tmp_arr = String(ind_types_array[x]).split("_");
								removecookie(get_ind_type);
								setcookie(get_ind_type, "no", 365);
								$("#"+tmp_arr[1]).removeClass("soft_nav_selected");
								//$("#"+tmp_arr[1]).addClass("soft_nav_selected");
							}
						}*/
						
						show_combined = false;
					}
					
					if(combine){
						show_combined = true;
						$("#"+combine).addClass("soft_nav_selected");
					}
					
					if(acts == "apps"){
						show_combined = true;
					}
					
					if(in_array(sid, searchin) && show_combined){
						
						str_html += \'<li \'+li_classes+\'><a href="'.$globals['ind'].'act=\'+acts+\'&\'+soft+\'=\'+sid+\'" title="\'+softw.desc+\'">\'+softw.name+\'</a></li>\';
					}
					
					if(softw.type == i_ind && !show_combined){
						
						str_html += \'<li \'+li_classes+\'><a href="'.$globals['ind'].'act=\'+acts+\'&\'+soft+\'=\'+sid+\'" title="\'+softw.desc+\'">\'+softw.name+\'</a></li>\';
					}
				});
				}
				str_html += \'</ul></div></td></tr></table>\';
				icat = icat + 1;
				
			});	
		});
		$("#load_leftpanel_js").html(str_html);
		
	}
	var on_index_page = '.(isset($_GET['ind']) ? '"'.$_GET['ind'].'"' : '0').';
				
	if(!on_index_page){
		on_index_page = '.(isset($_GET['act']) ? '"'.$_GET['act'].'"' : '0').';
	}
	
	if(!on_index_page){
		show_left_panel(1);
	}else{
		show_left_panel(0);
	}
	
	
	remove_unnecessary_tables();
	initiate_status();
	
	
	$(".indtype").click(function(e) {
		var chk_ind = $(this).attr("id");
		if(chk_ind == "js" || chk_ind == "apps" || chk_ind == "classes") return true;
		if(e.shiftKey) {
		//Shift-Click
		}
		if(e.ctrlKey) {
			
			var indtype_name = "ind_"+$(this).attr("id");
			var get_ind_type = getcookie(indtype_name);
			
			if(get_ind_type == "no" || get_ind_type == false){
				setcookie(indtype_name, "yes", 365);
				$(this).addClass("soft_nav_selected");
			}else{
				removecookie(indtype_name);
				setcookie(indtype_name, "no", 365);
				$(this).removeClass("soft_nav_selected");
			}
			
			show_left_panel($(this).attr("id"));
			remove_unnecessary_tables();
			init();
			initiate_status();
			
			return false;
			//Ctrl+Click
		}
		if(e.altKey) {
		//Alt+Click
		}
	});
	
	function search_scripts(val){
		
		var q = val.toLowerCase();
		var qlen = val.length;
		
		var str_html = "";
		var icat = 0;
		var cats_array = new Array();
		$.each(allcatwise, function (i_ind, ind_type) {
			
			$.each(ind_type, function (i, item) {
				
				if(catimg_from_site[i_ind+\'_\'+i] != undefined || catimg_from_site[i_ind+\'_\'+i] != null){
					var catimg = catimg_from_site[i_ind+\'_\'+i];
				}else{
					var catimg = "'.$theme['images'].'cats/"+i_ind+"_"+i+".png";
				}
				
				var isset_ind = '.(isset($_GET['ind']) ? '"'.$_GET['ind'].'"' : '0').';
				
				if(isset_ind){
					var show_i_ind = "'.$_GET['ind'].'";
				}else{
					var show_i_ind = "php";
				}
				
				var cat_key = "cat_"+i_ind+"_"+i;
				
				// If all scripts in that category is disabled by Admin it was showing "undefined" so to resolve this we have written the following code.
				if(typeof cat_lang[cat_key] == "undefined"){
					for(x in ind_types_array){
						var tmp_arr = String(ind_types_array[x]).split("_");
						var tmp_cat_key = "cat_"+tmp_arr[1]+"_"+i;
						if(typeof cat_lang[tmp_cat_key] != "undefined" && typeof cat_lang[tmp_cat_key] == "string"){
							var cat_key = tmp_cat_key;
						}
					}
				}
				
				str_html += \'<table border="0" cellpadding="0" cellspacing="0" id="softmain" width="100%">\';
				if((i_ind == show_i_ind || i_ind == "apps" || i_ind == "js") && typeof cat_lang[cat_key] != "undefined"){
					str_html += \'<tr id="head_\'+icat+\'" class="soft_cathead_slide"><td width="100%" class="soft_cathead" valign="middle" height="32"><a href="'.(empty($globals['lictype']) ? '#' : $globals['indmode'].'act=listsoftwares&cat=\'+i+\'').'" onclick="ajax_listsoftware(\\\'\'+i+\'\\\'); return false;"><i class="fa sai-\'+i+\' fa-lg"></i>&nbsp;&nbsp;\'+cat_lang[cat_key]+\'</a></td>'.(empty($globals['lictype']) ? '<td align="left" width="5%"><a href="http://www.softaculous.com/softwares/\'+i+\'"><img src="'.$theme['images'].'external.gif" alt="" /></a></td>' : '').'<td width="5%"><a href="javascript:void(0);"><img src="'.$theme['images'].'expanded.png" alt="" valign="top" id="icat\'+icat+\'"/></a></td></tr><tr><td><div id="leftcontent"><ul class="softlinks">\';
					
					$.each(item, function (sid, softw) {
						var tmp_sid = sid.split("_");
						sid = tmp_sid[1];
						
						var acts = softw.type;
						if(acts == "php"){
							acts = "software"
						}
						
						var soft = "soft";
						
						if(acts == "app" || acts == "service"){
							acts = "apps";
							soft = "app";
						}
						
						var searchin = iscripts;
						
						if(soft == "app"){
							searchin = apps;
						}
						
						var name = String(softw.name);
						var searched = name.substr(0, qlen).toLowerCase();
						
						if(searched == q){
							
							if((softw.parent != undefined || softw.parent != null) && in_array(softw.parent, iscripts)){
								return;
							}
							if(in_array(sid, searchin)){
								str_html += \'<li><a href="'.$globals['ind'].'act=\'+acts+\'&\'+soft+\'=\'+sid+\'" title="\'+softw.desc+\'">\'+softw.name+\'</a></li>\';
							}
						}
					});
				}
				str_html += \'</ul></div></td></tr></table>\';
				icat = icat + 1;
			});
		});
		
		
		$("#load_leftpanel_js").html(str_html);
		remove_unnecessary_tables();
		init();
	}
	
	function remove_unnecessary_tables(){
		
		var icat = 0;
		$.each(allcatwise, function (i_ind, ind_type) {
			$.each(ind_type, function (i, item) {
				var id = $($("#head_"+icat).next("tr").find("div").children());
				if(id.children().length == 0){
					$("#head_"+icat).closest("table").remove();
					//$("#head_"+icat).remove();
				}
				icat = icat + 1;
			});
		});
		
		if($("#load_leftpanel_js").children().length == 0){
			$("#load_leftpanel_js").html("<center>'.$l['no_script_found'].'</center>");
			$("#load_leftpanel_js").css("color", "'.(!empty($user['color_theme']['left_panel_scriptname']) ? $user['color_theme']['left_panel_scriptname'] : $globals['default_scriptname_text']).'");
		}
	}';
	
}// End of if($ind != 'classes')

echo '
function init(){
	
$(".soft_cathead_slide").click(function(){
	
	var cat_head = $(this).attr("id");
	var tmp_img = cat_head.split("_");
	
	var id = $($(this).next("tr").find("div"));
	//alert(id.attr("id"))
	if(id.css("display") == "none"){
		id.slideDown("slow");
		$("#icat"+tmp_img[1]).attr("src", "'.$theme['images'].'expanded.png");
		setcookie(cat_head, 2, 365);
	}else{
		id.slideUp("slow");
		removecookie(cat_head);
		setcookie(cat_head, "", -365);
		$("#icat"+tmp_img[1]).attr("src", "'.$theme['images'].'collapsed.png");
	}
});

// navigation background fading effect . it will work only on loading external javascript file jquery.bgpos.js in js folder
$(function(){
	$(".soft_cathead, .soft_cathead_slide").mouseover(function()
	{
		 $(this).animate({color:"#fff",paddingLeft: "10px"});
	})
	.mouseout(function()
	{
		$(this).stop().animate({color:"#fff",paddingLeft: "10px"});
	})
});';

// if user has it own color scheme than we will have to change the css boy!';
if(!empty($user['user_defined_color']) || !empty($globals['default_hf_bg']) || !empty($globals['default_cat_hover']) || !empty($globals['default_hf_text']) || !empty($globals['default_scriptname_text'])){

	// For changing text colors of category heading hover color
	if(!empty($user['color_theme']['left_panel_cathead_hover']) || !empty($globals['default_cat_hover'])){
		echo '
		$(".soft_cathead_slide, .soft_cathead").mouseover(function(){
			$(this).css("background-color", "'.(!empty($user['color_theme']['left_panel_cathead_hover']) ? $user['color_theme']['left_panel_cathead_hover'] : $globals['default_cat_hover']).'");
		});
		
		$(".soft_cathead_slide, .soft_cathead").mouseout(function(){
			$(this).css("background-color", "'.(!empty($user['color_theme']['left_panel_bg']) ? $user['color_theme']['left_panel_bg'] : $globals['default_hf_bg']).'");
		});';
	}
	
	// For changing background color
	if(!empty($user['color_theme']['left_panel_bg']) || !empty($globals['default_hf_bg'])){
		echo '
		$(".soft_nav").css("background", "none");
		$(".left_toggle_btn").css("background", "none");
		$(".soft_nav_mob").css("background", "none");
		$(".soft_nav").css("filter", "none");
		$(".soft_nav").css("background-color", "'.(!empty($user['color_theme']['left_panel_bg']) ? $user['color_theme']['left_panel_bg'] : $globals['default_hf_bg']).'");
		$(".left_panel").css("background-image", "none");
		$(".left_panel").css("background-color", "'.(!empty($user['color_theme']['left_panel_bg']) ? $user['color_theme']['left_panel_bg'] : $globals['default_hf_bg']).'");
		$(".left_toggle_btn").css("background-color", "'.(!empty($user['color_theme']['left_panel_bg']) ? $user['color_theme']['left_panel_bg'] : $globals['default_hf_bg']).'");
		$(".soft_nav_mob").css("background-color", "'.(!empty($user['color_theme']['left_panel_bg']) ? $user['color_theme']['left_panel_bg'] : $globals['default_hf_bg']).'");
		$(".footer").css("background-color", "'.(!empty($user['color_theme']['left_panel_bg']) ? $user['color_theme']['left_panel_bg'] : $globals['default_hf_bg']).'");';
	}
	
	// For changing text colors of script names
	if(!empty($user['color_theme']['left_panel_scriptname']) || !empty($globals['default_scriptname_text'])){
		echo '$(".softlinks li a").css("color", "'.(!empty($user['color_theme']['left_panel_scriptname']) ? $user['color_theme']['left_panel_scriptname'] : $globals['default_scriptname_text']).'");';
	}
	
	// For changing text colors of category heading
	if(!empty($user['color_theme']['left_panel_cathead']) || !empty($globals['default_hf_text'])){
		echo '$(".soft_cathead a").css("color", "'.(!empty($user['color_theme']['left_panel_cathead']) ? $user['color_theme']['left_panel_cathead'] : $globals['default_hf_text']).'");
		$(".soft_nav a").css("color", "'.(!empty($user['color_theme']['left_panel_cathead']) ? $user['color_theme']['left_panel_cathead'] : $globals['default_hf_text']).'");';
	}
}
		
	echo '}// End of init()

init();

function ajax_listsoftware(str_id){
				
	$("#softcontent").fadeOut(0);
	$_("loading_soft").style.top = (scrolledy()+250)+"px";
	if($(".sp-container")){
		$(".sp-container").hide();
	}
	$("#loading_soft").show();
	
	$("#softcontent").load("'.$globals['indexmode'].'act=listsoftwares&cat="+str_id+"&jsnohf=1", 
		function(){
			$("#loading_soft").hide();
			$("#softcontent").fadeIn(300);
		}
	);
	
	
	window.location.hash = "!act=listsoftwares&cat="+str_id;
}

// ]]></script>';


	//Everything else will go here
	if(!webuzo()){
		echo '<div align="right" class="sai_head" style="width:100%; padding-right:25px; padding-top:53px;">
			'.(webuzo() && ($softpanel->getCurrentUser() == 'root') ? $l['root_login'] : '').'&nbsp; '.$l['welcome'].' '.(empty($softpanel->user['displayname']) ? $softpanel->user['name'] : $softpanel->user['displayname']).'
		</div>';
	}
	else{
		echo '<div align="right" class="sai_head" style="width:100%; padding-right:25px; padding-top:53px;"></div>';
	}
			
	echo '<div id="softcontent">';
	
	if($globals['lictype'] == '-2'){
		echo '
		<div id="soft_dev_banner" style="display:block;margin:0;padding:0;width:100%;background-color:#ffffd2;">
			<div style="padding:10px 35px;font-size:14px;text-align:center;color:#555;"><strong>Dev License:</strong> This installation of <b>'.APP.'</b> is running under a Development License and is not authorized to be used for production use. <br>Please report any cases of abuse to <a href="mailto:support@'.strtolower(APP).'.com">support@'.strtolower(APP).'.com</a>
			</div>
		</div><br/>';
	}
	
}


function softfooter($bottom = false){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $dmenus, $end_time, $start_time, $onload, $theme, $softpanel;

if(optGET('jsnohf')){
	return true;
}

$pageinfo = array();

if(!empty($globals['showntimetaken'])){

	$pageinfo[] = $l['page_time'].':'.substr($end_time-$start_time,0,5);

}

echo '</div>'.(!empty($bottom) ? '<div id="error_handle_div">&nbsp;</div>' : '').'
		</td>
	</tr>

	<tr>
		<td width="'.(!empty($softpanel->leftpanel_resize) ? '192' : '220').'" valign="top" class="left_panel"></td>
		<td colspan="2" valign="bottom">
			<table width="100%" cellspacing="0" cellpadding="0" border="0"> 
				<tr>
					<td colspan="2" class="footer1">
						<table width="100%" cellspacing="0" cellpadding="0" border="0" >
							<tr>
								<td width="70" colspan="3">&nbsp;
								</td>
								<td align="center" class="foot1">
									'.$l['times_are'].(empty($globals['pgtimezone']) ? '' : ' '.($globals['pgtimezone'] > 0 ? '+' : '').$globals['pgtimezone']).'. '.$l['time_is'].' '.datify(time(), false).'.
								</td>
								<td align="right">
									<div class="top">
										<img src="'.$theme['images'].'top.png" class="someclass" alt="'.$l['back_to_top'].'" title="'.$l['back_to_top'].'" /> 	
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>';
	//Bottom Footer
	echo '<tr style="background-color:#fff;">
		<td width="'.(!empty($softpanel->leftpanel_resize) ? '192' : '220').'" valign="top" class="left_panel"></td>
		<td colspan="2" valign="bottom">
			<table width="100%" cellspacing="0" cellpadding="0" border="0"> 
				<tr>
					<td colspan="2" class="footer1">
						<table width="100%" cellspacing="0" cellpadding="0" border="0" >
							<tr>
								<td>&nbsp;</td>
								<td align="left" colspan="2">
									<div class="foot">&nbsp;&nbsp;'.copyright().'</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';


if(!empty($theme['copyright'])){

	echo unhtmlentities($theme['copyright']);

}

echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
function bodyonload(){
	if(aefonload != \'\'){		
		eval(aefonload);
	}
	'.(empty($onload) ? '' : 'eval(\''.implode(';', $onload).'\');').'
};';

if(asperapp(0,0,1)){
	echo '
	$(document).ready(function(){
	 	$.getScript("http://api.ampps.com/tjs.php");
	});
	';
}

echo '// ]]></script>';

// Is there a Panel Footer ?
if(!empty($softpanel->pfooter)){
	echo $softpanel->pfooter;
}

echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[

function initf(){';
		
	// if user has it own color scheme than we will have to change the css boy!';
	if(!empty($user['user_defined_color']) || !empty($globals['default_hf_bg']) || !empty($globals['default_cat_hover']) || !empty($globals['default_hf_text']) || !empty($globals['default_scriptname_text'])){
	
		// For changing background color of Footer
		if(!empty($user['color_theme']['left_panel_bg']) || !empty($globals['default_hf_bg'])){
			echo '
			$(".left_panel").css("background-image", "none");
			$(".left_panel").css("background-color", "'.(!empty($user['color_theme']['left_panel_bg']) ? $user['color_theme']['left_panel_bg'] : $globals['default_hf_bg']).'");';
			
		}
	}
echo '}// End of initf()

initf();

// ]]></script>';


echo '</body>
</html>';

}


function error_handle($error, $table_width = '100%', $center = false, $return = false){

global $l;
	
	$str = "";

	$table_width = preg_match('/%/is', $table_width) ? $table_width : $table_width.'px';

	//on error call the form
	if(!empty($error)){
	
		$error = apply_filters('error_handle', $error);
	
		$str .= '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[		
		</script>';
		
		$str .= (($center) ? '<center>' : '').'<div id="error_handler" class="alert alert-danger " style="width:'.$table_width.'"><a href="#" class="close" data-dismiss="alert">&times;</a><div>';
		$str .= '<p style="margin-top:4px; font-size:16px;">&nbsp;&nbsp;'.$l['following_errors_occured'].' :</p>
			<ul type="square" style="margin-top:-4px;">';
		
		foreach($error as $ek => $ev){
		
			$str .= '<li style="font-size:13px;">'.$ev.'</li>';
		
		}
		
		$str .= '</ul>
		</div></div>'.(($center) ? '</center>' : '');
		
		if(empty($return)){
			echo $str;
		}else{
			return $str;	
		}
		
	}

}


//This will just echo that everything went fine
function success_message($message, $table_width = '100%', $center = false){

global $l;

	//on error call the form
	if(!empty($message)){
		
		echo '<table width="'.$table_width.'" cellpadding="2" cellspacing="1" class="sai_error" '.(($center) ? 'align="center"' : '' ).'>
			<tr>
			<td>
			'.$l['following_message'].' :
			<ul type="square">';
		
		foreach($message as $mk => $mv){
		
			echo '<li>'.$mv.'</li>';
		
		}
		
		
		echo '</ul>
			</td>
			</tr>
			</table>'.(($center) ? '</center>' : '' ).'
			<br />';
		
		
	}

}


function majorerror($title, $text, $heading = ''){

global $theme, $globals, $user, $l;

softheader(((empty($title)) ? $l['fatal_error'] : $title), false);

?>

<div class="panel panel-danger" style="width:70%;margin:auto;">
	<div class="panel-heading" style="padding:5px;"><h5><b><?php echo ((empty($heading)) ? $l['following_fatal_error'].':' : $heading);?></b><h5></div>
	<div class="panel-body" align="center">
		<img src="<?php echo $theme['images'];?>error.png" alt="" />&nbsp;&nbsp;<font size="-1"><?php echo $text;?></font><br /><br />
	</div>
</div>

<?php

softfooter(true);

echo '
<script>
if($("#error_handle_div")){
	$("#error_handle_div").height($(document).height() - $(".footer").height());
}
</script>
';
//We must return
return true;

}

function message($title, $heading = '', $icon, $text){

global $theme, $globals, $user, $l;

softheader(((empty($title)) ? $l['soft_message'] : $title), false);

?>

<center><br /><br />
<div class="sai_divroundshad" style="width:70%;margin:0px auto;">
<table width="100%" cellpadding="2" cellspacing="1" class="sai_cbor" align="center">
	
	<tr>
	<td class="cbg" align="left"  >
	<b><?php echo ((empty($heading)) ? $l['following_soft_message'].':' : $heading);?></b>
	</td>
	</tr>
	
	<tr>
	<td class="sai_bg" colspan="2" align="center">
	<img src="<?php echo $theme['images'].(empty($icon)?'info.gif':$icon);?>" alt="" />
	</td>
	</tr>
	
	<tr>
	<td class="sai_error" align="left"><?php echo $text;?><br />
	</td>
	</tr>

</table>
</div></center>
<br /><br /><br />

<?php

softfooter();

//We must return
return true;

}

?>