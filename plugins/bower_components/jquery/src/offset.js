define([
	"./core",
	"./var/strundefined",
	"./core/access",
	"./css/var/rnumnonpx",
	"./css/curCSS",
	"./css/addGetHookIf",
	"./css/support",

	"./core/init",
	"./css",
	"./selector" // contains
], function( jQuery, strundefined, access, rnumnonpx, curCSS, addGetHookIf, support ) {

var docElem = window.document.documentElement;

/**
 * Gets a window from an element
 */
function getWindow( elem ) {
	return jQuery.isWindow( elem ) ? elem : elem.nodeType === 9 && elem.defaultView;
***REMOVED***

jQuery.offset = {
	setOffset: function( elem, options, i ) {
		var curPosition, curLeft, curCSSTop, curTop, curOffset, curCSSLeft, calculatePosition,
			position = jQuery.css( elem, "position" ),
			curElem = jQuery( elem ),
			props = {***REMOVED***;

		// Set position first, in-case top/left are set even on static elem
		if ( position === "static" ) {
			elem.style.position = "relative";
		***REMOVED***

		curOffset = curElem.offset();
		curCSSTop = jQuery.css( elem, "top" );
		curCSSLeft = jQuery.css( elem, "left" );
		calculatePosition = ( position === "absolute" || position === "fixed" ) &&
			( curCSSTop + curCSSLeft ).indexOf("auto") > -1;

		// Need to be able to calculate position if either
		// top or left is auto and position is either absolute or fixed
		if ( calculatePosition ) {
			curPosition = curElem.position();
			curTop = curPosition.top;
			curLeft = curPosition.left;

		***REMOVED*** else {
			curTop = parseFloat( curCSSTop ) || 0;
			curLeft = parseFloat( curCSSLeft ) || 0;
		***REMOVED***

		if ( jQuery.isFunction( options ) ) {
			options = options.call( elem, i, curOffset );
		***REMOVED***

		if ( options.top != null ) {
			props.top = ( options.top - curOffset.top ) + curTop;
		***REMOVED***
		if ( options.left != null ) {
			props.left = ( options.left - curOffset.left ) + curLeft;
		***REMOVED***

		if ( "using" in options ) {
			options.using.call( elem, props );

		***REMOVED*** else {
			curElem.css( props );
		***REMOVED***
	***REMOVED***
***REMOVED***;

jQuery.fn.extend({
	offset: function( options ) {
		if ( arguments.length ) {
			return options === undefined ?
				this :
				this.each(function( i ) {
					jQuery.offset.setOffset( this, options, i );
				***REMOVED***);
		***REMOVED***

		var docElem, win,
			elem = this[ 0 ],
			box = { top: 0, left: 0 ***REMOVED***,
			doc = elem && elem.ownerDocument;

		if ( !doc ) {
			return;
		***REMOVED***

		docElem = doc.documentElement;

		// Make sure it's not a disconnected DOM node
		if ( !jQuery.contains( docElem, elem ) ) {
			return box;
		***REMOVED***

		// Support: BlackBerry 5, iOS 3 (original iPhone)
		// If we don't have gBCR, just use 0,0 rather than error
		if ( typeof elem.getBoundingClientRect !== strundefined ) {
			box = elem.getBoundingClientRect();
		***REMOVED***
		win = getWindow( doc );
		return {
			top: box.top + win.pageYOffset - docElem.clientTop,
			left: box.left + win.pageXOffset - docElem.clientLeft
		***REMOVED***;
	***REMOVED***,

	position: function() {
		if ( !this[ 0 ] ) {
			return;
		***REMOVED***

		var offsetParent, offset,
			elem = this[ 0 ],
			parentOffset = { top: 0, left: 0 ***REMOVED***;

		// Fixed elements are offset from window (parentOffset = {top:0, left: 0***REMOVED***, because it is its only offset parent
		if ( jQuery.css( elem, "position" ) === "fixed" ) {
			// Assume getBoundingClientRect is there when computed position is fixed
			offset = elem.getBoundingClientRect();

		***REMOVED*** else {
			// Get *real* offsetParent
			offsetParent = this.offsetParent();

			// Get correct offsets
			offset = this.offset();
			if ( !jQuery.nodeName( offsetParent[ 0 ], "html" ) ) {
				parentOffset = offsetParent.offset();
			***REMOVED***

			// Add offsetParent borders
			parentOffset.top += jQuery.css( offsetParent[ 0 ], "borderTopWidth", true );
			parentOffset.left += jQuery.css( offsetParent[ 0 ], "borderLeftWidth", true );
		***REMOVED***

		// Subtract parent offsets and element margins
		return {
			top: offset.top - parentOffset.top - jQuery.css( elem, "marginTop", true ),
			left: offset.left - parentOffset.left - jQuery.css( elem, "marginLeft", true )
		***REMOVED***;
	***REMOVED***,

	offsetParent: function() {
		return this.map(function() {
			var offsetParent = this.offsetParent || docElem;

			while ( offsetParent && ( !jQuery.nodeName( offsetParent, "html" ) && jQuery.css( offsetParent, "position" ) === "static" ) ) {
				offsetParent = offsetParent.offsetParent;
			***REMOVED***

			return offsetParent || docElem;
		***REMOVED***);
	***REMOVED***
***REMOVED***);

// Create scrollLeft and scrollTop methods
jQuery.each( { scrollLeft: "pageXOffset", scrollTop: "pageYOffset" ***REMOVED***, function( method, prop ) {
	var top = "pageYOffset" === prop;

	jQuery.fn[ method ] = function( val ) {
		return access( this, function( elem, method, val ) {
			var win = getWindow( elem );

			if ( val === undefined ) {
				return win ? win[ prop ] : elem[ method ];
			***REMOVED***

			if ( win ) {
				win.scrollTo(
					!top ? val : window.pageXOffset,
					top ? val : window.pageYOffset
				);

			***REMOVED*** else {
				elem[ method ] = val;
			***REMOVED***
		***REMOVED***, method, val, arguments.length, null );
	***REMOVED***;
***REMOVED***);

// Support: Safari<7+, Chrome<37+
// Add the top/left cssHooks using jQuery.fn.position
// Webkit bug: https://bugs.webkit.org/show_bug.cgi?id=29084
// Blink bug: https://code.google.com/p/chromium/issues/detail?id=229280
// getComputedStyle returns percent when specified for top/left/bottom/right;
// rather than make the css module depend on the offset module, just check for it here
jQuery.each( [ "top", "left" ], function( i, prop ) {
	jQuery.cssHooks[ prop ] = addGetHookIf( support.pixelPosition,
		function( elem, computed ) {
			if ( computed ) {
				computed = curCSS( elem, prop );
				// If curCSS returns percentage, fallback to offset
				return rnumnonpx.test( computed ) ?
					jQuery( elem ).position()[ prop ] + "px" :
					computed;
			***REMOVED***
		***REMOVED***
	);
***REMOVED***);

return jQuery;
***REMOVED***);
