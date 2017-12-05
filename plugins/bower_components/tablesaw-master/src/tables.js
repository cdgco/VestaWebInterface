/*global Tablesaw:true */

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
