// keyboard
(function(window, document, $, undefined) {
    "use strict";

    var $doc = $(document);
    var keyboard = {
        keys: {
            'UP': 38,
            'DOWN': 40,
            'LEFT': 37,
            'RIGHT': 39,
            'RETURN': 13,
            'ESCAPE': 27,
            'BACKSPACE': 8,
            'SPACE': 32
        ***REMOVED***,
        map: {***REMOVED***,
        bound: false,
        press: function(e) {
            var key = e.keyCode || e.which;
            if (key in keyboard.map && typeof keyboard.map[key] === 'function') {
                keyboard.map[key](e);
            ***REMOVED***
            return false;
        ***REMOVED***,
        attach: function(map) {
            var key, up;
            for (key in map) {
                if (map.hasOwnProperty(key)) {
                    up = key.toUpperCase();
                    if (up in keyboard.keys) {
                        keyboard.map[keyboard.keys[up]] = map[key];
                    ***REMOVED*** else {
                        keyboard.map[up] = map[key];
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***
            if (!keyboard.bound) {
                keyboard.bound = true;
                $doc.bind('keydown', keyboard.press);
            ***REMOVED***
        ***REMOVED***,
        detach: function() {
            keyboard.bound = false;
            keyboard.map = {***REMOVED***;
            $doc.unbind('keydown', keyboard.press);
        ***REMOVED***
    ***REMOVED***;
    $doc.on('asColorPicker::init', function(event, instance) {
        if (instance.options.keyboard === true) {
            instance._keyboard = keyboard;
        ***REMOVED***
    ***REMOVED***);
***REMOVED***)(window, document, jQuery);
