// preview

(function($) {
    "use strict";

    $.asColorPicker.registerComponent('preview', function() {
        return {
            defaults: {
                template: function(namespace) {
                    return '<ul class="' + namespace + '-preview"><li class="' + namespace + '-preview-current"><span /></li><li class="' + namespace + '-preview-previous"><span /></li></ul>';
                ***REMOVED***
            ***REMOVED***,
            init: function(api, options) {
                var self = this;
                this.options = $.extend(this.defaults, options);
                this.$preview = $(this.options.template.call(self, api.namespace)).appendTo(api.$dropdown);
                this.$current = this.$preview.find('.' + api.namespace + '-preview-current span');
                this.$previous = this.$preview.find('.' + api.namespace + '-preview-previous span');

                api.$element.on('asColorPicker::firstOpen', function() {
                    self.$previous.on('click', function() {
                        api.set($(this).data('color'));
                        return false;
                    ***REMOVED***);
                ***REMOVED***);

                api.$element.on('asColorPicker::setup', function(e, api, color) {
                    self.updateCurrent(color);
                    self.updatePreview(color);
                ***REMOVED***);
                api.$element.on('asColorPicker::update', function(e, api, color) {
                    self.updateCurrent(color);
                ***REMOVED***);
            ***REMOVED***,
            updateCurrent: function(color) {
                this.$current.css('backgroundColor', color.toRGBA());
            ***REMOVED***,
            updatePreview: function(color) {
                this.$previous.css('backgroundColor', color.toRGBA());
                this.$previous.data('color', {
                    r: color.value.r,
                    g: color.value.g,
                    b: color.value.b,
                    a: color.value.a
                ***REMOVED***);
            ***REMOVED***
        ***REMOVED***;
    ***REMOVED***);
***REMOVED***)(jQuery);
