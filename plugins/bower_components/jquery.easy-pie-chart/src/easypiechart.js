var EasyPieChart = function(el, opts) {
	var defaultOptions = {
		barColor: '#ef1e25',
		trackColor: '#f9f9f9',
		scaleColor: '#dfe0e0',
		scaleLength: 5,
		lineCap: 'round',
		lineWidth: 3,
		trackWidth: undefined,
		size: 110,
		rotate: 0,
		animate: {
			duration: 1000,
			enabled: true
		***REMOVED***,
		easing: function (x, t, b, c, d) { // more can be found here: http://gsgd.co.uk/sandbox/jquery/easing/
			t = t / (d/2);
			if (t < 1) {
				return c / 2 * t * t + b;
			***REMOVED***
			return -c/2 * ((--t)*(t-2) - 1) + b;
		***REMOVED***,
		onStart: function(from, to) {
			return;
		***REMOVED***,
		onStep: function(from, to, currentValue) {
			return;
		***REMOVED***,
		onStop: function(from, to) {
			return;
		***REMOVED***
	***REMOVED***;

	// detect present renderer
	if (typeof(CanvasRenderer) !== 'undefined') {
		defaultOptions.renderer = CanvasRenderer;
	***REMOVED*** else if (typeof(SVGRenderer) !== 'undefined') {
		defaultOptions.renderer = SVGRenderer;
	***REMOVED*** else {
		throw new Error('Please load either the SVG- or the CanvasRenderer');
	***REMOVED***

	var options = {***REMOVED***;
	var currentValue = 0;

	/**
	 * Initialize the plugin by creating the options object and initialize rendering
	 */
	var init = function() {
		this.el = el;
		this.options = options;

		// merge user options into default options
		for (var i in defaultOptions) {
			if (defaultOptions.hasOwnProperty(i)) {
				options[i] = opts && typeof(opts[i]) !== 'undefined' ? opts[i] : defaultOptions[i];
				if (typeof(options[i]) === 'function') {
					options[i] = options[i].bind(this);
				***REMOVED***
			***REMOVED***
		***REMOVED***

		// check for jQuery easing
		if (typeof(options.easing) === 'string' && typeof(jQuery) !== 'undefined' && jQuery.isFunction(jQuery.easing[options.easing])) {
			options.easing = jQuery.easing[options.easing];
		***REMOVED*** else {
			options.easing = defaultOptions.easing;
		***REMOVED***

		// process earlier animate option to avoid bc breaks
		if (typeof(options.animate) === 'number') {
			options.animate = {
				duration: options.animate,
				enabled: true
			***REMOVED***;
		***REMOVED***

		if (typeof(options.animate) === 'boolean' && !options.animate) {
			options.animate = {
				duration: 1000,
				enabled: options.animate
			***REMOVED***;
		***REMOVED***

		// create renderer
		this.renderer = new options.renderer(el, options);

		// initial draw
		this.renderer.draw(currentValue);

		// initial update
		if (el.dataset && el.dataset.percent) {
			this.update(parseFloat(el.dataset.percent));
		***REMOVED*** else if (el.getAttribute && el.getAttribute('data-percent')) {
			this.update(parseFloat(el.getAttribute('data-percent')));
		***REMOVED***
	***REMOVED***.bind(this);

	/**
	 * Update the value of the chart
	 * @param  {number***REMOVED*** newValue Number between 0 and 100
	 * @return {object***REMOVED***          Instance of the plugin for method chaining
	 */
	this.update = function(newValue) {
		newValue = parseFloat(newValue);
		if (options.animate.enabled) {
			this.renderer.animate(currentValue, newValue);
		***REMOVED*** else {
			this.renderer.draw(newValue);
		***REMOVED***
		currentValue = newValue;
		return this;
	***REMOVED***.bind(this);

	/**
	 * Disable animation
	 * @return {object***REMOVED*** Instance of the plugin for method chaining
	 */
	this.disableAnimation = function() {
		options.animate.enabled = false;
		return this;
	***REMOVED***;

	/**
	 * Enable animation
	 * @return {object***REMOVED*** Instance of the plugin for method chaining
	 */
	this.enableAnimation = function() {
		options.animate.enabled = true;
		return this;
	***REMOVED***;

	init();
***REMOVED***;
