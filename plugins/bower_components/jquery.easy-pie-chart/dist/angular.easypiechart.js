/**!
 * easyPieChart
 * Lightweight plugin to render simple, animated and retina optimized pie charts
 *
 * @license 
 * @author Robert Fleischmann <rendro87@gmail.com> (http://robert-fleischmann.de)
 * @version 2.1.6
 **/

(function(root, factory) {
    if(typeof exports === 'object') {
        module.exports = factory(require('angular'));
    ***REMOVED***
    else if(typeof define === 'function' && define.amd) {
        define(['angular'], factory);
    ***REMOVED***
    else {
        factory(root.angular);
    ***REMOVED***
***REMOVED***(this, function(angular) {

(function (angular) {

	'use strict';

	return angular.module('easypiechart', [])

		.directive('easypiechart', [function() {
			return {
				restrict: 'A',
				require: '?ngModel',
				scope: {
					percent: '=',
					options: '='
				***REMOVED***,
				link: function (scope, element, attrs) {

					scope.percent = scope.percent || 0;

					/**
					 * default easy pie chart options
					 * @type {Object***REMOVED***
					 */
					var options = {
						barColor: '#ef1e25',
						trackColor: '#f9f9f9',
						scaleColor: '#dfe0e0',
						scaleLength: 5,
						lineCap: 'round',
						lineWidth: 3,
						size: 110,
						rotate: 0,
						animate: {
							duration: 1000,
							enabled: true
						***REMOVED***
					***REMOVED***;
					scope.options = angular.extend(options, scope.options);

					var pieChart = new EasyPieChart(element[0], options);

					scope.$watch('percent', function(newVal, oldVal) {
						pieChart.update(newVal);
					***REMOVED***);
				***REMOVED***
			***REMOVED***;
		***REMOVED***]);

***REMOVED***)(angular);
/**
 * Renderer to render the chart on a canvas object
 * @param {DOMElement***REMOVED*** el      DOM element to host the canvas (root of the plugin)
 * @param {object***REMOVED***     options options object of the plugin
 */
var CanvasRenderer = function(el, options) {
	var cachedBackground;
	var canvas = document.createElement('canvas');

	el.appendChild(canvas);

	if (typeof(G_vmlCanvasManager) !== 'undefined') {
		G_vmlCanvasManager.initElement(canvas);
	***REMOVED***

	var ctx = canvas.getContext('2d');

	canvas.width = canvas.height = options.size;

	// canvas on retina devices
	var scaleBy = 1;
	if (window.devicePixelRatio > 1) {
		scaleBy = window.devicePixelRatio;
		canvas.style.width = canvas.style.height = [options.size, 'px'].join('');
		canvas.width = canvas.height = options.size * scaleBy;
		ctx.scale(scaleBy, scaleBy);
	***REMOVED***

	// move 0,0 coordinates to the center
	ctx.translate(options.size / 2, options.size / 2);

	// rotate canvas -90deg
	ctx.rotate((-1 / 2 + options.rotate / 180) * Math.PI);

	var radius = (options.size - options.lineWidth) / 2;
	if (options.scaleColor && options.scaleLength) {
		radius -= options.scaleLength + 2; // 2 is the distance between scale and bar
	***REMOVED***

	// IE polyfill for Date
	Date.now = Date.now || function() {
		return +(new Date());
	***REMOVED***;

	/**
	 * Draw a circle around the center of the canvas
	 * @param {strong***REMOVED*** color     Valid CSS color string
	 * @param {number***REMOVED*** lineWidth Width of the line in px
	 * @param {number***REMOVED*** percent   Percentage to draw (float between -1 and 1)
	 */
	var drawCircle = function(color, lineWidth, percent) {
		percent = Math.min(Math.max(-1, percent || 0), 1);
		var isNegative = percent <= 0 ? true : false;

		ctx.beginPath();
		ctx.arc(0, 0, radius, 0, Math.PI * 2 * percent, isNegative);

		ctx.strokeStyle = color;
		ctx.lineWidth = lineWidth;

		ctx.stroke();
	***REMOVED***;

	/**
	 * Draw the scale of the chart
	 */
	var drawScale = function() {
		var offset;
		var length;

		ctx.lineWidth = 1;
		ctx.fillStyle = options.scaleColor;

		ctx.save();
		for (var i = 24; i > 0; --i) {
			if (i % 6 === 0) {
				length = options.scaleLength;
				offset = 0;
			***REMOVED*** else {
				length = options.scaleLength * 0.6;
				offset = options.scaleLength - length;
			***REMOVED***
			ctx.fillRect(-options.size/2 + offset, 0, length, 1);
			ctx.rotate(Math.PI / 12);
		***REMOVED***
		ctx.restore();
	***REMOVED***;

	/**
	 * Request animation frame wrapper with polyfill
	 * @return {function***REMOVED*** Request animation frame method or timeout fallback
	 */
	var reqAnimationFrame = (function() {
		return  window.requestAnimationFrame ||
				window.webkitRequestAnimationFrame ||
				window.mozRequestAnimationFrame ||
				function(callback) {
					window.setTimeout(callback, 1000 / 60);
				***REMOVED***;
	***REMOVED***());

	/**
	 * Draw the background of the plugin including the scale and the track
	 */
	var drawBackground = function() {
		if(options.scaleColor) drawScale();
		if(options.trackColor) drawCircle(options.trackColor, options.trackWidth || options.lineWidth, 1);
	***REMOVED***;

  /**
    * Canvas accessor
   */
  this.getCanvas = function() {
    return canvas;
  ***REMOVED***;

  /**
    * Canvas 2D context 'ctx' accessor
   */
  this.getCtx = function() {
    return ctx;
  ***REMOVED***;

	/**
	 * Clear the complete canvas
	 */
	this.clear = function() {
		ctx.clearRect(options.size / -2, options.size / -2, options.size, options.size);
	***REMOVED***;

	/**
	 * Draw the complete chart
	 * @param {number***REMOVED*** percent Percent shown by the chart between -100 and 100
	 */
	this.draw = function(percent) {
		// do we need to render a background
		if (!!options.scaleColor || !!options.trackColor) {
			// getImageData and putImageData are supported
			if (ctx.getImageData && ctx.putImageData) {
				if (!cachedBackground) {
					drawBackground();
					cachedBackground = ctx.getImageData(0, 0, options.size * scaleBy, options.size * scaleBy);
				***REMOVED*** else {
					ctx.putImageData(cachedBackground, 0, 0);
				***REMOVED***
			***REMOVED*** else {
				this.clear();
				drawBackground();
			***REMOVED***
		***REMOVED*** else {
			this.clear();
		***REMOVED***

		ctx.lineCap = options.lineCap;

		// if barcolor is a function execute it and pass the percent as a value
		var color;
		if (typeof(options.barColor) === 'function') {
			color = options.barColor(percent);
		***REMOVED*** else {
			color = options.barColor;
		***REMOVED***

		// draw bar
		drawCircle(color, options.lineWidth, percent / 100);
	***REMOVED***.bind(this);

	/**
	 * Animate from some percent to some other percentage
	 * @param {number***REMOVED*** from Starting percentage
	 * @param {number***REMOVED*** to   Final percentage
	 */
	this.animate = function(from, to) {
		var startTime = Date.now();
		options.onStart(from, to);
		var animation = function() {
			var process = Math.min(Date.now() - startTime, options.animate.duration);
			var currentValue = options.easing(this, process, from, to - from, options.animate.duration);
			this.draw(currentValue);
			options.onStep(from, to, currentValue);
			if (process >= options.animate.duration) {
				options.onStop(from, to);
			***REMOVED*** else {
				reqAnimationFrame(animation);
			***REMOVED***
		***REMOVED***.bind(this);

		reqAnimationFrame(animation);
	***REMOVED***.bind(this);
***REMOVED***;

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


***REMOVED***));
