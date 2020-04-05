<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2020 Carter Roeser <carter@cdgtech.one>
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

$ulang = array
    (
    'ar' => 'ar_EG.utf8',
    'bs' => 'bs_BA.utf8',
    'cn' => 'zh_CN.utf8',
    'cz' => 'cs_CZ.utf8', 
    'da' => 'da_DK.utf8',
    'de' => 'de_DE.utf8',
    'el' => 'el_GR.utf8',
    'en' => 'en_US.utf8',
    'es' => 'es_US.utf8',
    'fa' => 'fa_IR',
    'fi' => 'fi_FI.utf8',
    'fr' => 'fr_FR.utf8',
    'hu' => 'hu_HU.utf8',
    'id' => 'id_ID.utf8',
    'it' => 'it_IT.utf8',
    'ja' => 'ja_JP.utf8',
    'ka' => 'ka_GE.utf8',
    'nl' => 'nl_NL.utf8',
    'no' => 'nn_NO.utf8',
    'pl' => 'pl_PL.utf8',
    'pt-BR' => 'pt_BR.utf8',
    'pt' => 'pt_PT.utf8',
    'ro' => 'ro_RO.utf8',
    'ru' => 'ru_RU.utf8',
    'se' => 'sv_SE.utf8',
    'tr' => 'tr_TR.utf8',
    'tw' => 'zh_TW.utf8',
    'ua' => 'uk_UA.utf8',
    'vi' => 'vi_VN'
);

$errorcode = array
    (
    "1" => "Not enough arguments provided.",
    "2" => "Invalid object or argument.",
    "3" => "Object does not exist.",
    "4" => "Object already exists.", 
    "5" => "Object is suspended.",
    "6" => "Object is already unsuspended.",
    "7" => "Object is in use by another object.",
    "8" => "Object cannot be created because of hosting package limits.",
    "9" => "Wrong password.",
    "10" => "Object cannot be accessed.",
    "11" => "Subsystem is disabled.",
    "12" => "Configuration is broken.",
    "13" => "Not enough disk space.",
    "14" => "Server is busy.",
    "15" => "Connection failed.",
    "16" => "Server is not responding.",
    "17" => "Server is not responding.",
    "18" => "Update operation failed.",
    "19" => "Update operation failed.",
    "20" => "Service restart failed."
);

$countries = array
    (
    'ar' => 'العربية',
    'bs' => 'Bosanski / босански',
    'cn' => '汉语',
    'cz' => 'čeština',
    'da' => 'dansk',
    'de' => 'Deutsch',
    'el' => 'ελληνικά',
    'en' => 'English',
    'es' => 'español',
    'fa' => 'فارسی',
    'fi' => 'Finnish',
    'fr' => 'français',
    'hu' => 'Hungarian',
    'id' => 'Indonesian',
    'it' => 'italiano',
    'ja' => '日本語',
    'ka' => 'ქართული',
    'nl' => 'Dutch',
    'no' => 'norsk',
    'pl' => 'Język polski',
    'pt-BR' => 'português do Brasil',
    'pt' => 'português',
    'ro' => 'Romanian',
    'ru' => 'ру́сский язы́к',
    'se' => 'svenska',
    'tr' => 'Türkçe',
    'tw' => '臺灣華語',
    'ua' => 'українська мова',
    'vi' => 'Tiếng Việt / 㗂越'
);

$currencies = array
    (
    'usd' => '&#36;',
    'aed' => '&#1583;.&#1573;',
    'afn' => '&#1547;',
    'all' => 'L',
    'amd' => 'դր.',
    'ang' => '&#402;',
    'aoa' => 'Kz',
    'ars' => '&#36;',
    'aud' => '&#36;',
    'awg' => '&#402;',
    'azn' => '&#8380;',
    'bam' => 'KM',
    'bbd' => '&#36;',
    'bdt' => '&#2547;',
    'bgn' => '&#1083;&#1074;',
    'bif' => 'Fr',
    'bmd' => '&#36;',
    'bnd' => '&#36;',
    'bob' => 'Bs.',
    'brl' => 'R&#36;',
    'bsd' => '&#36;',
    'bwp' => 'P',
    'bzd' => '&#36;',
    'cad' => '&#36;',
    'cdf' => 'Fr',
    'chf' => 'CHF',
    'clp' => '&#36;',
    'cny' => '&yen;',
    'cop' => '&#36;',
    'crc' => '&#8353;',
    'cve' => '&#36;',
    'czk' => 'K&#269;',
    'djf' => 'Fdj',
    'dkk' => 'kr',
    'dop' => '&#36;',
    'dzd' => 'د.ج',
    'egp' => 'ج.م',
    'etb' => 'Br',
    'eur' => '&euro;',
    'fjd' => '&#36;',
    'fkp' => '&#163;',
    'gbp' => '&pound;',
    'gel' => 'ლ',
    'gip' => '&#163;',
    'gmd' => 'D',
    'gnf' => 'Fr',
    'gtq' => 'Q',
    'gyd' => '&#36;',
    'hkd' => '&#36;',
    'hnl' => 'L',
    'hrk' => 'kn',
    'htg' => 'G',
    'huf' => 'Ft',
    'idr' => 'Rp',
    'ils' => '&#8362;',
    'inr' => '&#x20B9;',
    'isk' => 'kr',
    'jmd' => '&#36;',
    'jpy' => '&yen;',
    'kes' => 'KSh',
    'kgs' => 'som',
    'kmf' => 'Fr',
    'krw' => '&#8361;',
    'kyd' => '&#36;',
    'kzt' => '〒',
    'lak' => '&#8365;',
    'lbp' => 'ل.ل',
    'lkr' => '&#8360;',
    'lrd' => '&#36;',
    'lsl' => 'L',
    'mad' => '.د.م',
    'mdl' => 'L',
    'mga' => 'Ar',
    'mkd' => '&#1076;&#1077;&#1085;',
    'mmk' => 'K',
    'mnt' => '&#8366;',
    'mop' => 'P',
    'mro' => 'UM',
    'mur' => '&#8360;',
    'mvr' => 'MVR',
    'mwk' => 'MK',
    'mxn' => '&#36;',
    'myr' => 'RM',
    'mzn' => 'MTn',
    'nad' => '&#36;',
    'ngn' => '&#8358;',
    'nio' => 'C&#36;',
    'nok' => 'kr',
    'npr' => '&#8360;',
    'nzd' => '&#36;',
    'pab' => 'B/.',
    'pen' => 'S/.',
    'pgk' => 'K',
    'php' => '&#8369;',
    'pkr' => '&#8360;',
    'pln' => 'z&#322;',
    'pyg' => '&#8370;',
    'qar' => '&#65020;',
    'ron' => 'Lei',
    'rsd' => 'РС&#1044;',
    'rub' => '&#402;',
    'rwf' => 'FRw',
    'sar' => '&#65020;',
    'sbd' => '&#36;',
    'scr' => '&#8360;',
    'sek' => 'kr',
    'sgd' => '&#36;',
    'shp' => '&#163;',
    'sll' => 'Le',
    'sos' => 'Sh',
    'srd' => '&#36;',
    'std' => 'Db',
    'svc' => '&#8353;',
    'szl' => 'L',
    'thb' => '&#3647;',
    'tjs' => 'SM',
    'top' => 'T&#36;',
    'try' => 'TL',
    'ttd' => '&#36',
    'twd' => '&#36;',
    'tzs' => 'Sh',
    'uah' => '&#8372;',
    'ugx' => 'USh',
    'uyu' => '&#36;',
    'uzs' => '&#1083;&#1074;',
    'vnd' => '&#8363;',
    'vuv' => 'Vt',
    'wst' => 'T',
    'xaf' => 'Fr',
    'xcd' => '&#36;',
    'xof' => 'Fr',
    'xpf' => 'Fr',
    'yer' => '&#65020;',
    'zar' => 'R',
    'zmw' => 'ZK',
);

function socialloginhtml($i) {
    switch($i) {
	case 'google-oauth2':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-google-inversed"><i class="fa fa-google"></i>&nbsp;&nbsp;'.__("Connect with Google").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
	case 'facebook':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-facebook-inversed"><i class="fa fa-facebook"></i>&nbsp;&nbsp;'.__("Connect with Facebook").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
	case 'apple':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-appstore-inversed"><i class="fa fa-apple"></i>&nbsp;&nbsp;'.__("Connect with Apple").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
	case 'windowslive':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-windows-inversed"><i class="fa fa-windows"></i>&nbsp;&nbsp;'.__("Connect with Microsoft").' <i class="fa fa-angle-right"></i></a></div></div>';
		break; 
    case 'linkedin':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-linkedin-inversed"><i class="fa fa-linkedin"></i>&nbsp;&nbsp;'.__("Connect with Linkedin").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'github':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-github-inversed"><i class="fa fa-github"></i>&nbsp;&nbsp;'.__("Connect with Github").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
	case 'dropbox':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-dropbox-inversed"><i class="fa fa-dropbox"></i>&nbsp;&nbsp;'.__("Connect with Dropbox").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
  	case 'bitbucket':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-bitbucket-inversed"><i class="fa fa-bitbucket"></i>&nbsp;&nbsp;'.__("Connect with BitBucket").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'paypal':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-paypal-inversed paypal"><i class="fa fa-paypal"></i>&nbsp;&nbsp;'.__("Connect with PayPal").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'paypal-sandbox':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-paypal-inversed paypal-sandbox"><i class="fa fa-paypal"></i>&nbsp;&nbsp;'.__("Connect with PayPal").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'twitter':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-twitter-inversed"><i class="fa fa-twitter"></i>&nbsp;&nbsp;'.__("Connect with Twitter").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'line':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-line-inversed"><i class="fab fa-line"></i>&nbsp;&nbsp;'.__("Connect with Line").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'amazon':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-amazon-inversed"><i class="fa fa-amazon"></i>&nbsp;&nbsp;'.__("Connect with Amazon").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'vkontakte':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-vk-inversed"><i class="fa fa-vk"></i>&nbsp;&nbsp;'.__("Connect with VK").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'yandex':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-yandex-inversed"><i class="fab fa-yandex"></i>&nbsp;&nbsp;'.__("Connect with Yandex").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
   	case 'yahoo':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-yahoo-inversed"><i class="fa fa-yahoo"></i>&nbsp;&nbsp;'.__("Connect with Yahoo").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'thirtysevensignals':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-37signals-inversed"><i class="fontello-icon icon-37signals"></i>&nbsp;'.__("Connect with 37signals").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'box':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-box-inversed"><i class="fontello-icon icon-box"></i>&nbsp;'.__("Connect with box").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'salesforce':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-salesforce-inversed salesforce"><i class="fab fa-salesforce"></i>&nbsp;&nbsp;'.__("Connect with Salesforce").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'salesforce-sandbox':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-salesforce-inversed salesforce-sandbox"><i class="fab fa-salesforce"></i>&nbsp;&nbsp;'.__("Connect with Salesforce").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'salesforce-community':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-salesforce-inversed salesforce-community"><i class="fab fa-salesforce"></i>&nbsp;&nbsp;'.__("Connect with Salesforce").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'fitbit':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-fitbit-inversed"><i class="fontello-icon icon-fitbit"></i>&nbsp;'.__("Connect with fitbit").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'baidu':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-baidu-inversed"><i class="fontello-icon icon-baidu"></i>&nbsp;'.__("Connect with Baidu").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'renren':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-renren-inversed"><i class="fa fa-renren"></i>&nbsp;&nbsp;'.__("Connect with renren").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'weibo':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-weibo-inversed"><i class="fa fa-weibo"></i>&nbsp;&nbsp;'.__("Connect with Weibo").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'aol':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-aol-inversed"><i class="fontello-icon icon-aol"></i>&nbsp;'.__("Connect with Aol").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'shopify':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-shopify-inversed"><i class="fab fa-shopify"></i>&nbsp;&nbsp;'.__("Connect with Shopify").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'wordpress':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-wordpress-inversed"><i class="fa fa-wordpress"></i>&nbsp;'.__("Connect with WordPress").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'dwolla':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-dwolla-inversed"><i class="fontello-icon icon-dwolla"></i>&nbsp;'.__("Connect with DWOLLA").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'miicard':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-miicard-inversed"><i class="fontello-icon icon-miicard"></i>&nbsp;'.__("Connect with miiCard").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'yammer':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-yammer-inversed"><i class="fab fa-yammer"></i>&nbsp;&nbsp;'.__("Connect with Yammer").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'soundcloud':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-soundcloud-inversed"><i class="fa fa-soundcloud"></i>&nbsp;&nbsp;'.__("Connect with SoundCloud").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'instagram':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-instagram-inversed"><i class="fa fa-instagram"></i>&nbsp;&nbsp;'.__("Connect with Instagram").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'planningcenter':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-planning-center-inversed"><i class="fontello-icon icon-planningcenter"></i>&nbsp;'.__("Connect with Planning Center").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'evernote':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-evernote-inversed evernote"><i class="fab fa-evernote"></i>&nbsp;&nbsp;'.__("Connect with Evernote").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'evernote-sandbox':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-evernote-inversed evernote-sandbox"><i class="fab fa-evernote"></i>&nbsp;&nbsp;'.__("Connect with Evernote").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'exact':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-exact-inversed"><i class="fontello-icon icon-exact"></i>&nbsp;'.__("Connect with Exact").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    case 'daccount':
		echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" class="btn btn-lg btn-block btn-rounded btn-docomo-inversed"><i class="fontello-icon icon-docomo"></i>&nbsp;'.__("Connect with Docomo").' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
	default:
        echo '<div class="form-group text-center m-t-20"><div class="col-xs-12"><a href="javascript:void(0)" onclick="webAuth.authorize({ connection: \''.$i.'\'});" class="btn btn-lg btn-block btn-rounded btn-skype-inversed">'.__("Connect with ").$i.' <i class="fa fa-angle-right"></i></a></div></div>';
		break;
    }
}

function socialloginhtmlsmall($i) {
    global $username; global $auth0_users;
    switch($i) {
	case 'google-oauth2':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-google-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Google" data-content="'.__('Link Account').'"><i class="fa fa-google"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-google-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Google" data-content="'.__('Unink Account').'"><i class="fa fa-google"></i></button>'; }
		break;
	case 'facebook':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-facebook-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Facebook" data-content="'.__('Link Account').'"><i class="fa fa-facebook"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-google-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Facebook" data-content="'.__('Unink Account').'"><i class="fa fa-facebook"></i></button>'; }
		break;
	case 'apple':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-appstore-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Apple" data-content="'.__('Link Account').'"><i class="fa fa-apple"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-appstore-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Apple" data-content="'.__('Unink Account').'"><i class="fa fa-apple"></i></button>'; }
		break;
	case 'windowslive':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-windows-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Microsoft" data-content="'.__('Link Account').'"><i class="fa fa-windows"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-windows-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Microsoft" data-content="'.__('Unink Account').'"><i class="fa fa-windows"></i></button>'; }
		break; 
    case 'linkedin':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-linkedin-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Linkedin" data-content="'.__('Link Account').'"><i class="fa fa-linkedin"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-linkedin-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Linkedin" data-content="'.__('Unink Account').'"><i class="fa fa-linkedin"></i></button>'; }
		break;
    case 'github':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-github-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Github" data-content="'.__('Link Account').'"><i class="fa fa-github"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-github-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Github" data-content="'.__('Unink Account').'"><i class="fa fa-github"></i></button>'; }
		break;
	case 'dropbox':  
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-dropbox-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Dropbox" data-content="'.__('Link Account').'"><i class="fa fa-dropbox"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-dropbox-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Dropbox" data-content="'.__('Unink Account').'"><i class="fa fa-dropbox"></i></button>'; }
		break;
  	case 'bitbucket':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-bitbucket-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="BitBucket" data-content="'.__('Link Account').'"><i class="fa fa-bitbucket"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-bitbucket-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="BitBucket" data-content="'.__('Unink Account').'"><i class="fa fa-bitbucket"></i></button>'; }
		break;
    case 'paypal':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-paypal-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="PayPal" data-content="'.__('Link Account').'"><i class="fa fa-paypal"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-paypal-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="PayPal" data-content="'.__('Unink Account').'"><i class="fa fa-paypal"></i></button>'; }
		break;
    case 'paypal-sandbox':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-paypal-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="PayPal Sandbox" data-content="'.__('Link Account').'"><i class="fa fa-paypal"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-paypal-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="PayPal Sandbox" data-content="'.__('Unink Account').'"><i class="fa fa-paypal"></i></button>'; }
		break;
    case 'twitter':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-twitter-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Twitter" data-content="'.__('Link Account').'"><i class="fa fa-twitter"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-twitter-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Twitter" data-content="'.__('Unink Account').'"><i class="fa fa-twitter"></i></button>'; }
		break;
    case 'line':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-line-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Line" data-content="'.__('Link Account').'"><i class="fab fa-line"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-line-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Line" data-content="'.__('Unink Account').'"><i class="fab fa-line"></i></button>'; }
		break;
    case 'amazon':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-amazon-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Amazon" data-content="'.__('Link Account').'"><i class="fa fa-amazon"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-amazon-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Amazon" data-content="'.__('Unink Account').'"><i class="fa fa-amazon"></i></button>'; }
		break;
    case 'vkontakte':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-vk-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="VK" data-content="'.__('Link Account').'"><i class="fa fa-vk"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-vk-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="VK" data-content="'.__('Unink Account').'"><i class="fa fa-vk"></i></button>'; }    
		break;
    case 'yandex':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-yandex-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Yandex" data-content="'.__('Link Account').'"><i class="fab fa-yandex"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-yandex-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Yandex" data-content="'.__('Unink Account').'"><i class="fab fa-yandex"></i></button>'; }    
		break;
   	case 'yahoo':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-yahoo-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Yahoo" data-content="'.__('Link Account').'"><i class="fa fa-yahoo"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-yahoo-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Yahoo" data-content="'.__('Unink Account').'"><i class="fa fa-yahoo"></i></button>'; }
		break;
    case 'thirtysevensignals':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-37signals-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="37signals" data-content="'.__('Link Account').'"><i class="fontello-icon icon-37signals"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-37signals-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="37signals" data-content="'.__('Unink Account').'"><i class="fontello-icon icon-37signals"></i></button>'; }
		break;
    case 'box':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-box-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="box" data-content="'.__('Link Account').'"><i class="fontello-icon icon-box"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-box-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="box" data-content="'.__('Unink Account').'"><i class="fontello-icon icon-box"></i></button>'; }
		break;
    case 'salesforce':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-salesforce-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="SalesForce" data-content="'.__('Link Account').'"><i class="fab fa-salesforce"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-salesforce-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="SalesForce" data-content="'.__('Unink Account').'"><i class="fab fa-salesforce"></i></button>'; }
		break;
    case 'salesforce-sandbox':
		if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-salesforce-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="SalesForce Sandbox" data-content="'.__('Link Account').'"><i class="fab fa-salesforce"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-salesforce-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="SalesForce Sandbox" data-content="'.__('Unink Account').'"><i class="fab fa-salesforce"></i></button>'; }
		break;
    case 'salesforce-community':
		if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-salesforce-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="SalesForce Community" data-content="'.__('Link Account').'"><i class="fab fa-salesforce"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-salesforce-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="SalesForce Community" data-content="'.__('Unink Account').'"><i class="fab fa-salesforce"></i></button>'; }
		break;
    case 'fitbit':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-fitbit-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="fitbit" data-content="'.__('Link Account').'"><i class="fontello-icon icon-fitbit"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-fitbit-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="fitbit" data-content="'.__('Unink Account').'"><i class="fontello-icon icon-fitbit"></i></button>'; }
		break;
    case 'baidu':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-baidu-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Baidu" data-content="'.__('Link Account').'"><i class="fontello-icon icon-baidu"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-baidu-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Baidu" data-content="'.__('Unink Account').'"><i class="fontello-icon icon-baidu"></i></button>'; }
		break;
    case 'renren':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-renren-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="renren" data-content="'.__('Link Account').'"><i class="fa fa-renren"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-renren-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="renren" data-content="'.__('Unink Account').'"><i class="fa fa-renren"></i></button>'; }
		break;
    case 'weibo':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-weibo-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Weibo" data-content="'.__('Link Account').'"><i class="fa fa-weibo"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-weibo-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Weibo" data-content="'.__('Unink Account').'"><i class="fa fa-weibo"></i></button>'; }
		break;
    case 'aol':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-aol-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Aol" data-content="'.__('Link Account').'"><i class="fontello-icon icon-aol"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-aol-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Aol" data-content="'.__('Unink Account').'"><i class="fontello-icon icon-aol"></i></button>'; }
		break;
    case 'shopify':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-shopify-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Shopify" data-content="'.__('Link Account').'"><i class="fab fa-shopify"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-shopify-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Shopify" data-content="'.__('Unink Account').'"><i class="fab fa-shopify"></i></button>'; }
		break;
    case 'wordpress':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-wordpress-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="WordPress" data-content="'.__('Link Account').'"><i class="fa fa-wordpress"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-wordpress-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="WordPress" data-content="'.__('Unink Account').'"><i class="fa fa-wordpress"></i></button>'; }
		break;
    case 'dwolla':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-dwolla-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="DWOLLA" data-content="'.__('Link Account').'"><i class="fontello-icon icon-dwolla"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-dwolla-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="DWOLLA" data-content="'.__('Unink Account').'"><i class="fontello-icon icon-dwolla"></i></button>'; }
		break;
    case 'miicard':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-miicard-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="miiCard" data-content="'.__('Link Account').'"><i class="fontello-icon icon-miicard"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-miicard-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="miiCard" data-content="'.__('Unink Account').'"><i class="fontello-icon icon-miicard"></i></button>'; }
		break;
    case 'yammer':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-yammer-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Yammer" data-content="'.__('Link Account').'"><i class="fab fa-yammer"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-yammer-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Yammer" data-content="'.__('Unink Account').'"><i class="fab fa-yammer"></i></button>'; }
		break;
    case 'soundcloud':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-soundcloud-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="SoundCloud" data-content="'.__('Link Account').'"><i class="fa fa-soundcloud"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-soundcloud-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="SoundCloud" data-content="'.__('Unink Account').'"><i class="fa fa-soundcloud"></i></button>'; }
		break;
    case 'instagram':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-instagram-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Instagram" data-content="'.__('Link Account').'"><i class="fa fa-instagram"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-instagram-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Instagram" data-content="'.__('Unink Account').'"><i class="fa fa-instagram"></i></button>'; }
		break;
    case 'planningcenter':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-planning-center-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Planning Center" data-content="'.__('Link Account').'"><i class="fontello-icon icon-planningcenter"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-planning-center-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Planning Center" data-content="'.__('Unink Account').'"><i class="fontello-icon icon-planningcenter"></i></button>'; }
		break;
    case 'evernote':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-evernote-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Evernote" data-content="'.__('Link Account').'"><i class="fab fa-evernote"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-evernote-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Evernote" data-content="'.__('Unink Account').'"><i class="fab fa-evernote"></i></button>'; }
		break;
    case 'evernote-sandbox':
		if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-evernote-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Evernote Sandbox" data-content="'.__('Link Account').'"><i class="fab fa-evernote"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-evernote-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Evernote Sandbox" data-content="'.__('Unink Account').'"><i class="fab fa-evernote"></i></button>'; }
		break;
    case 'exact':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-exact-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="Exact" data-content="'.__('Link Account').'"><i class="fontello-icon icon-exact"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-exact-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="Exact" data-content="'.__('Unink Account').'"><i class="fontello-icon icon-exact"></i></button>'; }
		break;
    case 'daccount':
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-docomo-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="NTT Docomo" data-content="'.__('Link Account').'"><i class="fontello-icon icon-docomo"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-docomo-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="NTT Docomo" data-content="'.__('Unink Account').'"><i class="fontello-icon icon-docomo"></i></button>'; }
		break;
	default:
        if (strpos(($auth0_users[$username]), $i) === false) { echo '<button class="btn btn-sm btn-skype-inversed" onclick="link(\''.$i.'\')" style="margin:4px; font-size:130%; filter: contrast(0.5);" data-toggle="popper" data-placement="top" title="'.$i.'" data-content="'.__('Link Account').'"><i class="fa fa-th"></i></button>'; } 
        else { echo '<button class="btn btn-sm btn-skype-inversed" onclick="unlink(\''.$i.'\')" style="margin:4px; font-size:130%;" data-toggle="popper" data-placement="top" title="'.$i.'" data-content="'.__('Unink Account').'"><i class="fa fa-th"></i></button>'; }
		break;
    }
}

function socialloginjs($i) {
    switch($i) {
	case 'google-oauth2':
		echo '$(".btn-google-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'facebook':
		echo '$(".btn-facebook-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'apple':
		echo '$(".btn-appstore-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'windowslive':
		echo '$(".btn-windows-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break; 
    case 'linkedin':
		echo '$(".btn-linkedin-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
    case 'github':
		echo '$(".btn-github-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'dropbox':
		echo '$(".btn-dropbox-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
  	case 'bitbucket':
		echo '$(".btn-bitbucket-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
    case 'paypal':
		echo '$(".paypal").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
    case 'paypal-sandbox':
		echo '$(".paypal-sandbox").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
    case 'twitter':
		echo '$(".btn-twitter-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'line':
		echo '$(".btn-line-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'amazon':
		echo '$(".btn-amazon-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'vkontakte':
		echo '$(".btn-vk-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'yandex':
		echo '$(".btn-yandex-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
   	case 'yahoo':
		echo '$(".btn-yahoo-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'thirtysevensignals':
		echo '$(".btn-37signals-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'box':
		echo '$(".btn-box-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'salesforce':
		echo '$(".salesforce").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'salesforce-sandbox':
		echo '$(".salesforce-sandbox").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'salesforce-community':
		echo '$(".salesforce-community").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'fitbit':
		echo '$(".btn-fitbit-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'baidu':
		echo '$(".btn-baidu-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'renren':
		echo '$(".btn-renren-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'weibo':
		echo '$(".btn-weibo-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'aol':
		echo '$(".btn-aol-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'shopify':
		echo '$(".btn-shopify-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'wordpress':
		echo '$(".btn-wordpress-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'dwolla':
		echo '$(".btn-dwolla-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'miicard':
		echo '$(".btn-miicard-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'yammer':
		echo '$(".btn-yammer-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
    case 'soundcloud':
		echo '$(".btn-soundcloud-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	case 'instagram':
		echo '$(".btn-instagram-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
    case 'planningcenter':
		echo '$(".btn-planning-center-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
    case 'evernote':
		echo '$(".evernote").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
    case 'evernote-sandbox':
		echo '$(".evernote-sandbox").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
    case 'exact':
		echo '$(".btn-exact-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
    case 'daccount':
		echo '$(".btn-docomo-inversed").click(function(e) {e.preventDefault(); webAuth.authorize({ connection: "'.$i.'"});});';
		break;
	default:
      		break;
    }
}

?>