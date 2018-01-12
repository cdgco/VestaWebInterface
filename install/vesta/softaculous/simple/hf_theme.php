***REMOVED***

***REMOVED***////
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
***REMOVED***////

if(!defined('SOFTACULOUS')){

	die('Hacking Attempt');

***REMOVED***

function js_url(){
	
	$js['givejs'] = func_get_args();
	
	return $GLOBALS['globals']['ind'].http_build_query($js).'&'.$GLOBALS['globals']['version'];
		
***REMOVED***

function softheader($title = '', $leftbody = true){

global $theme, $user, $logged_in, $globals, $l, $dmenus, $onload, $newslinks, $feeds, $softpanel, $iscripts, $catwise, $allcatwise, $soft, $classes_categories, $scripts, $apps, $apps_catwise, $user_sitepad;

	if(optGET('jsnohf')){
		return true;
	***REMOVED***
	
	
	/* <script language="javascript" src="'.js_url('js/jquery.js', 'js/universal.js', 'js/suggest.js', 'js/smoothscroll.js', 'js/slider.js', 'js/dock.js').'" type="text/javascript"> </script> */
	
	$title = ((empty($title)) ? $globals['sn'] : $title);
	$got_cache_js = get_cache_time();
	
	// Is there a Panel Header ?
	if(!empty($softpanel->pheader)){
		echo $softpanel->pheader;
	***REMOVED***
	
	$custom_favicon  = (!empty($globals['favicon_logo']) ? $globals['favicon_logo'] : $theme['images'].'/'.(asperapp('', 'webuzo/', 'ampps/')).'favicon.ico');
	
	//Lets echo the top headers
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset='.$globals['charset'].'" />
	<meta name="keywords" content="softaculous, software" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<title>'.$title.'</title>
	<link rel="stylesheet" type="text/css" href="'.$theme['this_url'].'/style.css?'.$GLOBALS['globals']['version'].'" />'.
	(file_exists($theme['path'].'/custom.css') ? '<link rel="stylesheet" type="text/css" href="'.$theme['url'].'/custom.css?'.$GLOBALS['globals']['version'].'" />' : '')
	.'<link rel="stylesheet" type="text/css" href="'.$theme['url'].'/bootstrap/css/bootstrap.min.css?'.$GLOBALS['globals']['version'].'" />
	<link rel="stylesheet" type="text/css" href="'.$theme['url'].'/font-awesome.css?'.$GLOBALS['globals']['version'].'" />
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="'.$theme['url'].'/ie7.css?'.$GLOBALS['globals']['version'].'">
	<![endif]-->
	<link rel="shortcut icon" href='.$custom_favicon.' />
	<script language="javascript" src="'.$theme['url'].'/js/jquery.js" type="text/javascript"></script>
	<script language="javascript" src="'.$theme['url'].'/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script language="javascript" src="'.$theme['url'].'/js/combined.js?'.$GLOBALS['globals']['version'].'" type="text/javascript"></script>
	<script language="javascript" src="'.$theme['this_url'].'/cache/cache.js?'.$got_cache_js.'" type="text/javascript"> </script>
	</head>
	<body onload="bodyonload();">';
	
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
				***REMOVED******REMOVED***
					var img = \'<img src="'.$theme['images'].'confirm.gif" />\';			
				***REMOVED***	
					
				if(jQuery(\'.sai_message_box\').html() === null) {
					var message = \'<div class="sai_message_box"><table border="0" cellpadding="8" width="100%" height="100%"><tr ><td rowspan="2" width="40%" > \'+ img + \'</td><td width="60%" class ="msg_tr1">\' +  title + \'</td></tr><tr class ="msg_tr2"><td style="text-align:left">\' + body + \'</td></tr><tr ><td colspan="2">\' + okbutton + \'</td></tr></table></div>\';
					jQuery(document.body).append( message );								
					jQuery(\'.sai_message_box\').css(\'top\', jQuery($(jQuery.browser.webkit ? "body": "html")).scrollTop() + 150);
					jQuery(\'.sai_message_box\').show(\'slow\');
				***REMOVED******REMOVED***
					var message =\' <table border="0" width="100%" cellpadding="8" height="100%"><tr ><td rowspan="2" width="40%">\'+ img +  \'</td><td widt="60%" class ="msg_tr1">\' + title + \'</td></tr><tr class ="msg_tr2"><td style="text-align:left">\' + body + \'</td></tr><tr ><td colspan="2">\' + okbutton + \'</td></tr></table>\';
					jQuery(\'.sai_message_box\').css(\'top\', jQuery($(jQuery.browser.webkit ? "body": "html")).scrollTop() + 150);
					jQuery(\'.sai_message_box\').show(\'slow\');
					jQuery(\'.sai_message_box\').html( message );
				***REMOVED***
			***REMOVED***,
			this.delete_message = function(title, body ,did) {
				var yesbutton = \'<input type="button" onclick="message_box.yes_close_message(\\\'\'+did+\'\\\');" value="YES" class="alert-butt"/>\';
				var nobutton = \'<input type="button" onclick="message_box.no_close_message();" value="NO" class="alert-butt"/>\';
				var img = \'<img src="'.$theme['images'].'remove_big.gif" />\';
										
				if(jQuery(\'.sai_message_box\').html() === null) {
					var message = \'<div class="sai_message_box"><table border="0" cellpadding="8" width="100%" height="100%"><tr height="60%" ><td rowspan="2" width="40%" > \'+ img + \'</td><td width="60%" class ="msg_tr1" height="10%">\' +  title + \'</td></tr><tr ><td style="text-align:left" height="60%" cellpading="2" class ="msg_tr2">\' + body + \'</td></tr><tr ><td colspan="2">\' + yesbutton + \'&nbsp; &nbsp; \' + nobutton + \'</td></tr></table></div>\';				
					jQuery(document.body).append( message );								
					jQuery(\'.sai_message_box\').css(\'top\', jQuery($(jQuery.browser.webkit ? "body": "html")).scrollTop() + 150);
					jQuery(\'.sai_message_box\').show(\'slow\');
				***REMOVED******REMOVED***
					var message = \' <table  border="0" cellpadding="8" width="100%" height="100%"><tr height="60%" ><td rowspan="2" width="40%">\'+ img +  \'</td><td widt="60%" class ="msg_tr1" height="10%">\' + title + \'</td></tr><tr><td style="text-align:left" height="60%" cellpading="2" class ="msg_tr2">\' + body + \'</td></tr><tr ><td colspan="2">\' + yesbutton + \'&nbsp; &nbsp; \' + nobutton + \'</td></tr></table>\'
					jQuery(\'.sai_message_box\').css(\'top\', jQuery($(jQuery.browser.webkit ? "body": "html")).scrollTop() + 150);
					jQuery(\'.sai_message_box\').show(\'slow\');
					jQuery(\'.sai_message_box\').html( message );
				***REMOVED***
			***REMOVED***,
			this.close_message = function() {
				jQuery(\'.sai_message_box\').hide(\'fast\');
				if(this.reload==1){ window.location=window.location;***REMOVED***
			***REMOVED***,
			this.yes_close_message = function(did) {	
				$(\'#did\'+did).attr("src","'.$theme['images'].'progress.gif");						
				fYes.apply(this, arguments);
				jQuery(\'.sai_message_box\').hide(\'fast\');
			***REMOVED***,
			this.no_close_message = function() {
				jQuery(\'.sai_message_box\').hide(\'fast\');
			***REMOVED***
		***REMOVED***
	</script>';
	
	***REMOVED***
	// Show the EULA Notice in Interworx panel
	if(empty($user['eula_accept']) && $globals['softpanel'] == 'interworx'){
		echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
	
		var message_box = function(){			
				return {
					show_message: function(title, body , image) {			
						var okbtn = \'<input  style="width:75px" class="sai_submit" type="button" onclick="message_box.close_message(this.value);" value="Agree" name="okbtn" />\';	
						var cancelbtn = \'<input  style="width:75px" class="sai_submit" type="button" onclick="message_box.close_message(this.value);" value="Decline" name="cancelbtn" />\';
											
						if(jQuery(\'.sai_message_box\').html() === null) {
							var message = \'<div class="sai_message_box"><table border="0" cellpadding="8" width="100%" height="100%"><tr><td width="100%" class ="msg_tr1" style="text-align:center">\' +  title + \'</td></tr><tr class ="msg_tr2"><td style="text-align:left">\' + body + \'</td></tr><tr ><td class ="msg_tr3">\' + okbtn + \' &nbsp; &nbsp; \' + cancelbtn + \'</td></tr></table></div>\';
							jQuery(document.body).append( message );								
							jQuery(\'.sai_message_box\').css(\'top\', jQuery(\'html, body\').scrollTop() + 150);
							jQuery(\'.sai_message_box\').show(\'slow\');
						***REMOVED******REMOVED***
							var message =\' <table border="0" width="100%" cellpadding="8" height="100%"><tr ><td widt="60%" class ="msg_tr1">\' + title + \'</td></tr><tr class ="msg_tr2"><td style="text-align:left">\' + body + \'</td></tr><tr ><td class ="msg_tr3">\' + okbtn + \'</td><td class ="msg_tr3">\' + cancelbtn + \'</td></tr></table>\';				
							jQuery(\'.sai_message_box\').css(\'top\', jQuery(\'html, body\').scrollTop() + 150);
							jQuery(\'.sai_message_box\').show(\'slow\');
							jQuery(\'.sai_message_box\').html( message );
						***REMOVED***
					***REMOVED***,
					close_message: function(action) {
						
						jQuery(\'.sai_message_box\').hide(\'fast\');
						
						if(action == "Agree"){
				
							$.ajax({
								type: "GET",
								url: window.location+"?&eula_accept=1",
								
								// Checking for error
								success: function(data){
								***REMOVED***,
								error: function() {
								***REMOVED***													
							***REMOVED***);
							
							return false;
							
						***REMOVED******REMOVED***
							alert("You must not use Softaculous if you do not agree to the EULA");
						***REMOVED***
					***REMOVED***
				***REMOVED***
			***REMOVED***();
	
		$(document).ready(function(){
			
			// Show the eula accept message
			var agree_msg = \'<center>You must agree to the <a href="http://www.softaculous.com/softaculous/eula" target="_blank">EULA</a> before using Softaculous</center>\';
			
			message_box.show_message("<a href=\"http://www.softaculous.com/softaculous/eula\" target=\"_blank\" style=\"text-decoration:none\">End User License Agreement</a>",agree_msg,1);
			
		***REMOVED***);
		// ]]></script>';
	***REMOVED***

	$navbar_top = array();
			
	if(empty($globals['off_panel_link'])){
		$navbar_top['goto_control_panel'] = '<li><a href="/vwi/panel.php"><img src="'.$theme['images'].(!empty($softpanel->goto_cp_logo) ? $softpanel->goto_cp_logo : 'panel.gif').'" alt="" tooltip="'.$l['go_cpanel'].'" /></a></li>';
	***REMOVED***

	if(webuzo() && (!$softpanel->is_sysapps_disable())){
		$navbar_top['goto_webuzo_home'] = '<li><a href="'.$globals['ind'].'"><img src="'.$theme['images'].'home.gif" alt="" tooltip="'.$l['go_home'].'" /></a></li>';
	***REMOVED***
	
	if(webuzo()){
		$navbar_top['goto_webuzo_cpanel'] = '<li><img src="'.$theme['images'].'panel.gif" alt="" tooltip="'.$l['go_cpanel'].'" onclick="goto_panel();" style="cursor:pointer" /></li>';
	***REMOVED***
	
	if(aefer() && allow_adddomain()){
		$navbar_top['add_domain'] = '<li><a href="'.$globals['ind'].'act=domains"><img src="'.$theme['images'].'domains.gif" alt="" tooltip="'.$l['go_domain'].'" /></a></li>';
	***REMOVED***
	
	if(webuzo()){
		$navbar_top['webuzo_manage_domains'] = '<li><a href="'.$globals['ind'].'act=domainmanage"><img src="'.$theme['images'].'domains.gif" alt="" tooltip="'.$l['go_domain'].'" /></a></li>';
	***REMOVED***
	
	if(empty($globals['off_demo_link'])){
		$navbar_top['goto_demo'] = '<li><a href="'.$globals['ind'].'act=demos"><img src="'.$theme['images'].'demos.gif" alt="" tooltip="'.$l['go_demos'].'" /></a></li>';
	***REMOVED***
	
	if(empty($globals['off_rating_link'])){
		$navbar_top['goto_rating'] = '<li><a href="'.$globals['ind'].'act=ratings"><img src="'.$theme['images'].'ratings.gif" alt="" tooltip="'.$l['go_ratings'].'" /></a></li>';
	***REMOVED***

	$navbar_top['goto_installations'] = '<li><a href="'.$globals['ind'].'act=installations"><img src="'.$theme['images'].'installations.gif" alt="" tooltip="'.$l['go_installations'].'" /></a></li>';

	if(webuzo() && (!$softpanel->is_sysapps_disable())){
		$navbar_top['webuzo_app_installations'] = '<li><a href="'.$globals['ind'].'act=apps_installations"><img src="'.$theme['images'].'apps_installations.gif" alt="" tooltip="'.$l['go_apps_installations'].'" /></a></li>';
	***REMOVED***

	$navbar_top['goto_tasklist'] = '<li><a href="'.$globals['ind'].'act=eu_tasklist"><img src="'.$theme['images'].'tasklist.png" alt="" tooltip="'.$l['go_tasklist'].'" /></a></li>';

	$navbar_top['goto_settings'] = '<li><a href="'.$globals['ind'].'act=settings"><img src="'.$theme['images'].'settings.gif" alt="" tooltip="'.$l['go_settings'].'" /></a></li>';

	if(empty($globals['disable_backup_restore'])){
		$navbar_top['goto_backups'] = '<li><a href="'.$globals['ind'].'act=backups"><img src="'.$theme['images'].'backups.gif" alt="" tooltip="'.$l['go_backups'].'" /></a></li>';
	***REMOVED***

	if(empty($globals['off_email_link'])){
		$navbar_top['goto_email_settings'] = '<li><a href="'.$globals['ind'].'act=email"><img src="'.$theme['images'].'emails.gif" alt="" tooltip="'.$l['go_email_settings'].'" /></a></li>';
	***REMOVED***

	if(empty($globals['off_sync_link'])){
		$navbar_top['goto_sync'] = '<li><a href="'.$globals['ind'].'act=sync"><img src="'.$theme['images'].'sync.gif" alt="" tooltip="'.$l['go_sync'].'" /></a></li>';
	***REMOVED***

	if(!empty($globals['eu_themes_premium']) && !empty($globals['lictype'])){
		$navbar_top['goto_premium_themes'] = '<li><a href="'.$globals['ind'].'act=my_themes"><img src="'.$theme['images'].'pfx_icon.png" alt="" tooltip="'.$l['go_my_themes'].'" /></a></li>';
	***REMOVED***

	$navbar_top['goto_help'] = '<li><a href="'.$globals['ind'].'act=help"><img src="'.$theme['images'].'help.gif" alt="" tooltip="'.$l['go_support'].'" /></a></li>';	
	
	$navbar_top = apply_filters('navbar_links', $navbar_top);
	
	echo '<div id="loading_soft" class="sai_loading_soft">
			<img src="'.$theme['images'].'fb_loader.gif" alt="Loading..." />
		</div>';
	
	echo '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="sai_docktable">	
		<tr>
			<td align="left" width="440" valign="middle">
				<a href="'.$globals['ind'].'"><img src="'.($globals['softpanel'] == 'ampps' ? $theme['a_images'].'header.jpg' : (empty($globals['logo_url']) ? ($globals['softpanel'] == 'webuzo' ? $theme['a_images'].'header.jpg' : $theme['images'].'header.gif') : $globals['logo_url'])).'" alt=""  height="'.(!empty($softpanel->leftpanel_resize) ? '60' : '65').'" class="header_logo"/></a>
			</td>
			<td>&nbsp;</td>
	
			<td align="right" width="350" style="padding:8px" valign="top">					
			<ul id="dock" class="sai_dock">';
				foreach($navbar_top as $n => $k){
					echo $navbar_top[$n];
				***REMOVED***
			echo '</ul>
			<span id="dock_titler" style="visibility:hidden; position:absolute; top:0px; left:0px; border:1px solid #DEDCD1; background-color:#FFFFFF; text-align:left; padding: 1px; width:auto; white-space:nowrap;"></span>
			<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
			softdock = new dock();
			softdock.min = 30;
			softdock.max = 50;
			softdock.init();

			function checksearchform(){
				if($_("inputString").value == ""){
					return false;
				***REMOVED******REMOVED***
					return true;
				***REMOVED***
			***REMOVED***;

			function goto_panel(){

				var str = window.location; 	

				var port_find = str.toString().search(\'2003\'); 	

				if(port_find < 1){		
					var str_url = str.toString().replace("2002", "2004");
				***REMOVED******REMOVED***
					var str_url = str.toString().replace("2003", "2005");
				***REMOVED***

				var res = str_url.split("/",4);

				var res_out = res.join("/");	

				window.location = res_out+"/";
			***REMOVED***

			function set_pheader(){

				var cur_img = $("#pheader_view img").attr("src");
				var strpos = cur_img.indexOf("expand");

				if(strpos > 0){
					removecookie("pheader");
					setcookie("pheader","no",365);		
				***REMOVED******REMOVED***
					setcookie("pheader","yes",365);		
				***REMOVED***

				//alert(getcookie("pheader"));
				window.location.href = window.location;
			***REMOVED***

			$(document).ready(function(){

				$(".soft_cathead_slide").click(function(){
			
					var cat_head = $(this).attr("id");
					var tmp_img = cat_head.split("_");

					//$("#shift_"+tmp_img[1]).css("width", "1");
					var id = $("#leftcontent_"+tmp_img[1]);
					//alert(id.attr("id"))
					//alert(id.is(":visible"))

					if(id.css("display") == "none"){
						//id.show();
						id.slideDown("slow");			
						$("#icat"+tmp_img[1]).attr("src", "'.$theme['images'].'expanded.gif");
						setcookie(cat_head, 2, 365);
					***REMOVED******REMOVED***
						$("#icat"+tmp_img[1]).attr("src", "'.$theme['images'].'collapsed.gif");
						id.slideUp("slow");
						removecookie(cat_head);

						setcookie(cat_head, "", -365);
	
					***REMOVED***

				***REMOVED***);
			***REMOVED***);

			// ]]></script>
			</td>			
		</tr>	
	</table>';
	
	$temp_allcatwise = $allcatwise;
	// Classes are only avaialable to Premium License
	if(empty($globals['disable_classes']) && !empty($globals['lictype'])){
		$temp_allcatwise['classes'] = 'Classes';
	***REMOVED***
	
	// Webuzo has the APPs support
	if(webuzo()){
		
		$disablesysapps = $softpanel->is_sysapps_disable();
			
		if(empty($disablesysapps)){
			$temp_allcatwise['apps'] = 'Apps';
			$allcatwise['apps'] = $apps_catwise;
		***REMOVED***else if($globals['mode'] == 'apps'){
			redirect('');
			return false;
		***REMOVED***
		
	***REMOVED***
	
	echo '<table border="0" cellpadding="0" cellspacing="0" width="100%" height="35">	
		<tr>
			<td width="5" align="right">&nbsp;</td>
			<td width="10" align="right"><img src="'.$theme['images'].'leftheader.gif" alt="" /></td>
			<td width="60" align="left" class="sai_softac_header sai_headtd">
			<a href="'.$globals['ind'].'"><img src="'.$theme['images'].'home_bar.gif" alt="'.$l['go_home'].'" /></a>
			</td>
			
			<td align="left" class="sai_softac_header">&nbsp;&nbsp;'.
			(!empty($globals['panel_hf']) && !empty($softpanel->can_shrink_nativeui) ? '<a href="javascript:set_pheader();" id="pheader_view" ><img src="'.$theme['this_images'].(empty($_COOKIE['pheader']) || $_COOKIE['pheader'] == 'yes' ? 'expand.png" title="'.$l['expand_view'].'"' : 'collapse.png" title="'.$l['collapse_view'].'"').'></a>'  : '');

			if(empty($globals['nolabels'])){
				echo '&nbsp; Scripts : &nbsp; <a href="'.$globals['ind'].'ind='.$globals['mode'].'" style="font-size:15px">'.($globals['mode'] == 'js' ? 'JavaScripts' : ($globals['mode'] == 'classes'  ? 'Classes' : ( asperapp(0,1,0) ? ($globals['mode'] == 'java'  ? 'JAVA' : ($globals['mode'] == 'python'  ? 'Python' : strtoupper($globals['mode']))) : strtoupper($globals['mode'])) )).'</a>';
					foreach($temp_allcatwise as $k => $v){
						echo (empty($temp_allcatwise[$k]) || $globals['mode'] == $k ? '' : '&nbsp; <a href="'.$globals['ind'].'ind='.$k.'" >'.($k == 'js' ? 'JavaScripts' : ($k == 'classes' ? 'Classes' : ($k == 'java' || $k == 'apps' || $k == 'python' ? ucfirst($k) : strtoupper($k)) )).'</a>');
					***REMOVED***
			***REMOVED***
			
			echo '</td><td align="right" class="sai_softac_header"> '.(webuzo() && ($softpanel->getCurrentUser() == 'root') ? $l['root_login'] : '').'&nbsp; '.$l['welcome'].' '.(empty($softpanel->user['displayname']) ? $softpanel->user['name'] : $softpanel->user['displayname']).' [<a href="/vwi/logout.php">'.$l['logout'].'</a>] &nbsp; &nbsp;	
			</td>	
			
			<td width="168" align="left" class="sai_softac_header sai_search" valign="middle">
				<form accept-charset="'.$globals['charset'].'" name="search" method="post" action="'.$globals['ind'].'act=search&smode='.$globals['mode'].'" onsubmit="return checksearchform();" id="searchform">
				<input type="text" name="inputString" id="inputString" style="border:none" class="sai_search_box" onfocus="suggestjs.show(0, this.id);" value="'.$l['search'].'" onKeyUp="suggestjs.myKeyDownHandler(event, this.value);" autocomplete="off" onblur="suggestjs.show(1);" sugurl="'.$globals['index'].'&act=suggest&smode='.$globals['mode'].'" mode="'.$globals['mode'].'"/>
				<input type="hidden" name="hidden_cid" id="hidden_cid">
				<div id="suggestions" class="sai_suggestions" style="position:absolute;width:200px;left:0px; top:0px; display:none;"></div>
				</form>			
			</td>
			
			<td width="10" align="left"><img src="'.$theme['images'].'rightheader.gif" alt="" /></td>
			<td width="5" align="left">&nbsp;</td>
		</tr>	
	</table>
	<br />';
	
//The Menus of softwares
if(!empty($leftbody)){
	
	$theme['leftbody'] = $leftbody;
	
	echo '<table border="0" cellpadding="8" cellspacing="0" width="100%" class="sai_softwares">	
	<tr>
		<td align="left" valign="top" width="'.(!empty($softpanel->leftpanel_resize) ? '192' : '220').'" class="sai_softmenu">';
		
		$ind = $globals['mode'];
		
		//This is done for the SLIDER
		$js_cat = array();
			
		foreach($allcatwise[$ind] as $cat => $softs){
			if(empty($softs)) continue;
			$js_cat[] = $cat;
		***REMOVED***
		
		echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
			imgurl = "'.$theme['images'].'";
			softmenu = new slider();
			if(!isIE){
				softmenu.speed = 5;
			***REMOVED***
			softmenu.elements = new Array(\'cat'.implode('\', \'cat', $js_cat).'\');
			softmenu.expanded = new Array("catlibraries");
			//addonload(\'softmenu.init();\');
			
			timers = new Object();
			
			function incwidth(elid, to, inc){
				eleid = "shift_"+elid;
				clearTimeout(timers[eleid]);
				current = parseInt($_(eleid).width);
				
				tobecome = current + inc;
				if(tobecome >= to){
					tobecome = to;
				***REMOVED***
				
				$_(eleid).width = tobecome;
				r = parseInt(255 - current*2);
				g = parseInt(255 - current);
				
				$("#head_"+elid).css("background", "rgb("+r+", "+g+", 255)");
				
				if(tobecome < to){
					timers[eleid] = setTimeout("incwidth(\""+elid+"\", "+to+", "+inc+")", 20);
				***REMOVED***
			***REMOVED***;
			
			function decwidth(elid, to, dec){
				eleid = "shift_"+elid;
				
				clearTimeout(timers[eleid]);
				current = parseInt($_(eleid).width);
				tobecome = current - dec;
				if(tobecome < to){
					tobecome = to;
				***REMOVED***
				$_(eleid).width = tobecome;
				r = parseInt(255 - current*2);
				g = parseInt(255 - current);
				$("#head_"+elid).css("background", "rgb("+r+", "+g+", 255)");
				
				if(tobecome > to){
					timers[eleid] = setTimeout("decwidth(\""+elid+"\", "+to+", "+dec+")", 20);
				***REMOVED******REMOVED***
					$("#head_"+elid).css("background", "rgb(255, 255, 255)");
				***REMOVED***		
			***REMOVED***;
			
			function ajax_listsoftware(str_id){
				
				$("#softcontent").fadeOut(0);
				$_("loading_soft").style.top = (scrolledy()+250)+"px";
				$("#loading_soft").show();
				
				$("#softcontent").load("'.$globals['indexmode'].'act=listsoftwares&cat="+str_id+"&jsnohf=1", 
					function(){
						$("#loading_soft").hide();
						$("#softcontent").fadeIn(300);
					***REMOVED***
				);
				
				window.location.hash = "!act=listsoftwares&cat="+str_id;
			***REMOVED***
			
		// ]]></script>
		
	<div id="softmenu">';

	if($ind == 'classes' || optGET('act') == 'classes'){
	
		echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
		
			(function($) {
				$.extend($.fx.step,{
					backgroundPosition: function(fx) {
						if (fx.state === 0 && typeof fx.end == \'string\') {
							var start = $.curCSS(fx.elem,\'backgroundPosition\');
							if(typeof(start) == "undefined"){
								start = $.css(fx.elem, "background-position-x")+\' \'+$.css(fx.elem, "background-position-y");
							***REMOVED***
							start = toArray(start);
							fx.start = [start[0],start[2]];
							var end = toArray(fx.end);
							fx.end = [end[0],end[2]];
							fx.unit = [end[1],end[3]];
						***REMOVED***
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
					   ***REMOVED***
					***REMOVED***
				***REMOVED***);
			***REMOVED***)(jQuery);
			
				
			// navigation background fading effect . it will work only on loading external javascript file jquery.bgpos.js in js folder
			$(function(){
					$("#cmenu li ").css( {backgroundPosition:"0px -120px"***REMOVED***)
					.mouseover(function()
					{
							 $(this).stop().animate({ backgroundPosition:"(0px 0px)",
							 marginLeft: "5px"***REMOVED***, {duration:400***REMOVED***);
					***REMOVED***)
					.mouseout(function()
					{
								$(this).stop().animate({backgroundPosition:"(0px -120px)",
								marginLeft: "0px"***REMOVED***, {duration:400, complete:function(){
								$(this).css({backgroundPosition: "0px -120px"***REMOVED***)
								***REMOVED******REMOVED***);
					***REMOVED***)
				***REMOVED***);
			
			// this function will add blue arrow after clicking	
			$(function(){
				$("#cmenu li a").click(function(){
					 $("#cmenu li a ").removeClass("selected");
					 $(this).addClass("selected");
				 ***REMOVED***)
			***REMOVED***);
			
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
					***REMOVED***
					var soft_classes = \'<div class="bg"><br /><div class="row row_usi_cls">\';
					var br = 1; 
					$.each(data.data, function (i, item) {
						soft_classes += \'<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding-bottom: 20px;"><div class="sai_classes_boxgrid2" onclick=window.location=this.id; id="'.$globals['index'].'act=classes&cid=\'+item.cid+\'&tab=overview" ><div class="sai_classes_boxgrid"><div><h2>\'
						+item.name+
						\'</h2><p style="padding:10px;height:50px;">\'
						+item.desc+\'</p><p style="padding:10px;height:15px;"> <b>'.$l['cl_ratings'].'</b> : \'
						+parseFloat(item.ratings)+\'/5</p> </div><div style="height:200px;"><br /><h2>\'
						+item.name+
						\'</h2><p style="margin-left:10px;margin-top:15px"><b> '.$l['cl_author'].'</b> : \'
						+item.author+\'</p><p style="margin-left:10px;"><b> '.$l['cl_license'].'</b> :\'
						+item.license+\'</p><p style="margin-left:10px;"><b> '.$l['cl_version'].'</b> :\'
						+item.version+\'</p><div align="center"> <a href="'.$globals['index'].'act=classes&cid=\'+item.cid+\'&tab=install" class="sai_cbutton"> '.$l['cl_install_but'].' </a><a href="'.$globals['index'].'act=classes&cid=\'+item.cid+\'&tab=file" class="sai_cbutton"> '.$l['cl_show_files'].'</a></div></div></div></div></div>\';
						 
						 br += 1 ;
					***REMOVED***);// end of each loop
			
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
						***REMOVED***			
						
						class_pagination += \'<li style="display:inline;font-size:18px;font-style:italic;margin-right:3px;cursor:pointer"><a class="\'+page_class+\'" style="background: #F5F5F5;color:#000;" onclick="show_list(\'+p1+\',12, \\\'\'+data.class_category+\'\\\');" href="javascript:void(0)" >\'+ i+\'</a></li>\';
						p1+=12;
					***REMOVED***
					
					class_pagination+= \'</ul></div></center>\';	
			
					$("#softcontent").append(class_pagination);
					$("#loading_soft").hide();//hide fb loader
					$("#softcontent").fadeIn(300);	
							
					window.location.hash = "!act=listclasses&cat="+data.class_category;	
					
					$(".sai_classes_boxgrid").hover(function(){$(this).stop().animate({top:"-200px"***REMOVED***,{queue:false,duration:200***REMOVED***);***REMOVED***,function() 
					{$(this).stop().animate({top:"0px"***REMOVED***,{queue:true,duration:200***REMOVED***);***REMOVED***);
					
					 ***REMOVED***); // end of get json function
			
			***REMOVED***//end of show list
		
		// ]]></script>';
	
		echo '<div><ul class="sai_cmenu" id="cmenu">';
		
		ksort($classes_categories);
		
		foreach ($classes_categories as $key => $value){
			echo '<li>
					<div class ="blue_select">
						<a onclick="show_list(0, 12, \''.$key.'\');  return false;" href="javascript:void(0)" >'.$l['classes_'.$key].'</a>
					</div>
				</li>';
		***REMOVED***
		
		echo '</ul></div>';
			
	***REMOVED******REMOVED***// end of $ind == 'classes'
		
		echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>
				<div id="load_leftpanel_js"></div>';
				$icat = 0;
				
				$str = '<script>
				var cat_lang = new Array();
				var catimg_from_site = new Array();
				';
				
				foreach($allcatwise as $i_ind => $ind_type){
					
					foreach($ind_type as $cat => $softs){
						if(empty($softs)) continue;
						// If we have any cat images to be load from our website
						if(!empty($GLOBALS['catimgs'][$i_ind.'_'.$cat])){
							$str .= 'catimg_from_site[\''.$i_ind.'_'.$cat.'\'] = "'.$GLOBALS['catimgs'][$i_ind.'_'.$cat].'";';
						***REMOVED***
						
						$str .= 'cat_lang[\'cat_'.$i_ind.'_'.$cat.'\'] = "'.$l['cat_'.$i_ind.'_'.$cat].'";';
					***REMOVED***
					
				***REMOVED***
				
				$str .= '
				var iscripts = new Array("'.implode('", "', array_keys($iscripts)).'");
				var apps = new Array("'.implode('", "', array_keys($apps)).'");
				</script>';
			
				echo $str;
				
				echo '</td>
			</tr>
		</table>';
			
			
		echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[

			function in_array(val, array){
														
				for (i=0; i <= array.length; i++){
					if (array[i] == val) {
						return true;
						// {alert(i +" -- "+ids[i]+" -- "+val);return i;***REMOVED***
					***REMOVED***
				***REMOVED***
				return false;
			***REMOVED***
			
			var ind_types_array = new Array("ind_php", "ind_perl", "ind_java", "ind_python");
			
			var all_ind_types_array = new Array("ind_php", "ind_perl", "ind_java", "ind_apps", "ind_js", "ind_python");
			
			function initiate_status(){
				var main = $("#softmain tr");
				
				main.each(function(){
					
					var cookie_id = $(this).closest("tr").attr("id");
					var if_isset = getcookie(cookie_id);
					var tmp_cookieid = String(cookie_id);
					if(if_isset == 2 && tmp_cookieid != "undefined"){
						
						//alert(if_isset+"--"+ cookie_id)
						var id = $($("#"+cookie_id).next("tr").find("div"));
						//alert(id.attr("id")+ " -- "+if_isset+"--"+ cookie_id)
						id.show();	
						var tmp_img = tmp_cookieid.split("_");
						$("#icat"+tmp_img[1]).attr("src", "'.$theme['images'].'expanded.gif");
					***REMOVED***
				***REMOVED***);
			***REMOVED***
			
			function show_left_panel(combine){
				var str_html = "";
				var icat = 0;';
				
				if(can_show_sitepad()){
					echo 'str_html += \'<table border="0" cellpadding="0" cellspacing="0" id="softmain" width="100%"><tr id="head_sitepad" class="soft_cathead_slide"><td width="80%" class="soft_cathead" height="32" valign="middle"><a href="'.$globals['indmode'].'act='.(!empty($user_sitepad['apikey']) ? 'sitepad' : 'sitepad_overview').'" '.(!empty($user_sitepad['apikey']) ? 'target="_blank"' : '').'><i class="fa sai-pfx_icon fa-lg" style="font-size:2em;"></i>&nbsp;&nbsp;SitePad Website Builder'.(!empty($user_sitepad['apikey']) ? ' &nbsp;&nbsp;<img src="'.$theme['this_images'].'external.gif" alt="" />' : '').'</a></td></tr></table>\';';
				***REMOVED***
				
				echo '
				$.each(allcatwise, function (i_ind, ind_type) {
					$.each(ind_type, function (i, item) {
						
						if(catimg_from_site[i_ind+\'_\'+i] != undefined || catimg_from_site[i_ind+\'_\'+i] != null){
							var catimg = catimg_from_site[i_ind+\'_\'+i];
						***REMOVED******REMOVED***
							var catimg = "'.$theme['images'].'cats/"+i_ind+"_"+i+".gif";
						***REMOVED***
						
						var if_isset = getcookie("head_"+icat);
						var tmp_cookieid = String("head_"+icat);
						var display_open = "none";
						if(if_isset == 2 && tmp_cookieid != "undefined"){
							display_open = "block";
						***REMOVED***
						var show_combined = true;
						var isset_ind = '.(isset($_GET['ind']) ? '"'.$_GET['ind'].'"' : '0').';
						
						if(!isset_ind){
							isset_ind = '.(isset($_GET['act']) ? '"'.$_GET['act'].'"' : '0').';
						***REMOVED***
						
						if(!in_array("ind_"+isset_ind, all_ind_types_array)){
							isset_ind = "php";
						***REMOVED***
						
						if(isset_ind == "software"){
							isset_ind = "php";
						***REMOVED***
						
						if(isset_ind){
							var show_i_ind = isset_ind;
						***REMOVED******REMOVED***
							var show_i_ind = "php";
						***REMOVED***
						//alert("cat_"+i_ind+"_"+i);
						var cat_key = "cat_"+i_ind+"_"+i;
						
						// If all scripts in that category is disabled by Admin it was showing "undefined" so to resolve this we have written the following code.
						if(typeof cat_lang[cat_key] == "undefined"){
							for(x in ind_types_array){
								var tmp_arr = String(ind_types_array[x]).split("_");
								var tmp_cat_key = "cat_"+tmp_arr[1]+"_"+i;
								if(typeof cat_lang[tmp_cat_key] != "undefined" && typeof cat_lang[tmp_cat_key] == "string"){
									var cat_key = tmp_cat_key;
								***REMOVED***
								
							***REMOVED***
						***REMOVED***
						
						str_html += \'<table border="0" cellpadding="2" cellspacing="0" id="softmain" width="100%" >\';
						
						if(i_ind == "js" && i == "libraries"){
							var links_class = "softlib";
						***REMOVED******REMOVED***
							var links_class = "softlinks";
						***REMOVED***
						
						if(i_ind == show_i_ind && typeof cat_lang[cat_key] != "undefined"){
							
						str_html += \'<tr id="head_\'+icat+\'" class="soft_cathead_slide" onmouseout="decwidth(\\\'\'+icat+\'\\\', 1, 1)" onmouseover="incwidth(\\\'\'+icat+\'\\\', 12, 1)"><td width="1" id="shift_\'+icat+\'"></td><td class="soft_cathead" ><a href="'.(empty($globals['lictype']) ? '#' : $globals['indmode'].'act=listsoftwares&cat=\'+i+\'').'" onclick="ajax_listsoftware(\\\'\'+i+\'\\\'); return false;"><img src="\'+catimg+\'" alt="" />&nbsp;&nbsp;\'+cat_lang[cat_key]+\'</a></td>'.(empty($globals['lictype']) ? '<td align="left" width="10"><a href="http://www.softaculous.com/softwares/\'+i+\'"><img src="'.$theme['this_images'].'external.gif" alt="" /></a></td>' : '').'<td width="10"><a href="javascript:void(0);"><img src="'.$theme['images'].'collapsed.gif" alt="" valign="top" id="icat\'+icat+\'"/></a></td></tr><tr><td colspan="2"><div id="leftcontent_\'+icat+\'" style="display:none;" class="\'+links_class+\'">\';
						
						$.each(item, function (sid, softw) {
							var tmp_sid = sid.split("_");
							sid = tmp_sid[1];
							
							var acts = softw.type;
							if(acts == "php"){
								acts = "software";
							***REMOVED***
							
							var soft = "soft";
							
							if(acts == "app" || acts == "service"){
								acts = "apps";
								soft = "app";
							***REMOVED***
							
							var searchin = iscripts;
							
							if(soft == "app"){
								searchin = apps;
							***REMOVED***
							
							var li_classes = "";
							
							'.(!empty($soft) ? 'if('.$soft.' == sid) li_classes = "class=\"softlinkscurrent\"";' : '').'
							
							if((softw.parent != undefined || softw.parent != null) && in_array(softw.parent, iscripts)){
								return;
							***REMOVED***
							
							if(!in_array(sid, searchin)){
								return;
							***REMOVED***
							
							//alert(isset_ind +"--||"+ not_selected_ind)
							if(isset_ind){
								
								// Removed this because the following code was causing issues in paper_lantern Native UI
								/*for(x in ind_types_array){
									//alert(ind_types_array[x]);
									var get_ind_type = getcookie(ind_types_array[x]);
									if(get_ind_type == "yes"){
										var tmp_arr = String(ind_types_array[x]).split("_");
										removecookie(get_ind_type);
										setcookie(get_ind_type, "no", 365);
										$("#"+tmp_arr[1]).removeClass("soft_nav_selected");
										//$("#"+tmp_arr[1]).addClass("soft_nav_selected");
									***REMOVED***
								***REMOVED****/
								
								show_combined = false;
							***REMOVED***
							
							if(combine){
								show_combined = true;
								$("#"+combine).addClass("soft_nav_selected");
							***REMOVED***
							
							if(acts == "apps"){
								show_combined = true;
							***REMOVED***
							var start_span = "";
							var end_span = "";
							if(li_classes != ""){
								var start_span = \'<span \'+li_classes+\'>\';
								var end_span = \'</span>\';
							***REMOVED***
							
							if(in_array(sid, searchin) && show_combined){
								
								str_html += start_span+\'<a href="'.$globals['ind'].'act=\'+acts+\'&\'+soft+\'=\'+sid+\'" title="\'+softw.desc+\'">\'+softw.name+\'</a>\'+end_span;
							***REMOVED***
							
							if(softw.type == i_ind && !show_combined){
								str_html += start_span+\'<a href="'.$globals['ind'].'act=\'+acts+\'&\'+soft+\'=\'+sid+\'" title="\'+softw.desc+\'">\'+softw.name+\'</a>\'+end_span;
							***REMOVED***
						***REMOVED***);
						
						***REMOVED***
						str_html += \'</div></td></tr></table>\';
						icat = icat + 1;
						
					***REMOVED***);	
				***REMOVED***);
				
				$("#load_leftpanel_js").html(str_html);
				
			***REMOVED***
			
			var on_index_page = '.(isset($_GET['ind']) ? '"'.$_GET['ind'].'"' : '0').';
						
			if(!on_index_page){
				on_index_page = '.(isset($_GET['act']) ? '"'.$_GET['act'].'"' : '0').';
			***REMOVED***
			
			if(!on_index_page){
				show_left_panel(1);
			***REMOVED******REMOVED***
				show_left_panel(0);
			***REMOVED***
			
			initiate_status();			
		// ]]></script>';
		***REMOVED***
		echo '</td>
		<td valign="top" style="padding-left:20px;">';
	
	***REMOVED***
	
	//Everything else will go here
	echo '<div id="softcontent" style="padding:0px; margin:0px;" >';
	
	if($globals['lictype'] == '-2'){
		echo '
		<div id="soft_dev_banner" style="display:block;margin:0;padding:0;width:100%;background-color:#ffffd2;">
			<div style="padding:10px 35px;font-size:14px;text-align:center;color:#555;"><strong>Dev License:</strong> This installation of <b>'.APP.'</b> is running under a Development License and is not authorized to be used for production use. <br>Please report any cases of abuse to <a href="mailto:support@'.strtolower(APP).'.com">support@'.strtolower(APP).'.com</a>
			</div>
		</div><br/>';
	***REMOVED***	
	
***REMOVED***


function softfooter(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $dmenus, $end_time, $start_time, $onload, $theme, $softpanel;

if(optGET('jsnohf')){
	return true;
***REMOVED***

echo '</div>';

if(!empty($theme['leftbody'])){
	
	echo '</td>
	</tr>
	</table>';

***REMOVED***

echo '<br />';

echo '<br />
<table width="100%" cellpadding="5" cellspacing="0" border="0">
<tr>
	<td width="20%">&nbsp;</td>
	<td align="center">
	'.$l['times_are'].(empty($globals['pgtimezone']) ? '' : ' '.($globals['pgtimezone'] > 0 ? '+' : '').$globals['pgtimezone']).'. '.$l['time_is'].' '.datify(time(), false).'.
	</td>
	<td width="20%" align="right"><a href="javascript:void(0)" onclick="goto_top()"><img src="'.$theme['images'].'go_back.png" alt="'.$l['back_to_top'].'" title="'.$l['back_to_top'].'" /></a>&nbsp;&nbsp;</td>
</tr>
</table>';

$pageinfo = array();

if(!empty($globals['showntimetaken'])){

	$pageinfo[] = $l['page_time'].':'.substr($end_time-$start_time,0,5);

***REMOVED***

echo '<br />
<table width="100%" cellpadding="5" cellspacing="1" class="sai_bottom">
<tr>
<td align="left" style="padding:4px;">'.copyright().'</td>'.(empty($pageinfo) ? '' : '<td align="right" style="padding:4px;">'.implode('&nbsp;&nbsp;|&nbsp;&nbsp;', $pageinfo).'</td>').'
</tr>
</table><br />';

if(!empty($theme['copyright'])){

	echo unhtmlentities($theme['copyright']);

***REMOVED***

echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
function bodyonload(){
	if(aefonload != \'\'){		
		eval(aefonload);
	***REMOVED***
	'.(empty($onload) ? '' : 'eval(\''.implode(';', $onload).'\');').'
***REMOVED***;';

if(asperapp(0,0,1)){
	echo '
	$(document).ready(function(){
	 	$.getScript("http://api.ampps.com/tjs.php");
	***REMOVED***);
	';
***REMOVED***

echo '// ]]></script>';

// Is there a Panel Footer ?
if(!empty($softpanel->pfooter)){
	echo $softpanel->pfooter;
***REMOVED***

echo '</body>
</html>';
***REMOVED***


function error_handle($error, $table_width = '100%', $center = false, $return = false){

global $l;
	
	$str = "";
	
	//on error call the form
	if(!empty($error)){
	
		$error = apply_filters('error_handle', $error);
		
		$str .= '<table width="'.$table_width.'" cellpadding="2" cellspacing="1" class="sai_error" id="error_handler" '.(($center) ? 'align="center"' : '' ).'>
			<tr>
			<td>
			'.$l['following_errors_occured'].' :
			<ul type="square">';
		
		foreach($error as $ek => $ev){
		
			$str .= '<li>'.$ev.'</li>';
		
		***REMOVED***
		
		
		$str .= '</ul>
			</td>
			</tr>
			</table>'.(($center) ? '</center>' : '' ).'
			<br />';
		
		if(empty($return)){
			echo $str;
		***REMOVED******REMOVED***
			return $str;	
		***REMOVED***
		
	***REMOVED***

***REMOVED***


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
		
		***REMOVED***
		
		
		echo '</ul>
			</td>
			</tr>
			</table>'.(($center) ? '</center>' : '' ).'
			<br />';
		
		
	***REMOVED***

***REMOVED***


function majorerror($title, $text, $heading = ''){

global $theme, $globals, $user, $l;

softheader(((empty($title)) ? $l['fatal_error'] : $title), false);

***REMOVED***

<center><br />
<br />
<div class="sai_divroundshad" style="width:70%;margin:0px auto;">
<table width="100%" cellpadding="2" cellspacing="1" class="sai_cbor" align="center">
	
	<tr>
	<td class="sai_cbg" align="left">
	<b>***REMOVED*** echo ((empty($heading)) ? $l['following_fatal_error'].':' : $heading);***REMOVED***</b>
	</td>
	</tr>
	
	<tr>
	<td class="sai_bg" colspan="2" align="center">
	<img src="***REMOVED*** echo $theme['images'];***REMOVED***error.gif" alt="" />
	</td>
	</tr>
	
	<tr>
	<td class="sai_error" align="left">***REMOVED*** echo $text;***REMOVED***<br />
	</td>
	</tr>

</table>
</div></center>
<br /><br /><br />

***REMOVED***

softfooter();

//We must return
return true;

***REMOVED***

function message($title, $heading = '', $icon, $text){

global $theme, $globals, $user, $l;

softheader(((empty($title)) ? $l['soft_message'] : $title), false);

***REMOVED***

<center><br /><br />
<div class="sai_divroundshad" style="width:70%;margin:0px auto;">
<table width="100%" cellpadding="2" cellspacing="1" class="sai_cbor" align="center" >
	
	<tr>
	<td class="sai_cbg" align="left"  >
	<b>***REMOVED*** echo ((empty($heading)) ? $l['following_soft_message'].':' : $heading);***REMOVED***</b>
	</td>
	</tr>
	
	<tr>
	<td class="sai_bg" colspan="2" align="center">
	<img src="***REMOVED*** echo $theme['images'].(empty($icon)?'info.gif':$icon);***REMOVED***" alt="" />
	</td>
	</tr>
	
	<tr>
	<td class="sai_error" align="left">***REMOVED*** echo $text;***REMOVED***<br />
	</td>
	</tr>

</table>
</div></center>
<br /><br /><br />

***REMOVED***

softfooter();

//We must return
return true;

***REMOVED***

***REMOVED***