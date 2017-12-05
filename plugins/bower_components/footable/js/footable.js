/*
* FooTable v3 - FooTable is a jQuery plugin that aims to make HTML tables on smaller devices look awesome.
* @version 3.1.5
* @link http://fooplugins.com
* @copyright Steven Usher & Brad Vincent 2015
* @license Released under the GPLv3 license.
*/
(function($, F){
	// add in console we use in case it's missing
	window.console = window.console || { log:function(){***REMOVED***, error:function(){***REMOVED*** ***REMOVED***;

	/**
	 * The jQuery plugin initializer.
	 * @function jQuery.fn.footable
	 * @param {(object|FooTable.Defaults)***REMOVED*** [options] - The options to initialize the plugin with.
	 * @param {function***REMOVED*** [ready] - A callback function to execute for each initialized plugin.
	 * @returns {jQuery***REMOVED***
	 */
	$.fn.footable = function (options, ready) {
		options = options || {***REMOVED***;
		// make sure we only work with tables
		return this.filter('table').each(function (i, tbl) {
			F.init(tbl, options, ready);
		***REMOVED***);
	***REMOVED***;

	var debug_defaults = {
		events: []
	***REMOVED***;
	F.__debug__ = JSON.parse(localStorage.getItem('footable_debug')) || false;
	F.__debug_options__ = JSON.parse(localStorage.getItem('footable_debug_options')) || debug_defaults;

	/**
	 * Gets or sets the internal debug variable which enables some additional logging to the console.
	 * When enabled this value is stored in the localStorage so it can persist across page reloads.
	 * @param {boolean***REMOVED*** value - Whether or not to enable additional logging.
	 * @param {object***REMOVED*** [options] - Any debug specific options.
	 * @returns {(boolean|undefined)***REMOVED***
	 */
	F.debug = function(value, options){
		if (!F.is.boolean(value)) return F.__debug__;
		F.__debug__ = value;
		if (F.__debug__){
			localStorage.setItem('footable_debug', JSON.stringify(F.__debug__));
			F.__debug_options__ = $.extend(true, {***REMOVED***, debug_defaults, options || {***REMOVED***);
			if (F.is.hash(options)){
				localStorage.setItem('footable_debug_options', JSON.stringify(F.__debug_options__));
			***REMOVED***
		***REMOVED*** else {
			localStorage.removeItem('footable_debug');
			localStorage.removeItem('footable_debug_options');
		***REMOVED***
	***REMOVED***;

	/**
	 * Gets the FooTable instance of the supplied table if one exists.
	 * @param {(jQuery|jQuery.selector|HTMLTableElement)***REMOVED*** table - The jQuery table object, selector or the HTMLTableElement to retrieve FooTable from.
	 * @returns {(FooTable.Table|undefined)***REMOVED***
	 */
	F.get = function(table){
		return $(table).first().data('__FooTable__');
	***REMOVED***;

	/**
	 * Initializes a new instance of FooTable on the supplied table.
	 * @param {(jQuery|jQuery.selector|HTMLTableElement)***REMOVED*** table - The jQuery table object, selector or the HTMLTableElement to initialize FooTable on.
	 * @param {object***REMOVED*** options - The options to initialize FooTable with.
	 * @param {function***REMOVED*** [ready] - A callback function to execute once the plugin is initialized.
	 * @returns {FooTable.Table***REMOVED***
	 */
	F.init = function(table, options, ready){
		var ft = F.get(table);
		if (ft instanceof F.Table) ft.destroy();
		return new F.Table(table, options, ready);
	***REMOVED***;

	/**
	 * Gets the FooTable.Row instance for the supplied element.
	 * @param {(jQuery|jQuery.selector|HTMLTableElement)***REMOVED*** element - A jQuery object, selector or the HTMLElement of an element to retrieve the FooTable.Row for.
	 * @returns {FooTable.Row***REMOVED***
	 */
	F.getRow = function(element){
		// to get the FooTable.Row object simply walk up the DOM, find the TR and grab the __FooTableRow__ data value
		var $row = $(element).closest('tr');
		// if this is a detail row get the previous row in the table to get the main TR element
		if ($row.hasClass('footable-detail-row')){
			$row = $row.prev();
		***REMOVED***
		// grab the row object
		return $row.data('__FooTableRow__');
	***REMOVED***;

	// The below are external type definitions mainly used as pointers to jQuery docs for important information
	/**
	 * jQuery is a fast, small, and feature-rich JavaScript library. It makes things like HTML document traversal and manipulation, event handling, animation, and Ajax much simpler with an easy-to-use API
	 * that works across a multitude of browsers. With a combination of versatility and extensibility, jQuery has changed the way that millions of people write JavaScript.
	 * @name jQuery
	 * @constructor
	 * @returns {jQuery***REMOVED***
	 * @see {@link http://api.jquery.com/***REMOVED***
	 */

	/**
	 * This object provides a subset of the methods of the Deferred object (then, done, fail, always, pipe, and state) to prevent users from changing the state of the Deferred.
	 * @typedef {object***REMOVED*** jQuery.Promise
	 * @see {@link http://api.jquery.com/Types/#Promise***REMOVED***
	 */

	/**
	 * As of jQuery 1.5, the Deferred object provides a way to register multiple callbacks into self-managed callback queues, invoke callback queues as appropriate,
	 * and relay the success or failure state of any synchronous or asynchronous function.
	 * @typedef {object***REMOVED*** jQuery.Deferred
	 * @see {@link http://api.jquery.com/Types/#Deferred***REMOVED***
	 */

	/**
	 * jQuery's event system normalizes the event object according to W3C standards. The event object is guaranteed to be passed to the event handler. Most properties from
	 * the original event are copied over and normalized to the new event object.
	 * @typedef {object***REMOVED*** jQuery.Event
	 * @see {@link http://api.jquery.com/category/events/event-object/***REMOVED***
	 */

	/**
	 * Provides a way to execute callback functions based on one or more objects, usually Deferred objects that represent asynchronous events.
	 * @memberof jQuery
	 * @function when
	 * @param {...jQuery.Deferred***REMOVED*** deferreds - Any number of deferred objects to wait for.
	 * @returns {jQuery.Promise***REMOVED***
	 * @see {@link http://api.jquery.com/jQuery.when/***REMOVED***
	 */

	/**
	 * The jQuery.fn namespace used to register plugins with jQuery.
	 * @memberof jQuery
	 * @namespace fn
	 * @see {@link http://learn.jquery.com/plugins/basic-plugin-creation/***REMOVED***
	 */
***REMOVED***)(
	jQuery,
	/**
	 * The core FooTable namespace containing all the plugin code.
	 * @namespace
	 */
	FooTable = window.FooTable || {***REMOVED***
);
(function(F){
	var returnTrue = function(){ return true; ***REMOVED***;

	/**
	 * This namespace contains commonly used array utility methods.
	 * @namespace {object***REMOVED*** FooTable.arr
	 */
	F.arr = {***REMOVED***;

	/**
	 * Iterates over each item in the supplied array and performs the supplied function passing in the current item as the first argument.
	 * @memberof FooTable.arr
	 * @function each
	 * @param {Array***REMOVED*** array - The array to iterate
	 * @param {function***REMOVED*** func - The function to execute for each item. The first argument supplied to this function is the current item and the second is the current index.
	 */
	F.arr.each = function (array, func) {
		if (!F.is.array(array) || !F.is.fn(func)) return;
		for (var i = 0, len = array.length; i < len; i++) {
			if (func(array[i], i) === false) break;
		***REMOVED***
	***REMOVED***;

	/**
	 * Get all items in the supplied array that optionally matches the supplied where function. If no items are found an empty array is returned.
	 * @memberof FooTable.arr
	 * @function get
	 * @param {Array***REMOVED*** array - The array to get items from.
	 * @param {function***REMOVED*** where - This function must return a boolean value, true includes the item in the result array.
	 * @returns {Array***REMOVED***
	 */
	F.arr.get = function (array, where) {
		var result = [];
		if (!F.is.array(array)) return result;
		if (!F.is.fn(where)) return array;
		for (var i = 0, len = array.length; i < len; i++) {
			if (where(array[i], i)) result.push(array[i]);
		***REMOVED***
		return result;
	***REMOVED***;

	/**
	 * Get a boolean value indicating if any item exists in the supplied array that optionally matches the supplied where function.
	 * @memberof FooTable.arr
	 * @function any
	 * @param {Array***REMOVED*** array - The array to check.
	 * @param {function***REMOVED*** [where] - [Optional] This function must return a boolean value, true indicates that the current item is a valid match.
	 * @returns {boolean***REMOVED***
	 */
	F.arr.any = function (array, where) {
		if (!F.is.array(array)) return false;
		where = F.is.fn(where) ? where : returnTrue;
		for (var i = 0, len = array.length; i < len; i++) {
			if (where(array[i], i)) return true;
		***REMOVED***
		return false;
	***REMOVED***;

	/**
	 * Checks if the supplied value exists in the array.
	 * @memberof FooTable.arr
	 * @function contains
	 * @param {Array***REMOVED*** array - The array to check.
	 * @param {****REMOVED*** value - The value to check for.
	 * @returns {boolean***REMOVED***
	 */
	F.arr.contains = function(array, value){
		if (!F.is.array(array) || F.is.undef(value)) return false;
		for (var i = 0, len = array.length; i < len; i++) {
			if (array[i] == value) return true;
		***REMOVED***
		return false;
	***REMOVED***;

	/**
	 * Get the first item in the supplied array that optionally matches the supplied where function. If no item is found null is returned.
	 * @memberof FooTable.arr
	 * @function first
	 * @param {Array***REMOVED*** array - The array to get the item from.
	 * @param {function***REMOVED*** [where] - [Optional] This function must return a boolean value, true indicates that the current item can be returned.
	 * @returns {(*|null)***REMOVED***
	 */
	F.arr.first = function (array, where) {
		if (!F.is.array(array)) return null;
		where = F.is.fn(where) ? where : returnTrue;
		for (var i = 0, len = array.length; i < len; i++) {
			if (where(array[i], i)) return array[i];
		***REMOVED***
		return null;
	***REMOVED***;

	/**
	 * Creates a new array from the results of the supplied getter function. If no items are found an empty array is returned, to exclude an item from the results return null.
	 * @memberof FooTable.arr
	 * @function map
	 * @param {Array***REMOVED*** array - The array to iterate.
	 * @param {function***REMOVED*** getter - This function must return either a new value or null.
	 * The first argument is the result being returned at this point in the iteration. The second argument is the current item being iterated.
	 * @returns {(*|null)***REMOVED***
	 */
	F.arr.map = function (array, getter) {
		var result = [], returned = null;
		if (!F.is.array(array) || !F.is.fn(getter)) return result;
		for (var i = 0, len = array.length; i < len; i++) {
			if ((returned = getter(array[i], i)) != null) result.push(returned);
		***REMOVED***
		return result;
	***REMOVED***;

	/**
	 * Removes items from the array matching the supplied where function. All removed items are returned in a new array.
	 * @memberof FooTable.arr
	 * @function remove
	 * @param {Array***REMOVED*** array - The array to iterate and remove items from.
	 * @param {function***REMOVED*** where - This function must return a boolean value, true includes the item in the result array.
	 * @returns {****REMOVED***
	 */
	F.arr.remove = function (array, where) {
		var remove = [], removed = [];
		if (!F.is.array(array) || !F.is.fn(where)) return removed;
		var i = 0, len = array.length;
		for (; i < len; i++) {
			if (where(array[i], i, removed)){
				remove.push(i);
				removed.push(array[i]);
			***REMOVED***
		***REMOVED***
		// sort the indexes to be removed from largest to smallest
		remove.sort(function(a, b){ return b - a; ***REMOVED***);
		i = 0; len = remove.length;
		for(; i < len; i++){
			var index = remove[i] - i;
			array.splice(index, 1);
		***REMOVED***
		return removed;
	***REMOVED***;

	/**
	 * Deletes a single item from the array. The item if removed is returned.
	 * @memberof FooTable.arr
	 * @function delete
	 * @param {Array***REMOVED*** array - The array to iterate and delete the item from.
	 * @param {****REMOVED*** item - The item to find and delete.
	 * @returns {(*|null)***REMOVED***
	 */
	F.arr.delete = function(array, item){
		var remove = -1, removed = null;
		if (!F.is.array(array) || F.is.undef(item)) return removed;
		var i = 0, len = array.length;
		for (; i < len; i++) {
			if (array[i] == item){
				remove = i;
				removed = array[i];
				break;
			***REMOVED***
		***REMOVED***
		if (remove != -1) array.splice(remove, 1);
		return removed;
	***REMOVED***;

	/**
	 * Replaces a single item in the array with a new one.
	 * @memberof FooTable.arr
	 * @function replace
	 * @param {Array***REMOVED*** array - The array to iterate and replace the item in.
	 * @param {****REMOVED*** oldItem - The item to be replaced.
	 * @param {****REMOVED*** newItem - The item to be inserted.
	 */
	F.arr.replace = function(array, oldItem, newItem){
		var index = array.indexOf(oldItem);
		if (index !== -1) array[index] = newItem;
	***REMOVED***;

***REMOVED***)(FooTable);
(function (F) {

	/**
	 * This namespace contains commonly used 'is' type methods that return boolean values.
	 * @namespace FooTable.is
	 */
	F.is = {***REMOVED***;

	/**
	 * Checks if the type of the value is the same as that supplied.
	 * @memberof FooTable.is
	 * @function type
	 * @param {****REMOVED*** value - The value to check the type of.
	 * @param {string***REMOVED*** type - The type to check for.
	 * @returns {boolean***REMOVED***
	 */
	F.is.type = function (value, type) {
		return typeof value === type;
	***REMOVED***;

	/**
	 * Checks if the value is defined.
	 * @memberof FooTable.is
	 * @function defined
	 * @param {****REMOVED*** value - The value to check is defined.
	 * @returns {boolean***REMOVED***
	 */
	F.is.defined = function (value) {
		return typeof value !== 'undefined';
	***REMOVED***;

	/**
	 * Checks if the value is undefined.
	 * @memberof FooTable.is
	 * @function undef
	 * @param {****REMOVED*** value - The value to check is undefined.
	 * @returns {boolean***REMOVED***
	 */
	F.is.undef = function (value) {
		return typeof value === 'undefined';
	***REMOVED***;

	/**
	 * Checks if the value is an array.
	 * @memberof FooTable.is
	 * @function array
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.array = function (value) {
		return '[object Array]' === Object.prototype.toString.call(value);
	***REMOVED***;

	/**
	 * Checks if the value is a date.
	 * @memberof FooTable.is
	 * @function date
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.date = function (value) {
		return '[object Date]' === Object.prototype.toString.call(value) && !isNaN(value.getTime());
	***REMOVED***;

	/**
	 * Checks if the value is a boolean.
	 * @memberof FooTable.is
	 * @function boolean
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.boolean = function (value) {
		return '[object Boolean]' === Object.prototype.toString.call(value);
	***REMOVED***;

	/**
	 * Checks if the value is a string.
	 * @memberof FooTable.is
	 * @function string
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.string = function (value) {
		return '[object String]' === Object.prototype.toString.call(value);
	***REMOVED***;

	/**
	 * Checks if the value is a number.
	 * @memberof FooTable.is
	 * @function number
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.number = function (value) {
		return '[object Number]' === Object.prototype.toString.call(value) && !isNaN(value);
	***REMOVED***;

	/**
	 * Checks if the value is a function.
	 * @memberof FooTable.is
	 * @function fn
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.fn = function (value) {
		return (F.is.defined(window) && value === window.alert) || '[object Function]' === Object.prototype.toString.call(value);
	***REMOVED***;

	/**
	 * Checks if the value is an error.
	 * @memberof FooTable.is
	 * @function error
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.error = function (value) {
		return '[object Error]' === Object.prototype.toString.call(value);
	***REMOVED***;

	/**
	 * Checks if the value is an object.
	 * @memberof FooTable.is
	 * @function object
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.object = function (value) {
		return '[object Object]' === Object.prototype.toString.call(value);
	***REMOVED***;

	/**
	 * Checks if the value is a hash.
	 * @memberof FooTable.is
	 * @function hash
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.hash = function (value) {
		return F.is.object(value) && value.constructor === Object && !value.nodeType && !value.setInterval;
	***REMOVED***;

	/**
	 * Checks if the supplied object is an HTMLElement
	 * @memberof FooTable.is
	 * @function element
	 * @param {object***REMOVED*** obj - The object to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.element = function (obj) {
		return typeof HTMLElement === 'object'
			? obj instanceof HTMLElement
			: obj && typeof obj === 'object' && obj !== null && obj.nodeType === 1 && typeof obj.nodeName === 'string';
	***REMOVED***;

	/**
	 * This is a simple check to determine if an object is a jQuery promise object. It simply checks the object has a "then" and "promise" function defined.
	 * The promise object is created as an object literal inside of jQuery.Deferred.
	 * It has no prototype, nor any other truly unique properties that could be used to distinguish it.
	 * This method should be a little more accurate than the internal jQuery one that simply checks for a "promise" method.
	 * @memberof FooTable.is
	 * @function promise
	 * @param {object***REMOVED*** obj - The object to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.promise = function(obj){
		return F.is.object(obj) && F.is.fn(obj.then) && F.is.fn(obj.promise);
	***REMOVED***;

	/**
	 * Checks if the supplied object is an instance of a jQuery object.
	 * @memberof FooTable.is
	 * @function jq
	 * @param {object***REMOVED*** obj - The object to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.jq = function(obj){
		return F.is.defined(window.jQuery) && obj instanceof jQuery && obj.length > 0;
	***REMOVED***;

	/**
	 * Checks if the supplied object is a moment.js date object.
	 * @memberof FooTable.is
	 * @function moment
	 * @param {object***REMOVED*** obj - The object to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.moment = function(obj){
		return F.is.defined(window.moment) && F.is.object(obj) && F.is.boolean(obj._isAMomentObject)
	***REMOVED***;

	/**
	 * Checks if the supplied value is an object and if it is empty.
	 * @memberof FooTable.is
	 * @function emptyObject
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.emptyObject = function(value){
		if (!F.is.hash(value)) return false;
		for(var prop in value) {
			if(value.hasOwnProperty(prop))
				return false;
		***REMOVED***
		return true;
	***REMOVED***;

	/**
	 * Checks if the supplied value is an array and if it is empty.
	 * @memberof FooTable.is
	 * @function emptyArray
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.emptyArray = function(value){
		return F.is.array(value) ? value.length === 0 : true;
	***REMOVED***;

	/**
	 * Checks if the supplied value is a string and if it is empty.
	 * @memberof FooTable.is
	 * @function emptyString
	 * @param {****REMOVED*** value - The value to check.
	 * @returns {boolean***REMOVED***
	 */
	F.is.emptyString = function(value){
		return F.is.string(value) ? value.length === 0 : true;
	***REMOVED***;

***REMOVED***)(FooTable);
(function (F) {
	/**
	 * This namespace contains commonly used string utility methods.
	 * @namespace FooTable.str
	 */
	F.str = {***REMOVED***;

	/**
	 * Checks if the supplied string contains the given substring.
	 * @memberof FooTable.str
	 * @function contains
	 * @param {string***REMOVED*** str - The string to check.
	 * @param {string***REMOVED*** contains - The string to check for.
	 * @param {boolean***REMOVED*** [ignoreCase=false] - Whether or not to ignore casing when performing the check.
	 * @returns {boolean***REMOVED***
	 */
	F.str.contains = function (str, contains, ignoreCase) {
		if (F.is.emptyString(str) || F.is.emptyString(contains)) return false;
		return contains.length <= str.length
			&& (ignoreCase ? str.toUpperCase().indexOf(contains.toUpperCase()) : str.indexOf(contains)) !== -1;
	***REMOVED***;

	/**
	 * Checks if the supplied string contains the exact given substring.
	 * @memberof FooTable.str
	 * @function contains
	 * @param {string***REMOVED*** str - The string to check.
	 * @param {string***REMOVED*** contains - The string to check for.
	 * @param {boolean***REMOVED*** [ignoreCase=false] - Whether or not to ignore casing when performing the check.
	 * @returns {boolean***REMOVED***
	 */
	F.str.containsExact = function (str, contains, ignoreCase) {
		if (F.is.emptyString(str) || F.is.emptyString(contains) || contains.length > str.length) return false;
		return new RegExp('\\b'+ F.str.escapeRegExp(contains)+'\\b', ignoreCase ? 'i' : '').test(str);
	***REMOVED***;

	/**
	 * Checks if the supplied string contains the given word.
	 * @memberof FooTable.str
	 * @function containsWord
	 * @param {string***REMOVED*** str - The string to check.
	 * @param {string***REMOVED*** word - The word to check for.
	 * @param {boolean***REMOVED*** [ignoreCase=false] - Whether or not to ignore casing when performing the check.
	 * @returns {boolean***REMOVED***
	 */
	F.str.containsWord = function(str, word, ignoreCase){
		if (F.is.emptyString(str) || F.is.emptyString(word) || str.length < word.length)
			return false;
		var parts = str.split(/\W/);
		for (var i = 0, len = parts.length; i < len; i++){
			if (ignoreCase ? parts[i].toUpperCase() == word.toUpperCase() : parts[i] == word) return true;
		***REMOVED***
		return false;
	***REMOVED***;

	/**
	 * Returns the remainder of a string split on the first index of the given substring.
	 * @memberof FooTable.str
	 * @function from
	 * @param {string***REMOVED*** str - The string to split.
	 * @param {string***REMOVED*** from - The substring to split on.
	 * @returns {string***REMOVED***
	 */
	F.str.from = function (str, from) {
		if (F.is.emptyString(str)) return str;
		return F.str.contains(str, from) ? str.substring(str.indexOf(from) + 1) : str;
	***REMOVED***;

	/**
	 * Checks if a string starts with the supplied prefix.
	 * @memberof FooTable.str
	 * @function startsWith
	 * @param {string***REMOVED*** str - The string to check.
	 * @param {string***REMOVED*** prefix - The prefix to check for.
	 * @returns {boolean***REMOVED***
	 */
	F.str.startsWith = function (str, prefix) {
		if (F.is.emptyString(str)) return str == prefix;
		return str.slice(0, prefix.length) == prefix;
	***REMOVED***;

	/**
	 * Takes the supplied string and converts it to camel case.
	 * @memberof FooTable.str
	 * @function toCamelCase
	 * @param {string***REMOVED*** str - The string to camel case.
	 * @returns {string***REMOVED***
	 */
	F.str.toCamelCase = function (str) {
		if (F.is.emptyString(str)) return str;
		if (str.toUpperCase() === str) return str.toLowerCase();
		return str.replace(/^([A-Z])|[-\s_](\w)/g, function (match, p1, p2) {
			if (F.is.string(p2)) return p2.toUpperCase();
			return p1.toLowerCase();
		***REMOVED***);
	***REMOVED***;

	/**
	 * Generates a random string 9 characters long using the optional prefix if supplied.
	 * @memberof FooTable.str
	 * @function random
	 * @param {string***REMOVED*** [prefix] - The prefix to append to the 9 random characters.
	 * @returns {string***REMOVED***
	 */
	F.str.random = function(prefix){
		prefix = F.is.emptyString(prefix) ? '' : prefix;
		return prefix + Math.random().toString(36).substr(2, 9);
	***REMOVED***;

	/**
	 * Escapes a string for use in a regular expression.
	 * @memberof FooTable.str
	 * @function escapeRegExp
	 * @param {string***REMOVED*** str - The string to escape.
	 * @returns {string***REMOVED***
	 */
	F.str.escapeRegExp = function(str){
		if (F.is.emptyString(str)) return str;
		return str.replace(/[.*+?^${***REMOVED***()|[\]\\]/g, "\\$&");
	***REMOVED***;

***REMOVED***)(FooTable);
(function (F) {
	"use strict";

	if (!Object.create) {
		Object.create = (function () {
			var Object = function () {***REMOVED***;
			return function (prototype) {
				if (arguments.length > 1)
					throw Error('Second argument not supported');

				if (!F.is.object(prototype))
					throw TypeError('Argument must be an object');

				Object.prototype = prototype;
				var result = new Object();
				Object.prototype = null;
				return result;
			***REMOVED***;
		***REMOVED***)();
	***REMOVED***

	/**
	 * This base implementation does nothing except provide access to the {@link FooTable.Class#extend***REMOVED*** method.
	 * @constructs FooTable.Class
	 * @classdesc This class is based off of John Resig's [Simple JavaScript Inheritance]{@link http://ejohn.org/blog/simple-javascript-inheritance***REMOVED*** but it has been updated to be ES 5.1
	 * compatible by implementing an [Object.create polyfill]{@link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/create#Polyfill***REMOVED***
	 * for older browsers.
	 * @see {@link http://ejohn.org/blog/simple-javascript-inheritance***REMOVED***
	 * @see {@link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/create#Polyfill***REMOVED***
	 * @returns {FooTable.Class***REMOVED***
	 */
	function Class() {***REMOVED***

	var __extendable__ = /xyz/.test(function () {xyz;***REMOVED***) ? /\b_super\b/ : /.*/;

	// this._super() within the context of the new function is a pointer to the original function
	// except if the hook param is specified then the this._super variable is the result of the original function
	Class.__extend__ = function(proto, name, func, original){
		// to all who venture here, here be dragons!
		proto[name] = F.is.fn(original) && __extendable__.test(func) ?
			(function (name, fn) {
				return function () {
					var tmp, ret;
					tmp = this._super;
					this._super = original;
					ret = fn.apply(this, arguments);
					this._super = tmp;
					return ret;
				***REMOVED***;
			***REMOVED***)(name, func) : func;
	***REMOVED***;

	/**
	 * Creates a new class that inherits from this class which in turn allows itself to be extended or if a name and function is supplied extends only that specific function on the class.
	 * @param {(object|string)***REMOVED*** arg1 - An object containing any new methods/members to implement or the name of the method to extend.
	 * @param {function***REMOVED*** arg2 - If the first argument is a method name then this is the new function to replace it with.
	 * @returns {FooTable.Class***REMOVED*** A new class that inherits from the base class.
	 * @example <caption>The below shows an example of how to implement inheritance using this method.</caption>
	 * var Person = FooTable.Class.extend({
	 *   construct: function(isDancing){
	 *     this.dancing = isDancing;
	 *   ***REMOVED***,
	 *   dance: function(){
	 *     return this.dancing;
	 *   ***REMOVED***
	 * ***REMOVED***);
	 *
	 * var Ninja = Person.extend({
	 *   construct: function(){
	 *     this._super( false );
	 *   ***REMOVED***,
	 *   dance: function(){
	 *     // Call the inherited version of dance()
	 *     return this._super();
	 *   ***REMOVED***,
	 *   swingSword: function(){
	 *     return true;
	 *   ***REMOVED***
	 * ***REMOVED***);
	 *
	 * var p = new Person(true);
	 * p.dance(); // => true
	 *
	 * var n = new Ninja();
	 * n.dance(); // => false
	 * n.swingSword(); // => true
	 *
	 * // Should all be true
	 * p instanceof Person && p instanceof FooTable.Class &&
	 * n instanceof Ninja && n instanceof Person && n instanceof FooTable.Class
	 */
	Class.extend = function (arg1 , arg2) {
		var args = Array.prototype.slice.call(arguments);
		arg1 = args.shift();
		arg2 = args.shift();

		function __extend__(proto, name, func, original){
			// to all who venture here, here be dragons!
			proto[name] = F.is.fn(original) && __extendable__.test(func) ?
				(function (name, fn, ofn) {
					return function () {
						var tmp, ret;
						tmp = this._super;
						this._super = ofn;
						ret = fn.apply(this, arguments);
						this._super = tmp;
						return ret;
					***REMOVED***;
				***REMOVED***)(name, func, original) : func;
		***REMOVED***

		if (F.is.hash(arg1)){
			var proto = Object.create(this.prototype),
				_super = this.prototype;
			for (var name in arg1) {
				if (name === '__ctor__') continue;
				__extend__(proto, name, arg1[name], _super[name]);
			***REMOVED***
			var obj = F.is.fn(proto.__ctor__) ? proto.__ctor__ : function () {
				if (!F.is.fn(this.construct))
					throw new SyntaxError('FooTable class objects must be constructed with the "new" keyword.');
				this.construct.apply(this, arguments);
			***REMOVED***;
			proto.construct = F.is.fn(proto.construct) ? proto.construct : function(){***REMOVED***;
			obj.prototype = proto;
			proto.constructor = obj;
			obj.extend = Class.extend;
			return obj;
		***REMOVED*** else if (F.is.string(arg1) && F.is.fn(arg2)) {
			__extend__(this.prototype, arg1, arg2, this.prototype[arg1]);
		***REMOVED***
	***REMOVED***;

	F.Class = Class;

	F.ClassFactory = F.Class.extend(/** @lends FooTable.ClassFactory */{
		/**
		 * This is a simple factory for {@link FooTable.Class***REMOVED*** objects allowing them to be registered using a friendly name
		 * and then new instances can be created using this friendly name.
		 * @constructs
		 * @extends FooTable.Class
		 * @returns {FooTable.ClassFactory***REMOVED***
		 * @this FooTable.ClassFactory
		 */
		construct: function(){
			/**
			 * An object containing all registered classes.
			 * @type {{***REMOVED******REMOVED***
			 */
			this.registered = {***REMOVED***;
		***REMOVED***,
		/**
		 * Checks if the factory contains a class registered using the supplied name.
		 * @instance
		 * @param {string***REMOVED*** name - The name of the class to check.
		 * @returns {boolean***REMOVED***
		 * @this FooTable.ClassFactory
		 */
		contains: function(name){
			return F.is.defined(this.registered[name]);
		***REMOVED***,
		/**
		 * Gets an array of all registered names.
		 * @instance
		 * @returns {Array.<string>***REMOVED***
		 * @this FooTable.ClassFactory
		 */
		names: function(){
			var names = [], name;
			for (name in this.registered){
				if (!this.registered.hasOwnProperty(name)) continue;
				names.push(name);
			***REMOVED***
			return names;
		***REMOVED***,
		/**
		 * Registers a class object using the supplied friendly name and priority. The priority is only taken into account when loading all registered classes
		 * using the {@link FooTable.ClassFactory#load***REMOVED*** method.
		 * @instance
		 * @param {string***REMOVED*** name - The friendly name of the class.
		 * @param {function***REMOVED*** klass - The class to register.
		 * @param {number***REMOVED*** priority - This determines the order that the class is created when using the {@link FooTable.ClassFactory#load***REMOVED*** method, higher values are loaded first.
		 * @this FooTable.ClassFactory
		 */
		register: function(name, klass, priority){
			if (!F.is.string(name) || !F.is.fn(klass)) return;
			var current = this.registered[name];
			this.registered[name] = {
				name: name,
				klass: klass,
				priority: F.is.number(priority) ? priority : (F.is.defined(current) ? current.priority : 0)
			***REMOVED***;
		***REMOVED***,
		/**
		 * Creates new instances of all registered classes using there priority and the supplied arguments to return them in an array.
		 * @instance
		 * @param {object***REMOVED*** subs - An object containing classes to substitute on load.
		 * @param {****REMOVED*** arg1 - The first argument to supply when creating new instances of all registered classes.
		 * @param {****REMOVED*** [argN...] - Any number of additional arguments to supply when creating new instances of all registered classes.
		 * @returns {Array.<FooTable.Class>***REMOVED***
		 * @this FooTable.ClassFactory
		 */
		load: function(subs, arg1, argN){
			var self = this, args = Array.prototype.slice.call(arguments), reg = [], loaded = [], name, klass;
			subs = args.shift() || {***REMOVED***;
			for (name in self.registered){
				if (!self.registered.hasOwnProperty(name)) continue;
				var component = self.registered[name];
				if (subs.hasOwnProperty(name)){
					klass = subs[name];
					if (F.is.string(klass)) klass = F.getFnPointer(subs[name]);
					if (F.is.fn(klass)){
						component = {name: name, klass: klass, priority: self.registered[name].priority***REMOVED***;
					***REMOVED***
				***REMOVED***
				reg.push(component);
			***REMOVED***
			for (name in subs){
				if (!subs.hasOwnProperty(name) || self.registered.hasOwnProperty(name)) continue;
				klass = subs[name];
				if (F.is.string(klass)) klass = F.getFnPointer(subs[name]);
				if (F.is.fn(klass)){
					reg.push({name: name, klass: klass, priority: 0***REMOVED***);
				***REMOVED***
			***REMOVED***
			reg.sort(function(a, b){ return b.priority - a.priority; ***REMOVED***);
			F.arr.each(reg, function(r){
				if (F.is.fn(r.klass)){
					loaded.push(self._make(r.klass, args));
				***REMOVED***
			***REMOVED***);
			return loaded;
		***REMOVED***,
		/**
		 * Create a new instance of a single class using the supplied name and arguments.
		 * @instance
		 * @param {string***REMOVED*** name - The name of the class to create.
		 * @param {****REMOVED*** arg1 - The first argument to supply to the new instance.
		 * @param {****REMOVED*** [argN...] - Any number of additional arguments to supply to the new instance.
		 * @returns {FooTable.Class***REMOVED***
		 * @this FooTable.ClassFactory
		 */
		make: function(name, arg1, argN){
			var self = this, args = Array.prototype.slice.call(arguments), reg;
			name = args.shift();
			reg = self.registered[name];
			if (F.is.fn(reg.klass)){
				return self._make(reg.klass, args);
			***REMOVED***
			return null;
		***REMOVED***,
		/**
		 * This in effect lets us use the "apply" method on a function using the "new" keyword.
		 * @instance
		 * @private
		 * @param {function***REMOVED*** klass
		 * @param args
		 * @returns {FooTable.Class***REMOVED***
		 * @this FooTable.ClassFactory
		 */
		_make: function(klass, args){
			function Class() {
				return klass.apply(this, args);
			***REMOVED***
			Class.prototype = klass.prototype;
			return new Class();
		***REMOVED***
	***REMOVED***);

***REMOVED***)(FooTable);
(function($, F){

	/**
	 * Converts the supplied cssText string into JSON object.
	 * @param {string***REMOVED*** cssText - The cssText to convert to a JSON object.
	 * @returns {object***REMOVED***
	 */
	F.css2json = function(cssText){
		if (F.is.emptyString(cssText)) return {***REMOVED***;
		var json = {***REMOVED***, props = cssText.split(';'), pair, key, value;
		for (var i = 0, i_len = props.length; i < i_len; i++){
			if (F.is.emptyString(props[i])) continue;
			pair = props[i].split(':');
			if (F.is.emptyString(pair[0]) || F.is.emptyString(pair[1])) continue;
			key = F.str.toCamelCase($.trim(pair[0]));
			value = $.trim(pair[1]);
			json[key] = value;
		***REMOVED***
		return json;
	***REMOVED***;

	/**
	 * Attempts to retrieve a function pointer using the given name.
	 * @param {string***REMOVED*** functionName - The name of the function to fetch a pointer to.
	 * @returns {(function|object|null)***REMOVED***
	 */
	F.getFnPointer = function(functionName){
		if (F.is.emptyString(functionName)) return null;
		var pointer = window,
			parts = functionName.split('.');
		F.arr.each(parts, function(part){
			if (pointer[part]) pointer = pointer[part];
		***REMOVED***);
		return F.is.fn(pointer) ? pointer : null;
	***REMOVED***;

	/**
	 * Checks the value for function properties such as the {@link FooTable.Column#formatter***REMOVED*** option which could also be specified using just the name
	 * and attempts to return the correct function pointer or null if none was found matching the value.
	 * @param {FooTable.Class***REMOVED*** self - The class to use as the 'this' keyword within the context of the function.
	 * @param {(function|string)***REMOVED*** value - The actual function or the name of the function for the property.
	 * @param {function***REMOVED*** [def] - A default function to return if none is found.
	 * @returns {(function|null)***REMOVED***
	 */
	F.checkFnValue = function(self, value, def){
		def = F.is.fn(def) ? def : null;
		function wrap(t, fn, d){
			if (!F.is.fn(fn)) return d;
			return function(){
				return fn.apply(t, arguments);
			***REMOVED***;
		***REMOVED***
		return F.is.fn(value) ? wrap(self, value, def) : (F.is.type(value, 'string') ? wrap(self, F.getFnPointer(value), def) : def);
	***REMOVED***;

***REMOVED***)(jQuery, FooTable);
(function($, F){

	F.Cell = F.Class.extend(/** @lends FooTable.Cell */{
		/**
		 * The cell class containing all the properties for cells.
		 * @constructs
		 * @extends FooTable.Class
		 * @param {FooTable.Table***REMOVED*** table -  The root {@link FooTable.Table***REMOVED*** this cell belongs to.
		 * @param {FooTable.Row***REMOVED*** row - The parent {@link FooTable.Row***REMOVED*** this cell belongs to.
		 * @param {FooTable.Column***REMOVED*** column - The {@link FooTable.Column***REMOVED*** this cell falls under.
		 * @param {(*|HTMLElement|jQuery)***REMOVED*** valueOrElement - Either the value or the element for the cell.
		 * @returns {FooTable.Cell***REMOVED***
		 * @this FooTable.Cell
		 */
		construct: function (table, row, column, valueOrElement) {
			/**
			 * The root {@link FooTable.Table***REMOVED*** for the cell.
			 * @instance
			 * @readonly
			 * @type {FooTable.Table***REMOVED***
			 */
			this.ft = table;
			/**
			 * The parent {@link FooTable.Row***REMOVED*** for the cell.
			 * @instance
			 * @readonly
			 * @type {FooTable.Row***REMOVED***
			 */
			this.row = row;
			/**
			 * The {@link FooTable.Column***REMOVED*** this cell falls under.
			 * @instance
			 * @readonly
			 * @type {FooTable.Column***REMOVED***
			 */
			this.column = column;
			this.created = false;
			this.define(valueOrElement);
		***REMOVED***,
		/**
		 * This is supplied either the value or the cell element/jQuery object if it exists.
		 * If supplied the element we need set the $el property and parse the value from it.
		 * @instance
		 * @protected
		 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or element to define the cell.
		 * @this FooTable.Cell
		 */
		define: function(valueOrElement){
			/**
			 * The jQuery table cell object this instance wraps.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$el = F.is.element(valueOrElement) || F.is.jq(valueOrElement) ? $(valueOrElement) : null;
			/**
			 * The jQuery row object that represents this cell in the details table.
			 * @type {jQuery***REMOVED***
			 */
			this.$detail = null;

			var hasOptions = F.is.hash(valueOrElement) && F.is.hash(valueOrElement.options) && F.is.defined(valueOrElement.value);

			/**
			 * The value of the cell.
			 * @instance
			 * @type {****REMOVED***
			 */
			this.value = this.column.parser.call(this.column, F.is.jq(this.$el) ? this.$el : (hasOptions ? valueOrElement.value : valueOrElement), this.ft.o);

			/**
			 * Contains any options for the cell. These are the options supplied through the plugin constructor as part of the row object itself.
			 * @type {object***REMOVED***
			 */
			this.o = $.extend(true, {
				classes: null,
				style: null
			***REMOVED***, hasOptions ? valueOrElement.options : {***REMOVED***);
			/**
			 * An array of CSS classes for the cell.
			 * @instance
			 * @protected
			 * @type {Array.<string>***REMOVED***
			 */
			this.classes = F.is.jq(this.$el) && this.$el.attr('class') ? this.$el.attr('class').match(/\S+/g) : (F.is.array(this.o.classes) ? this.o.classes : (F.is.string(this.o.classes) ? this.o.classes.match(/\S+/g) : []));
			/**
			 * The inline styles for the cell.
			 * @instance
			 * @protected
			 * @type {object***REMOVED***
			 */
			this.style = F.is.jq(this.$el) && this.$el.attr('style') ? F.css2json(this.$el.attr('style')) : (F.is.hash(this.o.style) ? this.o.style : (F.is.string(this.o.style) ? F.css2json(this.o.style) : {***REMOVED***));
		***REMOVED***,
		/**
		 * After the cell has been defined this ensures that the $el and #detail properties are jQuery objects by either creating or updating them.
		 * @instance
		 * @protected
		 * @this FooTable.Cell
		 */
		$create: function(){
			if (this.created) return;
			(this.$el = F.is.jq(this.$el) ? this.$el : $('<td/>'))
				.data('value', this.value)
				.contents().detach().end()
				.append(this.format(this.value));

			this._setClasses(this.$el);
			this._setStyle(this.$el);

			this.$detail = $('<tr/>').addClass(this.row.classes.join(' '))
				.data('__FooTableCell__', this)
				.append($('<th/>'))
				.append($('<td/>'));

			this.created = true;
		***REMOVED***,
		/**
		 * Collapses this cell and displays it in the details row.
		 * @instance
		 * @protected
		 */
		collapse: function(){
			if (!this.created) return;
			this.$detail.children('th').html(this.column.title);
			this.$el.clone()
				.attr('id', this.$el.attr('id') ? this.$el.attr('id') + '-detail' : undefined)
				.css('display', 'table-cell')
				.html('')
				.append(this.$el.contents().detach())
				.replaceAll(this.$detail.children('td').first());

			if (!F.is.jq(this.$detail.parent()))
				this.$detail.appendTo(this.row.$details.find('.footable-details > tbody'));
		***REMOVED***,
		/**
		 * Restores this cell from a detail row back into the normal row.
		 * @instance
		 * @protected
		 */
		restore: function(){
			if (!this.created) return;
			if (F.is.jq(this.$detail.parent())){
				var $cell = this.$detail.children('td').first();
				this.$el
					.attr('class', $cell.attr('class'))
					.attr('style', $cell.attr('style'))
					.css('display', (this.column.hidden || !this.column.visible) ? 'none' : 'table-cell')
					.append($cell.contents().detach());
			***REMOVED***
			this.$detail.detach();
		***REMOVED***,
		/**
		 * Helper method to call this cell's column parser function supplying the required parameters.
		 * @instance
		 * @protected
		 * @returns {****REMOVED***
		 * @see FooTable.Column#parser
		 * @this FooTable.Cell
		 */
		parse: function(){
			return this.column.parser.call(this.column, this.$el, this.ft.o);
		***REMOVED***,
		/**
		 * Helper method to call this cell's column formatter function using the supplied value and any additional required parameters.
		 * @instance
		 * @protected
		 * @param {****REMOVED*** value - The value to format.
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 * @see FooTable.Column#formatter
		 * @this FooTable.Cell
		 */
		format: function(value){
			return this.column.formatter.call(this.column, value, this.ft.o, this.row.value);
		***REMOVED***,
		/**
		 * Allows easy access to getting or setting the cell's value. If the value is set all associated properties are also updated along with the actual element.
		 * Using this method also allows us to supply an object containing options and the value for the cell.
		 * @instance
		 * @param {****REMOVED*** [value] - The value to set for the cell. If not supplied the current value of the cell is returned.
		 * @param {boolean***REMOVED*** [redraw=true] - Whether or not to redraw the row once the value has been set.
		 * @param {boolean***REMOVED*** [redrawSelf=true] - Whether or not to redraw the cell itself once the value has been set, if `false` this will override the supplied `redraw` value and prevent the row from redrawing as well.
		 * @returns {(*|undefined)***REMOVED***
		 * @this FooTable.Cell
		 */
		val: function(value, redraw, redrawSelf){
			if (F.is.undef(value)){
				// get
				return this.value;
			***REMOVED***
			// set
			var self = this, hasOptions = F.is.hash(value) && F.is.hash(value.options) && F.is.defined(value.value);
			this.o = $.extend(true, {
				classes: self.classes,
				style: self.style
			***REMOVED***, hasOptions ? value.options : {***REMOVED***);

			this.value = hasOptions ? value.value : value;
			this.classes = F.is.array(this.o.classes) ? this.o.classes : (F.is.string(this.o.classes) ? this.o.classes.match(/\S+/g) : []);
			this.style = F.is.hash(this.o.style) ? this.o.style : (F.is.string(this.o.style) ? F.css2json(this.o.style) : {***REMOVED***);

			redrawSelf = F.is.boolean(redrawSelf) ? redrawSelf : true;
			if (this.created && redrawSelf){
				this.$el.data('value', this.value).empty();

				var $detail = this.$detail.children('td').first().empty(),
					$target = F.is.jq(this.$detail.parent()) ? $detail : this.$el;

				$target.append(this.format(this.value));

				this._setClasses($target);
				this._setStyle($target);

				if (F.is.boolean(redraw) ? redraw : true) this.row.draw();
			***REMOVED***
		***REMOVED***,
		_setClasses: function($el){
			var hasColClasses = !F.is.emptyArray(this.column.classes),
				hasClasses = !F.is.emptyArray(this.classes),
				classes = null;
			$el.removeAttr('class');
			if (!hasColClasses && !hasClasses) return;
			if (hasColClasses && hasClasses){
				classes = this.classes.concat(this.column.classes).join(' ');
			***REMOVED*** else if (hasColClasses) {
				classes = this.column.classes.join(' ');
			***REMOVED*** else if (hasClasses){
				classes = this.classes.join(' ');
			***REMOVED***
			if (!F.is.emptyString(classes)){
				$el.addClass(classes);
			***REMOVED***
		***REMOVED***,
		_setStyle: function($el){
			var hasColStyle = !F.is.emptyObject(this.column.style),
				hasStyle = !F.is.emptyObject(this.style),
				style = null;
			$el.removeAttr('style');
			if (!hasColStyle && !hasStyle) return;
			if (hasColStyle && hasStyle){
				style = $.extend({***REMOVED***, this.column.style, this.style);
			***REMOVED*** else if (hasColStyle) {
				style = this.column.style;
			***REMOVED*** else if (hasStyle){
				style = this.style;
			***REMOVED***
			if (F.is.hash(style)){
				$el.css(style);
			***REMOVED***
		***REMOVED***
	***REMOVED***);

***REMOVED***)(jQuery, FooTable);
(function($, F){

	F.Column = F.Class.extend(/** @lends FooTable.Column */{
		/**
		 * The column class containing all the properties for columns. All members marked as "readonly" should not be used when defining {@link FooTable.Defaults#columns***REMOVED***.
		 * @constructs
		 * @extends FooTable.Class
		 * @param {FooTable.Table***REMOVED*** instance -  The parent {@link FooTable.Table***REMOVED*** this component belongs to.
		 * @param {object***REMOVED*** definition - An object containing all the properties to set for the column.
		 * @param {string***REMOVED*** [type] - The type of column, "text" by default.
		 * @returns {FooTable.Column***REMOVED***
		 * @this FooTable.Column
		 */
		construct: function(instance, definition, type){
			/**
			 * The root {@link FooTable.Table***REMOVED*** for the column.
			 * @instance
			 * @readonly
			 * @type {FooTable.Table***REMOVED***
			 */
			this.ft = instance;
			/**
			 * The type of data displayed by the column.
			 * @instance
			 * @readonly
			 * @type {string***REMOVED***
			 */
			this.type = F.is.emptyString(type) ? 'text' : type;
			/**
			 * Whether or not the column was parsed from a standard table row containing data instead of from an actual header row.
			 * @instance
			 * @readonly
			 * @type {boolean***REMOVED***
			 */
			this.virtual = F.is.boolean(definition.virtual) ? definition.virtual : false;
			/**
			 * The jQuery cell object for the column header.
			 * @instance
			 * @readonly
			 * @type {jQuery***REMOVED***
			 */
			this.$el = F.is.jq(definition.$el) ? definition.$el : null;
			/**
			 * The index of the column in the table. This is set by the plugin during initialization.
			 * @instance
			 * @readonly
			 * @type {number***REMOVED***
			 * @default -1
			 */
			this.index = F.is.number(definition.index) ? definition.index : -1;
			/**
			 * Whether or not this in an internal only column.
			 * @instance
			 * @readonly
			 * @type {boolean***REMOVED***
			 * @description Internal columns or there cells will not be returned when calling methods such as `FooTable.Row#val`.
			 */
			this.internal = false;
			this.define(definition);
			this.$create();
		***REMOVED***,
		/**
		 * This is supplied the column definition in the form of a simple object created by merging options supplied via the plugin constructor with those parsed from the DOM.
		 * @instance
		 * @protected
		 * @param {object***REMOVED*** definition - The object containing the column definition.
		 * @this FooTable.Column
		 */
		define: function(definition){
			/**
			 * Whether or not this column is hidden from view and appears in the details row.
			 * @type {boolean***REMOVED***
			 * @default false
			 */
			this.hidden = F.is.boolean(definition.hidden) ? definition.hidden : false;
			/**
			 * Whether or not this column is completely hidden from view and will not appear in the details row.
			 * @type {boolean***REMOVED***
			 * @default true
			 */
			this.visible = F.is.boolean(definition.visible) ? definition.visible : true;

			/**
			 * The name of the column. This name must correspond to the property name of the JSON row data.
			 * @type {string***REMOVED***
			 * @default null
			 */
			this.name = F.is.string(definition.name) ? definition.name : null;
			if (this.name == null) this.name = 'col'+(definition.index+1);
			/**
			 * The title to display in the column header, this can be HTML.
			 * @type {string***REMOVED***
			 * @default null
			 */
			this.title = F.is.string(definition.title) ? definition.title : null;
			if (!this.virtual && this.title == null && F.is.jq(this.$el)) this.title = this.$el.html();
			if (this.title == null) this.title = 'Column '+(definition.index+1);
			/**
			 * The styles to apply to all cells in this column.
			 * @type {object***REMOVED***
			 */
			this.style = F.is.hash(definition.style) ? definition.style : (F.is.string(definition.style) ? F.css2json(definition.style) : {***REMOVED***);
			/**
			 * The classes to apply to all cells in this column.
			 * @type {Array.<string>***REMOVED***
			 */
			this.classes = F.is.array(definition.classes) ? definition.classes : (F.is.string(definition.classes) ? definition.classes.match(/\S+/g) : []);

			// override any default functions ensuring when they are executed "this" within the context of the function points to the instance of this object.
			this.parser = F.checkFnValue(this, definition.parser, this.parser);
			this.formatter = F.checkFnValue(this, definition.formatter, this.formatter);
		***REMOVED***,
		/**
		 * After the column has been defined this ensures that the $el property is a jQuery object by either creating or updating the current value.
		 * @instance
		 * @protected
		 * @this FooTable.Column
		 */
		$create: function(){
			(this.$el = !this.virtual && F.is.jq(this.$el) ? this.$el : $('<th/>')).html(this.title).addClass(this.classes.join(' ')).css(this.style);
		***REMOVED***,
		/**
		 * This is supplied either the cell value or jQuery object to parse. Any value can be returned from this method and will be provided to the {@link FooTable.Column#format***REMOVED*** function
		 * to generate the cell contents.
		 * @instance
		 * @protected
		 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
		 * @returns {string***REMOVED***
		 * @this FooTable.Column
		 */
		parser: function(valueOrElement){
			if (F.is.element(valueOrElement) || F.is.jq(valueOrElement)){ // use jQuery to get the value
				var data = $(valueOrElement).data('value');
				return F.is.defined(data) ? data : $(valueOrElement).html();
			***REMOVED***
			if (F.is.defined(valueOrElement) && valueOrElement != null) return valueOrElement+''; // use the native toString of the value
			return null; // otherwise we have no value so return null
		***REMOVED***,
		/**
		 * This is supplied the value retrieved from the {@link FooTable.Column#parse***REMOVED*** function and must return a string, HTMLElement or jQuery object.
		 * The return value from this function is what is displayed in the cell in the table.
		 * @instance
		 * @protected
		 * @param {string***REMOVED*** value - The value to format.
		 * @param {object***REMOVED*** options - The current plugin options.
		 * @param {object***REMOVED*** rowData - An object containing the current row data.
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 * @this FooTable.Column
		 */
		formatter: function(value, options, rowData){
			return value == null ? '' : value;
		***REMOVED***,
		/**
		 * Creates a cell for this column from the supplied {@link FooTable.Row***REMOVED*** object. This allows different column types to return different types of cells.
		 * @instance
		 * @protected
		 * @param {FooTable.Row***REMOVED*** row - The row to create the cell from.
		 * @returns {FooTable.Cell***REMOVED***
		 * @this FooTable.Column
		 */
		createCell: function(row){
			var element = F.is.jq(row.$el) ? row.$el.children('td,th').get(this.index) : null,
				data = F.is.hash(row.value) ? row.value[this.name] : null;
			return new F.Cell(this.ft, row, this, element || data);
		***REMOVED***
	***REMOVED***);

	F.columns = new F.ClassFactory();

	F.columns.register('text', F.Column);

***REMOVED***)(jQuery, FooTable);
(function ($, F) {

	F.Component = F.Class.extend(/** @lends FooTable.Component */{
		/**
		 * The base class for all FooTable components.
		 * @constructs
		 * @extends FooTable.Class
		 * @param {FooTable.Table***REMOVED*** instance - The parent {@link FooTable.Table***REMOVED*** object for the component.
		 * @param {boolean***REMOVED*** enabled - Whether or not the component is enabled.
		 * @throws {TypeError***REMOVED*** The instance parameter must be an instance of {@link FooTable.Table***REMOVED***.
		 * @returns {FooTable.Component***REMOVED***
		 */
		construct: function (instance, enabled) {
			if (!(instance instanceof F.Table))
				throw new TypeError('The instance parameter must be an instance of FooTable.Table.');

			/**
			 * The parent {@link FooTable.Table***REMOVED*** for the component.
			 * @type {FooTable.Table***REMOVED***
			 */
			this.ft = instance;
			/**
			 * Whether or not this component is enabled. Disabled components only have there preinit method called allowing for this value to be overridden.
			 * @type {boolean***REMOVED***
			 */
			this.enabled = F.is.boolean(enabled) ? enabled : false;
		***REMOVED***,
		/**
		 * The preinit method is called during the parent {@link FooTable.Table***REMOVED*** constructor call.
		 * @param {object***REMOVED*** data - The jQuery.data() object of the root table.
		 * @instance
		 * @protected
		 * @function
		 */
		preinit: function(data){***REMOVED***,
		/**
		 * The init method is called during the parent {@link FooTable.Table***REMOVED*** constructor call.
		 * @instance
		 * @protected
		 * @function
		 */
		init: function(){***REMOVED***,
		/**
		 * This method is called from the {@link FooTable.Table#destroy***REMOVED*** method.
		 * @instance
		 * @protected
		 * @function
		 */
		destroy: function(){***REMOVED***,
		/**
		 * This method is called from the {@link FooTable.Table#draw***REMOVED*** method.
		 * @instance
		 * @protected
		 * @function
		 */
		predraw: function(){***REMOVED***,
		/**
		 * This method is called from the {@link FooTable.Table#draw***REMOVED*** method.
		 * @instance
		 * @protected
		 * @function
		 */
		draw: function(){***REMOVED***,
		/**
		 * This method is called from the {@link FooTable.Table#draw***REMOVED*** method.
		 * @instance
		 * @protected
		 * @function
		 */
		postdraw: function(){***REMOVED***
	***REMOVED***);

	F.components = new F.ClassFactory();

***REMOVED***)(jQuery, FooTable);
(function ($, F) {
	/**
	 * Contains all the available options for the FooTable plugin.
	 * @name FooTable.Defaults
	 * @function
	 * @constructor
	 * @returns {FooTable.Defaults***REMOVED***
	 */
	F.Defaults = function () {
		/**
		 * Whether or not events raised using the {@link FooTable.Table#raise***REMOVED*** method are propagated up the DOM. By default this is set to false and all events bubble up the DOM as per usual
		 * however the reason for this option is if we have nested tables. If false the parent table would receive all the events raised by it's children and any handlers bound to both the
		 * parent and child would be triggered which is not the desired behavior.
		 * @type {boolean***REMOVED***
		 * @default false
		 */
		this.stopPropagation = false;
		/**
		 * An object in which the string keys represent one or more space-separated event types and optional namespaces, and the values represent a handler function to be called for the event(s).
		 * @type {object.<string, function>***REMOVED***
		 * @default NULL
		 * @example <caption>This example shows how to pass an object containing the events and handlers.</caption>
		 * "on": {
		 * 	"click": function(e){
		 * 		// bind a custom click event to do something whenever the table is clicked
		 * 	***REMOVED***,
		 * 	"init.ft.table": function(e, ft){
		 * 		// bind to the FooTable initialize event to do something
		 * 	***REMOVED***
		 * ***REMOVED***
		 */
		this.on = null;
	***REMOVED***;

	/**
	 * Contains all the default options for the plugin.
	 * @type {FooTable.Defaults***REMOVED***
	 */
	F.defaults = new F.Defaults();

***REMOVED***)(jQuery, FooTable);
(function($, F){

	F.Row = F.Class.extend(/** @lends FooTable.Row */{
		/**
		 * The row class containing all the properties for a row and its' cells.
		 * @constructs
		 * @extends FooTable.Class
		 * @param {FooTable.Table***REMOVED*** table -  The parent {@link FooTable.Table***REMOVED*** this component belongs to.
		 * @param {Array.<FooTable.Column>***REMOVED*** columns - The array of {@link FooTable.Column***REMOVED*** for this row.
		 * @param {(*|HTMLElement|jQuery)***REMOVED*** dataOrElement - Either the data for the row (create) or the element (parse) for the row.
		 * @returns {FooTable.Row***REMOVED***
		 */
		construct: function (table, columns, dataOrElement) {
			/**
			 * The {@link FooTable.Table***REMOVED*** for the row.
			 * @type {FooTable.Table***REMOVED***
			 */
			this.ft = table;
			/**
			 * The array of {@link FooTable.Column***REMOVED*** for this row.
			 * @type {Array.<FooTable.Column>***REMOVED***
			 */
			this.columns = columns;

			this.created = false;
			this.define(dataOrElement);
		***REMOVED***,
		/**
		 * This is supplied either the object containing the values for the row or the row element/jQuery object if it exists.
		 * If supplied the element we need to set the $el property and parse the cells from it using the column index.
		 * If we have an object we parse the cells from it using the column name.
		 * @param {(object|jQuery)***REMOVED*** dataOrElement - The row object or element to define the row.
		 */
		define: function(dataOrElement){
			/**
			 * The jQuery table row object this instance wraps.
			 * @instance
			 * @protected
			 * @type {jQuery***REMOVED***
			 */
			this.$el = F.is.element(dataOrElement) || F.is.jq(dataOrElement) ? $(dataOrElement) : null;
			/**
			 * The jQuery toggle element for the row.
			 * @instance
			 * @protected
			 * @type {jQuery***REMOVED***
			 */
			this.$toggle = $('<span/>', {'class': 'footable-toggle fooicon fooicon-plus'***REMOVED***);

			var isObj = F.is.hash(dataOrElement),
				hasOptions = isObj && F.is.hash(dataOrElement.options) && F.is.hash(dataOrElement.value);

			/**
			 * The value of the row.
			 * @instance
			 * @protected
			 * @type {Object***REMOVED***
			 */
			this.value = isObj ? (hasOptions ? dataOrElement.value : dataOrElement) : null;

			/**
			 * Contains any options for the row.
			 * @type {object***REMOVED***
			 */
			this.o = $.extend(true, {
				expanded: false,
				classes: null,
				style: null
			***REMOVED***, hasOptions ? dataOrElement.options : {***REMOVED***);

			/**
			 * Whether or not this row is expanded and will display it's detail row when there are any hidden columns.
			 * @instance
			 * @protected
			 * @type {boolean***REMOVED***
			 */
			this.expanded = F.is.jq(this.$el) ? (this.$el.data('expanded') || this.o.expanded) : this.o.expanded;
			/**
			 * An array of CSS classes for the row.
			 * @instance
			 * @protected
			 * @type {Array.<string>***REMOVED***
			 */
			this.classes = F.is.jq(this.$el) && this.$el.attr('class') ? this.$el.attr('class').match(/\S+/g) : (F.is.array(this.o.classes) ? this.o.classes : (F.is.string(this.o.classes) ? this.o.classes.match(/\S+/g) : []));
			/**
			 * The inline styles for the row.
			 * @instance
			 * @protected
			 * @type {object***REMOVED***
			 */
			this.style = F.is.jq(this.$el) && this.$el.attr('style') ? F.css2json(this.$el.attr('style')) : (F.is.hash(this.o.style) ? this.o.style : (F.is.string(this.o.style) ? F.css2json(this.o.style) : {***REMOVED***));

			/**
			 * The cells array. This is populated before the call to the {@link FooTable.Row#$create***REMOVED*** method.
			 * @instance
			 * @type {Array.<FooTable.Cell>***REMOVED***
			 */
			this.cells = this.createCells();

			// this ensures the value contains the parsed cell values and not the supplied values
			var self = this;
			self.value = {***REMOVED***;
			F.arr.each(self.cells, function(cell){
				self.value[cell.column.name] = cell.val();
			***REMOVED***);
		***REMOVED***,
		/**
		 * After the row has been defined this ensures that the $el property is a jQuery object by either creating or updating the current value.
		 * @instance
		 * @protected
		 * @this FooTable.Row
		 */
		$create: function(){
			if (this.created) return;
			(this.$el = F.is.jq(this.$el) ? this.$el : $('<tr/>'))
				.data('__FooTableRow__', this);

			this._setClasses(this.$el);
			this._setStyle(this.$el);

			if (this.ft.rows.toggleColumn == 'last') this.$toggle.addClass('last-column');

			this.$details = $('<tr/>', { 'class': 'footable-detail-row' ***REMOVED***)
				.append($('<td/>', { colspan: this.ft.columns.visibleColspan ***REMOVED***)
					.append($('<table/>', { 'class': 'footable-details ' + this.ft.classes.join(' ') ***REMOVED***)
						.append('<tbody/>')));

			var self = this;
			F.arr.each(self.cells, function(cell){
				if (!cell.created) cell.$create();
				self.$el.append(cell.$el);
			***REMOVED***);
			self.$el.off('click.ft.row').on('click.ft.row', { self: self ***REMOVED***, self._onToggle);
			this.created = true;
		***REMOVED***,
		/**
		 * This is called during the construct method and uses the current column definitions to create an array of {@link FooTable.Cell***REMOVED*** objects for the row.
		 * @instance
		 * @protected
		 * @returns {Array.<FooTable.Cell>***REMOVED***
		 * @this FooTable.Row
		 */
		createCells: function(){
			var self = this;
			return F.arr.map(self.columns, function(col){
				return col.createCell(self);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Allows easy access to getting or setting the row's data. If the data is set all associated properties are also updated along with the actual element.
		 * Using this method also allows us to supply an object containing options and the data for the row at the same time.
		 * @instance
		 * @param {object***REMOVED*** [data] - The data to set for the row. If not supplied the current value of the row is returned.
		 * @param {boolean***REMOVED*** [redraw=true] - Whether or not to redraw the table once the value has been set.
		 * @param {boolean***REMOVED*** [redrawSelf=true] - Whether or not to redraw the row itself once the value has been set, if `false` this will override the supplied `redraw` value and prevent the table from redrawing as well.
		 * @returns {(*|undefined)***REMOVED***
		 */
		val: function(data, redraw, redrawSelf){
			var self = this;
			if (!F.is.hash(data)){
				// get - check the value property and build it from the cells if required.
				if (!F.is.hash(this.value) || F.is.emptyObject(this.value)){
					this.value = {***REMOVED***;
					F.arr.each(this.cells, function(cell){
						if (!cell.column.internal){
							self.value[cell.column.name] = cell.val();
						***REMOVED***
					***REMOVED***);
				***REMOVED***
				return this.value;
			***REMOVED***
			// set
			this.collapse(false);
			var isObj = F.is.hash(data),
				hasOptions = isObj && F.is.hash(data.options) && F.is.hash(data.value);

			this.o = $.extend(true, {
				expanded: self.expanded,
				classes: self.classes,
				style: self.style
			***REMOVED***, hasOptions ? data.options : {***REMOVED***);

			this.expanded = this.o.expanded;
			this.classes = F.is.array(this.o.classes) ? this.o.classes : (F.is.string(this.o.classes) ? this.o.classes.match(/\S+/g) : []);
			this.style = F.is.hash(this.o.style) ? this.o.style : (F.is.string(this.o.style) ? F.css2json(this.o.style) : {***REMOVED***);
			if (isObj) {
				if ( hasOptions ) data = data.value;
				if (F.is.hash(this.value)){
					for (var prop in data) {
						if (!data.hasOwnProperty(prop)) continue;
						this.value[prop] = data[prop];
					***REMOVED***
				***REMOVED*** else {
					this.value = data;
				***REMOVED***
			***REMOVED*** else {
				this.value = null;
			***REMOVED***

			redrawSelf = F.is.boolean(redrawSelf) ? redrawSelf : true;
			F.arr.each(this.cells, function(cell){
				if (!cell.column.internal && F.is.defined(self.value[cell.column.name])){
					cell.val(self.value[cell.column.name], false, redrawSelf);
				***REMOVED***
			***REMOVED***);

			if (this.created && redrawSelf){
				this._setClasses(this.$el);
				this._setStyle(this.$el);
				if (F.is.boolean(redraw) ? redraw : true) this.draw();
			***REMOVED***
		***REMOVED***,
		_setClasses: function($el){
			var hasClasses = !F.is.emptyArray(this.classes),
				classes = null;
			$el.removeAttr('class');
			if (!hasClasses) return;
			else classes = this.classes.join(' ');
			if (!F.is.emptyString(classes)){
				$el.addClass(classes);
			***REMOVED***
		***REMOVED***,
		_setStyle: function($el){
			var hasStyle = !F.is.emptyObject(this.style),
				style = null;
			$el.removeAttr('style');
			if (!hasStyle) return;
			else style = this.style;
			if (F.is.hash(style)){
				$el.css(style);
			***REMOVED***
		***REMOVED***,
		/**
		 * Sets the current row to an expanded state displaying any hidden columns in a detail row just below it.
		 * @instance
		 * @fires FooTable.Row#"expand.ft.row"
		 */
		expand: function(){
			if (!this.created) return;
			var self = this;
			/**
			 * The expand.ft.row event is raised before the the row is expanded.
			 * Calling preventDefault on this event will stop the row being expanded.
			 * @event FooTable.Row#"expand.ft.row"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {FooTable.Row***REMOVED*** row - The row about to be expanded.
			 */
			self.ft.raise('expand.ft.row',[self]).then(function(){
				self.__hidden__ = F.arr.map(self.cells, function(cell){
					return cell.column.hidden && cell.column.visible ? cell : null;
				***REMOVED***);

				if (self.__hidden__.length > 0){
					self.$details.insertAfter(self.$el)
						.children('td').first()
						.attr('colspan', self.ft.columns.visibleColspan);

					F.arr.each(self.__hidden__, function(cell){
						cell.collapse();
					***REMOVED***);
				***REMOVED***
				self.$el.attr('data-expanded', true);
				self.$toggle.removeClass('fooicon-plus').addClass('fooicon-minus');
				self.expanded = true;
				self.ft.raise('expanded.ft.row', [self]);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Sets the current row to a collapsed state removing the detail row if it exists.
		 * @instance
		 * @param {boolean***REMOVED*** [setExpanded] - Whether or not to set the {@link FooTable.Row#expanded***REMOVED*** property to false.
		 * @fires FooTable.Row#"collapse.ft.row"
		 */
		collapse: function(setExpanded){
			if (!this.created) return;
			var self = this;
			/**
			 * The collapse.ft.row event is raised before the the row is collapsed.
			 * Calling preventDefault on this event will stop the row being collapsed.
			 * @event FooTable.Row#"collapse.ft.row"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {FooTable.Row***REMOVED*** row - The row about to be expanded.
			 */
			self.ft.raise('collapse.ft.row',[self]).then(function(){
				F.arr.each(self.__hidden__, function(cell){
					cell.restore();
				***REMOVED***);
				self.$details.detach();
				self.$el.removeAttr('data-expanded');
				self.$toggle.removeClass('fooicon-minus').addClass('fooicon-plus');
				if (F.is.boolean(setExpanded) ? setExpanded : true) self.expanded = false;
				self.ft.raise('collapsed.ft.row', [self]);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Prior to drawing this moves the details contents back to there original cells and detaches the toggle element from the row.
		 * @instance
		 * @param {boolean***REMOVED*** [detach] - Whether or not to detach the row.
		 * @this FooTable.Row
		 */
		predraw: function(detach){
			if (this.created){
				if (this.expanded){
					this.collapse(false);
				***REMOVED***
				this.$toggle.detach();
				detach = F.is.boolean(detach) ? detach : true;
				if (detach) this.$el.detach();
			***REMOVED***
		***REMOVED***,
		/**
		 * Draws the current row and cells.
		 * @instance
		 * @this FooTable.Row
		 */
		draw: function($parent){
			if (!this.created) this.$create();
			if (F.is.jq($parent)) $parent.append(this.$el);
			var self = this;
			F.arr.each(self.cells, function(cell){
				cell.$el.css('display', (cell.column.hidden || !cell.column.visible  ? 'none' : 'table-cell'));
				if (self.ft.rows.showToggle && self.ft.columns.hasHidden){
					if ((self.ft.rows.toggleColumn == 'first' && cell.column.index == self.ft.columns.firstVisibleIndex)
						|| (self.ft.rows.toggleColumn == 'last' && cell.column.index == self.ft.columns.lastVisibleIndex)) {
						cell.$el.prepend(self.$toggle);
					***REMOVED***
				***REMOVED***
				cell.$el.add(cell.column.$el).removeClass('footable-first-visible footable-last-visible');
				if (cell.column.index == self.ft.columns.firstVisibleIndex){
					cell.$el.add(cell.column.$el).addClass('footable-first-visible');
				***REMOVED***
				if (cell.column.index == self.ft.columns.lastVisibleIndex){
					cell.$el.add(cell.column.$el).addClass('footable-last-visible');
				***REMOVED***
			***REMOVED***);
			if (this.expanded){
				this.expand();
			***REMOVED***
		***REMOVED***,
		/**
		 * Toggles the row between it's expanded and collapsed state if there are hidden columns.
		 * @instance
		 * @this FooTable.Row
		 */
		toggle: function(){
			if (this.created && this.ft.columns.hasHidden){
				if (this.expanded) this.collapse();
				else this.expand();
			***REMOVED***
		***REMOVED***,
		/**
		 * Handles the toggle click event for rows.
		 * @instance
		 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the click event.
		 * @private
		 * @this jQuery
		 */
		_onToggle: function (e) {
			var self = e.data.self;
			// only execute the toggle if the event.target is one of the approved initiators
			if ($(e.target).is(self.ft.rows.toggleSelector)){
				self.toggle();
			***REMOVED***
		***REMOVED***
	***REMOVED***);

***REMOVED***)(jQuery, FooTable);

(function ($, F) {

	/**
	 * An array of all currently loaded instances of the plugin.
	 * @protected
	 * @readonly
	 * @type {Array.<FooTable.Table>***REMOVED***
	 */
	F.instances = [];

	F.Table = F.Class.extend(/** @lends FooTable.Table */{
		/**
		 * This class is the core of the plugin and drives the logic of all components.
		 * @constructs
		 * @this FooTable.Table
		 * @extends FooTable.Class
		 * @param {(HTMLTableElement|jQuery)***REMOVED*** element - The element or jQuery table object to bind the plugin to.
		 * @param {object***REMOVED*** options - The options to initialize the plugin with.
		 * @param {function***REMOVED*** [ready] - A callback function to execute once the plugin is initialized.
		 * @returns {FooTable.Table***REMOVED***
		 */
		construct: function (element, options, ready) {
			//BEGIN MEMBERS
			/**
			 * The timeout ID for the resize event.
			 * @instance
			 * @private
			 * @type {?number***REMOVED***
			 */
			this._resizeTimeout = null;
			/**
			 * The ID of the FooTable instance.
			 * @instance
			 * @type {number***REMOVED***
			 */
			this.id = F.instances.push(this);
			/**
			 * Whether or not the plugin and all components and add-ons are fully initialized.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.initialized = false;
			/**
			 * The jQuery table object the plugin is bound to.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$el = (F.is.jq(element) ? element : $(element)).first(); // ensure one table, one instance
			/**
			 * A loader jQuery instance
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$loader = $('<div/>', { 'class': 'footable-loader' ***REMOVED***).append($('<span/>', {'class': 'fooicon fooicon-loader'***REMOVED***));
			/**
			 * The options for the plugin. This is a merge of user defined options and the default options.
			 * @instance
			 * @type {object***REMOVED***
			 */
			this.o = $.extend(true, {***REMOVED***, F.defaults, options);
			/**
			 * The jQuery data object for the table at initialization.
			 * @instance
			 * @type {object***REMOVED***
			 */
			this.data = this.$el.data() || {***REMOVED***;
			/**
			 * An array of all CSS classes on the table that do not start with "footable".
			 * @instance
			 * @protected
			 * @type {Array.<string>***REMOVED***
			 */
			this.classes = [];
			/**
			 * All components for this instance of the plugin. These are executed in the order they appear in the array for the initialize phase and in reverse order for the destroy phase of the plugin.
			 * @instance
			 * @protected
			 * @type {object***REMOVED***
			 * @prop {Array.<FooTable.Component>***REMOVED*** internal - The internal components for the plugin. These are executed either before all other components in the initialize phase or after them in the destroy phase of the plugin.
			 * @prop {Array.<FooTable.Component>***REMOVED*** core - The core components for the plugin. These are executed either after the internal components in the initialize phase or before them in the destroy phase of the plugin.
			 * @prop {Array.<FooTable.Component>***REMOVED*** custom - The custom components for the plugin. These are executed either after the core components in the initialize phase or before them in the destroy phase of the plugin.
			 */
			this.components = F.components.load((F.is.hash(this.data.components) ? this.data.components : this.o.components), this);
			/**
			 * The breakpoints component for this instance of the plugin.
			 * @instance
			 * @type {FooTable.Breakpoints***REMOVED***
			 */
			this.breakpoints = this.use(FooTable.Breakpoints);
			/**
			 * The columns component for this instance of the plugin.
			 * @instance
			 * @type {FooTable.Columns***REMOVED***
			 */
			this.columns = this.use(FooTable.Columns);
			/**
			 * The rows component for this instance of the plugin.
			 * @instance
			 * @type {FooTable.Rows***REMOVED***
			 */
			this.rows = this.use(FooTable.Rows);

			//END MEMBERS
			this._construct(ready);
		***REMOVED***,
		/**
		 * Once all properties are set this performs the actual initialization of the plugin calling the {@link FooTable.Table#_preinit***REMOVED*** and
		 * {@link FooTable.Table#_init***REMOVED*** methods as well as raising the {@link FooTable.Table#"ready.ft.table"***REMOVED*** event.
		 * @this FooTable.Table
		 * @instance
		 * @param {function***REMOVED*** [ready] - A callback function to execute once the plugin is initialized.
		 * @private
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Table#"ready.ft.table"
		 */
		_construct: function(ready){
			var self = this;
			return this._preinit().then(function(){
				return self._init().then(function(){
					/**
					 * The ready.ft.table event is raised after the plugin has been initialized and the table drawn.
					 * Calling preventDefault on this event will stop the ready callback being executed.
					 * @event FooTable.Table#"ready.ft.table"
					 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
					 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
					 */
					return self.raise('ready.ft.table').then(function(){
						if (F.is.fn(ready)) ready.call(self, self);
					***REMOVED***);
				***REMOVED***);
			***REMOVED***).always(function(arg){
				self.$el.show();
				if (F.is.error(arg)){
					console.error('FooTable: unhandled error thrown during initialization.', arg);
				***REMOVED***
			***REMOVED***);
		***REMOVED***,
		/**
		 * The preinit method is called prior to the plugins actual initialization and provides itself and it's components an opportunity to parse any additional option values.
		 * @instance
		 * @private
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Table#"preinit.ft.table"
		 */
		_preinit: function(){
			var self = this;
			/**
			 * The preinit.ft.table event is raised before any components.
			 * Calling preventDefault on this event will disable the entire plugin.
			 * @event FooTable.Table#"preinit.ft.table"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {object***REMOVED*** data - The jQuery data object from the root table element.
			 */
			return this.raise('preinit.ft.table', [self.data]).then(function(){
				var classes = (self.$el.attr('class') || '').match(/\S+/g) || [];

				self.o.ajax = F.checkFnValue(self, self.data.ajax, self.o.ajax);
				self.o.stopPropagation = F.is.boolean(self.data.stopPropagation)
					? self.data.stopPropagation
					: self.o.stopPropagation;

				for (var i = 0, len = classes.length; i < len; i++){
					if (!F.str.startsWith(classes[i], 'footable')) self.classes.push(classes[i]);
				***REMOVED***

				self.$el.hide().after(self.$loader);
				return self.execute(false, false, 'preinit', self.data);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Initializes this instance of the plugin and calls the callback function if one is supplied once complete.
		 * @this FooTable.Table
		 * @instance
		 * @private
		 * @return {jQuery.Promise***REMOVED***
		 * @fires FooTable.Table#"init.ft.table"
		 */
		_init: function(){
			var self = this;
			/**
			 * The init.ft.table event is raised before any components are initialized.
			 * Calling preventDefault on this event will disable the entire plugin.
			 * @event FooTable.Table#"init.ft.table"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			return self.raise('init.ft.table').then(function(){
				var $thead = self.$el.children('thead'),
					$tbody = self.$el.children('tbody'),
					$tfoot = self.$el.children('tfoot');
				self.$el.addClass('footable footable-' + self.id);
				if (F.is.hash(self.o.on)) self.$el.on(self.o.on);
				if ($tfoot.length == 0) self.$el.append($tfoot = $('<tfoot/>'));
				if ($tbody.length == 0) self.$el.append('<tbody/>');
				if ($thead.length == 0) self.$el.prepend($thead = $('<thead/>'));
				return self.execute(false, true, 'init').then(function(){
					self.$el.data('__FooTable__', self);
					if ($tfoot.children('tr').length == 0) $tfoot.remove();
					if ($thead.children('tr').length == 0) $thead.remove();

					/**
					 * The postinit.ft.table event is raised after any components are initialized but before the table is
					 * drawn for the first time.
					 * Calling preventDefault on this event will disable the initial drawing of the table.
					 * @event FooTable.Table#"postinit.ft.table"
					 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
					 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
					 */
					return self.raise('postinit.ft.table').then(function(){
						return self.draw();
					***REMOVED***).always(function(){
						$(window).off('resize.ft'+self.id, self._onWindowResize)
							.on('resize.ft'+self.id, { self: self ***REMOVED***, self._onWindowResize);
						self.initialized = true;
					***REMOVED***);
				***REMOVED***);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Destroys this plugin removing it from the table.
		 * @this FooTable.Table
		 * @instance
		 * @fires FooTable.Table#"destroy.ft.table"
		 */
		destroy: function () {
			var self = this;
			/**
			 * The destroy.ft.table event is called before all core components.
			 * Calling preventDefault on this event will prevent the entire plugin from being destroyed.
			 * @event FooTable.Table#"destroy.ft.table"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			return self.raise('destroy.ft.table').then(function(){
				return self.execute(true, true, 'destroy').then(function () {
					self.$el.removeData('__FooTable__').removeClass('footable-' + self.id);
					if (F.is.hash(self.o.on)) self.$el.off(self.o.on);
					$(window).off('resize.ft'+self.id, self._onWindowResize);
					self.initialized = false;
					F.instances[self.id] = null;
				***REMOVED***);
			***REMOVED***).fail(function(err){
				if (F.is.error(err)){
					console.error('FooTable: unhandled error thrown while destroying the plugin.', err);
				***REMOVED***
			***REMOVED***);
		***REMOVED***,
		/**
		 * Raises an event on this instance supplying the args array as additional parameters to the handlers.
		 * @this FooTable.Table
		 * @instance
		 * @param {string***REMOVED*** eventName - The name of the event to raise, this can include namespaces.
		 * @param {Array***REMOVED*** [args] - An array containing additional parameters to be passed to any bound handlers.
		 * @returns {jQuery.Event***REMOVED***
		 */
		raise: function(eventName, args){
			var self = this,
				debug = F.__debug__ && (F.is.emptyArray(F.__debug_options__.events) || F.arr.any(F.__debug_options__.events, function(name){ return F.str.contains(eventName, name); ***REMOVED***));
			args = args || [];
			args.unshift(this);
			return $.Deferred(function(d){
				var evt = $.Event(eventName);
				if (self.o.stopPropagation == true){
					self.$el.one(eventName, function (e) {e.stopPropagation();***REMOVED***);
				***REMOVED***
				if (debug) console.log('FooTable:'+eventName+': ', args);
				self.$el.trigger(evt, args);
				if (evt.isDefaultPrevented()){
					if (debug) console.log('FooTable: default prevented for the "'+eventName+'" event.');
					d.reject(evt);
				***REMOVED***	else d.resolve(evt);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Attempts to retrieve the instance of the supplied component type for this instance.
		 * @this FooTable.Table
		 * @instance
		 * @param {object***REMOVED*** type - The content type to retrieve for this instance.
		 * @returns {(*|null)***REMOVED***
		 */
		use: function(type){
			for (var i = 0, len = this.components.length; i < len; i++){
				if (this.components[i] instanceof type) return this.components[i];
			***REMOVED***
			return null;
		***REMOVED***,
		/**
		 * Performs the drawing of the table.
		 * @this FooTable.Table
		 * @instance
		 * @protected
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Table#"predraw.ft.table"
		 * @fires FooTable.Table#"draw.ft.table"
		 * @fires FooTable.Table#"postdraw.ft.table"
		 */
		draw: function () {
			var self = this;

			// Clone the current table and insert it into the original's place
			var $elCopy = self.$el.clone().insertBefore(self.$el);

			// Detach `self.$el` from the DOM, retaining its event handlers
			self.$el.detach();

			// when drawing the order that the components are executed is important so chain the methods but use promises to retain async safety.
			return self.execute(false, true, 'predraw').then(function(){
				/**
				 * The predraw.ft.table event is raised after all core components and add-ons have executed there predraw functions but before they execute there draw functions.
				 * @event FooTable.Table#"predraw.ft.table"
				 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
				 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
				 */
				return self.raise('predraw.ft.table').then(function(){
					return self.execute(false, true, 'draw').then(function(){
						/**
						 * The draw.ft.table event is raised after all core components and add-ons have executed there draw functions.
						 * @event FooTable.Table#"draw.ft.table"
						 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
						 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
						 */
						return self.raise('draw.ft.table').then(function(){
							return self.execute(false, true, 'postdraw').then(function(){
								/**
								 * The postdraw.ft.table event is raised after all core components and add-ons have executed there postdraw functions.
								 * @event FooTable.Table#"postdraw.ft.table"
								 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
								 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
								 */
								return self.raise('postdraw.ft.table');
							***REMOVED***);
						***REMOVED***);
					***REMOVED***);
				***REMOVED***);
			***REMOVED***).fail(function(err){
				if (F.is.error(err)){
					console.error('FooTable: unhandled error thrown during a draw operation.', err);
				***REMOVED***
			***REMOVED***).always(function(){
				// Replace the copy that we added above with the modified `self.$el`
				$elCopy.replaceWith(self.$el);
				self.$loader.remove();
			***REMOVED***);
		***REMOVED***,
		/**
		 * Executes the specified method with the optional number of parameters on all components and waits for the promise from each to be resolved before executing the next.
		 * @this FooTable.Table
		 * @instance
		 * @protected
		 * @param {boolean***REMOVED*** reverse - Whether or not to execute the component methods in the reverse order to what they were registered in.
		 * @param {boolean***REMOVED*** enabled - Whether or not to execute the method on enabled components only.
		 * @param {string***REMOVED*** methodName - The name of the method to execute.
		 * @param {****REMOVED*** [param1] - The first parameter for the method.
		 * @param {...****REMOVED*** [paramN] - Any number of additional parameters for the method.
		 * @returns {jQuery.Promise***REMOVED***
		 */
		execute: function(reverse, enabled, methodName, param1, paramN){
			var self = this, args = Array.prototype.slice.call(arguments);
			reverse = args.shift();
			enabled = args.shift();
			var components = enabled ? F.arr.get(self.components, function(c){ return c.enabled; ***REMOVED***) : self.components.slice(0);
			args.unshift(reverse ? components.reverse() : components);
			return self._execute.apply(self, args);
		***REMOVED***,
		/**
		 * Executes the specified method with the optional number of parameters on all supplied components waiting for the result of each before executing the next.
		 * @this FooTable.Table
		 * @instance
		 * @private
		 * @param {Array.<FooTable.Component>***REMOVED*** components - The components to call the method on.
		 * @param {string***REMOVED*** methodName - The name of the method to execute
		 * @param {****REMOVED*** [param1] - The first parameter for the method.
		 * @param {...****REMOVED*** [paramN] - Any additional parameters for the method.
		 * @returns {jQuery.Promise***REMOVED***
		 */
		_execute: function(components, methodName, param1, paramN){
			if (!components || !components.length) return $.when();
			var self = this, args = Array.prototype.slice.call(arguments),
				component;
			components = args.shift();
			methodName = args.shift();
			component = components.shift();

			if (!F.is.fn(component[methodName]))
				return self._execute.apply(self, [components, methodName].concat(args));

			return $.Deferred(function(d){
				try {
					var result = component[methodName].apply(component, args);
					if (F.is.promise(result)){
						return result.then(d.resolve, d.reject);
					***REMOVED*** else {
						d.resolve(result);
					***REMOVED***
				***REMOVED*** catch (err) {
					d.reject(err);
				***REMOVED***
			***REMOVED***).then(function(){
				return self._execute.apply(self, [components, methodName].concat(args));
			***REMOVED***);
		***REMOVED***,
		/**
		 * Listens to the window resize event and performs a check to see if the breakpoint has changed.
		 * @this window
		 * @instance
		 * @private
		 * @fires FooTable.Table#"resize.ft.table"
		 */
		_onWindowResize: function (e) {
			var self = e.data.self;
			if (self._resizeTimeout != null) { clearTimeout(self._resizeTimeout); ***REMOVED***
			self._resizeTimeout = setTimeout(function () {
				self._resizeTimeout = null;
				/**
				 * The resize event is raised a short time after window resize operations cease.
				 * @event FooTable.Table#"resize.ft.table"
				 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
				 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
				 */
				self.raise('resize.ft.table').then(function(){
					self.breakpoints.check();
				***REMOVED***);
			***REMOVED***, 300);
		***REMOVED***
	***REMOVED***);

***REMOVED***)(jQuery, FooTable);
(function($, F){

	F.ArrayColumn = F.Column.extend(/** @lends FooTable.ArrayColumn */{
		/**
		 * @summary A column to handle Array values.
		 * @constructs
		 * @extends FooTable.Column
		 * @param {FooTable.Table***REMOVED*** instance -  The parent {@link FooTable.Table***REMOVED*** this column belongs to.
		 * @param {object***REMOVED*** definition - An object containing all the properties to set for the column.
		 */
		construct: function(instance, definition) {
			this._super(instance, definition, 'array');
		***REMOVED***,
		/**
		 * @summary Parses the supplied value or element to retrieve a column value.
		 * @description This is supplied either the cell value or jQuery object to parse. This method will return either the Array containing the values or null.
		 * @instance
		 * @protected
		 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
		 * @returns {(array|null)***REMOVED***
		 */
		parser: function(valueOrElement){
			if (F.is.element(valueOrElement) || F.is.jq(valueOrElement)){ // use jQuery to get the value
				var $el = $(valueOrElement), data = $el.data('value'); // .data() will automatically convert a JSON string to an array
				if (F.is.array(data)) return data;
				data = $el.html();
				try {
					data = JSON.parse(data);
				***REMOVED*** catch(err) {
					data = null;
				***REMOVED***
				return F.is.array(data) ? data : null; // if we have an array return it
			***REMOVED***
			if (F.is.array(valueOrElement)) return valueOrElement; // if we have an array return it
			return null; // otherwise we have no value so return null
		***REMOVED***,
		/**
		 * @summary Formats the column value and creates the HTML seen within a cell.
		 * @description This is supplied the value retrieved from the {@link FooTable.ArrayColumn#parser***REMOVED*** function and must return a string, HTMLElement or jQuery object.
		 * The return value from this function is what is displayed in the cell in the table.
		 * @instance
		 * @protected
		 * @param {?Array***REMOVED*** value - The value to format.
		 * @param {object***REMOVED*** options - The current plugin options.
		 * @param {object***REMOVED*** rowData - An object containing the current row data.
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 */
		formatter: function(value, options, rowData){
			return F.is.array(value) ? JSON.stringify(value) : '';
		***REMOVED***
	***REMOVED***);

	F.columns.register('array', F.ArrayColumn);

***REMOVED***)(jQuery, FooTable);
(function($, F){

	if (F.is.undef(window.moment)){
		// The DateColumn requires moment.js to parse and format date values. Goto http://momentjs.com/ to get it.
		return;
	***REMOVED***

	F.DateColumn = F.Column.extend(/** @lends FooTable.DateColumn */{
		/**
		 * The date column class is used to handle date values. This column is dependent on [moment.js]{@link http://momentjs.com/***REMOVED*** to provide date parsing and formatting functionality.
		 * @constructs
		 * @extends FooTable.Column
		 * @param {FooTable.Table***REMOVED*** instance -  The parent {@link FooTable.Table***REMOVED*** this column belongs to.
		 * @param {object***REMOVED*** definition - An object containing all the properties to set for the column.
		 * @returns {FooTable.DateColumn***REMOVED***
		 */
		construct: function(instance, definition){
			this._super(instance, definition, 'date');
			/**
			 * The format string to use when parsing and formatting dates.
			 * @instance
			 * @type {string***REMOVED***
			 */
			this.formatString = F.is.string(definition.formatString) ? definition.formatString : 'MM-DD-YYYY';
		***REMOVED***,
		/**
		 * This is supplied either the cell value or jQuery object to parse. Any value can be returned from this method and will be provided to the {@link FooTable.DateColumn#format***REMOVED*** function
		 * to generate the cell contents.
		 * @instance
		 * @protected
		 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
		 * @returns {(moment|null)***REMOVED***
		 * @this FooTable.DateColumn
		 */
		parser: function(valueOrElement){
			if (F.is.element(valueOrElement) || F.is.jq(valueOrElement)){
				var data = $(valueOrElement).data('value');
				valueOrElement = F.is.defined(data) ? data : $(valueOrElement).text();
				if (F.is.string(valueOrElement)) valueOrElement = isNaN(valueOrElement) ? valueOrElement : +valueOrElement;
			***REMOVED***
			if (F.is.date(valueOrElement)) return moment(valueOrElement);
			if (F.is.object(valueOrElement) && F.is.boolean(valueOrElement._isAMomentObject)) return valueOrElement;
			if (F.is.string(valueOrElement)){
				// if it looks like a number convert it and do nothing else otherwise create a new moment using the string value and formatString
				if (isNaN(valueOrElement)){
					return moment(valueOrElement, this.formatString);
				***REMOVED*** else {
					valueOrElement = +valueOrElement;
				***REMOVED***
			***REMOVED***
			if (F.is.number(valueOrElement)){
				return moment(valueOrElement);
			***REMOVED***
			return null;
		***REMOVED***,
		/**
		 * This is supplied the value retrieved from the {@link FooTable.DateColumn#parser***REMOVED*** function and must return a string, HTMLElement or jQuery object.
		 * The return value from this function is what is displayed in the cell in the table.
		 * @instance
		 * @protected
		 * @param {****REMOVED*** value - The value to format.
		 * @param {object***REMOVED*** options - The current plugin options.
		 * @param {object***REMOVED*** rowData - An object containing the current row data.
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 * @this FooTable.DateColumn
		 */
		formatter: function(value, options, rowData){
			return F.is.object(value) && F.is.boolean(value._isAMomentObject) && value.isValid() ? value.format(this.formatString) : '';
		***REMOVED***,
		/**
		 * This is supplied either the cell value or jQuery object to parse. A string value must be returned from this method and will be used during filtering operations.
		 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
		 * @returns {string***REMOVED***
		 * @this FooTable.DateColumn
		 */
		filterValue: function(valueOrElement){
			// if we have an element or a jQuery object use jQuery to get the value
			if (F.is.element(valueOrElement) || F.is.jq(valueOrElement)) valueOrElement = $(valueOrElement).data('filterValue') || $(valueOrElement).text();
			// if options are supplied with the value
			if (F.is.hash(valueOrElement) && F.is.hash(valueOrElement.options)){
				if (F.is.string(valueOrElement.options.filterValue)) valueOrElement = valueOrElement.options.filterValue;
				if (F.is.defined(valueOrElement.value)) valueOrElement = valueOrElement.value;
			***REMOVED***
			// if the value is a moment object just return the formatted value
			if (F.is.object(valueOrElement) && F.is.boolean(valueOrElement._isAMomentObject)) return valueOrElement.format(this.formatString);
			// if its a string
			if (F.is.string(valueOrElement)){
				// if its not a number return it
				if (isNaN(valueOrElement)){
					return valueOrElement;
				***REMOVED*** else { // otherwise convert it and carry on
					valueOrElement = +valueOrElement;
				***REMOVED***
			***REMOVED***
			// if the value is a number or date convert to a moment object and return the formatted result.
			if (F.is.number(valueOrElement) || F.is.date(valueOrElement)){
				return moment(valueOrElement).format(this.formatString);
			***REMOVED***
			// try use the native toString of the value if its not undefined or null
			if (F.is.defined(valueOrElement) && valueOrElement != null) return valueOrElement+'';
			return ''; // otherwise we have no value so return an empty string
		***REMOVED***
	***REMOVED***);

	F.columns.register('date', F.DateColumn);

***REMOVED***)(jQuery, FooTable);

(function($, F){

	F.HTMLColumn = F.Column.extend(/** @lends FooTable.HTMLColumn */{
		/**
		 * The HTML column class is used to handle any raw HTML columns.
		 * @constructs
		 * @extends FooTable.Column
		 * @param {FooTable.Table***REMOVED*** instance -  The parent {@link FooTable.Table***REMOVED*** this column belongs to.
		 * @param {object***REMOVED*** definition - An object containing all the properties to set for the column.
		 * @returns {FooTable.HTMLColumn***REMOVED***
		 */
		construct: function(instance, definition){
			this._super(instance, definition, 'html');
		***REMOVED***,
		/**
		 * This is supplied either the cell value or jQuery object to parse. Any value can be returned from this method and will be provided to the {@link FooTable.HTMLColumn#format***REMOVED*** function
		 * to generate the cell contents.
		 * @instance
		 * @protected
		 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
		 * @returns {(jQuery|null)***REMOVED***
		 * @this FooTable.HTMLColumn
		 */
		parser: function(valueOrElement){
			if (F.is.string(valueOrElement)) valueOrElement = $($.trim(valueOrElement));
			if (F.is.element(valueOrElement)) valueOrElement = $(valueOrElement);
			if (F.is.jq(valueOrElement)){
				var tagName = valueOrElement.prop('tagName').toLowerCase();
				if (tagName == 'td' || tagName == 'th'){
					var data = valueOrElement.data('value');
					return F.is.defined(data) ? data : valueOrElement.contents();
				***REMOVED***
				return valueOrElement;
			***REMOVED***
			return null;
		***REMOVED***
	***REMOVED***);

	F.columns.register('html', F.HTMLColumn);

***REMOVED***)(jQuery, FooTable);
(function($, F){

	F.NumberColumn = F.Column.extend(/** @lends FooTable.NumberColumn */{
		/**
		 * The number column class is used to handle simple number columns.
		 * @constructs
		 * @extends FooTable.Column
		 * @param {FooTable.Table***REMOVED*** instance -  The parent {@link FooTable.Table***REMOVED*** this column belongs to.
		 * @param {object***REMOVED*** definition - An object containing all the properties to set for the column.
		 * @returns {FooTable.NumberColumn***REMOVED***
		 */
		construct: function(instance, definition){
			this._super(instance, definition, 'number');
			this.decimalSeparator = F.is.string(definition.decimalSeparator) ? definition.decimalSeparator : '.';
			this.thousandSeparator = F.is.string(definition.thousandSeparator) ? definition.thousandSeparator : ',';
			this.decimalSeparatorRegex = new RegExp(F.str.escapeRegExp(this.decimalSeparator), 'g');
			this.thousandSeparatorRegex = new RegExp(F.str.escapeRegExp(this.thousandSeparator), 'g');
			this.cleanRegex = new RegExp('[^\-0-9' + F.str.escapeRegExp(this.decimalSeparator) + ']', 'g');
		***REMOVED***,
		/**
		 * This is supplied either the cell value or jQuery object to parse. Any value can be returned from this method and will be provided to the {@link FooTable.Column#formatter***REMOVED*** function
		 * to generate the cell contents.
		 * @instance
		 * @protected
		 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
		 * @returns {(number|null)***REMOVED***
		 * @this FooTable.NumberColumn
		 */
		parser: function(valueOrElement){
			if (F.is.element(valueOrElement) || F.is.jq(valueOrElement)){
				var data = $(valueOrElement).data('value');
				valueOrElement = F.is.defined(data) ? data : $(valueOrElement).text().replace(this.cleanRegex, '');
			***REMOVED***
			if (F.is.string(valueOrElement)){
				valueOrElement = valueOrElement.replace(this.thousandSeparatorRegex, '').replace(this.decimalSeparatorRegex, '.');
				valueOrElement = parseFloat(valueOrElement);
			***REMOVED***
			if (F.is.number(valueOrElement)) return valueOrElement;
			return null;
		***REMOVED***,
		/**
		 * This is supplied the value retrieved from the {@link FooTable.NumberColumn#parse***REMOVED*** function and must return a string, HTMLElement or jQuery object.
		 * The return value from this function is what is displayed in the cell in the table.
		 * @instance
		 * @protected
		 * @param {number***REMOVED*** value - The value to format.
		 * @param {object***REMOVED*** options - The current plugin options.
		 * @param {object***REMOVED*** rowData - An object containing the current row data.
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 * @this FooTable.NumberColumn
		 */
		formatter: function(value, options, rowData){
			if (value == null) return '';
			var s = (value + '').split('.');
			if (s.length == 2 && s[0].length > 3) {
				s[0] = s[0].replace(/\B(?=(?:\d{3***REMOVED***)+(?!\d))/g, this.thousandSeparator);
			***REMOVED***
			return s.join(this.decimalSeparator);
		***REMOVED***
	***REMOVED***);

	F.columns.register('number', F.NumberColumn);

***REMOVED***)(jQuery, FooTable);
(function($, F){

	F.ObjectColumn = F.Column.extend(/** @lends FooTable.ObjectColumn */{
		/**
		 * @summary A column to handle Object values.
		 * @constructs
		 * @extends FooTable.Column
		 * @param {FooTable.Table***REMOVED*** instance -  The parent {@link FooTable.Table***REMOVED*** this column belongs to.
		 * @param {object***REMOVED*** definition - An object containing all the properties to set for the column.
		 */
		construct: function(instance, definition) {
			this._super(instance, definition, 'object');
		***REMOVED***,
		/**
		 * @summary Parses the supplied value or element to retrieve a column value.
		 * @description This is supplied either the cell value or jQuery object to parse. This method will return either the Object containing the values or null.
		 * @instance
		 * @protected
		 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
		 * @returns {(object|null)***REMOVED***
		 */
		parser: function(valueOrElement){
			if (F.is.element(valueOrElement) || F.is.jq(valueOrElement)){ // use jQuery to get the value
				var $el = $(valueOrElement), data = $el.data('value'); // .data() will automatically convert a JSON string to an object
				if (F.is.object(data)) return data;
				data = $el.html();
				try {
					data = JSON.parse(data);
				***REMOVED*** catch(err) {
					data = null;
				***REMOVED***
				return F.is.object(data) ? data : null; // if we have an object return it
			***REMOVED***
			if (F.is.object(valueOrElement)) return valueOrElement; // if we have an object return it
			return null; // otherwise we have no value so return null
		***REMOVED***,
		/**
		 * @summary Formats the column value and creates the HTML seen within a cell.
		 * @description This is supplied the value retrieved from the {@link FooTable.ObjectColumn#parser***REMOVED*** function and must return a string, HTMLElement or jQuery object.
		 * The return value from this function is what is displayed in the cell in the table.
		 * @instance
		 * @protected
		 * @param {****REMOVED*** value - The value to format.
		 * @param {object***REMOVED*** options - The current plugin options.
		 * @param {object***REMOVED*** rowData - An object containing the current row data.
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 */
		formatter: function(value, options, rowData){
			return F.is.object(value) ? JSON.stringify(value) : '';
		***REMOVED***
	***REMOVED***);

	F.columns.register('object', F.ObjectColumn);

***REMOVED***)(jQuery, FooTable);
(function($, F){

	F.Breakpoint = F.Class.extend(/** @lends FooTable.Breakpoint */{
		/**
		 * The breakpoint class containing the name and maximum width for the breakpoint.
		 * @constructs
		 * @extends FooTable.Class
		 * @param {string***REMOVED*** name - The name of the breakpoint. Must contain no spaces or special characters.
		 * @param {number***REMOVED*** width - The width of the breakpoint in pixels.
		 * @returns {FooTable.Breakpoint***REMOVED***
		 */
		construct: function(name, width){
			/**
			 * The name of the breakpoint.
			 * @type {string***REMOVED***
			 */
			this.name = name;
			/**
			 * The maximum width of the breakpoint in pixels.
			 * @type {number***REMOVED***
			 */
			this.width = width;
		***REMOVED***
	***REMOVED***);

***REMOVED***)(jQuery, FooTable);
(function($, F){
	F.Breakpoints = F.Component.extend(/** @lends FooTable.Breakpoints */{
		/**
		 * Contains the logic to calculate and apply breakpoints for the plugin.
		 * @constructs
		 * @extends FooTable.Component
		 * @param {FooTable.Table***REMOVED*** table -  The parent {@link FooTable.Table***REMOVED*** this component belongs to.
		 * @returns {FooTable.Breakpoints***REMOVED***
		 */
		construct: function(table){
			// call the base class constructor
			this._super(table, true);

			/* PROTECTED */
			/**
			 * This provides a shortcut to the {@link FooTable.Table#options***REMOVED*** object.
			 * @protected
			 * @type {FooTable.Table#options***REMOVED***
			 */
			this.o = table.o;

			/* PUBLIC */
			/**
			 * The current breakpoint.
			 * @type {FooTable.Breakpoint***REMOVED***
			 */
			this.current = null;
			/**
			 * An array of {@link FooTable.Breakpoint***REMOVED*** objects created from parsing the options.
			 * @type {Array.<FooTable.Breakpoint>***REMOVED***
			 */
			this.array = [];
			/**
			 * Whether or not breakpoints cascade. When set to true all breakpoints larger than the current will be hidden along with it.
			 * @type {boolean***REMOVED***
			 */
			this.cascade = this.o.cascade;
			/**
			 * Whether or not to calculate breakpoints on the width of the parent element rather than the viewport.
			 * @type {boolean***REMOVED***
			 */
			this.useParentWidth = this.o.useParentWidth;
			/**
			 * This value is updated each time the current breakpoint changes and contains a space delimited string of the names of the current breakpoint and all those smaller than it.
			 * @type {string***REMOVED***
			 */
			this.hidden = null;

			/* PRIVATE */
			/**
			 * This value is set once when the {@link FooTable.Breakpoints#array***REMOVED*** is generated and contains a space delimited string of all the breakpoint class names.
			 * @type {string***REMOVED***
			 * @private
			 */
			this._classNames = '';

			// check if a function was supplied to override the default getWidth
			this.getWidth = F.checkFnValue(this, this.o.getWidth, this.getWidth);
		***REMOVED***,

		/* PROTECTED */
		/**
		 * Checks the supplied data and options for the breakpoints component.
		 * @instance
		 * @protected
		 * @param {object***REMOVED*** data - The jQuery data object from the parent table.
		 * @fires FooTable.Breakpoints#"preinit.ft.breakpoints"
		 */
		preinit: function(data){
			var self = this;
			/**
			 * The preinit.ft.breakpoints event is raised before any UI is created and provides the tables jQuery data object for additional options parsing.
			 * Calling preventDefault on this event will disable the entire plugin.
			 * @event FooTable.Breakpoints#"preinit.ft.breakpoints"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {object***REMOVED*** data - The jQuery data object of the table raising the event.
			 */
			return this.ft.raise('preinit.ft.breakpoints', [data]).then(function(){
				self.cascade = F.is.boolean(data.cascade) ? data.cascade : self.cascade;
				self.o.breakpoints = F.is.hash(data.breakpoints) ? data.breakpoints : self.o.breakpoints;
				self.getWidth = F.checkFnValue(self, data.getWidth, self.getWidth);
				if (self.o.breakpoints == null) self.o.breakpoints = { "xs": 480, "sm": 768, "md": 992, "lg": 1200 ***REMOVED***;
				// Create a nice friendly array to work with out of the breakpoints object.
				for (var name in self.o.breakpoints) {
					if (!self.o.breakpoints.hasOwnProperty(name)) continue;
					self.array.push(new F.Breakpoint(name, self.o.breakpoints[name]));
					self._classNames += 'breakpoint-' + name + ' ';
				***REMOVED***
				// Sort the breakpoints so the largest is checked first
				self.array.sort(function (a, b) {
					return b.width - a.width;
				***REMOVED***);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Initializes the class parsing the options into a sorted array of {@link FooTable.Breakpoint***REMOVED*** objects.
		 * @instance
		 * @protected
		 * @fires FooTable.Breakpoints#"init.ft.breakpoints"
		 */
		init: function(){
			var self = this;
			/**
			 * The init.ft.breakpoints event is raised before any UI is generated.
			 * Calling preventDefault on this event will disable the entire plugin.
			 * @event FooTable.Breakpoints#"init.ft.breakpoints"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			return this.ft.raise('init.ft.breakpoints').then(function(){
				self.current = self.get();
			***REMOVED***);
		***REMOVED***,
		/**
		 * Whenever the table is drawn this ensures the correct breakpoint class is applied to the table.
		 * @instance
		 * @protected
		 */
		draw: function(){
			this.ft.$el.removeClass(this._classNames).addClass('breakpoint-' + this.current.name);
		***REMOVED***,

		/* PUBLIC */
		/**
		 * Calculates the current breakpoint from the {@link FooTable.Breakpoints#array***REMOVED*** and sets the {@link FooTable.Breakpoints#current***REMOVED*** property.
		 * @instance
		 * @returns {FooTable.Breakpoint***REMOVED***
		 */
		calculate: function(){
			var self = this, current = null, hidden = [], breakpoint, prev = null, width = self.getWidth();
			for (var i = 0, len = self.array.length; i < len; i++) {
				breakpoint = self.array[i];
				// if the width is smaller than the smallest breakpoint set the smallest as the current.
				// if the width is larger than the largest breakpoint set the largest as the current.
				// otherwise if the width is somewhere in between check all breakpoints testing if the width
				// is greater than the current but smaller than the previous.
				if ((!current && i == len -1)
					|| (width >= breakpoint.width && (prev instanceof F.Breakpoint ? width < prev.width : true))) {
					current = breakpoint;
				***REMOVED***
				if (!current) hidden.push(breakpoint.name);
				prev = breakpoint;
			***REMOVED***
			hidden.push(current.name);
			self.hidden = hidden.join(' ');
			return current;
		***REMOVED***,
		/**
		 * Supplied a columns breakpoints this returns a boolean value indicating whether or not the column is visible.
		 * @param {string***REMOVED*** breakpoints - A space separated string of breakpoint names.
		 * @returns {boolean***REMOVED***
		 */
		visible: function(breakpoints){
			if (F.is.emptyString(breakpoints)) return true;
			if (breakpoints === 'all') return false;
			var parts = breakpoints.split(' '), i = 0, len = parts.length;
			for (; i < len; i++){
				if (this.cascade ? F.str.containsWord(this.hidden, parts[i]) : parts[i] == this.current.name) return false;
			***REMOVED***
			return true;
		***REMOVED***,
		/**
		 * Performs a check between the current breakpoint and the previous breakpoint and performs a redraw if they differ.
		 * @instance
		 * @fires FooTable.Breakpoints#"before.ft.breakpoints"
		 * @fires FooTable.Breakpoints#"after.ft.breakpoints"
		 */
		check: function(){
			var self = this, bp = self.get();
			if (!(bp instanceof F.Breakpoint)
				|| bp == self.current)
				return;

			/**
			 * The before.ft.breakpoints event is raised if the breakpoint has changed but before the UI is redrawn and is supplied both the current breakpoint
			 * and the next "new" one that is about to be applied.
			 * Calling preventDefault on this event will prevent the next breakpoint from being applied.
			 * @event FooTable.Breakpoints#"before.ft.breakpoints"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {FooTable.Breakpoint***REMOVED*** current - The current breakpoint.
			 * @param {FooTable.Breakpoint***REMOVED*** next - The breakpoint that is about to be applied.
			 */
			self.ft.raise('before.ft.breakpoints', [self.current, bp]).then(function(){
				var previous = self.current;
				self.current = bp;
				return self.ft.draw().then(function(){
					/**
					 * The after.ft.breakpoints event is raised after the breakpoint has changed and the UI is redrawn and is supplied both the "new" current breakpoint
					 * and the previous one that was replaced.
					 * @event FooTable.Breakpoints#"after.ft.breakpoints"
					 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
					 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
					 * @param {FooTable.Breakpoint***REMOVED*** current - The current breakpoint.
					 * @param {FooTable.Breakpoint***REMOVED*** previous - The breakpoint that was just replaced.
					 */
					self.ft.raise('after.ft.breakpoints', [self.current, previous]);
				***REMOVED***);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Attempts to return a {@link FooTable.Breakpoint***REMOVED*** instance when passed a {@link FooTable.Breakpoint***REMOVED***,
		 * the {@link FooTable.Breakpoint#name***REMOVED*** string or if nothing is supplied the current breakpoint.
		 * @instance
		 * @param {(FooTable.Breakpoint|string|number)***REMOVED*** [breakpoint] - The breakpoint to retrieve.
		 * @returns {FooTable.Breakpoint***REMOVED***
		 */
		get: function(breakpoint){
			if (F.is.undef(breakpoint)) return this.calculate();
			if (breakpoint instanceof F.Breakpoint) return breakpoint;
			if (F.is.string(breakpoint)) return F.arr.first(this.array, function (bp) { return bp.name == breakpoint; ***REMOVED***);
			if (F.is.number(breakpoint)) return breakpoint >= 0 && breakpoint < this.array.length ? this.array[breakpoint] : null;
			return null;
		***REMOVED***,
		/**
		 * Gets the width used to determine breakpoints whether it be from the viewport, parent or a custom function.
		 * @instance
		 * @returns {number***REMOVED***
		 */
		getWidth: function(){
			if (F.is.fn(this.o.getWidth)) return this.o.getWidth(this.ft);
			if (this.useParentWidth == true) return this.getParentWidth();
			return this.getViewportWidth();
		***REMOVED***,
		/**
		 * Gets the tables direct parents width.
		 * @instance
		 * @returns {number***REMOVED***
		 */
		getParentWidth: function(){
			return this.ft.$el.parent().width();
		***REMOVED***,
		/**
		 * Gets the current viewport width.
		 * @instance
		 * @returns {number***REMOVED***
		 */
		getViewportWidth: function(){
			return Math.max(document.documentElement.clientWidth, window.innerWidth, 0);
		***REMOVED***
	***REMOVED***);

	F.components.register('breakpoints', F.Breakpoints, 1000);

***REMOVED***)(jQuery, FooTable);
(function(F){
	/**
	 * A space delimited string of breakpoint names that specify when the column will be hidden. You can also specify "all" to make a column permanently display in an expandable detail row.
	 * @type {string***REMOVED***
	 * @default null
	 * @example <caption>The below shows how this value would be set</caption>
	 * breakpoints: "md"
	 */
	F.Column.prototype.breakpoints = null;

	F.Column.prototype.__breakpoints_define__ = function(definition){
		this.breakpoints = F.is.emptyString(definition.breakpoints) ? null : definition.breakpoints;
	***REMOVED***;

	F.Column.extend('define', function(definition){
		this._super(definition);
		this.__breakpoints_define__(definition);
	***REMOVED***);
***REMOVED***)(FooTable);
(function(F){
	/**
	 * An object containing the breakpoints for the plugin.
	 * @type {object.<string, number>***REMOVED***
	 * @default { "xs": 480, "sm": 768, "md": 992, "lg": 1200 ***REMOVED***
	 */
	F.Defaults.prototype.breakpoints = null;

	/**
	 * Whether or not breakpoints cascade. When set to true all breakpoints larger than the current will also be hidden along with it.
	 * @type {boolean***REMOVED***
	 * @default false
	 */
	F.Defaults.prototype.cascade = false;

	/**
	 * Whether or not to calculate breakpoints on the width of the parent element rather than the viewport.
	 * @type {boolean***REMOVED***
	 * @default false
	 */
	F.Defaults.prototype.useParentWidth = false;

	/**
	 * A function used to override the default getWidth function with a custom one.
	 * @type {function***REMOVED***
	 * @default null
	 * @example <caption>The below shows what the default getWidth function would look like.</caption>
	 * getWidth: function(instance){
	 * 	if (instance.o.useParentWidth == true) return instance.$el.parent().width();
	 * 	return instance.breakpoints.getViewportWidth();
	 * ***REMOVED***
	 */
	F.Defaults.prototype.getWidth = null;
***REMOVED***)(FooTable);
(function($, F){
	F.Columns = F.Component.extend(/** @lends FooTable.Columns */{
		/**
		 * The columns class contains all the logic for handling columns.
		 * @constructs
		 * @extends FooTable.Component
		 * @param {FooTable.Table***REMOVED*** table -  The parent {@link FooTable.Table***REMOVED*** this component belongs to.
		 * @returns {FooTable.Columns***REMOVED***
		 */
		construct: function(table){
			// call the base class constructor
			this._super(table, true);

			/* PROTECTED */
			/**
			 * This provides a shortcut to the {@link FooTable.Table#options***REMOVED*** object.
			 * @protected
			 * @type {FooTable.Table#options***REMOVED***
			 */
			this.o = table.o;

			/* PUBLIC */
			/**
			 * An array of {@link FooTable.Column***REMOVED*** objects created from parsing the options and/or DOM.
			 * @type {Array.<FooTable.Column>***REMOVED***
			 */
			this.array = [];
			/**
			 * The jQuery header row object.
			 * @type {jQuery***REMOVED***
			 */
			this.$header = null;
			/**
			 * Whether or not to display the header row.
			 * @type {boolean***REMOVED***
			 */
			this.showHeader = table.o.showHeader;

			this._fromHTML = F.is.emptyArray(table.o.columns) && !F.is.promise(table.o.columns);
		***REMOVED***,

		/* PROTECTED */
		/**
		 * This parses the columns from either the tables rows or the supplied options.
		 * @instance
		 * @protected
		 * @param {object***REMOVED*** data - The tables jQuery data object.
		 * @returns {jQuery.Promise***REMOVED***
		 * @this FooTable.Columns
		 */
		parse: function(data){
			var self = this;
			return $.Deferred(function(d){
				function merge(cols1, cols2){
					var merged = [];
					// check if either of the arrays is empty as it can save us having to merge them by index.
					if (cols1.length == 0 || cols2.length == 0){
						merged = cols1.concat(cols2);
					***REMOVED*** else {
						// at this point we have two arrays of column definitions, we now need to merge them based on there index properties
						// first figure out the highest column index provided so we can loop that many times to merge all columns and provide
						// defaults where nothing was specified (fill in the gaps in the array as it were).
						var highest = 0;
						F.arr.each(cols1.concat(cols2), function(c){
							if (c.index > highest) highest = c.index;
						***REMOVED***);
						highest++;
						for (var i = 0, cols1_c, cols2_c; i < highest; i++){
							cols1_c = {***REMOVED***;
							F.arr.each(cols1, function(c){
								if (c.index == i){
									cols1_c = c;
									return false;
								***REMOVED***
							***REMOVED***);
							cols2_c = {***REMOVED***;
							F.arr.each(cols2, function(c){
								if (c.index == i){
									cols2_c = c;
									return false;
								***REMOVED***
							***REMOVED***);
							merged.push($.extend(true, {***REMOVED***, cols1_c, cols2_c));
						***REMOVED***
					***REMOVED***
					return merged;
				***REMOVED***

				var json = [], html = [];
				// get the column options from the content
				var $header = self.ft.$el.find('tr.footable-header, thead > tr:last:has([data-breakpoints]), tbody > tr:first:has([data-breakpoints]), thead > tr:last, tbody > tr:first').first(), $cell, cdata;
				if ($header.length > 0){
					var virtual = $header.parent().is('tbody') && $header.children().length == $header.children('td').length;
					if (!virtual) self.$header = $header.addClass('footable-header');
					$header.children('td,th').each(function(i, cell){
						$cell = $(cell);
						cdata = $cell.data();
						cdata.index = i;
						cdata.$el = $cell;
						cdata.virtual = virtual;
						html.push(cdata);
					***REMOVED***);
					if (virtual) self.showHeader = false;
				***REMOVED***
				// get the supplied column options
				if (F.is.array(self.o.columns) && !F.is.emptyArray(self.o.columns)){
					F.arr.each(self.o.columns, function(c, i){
						c.index = i;
						json.push(c);
					***REMOVED***);
					self.parseFinalize(d, merge(json, html));
				***REMOVED*** else if (F.is.promise(self.o.columns)){
					self.o.columns.then(function(cols){
						F.arr.each(cols, function(c, i){
							c.index = i;
							json.push(c);
						***REMOVED***);
						self.parseFinalize(d, merge(json, html));
					***REMOVED***, function(xhr){
						d.reject(Error('Columns ajax request error: ' + xhr.status + ' (' + xhr.statusText + ')'));
					***REMOVED***);
				***REMOVED*** else {
					self.parseFinalize(d, merge(json, html));
				***REMOVED***
			***REMOVED***);
		***REMOVED***,
		/**
		 * Used to finalize the parsing of columns it is supplied the parse deferred object which must be resolved with an array of {@link FooTable.Column***REMOVED*** objects
		 * or rejected with an error.
		 * @instance
		 * @protected
		 * @param {jQuery.Deferred***REMOVED*** deferred - The deferred object used for parsing.
		 * @param {Array.<object>***REMOVED*** cols - An array of all merged column definitions.
		 */
		parseFinalize: function(deferred, cols){
			// we now have a merged array of all column definitions supplied to the plugin, time to make the objects.
			var self = this, columns = [], column;
			F.arr.each(cols, function(def){
				// if we have a column registered using the definition type then create an instance of that column otherwise just create a default text column.
				if (column = F.columns.contains(def.type) ? F.columns.make(def.type, self.ft, def) : new F.Column(self.ft, def))
					columns.push(column);
			***REMOVED***);
			if (F.is.emptyArray(columns)){
				deferred.reject(Error("No columns supplied."));
			***REMOVED*** else {
				// make sure to sort by the column index as the merge process may have mixed them up
				columns.sort(function(a, b){ return a.index - b.index; ***REMOVED***);
				deferred.resolve(columns);
			***REMOVED***
		***REMOVED***,
		/**
		 * The columns preinit method is used to parse and check the column options supplied from both static content and through the constructor.
		 * @instance
		 * @protected
		 * @param {object***REMOVED*** data - The jQuery data object from the root table element.
		 * @this FooTable.Columns
		 */
		preinit: function(data){
			var self = this;
			/**
			 * The preinit.ft.columns event is raised before any UI is created and provides the tables jQuery data object for additional options parsing.
			 * Calling preventDefault on this event will disable the entire plugin.
			 * @event FooTable.Columns#"preinit.ft.columns"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {object***REMOVED*** data - The jQuery data object of the table raising the event.
			 */
			return self.ft.raise('preinit.ft.columns', [data]).then(function(){
				return self.parse(data).then(function(columns){
					self.array = columns;
					self.showHeader = F.is.boolean(data.showHeader) ? data.showHeader : self.showHeader;
				***REMOVED***);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Initializes the columns creating the table header if required.
		 * @instance
		 * @protected
		 * @fires FooTable.Columns#"init.ft.columns"
		 * @this FooTable.Columns
		 */
		init: function(){
			var self = this;
			/**
			 * The init.ft.columns event is raised after the header row is created/parsed for column data.
			 * @event FooTable.Columns#"init.ft.columns"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** instance - The instance of the plugin raising the event.
			 * @param {Array.<FooTable.Column>***REMOVED*** columns - The array of {@link FooTable.Column***REMOVED*** objects parsed from the options and/or DOM.
			 */
			return this.ft.raise('init.ft.columns', [ self.array ]).then(function(){
				self.$create();
			***REMOVED***);
		***REMOVED***,
		/**
		 * Destroys the columns component removing any UI generated from the table.
		 * @instance
		 * @protected
		 * @fires FooTable.Columns#"destroy.ft.columns"
		 */
		destroy: function(){
			/**
			 * The destroy.ft.columns event is raised before its UI is removed.
			 * Calling preventDefault on this event will prevent the component from being destroyed.
			 * @event FooTable.Columns#"destroy.ft.columns"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			var self = this;
			this.ft.raise('destroy.ft.columns').then(function(){
				if (!self._fromHTML) self.$header.remove();
			***REMOVED***);
		***REMOVED***,
		/**
		 * The predraw method called from within the {@link FooTable.Table#draw***REMOVED*** method.
		 * @instance
		 * @protected
		 * @this FooTable.Columns
		 */
		predraw: function(){
			var self = this, first = true;
			self.visibleColspan = 0;
			self.firstVisibleIndex = 0;
			self.lastVisibleIndex = 0;
			self.hasHidden = false;
			F.arr.each(self.array, function(col){
				col.hidden = !self.ft.breakpoints.visible(col.breakpoints);
				if (!col.hidden && col.visible){
					if (first){
						self.firstVisibleIndex = col.index;
						first = false;
					***REMOVED***
					self.lastVisibleIndex = col.index;
					self.visibleColspan++;
				***REMOVED***
				if (col.hidden) self.hasHidden = true;
			***REMOVED***);
			self.ft.$el.toggleClass('breakpoint', self.hasHidden);
		***REMOVED***,
		/**
		 * Performs the actual drawing of the columns, hiding or displaying them depending on there breakpoints.
		 * @instance
		 * @protected
		 * @this FooTable.Columns
		 */
		draw: function(){
			F.arr.each(this.array, function(col){
				col.$el.css('display', (col.hidden || !col.visible  ? 'none' : 'table-cell'));
			***REMOVED***);
			if (!this.showHeader && F.is.jq(this.$header.parent())){
				this.$header.detach();
			***REMOVED***
		***REMOVED***,
		/**
		 * Creates the header row for the table from the parsed column definitions.
		 * @instance
		 * @protected
		 * @this FooTable.Columns
		 */
		$create: function(){
			var self = this;
			self.$header = F.is.jq(self.$header) ? self.$header : $('<tr/>', {'class': 'footable-header'***REMOVED***);
			self.$header.children('th,td').detach();
			F.arr.each(self.array, function(col){
				self.$header.append(col.$el);
			***REMOVED***);
			if (self.showHeader && !F.is.jq(self.$header.parent())){
				self.ft.$el.children('thead').append(self.$header);
			***REMOVED***
		***REMOVED***,
		/**
		 * Attempts to return a {@link FooTable.Column***REMOVED*** instance when passed the {@link FooTable.Column***REMOVED*** instance, the {@link FooTable.Column#name***REMOVED*** string or the {@link FooTable.Column#index***REMOVED*** number.
		 * If supplied a function this will return an array by iterating all columns passing the index and column itself to the supplied callback as arguments.
		 * Returning true in the callback will include the column in the result.
		 * @instance
		 * @param {(FooTable.Column|string|number|function)***REMOVED*** column - The column to retrieve.
		 * @returns {(Array.<FooTable.Column>|FooTable.Column|null)***REMOVED*** The column if one is found otherwise it returns NULL.
		 * @example <caption>This example shows retrieving a column by name assuming a column called "id" exists. The <code>columns</code> object is an instance of {@link FooTable.Columns***REMOVED***.</caption>
		 * var column = columns.get('id');
		 * if (column instanceof FooTable.Column){
		 * 	// found the "id" column
		 * ***REMOVED*** else {
		 * 	// no column with a name of "id" exists
		 * ***REMOVED***
		 * // to get an array of all hidden columns
		 * var columns = columns.get(function(col){
		 *  return col.hidden;
		 * ***REMOVED***);
		 */
		get: function(column){
			if (column instanceof F.Column) return column;
			if (F.is.string(column)) return F.arr.first(this.array, function (col) { return col.name == column; ***REMOVED***);
			if (F.is.number(column)) return F.arr.first(this.array, function (col) { return col.index == column; ***REMOVED***);
			if (F.is.fn(column)) return F.arr.get(this.array, column);
			return null;
		***REMOVED***,
		/**
		 * Takes an array of column names, index's or actual {@link FooTable.Column***REMOVED*** and ensures that an array of only {@link FooTable.Column***REMOVED*** is returned.
		 * @instance
		 * @param {(Array.<string>|Array.<number>|Array.<FooTable.Column>)***REMOVED*** columns - The array of column names, index's or {@link FooTable.Column***REMOVED*** to check.
		 * @returns {Array.<FooTable.Column>***REMOVED***
		 */
		ensure: function(columns){
			var self = this, result = [];
			if (!F.is.array(columns)) return result;
			F.arr.each(columns, function(name){
				result.push(self.get(name));
			***REMOVED***);
			return result;
		***REMOVED***
	***REMOVED***);

	F.components.register('columns', F.Columns, 900);

***REMOVED***)(jQuery, FooTable);
(function(F){
	/**
	 * An array containing the column options or a jQuery promise that resolves returning the columns. The index of the definitions must match the index of each column as it should appear in the table. For more information on the options available see the {@link FooTable.Column***REMOVED*** object.
	 * @type {(Array.<object>|jQuery.Promise)***REMOVED***
	 * @default []
	 * @example <caption>The below shows column definitions for a row defined as <code>{ id: Number, name: String, age: Number ***REMOVED***</code>. The ID column has a fixed width, the table is initially sorted on the Name column and the Age column will be hidden on phones.</caption>
	 * columns: [
	 * 	{ name: 'id', title: 'ID', type: 'number' ***REMOVED***,
	 *	{ name: 'name', title: 'Name', sorted: true, direction: 'ASC' ***REMOVED***
	 *	{ name: 'age', title: 'Age', type: 'number', breakpoints: 'xs' ***REMOVED***
	 * ]
	 */
	F.Defaults.prototype.columns = [];

	/**
	 * Specifies whether or not the column headers should be displayed.
	 * @type {boolean***REMOVED***
	 * @default true
	 */
	F.Defaults.prototype.showHeader = true;
***REMOVED***)(FooTable);
(function ($, F) {
	F.Rows = F.Component.extend(/** @lends FooTable.Rows */{
		/**
		 * The rows class contains all the logic for handling rows.
		 * @constructs
		 * @extends FooTable.Component
		 * @param {FooTable.Table***REMOVED*** table -  The parent {@link FooTable.Table***REMOVED*** this component belongs to.
		 * @returns {FooTable.Rows***REMOVED***
		 */
		construct: function (table) {
			// call the base class constructor
			this._super(table, true);

			/**
			 * This provides a shortcut to the {@link FooTable.Table#options***REMOVED*** object.
			 * @instance
			 * @protected
			 * @type {FooTable.Table#options***REMOVED***
			 */
			this.o = table.o;
			/**
			 * The current working array of {@link FooTable.Row***REMOVED*** objects.
			 * @instance
			 * @protected
			 * @type {Array.<FooTable.Row>***REMOVED***
			 * @default []
			 */
			this.array = [];
			/**
			 * The base array of rows parsed from either the DOM or the constructor options.
			 * The {@link FooTable.Rows#current***REMOVED*** member is populated with a shallow clone of this array
			 * during the predraw operation before any core or custom components are executed.
			 * @instance
			 * @protected
			 * @type {Array.<FooTable.Row>***REMOVED***
			 * @default []
			 */
			this.all = [];
			/**
			 * Whether or not to display a toggle in each row when it contains hidden columns.
			 * @type {boolean***REMOVED***
			 * @default true
			 */
			this.showToggle = table.o.showToggle;
			/**
			 * The CSS selector used to filter row click events. If the event.target property matches the selector the row will be toggled.
			 * @type {string***REMOVED***
			 * @default "tr,td,.footable-toggle"
			 */
			this.toggleSelector = table.o.toggleSelector;
			/**
			 * Specifies which column the row toggle is appended to. Supports only two values; "first" and "last"
			 * @type {string***REMOVED***
			 */
			this.toggleColumn = table.o.toggleColumn;
			/**
			 * The text to display when the table has no rows.
			 * @type {string***REMOVED***
			 */
			this.emptyString = table.o.empty;
			/**
			 * Whether or not the first rows details are expanded by default when displayed on a device that hides any columns.
			 * @type {boolean***REMOVED***
			 */
			this.expandFirst = table.o.expandFirst;
			/**
			 * Whether or not all row details are expanded by default when displayed on a device that hides any columns.
			 * @type {boolean***REMOVED***
			 */
			this.expandAll = table.o.expandAll;
			/**
			 * The jQuery object that contains the empty row control.
			 * @type {jQuery***REMOVED***
			 */
			this.$empty = null;
			this._fromHTML = F.is.emptyArray(table.o.rows) && !F.is.promise(table.o.rows);
		***REMOVED***,
		/**
		 * This parses the rows from either the tables rows or the supplied options.
		 * @instance
		 * @protected
		 * @returns {jQuery.Promise***REMOVED***
		 */
		parse: function(){
			var self = this;
			return $.Deferred(function(d){
				var $rows = self.ft.$el.children('tbody').children('tr');
				if (F.is.array(self.o.rows) && self.o.rows.length > 0){
					self.parseFinalize(d, self.o.rows);
				***REMOVED*** else if (F.is.promise(self.o.rows)){
					self.o.rows.then(function(rows){
						self.parseFinalize(d, rows);
					***REMOVED***, function(xhr){
						d.reject(Error('Rows ajax request error: ' + xhr.status + ' (' + xhr.statusText + ')'));
					***REMOVED***);
				***REMOVED*** else if (F.is.jq($rows)){
					self.parseFinalize(d, $rows);
					$rows.detach();
				***REMOVED*** else {
					self.parseFinalize(d, []);
				***REMOVED***
			***REMOVED***);
		***REMOVED***,
		/**
		 * Used to finalize the parsing of rows it is supplied the parse deferred object which must be resolved with an array of {@link FooTable.Row***REMOVED*** objects
		 * or rejected with an error.
		 * @instance
		 * @protected
		 * @param {jQuery.Deferred***REMOVED*** deferred - The deferred object used for parsing.
		 * @param {(Array.<object>|jQuery)***REMOVED*** rows - An array of row values and options or the jQuery object containing all rows.
		 */
		parseFinalize: function(deferred, rows){
			var self = this, result = $.map(rows, function(r){
				return new F.Row(self.ft, self.ft.columns.array, r);
			***REMOVED***);
			deferred.resolve(result);
		***REMOVED***,
		/**
		 * The columns preinit method is used to parse and check the column options supplied from both static content and through the constructor.
		 * @instance
		 * @protected
		 * @param {object***REMOVED*** data - The jQuery data object from the root table element.
		 * @fires FooTable.Rows#"preinit.ft.rows"
		 */
		preinit: function(data){
			var self = this;
			/**
			 * The preinit.ft.rows event is raised before any UI is created and provides the tables jQuery data object for additional options parsing.
			 * Calling preventDefault on this event will disable the entire plugin.
			 * @event FooTable.Rows#"preinit.ft.rows"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {object***REMOVED*** data - The jQuery data object of the table raising the event.
			 */
			return self.ft.raise('preinit.ft.rows', [data]).then(function(){
				return self.parse().then(function(rows){
					self.all = rows;
					self.array = self.all.slice(0);
					self.showToggle = F.is.boolean(data.showToggle) ? data.showToggle : self.showToggle;
					self.toggleSelector = F.is.string(data.toggleSelector) ? data.toggleSelector : self.toggleSelector;
					self.toggleColumn = F.is.string(data.toggleColumn) ? data.toggleColumn : self.toggleColumn;
					if (self.toggleColumn != "first" && self.toggleColumn != "last") self.toggleColumn = "first";
					self.emptyString = F.is.string(data.empty) ? data.empty : self.emptyString;
					self.expandFirst = F.is.boolean(data.expandFirst) ? data.expandFirst : self.expandFirst;
					self.expandAll = F.is.boolean(data.expandAll) ? data.expandAll : self.expandAll;
				***REMOVED***);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Initializes the rows class using the supplied table and options.
		 * @instance
		 * @protected
		 * @fires FooTable.Rows#"init.ft.rows"
		 */
		init: function () {
			var self = this;
			/**
			 * The init.ft.rows event is raised after the the rows are parsed from either the DOM or the options.
			 * Calling preventDefault on this event will disable the entire plugin.
			 * @event FooTable.Rows#"init.ft.rows"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** instance - The instance of the plugin raising the event.
			 * @param {Array.<FooTable.Row>***REMOVED*** rows - The array of {@link FooTable.Row***REMOVED*** objects parsed from the DOM or the options.
			 */
			return self.ft.raise('init.ft.rows', [self.all]).then(function(){
				self.$create();
			***REMOVED***);
		***REMOVED***,
		/**
		 * Destroys the rows component removing any UI generated from the table.
		 * @instance
		 * @protected
		 * @fires FooTable.Rows#"destroy.ft.rows"
		 */
		destroy: function(){
			/**
			 * The destroy.ft.rows event is raised before its UI is removed.
			 * Calling preventDefault on this event will prevent the component from being destroyed.
			 * @event FooTable.Rows#"destroy.ft.rows"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			var self = this;
			this.ft.raise('destroy.ft.rows').then(function(){
				F.arr.each(self.array, function(row){
					row.predraw(!self._fromHTML);
				***REMOVED***);
				self.all = self.array = [];
			***REMOVED***);
		***REMOVED***,
		/**
		 * Performs the predraw operations that are required including creating the shallow clone of the {@link FooTable.Rows#array***REMOVED*** to work with.
		 * @instance
		 * @protected
		 */
		predraw: function(){
			F.arr.each(this.array, function(row){
				row.predraw();
			***REMOVED***);
			this.array = this.all.slice(0);
		***REMOVED***,
		$create: function(){
			this.$empty = $('<tr/>', { 'class': 'footable-empty' ***REMOVED***).append($('<td/>').text(this.emptyString));
		***REMOVED***,
		/**
		 * Performs the actual drawing of the table rows.
		 * @instance
		 * @protected
		 */
		draw: function(){
			var self = this, $tbody = self.ft.$el.children('tbody'), first = true;
			// if we have rows
			if (self.array.length > 0){
				self.$empty.detach();
				// loop through them appending to the tbody and then drawing
				F.arr.each(self.array, function(row){
					if ((self.expandFirst && first) || self.expandAll){
						row.expanded = true;
						first = false;
					***REMOVED***
					row.draw($tbody);
				***REMOVED***);
			***REMOVED*** else {
				// otherwise display the $empty row
				self.$empty.children('td').attr('colspan', self.ft.columns.visibleColspan);
				$tbody.append(self.$empty);
			***REMOVED***
		***REMOVED***,
		/**
		 * Loads a JSON array of row objects into the table
		 * @instance
		 * @param {Array.<object>***REMOVED*** data - An array of row objects to load.
		 * @param {boolean***REMOVED*** [append=false] - Whether or not to append the new rows to the current rows array or to replace them entirely.
		 */
		load: function(data, append){
			var self = this, rows = $.map(data, function(r){
				return new F.Row(self.ft, self.ft.columns.array, r);
			***REMOVED***);
			F.arr.each(this.array, function(row){
				row.predraw();
			***REMOVED***);
			this.all = (F.is.boolean(append) ? append : false) ? this.all.concat(rows) : rows;
			this.array = this.all.slice(0);
			this.ft.draw();
		***REMOVED***,
		/**
		 * Expands all visible rows.
		 * @instance
		 */
		expand: function(){
			F.arr.each(this.array, function(row){
				row.expand();
			***REMOVED***);
		***REMOVED***,
		/**
		 * Collapses all visible rows.
		 * @instance
		 */
		collapse: function(){
			F.arr.each(this.array, function(row){
				row.collapse();
			***REMOVED***);
		***REMOVED***
	***REMOVED***);

	F.components.register('rows', F.Rows, 800);

***REMOVED***)(jQuery, FooTable);
(function(F){
	/**
	 * An array of JSON objects containing the row data or a jQuery promise that resolves returning the row data.
	 * @type {(Array.<object>|jQuery.Promise)***REMOVED***
	 * @default []
	 */
	F.Defaults.prototype.rows = [];

	/**
	 * A string to display when there are no rows in the table.
	 * @type {string***REMOVED***
	 * @default "No results"
	 */
	F.Defaults.prototype.empty = 'No results';

	/**
	 * Whether or not the toggle is appended to each row.
	 * @type {boolean***REMOVED***
	 * @default true
	 */
	F.Defaults.prototype.showToggle = true;

	/**
	 * The CSS selector used to filter row click events. If the event.target property matches the selector the row will be toggled.
	 * @type {string***REMOVED***
	 * @default "tr,td,.footable-toggle"
	 */
	F.Defaults.prototype.toggleSelector = 'tr,td,.footable-toggle';

	/**
	 * Specifies which column to display the row toggle in. The only supported values are "first" or "last".
	 * @type {string***REMOVED***
	 * @default "first"
	 */
	F.Defaults.prototype.toggleColumn = 'first';

	/**
	 * Whether or not the first rows details are expanded by default when displayed on a device that hides any columns.
	 * @type {boolean***REMOVED***
	 */
	F.Defaults.prototype.expandFirst = false;

	/**
	 * Whether or not all row details are expanded by default when displayed on a device that hides any columns.
	 * @type {boolean***REMOVED***
	 */
	F.Defaults.prototype.expandAll = false;
***REMOVED***)(FooTable);
(function(F){
	/**
	 * Loads a JSON array of row objects into the table
	 * @param {Array.<object>***REMOVED*** data - An array of row objects to load.
	 * @param {boolean***REMOVED*** [append=false] - Whether or not to append the new rows to the current rows array or to replace them entirely.
	 */
	F.Table.prototype.loadRows = function(data, append){
		this.rows.load(data, append);
	***REMOVED***;
***REMOVED***)(FooTable);
(function(F){
	F.Filter = F.Class.extend(/** @lends FooTable.Filter */{
		/**
		 * The filter object contains the query to filter by and the columns to apply it to.
		 * @constructs
		 * @extends FooTable.Class
		 * @param {string***REMOVED*** name - The name for the filter.
		 * @param {(string|FooTable.Query)***REMOVED*** query - The query for the filter.
		 * @param {Array.<FooTable.Column>***REMOVED*** columns - The columns to apply the query to.
		 * @param {string***REMOVED*** [space="AND"] - How the query treats space chars.
		 * @param {boolean***REMOVED*** [connectors=true] - Whether or not to replace phrase connectors (+.-_) with spaces.
		 * @param {boolean***REMOVED*** [ignoreCase=true] - Whether or not ignore case when matching.
		 * @param {boolean***REMOVED*** [hidden=true] - Whether or not this is a hidden filter.
		 * @returns {FooTable.Filter***REMOVED***
		 */
		construct: function(name, query, columns, space, connectors, ignoreCase, hidden){
			/**
			 * The name of the filter.
			 * @instance
			 * @type {string***REMOVED***
			 */
			this.name = name;
			/**
			 * A string specifying how the filter treats space characters. Can be either "OR" or "AND".
			 * @instance
			 * @type {string***REMOVED***
			 */
			this.space = F.is.string(space) && (space == 'OR' || space == 'AND') ? space : 'AND';
			/**
			 * Whether or not to replace phrase connectors (+.-_) with spaces before executing the query.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.connectors = F.is.boolean(connectors) ? connectors : true;
			/**
			 * Whether or not ignore case when matching.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.ignoreCase = F.is.boolean(ignoreCase) ? ignoreCase : true;
			/**
			 * Whether or not this is a hidden filter.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.hidden = F.is.boolean(hidden) ? hidden : false;
			/**
			 * The query for the filter.
			 * @instance
			 * @type {(string|FooTable.Query)***REMOVED***
			 */
			this.query = query instanceof F.Query ? query : new F.Query(query, this.space, this.connectors, this.ignoreCase);
			/**
			 * The columns to apply the query to.
			 * @instance
			 * @type {Array.<FooTable.Column>***REMOVED***
			 */
			this.columns = columns;
		***REMOVED***,
		/**
		 * Checks if the current filter matches the supplied string.
		 * If the current query property is a string it will be auto converted to a {@link FooTable.Query***REMOVED*** object to perform the match.
		 * @instance
		 * @param {string***REMOVED*** str - The string to check.
		 * @returns {boolean***REMOVED***
		 */
		match: function(str){
			if (!F.is.string(str)) return false;
			if (F.is.string(this.query)){
				this.query = new F.Query(this.query, this.space, this.connectors, this.ignoreCase);
			***REMOVED***
			return this.query instanceof F.Query ? this.query.match(str) : false;
		***REMOVED***,
		/**
		 * Checks if the current filter matches the supplied {@link FooTable.Row***REMOVED***.
		 * @instance
		 * @param {FooTable.Row***REMOVED*** row - The row to check.
		 * @returns {boolean***REMOVED***
		 */
		matchRow: function(row){
			var self = this, text = F.arr.map(row.cells, function(cell){
				return F.arr.contains(self.columns, cell.column) ? cell.filterValue : null;
			***REMOVED***).join(' ');
			return self.match(text);
		***REMOVED***
	***REMOVED***);

***REMOVED***)(FooTable);
(function ($, F) {
	F.Filtering = F.Component.extend(/** @lends FooTable.Filtering */{
		/**
		 * The filtering component adds a search input and column selector dropdown to the table allowing users to filter the using space delimited queries.
		 * @constructs
		 * @extends FooTable.Component
		 * @param {FooTable.Table***REMOVED*** table - The parent {@link FooTable.Table***REMOVED*** object for the component.
		 * @returns {FooTable.Filtering***REMOVED***
		 */
		construct: function (table) {
			// call the constructor of the base class
			this._super(table, table.o.filtering.enabled);

			/* PUBLIC */
			/**
			 * The filters to apply to the current {@link FooTable.Rows#array***REMOVED***.
			 * @instance
			 * @type {Array.<FooTable.Filter>***REMOVED***
			 */
			this.filters = table.o.filtering.filters;
			/**
			 * The delay in milliseconds before the query is auto applied after a change.
			 * @instance
			 * @type {number***REMOVED***
			 */
			this.delay = table.o.filtering.delay;
			/**
			 * The minimum number of characters allowed in the search input before it is auto applied.
			 * @instance
			 * @type {number***REMOVED***
			 */
			this.min = table.o.filtering.min;
			/**
			 * Specifies how whitespace in a filter query is handled.
			 * @instance
			 * @type {string***REMOVED***
			 */
			this.space = table.o.filtering.space;
			/**
			 * Whether or not to replace phrase connectors (+.-_) with spaces before executing the query.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.connectors = table.o.filtering.connectors;
			/**
			 * Whether or not ignore case when matching.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.ignoreCase = table.o.filtering.ignoreCase;
			/**
			 * Whether or not search queries are treated as phrases when matching.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.exactMatch = table.o.filtering.exactMatch;
			/**
			 * The placeholder text to display within the search $input.
			 * @instance
			 * @type {string***REMOVED***
			 */
			this.placeholder = table.o.filtering.placeholder;
			/**
			 * The title to display at the top of the search input column select.
			 * @type {string***REMOVED***
			 */
			this.dropdownTitle = table.o.filtering.dropdownTitle;
			/**
			 * The position of the $search input within the filtering rows cell.
			 * @type {string***REMOVED***
			 */
			this.position = table.o.filtering.position;
			/**
			 * Whether or not to focus the search input after the search/clear button is clicked or after auto applying the search input query.
			 * @type {boolean***REMOVED***
			 */
			this.focus = table.o.filtering.focus;
			/**
			 * A selector specifying where to place the filtering components form, if null the form is displayed within a row in the head of the table.
			 * @type {string***REMOVED***
			 */
			this.container = table.o.filtering.container;
			/**
			 * The jQuery object of the element containing the entire filtering form.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$container = null;
			/**
			 * The jQuery row object that contains all the filtering specific elements.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$row = null;
			/**
			 * The jQuery cell object that contains the search input and column selector.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$cell = null;
			/**
			 * The jQuery form object of the form that contains the search input and column selector.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$form = null;
			/**
			 * The jQuery object of the column selector dropdown.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$dropdown = null;
			/**
			 * The jQuery object of the search input.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$input = null;
			/**
			 * The jQuery object of the search button.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$button = null;

			/* PRIVATE */
			/**
			 * The timeout ID for the filter changed event.
			 * @instance
			 * @private
			 * @type {?number***REMOVED***
			 */
			this._filterTimeout = null;
			/**
			 * The regular expression used to check for encapsulating quotations.
			 * @instance
			 * @private
			 * @type {RegExp***REMOVED***
			 */
			this._exactRegExp = /^"(.*?)"$/;
		***REMOVED***,

		/* PROTECTED */
		/**
		 * Checks the supplied data and options for the filtering component.
		 * @instance
		 * @protected
		 * @param {object***REMOVED*** data - The jQuery data object from the parent table.
		 * @fires FooTable.Filtering#"preinit.ft.filtering"
		 */
		preinit: function(data){
			var self = this;
			/**
			 * The preinit.ft.filtering event is raised before the UI is created and provides the tables jQuery data object for additional options parsing.
			 * Calling preventDefault on this event will disable the component.
			 * @event FooTable.Filtering#"preinit.ft.filtering"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {object***REMOVED*** data - The jQuery data object of the table raising the event.
			 */
			return self.ft.raise('preinit.ft.filtering').then(function(){
				// first check if filtering is enabled via the class being applied
				if (self.ft.$el.hasClass('footable-filtering'))
					self.enabled = true;
				// then check if the data-filtering-enabled attribute has been set
				self.enabled = F.is.boolean(data.filtering)
					? data.filtering
					: self.enabled;

				// if filtering is not enabled exit early as we don't need to do anything else
				if (!self.enabled) return;

				self.space = F.is.string(data.filterSpace)
					? data.filterSpace
					: self.space;

				self.min = F.is.number(data.filterMin)
					? data.filterMin
					: self.min;

				self.connectors = F.is.boolean(data.filterConnectors)
					? data.filterConnectors
					: self.connectors;

				self.ignoreCase = F.is.boolean(data.filterIgnoreCase)
					? data.filterIgnoreCase
					: self.ignoreCase;

				self.exactMatch = F.is.boolean(data.filterExactMatch)
					? data.filterExactMatch
					: self.exactMatch;

				self.focus = F.is.boolean(data.filterFocus)
					? data.filterFocus
					: self.focus;

				self.delay = F.is.number(data.filterDelay)
					? data.filterDelay
					: self.delay;

				self.placeholder = F.is.string(data.filterPlaceholder)
					? data.filterPlaceholder
					: self.placeholder;

				self.dropdownTitle = F.is.string(data.filterDropdownTitle)
					? data.filterDropdownTitle
					: self.dropdownTitle;

				self.container = F.is.string(data.filterContainer)
					? data.filterContainer
					: self.container;

				self.filters = F.is.array(data.filterFilters)
					? self.ensure(data.filterFilters)
					: self.ensure(self.filters);

				if (self.ft.$el.hasClass('footable-filtering-left'))
					self.position = 'left';
				if (self.ft.$el.hasClass('footable-filtering-center'))
					self.position = 'center';
				if (self.ft.$el.hasClass('footable-filtering-right'))
					self.position = 'right';

				self.position = F.is.string(data.filterPosition)
					? data.filterPosition
					: self.position;
			***REMOVED***,function(){
				self.enabled = false;
			***REMOVED***);
		***REMOVED***,
		/**
		 * Initializes the filtering component for the plugin.
		 * @instance
		 * @protected
		 * @fires FooTable.Filtering#"init.ft.filtering"
		 */
		init: function () {
			var self = this;
			/**
			 * The init.ft.filtering event is raised before its UI is generated.
			 * Calling preventDefault on this event will disable the component.
			 * @event FooTable.Filtering#"init.ft.filtering"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			return self.ft.raise('init.ft.filtering').then(function(){
				self.$create();
			***REMOVED***, function(){
				self.enabled = false;
			***REMOVED***);
		***REMOVED***,
		/**
		 * Destroys the filtering component removing any UI from the table.
		 * @instance
		 * @protected
		 * @fires FooTable.Filtering#"destroy.ft.filtering"
		 */
		destroy: function () {
			var self = this;
			/**
			 * The destroy.ft.filtering event is raised before its UI is removed.
			 * Calling preventDefault on this event will prevent the component from being destroyed.
			 * @event FooTable.Filtering#"destroy.ft.filtering"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			return self.ft.raise('destroy.ft.filtering').then(function(){
				self.ft.$el.removeClass('footable-filtering')
					.find('thead > tr.footable-filtering').remove();
			***REMOVED***);
		***REMOVED***,
		/**
		 * Creates the filtering UI from the current options setting the various jQuery properties of this component.
		 * @instance
		 * @protected
		 * @this FooTable.Filtering
		 */
		$create: function () {
			var self = this;
			// generate the cell that actually contains all the UI.
			var $form_grp = $('<div/>', {'class': 'form-group footable-filtering-search'***REMOVED***)
					.append($('<label/>', {'class': 'sr-only', text: 'Search'***REMOVED***)),
				$input_grp = $('<div/>', {'class': 'input-group'***REMOVED***).appendTo($form_grp),
				$input_grp_btn = $('<div/>', {'class': 'input-group-btn'***REMOVED***),
				$dropdown_toggle = $('<button/>', {type: 'button', 'class': 'btn btn-default dropdown-toggle'***REMOVED***)
					.on('click', { self: self ***REMOVED***, self._onDropdownToggleClicked)
					.append($('<span/>', {'class': 'caret'***REMOVED***)),
				position;

			switch (self.position){
				case 'left': position = 'footable-filtering-left'; break;
				case 'center': position = 'footable-filtering-center'; break;
				default: position = 'footable-filtering-right'; break;
			***REMOVED***
			self.ft.$el.addClass('footable-filtering').addClass(position);

			self.$container = self.container === null ? $() : $(self.container).first();
			if (!self.$container.length){
				// add it to a row and then populate it with the search input and column selector dropdown.
				self.$row = $('<tr/>', {'class': 'footable-filtering'***REMOVED***).prependTo(self.ft.$el.children('thead'));
				self.$cell = $('<th/>').attr('colspan', self.ft.columns.visibleColspan).appendTo(self.$row);
				self.$container = self.$cell;
			***REMOVED*** else {
				self.$container.addClass('footable-filtering-external').addClass(position);
			***REMOVED***
			self.$form = $('<form/>', {'class': 'form-inline'***REMOVED***).append($form_grp).appendTo(self.$container);

			self.$input = $('<input/>', {type: 'text', 'class': 'form-control', placeholder: self.placeholder***REMOVED***);

			self.$button = $('<button/>', {type: 'button', 'class': 'btn btn-primary'***REMOVED***)
				.on('click', { self: self ***REMOVED***, self._onSearchButtonClicked)
				.append($('<span/>', {'class': 'fooicon fooicon-search'***REMOVED***));

			self.$dropdown = $('<ul/>', {'class': 'dropdown-menu dropdown-menu-right'***REMOVED***);
			if (!F.is.emptyString(self.dropdownTitle)){
				self.$dropdown.append($('<li/>', {'class': 'dropdown-header','text': self.dropdownTitle***REMOVED***));
			***REMOVED***
			self.$dropdown.append(
				F.arr.map(self.ft.columns.array, function (col) {
					return col.filterable ? $('<li/>').append(
						$('<a/>', {'class': 'checkbox'***REMOVED***).append(
							$('<label/>', {html: col.title***REMOVED***).prepend(
								$('<input/>', {type: 'checkbox', checked: true***REMOVED***).data('__FooTableColumn__', col)
							)
						)
					) : null;
				***REMOVED***)
			);

			if (self.delay > 0){
				self.$input.on('keypress keyup paste', { self: self ***REMOVED***, self._onSearchInputChanged);
				self.$dropdown.on('click', 'input[type="checkbox"]', {self: self***REMOVED***, self._onSearchColumnClicked);
			***REMOVED***

			$input_grp_btn.append(self.$button, $dropdown_toggle, self.$dropdown);
			$input_grp.append(self.$input, $input_grp_btn);
		***REMOVED***,
		/**
		 * Performs the filtering of rows before they are appended to the page.
		 * @instance
		 * @protected
		 */
		predraw: function(){
			if (F.is.emptyArray(this.filters))
				return;

			var self = this;
			self.ft.rows.array = $.grep(self.ft.rows.array, function(r){
				return r.filtered(self.filters);
			***REMOVED***);
		***REMOVED***,
		/**
		 * As the rows are drawn by the {@link FooTable.Rows#draw***REMOVED*** method this simply updates the colspan for the UI.
		 * @instance
		 * @protected
		 */
		draw: function(){
			if (F.is.jq(this.$cell)){
				this.$cell.attr('colspan', this.ft.columns.visibleColspan);
			***REMOVED***
			var search = this.find('search');
			if (search instanceof F.Filter){
				var query = search.query.val();
				if (this.exactMatch && this._exactRegExp.test(query)){
					query = query.replace(this._exactRegExp, '$1');
				***REMOVED***
				this.$input.val(query);
			***REMOVED*** else {
				this.$input.val(null);
			***REMOVED***
			this.setButton(!F.arr.any(this.filters, function(f){ return !f.hidden; ***REMOVED***));
		***REMOVED***,

		/* PUBLIC */
		/**
		 * Adds or updates the filter using the supplied name, query and columns.
		 * @instance
		 * @param {(string|FooTable.Filter|object)***REMOVED*** nameOrFilter - The name for the filter or the actual filter object itself.
		 * @param {(string|FooTable.Query)***REMOVED*** [query] - The query for the filter. This is only optional when the first parameter is a filter object.
		 * @param {(Array.<number>|Array.<string>|Array.<FooTable.Column>)***REMOVED*** [columns] - The columns to apply the filter to.
		 * 	If not supplied the filter will be applied to all selected columns in the search input dropdown.
		 * @param {boolean***REMOVED*** [ignoreCase=true] - Whether or not ignore case when matching.
		 * @param {boolean***REMOVED*** [connectors=true] - Whether or not to replace phrase connectors (+.-_) with spaces.
		 * @param {string***REMOVED*** [space="AND"] - How the query treats space chars.
		 * @param {boolean***REMOVED*** [hidden=true] - Whether or not this is a hidden filter.
		 */
		addFilter: function(nameOrFilter, query, columns, ignoreCase, connectors, space, hidden){
			var f = this.createFilter(nameOrFilter, query, columns, ignoreCase, connectors, space, hidden);
			if (f instanceof F.Filter){
				this.removeFilter(f.name);
				this.filters.push(f);
			***REMOVED***
		***REMOVED***,
		/**
		 * Removes the filter using the supplied name if it exists.
		 * @instance
		 * @param {string***REMOVED*** name - The name of the filter to remove.
		 */
		removeFilter: function(name){
			F.arr.remove(this.filters, function(f){ return f.name == name; ***REMOVED***);
		***REMOVED***,
		/**
		 * Performs the required steps to handle filtering including the raising of the {@link FooTable.Filtering#"before.ft.filtering"***REMOVED*** and {@link FooTable.Filtering#"after.ft.filtering"***REMOVED*** events.
		 * @instance
		 * @param {boolean***REMOVED*** [focus=false] - Whether or not to set the focus to the input once filtering is complete.
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Filtering#"before.ft.filtering"
		 * @fires FooTable.Filtering#"after.ft.filtering"
		 */
		filter: function(focus){
			var self = this;
			self.filters = self.ensure(self.filters);
			/**
			 * The before.ft.filtering event is raised before a filter is applied and allows listeners to modify the filter or cancel it completely by calling preventDefault on the jQuery.Event object.
			 * @event FooTable.Filtering#"before.ft.filtering"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {Array.<FooTable.Filter>***REMOVED*** filters - The filters that are about to be applied.
			 */
			return self.ft.raise('before.ft.filtering', [self.filters]).then(function(){
				self.filters = self.ensure(self.filters);
				if (focus){
					var start = self.$input.prop('selectionStart'),
						end = self.$input.prop('selectionEnd');
				***REMOVED***
				return self.ft.draw().then(function(){
					if (focus){
						self.$input.focus().prop({
							selectionStart: start,
							selectionEnd: end
						***REMOVED***);
					***REMOVED***
					/**
					 * The after.ft.filtering event is raised after a filter has been applied.
					 * @event FooTable.Filtering#"after.ft.filtering"
					 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
					 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
					 * @param {FooTable.Filter***REMOVED*** filter - The filters that were applied.
					 */
					self.ft.raise('after.ft.filtering', [self.filters]);
				***REMOVED***);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Removes the current search filter.
		 * @instance
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Filtering#"before.ft.filtering"
		 * @fires FooTable.Filtering#"after.ft.filtering"
		 */
		clear: function(){
			this.filters = F.arr.get(this.filters, function(f){ return f.hidden; ***REMOVED***);
			return this.filter(this.focus);
		***REMOVED***,
		/**
		 * Toggles the button icon between the search and clear icons based on the supplied value.
		 * @instance
		 * @param {boolean***REMOVED*** search - Whether or not to display the search icon.
		 */
		setButton: function(search){
			if (!search){
				this.$button.children('.fooicon').removeClass('fooicon-search').addClass('fooicon-remove');
			***REMOVED*** else {
				this.$button.children('.fooicon').removeClass('fooicon-remove').addClass('fooicon-search');
			***REMOVED***
		***REMOVED***,
		/**
		 * Finds a filter by name.
		 * @param {string***REMOVED*** name - The name of the filter to find.
		 * @returns {(FooTable.Filter|null)***REMOVED***
		 */
		find: function(name){
			return F.arr.first(this.filters, function(f){ return f.name == name; ***REMOVED***);
		***REMOVED***,
		/**
		 * Gets an array of {@link FooTable.Column***REMOVED*** to apply the search filter to. This also doubles as the default columns for filters which do not specify any columns.
		 * @instance
		 * @returns {Array.<FooTable.Column>***REMOVED***
		 */
		columns: function(){
			if (F.is.jq(this.$dropdown)){
				// if we have a dropdown containing the column names get the selected columns from there
				return this.$dropdown.find('input:checked').map(function(){
					return $(this).data('__FooTableColumn__');
				***REMOVED***).get();
			***REMOVED*** else {
				// otherwise find all columns that are set to be filterable.
				return this.ft.columns.get(function(c){ return c.filterable; ***REMOVED***);
			***REMOVED***
		***REMOVED***,
		/**
		 * Takes an array of plain objects containing the filter values or actual {@link FooTable.Filter***REMOVED*** objects and ensures that an array of only {@link FooTable.Filter***REMOVED*** is returned.
		 * If supplied a plain object that object must contain a name, query and columns properties which are used to create a new {@link FooTable.Filter***REMOVED***.
		 * @instance
		 * @param {({name: string, query: (string|FooTable.Query), columns: (Array.<string>|Array.<number>|Array.<FooTable.Column>)***REMOVED***|Array.<FooTable.Filter>)***REMOVED*** filters - The array of filters to check.
		 * @returns {Array.<FooTable.Filter>***REMOVED***
		 */
		ensure: function(filters){
			var self = this, parsed = [], filterable = self.columns();
			if (!F.is.emptyArray(filters)){
				F.arr.each(filters, function(f){
					f = self._ensure(f, filterable);
					if (f instanceof F.Filter) parsed.push(f);
				***REMOVED***);
			***REMOVED***
			return parsed;
		***REMOVED***,

		/**
		 * Creates a new filter using the supplied object or individual parameters to populate it.
		 * @instance
		 * @param {(string|FooTable.Filter|object)***REMOVED*** nameOrObject - The name for the filter or the actual filter object itself.
		 * @param {(string|FooTable.Query)***REMOVED*** [query] - The query for the filter. This is only optional when the first parameter is a filter object.
		 * @param {(Array.<number>|Array.<string>|Array.<FooTable.Column>)***REMOVED*** [columns] - The columns to apply the filter to.
		 * 	If not supplied the filter will be applied to all selected columns in the search input dropdown.
		 * @param {boolean***REMOVED*** [ignoreCase=true] - Whether or not ignore case when matching.
		 * @param {boolean***REMOVED*** [connectors=true] - Whether or not to replace phrase connectors (+.-_) with spaces.
		 * @param {string***REMOVED*** [space="AND"] - How the query treats space chars.
		 * @param {boolean***REMOVED*** [hidden=true] - Whether or not this is a hidden filter.
		 * @returns {****REMOVED***
		 */
		createFilter: function(nameOrObject, query, columns, ignoreCase, connectors, space, hidden){
			if (F.is.string(nameOrObject)){
				nameOrObject = {name: nameOrObject, query: query, columns: columns, ignoreCase: ignoreCase, connectors: connectors, space: space, hidden: hidden***REMOVED***;
			***REMOVED***
			return this._ensure(nameOrObject, this.columns());
		***REMOVED***,

		/* PRIVATE */
		_ensure: function(filter, selectedColumns){
			if ((F.is.hash(filter) || filter instanceof F.Filter) && !F.is.emptyString(filter.name) && (!F.is.emptyString(filter.query) || filter.query instanceof F.Query)){
				filter.columns = F.is.emptyArray(filter.columns) ? selectedColumns : this.ft.columns.ensure(filter.columns);
				filter.ignoreCase = F.is.boolean(filter.ignoreCase) ? filter.ignoreCase : this.ignoreCase;
				filter.connectors = F.is.boolean(filter.connectors) ? filter.connectors : this.connectors;
				filter.hidden = F.is.boolean(filter.hidden) ? filter.hidden : false;
				filter.space = F.is.string(filter.space) && (filter.space === 'AND' || filter.space === 'OR') ? filter.space : this.space;
				filter.query = F.is.string(filter.query) ? new F.Query(filter.query, filter.space, filter.connectors, filter.ignoreCase) : filter.query;
				return (filter instanceof F.Filter)
					? filter
					: new F.Filter(filter.name, filter.query, filter.columns, filter.space, filter.connectors, filter.ignoreCase, filter.hidden);
			***REMOVED***
			return null;
		***REMOVED***,
		/**
		 * Handles the change event for the {@link FooTable.Filtering#$input***REMOVED***.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The event object for the event.
		 */
		_onSearchInputChanged: function (e) {
			var self = e.data.self;
			var alpha = e.type == 'keypress' && !F.is.emptyString(String.fromCharCode(e.charCode)),
				ctrl = e.type == 'keyup' && (e.which == 8 || e.which == 46),
				paste = e.type == 'paste'; // backspace & delete

			// if alphanumeric characters or specific control characters
			if(alpha || ctrl || paste) {
				if (e.which == 13) e.preventDefault();
				if (self._filterTimeout != null) clearTimeout(self._filterTimeout);
				self._filterTimeout = setTimeout(function(){
					self._filterTimeout = null;
					var query = self.$input.val();
					if (query.length >= self.min){
						if (self.exactMatch && !self._exactRegExp.test(query)){
							query = '"' + query + '"';
						***REMOVED***
						self.addFilter('search', query);
						self.filter(self.focus);
					***REMOVED*** else if (F.is.emptyString(query)){
						self.clear();
					***REMOVED***
				***REMOVED***, self.delay);
			***REMOVED***
		***REMOVED***,
		/**
		 * Handles the click event for the {@link FooTable.Filtering#$button***REMOVED***.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The event object for the event.
		 */
		_onSearchButtonClicked: function (e) {
			e.preventDefault();
			var self = e.data.self;
			if (self._filterTimeout != null) clearTimeout(self._filterTimeout);
			var $icon = self.$button.children('.fooicon');
			if ($icon.hasClass('fooicon-remove')) self.clear();
			else {
				var query = self.$input.val();
				if (query.length >= self.min){
					if (self.exactMatch && !self._exactRegExp.test(query)){
						query = '"' + query + '"';
					***REMOVED***
					self.addFilter('search', query);
					self.filter(self.focus);
				***REMOVED***
			***REMOVED***
		***REMOVED***,
		/**
		 * Handles the click event for the column checkboxes in the {@link FooTable.Filtering#$dropdown***REMOVED***.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The event object for the event.
		 */
		_onSearchColumnClicked: function (e) {
			var self = e.data.self;
			if (self._filterTimeout != null) clearTimeout(self._filterTimeout);
			self._filterTimeout = setTimeout(function(){
				self._filterTimeout = null;
				var $icon = self.$button.children('.fooicon');
				if ($icon.hasClass('fooicon-remove')){
					$icon.removeClass('fooicon-remove').addClass('fooicon-search');
					self.addFilter('search', self.$input.val());
					self.filter();
				***REMOVED***
			***REMOVED***, self.delay);
		***REMOVED***,
		/**
		 * Handles the click event for the {@link FooTable.Filtering#$dropdown***REMOVED*** toggle.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The event object for the event.
		 */
		_onDropdownToggleClicked: function (e) {
			e.preventDefault();
			e.stopPropagation();
			var self = e.data.self;
			self.$dropdown.parent().toggleClass('open');
			if (self.$dropdown.parent().hasClass('open')) $(document).on('click.footable', { self: self ***REMOVED***, self._onDocumentClicked);
			else $(document).off('click.footable', self._onDocumentClicked);
		***REMOVED***,
		/**
		 * Checks all click events when the dropdown is visible and closes the menu if the target is not the dropdown.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The event object for the event.
		 */
		_onDocumentClicked: function(e){
			if ($(e.target).closest('.dropdown-menu').length == 0){
				e.preventDefault();
				var self = e.data.self;
				self.$dropdown.parent().removeClass('open');
				$(document).off('click.footable', self._onDocumentClicked);
			***REMOVED***
		***REMOVED***
	***REMOVED***);

	F.components.register('filtering', F.Filtering, 500);

***REMOVED***)(jQuery, FooTable);

(function(F){
	F.Query = F.Class.extend(/** @lends FooTable.Query */{
		/**
		 * The query object is used to parse and test the filtering component's queries
		 * @constructs
		 * @extends FooTable.Class
		 * @param {string***REMOVED*** query - The string value of the query.
		 * @param {string***REMOVED*** [space="AND"] - How the query treats whitespace.
		 * @param {boolean***REMOVED*** [connectors=true] - Whether or not to replace phrase connectors (+.-_) with spaces.
		 * @param {boolean***REMOVED*** [ignoreCase=true] - Whether or not ignore case when matching.
		 * @returns {FooTable.Query***REMOVED***
		 */
		construct: function(query, space, connectors, ignoreCase){
			/* PRIVATE */
			/**
			 * Holds the previous value of the query and is used internally in the {@link FooTable.Query#val***REMOVED*** method.
			 * @type {string***REMOVED***
			 * @private
			 */
			this._original = null;
			/**
			 * Holds the value for the query. Access to this variable is provided through the {@link FooTable.Query#val***REMOVED*** method.
			 * @type {string***REMOVED***
			 * @private
			 */
			this._value = null;
			/* PUBLIC */
			/**
			 * A string specifying how the query treats whitespace. Can be either "OR" or "AND".
			 * @type {string***REMOVED***
			 */
			this.space = F.is.string(space) && (space == 'OR' || space == 'AND') ? space : 'AND';
			/**
			 * Whether or not to replace phrase connectors (+.-_) with spaces before executing the query.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.connectors = F.is.boolean(connectors) ? connectors : true;
			/**
			 * Whether or not ignore case when matching.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.ignoreCase = F.is.boolean(ignoreCase) ? ignoreCase : true;
			/**
			 * The left side of the query if one exists. OR takes precedence over AND.
			 * @type {FooTable.Query***REMOVED***
			 * @example <caption>The below shows what is meant by the "left" side of a query</caption>
			 * query = "Dave AND Mary" - "Dave" is the left side of the query.
			 * query = "Dave AND Mary OR John" - "Dave and Mary" is the left side of the query.
			 */
			this.left = null;
			/**
			 * The right side of the query if one exists. OR takes precedence over AND.
			 * @type {FooTable.Query***REMOVED***
			 * @example <caption>The below shows what is meant by the "right" side of a query</caption>
			 * query = "Dave AND Mary" - "Mary" is the right side of the query.
			 * query = "Dave AND Mary OR John" - "John" is the right side of the query.
			 */
			this.right = null;
			/**
			 * The parsed parts of the query. This contains the information used to actually perform a match against a string.
			 * @type {Array***REMOVED***
			 */
			this.parts = [];
			/**
			 * The type of operand to apply to the results of the individual parts of the query.
			 * @type {string***REMOVED***
			 */
			this.operator = null;
			this.val(query);
		***REMOVED***,
		/**
		 * Gets or sets the value for the query. During set the value is parsed setting all properties as required.
		 * @param {string***REMOVED*** [value] - If supplied the value to set for this query.
		 * @returns {(string|undefined)***REMOVED***
		 */
		val: function(value){
			// get
			if (F.is.emptyString(value)) return this._value;

			// set
			if (F.is.emptyString(this._original)) this._original = value;
			else if (this._original == value) return;

			this._value = value;
			this._parse();
		***REMOVED***,
		/**
		 * Tests the supplied string against the query.
		 * @param {string***REMOVED*** str - The string to test.
		 * @returns {boolean***REMOVED***
		 */
		match: function(str){
			if (F.is.emptyString(this.operator) || this.operator === 'OR')
				return this._left(str, false) || this._match(str, false) || this._right(str, false);
			if (this.operator === 'AND')
				return this._left(str, true) && this._match(str, true) && this._right(str, true);
		***REMOVED***,
		/**
		 * Matches this queries parts array against the supplied string.
		 * @param {string***REMOVED*** str - The string to test.
		 * @param {boolean***REMOVED*** def - The default value to return based on the operand.
		 * @returns {boolean***REMOVED***
		 * @private
		 */
		_match: function(str, def){
			var self = this, result = false, empty = F.is.emptyString(str);
			if (F.is.emptyArray(self.parts) && self.left instanceof F.Query) return def;
			if (F.is.emptyArray(self.parts)) return result;
			if (self.space === 'OR'){
				// with OR we give the str every part to test and if any match it is a success, we do exit early if a negated match occurs
				F.arr.each(self.parts, function(p){
					if (p.empty && empty){
						result = true;
						if (p.negate){
							result = false;
							return result;
						***REMOVED***
					***REMOVED*** else {
						var match = (p.exact ? F.str.containsExact : F.str.contains)(str, p.query, self.ignoreCase);
						if (match && !p.negate) result = true;
						if (match && p.negate) {
							result = false;
							return result;
						***REMOVED***
					***REMOVED***
				***REMOVED***);
			***REMOVED*** else {
				// otherwise with AND we check until the first failure and then exit
				result = true;
				F.arr.each(self.parts, function(p){
					if (p.empty){
						if ((!empty && !p.negate) || (empty && p.negate)) result = false;
						return result;
					***REMOVED*** else {
						var match = (p.exact ? F.str.containsExact : F.str.contains)(str, p.query, self.ignoreCase);
						if ((!match && !p.negate) || (match && p.negate)) result = false;
						return result;
					***REMOVED***
				***REMOVED***);
			***REMOVED***
			return result;
		***REMOVED***,
		/**
		 * Matches the left side of the query if one exists with the supplied string.
		 * @param {string***REMOVED*** str - The string to test.
		 * @param {boolean***REMOVED*** def - The default value to return based on the operand.
		 * @returns {boolean***REMOVED***
		 * @private
		 */
		_left: function(str, def){
			return (this.left instanceof F.Query) ? this.left.match(str) : def;
		***REMOVED***,
		/**
		 * Matches the right side of the query if one exists with the supplied string.
		 * @param {string***REMOVED*** str - The string to test.
		 * @param {boolean***REMOVED*** def - The default value to return based on the operand.
		 * @returns {boolean***REMOVED***
		 * @private
		 */
		_right: function(str, def){
			return (this.right instanceof F.Query) ? this.right.match(str) : def;
		***REMOVED***,
		/**
		 * Parses the private {@link FooTable.Query#_value***REMOVED*** property and populates the object.
		 * @private
		 */
		_parse: function(){
			if (F.is.emptyString(this._value)) return;
			// OR takes precedence so test for it first
			if (/\sOR\s/.test(this._value)){
				// we have an OR so split the value on the first occurrence of OR to get the left and right sides of the statement
				this.operator = 'OR';
				var or = this._value.split(/(?:\sOR\s)(.*)?/);
				this.left = new F.Query(or[0], this.space, this.connectors, this.ignoreCase);
				this.right = new F.Query(or[1], this.space, this.connectors, this.ignoreCase);
			***REMOVED*** else if (/\sAND\s/.test(this._value)) {
				// there are no more OR's so start with AND
				this.operator = 'AND';
				var and = this._value.split(/(?:\sAND\s)(.*)?/);
				this.left = new F.Query(and[0], this.space, this.connectors, this.ignoreCase);
				this.right = new F.Query(and[1], this.space, this.connectors, this.ignoreCase);
			***REMOVED*** else {
				// we have no more statements to parse so set the parts array by parsing each part of the remaining query
				var self = this;
				this.parts = F.arr.map(this._value.match(/(?:[^\s"]+|"[^"]*")+/g), function(str){
					return self._part(str);
				***REMOVED***);
			***REMOVED***
		***REMOVED***,
		/**
		 * Parses a single part of a query into an object to use during matching.
		 * @param {string***REMOVED*** str - The string representation of the part.
		 * @returns {{query: string, negate: boolean, phrase: boolean, exact: boolean***REMOVED******REMOVED***
		 * @private
		 */
		_part: function(str){
			var p = {
				query: str,
				negate: false,
				phrase: false,
				exact: false,
				empty: false
			***REMOVED***;
			// support for NEGATE operand - (minus sign). Remove this first so we can get onto phrase checking
			if (F.str.startsWith(p.query, '-')){
				p.query = F.str.from(p.query, '-');
				p.negate = true;
			***REMOVED***
			// support for PHRASES (exact matches)
			if (/^"(.*?)"$/.test(p.query)){ // if surrounded in quotes strip them and nothing else
				p.query = p.query.replace(/^"(.*?)"$/, '$1');
				p.phrase = true;
				p.exact = true;
			***REMOVED*** else if (this.connectors && /(?:\w)+?([-_\+\.])(?:\w)+?/.test(p.query)) { // otherwise replace supported phrase connectors (-_+.) with spaces
				p.query = p.query.replace(/(?:\w)+?([-_\+\.])(?:\w)+?/g, function(match, p1){
					return match.replace(p1, ' ');
				***REMOVED***);
				p.phrase = true;
			***REMOVED***
			p.empty = p.phrase && F.is.emptyString(p.query);
			return p;
		***REMOVED***
	***REMOVED***);

***REMOVED***)(FooTable);
(function(F){

	/**
	 * The value used by the filtering component during filter operations. Must be a string and can be set using the data-filter-value attribute on the cell itself.
	 * If this is not supplied it is set to the result of the toString method called on the value for the cell. Added by the {@link FooTable.Filtering***REMOVED*** component.
	 * @type {string***REMOVED***
	 * @default null
	 */
	F.Cell.prototype.filterValue = null;

	// this is used to define the filtering specific properties on cell creation
	F.Cell.prototype.__filtering_define__ = function(valueOrElement){
		this.filterValue = this.column.filterValue.call(this.column, valueOrElement);
	***REMOVED***;

	// this is used to update the filterValue property whenever the cell value is changed
	F.Cell.prototype.__filtering_val__ = function(value){
		if (F.is.defined(value)){
			// set only
			this.filterValue = this.column.filterValue.call(this.column, value);
		***REMOVED***
	***REMOVED***;

	// overrides the public define method and replaces it with our own
	F.Cell.extend('define', function(valueOrElement){
		this._super(valueOrElement);
		this.__filtering_define__(valueOrElement);
	***REMOVED***);
	// overrides the public val method and replaces it with our own
	F.Cell.extend('val', function(value, redraw, redrawSelf){
		var val = this._super(value, redraw, redrawSelf);
		this.__filtering_val__(value);
		return val;
	***REMOVED***);
***REMOVED***)(FooTable);
(function($, F){
	/**
	 * Whether or not the column can be used during filtering. Added by the {@link FooTable.Filtering***REMOVED*** component.
	 * @type {boolean***REMOVED***
	 * @default true
	 */
	F.Column.prototype.filterable = true;

	/**
	 * This is supplied either the cell value or jQuery object to parse. A string value must be returned from this method and will be used during filtering operations.
	 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
	 * @returns {string***REMOVED***
	 * @this FooTable.Column
	 */
	F.Column.prototype.filterValue = function(valueOrElement){
		// if we have an element or a jQuery object use jQuery to get the value
		if (F.is.element(valueOrElement) || F.is.jq(valueOrElement)){
			var data = $(valueOrElement).data('filterValue');
			return F.is.defined(data) ? ''+data : $(valueOrElement).text();
		***REMOVED***
		// if options are supplied with the value
		if (F.is.hash(valueOrElement) && F.is.hash(valueOrElement.options)){
			if (F.is.string(valueOrElement.options.filterValue)) return valueOrElement.options.filterValue;
			if (F.is.defined(valueOrElement.value)) valueOrElement = valueOrElement.value;
		***REMOVED***
		if (F.is.defined(valueOrElement) && valueOrElement != null) return valueOrElement+''; // use the native toString of the value
		return ''; // otherwise we have no value so return an empty string
	***REMOVED***;

	// this is used to define the filtering specific properties on column creation
	F.Column.prototype.__filtering_define__ = function(definition){
		this.filterable = F.is.boolean(definition.filterable) ? definition.filterable : this.filterable;
		this.filterValue = F.checkFnValue(this, definition.filterValue, this.filterValue);
	***REMOVED***;

	// overrides the public define method and replaces it with our own
	F.Column.extend('define', function(definition){
		this._super(definition); // call the base so we don't have to redefine any previously set properties
		this.__filtering_define__(definition); // then call our own
	***REMOVED***);
***REMOVED***)(jQuery, FooTable);
(function(F){
	/**
	 * An object containing the filtering options for the plugin. Added by the {@link FooTable.Filtering***REMOVED*** component.
	 * @type {object***REMOVED***
	 * @prop {boolean***REMOVED*** enabled=false - Whether or not to allow filtering on the table.
	 * @prop {({name: string, query: (string|FooTable.Query), columns: (Array.<string>|Array.<number>|Array.<FooTable.Column>)***REMOVED***|Array.<FooTable.Filter>)***REMOVED*** filters - The filters to apply to the current {@link FooTable.Rows#array***REMOVED***.
	 * @prop {number***REMOVED*** delay=1200 - The delay in milliseconds before the query is auto applied after a change (any value equal to or less than zero will disable this).
	 * @prop {number***REMOVED*** min=1 - The minimum number of characters allowed in the search input before it is auto applied.
	 * @prop {string***REMOVED*** space="AND" - Specifies how whitespace in a filter query is handled.
	 * @prop {string***REMOVED*** placeholder="Search" - The string used as the placeholder for the search input.
	 * @prop {string***REMOVED*** dropdownTitle=null - The title to display at the top of the search input column select.
	 * @prop {string***REMOVED*** position="right" - The string used to specify the alignment of the search input.
	 * @prop {string***REMOVED*** connectors=true - Whether or not to replace phrase connectors (+.-_) with space before executing the query.
	 * @prop {boolean***REMOVED*** ignoreCase=true - Whether or not ignore case when matching.
	 * @prop {boolean***REMOVED*** exactMatch=false - Whether or not search queries are treated as phrases when matching.
	 * @prop {boolean***REMOVED*** focus=true - Whether or not to focus the search input after the search/clear button is clicked or after auto applying the search input query.
	 * @prop {string***REMOVED*** container=null - A selector specifying where to place the filtering components form, if null the form is displayed within a row in the head of the table.
	 */
	F.Defaults.prototype.filtering = {
		enabled: false,
		filters: [],
		delay: 1200,
		min: 1,
		space: 'AND',
		placeholder: 'Search',
		dropdownTitle: null,
		position: 'right',
		connectors: true,
		ignoreCase: true,
		exactMatch: false,
		focus: true,
		container: null
	***REMOVED***;
***REMOVED***)(FooTable);
(function(F){
	/**
	 * Checks if the row is filtered using the supplied filters.
	 * @this FooTable.Row
	 * @param {Array.<FooTable.Filter>***REMOVED*** filters - The filters to apply.
	 * @returns {boolean***REMOVED***
	 */
	F.Row.prototype.filtered = function(filters){
		var result = true, self = this;
		F.arr.each(filters, function(f){
			if ((result = f.matchRow(self)) == false) return false;
		***REMOVED***);
		return result;
	***REMOVED***;
***REMOVED***)(FooTable);
(function($, F){

	F.Sorter = F.Class.extend(/** @lends FooTable.Sorter */{
		/**
		 * The sorter object contains the column and direction to sort by.
		 * @constructs
		 * @extends FooTable.Class
		 * @param {FooTable.Column***REMOVED*** column - The column to sort.
		 * @param {string***REMOVED*** direction - The direction to sort by.
		 * @returns {FooTable.Sorter***REMOVED***
		 */
		construct: function(column, direction){
			/**
			 * The column to sort.
			 * @type {FooTable.Column***REMOVED***
			 */
			this.column = column;
			/**
			 * The direction to sort by.
			 * @type {string***REMOVED***
			 */
			this.direction = direction;
		***REMOVED***
	***REMOVED***);

***REMOVED***)(jQuery, FooTable);
(function ($, F) {
	F.Sorting = F.Component.extend(/** @lends FooTable.Sorting */{
		/**
		 * The sorting component adds a small sort button to specified column headers allowing users to sort those columns in the table.
		 * @constructs
		 * @extends FooTable.Component
		 * @param {FooTable.Table***REMOVED*** table - The parent {@link FooTable.Table***REMOVED*** object for the component.
		 * @returns {FooTable.Sorting***REMOVED***
		 */
		construct: function (table) {
			// call the constructor of the base class
			this._super(table, table.o.sorting.enabled);

			/* PROTECTED */
			/**
			 * This provides a shortcut to the {@link FooTable.Table#options***REMOVED***.[sorting]{@link FooTable.Defaults#sorting***REMOVED*** object.
			 * @instance
			 * @protected
			 * @type {object***REMOVED***
			 */
			this.o = table.o.sorting;
			/**
			 * The current sorted column.
			 * @instance
			 * @type {FooTable.Column***REMOVED***
			 */
			this.column = null;
			/**
			 * Whether or not to allow sorting to occur, should be set using the {@link FooTable.Sorting#toggleAllowed***REMOVED*** method.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.allowed = true;
			/**
			 * The initial sort state of the table, this value is used for determining if the sorting has occurred or to reset the state to default.
			 * @instance
			 * @type {{isset: boolean, rows: Array.<FooTable.Row>, column: string, direction: ?string***REMOVED******REMOVED***
			 */
			this.initial = null;
		***REMOVED***,

		/* PROTECTED */
		/**
		 * Checks the supplied data and options for the sorting component.
		 * @instance
		 * @protected
		 * @param {object***REMOVED*** data - The jQuery data object from the parent table.
		 * @fires FooTable.Sorting#"preinit.ft.sorting"
		 * @this FooTable.Sorting
		 */
		preinit: function(data){
			var self = this;
			/**
			 * The preinit.ft.sorting event is raised before the UI is created and provides the tables jQuery data object for additional options parsing.
			 * Calling preventDefault on this event will disable the component.
			 * @event FooTable.Sorting#"preinit.ft.sorting"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {object***REMOVED*** data - The jQuery data object of the table raising the event.
			 */
			this.ft.raise('preinit.ft.sorting', [data]).then(function(){
				if (self.ft.$el.hasClass('footable-sorting'))
					self.enabled = true;
				self.enabled = F.is.boolean(data.sorting)
					? data.sorting
					: self.enabled;
				if (!self.enabled) return;
				self.column = F.arr.first(self.ft.columns.array, function(col){ return col.sorted; ***REMOVED***);
			***REMOVED***, function(){
				self.enabled = false;
			***REMOVED***);
		***REMOVED***,
		/**
		 * Initializes the sorting component for the plugin using the supplied table and options.
		 * @instance
		 * @protected
		 * @fires FooTable.Sorting#"init.ft.sorting"
		 * @this FooTable.Sorting
		 */
		init: function () {
			/**
			 * The init.ft.sorting event is raised before its UI is generated.
			 * Calling preventDefault on this event will disable the component.
			 * @event FooTable.Sorting#"init.ft.sorting"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			var self = this;
			this.ft.raise('init.ft.sorting').then(function(){
				if (!self.initial){
					var isset = !!self.column;
					self.initial = {
						isset: isset,
						// grab a shallow copy of the rows array prior to sorting - allows us to reset without an initial sort
						rows: self.ft.rows.all.slice(0),
						// if there is a sorted column store its name and direction
						column: isset ? self.column.name : null,
						direction: isset ? self.column.direction : null
					***REMOVED***
				***REMOVED***
				F.arr.each(self.ft.columns.array, function(col){
					if (col.sortable){
						col.$el.addClass('footable-sortable').append($('<span/>', {'class': 'fooicon fooicon-sort'***REMOVED***));
					***REMOVED***
				***REMOVED***);
				self.ft.$el.on('click.footable', '.footable-sortable', { self: self ***REMOVED***, self._onSortClicked);
			***REMOVED***, function(){
				self.enabled = false;
			***REMOVED***);
		***REMOVED***,
		/**
		 * Destroys the sorting component removing any UI generated from the table.
		 * @instance
		 * @protected
		 * @fires FooTable.Sorting#"destroy.ft.sorting"
		 */
		destroy: function () {
			/**
			 * The destroy.ft.sorting event is raised before its UI is removed.
			 * Calling preventDefault on this event will prevent the component from being destroyed.
			 * @event FooTable.Sorting#"destroy.ft.sorting"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			var self = this;
			this.ft.raise('destroy.ft.paging').then(function(){
				self.ft.$el.off('click.footable', '.footable-sortable', self._onSortClicked);
				self.ft.$el.children('thead').children('tr.footable-header')
					.children('.footable-sortable').removeClass('footable-sortable footable-asc footable-desc')
					.find('span.fooicon').remove();
			***REMOVED***);
		***REMOVED***,
		/**
		 * Performs the actual sorting against the {@link FooTable.Rows#current***REMOVED*** array.
		 * @instance
		 * @protected
		 */
		predraw: function () {
			if (!this.column) return;
			var self = this, col = self.column;
			self.ft.rows.array.sort(function (a, b) {
				return col.direction == 'DESC'
						? col.sorter(b.cells[col.index].sortValue, a.cells[col.index].sortValue)
						: col.sorter(a.cells[col.index].sortValue, b.cells[col.index].sortValue);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Updates the sorting UI setting the state of the sort buttons.
		 * @instance
		 * @protected
		 */
		draw: function () {
			if (!this.column) return;
			var self = this,
				$sortable = self.ft.$el.find('thead > tr > .footable-sortable'),
				$active = self.column.$el;

			$sortable.removeClass('footable-asc footable-desc').children('.fooicon').removeClass('fooicon-sort fooicon-sort-asc fooicon-sort-desc');
			$sortable.not($active).children('.fooicon').addClass('fooicon-sort');
			$active.addClass(self.column.direction == 'DESC' ? 'footable-desc' : 'footable-asc')
				.children('.fooicon').addClass(self.column.direction == 'DESC' ? 'fooicon-sort-desc' : 'fooicon-sort-asc');
		***REMOVED***,

		/* PUBLIC */
		/**
		 * Sets the sorting options and calls the {@link FooTable.Table#draw***REMOVED*** method to perform the actual sorting.
		 * @instance
		 * @param {(string|number|FooTable.Column)***REMOVED*** column - The column name, index or the actual {@link FooTable.Column***REMOVED*** object to sort by.
		 * @param {string***REMOVED*** [direction="ASC"] - The direction to sort by, either ASC or DESC.
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Sorting#"before.ft.sorting"
		 * @fires FooTable.Sorting#"after.ft.sorting"
		 */
		sort: function(column, direction){
			return this._sort(column, direction);
		***REMOVED***,
		/**
		 * Toggles whether or not sorting is currently allowed.
		 * @param {boolean***REMOVED*** [state] - You can optionally specify the state you want it to be, if not supplied the current value is flipped.
		 */
		toggleAllowed: function(state){
			state = F.is.boolean(state) ? state : !this.allowed;
			this.allowed = state;
			this.ft.$el.toggleClass('footable-sorting-disabled', !this.allowed);
		***REMOVED***,
		/**
		 * Checks whether any sorting has occurred for the table.
		 * @returns {boolean***REMOVED***
		 */
		hasChanged: function(){
			return !(!this.initial || !this.column ||
				(this.column.name === this.initial.column &&
					(this.column.direction === this.initial.direction || (this.initial.direction === null && this.column.direction === 'ASC')))
			);
		***REMOVED***,
		/**
		 * Resets the table sorting to the initial state recorded in the components init method.
		 */
		reset: function(){
			if (!!this.initial){
				if (this.initial.isset){
					// if the initial value specified a column, sort by it
					this.sort(this.initial.column, this.initial.direction);
				***REMOVED*** else {
					// if there was no initial column then we need to reset the rows to there original order
					if (!!this.column){
						// if there is a currently sorted column remove the asc/desc classes and set it to null.
						this.column.$el.removeClass('footable-asc footable-desc');
						this.column = null;
					***REMOVED***
					// replace the current all rows array with the one stored in the initial value
					this.ft.rows.all = this.initial.rows;
					// force the table to redraw itself using the updated rows array
					this.ft.draw();
				***REMOVED***
			***REMOVED***
		***REMOVED***,

		/* PRIVATE */
		/**
		 * Performs the required steps to handle sorting including the raising of the {@link FooTable.Sorting#"before.ft.sorting"***REMOVED*** and {@link FooTable.Sorting#"after.ft.sorting"***REMOVED*** events.
		 * @instance
		 * @private
		 * @param {(string|number|FooTable.Column)***REMOVED*** column - The column name, index or the actual {@link FooTable.Column***REMOVED*** object to sort by.
		 * @param {string***REMOVED*** [direction="ASC"] - The direction to sort by, either ASC or DESC.
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Sorting#"before.ft.sorting"
		 * @fires FooTable.Sorting#"after.ft.sorting"
		 */
		_sort: function(column, direction){
			if (!this.allowed) return $.Deferred().reject('sorting disabled');
			var self = this;
			var sorter = new F.Sorter(self.ft.columns.get(column), F.Sorting.dir(direction));
			/**
			 * The before.ft.sorting event is raised before a sort is applied and allows listeners to modify the sorter or cancel it completely by calling preventDefault on the jQuery.Event object.
			 * @event FooTable.Sorting#"before.ft.sorting"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {FooTable.Sorter***REMOVED*** sorter - The sorter that is about to be applied.
			 */
			return self.ft.raise('before.ft.sorting', [sorter]).then(function(){
				F.arr.each(self.ft.columns.array, function(col){
					if (col != self.column) col.direction = null;
				***REMOVED***);
				self.column = self.ft.columns.get(sorter.column);
				if (self.column) self.column.direction = F.Sorting.dir(sorter.direction);
				return self.ft.draw().then(function(){
					/**
					 * The after.ft.sorting event is raised after a sorter has been applied.
					 * @event FooTable.Sorting#"after.ft.sorting"
					 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
					 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
					 * @param {FooTable.Sorter***REMOVED*** sorter - The sorter that has been applied.
					 */
					self.ft.raise('after.ft.sorting', [sorter]);
				***REMOVED***);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Handles the sort button clicked event.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The event object for the event.
		 */
		_onSortClicked: function (e) {
			var self = e.data.self, $header = $(this).closest('th,td'),
				direction = $header.is('.footable-asc, .footable-desc')
					? ($header.hasClass('footable-desc') ? 'ASC' : 'DESC')
					: 'ASC';
			self._sort($header.index(), direction);
		***REMOVED***
	***REMOVED***);

	/**
	 * Checks the supplied string is a valid direction and if not returns ASC as default.
	 * @static
	 * @protected
	 * @param {string***REMOVED*** str - The string to check.
	 */
	F.Sorting.dir = function(str){
		return F.is.string(str) && (str == 'ASC' || str == 'DESC') ? str : 'ASC';
	***REMOVED***;

	F.components.register('sorting', F.Sorting, 600);

***REMOVED***)(jQuery, FooTable);
(function(F){

	/**
	 * The value used by the sorting component during sort operations. Can be set using the data-sort-value attribute on the cell itself.
	 * If this is not supplied it is set to the result of the toString method called on the value for the cell. Added by the {@link FooTable.Sorting***REMOVED*** component.
	 * @type {string***REMOVED***
	 * @default null
	 */
	F.Cell.prototype.sortValue = null;

	// this is used to define the sorting specific properties on cell creation
	F.Cell.prototype.__sorting_define__ = function(valueOrElement){
		this.sortValue = this.column.sortValue.call(this.column, valueOrElement);
	***REMOVED***;

	// this is used to update the sortValue property whenever the cell value is changed
	F.Cell.prototype.__sorting_val__ = function(value){
		if (F.is.defined(value)){
			// set only
			this.sortValue = this.column.sortValue.call(this.column, value);
		***REMOVED***
	***REMOVED***;

	// overrides the public define method and replaces it with our own
	F.Cell.extend('define', function(valueOrElement){
		this._super(valueOrElement);
		this.__sorting_define__(valueOrElement);
	***REMOVED***);
	// overrides the public val method and replaces it with our own
	F.Cell.extend('val', function(value, redraw, redrawSelf){
		var val = this._super(value, redraw, redrawSelf);
		this.__sorting_val__(value);
		return val;
	***REMOVED***);
***REMOVED***)(FooTable);
(function($, F){
	/**
	 * The direction to sort if the {@link FooTable.Column#sorted***REMOVED*** property is set to true. Can be "ASC", "DESC" or NULL. Added by the {@link FooTable.Sorting***REMOVED*** component.
	 * @type {string***REMOVED***
	 * @default null
	 */
	F.Column.prototype.direction = null;
	/**
	 * Whether or not the column can be sorted. Added by the {@link FooTable.Sorting***REMOVED*** component.
	 * @type {boolean***REMOVED***
	 * @default true
	 */
	F.Column.prototype.sortable = true;
	/**
	 * Whether or not the column is sorted. Added by the {@link FooTable.Sorting***REMOVED*** component.
	 * @type {boolean***REMOVED***
	 * @default false
	 */
	F.Column.prototype.sorted = false;

	/**
	 * This is supplied two values from the column for a comparison to be made and the result returned. Added by the {@link FooTable.Sorting***REMOVED*** component.
	 * @param {****REMOVED*** a - The first value to be compared.
	 * @param {****REMOVED*** b - The second value to compare to the first.
	 * @returns {number***REMOVED***
	 * @example <caption>This example shows using pseudo code what a sort function would look like.</caption>
	 * "sorter": function(a, b){
	 * 	if (a is less than b by some ordering criterion) {
	 * 		return -1;
	 * 	***REMOVED***
	 * 	if (a is greater than b by the ordering criterion) {
	 * 		return 1;
	 * 	***REMOVED***
	 * 	// a must be equal to b
	 * 	return 0;
	 * ***REMOVED***
	 */
	F.Column.prototype.sorter = function(a, b){
		if (typeof a === 'string') a = a.toLowerCase();
		if (typeof b === 'string') b = b.toLowerCase();
		if (a === b) return 0;
		if (a < b) return -1;
		return 1;
	***REMOVED***;

	/**
	 * This is supplied either the cell value or jQuery object to parse. A value must be returned from this method and will be used during sorting operations.
	 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
	 * @returns {****REMOVED***
	 * @this FooTable.Column
	 */
	F.Column.prototype.sortValue = function(valueOrElement){
		// if we have an element or a jQuery object use jQuery to get the value
		if (F.is.element(valueOrElement) || F.is.jq(valueOrElement)){
			var data = $(valueOrElement).data('sortValue');
			return F.is.defined(data) ? data : this.parser(valueOrElement);
		***REMOVED***
		// if options are supplied with the value
		if (F.is.hash(valueOrElement) && F.is.hash(valueOrElement.options)){
			if (F.is.string(valueOrElement.options.sortValue)) return valueOrElement.options.sortValue;
			if (F.is.defined(valueOrElement.value)) valueOrElement = valueOrElement.value;
		***REMOVED***
		if (F.is.defined(valueOrElement) && valueOrElement != null) return valueOrElement;
		return null;
	***REMOVED***;

	// this is used to define the sorting specific properties on column creation
	F.Column.prototype.__sorting_define__ = function(definition){
		this.sorter = F.checkFnValue(this, definition.sorter, this.sorter);
		this.direction = F.is.type(definition.direction, 'string') ? F.Sorting.dir(definition.direction) : null;
		this.sortable = F.is.boolean(definition.sortable) ? definition.sortable : true;
		this.sorted = F.is.boolean(definition.sorted) ? definition.sorted : false;
		this.sortValue = F.checkFnValue(this, definition.sortValue, this.sortValue);
	***REMOVED***;

	// overrides the public define method and replaces it with our own
	F.Column.extend('define', function(definition){
		this._super(definition);
		this.__sorting_define__(definition);
	***REMOVED***);

***REMOVED***)(jQuery, FooTable);
(function(F){
	/**
	 * An object containing the sorting options for the plugin. Added by the {@link FooTable.Sorting***REMOVED*** component.
	 * @type {object***REMOVED***
	 * @prop {boolean***REMOVED*** enabled=false - Whether or not to allow sorting on the table.
	 */
	F.Defaults.prototype.sorting = {
		enabled: false
	***REMOVED***;
***REMOVED***)(FooTable);
(function($, F){

	F.HTMLColumn.extend('__sorting_define__', function(definition){
		this._super(definition);
		this.sortUse = F.is.string(definition.sortUse) && $.inArray(definition.sortUse, ['html','text']) !== -1 ? definition.sortUse : 'html';
	***REMOVED***);

	/**
	 * This is supplied either the cell value or jQuery object to parse. A value must be returned from this method and will be used during sorting operations.
	 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
	 * @returns {****REMOVED***
	 * @this FooTable.HTMLColumn
	 */
	F.HTMLColumn.prototype.sortValue = function(valueOrElement){
		// if we have an element or a jQuery object use jQuery to get the data value or pass it off to the parser
		if (F.is.element(valueOrElement) || F.is.jq(valueOrElement)){
			var data = $(valueOrElement).data('sortValue');
			return F.is.defined(data) ? data : this.parser(valueOrElement);
		***REMOVED***
		// if options are supplied with the value
		if (F.is.hash(valueOrElement) && F.is.hash(valueOrElement.options)){
			if (F.is.string(valueOrElement.options.sortValue)) return valueOrElement.options.sortValue;
			if (F.is.defined(valueOrElement.value)) valueOrElement = valueOrElement.value;
		***REMOVED***
		if (F.is.defined(valueOrElement) && valueOrElement != null) return valueOrElement;
		return null;
	***REMOVED***;

***REMOVED***)(jQuery, FooTable);
(function($, F){

	/**
	 * This is supplied either the cell value or jQuery object to parse. A value must be returned from this method and will be used during sorting operations.
	 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
	 * @returns {****REMOVED***
	 */
	F.NumberColumn.prototype.sortValue = function(valueOrElement){
		// if we have an element or a jQuery object use jQuery to get the data value or pass it off to the parser
		if (F.is.element(valueOrElement) || F.is.jq(valueOrElement)){
			var data = $(valueOrElement).data('sortValue');
			return F.is.number(data) ? data : this.parser(valueOrElement);
		***REMOVED***
		// if options are supplied with the value
		if (F.is.hash(valueOrElement) && F.is.hash(valueOrElement.options)){
			if (F.is.string(valueOrElement.options.sortValue)) return this.parser(valueOrElement);
			if (F.is.number(valueOrElement.options.sortValue)) return valueOrElement.options.sortValue;
			if (F.is.number(valueOrElement.value)) return valueOrElement.value;
		***REMOVED***
		if (F.is.string(valueOrElement)) return this.parser(valueOrElement);
		if (F.is.number(valueOrElement)) return valueOrElement;
		return null;
	***REMOVED***;

***REMOVED***)(jQuery, FooTable);
(function(F){
	/**
	 * Sort the table using the specified column and direction. Added by the {@link FooTable.Sorting***REMOVED*** component.
	 * @instance
	 * @param {(string|number|FooTable.Column)***REMOVED*** column - The column name, index or the actual {@link FooTable.Column***REMOVED*** object to sort by.
	 * @param {string***REMOVED*** [direction="ASC"] - The direction to sort by, either ASC or DESC.
	 * @returns {jQuery.Promise***REMOVED***
	 * @fires FooTable.Sorting#"change.ft.sorting"
	 * @fires FooTable.Sorting#"changed.ft.sorting"
	 * @see FooTable.Sorting#sort
	 */
	F.Table.prototype.sort = function(column, direction){
		return this.use(F.Sorting).sort(column, direction);
	***REMOVED***;
***REMOVED***)(FooTable);
(function($, F){

	F.Pager = F.Class.extend(/** @lends FooTable.Pager */{
		/**
		 * The pager object contains the page number and direction to page to.
		 * @constructs
		 * @extends FooTable.Class
		 * @param {number***REMOVED*** total - The total number of pages available.
		 * @param {number***REMOVED*** current - The current page number.
		 * @param {number***REMOVED*** size - The number of rows per page.
		 * @param {number***REMOVED*** page - The page number to goto.
		 * @param {boolean***REMOVED*** forward - A boolean indicating the direction of paging, TRUE = forward, FALSE = back.
		 * @returns {FooTable.Pager***REMOVED***
		 */
		construct: function(total, current, size, page, forward){
			/**
			 * The total number of pages available.
			 * @type {number***REMOVED***
			 */
			this.total = total;
			/**
			 * The current page number.
			 * @type {number***REMOVED***
			 */
			this.current = current;
			/**
			 * The number of rows per page.
			 * @type {number***REMOVED***
			 */
			this.size = size;
			/**
			 * The page number to goto.
			 * @type {number***REMOVED***
			 */
			this.page = page;
			/**
			 * A boolean indicating the direction of paging, TRUE = forward, FALSE = back.
			 * @type {boolean***REMOVED***
			 */
			this.forward = forward;
		***REMOVED***
	***REMOVED***);

***REMOVED***)(jQuery, FooTable);
(function($, F){
	F.Paging = F.Component.extend(/** @lends FooTable.Paging */{
		/**
		 * The paging component adds a pagination control to the table allowing users to navigate table rows via pages.
		 * @constructs
		 * @extends FooTable.Component
		 * @param {FooTable.Table***REMOVED*** table - The parent {@link FooTable.Table***REMOVED*** object for the component.
		 * @returns {FooTable.Filtering***REMOVED***
		 */
		construct: function(table){
			// call the base constructor
			this._super(table, table.o.paging.enabled);

			/* PROTECTED */
			/**
			 * An object containing the strings used by the paging buttons.
			 * @type {{ first: string, prev: string, next: string, last: string ***REMOVED******REMOVED***
			 */
			this.strings = table.o.paging.strings;

			/* PUBLIC */
			/**
			 * The current page number to display.
			 * @instance
			 * @type {number***REMOVED***
			 */
			this.current = table.o.paging.current;
			/**
			 * The number of rows to display per page.
			 * @instance
			 * @type {number***REMOVED***
			 */
			this.size = table.o.paging.size;
			/**
			 * The maximum number of page links to display at once.
			 * @instance
			 * @type {number***REMOVED***
			 */
			this.limit = table.o.paging.limit;
			/**
			 * The position of the pagination control within the paging rows cell.
			 * @instance
			 * @type {string***REMOVED***
			 */
			this.position = table.o.paging.position;
			/**
			 * The format string used to generate the text displayed under the pagination control.
			 * @instance
			 * @type {string***REMOVED***
			 */
			this.countFormat = table.o.paging.countFormat;
			/**
			 * A selector specifying where to place the paging components UI, if null the UI is displayed within a row in the foot of the table.
			 * @instance
			 * @type {string***REMOVED***
			 */
			this.container = table.o.paging.container;
				/**
			 * The total number of pages.
			 * @instance
			 * @type {number***REMOVED***
			 */
			this.total = -1;
			/**
			 * The number of rows in the {@link FooTable.Rows#array***REMOVED*** before paging is applied.
			 * @instance
			 * @type {number***REMOVED***
			 */
			this.totalRows = 0;
			/**
			 * A number indicating the previous page displayed.
			 * @instance
			 * @type {number***REMOVED***
			 */
			this.previous = -1;
			/**
			 * The count string generated using the {@link FooTable.Filtering#countFormat***REMOVED*** option. This value is only set after the first call to the {@link FooTable.Filtering#predraw***REMOVED*** method.
			 * @instance
			 * @type {string***REMOVED***
			 */
			this.formattedCount = null;
			/**
			 * The jQuery object of the element containing the entire paging UI.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$container = null;
			/**
			 * The jQuery object of the element wrapping all the paging UI elements.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$wrapper = null;
			/** +
			 * The jQuery row object that contains all the paging specific elements.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$row = null;
			/**
			 * The jQuery cell object that contains the pagination control and total count.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$cell = null;
			/**
			 * The jQuery object that contains the links for the pagination control.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$pagination = null;
			/**
			 * The jQuery object that contains the row count.
			 * @instance
			 * @type {jQuery***REMOVED***
			 */
			this.$count = null;
			/**
			 * Whether or not the pagination row is detached from the table.
			 * @instance
			 * @type {boolean***REMOVED***
			 */
			this.detached = true;

			/* PRIVATE */
			/**
			 * Used to hold the number of page links created.
			 * @instance
			 * @type {number***REMOVED***
			 * @private
			 */
			this._createdLinks = 0;
		***REMOVED***,

		/* PROTECTED */
		/**
		 * Checks the supplied data and options for the paging component.
		 * @instance
		 * @protected
		 * @param {object***REMOVED*** data - The jQuery data object from the parent table.
		 * @fires FooTable.Paging#"preinit.ft.paging"
		 */
		preinit: function(data){
			var self = this;
			/**
			 * The preinit.ft.paging event is raised before the UI is created and provides the tables jQuery data object for additional options parsing.
			 * Calling preventDefault on this event will disable the component.
			 * @event FooTable.Paging#"preinit.ft.paging"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {object***REMOVED*** data - The jQuery data object of the table raising the event.
			 */
			this.ft.raise('preinit.ft.paging', [data]).then(function(){
				if (self.ft.$el.hasClass('footable-paging'))
					self.enabled = true;
				self.enabled = F.is.boolean(data.paging)
					? data.paging
					: self.enabled;

				if (!self.enabled) return;

				self.size = F.is.number(data.pagingSize)
					? data.pagingSize
					: self.size;

				self.current = F.is.number(data.pagingCurrent)
					? data.pagingCurrent
					: self.current;

				self.limit = F.is.number(data.pagingLimit)
					? data.pagingLimit
					: self.limit;

				if (self.ft.$el.hasClass('footable-paging-left'))
					self.position = 'left';
				if (self.ft.$el.hasClass('footable-paging-center'))
					self.position = 'center';
				if (self.ft.$el.hasClass('footable-paging-right'))
					self.position = 'right';

				self.position = F.is.string(data.pagingPosition)
					? data.pagingPosition
					: self.position;

				self.countFormat = F.is.string(data.pagingCountFormat)
					? data.pagingCountFormat
					: self.countFormat;

				self.container = F.is.string(data.pagingContainer)
					? data.pagingContainer
					: self.container;

				self.total = Math.ceil(self.ft.rows.all.length / self.size);
			***REMOVED***, function(){
				self.enabled = false;
			***REMOVED***);
		***REMOVED***,
		/**
		 * Initializes the paging component for the plugin using the supplied table and options.
		 * @instance
		 * @protected
		 * @fires FooTable.Paging#"init.ft.paging"
		 */
		init: function(){
			/**
			 * The init.ft.paging event is raised before its UI is generated.
			 * Calling preventDefault on this event will disable the component.
			 * @event FooTable.Paging#"init.ft.paging"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			var self = this;
			this.ft.raise('init.ft.paging').then(function(){
				self.$create();
			***REMOVED***, function(){
				self.enabled = false;
			***REMOVED***);
		***REMOVED***,
		/**
		 * Destroys the paging component removing any UI generated from the table.
		 * @instance
		 * @protected
		 * @fires FooTable.Paging#"destroy.ft.paging"
		 */
		destroy: function () {
			/**
			 * The destroy.ft.paging event is raised before its UI is removed.
			 * Calling preventDefault on this event will prevent the component from being destroyed.
			 * @event FooTable.Paging#"destroy.ft.paging"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			var self = this;
			this.ft.raise('destroy.ft.paging').then(function(){
				self.ft.$el.removeClass('footable-paging')
					.find('tfoot > tr.footable-paging').remove();
				self.detached = true;
				self._createdLinks = 0;
			***REMOVED***);
		***REMOVED***,
		/**
		 * Performs the actual paging against the {@link FooTable.Rows#current***REMOVED*** array removing all rows that are not on the current visible page.
		 * @instance
		 * @protected
		 */
		predraw: function(){
			this.total = Math.ceil(this.ft.rows.array.length / this.size);
			this.current = this.current > this.total ? this.total : (this.current < 1 ? 1 : this.current);
			this.totalRows = this.ft.rows.array.length;
			if (this.totalRows > this.size){
				this.ft.rows.array = this.ft.rows.array.splice((this.current - 1) * this.size, this.size);
			***REMOVED***
			this.formattedCount = this.format(this.countFormat);
		***REMOVED***,
		/**
		 * Updates the paging UI setting the state of the pagination control.
		 * @instance
		 * @protected
		 */
		draw: function(){
			if (this.total <= 1){
				if (!this.detached){
					if (this.$row){
						this.$row.detach();
					***REMOVED*** else {
						this.$wrapper.detach();
					***REMOVED***
					this.detached = true;
				***REMOVED***
			***REMOVED*** else {
				if (this.detached){
					if (this.$row){
						var $tfoot = this.ft.$el.children('tfoot');
						if ($tfoot.length == 0){
							$tfoot = $('<tfoot/>');
							this.ft.$el.append($tfoot);
						***REMOVED***
						this.$row.appendTo($tfoot);
					***REMOVED*** else {
						this.$wrapper.appendTo(this.$container);
					***REMOVED***
					this.detached = false;
				***REMOVED***
				if (F.is.jq(this.$cell)){
					this.$cell.attr('colspan', this.ft.columns.visibleColspan);
				***REMOVED***
				this._createLinks();
				this._setVisible(this.current, this.current > this.previous);
				this._setNavigation(true);
				this.$count.text(this.formattedCount);
			***REMOVED***
		***REMOVED***,
		/**
		 * Creates the paging UI from the current options setting the various jQuery properties of this component.
		 * @instance
		 * @protected
		 */
		$create: function(){
			this._createdLinks = 0;
			var position = 'footable-paging-center';
			switch (this.position){
				case 'left': position = 'footable-paging-left'; break;
				case 'right': position = 'footable-paging-right'; break;
			***REMOVED***
			this.ft.$el.addClass('footable-paging').addClass(position);

			this.$container = this.container === null ? null : $(this.container).first();
			if (!F.is.jq(this.$container)){
				var $tfoot = this.ft.$el.children('tfoot');
				if ($tfoot.length == 0){
					$tfoot = $('<tfoot/>');
					this.ft.$el.append($tfoot);
				***REMOVED***
				// add it to a row and then populate it with the search input and column selector dropdown.
				this.$row = $('<tr/>', {'class': 'footable-paging'***REMOVED***).prependTo($tfoot);
				this.$container = this.$cell = $('<td/>').attr('colspan', this.ft.columns.visibleColspan).appendTo(this.$row);
			***REMOVED*** else {
				this.$container.addClass('footable-paging-external').addClass(position);
			***REMOVED***
			this.$wrapper = $('<div/>', {'class': 'footable-pagination-wrapper'***REMOVED***).appendTo(this.$container);
			this.$pagination = $('<ul/>', { 'class': 'pagination' ***REMOVED***).on('click.footable', 'a.footable-page-link', { self: this ***REMOVED***, this._onPageClicked);
			this.$count = $('<span/>', { 'class': 'label label-default' ***REMOVED***);
			this.$wrapper.append(this.$pagination, $('<div/>', {'class': 'divider'***REMOVED***), this.$count);
			this.detached = false;
		***REMOVED***,

		/* PUBLIC */
		/**
		 * @summary Uses the supplied format string and replaces the placeholder strings with the current values.
		 * @description This method is used to generate the short description label for the pagination control. i.e. Showing X of Y records. The placeholders for this string are the following:
		 * * {CP***REMOVED*** - The current page number.
		 * * {TP***REMOVED*** - The total number of pages.
		 * * {PF***REMOVED*** - The first row of the current page.
		 * * {PL***REMOVED*** - The last row of the current page.
		 * * {TR***REMOVED*** - The total rows available.
		 * These placeholders can be supplied in a string like; "Showing {PF***REMOVED*** to {PL***REMOVED*** of {TR***REMOVED*** rows."
		 * @param {string***REMOVED*** formatString - The string to be formatted with the paging specific variables.
		 * @returns {string***REMOVED***
		 */
		format: function(formatString){
			var firstRow = (this.size * (this.current - 1)) + 1,
				lastRow = this.size * this.current;
			if (this.ft.rows.array.length == 0){
				firstRow = 0;
				lastRow = 0;
			***REMOVED*** else {
				lastRow = lastRow > this.totalRows ? this.totalRows : lastRow;
			***REMOVED***
			return formatString.replace(/\{CP***REMOVED***/g, this.current)
				.replace(/\{TP***REMOVED***/g, this.total)
				.replace(/\{PF***REMOVED***/g, firstRow)
				.replace(/\{PL***REMOVED***/g, lastRow)
				.replace(/\{TR***REMOVED***/g, this.totalRows);
		***REMOVED***,
		/**
		 * Pages to the first page.
		 * @instance
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Paging#"before.ft.paging"
		 * @fires FooTable.Paging#"after.ft.paging"
		 */
		first: function(){
			return this._set(1);
		***REMOVED***,
		/**
		 * Pages to the previous page.
		 * @instance
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Paging#"before.ft.paging"
		 * @fires FooTable.Paging#"after.ft.paging"
		 */
		prev: function(){
			return this._set(this.current - 1 > 0 ? this.current - 1 : 1);
		***REMOVED***,
		/**
		 * Pages to the next page.
		 * @instance
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Paging#"before.ft.paging"
		 * @fires FooTable.Paging#"after.ft.paging"
		 */
		next: function(){
			return this._set(this.current + 1 < this.total ? this.current + 1 : this.total);
		***REMOVED***,
		/**
		 * Pages to the last page.
		 * @instance
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Paging#"before.ft.paging"
		 * @fires FooTable.Paging#"after.ft.paging"
		 */
		last: function(){
			return this._set(this.total);
		***REMOVED***,
		/**
		 * Pages to the specified page.
		 * @instance
		 * @param {number***REMOVED*** page - The page number to go to.
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Paging#"before.ft.paging"
		 * @fires FooTable.Paging#"after.ft.paging"
		 */
		goto: function(page){
			return this._set(page > this.total ? this.total : (page < 1 ? 1 : page));
		***REMOVED***,
		/**
		 * Shows the previous X number of pages in the pagination control where X is the value set by the {@link FooTable.Defaults#paging***REMOVED*** - limit option value.
		 * @instance
		 */
		prevPages: function(){
			var page = this.$pagination.children('li.footable-page.visible:first').data('page') - 1;
			this._setVisible(page, true);
			this._setNavigation(false);
		***REMOVED***,
		/**
		 * Shows the next X number of pages in the pagination control where X is the value set by the {@link FooTable.Defaults#paging***REMOVED*** - limit option value.
		 * @instance
		 */
		nextPages: function(){
			var page = this.$pagination.children('li.footable-page.visible:last').data('page') + 1;
			this._setVisible(page, false);
			this._setNavigation(false);
		***REMOVED***,
		/**
		 * Gets or sets the current page size.
		 * @instance
		 * @param {(number|string)***REMOVED*** [value] - The new page size to use, this value is supplied to `parseInt` so strings can be used. If not supplied or an invalid valid the current page size is returned.
		 * @returns {(number|undefined)***REMOVED***
		 */
		pageSize: function(value){
			value = parseInt(value);
			if (isNaN(value)){
				return this.size;
			***REMOVED***
			this.size = value;
			this.total = Math.ceil(this.ft.rows.all.length / this.size);
			if (F.is.jq(this.$wrapper)){
				if (this.$container.is("td")){
					this.$row.remove();
				***REMOVED*** else {
					this.$wrapper.remove();
				***REMOVED***
			***REMOVED***
			this.$create();
			this.ft.draw();
		***REMOVED***,

		/* PRIVATE */
		/**
		 * Performs the required steps to handle paging including the raising of the {@link FooTable.Paging#"before.ft.paging"***REMOVED*** and {@link FooTable.Paging#"after.ft.paging"***REMOVED*** events.
		 * @instance
		 * @private
		 * @param {number***REMOVED*** page - The page to set.
		 * @returns {jQuery.Promise***REMOVED***
		 * @fires FooTable.Paging#"before.ft.paging"
		 * @fires FooTable.Paging#"after.ft.paging"
		 */
		_set: function(page){
			var self = this,
				pager = new F.Pager(self.total, self.current, self.size, page, page > self.current);
			/**
			 * The before.ft.paging event is raised before a sort is applied and allows listeners to modify the pager or cancel it completely by calling preventDefault on the jQuery.Event object.
			 * @event FooTable.Paging#"before.ft.paging"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {FooTable.Pager***REMOVED*** pager - The pager that is about to be applied.
			 */
			return self.ft.raise('before.ft.paging', [pager]).then(function(){
				pager.page = pager.page > pager.total ? pager.total	: pager.page;
				pager.page = pager.page < 1 ? 1 : pager.page;
				if (self.current == page) return $.when();
				self.previous = self.current;
				self.current = pager.page;
				return self.ft.draw().then(function(){
					/**
					 * The after.ft.paging event is raised after a pager has been applied.
					 * @event FooTable.Paging#"after.ft.paging"
					 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
					 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
					 * @param {FooTable.Pager***REMOVED*** pager - The pager that has been applied.
					 */
					self.ft.raise('after.ft.paging', [pager]);
				***REMOVED***);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Creates the pagination links using the current state of the plugin. If the total number of pages is the same as
		 * the last time this function was executed it does nothing.
		 * @instance
		 * @private
		 */
		_createLinks: function(){
			if (this._createdLinks === this.total) return;
			var self = this,
				multiple = self.total > 1,
				link = function(attr, html, klass){
					return $('<li/>', {
						'class': klass
					***REMOVED***).attr('data-page', attr)
						.append($('<a/>', {
							'class': 'footable-page-link',
							href: '#'
						***REMOVED***).data('page', attr).html(html));
				***REMOVED***;
			self.$pagination.empty();
			if (multiple) {
				self.$pagination.append(link('first', self.strings.first, 'footable-page-nav'));
				self.$pagination.append(link('prev', self.strings.prev, 'footable-page-nav'));
				if (self.limit > 0 && self.limit < self.total){
					self.$pagination.append(link('prev-limit', self.strings.prevPages, 'footable-page-nav'));
				***REMOVED***
			***REMOVED***
			for (var i = 0, $li; i < self.total; i++){
				$li = link(i + 1, i + 1, 'footable-page');
				self.$pagination.append($li);
			***REMOVED***
			if (multiple){
				if (self.limit > 0 && self.limit < self.total){
					self.$pagination.append(link('next-limit', self.strings.nextPages, 'footable-page-nav'));
				***REMOVED***
				self.$pagination.append(link('next', self.strings.next, 'footable-page-nav'));
				self.$pagination.append(link('last', self.strings.last, 'footable-page-nav'));
			***REMOVED***
			self._createdLinks = self.total;
		***REMOVED***,
		/**
		 * Sets the state for the navigation links of the pagination control and optionally sets the active class state on the current page link.
		 * @instance
		 * @private
		 * @param {boolean***REMOVED*** active - Whether or not to set the active class state on the individual page links.
		 */
		_setNavigation: function(active){
			if (this.current == 1) {
				this.$pagination.children('li[data-page="first"],li[data-page="prev"]').addClass('disabled');
			***REMOVED*** else {
				this.$pagination.children('li[data-page="first"],li[data-page="prev"]').removeClass('disabled');
			***REMOVED***

			if (this.current == this.total) {
				this.$pagination.children('li[data-page="next"],li[data-page="last"]').addClass('disabled');
			***REMOVED*** else {
				this.$pagination.children('li[data-page="next"],li[data-page="last"]').removeClass('disabled');
			***REMOVED***

			if ((this.$pagination.children('li.footable-page.visible:first').data('page') || 1) == 1) {
				this.$pagination.children('li[data-page="prev-limit"]').addClass('disabled');
			***REMOVED*** else {
				this.$pagination.children('li[data-page="prev-limit"]').removeClass('disabled');
			***REMOVED***

			if ((this.$pagination.children('li.footable-page.visible:last').data('page') || this.limit) == this.total) {
				this.$pagination.children('li[data-page="next-limit"]').addClass('disabled');
			***REMOVED*** else {
				this.$pagination.children('li[data-page="next-limit"]').removeClass('disabled');
			***REMOVED***

			if (this.limit > 0 && this.total < this.limit){
				this.$pagination.children('li[data-page="prev-limit"],li[data-page="next-limit"]').css('display', 'none');
			***REMOVED*** else {
				this.$pagination.children('li[data-page="prev-limit"],li[data-page="next-limit"]').css('display', '');
			***REMOVED***

			if (active){
				this.$pagination.children('li.footable-page').removeClass('active').filter('li[data-page="' + this.current + '"]').addClass('active');
			***REMOVED***
		***REMOVED***,
		/**
		 * Sets the visible page using the supplied parameters.
		 * @instance
		 * @private
		 * @param {number***REMOVED*** page - The page to make visible.
		 * @param {boolean***REMOVED*** right - If set to true the supplied page will be the right most visible pagination link.
		 */
		_setVisible: function(page, right){
			if (this.limit > 0 && this.total > this.limit){
				if (!this.$pagination.children('li.footable-page[data-page="'+page+'"]').hasClass('visible')){
					var start = 0, end = 0;
					if (right == true){
						end = page > this.total ? this.total : page;
						start = end - this.limit;
					***REMOVED*** else {
						start = page < 1 ? 0 : page - 1;
						end = start + this.limit;
					***REMOVED***
					if (start < 0){
						start = 0;
						end = this.limit > this.total ? this.total : this.limit;
					***REMOVED***
					if (end > this.total){
						end = this.total;
						start = this.total - this.limit < 0 ? 0 : this.total - this.limit;
					***REMOVED***
					this.$pagination.children('li.footable-page').removeClass('visible').slice(start, end).addClass('visible');
				***REMOVED***
			***REMOVED*** else {
				this.$pagination.children('li.footable-page').removeClass('visible').slice(0, this.total).addClass('visible');
			***REMOVED***
		***REMOVED***,
		/**
		 * Handles the click event for all links in the pagination control.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The event object for the event.
		 */
		_onPageClicked: function(e){
			e.preventDefault();
			if ($(e.target).closest('li').is('.active,.disabled')) return;

			var self = e.data.self, page = $(this).data('page');
			switch(page){
				case 'first': self.first();
					return;
				case 'prev': self.prev();
					return;
				case 'next': self.next();
					return;
				case 'last': self.last();
					return;
				case 'prev-limit': self.prevPages();
					return;
				case 'next-limit': self.nextPages();
					return;
				default: self._set(page);
					return;
			***REMOVED***
		***REMOVED***
	***REMOVED***);

	F.components.register('paging', F.Paging, 400);

***REMOVED***)(jQuery, FooTable);
(function(F){
	/**
	 * An object containing the paging options for the plugin. Added by the {@link FooTable.Paging***REMOVED*** component.
	 * @type {object***REMOVED***
	 * @prop {boolean***REMOVED*** enabled=false - Whether or not to allow paging on the table.
	 * @prop {string***REMOVED*** countFormat="{CP***REMOVED*** of {TP***REMOVED***" - A string format used to generate the page count text.
	 * @prop {number***REMOVED*** current=1 - The page number to display.
	 * @prop {number***REMOVED*** limit=5 - The maximum number of page links to display at once.
	 * @prop {string***REMOVED*** position="center" - The string used to specify the alignment of the pagination control.
	 * @prop {number***REMOVED*** size=10 - The number of rows displayed per page.
	 * @prop {string***REMOVED*** container=null - A selector specifying where to place the paging components UI, if null the UI is displayed within a row in the foot of the table.
	 * @prop {object***REMOVED*** strings - An object containing the strings used by the paging buttons.
	 * @prop {string***REMOVED*** strings.first="&laquo;" - The string used for the 'first' button.
	 * @prop {string***REMOVED*** strings.prev="&lsaquo;" - The string used for the 'previous' button.
	 * @prop {string***REMOVED*** strings.next="&rsaquo;" - The string used for the 'next' button.
	 * @prop {string***REMOVED*** strings.last="&raquo;" - The string used for the 'last' button.
	 * @prop {string***REMOVED*** strings.prevPages="..." - The string used for the 'previous X pages' button.
	 * @prop {string***REMOVED*** strings.nextPages="..." - The string used for the 'next X pages' button.
	 */
	F.Defaults.prototype.paging = {
		enabled: false,
		countFormat: '{CP***REMOVED*** of {TP***REMOVED***',
		current: 1,
		limit: 5,
		position: 'center',
		size: 10,
		container: null,
		strings: {
			first: '&laquo;',
			prev: '&lsaquo;',
			next: '&rsaquo;',
			last: '&raquo;',
			prevPages: '...',
			nextPages: '...'
		***REMOVED***
	***REMOVED***;
***REMOVED***)(FooTable);
(function(F){
	/**
	 * Navigates to the specified page number. Added by the {@link FooTable.Paging***REMOVED*** component.
	 * @instance
	 * @param {number***REMOVED*** num - The page number to go to.
	 * @returns {jQuery.Promise***REMOVED***
	 * @fires FooTable.Paging#paging_changing
	 * @fires FooTable.Paging#paging_changed
	 * @see FooTable.Paging#goto
	 */
	F.Table.prototype.gotoPage = function(num){
		return this.use(F.Paging).goto(num);
	***REMOVED***;

	/**
	 * Navigates to the next page. Added by the {@link FooTable.Paging***REMOVED*** component.
	 * @instance
	 * @returns {jQuery.Promise***REMOVED***
	 * @fires FooTable.Paging#paging_changing
	 * @fires FooTable.Paging#paging_changed
	 * @see FooTable.Paging#next
	 */
	F.Table.prototype.nextPage = function(){
		return this.use(F.Paging).next();
	***REMOVED***;

	/**
	 * Navigates to the previous page. Added by the {@link FooTable.Paging***REMOVED*** component.
	 * @instance
	 * @returns {jQuery.Promise***REMOVED***
	 * @fires FooTable.Paging#paging_changing
	 * @fires FooTable.Paging#paging_changed
	 * @see FooTable.Paging#prev
	 */
	F.Table.prototype.prevPage = function(){
		return this.use(F.Paging).prev();
	***REMOVED***;

	/**
	 * Navigates to the first page. Added by the {@link FooTable.Paging***REMOVED*** component.
	 * @instance
	 * @returns {jQuery.Promise***REMOVED***
	 * @fires FooTable.Paging#paging_changing
	 * @fires FooTable.Paging#paging_changed
	 * @see FooTable.Paging#first
	 */
	F.Table.prototype.firstPage = function(){
		return this.use(F.Paging).first();
	***REMOVED***;

	/**
	 * Navigates to the last page. Added by the {@link FooTable.Paging***REMOVED*** component.
	 * @instance
	 * @returns {jQuery.Promise***REMOVED***
	 * @fires FooTable.Paging#paging_changing
	 * @fires FooTable.Paging#paging_changed
	 * @see FooTable.Paging#last
	 */
	F.Table.prototype.lastPage = function(){
		return this.use(F.Paging).last();
	***REMOVED***;

	/**
	 * Shows the next X number of pages in the pagination control where X is the value set by the {@link FooTable.Defaults#paging***REMOVED*** - limit.size option value. Added by the {@link FooTable.Paging***REMOVED*** component.
	 * @instance
	 * @see FooTable.Paging#nextPages
	 */
	F.Table.prototype.nextPages = function(){
		return this.use(F.Paging).nextPages();
	***REMOVED***;

	/**
	 * Shows the previous X number of pages in the pagination control where X is the value set by the {@link FooTable.Defaults#paging***REMOVED*** - limit.size option value. Added by the {@link FooTable.Paging***REMOVED*** component.
	 * @instance
	 * @see FooTable.Paging#prevPages
	 */
	F.Table.prototype.prevPages = function(){
		return this.use(F.Paging).prevPages();
	***REMOVED***;

	/**
	 * Gets or sets the current page size
	 * @instance
	 * @param {number***REMOVED*** [value] - The new page size to use.
	 * @returns {(number|undefined)***REMOVED***
	 * @see FooTable.Paging#pageSize
	 */
	F.Table.prototype.pageSize = function(value){
		return this.use(F.Paging).pageSize(value);
	***REMOVED***;
***REMOVED***)(FooTable);
(function($, F){

	F.Editing = F.Component.extend(/** @lends FooTable.Editing */{
		/**
		 * The editing component adds a column with edit and delete buttons to each row as well as a single add row button in the footer.
		 * @constructs
		 * @extends FooTable.Component
		 * @param {FooTable.Table***REMOVED*** table - The parent {@link FooTable.Table***REMOVED*** object for the component.
		 * @returns {FooTable.Editing***REMOVED***
		 */
		construct: function(table){
			// call the base constructor
			this._super(table, table.o.editing.enabled);

			/**
			 * Whether or not to automatically page to a new row when it is added to the table.
			 * @type {boolean***REMOVED***
			 */
			this.pageToNew = table.o.editing.pageToNew;

			/**
			 * Whether or not the editing column and add row button are always visible.
			 * @type {boolean***REMOVED***
			 */
			this.alwaysShow = table.o.editing.alwaysShow;

			/**
			 * The options for the editing column. @see {@link FooTable.EditingColumn***REMOVED*** for more info.
			 * @type {object***REMOVED***
			 * @prop {string***REMOVED*** classes="footable-editing" - A space separated string of class names to apply to all cells in the column.
			 * @prop {string***REMOVED*** name="editing" - The name of the column.
			 * @prop {string***REMOVED*** title="" - The title displayed in the header row of the table for the column.
			 * @prop {boolean***REMOVED*** filterable=false - Whether or not the column should be filterable when using the filtering component.
			 * @prop {boolean***REMOVED*** sortable=false - Whether or not the column should be sortable when using the sorting component.
			 */
			this.column = $.extend(true, {***REMOVED***, table.o.editing.column, {visible: this.alwaysShow***REMOVED***);

			/**
			 * The position of the editing column in the table as well as the alignment of the buttons.
			 * @type {string***REMOVED***
			 */
			this.position = table.o.editing.position;


			/**
			 * The text that appears in the show button. This can contain HTML.
			 * @type {string***REMOVED***
			 */
			this.showText = table.o.editing.showText;

			/**
			 * The text that appears in the hide button. This can contain HTML.
			 * @type {string***REMOVED***
			 */
			this.hideText = table.o.editing.hideText;

			/**
			 * The text that appears in the add button. This can contain HTML.
			 * @type {string***REMOVED***
			 */
			this.addText = table.o.editing.addText;

			/**
			 * The text that appears in the edit button. This can contain HTML.
			 * @type {string***REMOVED***
			 */
			this.editText = table.o.editing.editText;

			/**
			 * The text that appears in the delete button. This can contain HTML.
			 * @type {string***REMOVED***
			 */
			this.deleteText = table.o.editing.deleteText;
			
			/**
			 * The text that appears in the view button. This can contain HTML.
			 * @type {string***REMOVED***
			 */
			this.viewText = table.o.editing.viewText;

			/**
			 * Whether or not to show the Add Row button.
			 * @type {boolean***REMOVED***
			 */
			this.allowAdd = table.o.editing.allowAdd;

			/**
			 * Whether or not to show the Edit Row button.
			 * @type {boolean***REMOVED***
			 */
			this.allowEdit = table.o.editing.allowEdit;

			/**
			 * Whether or not to show the Delete Row button.
			 * @type {boolean***REMOVED***
			 */
			this.allowDelete = table.o.editing.allowDelete;

			/**
			 * Whether or not to show the View Row button.
			 * @type {boolean***REMOVED***
			 */
			this.allowView = table.o.editing.allowView;

			/**
			 * Caches the row button elements to help with performance.
			 * @type {(null|jQuery)***REMOVED***
			 * @private
			 */
			this._$buttons = null;

			/**
			 * This object is used to contain the callbacks for the add, edit and delete row buttons.
			 * @type {object***REMOVED***
			 * @prop {function***REMOVED*** addRow
			 * @prop {function***REMOVED*** editRow
			 * @prop {function***REMOVED*** deleteRow
			 * @prop {function***REMOVED*** viewRow
			 */
			this.callbacks = {
				addRow: F.checkFnValue(this, table.o.editing.addRow),
				editRow: F.checkFnValue(this, table.o.editing.editRow),
				deleteRow: F.checkFnValue(this, table.o.editing.deleteRow),
				viewRow: F.checkFnValue(this, table.o.editing.viewRow)
			***REMOVED***;
		***REMOVED***,
		/* PROTECTED */
		/**
		 * Checks the supplied data and options for the editing component.
		 * @instance
		 * @protected
		 * @param {object***REMOVED*** data - The jQuery data object from the parent table.
		 * @fires FooTable.Editing#"preinit.ft.editing"
		 */
		preinit: function(data){
			var self = this;
			/**
			 * The preinit.ft.editing event is raised before the UI is created and provides the tables jQuery data object for additional options parsing.
			 * Calling preventDefault on this event will disable the component.
			 * @event FooTable.Editing#"preinit.ft.editing"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {object***REMOVED*** data - The jQuery data object of the table raising the event.
			 */
			this.ft.raise('preinit.ft.editing', [data]).then(function(){
				if (self.ft.$el.hasClass('footable-editing'))
					self.enabled = true;

				self.enabled = F.is.boolean(data.editing)
					? data.editing
					: self.enabled;

				if (!self.enabled) return;

				self.pageToNew = F.is.boolean(data.editingPageToNew) ? data.editingPageToNew : self.pageToNew;

				self.alwaysShow = F.is.boolean(data.editingAlwaysShow) ? data.editingAlwaysShow : self.alwaysShow;

				self.position = F.is.string(data.editingPosition) ? data.editingPosition : self.position;

				self.showText = F.is.string(data.editingShowText) ? data.editingShowText : self.showText;

				self.hideText = F.is.string(data.editingHideText) ? data.editingHideText : self.hideText;

				self.addText = F.is.string(data.editingAddText) ? data.editingAddText : self.addText;

				self.editText = F.is.string(data.editingEditText) ? data.editingEditText : self.editText;

				self.deleteText = F.is.string(data.editingDeleteText) ? data.editingDeleteText : self.deleteText;

				self.viewText = F.is.string(data.editingViewText) ? data.editingViewText : self.viewText;

				self.allowAdd = F.is.boolean(data.editingAllowAdd) ? data.editingAllowAdd : self.allowAdd;

				self.allowEdit = F.is.boolean(data.editingAllowEdit) ? data.editingAllowEdit : self.allowEdit;

				self.allowDelete = F.is.boolean(data.editingAllowDelete) ? data.editingAllowDelete : self.allowDelete;

				self.allowView = F.is.boolean(data.editingAllowView) ? data.editingAllowView : self.allowView;

				self.column = new F.EditingColumn(self.ft, self, $.extend(true, {***REMOVED***, self.column, data.editingColumn, {visible: self.alwaysShow***REMOVED***));

				if (self.ft.$el.hasClass('footable-editing-left'))
					self.position = 'left';

				if (self.ft.$el.hasClass('footable-editing-right'))
					self.position = 'right';

				if (self.position === 'right'){
					self.column.index = self.ft.columns.array.length;
				***REMOVED*** else {
					self.column.index = 0;
					for (var i = 0, len = self.ft.columns.array.length; i < len; i++){
						self.ft.columns.array[i].index += 1;
					***REMOVED***
				***REMOVED***
				self.ft.columns.array.push(self.column);
				self.ft.columns.array.sort(function(a, b){ return a.index - b.index; ***REMOVED***);

				self.callbacks.addRow = F.checkFnValue(self, data.editingAddRow, self.callbacks.addRow);
				self.callbacks.editRow = F.checkFnValue(self, data.editingEditRow, self.callbacks.editRow);
				self.callbacks.deleteRow = F.checkFnValue(self, data.editingDeleteRow, self.callbacks.deleteRow);
				self.callbacks.viewRow = F.checkFnValue(self, data.editingViewRow, self.callbacks.viewRow);
			***REMOVED***, function(){
				self.enabled = false;
			***REMOVED***);
		***REMOVED***,
		/**
		 * Initializes the editing component for the plugin using the supplied table and options.
		 * @instance
		 * @protected
		 * @fires FooTable.Editing#"init.ft.editing"
		 */
		init: function(){
			/**
			 * The init.ft.editing event is raised before its UI is generated.
			 * Calling preventDefault on this event will disable the component.
			 * @event FooTable.Editing#"init.ft.editing"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			var self = this;
			this.ft.raise('init.ft.editing').then(function(){
				self.$create();
			***REMOVED***, function(){
				self.enabled = false;
			***REMOVED***);
		***REMOVED***,
		/**
		 * Destroys the editing component removing any UI generated from the table.
		 * @instance
		 * @protected
		 * @fires FooTable.Editing#"destroy.ft.editing"
		 */
		destroy: function () {
			/**
			 * The destroy.ft.editing event is raised before its UI is removed.
			 * Calling preventDefault on this event will prevent the component from being destroyed.
			 * @event FooTable.Editing#"destroy.ft.editing"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			var self = this;
			this.ft.raise('destroy.ft.editing').then(function(){
				self.ft.$el.removeClass('footable-editing footable-editing-always-show footable-editing-no-add footable-editing-no-edit footable-editing-no-delete footable-editing-no-view')
					.off('click.ft.editing').find('tfoot > tr.footable-editing').remove();
			***REMOVED***);
		***REMOVED***,
		/**
		 * Creates the editing UI from the current options setting the various jQuery properties of this component.
		 * @instance
		 * @protected
		 */
		$create: function(){
			var self = this, position = self.position === 'right' ? 'footable-editing-right' : 'footable-editing-left';
			self.ft.$el.addClass('footable-editing').addClass(position)
				.on('click.ft.editing', '.footable-show', {self: self***REMOVED***, self._onShowClick)
				.on('click.ft.editing', '.footable-hide', {self: self***REMOVED***, self._onHideClick)
				.on('click.ft.editing', '.footable-edit', {self: self***REMOVED***, self._onEditClick)
				.on('click.ft.editing', '.footable-delete', {self: self***REMOVED***, self._onDeleteClick)
				.on('click.ft.editing', '.footable-view', {self: self***REMOVED***, self._onViewClick)
				.on('click.ft.editing', '.footable-add', {self: self***REMOVED***, self._onAddClick);

			self.$cell = $('<td/>').attr('colspan', self.ft.columns.visibleColspan).append(self.$buttonShow());
			if (self.allowAdd){
				self.$cell.append(self.$buttonAdd());
			***REMOVED***
			self.$cell.append(self.$buttonHide());

			if (self.alwaysShow){
				self.ft.$el.addClass('footable-editing-always-show');
			***REMOVED***

			if (!self.allowAdd) self.ft.$el.addClass('footable-editing-no-add');
			if (!self.allowEdit) self.ft.$el.addClass('footable-editing-no-edit');
			if (!self.allowDelete) self.ft.$el.addClass('footable-editing-no-delete');
			if (!self.allowView) self.ft.$el.addClass('footable-editing-no-view');

			var $tfoot = self.ft.$el.children('tfoot');
			if ($tfoot.length == 0){
				$tfoot = $('<tfoot/>');
				self.ft.$el.append($tfoot);
			***REMOVED***
			self.$row = $('<tr/>', { 'class': 'footable-editing' ***REMOVED***).append(self.$cell).appendTo($tfoot);
		***REMOVED***,
		/**
		 * Creates the show button for the editing component.
		 * @instance
		 * @protected
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 */
		$buttonShow: function(){
			return '<button type="button" class="btn btn-primary footable-show">' + this.showText + '</button>';
		***REMOVED***,
		/**
		 * Creates the hide button for the editing component.
		 * @instance
		 * @protected
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 */
		$buttonHide: function(){
			return '<button type="button" class="btn btn-default footable-hide">' + this.hideText + '</button>';
		***REMOVED***,
		/**
		 * Creates the add button for the editing component.
		 * @instance
		 * @protected
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 */
		$buttonAdd: function(){
			return '<button type="button" class="btn btn-primary footable-add">' + this.addText + '</button> ';
		***REMOVED***,
		/**
		 * Creates the edit button for the editing component.
		 * @instance
		 * @protected
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 */
		$buttonEdit: function(){
			return '<button type="button" class="btn btn-default footable-edit">' + this.editText + '</button> ';
		***REMOVED***,
		/**
		 * Creates the delete button for the editing component.
		 * @instance
		 * @protected
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 */
		$buttonDelete: function(){
			return '<button type="button" class="btn btn-default footable-delete">' + this.deleteText + '</button>';
		***REMOVED***,
		/**
		 * Creates the view button for the editing component.
		 * @instance
		 * @protected
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 */
		$buttonView: function(){
			return '<button type="button" class="btn btn-default footable-view">' + this.viewText + '</button> ';
		***REMOVED***,
		/**
		 * Creates the button group for the row buttons.
		 * @instance
		 * @protected
		 * @returns {(string|HTMLElement|jQuery)***REMOVED***
		 */
		$rowButtons: function(){
			if (F.is.jq(this._$buttons)) return this._$buttons.clone();
			this._$buttons = $('<div class="btn-group btn-group-xs" role="group"></div>');
			if (this.allowView) this._$buttons.append(this.$buttonView());
			if (this.allowEdit) this._$buttons.append(this.$buttonEdit());
			if (this.allowDelete) this._$buttons.append(this.$buttonDelete());
			return this._$buttons;
		***REMOVED***,
		/**
		 * Performs the drawing of the component.
		 */
		draw: function(){
			this.$cell.attr('colspan', this.ft.columns.visibleColspan);
		***REMOVED***,
		/**
		 * Handles the edit button click event.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
		 * @fires FooTable.Editing#"edit.ft.editing"
		 */
		_onEditClick: function(e){
			e.preventDefault();
			var self = e.data.self, row = $(this).closest('tr').data('__FooTableRow__');
			if (row instanceof F.Row){
				/**
				 * The edit.ft.editing event is raised before its callback is executed.
				 * Calling preventDefault on this event will prevent the callback from being executed.
				 * @event FooTable.Editing#"edit.ft.editing"
				 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
				 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
				 * @param {FooTable.Row***REMOVED*** row - The row to be edited.
				 */
				self.ft.raise('edit.ft.editing', [row]).then(function(){
					self.callbacks.editRow.call(self.ft, row);
				***REMOVED***);
			***REMOVED***
		***REMOVED***,
		/**
		 * Handles the delete button click event.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
		 * @fires FooTable.Editing#"delete.ft.editing"
		 */
		_onDeleteClick: function(e){
			e.preventDefault();
			var self = e.data.self, row = $(this).closest('tr').data('__FooTableRow__');
			if (row instanceof F.Row){
				/**
				 * The delete.ft.editing event is raised before its callback is executed.
				 * Calling preventDefault on this event will prevent the callback from being executed.
				 * @event FooTable.Editing#"delete.ft.editing"
				 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
				 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
				 * @param {FooTable.Row***REMOVED*** row - The row to be deleted.
				 */
				self.ft.raise('delete.ft.editing', [row]).then(function(){
					self.callbacks.deleteRow.call(self.ft, row);
				***REMOVED***);
			***REMOVED***
		***REMOVED***,
		/**
		 * Handles the view button click event.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
		 * @fires FooTable.Editing#"view.ft.editing"
		 */
		_onViewClick: function(e){
			e.preventDefault();
			var self = e.data.self, row = $(this).closest('tr').data('__FooTableRow__');
			if (row instanceof F.Row){
				/**
				 * The view.ft.editing event is raised before its callback is executed.
				 * Calling preventDefault on this event will prevent the callback from being executed.
				 * @event FooTable.Editing#"view.ft.editing"
				 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
				 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
				 * @param {FooTable.Row***REMOVED*** row - The row to be viewed.
				 */
				self.ft.raise('view.ft.editing', [row]).then(function(){
					self.callbacks.viewRow.call(self.ft, row);
				***REMOVED***);
			***REMOVED***
		***REMOVED***,
		/**
		 * Handles the add button click event.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
		 * @fires FooTable.Editing#"add.ft.editing"
		 */
		_onAddClick: function(e){
			e.preventDefault();
			var self = e.data.self;
			/**
			 * The add.ft.editing event is raised before its callback is executed.
			 * Calling preventDefault on this event will prevent the callback from being executed.
			 * @event FooTable.Editing#"add.ft.editing"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			self.ft.raise('add.ft.editing').then(function(){
				self.callbacks.addRow.call(self.ft);
			***REMOVED***);
		***REMOVED***,
		/**
		 * Handles the show button click event.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
		 * @fires FooTable.Editing#"show.ft.editing"
		 */
		_onShowClick: function(e){
			e.preventDefault();
			var self = e.data.self;
			/**
			 * The show.ft.editing event is raised before its callback is executed.
			 * Calling preventDefault on this event will prevent the callback from being executed.
			 * @event FooTable.Editing#"show.ft.editing"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			self.ft.raise('show.ft.editing').then(function(){
				self.ft.$el.addClass('footable-editing-show');
				self.column.visible = true;
				self.ft.draw();
			***REMOVED***);
		***REMOVED***,
		/**
		 * Handles the hide button click event.
		 * @instance
		 * @private
		 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
		 * @fires FooTable.Editing#"show.ft.editing"
		 */
		_onHideClick: function(e){
			e.preventDefault();
			var self = e.data.self;
			/**
			 * The hide.ft.editing event is raised before its callback is executed.
			 * Calling preventDefault on this event will prevent the callback from being executed.
			 * @event FooTable.Editing#"hide.ft.editing"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 */
			self.ft.raise('hide.ft.editing').then(function(){
				self.ft.$el.removeClass('footable-editing-show');
				self.column.visible = false;
				self.ft.draw();
			***REMOVED***);
		***REMOVED***
	***REMOVED***);

	F.components.register('editing', F.Editing, 850);

***REMOVED***)(jQuery, FooTable);

(function($, F){

	F.EditingColumn = F.Column.extend(/** @lends FooTable.EditingColumn */{
		/**
		 * The Editing column class is used to create the column containing the editing buttons.
		 * @constructs
		 * @extends FooTable.Column
		 * @param {FooTable.Table***REMOVED*** instance -  The parent {@link FooTable.Table***REMOVED*** this column belongs to.
		 * @param {FooTable.Editing***REMOVED*** editing - The parent {@link FooTable.Editing***REMOVED*** component this column is used with.
		 * @param {object***REMOVED*** definition - An object containing all the properties to set for the column.
		 * @returns {FooTable.EditingColumn***REMOVED***
		 */
		construct: function(instance, editing, definition){
			this._super(instance, definition, 'editing');
			this.editing = editing;
			this.internal = true;
		***REMOVED***,
		/**
		 * After the column has been defined this ensures that the $el property is a jQuery object by either creating or updating the current value.
		 * @instance
		 * @protected
		 * @this FooTable.Column
		 */
		$create: function(){
			(this.$el = !this.virtual && F.is.jq(this.$el) ? this.$el : $('<th/>', {'class': 'footable-editing'***REMOVED***)).html(this.title);
		***REMOVED***,
		/**
		 * This is supplied either the cell value or jQuery object to parse. Any value can be returned from this method and
		 * will be provided to the {@link FooTable.EditingColumn#format***REMOVED*** function
		 * to generate the cell contents.
		 * @instance
		 * @protected
		 * @param {(*|jQuery)***REMOVED*** valueOrElement - The value or jQuery cell object.
		 * @returns {(jQuery)***REMOVED***
		 */
		parser: function(valueOrElement){
			if (F.is.string(valueOrElement)) valueOrElement = $($.trim(valueOrElement));
			if (F.is.element(valueOrElement)) valueOrElement = $(valueOrElement);
			if (F.is.jq(valueOrElement)){
				var tagName = valueOrElement.prop('tagName').toLowerCase();
				if (tagName == 'td' || tagName == 'th') return valueOrElement.data('value') || valueOrElement.contents();
				return valueOrElement;
			***REMOVED***
			return null;
		***REMOVED***,
		/**
		 * Creates a cell to be used in the supplied row for this column.
		 * @param {FooTable.Row***REMOVED*** row - The row to create the cell for.
		 * @returns {FooTable.Cell***REMOVED***
		 */
		createCell: function(row){
			var $buttons = this.editing.$rowButtons(), $cell = $('<td/>').append($buttons);
			if (F.is.jq(row.$el)){
				if (this.index === 0){
					$cell.prependTo(row.$el);
				***REMOVED*** else {
					$cell.insertAfter(row.$el.children().eq(this.index-1));
				***REMOVED***
			***REMOVED***
			return new F.Cell(this.ft, row, this, $cell || $cell.html());
		***REMOVED***
	***REMOVED***);

	F.columns.register('editing', F.EditingColumn);

***REMOVED***)(jQuery, FooTable);
(function($, F) {

	/**
	 * An object containing the editing options for the plugin. Added by the {@link FooTable.Editing***REMOVED*** component.
	 * @type {object***REMOVED***
	 * @prop {boolean***REMOVED*** enabled=false - Whether or not to allow editing on the table.
	 * @prop {boolean***REMOVED*** pageToNew=true - Whether or not to automatically page to a new row when it is added to the table.
	 * @prop {string***REMOVED*** position="right" - The position of the editing column in the table as well as the alignment of the buttons.
	 * @prop {boolean***REMOVED*** alwaysShow=false - Whether or not the editing column and add row button are always visible.
	 * @prop {function***REMOVED*** addRow - The callback function to execute when the add row button is clicked.
	 * @prop {function***REMOVED*** editRow - The callback function to execute when the edit row button is clicked.
	 * @prop {function***REMOVED*** deleteRow - The callback function to execute when the delete row button is clicked.
	 * @prop {function***REMOVED*** viewRow - The callback function to execute when the view row button is clicked.
	 * @prop {string***REMOVED*** showText - The text that appears in the show button. This can contain HTML.
	 * @prop {string***REMOVED*** hideText - The text that appears in the hide button. This can contain HTML.
	 * @prop {string***REMOVED*** addText - The text that appears in the add button. This can contain HTML.
	 * @prop {string***REMOVED*** editText - The text that appears in the edit button. This can contain HTML.
	 * @prop {string***REMOVED*** deleteText - The text that appears in the delete button. This can contain HTML.
	 * @prop {string***REMOVED*** viewText - The text that appears in the view button. This can contain HTML.
	 * @prop {boolean***REMOVED*** allowAdd - Whether or not to show the Add Row button.
	 * @prop {boolean***REMOVED*** allowEdit - Whether or not to show the Edit Row button.
	 * @prop {boolean***REMOVED*** allowDelete - Whether or not to show the Delete Row button.
	 * @prop {boolean***REMOVED*** allowView - Whether or not to show the View Row button.
	 * @prop {object***REMOVED*** column - The options for the editing column. @see {@link FooTable.EditingColumn***REMOVED*** for more info.
	 * @prop {string***REMOVED*** column.classes="footable-editing" - A space separated string of class names to apply to all cells in the column.
	 * @prop {string***REMOVED*** column.name="editing" - The name of the column.
	 * @prop {string***REMOVED*** column.title="" - The title displayed in the header row of the table for the column.
	 * @prop {boolean***REMOVED*** column.filterable=false - Whether or not the column should be filterable when using the filtering component.
	 * @prop {boolean***REMOVED*** column.sortable=false - Whether or not the column should be sortable when using the sorting component.
	 */
	F.Defaults.prototype.editing = {
		enabled: false,
		pageToNew: true,
		position: 'right',
		alwaysShow: false,
		addRow: function(){***REMOVED***,
		editRow: function(row){***REMOVED***,
		deleteRow: function(row){***REMOVED***,
		viewRow: function(row){***REMOVED***,
		showText: '<span class="fooicon fooicon-pencil" aria-hidden="true"></span> Edit rows',
		hideText: 'Cancel',
		addText: 'New row',
		editText: '<span class="fooicon fooicon-pencil" aria-hidden="true"></span>',
		deleteText: '<span class="fooicon fooicon-trash" aria-hidden="true"></span>',
		viewText: '<span class="fooicon fooicon-stats" aria-hidden="true"></span>',
		allowAdd: true,
		allowEdit: true,
		allowDelete: true,
		allowView: false,
		column: {
			classes: 'footable-editing',
			name: 'editing',
			title: '',
			filterable: false,
			sortable: false
		***REMOVED***
	***REMOVED***;

***REMOVED***)(jQuery, FooTable);

(function($, F){

	if (F.is.defined(F.Paging)){
		/**
		 * Holds a shallow clone of the un-paged {@link FooTable.Rows#array***REMOVED*** value before paging occurs and superfluous rows are removed. Added by the {@link FooTable.Editing***REMOVED*** component.
		 * @instance
		 * @public
		 * @type {Array<FooTable.Row>***REMOVED***
		 */
		F.Paging.prototype.unpaged = [];

		// override the default predraw method with one that sets the unpaged property.
		F.Paging.extend('predraw', function(){
			this.unpaged = this.ft.rows.array.slice(0); // create a shallow clone for later use
			this._super(); // call the original method
		***REMOVED***);
	***REMOVED***

***REMOVED***)(jQuery, FooTable);
(function($, F){

	/**
	 * Adds the row to the table.
	 * @param {boolean***REMOVED*** [redraw=true] - Whether or not to redraw the table, defaults to true but for bulk operations this
	 * can be set to false and then followed by a call to the {@link FooTable.Table#draw***REMOVED*** method.
	 * @returns {jQuery.Deferred***REMOVED***
	 */
	F.Row.prototype.add = function(redraw){
		redraw = F.is.boolean(redraw) ? redraw : true;
		var self = this;
		return $.Deferred(function(d){
			var index = self.ft.rows.all.push(self) - 1;
			if (redraw){
				return self.ft.draw().then(function(){
					d.resolve(index);
				***REMOVED***);
			***REMOVED*** else {
				d.resolve(index);
			***REMOVED***
		***REMOVED***);
	***REMOVED***;

	/**
	 * Removes the row from the table.
	 * @param {boolean***REMOVED*** [redraw=true] - Whether or not to redraw the table, defaults to true but for bulk operations this
	 * can be set to false and then followed by a call to the {@link FooTable.Table#draw***REMOVED*** method.
	 * @returns {jQuery.Deferred***REMOVED***
	 */
	F.Row.prototype.delete = function(redraw){
		redraw = F.is.boolean(redraw) ? redraw : true;
		var self = this;
		return $.Deferred(function(d){
			var index = self.ft.rows.all.indexOf(self);
			if (F.is.number(index) && index >= 0 && index < self.ft.rows.all.length){
				self.ft.rows.all.splice(index, 1);
				if (redraw){
					return self.ft.draw().then(function(){
						d.resolve(self);
					***REMOVED***);
				***REMOVED***
			***REMOVED***
			d.resolve(self);
		***REMOVED***);
	***REMOVED***;

	if (F.is.defined(F.Paging)){
		// override the default add method with one that supports paging
		F.Row.extend('add', function(redraw){
			redraw = F.is.boolean(redraw) ? redraw : true;
			var self = this,
				added = this._super(redraw),
				editing = self.ft.use(F.Editing),
				paging;
			if (editing && editing.pageToNew && (paging = self.ft.use(F.Paging)) && redraw){
				return added.then(function(){
					var index = paging.unpaged.indexOf(self); // find this row in the unpaged array (this array will be sorted and filtered)
					var page = Math.ceil((index + 1) / paging.size); // calculate the page the new row is on
					if (paging.current !== page){ // goto the page if we need to
						return paging.goto(page);
					***REMOVED***
				***REMOVED***);
			***REMOVED***
			return added;
		***REMOVED***);
	***REMOVED***

	if (F.is.defined(F.Sorting)){
		// override the default val method with one that supports sorting and paging
		F.Row.extend('val', function(data, redraw){
			redraw = F.is.boolean(redraw) ? redraw : true;
			var result = this._super(data);
			if (!F.is.hash(data)){
				return result;
			***REMOVED***
			var self = this;
			if (redraw){
				self.ft.draw().then(function(){
					var editing = self.ft.use(F.Editing), paging;
					if (F.is.defined(F.Paging) && editing && editing.pageToNew && (paging = self.ft.use(F.Paging))){
						var index = paging.unpaged.indexOf(self); // find this row in the unpaged array (this array will be sorted and filtered)
						var page = Math.ceil((index + 1) / paging.size); // calculate the page the new row is on
						if (paging.current !== page){ // goto the page if we need to
							return paging.goto(page);
						***REMOVED***
					***REMOVED***
				***REMOVED***);
			***REMOVED***
			return result;
		***REMOVED***);
	***REMOVED***

***REMOVED***)(jQuery, FooTable);
(function(F){

	/**
	 * Adds a row to the underlying {@link FooTable.Rows#all***REMOVED*** array.
	 * @param {(object|FooTable.Row)***REMOVED*** dataOrRow - A hash containing the row values or an actual {@link FooTable.Row***REMOVED*** object.
	 * @param {boolean***REMOVED*** [redraw=true] - Whether or not to redraw the table, defaults to true but for bulk operations this
	 * can be set to false and then followed by a call to the {@link FooTable.Table#draw***REMOVED*** method.
	 */
	F.Rows.prototype.add = function(dataOrRow, redraw){
		var row = dataOrRow;
		if (F.is.hash(dataOrRow)){
			row = new FooTable.Row(this.ft, this.ft.columns.array, dataOrRow);
		***REMOVED***
		if (row instanceof FooTable.Row){
			row.add(redraw);
		***REMOVED***
	***REMOVED***;

	/**
	 * Updates a row in the underlying {@link FooTable.Rows#all***REMOVED*** array.
	 * @param {(number|FooTable.Row)***REMOVED*** indexOrRow - The index to update or the actual {@link FooTable.Row***REMOVED*** object.
	 * @param {object***REMOVED*** data - A hash containing the new row values.
	 * @param {boolean***REMOVED*** [redraw=true] - Whether or not to redraw the table, defaults to true but for bulk operations this
	 * can be set to false and then followed by a call to the {@link FooTable.Table#draw***REMOVED*** method.
	 */
	F.Rows.prototype.update = function(indexOrRow, data, redraw){
		var len = this.ft.rows.all.length, 
			row = indexOrRow;
		if (F.is.number(indexOrRow) && indexOrRow >= 0 && indexOrRow < len){
			row = this.ft.rows.all[indexOrRow];
		***REMOVED***
		if (row instanceof FooTable.Row && F.is.hash(data)){
			row.val(data, redraw);
		***REMOVED***
	***REMOVED***;

	/**
	 * Deletes a row from the underlying {@link FooTable.Rows#all***REMOVED*** array.
	 * @param {(number|FooTable.Row)***REMOVED*** indexOrRow - The index to delete or the actual {@link FooTable.Row***REMOVED*** object.
	 * @param {boolean***REMOVED*** [redraw=true] - Whether or not to redraw the table, defaults to true but for bulk operations this
	 * can be set to false and then followed by a call to the {@link FooTable.Table#draw***REMOVED*** method.
	 */
	F.Rows.prototype.delete = function(indexOrRow, redraw){
		var len = this.ft.rows.all.length, 
			row = indexOrRow;
		if (F.is.number(indexOrRow) && indexOrRow >= 0 && indexOrRow < len){
			row = this.ft.rows.all[indexOrRow];
		***REMOVED***
		if (row instanceof FooTable.Row){
			row.delete(redraw);
		***REMOVED***
	***REMOVED***;

***REMOVED***)(FooTable);

(function($, F){

	// global int to use if the table has no ID
	var _uid = 0,
	// a hash value for the current url
		_url_hash = (function(str){
			var i, l, hval = 0x811c9dc5;
			for (i = 0, l = str.length; i < l; i++) {
				hval ^= str.charCodeAt(i);
				hval += (hval << 1) + (hval << 4) + (hval << 7) + (hval << 8) + (hval << 24);
			***REMOVED***
			return hval >>> 0;
		***REMOVED***)(location.origin + location.pathname);

	F.State = F.Component.extend(/** @lends FooTable.State */{
		/**
		 * The state component adds the ability for the table to remember its basic state for filtering, paging and sorting.
		 * @constructs
		 * @extends FooTable.Component
		 * @param {FooTable.Table***REMOVED*** table - The parent {@link FooTable.Table***REMOVED*** object for the component.
		 * @returns {FooTable.State***REMOVED***
		 */
		construct: function(table){
			// call the constructor of the base class
			this._super(table, table.o.state.enabled);
			// Change this value if an update to this component requires any stored data to be reset
			this._key = '1';
			/**
			 * The key to use to store the state for this table.
			 * @type {(null|string)***REMOVED***
			 */
			this.key = this._key + (F.is.string(table.o.state.key) ? table.o.state.key : this._uid());
			/**
			 * Whether or not to allow the filtering component to store it's state.
			 * @type {boolean***REMOVED***
			 */
			this.filtering = F.is.boolean(table.o.state.filtering) ? table.o.state.filtering : true;
			/**
			 * Whether or not to allow the paging component to store it's state.
			 * @type {boolean***REMOVED***
			 */
			this.paging = F.is.boolean(table.o.state.paging) ? table.o.state.paging : true;
			/**
			 * Whether or not to allow the sorting component to store it's state.
			 * @type {boolean***REMOVED***
			 */
			this.sorting = F.is.boolean(table.o.state.sorting) ? table.o.state.sorting : true;
		***REMOVED***,
		/* PROTECTED */
		/**
		 * Checks the supplied data and options for the state component.
		 * @instance
		 * @protected
		 * @param {object***REMOVED*** data - The jQuery data object from the parent table.
		 * @fires FooTable.State#"preinit.ft.state"
		 * @this FooTable.State
		 */
		preinit: function(data){
			var self = this;
			/**
			 * The preinit.ft.state event is raised before the UI is created and provides the tables jQuery data object for additional options parsing.
			 * Calling preventDefault on this event will disable the component.
			 * @event FooTable.State#"preinit.ft.state"
			 * @param {jQuery.Event***REMOVED*** e - The jQuery.Event object for the event.
			 * @param {FooTable.Table***REMOVED*** ft - The instance of the plugin raising the event.
			 * @param {object***REMOVED*** data - The jQuery data object of the table raising the event.
			 */
			this.ft.raise('preinit.ft.state', [data]).then(function(){

				self.enabled = F.is.boolean(data.state)
					? data.state
					: self.enabled;

				if (!self.enabled) return;

				self.key = self._key + (F.is.string(data.stateKey) ? data.stateKey : self.key);

				self.filtering = F.is.boolean(data.stateFiltering) ? data.stateFiltering : self.filtering;

				self.paging = F.is.boolean(data.statePaging) ? data.statePaging : self.paging;

				self.sorting = F.is.boolean(data.stateSorting) ? data.stateSorting : self.sorting;

			***REMOVED***, function(){
				self.enabled = false;
			***REMOVED***);
		***REMOVED***,
		/**
		 * Gets the state value for the specified key for this table.
		 * @instance
		 * @param {string***REMOVED*** key - The key to get the value for.
		 * @returns {(*|null)***REMOVED***
		 */
		get: function(key){
			return JSON.parse(localStorage.getItem(this.key + ':' + key));
		***REMOVED***,
		/**
		 * Sets the state value for the specified key for this table.
		 * @instance
		 * @param {string***REMOVED*** key - The key to set the value for.
		 * @param {****REMOVED*** data - The value to store for the key. This value must be JSON.stringify friendly.
		 */
		set: function(key, data){
			localStorage.setItem(this.key + ':' + key, JSON.stringify(data));
		***REMOVED***,
		/**
		 * Clears the state value for the specified key for this table.
		 * @instance
		 * @param {string***REMOVED*** key - The key to clear the value for.
		 */
		remove: function(key){
			localStorage.removeItem(this.key + ':' + key);
		***REMOVED***,
		/**
		 * Executes the {@link FooTable.Component#readState***REMOVED*** function on all components.
		 * @instance
		 */
		read: function(){
			this.ft.execute(false, true, 'readState');
		***REMOVED***,
		/**
		 * Executes the {@link FooTable.Component#writeState***REMOVED*** function on all components.
		 * @instance
		 */
		write: function(){
			this.ft.execute(false, true, 'writeState');
		***REMOVED***,
		/**
		 * Executes the {@link FooTable.Component#clearState***REMOVED*** function on all components.
		 * @instance
		 */
		clear: function(){
			this.ft.execute(false, true, 'clearState');
		***REMOVED***,
		/**
		 * Generates a unique identifier for the current {@link FooTable.Table***REMOVED*** if one is not supplied through the options.
		 * This value is a combination of the url hash and either the element ID or an incremented global int value.
		 * @instance
		 * @returns {****REMOVED***
		 * @private
		 */
		_uid: function(){
			var id = this.ft.$el.attr('id');
			return _url_hash + '_' + (F.is.string(id) ? id : ++_uid);
		***REMOVED***
	***REMOVED***);

	F.components.register('state', F.State, 700);

***REMOVED***)(jQuery, FooTable);
(function(F){

	/**
	 * This method is called from the {@link FooTable.State#read***REMOVED*** method and allows a component to retrieve its' stored state.
	 * @instance
	 * @protected
	 * @function
	 */
	F.Component.prototype.readState = function(){***REMOVED***;

	/**
	 * This method is called from the {@link FooTable.State#write***REMOVED*** method and allows a component to write its' current state to the store.
	 * @instance
	 * @protected
	 * @function
	 */
	F.Component.prototype.writeState = function(){***REMOVED***;

	/**
	 * This method is called from the {@link FooTable.State#clear***REMOVED*** method and allows a component to clear any stored state.
	 * @instance
	 * @protected
	 * @function
	 */
	F.Component.prototype.clearState = function(){***REMOVED***;

***REMOVED***)(FooTable);
(function(F){

	/**
	 * An object containing the state options for the plugin. Added by the {@link FooTable.State***REMOVED*** component.
	 * @type {object***REMOVED***
	 * @prop {boolean***REMOVED*** enabled=false - Whether or not to allow state to be stored for the table. This overrides the individual component enable options.
	 * @prop {boolean***REMOVED*** filtering=true - Whether or not to allow the filtering state to be stored.
	 * @prop {boolean***REMOVED*** paging=true - Whether or not to allow the filtering state to be stored.
	 * @prop {boolean***REMOVED*** sorting=true - Whether or not to allow the filtering state to be stored.
	 * @prop {string***REMOVED*** key=null - The unique key to use to store the table's data.
	 */
	F.Defaults.prototype.state = {
		enabled: false,
		filtering: true,
		paging: true,
		sorting: true,
		key: null
	***REMOVED***;

***REMOVED***)(FooTable);
(function(F){

	if (!F.Filtering) return;

	/**
	 * Allows the filtering component to retrieve its' stored state.
	 */
	F.Filtering.prototype.readState = function(){
		if (this.ft.state.filtering){
			var state = this.ft.state.get('filtering');
			if (F.is.hash(state) && !F.is.emptyArray(state.filters)){
				this.filters = this.ensure(state.filters);
			***REMOVED***
		***REMOVED***
	***REMOVED***;

	/**
	 * Allows the filtering component to write its' current state to the store.
	 */
	F.Filtering.prototype.writeState = function(){
		if (this.ft.state.filtering) {
			var filters = F.arr.map(this.filters, function (f) {
				return {
					name: f.name,
					query: f.query instanceof F.Query ? f.query.val() : f.query,
					columns: F.arr.map(f.columns, function (c) {
						return c.name;
					***REMOVED***),
					hidden: f.hidden,
					space: f.space,
					connectors: f.connectors,
					ignoreCase: f.ignoreCase
				***REMOVED***;
			***REMOVED***);
			this.ft.state.set('filtering', {filters: filters***REMOVED***);
		***REMOVED***
	***REMOVED***;

	/**
	 * Allows the filtering component to clear any stored state.
	 */
	F.Filtering.prototype.clearState = function(){
		if (this.ft.state.filtering) {
			this.ft.state.remove('filtering');
		***REMOVED***
	***REMOVED***;

***REMOVED***)(FooTable);
(function(F){

	if (!F.Paging) return;

	/**
	 * Allows the paging component to retrieve its' stored state.
	 */
	F.Paging.prototype.readState = function(){
		if (this.ft.state.paging) {
			var state = this.ft.state.get('paging');
			if (F.is.hash(state)) {
				this.current = state.current;
				this.size = state.size;
			***REMOVED***
		***REMOVED***
	***REMOVED***;

	/**
	 * Allows the paging component to write its' current state to the store.
	 */
	F.Paging.prototype.writeState = function(){
		if (this.ft.state.paging) {
			this.ft.state.set('paging', {
				current: this.current,
				size: this.size
			***REMOVED***);
		***REMOVED***
	***REMOVED***;

	/**
	 * Allows the paging component to clear any stored state.
	 */
	F.Paging.prototype.clearState = function(){
		if (this.ft.state.paging) {
			this.ft.state.remove('paging');
		***REMOVED***
	***REMOVED***;

***REMOVED***)(FooTable);
(function(F){

	if (!F.Sorting) return;

	/**
	 * Allows the sorting component to retrieve its' stored state.
	 */
	F.Sorting.prototype.readState = function(){
		if (this.ft.state.sorting) {
			var state = this.ft.state.get('sorting');
			if (F.is.hash(state)) {
				var column = this.ft.columns.get(state.column);
				if (column instanceof F.Column) {
					this.column = column;
					this.column.direction = state.direction;
				***REMOVED***
			***REMOVED***
		***REMOVED***
	***REMOVED***;

	/**
	 * Allows the sorting component to write its' current state to the store.
	 */
	F.Sorting.prototype.writeState = function(){
		if (this.ft.state.sorting && this.column instanceof F.Column){
			this.ft.state.set('sorting', {
				column: this.column.name,
				direction: this.column.direction
			***REMOVED***);
		***REMOVED***
	***REMOVED***;

	/**
	 * Allows the sorting component to clear any stored state.
	 */
	F.Sorting.prototype.clearState = function(){
		if (this.ft.state.sorting) {
			this.ft.state.remove('sorting');
		***REMOVED***
	***REMOVED***;

***REMOVED***)(FooTable);
(function(F){

	// hook into the _construct method so we can add the state property to the table.
	F.Table.extend('_construct', function(ready){
		this.state = this.use(FooTable.State);
		return this._super(ready);
	***REMOVED***);

	// hook into the _preinit method so we can trigger a plugin wide read state operation.
	F.Table.extend('_preinit', function(){
		var self = this;
		return self._super().then(function(){
			if (self.state.enabled){
				self.state.read();
			***REMOVED***
		***REMOVED***);
	***REMOVED***);

	// hook into the draw method so we can trigger a plugin wide write state operation.
	F.Table.extend('draw', function(){
		var self = this;
		return self._super().then(function(){
			if (self.state.enabled){
				self.state.write();
			***REMOVED***
		***REMOVED***);
	***REMOVED***);

***REMOVED***)(FooTable);
(function($, F){

	F.Export = F.Component.extend(/** @lends FooTable.Export */{
		/**
		 * @summary This component provides some basic export functionality.
		 * @memberof FooTable
		 * @constructs Export
		 * @param {FooTable.Table***REMOVED*** table - The current instance of the plugin.
		 */
		construct: function(table){
			// call the constructor of the base class
			this._super(table, true);
			/**
			 * @summary A snapshot of the working set of rows prior to being trimmed by the paging component.
			 * @memberof FooTable.Export#
			 * @name snapshot
			 * @type {FooTable.Row[]***REMOVED***
			 */
			this.snapshot = [];
		***REMOVED***,
		/**
		 * @summary Hooks into the predraw pipeline after sorting and filtering have taken place but prior to paging.
		 * @memberof FooTable.Export#
		 * @function predraw
		 * @description This method allows us to take a snapshot of the working set of rows before they are trimmed by the paging component and is called by the plugin instance.
		 */
		predraw: function(){
			this.snapshot = this.ft.rows.array.slice(0);
		***REMOVED***,
		/**
		 * @summary Return the columns as simple JavaScript objects in an array.
		 * @memberof FooTable.Export#
		 * @function columns
		 * @returns {Object[]***REMOVED***
		 */
		columns: function(){
			var result = [];
			F.arr.each(this.ft.columns.array, function(column){
				if (!column.internal){
					result.push({
						type: column.type,
						name: column.name,
						title: column.title,
						visible: column.visible,
						hidden: column.hidden,
						classes: column.classes,
						style: column.style
					***REMOVED***);
				***REMOVED***
			***REMOVED***);
			return result;
		***REMOVED***,
		/**
		 * @summary Return the rows as simple JavaScript objects in an array.
		 * @memberof FooTable.Export#
		 * @function rows
		 * @param {boolean***REMOVED*** [filtered=false] - Whether or not to exclude filtered rows from the result.
		 * @returns {Object[]***REMOVED***
		 */
		rows: function(filtered){
			filtered = F.is.boolean(filtered) ? filtered : false;
			var rows = filtered ? this.ft.rows.all : this.snapshot, result = [];
			F.arr.each(rows, function(row){
				result.push(row.val());
			***REMOVED***);
			return result;
		***REMOVED***,
		/**
		 * @summary Return the columns and rows as a properly formatted JSON object.
		 * @memberof FooTable.Export#
		 * @function json
		 * @param {boolean***REMOVED*** [filtered=false] - Whether or not to exclude filtered rows from the result.
		 * @returns {Object***REMOVED***
		 */
		json: function(filtered){
			return JSON.parse(JSON.stringify({columns: this.columns(),rows: this.rows(filtered)***REMOVED***));
		***REMOVED***,
		/**
		 * @summary Return the columns and rows as a properly formatted CSV value.
		 * @memberof FooTable.Export#
		 * @function csv
		 * @param {boolean***REMOVED*** [filtered=false] - Whether or not to exclude filtered rows from the result.
		 * @returns {string***REMOVED***
		 */
		csv: function(filtered){
			var csv = "", columns = this.columns(), value, escaped;
			F.arr.each(columns, function(column, i){
				escaped = '"' + column.title.replace(/"/g, '""') + '"';
				csv += (i === 0 ? escaped : "," + escaped);
			***REMOVED***);
			csv += "\n";

			var rows = filtered ? this.ft.rows.all : this.snapshot;
			F.arr.each(rows, function(row){
				F.arr.each(row.cells, function(cell, i){
					if (!cell.column.internal){
						value = cell.column.stringify.call(cell.column, cell.value, cell.ft.o, cell.row.value);
						escaped = '"' + value.replace(/"/g, '""') + '"';
						csv += (i === 0 ? escaped : "," + escaped);
					***REMOVED***
				***REMOVED***);
				csv += "\n";
			***REMOVED***);
			return csv;
		***REMOVED***
	***REMOVED***);

	// register the component using a priority of 490 which falls just after filtering (500) and before paging (400).
	F.components.register("export", F.Export, 490);

***REMOVED***)(jQuery, FooTable);
(function(F){
	// this is used to define the filtering specific properties on column creation
	F.Column.prototype.__export_define__ = function(definition){
		this.stringify = F.checkFnValue(this, definition.stringify, this.stringify);
	***REMOVED***;

	// overrides the public define method and replaces it with our own
	F.Column.extend('define', function(definition){
		this._super(definition); // call the base so we don't have to redefine any previously set properties
		this.__export_define__(definition); // then call our own
	***REMOVED***);

	/**
	 * @summary Return the supplied value as a string.
	 * @memberof FooTable.Column#
	 * @function stringify
	 * @returns {string***REMOVED***
	 */
	F.Column.prototype.stringify = function(value, options, rowData){
		return value + "";
	***REMOVED***;

	// override the base method for DateColumns
	F.DateColumn.prototype.stringify = function(value, options, rowData){
		return F.is.object(value) && F.is.boolean(value._isAMomentObject) && value.isValid() ? value.format(this.formatString) : '';
	***REMOVED***;

	// override the base method for ObjectColumns
	F.ObjectColumn.prototype.stringify = function(value, options, rowData){
		return F.is.object(value) ? JSON.stringify(value) : "";
	***REMOVED***;

	// override the base method for ArrayColumns
	F.ArrayColumn.prototype.stringify = function(value, options, rowData){
		return F.is.array(value) ? JSON.stringify(value) : "";
	***REMOVED***;

***REMOVED***)(FooTable);
(function(F){
	/**
	 * @summary Return the columns and rows as a properly formatted JSON object.
	 * @memberof FooTable.Table#
	 * @function toJSON
	 * @param {boolean***REMOVED*** [filtered=false] - Whether or not to exclude filtered rows from the result.
	 * @returns {Object***REMOVED***
	 */
	F.Table.prototype.toJSON = function(filtered){
		return this.use(F.Export).json(filtered);
	***REMOVED***;

	/**
	 * @summary Return the columns and rows as a properly formatted CSV value.
	 * @memberof FooTable.Table#
	 * @function toCSV
	 * @param {boolean***REMOVED*** [filtered=false] - Whether or not to exclude filtered rows from the result.
	 * @returns {string***REMOVED***
	 */
	F.Table.prototype.toCSV = function(filtered){
		return this.use(F.Export).csv(filtered);
	***REMOVED***;

***REMOVED***)(FooTable);