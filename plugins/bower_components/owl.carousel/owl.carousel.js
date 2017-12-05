/**
 * Owl carousel
 * @version 2.0.0
 * @author Bartosz Wojciechowski
 * @license The MIT License (MIT)
 * @todo Lazy Load Icon
 * @todo prevent animationend bubling
 * @todo itemsScaleUp
 * @todo Test Zepto
 * @todo stagePadding calculate wrong active classes
 */
;(function($, window, document, undefined) {

	/**
	 * Creates a carousel.
	 * @class The Owl Carousel.
	 * @public
	 * @param {HTMLElement|jQuery***REMOVED*** element - The element to create the carousel for.
	 * @param {Object***REMOVED*** [options] - The options
	 */
	function Owl(element, options) {

		/**
		 * Current settings for the carousel.
		 * @public
		 */
		this.settings = null;

		/**
		 * Current options set by the caller including defaults.
		 * @public
		 */
		this.options = $.extend({***REMOVED***, Owl.Defaults, options);

		/**
		 * Plugin element.
		 * @public
		 */
		this.$element = $(element);

		/**
		 * Proxied event handlers.
		 * @protected
		 */
		this._handlers = {***REMOVED***;

		/**
		 * References to the running plugins of this carousel.
		 * @protected
		 */
		this._plugins = {***REMOVED***;

		/**
		 * Currently suppressed events to prevent them from beeing retriggered.
		 * @protected
		 */
		this._supress = {***REMOVED***;

		/**
		 * Absolute current position.
		 * @protected
		 */
		this._current = null;

		/**
		 * Animation speed in milliseconds.
		 * @protected
		 */
		this._speed = null;

		/**
		 * Coordinates of all items in pixel.
		 * @todo The name of this member is missleading.
		 * @protected
		 */
		this._coordinates = [];

		/**
		 * Current breakpoint.
		 * @todo Real media queries would be nice.
		 * @protected
		 */
		this._breakpoint = null;

		/**
		 * Current width of the plugin element.
		 */
		this._width = null;

		/**
		 * All real items.
		 * @protected
		 */
		this._items = [];

		/**
		 * All cloned items.
		 * @protected
		 */
		this._clones = [];

		/**
		 * Merge values of all items.
		 * @todo Maybe this could be part of a plugin.
		 * @protected
		 */
		this._mergers = [];

		/**
		 * Widths of all items.
		 */
		this._widths = [];

		/**
		 * Invalidated parts within the update process.
		 * @protected
		 */
		this._invalidated = {***REMOVED***;

		/**
		 * Ordered list of workers for the update process.
		 * @protected
		 */
		this._pipe = [];

		/**
		 * Current state information for the drag operation.
		 * @todo #261
		 * @protected
		 */
		this._drag = {
			time: null,
			target: null,
			pointer: null,
			stage: {
				start: null,
				current: null
			***REMOVED***,
			direction: null
		***REMOVED***;

		/**
		 * Current state information and their tags.
		 * @type {Object***REMOVED***
		 * @protected
		 */
		this._states = {
			current: {***REMOVED***,
			tags: {
				'initializing': [ 'busy' ],
				'animating': [ 'busy' ],
				'dragging': [ 'interacting' ]
			***REMOVED***
		***REMOVED***;

		$.each([ 'onResize', 'onThrottledResize' ], $.proxy(function(i, handler) {
			this._handlers[handler] = $.proxy(this[handler], this);
		***REMOVED***, this));

		$.each(Owl.Plugins, $.proxy(function(key, plugin) {
			this._plugins[key.charAt(0).toLowerCase() + key.slice(1)]
				= new plugin(this);
		***REMOVED***, this));

		$.each(Owl.Workers, $.proxy(function(priority, worker) {
			this._pipe.push({
				'filter': worker.filter,
				'run': $.proxy(worker.run, this)
			***REMOVED***);
		***REMOVED***, this));

		this.setup();
		this.initialize();
	***REMOVED***

	/**
	 * Default options for the carousel.
	 * @public
	 */
	Owl.Defaults = {
		items: 3,
		loop: false,
		center: false,
		rewind: false,

		mouseDrag: true,
		touchDrag: true,
		pullDrag: true,
		freeDrag: false,

		margin: 0,
		stagePadding: 0,

		merge: false,
		mergeFit: true,
		autoWidth: false,

		startPosition: 0,
		rtl: false,

		smartSpeed: 250,
		fluidSpeed: false,
		dragEndSpeed: false,

		responsive: {***REMOVED***,
		responsiveRefreshRate: 200,
		responsiveBaseElement: window,

		fallbackEasing: 'swing',

		info: false,

		nestedItemSelector: false,
		itemElement: 'div',
		stageElement: 'div',

		refreshClass: 'owl-refresh',
		loadedClass: 'owl-loaded',
		loadingClass: 'owl-loading',
		rtlClass: 'owl-rtl',
		responsiveClass: 'owl-responsive',
		dragClass: 'owl-drag',
		itemClass: 'owl-item',
		stageClass: 'owl-stage',
		stageOuterClass: 'owl-stage-outer',
		grabClass: 'owl-grab'
	***REMOVED***;

	/**
	 * Enumeration for width.
	 * @public
	 * @readonly
	 * @enum {String***REMOVED***
	 */
	Owl.Width = {
		Default: 'default',
		Inner: 'inner',
		Outer: 'outer'
	***REMOVED***;

	/**
	 * Enumeration for types.
	 * @public
	 * @readonly
	 * @enum {String***REMOVED***
	 */
	Owl.Type = {
		Event: 'event',
		State: 'state'
	***REMOVED***;

	/**
	 * Contains all registered plugins.
	 * @public
	 */
	Owl.Plugins = {***REMOVED***;

	/**
	 * List of workers involved in the update process.
	 */
	Owl.Workers = [ {
		filter: [ 'width', 'settings' ],
		run: function() {
			this._width = this.$element.width();
		***REMOVED***
	***REMOVED***, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			cache.current = this._items && this._items[this.relative(this._current)];
		***REMOVED***
	***REMOVED***, {
		filter: [ 'items', 'settings' ],
		run: function() {
			this.$stage.children('.cloned').remove();
		***REMOVED***
	***REMOVED***, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			var margin = this.settings.margin || '',
				grid = !this.settings.autoWidth,
				rtl = this.settings.rtl,
				css = {
					'width': 'auto',
					'margin-left': rtl ? margin : '',
					'margin-right': rtl ? '' : margin
				***REMOVED***;

			!grid && this.$stage.children().css(css);

			cache.css = css;
		***REMOVED***
	***REMOVED***, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			var width = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
				merge = null,
				iterator = this._items.length,
				grid = !this.settings.autoWidth,
				widths = [];

			cache.items = {
				merge: false,
				width: width
			***REMOVED***;

			while (iterator--) {
				merge = this._mergers[iterator];
				merge = this.settings.mergeFit && Math.min(merge, this.settings.items) || merge;

				cache.items.merge = merge > 1 || cache.items.merge;

				widths[iterator] = !grid ? this._items[iterator].width() : width * merge;
			***REMOVED***

			this._widths = widths;
		***REMOVED***
	***REMOVED***, {
		filter: [ 'items', 'settings' ],
		run: function() {
			var clones = [],
				items = this._items,
				settings = this.settings,
				view = Math.max(settings.items * 2, 4),
				size = Math.ceil(items.length / 2) * 2,
				repeat = settings.loop && items.length ? settings.rewind ? view : Math.max(view, size) : 0,
				append = '',
				prepend = '';

			repeat /= 2;

			while (repeat--) {
				clones.push(this.normalize(clones.length / 2, true));
				append = append + items[clones[clones.length - 1]][0].outerHTML;
				clones.push(this.normalize(items.length - 1 - (clones.length - 1) / 2, true));
				prepend = items[clones[clones.length - 1]][0].outerHTML + prepend;
			***REMOVED***

			this._clones = clones;

			$(append).addClass('cloned').appendTo(this.$stage);
			$(prepend).addClass('cloned').prependTo(this.$stage);
		***REMOVED***
	***REMOVED***, {
		filter: [ 'width', 'items', 'settings' ],
		run: function() {
			var rtl = this.settings.rtl ? 1 : -1,
				size = this._clones.length + this._items.length,
				iterator = -1,
				previous = 0,
				current = 0,
				coordinates = [];

			while (++iterator < size) {
				previous = coordinates[iterator - 1] || 0;
				current = this._widths[this.relative(iterator)] + this.settings.margin;
				coordinates.push(previous + current * rtl);
			***REMOVED***

			this._coordinates = coordinates;
		***REMOVED***
	***REMOVED***, {
		filter: [ 'width', 'items', 'settings' ],
		run: function() {
			var padding = this.settings.stagePadding,
				coordinates = this._coordinates,
				css = {
					'width': Math.ceil(Math.abs(coordinates[coordinates.length - 1])) + padding * 2,
					'padding-left': padding || '',
					'padding-right': padding || ''
				***REMOVED***;

			this.$stage.css(css);
		***REMOVED***
	***REMOVED***, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			var iterator = this._coordinates.length,
				grid = !this.settings.autoWidth,
				items = this.$stage.children();

			if (grid && cache.items.merge) {
				while (iterator--) {
					cache.css.width = this._widths[this.relative(iterator)];
					items.eq(iterator).css(cache.css);
				***REMOVED***
			***REMOVED*** else if (grid) {
				cache.css.width = cache.items.width;
				items.css(cache.css);
			***REMOVED***
		***REMOVED***
	***REMOVED***, {
		filter: [ 'items' ],
		run: function() {
			this._coordinates.length < 1 && this.$stage.removeAttr('style');
		***REMOVED***
	***REMOVED***, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			cache.current = cache.current ? this.$stage.children().index(cache.current) : 0;
			cache.current = Math.max(this.minimum(), Math.min(this.maximum(), cache.current));
			this.reset(cache.current);
		***REMOVED***
	***REMOVED***, {
		filter: [ 'position' ],
		run: function() {
			this.animate(this.coordinates(this._current));
		***REMOVED***
	***REMOVED***, {
		filter: [ 'width', 'position', 'items', 'settings' ],
		run: function() {
			var rtl = this.settings.rtl ? 1 : -1,
				padding = this.settings.stagePadding * 2,
				begin = this.coordinates(this.current()) + padding,
				end = begin + this.width() * rtl,
				inner, outer, matches = [], i, n;

			for (i = 0, n = this._coordinates.length; i < n; i++) {
				inner = this._coordinates[i - 1] || 0;
				outer = Math.abs(this._coordinates[i]) + padding * rtl;

				if ((this.op(inner, '<=', begin) && (this.op(inner, '>', end)))
					|| (this.op(outer, '<', begin) && this.op(outer, '>', end))) {
					matches.push(i);
				***REMOVED***
			***REMOVED***

			this.$stage.children('.active').removeClass('active');
			this.$stage.children(':eq(' + matches.join('), :eq(') + ')').addClass('active');

			if (this.settings.center) {
				this.$stage.children('.center').removeClass('center');
				this.$stage.children().eq(this.current()).addClass('center');
			***REMOVED***
		***REMOVED***
	***REMOVED*** ];

	/**
	 * Initializes the carousel.
	 * @protected
	 */
	Owl.prototype.initialize = function() {
		this.enter('initializing');
		this.trigger('initialize');

		this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl);

		if (this.settings.autoWidth && !this.is('pre-loading')) {
			var imgs, nestedSelector, width;
			imgs = this.$element.find('img');
			nestedSelector = this.settings.nestedItemSelector ? '.' + this.settings.nestedItemSelector : undefined;
			width = this.$element.children(nestedSelector).width();

			if (imgs.length && width <= 0) {
				this.preloadAutoWidthImages(imgs);
			***REMOVED***
		***REMOVED***

		this.$element.addClass(this.options.loadingClass);

		// create stage
		this.$stage = $('<' + this.settings.stageElement + ' class="' + this.settings.stageClass + '"/>')
			.wrap('<div class="' + this.settings.stageOuterClass + '"/>');

		// append stage
		this.$element.append(this.$stage.parent());

		// append content
		this.replace(this.$element.children().not(this.$stage.parent()));

		// check visibility
		if (this.$element.is(':visible')) {
			// update view
			this.refresh();
		***REMOVED*** else {
			// invalidate width
			this.invalidate('width');
		***REMOVED***

		this.$element
			.removeClass(this.options.loadingClass)
			.addClass(this.options.loadedClass);

		// register event handlers
		this.registerEventHandlers();

		this.leave('initializing');
		this.trigger('initialized');
	***REMOVED***;

	/**
	 * Setups the current settings.
	 * @todo Remove responsive classes. Why should adaptive designs be brought into IE8?
	 * @todo Support for media queries by using `matchMedia` would be nice.
	 * @public
	 */
	Owl.prototype.setup = function() {
		var viewport = this.viewport(),
			overwrites = this.options.responsive,
			match = -1,
			settings = null;

		if (!overwrites) {
			settings = $.extend({***REMOVED***, this.options);
		***REMOVED*** else {
			$.each(overwrites, function(breakpoint) {
				if (breakpoint <= viewport && breakpoint > match) {
					match = Number(breakpoint);
				***REMOVED***
			***REMOVED***);

			settings = $.extend({***REMOVED***, this.options, overwrites[match]);
			delete settings.responsive;

			// responsive class
			if (settings.responsiveClass) {
				this.$element.attr('class',
					this.$element.attr('class').replace(new RegExp('(' + this.options.responsiveClass + '-)\\S+\\s', 'g'), '$1' + match)
				);
			***REMOVED***
		***REMOVED***

		if (this.settings === null || this._breakpoint !== match) {
			this.trigger('change', { property: { name: 'settings', value: settings ***REMOVED*** ***REMOVED***);
			this._breakpoint = match;
			this.settings = settings;
			this.invalidate('settings');
			this.trigger('changed', { property: { name: 'settings', value: this.settings ***REMOVED*** ***REMOVED***);
		***REMOVED***
	***REMOVED***;

	/**
	 * Updates option logic if necessery.
	 * @protected
	 */
	Owl.prototype.optionsLogic = function() {
		if (this.settings.autoWidth) {
			this.settings.stagePadding = false;
			this.settings.merge = false;
		***REMOVED***
	***REMOVED***;

	/**
	 * Prepares an item before add.
	 * @todo Rename event parameter `content` to `item`.
	 * @protected
	 * @returns {jQuery|HTMLElement***REMOVED*** - The item container.
	 */
	Owl.prototype.prepare = function(item) {
		var event = this.trigger('prepare', { content: item ***REMOVED***);

		if (!event.data) {
			event.data = $('<' + this.settings.itemElement + '/>')
				.addClass(this.options.itemClass).append(item)
		***REMOVED***

		this.trigger('prepared', { content: event.data ***REMOVED***);

		return event.data;
	***REMOVED***;

	/**
	 * Updates the view.
	 * @public
	 */
	Owl.prototype.update = function() {
		var i = 0,
			n = this._pipe.length,
			filter = $.proxy(function(p) { return this[p] ***REMOVED***, this._invalidated),
			cache = {***REMOVED***;

		while (i < n) {
			if (this._invalidated.all || $.grep(this._pipe[i].filter, filter).length > 0) {
				this._pipe[i].run(cache);
			***REMOVED***
			i++;
		***REMOVED***

		this._invalidated = {***REMOVED***;

		!this.is('valid') && this.enter('valid');
	***REMOVED***;

	/**
	 * Gets the width of the view.
	 * @public
	 * @param {Owl.Width***REMOVED*** [dimension=Owl.Width.Default] - The dimension to return.
	 * @returns {Number***REMOVED*** - The width of the view in pixel.
	 */
	Owl.prototype.width = function(dimension) {
		dimension = dimension || Owl.Width.Default;
		switch (dimension) {
			case Owl.Width.Inner:
			case Owl.Width.Outer:
				return this._width;
			default:
				return this._width - this.settings.stagePadding * 2 + this.settings.margin;
		***REMOVED***
	***REMOVED***;

	/**
	 * Refreshes the carousel primarily for adaptive purposes.
	 * @public
	 */
	Owl.prototype.refresh = function() {
		this.enter('refreshing');
		this.trigger('refresh');

		this.setup();

		this.optionsLogic();

		this.$element.addClass(this.options.refreshClass);

		this.update();

		this.$element.removeClass(this.options.refreshClass);

		this.leave('refreshing');
		this.trigger('refreshed');
	***REMOVED***;

	/**
	 * Checks window `resize` event.
	 * @protected
	 */
	Owl.prototype.onThrottledResize = function() {
		window.clearTimeout(this.resizeTimer);
		this.resizeTimer = window.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate);
	***REMOVED***;

	/**
	 * Checks window `resize` event.
	 * @protected
	 */
	Owl.prototype.onResize = function() {
		if (!this._items.length) {
			return false;
		***REMOVED***

		if (this._width === this.$element.width()) {
			return false;
		***REMOVED***

		if (!this.$element.is(':visible')) {
			return false;
		***REMOVED***

		this.enter('resizing');

		if (this.trigger('resize').isDefaultPrevented()) {
			this.leave('resizing');
			return false;
		***REMOVED***

		this.invalidate('width');

		this.refresh();

		this.leave('resizing');
		this.trigger('resized');
	***REMOVED***;

	/**
	 * Registers event handlers.
	 * @todo Check `msPointerEnabled`
	 * @todo #261
	 * @protected
	 */
	Owl.prototype.registerEventHandlers = function() {
		if ($.support.transition) {
			this.$stage.on($.support.transition.end + '.owl.core', $.proxy(this.onTransitionEnd, this));
		***REMOVED***

		if (this.settings.responsive !== false) {
			this.on(window, 'resize', this._handlers.onThrottledResize);
		***REMOVED***

		if (this.settings.mouseDrag) {
			this.$element.addClass(this.options.dragClass);
			this.$stage.on('mousedown.owl.core', $.proxy(this.onDragStart, this));
			this.$stage.on('dragstart.owl.core selectstart.owl.core', function() { return false ***REMOVED***);
		***REMOVED***

		if (this.settings.touchDrag){
			this.$stage.on('touchstart.owl.core', $.proxy(this.onDragStart, this));
			this.$stage.on('touchcancel.owl.core', $.proxy(this.onDragEnd, this));
		***REMOVED***
	***REMOVED***;

	/**
	 * Handles `touchstart` and `mousedown` events.
	 * @todo Horizontal swipe threshold as option
	 * @todo #261
	 * @protected
	 * @param {Event***REMOVED*** event - The event arguments.
	 */
	Owl.prototype.onDragStart = function(event) {
		var stage = null;

		if (event.which === 3) {
			return;
		***REMOVED***

		if ($.support.transform) {
			stage = this.$stage.css('transform').replace(/.*\(|\)| /g, '').split(',');
			stage = {
				x: stage[stage.length === 16 ? 12 : 4],
				y: stage[stage.length === 16 ? 13 : 5]
			***REMOVED***;
		***REMOVED*** else {
			stage = this.$stage.position();
			stage = {
				x: this.settings.rtl ?
					stage.left + this.$stage.width() - this.width() + this.settings.margin :
					stage.left,
				y: stage.top
			***REMOVED***;
		***REMOVED***

		if (this.is('animating')) {
			$.support.transform ? this.animate(stage.x) : this.$stage.stop()
			this.invalidate('position');
		***REMOVED***

		this.$element.toggleClass(this.options.grabClass, event.type === 'mousedown');

		this.speed(0);

		this._drag.time = new Date().getTime();
		this._drag.target = $(event.target);
		this._drag.stage.start = stage;
		this._drag.stage.current = stage;
		this._drag.pointer = this.pointer(event);

		$(document).on('mouseup.owl.core touchend.owl.core', $.proxy(this.onDragEnd, this));

		$(document).one('mousemove.owl.core touchmove.owl.core', $.proxy(function(event) {
			var delta = this.difference(this._drag.pointer, this.pointer(event));

			$(document).on('mousemove.owl.core touchmove.owl.core', $.proxy(this.onDragMove, this));

			if (Math.abs(delta.x) < Math.abs(delta.y) && this.is('valid')) {
				return;
			***REMOVED***

			event.preventDefault();

			this.enter('dragging');
			this.trigger('drag');
		***REMOVED***, this));
	***REMOVED***;

	/**
	 * Handles the `touchmove` and `mousemove` events.
	 * @todo #261
	 * @protected
	 * @param {Event***REMOVED*** event - The event arguments.
	 */
	Owl.prototype.onDragMove = function(event) {
		var minimum = null,
			maximum = null,
			pull = null,
			delta = this.difference(this._drag.pointer, this.pointer(event)),
			stage = this.difference(this._drag.stage.start, delta);

		if (!this.is('dragging')) {
			return;
		***REMOVED***

		event.preventDefault();

		if (this.settings.loop) {
			minimum = this.coordinates(this.minimum());
			maximum = this.coordinates(this.maximum() + 1) - minimum;
			stage.x = (((stage.x - minimum) % maximum + maximum) % maximum) + minimum;
		***REMOVED*** else {
			minimum = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum());
			maximum = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum());
			pull = this.settings.pullDrag ? -1 * delta.x / 5 : 0;
			stage.x = Math.max(Math.min(stage.x, minimum + pull), maximum + pull);
		***REMOVED***

		this._drag.stage.current = stage;

		this.animate(stage.x);
	***REMOVED***;

	/**
	 * Handles the `touchend` and `mouseup` events.
	 * @todo #261
	 * @todo Threshold for click event
	 * @protected
	 * @param {Event***REMOVED*** event - The event arguments.
	 */
	Owl.prototype.onDragEnd = function(event) {
		var delta = this.difference(this._drag.pointer, this.pointer(event)),
			stage = this._drag.stage.current,
			direction = delta.x > 0 ^ this.settings.rtl ? 'left' : 'right';

		$(document).off('.owl.core');

		this.$element.removeClass(this.options.grabClass);

		if (delta.x !== 0 && this.is('dragging') || !this.is('valid')) {
			this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed);
			this.current(this.closest(stage.x, delta.x !== 0 ? direction : this._drag.direction));
			this.invalidate('position');
			this.update();

			this._drag.direction = direction;

			if (Math.abs(delta.x) > 3 || new Date().getTime() - this._drag.time > 300) {
				this._drag.target.one('click.owl.core', function() { return false; ***REMOVED***);
			***REMOVED***
		***REMOVED***

		if (!this.is('dragging')) {
			return;
		***REMOVED***

		this.leave('dragging');
		this.trigger('dragged');
	***REMOVED***;

	/**
	 * Gets absolute position of the closest item for a coordinate.
	 * @todo Setting `freeDrag` makes `closest` not reusable. See #165.
	 * @protected
	 * @param {Number***REMOVED*** coordinate - The coordinate in pixel.
	 * @param {String***REMOVED*** direction - The direction to check for the closest item. Ether `left` or `right`.
	 * @return {Number***REMOVED*** - The absolute position of the closest item.
	 */
	Owl.prototype.closest = function(coordinate, direction) {
		var position = -1,
			pull = 30,
			width = this.width(),
			coordinates = this.coordinates();

		if (!this.settings.freeDrag) {
			// check closest item
			$.each(coordinates, $.proxy(function(index, value) {
				if (coordinate > value - pull && coordinate < value + pull) {
					position = index;
				***REMOVED*** else if (this.op(coordinate, '<', value)
					&& this.op(coordinate, '>', coordinates[index + 1] || value - width)) {
					position = direction === 'left' ? index + 1 : index;
				***REMOVED***
				return position === -1;
			***REMOVED***, this));
		***REMOVED***

		if (!this.settings.loop) {
			// non loop boundries
			if (this.op(coordinate, '>', coordinates[this.minimum()])) {
				position = coordinate = this.minimum();
			***REMOVED*** else if (this.op(coordinate, '<', coordinates[this.maximum()])) {
				position = coordinate = this.maximum();
			***REMOVED***
		***REMOVED***

		return position;
	***REMOVED***;

	/**
	 * Animates the stage.
	 * @todo #270
	 * @public
	 * @param {Number***REMOVED*** coordinate - The coordinate in pixels.
	 */
	Owl.prototype.animate = function(coordinate) {
		var animate = this.speed() > 0;

		this.is('animating') && this.onTransitionEnd();

		if (animate) {
			this.enter('animating');
			this.trigger('translate');
		***REMOVED***

		if ($.support.transform3d && $.support.transition) {
			this.$stage.css({
				transform: 'translate3d(' + coordinate + 'px,0px,0px)',
				transition: (this.speed() / 1000) + 's'
			***REMOVED***);
		***REMOVED*** else if (animate) {
			this.$stage.animate({
				left: coordinate + 'px'
			***REMOVED***, this.speed(), this.settings.fallbackEasing, $.proxy(this.onTransitionEnd, this));
		***REMOVED*** else {
			this.$stage.css({
				left: coordinate + 'px'
			***REMOVED***);
		***REMOVED***
	***REMOVED***;

	/**
	 * Checks whether the carousel is in a specific state or not.
	 * @param {String***REMOVED*** state - The state to check.
	 * @returns {Boolean***REMOVED*** - The flag which indicates if the carousel is busy.
	 */
	Owl.prototype.is = function(state) {
		return this._states.current[state] && this._states.current[state] > 0;
	***REMOVED***;

	/**
	 * Sets the absolute position of the current item.
	 * @public
	 * @param {Number***REMOVED*** [position] - The new absolute position or nothing to leave it unchanged.
	 * @returns {Number***REMOVED*** - The absolute position of the current item.
	 */
	Owl.prototype.current = function(position) {
		if (position === undefined) {
			return this._current;
		***REMOVED***

		if (this._items.length === 0) {
			return undefined;
		***REMOVED***

		position = this.normalize(position);

		if (this._current !== position) {
			var event = this.trigger('change', { property: { name: 'position', value: position ***REMOVED*** ***REMOVED***);

			if (event.data !== undefined) {
				position = this.normalize(event.data);
			***REMOVED***

			this._current = position;

			this.invalidate('position');

			this.trigger('changed', { property: { name: 'position', value: this._current ***REMOVED*** ***REMOVED***);
		***REMOVED***

		return this._current;
	***REMOVED***;

	/**
	 * Invalidates the given part of the update routine.
	 * @param {String***REMOVED*** [part] - The part to invalidate.
	 * @returns {Array.<String>***REMOVED*** - The invalidated parts.
	 */
	Owl.prototype.invalidate = function(part) {
		if ($.type(part) === 'string') {
			this._invalidated[part] = true;
			this.is('valid') && this.leave('valid');
		***REMOVED***
		return $.map(this._invalidated, function(v, i) { return i ***REMOVED***);
	***REMOVED***;

	/**
	 * Resets the absolute position of the current item.
	 * @public
	 * @param {Number***REMOVED*** position - The absolute position of the new item.
	 */
	Owl.prototype.reset = function(position) {
		position = this.normalize(position);

		if (position === undefined) {
			return;
		***REMOVED***

		this._speed = 0;
		this._current = position;

		this.suppress([ 'translate', 'translated' ]);

		this.animate(this.coordinates(position));

		this.release([ 'translate', 'translated' ]);
	***REMOVED***;

	/**
	 * Normalizes an absolute or a relative position of an item.
	 * @public
	 * @param {Number***REMOVED*** position - The absolute or relative position to normalize.
	 * @param {Boolean***REMOVED*** [relative=false] - Whether the given position is relative or not.
	 * @returns {Number***REMOVED*** - The normalized position.
	 */
	Owl.prototype.normalize = function(position, relative) {
		var n = this._items.length,
			m = relative ? 0 : this._clones.length;

		if (!$.isNumeric(position) || n < 1) {
			position = undefined;
		***REMOVED*** else if (position < 0 || position >= n + m) {
			position = ((position - m / 2) % n + n) % n + m / 2;
		***REMOVED***

		return position;
	***REMOVED***;

	/**
	 * Converts an absolute position of an item into a relative one.
	 * @public
	 * @param {Number***REMOVED*** position - The absolute position to convert.
	 * @returns {Number***REMOVED*** - The converted position.
	 */
	Owl.prototype.relative = function(position) {
		position -= this._clones.length / 2;
		return this.normalize(position, true);
	***REMOVED***;

	/**
	 * Gets the maximum position for the current item.
	 * @public
	 * @param {Boolean***REMOVED*** [relative=false] - Whether to return an absolute position or a relative position.
	 * @returns {Number***REMOVED***
	 */
	Owl.prototype.maximum = function(relative) {
		var settings = this.settings,
			maximum = this._coordinates.length,
			boundary = Math.abs(this._coordinates[maximum - 1]) - this._width,
			i = -1, j;

		if (settings.loop) {
			maximum = this._clones.length / 2 + this._items.length - 1;
		***REMOVED*** else if (settings.autoWidth || settings.merge) {
			// binary search
			while (maximum - i > 1) {
				Math.abs(this._coordinates[j = maximum + i >> 1]) < boundary
					? i = j : maximum = j;
			***REMOVED***
		***REMOVED*** else if (settings.center) {
			maximum = this._items.length - 1;
		***REMOVED*** else {
			maximum = this._items.length - settings.items;
		***REMOVED***

		if (relative) {
			maximum -= this._clones.length / 2;
		***REMOVED***

		return Math.max(maximum, 0);
	***REMOVED***;

	/**
	 * Gets the minimum position for the current item.
	 * @public
	 * @param {Boolean***REMOVED*** [relative=false] - Whether to return an absolute position or a relative position.
	 * @returns {Number***REMOVED***
	 */
	Owl.prototype.minimum = function(relative) {
		return relative ? 0 : this._clones.length / 2;
	***REMOVED***;

	/**
	 * Gets an item at the specified relative position.
	 * @public
	 * @param {Number***REMOVED*** [position] - The relative position of the item.
	 * @return {jQuery|Array.<jQuery>***REMOVED*** - The item at the given position or all items if no position was given.
	 */
	Owl.prototype.items = function(position) {
		if (position === undefined) {
			return this._items.slice();
		***REMOVED***

		position = this.normalize(position, true);
		return this._items[position];
	***REMOVED***;

	/**
	 * Gets an item at the specified relative position.
	 * @public
	 * @param {Number***REMOVED*** [position] - The relative position of the item.
	 * @return {jQuery|Array.<jQuery>***REMOVED*** - The item at the given position or all items if no position was given.
	 */
	Owl.prototype.mergers = function(position) {
		if (position === undefined) {
			return this._mergers.slice();
		***REMOVED***

		position = this.normalize(position, true);
		return this._mergers[position];
	***REMOVED***;

	/**
	 * Gets the absolute positions of clones for an item.
	 * @public
	 * @param {Number***REMOVED*** [position] - The relative position of the item.
	 * @returns {Array.<Number>***REMOVED*** - The absolute positions of clones for the item or all if no position was given.
	 */
	Owl.prototype.clones = function(position) {
		var odd = this._clones.length / 2,
			even = odd + this._items.length,
			map = function(index) { return index % 2 === 0 ? even + index / 2 : odd - (index + 1) / 2 ***REMOVED***;

		if (position === undefined) {
			return $.map(this._clones, function(v, i) { return map(i) ***REMOVED***);
		***REMOVED***

		return $.map(this._clones, function(v, i) { return v === position ? map(i) : null ***REMOVED***);
	***REMOVED***;

	/**
	 * Sets the current animation speed.
	 * @public
	 * @param {Number***REMOVED*** [speed] - The animation speed in milliseconds or nothing to leave it unchanged.
	 * @returns {Number***REMOVED*** - The current animation speed in milliseconds.
	 */
	Owl.prototype.speed = function(speed) {
		if (speed !== undefined) {
			this._speed = speed;
		***REMOVED***

		return this._speed;
	***REMOVED***;

	/**
	 * Gets the coordinate of an item.
	 * @todo The name of this method is missleanding.
	 * @public
	 * @param {Number***REMOVED*** position - The absolute position of the item within `minimum()` and `maximum()`.
	 * @returns {Number|Array.<Number>***REMOVED*** - The coordinate of the item in pixel or all coordinates.
	 */
	Owl.prototype.coordinates = function(position) {
		var coordinate = null;

		if (position === undefined) {
			return $.map(this._coordinates, $.proxy(function(coordinate, index) {
				return this.coordinates(index);
			***REMOVED***, this));
		***REMOVED***

		if (this.settings.center) {
			coordinate = this._coordinates[position];
			coordinate += (this.width() - coordinate + (this._coordinates[position - 1] || 0)) / 2 * (this.settings.rtl ? -1 : 1);
		***REMOVED*** else {
			coordinate = this._coordinates[position - 1] || 0;
		***REMOVED***

		return coordinate;
	***REMOVED***;

	/**
	 * Calculates the speed for a translation.
	 * @protected
	 * @param {Number***REMOVED*** from - The absolute position of the start item.
	 * @param {Number***REMOVED*** to - The absolute position of the target item.
	 * @param {Number***REMOVED*** [factor=undefined] - The time factor in milliseconds.
	 * @returns {Number***REMOVED*** - The time in milliseconds for the translation.
	 */
	Owl.prototype.duration = function(from, to, factor) {
		return Math.min(Math.max(Math.abs(to - from), 1), 6) * Math.abs((factor || this.settings.smartSpeed));
	***REMOVED***;

	/**
	 * Slides to the specified item.
	 * @public
	 * @param {Number***REMOVED*** position - The position of the item.
	 * @param {Number***REMOVED*** [speed] - The time in milliseconds for the transition.
	 */
	Owl.prototype.to = function(position, speed) {
		var current = this.current(),
			revert = null,
			distance = position - this.relative(current),
			direction = (distance > 0) - (distance < 0),
			items = this._items.length,
			minimum = this.minimum(),
			maximum = this.maximum();

		if (this.settings.loop) {
			if (!this.settings.rewind && Math.abs(distance) > items / 2) {
				distance += direction * -1 * items;
			***REMOVED***

			position = current + distance;
			revert = ((position - minimum) % items + items) % items + minimum;

			if (revert !== position && revert - distance <= maximum && revert - distance > 0) {
				current = revert - distance;
				position = revert;
				this.reset(current);
			***REMOVED***
		***REMOVED*** else if (this.settings.rewind) {
			maximum += 1;
			position = (position % maximum + maximum) % maximum;
		***REMOVED*** else {
			position = Math.max(minimum, Math.min(maximum, position));
		***REMOVED***

		this.speed(this.duration(current, position, speed));
		this.current(position);

		if (this.$element.is(':visible')) {
			this.update();
		***REMOVED***
	***REMOVED***;

	/**
	 * Slides to the next item.
	 * @public
	 * @param {Number***REMOVED*** [speed] - The time in milliseconds for the transition.
	 */
	Owl.prototype.next = function(speed) {
		speed = speed || false;
		this.to(this.relative(this.current()) + 1, speed);
	***REMOVED***;

	/**
	 * Slides to the previous item.
	 * @public
	 * @param {Number***REMOVED*** [speed] - The time in milliseconds for the transition.
	 */
	Owl.prototype.prev = function(speed) {
		speed = speed || false;
		this.to(this.relative(this.current()) - 1, speed);
	***REMOVED***;

	/**
	 * Handles the end of an animation.
	 * @protected
	 * @param {Event***REMOVED*** event - The event arguments.
	 */
	Owl.prototype.onTransitionEnd = function(event) {

		// if css2 animation then event object is undefined
		if (event !== undefined) {
			event.stopPropagation();

			// Catch only owl-stage transitionEnd event
			if ((event.target || event.srcElement || event.originalTarget) !== this.$stage.get(0)) {
				return false;
			***REMOVED***
		***REMOVED***

		this.leave('animating');
		this.trigger('translated');
	***REMOVED***;

	/**
	 * Gets viewport width.
	 * @protected
	 * @return {Number***REMOVED*** - The width in pixel.
	 */
	Owl.prototype.viewport = function() {
		var width;
		if (this.options.responsiveBaseElement !== window) {
			width = $(this.options.responsiveBaseElement).width();
		***REMOVED*** else if (window.innerWidth) {
			width = window.innerWidth;
		***REMOVED*** else if (document.documentElement && document.documentElement.clientWidth) {
			width = document.documentElement.clientWidth;
		***REMOVED*** else {
			throw 'Can not detect viewport width.';
		***REMOVED***
		return width;
	***REMOVED***;

	/**
	 * Replaces the current content.
	 * @public
	 * @param {HTMLElement|jQuery|String***REMOVED*** content - The new content.
	 */
	Owl.prototype.replace = function(content) {
		this.$stage.empty();
		this._items = [];

		if (content) {
			content = (content instanceof jQuery) ? content : $(content);
		***REMOVED***

		if (this.settings.nestedItemSelector) {
			content = content.find('.' + this.settings.nestedItemSelector);
		***REMOVED***

		content.filter(function() {
			return this.nodeType === 1;
		***REMOVED***).each($.proxy(function(index, item) {
			item = this.prepare(item);
			this.$stage.append(item);
			this._items.push(item);
			this._mergers.push(item.find('[data-merge]').andSelf('[data-merge]').attr('data-merge') * 1 || 1);
		***REMOVED***, this));

		this.reset($.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0);

		this.invalidate('items');
	***REMOVED***;

	/**
	 * Adds an item.
	 * @todo Use `item` instead of `content` for the event arguments.
	 * @public
	 * @param {HTMLElement|jQuery|String***REMOVED*** content - The item content to add.
	 * @param {Number***REMOVED*** [position] - The relative position at which to insert the item otherwise the item will be added to the end.
	 */
	Owl.prototype.add = function(content, position) {
		var current = this.relative(this._current);

		position = position === undefined ? this._items.length : this.normalize(position, true);
		content = content instanceof jQuery ? content : $(content);

		this.trigger('add', { content: content, position: position ***REMOVED***);

		content = this.prepare(content);

		if (this._items.length === 0 || position === this._items.length) {
			this._items.length === 0 && this.$stage.append(content);
			this._items.length !== 0 && this._items[position - 1].after(content);
			this._items.push(content);
			this._mergers.push(content.find('[data-merge]').andSelf('[data-merge]').attr('data-merge') * 1 || 1);
		***REMOVED*** else {
			this._items[position].before(content);
			this._items.splice(position, 0, content);
			this._mergers.splice(position, 0, content.find('[data-merge]').andSelf('[data-merge]').attr('data-merge') * 1 || 1);
		***REMOVED***

		this._items[current] && this.reset(this._items[current].index());

		this.invalidate('items');

		this.trigger('added', { content: content, position: position ***REMOVED***);
	***REMOVED***;

	/**
	 * Removes an item by its position.
	 * @todo Use `item` instead of `content` for the event arguments.
	 * @public
	 * @param {Number***REMOVED*** position - The relative position of the item to remove.
	 */
	Owl.prototype.remove = function(position) {
		position = this.normalize(position, true);

		if (position === undefined) {
			return;
		***REMOVED***

		this.trigger('remove', { content: this._items[position], position: position ***REMOVED***);

		this._items[position].remove();
		this._items.splice(position, 1);
		this._mergers.splice(position, 1);

		this.invalidate('items');

		this.trigger('removed', { content: null, position: position ***REMOVED***);
	***REMOVED***;

	/**
	 * Preloads images with auto width.
	 * @todo Replace by a more generic approach
	 * @protected
	 */
	Owl.prototype.preloadAutoWidthImages = function(images) {
		images.each($.proxy(function(i, element) {
			this.enter('pre-loading');
			element = $(element);
			$(new Image()).one('load', $.proxy(function(e) {
				element.attr('src', e.target.src);
				element.css('opacity', 1);
				this.leave('pre-loading');
				!this.is('pre-loading') && !this.is('initializing') && this.refresh();
			***REMOVED***, this)).attr('src', element.attr('src') || element.attr('data-src') || element.attr('data-src-retina'));
		***REMOVED***, this));
	***REMOVED***;

	/**
	 * Destroys the carousel.
	 * @public
	 */
	Owl.prototype.destroy = function() {

		this.$element.off('.owl.core');
		this.$stage.off('.owl.core');
		$(document).off('.owl.core');

		if (this.settings.responsive !== false) {
			window.clearTimeout(this.resizeTimer);
			this.off(window, 'resize', this._handlers.onThrottledResize);
		***REMOVED***

		for (var i in this._plugins) {
			this._plugins[i].destroy();
		***REMOVED***

		this.$stage.children('.cloned').remove();

		this.$stage.unwrap();
		this.$stage.children().contents().unwrap();
		this.$stage.children().unwrap();

		this.$element
			.removeClass(this.options.refreshClass)
			.removeClass(this.options.loadingClass)
			.removeClass(this.options.loadedClass)
			.removeClass(this.options.rtlClass)
			.removeClass(this.options.dragClass)
			.removeClass(this.options.grabClass)
			.attr('class', this.$element.attr('class').replace(new RegExp(this.options.responsiveClass + '-\\S+\\s', 'g'), ''))
			.removeData('owl.carousel');
	***REMOVED***;

	/**
	 * Operators to calculate right-to-left and left-to-right.
	 * @protected
	 * @param {Number***REMOVED*** [a] - The left side operand.
	 * @param {String***REMOVED*** [o] - The operator.
	 * @param {Number***REMOVED*** [b] - The right side operand.
	 */
	Owl.prototype.op = function(a, o, b) {
		var rtl = this.settings.rtl;
		switch (o) {
			case '<':
				return rtl ? a > b : a < b;
			case '>':
				return rtl ? a < b : a > b;
			case '>=':
				return rtl ? a <= b : a >= b;
			case '<=':
				return rtl ? a >= b : a <= b;
			default:
				break;
		***REMOVED***
	***REMOVED***;

	/**
	 * Attaches to an internal event.
	 * @protected
	 * @param {HTMLElement***REMOVED*** element - The event source.
	 * @param {String***REMOVED*** event - The event name.
	 * @param {Function***REMOVED*** listener - The event handler to attach.
	 * @param {Boolean***REMOVED*** capture - Wether the event should be handled at the capturing phase or not.
	 */
	Owl.prototype.on = function(element, event, listener, capture) {
		if (element.addEventListener) {
			element.addEventListener(event, listener, capture);
		***REMOVED*** else if (element.attachEvent) {
			element.attachEvent('on' + event, listener);
		***REMOVED***
	***REMOVED***;

	/**
	 * Detaches from an internal event.
	 * @protected
	 * @param {HTMLElement***REMOVED*** element - The event source.
	 * @param {String***REMOVED*** event - The event name.
	 * @param {Function***REMOVED*** listener - The attached event handler to detach.
	 * @param {Boolean***REMOVED*** capture - Wether the attached event handler was registered as a capturing listener or not.
	 */
	Owl.prototype.off = function(element, event, listener, capture) {
		if (element.removeEventListener) {
			element.removeEventListener(event, listener, capture);
		***REMOVED*** else if (element.detachEvent) {
			element.detachEvent('on' + event, listener);
		***REMOVED***
	***REMOVED***;

	/**
	 * Triggers a public event.
	 * @todo Remove `status`, `relatedTarget` should be used instead.
	 * @protected
	 * @param {String***REMOVED*** name - The event name.
	 * @param {****REMOVED*** [data=null] - The event data.
	 * @param {String***REMOVED*** [namespace=carousel] - The event namespace.
	 * @param {String***REMOVED*** [state] - The state which is associated with the event.
	 * @param {Boolean***REMOVED*** [enter=false] - Indicates if the call enters the specified state or not.
	 * @returns {Event***REMOVED*** - The event arguments.
	 */
	Owl.prototype.trigger = function(name, data, namespace, state, enter) {
		var status = {
			item: { count: this._items.length, index: this.current() ***REMOVED***
		***REMOVED***, handler = $.camelCase(
			$.grep([ 'on', name, namespace ], function(v) { return v ***REMOVED***)
				.join('-').toLowerCase()
		), event = $.Event(
			[ name, 'owl', namespace || 'carousel' ].join('.').toLowerCase(),
			$.extend({ relatedTarget: this ***REMOVED***, status, data)
		);

		if (!this._supress[name]) {
			$.each(this._plugins, function(name, plugin) {
				if (plugin.onTrigger) {
					plugin.onTrigger(event);
				***REMOVED***
			***REMOVED***);

			this.register({ type: Owl.Type.Event, name: name ***REMOVED***);
			this.$element.trigger(event);

			if (this.settings && typeof this.settings[handler] === 'function') {
				this.settings[handler].call(this, event);
			***REMOVED***
		***REMOVED***

		return event;
	***REMOVED***;

	/**
	 * Enters a state.
	 * @param name - The state name.
	 */
	Owl.prototype.enter = function(name) {
		$.each([ name ].concat(this._states.tags[name] || []), $.proxy(function(i, name) {
			if (this._states.current[name] === undefined) {
				this._states.current[name] = 0;
			***REMOVED***

			this._states.current[name]++;
		***REMOVED***, this));
	***REMOVED***;

	/**
	 * Leaves a state.
	 * @param name - The state name.
	 */
	Owl.prototype.leave = function(name) {
		$.each([ name ].concat(this._states.tags[name] || []), $.proxy(function(i, name) {
			this._states.current[name]--;
		***REMOVED***, this));
	***REMOVED***;

	/**
	 * Registers an event or state.
	 * @public
	 * @param {Object***REMOVED*** object - The event or state to register.
	 */
	Owl.prototype.register = function(object) {
		if (object.type === Owl.Type.Event) {
			if (!$.event.special[object.name]) {
				$.event.special[object.name] = {***REMOVED***;
			***REMOVED***

			if (!$.event.special[object.name].owl) {
				var _default = $.event.special[object.name]._default;
				$.event.special[object.name]._default = function(e) {
					if (_default && _default.apply && (!e.namespace || e.namespace.indexOf('owl') === -1)) {
						return _default.apply(this, arguments);
					***REMOVED***
					return e.namespace && e.namespace.indexOf('owl') > -1;
				***REMOVED***;
				$.event.special[object.name].owl = true;
			***REMOVED***
		***REMOVED*** else if (object.type === Owl.Type.State) {
			if (!this._states.tags[object.name]) {
				this._states.tags[object.name] = object.tags;
			***REMOVED*** else {
				this._states.tags[object.name] = this._states.tags[object.name].concat(object.tags);
			***REMOVED***

			this._states.tags[object.name] = $.grep(this._states.tags[object.name], $.proxy(function(tag, i) {
				return $.inArray(tag, this._states.tags[object.name]) === i;
			***REMOVED***, this));
		***REMOVED***
	***REMOVED***;

	/**
	 * Suppresses events.
	 * @protected
	 * @param {Array.<String>***REMOVED*** events - The events to suppress.
	 */
	Owl.prototype.suppress = function(events) {
		$.each(events, $.proxy(function(index, event) {
			this._supress[event] = true;
		***REMOVED***, this));
	***REMOVED***;

	/**
	 * Releases suppressed events.
	 * @protected
	 * @param {Array.<String>***REMOVED*** events - The events to release.
	 */
	Owl.prototype.release = function(events) {
		$.each(events, $.proxy(function(index, event) {
			delete this._supress[event];
		***REMOVED***, this));
	***REMOVED***;

	/**
	 * Gets unified pointer coordinates from event.
	 * @todo #261
	 * @protected
	 * @param {Event***REMOVED*** - The `mousedown` or `touchstart` event.
	 * @returns {Object***REMOVED*** - Contains `x` and `y` coordinates of current pointer position.
	 */
	Owl.prototype.pointer = function(event) {
		var result = { x: null, y: null ***REMOVED***;

		event = event.originalEvent || event || window.event;

		event = event.touches && event.touches.length ?
			event.touches[0] : event.changedTouches && event.changedTouches.length ?
				event.changedTouches[0] : event;

		if (event.pageX) {
			result.x = event.pageX;
			result.y = event.pageY;
		***REMOVED*** else {
			result.x = event.clientX;
			result.y = event.clientY;
		***REMOVED***

		return result;
	***REMOVED***;

	/**
	 * Gets the difference of two vectors.
	 * @todo #261
	 * @protected
	 * @param {Object***REMOVED*** - The first vector.
	 * @param {Object***REMOVED*** - The second vector.
	 * @returns {Object***REMOVED*** - The difference.
	 */
	Owl.prototype.difference = function(first, second) {
		return {
			x: first.x - second.x,
			y: first.y - second.y
		***REMOVED***;
	***REMOVED***;

	/**
	 * The jQuery Plugin for the Owl Carousel
	 * @todo Navigation plugin `next` and `prev`
	 * @public
	 */
	$.fn.owlCarousel = function(option) {
		var args = Array.prototype.slice.call(arguments, 1);

		return this.each(function() {
			var $this = $(this),
				data = $this.data('owl.carousel');

			if (!data) {
				data = new Owl(this, typeof option == 'object' && option);
				$this.data('owl.carousel', data);

				$.each([
					'next', 'prev', 'to', 'destroy', 'refresh', 'replace', 'add', 'remove'
				], function(i, event) {
					data.register({ type: Owl.Type.Event, name: event ***REMOVED***);
					data.$element.on(event + '.owl.carousel.core', $.proxy(function(e) {
						if (e.namespace && e.relatedTarget !== this) {
							this.suppress([ event ]);
							data[event].apply(this, [].slice.call(arguments, 1));
							this.release([ event ]);
						***REMOVED***
					***REMOVED***, data));
				***REMOVED***);
			***REMOVED***

			if (typeof option == 'string' && option.charAt(0) !== '_') {
				data[option].apply(data, args);
			***REMOVED***
		***REMOVED***);
	***REMOVED***;

	/**
	 * The constructor for the jQuery Plugin
	 * @public
	 */
	$.fn.owlCarousel.Constructor = Owl;

***REMOVED***)(window.Zepto || window.jQuery, window, document);

/**
 * AutoRefresh Plugin
 * @version 2.0.0
 * @author Artus Kolanowski
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the auto refresh plugin.
	 * @class The Auto Refresh Plugin
	 * @param {Owl***REMOVED*** carousel - The Owl Carousel
	 */
	var AutoRefresh = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl***REMOVED***
		 */
		this._core = carousel;

		/**
		 * Refresh interval.
		 * @protected
		 * @type {number***REMOVED***
		 */
		this._interval = null;

		/**
		 * Whether the element is currently visible or not.
		 * @protected
		 * @type {Boolean***REMOVED***
		 */
		this._visible = null;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._handlers = {
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoRefresh) {
					this.watch();
				***REMOVED***
			***REMOVED***, this)
		***REMOVED***;

		// set default options
		this._core.options = $.extend({***REMOVED***, AutoRefresh.Defaults, this._core.options);

		// register event handlers
		this._core.$element.on(this._handlers);
	***REMOVED***;

	/**
	 * Default options.
	 * @public
	 */
	AutoRefresh.Defaults = {
		autoRefresh: true,
		autoRefreshInterval: 500
	***REMOVED***;

	/**
	 * Watches the element.
	 */
	AutoRefresh.prototype.watch = function() {
		if (this._interval) {
			return;
		***REMOVED***

		this._visible = this._core.$element.is(':visible');
		this._interval = window.setInterval($.proxy(this.refresh, this), this._core.settings.autoRefreshInterval);
	***REMOVED***;

	/**
	 * Refreshes the element.
	 */
	AutoRefresh.prototype.refresh = function() {
		if (this._core.$element.is(':visible') === this._visible) {
			return;
		***REMOVED***

		this._visible = !this._visible;

		this._core.$element.toggleClass('owl-hidden', !this._visible);

		this._visible && (this._core.invalidate('width') && this._core.refresh());
	***REMOVED***;

	/**
	 * Destroys the plugin.
	 */
	AutoRefresh.prototype.destroy = function() {
		var handler, property;

		window.clearInterval(this._interval);

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		***REMOVED***
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		***REMOVED***
	***REMOVED***;

	$.fn.owlCarousel.Constructor.Plugins.AutoRefresh = AutoRefresh;

***REMOVED***)(window.Zepto || window.jQuery, window, document);

/**
 * Lazy Plugin
 * @version 2.0.0
 * @author Bartosz Wojciechowski
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the lazy plugin.
	 * @class The Lazy Plugin
	 * @param {Owl***REMOVED*** carousel - The Owl Carousel
	 */
	var Lazy = function(carousel) {

		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl***REMOVED***
		 */
		this._core = carousel;

		/**
		 * Already loaded items.
		 * @protected
		 * @type {Array.<jQuery>***REMOVED***
		 */
		this._loaded = [];

		/**
		 * Event handlers.
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._handlers = {
			'initialized.owl.carousel change.owl.carousel': $.proxy(function(e) {
				if (!e.namespace) {
					return;
				***REMOVED***

				if (!this._core.settings || !this._core.settings.lazyLoad) {
					return;
				***REMOVED***

				if ((e.property && e.property.name == 'position') || e.type == 'initialized') {
					var settings = this._core.settings,
						n = (settings.center && Math.ceil(settings.items / 2) || settings.items),
						i = ((settings.center && n * -1) || 0),
						position = ((e.property && e.property.value) || this._core.current()) + i,
						clones = this._core.clones().length,
						load = $.proxy(function(i, v) { this.load(v) ***REMOVED***, this);

					while (i++ < n) {
						this.load(clones / 2 + this._core.relative(position));
						clones && $.each(this._core.clones(this._core.relative(position)), load);
						position++;
					***REMOVED***
				***REMOVED***
			***REMOVED***, this)
		***REMOVED***;

		// set the default options
		this._core.options = $.extend({***REMOVED***, Lazy.Defaults, this._core.options);

		// register event handler
		this._core.$element.on(this._handlers);
	***REMOVED***

	/**
	 * Default options.
	 * @public
	 */
	Lazy.Defaults = {
		lazyLoad: false
	***REMOVED***

	/**
	 * Loads all resources of an item at the specified position.
	 * @param {Number***REMOVED*** position - The absolute position of the item.
	 * @protected
	 */
	Lazy.prototype.load = function(position) {
		var $item = this._core.$stage.children().eq(position),
			$elements = $item && $item.find('.owl-lazy');

		if (!$elements || $.inArray($item.get(0), this._loaded) > -1) {
			return;
		***REMOVED***

		$elements.each($.proxy(function(index, element) {
			var $element = $(element), image,
				url = (window.devicePixelRatio > 1 && $element.attr('data-src-retina')) || $element.attr('data-src');

			this._core.trigger('load', { element: $element, url: url ***REMOVED***, 'lazy');

			if ($element.is('img')) {
				$element.one('load.owl.lazy', $.proxy(function() {
					$element.css('opacity', 1);
					this._core.trigger('loaded', { element: $element, url: url ***REMOVED***, 'lazy');
				***REMOVED***, this)).attr('src', url);
			***REMOVED*** else {
				image = new Image();
				image.onload = $.proxy(function() {
					$element.css({
						'background-image': 'url(' + url + ')',
						'opacity': '1'
					***REMOVED***);
					this._core.trigger('loaded', { element: $element, url: url ***REMOVED***, 'lazy');
				***REMOVED***, this);
				image.src = url;
			***REMOVED***
		***REMOVED***, this));

		this._loaded.push($item.get(0));
	***REMOVED***

	/**
	 * Destroys the plugin.
	 * @public
	 */
	Lazy.prototype.destroy = function() {
		var handler, property;

		for (handler in this.handlers) {
			this._core.$element.off(handler, this.handlers[handler]);
		***REMOVED***
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		***REMOVED***
	***REMOVED***;

	$.fn.owlCarousel.Constructor.Plugins.Lazy = Lazy;

***REMOVED***)(window.Zepto || window.jQuery, window, document);

/**
 * AutoHeight Plugin
 * @version 2.0.0
 * @author Bartosz Wojciechowski
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the auto height plugin.
	 * @class The Auto Height Plugin
	 * @param {Owl***REMOVED*** carousel - The Owl Carousel
	 */
	var AutoHeight = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl***REMOVED***
		 */
		this._core = carousel;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._handlers = {
			'initialized.owl.carousel refreshed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoHeight) {
					this.update();
				***REMOVED***
			***REMOVED***, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoHeight && e.property.name == 'position'){
					this.update();
				***REMOVED***
			***REMOVED***, this),
			'loaded.owl.lazy': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoHeight
					&& e.element.closest('.' + this._core.settings.itemClass).index() === this._core.current()) {
					this.update();
				***REMOVED***
			***REMOVED***, this)
		***REMOVED***;

		// set default options
		this._core.options = $.extend({***REMOVED***, AutoHeight.Defaults, this._core.options);

		// register event handlers
		this._core.$element.on(this._handlers);
	***REMOVED***;

	/**
	 * Default options.
	 * @public
	 */
	AutoHeight.Defaults = {
		autoHeight: false,
		autoHeightClass: 'owl-height'
	***REMOVED***;

	/**
	 * Updates the view.
	 */
	AutoHeight.prototype.update = function() {
		var start = this._core._current,
			end = start + this._core.settings.items,
			visible = this._core.$stage.children().toArray().slice(start, end);
			heights = [],
			maxheight = 0;

		$.each(visible, function(index, item) {
			heights.push($(item).height());
		***REMOVED***);

		maxheight = Math.max.apply(null, heights);

		this._core.$stage.parent()
			.height(maxheight)
			.addClass(this._core.settings.autoHeightClass);
	***REMOVED***;

	AutoHeight.prototype.destroy = function() {
		var handler, property;

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		***REMOVED***
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		***REMOVED***
	***REMOVED***;

	$.fn.owlCarousel.Constructor.Plugins.AutoHeight = AutoHeight;

***REMOVED***)(window.Zepto || window.jQuery, window, document);

/**
 * Video Plugin
 * @version 2.0.0
 * @author Bartosz Wojciechowski
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the video plugin.
	 * @class The Video Plugin
	 * @param {Owl***REMOVED*** carousel - The Owl Carousel
	 */
	var Video = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl***REMOVED***
		 */
		this._core = carousel;

		/**
		 * Cache all video URLs.
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._videos = {***REMOVED***;

		/**
		 * Current playing item.
		 * @protected
		 * @type {jQuery***REMOVED***
		 */
		this._playing = null;

		/**
		 * All event handlers.
		 * @todo The cloned content removale is too late
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._handlers = {
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace) {
					this._core.register({ type: 'state', name: 'playing', tags: [ 'interacting' ] ***REMOVED***);
				***REMOVED***
			***REMOVED***, this),
			'resize.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.video && this.isInFullScreen()) {
					e.preventDefault();
				***REMOVED***
			***REMOVED***, this),
			'refreshed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.is('resizing')) {
					this._core.$stage.find('.cloned .owl-video-frame').remove();
				***REMOVED***
			***REMOVED***, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name === 'position' && this._playing) {
					this.stop();
				***REMOVED***
			***REMOVED***, this),
			'prepared.owl.carousel': $.proxy(function(e) {
				if (!e.namespace) {
					return;
				***REMOVED***

				var $element = $(e.content).find('.owl-video');

				if ($element.length) {
					$element.css('display', 'none');
					this.fetch($element, $(e.content));
				***REMOVED***
			***REMOVED***, this)
		***REMOVED***;

		// set default options
		this._core.options = $.extend({***REMOVED***, Video.Defaults, this._core.options);

		// register event handlers
		this._core.$element.on(this._handlers);

		this._core.$element.on('click.owl.video', '.owl-video-play-icon', $.proxy(function(e) {
			this.play(e);
		***REMOVED***, this));
	***REMOVED***;

	/**
	 * Default options.
	 * @public
	 */
	Video.Defaults = {
		video: false,
		videoHeight: false,
		videoWidth: false
	***REMOVED***;

	/**
	 * Gets the video ID and the type (YouTube/Vimeo only).
	 * @protected
	 * @param {jQuery***REMOVED*** target - The target containing the video data.
	 * @param {jQuery***REMOVED*** item - The item containing the video.
	 */
	Video.prototype.fetch = function(target, item) {
		var type = target.attr('data-vimeo-id') ? 'vimeo' : 'youtube',
			id = target.attr('data-vimeo-id') || target.attr('data-youtube-id'),
			width = target.attr('data-width') || this._core.settings.videoWidth,
			height = target.attr('data-height') || this._core.settings.videoHeight,
			url = target.attr('href');

		if (url) {
			id = url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

			if (id[3].indexOf('youtu') > -1) {
				type = 'youtube';
			***REMOVED*** else if (id[3].indexOf('vimeo') > -1) {
				type = 'vimeo';
			***REMOVED*** else {
				throw new Error('Video URL not supported.');
			***REMOVED***
			id = id[6];
		***REMOVED*** else {
			throw new Error('Missing video URL.');
		***REMOVED***

		this._videos[url] = {
			type: type,
			id: id,
			width: width,
			height: height
		***REMOVED***;

		item.attr('data-video', url);

		this.thumbnail(target, this._videos[url]);
	***REMOVED***;

	/**
	 * Creates video thumbnail.
	 * @protected
	 * @param {jQuery***REMOVED*** target - The target containing the video data.
	 * @param {Object***REMOVED*** info - The video info object.
	 * @see `fetch`
	 */
	Video.prototype.thumbnail = function(target, video) {
		var tnLink,
			icon,
			path,
			dimensions = video.width && video.height ? 'style="width:' + video.width + 'px;height:' + video.height + 'px;"' : '',
			customTn = target.find('img'),
			srcType = 'src',
			lazyClass = '',
			settings = this._core.settings,
			create = function(path) {
				icon = '<div class="owl-video-play-icon"></div>';

				if (settings.lazyLoad) {
					tnLink = '<div class="owl-video-tn ' + lazyClass + '" ' + srcType + '="' + path + '"></div>';
				***REMOVED*** else {
					tnLink = '<div class="owl-video-tn" style="opacity:1;background-image:url(' + path + ')"></div>';
				***REMOVED***
				target.after(tnLink);
				target.after(icon);
			***REMOVED***;

		// wrap video content into owl-video-wrapper div
		target.wrap('<div class="owl-video-wrapper"' + dimensions + '></div>');

		if (this._core.settings.lazyLoad) {
			srcType = 'data-src';
			lazyClass = 'owl-lazy';
		***REMOVED***

		// custom thumbnail
		if (customTn.length) {
			create(customTn.attr(srcType));
			customTn.remove();
			return false;
		***REMOVED***

		if (video.type === 'youtube') {
			path = "http://img.youtube.com/vi/" + video.id + "/hqdefault.jpg";
			create(path);
		***REMOVED*** else if (video.type === 'vimeo') {
			$.ajax({
				type: 'GET',
				url: 'http://vimeo.com/api/v2/video/' + video.id + '.json',
				jsonp: 'callback',
				dataType: 'jsonp',
				success: function(data) {
					path = data[0].thumbnail_large;
					create(path);
				***REMOVED***
			***REMOVED***);
		***REMOVED***
	***REMOVED***;

	/**
	 * Stops the current video.
	 * @public
	 */
	Video.prototype.stop = function() {
		this._core.trigger('stop', null, 'video');
		this._playing.find('.owl-video-frame').remove();
		this._playing.removeClass('owl-video-playing');
		this._playing = null;
		this._core.leave('playing');
		this._core.trigger('stopped', null, 'video');
	***REMOVED***;

	/**
	 * Starts the current video.
	 * @public
	 * @param {Event***REMOVED*** event - The event arguments.
	 */
	Video.prototype.play = function(event) {
		var target = $(event.target),
			item = target.closest('.' + this._core.settings.itemClass),
			video = this._videos[item.attr('data-video')],
			width = video.width || '100%',
			height = video.height || this._core.$stage.height(),
			html;

		if (this._playing) {
			return;
		***REMOVED***

		this._core.enter('playing');
		this._core.trigger('play', null, 'video');

		item = this._core.items(this._core.relative(item.index()));

		this._core.reset(item.index());

		if (video.type === 'youtube') {
			html = '<iframe width="' + width + '" height="' + height + '" src="http://www.youtube.com/embed/' +
				video.id + '?autoplay=1&v=' + video.id + '" frameborder="0" allowfullscreen></iframe>';
		***REMOVED*** else if (video.type === 'vimeo') {
			html = '<iframe src="http://player.vimeo.com/video/' + video.id +
				'?autoplay=1" width="' + width + '" height="' + height +
				'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		***REMOVED***

		$('<div class="owl-video-frame">' + html + '</div>').insertAfter(item.find('.owl-video'));

		this._playing = item.addClass('owl-video-playing');
	***REMOVED***;

	/**
	 * Checks whether an video is currently in full screen mode or not.
	 * @todo Bad style because looks like a readonly method but changes members.
	 * @protected
	 * @returns {Boolean***REMOVED***
	 */
	Video.prototype.isInFullScreen = function() {
		var element = document.fullscreenElement || document.mozFullScreenElement ||
				document.webkitFullscreenElement;

		return element && $(element).parent().hasClass('owl-video-frame');
	***REMOVED***;

	/**
	 * Destroys the plugin.
	 */
	Video.prototype.destroy = function() {
		var handler, property;

		this._core.$element.off('click.owl.video');

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		***REMOVED***
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		***REMOVED***
	***REMOVED***;

	$.fn.owlCarousel.Constructor.Plugins.Video = Video;

***REMOVED***)(window.Zepto || window.jQuery, window, document);

/**
 * Animate Plugin
 * @version 2.0.0
 * @author Bartosz Wojciechowski
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the animate plugin.
	 * @class The Navigation Plugin
	 * @param {Owl***REMOVED*** scope - The Owl Carousel
	 */
	var Animate = function(scope) {
		this.core = scope;
		this.core.options = $.extend({***REMOVED***, Animate.Defaults, this.core.options);
		this.swapping = true;
		this.previous = undefined;
		this.next = undefined;

		this.handlers = {
			'change.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name == 'position') {
					this.previous = this.core.current();
					this.next = e.property.value;
				***REMOVED***
			***REMOVED***, this),
			'drag.owl.carousel dragged.owl.carousel translated.owl.carousel': $.proxy(function(e) {
				if (e.namespace) {
					this.swapping = e.type == 'translated';
				***REMOVED***
			***REMOVED***, this),
			'translate.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn)) {
					this.swap();
				***REMOVED***
			***REMOVED***, this)
		***REMOVED***;

		this.core.$element.on(this.handlers);
	***REMOVED***;

	/**
	 * Default options.
	 * @public
	 */
	Animate.Defaults = {
		animateOut: false,
		animateIn: false
	***REMOVED***;

	/**
	 * Toggles the animation classes whenever an translations starts.
	 * @protected
	 * @returns {Boolean|undefined***REMOVED***
	 */
	Animate.prototype.swap = function() {

		if (this.core.settings.items !== 1) {
			return;
		***REMOVED***

		if (!$.support.animation || !$.support.transition) {
			return;
		***REMOVED***

		this.core.speed(0);

		var left,
			clear = $.proxy(this.clear, this),
			previous = this.core.$stage.children().eq(this.previous),
			next = this.core.$stage.children().eq(this.next),
			incoming = this.core.settings.animateIn,
			outgoing = this.core.settings.animateOut;

		if (this.core.current() === this.previous) {
			return;
		***REMOVED***

		if (outgoing) {
			left = this.core.coordinates(this.previous) - this.core.coordinates(this.next);
			previous.one($.support.animation.end, clear)
				.css( { 'left': left + 'px' ***REMOVED*** )
				.addClass('animated owl-animated-out')
				.addClass(outgoing);
		***REMOVED***

		if (incoming) {
			next.one($.support.animation.end, clear)
				.addClass('animated owl-animated-in')
				.addClass(incoming);
		***REMOVED***
	***REMOVED***;

	Animate.prototype.clear = function(e) {
		$(e.target).css( { 'left': '' ***REMOVED*** )
			.removeClass('animated owl-animated-out owl-animated-in')
			.removeClass(this.core.settings.animateIn)
			.removeClass(this.core.settings.animateOut);
		this.core.onTransitionEnd();
	***REMOVED***;

	/**
	 * Destroys the plugin.
	 * @public
	 */
	Animate.prototype.destroy = function() {
		var handler, property;

		for (handler in this.handlers) {
			this.core.$element.off(handler, this.handlers[handler]);
		***REMOVED***
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		***REMOVED***
	***REMOVED***;

	$.fn.owlCarousel.Constructor.Plugins.Animate = Animate;

***REMOVED***)(window.Zepto || window.jQuery, window, document);

/**
 * Autoplay Plugin
 * @version 2.0.0
 * @author Bartosz Wojciechowski
 * @author Artus Kolanowski
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the autoplay plugin.
	 * @class The Autoplay Plugin
	 * @param {Owl***REMOVED*** scope - The Owl Carousel
	 */
	var Autoplay = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl***REMOVED***
		 */
		this._core = carousel;

		/**
		 * The autoplay interval.
		 * @type {Number***REMOVED***
		 */
		this._interval = null;

		/**
		 * Indicates whenever the autoplay is paused.
		 * @type {Boolean***REMOVED***
		 */
		this._paused = false;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._handlers = {
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name === 'settings') {
					if (this._core.settings.autoplay) {
						this.play();
					***REMOVED*** else {
						this.stop();
					***REMOVED***
				***REMOVED***
			***REMOVED***, this),
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoplay) {
					this.play();
				***REMOVED***
			***REMOVED***, this),
			'play.owl.autoplay': $.proxy(function(e, t, s) {
				if (e.namespace) {
					this.play(t, s);
				***REMOVED***
			***REMOVED***, this),
			'stop.owl.autoplay': $.proxy(function(e) {
				if (e.namespace) {
					this.stop();
				***REMOVED***
			***REMOVED***, this),
			'mouseover.owl.autoplay': $.proxy(function() {
				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {
					this.pause();
				***REMOVED***
			***REMOVED***, this),
			'mouseleave.owl.autoplay': $.proxy(function() {
				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {
					this.play();
				***REMOVED***
			***REMOVED***, this)
		***REMOVED***;

		// register event handlers
		this._core.$element.on(this._handlers);

		// set default options
		this._core.options = $.extend({***REMOVED***, Autoplay.Defaults, this._core.options);
	***REMOVED***;

	/**
	 * Default options.
	 * @public
	 */
	Autoplay.Defaults = {
		autoplay: false,
		autoplayTimeout: 5000,
		autoplayHoverPause: false,
		autoplaySpeed: false
	***REMOVED***;

	/**
	 * Starts the autoplay.
	 * @public
	 * @param {Number***REMOVED*** [timeout] - The interval before the next animation starts.
	 * @param {Number***REMOVED*** [speed] - The animation speed for the animations.
	 */
	Autoplay.prototype.play = function(timeout, speed) {
		this._paused = false;

		if (this._core.is('rotating')) {
			return;
		***REMOVED***

		this._core.enter('rotating');

		this._interval = window.setInterval($.proxy(function() {
			if (this._paused || this._core.is('busy') || this._core.is('interacting') || document.hidden) {
				return;
			***REMOVED***
			this._core.next(speed || this._core.settings.autoplaySpeed);
		***REMOVED***, this), timeout || this._core.settings.autoplayTimeout);
	***REMOVED***;

	/**
	 * Stops the autoplay.
	 * @public
	 */
	Autoplay.prototype.stop = function() {
		if (!this._core.is('rotating')) {
			return;
		***REMOVED***

		window.clearInterval(this._interval);
		this._core.leave('rotating');
	***REMOVED***;

	/**
	 * Stops the autoplay.
	 * @public
	 */
	Autoplay.prototype.pause = function() {
		if (!this._core.is('rotating')) {
			return;
		***REMOVED***

		this._paused = true;
	***REMOVED***;

	/**
	 * Destroys the plugin.
	 */
	Autoplay.prototype.destroy = function() {
		var handler, property;

		this.stop();

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		***REMOVED***
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		***REMOVED***
	***REMOVED***;

	$.fn.owlCarousel.Constructor.Plugins.autoplay = Autoplay;

***REMOVED***)(window.Zepto || window.jQuery, window, document);

/**
 * Navigation Plugin
 * @version 2.0.0
 * @author Artus Kolanowski
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {
	'use strict';

	/**
	 * Creates the navigation plugin.
	 * @class The Navigation Plugin
	 * @param {Owl***REMOVED*** carousel - The Owl Carousel.
	 */
	var Navigation = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl***REMOVED***
		 */
		this._core = carousel;

		/**
		 * Indicates whether the plugin is initialized or not.
		 * @protected
		 * @type {Boolean***REMOVED***
		 */
		this._initialized = false;

		/**
		 * The current paging indexes.
		 * @protected
		 * @type {Array***REMOVED***
		 */
		this._pages = [];

		/**
		 * All DOM elements of the user interface.
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._controls = {***REMOVED***;

		/**
		 * Markup for an indicator.
		 * @protected
		 * @type {Array.<String>***REMOVED***
		 */
		this._templates = [];

		/**
		 * The carousel element.
		 * @type {jQuery***REMOVED***
		 */
		this.$element = this._core.$element;

		/**
		 * Overridden methods of the carousel.
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._overrides = {
			next: this._core.next,
			prev: this._core.prev,
			to: this._core.to
		***REMOVED***;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._handlers = {
			'prepared.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.dotsData) {
					this._templates.push('<div class="' + this._core.settings.dotClass + '">' +
						$(e.content).find('[data-dot]').andSelf('[data-dot]').attr('data-dot') + '</div>');
				***REMOVED***
			***REMOVED***, this),
			'added.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.dotsData) {
					this._templates.splice(e.position, 0, this._templates.pop());
				***REMOVED***
			***REMOVED***, this),
			'remove.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.dotsData) {
					this._templates.splice(e.position, 1);
				***REMOVED***
			***REMOVED***, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name == 'position') {
					this.draw();
				***REMOVED***
			***REMOVED***, this),
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && !this._initialized) {
					this._core.trigger('initialize', null, 'navigation');
					this.initialize();
					this.update();
					this.draw();
					this._initialized = true;
					this._core.trigger('initialized', null, 'navigation');
				***REMOVED***
			***REMOVED***, this),
			'refreshed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._initialized) {
					this._core.trigger('refresh', null, 'navigation');
					this.update();
					this.draw();
					this._core.trigger('refreshed', null, 'navigation');
				***REMOVED***
			***REMOVED***, this)
		***REMOVED***;

		// set default options
		this._core.options = $.extend({***REMOVED***, Navigation.Defaults, this._core.options);

		// register event handlers
		this.$element.on(this._handlers);
	***REMOVED***;

	/**
	 * Default options.
	 * @public
	 * @todo Rename `slideBy` to `navBy`
	 */
	Navigation.Defaults = {
		nav: false,
		navText: [ 'prev', 'next' ],
		navSpeed: false,
		navElement: 'div',
		navContainer: false,
		navContainerClass: 'owl-nav',
		navClass: [ 'owl-prev', 'owl-next' ],
		slideBy: 1,
		dotClass: 'owl-dot',
		dotsClass: 'owl-dots',
		dots: true,
		dotsEach: false,
		dotsData: false,
		dotsSpeed: false,
		dotsContainer: false
	***REMOVED***;

	/**
	 * Initializes the layout of the plugin and extends the carousel.
	 * @protected
	 */
	Navigation.prototype.initialize = function() {
		var override,
			settings = this._core.settings;

		// create DOM structure for relative navigation
		this._controls.$relative = (settings.navContainer ? $(settings.navContainer)
			: $('<div>').addClass(settings.navContainerClass).appendTo(this.$element)).addClass('disabled');

		this._controls.$previous = $('<' + settings.navElement + '>')
			.addClass(settings.navClass[0])
			.html(settings.navText[0])
			.prependTo(this._controls.$relative)
			.on('click', $.proxy(function(e) {
				this.prev(settings.navSpeed);
			***REMOVED***, this));
		this._controls.$next = $('<' + settings.navElement + '>')
			.addClass(settings.navClass[1])
			.html(settings.navText[1])
			.appendTo(this._controls.$relative)
			.on('click', $.proxy(function(e) {
				this.next(settings.navSpeed);
			***REMOVED***, this));

		// create DOM structure for absolute navigation
		if (!settings.dotsData) {
			this._templates = [ $('<div>')
				.addClass(settings.dotClass)
				.append($('<span>'))
				.prop('outerHTML') ];
		***REMOVED***

		this._controls.$absolute = (settings.dotsContainer ? $(settings.dotsContainer)
			: $('<div>').addClass(settings.dotsClass).appendTo(this.$element)).addClass('disabled');

		this._controls.$absolute.on('click', 'div', $.proxy(function(e) {
			var index = $(e.target).parent().is(this._controls.$absolute)
				? $(e.target).index() : $(e.target).parent().index();

			e.preventDefault();

			this.to(index, settings.dotsSpeed);
		***REMOVED***, this));

		// override public methods of the carousel
		for (override in this._overrides) {
			this._core[override] = $.proxy(this[override], this);
		***REMOVED***
	***REMOVED***;

	/**
	 * Destroys the plugin.
	 * @protected
	 */
	Navigation.prototype.destroy = function() {
		var handler, control, property, override;

		for (handler in this._handlers) {
			this.$element.off(handler, this._handlers[handler]);
		***REMOVED***
		for (control in this._controls) {
			this._controls[control].remove();
		***REMOVED***
		for (override in this.overides) {
			this._core[override] = this._overrides[override];
		***REMOVED***
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		***REMOVED***
	***REMOVED***;

	/**
	 * Updates the internal state.
	 * @protected
	 */
	Navigation.prototype.update = function() {
		var i, j, k,
			lower = this._core.clones().length / 2,
			upper = lower + this._core.items().length,
			maximum = this._core.maximum(true),
			settings = this._core.settings,
			size = settings.center || settings.autoWidth || settings.dotsData
				? 1 : settings.dotsEach || settings.items;

		if (settings.slideBy !== 'page') {
			settings.slideBy = Math.min(settings.slideBy, settings.items);
		***REMOVED***

		if (settings.dots || settings.slideBy == 'page') {
			this._pages = [];

			for (i = lower, j = 0, k = 0; i < upper; i++) {
				if (j >= size || j === 0) {
					this._pages.push({
						start: Math.min(maximum, i - lower),
						end: i - lower + size - 1
					***REMOVED***);
					if (Math.min(maximum, i - lower) === maximum) {
						break;
					***REMOVED***
					j = 0, ++k;
				***REMOVED***
				j += this._core.mergers(this._core.relative(i));
			***REMOVED***
		***REMOVED***
	***REMOVED***;

	/**
	 * Draws the user interface.
	 * @todo The option `dotsData` wont work.
	 * @protected
	 */
	Navigation.prototype.draw = function() {
		var difference,
			settings = this._core.settings,
			disabled = this._core.items().length <= settings.items,
			index = this._core.relative(this._core.current()),
			loop = settings.loop || settings.rewind;

		this._controls.$relative.toggleClass('disabled', !settings.nav || disabled);

		if (settings.nav) {
			this._controls.$previous.toggleClass('disabled', !loop && index <= this._core.minimum(true));
			this._controls.$next.toggleClass('disabled', !loop && index >= this._core.maximum(true));
		***REMOVED***

		this._controls.$absolute.toggleClass('disabled', !settings.dots || disabled);

		if (settings.dots) {
			difference = this._pages.length - this._controls.$absolute.children().length;

			if (settings.dotsData && difference !== 0) {
				this._controls.$absolute.html(this._templates.join(''));
			***REMOVED*** else if (difference > 0) {
				this._controls.$absolute.append(new Array(difference + 1).join(this._templates[0]));
			***REMOVED*** else if (difference < 0) {
				this._controls.$absolute.children().slice(difference).remove();
			***REMOVED***

			this._controls.$absolute.find('.active').removeClass('active');
			this._controls.$absolute.children().eq($.inArray(this.current(), this._pages)).addClass('active');
		***REMOVED***
	***REMOVED***;

	/**
	 * Extends event data.
	 * @protected
	 * @param {Event***REMOVED*** event - The event object which gets thrown.
	 */
	Navigation.prototype.onTrigger = function(event) {
		var settings = this._core.settings;

		event.page = {
			index: $.inArray(this.current(), this._pages),
			count: this._pages.length,
			size: settings && (settings.center || settings.autoWidth || settings.dotsData
				? 1 : settings.dotsEach || settings.items)
		***REMOVED***;
	***REMOVED***;

	/**
	 * Gets the current page position of the carousel.
	 * @protected
	 * @returns {Number***REMOVED***
	 */
	Navigation.prototype.current = function() {
		var current = this._core.relative(this._core.current());
		return $.grep(this._pages, $.proxy(function(page, index) {
			return page.start <= current && page.end >= current;
		***REMOVED***, this)).pop();
	***REMOVED***;

	/**
	 * Gets the current succesor/predecessor position.
	 * @protected
	 * @returns {Number***REMOVED***
	 */
	Navigation.prototype.getPosition = function(successor) {
		var position, length,
			settings = this._core.settings;

		if (settings.slideBy == 'page') {
			position = $.inArray(this.current(), this._pages);
			length = this._pages.length;
			successor ? ++position : --position;
			position = this._pages[((position % length) + length) % length].start;
		***REMOVED*** else {
			position = this._core.relative(this._core.current());
			length = this._core.items().length;
			successor ? position += settings.slideBy : position -= settings.slideBy;
		***REMOVED***

		return position;
	***REMOVED***;

	/**
	 * Slides to the next item or page.
	 * @public
	 * @param {Number***REMOVED*** [speed=false] - The time in milliseconds for the transition.
	 */
	Navigation.prototype.next = function(speed) {
		$.proxy(this._overrides.to, this._core)(this.getPosition(true), speed);
	***REMOVED***;

	/**
	 * Slides to the previous item or page.
	 * @public
	 * @param {Number***REMOVED*** [speed=false] - The time in milliseconds for the transition.
	 */
	Navigation.prototype.prev = function(speed) {
		$.proxy(this._overrides.to, this._core)(this.getPosition(false), speed);
	***REMOVED***;

	/**
	 * Slides to the specified item or page.
	 * @public
	 * @param {Number***REMOVED*** position - The position of the item or page.
	 * @param {Number***REMOVED*** [speed] - The time in milliseconds for the transition.
	 * @param {Boolean***REMOVED*** [standard=false] - Whether to use the standard behaviour or not.
	 */
	Navigation.prototype.to = function(position, speed, standard) {
		var length;

		if (!standard) {
			length = this._pages.length;
			$.proxy(this._overrides.to, this._core)(this._pages[((position % length) + length) % length].start, speed);
		***REMOVED*** else {
			$.proxy(this._overrides.to, this._core)(position, speed);
		***REMOVED***
	***REMOVED***;

	$.fn.owlCarousel.Constructor.Plugins.Navigation = Navigation;

***REMOVED***)(window.Zepto || window.jQuery, window, document);

/**
 * Hash Plugin
 * @version 2.0.0
 * @author Artus Kolanowski
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {
	'use strict';

	/**
	 * Creates the hash plugin.
	 * @class The Hash Plugin
	 * @param {Owl***REMOVED*** carousel - The Owl Carousel
	 */
	var Hash = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl***REMOVED***
		 */
		this._core = carousel;

		/**
		 * Hash index for the items.
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._hashes = {***REMOVED***;

		/**
		 * The carousel element.
		 * @type {jQuery***REMOVED***
		 */
		this.$element = this._core.$element;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object***REMOVED***
		 */
		this._handlers = {
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.startPosition === 'URLHash') {
					$(window).trigger('hashchange.owl.navigation');
				***REMOVED***
			***REMOVED***, this),
			'prepared.owl.carousel': $.proxy(function(e) {
				if (e.namespace) {
					var hash = $(e.content).find('[data-hash]').andSelf('[data-hash]').attr('data-hash');

					if (!hash) {
						return;
					***REMOVED***

					this._hashes[hash] = e.content;
				***REMOVED***
			***REMOVED***, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name === 'position') {
					var current = this._core.items(this._core.relative(this._core.current())),
						hash = $.map(this._hashes, function(item, hash) {
							return item === current ? hash : null;
						***REMOVED***).join();

					if (!hash || window.location.hash.slice(1) === hash) {
						return;
					***REMOVED***

					window.location.hash = hash;
				***REMOVED***
			***REMOVED***, this)
		***REMOVED***;

		// set default options
		this._core.options = $.extend({***REMOVED***, Hash.Defaults, this._core.options);

		// register the event handlers
		this.$element.on(this._handlers);

		// register event listener for hash navigation
		$(window).on('hashchange.owl.navigation', $.proxy(function(e) {
			var hash = window.location.hash.substring(1),
				items = this._core.$stage.children(),
				position = this._hashes[hash] && items.index(this._hashes[hash]);

			if (position === undefined || position === this._core.current()) {
				return;
			***REMOVED***

			this._core.to(this._core.relative(position), false, true);
		***REMOVED***, this));
	***REMOVED***;

	/**
	 * Default options.
	 * @public
	 */
	Hash.Defaults = {
		URLhashListener: false
	***REMOVED***;

	/**
	 * Destroys the plugin.
	 * @public
	 */
	Hash.prototype.destroy = function() {
		var handler, property;

		$(window).off('hashchange.owl.navigation');

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		***REMOVED***
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		***REMOVED***
	***REMOVED***;

	$.fn.owlCarousel.Constructor.Plugins.Hash = Hash;

***REMOVED***)(window.Zepto || window.jQuery, window, document);

/**
 * Support Plugin
 *
 * @version 2.0.0
 * @author Vivid Planet Software GmbH
 * @author Artus Kolanowski
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	var style = $('<support>').get(0).style,
		prefixes = 'Webkit Moz O ms'.split(' '),
		events = {
			transition: {
				end: {
					WebkitTransition: 'webkitTransitionEnd',
					MozTransition: 'transitionend',
					OTransition: 'oTransitionEnd',
					transition: 'transitionend'
				***REMOVED***
			***REMOVED***,
			animation: {
				end: {
					WebkitAnimation: 'webkitAnimationEnd',
					MozAnimation: 'animationend',
					OAnimation: 'oAnimationEnd',
					animation: 'animationend'
				***REMOVED***
			***REMOVED***
		***REMOVED***,
		tests = {
			csstransforms: function() {
				return !!test('transform');
			***REMOVED***,
			csstransforms3d: function() {
				return !!test('perspective');
			***REMOVED***,
			csstransitions: function() {
				return !!test('transition');
			***REMOVED***,
			cssanimations: function() {
				return !!test('animation');
			***REMOVED***
		***REMOVED***;

	function test(property, prefixed) {
		var result = false,
			upper = property.charAt(0).toUpperCase() + property.slice(1);

		$.each((property + ' ' + prefixes.join(upper + ' ') + upper).split(' '), function(i, property) {
			if (style[property] !== undefined) {
				result = prefixed ? property : true;
				return false;
			***REMOVED***
		***REMOVED***);

		return result;
	***REMOVED***

	function prefixed(property) {
		return test(property, true);
	***REMOVED***

	if (tests.csstransitions()) {
		/* jshint -W053 */
		$.support.transition = new String(prefixed('transition'))
		$.support.transition.end = events.transition.end[ $.support.transition ];
	***REMOVED***

	if (tests.cssanimations()) {
		/* jshint -W053 */
		$.support.animation = new String(prefixed('animation'))
		$.support.animation.end = events.animation.end[ $.support.animation ];
	***REMOVED***

	if (tests.csstransforms()) {
		/* jshint -W053 */
		$.support.transform = new String(prefixed('transform'));
		$.support.transform3d = tests.csstransforms3d();
	***REMOVED***

***REMOVED***)(window.Zepto || window.jQuery, window, document);
