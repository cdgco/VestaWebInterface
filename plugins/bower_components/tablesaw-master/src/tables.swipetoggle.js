/*
* tablesaw: A set of plugins for responsive tables
* Swipe Toggle: swipe gesture (or buttons) to navigate which columns are shown.
* Copyright (c) 2013 Filament Group, Inc.
* MIT License
*/

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
