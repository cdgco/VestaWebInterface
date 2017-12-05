var Support = (function() {
    var style = $('<support>').get(0).style,
        prefixes = ['webkit', 'Moz', 'O', 'ms'],
        events = {
            transition: {
                end: {
                    WebkitTransition: 'webkitTransitionEnd',
                    MozTransition: 'transitionend',
                    OTransition: 'oTransitionEnd',
                    transition: 'transitionend'
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***,
        tests = {
            csstransitions: function() {
                return !!test('transition');
            ***REMOVED***
        ***REMOVED***;

    function test(property, prefixed) {
        var result = false,
            upper = property.charAt(0).toUpperCase() + property.slice(1);

        if (style[property] !== undefined) {
            result = property;
        ***REMOVED***
        if (!result) {
            $.each(prefixes, function(i, prefix) {
                if (style[prefix + upper] !== undefined) {
                    result = '-' + prefix.toLowerCase() + '-' + upper;
                    return false;
                ***REMOVED***
            ***REMOVED***);
        ***REMOVED***

        if (prefixed) {
            return result;
        ***REMOVED***
        if (result) {
            return true;
        ***REMOVED*** else {
            return false;
        ***REMOVED***
    ***REMOVED***

    function prefixed(property) {
        return test(property, true);
    ***REMOVED***
    var support = {***REMOVED***;
    if (tests.csstransitions()) {
        /* jshint -W053 */
        support.transition = new String(prefixed('transition'))
        support.transition.end = events.transition.end[support.transition];
    ***REMOVED***

    return support;
***REMOVED***)();

