// clear

(function($) {
    "use strict";

    $.asColorPicker.registerComponent('clear', function() {
        return {
            defaults: {
                template: function(namespace) {
                    return '<a href="#" class="' + namespace + '-clear"></a>';
                ***REMOVED***
            ***REMOVED***,
            init: function(api, options) {
                if (api.options.hideInput) {
                    return;
                ***REMOVED***
                this.options = $.extend(this.defaults, options);
                this.$clear = $(this.options.template.call(this, api.namespace)).insertAfter(api.$element);

                this.$clear.on('click', function() {
                    api.clear();
                    return false;
                ***REMOVED***);
            ***REMOVED***
        ***REMOVED***;
    ***REMOVED***);
***REMOVED***)(jQuery);
