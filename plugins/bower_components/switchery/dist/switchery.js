
;(function(){

/**
 * Require the module at `name`.
 *
 * @param {String***REMOVED*** name
 * @return {Object***REMOVED*** exports
 * @api public
 */

function require(name) {
  var module = require.modules[name];
  if (!module) throw new Error('failed to require "' + name + '"');

  if (!('exports' in module) && typeof module.definition === 'function') {
    module.client = module.component = true;
    module.definition.call(this, module.exports = {***REMOVED***, module);
    delete module.definition;
  ***REMOVED***

  return module.exports;
***REMOVED***

/**
 * Meta info, accessible in the global scope unless you use AMD option.
 */

require.loader = 'component';

/**
 * Internal helper object, contains a sorting function for semantiv versioning
 */
require.helper = {***REMOVED***;
require.helper.semVerSort = function(a, b) {
  var aArray = a.version.split('.');
  var bArray = b.version.split('.');
  for (var i=0; i<aArray.length; ++i) {
    var aInt = parseInt(aArray[i], 10);
    var bInt = parseInt(bArray[i], 10);
    if (aInt === bInt) {
      var aLex = aArray[i].substr((""+aInt).length);
      var bLex = bArray[i].substr((""+bInt).length);
      if (aLex === '' && bLex !== '') return 1;
      if (aLex !== '' && bLex === '') return -1;
      if (aLex !== '' && bLex !== '') return aLex > bLex ? 1 : -1;
      continue;
    ***REMOVED*** else if (aInt > bInt) {
      return 1;
    ***REMOVED*** else {
      return -1;
    ***REMOVED***
  ***REMOVED***
  return 0;
***REMOVED***

/**
 * Find and require a module which name starts with the provided name.
 * If multiple modules exists, the highest semver is used. 
 * This function can only be used for remote dependencies.

 * @param {String***REMOVED*** name - module name: `user~repo`
 * @param {Boolean***REMOVED*** returnPath - returns the canonical require path if true, 
 *                               otherwise it returns the epxorted module
 */
require.latest = function (name, returnPath) {
  function showError(name) {
    throw new Error('failed to find latest module of "' + name + '"');
  ***REMOVED***
  // only remotes with semvers, ignore local files conataining a '/'
  var versionRegexp = /(.*)~(.*)@v?(\d+\.\d+\.\d+[^\/]*)$/;
  var remoteRegexp = /(.*)~(.*)/;
  if (!remoteRegexp.test(name)) showError(name);
  var moduleNames = Object.keys(require.modules);
  var semVerCandidates = [];
  var otherCandidates = []; // for instance: name of the git branch
  for (var i=0; i<moduleNames.length; i++) {
    var moduleName = moduleNames[i];
    if (new RegExp(name + '@').test(moduleName)) {
        var version = moduleName.substr(name.length+1);
        var semVerMatch = versionRegexp.exec(moduleName);
        if (semVerMatch != null) {
          semVerCandidates.push({version: version, name: moduleName***REMOVED***);
        ***REMOVED*** else {
          otherCandidates.push({version: version, name: moduleName***REMOVED***);
        ***REMOVED*** 
    ***REMOVED***
  ***REMOVED***
  if (semVerCandidates.concat(otherCandidates).length === 0) {
    showError(name);
  ***REMOVED***
  if (semVerCandidates.length > 0) {
    var module = semVerCandidates.sort(require.helper.semVerSort).pop().name;
    if (returnPath === true) {
      return module;
    ***REMOVED***
    return require(module);
  ***REMOVED***
  // if the build contains more than one branch of the same module
  // you should not use this funciton
  var module = otherCandidates.sort(function(a, b) {return a.name > b.name***REMOVED***)[0].name;
  if (returnPath === true) {
    return module;
  ***REMOVED***
  return require(module);
***REMOVED***

/**
 * Registered modules.
 */

require.modules = {***REMOVED***;

/**
 * Register module at `name` with callback `definition`.
 *
 * @param {String***REMOVED*** name
 * @param {Function***REMOVED*** definition
 * @api private
 */

require.register = function (name, definition) {
  require.modules[name] = {
    definition: definition
  ***REMOVED***;
***REMOVED***;

/**
 * Define a module's exports immediately with `exports`.
 *
 * @param {String***REMOVED*** name
 * @param {Generic***REMOVED*** exports
 * @api private
 */

require.define = function (name, exports) {
  require.modules[name] = {
    exports: exports
  ***REMOVED***;
***REMOVED***;
require.register("abpetkov~transitionize@0.0.3", function (exports, module) {

/**
 * Transitionize 0.0.2
 * https://github.com/abpetkov/transitionize
 *
 * Authored by Alexander Petkov
 * https://github.com/abpetkov
 *
 * Copyright 2013, Alexander Petkov
 * License: The MIT License (MIT)
 * http://opensource.org/licenses/MIT
 *
 */

/**
 * Expose `Transitionize`.
 */

module.exports = Transitionize;

/**
 * Initialize new Transitionize.
 *
 * @param {Object***REMOVED*** element
 * @param {Object***REMOVED*** props
 * @api public
 */

function Transitionize(element, props) {
  if (!(this instanceof Transitionize)) return new Transitionize(element, props);

  this.element = element;
  this.props = props || {***REMOVED***;
  this.init();
***REMOVED***

/**
 * Detect if Safari.
 *
 * @returns {Boolean***REMOVED***
 * @api private
 */

Transitionize.prototype.isSafari = function() {
  return (/Safari/).test(navigator.userAgent) && (/Apple Computer/).test(navigator.vendor);
***REMOVED***;

/**
 * Loop though the object and push the keys and values in an array.
 * Apply the CSS3 transition to the element and prefix with -webkit- for Safari.
 *
 * @api private
 */

Transitionize.prototype.init = function() {
  var transitions = [];

  for (var key in this.props) {
    transitions.push(key + ' ' + this.props[key]);
  ***REMOVED***

  this.element.style.transition = transitions.join(', ');
  if (this.isSafari()) this.element.style.webkitTransition = transitions.join(', ');
***REMOVED***;
***REMOVED***);

require.register("ftlabs~fastclick@v0.6.11", function (exports, module) {
/**
 * @preserve FastClick: polyfill to remove click delays on browsers with touch UIs.
 *
 * @version 0.6.11
 * @codingstandard ftlabs-jsv2
 * @copyright The Financial Times Limited [All Rights Reserved]
 * @license MIT License (see LICENSE.txt)
 */

/*jslint browser:true, node:true*/
/*global define, Event, Node*/


/**
 * Instantiate fast-clicking listeners on the specificed layer.
 *
 * @constructor
 * @param {Element***REMOVED*** layer The layer to listen on
 */
function FastClick(layer) {
	'use strict';
	var oldOnClick, self = this;


	/**
	 * Whether a click is currently being tracked.
	 *
	 * @type boolean
	 */
	this.trackingClick = false;


	/**
	 * Timestamp for when when click tracking started.
	 *
	 * @type number
	 */
	this.trackingClickStart = 0;


	/**
	 * The element being tracked for a click.
	 *
	 * @type EventTarget
	 */
	this.targetElement = null;


	/**
	 * X-coordinate of touch start event.
	 *
	 * @type number
	 */
	this.touchStartX = 0;


	/**
	 * Y-coordinate of touch start event.
	 *
	 * @type number
	 */
	this.touchStartY = 0;


	/**
	 * ID of the last touch, retrieved from Touch.identifier.
	 *
	 * @type number
	 */
	this.lastTouchIdentifier = 0;


	/**
	 * Touchmove boundary, beyond which a click will be cancelled.
	 *
	 * @type number
	 */
	this.touchBoundary = 10;


	/**
	 * The FastClick layer.
	 *
	 * @type Element
	 */
	this.layer = layer;

	if (!layer || !layer.nodeType) {
		throw new TypeError('Layer must be a document node');
	***REMOVED***

	/** @type function() */
	this.onClick = function() { return FastClick.prototype.onClick.apply(self, arguments); ***REMOVED***;

	/** @type function() */
	this.onMouse = function() { return FastClick.prototype.onMouse.apply(self, arguments); ***REMOVED***;

	/** @type function() */
	this.onTouchStart = function() { return FastClick.prototype.onTouchStart.apply(self, arguments); ***REMOVED***;

	/** @type function() */
	this.onTouchMove = function() { return FastClick.prototype.onTouchMove.apply(self, arguments); ***REMOVED***;

	/** @type function() */
	this.onTouchEnd = function() { return FastClick.prototype.onTouchEnd.apply(self, arguments); ***REMOVED***;

	/** @type function() */
	this.onTouchCancel = function() { return FastClick.prototype.onTouchCancel.apply(self, arguments); ***REMOVED***;

	if (FastClick.notNeeded(layer)) {
		return;
	***REMOVED***

	// Set up event handlers as required
	if (this.deviceIsAndroid) {
		layer.addEventListener('mouseover', this.onMouse, true);
		layer.addEventListener('mousedown', this.onMouse, true);
		layer.addEventListener('mouseup', this.onMouse, true);
	***REMOVED***

	layer.addEventListener('click', this.onClick, true);
	layer.addEventListener('touchstart', this.onTouchStart, false);
	layer.addEventListener('touchmove', this.onTouchMove, false);
	layer.addEventListener('touchend', this.onTouchEnd, false);
	layer.addEventListener('touchcancel', this.onTouchCancel, false);

	// Hack is required for browsers that don't support Event#stopImmediatePropagation (e.g. Android 2)
	// which is how FastClick normally stops click events bubbling to callbacks registered on the FastClick
	// layer when they are cancelled.
	if (!Event.prototype.stopImmediatePropagation) {
		layer.removeEventListener = function(type, callback, capture) {
			var rmv = Node.prototype.removeEventListener;
			if (type === 'click') {
				rmv.call(layer, type, callback.hijacked || callback, capture);
			***REMOVED*** else {
				rmv.call(layer, type, callback, capture);
			***REMOVED***
		***REMOVED***;

		layer.addEventListener = function(type, callback, capture) {
			var adv = Node.prototype.addEventListener;
			if (type === 'click') {
				adv.call(layer, type, callback.hijacked || (callback.hijacked = function(event) {
					if (!event.propagationStopped) {
						callback(event);
					***REMOVED***
				***REMOVED***), capture);
			***REMOVED*** else {
				adv.call(layer, type, callback, capture);
			***REMOVED***
		***REMOVED***;
	***REMOVED***

	// If a handler is already declared in the element's onclick attribute, it will be fired before
	// FastClick's onClick handler. Fix this by pulling out the user-defined handler function and
	// adding it as listener.
	if (typeof layer.onclick === 'function') {

		// Android browser on at least 3.2 requires a new reference to the function in layer.onclick
		// - the old one won't work if passed to addEventListener directly.
		oldOnClick = layer.onclick;
		layer.addEventListener('click', function(event) {
			oldOnClick(event);
		***REMOVED***, false);
		layer.onclick = null;
	***REMOVED***
***REMOVED***


/**
 * Android requires exceptions.
 *
 * @type boolean
 */
FastClick.prototype.deviceIsAndroid = navigator.userAgent.indexOf('Android') > 0;


/**
 * iOS requires exceptions.
 *
 * @type boolean
 */
FastClick.prototype.deviceIsIOS = /iP(ad|hone|od)/.test(navigator.userAgent);


/**
 * iOS 4 requires an exception for select elements.
 *
 * @type boolean
 */
FastClick.prototype.deviceIsIOS4 = FastClick.prototype.deviceIsIOS && (/OS 4_\d(_\d)?/).test(navigator.userAgent);


/**
 * iOS 6.0(+?) requires the target element to be manually derived
 *
 * @type boolean
 */
FastClick.prototype.deviceIsIOSWithBadTarget = FastClick.prototype.deviceIsIOS && (/OS ([6-9]|\d{2***REMOVED***)_\d/).test(navigator.userAgent);


/**
 * Determine whether a given element requires a native click.
 *
 * @param {EventTarget|Element***REMOVED*** target Target DOM element
 * @returns {boolean***REMOVED*** Returns true if the element needs a native click
 */
FastClick.prototype.needsClick = function(target) {
	'use strict';
	switch (target.nodeName.toLowerCase()) {

	// Don't send a synthetic click to disabled inputs (issue #62)
	case 'button':
	case 'select':
	case 'textarea':
		if (target.disabled) {
			return true;
		***REMOVED***

		break;
	case 'input':

		// File inputs need real clicks on iOS 6 due to a browser bug (issue #68)
		if ((this.deviceIsIOS && target.type === 'file') || target.disabled) {
			return true;
		***REMOVED***

		break;
	case 'label':
	case 'video':
		return true;
	***REMOVED***

	return (/\bneedsclick\b/).test(target.className);
***REMOVED***;


/**
 * Determine whether a given element requires a call to focus to simulate click into element.
 *
 * @param {EventTarget|Element***REMOVED*** target Target DOM element
 * @returns {boolean***REMOVED*** Returns true if the element requires a call to focus to simulate native click.
 */
FastClick.prototype.needsFocus = function(target) {
	'use strict';
	switch (target.nodeName.toLowerCase()) {
	case 'textarea':
		return true;
	case 'select':
		return !this.deviceIsAndroid;
	case 'input':
		switch (target.type) {
		case 'button':
		case 'checkbox':
		case 'file':
		case 'image':
		case 'radio':
		case 'submit':
			return false;
		***REMOVED***

		// No point in attempting to focus disabled inputs
		return !target.disabled && !target.readOnly;
	default:
		return (/\bneedsfocus\b/).test(target.className);
	***REMOVED***
***REMOVED***;


/**
 * Send a click event to the specified element.
 *
 * @param {EventTarget|Element***REMOVED*** targetElement
 * @param {Event***REMOVED*** event
 */
FastClick.prototype.sendClick = function(targetElement, event) {
	'use strict';
	var clickEvent, touch;

	// On some Android devices activeElement needs to be blurred otherwise the synthetic click will have no effect (#24)
	if (document.activeElement && document.activeElement !== targetElement) {
		document.activeElement.blur();
	***REMOVED***

	touch = event.changedTouches[0];

	// Synthesise a click event, with an extra attribute so it can be tracked
	clickEvent = document.createEvent('MouseEvents');
	clickEvent.initMouseEvent(this.determineEventType(targetElement), true, true, window, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, false, false, false, false, 0, null);
	clickEvent.forwardedTouchEvent = true;
	targetElement.dispatchEvent(clickEvent);
***REMOVED***;

FastClick.prototype.determineEventType = function(targetElement) {
	'use strict';

	//Issue #159: Android Chrome Select Box does not open with a synthetic click event
	if (this.deviceIsAndroid && targetElement.tagName.toLowerCase() === 'select') {
		return 'mousedown';
	***REMOVED***

	return 'click';
***REMOVED***;


/**
 * @param {EventTarget|Element***REMOVED*** targetElement
 */
FastClick.prototype.focus = function(targetElement) {
	'use strict';
	var length;

	// Issue #160: on iOS 7, some input elements (e.g. date datetime) throw a vague TypeError on setSelectionRange. These elements don't have an integer value for the selectionStart and selectionEnd properties, but unfortunately that can't be used for detection because accessing the properties also throws a TypeError. Just check the type instead. Filed as Apple bug #15122724.
	if (this.deviceIsIOS && targetElement.setSelectionRange && targetElement.type.indexOf('date') !== 0 && targetElement.type !== 'time') {
		length = targetElement.value.length;
		targetElement.setSelectionRange(length, length);
	***REMOVED*** else {
		targetElement.focus();
	***REMOVED***
***REMOVED***;


/**
 * Check whether the given target element is a child of a scrollable layer and if so, set a flag on it.
 *
 * @param {EventTarget|Element***REMOVED*** targetElement
 */
FastClick.prototype.updateScrollParent = function(targetElement) {
	'use strict';
	var scrollParent, parentElement;

	scrollParent = targetElement.fastClickScrollParent;

	// Attempt to discover whether the target element is contained within a scrollable layer. Re-check if the
	// target element was moved to another parent.
	if (!scrollParent || !scrollParent.contains(targetElement)) {
		parentElement = targetElement;
		do {
			if (parentElement.scrollHeight > parentElement.offsetHeight) {
				scrollParent = parentElement;
				targetElement.fastClickScrollParent = parentElement;
				break;
			***REMOVED***

			parentElement = parentElement.parentElement;
		***REMOVED*** while (parentElement);
	***REMOVED***

	// Always update the scroll top tracker if possible.
	if (scrollParent) {
		scrollParent.fastClickLastScrollTop = scrollParent.scrollTop;
	***REMOVED***
***REMOVED***;


/**
 * @param {EventTarget***REMOVED*** targetElement
 * @returns {Element|EventTarget***REMOVED***
 */
FastClick.prototype.getTargetElementFromEventTarget = function(eventTarget) {
	'use strict';

	// On some older browsers (notably Safari on iOS 4.1 - see issue #56) the event target may be a text node.
	if (eventTarget.nodeType === Node.TEXT_NODE) {
		return eventTarget.parentNode;
	***REMOVED***

	return eventTarget;
***REMOVED***;


/**
 * On touch start, record the position and scroll offset.
 *
 * @param {Event***REMOVED*** event
 * @returns {boolean***REMOVED***
 */
FastClick.prototype.onTouchStart = function(event) {
	'use strict';
	var targetElement, touch, selection;

	// Ignore multiple touches, otherwise pinch-to-zoom is prevented if both fingers are on the FastClick element (issue #111).
	if (event.targetTouches.length > 1) {
		return true;
	***REMOVED***

	targetElement = this.getTargetElementFromEventTarget(event.target);
	touch = event.targetTouches[0];

	if (this.deviceIsIOS) {

		// Only trusted events will deselect text on iOS (issue #49)
		selection = window.getSelection();
		if (selection.rangeCount && !selection.isCollapsed) {
			return true;
		***REMOVED***

		if (!this.deviceIsIOS4) {

			// Weird things happen on iOS when an alert or confirm dialog is opened from a click event callback (issue #23):
			// when the user next taps anywhere else on the page, new touchstart and touchend events are dispatched
			// with the same identifier as the touch event that previously triggered the click that triggered the alert.
			// Sadly, there is an issue on iOS 4 that causes some normal touch events to have the same identifier as an
			// immediately preceeding touch event (issue #52), so this fix is unavailable on that platform.
			if (touch.identifier === this.lastTouchIdentifier) {
				event.preventDefault();
				return false;
			***REMOVED***

			this.lastTouchIdentifier = touch.identifier;

			// If the target element is a child of a scrollable layer (using -webkit-overflow-scrolling: touch) and:
			// 1) the user does a fling scroll on the scrollable layer
			// 2) the user stops the fling scroll with another tap
			// then the event.target of the last 'touchend' event will be the element that was under the user's finger
			// when the fling scroll was started, causing FastClick to send a click event to that layer - unless a check
			// is made to ensure that a parent layer was not scrolled before sending a synthetic click (issue #42).
			this.updateScrollParent(targetElement);
		***REMOVED***
	***REMOVED***

	this.trackingClick = true;
	this.trackingClickStart = event.timeStamp;
	this.targetElement = targetElement;

	this.touchStartX = touch.pageX;
	this.touchStartY = touch.pageY;

	// Prevent phantom clicks on fast double-tap (issue #36)
	if ((event.timeStamp - this.lastClickTime) < 200) {
		event.preventDefault();
	***REMOVED***

	return true;
***REMOVED***;


/**
 * Based on a touchmove event object, check whether the touch has moved past a boundary since it started.
 *
 * @param {Event***REMOVED*** event
 * @returns {boolean***REMOVED***
 */
FastClick.prototype.touchHasMoved = function(event) {
	'use strict';
	var touch = event.changedTouches[0], boundary = this.touchBoundary;

	if (Math.abs(touch.pageX - this.touchStartX) > boundary || Math.abs(touch.pageY - this.touchStartY) > boundary) {
		return true;
	***REMOVED***

	return false;
***REMOVED***;


/**
 * Update the last position.
 *
 * @param {Event***REMOVED*** event
 * @returns {boolean***REMOVED***
 */
FastClick.prototype.onTouchMove = function(event) {
	'use strict';
	if (!this.trackingClick) {
		return true;
	***REMOVED***

	// If the touch has moved, cancel the click tracking
	if (this.targetElement !== this.getTargetElementFromEventTarget(event.target) || this.touchHasMoved(event)) {
		this.trackingClick = false;
		this.targetElement = null;
	***REMOVED***

	return true;
***REMOVED***;


/**
 * Attempt to find the labelled control for the given label element.
 *
 * @param {EventTarget|HTMLLabelElement***REMOVED*** labelElement
 * @returns {Element|null***REMOVED***
 */
FastClick.prototype.findControl = function(labelElement) {
	'use strict';

	// Fast path for newer browsers supporting the HTML5 control attribute
	if (labelElement.control !== undefined) {
		return labelElement.control;
	***REMOVED***

	// All browsers under test that support touch events also support the HTML5 htmlFor attribute
	if (labelElement.htmlFor) {
		return document.getElementById(labelElement.htmlFor);
	***REMOVED***

	// If no for attribute exists, attempt to retrieve the first labellable descendant element
	// the list of which is defined here: http://www.w3.org/TR/html5/forms.html#category-label
	return labelElement.querySelector('button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea');
***REMOVED***;


/**
 * On touch end, determine whether to send a click event at once.
 *
 * @param {Event***REMOVED*** event
 * @returns {boolean***REMOVED***
 */
FastClick.prototype.onTouchEnd = function(event) {
	'use strict';
	var forElement, trackingClickStart, targetTagName, scrollParent, touch, targetElement = this.targetElement;

	if (!this.trackingClick) {
		return true;
	***REMOVED***

	// Prevent phantom clicks on fast double-tap (issue #36)
	if ((event.timeStamp - this.lastClickTime) < 200) {
		this.cancelNextClick = true;
		return true;
	***REMOVED***

	// Reset to prevent wrong click cancel on input (issue #156).
	this.cancelNextClick = false;

	this.lastClickTime = event.timeStamp;

	trackingClickStart = this.trackingClickStart;
	this.trackingClick = false;
	this.trackingClickStart = 0;

	// On some iOS devices, the targetElement supplied with the event is invalid if the layer
	// is performing a transition or scroll, and has to be re-detected manually. Note that
	// for this to function correctly, it must be called *after* the event target is checked!
	// See issue #57; also filed as rdar://13048589 .
	if (this.deviceIsIOSWithBadTarget) {
		touch = event.changedTouches[0];

		// In certain cases arguments of elementFromPoint can be negative, so prevent setting targetElement to null
		targetElement = document.elementFromPoint(touch.pageX - window.pageXOffset, touch.pageY - window.pageYOffset) || targetElement;
		targetElement.fastClickScrollParent = this.targetElement.fastClickScrollParent;
	***REMOVED***

	targetTagName = targetElement.tagName.toLowerCase();
	if (targetTagName === 'label') {
		forElement = this.findControl(targetElement);
		if (forElement) {
			this.focus(targetElement);
			if (this.deviceIsAndroid) {
				return false;
			***REMOVED***

			targetElement = forElement;
		***REMOVED***
	***REMOVED*** else if (this.needsFocus(targetElement)) {

		// Case 1: If the touch started a while ago (best guess is 100ms based on tests for issue #36) then focus will be triggered anyway. Return early and unset the target element reference so that the subsequent click will be allowed through.
		// Case 2: Without this exception for input elements tapped when the document is contained in an iframe, then any inputted text won't be visible even though the value attribute is updated as the user types (issue #37).
		if ((event.timeStamp - trackingClickStart) > 100 || (this.deviceIsIOS && window.top !== window && targetTagName === 'input')) {
			this.targetElement = null;
			return false;
		***REMOVED***

		this.focus(targetElement);

		// Select elements need the event to go through on iOS 4, otherwise the selector menu won't open.
		if (!this.deviceIsIOS4 || targetTagName !== 'select') {
			this.targetElement = null;
			event.preventDefault();
		***REMOVED***

		return false;
	***REMOVED***

	if (this.deviceIsIOS && !this.deviceIsIOS4) {

		// Don't send a synthetic click event if the target element is contained within a parent layer that was scrolled
		// and this tap is being used to stop the scrolling (usually initiated by a fling - issue #42).
		scrollParent = targetElement.fastClickScrollParent;
		if (scrollParent && scrollParent.fastClickLastScrollTop !== scrollParent.scrollTop) {
			return true;
		***REMOVED***
	***REMOVED***

	// Prevent the actual click from going though - unless the target node is marked as requiring
	// real clicks or if it is in the whitelist in which case only non-programmatic clicks are permitted.
	if (!this.needsClick(targetElement)) {
		event.preventDefault();
		this.sendClick(targetElement, event);
	***REMOVED***

	return false;
***REMOVED***;


/**
 * On touch cancel, stop tracking the click.
 *
 * @returns {void***REMOVED***
 */
FastClick.prototype.onTouchCancel = function() {
	'use strict';
	this.trackingClick = false;
	this.targetElement = null;
***REMOVED***;


/**
 * Determine mouse events which should be permitted.
 *
 * @param {Event***REMOVED*** event
 * @returns {boolean***REMOVED***
 */
FastClick.prototype.onMouse = function(event) {
	'use strict';

	// If a target element was never set (because a touch event was never fired) allow the event
	if (!this.targetElement) {
		return true;
	***REMOVED***

	if (event.forwardedTouchEvent) {
		return true;
	***REMOVED***

	// Programmatically generated events targeting a specific element should be permitted
	if (!event.cancelable) {
		return true;
	***REMOVED***

	// Derive and check the target element to see whether the mouse event needs to be permitted;
	// unless explicitly enabled, prevent non-touch click events from triggering actions,
	// to prevent ghost/doubleclicks.
	if (!this.needsClick(this.targetElement) || this.cancelNextClick) {

		// Prevent any user-added listeners declared on FastClick element from being fired.
		if (event.stopImmediatePropagation) {
			event.stopImmediatePropagation();
		***REMOVED*** else {

			// Part of the hack for browsers that don't support Event#stopImmediatePropagation (e.g. Android 2)
			event.propagationStopped = true;
		***REMOVED***

		// Cancel the event
		event.stopPropagation();
		event.preventDefault();

		return false;
	***REMOVED***

	// If the mouse event is permitted, return true for the action to go through.
	return true;
***REMOVED***;


/**
 * On actual clicks, determine whether this is a touch-generated click, a click action occurring
 * naturally after a delay after a touch (which needs to be cancelled to avoid duplication), or
 * an actual click which should be permitted.
 *
 * @param {Event***REMOVED*** event
 * @returns {boolean***REMOVED***
 */
FastClick.prototype.onClick = function(event) {
	'use strict';
	var permitted;

	// It's possible for another FastClick-like library delivered with third-party code to fire a click event before FastClick does (issue #44). In that case, set the click-tracking flag back to false and return early. This will cause onTouchEnd to return early.
	if (this.trackingClick) {
		this.targetElement = null;
		this.trackingClick = false;
		return true;
	***REMOVED***

	// Very odd behaviour on iOS (issue #18): if a submit element is present inside a form and the user hits enter in the iOS simulator or clicks the Go button on the pop-up OS keyboard the a kind of 'fake' click event will be triggered with the submit-type input element as the target.
	if (event.target.type === 'submit' && event.detail === 0) {
		return true;
	***REMOVED***

	permitted = this.onMouse(event);

	// Only unset targetElement if the click is not permitted. This will ensure that the check for !targetElement in onMouse fails and the browser's click doesn't go through.
	if (!permitted) {
		this.targetElement = null;
	***REMOVED***

	// If clicks are permitted, return true for the action to go through.
	return permitted;
***REMOVED***;


/**
 * Remove all FastClick's event listeners.
 *
 * @returns {void***REMOVED***
 */
FastClick.prototype.destroy = function() {
	'use strict';
	var layer = this.layer;

	if (this.deviceIsAndroid) {
		layer.removeEventListener('mouseover', this.onMouse, true);
		layer.removeEventListener('mousedown', this.onMouse, true);
		layer.removeEventListener('mouseup', this.onMouse, true);
	***REMOVED***

	layer.removeEventListener('click', this.onClick, true);
	layer.removeEventListener('touchstart', this.onTouchStart, false);
	layer.removeEventListener('touchmove', this.onTouchMove, false);
	layer.removeEventListener('touchend', this.onTouchEnd, false);
	layer.removeEventListener('touchcancel', this.onTouchCancel, false);
***REMOVED***;


/**
 * Check whether FastClick is needed.
 *
 * @param {Element***REMOVED*** layer The layer to listen on
 */
FastClick.notNeeded = function(layer) {
	'use strict';
	var metaViewport;
	var chromeVersion;

	// Devices that don't support touch don't need FastClick
	if (typeof window.ontouchstart === 'undefined') {
		return true;
	***REMOVED***

	// Chrome version - zero for other browsers
	chromeVersion = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [,0])[1];

	if (chromeVersion) {

		if (FastClick.prototype.deviceIsAndroid) {
			metaViewport = document.querySelector('meta[name=viewport]');
			
			if (metaViewport) {
				// Chrome on Android with user-scalable="no" doesn't need FastClick (issue #89)
				if (metaViewport.content.indexOf('user-scalable=no') !== -1) {
					return true;
				***REMOVED***
				// Chrome 32 and above with width=device-width or less don't need FastClick
				if (chromeVersion > 31 && window.innerWidth <= window.screen.width) {
					return true;
				***REMOVED***
			***REMOVED***

		// Chrome desktop doesn't need FastClick (issue #15)
		***REMOVED*** else {
			return true;
		***REMOVED***
	***REMOVED***

	// IE10 with -ms-touch-action: none, which disables double-tap-to-zoom (issue #97)
	if (layer.style.msTouchAction === 'none') {
		return true;
	***REMOVED***

	return false;
***REMOVED***;


/**
 * Factory method for creating a FastClick object
 *
 * @param {Element***REMOVED*** layer The layer to listen on
 */
FastClick.attach = function(layer) {
	'use strict';
	return new FastClick(layer);
***REMOVED***;


if (typeof define !== 'undefined' && define.amd) {

	// AMD. Register as an anonymous module.
	define(function() {
		'use strict';
		return FastClick;
	***REMOVED***);
***REMOVED*** else if (typeof module !== 'undefined' && module.exports) {
	module.exports = FastClick.attach;
	module.exports.FastClick = FastClick;
***REMOVED*** else {
	window.FastClick = FastClick;
***REMOVED***

***REMOVED***);

require.register("component~indexof@0.0.3", function (exports, module) {
module.exports = function(arr, obj){
  if (arr.indexOf) return arr.indexOf(obj);
  for (var i = 0; i < arr.length; ++i) {
    if (arr[i] === obj) return i;
  ***REMOVED***
  return -1;
***REMOVED***;
***REMOVED***);

require.register("component~classes@1.2.1", function (exports, module) {
/**
 * Module dependencies.
 */

var index = require('component~indexof@0.0.3');

/**
 * Whitespace regexp.
 */

var re = /\s+/;

/**
 * toString reference.
 */

var toString = Object.prototype.toString;

/**
 * Wrap `el` in a `ClassList`.
 *
 * @param {Element***REMOVED*** el
 * @return {ClassList***REMOVED***
 * @api public
 */

module.exports = function(el){
  return new ClassList(el);
***REMOVED***;

/**
 * Initialize a new ClassList for `el`.
 *
 * @param {Element***REMOVED*** el
 * @api private
 */

function ClassList(el) {
  if (!el) throw new Error('A DOM element reference is required');
  this.el = el;
  this.list = el.classList;
***REMOVED***

/**
 * Add class `name` if not already present.
 *
 * @param {String***REMOVED*** name
 * @return {ClassList***REMOVED***
 * @api public
 */

ClassList.prototype.add = function(name){
  // classList
  if (this.list) {
    this.list.add(name);
    return this;
  ***REMOVED***

  // fallback
  var arr = this.array();
  var i = index(arr, name);
  if (!~i) arr.push(name);
  this.el.className = arr.join(' ');
  return this;
***REMOVED***;

/**
 * Remove class `name` when present, or
 * pass a regular expression to remove
 * any which match.
 *
 * @param {String|RegExp***REMOVED*** name
 * @return {ClassList***REMOVED***
 * @api public
 */

ClassList.prototype.remove = function(name){
  if ('[object RegExp]' == toString.call(name)) {
    return this.removeMatching(name);
  ***REMOVED***

  // classList
  if (this.list) {
    this.list.remove(name);
    return this;
  ***REMOVED***

  // fallback
  var arr = this.array();
  var i = index(arr, name);
  if (~i) arr.splice(i, 1);
  this.el.className = arr.join(' ');
  return this;
***REMOVED***;

/**
 * Remove all classes matching `re`.
 *
 * @param {RegExp***REMOVED*** re
 * @return {ClassList***REMOVED***
 * @api private
 */

ClassList.prototype.removeMatching = function(re){
  var arr = this.array();
  for (var i = 0; i < arr.length; i++) {
    if (re.test(arr[i])) {
      this.remove(arr[i]);
    ***REMOVED***
  ***REMOVED***
  return this;
***REMOVED***;

/**
 * Toggle class `name`, can force state via `force`.
 *
 * For browsers that support classList, but do not support `force` yet,
 * the mistake will be detected and corrected.
 *
 * @param {String***REMOVED*** name
 * @param {Boolean***REMOVED*** force
 * @return {ClassList***REMOVED***
 * @api public
 */

ClassList.prototype.toggle = function(name, force){
  // classList
  if (this.list) {
    if ("undefined" !== typeof force) {
      if (force !== this.list.toggle(name, force)) {
        this.list.toggle(name); // toggle again to correct
      ***REMOVED***
    ***REMOVED*** else {
      this.list.toggle(name);
    ***REMOVED***
    return this;
  ***REMOVED***

  // fallback
  if ("undefined" !== typeof force) {
    if (!force) {
      this.remove(name);
    ***REMOVED*** else {
      this.add(name);
    ***REMOVED***
  ***REMOVED*** else {
    if (this.has(name)) {
      this.remove(name);
    ***REMOVED*** else {
      this.add(name);
    ***REMOVED***
  ***REMOVED***

  return this;
***REMOVED***;

/**
 * Return an array of classes.
 *
 * @return {Array***REMOVED***
 * @api public
 */

ClassList.prototype.array = function(){
  var str = this.el.className.replace(/^\s+|\s+$/g, '');
  var arr = str.split(re);
  if ('' === arr[0]) arr.shift();
  return arr;
***REMOVED***;

/**
 * Check if class `name` is present.
 *
 * @param {String***REMOVED*** name
 * @return {ClassList***REMOVED***
 * @api public
 */

ClassList.prototype.has =
ClassList.prototype.contains = function(name){
  return this.list
    ? this.list.contains(name)
    : !! ~index(this.array(), name);
***REMOVED***;

***REMOVED***);

require.register("component~event@0.1.4", function (exports, module) {
var bind = window.addEventListener ? 'addEventListener' : 'attachEvent',
    unbind = window.removeEventListener ? 'removeEventListener' : 'detachEvent',
    prefix = bind !== 'addEventListener' ? 'on' : '';

/**
 * Bind `el` event `type` to `fn`.
 *
 * @param {Element***REMOVED*** el
 * @param {String***REMOVED*** type
 * @param {Function***REMOVED*** fn
 * @param {Boolean***REMOVED*** capture
 * @return {Function***REMOVED***
 * @api public
 */

exports.bind = function(el, type, fn, capture){
  el[bind](prefix + type, fn, capture || false);
  return fn;
***REMOVED***;

/**
 * Unbind `el` event `type`'s callback `fn`.
 *
 * @param {Element***REMOVED*** el
 * @param {String***REMOVED*** type
 * @param {Function***REMOVED*** fn
 * @param {Boolean***REMOVED*** capture
 * @return {Function***REMOVED***
 * @api public
 */

exports.unbind = function(el, type, fn, capture){
  el[unbind](prefix + type, fn, capture || false);
  return fn;
***REMOVED***;
***REMOVED***);

require.register("component~query@0.0.3", function (exports, module) {
function one(selector, el) {
  return el.querySelector(selector);
***REMOVED***

exports = module.exports = function(selector, el){
  el = el || document;
  return one(selector, el);
***REMOVED***;

exports.all = function(selector, el){
  el = el || document;
  return el.querySelectorAll(selector);
***REMOVED***;

exports.engine = function(obj){
  if (!obj.one) throw new Error('.one callback required');
  if (!obj.all) throw new Error('.all callback required');
  one = obj.one;
  exports.all = obj.all;
  return exports;
***REMOVED***;

***REMOVED***);

require.register("component~matches-selector@0.1.5", function (exports, module) {
/**
 * Module dependencies.
 */

var query = require('component~query@0.0.3');

/**
 * Element prototype.
 */

var proto = Element.prototype;

/**
 * Vendor function.
 */

var vendor = proto.matches
  || proto.webkitMatchesSelector
  || proto.mozMatchesSelector
  || proto.msMatchesSelector
  || proto.oMatchesSelector;

/**
 * Expose `match()`.
 */

module.exports = match;

/**
 * Match `el` to `selector`.
 *
 * @param {Element***REMOVED*** el
 * @param {String***REMOVED*** selector
 * @return {Boolean***REMOVED***
 * @api public
 */

function match(el, selector) {
  if (!el || el.nodeType !== 1) return false;
  if (vendor) return vendor.call(el, selector);
  var nodes = query.all(selector, el.parentNode);
  for (var i = 0; i < nodes.length; ++i) {
    if (nodes[i] == el) return true;
  ***REMOVED***
  return false;
***REMOVED***

***REMOVED***);

require.register("component~closest@0.1.4", function (exports, module) {
var matches = require('component~matches-selector@0.1.5')

module.exports = function (element, selector, checkYoSelf, root) {
  element = checkYoSelf ? {parentNode: element***REMOVED*** : element

  root = root || document

  // Make sure `element !== document` and `element != null`
  // otherwise we get an illegal invocation
  while ((element = element.parentNode) && element !== document) {
    if (matches(element, selector))
      return element
    // After `matches` on the edge case that
    // the selector matches the root
    // (when the root is not the document)
    if (element === root)
      return
  ***REMOVED***
***REMOVED***

***REMOVED***);

require.register("component~delegate@0.2.3", function (exports, module) {
/**
 * Module dependencies.
 */

var closest = require('component~closest@0.1.4')
  , event = require('component~event@0.1.4');

/**
 * Delegate event `type` to `selector`
 * and invoke `fn(e)`. A callback function
 * is returned which may be passed to `.unbind()`.
 *
 * @param {Element***REMOVED*** el
 * @param {String***REMOVED*** selector
 * @param {String***REMOVED*** type
 * @param {Function***REMOVED*** fn
 * @param {Boolean***REMOVED*** capture
 * @return {Function***REMOVED***
 * @api public
 */

exports.bind = function(el, selector, type, fn, capture){
  return event.bind(el, type, function(e){
    var target = e.target || e.srcElement;
    e.delegateTarget = closest(target, selector, true, el);
    if (e.delegateTarget) fn.call(el, e);
  ***REMOVED***, capture);
***REMOVED***;

/**
 * Unbind event `type`'s callback `fn`.
 *
 * @param {Element***REMOVED*** el
 * @param {String***REMOVED*** type
 * @param {Function***REMOVED*** fn
 * @param {Boolean***REMOVED*** capture
 * @api public
 */

exports.unbind = function(el, type, fn, capture){
  event.unbind(el, type, fn, capture);
***REMOVED***;

***REMOVED***);

require.register("component~events@1.0.9", function (exports, module) {

/**
 * Module dependencies.
 */

var events = require('component~event@0.1.4');
var delegate = require('component~delegate@0.2.3');

/**
 * Expose `Events`.
 */

module.exports = Events;

/**
 * Initialize an `Events` with the given
 * `el` object which events will be bound to,
 * and the `obj` which will receive method calls.
 *
 * @param {Object***REMOVED*** el
 * @param {Object***REMOVED*** obj
 * @api public
 */

function Events(el, obj) {
  if (!(this instanceof Events)) return new Events(el, obj);
  if (!el) throw new Error('element required');
  if (!obj) throw new Error('object required');
  this.el = el;
  this.obj = obj;
  this._events = {***REMOVED***;
***REMOVED***

/**
 * Subscription helper.
 */

Events.prototype.sub = function(event, method, cb){
  this._events[event] = this._events[event] || {***REMOVED***;
  this._events[event][method] = cb;
***REMOVED***;

/**
 * Bind to `event` with optional `method` name.
 * When `method` is undefined it becomes `event`
 * with the "on" prefix.
 *
 * Examples:
 *
 *  Direct event handling:
 *
 *    events.bind('click') // implies "onclick"
 *    events.bind('click', 'remove')
 *    events.bind('click', 'sort', 'asc')
 *
 *  Delegated event handling:
 *
 *    events.bind('click li > a')
 *    events.bind('click li > a', 'remove')
 *    events.bind('click a.sort-ascending', 'sort', 'asc')
 *    events.bind('click a.sort-descending', 'sort', 'desc')
 *
 * @param {String***REMOVED*** event
 * @param {String|function***REMOVED*** [method]
 * @return {Function***REMOVED*** callback
 * @api public
 */

Events.prototype.bind = function(event, method){
  var e = parse(event);
  var el = this.el;
  var obj = this.obj;
  var name = e.name;
  var method = method || 'on' + name;
  var args = [].slice.call(arguments, 2);

  // callback
  function cb(){
    var a = [].slice.call(arguments).concat(args);
    obj[method].apply(obj, a);
  ***REMOVED***

  // bind
  if (e.selector) {
    cb = delegate.bind(el, e.selector, name, cb);
  ***REMOVED*** else {
    events.bind(el, name, cb);
  ***REMOVED***

  // subscription for unbinding
  this.sub(name, method, cb);

  return cb;
***REMOVED***;

/**
 * Unbind a single binding, all bindings for `event`,
 * or all bindings within the manager.
 *
 * Examples:
 *
 *  Unbind direct handlers:
 *
 *     events.unbind('click', 'remove')
 *     events.unbind('click')
 *     events.unbind()
 *
 * Unbind delegate handlers:
 *
 *     events.unbind('click', 'remove')
 *     events.unbind('click')
 *     events.unbind()
 *
 * @param {String|Function***REMOVED*** [event]
 * @param {String|Function***REMOVED*** [method]
 * @api public
 */

Events.prototype.unbind = function(event, method){
  if (0 == arguments.length) return this.unbindAll();
  if (1 == arguments.length) return this.unbindAllOf(event);

  // no bindings for this event
  var bindings = this._events[event];
  if (!bindings) return;

  // no bindings for this method
  var cb = bindings[method];
  if (!cb) return;

  events.unbind(this.el, event, cb);
***REMOVED***;

/**
 * Unbind all events.
 *
 * @api private
 */

Events.prototype.unbindAll = function(){
  for (var event in this._events) {
    this.unbindAllOf(event);
  ***REMOVED***
***REMOVED***;

/**
 * Unbind all events for `event`.
 *
 * @param {String***REMOVED*** event
 * @api private
 */

Events.prototype.unbindAllOf = function(event){
  var bindings = this._events[event];
  if (!bindings) return;

  for (var method in bindings) {
    this.unbind(event, method);
  ***REMOVED***
***REMOVED***;

/**
 * Parse `event`.
 *
 * @param {String***REMOVED*** event
 * @return {Object***REMOVED***
 * @api private
 */

function parse(event) {
  var parts = event.split(/ +/);
  return {
    name: parts.shift(),
    selector: parts.join(' ')
  ***REMOVED***
***REMOVED***

***REMOVED***);

require.register("switchery", function (exports, module) {
/**
 * Switchery 0.8.1
 * http://abpetkov.github.io/switchery/
 *
 * Authored by Alexander Petkov
 * https://github.com/abpetkov
 *
 * Copyright 2013-2015, Alexander Petkov
 * License: The MIT License (MIT)
 * http://opensource.org/licenses/MIT
 *
 */

/**
 * External dependencies.
 */

var transitionize = require('abpetkov~transitionize@0.0.3')
  , fastclick = require('ftlabs~fastclick@v0.6.11')
  , classes = require('component~classes@1.2.1')
  , events = require('component~events@1.0.9');

/**
 * Expose `Switchery`.
 */

module.exports = Switchery;

/**
 * Set Switchery default values.
 *
 * @api public
 */

var defaults = {
    color             : '#64bd63'
  , secondaryColor    : '#dfdfdf'
  , jackColor         : '#fff'
  , jackSecondaryColor: null
  , className         : 'switchery'
  , disabled          : false
  , disabledOpacity   : 0.5
  , speed             : '0.4s'
  , size              : 'default'
***REMOVED***;

/**
 * Create Switchery object.
 *
 * @param {Object***REMOVED*** element
 * @param {Object***REMOVED*** options
 * @api public
 */

function Switchery(element, options) {
  if (!(this instanceof Switchery)) return new Switchery(element, options);

  this.element = element;
  this.options = options || {***REMOVED***;

  for (var i in defaults) {
    if (this.options[i] == null) {
      this.options[i] = defaults[i];
    ***REMOVED***
  ***REMOVED***

  if (this.element != null && this.element.type == 'checkbox') this.init();
  if (this.isDisabled() === true) this.disable();
***REMOVED***

/**
 * Hide the target element.
 *
 * @api private
 */

Switchery.prototype.hide = function() {
  this.element.style.display = 'none';
***REMOVED***;

/**
 * Show custom switch after the target element.
 *
 * @api private
 */

Switchery.prototype.show = function() {
  var switcher = this.create();
  this.insertAfter(this.element, switcher);
***REMOVED***;

/**
 * Create custom switch.
 *
 * @returns {Object***REMOVED*** this.switcher
 * @api private
 */

Switchery.prototype.create = function() {
  this.switcher = document.createElement('span');
  this.jack = document.createElement('small');
  this.switcher.appendChild(this.jack);
  this.switcher.className = this.options.className;
  this.events = events(this.switcher, this);

  return this.switcher;
***REMOVED***;

/**
 * Insert after element after another element.
 *
 * @param {Object***REMOVED*** reference
 * @param {Object***REMOVED*** target
 * @api private
 */

Switchery.prototype.insertAfter = function(reference, target) {
  reference.parentNode.insertBefore(target, reference.nextSibling);
***REMOVED***;

/**
 * Set switch jack proper position.
 *
 * @param {Boolean***REMOVED*** clicked - we need this in order to uncheck the input when the switch is clicked
 * @api private
 */

Switchery.prototype.setPosition = function (clicked) {
  var checked = this.isChecked()
    , switcher = this.switcher
    , jack = this.jack;

  if (clicked && checked) checked = false;
  else if (clicked && !checked) checked = true;

  if (checked === true) {
    this.element.checked = true;

    if (window.getComputedStyle) jack.style.left = parseInt(window.getComputedStyle(switcher).width) - parseInt(window.getComputedStyle(jack).width) + 'px';
    else jack.style.left = parseInt(switcher.currentStyle['width']) - parseInt(jack.currentStyle['width']) + 'px';

    if (this.options.color) this.colorize();
    this.setSpeed();
  ***REMOVED*** else {
    jack.style.left = 0;
    this.element.checked = false;
    this.switcher.style.boxShadow = 'inset 0 0 0 0 ' + this.options.secondaryColor;
    this.switcher.style.borderColor = this.options.secondaryColor;
    this.switcher.style.backgroundColor = (this.options.secondaryColor !== defaults.secondaryColor) ? this.options.secondaryColor : '#fff';
    this.jack.style.backgroundColor = (this.options.jackSecondaryColor !== this.options.jackColor) ? this.options.jackSecondaryColor : this.options.jackColor;
    this.setSpeed();
  ***REMOVED***
***REMOVED***;

/**
 * Set speed.
 *
 * @api private
 */

Switchery.prototype.setSpeed = function() {
  var switcherProp = {***REMOVED***
    , jackProp = {
        'background-color': this.options.speed
      , 'left': this.options.speed.replace(/[a-z]/, '') / 2 + 's'
    ***REMOVED***;

  if (this.isChecked()) {
    switcherProp = {
        'border': this.options.speed
      , 'box-shadow': this.options.speed
      , 'background-color': this.options.speed.replace(/[a-z]/, '') * 3 + 's'
    ***REMOVED***;
  ***REMOVED*** else {
    switcherProp = {
        'border': this.options.speed
      , 'box-shadow': this.options.speed
    ***REMOVED***;
  ***REMOVED***

  transitionize(this.switcher, switcherProp);
  transitionize(this.jack, jackProp);
***REMOVED***;

/**
 * Set switch size.
 *
 * @api private
 */

Switchery.prototype.setSize = function() {
  var small = 'switchery-small'
    , normal = 'switchery-default'
    , large = 'switchery-large';

  switch (this.options.size) {
    case 'small':
      classes(this.switcher).add(small)
      break;
    case 'large':
      classes(this.switcher).add(large)
      break;
    default:
      classes(this.switcher).add(normal)
      break;
  ***REMOVED***
***REMOVED***;

/**
 * Set switch color.
 *
 * @api private
 */

Switchery.prototype.colorize = function() {
  var switcherHeight = this.switcher.offsetHeight / 2;

  this.switcher.style.backgroundColor = this.options.color;
  this.switcher.style.borderColor = this.options.color;
  this.switcher.style.boxShadow = 'inset 0 0 0 ' + switcherHeight + 'px ' + this.options.color;
  this.jack.style.backgroundColor = this.options.jackColor;
***REMOVED***;

/**
 * Handle the onchange event.
 *
 * @param {Boolean***REMOVED*** state
 * @api private
 */

Switchery.prototype.handleOnchange = function(state) {
  if (document.dispatchEvent) {
    var event = document.createEvent('HTMLEvents');
    event.initEvent('change', true, true);
    this.element.dispatchEvent(event);
  ***REMOVED*** else {
    this.element.fireEvent('onchange');
  ***REMOVED***
***REMOVED***;

/**
 * Handle the native input element state change.
 * A `change` event must be fired in order to detect the change.
 *
 * @api private
 */

Switchery.prototype.handleChange = function() {
  var self = this
    , el = this.element;

  if (el.addEventListener) {
    el.addEventListener('change', function() {
      self.setPosition();
    ***REMOVED***);
  ***REMOVED*** else {
    el.attachEvent('onchange', function() {
      self.setPosition();
    ***REMOVED***);
  ***REMOVED***
***REMOVED***;

/**
 * Handle the switch click event.
 *
 * @api private
 */

Switchery.prototype.handleClick = function() {
  var switcher = this.switcher;

  fastclick(switcher);
  this.events.bind('click', 'bindClick');
***REMOVED***;

/**
 * Attach all methods that need to happen on switcher click.
 *
 * @api private
 */

Switchery.prototype.bindClick = function() {
  var parent = this.element.parentNode.tagName.toLowerCase()
    , labelParent = (parent === 'label') ? false : true;

  this.setPosition(labelParent);
  this.handleOnchange(this.element.checked);
***REMOVED***;

/**
 * Mark an individual switch as already handled.
 *
 * @api private
 */

Switchery.prototype.markAsSwitched = function() {
  this.element.setAttribute('data-switchery', true);
***REMOVED***;

/**
 * Check if an individual switch is already handled.
 *
 * @api private
 */

Switchery.prototype.markedAsSwitched = function() {
  return this.element.getAttribute('data-switchery');
***REMOVED***;

/**
 * Initialize Switchery.
 *
 * @api private
 */

Switchery.prototype.init = function() {
  this.hide();
  this.show();
  this.setSize();
  this.setPosition();
  this.markAsSwitched();
  this.handleChange();
  this.handleClick();
***REMOVED***;

/**
 * See if input is checked.
 *
 * @returns {Boolean***REMOVED***
 * @api public
 */

Switchery.prototype.isChecked = function() {
  return this.element.checked;
***REMOVED***;

/**
 * See if switcher should be disabled.
 *
 * @returns {Boolean***REMOVED***
 * @api public
 */

Switchery.prototype.isDisabled = function() {
  return this.options.disabled || this.element.disabled || this.element.readOnly;
***REMOVED***;

/**
 * Destroy all event handlers attached to the switch.
 *
 * @api public
 */

Switchery.prototype.destroy = function() {
  this.events.unbind();
***REMOVED***;

/**
 * Enable disabled switch element.
 *
 * @api public
 */

Switchery.prototype.enable = function() {
  if (this.options.disabled) this.options.disabled = false;
  if (this.element.disabled) this.element.disabled = false;
  if (this.element.readOnly) this.element.readOnly = false;
  this.switcher.style.opacity = 1;
  this.events.bind('click', 'bindClick');
***REMOVED***;

/**
 * Disable switch element.
 *
 * @api public
 */

Switchery.prototype.disable = function() {
  if (!this.options.disabled) this.options.disabled = true;
  if (!this.element.disabled) this.element.disabled = true;
  if (!this.element.readOnly) this.element.readOnly = true;
  this.switcher.style.opacity = this.options.disabledOpacity;
  this.destroy();
***REMOVED***;

***REMOVED***);

if (typeof exports == "object") {
  module.exports = require("switchery");
***REMOVED*** else if (typeof define == "function" && define.amd) {
  define("Switchery", [], function(){ return require("switchery"); ***REMOVED***);
***REMOVED*** else {
  (this || window)["Switchery"] = require("switchery");
***REMOVED***
***REMOVED***)()
