define([
	"./core",
	"./data/var/data_priv",
	"./deferred",
	"./callbacks"
], function( jQuery, data_priv ) {

jQuery.extend({
	queue: function( elem, type, data ) {
		var queue;

		if ( elem ) {
			type = ( type || "fx" ) + "queue";
			queue = data_priv.get( elem, type );

			// Speed up dequeue by getting out quickly if this is just a lookup
			if ( data ) {
				if ( !queue || jQuery.isArray( data ) ) {
					queue = data_priv.access( elem, type, jQuery.makeArray(data) );
				***REMOVED*** else {
					queue.push( data );
				***REMOVED***
			***REMOVED***
			return queue || [];
		***REMOVED***
	***REMOVED***,

	dequeue: function( elem, type ) {
		type = type || "fx";

		var queue = jQuery.queue( elem, type ),
			startLength = queue.length,
			fn = queue.shift(),
			hooks = jQuery._queueHooks( elem, type ),
			next = function() {
				jQuery.dequeue( elem, type );
			***REMOVED***;

		// If the fx queue is dequeued, always remove the progress sentinel
		if ( fn === "inprogress" ) {
			fn = queue.shift();
			startLength--;
		***REMOVED***

		if ( fn ) {

			// Add a progress sentinel to prevent the fx queue from being
			// automatically dequeued
			if ( type === "fx" ) {
				queue.unshift( "inprogress" );
			***REMOVED***

			// Clear up the last queue stop function
			delete hooks.stop;
			fn.call( elem, next, hooks );
		***REMOVED***

		if ( !startLength && hooks ) {
			hooks.empty.fire();
		***REMOVED***
	***REMOVED***,

	// Not public - generate a queueHooks object, or return the current one
	_queueHooks: function( elem, type ) {
		var key = type + "queueHooks";
		return data_priv.get( elem, key ) || data_priv.access( elem, key, {
			empty: jQuery.Callbacks("once memory").add(function() {
				data_priv.remove( elem, [ type + "queue", key ] );
			***REMOVED***)
		***REMOVED***);
	***REMOVED***
***REMOVED***);

jQuery.fn.extend({
	queue: function( type, data ) {
		var setter = 2;

		if ( typeof type !== "string" ) {
			data = type;
			type = "fx";
			setter--;
		***REMOVED***

		if ( arguments.length < setter ) {
			return jQuery.queue( this[0], type );
		***REMOVED***

		return data === undefined ?
			this :
			this.each(function() {
				var queue = jQuery.queue( this, type, data );

				// Ensure a hooks for this queue
				jQuery._queueHooks( this, type );

				if ( type === "fx" && queue[0] !== "inprogress" ) {
					jQuery.dequeue( this, type );
				***REMOVED***
			***REMOVED***);
	***REMOVED***,
	dequeue: function( type ) {
		return this.each(function() {
			jQuery.dequeue( this, type );
		***REMOVED***);
	***REMOVED***,
	clearQueue: function( type ) {
		return this.queue( type || "fx", [] );
	***REMOVED***,
	// Get a promise resolved when queues of a certain type
	// are emptied (fx is the type by default)
	promise: function( type, obj ) {
		var tmp,
			count = 1,
			defer = jQuery.Deferred(),
			elements = this,
			i = this.length,
			resolve = function() {
				if ( !( --count ) ) {
					defer.resolveWith( elements, [ elements ] );
				***REMOVED***
			***REMOVED***;

		if ( typeof type !== "string" ) {
			obj = type;
			type = undefined;
		***REMOVED***
		type = type || "fx";

		while ( i-- ) {
			tmp = data_priv.get( elements[ i ], type + "queueHooks" );
			if ( tmp && tmp.empty ) {
				count++;
				tmp.empty.add( resolve );
			***REMOVED***
		***REMOVED***
		resolve();
		return defer.promise( obj );
	***REMOVED***
***REMOVED***);

return jQuery;
***REMOVED***);
