// hue
(function($) {
    "use strict";

    $.asColorPicker.registerComponent('hue', function() {
        return {
            size: 150,
            defaults: {
                direction: 'vertical', // horizontal
                template: function() {
                    var namespace = this.api.namespace;
                    return '<div class="' + namespace + '-hue ' + namespace + '-hue-' + this.direction + '"><i></i></div>';
                ***REMOVED***
            ***REMOVED***,
            data: {***REMOVED***,
            init: function(api, options) {
                var self = this;

                this.options = $.extend(this.defaults, options);
                this.direction = this.options.direction;
                this.api = api;

                this.$hue = $(this.options.template.call(self)).appendTo(api.$dropdown);
                this.$handle = this.$hue.find('i');

                api.$element.on('asColorPicker::firstOpen', function() {
                    // init variable
                    if (self.direction === 'vertical') {
                        self.size = self.$hue.height();
                    ***REMOVED*** else {
                        self.size = self.$hue.width();
                    ***REMOVED***
                    self.step = self.size / 360;

                    // bind events
                    self.bindEvents(api);
                    self.keyboard(api);
                ***REMOVED***);

                api.$element.on('asColorPicker::update asColorPicker::setup', function(e, api, color) {
                    self.update(color);
                ***REMOVED***);
            ***REMOVED***,
            bindEvents: function() {
                var self = this;
                this.$hue.on('mousedown.asColorPicker', function(e) {
                    var rightclick = (e.which) ? (e.which === 3) : (e.button === 2);
                    if (rightclick) {
                        return false;
                    ***REMOVED***
                    $.proxy(self.mousedown, self)(e);
                ***REMOVED***);
            ***REMOVED***,
            mousedown: function(e) {
                var offset = this.$hue.offset();
                if (this.direction === 'vertical') {
                    this.data.startY = e.pageY;
                    this.data.top = e.pageY - offset.top;
                    this.move(this.data.top);
                ***REMOVED*** else {
                    this.data.startX = e.pageX;
                    this.data.left = e.pageX - offset.left;
                    this.move(this.data.left);
                ***REMOVED***

                this.mousemove = function(e) {
                    var position;
                    if (this.direction === 'vertical') {
                        position = this.data.top + (e.pageY || this.data.startY) - this.data.startY;
                    ***REMOVED*** else {
                        position = this.data.left + (e.pageX || this.data.startX) - this.data.startX;
                    ***REMOVED***

                    this.move(position);
                    return false;
                ***REMOVED***;

                this.mouseup = function() {
                    $(document).off({
                        mousemove: this.mousemove,
                        mouseup: this.mouseup
                    ***REMOVED***);
                    if (this.direction === 'vertical') {
                        this.data.top = this.data.cach;
                    ***REMOVED*** else {
                        this.data.left = this.data.cach;
                    ***REMOVED***

                    return false;
                ***REMOVED***;

                $(document).on({
                    mousemove: $.proxy(this.mousemove, this),
                    mouseup: $.proxy(this.mouseup, this)
                ***REMOVED***);

                return false;
            ***REMOVED***,
            move: function(position, hub, update) {
                position = Math.max(0, Math.min(this.size, position));
                this.data.cach = position;
                if (typeof hub === 'undefined') {
                    hub = (1 - position / this.size) * 360;
                ***REMOVED***
                hub = Math.max(0, Math.min(360, hub));
                if (this.direction === 'vertical') {
                    this.$handle.css({
                        top: position
                    ***REMOVED***);
                ***REMOVED*** else {
                    this.$handle.css({
                        left: position
                    ***REMOVED***);
                ***REMOVED***
                if (update !== false) {
                    this.api.set({
                        h: hub
                    ***REMOVED***);
                ***REMOVED***
            ***REMOVED***,
            moveLeft: function() {
                var step = this.step,
                    data = this.data;
                data.left = Math.max(0, Math.min(this.width, data.left - step));
                this.move(data.left);
            ***REMOVED***,
            moveRight: function() {
                var step = this.step,
                    data = this.data;
                data.left = Math.max(0, Math.min(this.width, data.left + step));
                this.move(data.left);
            ***REMOVED***,
            moveUp: function() {
                var step = this.step,
                    data = this.data;
                data.top = Math.max(0, Math.min(this.width, data.top - step));
                this.move(data.top);
            ***REMOVED***,
            moveDown: function() {
                var step = this.step,
                    data = this.data;
                data.top = Math.max(0, Math.min(this.width, data.top + step));
                this.move(data.top);
            ***REMOVED***,
            keyboard: function() {
                var keyboard, self = this;
                if (this.api._keyboard) {
                    keyboard = $.extend(true, {***REMOVED***, this.api._keyboard);
                ***REMOVED*** else {
                    return false;
                ***REMOVED***

                this.$hue.attr('tabindex', '0').on('focus', function() {
                    if (this.direction === 'vertical') {
                        keyboard.attach({
                            up: function() {
                                self.moveUp();
                            ***REMOVED***,
                            down: function() {
                                self.moveDown();
                            ***REMOVED***
                        ***REMOVED***);
                    ***REMOVED*** else {
                        keyboard.attach({
                            left: function() {
                                self.moveLeft();
                            ***REMOVED***,
                            right: function() {
                                self.moveRight();
                            ***REMOVED***
                        ***REMOVED***);
                    ***REMOVED***
                    return false;
                ***REMOVED***).on('blur', function() {
                    keyboard.detach();
                ***REMOVED***);
            ***REMOVED***,
            update: function(color) {
                var position = (color.value.h === 0) ? 0 : this.size * (1 - color.value.h / 360);
                this.move(position, color.value.h, false);
            ***REMOVED***,
            destroy: function() {
                $(document).off({
                    mousemove: this.mousemove,
                    mouseup: this.mouseup
                ***REMOVED***);
            ***REMOVED***
        ***REMOVED***;
    ***REMOVED***);
***REMOVED***)(jQuery);
