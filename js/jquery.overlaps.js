/*! Copyright (c) 2010 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version 1.2.3
 */

(function (factory) {
    if (typeof define === "function" && define.amd) {
        // AMD. Register as an anonymous module.
        define(["jquery"], factory);
    ***REMOVED*** else {
        // Browser globals
        factory(jQuery);
    ***REMOVED***
***REMOVED***(function ($) {
    function getDims(elems) {
        var dims = [], i = 0, offset, elem;

        while ((elem = elems[i++])) {
            offset = $(elem).offset();
            dims.push([
                offset.top,
                offset.left,
                elem.offsetWidth,
                elem.offsetHeight
            ]);
        ***REMOVED***
        return dims;
    ***REMOVED***
    function filterOverlaps(collection1, collection2) {
        var dims1  = getDims(collection1),
            dims2  = !collection2 ? dims1 : getDims(collection2),
            stack  = [],
            index1 = 0,
            index2 = 0,
            length1 = dims1.length,
            length2 = !collection2 ? dims1.length : dims2.length;

        if (!collection2) { collection2 = collection1; ***REMOVED***

    $.fn.overlaps = function(selector) {
        return this.pushStack(filterOverlaps(this, selector && $(selector)));
    ***REMOVED***;
        for (; index1 < length1; index1++) {
            for (index2 = 0; index2 < length2; index2++) {
                if (collection1[index1] === collection2[index2]) {
                    continue;
                ***REMOVED*** else if (checkOverlap(dims1[index1], dims2[index2])) {
                    stack.push( (length1 > length2) ?
                        collection1[index1] :
                        collection2[index2]);
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***
        return $.unique(stack);
    ***REMOVED***
***REMOVED***));
