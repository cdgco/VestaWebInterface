/*!
 * jQuery Cookie Plugin v1.3.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as anonymous module.
		define(['jquery'], factory);
	***REMOVED*** else {
		// Browser globals.
		factory(jQuery);
	***REMOVED***
***REMOVED***(function ($) {

	var pluses = /\+/g;

	function raw(s) {
		return s;
	***REMOVED***

	function decoded(s) {
		return decodeURIComponent(s.replace(pluses, ' '));
	***REMOVED***

	function converted(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		***REMOVED***
		try {
			return config.json ? JSON.parse(s) : s;
		***REMOVED*** catch(er) {***REMOVED***
	***REMOVED***

	var config = $.cookie = function (key, value, options) {

		// write
		if (value !== undefined) {
			options = $.extend({***REMOVED***, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setDate(t.getDate() + days);
			***REMOVED***

			value = config.json ? JSON.stringify(value) : String(value);

			return (document.cookie = [
				config.raw ? key : encodeURIComponent(key),
				'=',
				config.raw ? value : encodeURIComponent(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		***REMOVED***

		// read
		var decode = config.raw ? raw : decoded;
		var cookies = document.cookie.split('; ');
		var result = key ? undefined : {***REMOVED***;
		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = decode(parts.join('='));

			if (key && key === name) {
				result = converted(cookie);
				break;
			***REMOVED***

			if (!key) {
				result[name] = converted(cookie);
			***REMOVED***
		***REMOVED***

		return result;
	***REMOVED***;

	config.defaults = {***REMOVED***;

	$.removeCookie = function (key, options) {
		if ($.cookie(key) !== undefined) {
			// Must not alter options, thus extending a fresh object...
			$.cookie(key, '', $.extend({***REMOVED***, options, { expires: -1 ***REMOVED***));
			return true;
		***REMOVED***
		return false;
	***REMOVED***;

***REMOVED***));

