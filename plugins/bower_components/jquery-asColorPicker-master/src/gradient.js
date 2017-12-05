// gradient

(function($, asGradient) {
    $.asColorPicker.registerComponent('gradient', function() {
        return {
            defaults: {
                switchable: true,
                switchText: 'Gradient',
                cancelText: 'Cancel',
                settings: {
                    forceStandard: true,
                    angleUseKeyword: true,
                    emptyString: '',
                    degradationFormat: false,
                    cleanPosition: false,
                    forceColorFormat: 'rgb', // rgb, rgba, hsl, hsla, hex
                ***REMOVED***,
                template: function() {
                    var namespace = this.api.namespace;
                    var control = '<div class="' + namespace + '-gradient-control">';
                    if (this.options.switchable) {
                        control += '<a href="#" class="' + namespace + '-gradient-switch">' + this.options.switchText + '</a>';
                    ***REMOVED***
                    control += '<a href="#" class="' + namespace + '-gradient-cancel">' + this.options.cancelText + '</a>' +
                        '</div>';

                    return control +
                        '<div class="' + namespace + '-gradient">' +
                        '<div class="' + namespace + '-gradient-preview">' +
                        '<ul class="' + namespace + '-gradient-markers"></ul>' +
                        '</div>' +
                        '<div class="' + namespace + '-gradient-wheel">' +
                        '<i></i>' +
                        '</div>' +
                        '<input class="' + namespace + '-gradient-angle" type="text" value="" size="3" />' +
                        '</div>';
                ***REMOVED***
            ***REMOVED***,
            init: function(api, options) {
                var self = this;

                api.$element.on('asColorPicker::ready', function(event, instance) {
                    if (instance.options.mode !== 'gradient') {
                        return;
                    ***REMOVED***

                    self.defaults.settings.color = api.options.color;
                    options = $.extend(true, self.defaults, options);

                    api.gradient = new Gradient(api, options);
                ***REMOVED***);
            ***REMOVED***
        ***REMOVED***;
    ***REMOVED***);

    function conventToPercentage(n) {
        if (n < 0) {
            n = 0;
        ***REMOVED*** else if (n > 1) {
            n = 1;
        ***REMOVED***
        return n * 100 + '%';
    ***REMOVED***

    var Gradient = function(api, options) {
        this.api = api;
        this.options = options;
        this.classes = {
            enable: api.namespace + '-gradient_enable',
            marker: api.namespace + '-gradient-marker',
            active: api.namespace + '-gradient-marker_active',
            focus: api.namespace + '-gradient_focus'
        ***REMOVED***;
        this.isEnabled = false;
        this.initialized = false;
        this.current = null;
        this.value = new asGradient(this.options.settings);
        this.$doc = $(document);

        var self = this;
        $.extend(self, {
            init: function() {
                self.$wrap = $(self.options.template.call(self)).appendTo(api.$dropdown);

                self.$gradient = self.$wrap.filter('.' + api.namespace + '-gradient');

                this.angle.init();
                this.preview.init();
                this.markers.init();
                this.wheel.init();

                this.bind();

                if (self.options.switchable === false) {
                    self.enable();
                ***REMOVED*** else {
                    if (this.value.matchString(api.element.value)) {
                        self.enable();
                    ***REMOVED***
                ***REMOVED***
                this.initialized = true;
            ***REMOVED***,
            bind: function() {
                var namespace = api.namespace;

                self.$gradient.on('update', function() {
                    var current = self.value.getById(self.current);

                    if (current) {
                        api._trigger('update', current.color, self.value);
                    ***REMOVED***

                    if (api.element.value !== self.value.toString()) {
                        api._updateInput();
                    ***REMOVED***
                ***REMOVED***);

                // self.$gradient.on('add', function(e, data) {
                //     if (data.stop) {
                //         self.active(data.stop.id);
                //         api._trigger('update', data.stop.color, self.value);
                //         api._updateInput();
                //     ***REMOVED***
                // ***REMOVED***);

                if (self.options.switchable) {
                    self.$wrap.on('click', '.' + namespace + '-gradient-switch', function() {
                        if (self.isEnabled) {
                            self.disable();
                        ***REMOVED*** else {
                            self.enable();
                        ***REMOVED***

                        return false;
                    ***REMOVED***);
                ***REMOVED***

                self.$wrap.on('click', '.' + namespace + '-gradient-cancel', function() {
                    if (self.options.switchable === false || asGradient.matchString(api.originValue)) {
                        self.overrideCore();
                    ***REMOVED***

                    api.cancel();

                    return false;
                ***REMOVED***);
            ***REMOVED***,
            overrideCore: function() {
                api.set = function(value) {
                    if (value !== '') {
                        api.isEmpty = false;
                    ***REMOVED*** else {
                        api.isEmpty = true;
                    ***REMOVED***
                    if (typeof value === 'string') {
                        if (self.options.switchable === false || asGradient.matchString(value)) {
                            if (self.isEnabled) {
                                self.val(value);
                                api.color = self.value;
                                self.$gradient.trigger('update', self.value.value);
                            ***REMOVED*** else {
                                self.enable(value);
                            ***REMOVED***
                        ***REMOVED*** else {
                            self.disable();
                            api.val(value);
                        ***REMOVED***
                    ***REMOVED*** else {
                        var current = self.value.getById(self.current);

                        if (current) {
                            current.color.val(value)
                            api._trigger('update', current.color, self.value);
                        ***REMOVED***

                        self.$gradient.trigger('update', {
                            id: self.current,
                            stop: current
                        ***REMOVED***);
                    ***REMOVED***
                ***REMOVED***;

                api._setup = function() {
                    var current = self.value.getById(self.current);

                    api._trigger('setup', current.color);
                ***REMOVED***;
            ***REMOVED***,
            revertCore: function() {
                api.set = $.proxy(api._set, api);
                api._setup = function() {
                    api._trigger('setup', api.color);
                ***REMOVED***;
            ***REMOVED***,
            preview: {
                init: function() {
                    var that = this;
                    self.$preview = self.$gradient.find('.' + api.namespace + '-gradient-preview');

                    self.$gradient.on('add del update empty', function() {
                        that.render();
                    ***REMOVED***);
                ***REMOVED***,
                render: function() {
                    self.$preview.css({
                        'background-image': self.value.toStringWithAngle('to right', true),
                    ***REMOVED***);
                    self.$preview.css({
                        'background-image': self.value.toStringWithAngle('to right'),
                    ***REMOVED***);
                ***REMOVED***
            ***REMOVED***,
            markers: {
                width: 160,
                init: function() {
                    self.$markers = self.$gradient.find('.' + api.namespace + '-gradient-markers').attr('tabindex', 0);
                    var that = this;

                    self.$gradient.on('add', function(e, data) {
                        that.add(data.stop);
                    ***REMOVED***);

                    self.$gradient.on('active', function(e, data) {
                        that.active(data.id);
                    ***REMOVED***);

                    self.$gradient.on('del', function(e, data) {
                        that.del(data.id);
                    ***REMOVED***);

                    self.$gradient.on('update', function(e, data) {
                        if (data.stop) {
                            that.update(data.stop.id, data.stop.color);
                        ***REMOVED***
                    ***REMOVED***);

                    self.$gradient.on('empty', function() {
                        that.empty();
                    ***REMOVED***);

                    self.$markers.on('mousedown.asColorPicker', function(e) {
                        var rightclick = (e.which) ? (e.which === 3) : (e.button === 2);
                        if (rightclick) {
                            return false;
                        ***REMOVED***

                        var position = parseFloat((e.pageX - self.$markers.offset().left) / self.markers.width, 10);
                        self.add('#fff', position);
                        return false;
                    ***REMOVED***);

                    self.$markers.on('mousedown.asColorPicker', 'li', function(e) {
                        var rightclick = (e.which) ? (e.which === 3) : (e.button === 2);
                        if (rightclick) {
                            return false;
                        ***REMOVED***
                        that.mousedown(this, e);
                        return false;
                    ***REMOVED***);

                    self.$doc.on('keydown.asColorPicker', function(e) {
                        if (self.api.opened && self.$markers.is('.' + self.classes.focus)) {

                            var key = e.keyCode || e.which;
                            if (key === 46 || key === 8) {
                                if (self.value.length <= 2) {
                                    return false;
                                ***REMOVED***

                                self.del(self.current);

                                return false;
                            ***REMOVED***
                        ***REMOVED***
                    ***REMOVED***);

                    self.$markers.on('focus.asColorPicker', function() {
                        self.$markers.addClass(self.classes.focus);
                    ***REMOVED***).on('blur.asColorPicker', function() {
                        self.$markers.removeClass(self.classes.focus);
                    ***REMOVED***);

                    self.$markers.on('click', 'li', function() {
                        var id = $(this).data('id');
                        self.active(id);
                    ***REMOVED***);
                ***REMOVED***,
                getMarker: function(id) {
                    return self.$markers.find('[data-id="' + id + '"]');
                ***REMOVED***,
                update: function(id, color) {
                    var $marker = this.getMarker(id);
                    $marker.find('span').css('background-color', color.toHEX());
                    $marker.find('i').css('background-color', color.toHEX());
                ***REMOVED***,
                add: function(stop) {
                    $('<li data-id="' + stop.id + '" style="left:' + conventToPercentage(stop.position) + '" class="' + self.classes.marker + '"><span style="background-color: ' + stop.color.toHEX() + '"></span><i style="background-color: ' + stop.color.toHEX() + '"></i></li>').appendTo(self.$markers);
                ***REMOVED***,
                empty: function() {
                    self.$markers.html('');
                ***REMOVED***,
                del: function(id) {
                    var $marker = this.getMarker(id);
                    var $to = $marker.prev();
                    if ($to.length === 0) {
                        $to = $marker.next();
                    ***REMOVED***

                    self.active($to.data('id'));
                    $marker.remove();
                ***REMOVED***,
                active: function(id) {
                    self.$markers.children().removeClass(self.classes.active);

                    var $marker = this.getMarker(id);
                    $marker.addClass(self.classes.active);

                    self.$markers.focus();
                    // self.api._trigger('apply', self.value.getById(id).color);
                ***REMOVED***,
                mousedown: function(marker, e) {
                    var that = this,
                        id = $(marker).data('id'),
                        first = $(marker).position().left,
                        start = e.pageX,
                        end;

                    this.mousemove = function(e) {
                        end = e.pageX || start;
                        var position = (first + end - start) / this.width;
                        that.move(marker, position, id);
                        return false;
                    ***REMOVED***;

                    this.mouseup = function() {
                        $(document).off({
                            mousemove: this.mousemove,
                            mouseup: this.mouseup
                        ***REMOVED***);

                        return false;
                    ***REMOVED***;

                    self.$doc.on({
                        mousemove: $.proxy(this.mousemove, this),
                        mouseup: $.proxy(this.mouseup, this)
                    ***REMOVED***);
                    self.active(id);
                    return false;
                ***REMOVED***,
                move: function(marker, position, id) {
                    self.api.isEmpty = false;
                    position = Math.max(0, Math.min(1, position));
                    $(marker).css({
                        left: conventToPercentage(position)
                    ***REMOVED***);
                    if (!id) {
                        id = $(marker).data('id');
                    ***REMOVED***

                    self.value.getById(id).setPosition(position);

                    self.$gradient.trigger('update', {
                        id: $(marker).data('id'),
                        position: position
                    ***REMOVED***);
                ***REMOVED***,
            ***REMOVED***,
            wheel: {
                init: function() {
                    var that = this;
                    self.$wheel = self.$gradient.find('.' + api.namespace + '-gradient-wheel');
                    self.$pointer = self.$wheel.find('i');

                    self.$gradient.on('update', function(e, data) {
                        if (typeof data.angle !== 'undefined') {
                            that.position(data.angle);
                        ***REMOVED***
                    ***REMOVED***);

                    self.$wheel.on('mousedown.asColorPicker', function(e) {
                        var rightclick = (e.which) ? (e.which === 3) : (e.button === 2);
                        if (rightclick) {
                            return false;
                        ***REMOVED***
                        that.mousedown(e, self);
                        return false;
                    ***REMOVED***);
                ***REMOVED***,
                mousedown: function(e, self) {
                    var offset = self.$wheel.offset();
                    var r = self.$wheel.width() / 2;
                    var startX = offset.left + r;
                    var startY = offset.top + r;
                    var $doc = self.$doc;
                    var that = this;

                    this.r = r;

                    this.wheelMove = function(e) {
                        var x = e.pageX - startX;
                        var y = startY - e.pageY;

                        var position = that.getPosition(x, y);
                        var angle = that.calAngle(position.x, position.y);
                        self.api.isEmpty = false;
                        self.setAngle(angle);
                    ***REMOVED***;
                    this.wheelMouseup = function() {
                        $doc.off({
                            mousemove: this.wheelMove,
                            mouseup: this.wheelMouseup
                        ***REMOVED***);
                        return false;
                    ***REMOVED***;
                    $doc.on({
                        mousemove: $.proxy(this.wheelMove, this),
                        mouseup: $.proxy(this.wheelMouseup, this)
                    ***REMOVED***);

                    this.wheelMove(e);
                ***REMOVED***,
                getPosition: function(a, b) {
                    var r = this.r;
                    var x = a / Math.sqrt(a * a + b * b) * r;
                    var y = b / Math.sqrt(a * a + b * b) * r;
                    return {
                        x: x,
                        y: y
                    ***REMOVED***;
                ***REMOVED***,
                calAngle: function(x, y) {
                    var deg = Math.round(Math.atan(Math.abs(x / y)) * (180 / Math.PI));
                    if (x < 0 && y > 0) {
                        return 360 - deg;
                    ***REMOVED***
                    if (x < 0 && y <= 0) {
                        return deg + 180;
                    ***REMOVED***
                    if (x >= 0 && y <= 0) {
                        return 180 - deg;
                    ***REMOVED***
                    if (x >= 0 && y > 0) {
                        return deg;
                    ***REMOVED***
                ***REMOVED***,
                set: function(value) {
                    self.value.angle(value);
                    self.$gradient.trigger('update', {
                        angle: value
                    ***REMOVED***);
                ***REMOVED***,
                position: function(angle) {
                    var r = this.r || self.$wheel.width() / 2;
                    var pos = this.calPointer(angle, r);
                    self.$pointer.css({
                        left: pos.x,
                        top: pos.y
                    ***REMOVED***);
                ***REMOVED***,
                calPointer: function(angle, r) {
                    var x = Math.sin(angle * Math.PI / 180) * r;
                    var y = Math.cos(angle * Math.PI / 180) * r;
                    return {
                        x: r + x,
                        y: r - y
                    ***REMOVED***;
                ***REMOVED***
            ***REMOVED***,
            angle: {
                init: function() {
                    self.$angle = self.$gradient.find('.' + api.namespace + '-gradient-angle');

                    self.$angle.on('blur.asColorPicker', function() {
                        self.setAngle(this.value);
                        return false;
                    ***REMOVED***).on('keydown.asColorPicker', function(e) {
                        var key = e.keyCode || e.which;
                        if (key === 13) {
                            self.api.isEmpty = false;
                            $(this).blur();
                            return false;
                        ***REMOVED***
                    ***REMOVED***);

                    self.$gradient.on('update', function(e, data) {
                        if (typeof data.angle !== 'undefined') {
                            self.$angle.val(data.angle);
                        ***REMOVED***
                    ***REMOVED***);
                ***REMOVED***,
                set: function(value) {
                    self.value.angle(value);
                    self.$gradient.trigger('update', {
                        angle: value
                    ***REMOVED***);
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***);

        this.init();
    ***REMOVED***;

    Gradient.prototype = {
        constructor: Gradient,

        enable: function(value) {
            if (this.isEnabled === true) {
                return;
            ***REMOVED***
            this.isEnabled = true;
            this.overrideCore();



            this.$gradient.addClass(this.classes.enable);
            this.markers.width = this.$markers.width();

            if (typeof value === 'undefined') {
                value = this.api.element.value;
            ***REMOVED***

            if (value !== '') {
                this.api.isEmpty = false;
            ***REMOVED*** else {
                this.api.isEmpty = true;
            ***REMOVED***

            if (!asGradient.matchString(value) && this._last) {
                this.value = this._last;
            ***REMOVED*** else {
                this.val(value);
            ***REMOVED***
            this.api.color = this.value;

            this.$gradient.trigger('update', this.value.value);

            if (this.api.opened) {
                this.api.position();
            ***REMOVED***
        ***REMOVED***,
        val: function(string) {
            if (string !== '' && this.value.toString() === string) {
                return;
            ***REMOVED***
            this.empty();
            this.value.val(string);
            this.value.reorder();

            if (this.value.length < 2) {
                var fill = string;

                if (!$.asColor.matchString(string)) {
                    fill = 'rgba(0,0,0,1)';
                ***REMOVED***

                if (this.value.length === 0) {
                    this.value.append(fill, 0);
                ***REMOVED***
                if (this.value.length === 1) {
                    this.value.append(fill, 1);
                ***REMOVED***
            ***REMOVED***

            var stop;
            for (var i = 0; i < this.value.length; i++) {
                stop = this.value.get(i);
                if (stop) {
                    this.$gradient.trigger('add', {
                        stop: stop
                    ***REMOVED***);
                ***REMOVED***
            ***REMOVED***

            this.active(stop.id);
        ***REMOVED***,
        disable: function() {
            if (this.isEnabled === false) {
                return;
            ***REMOVED***
            this.isEnabled = false;
            this.revertCore();

            this.$gradient.removeClass(this.classes.enable);
            this._last = this.value;
            this.api.color = this.api.color.getCurrent().color;
            this.api.set(this.api.color.value);

            if (this.api.opened) {
                this.api.position();
            ***REMOVED***
        ***REMOVED***,
        active: function(id) {
            if (this.current !== id) {
                this.current = id;
                this.value.setCurrentById(id);

                this.$gradient.trigger('active', {
                    id: id
                ***REMOVED***);
            ***REMOVED***
        ***REMOVED***,
        empty: function() {
            this.value.empty();
            this.$gradient.trigger('empty');
        ***REMOVED***,
        add: function(color, position) {
            var stop = this.value.insert(color, position);
            this.api.isEmpty = false;
            this.value.reorder();

            this.$gradient.trigger('add', {
                stop: stop
            ***REMOVED***);

            this.active(stop.id);

            this.$gradient.trigger('update', {
                stop: stop
            ***REMOVED***);
            return stop;
        ***REMOVED***,
        del: function(id) {
            if (this.value.length <= 2) {
                return;
            ***REMOVED***
            this.value.removeById(id);
            this.value.reorder();
            this.$gradient.trigger('del', {
                id: id
            ***REMOVED***);

            this.$gradient.trigger('update', {***REMOVED***);
        ***REMOVED***,
        setAngle: function(value) {
            this.value.angle(value);
            this.$gradient.trigger('update', {
                angle: value
            ***REMOVED***);
        ***REMOVED***
    ***REMOVED***;
***REMOVED***)(jQuery, (function($) {
    if ($.asGradient === undefined) {
        // console.info('lost dependency lib of $.asGradient , please load it first !');
        return false;
    ***REMOVED*** else {
        return $.asGradient;
    ***REMOVED***
***REMOVED***(jQuery)));
