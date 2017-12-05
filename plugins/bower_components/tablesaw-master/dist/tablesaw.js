/*! Tablesaw - v2.0.3 - 2016-05-02
* https://github.com/filamentgroup/tablesaw
* Copyright (c) 2016 Filament Group; Licensed MIT */
/*
* tablesaw: A set of plugins for responsive tables
* Stack and Column Toggle tables
* Copyright (c) 2013 Filament Group, Inc.
* MIT License
*/

if( typeof Tablesaw === "undefined" ) {
	Tablesaw = {
		i18n: {
			modes: [ 'Stack', 'Swipe', 'Toggle' ],
			columns: 'Col<span class=\"a11y-sm\">umn</span>s',
			columnBtnText: 'Columns',
			columnsDialogError: 'No eligible columns.',
			sort: 'Sort'
		***REMOVED***,
		// cut the mustard
		mustard: 'querySelector' in document &&
			( !window.blackberry || window.WebKitPoint ) &&
			!window.operamini
	***REMOVED***;
***REMOVED***
if( !Tablesaw.config ) {
	Tablesaw.config = {***REMOVED***;
***REMOVED***
if( Tablesaw.mustard ) {
	jQuery( document.documentElement ).addClass( 'tablesaw-enhanced' );
***REMOVED***

;(function( $ ) {
	var pluginName = "table",
		classes = {
			toolbar: "tablesaw-bar"
		***REMOVED***,
		events = {
			create: "tablesawcreate",
			destroy: "tablesawdestroy",
			refresh: "tablesawrefresh"
		***REMOVED***,
		defaultMode = "stack",
		initSelector = "table[data-tablesaw-mode],table[data-tablesaw-sortable]";

	var Table = function( element ) {
		if( !element ) {
			throw new Error( "Tablesaw requires an element." );
		***REMOVED***

		this.table = element;
		this.$table = $( element );

		this.mode = this.$table.attr( "data-tablesaw-mode" ) || defaultMode;

		this.init();
	***REMOVED***;

	Table.prototype.init = function() {
		// assign an id if there is none
		if ( !this.$table.attr( "id" ) ) {
			this.$table.attr( "id", pluginName + "-" + Math.round( Math.random() * 10000 ) );
		***REMOVED***

		this.createToolbar();

		var colstart = this._initCells();

		this.$table.trigger( events.create, [ this, colstart ] );
	***REMOVED***;

	Table.prototype._initCells = function() {
		var colstart,
			thrs = this.table.querySelectorAll( "thead tr" ),
			self = this;

		$( thrs ).each( function(){
			var coltally = 0;

			$( this ).children().each( function(){
				var span = parseInt( this.getAttribute( "colspan" ), 10 ),
					sel = ":nth-child(" + ( coltally + 1 ) + ")";

				colstart = coltally + 1;

				if( span ){
					for( var k = 0; k < span - 1; k++ ){
						coltally++;
						sel += ", :nth-child(" + ( coltally + 1 ) + ")";
					***REMOVED***
				***REMOVED***

				// Store "cells" data on header as a reference to all cells in the same column as this TH
				this.cells = self.$table.find("tr").not( thrs[0] ).not( this ).children().filter( sel );
				coltally++;
			***REMOVED***);
		***REMOVED***);

		return colstart;
	***REMOVED***;

	Table.prototype.refresh = function() {
		this._initCells();

		this.$table.trigger( events.refresh );
	***REMOVED***;

	Table.prototype.createToolbar = function() {
		// Insert the toolbar
		// TODO move this into a separate component
		var $toolbar = this.$table.prev().filter( '.' + classes.toolbar );
		if( !$toolbar.length ) {
			$toolbar = $( '<div>' )
				.addClass( classes.toolbar )
				.insertBefore( this.$table );
		***REMOVED***
		this.$toolbar = $toolbar;

		if( this.mode ) {
			this.$toolbar.addClass( 'mode-' + this.mode );
		***REMOVED***
	***REMOVED***;

	Table.prototype.destroy = function() {
		// Don’t remove the toolbar. Some of the table features are not yet destroy-friendly.
		this.$table.prev().filter( '.' + classes.toolbar ).each(function() {
			this.className = this.className.replace( /\bmode\-\w*\b/gi, '' );
		***REMOVED***);

		var tableId = this.$table.attr( 'id' );
		$( document ).unbind( "." + tableId );
		$( window ).unbind( "." + tableId );

		// other plugins
		this.$table.trigger( events.destroy, [ this ] );

		this.$table.removeData( pluginName );
	***REMOVED***;

	// Collection method.
	$.fn[ pluginName ] = function() {
		return this.each( function() {
			var $t = $( this );

			if( $t.data( pluginName ) ){
				return;
			***REMOVED***

			var table = new Table( this );
			$t.data( pluginName, table );
		***REMOVED***);
	***REMOVED***;

	$( document ).on( "enhance.tablesaw", function( e ) {
		// Cut the mustard
		if( Tablesaw.mustard ) {
			$( e.target ).find( initSelector )[ pluginName ]();
		***REMOVED***
	***REMOVED***);

***REMOVED***( jQuery ));

;(function( win, $, undefined ){

	var classes = {
		stackTable: 'tablesaw-stack',
		cellLabels: 'tablesaw-cell-label',
		cellContentLabels: 'tablesaw-cell-content'
	***REMOVED***;

	var data = {
		obj: 'tablesaw-stack'
	***REMOVED***;

	var attrs = {
		labelless: 'data-tablesaw-no-labels',
		hideempty: 'data-tablesaw-hide-empty'
	***REMOVED***;

	var Stack = function( element ) {

		this.$table = $( element );

		this.labelless = this.$table.is( '[' + attrs.labelless + ']' );
		this.hideempty = this.$table.is( '[' + attrs.hideempty + ']' );

		if( !this.labelless ) {
			// allHeaders references headers, plus all THs in the thead, which may include several rows, or not
			this.allHeaders = this.$table.find( "th" );
		***REMOVED***

		this.$table.data( data.obj, this );
	***REMOVED***;

	Stack.prototype.init = function( colstart ) {
		this.$table.addClass( classes.stackTable );

		if( this.labelless ) {
			return;
		***REMOVED***

		// get headers in reverse order so that top-level headers are appended last
		var reverseHeaders = $( this.allHeaders );
		var hideempty = this.hideempty;
		
		// create the hide/show toggles
		reverseHeaders.each(function(){
			var $t = $( this ),
				$cells = $( this.cells ).filter(function() {
					return !$( this ).parent().is( "[" + attrs.labelless + "]" ) && ( !hideempty || !$( this ).is( ":empty" ) );
				***REMOVED***),
				hierarchyClass = $cells.not( this ).filter( "thead th" ).length && " tablesaw-cell-label-top",
				// TODO reduce coupling with sortable
				$sortableButton = $t.find( ".tablesaw-sortable-btn" ),
				html = $sortableButton.length ? $sortableButton.html() : $t.html();

			if( html !== "" ){
				if( hierarchyClass ){
					var iteration = parseInt( $( this ).attr( "colspan" ), 10 ),
						filter = "";

					if( iteration ){
						filter = "td:nth-child("+ iteration +"n + " + ( colstart ) +")";
					***REMOVED***
					$cells.filter( filter ).prepend( "<b class='" + classes.cellLabels + hierarchyClass + "'>" + html + "</b>"  );
				***REMOVED*** else {
					$cells.wrapInner( "<span class='" + classes.cellContentLabels + "'></span>" );
					$cells.prepend( "<b class='" + classes.cellLabels + "'>" + html + "</b>"  );
				***REMOVED***
			***REMOVED***
		***REMOVED***);
	***REMOVED***;

	Stack.prototype.destroy = function() {
		this.$table.removeClass( classes.stackTable );
		this.$table.find( '.' + classes.cellLabels ).remove();
		this.$table.find( '.' + classes.cellContentLabels ).each(function() {
			$( this ).replaceWith( this.childNodes );
		***REMOVED***);
	***REMOVED***;

	// on tablecreate, init
	$( document ).on( "tablesawcreate", function( e, Tablesaw, colstart ){
		if( Tablesaw.mode === 'stack' ){
			var table = new Stack( Tablesaw.table );
			table.init( colstart );
		***REMOVED***

	***REMOVED*** );

	$( document ).on( "tablesawdestroy", function( e, Tablesaw ){

		if( Tablesaw.mode === 'stack' ){
			$( Tablesaw.table ).data( data.obj ).destroy();
		***REMOVED***

	***REMOVED*** );

***REMOVED***( this, jQuery ));
;(function( $ ) {
	var pluginName = "tablesawbtn",
		methods = {
			_create: function(){
				return $( this ).each(function() {
					$( this )
						.trigger( "beforecreate." + pluginName )
						[ pluginName ]( "_init" )
						.trigger( "create." + pluginName );
				***REMOVED***);
			***REMOVED***,
			_init: function(){
				var oEl = $( this ),
					sel = this.getElementsByTagName( "select" )[ 0 ];

				if( sel ) {
					$( this )
						.addClass( "btn-select" )
						[ pluginName ]( "_select", sel );
				***REMOVED***
				return oEl;
			***REMOVED***,
			_select: function( sel ) {
				var update = function( oEl, sel ) {
					var opts = $( sel ).find( "option" ),
						label, el, children;

					opts.each(function() {
						var opt = this;
						if( opt.selected ) {
							label = document.createTextNode( opt.text );
						***REMOVED***
					***REMOVED***);

					children = oEl.childNodes;
					if( opts.length > 0 ){
						for( var i = 0, l = children.length; i < l; i++ ) {
							el = children[ i ];

							if( el && el.nodeType === 3 ) {
								oEl.replaceChild( label, el );
							***REMOVED***
						***REMOVED***
					***REMOVED***
				***REMOVED***;

				update( this, sel );
				$( this ).bind( "change refresh", function() {
					update( this, sel );
				***REMOVED***);
			***REMOVED***
		***REMOVED***;

	// Collection method.
	$.fn[ pluginName ] = function( arrg, a, b, c ) {
		return this.each(function() {

		// if it's a method
		if( arrg && typeof( arrg ) === "string" ){
			return $.fn[ pluginName ].prototype[ arrg ].call( this, a, b, c );
		***REMOVED***

		// don't re-init
		if( $( this ).data( pluginName + "active" ) ){
			return $( this );
		***REMOVED***

		// otherwise, init

		$( this ).data( pluginName + "active", true );
			$.fn[ pluginName ].prototype._create.call( this );
		***REMOVED***);
	***REMOVED***;

	// add methods
	$.extend( $.fn[ pluginName ].prototype, methods );

***REMOVED***( jQuery ));
;(function( win, $, undefined ){

	var ColumnToggle = function( element ) {

		this.$table = $( element );

		this.classes = {
			columnToggleTable: 'tablesaw-columntoggle',
			columnBtnContain: 'tablesaw-columntoggle-btnwrap tablesaw-advance',
			columnBtn: 'tablesaw-columntoggle-btn tablesaw-nav-btn down',
			popup: 'tablesaw-columntoggle-popup',
			priorityPrefix: 'tablesaw-priority-',
			// TODO duplicate class, also in tables.js
			toolbar: 'tablesaw-bar'
		***REMOVED***;

		// Expose headers and allHeaders properties on the widget
		// headers references the THs within the first TR in the table
		this.headers = this.$table.find( 'tr:first > th' );

		this.$table.data( 'tablesaw-coltoggle', this );
	***REMOVED***;

	ColumnToggle.prototype.init = function() {

		var tableId,
			id,
			$menuButton,
			$popup,
			$menu,
			$btnContain,
			self = this;

		this.$table.addClass( this.classes.columnToggleTable );

		tableId = this.$table.attr( "id" );
		id = tableId + "-popup";
		$btnContain = $( "<div class='" + this.classes.columnBtnContain + "'></div>" );
		$menuButton = $( "<a href='#" + id + "' class='btn btn-micro " + this.classes.columnBtn +"' data-popup-link>" +
										"<span>" + Tablesaw.i18n.columnBtnText + "</span></a>" );
		$popup = $( "<div class='dialog-table-coltoggle " + this.classes.popup + "' id='" + id + "'></div>" );
		$menu = $( "<div class='btn-group'></div>" );

		var hasNonPersistentHeaders = false;
		$( this.headers ).not( "td" ).each( function() {
			var $this = $( this ),
				priority = $this.attr("data-tablesaw-priority"),
				$cells = self.$getCells( this );

			if( priority && priority !== "persist" ) {
				$cells.addClass( self.classes.priorityPrefix + priority );

				$("<label><input type='checkbox' checked>" + $this.text() + "</label>" )
					.appendTo( $menu )
					.children( 0 )
					.data( "tablesaw-header", this );

				hasNonPersistentHeaders = true;
			***REMOVED***
		***REMOVED***);

		if( !hasNonPersistentHeaders ) {
			$menu.append( '<label>' + Tablesaw.i18n.columnsDialogError + '</label>' );
		***REMOVED***

		$menu.appendTo( $popup );

		// bind change event listeners to inputs - TODO: move to a private method?
		$menu.find( 'input[type="checkbox"]' ).on( "change", function(e) {
			var checked = e.target.checked;

			self.$getCellsFromCheckbox( e.target )
				.toggleClass( "tablesaw-cell-hidden", !checked )
				.toggleClass( "tablesaw-cell-visible", checked );

			self.$table.trigger( 'tablesawcolumns' );
		***REMOVED***);

		$menuButton.appendTo( $btnContain );
		$btnContain.appendTo( this.$table.prev().filter( '.' + this.classes.toolbar ) );


		function closePopup( event ) {
			// Click came from inside the popup, ignore.
			if( event && $( event.target ).closest( "." + self.classes.popup ).length ) {
				return;
			***REMOVED***

			$( document ).unbind( 'click.' + tableId );
			$menuButton.removeClass( 'up' ).addClass( 'down' );
			$btnContain.removeClass( 'visible' );
		***REMOVED***

		var closeTimeout;
		function openPopup() {
			$btnContain.addClass( 'visible' );
			$menuButton.removeClass( 'down' ).addClass( 'up' );

			$( document ).unbind( 'click.' + tableId, closePopup );

			window.clearTimeout( closeTimeout );
			closeTimeout = window.setTimeout(function() {
				$( document ).one( 'click.' + tableId, closePopup );
			***REMOVED***, 15 );
		***REMOVED***

		$menuButton.on( "click.tablesaw", function( event ) {
			event.preventDefault();

			if( !$btnContain.is( ".visible" ) ) {
				openPopup();
			***REMOVED*** else {
				closePopup();
			***REMOVED***
		***REMOVED***);

		$popup.appendTo( $btnContain );

		this.$menu = $menu;

		$(window).on( "resize." + tableId, function(){
			self.refreshToggle();
		***REMOVED***);

		this.refreshToggle();
	***REMOVED***;

	ColumnToggle.prototype.$getCells = function( th ) {
		return $( th ).add( th.cells );
	***REMOVED***;

	ColumnToggle.prototype.$getCellsFromCheckbox = function( checkbox ) {
		var th = $( checkbox ).data( "tablesaw-header" );
		return this.$getCells( th );
	***REMOVED***;

	ColumnToggle.prototype.refreshToggle = function() {
		var self = this;
		this.$menu.find( "input" ).each( function() {
			this.checked = self.$getCellsFromCheckbox( this ).eq( 0 ).css( "display" ) === "table-cell";
		***REMOVED***);
	***REMOVED***;

	ColumnToggle.prototype.refreshPriority = function(){
		var self = this;
		$(this.headers).not( "td" ).each( function() {
			var $this = $( this ),
				priority = $this.attr("data-tablesaw-priority"),
				$cells = $this.add( this.cells );

			if( priority && priority !== "persist" ) {
				$cells.addClass( self.classes.priorityPrefix + priority );
			***REMOVED***
		***REMOVED***);
	***REMOVED***;

	ColumnToggle.prototype.destroy = function() {
		// table toolbars, document and window .tableId events
		// removed in parent tables.js destroy method

		this.$table.removeClass( this.classes.columnToggleTable );
		this.$table.find( 'th, td' ).each(function() {
			var $cell = $( this );
			$cell.removeClass( 'tablesaw-cell-hidden' )
				.removeClass( 'tablesaw-cell-visible' );

			this.className = this.className.replace( /\bui\-table\-priority\-\d\b/g, '' );
		***REMOVED***);
	***REMOVED***;

	// on tablecreate, init
	$( document ).on( "tablesawcreate", function( e, Tablesaw ){

		if( Tablesaw.mode === 'columntoggle' ){
			var table = new ColumnToggle( Tablesaw.table );
			table.init();
		***REMOVED***

	***REMOVED*** );

	$( document ).on( "tablesawdestroy", function( e, Tablesaw ){
		if( Tablesaw.mode === 'columntoggle' ){
			$( Tablesaw.table ).data( 'tablesaw-coltoggle' ).destroy();
		***REMOVED***
	***REMOVED*** );

***REMOVED***( this, jQuery ));
;(function( win, $, undefined ){

	$.extend( Tablesaw.config, {
		swipe: {
			horizontalThreshold: 15,
			verticalThreshold: 30
		***REMOVED***
	***REMOVED***);

	function isIE8() {
		var div = document.createElement('div'),
			all = div.getElementsByTagName('i');

		div.innerHTML = '<!--[if lte IE 8]><i></i><![endif]-->';

		return !!all.length;
	***REMOVED***

	var classes = {
		// TODO duplicate class, also in tables.js
		toolbar: "tablesaw-bar",
		hideBtn: "disabled",
		persistWidths: "tablesaw-fix-persist",
		allColumnsVisible: 'tablesaw-all-cols-visible'
	***REMOVED***;

	function createSwipeTable( $table ){

		var $btns = $( "<div class='tablesaw-advance'></div>" ),
			$prevBtn = $( "<a href='#' class='tablesaw-nav-btn btn btn-micro left' title='Previous Column'></a>" ).appendTo( $btns ),
			$nextBtn = $( "<a href='#' class='tablesaw-nav-btn btn btn-micro right' title='Next Column'></a>" ).appendTo( $btns ),
			$headerCells = $table.find( "thead th" ),
			$headerCellsNoPersist = $headerCells.not( '[data-tablesaw-priority="persist"]' ),
			headerWidths = [],
			$head = $( document.head || 'head' ),
			tableId = $table.attr( 'id' ),
			// TODO switch this to an nth-child feature test
			supportsNthChild = !isIE8();

		if( !$headerCells.length ) {
			throw new Error( "tablesaw swipe: no header cells found. Are you using <th> inside of <thead>?" );
		***REMOVED***

		// Calculate initial widths
		$table.css('width', 'auto');
		$headerCells.each(function() {
			headerWidths.push( $( this ).outerWidth() );
		***REMOVED***);
		$table.css( 'width', '' );

		$btns.appendTo( $table.prev().filter( '.tablesaw-bar' ) );

		$table.addClass( "tablesaw-swipe" );

		if( !tableId ) {
			tableId = 'tableswipe-' + Math.round( Math.random() * 10000 );
			$table.attr( 'id', tableId );
		***REMOVED***

		function $getCells( headerCell ) {
			return $( headerCell.cells ).add( headerCell );
		***REMOVED***

		function showColumn( headerCell ) {
			$getCells( headerCell ).removeClass( 'tablesaw-cell-hidden' );
		***REMOVED***

		function hideColumn( headerCell ) {
			$getCells( headerCell ).addClass( 'tablesaw-cell-hidden' );
		***REMOVED***

		function persistColumn( headerCell ) {
			$getCells( headerCell ).addClass( 'tablesaw-cell-persist' );
		***REMOVED***

		function isPersistent( headerCell ) {
			return $( headerCell ).is( '[data-tablesaw-priority="persist"]' );
		***REMOVED***

		function unmaintainWidths() {
			$table.removeClass( classes.persistWidths );
			$( '#' + tableId + '-persist' ).remove();
		***REMOVED***

		function maintainWidths() {
			var prefix = '#' + tableId + '.tablesaw-swipe ',
				styles = [],
				tableWidth = $table.width(),
				hash = [],
				newHash;

			$headerCells.each(function( index ) {
				var width;
				if( isPersistent( this ) ) {
					width = $( this ).outerWidth();

					// Only save width on non-greedy columns (take up less than 75% of table width)
					if( width < tableWidth * 0.75 ) {
						hash.push( index + '-' + width );
						styles.push( prefix + ' .tablesaw-cell-persist:nth-child(' + ( index + 1 ) + ') { width: ' + width + 'px; ***REMOVED***' );
					***REMOVED***
				***REMOVED***
			***REMOVED***);
			newHash = hash.join( '_' );

			$table.addClass( classes.persistWidths );

			var $style = $( '#' + tableId + '-persist' );
			// If style element not yet added OR if the widths have changed
			if( !$style.length || $style.data( 'hash' ) !== newHash ) {
				// Remove existing
				$style.remove();

				if( styles.length ) {
					$( '<style>' + styles.join( "\n" ) + '</style>' )
						.attr( 'id', tableId + '-persist' )
						.data( 'hash', newHash )
						.appendTo( $head );
				***REMOVED***
			***REMOVED***
		***REMOVED***

		function getNext(){
			var next = [],
				checkFound;

			$headerCellsNoPersist.each(function( i ) {
				var $t = $( this ),
					isHidden = $t.css( "display" ) === "none" || $t.is( ".tablesaw-cell-hidden" );

				if( !isHidden && !checkFound ) {
					checkFound = true;
					next[ 0 ] = i;
				***REMOVED*** else if( isHidden && checkFound ) {
					next[ 1 ] = i;

					return false;
				***REMOVED***
			***REMOVED***);

			return next;
		***REMOVED***

		function getPrev(){
			var next = getNext();
			return [ next[ 1 ] - 1 , next[ 0 ] - 1 ];
		***REMOVED***

		function nextpair( fwd ){
			return fwd ? getNext() : getPrev();
		***REMOVED***

		function canAdvance( pair ){
			return pair[ 1 ] > -1 && pair[ 1 ] < $headerCellsNoPersist.length;
		***REMOVED***

		function matchesMedia() {
			var matchMedia = $table.attr( "data-tablesaw-swipe-media" );
			return !matchMedia || ( "matchMedia" in win ) && win.matchMedia( matchMedia ).matches;
		***REMOVED***

		function fakeBreakpoints() {
			if( !matchesMedia() ) {
				return;
			***REMOVED***

			var extraPaddingPixels = 20,
				containerWidth = $table.parent().width(),
				persist = [],
				sum = 0,
				sums = [],
				visibleNonPersistantCount = $headerCells.length;

			$headerCells.each(function( index ) {
				var $t = $( this ),
					isPersist = $t.is( '[data-tablesaw-priority="persist"]' );

				persist.push( isPersist );

				sum += headerWidths[ index ] + ( isPersist ? 0 : extraPaddingPixels );
				sums.push( sum );

				// is persistent or is hidden
				if( isPersist || sum > containerWidth ) {
					visibleNonPersistantCount--;
				***REMOVED***
			***REMOVED***);

			var needsNonPersistentColumn = visibleNonPersistantCount === 0;

			$headerCells.each(function( index ) {
				if( persist[ index ] ) {

					// for visual box-shadow
					persistColumn( this );
					return;
				***REMOVED***

				if( sums[ index ] <= containerWidth || needsNonPersistentColumn ) {
					needsNonPersistentColumn = false;
					showColumn( this );
				***REMOVED*** else {
					hideColumn( this );
				***REMOVED***
			***REMOVED***);

			if( supportsNthChild ) {
				unmaintainWidths();
			***REMOVED***
			$table.trigger( 'tablesawcolumns' );
		***REMOVED***

		function advance( fwd ){
			var pair = nextpair( fwd );
			if( canAdvance( pair ) ){
				if( isNaN( pair[ 0 ] ) ){
					if( fwd ){
						pair[0] = 0;
					***REMOVED***
					else {
						pair[0] = $headerCellsNoPersist.length - 1;
					***REMOVED***
				***REMOVED***

				if( supportsNthChild ) {
					maintainWidths();
				***REMOVED***

				hideColumn( $headerCellsNoPersist.get( pair[ 0 ] ) );
				showColumn( $headerCellsNoPersist.get( pair[ 1 ] ) );

				$table.trigger( 'tablesawcolumns' );
			***REMOVED***
		***REMOVED***

		$prevBtn.add( $nextBtn ).click(function( e ){
			advance( !!$( e.target ).closest( $nextBtn ).length );
			e.preventDefault();
		***REMOVED***);

		function getCoord( event, key ) {
			return ( event.touches || event.originalEvent.touches )[ 0 ][ key ];
		***REMOVED***

		$table
			.bind( "touchstart.swipetoggle", function( e ){
				var originX = getCoord( e, 'pageX' ),
					originY = getCoord( e, 'pageY' ),
					x,
					y;

				$( win ).off( "resize", fakeBreakpoints );

				$( this )
					.bind( "touchmove", function( e ){
						x = getCoord( e, 'pageX' );
						y = getCoord( e, 'pageY' );
						var cfg = Tablesaw.config.swipe;
						if( Math.abs( x - originX ) > cfg.horizontalThreshold && Math.abs( y - originY ) < cfg.verticalThreshold ) {
							e.preventDefault();
						***REMOVED***
					***REMOVED***)
					.bind( "touchend.swipetoggle", function(){
						var cfg = Tablesaw.config.swipe;
						if( Math.abs( y - originY ) < cfg.verticalThreshold ) {
							if( x - originX < -1 * cfg.horizontalThreshold ){
								advance( true );
							***REMOVED***
							if( x - originX > cfg.horizontalThreshold ){
								advance( false );
							***REMOVED***
						***REMOVED***

						window.setTimeout(function() {
							$( win ).on( "resize", fakeBreakpoints );
						***REMOVED***, 300);
						$( this ).unbind( "touchmove touchend" );
					***REMOVED***);

			***REMOVED***)
			.bind( "tablesawcolumns.swipetoggle", function(){
				var canGoPrev = canAdvance( getPrev() );
				var canGoNext = canAdvance( getNext() );
				$prevBtn[ canGoPrev ? "removeClass" : "addClass" ]( classes.hideBtn );
				$nextBtn[ canGoNext ? "removeClass" : "addClass" ]( classes.hideBtn );

				$prevBtn.closest( "." + classes.toolbar )[ !canGoPrev && !canGoNext ? 'addClass' : 'removeClass' ]( classes.allColumnsVisible );
			***REMOVED***)
			.bind( "tablesawnext.swipetoggle", function(){
				advance( true );
			***REMOVED*** )
			.bind( "tablesawprev.swipetoggle", function(){
				advance( false );
			***REMOVED*** )
			.bind( "tablesawdestroy.swipetoggle", function(){
				var $t = $( this );

				$t.removeClass( 'tablesaw-swipe' );
				$t.prev().filter( '.tablesaw-bar' ).find( '.tablesaw-advance' ).remove();
				$( win ).off( "resize", fakeBreakpoints );

				$t.unbind( ".swipetoggle" );
			***REMOVED***);

		fakeBreakpoints();
		$( win ).on( "resize", fakeBreakpoints );
	***REMOVED***



	// on tablecreate, init
	$( document ).on( "tablesawcreate", function( e, Tablesaw ){

		if( Tablesaw.mode === 'swipe' ){
			createSwipeTable( Tablesaw.$table );
		***REMOVED***

	***REMOVED*** );

***REMOVED***( this, jQuery ));

;(function( $ ) {
	function getSortValue( cell ) {
		return $.map( cell.childNodes, function( el ) {
				var $el = $( el );
				if( $el.is( 'input, select' ) ) {
					return $el.val();
				***REMOVED*** else if( $el.hasClass( 'tablesaw-cell-label' ) ) {
					return;
				***REMOVED***
				return $.trim( $el.text() );
			***REMOVED***).join( '' );
	***REMOVED***

	var pluginName = "tablesaw-sortable",
		initSelector = "table[data-" + pluginName + "]",
		sortableSwitchSelector = "[data-" + pluginName + "-switch]",
		attrs = {
			defaultCol: "data-tablesaw-sortable-default-col",
			numericCol: "data-tablesaw-sortable-numeric"
		***REMOVED***,
		classes = {
			head: pluginName + "-head",
			ascend: pluginName + "-ascending",
			descend: pluginName + "-descending",
			switcher: pluginName + "-switch",
			tableToolbar: 'tablesaw-toolbar',
			sortButton: pluginName + "-btn"
		***REMOVED***,
		methods = {
			_create: function( o ){
				return $( this ).each(function() {
					var init = $( this ).data( "init" + pluginName );
					if( init ) {
						return false;
					***REMOVED***
					$( this )
						.data( "init"+ pluginName, true )
						.trigger( "beforecreate." + pluginName )
						[ pluginName ]( "_init" , o )
						.trigger( "create." + pluginName );
				***REMOVED***);
			***REMOVED***,
			_init: function(){
				var el = $( this ),
					heads,
					$switcher;

				var addClassToTable = function(){
						el.addClass( pluginName );
					***REMOVED***,
					addClassToHeads = function( h ){
						$.each( h , function( i , v ){
							$( v ).addClass( classes.head );
						***REMOVED***);
					***REMOVED***,
					makeHeadsActionable = function( h , fn ){
						$.each( h , function( i , v ){
							var b = $( "<button class='" + classes.sortButton + "'/>" );
							b.bind( "click" , { col: v ***REMOVED*** , fn );
							$( v ).wrapInner( b );
						***REMOVED***);
					***REMOVED***,
					clearOthers = function( sibs ){
						$.each( sibs , function( i , v ){
							var col = $( v );
							col.removeAttr( attrs.defaultCol );
							col.removeClass( classes.ascend );
							col.removeClass( classes.descend );
						***REMOVED***);
					***REMOVED***,
					headsOnAction = function( e ){
						if( $( e.target ).is( 'a[href]' ) ) {
							return;
						***REMOVED***

						e.stopPropagation();
						var head = $( this ).parent(),
							v = e.data.col,
							newSortValue = heads.index( head );

						clearOthers( head.siblings() );
						if( head.hasClass( classes.descend ) ){
							el[ pluginName ]( "sortBy" , v , true);
							newSortValue += '_asc';
						***REMOVED*** else {
							el[ pluginName ]( "sortBy" , v );
							newSortValue += '_desc';
						***REMOVED***
						if( $switcher ) {
							$switcher.find( 'select' ).val( newSortValue ).trigger( 'refresh' );
						***REMOVED***

						e.preventDefault();
					***REMOVED***,
					handleDefault = function( heads ){
						$.each( heads , function( idx , el ){
							var $el = $( el );
							if( $el.is( "[" + attrs.defaultCol + "]" ) ){
								if( !$el.hasClass( classes.descend ) ) {
									$el.addClass( classes.ascend );
								***REMOVED***
							***REMOVED***
						***REMOVED***);
					***REMOVED***,
					addSwitcher = function( heads ){
						$switcher = $( '<div>' ).addClass( classes.switcher ).addClass( classes.tableToolbar ).html(function() {
							var html = [ '<label>' + Tablesaw.i18n.sort + ':' ];

							html.push( '<span class="btn btn-small">&#160;<select>' );
							heads.each(function( j ) {
								var $t = $( this );
								var isDefaultCol = $t.is( "[" + attrs.defaultCol + "]" );
								var isDescending = $t.hasClass( classes.descend );

								var hasNumericAttribute = $t.is( '[data-sortable-numeric]' );
								var numericCount = 0;
								// Check only the first four rows to see if the column is numbers.
								var numericCountMax = 5;

								$( this.cells ).slice( 0, numericCountMax ).each(function() {
									if( !isNaN( parseInt( getSortValue( this ), 10 ) ) ) {
										numericCount++;
									***REMOVED***
								***REMOVED***);
								var isNumeric = numericCount === numericCountMax;
								if( !hasNumericAttribute ) {
									$t.attr( "data-sortable-numeric", isNumeric ? "" : "false" );
								***REMOVED***

								html.push( '<option' + ( isDefaultCol && !isDescending ? ' selected' : '' ) + ' value="' + j + '_asc">' + $t.text() + ' ' + ( isNumeric ? '&#x2191;' : '(A-Z)' ) + '</option>' );
								html.push( '<option' + ( isDefaultCol && isDescending ? ' selected' : '' ) + ' value="' + j + '_desc">' + $t.text() + ' ' + ( isNumeric ? '&#x2193;' : '(Z-A)' ) + '</option>' );
							***REMOVED***);
							html.push( '</select></span></label>' );

							return html.join('');
						***REMOVED***);

						var $toolbar = el.prev().filter( '.tablesaw-bar' ),
							$firstChild = $toolbar.children().eq( 0 );

						if( $firstChild.length ) {
							$switcher.insertBefore( $firstChild );
						***REMOVED*** else {
							$switcher.appendTo( $toolbar );
						***REMOVED***
						$switcher.find( '.btn' ).tablesawbtn();
						$switcher.find( 'select' ).on( 'change', function() {
							var val = $( this ).val().split( '_' ),
								head = heads.eq( val[ 0 ] );

							clearOthers( head.siblings() );
							el[ pluginName ]( 'sortBy', head.get( 0 ), val[ 1 ] === 'asc' );
						***REMOVED***);
					***REMOVED***;

					addClassToTable();
					heads = el.find( "thead th[data-" + pluginName + "-col]" );
					addClassToHeads( heads );
					makeHeadsActionable( heads , headsOnAction );
					handleDefault( heads );

					if( el.is( sortableSwitchSelector ) ) {
						addSwitcher( heads, el.find('tbody tr:nth-child(-n+3)') );
					***REMOVED***
			***REMOVED***,
			getColumnNumber: function( col ){
				return $( col ).prevAll().length;
			***REMOVED***,
			getTableRows: function(){
				return $( this ).find( "tbody tr" );
			***REMOVED***,
			sortRows: function( rows , colNum , ascending, col ){
				var cells, fn, sorted;
				var getCells = function( rows ){
						var cells = [];
						$.each( rows , function( i , r ){
							var element = $( r ).children().get( colNum );
							cells.push({
								element: element,
								cell: getSortValue( element ),
								rowNum: i
							***REMOVED***);
						***REMOVED***);
						return cells;
					***REMOVED***,
					getSortFxn = function( ascending, forceNumeric ){
						var fn,
							regex = /[^\-\+\d\.]/g;
						if( ascending ){
							fn = function( a , b ){
								if( forceNumeric ) {
									return parseFloat( a.cell.replace( regex, '' ) ) - parseFloat( b.cell.replace( regex, '' ) );
								***REMOVED*** else {
									return a.cell.toLowerCase() > b.cell.toLowerCase() ? 1 : -1;
								***REMOVED***
							***REMOVED***;
						***REMOVED*** else {
							fn = function( a , b ){
								if( forceNumeric ) {
									return parseFloat( b.cell.replace( regex, '' ) ) - parseFloat( a.cell.replace( regex, '' ) );
								***REMOVED*** else {
									return a.cell.toLowerCase() < b.cell.toLowerCase() ? 1 : -1;
								***REMOVED***
							***REMOVED***;
						***REMOVED***
						return fn;
					***REMOVED***,
					applyToRows = function( sorted , rows ){
						var newRows = [], i, l, cur;
						for( i = 0, l = sorted.length ; i < l ; i++ ){
							cur = sorted[ i ].rowNum;
							newRows.push( rows[cur] );
						***REMOVED***
						return newRows;
					***REMOVED***;

				cells = getCells( rows );
				var customFn = $( col ).data( 'tablesaw-sort' );
				fn = ( customFn && typeof customFn === "function" ? customFn( ascending ) : false ) ||
					getSortFxn( ascending, $( col ).is( '[data-sortable-numeric]' ) && !$( col ).is( '[data-sortable-numeric="false"]' ) );
				sorted = cells.sort( fn );
				rows = applyToRows( sorted , rows );
				return rows;
			***REMOVED***,
			replaceTableRows: function( rows ){
				var el = $( this ),
					body = el.find( "tbody" );
				body.html( rows );
			***REMOVED***,
			makeColDefault: function( col , a ){
				var c = $( col );
				c.attr( attrs.defaultCol , "true" );
				if( a ){
					c.removeClass( classes.descend );
					c.addClass( classes.ascend );
				***REMOVED*** else {
					c.removeClass( classes.ascend );
					c.addClass( classes.descend );
				***REMOVED***
			***REMOVED***,
			sortBy: function( col , ascending ){
				var el = $( this ), colNum, rows;

				colNum = el[ pluginName ]( "getColumnNumber" , col );
				rows = el[ pluginName ]( "getTableRows" );
				rows = el[ pluginName ]( "sortRows" , rows , colNum , ascending, col );
				el[ pluginName ]( "replaceTableRows" , rows );
				el[ pluginName ]( "makeColDefault" , col , ascending );
			***REMOVED***
		***REMOVED***;

	// Collection method.
	$.fn[ pluginName ] = function( arrg ) {
		var args = Array.prototype.slice.call( arguments , 1),
			returnVal;

		// if it's a method
		if( arrg && typeof( arrg ) === "string" ){
			returnVal = $.fn[ pluginName ].prototype[ arrg ].apply( this[0], args );
			return (typeof returnVal !== "undefined")? returnVal:$(this);
		***REMOVED***
		// check init
		if( !$( this ).data( pluginName + "data" ) ){
			$( this ).data( pluginName + "active", true );
			$.fn[ pluginName ].prototype._create.call( this , arrg );
		***REMOVED***
		return $(this);
	***REMOVED***;
	// add methods
	$.extend( $.fn[ pluginName ].prototype, methods );

	$( document ).on( "tablesawcreate", function( e, Tablesaw ) {
		if( Tablesaw.$table.is( initSelector ) ) {
			Tablesaw.$table[ pluginName ]();
		***REMOVED***
	***REMOVED***);

***REMOVED***( jQuery ));

;(function( win, $, undefined ){

	var MM = {
		attr: {
			init: 'data-tablesaw-minimap'
		***REMOVED***
	***REMOVED***;

	function createMiniMap( $table ){

		var $btns = $( '<div class="tablesaw-advance minimap">' ),
			$dotNav = $( '<ul class="tablesaw-advance-dots">' ).appendTo( $btns ),
			hideDot = 'tablesaw-advance-dots-hide',
			$headerCells = $table.find( 'thead th' );

		// populate dots
		$headerCells.each(function(){
			$dotNav.append( '<li><i></i></li>' );
		***REMOVED***);

		$btns.appendTo( $table.prev().filter( '.tablesaw-bar' ) );

		function showMinimap( $table ) {
			var mq = $table.attr( MM.attr.init );
			return !mq || win.matchMedia && win.matchMedia( mq ).matches;
		***REMOVED***

		function showHideNav(){
			if( !showMinimap( $table ) ) {
				$btns.hide();
				return;
			***REMOVED***
			$btns.show();

			// show/hide dots
			var dots = $dotNav.find( "li" ).removeClass( hideDot );
			$table.find( "thead th" ).each(function(i){
				if( $( this ).css( "display" ) === "none" ){
					dots.eq( i ).addClass( hideDot );
				***REMOVED***
			***REMOVED***);
		***REMOVED***

		// run on init and resize
		showHideNav();
		$( win ).on( "resize", showHideNav );


		$table
			.bind( "tablesawcolumns.minimap", function(){
				showHideNav();
			***REMOVED***)
			.bind( "tablesawdestroy.minimap", function(){
				var $t = $( this );

				$t.prev().filter( '.tablesaw-bar' ).find( '.tablesaw-advance' ).remove();
				$( win ).off( "resize", showHideNav );

				$t.unbind( ".minimap" );
			***REMOVED***);
	***REMOVED***



	// on tablecreate, init
	$( document ).on( "tablesawcreate", function( e, Tablesaw ){

		if( ( Tablesaw.mode === 'swipe' || Tablesaw.mode === 'columntoggle' ) && Tablesaw.$table.is( '[ ' + MM.attr.init + ']' ) ){
			createMiniMap( Tablesaw.$table );
		***REMOVED***

	***REMOVED*** );

***REMOVED***( this, jQuery ));

;(function( win, $ ) {

	var S = {
		selectors: {
			init: 'table[data-tablesaw-mode-switch]'
		***REMOVED***,
		attributes: {
			excludeMode: 'data-tablesaw-mode-exclude'
		***REMOVED***,
		classes: {
			main: 'tablesaw-modeswitch',
			toolbar: 'tablesaw-toolbar'
		***REMOVED***,
		modes: [ 'stack', 'swipe', 'columntoggle' ],
		init: function( table ) {
			var $table = $( table ),
				ignoreMode = $table.attr( S.attributes.excludeMode ),
				$toolbar = $table.prev().filter( '.tablesaw-bar' ),
				modeVal = '',
				$switcher = $( '<div>' ).addClass( S.classes.main + ' ' + S.classes.toolbar ).html(function() {
					var html = [ '<label>' + Tablesaw.i18n.columns + ':' ],
						dataMode = $table.attr( 'data-tablesaw-mode' ),
						isSelected;

					html.push( '<span class="btn btn-small">&#160;<select>' );
					for( var j=0, k = S.modes.length; j<k; j++ ) {
						if( ignoreMode && ignoreMode.toLowerCase() === S.modes[ j ] ) {
							continue;
						***REMOVED***

						isSelected = dataMode === S.modes[ j ];

						if( isSelected ) {
							modeVal = S.modes[ j ];
						***REMOVED***

						html.push( '<option' +
							( isSelected ? ' selected' : '' ) +
							' value="' + S.modes[ j ] + '">' + Tablesaw.i18n.modes[ j ] + '</option>' );
					***REMOVED***
					html.push( '</select></span></label>' );

					return html.join('');
				***REMOVED***);

			var $otherToolbarItems = $toolbar.find( '.tablesaw-advance' ).eq( 0 );
			if( $otherToolbarItems.length ) {
				$switcher.insertBefore( $otherToolbarItems );
			***REMOVED*** else {
				$switcher.appendTo( $toolbar );
			***REMOVED***

			$switcher.find( '.btn' ).tablesawbtn();
			$switcher.find( 'select' ).bind( 'change', S.onModeChange );
		***REMOVED***,
		onModeChange: function() {
			var $t = $( this ),
				$switcher = $t.closest( '.' + S.classes.main ),
				$table = $t.closest( '.tablesaw-bar' ).nextUntil( $table ).eq( 0 ),
				val = $t.val();

			$switcher.remove();
			$table.data( 'table' ).destroy();

			$table.attr( 'data-tablesaw-mode', val );
			$table.table();
		***REMOVED***
	***REMOVED***;

	$( win.document ).on( "tablesawcreate", function( e, Tablesaw ) {
		if( Tablesaw.$table.is( S.selectors.init ) ) {
			S.init( Tablesaw.table );
		***REMOVED***
	***REMOVED***);

***REMOVED***)( this, jQuery );