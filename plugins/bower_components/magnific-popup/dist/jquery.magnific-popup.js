/*! Magnific Popup - v1.0.0 - 2014-12-12
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2014 Dmitry Semenov; */
;(function (factory) { 
if (typeof define === 'function' && define.amd) { 
 // AMD. Register as an anonymous module. 
 define(['jquery'], factory); 
 ***REMOVED*** else if (typeof exports === 'object') { 
 // Node/CommonJS 
 factory(require('jquery')); 
 ***REMOVED*** else { 
 // Browser globals 
 factory(window.jQuery || window.Zepto); 
 ***REMOVED*** 
 ***REMOVED***(function($) { 

/*>>core*/
/**
 * 
 * Magnific Popup Core JS file
 * 
 */


/**
 * Private static constants
 */
var CLOSE_EVENT = 'Close',
	BEFORE_CLOSE_EVENT = 'BeforeClose',
	AFTER_CLOSE_EVENT = 'AfterClose',
	BEFORE_APPEND_EVENT = 'BeforeAppend',
	MARKUP_PARSE_EVENT = 'MarkupParse',
	OPEN_EVENT = 'Open',
	CHANGE_EVENT = 'Change',
	NS = 'mfp',
	EVENT_NS = '.' + NS,
	READY_CLASS = 'mfp-ready',
	REMOVING_CLASS = 'mfp-removing',
	PREVENT_CLOSE_CLASS = 'mfp-prevent-close';


/**
 * Private vars 
 */
var mfp, // As we have only one instance of MagnificPopup object, we define it locally to not to use 'this'
	MagnificPopup = function(){***REMOVED***,
	_isJQ = !!(window.jQuery),
	_prevStatus,
	_window = $(window),
	_body,
	_document,
	_prevContentType,
	_wrapClasses,
	_currPopupType;


/**
 * Private functions
 */
var _mfpOn = function(name, f) {
		mfp.ev.on(NS + name + EVENT_NS, f);
	***REMOVED***,
	_getEl = function(className, appendTo, html, raw) {
		var el = document.createElement('div');
		el.className = 'mfp-'+className;
		if(html) {
			el.innerHTML = html;
		***REMOVED***
		if(!raw) {
			el = $(el);
			if(appendTo) {
				el.appendTo(appendTo);
			***REMOVED***
		***REMOVED*** else if(appendTo) {
			appendTo.appendChild(el);
		***REMOVED***
		return el;
	***REMOVED***,
	_mfpTrigger = function(e, data) {
		mfp.ev.triggerHandler(NS + e, data);

		if(mfp.st.callbacks) {
			// converts "mfpEventName" to "eventName" callback and triggers it if it's present
			e = e.charAt(0).toLowerCase() + e.slice(1);
			if(mfp.st.callbacks[e]) {
				mfp.st.callbacks[e].apply(mfp, $.isArray(data) ? data : [data]);
			***REMOVED***
		***REMOVED***
	***REMOVED***,
	_getCloseBtn = function(type) {
		if(type !== _currPopupType || !mfp.currTemplate.closeBtn) {
			mfp.currTemplate.closeBtn = $( mfp.st.closeMarkup.replace('%title%', mfp.st.tClose ) );
			_currPopupType = type;
		***REMOVED***
		return mfp.currTemplate.closeBtn;
	***REMOVED***,
	// Initialize Magnific Popup only when called at least once
	_checkInstance = function() {
		if(!$.magnificPopup.instance) {
			mfp = new MagnificPopup();
			mfp.init();
			$.magnificPopup.instance = mfp;
		***REMOVED***
	***REMOVED***,
	// CSS transition detection, http://stackoverflow.com/questions/7264899/detect-css-transitions-using-javascript-and-without-modernizr
	supportsTransitions = function() {
		var s = document.createElement('p').style, // 's' for style. better to create an element if body yet to exist
			v = ['ms','O','Moz','Webkit']; // 'v' for vendor

		if( s['transition'] !== undefined ) {
			return true; 
		***REMOVED***
			
		while( v.length ) {
			if( v.pop() + 'Transition' in s ) {
				return true;
			***REMOVED***
		***REMOVED***
				
		return false;
	***REMOVED***;



/**
 * Public functions
 */
MagnificPopup.prototype = {

	constructor: MagnificPopup,

	/**
	 * Initializes Magnific Popup plugin. 
	 * This function is triggered only once when $.fn.magnificPopup or $.magnificPopup is executed
	 */
	init: function() {
		var appVersion = navigator.appVersion;
		mfp.isIE7 = appVersion.indexOf("MSIE 7.") !== -1; 
		mfp.isIE8 = appVersion.indexOf("MSIE 8.") !== -1;
		mfp.isLowIE = mfp.isIE7 || mfp.isIE8;
		mfp.isAndroid = (/android/gi).test(appVersion);
		mfp.isIOS = (/iphone|ipad|ipod/gi).test(appVersion);
		mfp.supportsTransition = supportsTransitions();

		// We disable fixed positioned lightbox on devices that don't handle it nicely.
		// If you know a better way of detecting this - let me know.
		mfp.probablyMobile = (mfp.isAndroid || mfp.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent) );
		_document = $(document);

		mfp.popupsCache = {***REMOVED***;
	***REMOVED***,

	/**
	 * Opens popup
	 * @param  data [description]
	 */
	open: function(data) {

		if(!_body) {
			_body = $(document.body);
		***REMOVED***

		var i;

		if(data.isObj === false) { 
			// convert jQuery collection to array to avoid conflicts later
			mfp.items = data.items.toArray();

			mfp.index = 0;
			var items = data.items,
				item;
			for(i = 0; i < items.length; i++) {
				item = items[i];
				if(item.parsed) {
					item = item.el[0];
				***REMOVED***
				if(item === data.el[0]) {
					mfp.index = i;
					break;
				***REMOVED***
			***REMOVED***
		***REMOVED*** else {
			mfp.items = $.isArray(data.items) ? data.items : [data.items];
			mfp.index = data.index || 0;
		***REMOVED***

		// if popup is already opened - we just update the content
		if(mfp.isOpen) {
			mfp.updateItemHTML();
			return;
		***REMOVED***
		
		mfp.types = []; 
		_wrapClasses = '';
		if(data.mainEl && data.mainEl.length) {
			mfp.ev = data.mainEl.eq(0);
		***REMOVED*** else {
			mfp.ev = _document;
		***REMOVED***

		if(data.key) {
			if(!mfp.popupsCache[data.key]) {
				mfp.popupsCache[data.key] = {***REMOVED***;
			***REMOVED***
			mfp.currTemplate = mfp.popupsCache[data.key];
		***REMOVED*** else {
			mfp.currTemplate = {***REMOVED***;
		***REMOVED***



		mfp.st = $.extend(true, {***REMOVED***, $.magnificPopup.defaults, data ); 
		mfp.fixedContentPos = mfp.st.fixedContentPos === 'auto' ? !mfp.probablyMobile : mfp.st.fixedContentPos;

		if(mfp.st.modal) {
			mfp.st.closeOnContentClick = false;
			mfp.st.closeOnBgClick = false;
			mfp.st.showCloseBtn = false;
			mfp.st.enableEscapeKey = false;
		***REMOVED***
		

		// Building markup
		// main containers are created only once
		if(!mfp.bgOverlay) {

			// Dark overlay
			mfp.bgOverlay = _getEl('bg').on('click'+EVENT_NS, function() {
				mfp.close();
			***REMOVED***);

			mfp.wrap = _getEl('wrap').attr('tabindex', -1).on('click'+EVENT_NS, function(e) {
				if(mfp._checkIfClose(e.target)) {
					mfp.close();
				***REMOVED***
			***REMOVED***);

			mfp.container = _getEl('container', mfp.wrap);
		***REMOVED***

		mfp.contentContainer = _getEl('content');
		if(mfp.st.preloader) {
			mfp.preloader = _getEl('preloader', mfp.container, mfp.st.tLoading);
		***REMOVED***


		// Initializing modules
		var modules = $.magnificPopup.modules;
		for(i = 0; i < modules.length; i++) {
			var n = modules[i];
			n = n.charAt(0).toUpperCase() + n.slice(1);
			mfp['init'+n].call(mfp);
		***REMOVED***
		_mfpTrigger('BeforeOpen');


		if(mfp.st.showCloseBtn) {
			// Close button
			if(!mfp.st.closeBtnInside) {
				mfp.wrap.append( _getCloseBtn() );
			***REMOVED*** else {
				_mfpOn(MARKUP_PARSE_EVENT, function(e, template, values, item) {
					values.close_replaceWith = _getCloseBtn(item.type);
				***REMOVED***);
				_wrapClasses += ' mfp-close-btn-in';
			***REMOVED***
		***REMOVED***

		if(mfp.st.alignTop) {
			_wrapClasses += ' mfp-align-top';
		***REMOVED***

	

		if(mfp.fixedContentPos) {
			mfp.wrap.css({
				overflow: mfp.st.overflowY,
				overflowX: 'hidden',
				overflowY: mfp.st.overflowY
			***REMOVED***);
		***REMOVED*** else {
			mfp.wrap.css({ 
				top: _window.scrollTop(),
				position: 'absolute'
			***REMOVED***);
		***REMOVED***
		if( mfp.st.fixedBgPos === false || (mfp.st.fixedBgPos === 'auto' && !mfp.fixedContentPos) ) {
			mfp.bgOverlay.css({
				height: _document.height(),
				position: 'absolute'
			***REMOVED***);
		***REMOVED***

		

		if(mfp.st.enableEscapeKey) {
			// Close on ESC key
			_document.on('keyup' + EVENT_NS, function(e) {
				if(e.keyCode === 27) {
					mfp.close();
				***REMOVED***
			***REMOVED***);
		***REMOVED***

		_window.on('resize' + EVENT_NS, function() {
			mfp.updateSize();
		***REMOVED***);


		if(!mfp.st.closeOnContentClick) {
			_wrapClasses += ' mfp-auto-cursor';
		***REMOVED***
		
		if(_wrapClasses)
			mfp.wrap.addClass(_wrapClasses);


		// this triggers recalculation of layout, so we get it once to not to trigger twice
		var windowHeight = mfp.wH = _window.height();

		
		var windowStyles = {***REMOVED***;

		if( mfp.fixedContentPos ) {
            if(mfp._hasScrollBar(windowHeight)){
                var s = mfp._getScrollbarSize();
                if(s) {
                    windowStyles.marginRight = s;
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***

		if(mfp.fixedContentPos) {
			if(!mfp.isIE7) {
				windowStyles.overflow = 'hidden';
			***REMOVED*** else {
				// ie7 double-scroll bug
				$('body, html').css('overflow', 'hidden');
			***REMOVED***
		***REMOVED***

		
		
		var classesToadd = mfp.st.mainClass;
		if(mfp.isIE7) {
			classesToadd += ' mfp-ie7';
		***REMOVED***
		if(classesToadd) {
			mfp._addClassToMFP( classesToadd );
		***REMOVED***

		// add content
		mfp.updateItemHTML();

		_mfpTrigger('BuildControls');

		// remove scrollbar, add margin e.t.c
		$('html').css(windowStyles);
		
		// add everything to DOM
		mfp.bgOverlay.add(mfp.wrap).prependTo( mfp.st.prependTo || _body );

		// Save last focused element
		mfp._lastFocusedEl = document.activeElement;
		
		// Wait for next cycle to allow CSS transition
		setTimeout(function() {
			
			if(mfp.content) {
				mfp._addClassToMFP(READY_CLASS);
				mfp._setFocus();
			***REMOVED*** else {
				// if content is not defined (not loaded e.t.c) we add class only for BG
				mfp.bgOverlay.addClass(READY_CLASS);
			***REMOVED***
			
			// Trap the focus in popup
			_document.on('focusin' + EVENT_NS, mfp._onFocusIn);

		***REMOVED***, 16);

		mfp.isOpen = true;
		mfp.updateSize(windowHeight);
		_mfpTrigger(OPEN_EVENT);

		return data;
	***REMOVED***,

	/**
	 * Closes the popup
	 */
	close: function() {
		if(!mfp.isOpen) return;
		_mfpTrigger(BEFORE_CLOSE_EVENT);

		mfp.isOpen = false;
		// for CSS3 animation
		if(mfp.st.removalDelay && !mfp.isLowIE && mfp.supportsTransition )  {
			mfp._addClassToMFP(REMOVING_CLASS);
			setTimeout(function() {
				mfp._close();
			***REMOVED***, mfp.st.removalDelay);
		***REMOVED*** else {
			mfp._close();
		***REMOVED***
	***REMOVED***,

	/**
	 * Helper for close() function
	 */
	_close: function() {
		_mfpTrigger(CLOSE_EVENT);

		var classesToRemove = REMOVING_CLASS + ' ' + READY_CLASS + ' ';

		mfp.bgOverlay.detach();
		mfp.wrap.detach();
		mfp.container.empty();

		if(mfp.st.mainClass) {
			classesToRemove += mfp.st.mainClass + ' ';
		***REMOVED***

		mfp._removeClassFromMFP(classesToRemove);

		if(mfp.fixedContentPos) {
			var windowStyles = {marginRight: ''***REMOVED***;
			if(mfp.isIE7) {
				$('body, html').css('overflow', '');
			***REMOVED*** else {
				windowStyles.overflow = '';
			***REMOVED***
			$('html').css(windowStyles);
		***REMOVED***
		
		_document.off('keyup' + EVENT_NS + ' focusin' + EVENT_NS);
		mfp.ev.off(EVENT_NS);

		// clean up DOM elements that aren't removed
		mfp.wrap.attr('class', 'mfp-wrap').removeAttr('style');
		mfp.bgOverlay.attr('class', 'mfp-bg');
		mfp.container.attr('class', 'mfp-container');

		// remove close button from target element
		if(mfp.st.showCloseBtn &&
		(!mfp.st.closeBtnInside || mfp.currTemplate[mfp.currItem.type] === true)) {
			if(mfp.currTemplate.closeBtn)
				mfp.currTemplate.closeBtn.detach();
		***REMOVED***


		if(mfp._lastFocusedEl) {
			$(mfp._lastFocusedEl).focus(); // put tab focus back
		***REMOVED***
		mfp.currItem = null;	
		mfp.content = null;
		mfp.currTemplate = null;
		mfp.prevHeight = 0;

		_mfpTrigger(AFTER_CLOSE_EVENT);
	***REMOVED***,
	
	updateSize: function(winHeight) {

		if(mfp.isIOS) {
			// fixes iOS nav bars https://github.com/dimsemenov/Magnific-Popup/issues/2
			var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
			var height = window.innerHeight * zoomLevel;
			mfp.wrap.css('height', height);
			mfp.wH = height;
		***REMOVED*** else {
			mfp.wH = winHeight || _window.height();
		***REMOVED***
		// Fixes #84: popup incorrectly positioned with position:relative on body
		if(!mfp.fixedContentPos) {
			mfp.wrap.css('height', mfp.wH);
		***REMOVED***

		_mfpTrigger('Resize');

	***REMOVED***,

	/**
	 * Set content of popup based on current index
	 */
	updateItemHTML: function() {
		var item = mfp.items[mfp.index];

		// Detach and perform modifications
		mfp.contentContainer.detach();

		if(mfp.content)
			mfp.content.detach();

		if(!item.parsed) {
			item = mfp.parseEl( mfp.index );
		***REMOVED***

		var type = item.type;	

		_mfpTrigger('BeforeChange', [mfp.currItem ? mfp.currItem.type : '', type]);
		// BeforeChange event works like so:
		// _mfpOn('BeforeChange', function(e, prevType, newType) { ***REMOVED***);
		
		mfp.currItem = item;

		

		

		if(!mfp.currTemplate[type]) {
			var markup = mfp.st[type] ? mfp.st[type].markup : false;

			// allows to modify markup
			_mfpTrigger('FirstMarkupParse', markup);

			if(markup) {
				mfp.currTemplate[type] = $(markup);
			***REMOVED*** else {
				// if there is no markup found we just define that template is parsed
				mfp.currTemplate[type] = true;
			***REMOVED***
		***REMOVED***

		if(_prevContentType && _prevContentType !== item.type) {
			mfp.container.removeClass('mfp-'+_prevContentType+'-holder');
		***REMOVED***
		
		var newContent = mfp['get' + type.charAt(0).toUpperCase() + type.slice(1)](item, mfp.currTemplate[type]);
		mfp.appendContent(newContent, type);

		item.preloaded = true;

		_mfpTrigger(CHANGE_EVENT, item);
		_prevContentType = item.type;
		
		// Append container back after its content changed
		mfp.container.prepend(mfp.contentContainer);

		_mfpTrigger('AfterChange');
	***REMOVED***,


	/**
	 * Set HTML content of popup
	 */
	appendContent: function(newContent, type) {
		mfp.content = newContent;
		
		if(newContent) {
			if(mfp.st.showCloseBtn && mfp.st.closeBtnInside &&
				mfp.currTemplate[type] === true) {
				// if there is no markup, we just append close button element inside
				if(!mfp.content.find('.mfp-close').length) {
					mfp.content.append(_getCloseBtn());
				***REMOVED***
			***REMOVED*** else {
				mfp.content = newContent;
			***REMOVED***
		***REMOVED*** else {
			mfp.content = '';
		***REMOVED***

		_mfpTrigger(BEFORE_APPEND_EVENT);
		mfp.container.addClass('mfp-'+type+'-holder');

		mfp.contentContainer.append(mfp.content);
	***REMOVED***,



	
	/**
	 * Creates Magnific Popup data object based on given data
	 * @param  {int***REMOVED*** index Index of item to parse
	 */
	parseEl: function(index) {
		var item = mfp.items[index],
			type;

		if(item.tagName) {
			item = { el: $(item) ***REMOVED***;
		***REMOVED*** else {
			type = item.type;
			item = { data: item, src: item.src ***REMOVED***;
		***REMOVED***

		if(item.el) {
			var types = mfp.types;

			// check for 'mfp-TYPE' class
			for(var i = 0; i < types.length; i++) {
				if( item.el.hasClass('mfp-'+types[i]) ) {
					type = types[i];
					break;
				***REMOVED***
			***REMOVED***

			item.src = item.el.attr('data-mfp-src');
			if(!item.src) {
				item.src = item.el.attr('href');
			***REMOVED***
		***REMOVED***

		item.type = type || mfp.st.type || 'inline';
		item.index = index;
		item.parsed = true;
		mfp.items[index] = item;
		_mfpTrigger('ElementParse', item);

		return mfp.items[index];
	***REMOVED***,


	/**
	 * Initializes single popup or a group of popups
	 */
	addGroup: function(el, options) {
		var eHandler = function(e) {
			e.mfpEl = this;
			mfp._openClick(e, el, options);
		***REMOVED***;

		if(!options) {
			options = {***REMOVED***;
		***REMOVED*** 

		var eName = 'click.magnificPopup';
		options.mainEl = el;
		
		if(options.items) {
			options.isObj = true;
			el.off(eName).on(eName, eHandler);
		***REMOVED*** else {
			options.isObj = false;
			if(options.delegate) {
				el.off(eName).on(eName, options.delegate , eHandler);
			***REMOVED*** else {
				options.items = el;
				el.off(eName).on(eName, eHandler);
			***REMOVED***
		***REMOVED***
	***REMOVED***,
	_openClick: function(e, el, options) {
		var midClick = options.midClick !== undefined ? options.midClick : $.magnificPopup.defaults.midClick;


		if(!midClick && ( e.which === 2 || e.ctrlKey || e.metaKey ) ) {
			return;
		***REMOVED***

		var disableOn = options.disableOn !== undefined ? options.disableOn : $.magnificPopup.defaults.disableOn;

		if(disableOn) {
			if($.isFunction(disableOn)) {
				if( !disableOn.call(mfp) ) {
					return true;
				***REMOVED***
			***REMOVED*** else { // else it's number
				if( _window.width() < disableOn ) {
					return true;
				***REMOVED***
			***REMOVED***
		***REMOVED***
		
		if(e.type) {
			e.preventDefault();

			// This will prevent popup from closing if element is inside and popup is already opened
			if(mfp.isOpen) {
				e.stopPropagation();
			***REMOVED***
		***REMOVED***
			

		options.el = $(e.mfpEl);
		if(options.delegate) {
			options.items = el.find(options.delegate);
		***REMOVED***
		mfp.open(options);
	***REMOVED***,


	/**
	 * Updates text on preloader
	 */
	updateStatus: function(status, text) {

		if(mfp.preloader) {
			if(_prevStatus !== status) {
				mfp.container.removeClass('mfp-s-'+_prevStatus);
			***REMOVED***

			if(!text && status === 'loading') {
				text = mfp.st.tLoading;
			***REMOVED***

			var data = {
				status: status,
				text: text
			***REMOVED***;
			// allows to modify status
			_mfpTrigger('UpdateStatus', data);

			status = data.status;
			text = data.text;

			mfp.preloader.html(text);

			mfp.preloader.find('a').on('click', function(e) {
				e.stopImmediatePropagation();
			***REMOVED***);

			mfp.container.addClass('mfp-s-'+status);
			_prevStatus = status;
		***REMOVED***
	***REMOVED***,


	/*
		"Private" helpers that aren't private at all
	 */
	// Check to close popup or not
	// "target" is an element that was clicked
	_checkIfClose: function(target) {

		if($(target).hasClass(PREVENT_CLOSE_CLASS)) {
			return;
		***REMOVED***

		var closeOnContent = mfp.st.closeOnContentClick;
		var closeOnBg = mfp.st.closeOnBgClick;

		if(closeOnContent && closeOnBg) {
			return true;
		***REMOVED*** else {

			// We close the popup if click is on close button or on preloader. Or if there is no content.
			if(!mfp.content || $(target).hasClass('mfp-close') || (mfp.preloader && target === mfp.preloader[0]) ) {
				return true;
			***REMOVED***

			// if click is outside the content
			if(  (target !== mfp.content[0] && !$.contains(mfp.content[0], target))  ) {
				if(closeOnBg) {
					// last check, if the clicked element is in DOM, (in case it's removed onclick)
					if( $.contains(document, target) ) {
						return true;
					***REMOVED***
				***REMOVED***
			***REMOVED*** else if(closeOnContent) {
				return true;
			***REMOVED***

		***REMOVED***
		return false;
	***REMOVED***,
	_addClassToMFP: function(cName) {
		mfp.bgOverlay.addClass(cName);
		mfp.wrap.addClass(cName);
	***REMOVED***,
	_removeClassFromMFP: function(cName) {
		this.bgOverlay.removeClass(cName);
		mfp.wrap.removeClass(cName);
	***REMOVED***,
	_hasScrollBar: function(winHeight) {
		return (  (mfp.isIE7 ? _document.height() : document.body.scrollHeight) > (winHeight || _window.height()) );
	***REMOVED***,
	_setFocus: function() {
		(mfp.st.focus ? mfp.content.find(mfp.st.focus).eq(0) : mfp.wrap).focus();
	***REMOVED***,
	_onFocusIn: function(e) {
		if( e.target !== mfp.wrap[0] && !$.contains(mfp.wrap[0], e.target) ) {
			mfp._setFocus();
			return false;
		***REMOVED***
	***REMOVED***,
	_parseMarkup: function(template, values, item) {
		var arr;
		if(item.data) {
			values = $.extend(item.data, values);
		***REMOVED***
		_mfpTrigger(MARKUP_PARSE_EVENT, [template, values, item] );

		$.each(values, function(key, value) {
			if(value === undefined || value === false) {
				return true;
			***REMOVED***
			arr = key.split('_');
			if(arr.length > 1) {
				var el = template.find(EVENT_NS + '-'+arr[0]);

				if(el.length > 0) {
					var attr = arr[1];
					if(attr === 'replaceWith') {
						if(el[0] !== value[0]) {
							el.replaceWith(value);
						***REMOVED***
					***REMOVED*** else if(attr === 'img') {
						if(el.is('img')) {
							el.attr('src', value);
						***REMOVED*** else {
							el.replaceWith( '<img src="'+value+'" class="' + el.attr('class') + '" />' );
						***REMOVED***
					***REMOVED*** else {
						el.attr(arr[1], value);
					***REMOVED***
				***REMOVED***

			***REMOVED*** else {
				template.find(EVENT_NS + '-'+key).html(value);
			***REMOVED***
		***REMOVED***);
	***REMOVED***,

	_getScrollbarSize: function() {
		// thx David
		if(mfp.scrollbarSize === undefined) {
			var scrollDiv = document.createElement("div");
			scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
			document.body.appendChild(scrollDiv);
			mfp.scrollbarSize = scrollDiv.offsetWidth - scrollDiv.clientWidth;
			document.body.removeChild(scrollDiv);
		***REMOVED***
		return mfp.scrollbarSize;
	***REMOVED***

***REMOVED***; /* MagnificPopup core prototype end */




/**
 * Public static functions
 */
$.magnificPopup = {
	instance: null,
	proto: MagnificPopup.prototype,
	modules: [],

	open: function(options, index) {
		_checkInstance();	

		if(!options) {
			options = {***REMOVED***;
		***REMOVED*** else {
			options = $.extend(true, {***REMOVED***, options);
		***REMOVED***
			

		options.isObj = true;
		options.index = index || 0;
		return this.instance.open(options);
	***REMOVED***,

	close: function() {
		return $.magnificPopup.instance && $.magnificPopup.instance.close();
	***REMOVED***,

	registerModule: function(name, module) {
		if(module.options) {
			$.magnificPopup.defaults[name] = module.options;
		***REMOVED***
		$.extend(this.proto, module.proto);			
		this.modules.push(name);
	***REMOVED***,

	defaults: {   

		// Info about options is in docs:
		// http://dimsemenov.com/plugins/magnific-popup/documentation.html#options
		
		disableOn: 0,	

		key: null,

		midClick: false,

		mainClass: '',

		preloader: true,

		focus: '', // CSS selector of input to focus after popup is opened
		
		closeOnContentClick: false,

		closeOnBgClick: true,

		closeBtnInside: true, 

		showCloseBtn: true,

		enableEscapeKey: true,

		modal: false,

		alignTop: false,
	
		removalDelay: 0,

		prependTo: null,
		
		fixedContentPos: 'auto', 
	
		fixedBgPos: 'auto',

		overflowY: 'auto',

		closeMarkup: '<button title="%title%" type="button" class="mfp-close">&times;</button>',

		tClose: 'Close (Esc)',

		tLoading: 'Loading...'

	***REMOVED***
***REMOVED***;



$.fn.magnificPopup = function(options) {
	_checkInstance();

	var jqEl = $(this);

	// We call some API method of first param is a string
	if (typeof options === "string" ) {

		if(options === 'open') {
			var items,
				itemOpts = _isJQ ? jqEl.data('magnificPopup') : jqEl[0].magnificPopup,
				index = parseInt(arguments[1], 10) || 0;

			if(itemOpts.items) {
				items = itemOpts.items[index];
			***REMOVED*** else {
				items = jqEl;
				if(itemOpts.delegate) {
					items = items.find(itemOpts.delegate);
				***REMOVED***
				items = items.eq( index );
			***REMOVED***
			mfp._openClick({mfpEl:items***REMOVED***, jqEl, itemOpts);
		***REMOVED*** else {
			if(mfp.isOpen)
				mfp[options].apply(mfp, Array.prototype.slice.call(arguments, 1));
		***REMOVED***

	***REMOVED*** else {
		// clone options obj
		options = $.extend(true, {***REMOVED***, options);
		
		/*
		 * As Zepto doesn't support .data() method for objects 
		 * and it works only in normal browsers
		 * we assign "options" object directly to the DOM element. FTW!
		 */
		if(_isJQ) {
			jqEl.data('magnificPopup', options);
		***REMOVED*** else {
			jqEl[0].magnificPopup = options;
		***REMOVED***

		mfp.addGroup(jqEl, options);

	***REMOVED***
	return jqEl;
***REMOVED***;


//Quick benchmark
/*
var start = performance.now(),
	i,
	rounds = 1000;

for(i = 0; i < rounds; i++) {

***REMOVED***
console.log('Test #1:', performance.now() - start);

start = performance.now();
for(i = 0; i < rounds; i++) {

***REMOVED***
console.log('Test #2:', performance.now() - start);
*/


/*>>core*/

/*>>inline*/

var INLINE_NS = 'inline',
	_hiddenClass,
	_inlinePlaceholder, 
	_lastInlineElement,
	_putInlineElementsBack = function() {
		if(_lastInlineElement) {
			_inlinePlaceholder.after( _lastInlineElement.addClass(_hiddenClass) ).detach();
			_lastInlineElement = null;
		***REMOVED***
	***REMOVED***;

$.magnificPopup.registerModule(INLINE_NS, {
	options: {
		hiddenClass: 'hide', // will be appended with `mfp-` prefix
		markup: '',
		tNotFound: 'Content not found'
	***REMOVED***,
	proto: {

		initInline: function() {
			mfp.types.push(INLINE_NS);

			_mfpOn(CLOSE_EVENT+'.'+INLINE_NS, function() {
				_putInlineElementsBack();
			***REMOVED***);
		***REMOVED***,

		getInline: function(item, template) {

			_putInlineElementsBack();

			if(item.src) {
				var inlineSt = mfp.st.inline,
					el = $(item.src);

				if(el.length) {

					// If target element has parent - we replace it with placeholder and put it back after popup is closed
					var parent = el[0].parentNode;
					if(parent && parent.tagName) {
						if(!_inlinePlaceholder) {
							_hiddenClass = inlineSt.hiddenClass;
							_inlinePlaceholder = _getEl(_hiddenClass);
							_hiddenClass = 'mfp-'+_hiddenClass;
						***REMOVED***
						// replace target inline element with placeholder
						_lastInlineElement = el.after(_inlinePlaceholder).detach().removeClass(_hiddenClass);
					***REMOVED***

					mfp.updateStatus('ready');
				***REMOVED*** else {
					mfp.updateStatus('error', inlineSt.tNotFound);
					el = $('<div>');
				***REMOVED***

				item.inlineElement = el;
				return el;
			***REMOVED***

			mfp.updateStatus('ready');
			mfp._parseMarkup(template, {***REMOVED***, item);
			return template;
		***REMOVED***
	***REMOVED***
***REMOVED***);

/*>>inline*/

/*>>ajax*/
var AJAX_NS = 'ajax',
	_ajaxCur,
	_removeAjaxCursor = function() {
		if(_ajaxCur) {
			_body.removeClass(_ajaxCur);
		***REMOVED***
	***REMOVED***,
	_destroyAjaxRequest = function() {
		_removeAjaxCursor();
		if(mfp.req) {
			mfp.req.abort();
		***REMOVED***
	***REMOVED***;

$.magnificPopup.registerModule(AJAX_NS, {

	options: {
		settings: null,
		cursor: 'mfp-ajax-cur',
		tError: '<a href="%url%">The content</a> could not be loaded.'
	***REMOVED***,

	proto: {
		initAjax: function() {
			mfp.types.push(AJAX_NS);
			_ajaxCur = mfp.st.ajax.cursor;

			_mfpOn(CLOSE_EVENT+'.'+AJAX_NS, _destroyAjaxRequest);
			_mfpOn('BeforeChange.' + AJAX_NS, _destroyAjaxRequest);
		***REMOVED***,
		getAjax: function(item) {

			if(_ajaxCur)
				_body.addClass(_ajaxCur);

			mfp.updateStatus('loading');

			var opts = $.extend({
				url: item.src,
				success: function(data, textStatus, jqXHR) {
					var temp = {
						data:data,
						xhr:jqXHR
					***REMOVED***;

					_mfpTrigger('ParseAjax', temp);

					mfp.appendContent( $(temp.data), AJAX_NS );

					item.finished = true;

					_removeAjaxCursor();

					mfp._setFocus();

					setTimeout(function() {
						mfp.wrap.addClass(READY_CLASS);
					***REMOVED***, 16);

					mfp.updateStatus('ready');

					_mfpTrigger('AjaxContentAdded');
				***REMOVED***,
				error: function() {
					_removeAjaxCursor();
					item.finished = item.loadError = true;
					mfp.updateStatus('error', mfp.st.ajax.tError.replace('%url%', item.src));
				***REMOVED***
			***REMOVED***, mfp.st.ajax.settings);

			mfp.req = $.ajax(opts);

			return '';
		***REMOVED***
	***REMOVED***
***REMOVED***);





	

/*>>ajax*/

/*>>image*/
var _imgInterval,
	_getTitle = function(item) {
		if(item.data && item.data.title !== undefined) 
			return item.data.title;

		var src = mfp.st.image.titleSrc;

		if(src) {
			if($.isFunction(src)) {
				return src.call(mfp, item);
			***REMOVED*** else if(item.el) {
				return item.el.attr(src) || '';
			***REMOVED***
		***REMOVED***
		return '';
	***REMOVED***;

$.magnificPopup.registerModule('image', {

	options: {
		markup: '<div class="mfp-figure">'+
					'<div class="mfp-close"></div>'+
					'<figure>'+
						'<div class="mfp-img"></div>'+
						'<figcaption>'+
							'<div class="mfp-bottom-bar">'+
								'<div class="mfp-title"></div>'+
								'<div class="mfp-counter"></div>'+
							'</div>'+
						'</figcaption>'+
					'</figure>'+
				'</div>',
		cursor: 'mfp-zoom-out-cur',
		titleSrc: 'title', 
		verticalFit: true,
		tError: '<a href="%url%">The image</a> could not be loaded.'
	***REMOVED***,

	proto: {
		initImage: function() {
			var imgSt = mfp.st.image,
				ns = '.image';

			mfp.types.push('image');

			_mfpOn(OPEN_EVENT+ns, function() {
				if(mfp.currItem.type === 'image' && imgSt.cursor) {
					_body.addClass(imgSt.cursor);
				***REMOVED***
			***REMOVED***);

			_mfpOn(CLOSE_EVENT+ns, function() {
				if(imgSt.cursor) {
					_body.removeClass(imgSt.cursor);
				***REMOVED***
				_window.off('resize' + EVENT_NS);
			***REMOVED***);

			_mfpOn('Resize'+ns, mfp.resizeImage);
			if(mfp.isLowIE) {
				_mfpOn('AfterChange', mfp.resizeImage);
			***REMOVED***
		***REMOVED***,
		resizeImage: function() {
			var item = mfp.currItem;
			if(!item || !item.img) return;

			if(mfp.st.image.verticalFit) {
				var decr = 0;
				// fix box-sizing in ie7/8
				if(mfp.isLowIE) {
					decr = parseInt(item.img.css('padding-top'), 10) + parseInt(item.img.css('padding-bottom'),10);
				***REMOVED***
				item.img.css('max-height', mfp.wH-decr);
			***REMOVED***
		***REMOVED***,
		_onImageHasSize: function(item) {
			if(item.img) {
				
				item.hasSize = true;

				if(_imgInterval) {
					clearInterval(_imgInterval);
				***REMOVED***
				
				item.isCheckingImgSize = false;

				_mfpTrigger('ImageHasSize', item);

				if(item.imgHidden) {
					if(mfp.content)
						mfp.content.removeClass('mfp-loading');
					
					item.imgHidden = false;
				***REMOVED***

			***REMOVED***
		***REMOVED***,

		/**
		 * Function that loops until the image has size to display elements that rely on it asap
		 */
		findImageSize: function(item) {

			var counter = 0,
				img = item.img[0],
				mfpSetInterval = function(delay) {

					if(_imgInterval) {
						clearInterval(_imgInterval);
					***REMOVED***
					// decelerating interval that checks for size of an image
					_imgInterval = setInterval(function() {
						if(img.naturalWidth > 0) {
							mfp._onImageHasSize(item);
							return;
						***REMOVED***

						if(counter > 200) {
							clearInterval(_imgInterval);
						***REMOVED***

						counter++;
						if(counter === 3) {
							mfpSetInterval(10);
						***REMOVED*** else if(counter === 40) {
							mfpSetInterval(50);
						***REMOVED*** else if(counter === 100) {
							mfpSetInterval(500);
						***REMOVED***
					***REMOVED***, delay);
				***REMOVED***;

			mfpSetInterval(1);
		***REMOVED***,

		getImage: function(item, template) {

			var guard = 0,

				// image load complete handler
				onLoadComplete = function() {
					if(item) {
						if (item.img[0].complete) {
							item.img.off('.mfploader');
							
							if(item === mfp.currItem){
								mfp._onImageHasSize(item);

								mfp.updateStatus('ready');
							***REMOVED***

							item.hasSize = true;
							item.loaded = true;

							_mfpTrigger('ImageLoadComplete');
							
						***REMOVED***
						else {
							// if image complete check fails 200 times (20 sec), we assume that there was an error.
							guard++;
							if(guard < 200) {
								setTimeout(onLoadComplete,100);
							***REMOVED*** else {
								onLoadError();
							***REMOVED***
						***REMOVED***
					***REMOVED***
				***REMOVED***,

				// image error handler
				onLoadError = function() {
					if(item) {
						item.img.off('.mfploader');
						if(item === mfp.currItem){
							mfp._onImageHasSize(item);
							mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
						***REMOVED***

						item.hasSize = true;
						item.loaded = true;
						item.loadError = true;
					***REMOVED***
				***REMOVED***,
				imgSt = mfp.st.image;


			var el = template.find('.mfp-img');
			if(el.length) {
				var img = document.createElement('img');
				img.className = 'mfp-img';
				if(item.el && item.el.find('img').length) {
					img.alt = item.el.find('img').attr('alt');
				***REMOVED***
				item.img = $(img).on('load.mfploader', onLoadComplete).on('error.mfploader', onLoadError);
				img.src = item.src;

				// without clone() "error" event is not firing when IMG is replaced by new IMG
				// TODO: find a way to avoid such cloning
				if(el.is('img')) {
					item.img = item.img.clone();
				***REMOVED***

				img = item.img[0];
				if(img.naturalWidth > 0) {
					item.hasSize = true;
				***REMOVED*** else if(!img.width) {										
					item.hasSize = false;
				***REMOVED***
			***REMOVED***

			mfp._parseMarkup(template, {
				title: _getTitle(item),
				img_replaceWith: item.img
			***REMOVED***, item);

			mfp.resizeImage();

			if(item.hasSize) {
				if(_imgInterval) clearInterval(_imgInterval);

				if(item.loadError) {
					template.addClass('mfp-loading');
					mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
				***REMOVED*** else {
					template.removeClass('mfp-loading');
					mfp.updateStatus('ready');
				***REMOVED***
				return template;
			***REMOVED***

			mfp.updateStatus('loading');
			item.loading = true;

			if(!item.hasSize) {
				item.imgHidden = true;
				template.addClass('mfp-loading');
				mfp.findImageSize(item);
			***REMOVED*** 

			return template;
		***REMOVED***
	***REMOVED***
***REMOVED***);



/*>>image*/

/*>>zoom*/
var hasMozTransform,
	getHasMozTransform = function() {
		if(hasMozTransform === undefined) {
			hasMozTransform = document.createElement('p').style.MozTransform !== undefined;
		***REMOVED***
		return hasMozTransform;		
	***REMOVED***;

$.magnificPopup.registerModule('zoom', {

	options: {
		enabled: false,
		easing: 'ease-in-out',
		duration: 300,
		opener: function(element) {
			return element.is('img') ? element : element.find('img');
		***REMOVED***
	***REMOVED***,

	proto: {

		initZoom: function() {
			var zoomSt = mfp.st.zoom,
				ns = '.zoom',
				image;
				
			if(!zoomSt.enabled || !mfp.supportsTransition) {
				return;
			***REMOVED***

			var duration = zoomSt.duration,
				getElToAnimate = function(image) {
					var newImg = image.clone().removeAttr('style').removeAttr('class').addClass('mfp-animated-image'),
						transition = 'all '+(zoomSt.duration/1000)+'s ' + zoomSt.easing,
						cssObj = {
							position: 'fixed',
							zIndex: 9999,
							left: 0,
							top: 0,
							'-webkit-backface-visibility': 'hidden'
						***REMOVED***,
						t = 'transition';

					cssObj['-webkit-'+t] = cssObj['-moz-'+t] = cssObj['-o-'+t] = cssObj[t] = transition;

					newImg.css(cssObj);
					return newImg;
				***REMOVED***,
				showMainContent = function() {
					mfp.content.css('visibility', 'visible');
				***REMOVED***,
				openTimeout,
				animatedImg;

			_mfpOn('BuildControls'+ns, function() {
				if(mfp._allowZoom()) {

					clearTimeout(openTimeout);
					mfp.content.css('visibility', 'hidden');

					// Basically, all code below does is clones existing image, puts in on top of the current one and animated it
					
					image = mfp._getItemToZoom();

					if(!image) {
						showMainContent();
						return;
					***REMOVED***

					animatedImg = getElToAnimate(image); 
					
					animatedImg.css( mfp._getOffset() );

					mfp.wrap.append(animatedImg);

					openTimeout = setTimeout(function() {
						animatedImg.css( mfp._getOffset( true ) );
						openTimeout = setTimeout(function() {

							showMainContent();

							setTimeout(function() {
								animatedImg.remove();
								image = animatedImg = null;
								_mfpTrigger('ZoomAnimationEnded');
							***REMOVED***, 16); // avoid blink when switching images 

						***REMOVED***, duration); // this timeout equals animation duration

					***REMOVED***, 16); // by adding this timeout we avoid short glitch at the beginning of animation


					// Lots of timeouts...
				***REMOVED***
			***REMOVED***);
			_mfpOn(BEFORE_CLOSE_EVENT+ns, function() {
				if(mfp._allowZoom()) {

					clearTimeout(openTimeout);

					mfp.st.removalDelay = duration;

					if(!image) {
						image = mfp._getItemToZoom();
						if(!image) {
							return;
						***REMOVED***
						animatedImg = getElToAnimate(image);
					***REMOVED***
					
					
					animatedImg.css( mfp._getOffset(true) );
					mfp.wrap.append(animatedImg);
					mfp.content.css('visibility', 'hidden');
					
					setTimeout(function() {
						animatedImg.css( mfp._getOffset() );
					***REMOVED***, 16);
				***REMOVED***

			***REMOVED***);

			_mfpOn(CLOSE_EVENT+ns, function() {
				if(mfp._allowZoom()) {
					showMainContent();
					if(animatedImg) {
						animatedImg.remove();
					***REMOVED***
					image = null;
				***REMOVED***	
			***REMOVED***);
		***REMOVED***,

		_allowZoom: function() {
			return mfp.currItem.type === 'image';
		***REMOVED***,

		_getItemToZoom: function() {
			if(mfp.currItem.hasSize) {
				return mfp.currItem.img;
			***REMOVED*** else {
				return false;
			***REMOVED***
		***REMOVED***,

		// Get element postion relative to viewport
		_getOffset: function(isLarge) {
			var el;
			if(isLarge) {
				el = mfp.currItem.img;
			***REMOVED*** else {
				el = mfp.st.zoom.opener(mfp.currItem.el || mfp.currItem);
			***REMOVED***

			var offset = el.offset();
			var paddingTop = parseInt(el.css('padding-top'),10);
			var paddingBottom = parseInt(el.css('padding-bottom'),10);
			offset.top -= ( $(window).scrollTop() - paddingTop );


			/*
			
			Animating left + top + width/height looks glitchy in Firefox, but perfect in Chrome. And vice-versa.

			 */
			var obj = {
				width: el.width(),
				// fix Zepto height+padding issue
				height: (_isJQ ? el.innerHeight() : el[0].offsetHeight) - paddingBottom - paddingTop
			***REMOVED***;

			// I hate to do this, but there is no another option
			if( getHasMozTransform() ) {
				obj['-moz-transform'] = obj['transform'] = 'translate(' + offset.left + 'px,' + offset.top + 'px)';
			***REMOVED*** else {
				obj.left = offset.left;
				obj.top = offset.top;
			***REMOVED***
			return obj;
		***REMOVED***

	***REMOVED***
***REMOVED***);



/*>>zoom*/

/*>>iframe*/

var IFRAME_NS = 'iframe',
	_emptyPage = '//about:blank',
	
	_fixIframeBugs = function(isShowing) {
		if(mfp.currTemplate[IFRAME_NS]) {
			var el = mfp.currTemplate[IFRAME_NS].find('iframe');
			if(el.length) { 
				// reset src after the popup is closed to avoid "video keeps playing after popup is closed" bug
				if(!isShowing) {
					el[0].src = _emptyPage;
				***REMOVED***

				// IE8 black screen bug fix
				if(mfp.isIE8) {
					el.css('display', isShowing ? 'block' : 'none');
				***REMOVED***
			***REMOVED***
		***REMOVED***
	***REMOVED***;

$.magnificPopup.registerModule(IFRAME_NS, {

	options: {
		markup: '<div class="mfp-iframe-scaler">'+
					'<div class="mfp-close"></div>'+
					'<iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe>'+
				'</div>',

		srcAction: 'iframe_src',

		// we don't care and support only one default type of URL by default
		patterns: {
			youtube: {
				index: 'youtube.com', 
				id: 'v=', 
				src: '//www.youtube.com/embed/%id%?autoplay=1'
			***REMOVED***,
			vimeo: {
				index: 'vimeo.com/',
				id: '/',
				src: '//player.vimeo.com/video/%id%?autoplay=1'
			***REMOVED***,
			gmaps: {
				index: '//maps.google.',
				src: '%id%&output=embed'
			***REMOVED***
		***REMOVED***
	***REMOVED***,

	proto: {
		initIframe: function() {
			mfp.types.push(IFRAME_NS);

			_mfpOn('BeforeChange', function(e, prevType, newType) {
				if(prevType !== newType) {
					if(prevType === IFRAME_NS) {
						_fixIframeBugs(); // iframe if removed
					***REMOVED*** else if(newType === IFRAME_NS) {
						_fixIframeBugs(true); // iframe is showing
					***REMOVED*** 
				***REMOVED***// else {
					// iframe source is switched, don't do anything
				//***REMOVED***
			***REMOVED***);

			_mfpOn(CLOSE_EVENT + '.' + IFRAME_NS, function() {
				_fixIframeBugs();
			***REMOVED***);
		***REMOVED***,

		getIframe: function(item, template) {
			var embedSrc = item.src;
			var iframeSt = mfp.st.iframe;
				
			$.each(iframeSt.patterns, function() {
				if(embedSrc.indexOf( this.index ) > -1) {
					if(this.id) {
						if(typeof this.id === 'string') {
							embedSrc = embedSrc.substr(embedSrc.lastIndexOf(this.id)+this.id.length, embedSrc.length);
						***REMOVED*** else {
							embedSrc = this.id.call( this, embedSrc );
						***REMOVED***
					***REMOVED***
					embedSrc = this.src.replace('%id%', embedSrc );
					return false; // break;
				***REMOVED***
			***REMOVED***);
			
			var dataObj = {***REMOVED***;
			if(iframeSt.srcAction) {
				dataObj[iframeSt.srcAction] = embedSrc;
			***REMOVED***
			mfp._parseMarkup(template, dataObj, item);

			mfp.updateStatus('ready');

			return template;
		***REMOVED***
	***REMOVED***
***REMOVED***);



/*>>iframe*/

/*>>gallery*/
/**
 * Get looped index depending on number of slides
 */
var _getLoopedId = function(index) {
		var numSlides = mfp.items.length;
		if(index > numSlides - 1) {
			return index - numSlides;
		***REMOVED*** else  if(index < 0) {
			return numSlides + index;
		***REMOVED***
		return index;
	***REMOVED***,
	_replaceCurrTotal = function(text, curr, total) {
		return text.replace(/%curr%/gi, curr + 1).replace(/%total%/gi, total);
	***REMOVED***;

$.magnificPopup.registerModule('gallery', {

	options: {
		enabled: false,
		arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
		preload: [0,2],
		navigateByImgClick: true,
		arrows: true,

		tPrev: 'Previous (Left arrow key)',
		tNext: 'Next (Right arrow key)',
		tCounter: '%curr% of %total%'
	***REMOVED***,

	proto: {
		initGallery: function() {

			var gSt = mfp.st.gallery,
				ns = '.mfp-gallery',
				supportsFastClick = Boolean($.fn.mfpFastClick);

			mfp.direction = true; // true - next, false - prev
			
			if(!gSt || !gSt.enabled ) return false;

			_wrapClasses += ' mfp-gallery';

			_mfpOn(OPEN_EVENT+ns, function() {

				if(gSt.navigateByImgClick) {
					mfp.wrap.on('click'+ns, '.mfp-img', function() {
						if(mfp.items.length > 1) {
							mfp.next();
							return false;
						***REMOVED***
					***REMOVED***);
				***REMOVED***

				_document.on('keydown'+ns, function(e) {
					if (e.keyCode === 37) {
						mfp.prev();
					***REMOVED*** else if (e.keyCode === 39) {
						mfp.next();
					***REMOVED***
				***REMOVED***);
			***REMOVED***);

			_mfpOn('UpdateStatus'+ns, function(e, data) {
				if(data.text) {
					data.text = _replaceCurrTotal(data.text, mfp.currItem.index, mfp.items.length);
				***REMOVED***
			***REMOVED***);

			_mfpOn(MARKUP_PARSE_EVENT+ns, function(e, element, values, item) {
				var l = mfp.items.length;
				values.counter = l > 1 ? _replaceCurrTotal(gSt.tCounter, item.index, l) : '';
			***REMOVED***);

			_mfpOn('BuildControls' + ns, function() {
				if(mfp.items.length > 1 && gSt.arrows && !mfp.arrowLeft) {
					var markup = gSt.arrowMarkup,
						arrowLeft = mfp.arrowLeft = $( markup.replace(/%title%/gi, gSt.tPrev).replace(/%dir%/gi, 'left') ).addClass(PREVENT_CLOSE_CLASS),			
						arrowRight = mfp.arrowRight = $( markup.replace(/%title%/gi, gSt.tNext).replace(/%dir%/gi, 'right') ).addClass(PREVENT_CLOSE_CLASS);

					var eName = supportsFastClick ? 'mfpFastClick' : 'click';
					arrowLeft[eName](function() {
						mfp.prev();
					***REMOVED***);			
					arrowRight[eName](function() {
						mfp.next();
					***REMOVED***);	

					// Polyfill for :before and :after (adds elements with classes mfp-a and mfp-b)
					if(mfp.isIE7) {
						_getEl('b', arrowLeft[0], false, true);
						_getEl('a', arrowLeft[0], false, true);
						_getEl('b', arrowRight[0], false, true);
						_getEl('a', arrowRight[0], false, true);
					***REMOVED***

					mfp.container.append(arrowLeft.add(arrowRight));
				***REMOVED***
			***REMOVED***);

			_mfpOn(CHANGE_EVENT+ns, function() {
				if(mfp._preloadTimeout) clearTimeout(mfp._preloadTimeout);

				mfp._preloadTimeout = setTimeout(function() {
					mfp.preloadNearbyImages();
					mfp._preloadTimeout = null;
				***REMOVED***, 16);		
			***REMOVED***);


			_mfpOn(CLOSE_EVENT+ns, function() {
				_document.off(ns);
				mfp.wrap.off('click'+ns);
			
				if(mfp.arrowLeft && supportsFastClick) {
					mfp.arrowLeft.add(mfp.arrowRight).destroyMfpFastClick();
				***REMOVED***
				mfp.arrowRight = mfp.arrowLeft = null;
			***REMOVED***);

		***REMOVED***, 
		next: function() {
			mfp.direction = true;
			mfp.index = _getLoopedId(mfp.index + 1);
			mfp.updateItemHTML();
		***REMOVED***,
		prev: function() {
			mfp.direction = false;
			mfp.index = _getLoopedId(mfp.index - 1);
			mfp.updateItemHTML();
		***REMOVED***,
		goTo: function(newIndex) {
			mfp.direction = (newIndex >= mfp.index);
			mfp.index = newIndex;
			mfp.updateItemHTML();
		***REMOVED***,
		preloadNearbyImages: function() {
			var p = mfp.st.gallery.preload,
				preloadBefore = Math.min(p[0], mfp.items.length),
				preloadAfter = Math.min(p[1], mfp.items.length),
				i;

			for(i = 1; i <= (mfp.direction ? preloadAfter : preloadBefore); i++) {
				mfp._preloadItem(mfp.index+i);
			***REMOVED***
			for(i = 1; i <= (mfp.direction ? preloadBefore : preloadAfter); i++) {
				mfp._preloadItem(mfp.index-i);
			***REMOVED***
		***REMOVED***,
		_preloadItem: function(index) {
			index = _getLoopedId(index);

			if(mfp.items[index].preloaded) {
				return;
			***REMOVED***

			var item = mfp.items[index];
			if(!item.parsed) {
				item = mfp.parseEl( index );
			***REMOVED***

			_mfpTrigger('LazyLoad', item);

			if(item.type === 'image') {
				item.img = $('<img class="mfp-img" />').on('load.mfploader', function() {
					item.hasSize = true;
				***REMOVED***).on('error.mfploader', function() {
					item.hasSize = true;
					item.loadError = true;
					_mfpTrigger('LazyLoadError', item);
				***REMOVED***).attr('src', item.src);
			***REMOVED***


			item.preloaded = true;
		***REMOVED***
	***REMOVED***
***REMOVED***);

/*
Touch Support that might be implemented some day

addSwipeGesture: function() {
	var startX,
		moved,
		multipleTouches;

		return;

	var namespace = '.mfp',
		addEventNames = function(pref, down, move, up, cancel) {
			mfp._tStart = pref + down + namespace;
			mfp._tMove = pref + move + namespace;
			mfp._tEnd = pref + up + namespace;
			mfp._tCancel = pref + cancel + namespace;
		***REMOVED***;

	if(window.navigator.msPointerEnabled) {
		addEventNames('MSPointer', 'Down', 'Move', 'Up', 'Cancel');
	***REMOVED*** else if('ontouchstart' in window) {
		addEventNames('touch', 'start', 'move', 'end', 'cancel');
	***REMOVED*** else {
		return;
	***REMOVED***
	_window.on(mfp._tStart, function(e) {
		var oE = e.originalEvent;
		multipleTouches = moved = false;
		startX = oE.pageX || oE.changedTouches[0].pageX;
	***REMOVED***).on(mfp._tMove, function(e) {
		if(e.originalEvent.touches.length > 1) {
			multipleTouches = e.originalEvent.touches.length;
		***REMOVED*** else {
			//e.preventDefault();
			moved = true;
		***REMOVED***
	***REMOVED***).on(mfp._tEnd + ' ' + mfp._tCancel, function(e) {
		if(moved && !multipleTouches) {
			var oE = e.originalEvent,
				diff = startX - (oE.pageX || oE.changedTouches[0].pageX);

			if(diff > 20) {
				mfp.next();
			***REMOVED*** else if(diff < -20) {
				mfp.prev();
			***REMOVED***
		***REMOVED***
	***REMOVED***);
***REMOVED***,
*/


/*>>gallery*/

/*>>retina*/

var RETINA_NS = 'retina';

$.magnificPopup.registerModule(RETINA_NS, {
	options: {
		replaceSrc: function(item) {
			return item.src.replace(/\.\w+$/, function(m) { return '@2x' + m; ***REMOVED***);
		***REMOVED***,
		ratio: 1 // Function or number.  Set to 1 to disable.
	***REMOVED***,
	proto: {
		initRetina: function() {
			if(window.devicePixelRatio > 1) {

				var st = mfp.st.retina,
					ratio = st.ratio;

				ratio = !isNaN(ratio) ? ratio : ratio();

				if(ratio > 1) {
					_mfpOn('ImageHasSize' + '.' + RETINA_NS, function(e, item) {
						item.img.css({
							'max-width': item.img[0].naturalWidth / ratio,
							'width': '100%'
						***REMOVED***);
					***REMOVED***);
					_mfpOn('ElementParse' + '.' + RETINA_NS, function(e, item) {
						item.src = st.replaceSrc(item, ratio);
					***REMOVED***);
				***REMOVED***
			***REMOVED***

		***REMOVED***
	***REMOVED***
***REMOVED***);

/*>>retina*/

/*>>fastclick*/
/**
 * FastClick event implementation. (removes 300ms delay on touch devices)
 * Based on https://developers.google.com/mobile/articles/fast_buttons
 *
 * You may use it outside the Magnific Popup by calling just:
 *
 * $('.your-el').mfpFastClick(function() {
 *     console.log('Clicked!');
 * ***REMOVED***);
 *
 * To unbind:
 * $('.your-el').destroyMfpFastClick();
 * 
 * 
 * Note that it's a very basic and simple implementation, it blocks ghost click on the same element where it was bound.
 * If you need something more advanced, use plugin by FT Labs https://github.com/ftlabs/fastclick
 * 
 */

(function() {
	var ghostClickDelay = 1000,
		supportsTouch = 'ontouchstart' in window,
		unbindTouchMove = function() {
			_window.off('touchmove'+ns+' touchend'+ns);
		***REMOVED***,
		eName = 'mfpFastClick',
		ns = '.'+eName;


	// As Zepto.js doesn't have an easy way to add custom events (like jQuery), so we implement it in this way
	$.fn.mfpFastClick = function(callback) {

		return $(this).each(function() {

			var elem = $(this),
				lock;

			if( supportsTouch ) {

				var timeout,
					startX,
					startY,
					pointerMoved,
					point,
					numPointers;

				elem.on('touchstart' + ns, function(e) {
					pointerMoved = false;
					numPointers = 1;

					point = e.originalEvent ? e.originalEvent.touches[0] : e.touches[0];
					startX = point.clientX;
					startY = point.clientY;

					_window.on('touchmove'+ns, function(e) {
						point = e.originalEvent ? e.originalEvent.touches : e.touches;
						numPointers = point.length;
						point = point[0];
						if (Math.abs(point.clientX - startX) > 10 ||
							Math.abs(point.clientY - startY) > 10) {
							pointerMoved = true;
							unbindTouchMove();
						***REMOVED***
					***REMOVED***).on('touchend'+ns, function(e) {
						unbindTouchMove();
						if(pointerMoved || numPointers > 1) {
							return;
						***REMOVED***
						lock = true;
						e.preventDefault();
						clearTimeout(timeout);
						timeout = setTimeout(function() {
							lock = false;
						***REMOVED***, ghostClickDelay);
						callback();
					***REMOVED***);
				***REMOVED***);

			***REMOVED***

			elem.on('click' + ns, function() {
				if(!lock) {
					callback();
				***REMOVED***
			***REMOVED***);
		***REMOVED***);
	***REMOVED***;

	$.fn.destroyMfpFastClick = function() {
		$(this).off('touchstart' + ns + ' click' + ns);
		if(supportsTouch) _window.off('touchmove'+ns+' touchend'+ns);
	***REMOVED***;
***REMOVED***)();

/*>>fastclick*/
 _checkInstance(); ***REMOVED***));