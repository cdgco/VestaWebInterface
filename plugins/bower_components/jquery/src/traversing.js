define([
	"./core",
	"./var/indexOf",
	"./traversing/var/rneedsContext",
	"./core/init",
	"./traversing/findFilter",
	"./selector"
], function( jQuery, indexOf, rneedsContext ) {

var rparentsprev = /^(?:parents|prev(?:Until|All))/,
	// Methods guaranteed to produce a unique set when starting from a unique set
	guaranteedUnique = {
		children: true,
		contents: true,
		next: true,
		prev: true
	***REMOVED***;

jQuery.extend({
	dir: function( elem, dir, until ) {
		var matched = [],
			truncate = until !== undefined;

		while ( (elem = elem[ dir ]) && elem.nodeType !== 9 ) {
			if ( elem.nodeType === 1 ) {
				if ( truncate && jQuery( elem ).is( until ) ) {
					break;
				***REMOVED***
				matched.push( elem );
			***REMOVED***
		***REMOVED***
		return matched;
	***REMOVED***,

	sibling: function( n, elem ) {
		var matched = [];

		for ( ; n; n = n.nextSibling ) {
			if ( n.nodeType === 1 && n !== elem ) {
				matched.push( n );
			***REMOVED***
		***REMOVED***

		return matched;
	***REMOVED***
***REMOVED***);

jQuery.fn.extend({
	has: function( target ) {
		var targets = jQuery( target, this ),
			l = targets.length;

		return this.filter(function() {
			var i = 0;
			for ( ; i < l; i++ ) {
				if ( jQuery.contains( this, targets[i] ) ) {
					return true;
				***REMOVED***
			***REMOVED***
		***REMOVED***);
	***REMOVED***,

	closest: function( selectors, context ) {
		var cur,
			i = 0,
			l = this.length,
			matched = [],
			pos = rneedsContext.test( selectors ) || typeof selectors !== "string" ?
				jQuery( selectors, context || this.context ) :
				0;

		for ( ; i < l; i++ ) {
			for ( cur = this[i]; cur && cur !== context; cur = cur.parentNode ) {
				// Always skip document fragments
				if ( cur.nodeType < 11 && (pos ?
					pos.index(cur) > -1 :

					// Don't pass non-elements to Sizzle
					cur.nodeType === 1 &&
						jQuery.find.matchesSelector(cur, selectors)) ) {

					matched.push( cur );
					break;
				***REMOVED***
			***REMOVED***
		***REMOVED***

		return this.pushStack( matched.length > 1 ? jQuery.unique( matched ) : matched );
	***REMOVED***,

	// Determine the position of an element within the set
	index: function( elem ) {

		// No argument, return index in parent
		if ( !elem ) {
			return ( this[ 0 ] && this[ 0 ].parentNode ) ? this.first().prevAll().length : -1;
		***REMOVED***

		// Index in selector
		if ( typeof elem === "string" ) {
			return indexOf.call( jQuery( elem ), this[ 0 ] );
		***REMOVED***

		// Locate the position of the desired element
		return indexOf.call( this,

			// If it receives a jQuery object, the first element is used
			elem.jquery ? elem[ 0 ] : elem
		);
	***REMOVED***,

	add: function( selector, context ) {
		return this.pushStack(
			jQuery.unique(
				jQuery.merge( this.get(), jQuery( selector, context ) )
			)
		);
	***REMOVED***,

	addBack: function( selector ) {
		return this.add( selector == null ?
			this.prevObject : this.prevObject.filter(selector)
		);
	***REMOVED***
***REMOVED***);

function sibling( cur, dir ) {
	while ( (cur = cur[dir]) && cur.nodeType !== 1 ) {***REMOVED***
	return cur;
***REMOVED***

jQuery.each({
	parent: function( elem ) {
		var parent = elem.parentNode;
		return parent && parent.nodeType !== 11 ? parent : null;
	***REMOVED***,
	parents: function( elem ) {
		return jQuery.dir( elem, "parentNode" );
	***REMOVED***,
	parentsUntil: function( elem, i, until ) {
		return jQuery.dir( elem, "parentNode", until );
	***REMOVED***,
	next: function( elem ) {
		return sibling( elem, "nextSibling" );
	***REMOVED***,
	prev: function( elem ) {
		return sibling( elem, "previousSibling" );
	***REMOVED***,
	nextAll: function( elem ) {
		return jQuery.dir( elem, "nextSibling" );
	***REMOVED***,
	prevAll: function( elem ) {
		return jQuery.dir( elem, "previousSibling" );
	***REMOVED***,
	nextUntil: function( elem, i, until ) {
		return jQuery.dir( elem, "nextSibling", until );
	***REMOVED***,
	prevUntil: function( elem, i, until ) {
		return jQuery.dir( elem, "previousSibling", until );
	***REMOVED***,
	siblings: function( elem ) {
		return jQuery.sibling( ( elem.parentNode || {***REMOVED*** ).firstChild, elem );
	***REMOVED***,
	children: function( elem ) {
		return jQuery.sibling( elem.firstChild );
	***REMOVED***,
	contents: function( elem ) {
		return elem.contentDocument || jQuery.merge( [], elem.childNodes );
	***REMOVED***
***REMOVED***, function( name, fn ) {
	jQuery.fn[ name ] = function( until, selector ) {
		var matched = jQuery.map( this, fn, until );

		if ( name.slice( -5 ) !== "Until" ) {
			selector = until;
		***REMOVED***

		if ( selector && typeof selector === "string" ) {
			matched = jQuery.filter( selector, matched );
		***REMOVED***

		if ( this.length > 1 ) {
			// Remove duplicates
			if ( !guaranteedUnique[ name ] ) {
				jQuery.unique( matched );
			***REMOVED***

			// Reverse order for parents* and prev-derivatives
			if ( rparentsprev.test( name ) ) {
				matched.reverse();
			***REMOVED***
		***REMOVED***

		return this.pushStack( matched );
	***REMOVED***;
***REMOVED***);

return jQuery;
***REMOVED***);
