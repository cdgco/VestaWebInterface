define([
	"./core",
	"./core/init",
	"./manipulation", // clone
	"./traversing" // parent, contents
], function( jQuery ) {

jQuery.fn.extend({
	wrapAll: function( html ) {
		var wrap;

		if ( jQuery.isFunction( html ) ) {
			return this.each(function( i ) {
				jQuery( this ).wrapAll( html.call(this, i) );
			***REMOVED***);
		***REMOVED***

		if ( this[ 0 ] ) {

			// The elements to wrap the target around
			wrap = jQuery( html, this[ 0 ].ownerDocument ).eq( 0 ).clone( true );

			if ( this[ 0 ].parentNode ) {
				wrap.insertBefore( this[ 0 ] );
			***REMOVED***

			wrap.map(function() {
				var elem = this;

				while ( elem.firstElementChild ) {
					elem = elem.firstElementChild;
				***REMOVED***

				return elem;
			***REMOVED***).append( this );
		***REMOVED***

		return this;
	***REMOVED***,

	wrapInner: function( html ) {
		if ( jQuery.isFunction( html ) ) {
			return this.each(function( i ) {
				jQuery( this ).wrapInner( html.call(this, i) );
			***REMOVED***);
		***REMOVED***

		return this.each(function() {
			var self = jQuery( this ),
				contents = self.contents();

			if ( contents.length ) {
				contents.wrapAll( html );

			***REMOVED*** else {
				self.append( html );
			***REMOVED***
		***REMOVED***);
	***REMOVED***,

	wrap: function( html ) {
		var isFunction = jQuery.isFunction( html );

		return this.each(function( i ) {
			jQuery( this ).wrapAll( isFunction ? html.call(this, i) : html );
		***REMOVED***);
	***REMOVED***,

	unwrap: function() {
		return this.parent().each(function() {
			if ( !jQuery.nodeName( this, "body" ) ) {
				jQuery( this ).replaceWith( this.childNodes );
			***REMOVED***
		***REMOVED***).end();
	***REMOVED***
***REMOVED***);

return jQuery;
***REMOVED***);
