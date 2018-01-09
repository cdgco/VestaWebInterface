***REMOVED*** if (file_exists( '../includes/config.php' )) { header( 'Location: ../index.php' );***REMOVED***; ***REMOVED***
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Install Vesta Web Interface</title>
  <script src="https://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>


  
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css'>

      <link rel="stylesheet" href="css/style.css">

  
</head>

<body><br><br>
  <div class="container">

<form class="form-horizontal" method="post" action="install.php">
<fieldset>

<!-- Form Name -->
<legend>Install Vesta Web Interface</legend>
<br>
        <center>
    <h3>Server Configuration</h3>
</center><br>
    <input type="hidden" value="1" name="x"/>
<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="timezone">Server Timezone</label>
  <div class="col-md-4">
    <select id="timezone" name="TIMEZONE" class="form-control">
      <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
<option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
<option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
<option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
<option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
<option value="America/Anchorage">(GMT-09:00) Alaska</option>
<option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
<option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
<option value="America/Los_Angeles" selected>(GMT-08:00) Pacific Time (US & Canada)</option>
<option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
<option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
<option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
<option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
<option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
<option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
<option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
<option value="America/Havana">(GMT-05:00) Cuba</option>
<option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
<option value="America/Caracas">(GMT-04:30) Caracas</option>
<option value="America/Santiago">(GMT-04:00) Santiago</option>
<option value="America/La_Paz">(GMT-04:00) La Paz</option>
<option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
<option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
<option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
<option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
<option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
<option value="America/Araguaina">(GMT-03:00) UTC-3</option>
<option value="America/Montevideo">(GMT-03:00) Montevideo</option>
<option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
<option value="America/Godthab">(GMT-03:00) Greenland</option>
<option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
<option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
<option value="Atlantic/Azores">(GMT-01:00) Azores</option>
<option value="UTC">(UTC) Universal Time Coordinated</option>
<option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
<option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
<option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
<option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
<option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
<option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
<option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
<option value="Asia/Beirut">(GMT+02:00) Beirut</option>
<option value="Africa/Cairo">(GMT+02:00) Cairo</option>
<option value="Asia/Gaza">(GMT+02:00) Gaza</option>
<option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
<option value="Europe/Minsk">(GMT+02:00) Minsk</option>
<option value="Asia/Damascus">(GMT+02:00) Syria</option>
<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
<option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
<option value="Asia/Tehran">(GMT+03:30) Tehran</option>
<option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
<option value="Asia/Kabul">(GMT+04:30) Kabul</option>
<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
<option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
<option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
<option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
<option value="Australia/Perth">(GMT+08:00) Perth</option>
<option value="Australia/Eucla">(GMT+08:45) Eucla</option>
<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
<option value="Asia/Seoul">(GMT+09:00) Seoul</option>
<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
<option value="Australia/Darwin">(GMT+09:30) Darwin</option>
<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
<option value="Australia/Hobart">(GMT+10:00) Hobart</option>
<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
<option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
<option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
<option value="Asia/Magadan">(GMT+11:00) Magadan</option>
<option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
<option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
<option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
<option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
<option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
<option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Site Name</label>  
  <div class="col-md-4">
  <input id="textinput" name="SITENAME" type="text" placeholder="My Host" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="THEME">Theme</label>
  <div class="col-md-4">
    <select id="THEME" name="THEME" class="form-control">
      <option value="default">Default</option>
      <option value="blue">Blue</option>
      <option value="purple">Purple</option>
      <option value="orange">Orange</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="VESTA_HOST_ADDRESS">Vesta Host Address</label>  
  <div class="col-md-4">
  <input id="VESTA_HOST_ADDRESS" name="VESTA_HOST_ADDRESS" type="text" placeholder="myhost.com or 12.34.56.78" class="form-control input-md" required="">
  <span class="help-block">VestaCP Host URL or IP Address</span>  
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="VESTA_SSL_ENABLED">Vesta SSL</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="VESTA_SSL_ENABLED-0">
      <input type="checkbox" name="VESTA_SSL_ENABLED" id="VESTA_SSL_ENABLED-0" checked>
      Enabled
    </label>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="VESTA_PORT">Vesta Port</label>  
  <div class="col-md-4">
  <input id="VESTA_PORT" name="VESTA_PORT" type="text" value="8083" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="VESTA_ADMIN_UNAME">Vesta Admin Username</label>  
  <div class="col-md-4">
  <input id="VESTA_ADMIN_UNAME" name="VESTA_ADMIN_UNAME" type="text" value="admin" class="form-control input-md" required="">
    
  </div>
</div>
    <!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="VESTA_ADMIN_PW">Vesta Admin Password</label>
  <div class="col-md-4">
    <input id="VESTA_ADMIN_PW" name="VESTA_ADMIN_PW" type="password" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>
    <!-- Multiple Checkboxes -->
<div class="form-group">
  <label class="col-md-4 control-label" for="ENABLE_SECTIONS">Enable / Disable Sections</label>
  <div class="col-md-4">
  <div class="checkbox">
    <label for="ENABLE_SECTIONS-0">
      <input type="checkbox" name="ENABLE_WEB" id="ENABLE_SECTIONS-0" checked>
      Web Enabled
    </label>
	</div>
  <div class="checkbox">
    <label for="ENABLE_SECTIONS-1">
      <input type="checkbox" name="ENABLE_DNS" id="ENABLE_SECTIONS-1" checked>
      DNS Enabled
    </label>
	</div>
  <div class="checkbox">
    <label for="ENABLE_SECTIONS-2">
      <input type="checkbox" name="ENABLE_MAIL" id="ENABLE_SECTIONS-2" checked>
      Mail Enabled
    </label>
	</div>
  <div class="checkbox">
    <label for="ENABLE_SECTIONS-3">
      <input type="checkbox" name="ENABLE_DB" id="ENABLE_SECTIONS-3" checked>
      Database Enabled
    </label>
	</div>
  <div class="checkbox">
    <label for="ENABLE_SECTIONS-4">
      <input type="checkbox" name="ENABLE_OLDCPURL" id="ENABLE_SECTIONS-4" checked>
      Link to Old CP Enabled
    </label>
	</div>
  </div>
</div>
    <center><br>
    <h3>Optional Links</h3>
</center><br>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="FTP_URL">FTP Client URL</label>  
  <div class="col-md-4">
  <input id="FTP_URL" name="FTP_URL" type="text" placeholder="http://net2ftp.com" class="form-control input-md">
          <span class="help-block">Leave blank for default or enter 'disabled' to disable.</span> 
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="WEBMAIL_URL">Webmail URL</label>  
  <div class="col-md-4">
  <input id="WEBMAIL_URL" name="WEBMAIL_URL" type="text" placeholder="http://webmail.myhost.com" class="form-control input-md">
    <span class="help-block">Leave blank for default or enter 'disabled' to disable.</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="PHPMYADMIN_URL">phpMyAdmin URL</label>  
  <div class="col-md-4">
  <input id="PHPMYADMIN_URL" name="PHPMYADMIN_URL" type="text" placeholder="http://phpmyadmin.myhost.com" class="form-control input-md">
        <span class="help-block">Leave blank for default or enter 'disabled' to disable.</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="PHPPGADMIN_URL">phpPgAdmin URL</label>  
  <div class="col-md-4">
  <input id="PHPPGADMIN_URL" name="PHPPGADMIN_URL" type="text" placeholder="http://phppgadmin.myhost.com" class="form-control input-md">
        <span class="help-block">Leave blank for default or enter 'disabled' to disable.</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="SUPPORT_URL">Support URL</label>  
  <div class="col-md-4">
  <input id="SUPPORT_URL" name="SUPPORT_URL" type="text" placeholder="http://mysupportsite.com" class="form-control input-md">
        <span class="help-block">Leave blank or enter 'disabled' to disable.</span>  
  </div>
</div>
    <center><br>
    <h3>Optional Integrations</h3>
</center><br><br>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="GOOGLE_ANALYTICS_ID">Google Analytics ID</label>  
  <div class="col-md-4">
  <input id="GOOGLE_ANALYTICS_ID" name="GOOGLE_ANALYTICS_ID" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="INTERAKT_APP_ID">Interakt App ID</label>  
  <div class="col-md-4">
  <input id="INTERAKT_APP_ID" name="INTERAKT_APP_ID" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="INTERAKT_API_KEY">Interakt API Key</label>  
  <div class="col-md-4">
  <input id="INTERAKT_API_KEY" name="INTERAKT_API_KEY" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
</form>
<br><br><br>

</div>
    
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
<script src="js/index.js"></script>
</body>
</html>
