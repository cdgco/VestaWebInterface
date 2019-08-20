<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2018 Carter Roeser <carter@cdgtech.one>
* https://cdgco.github.io/VestaWebInterface
*
* Vesta Web Interface is free software: you can redistribute it and/or modify
* it under the terms of version 3 of the GNU General Public License as published 
* by the Free Software Foundation.
*
* Vesta Web Interface is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Vesta Web Interface.  If not, see
* <https://github.com/cdgco/VestaWebInterface/blob/master/LICENSE>.
*
*/

if (!file_exists( '../includes/config.php' )) { header('step2.php'); exit(); } 
require '../includes/arrays.php'; include("../includes/version.php");
?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Install Vesta Web Interface</title>
        <link rel='stylesheet prefetch' href='../plugins/components/bootstrap/dist/css/bootstrap.min.css'>
        <link rel='stylesheet prefetch' href='../plugins/components/bootstrap/dist/css/bootstrap-theme.min.css'>
        <link rel='stylesheet prefetch' href='../plugins/components/bootstrapvalidator/bootstrapValidator.css'>
        <style>
        #success_message{ display: none;}
        </style>
    </head>

    <body><br><br>
        <div class="container">

            <form class="form-horizontal" id="form" method="post" action="install.php">
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
                                <option value="Pacific/Midway">(UTC-11:00) Midway Island</option>
                                <option value="Pacific/Samoa">(UTC-11:00) Samoa</option>
                                <option value="Pacific/Honolulu">(UTC-10:00) Hawaii</option>
                                <option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
                                <option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
                                <option value="US/Alaska">(UTC-09:00) Alaska</option>
                                <option value="America/Los_Angeles" selected="selected">(UTC-08:00) Pacific Time (US &amp; Canada)</option>
                                <option value="America/Tijuana">(UTC-08:00) Tijuana</option>
                                <option value="US/Arizona">(UTC-07:00) Arizona</option>
                                <option value="America/Chihuahua">(UTC-07:00) Chihuahua</option>
                                <option value="America/Chihuahua">(UTC-07:00) La Paz</option>
                                <option value="America/Mazatlan">(UTC-07:00) Mazatlan</option>
                                <option value="US/Mountain">(UTC-07:00) Mountain Time (US &amp; Canada)</option>
                                <option value="America/Managua">(UTC-06:00) Central America</option>
                                <option value="US/Central">(UTC-06:00) Central Time (US &amp; Canada)</option>
                                <option value="America/Mexico_City">(UTC-06:00) Guadalajara</option>
                                <option value="America/Mexico_City">(UTC-06:00) Mexico City</option>
                                <option value="America/Monterrey">(UTC-06:00) Monterrey</option>
                                <option value="Canada/Saskatchewan">(UTC-06:00) Saskatchewan</option>
                                <option value="America/Bogota">(UTC-05:00) Bogota</option>
                                <option value="US/Eastern">(UTC-05:00) Eastern Time (US &amp; Canada)</option>
                                <option value="US/East-Indiana">(UTC-05:00) Indiana (East)</option>
                                <option value="America/Lima">(UTC-05:00) Lima</option>
                                <option value="America/Bogota">(UTC-05:00) Quito</option>
                                <option value="Canada/Atlantic">(UTC-04:00) Atlantic Time (Canada)</option>
                                <option value="America/Caracas">(UTC-04:30) Caracas</option>
                                <option value="America/La_Paz">(UTC-04:00) La Paz</option>
                                <option value="America/Santiago">(UTC-04:00) Santiago</option>
                                <option value="Canada/Newfoundland">(UTC-03:30) Newfoundland</option>
                                <option value="America/Sao_Paulo">(UTC-03:00) Brasilia</option>
                                <option value="America/Argentina/Buenos_Aires">(UTC-03:00) Buenos Aires</option>
                                <option value="America/Argentina/Buenos_Aires">(UTC-03:00) Georgetown</option>
                                <option value="America/Godthab">(UTC-03:00) Greenland</option>
                                <option value="America/Noronha">(UTC-02:00) Mid-Atlantic</option>
                                <option value="Atlantic/Azores">(UTC-01:00) Azores</option>
                                <option value="Atlantic/Cape_Verde">(UTC-01:00) Cape Verde Is.</option>
                                <option value="Africa/Casablanca">(UTC+00:00) Casablanca</option>
                                <option value="Europe/London">(UTC+00:00) Edinburgh</option>
                                <option value="Etc/Greenwich">(UTC+00:00) Greenwich Mean Time : Dublin</option>
                                <option value="Europe/Lisbon">(UTC+00:00) Lisbon</option>
                                <option value="Europe/London">(UTC+00:00) London</option>
                                <option value="Africa/Monrovia">(UTC+00:00) Monrovia</option>
                                <option value="UTC">(UTC+00:00) UTC</option>
                                <option value="Europe/Amsterdam">(UTC+01:00) Amsterdam</option>
                                <option value="Europe/Belgrade">(UTC+01:00) Belgrade</option>
                                <option value="Europe/Berlin">(UTC+01:00) Berlin</option>
                                <option value="Europe/Berlin">(UTC+01:00) Bern</option>
                                <option value="Europe/Bratislava">(UTC+01:00) Bratislava</option>
                                <option value="Europe/Brussels">(UTC+01:00) Brussels</option>
                                <option value="Europe/Budapest">(UTC+01:00) Budapest</option>
                                <option value="Europe/Copenhagen">(UTC+01:00) Copenhagen</option>
                                <option value="Europe/Ljubljana">(UTC+01:00) Ljubljana</option>
                                <option value="Europe/Madrid">(UTC+01:00) Madrid</option>
                                <option value="Europe/Paris">(UTC+01:00) Paris</option>
                                <option value="Europe/Prague">(UTC+01:00) Prague</option>
                                <option value="Europe/Rome">(UTC+01:00) Rome</option>
                                <option value="Europe/Sarajevo">(UTC+01:00) Sarajevo</option>
                                <option value="Europe/Skopje">(UTC+01:00) Skopje</option>
                                <option value="Europe/Stockholm">(UTC+01:00) Stockholm</option>
                                <option value="Europe/Vienna">(UTC+01:00) Vienna</option>
                                <option value="Europe/Warsaw">(UTC+01:00) Warsaw</option>
                                <option value="Africa/Lagos">(UTC+01:00) West Central Africa</option>
                                <option value="Europe/Zagreb">(UTC+01:00) Zagreb</option>
                                <option value="Europe/Athens">(UTC+02:00) Athens</option>
                                <option value="Europe/Bucharest">(UTC+02:00) Bucharest</option>
                                <option value="Africa/Cairo">(UTC+02:00) Cairo</option>
                                <option value="Africa/Harare">(UTC+02:00) Harare</option>
                                <option value="Europe/Helsinki">(UTC+02:00) Helsinki</option>
                                <option value="Europe/Istanbul">(UTC+02:00) Istanbul</option>
                                <option value="Asia/Jerusalem">(UTC+02:00) Jerusalem</option>
                                <option value="Europe/Helsinki">(UTC+02:00) Kyiv</option>
                                <option value="Africa/Johannesburg">(UTC+02:00) Pretoria</option>
                                <option value="Europe/Riga">(UTC+02:00) Riga</option>
                                <option value="Europe/Sofia">(UTC+02:00) Sofia</option>
                                <option value="Europe/Tallinn">(UTC+02:00) Tallinn</option>
                                <option value="Europe/Vilnius">(UTC+02:00) Vilnius</option>
                                <option value="Asia/Baghdad">(UTC+03:00) Baghdad</option>
                                <option value="Asia/Kuwait">(UTC+03:00) Kuwait</option>
                                <option value="Europe/Minsk">(UTC+03:00) Minsk</option>
                                <option value="Africa/Nairobi">(UTC+03:00) Nairobi</option>
                                <option value="Asia/Riyadh">(UTC+03:00) Riyadh</option>
                                <option value="Europe/Volgograd">(UTC+03:00) Volgograd</option>
                                <option value="Asia/Tehran">(UTC+03:30) Tehran</option>
                                <option value="Asia/Muscat">(UTC+04:00) Abu Dhabi</option>
                                <option value="Asia/Baku">(UTC+04:00) Baku</option>
                                <option value="Europe/Moscow">(UTC+04:00) Moscow</option>
                                <option value="Asia/Muscat">(UTC+04:00) Muscat</option>
                                <option value="Europe/Moscow">(UTC+04:00) St. Petersburg</option>
                                <option value="Asia/Tbilisi">(UTC+04:00) Tbilisi</option>
                                <option value="Asia/Yerevan">(UTC+04:00) Yerevan</option>
                                <option value="Asia/Kabul">(UTC+04:30) Kabul</option>
                                <option value="Asia/Karachi">(UTC+05:00) Islamabad</option>
                                <option value="Asia/Karachi">(UTC+05:00) Karachi</option>
                                <option value="Asia/Tashkent">(UTC+05:00) Tashkent</option>
                                <option value="Asia/Calcutta">(UTC+05:30) Chennai</option>
                                <option value="Asia/Kolkata">(UTC+05:30) Kolkata</option>
                                <option value="Asia/Calcutta">(UTC+05:30) Mumbai</option>
                                <option value="Asia/Calcutta">(UTC+05:30) New Delhi</option>
                                <option value="Asia/Calcutta">(UTC+05:30) Sri Jayawardenepura</option>
                                <option value="Asia/Katmandu">(UTC+05:45) Kathmandu</option>
                                <option value="Asia/Almaty">(UTC+06:00) Almaty</option>
                                <option value="Asia/Dhaka">(UTC+06:00) Astana</option>
                                <option value="Asia/Dhaka">(UTC+06:00) Dhaka</option>
                                <option value="Asia/Yekaterinburg">(UTC+06:00) Ekaterinburg</option>
                                <option value="Asia/Rangoon">(UTC+06:30) Rangoon</option>
                                <option value="Asia/Bangkok">(UTC+07:00) Bangkok</option>
                                <option value="Asia/Bangkok">(UTC+07:00) Hanoi</option>
                                <option value="Asia/Jakarta">(UTC+07:00) Jakarta</option>
                                <option value="Asia/Novosibirsk">(UTC+07:00) Novosibirsk</option>
                                <option value="Asia/Hong_Kong">(UTC+08:00) Beijing</option>
                                <option value="Asia/Chongqing">(UTC+08:00) Chongqing</option>
                                <option value="Asia/Hong_Kong">(UTC+08:00) Hong Kong</option>
                                <option value="Asia/Krasnoyarsk">(UTC+08:00) Krasnoyarsk</option>
                                <option value="Asia/Kuala_Lumpur">(UTC+08:00) Kuala Lumpur</option>
                                <option value="Australia/Perth">(UTC+08:00) Perth</option>
                                <option value="Asia/Singapore">(UTC+08:00) Singapore</option>
                                <option value="Asia/Taipei">(UTC+08:00) Taipei</option>
                                <option value="Asia/Ulan_Bator">(UTC+08:00) Ulaan Bataar</option>
                                <option value="Asia/Urumqi">(UTC+08:00) Urumqi</option>
                                <option value="Asia/Irkutsk">(UTC+09:00) Irkutsk</option>
                                <option value="Asia/Tokyo">(UTC+09:00) Osaka</option>
                                <option value="Asia/Tokyo">(UTC+09:00) Sapporo</option>
                                <option value="Asia/Seoul">(UTC+09:00) Seoul</option>
                                <option value="Asia/Tokyo">(UTC+09:00) Tokyo</option>
                                <option value="Australia/Adelaide">(UTC+09:30) Adelaide</option>
                                <option value="Australia/Darwin">(UTC+09:30) Darwin</option>
                                <option value="Australia/Brisbane">(UTC+10:00) Brisbane</option>
                                <option value="Australia/Canberra">(UTC+10:00) Canberra</option>
                                <option value="Pacific/Guam">(UTC+10:00) Guam</option>
                                <option value="Australia/Hobart">(UTC+10:00) Hobart</option>
                                <option value="Australia/Melbourne">(UTC+10:00) Melbourne</option>
                                <option value="Pacific/Port_Moresby">(UTC+10:00) Port Moresby</option>
                                <option value="Australia/Sydney">(UTC+10:00) Sydney</option>
                                <option value="Asia/Yakutsk">(UTC+10:00) Yakutsk</option>
                                <option value="Asia/Vladivostok">(UTC+11:00) Vladivostok</option>
                                <option value="Pacific/Auckland">(UTC+12:00) Auckland</option>
                                <option value="Pacific/Fiji">(UTC+12:00) Fiji</option>
                                <option value="Pacific/Kwajalein">(UTC+12:00) International Date Line West</option>
                                <option value="Asia/Kamchatka">(UTC+12:00) Kamchatka</option>
                                <option value="Asia/Magadan">(UTC+12:00) Magadan</option>
                                <option value="Pacific/Fiji">(UTC+12:00) Marshall Is.</option>
                                <option value="Asia/Magadan">(UTC+12:00) New Caledonia</option>
                                <option value="Asia/Magadan">(UTC+12:00) Solomon Is.</option>
                                <option value="Pacific/Auckland">(UTC+12:00) Wellington</option>
                                <option value="Pacific/Tongatapu">(UTC+13:00) Nuku'alofa</option>
                            </select>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Site Name</label>  
                        <div class="col-md-4">
                            <input id="sitename" name="SITENAME" type="text" placeholder="My Host" class="form-control input-md" required="">

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
                                <option value="orange">Dark</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="overflow: visible;">
                        <label class="col-md-4 control-label" for="THEME">Default Language</label>
                        <div class="col-md-4">
                            <select id="LANGUAGE" name="LANGUAGE" class="form-control">
                                <option value="<?php print_r($ulang['ar']); ?>"><?php print_r($countries['ar']); ?></option>
                                <option value="<?php print_r($ulang['bs']); ?>"><?php print_r($countries['bs']); ?></option>
                                <option value="<?php print_r($ulang['cn']); ?>>"><?php print_r($countries['cn']); ?></option>
                                <option value="<?php print_r($ulang['cz']); ?>"><?php print_r($countries['cz']); ?></option>
                                <option value="<?php print_r($ulang['da']); ?>"><?php print_r($countries['da']); ?></option>
                                <option value="<?php print_r($ulang['de']); ?>"><?php print_r($countries['de']); ?></option>
                                <option value="<?php print_r($ulang['el']); ?>>"><?php print_r($countries['el']); ?></option>
                                <option value="<?php print_r($ulang['en']); ?>" selected><?php print_r($countries['en']); ?></option>
                                <option value="<?php print_r($ulang['es']); ?>"><?php print_r($countries['es']); ?></option>
                                <option value="<?php print_r($ulang['fa']); ?>"><?php print_r($countries['fa']); ?></option>
                                <option value="<?php print_r($ulang['fi']); ?>"><?php print_r($countries['fi']); ?></option>
                                <option value="<?php print_r($ulang['fr']); ?>"><?php print_r($countries['fr']); ?></option>
                                <option value="<?php print_r($ulang['hu']); ?>"><?php print_r($countries['hu']); ?></option>
                                <option value="<?php print_r($ulang['id']); ?>"><?php print_r($countries['id']); ?></option>
                                <option value="<?php print_r($ulang['it']); ?>"><?php print_r($countries['it']); ?></option>
                                <option value="<?php print_r($ulang['ja']); ?>"><?php print_r($countries['ja']); ?></option>
                                <option value="<?php print_r($ulang['ka']); ?>"><?php print_r($countries['ka']); ?></option>
                                <option value="<?php print_r($ulang['nl']); ?>"><?php print_r($countries['nl']); ?></option>
                                <option value="<?php print_r($ulang['no']); ?>"><?php print_r($countries['no']); ?></option>
                                <option value="<?php print_r($ulang['pl']); ?>"><?php print_r($countries['pl']); ?></option>
                                <option value="<?php print_r($ulang['pt-BR']); ?>"><?php print_r($countries['pt-BR']); ?></option>
                                <option value="<?php print_r($ulang['pt']); ?>"><?php print_r($countries['pt']); ?></option>
                                <option value="<?php print_r($ulang['ro']); ?>"><?php print_r($countries['ro']); ?></option>
                                <option value="<?php print_r($ulang['ru']); ?>"><?php print_r($countries['ru']); ?></option>
                                <option value="<?php print_r($ulang['se']); ?>"><?php print_r($countries['se']); ?></option>
                                <option value="<?php print_r($ulang['tr']); ?>"><?php print_r($countries['tr']); ?></option>
                                <option value="<?php print_r($ulang['tw']); ?>"><?php print_r($countries['tw']); ?></option>
                                <option value="<?php print_r($ulang['ua']); ?>"><?php print_r($countries['ua']); ?></option>
                                <option value="<?php print_r($ulang['vi']); ?>"><?php print_r($countries['vi']); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="DEFAULT_TO_ADMIN">Default to Admin Panel</label>
                        <div class="col-md-4">
                            <label class="checkbox-inline" for="DEFAULT_TO_ADMIN-0">
                                <input type="checkbox" name="DEFAULT_TO_ADMIN" id="DEFAULT_TO_ADMIN-0" checked>
                                Enabled
                            </label>
                            <span class="help-block">Choose whether or not the admin should go to the admin panel by default after login.</span>  
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="VESTA_EMAIL">Email Address</label>  
                        <div class="col-md-4">
                            <input id="VESTA_EMAIL" name="EMAILADDR" type="text" placeholder="name@example.com" class="form-control input-md">
                            <span class="help-block">By entering an email, you may receive alerts regarding the security and status of your installation.</span>  
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="VESTA_HOST_ADDRESS">Vesta Host Address</label>  
                        <div class="col-md-4">
                            <input id="VESTA_HOST_ADDRESS" name="VESTA_HOST_ADDRESS" type="text" placeholder="myhost.com or 12.34.56.78" class="form-control input-md" required="">
                            <span class="help-block">VestaCP Host or IP Address without leading 'http(s)://' or trailing '/'</span>  
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
                                    <input type="checkbox" name="ENABLE_ADMIN" id="ENABLE_SECTIONS-4" checked>
                                    Admin Panel Enabled
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="ENABLE_SECTIONS-5">
                                    <input type="checkbox" name="ENABLE_PROFILE" id="ENABLE_SECTIONS-5" checked>
                                    Profile Page Enabled
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="ENABLE_SECTIONS-6">
                                    <input type="checkbox" name="ENABLE_CRON" id="ENABLE_SECTIONS-6" checked>
                                    Cron Enabled
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="ENABLE_SECTIONS-7">
                                    <input type="checkbox" name="ENABLE_BACKUPS" id="ENABLE_SECTIONS-7" checked>
                                    Backups Enabled
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="ENABLE_SECTIONS-8">
                                    <input type="checkbox" name="ENABLE_NOTIFICATIONS" id="ENABLE_SECTIONS-8">
                                    Notification System Enabled
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="ENABLE_SECTIONS-9">
                                    <input type="checkbox" name="ENABLE_REG" id="ENABLE_SECTIONS-9">
                                    Registrations Enabled
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="ENABLE_SECTIONS-10">
                                    <input type="checkbox" name="ENABLE_SOFTURL" id="ENABLE_SECTIONS-10">
                                    Softaculous Enabled
                                </label>
                            </div>

                            <div class="checkbox">
                                <label for="ENABLE_SECTIONS-11">
                                    <input type="checkbox" name="ENABLE_OLDCPURL" id="ENABLE_SECTIONS-11">
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
                        <label class="col-md-4 control-label" for="PLUGINS">Plugins</label>  
                        <div class="col-md-4">
                            <input id="PLUGINS" name="PLUGINS" type="text" placeholder="ftp,rainloop" class="form-control input-md">
                            <span class="help-block">Comma seperated list of installed plugins.</span>  
                        </div>
                    </div>
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

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="CLOUDFLARE_API_KEY">Cloudflare API Key</label>  
                        <div class="col-md-4">
                            <input id="CLOUDFLARE_API_KEY" name="CLOUDFLARE_API_KEY" type="text" placeholder="" class="form-control input-md">

                        </div>
                    </div>


                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="CLOUDFLARE_EMAIL">Cloudflare Account Email Address</label>  
                        <div class="col-md-4">
                            <input id="CLOUDFLARE_EMAIL" name="CLOUDFLARE_EMAIL" type="email" placeholder="" class="form-control input-md">

                        </div>
                    </div>

                    <!-- Button -->

                </fieldset>
            </form>
            <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton"></label>
                        <div class="col-md-4">
                            <button id="button" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
            <br><br><br>

        </div>

        <script src='../plugins/components/jquery/jquery.min.js'></script>
        <script src='../plugins/components/bootstrap/dist/js/bootstrap.min.js'></script>
        <script src='../plugins/components/bootstrapvalidator/bootstrapValidator.js'></script>
        <script>
        $(document).ready(function(){$("#contact_form").bootstrapValidator({feedbackIcons:{valid:"glyphicon glyphicon-ok",invalid:"glyphicon glyphicon-remove",validating:"glyphicon glyphicon-refresh"},fields:{first_name:{validators:{stringLength:{min:2},notEmpty:{message:"Please supply your first name"}}},last_name:{validators:{stringLength:{min:2},notEmpty:{message:"Please supply your last name"}}},email:{validators:{notEmpty:{message:"Please supply your email address"},emailAddress:{message:"Please supply a valid email address"}}},phone:{validators:{notEmpty:{message:"Please supply your phone number"},phone:{country:"US",message:"Please supply a vaild phone number with area code"}}},address:{validators:{stringLength:{min:8},notEmpty:{message:"Please supply your street address"}}},city:{validators:{stringLength:{min:4},notEmpty:{message:"Please supply your city"}}},state:{validators:{notEmpty:{message:"Please select your state"}}},zip:{validators:{notEmpty:{message:"Please supply your zip code"},zipCode:{country:"US",message:"Please supply a vaild zip code"}}},comment:{validators:{stringLength:{min:10,max:200,message:"Please enter at least 10 characters and no more than 200"},notEmpty:{message:"Please supply a description of your project"}}}}}).on("success.form.bv",function(e){$("#success_message").slideDown({opacity:"show"},"slow"),$("#contact_form").data("bootstrapValidator").resetForm(),e.preventDefault();var s=$(e.target);s.data("bootstrapValidator");$.post(s.attr("action"),s.serialize(),function(e){console.log(e)},"json")})});
        
            <?php 
            
                if(phpversion()){ $phpversion = phpversion(); }
                if(php_uname()){ $operatingsystem = php_uname(); }
            
            ?>
            
        
            
        $("#button").click(function(){
            
        if (document.getElementById('VESTA_EMAIL').value != '') {var VEMAIL= document.getElementById('VESTA_EMAIL').value;} else {var VEMAIL="";}
        if (document.getElementById('GOOGLE_ANALYTICS_ID').value != '') {var GAE="Enabled";} else {var GAE="Disabled";}
        if (document.getElementById('INTERAKT_APP_ID').value != '') {var IAE="Enabled";} else {var IAE="Disabled";}
        if (document.getElementById('CLOUDFLARE_API_KEY').value != '') {var CFE="Enabled";} else {var CFE="Disabled";}
            
          $.post("https://cdgtech.one/installvwi.php",
          {
            url: "<?php echo $_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]; ?>",
            name: document.getElementById("sitename").value,
            theme: document.getElementById("THEME").value,
            language: document.getElementById("LANGUAGE").value,
            timezone: document.getElementById("timezone").value,
            clientip: "<?php echo $_SERVER[REMOTE_ADDR]; ?>",
            serverip: "<?php echo $_SERVER[SERVER_ADDR]; ?>",
            https: "<?php echo $_SERVER[HTTPS]; ?>",
            serverprotocol: "<?php echo $_SERVER[SERVER_PROTOCOL]; ?>",
            time: "<?php echo $_SERVER[REQUEST_TIME]; ?>",
            email: VEMAIL,
            gae: GAE,
            iae: IAE,
            cfe: CFE,
            version: "<?php echo $currentversion; ?>",
            software: "<?php echo $_SERVER[SERVER_SOFTWARE]; ?>",
            agent: "<?php echo $_SERVER[HTTP_USER_AGENT]; ?>",
            php: "<?php echo $phpversion; ?>",
            os: "<?php echo $operatingsystem; ?>"
          });
            
            document.getElementById("form").submit();
        });
        </script>
    </body>
</html>
