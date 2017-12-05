// trigger

(function($) {
    "use strict";

    $.asColorPicker.registerComponent('trigger', function() {
        return {
            defaults: {
                template: function(namespace) {
                    return '<div class="' + namespace + '-trigger"><span></span></div>';
                ***REMOVED***
            ***REMOVED***,
            init: function(api, options) {
                this.options = $.extend(this.defaults, options),
                    api.$trigger = $(this.options.template.call(this, api.namespace));
                this.$trigger_inner = api.$trigger.children('span');

                api.$trigger.insertAfter(api.$element);
                api.$trigger.on('click', function() {
                    if (!api.opened) {
                        api.open();
                    ***REMOVED*** else {
                        api.close();
                    ***REMOVED***
                    return false;
                ***REMOVED***);
                var self = this;
                api.$element.on('asColorPicker::update', function(e, api, color, gradient) {
                    if (typeof gradient === 'undefined') {
                        gradient = false;
                    ***REMOVED***
                    self.update(color, gradient);
                ***REMOVED***);

                this.update(api.color);
            ***REMOVED***,
            update: function(color, gradient) {
                if (gradient) {
                    this.$trigger_inner.css('background', gradient.toString(true));
                ***REMOVED*** else {
                    this.$trigger_inner.css('background', color.toRGBA());
                ***REMOVED***
            ***REMOVED***,
            destroy: function(api) {
                api.$trigger.remove();
            ***REMOVED***
        ***REMOVED***;
    ***REMOVED***);
***REMOVED***)(jQuery);
