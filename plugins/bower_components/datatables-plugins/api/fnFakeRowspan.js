/**
 * Creates `rowspan` cells in a column when there are two or more cells in a 
 * row with the same content, effectively grouping them together visually. 
 * 
 * **Note** - this plug-in currently only operates correctly with 
 * **server-side processing**.
 *
 *  @name fnFakeRowspan
 *  @summary Create a rowspan for cells which share data
 *  @author Fredrik Wendel
 *
 *  @param {interger***REMOVED*** iColumn Column index to have row span
 *  @param {boolean***REMOVED*** [bCaseSensitive=true] If the data check should be case
 *    sensitive or not.
 *  @returns {jQuery***REMOVED*** jQuery instance
 *
 *  @example
 *    $('#example').dataTable().fnFakeRowspan(3);
 */

jQuery.fn.dataTableExt.oApi.fnFakeRowspan = function ( oSettings, iColumn, bCaseSensitive ) {
	/* Fail silently on missing/errorenous parameter data. */
	if (isNaN(iColumn)) {
		return false;
	***REMOVED***

	if (iColumn < 0 || iColumn > oSettings.aoColumns.length-1) {
		alert ('Invalid column number choosen, must be between 0 and ' + (oSettings.aoColumns.length-1));
		return false;
	***REMOVED***

	bCaseSensitive = (typeof(bCaseSensitive) != 'boolean' ? true : bCaseSensitive);

	function fakeRowspan () {
		var firstOccurance = null,
			value = null,
			rowspan = 0;
		jQuery.each(oSettings.aoData, function (i, oData) {
			var val = oData._aData[iColumn],
				cell = oData.nTr.childNodes[iColumn];
			/* Use lowercase comparison if not case-sensitive. */
			if (!bCaseSensitive) {
				val = val.toLowerCase();
			***REMOVED***
			/* Reset values on new cell data. */
			if (val != value) {
				value = val;
				firstOccurance = cell;
				rowspan = 0;
			***REMOVED***

			if (val == value) {
				rowspan++;
			***REMOVED***

			if (firstOccurance !== null && val == value && rowspan > 1) {
				oData.nTr.removeChild(cell);
				firstOccurance.rowSpan = rowspan;
			***REMOVED***
		***REMOVED***);
	***REMOVED***

	oSettings.aoDrawCallback.push({ "fn": fakeRowspan, "sName": "fnFakeRowspan" ***REMOVED***);

	return this;
***REMOVED***;
