// palettes

(function($) {
    "use strict";

    function noop() {
        return;
    ***REMOVED***
    if (!window.localStorage) {
        window.localStorage = noop;
    ***REMOVED***

    $.asColorPicker.registerComponent('palettes', function() {
        return {
            defaults: {
                template: function(namespace) {
                    return '<ul class="' + namespace + '-palettes"></ul>';
                ***REMOVED***,
                item: function(namespace, color) {
                    return '<li data-color="' + color + '"><span style="background-color:' + color + '" /></li>';
                ***REMOVED***,
                colors: ['white', 'black', 'red', 'blue', 'yellow'],
                max: 10,
                localStorage: true
            ***REMOVED***,
            init: function(api, options) {
                var self = this,
                    colors, asColor = new $.asColor();

                this.options = $.extend(true, {***REMOVED***, this.defaults, options);
                this.colors = [];
                if (this.options.localStorage) {
                    var localKey = api.namespace + '_palettes_' + api.id;
                    colors = this.getLocal(localKey);
                    if (!colors) {
                        colors = this.options.colors;
                        this.setLocal(localKey, colors);
                    ***REMOVED***
                ***REMOVED*** else {
                    colors = this.options.colors;
                ***REMOVED***

                for (var i in colors) {
                    this.colors.push(asColor.val(colors[i]).toRGBA());
                ***REMOVED***

                var list = '';
                $.each(this.colors, function(i, color) {
                    list += self.options.item(api.namespace, color);
                ***REMOVED***);

                this.$palettes = $(this.options.template.call(this, api.namespace)).html(list).appendTo(api.$dropdown);

                this.$palettes.delegate('li', 'click', function(e) {
                    var color = $(this).data('color');
                    api.set(color);

                    e.preventDefault();
                    e.stopPropagation();
                ***REMOVED***);

                api.$element.on('asColorPicker::apply', function(e, api, color) {
                    if (typeof color.toRGBA !== 'function') {
                        color = color.get().color;
                    ***REMOVED***

                    var rgba = color.toRGBA();
                    if ($.inArray(rgba, self.colors) === -1) {
                        if (self.colors.length >= self.options.max) {
                            self.colors.shift();
                            self.$palettes.find('li').eq(0).remove();
                        ***REMOVED***

                        self.colors.push(rgba);

                        self.$palettes.append(self.options.item(api.namespace, color));

                        if (self.options.localStorage) {
                            self.setLocal(localKey, self.colors);
                        ***REMOVED***
                    ***REMOVED***
                ***REMOVED***);
            ***REMOVED***,
            setLocal: function(key, value) {
                var jsonValue = JSON.stringify(value);

                localStorage[key] = jsonValue;
            ***REMOVED***,
            getLocal: function(key) {
                var value = localStorage[key];

                return value ? JSON.parse(value) : value;
            ***REMOVED***
        ***REMOVED***;
    ***REMOVED***);
***REMOVED***)(jQuery);
