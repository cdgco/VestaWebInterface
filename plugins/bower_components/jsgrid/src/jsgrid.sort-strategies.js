(function(jsGrid, $, undefined) {

    var isDefined = function(val) {
        return typeof(val) !== "undefined" && val !== null;
    ***REMOVED***;

    var sortStrategies = {
        string: function(str1, str2) {
            if(!isDefined(str1) && !isDefined(str2))
                return 0;

            if(!isDefined(str1))
                return -1;

            if(!isDefined(str2))
                return 1;

            return ("" + str1).localeCompare("" + str2);
        ***REMOVED***,

        number: function(n1, n2) {
            return n1 - n2;
        ***REMOVED***,

        date: function(dt1, dt2) {
            return dt1 - dt2;
        ***REMOVED***,

        numberAsString: function(n1, n2) {
            return parseFloat(n1) - parseFloat(n2);
        ***REMOVED***
    ***REMOVED***;

    jsGrid.sortStrategies = sortStrategies;

***REMOVED***(jsGrid, jQuery));
