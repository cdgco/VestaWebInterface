/**
 * Return an array of table values from a particular column, with various
 * filtering options.
 *
 * DataTables 1.10+ provides the `dt-api column().data()` method, built-in to
 * the core, to provide this ability. As such, this method is marked deprecated,
 * but is available for use with legacy version of DataTables. Please use the
 * new API if you are used DataTables 1.10 or newer.
 *
 *  @name fnGetColumnData
 *  @summary Get the data from a column
 *  @author [Benedikt Forchhammer](http://mind2.de)
 *  @deprecated
 *
 *  @param {integer***REMOVED*** iColumn Column to get data from
 *  @param {boolean***REMOVED*** [bFiltered=true] Reduce the data set to only unique values
 *  @param {boolean***REMOVED*** [bUnique=true] Get data from filter results only
 *  @param {boolean***REMOVED*** [bIgnoreEmpty=true] Remove data elements which are empty
 *  @returns {array***REMOVED*** Array of data from the column
 *
 *  @example
 *    var table = $('#example').dataTable();
 *    table.fnGetColumnData( 3 );
 */

jQuery.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
	// check that we have a column id
	if ( typeof iColumn == "undefined" ) {
		return [];
	***REMOVED***

	// by default we only wany unique data
	if ( typeof bUnique == "undefined" ) {
		bUnique = true;
	***REMOVED***

	// by default we do want to only look at filtered data
	if ( typeof bFiltered == "undefined" ) {
		bFiltered = true;
	***REMOVED***

	// by default we do not wany to include empty values
	if ( typeof bIgnoreEmpty == "undefined" ) {
		bIgnoreEmpty = true;
	***REMOVED***

	// list of rows which we're going to loop through
	var aiRows;

	// use only filtered rows
	if (bFiltered === true) {
		aiRows = oSettings.aiDisplay;
	***REMOVED***
	// use all rows
	else {
		aiRows = oSettings.aiDisplayMaster; // all row numbers
	***REMOVED***

	// set up data array    
	var asResultData = [];

	for (var i=0,c=aiRows.length; i<c; i++) {
		var iRow = aiRows[i];
		var sValue = this.fnGetData(iRow, iColumn);

		// ignore empty values?
		if (bIgnoreEmpty === true && sValue.length === 0) {
			continue;
		***REMOVED***

		// ignore unique values?
		else if (bUnique === true && jQuery.inArray(sValue, asResultData) > -1) {
			continue;
		***REMOVED***

		// else push the value onto the result data array
		else {
			asResultData.push(sValue);
		***REMOVED***
	***REMOVED***

	return asResultData;
***REMOVED***;
