/*! jQuery wizard - v0.3.1 - 2015-05-07
 * https://github.com/amazingSurge/jquery-wizard
 * Copyright (c) 2015 amazingSurge; Licensed GPL */
(function($, document, window, undefined) {
    "use strict";

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


    var counter = 0;

    var Wizard = function(element, options) {
        this.$element = $(element);

        this.options = $.extend(true, {***REMOVED***, Wizard.defaults, options);

        this.$steps = this.$element.find(this.options.step);

        this.id = this.$element.attr('id');
        if (!this.id) {
            this.id = 'wizard-' + (++counter);
            this.$element.attr('id', this.id);
        ***REMOVED***

        this.initialize();
    ***REMOVED***

    function emulateTransitionEnd($el, duration) {
        var called = false;

        $el.one(Support.transition.end, function() {
            called = true;
        ***REMOVED***);
        var callback = function() {
            if (!called) {
                $el.trigger(Support.transition.end);
            ***REMOVED***
        ***REMOVED***
        setTimeout(callback, duration);
    ***REMOVED***
    Wizard.defaults = {
        step: '.wizard-steps > li',

        getPane: function(index, step) {
            return this.$element.find('.wizard-content').children().eq(index);
        ***REMOVED***,

        buttonsAppendTo: 'this',
        templates: {
            buttons: function() {
                var options = this.options;
                return '<div class="wizard-buttons">' +
                    '<a class="wizard-back" href="#' + this.id + '" data-wizard="back" role="button">' + options.buttonLabels.back + '</a>' +
                    '<a class="wizard-next" href="#' + this.id + '" data-wizard="next" role="button">' + options.buttonLabels.next + '</a>' +
                    '<a class="wizard-finish" href="#' + this.id + '" data-wizard="finish" role="button">' + options.buttonLabels.finish + '</a>' +
                    '</div>';
            ***REMOVED***
        ***REMOVED***,

        classes: {
            step: {
                done: 'done',
                error: 'error',
                active: 'current',
                disabled: 'disabled',
                activing: 'activing',
                loading: 'loading'
            ***REMOVED***,

            pane: {
                active: 'active',
                activing: 'activing'
            ***REMOVED***,

            button: {
                hide: 'hide',
                disabled: 'disabled'
            ***REMOVED***
        ***REMOVED***,

        autoFocus: true,
        keyboard: true,

        enableWhenVisited: false,

        buttonLabels: {
            next: 'Next',
            back: 'Back',
            finish: 'Finish'
        ***REMOVED***,

        loading: {
            show: function(step) {***REMOVED***,
            hide: function(step) {***REMOVED***,
            fail: function(step) {***REMOVED***
        ***REMOVED***,

        cacheContent: false,

        validator: function(step) {
            return true;
        ***REMOVED***,

        onInit: null,
        onNext: null,
        onBack: null,
        onReset: null,

        onBeforeShow: null,
        onAfterShow: null,
        onBeforeHide: null,
        onAfterHide: null,
        onBeforeLoad: null,
        onAfterLoad: null,

        onBeforeChange: null,
        onAfterChange: null,

        onStateChange: null,

        onFinish: null
    ***REMOVED***;

    // Step
    function Step() {
        return this.initialize.apply(this, Array.prototype.slice.call(arguments));
    ***REMOVED***

    $.extend(Step.prototype, {
        TRANSITION_DURATION: 200,
        initialize: function(element, wizard, index) {
            this.$element = $(element);
            this.wizard = wizard;

            this.events = {***REMOVED***;
            this.loader = null;
            this.loaded = false;

            this.validator = this.wizard.options.validator;

            this.states = {
                done: false,
                error: false,
                active: false,
                disabled: false,
                activing: false
            ***REMOVED***;

            this.index = index;
            this.$element.data('wizard-index', index);


            this.$pane = this.getPaneFromTarget();

            if (!this.$pane) {
                this.$pane = this.wizard.options.getPane.call(this.wizard, index, element);
            ***REMOVED***

            this.setValidatorFromData();
            this.setLoaderFromData();
        ***REMOVED***,

        getPaneFromTarget: function() {
            var selector = this.$element.data('target');

            if (!selector) {
                selector = this.$element.attr('href');
                selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '');
            ***REMOVED***

            if (selector) {
                return $(selector);
            ***REMOVED*** else {
                return null;
            ***REMOVED***
        ***REMOVED***,

        setup: function() {
            var current = this.wizard.currentIndex();
            if (this.index === current) {
                this.enter('active');

                if (this.loader) {
                    this.load();
                ***REMOVED***
            ***REMOVED*** else if (this.index > current) {
                this.enter('disabled');
            ***REMOVED***

            this.$element.attr('aria-expanded', this.is('active'));
            this.$pane.attr('aria-expanded', this.is('active'));

            var classes = this.wizard.options.classes;
            if (this.is('active')) {
                this.$pane.addClass(classes.pane.active);
            ***REMOVED*** else {
                this.$pane.removeClass(classes.pane.active);
            ***REMOVED***
        ***REMOVED***,

        show: function(callback) {
            if (this.is('activing') || this.is('active')) {
                return;
            ***REMOVED***

            this.trigger('beforeShow');
            this.enter('activing');

            var classes = this.wizard.options.classes;

            this.$element
                .attr('aria-expanded', true);

            this.$pane
                .addClass(classes.pane.activing)
                .addClass(classes.pane.active)
                .attr('aria-expanded', true);

            var complete = function() {
                this.$pane
                    .removeClass(classes.pane.activing)

                this.leave('activing');
                this.enter('active');
                this.trigger('afterShow');

                if ($.isFunction(callback)) {
                    callback.call(this);
                ***REMOVED***
            ***REMOVED***

            if (!Support.transition) {
                return complete.call(this);
            ***REMOVED***

            this.$pane.one(Support.transition.end, $.proxy(complete, this));

            emulateTransitionEnd(this.$pane, this.TRANSITION_DURATION);
        ***REMOVED***,

        hide: function(callback) {
            if (this.is('activing') || !this.is('active')) {
                return;
            ***REMOVED***

            this.trigger('beforeHide');
            this.enter('activing');

            var classes = this.wizard.options.classes;

            this.$element
                .attr('aria-expanded', false);

            this.$pane
                .addClass(classes.pane.activing)
                .removeClass(classes.pane.active)
                .attr('aria-expanded', false);

            var complete = function() {
                this.$pane
                    .removeClass(classes.pane.activing);

                this.leave('activing');
                this.leave('active');
                this.trigger('afterHide');

                if ($.isFunction(callback)) {
                    callback.call(this);
                ***REMOVED***
            ***REMOVED***

            if (!Support.transition) {
                return complete.call(this);
            ***REMOVED***

            this.$pane.one(Support.transition.end, $.proxy(complete, this));

            emulateTransitionEnd(this.$pane, this.TRANSITION_DURATION);
        ***REMOVED***,

        empty: function() {
            this.$pane.empty();
        ***REMOVED***,

        load: function(callback) {
            var self = this;
            var loader = this.loader;

            if ($.isFunction(loader)) {
                loader = loader.call(this.wizard, this);
            ***REMOVED***

            if (this.wizard.options.cacheContent && this.loaded) {
                if ($.isFunction(callback)) {
                    callback.call(this);
                ***REMOVED***
                return true;
            ***REMOVED***

            this.trigger('beforeLoad');
            this.enter('loading');

            function setContent(content) {
                self.$pane.html(content);

                self.leave('loading');
                self.loaded = true;
                self.trigger('afterLoad');

                if ($.isFunction(callback)) {
                    callback.call(self);
                ***REMOVED***
            ***REMOVED***

            if (typeof loader === 'string') {
                setContent(loader);
            ***REMOVED*** else if (typeof loader === 'object' && loader.hasOwnProperty('url')) {
                self.wizard.options.loading.show.call(self.wizard, self);

                $.ajax(loader.url, loader.settings || {***REMOVED***).done(function(data) {
                    setContent(data);

                    self.wizard.options.loading.hide.call(self.wizard, self);
                ***REMOVED***).fail(function() {
                    self.wizard.options.loading.fail.call(self.wizard, self);
                ***REMOVED***);
            ***REMOVED*** else {
                setContent('');
            ***REMOVED***
        ***REMOVED***,

        trigger: function(event) {
            var method_arguments = Array.prototype.slice.call(arguments, 1);

            if ($.isArray(this.events[event])) {
                for (var i in this.events[event]) {
                    this.events[event][i].apply(this, method_arguments);
                ***REMOVED***
            ***REMOVED***

            this.wizard.trigger.apply(this.wizard, [event, this].concat(method_arguments));
        ***REMOVED***,

        enter: function(state) {
            this.states[state] = true;

            var classes = this.wizard.options.classes;
            this.$element.addClass(classes.step[state]);

            this.trigger('stateChange', true, state);
        ***REMOVED***,

        leave: function(state) {
            if (this.states[state]) {
                this.states[state] = false;

                var classes = this.wizard.options.classes;
                this.$element.removeClass(classes.step[state]);

                this.trigger('stateChange', false, state);
            ***REMOVED***
        ***REMOVED***,

        setValidatorFromData: function() {
            var validator = this.$pane.data('validator');
            if (validator && $.isFunction(window[validator])) {
                this.validator = window[validator];
            ***REMOVED***
        ***REMOVED***,

        setLoaderFromData: function() {
            var loader = this.$pane.data('loader');

            if (loader) {
                if ($.isFunction(window[loader])) {
                    this.loader = window[loader];
                ***REMOVED***
            ***REMOVED*** else {
                var url = this.$pane.data('loader-url');
                if (url) {
                    this.loader = {
                        url: url,
                        settings: this.$pane.data('settings') || {***REMOVED***
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***,

        /*
         * Public methods below
         */
        active: function() {
            return this.wizard.goTo(this.index);
        ***REMOVED***,

        on: function(event, handler) {
            if ($.isFunction(handler)) {
                if ($.isArray(this.events[event])) {
                    this.events[event].push(handler);
                ***REMOVED*** else {
                    this.events[event] = [handler];
                ***REMOVED***
            ***REMOVED***

            return this;
        ***REMOVED***,

        off: function(event, handler) {
            if ($.isFunction(handler) && $.isArray(this.events[event])) {
                $.each(this.events[event], function(i, f) {
                    if (f === handler) {
                        delete this.events[event][i];
                        return false;
                    ***REMOVED***
                ***REMOVED***);
            ***REMOVED***

            return this;
        ***REMOVED***,

        is: function(state) {
            return this.states[state] && this.states[state] === true;
        ***REMOVED***,

        reset: function() {
            for (var state in this.states) {
                this.leave(state);
            ***REMOVED***
            this.setup();

            return this;
        ***REMOVED***,

        setLoader: function(loader) {
            this.loader = loader;

            if (this.is('active')) {
                this.load();
            ***REMOVED***

            return this;
        ***REMOVED***,

        setValidator: function(validator) {
            if ($.isFunction(validator)) {
                this.validator = validator;
            ***REMOVED***

            return this;
        ***REMOVED***,

        validate: function() {
            return this.validator.call(this.$pane.get(0), this);
        ***REMOVED***
    ***REMOVED***);

    $.extend(Wizard.prototype, {
        Constructor: Wizard,
        initialize: function() {
            this.steps = [];
            var self = this;

            this.$steps.each(function(index) {
                self.steps.push(new Step(this, self, index));
            ***REMOVED***);

            this._current = 0;
            this.transitioning = null;

            $.each(this.steps, function(i, step) {
                step.setup();
            ***REMOVED***);

            this.setup();

            this.$element.on('click', this.options.step, function(e) {
                var index = $(this).data('wizard-index');

                if (!self.get(index).is('disabled')) {
                    self.goTo(index);
                ***REMOVED***

                e.preventDefault();
                e.stopPropagation();
            ***REMOVED***);

            if (this.options.keyboard) {
                $(document).on('keyup', $.proxy(this.keydown, this));
            ***REMOVED***

            this.trigger('init');
        ***REMOVED***,

        setup: function() {
            this.$buttons = $(this.options.templates.buttons.call(this));

            this.updateButtons();

            var buttonsAppendTo = this.options.buttonsAppendTo;
            var $to;
            if (buttonsAppendTo === 'this') {
                $to = this.$element;
            ***REMOVED*** else if ($.isFunction(buttonsAppendTo)) {
                $to = buttonsAppendTo.call(this);
            ***REMOVED*** else {
                $to = this.$element.find(buttonsAppendTo);
            ***REMOVED***
            this.$buttons = this.$buttons.appendTo($to);
        ***REMOVED***,

        updateButtons: function() {
            var classes = this.options.classes.button;
            var $back = this.$buttons.find('[data-wizard="back"]');
            var $next = this.$buttons.find('[data-wizard="next"]');
            var $finish = this.$buttons.find('[data-wizard="finish"]');

            if (this._current === 0) {
                $back.addClass(classes.disabled);
            ***REMOVED*** else {
                $back.removeClass(classes.disabled);
            ***REMOVED***

            if (this._current === this.lastIndex()) {
                $next.addClass(classes.hide);
                $finish.removeClass(classes.hide);
            ***REMOVED*** else {
                $next.removeClass(classes.hide);
                $finish.addClass(classes.hide);
            ***REMOVED***
        ***REMOVED***,

        updateSteps: function() {
            var self = this;

            $.each(this.steps, function(i, step) {

                if (i > self._current) {
                    step.leave('error');
                    step.leave('active');
                    step.leave('done');

                    if (!self.options.enableWhenVisited) {
                        step.enter('disabled');
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***);
        ***REMOVED***,

        keydown: function(e) {
            if (/input|textarea/i.test(e.target.tagName)) return;
            switch (e.which) {
                case 37:
                    this.back();
                    break;
                case 39:
                    this.next();
                    break;
                default:
                    return;
            ***REMOVED***

            e.preventDefault();
        ***REMOVED***,

        trigger: function(eventType) {
            var method_arguments = Array.prototype.slice.call(arguments, 1);
            var data = [this].concat(method_arguments);

            this.$element.trigger('wizard::' + eventType, data);

            // callback
            eventType = eventType.replace(/\b\w+\b/g, function(word) {
                return word.substring(0, 1).toUpperCase() + word.substring(1);
            ***REMOVED***);

            var onFunction = 'on' + eventType;
            if (typeof this.options[onFunction] === 'function') {
                this.options[onFunction].apply(this, method_arguments);
            ***REMOVED***
        ***REMOVED***,

        get: function(index) {
            if (typeof index === 'string' && index.substring(0, 1) === '#') {
                var id = index.substring(1);
                for (var i in this.steps) {
                    if (this.steps[i].$pane.attr('id') === id) {
                        return this.steps[i];
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***

            if (index < this.length() && this.steps[index]) {
                return this.steps[index];
            ***REMOVED***

            return null;
        ***REMOVED***,

        goTo: function(index, callback) {
            if (index === this._current || this.transitioning === true) {
                return false;
            ***REMOVED***

            var current = this.current();
            var to = this.get(index);

            if (index > this._current) {
                if (!current.validate()) {
                    current.leave('done');
                    current.enter('error');

                    return -1;
                ***REMOVED*** else {
                    current.leave('error');

                    if (index > this._current) {
                        current.enter('done');
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***

            var self = this;
            var process = function() {
                self.trigger('beforeChange', current, to);
                self.transitioning = true;

                current.hide();
                to.show(function() {
                    self._current = index;
                    self.transitioning = false;
                    this.leave('disabled');

                    self.updateButtons();
                    self.updateSteps();

                    if (self.options.autoFocus) {
                        var $input = this.$pane.find(':input');
                        if ($input.length > 0) {
                            $input.eq(0).focus();
                        ***REMOVED*** else {
                            this.$pane.focus();
                        ***REMOVED***
                    ***REMOVED***

                    if ($.isFunction(callback)) {
                        callback.call(self);
                    ***REMOVED***

                    self.trigger('afterChange', current, to);
                ***REMOVED***);
            ***REMOVED***;

            if (to.loader) {
                to.load(function() {
                    process();
                ***REMOVED***);
            ***REMOVED*** else {
                process();
            ***REMOVED***

            return true;
        ***REMOVED***,

        length: function() {
            return this.steps.length;
        ***REMOVED***,

        current: function() {
            return this.get(this._current);
        ***REMOVED***,

        currentIndex: function() {
            return this._current;
        ***REMOVED***,

        lastIndex: function() {
            return this.length() - 1;
        ***REMOVED***,

        next: function() {
            if (this._current < this.lastIndex()) {
                var from = this._current,
                    to = this._current + 1;

                this.goTo(to, function() {
                    this.trigger('next', this.get(from), this.get(to));
                ***REMOVED***);
            ***REMOVED***

            return false;
        ***REMOVED***,

        back: function() {
            if (this._current > 0) {
                var from = this._current,
                    to = this._current - 1;

                this.goTo(to, function() {
                    this.trigger('back', this.get(from), this.get(to));
                ***REMOVED***);
            ***REMOVED***

            return false;
        ***REMOVED***,

        first: function() {
            return this.goTo(0);
        ***REMOVED***,

        finish: function() {
            if (this._current === this.lastIndex()) {
                var current = this.current();
                if (current.validate()) {
                    this.trigger('finish');
                    current.leave('error');
                    current.enter('done');
                ***REMOVED*** else {
                    current.enter('error');
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***,

        reset: function() {
            this._current = 0;

            $.each(this.steps, function(i, step) {
                step.reset();
            ***REMOVED***);

            this.trigger('reset');
        ***REMOVED***
    ***REMOVED***);

    $(document).on('click', '[data-wizard]', function(e) {
        var href;
        var $this = $(this);
        var $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, ''));

        var wizard = $target.data('wizard');

        if (!wizard) {
            return;
        ***REMOVED***

        var method = $this.data('wizard');

        if (/^(back|next|first|finish|reset)$/.test(method)) {
            wizard[method]();
        ***REMOVED***

        e.preventDefault();
    ***REMOVED***);

    $.fn.wizard = function(options) {
        if (typeof options === 'string') {
            var method = options;
            var method_arguments = Array.prototype.slice.call(arguments, 1);

            if (/^\_/.test(method)) {
                return false;
            ***REMOVED*** else if ((/^(get)$/.test(method))) {
                var api = this.first().data('wizard');
                if (api && typeof api[method] === 'function') {
                    return api[method].apply(api, method_arguments);
                ***REMOVED***
            ***REMOVED*** else {
                return this.each(function() {
                    var api = $.data(this, 'wizard');
                    if (api && typeof api[method] === 'function') {
                        api[method].apply(api, method_arguments);
                    ***REMOVED***
                ***REMOVED***);
            ***REMOVED***
        ***REMOVED*** else {
            return this.each(function() {
                if (!$.data(this, 'wizard')) {
                    $.data(this, 'wizard', new Wizard(this, options));
                ***REMOVED***
            ***REMOVED***);
        ***REMOVED***
    ***REMOVED***;
***REMOVED***)(jQuery, document, window);
