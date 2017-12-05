/**
 * Set the point at which DataTables will start it's display of data in the
 * table.
 *
 *  @name fnDisplayStart
 *  @summary Change the table's paging display start.
 *  @author [Allan Jardine](http://sprymedia.co.uk)
 *  @deprecated
 *
 *  @param {integer***REMOVED*** iStart Display start index.
 *  @param {boolean***REMOVED*** [bRedraw=false] Indicate if the table should do a redraw or not.
 *
 *  @example
 *    var table = $('#example').dataTable();
 *    table.fnDisplayStart( 21 );
 */

jQuery.fn.dataTableExt.oApi.fnDisplayStart = function ( oSettings, iStart, bRedraw )
{
    if ( typeof bRedraw == 'undefined' ) {
        bRedraw = true;
    ***REMOVED***

    oSettings._iDisplayStart = iStart;
    if ( oSettings.oApi._fnCalculateEnd ) {
        oSettings.oApi._fnCalculateEnd( oSettings );
    ***REMOVED***

    if ( bRedraw ) {
        oSettings.oApi._fnDraw( oSettings );
    ***REMOVED***
***REMOVED***;
