/*
 * This plug-in adds another pagination option similar to `full_numbers`, except
 * it adds ellipses around the page numbers when applicable. You can set how
 * many page numbers should be displayed with the iShowPages option.
 * 
 * This plug- in extends the oStdClasses object with the following properties:
 * sPageEllipsis, sPageNumber and sPageNumbers.
 * 
 * It also extends the oSettings object with the following properties:
 * _iShowPages, _iShowPagesHalf, _iCurrentPage, _iTotalPages, _iFirstPage and
 * _iLastPage.
 *
 * Note that DataTables 1.10 has this ability built in. As such, this plug-ins
 * has been marked as deprecated, but may still be useful for if you are using
 * an old version of DataTables.
 *
 * @name Ellipses
 * @summary Show ellipses in the pagination control where there is a gap in numbers
 * @deprecated
 * @author [Dave Kennedy](http://daveden.wordpress.com/)
 * @example
 *     $(document).ready(function() {
 *         $('#example').dataTable({
 *             'sPaginationType': 'ellipses'
 *         ***REMOVED***);
 *     ***REMOVED***);
 */

$.extend($.fn.dataTableExt.oStdClasses, {
    'sPageEllipsis': 'paginate_ellipsis',
    'sPageNumber': 'paginate_number',
    'sPageNumbers': 'paginate_numbers'
***REMOVED***);

$.fn.dataTableExt.oPagination.ellipses = {
    'oDefaults': {
        'iShowPages': 5
    ***REMOVED***,
    'fnClickHandler': function(e) {
        var fnCallbackDraw = e.data.fnCallbackDraw,
            oSettings = e.data.oSettings,
            sPage = e.data.sPage;

        if ($(this).is('[disabled]')) {
            return false;
        ***REMOVED***

        oSettings.oApi._fnPageChange(oSettings, sPage);
        fnCallbackDraw(oSettings);

        return true;
    ***REMOVED***,
    // fnInit is called once for each instance of pager
    'fnInit': function(oSettings, nPager, fnCallbackDraw) {
        var oClasses = oSettings.oClasses,
            oLang = oSettings.oLanguage.oPaginate,
            that = this;

        var iShowPages = oSettings.oInit.iShowPages || this.oDefaults.iShowPages,
            iShowPagesHalf = Math.floor(iShowPages / 2);

        $.extend(oSettings, {
            _iShowPages: iShowPages,
            _iShowPagesHalf: iShowPagesHalf,
        ***REMOVED***);

        var oFirst = $('<a class="' + oClasses.sPageButton + ' ' + oClasses.sPageFirst + '">' + oLang.sFirst + '</a>'),
            oPrevious = $('<a class="' + oClasses.sPageButton + ' ' + oClasses.sPagePrevious + '">' + oLang.sPrevious + '</a>'),
            oNumbers = $('<span class="' + oClasses.sPageNumbers + '"></span>'),
            oNext = $('<a class="' + oClasses.sPageButton + ' ' + oClasses.sPageNext + '">' + oLang.sNext + '</a>'),
            oLast = $('<a class="' + oClasses.sPageButton + ' ' + oClasses.sPageLast + '">' + oLang.sLast + '</a>');

        oFirst.click({ 'fnCallbackDraw': fnCallbackDraw, 'oSettings': oSettings, 'sPage': 'first' ***REMOVED***, that.fnClickHandler);
        oPrevious.click({ 'fnCallbackDraw': fnCallbackDraw, 'oSettings': oSettings, 'sPage': 'previous' ***REMOVED***, that.fnClickHandler);
        oNext.click({ 'fnCallbackDraw': fnCallbackDraw, 'oSettings': oSettings, 'sPage': 'next' ***REMOVED***, that.fnClickHandler);
        oLast.click({ 'fnCallbackDraw': fnCallbackDraw, 'oSettings': oSettings, 'sPage': 'last' ***REMOVED***, that.fnClickHandler);

        // Draw
        $(nPager).append(oFirst, oPrevious, oNumbers, oNext, oLast);
    ***REMOVED***,
    // fnUpdate is only called once while table is rendered
    'fnUpdate': function(oSettings, fnCallbackDraw) {
        var oClasses = oSettings.oClasses,
            that = this;

        var tableWrapper = oSettings.nTableWrapper;

        // Update stateful properties
        this.fnUpdateState(oSettings);

        if (oSettings._iCurrentPage === 1) {
            $('.' + oClasses.sPageFirst, tableWrapper).attr('disabled', true);
            $('.' + oClasses.sPagePrevious, tableWrapper).attr('disabled', true);
        ***REMOVED*** else {
            $('.' + oClasses.sPageFirst, tableWrapper).removeAttr('disabled');
            $('.' + oClasses.sPagePrevious, tableWrapper).removeAttr('disabled');
        ***REMOVED***

        if (oSettings._iTotalPages === 0 || oSettings._iCurrentPage === oSettings._iTotalPages) {
            $('.' + oClasses.sPageNext, tableWrapper).attr('disabled', true);
            $('.' + oClasses.sPageLast, tableWrapper).attr('disabled', true);
        ***REMOVED*** else {
            $('.' + oClasses.sPageNext, tableWrapper).removeAttr('disabled');
            $('.' + oClasses.sPageLast, tableWrapper).removeAttr('disabled');
        ***REMOVED***

        var i, oNumber, oNumbers = $('.' + oClasses.sPageNumbers, tableWrapper);

        // Erase
        oNumbers.html('');

        for (i = oSettings._iFirstPage; i <= oSettings._iLastPage; i++) {
            oNumber = $('<a class="' + oClasses.sPageButton + ' ' + oClasses.sPageNumber + '">' + oSettings.fnFormatNumber(i) + '</a>');

            if (oSettings._iCurrentPage === i) {
                oNumber.attr('active', true).attr('disabled', true);
            ***REMOVED*** else {
                oNumber.click({ 'fnCallbackDraw': fnCallbackDraw, 'oSettings': oSettings, 'sPage': i - 1 ***REMOVED***, that.fnClickHandler);
            ***REMOVED***

            // Draw
            oNumbers.append(oNumber);
        ***REMOVED***

        // Add ellipses
        if (1 < oSettings._iFirstPage) {
            oNumbers.prepend('<span class="' + oClasses.sPageEllipsis + '">...</span>');
        ***REMOVED***

        if (oSettings._iLastPage < oSettings._iTotalPages) {
            oNumbers.append('<span class="' + oClasses.sPageEllipsis + '">...</span>');
        ***REMOVED***
    ***REMOVED***,
    // fnUpdateState used to be part of fnUpdate
    // The reason for moving is so we can access current state info before fnUpdate is called
    'fnUpdateState': function(oSettings) {
        var iCurrentPage = Math.ceil((oSettings._iDisplayStart + 1) / oSettings._iDisplayLength),
            iTotalPages = Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength),
            iFirstPage = iCurrentPage - oSettings._iShowPagesHalf,
            iLastPage = iCurrentPage + oSettings._iShowPagesHalf;

        if (iTotalPages < oSettings._iShowPages) {
            iFirstPage = 1;
            iLastPage = iTotalPages;
        ***REMOVED*** else if (iFirstPage < 1) {
            iFirstPage = 1;
            iLastPage = oSettings._iShowPages;
        ***REMOVED*** else if (iLastPage > iTotalPages) {
            iFirstPage = (iTotalPages - oSettings._iShowPages) + 1;
            iLastPage = iTotalPages;
        ***REMOVED***

        $.extend(oSettings, {
            _iCurrentPage: iCurrentPage,
            _iTotalPages: iTotalPages,
            _iFirstPage: iFirstPage,
            _iLastPage: iLastPage
        ***REMOVED***);
    ***REMOVED***
***REMOVED***;
