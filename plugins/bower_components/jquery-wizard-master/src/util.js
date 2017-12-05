function emulateTransitionEnd($el, duration) {
    var called = false;

    $el.one(Support.transition.end, function () {
        called = true;
    ***REMOVED***);
    var callback = function () {
        if (!called) {
            $el.trigger( Support.transition.end );
        ***REMOVED***
    ***REMOVED***
    setTimeout(callback, duration);
***REMOVED***