;(function(){

// CommonJS require()

function require(p){
    var path = require.resolve(p)
      , mod = require.modules[path];
    if (!mod) throw new Error('failed to require "' + p + '"');
    if (!mod.exports) {
      mod.exports = {***REMOVED***;
      mod.call(mod.exports, mod, mod.exports, require.relative(path));
    ***REMOVED***
    return mod.exports;
  ***REMOVED***

require.modules = {***REMOVED***;

require.resolve = function (path){
    var orig = path
      , reg = path + '.js'
      , index = path + '/index.js';
    return require.modules[reg] && reg
      || require.modules[index] && index
      || orig;
  ***REMOVED***;

require.register = function (path, fn){
    require.modules[path] = fn;
  ***REMOVED***;

require.relative = function (parent) {
    return function(p){
      if ('.' != p.charAt(0)) return require(p);

      var path = parent.split('/')
        , segs = p.split('/');
      path.pop();

      for (var i = 0; i < segs.length; i++) {
        var seg = segs[i];
        if ('..' == seg) path.pop();
        else if ('.' != seg) path.push(seg);
      ***REMOVED***

      return require(path.join('/'));
    ***REMOVED***;
  ***REMOVED***;


require.register("browser/debug.js", function(module, exports, require){

module.exports = function(type){
  return function(){
  ***REMOVED***
***REMOVED***;

***REMOVED***); // module: browser/debug.js

require.register("browser/diff.js", function(module, exports, require){
/* See LICENSE file for terms of use */

/*
 * Text diff implementation.
 *
 * This library supports the following APIS:
 * JsDiff.diffChars: Character by character diff
 * JsDiff.diffWords: Word (as defined by \b regex) diff which ignores whitespace
 * JsDiff.diffLines: Line based diff
 *
 * JsDiff.diffCss: Diff targeted at CSS content
 *
 * These methods are based on the implementation proposed in
 * "An O(ND) Difference Algorithm and its Variations" (Myers, 1986).
 * http://citeseerx.ist.psu.edu/viewdoc/summary?doi=10.1.1.4.6927
 */
var JsDiff = (function() {
  /*jshint maxparams: 5*/
  function clonePath(path) {
    return { newPos: path.newPos, components: path.components.slice(0) ***REMOVED***;
  ***REMOVED***
  function removeEmpty(array) {
    var ret = [];
    for (var i = 0; i < array.length; i++) {
      if (array[i]) {
        ret.push(array[i]);
      ***REMOVED***
    ***REMOVED***
    return ret;
  ***REMOVED***
  function escapeHTML(s) {
    var n = s;
    n = n.replace(/&/g, '&amp;');
    n = n.replace(/</g, '&lt;');
    n = n.replace(/>/g, '&gt;');
    n = n.replace(/"/g, '&quot;');

    return n;
  ***REMOVED***

  var Diff = function(ignoreWhitespace) {
    this.ignoreWhitespace = ignoreWhitespace;
  ***REMOVED***;
  Diff.prototype = {
      diff: function(oldString, newString) {
        // Handle the identity case (this is due to unrolling editLength == 0
        if (newString === oldString) {
          return [{ value: newString ***REMOVED***];
        ***REMOVED***
        if (!newString) {
          return [{ value: oldString, removed: true ***REMOVED***];
        ***REMOVED***
        if (!oldString) {
          return [{ value: newString, added: true ***REMOVED***];
        ***REMOVED***

        newString = this.tokenize(newString);
        oldString = this.tokenize(oldString);

        var newLen = newString.length, oldLen = oldString.length;
        var maxEditLength = newLen + oldLen;
        var bestPath = [{ newPos: -1, components: [] ***REMOVED***];

        // Seed editLength = 0
        var oldPos = this.extractCommon(bestPath[0], newString, oldString, 0);
        if (bestPath[0].newPos+1 >= newLen && oldPos+1 >= oldLen) {
          return bestPath[0].components;
        ***REMOVED***

        for (var editLength = 1; editLength <= maxEditLength; editLength++) {
          for (var diagonalPath = -1*editLength; diagonalPath <= editLength; diagonalPath+=2) {
            var basePath;
            var addPath = bestPath[diagonalPath-1],
                removePath = bestPath[diagonalPath+1];
            oldPos = (removePath ? removePath.newPos : 0) - diagonalPath;
            if (addPath) {
              // No one else is going to attempt to use this value, clear it
              bestPath[diagonalPath-1] = undefined;
            ***REMOVED***

            var canAdd = addPath && addPath.newPos+1 < newLen;
            var canRemove = removePath && 0 <= oldPos && oldPos < oldLen;
            if (!canAdd && !canRemove) {
              bestPath[diagonalPath] = undefined;
              continue;
            ***REMOVED***

            // Select the diagonal that we want to branch from. We select the prior
            // path whose position in the new string is the farthest from the origin
            // and does not pass the bounds of the diff graph
            if (!canAdd || (canRemove && addPath.newPos < removePath.newPos)) {
              basePath = clonePath(removePath);
              this.pushComponent(basePath.components, oldString[oldPos], undefined, true);
            ***REMOVED*** else {
              basePath = clonePath(addPath);
              basePath.newPos++;
              this.pushComponent(basePath.components, newString[basePath.newPos], true, undefined);
            ***REMOVED***

            var oldPos = this.extractCommon(basePath, newString, oldString, diagonalPath);

            if (basePath.newPos+1 >= newLen && oldPos+1 >= oldLen) {
              return basePath.components;
            ***REMOVED*** else {
              bestPath[diagonalPath] = basePath;
            ***REMOVED***
          ***REMOVED***
        ***REMOVED***
      ***REMOVED***,

      pushComponent: function(components, value, added, removed) {
        var last = components[components.length-1];
        if (last && last.added === added && last.removed === removed) {
          // We need to clone here as the component clone operation is just
          // as shallow array clone
          components[components.length-1] =
            {value: this.join(last.value, value), added: added, removed: removed ***REMOVED***;
        ***REMOVED*** else {
          components.push({value: value, added: added, removed: removed ***REMOVED***);
        ***REMOVED***
      ***REMOVED***,
      extractCommon: function(basePath, newString, oldString, diagonalPath) {
        var newLen = newString.length,
            oldLen = oldString.length,
            newPos = basePath.newPos,
            oldPos = newPos - diagonalPath;
        while (newPos+1 < newLen && oldPos+1 < oldLen && this.equals(newString[newPos+1], oldString[oldPos+1])) {
          newPos++;
          oldPos++;

          this.pushComponent(basePath.components, newString[newPos], undefined, undefined);
        ***REMOVED***
        basePath.newPos = newPos;
        return oldPos;
      ***REMOVED***,

      equals: function(left, right) {
        var reWhitespace = /\S/;
        if (this.ignoreWhitespace && !reWhitespace.test(left) && !reWhitespace.test(right)) {
          return true;
        ***REMOVED*** else {
          return left === right;
        ***REMOVED***
      ***REMOVED***,
      join: function(left, right) {
        return left + right;
      ***REMOVED***,
      tokenize: function(value) {
        return value;
      ***REMOVED***
  ***REMOVED***;

  var CharDiff = new Diff();

  var WordDiff = new Diff(true);
  var WordWithSpaceDiff = new Diff();
  WordDiff.tokenize = WordWithSpaceDiff.tokenize = function(value) {
    return removeEmpty(value.split(/(\s+|\b)/));
  ***REMOVED***;

  var CssDiff = new Diff(true);
  CssDiff.tokenize = function(value) {
    return removeEmpty(value.split(/([{***REMOVED***:;,]|\s+)/));
  ***REMOVED***;

  var LineDiff = new Diff();
  LineDiff.tokenize = function(value) {
    return value.split(/^/m);
  ***REMOVED***;

  return {
    Diff: Diff,

    diffChars: function(oldStr, newStr) { return CharDiff.diff(oldStr, newStr); ***REMOVED***,
    diffWords: function(oldStr, newStr) { return WordDiff.diff(oldStr, newStr); ***REMOVED***,
    diffWordsWithSpace: function(oldStr, newStr) { return WordWithSpaceDiff.diff(oldStr, newStr); ***REMOVED***,
    diffLines: function(oldStr, newStr) { return LineDiff.diff(oldStr, newStr); ***REMOVED***,

    diffCss: function(oldStr, newStr) { return CssDiff.diff(oldStr, newStr); ***REMOVED***,

    createPatch: function(fileName, oldStr, newStr, oldHeader, newHeader) {
      var ret = [];

      ret.push('Index: ' + fileName);
      ret.push('===================================================================');
      ret.push('--- ' + fileName + (typeof oldHeader === 'undefined' ? '' : '\t' + oldHeader));
      ret.push('+++ ' + fileName + (typeof newHeader === 'undefined' ? '' : '\t' + newHeader));

      var diff = LineDiff.diff(oldStr, newStr);
      if (!diff[diff.length-1].value) {
        diff.pop();   // Remove trailing newline add
      ***REMOVED***
      diff.push({value: '', lines: []***REMOVED***);   // Append an empty value to make cleanup easier

      function contextLines(lines) {
        return lines.map(function(entry) { return ' ' + entry; ***REMOVED***);
      ***REMOVED***
      function eofNL(curRange, i, current) {
        var last = diff[diff.length-2],
            isLast = i === diff.length-2,
            isLastOfType = i === diff.length-3 && (current.added !== last.added || current.removed !== last.removed);

        // Figure out if this is the last line for the given file and missing NL
        if (!/\n$/.test(current.value) && (isLast || isLastOfType)) {
          curRange.push('\\ No newline at end of file');
        ***REMOVED***
      ***REMOVED***

      var oldRangeStart = 0, newRangeStart = 0, curRange = [],
          oldLine = 1, newLine = 1;
      for (var i = 0; i < diff.length; i++) {
        var current = diff[i],
            lines = current.lines || current.value.replace(/\n$/, '').split('\n');
        current.lines = lines;

        if (current.added || current.removed) {
          if (!oldRangeStart) {
            var prev = diff[i-1];
            oldRangeStart = oldLine;
            newRangeStart = newLine;

            if (prev) {
              curRange = contextLines(prev.lines.slice(-4));
              oldRangeStart -= curRange.length;
              newRangeStart -= curRange.length;
            ***REMOVED***
          ***REMOVED***
          curRange.push.apply(curRange, lines.map(function(entry) { return (current.added?'+':'-') + entry; ***REMOVED***));
          eofNL(curRange, i, current);

          if (current.added) {
            newLine += lines.length;
          ***REMOVED*** else {
            oldLine += lines.length;
          ***REMOVED***
        ***REMOVED*** else {
          if (oldRangeStart) {
            // Close out any changes that have been output (or join overlapping)
            if (lines.length <= 8 && i < diff.length-2) {
              // Overlapping
              curRange.push.apply(curRange, contextLines(lines));
            ***REMOVED*** else {
              // end the range and output
              var contextSize = Math.min(lines.length, 4);
              ret.push(
                  '@@ -' + oldRangeStart + ',' + (oldLine-oldRangeStart+contextSize)
                  + ' +' + newRangeStart + ',' + (newLine-newRangeStart+contextSize)
                  + ' @@');
              ret.push.apply(ret, curRange);
              ret.push.apply(ret, contextLines(lines.slice(0, contextSize)));
              if (lines.length <= 4) {
                eofNL(ret, i, current);
              ***REMOVED***

              oldRangeStart = 0;  newRangeStart = 0; curRange = [];
            ***REMOVED***
          ***REMOVED***
          oldLine += lines.length;
          newLine += lines.length;
        ***REMOVED***
      ***REMOVED***

      return ret.join('\n') + '\n';
    ***REMOVED***,

    applyPatch: function(oldStr, uniDiff) {
      var diffstr = uniDiff.split('\n');
      var diff = [];
      var remEOFNL = false,
          addEOFNL = false;

      for (var i = (diffstr[0][0]==='I'?4:0); i < diffstr.length; i++) {
        if(diffstr[i][0] === '@') {
          var meh = diffstr[i].split(/@@ -(\d+),(\d+) \+(\d+),(\d+) @@/);
          diff.unshift({
            start:meh[3],
            oldlength:meh[2],
            oldlines:[],
            newlength:meh[4],
            newlines:[]
          ***REMOVED***);
        ***REMOVED*** else if(diffstr[i][0] === '+') {
          diff[0].newlines.push(diffstr[i].substr(1));
        ***REMOVED*** else if(diffstr[i][0] === '-') {
          diff[0].oldlines.push(diffstr[i].substr(1));
        ***REMOVED*** else if(diffstr[i][0] === ' ') {
          diff[0].newlines.push(diffstr[i].substr(1));
          diff[0].oldlines.push(diffstr[i].substr(1));
        ***REMOVED*** else if(diffstr[i][0] === '\\') {
          if (diffstr[i-1][0] === '+') {
            remEOFNL = true;
          ***REMOVED*** else if(diffstr[i-1][0] === '-') {
            addEOFNL = true;
          ***REMOVED***
        ***REMOVED***
      ***REMOVED***

      var str = oldStr.split('\n');
      for (var i = diff.length - 1; i >= 0; i--) {
        var d = diff[i];
        for (var j = 0; j < d.oldlength; j++) {
          if(str[d.start-1+j] !== d.oldlines[j]) {
            return false;
          ***REMOVED***
        ***REMOVED***
        Array.prototype.splice.apply(str,[d.start-1,+d.oldlength].concat(d.newlines));
      ***REMOVED***

      if (remEOFNL) {
        while (!str[str.length-1]) {
          str.pop();
        ***REMOVED***
      ***REMOVED*** else if (addEOFNL) {
        str.push('');
      ***REMOVED***
      return str.join('\n');
    ***REMOVED***,

    convertChangesToXML: function(changes){
      var ret = [];
      for ( var i = 0; i < changes.length; i++) {
        var change = changes[i];
        if (change.added) {
          ret.push('<ins>');
        ***REMOVED*** else if (change.removed) {
          ret.push('<del>');
        ***REMOVED***

        ret.push(escapeHTML(change.value));

        if (change.added) {
          ret.push('</ins>');
        ***REMOVED*** else if (change.removed) {
          ret.push('</del>');
        ***REMOVED***
      ***REMOVED***
      return ret.join('');
    ***REMOVED***,

    // See: http://code.google.com/p/google-diff-match-patch/wiki/API
    convertChangesToDMP: function(changes){
      var ret = [], change;
      for ( var i = 0; i < changes.length; i++) {
        change = changes[i];
        ret.push([(change.added ? 1 : change.removed ? -1 : 0), change.value]);
      ***REMOVED***
      return ret;
    ***REMOVED***
  ***REMOVED***;
***REMOVED***)();

if (typeof module !== 'undefined') {
    module.exports = JsDiff;
***REMOVED***

***REMOVED***); // module: browser/diff.js

require.register("browser/events.js", function(module, exports, require){

/**
 * Module exports.
 */

exports.EventEmitter = EventEmitter;

/**
 * Check if `obj` is an array.
 */

function isArray(obj) {
  return '[object Array]' == {***REMOVED***.toString.call(obj);
***REMOVED***

/**
 * Event emitter constructor.
 *
 * @api public
 */

function EventEmitter(){***REMOVED***;

/**
 * Adds a listener.
 *
 * @api public
 */

EventEmitter.prototype.on = function (name, fn) {
  if (!this.$events) {
    this.$events = {***REMOVED***;
  ***REMOVED***

  if (!this.$events[name]) {
    this.$events[name] = fn;
  ***REMOVED*** else if (isArray(this.$events[name])) {
    this.$events[name].push(fn);
  ***REMOVED*** else {
    this.$events[name] = [this.$events[name], fn];
  ***REMOVED***

  return this;
***REMOVED***;

EventEmitter.prototype.addListener = EventEmitter.prototype.on;

/**
 * Adds a volatile listener.
 *
 * @api public
 */

EventEmitter.prototype.once = function (name, fn) {
  var self = this;

  function on () {
    self.removeListener(name, on);
    fn.apply(this, arguments);
  ***REMOVED***;

  on.listener = fn;
  this.on(name, on);

  return this;
***REMOVED***;

/**
 * Removes a listener.
 *
 * @api public
 */

EventEmitter.prototype.removeListener = function (name, fn) {
  if (this.$events && this.$events[name]) {
    var list = this.$events[name];

    if (isArray(list)) {
      var pos = -1;

      for (var i = 0, l = list.length; i < l; i++) {
        if (list[i] === fn || (list[i].listener && list[i].listener === fn)) {
          pos = i;
          break;
        ***REMOVED***
      ***REMOVED***

      if (pos < 0) {
        return this;
      ***REMOVED***

      list.splice(pos, 1);

      if (!list.length) {
        delete this.$events[name];
      ***REMOVED***
    ***REMOVED*** else if (list === fn || (list.listener && list.listener === fn)) {
      delete this.$events[name];
    ***REMOVED***
  ***REMOVED***

  return this;
***REMOVED***;

/**
 * Removes all listeners for an event.
 *
 * @api public
 */

EventEmitter.prototype.removeAllListeners = function (name) {
  if (name === undefined) {
    this.$events = {***REMOVED***;
    return this;
  ***REMOVED***

  if (this.$events && this.$events[name]) {
    this.$events[name] = null;
  ***REMOVED***

  return this;
***REMOVED***;

/**
 * Gets all listeners for a certain event.
 *
 * @api public
 */

EventEmitter.prototype.listeners = function (name) {
  if (!this.$events) {
    this.$events = {***REMOVED***;
  ***REMOVED***

  if (!this.$events[name]) {
    this.$events[name] = [];
  ***REMOVED***

  if (!isArray(this.$events[name])) {
    this.$events[name] = [this.$events[name]];
  ***REMOVED***

  return this.$events[name];
***REMOVED***;

/**
 * Emits an event.
 *
 * @api public
 */

EventEmitter.prototype.emit = function (name) {
  if (!this.$events) {
    return false;
  ***REMOVED***

  var handler = this.$events[name];

  if (!handler) {
    return false;
  ***REMOVED***

  var args = [].slice.call(arguments, 1);

  if ('function' == typeof handler) {
    handler.apply(this, args);
  ***REMOVED*** else if (isArray(handler)) {
    var listeners = handler.slice();

    for (var i = 0, l = listeners.length; i < l; i++) {
      listeners[i].apply(this, args);
    ***REMOVED***
  ***REMOVED*** else {
    return false;
  ***REMOVED***

  return true;
***REMOVED***;
***REMOVED***); // module: browser/events.js

require.register("browser/fs.js", function(module, exports, require){

***REMOVED***); // module: browser/fs.js

require.register("browser/path.js", function(module, exports, require){

***REMOVED***); // module: browser/path.js

require.register("browser/progress.js", function(module, exports, require){
/**
 * Expose `Progress`.
 */

module.exports = Progress;

/**
 * Initialize a new `Progress` indicator.
 */

function Progress() {
  this.percent = 0;
  this.size(0);
  this.fontSize(11);
  this.font('helvetica, arial, sans-serif');
***REMOVED***

/**
 * Set progress size to `n`.
 *
 * @param {Number***REMOVED*** n
 * @return {Progress***REMOVED*** for chaining
 * @api public
 */

Progress.prototype.size = function(n){
  this._size = n;
  return this;
***REMOVED***;

/**
 * Set text to `str`.
 *
 * @param {String***REMOVED*** str
 * @return {Progress***REMOVED*** for chaining
 * @api public
 */

Progress.prototype.text = function(str){
  this._text = str;
  return this;
***REMOVED***;

/**
 * Set font size to `n`.
 *
 * @param {Number***REMOVED*** n
 * @return {Progress***REMOVED*** for chaining
 * @api public
 */

Progress.prototype.fontSize = function(n){
  this._fontSize = n;
  return this;
***REMOVED***;

/**
 * Set font `family`.
 *
 * @param {String***REMOVED*** family
 * @return {Progress***REMOVED*** for chaining
 */

Progress.prototype.font = function(family){
  this._font = family;
  return this;
***REMOVED***;

/**
 * Update percentage to `n`.
 *
 * @param {Number***REMOVED*** n
 * @return {Progress***REMOVED*** for chaining
 */

Progress.prototype.update = function(n){
  this.percent = n;
  return this;
***REMOVED***;

/**
 * Draw on `ctx`.
 *
 * @param {CanvasRenderingContext2d***REMOVED*** ctx
 * @return {Progress***REMOVED*** for chaining
 */

Progress.prototype.draw = function(ctx){
  try {
    var percent = Math.min(this.percent, 100)
      , size = this._size
      , half = size / 2
      , x = half
      , y = half
      , rad = half - 1
      , fontSize = this._fontSize;
  
    ctx.font = fontSize + 'px ' + this._font;
  
    var angle = Math.PI * 2 * (percent / 100);
    ctx.clearRect(0, 0, size, size);
  
    // outer circle
    ctx.strokeStyle = '#9f9f9f';
    ctx.beginPath();
    ctx.arc(x, y, rad, 0, angle, false);
    ctx.stroke();
  
    // inner circle
    ctx.strokeStyle = '#eee';
    ctx.beginPath();
    ctx.arc(x, y, rad - 1, 0, angle, true);
    ctx.stroke();
  
    // text
    var text = this._text || (percent | 0) + '%'
      , w = ctx.measureText(text).width;
  
    ctx.fillText(
        text
      , x - w / 2 + 1
      , y + fontSize / 2 - 1);
  ***REMOVED*** catch (ex) {***REMOVED*** //don't fail if we can't render progress
  return this;
***REMOVED***;

***REMOVED***); // module: browser/progress.js

require.register("browser/tty.js", function(module, exports, require){

exports.isatty = function(){
  return true;
***REMOVED***;

exports.getWindowSize = function(){
  if ('innerHeight' in global) {
    return [global.innerHeight, global.innerWidth];
  ***REMOVED*** else {
    // In a Web Worker, the DOM Window is not available.
    return [640, 480];
  ***REMOVED***
***REMOVED***;

***REMOVED***); // module: browser/tty.js

require.register("context.js", function(module, exports, require){

/**
 * Expose `Context`.
 */

module.exports = Context;

/**
 * Initialize a new `Context`.
 *
 * @api private
 */

function Context(){***REMOVED***

/**
 * Set or get the context `Runnable` to `runnable`.
 *
 * @param {Runnable***REMOVED*** runnable
 * @return {Context***REMOVED***
 * @api private
 */

Context.prototype.runnable = function(runnable){
  if (0 == arguments.length) return this._runnable;
  this.test = this._runnable = runnable;
  return this;
***REMOVED***;

/**
 * Set test timeout `ms`.
 *
 * @param {Number***REMOVED*** ms
 * @return {Context***REMOVED*** self
 * @api private
 */

Context.prototype.timeout = function(ms){
  this.runnable().timeout(ms);
  return this;
***REMOVED***;

/**
 * Set test slowness threshold `ms`.
 *
 * @param {Number***REMOVED*** ms
 * @return {Context***REMOVED*** self
 * @api private
 */

Context.prototype.slow = function(ms){
  this.runnable().slow(ms);
  return this;
***REMOVED***;

/**
 * Inspect the context void of `._runnable`.
 *
 * @return {String***REMOVED***
 * @api private
 */

Context.prototype.inspect = function(){
  return JSON.stringify(this, function(key, val){
    if ('_runnable' == key) return;
    if ('test' == key) return;
    return val;
  ***REMOVED***, 2);
***REMOVED***;

***REMOVED***); // module: context.js

require.register("hook.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Runnable = require('./runnable');

/**
 * Expose `Hook`.
 */

module.exports = Hook;

/**
 * Initialize a new `Hook` with the given `title` and callback `fn`.
 *
 * @param {String***REMOVED*** title
 * @param {Function***REMOVED*** fn
 * @api private
 */

function Hook(title, fn) {
  Runnable.call(this, title, fn);
  this.type = 'hook';
***REMOVED***

/**
 * Inherit from `Runnable.prototype`.
 */

function F(){***REMOVED***;
F.prototype = Runnable.prototype;
Hook.prototype = new F;
Hook.prototype.constructor = Hook;


/**
 * Get or set the test `err`.
 *
 * @param {Error***REMOVED*** err
 * @return {Error***REMOVED***
 * @api public
 */

Hook.prototype.error = function(err){
  if (0 == arguments.length) {
    var err = this._error;
    this._error = null;
    return err;
  ***REMOVED***

  this._error = err;
***REMOVED***;

***REMOVED***); // module: hook.js

require.register("interfaces/bdd.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Suite = require('../suite')
  , Test = require('../test')
  , utils = require('../utils');

/**
 * BDD-style interface:
 *
 *      describe('Array', function(){
 *        describe('#indexOf()', function(){
 *          it('should return -1 when not present', function(){
 *
 *          ***REMOVED***);
 *
 *          it('should return the index when present', function(){
 *
 *          ***REMOVED***);
 *        ***REMOVED***);
 *      ***REMOVED***);
 *
 */

module.exports = function(suite){
  var suites = [suite];

  suite.on('pre-require', function(context, file, mocha){

    /**
     * Execute before running tests.
     */

    context.before = function(fn){
      suites[0].beforeAll(fn);
    ***REMOVED***;

    /**
     * Execute after running tests.
     */

    context.after = function(fn){
      suites[0].afterAll(fn);
    ***REMOVED***;

    /**
     * Execute before each test case.
     */

    context.beforeEach = function(fn){
      suites[0].beforeEach(fn);
    ***REMOVED***;

    /**
     * Execute after each test case.
     */

    context.afterEach = function(fn){
      suites[0].afterEach(fn);
    ***REMOVED***;

    /**
     * Describe a "suite" with the given `title`
     * and callback `fn` containing nested suites
     * and/or tests.
     */

    context.describe = context.context = function(title, fn){
      var suite = Suite.create(suites[0], title);
      suites.unshift(suite);
      fn.call(suite);
      suites.shift();
      return suite;
    ***REMOVED***;

    /**
     * Pending describe.
     */

    context.xdescribe =
    context.xcontext =
    context.describe.skip = function(title, fn){
      var suite = Suite.create(suites[0], title);
      suite.pending = true;
      suites.unshift(suite);
      fn.call(suite);
      suites.shift();
    ***REMOVED***;

    /**
     * Exclusive suite.
     */

    context.describe.only = function(title, fn){
      var suite = context.describe(title, fn);
      mocha.grep(suite.fullTitle());
      return suite;
    ***REMOVED***;

    /**
     * Describe a specification or test-case
     * with the given `title` and callback `fn`
     * acting as a thunk.
     */

    context.it = context.specify = function(title, fn){
      var suite = suites[0];
      if (suite.pending) var fn = null;
      var test = new Test(title, fn);
      suite.addTest(test);
      return test;
    ***REMOVED***;

    /**
     * Exclusive test-case.
     */

    context.it.only = function(title, fn){
      var test = context.it(title, fn);
      var reString = '^' + utils.escapeRegexp(test.fullTitle()) + '$';
      mocha.grep(new RegExp(reString));
      return test;
    ***REMOVED***;

    /**
     * Pending test case.
     */

    context.xit =
    context.xspecify =
    context.it.skip = function(title){
      context.it(title);
    ***REMOVED***;
  ***REMOVED***);
***REMOVED***;

***REMOVED***); // module: interfaces/bdd.js

require.register("interfaces/exports.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Suite = require('../suite')
  , Test = require('../test');

/**
 * TDD-style interface:
 *
 *     exports.Array = {
 *       '#indexOf()': {
 *         'should return -1 when the value is not present': function(){
 *
 *         ***REMOVED***,
 *
 *         'should return the correct index when the value is present': function(){
 *
 *         ***REMOVED***
 *       ***REMOVED***
 *     ***REMOVED***;
 *
 */

module.exports = function(suite){
  var suites = [suite];

  suite.on('require', visit);

  function visit(obj) {
    var suite;
    for (var key in obj) {
      if ('function' == typeof obj[key]) {
        var fn = obj[key];
        switch (key) {
          case 'before':
            suites[0].beforeAll(fn);
            break;
          case 'after':
            suites[0].afterAll(fn);
            break;
          case 'beforeEach':
            suites[0].beforeEach(fn);
            break;
          case 'afterEach':
            suites[0].afterEach(fn);
            break;
          default:
            suites[0].addTest(new Test(key, fn));
        ***REMOVED***
      ***REMOVED*** else {
        var suite = Suite.create(suites[0], key);
        suites.unshift(suite);
        visit(obj[key]);
        suites.shift();
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***
***REMOVED***;

***REMOVED***); // module: interfaces/exports.js

require.register("interfaces/index.js", function(module, exports, require){

exports.bdd = require('./bdd');
exports.tdd = require('./tdd');
exports.qunit = require('./qunit');
exports.exports = require('./exports');

***REMOVED***); // module: interfaces/index.js

require.register("interfaces/qunit.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Suite = require('../suite')
  , Test = require('../test')
  , utils = require('../utils');

/**
 * QUnit-style interface:
 *
 *     suite('Array');
 *
 *     test('#length', function(){
 *       var arr = [1,2,3];
 *       ok(arr.length == 3);
 *     ***REMOVED***);
 *
 *     test('#indexOf()', function(){
 *       var arr = [1,2,3];
 *       ok(arr.indexOf(1) == 0);
 *       ok(arr.indexOf(2) == 1);
 *       ok(arr.indexOf(3) == 2);
 *     ***REMOVED***);
 *
 *     suite('String');
 *
 *     test('#length', function(){
 *       ok('foo'.length == 3);
 *     ***REMOVED***);
 *
 */

module.exports = function(suite){
  var suites = [suite];

  suite.on('pre-require', function(context, file, mocha){

    /**
     * Execute before running tests.
     */

    context.before = function(fn){
      suites[0].beforeAll(fn);
    ***REMOVED***;

    /**
     * Execute after running tests.
     */

    context.after = function(fn){
      suites[0].afterAll(fn);
    ***REMOVED***;

    /**
     * Execute before each test case.
     */

    context.beforeEach = function(fn){
      suites[0].beforeEach(fn);
    ***REMOVED***;

    /**
     * Execute after each test case.
     */

    context.afterEach = function(fn){
      suites[0].afterEach(fn);
    ***REMOVED***;

    /**
     * Describe a "suite" with the given `title`.
     */

    context.suite = function(title){
      if (suites.length > 1) suites.shift();
      var suite = Suite.create(suites[0], title);
      suites.unshift(suite);
      return suite;
    ***REMOVED***;

    /**
     * Exclusive test-case.
     */

    context.suite.only = function(title, fn){
      var suite = context.suite(title, fn);
      mocha.grep(suite.fullTitle());
    ***REMOVED***;

    /**
     * Describe a specification or test-case
     * with the given `title` and callback `fn`
     * acting as a thunk.
     */

    context.test = function(title, fn){
      var test = new Test(title, fn);
      suites[0].addTest(test);
      return test;
    ***REMOVED***;

    /**
     * Exclusive test-case.
     */

    context.test.only = function(title, fn){
      var test = context.test(title, fn);
      var reString = '^' + utils.escapeRegexp(test.fullTitle()) + '$';
      mocha.grep(new RegExp(reString));
    ***REMOVED***;

    /**
     * Pending test case.
     */

    context.test.skip = function(title){
      context.test(title);
    ***REMOVED***;
  ***REMOVED***);
***REMOVED***;

***REMOVED***); // module: interfaces/qunit.js

require.register("interfaces/tdd.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Suite = require('../suite')
  , Test = require('../test')
  , utils = require('../utils');;

/**
 * TDD-style interface:
 *
 *      suite('Array', function(){
 *        suite('#indexOf()', function(){
 *          suiteSetup(function(){
 *
 *          ***REMOVED***);
 *
 *          test('should return -1 when not present', function(){
 *
 *          ***REMOVED***);
 *
 *          test('should return the index when present', function(){
 *
 *          ***REMOVED***);
 *
 *          suiteTeardown(function(){
 *
 *          ***REMOVED***);
 *        ***REMOVED***);
 *      ***REMOVED***);
 *
 */

module.exports = function(suite){
  var suites = [suite];

  suite.on('pre-require', function(context, file, mocha){

    /**
     * Execute before each test case.
     */

    context.setup = function(fn){
      suites[0].beforeEach(fn);
    ***REMOVED***;

    /**
     * Execute after each test case.
     */

    context.teardown = function(fn){
      suites[0].afterEach(fn);
    ***REMOVED***;

    /**
     * Execute before the suite.
     */

    context.suiteSetup = function(fn){
      suites[0].beforeAll(fn);
    ***REMOVED***;

    /**
     * Execute after the suite.
     */

    context.suiteTeardown = function(fn){
      suites[0].afterAll(fn);
    ***REMOVED***;

    /**
     * Describe a "suite" with the given `title`
     * and callback `fn` containing nested suites
     * and/or tests.
     */

    context.suite = function(title, fn){
      var suite = Suite.create(suites[0], title);
      suites.unshift(suite);
      fn.call(suite);
      suites.shift();
      return suite;
    ***REMOVED***;

    /**
     * Pending suite.
     */
    context.suite.skip = function(title, fn) {
      var suite = Suite.create(suites[0], title);
      suite.pending = true;
      suites.unshift(suite);
      fn.call(suite);
      suites.shift();
    ***REMOVED***;

    /**
     * Exclusive test-case.
     */

    context.suite.only = function(title, fn){
      var suite = context.suite(title, fn);
      mocha.grep(suite.fullTitle());
    ***REMOVED***;

    /**
     * Describe a specification or test-case
     * with the given `title` and callback `fn`
     * acting as a thunk.
     */

    context.test = function(title, fn){
      var suite = suites[0];
      if (suite.pending) var fn = null;
      var test = new Test(title, fn);
      suite.addTest(test);
      return test;
    ***REMOVED***;

    /**
     * Exclusive test-case.
     */

    context.test.only = function(title, fn){
      var test = context.test(title, fn);
      var reString = '^' + utils.escapeRegexp(test.fullTitle()) + '$';
      mocha.grep(new RegExp(reString));
    ***REMOVED***;

    /**
     * Pending test case.
     */

    context.test.skip = function(title){
      context.test(title);
    ***REMOVED***;
  ***REMOVED***);
***REMOVED***;

***REMOVED***); // module: interfaces/tdd.js

require.register("mocha.js", function(module, exports, require){
/*!
 * mocha
 * Copyright(c) 2011 TJ Holowaychuk <tj@vision-media.ca>
 * MIT Licensed
 */

/**
 * Module dependencies.
 */

var path = require('browser/path')
  , utils = require('./utils');

/**
 * Expose `Mocha`.
 */

exports = module.exports = Mocha;

/**
 * Expose internals.
 */

exports.utils = utils;
exports.interfaces = require('./interfaces');
exports.reporters = require('./reporters');
exports.Runnable = require('./runnable');
exports.Context = require('./context');
exports.Runner = require('./runner');
exports.Suite = require('./suite');
exports.Hook = require('./hook');
exports.Test = require('./test');

/**
 * Return image `name` path.
 *
 * @param {String***REMOVED*** name
 * @return {String***REMOVED***
 * @api private
 */

function image(name) {
  return __dirname + '/../images/' + name + '.png';
***REMOVED***

/**
 * Setup mocha with `options`.
 *
 * Options:
 *
 *   - `ui` name "bdd", "tdd", "exports" etc
 *   - `reporter` reporter instance, defaults to `mocha.reporters.Dot`
 *   - `globals` array of accepted globals
 *   - `timeout` timeout in milliseconds
 *   - `bail` bail on the first test failure
 *   - `slow` milliseconds to wait before considering a test slow
 *   - `ignoreLeaks` ignore global leaks
 *   - `grep` string or regexp to filter tests with
 *
 * @param {Object***REMOVED*** options
 * @api public
 */

function Mocha(options) {
  options = options || {***REMOVED***;
  this.files = [];
  this.options = options;
  this.grep(options.grep);
  this.suite = new exports.Suite('', new exports.Context);
  this.ui(options.ui);
  this.bail(options.bail);
  this.reporter(options.reporter);
  if (null != options.timeout) this.timeout(options.timeout);
  this.useColors(options.useColors)
  if (options.slow) this.slow(options.slow);

  this.suite.on('pre-require', function (context) {
    exports.afterEach = context.afterEach || context.teardown;
    exports.after = context.after || context.suiteTeardown;
    exports.beforeEach = context.beforeEach || context.setup;
    exports.before = context.before || context.suiteSetup;
    exports.describe = context.describe || context.suite;
    exports.it = context.it || context.test;
    exports.setup = context.setup || context.beforeEach;
    exports.suiteSetup = context.suiteSetup || context.before;
    exports.suiteTeardown = context.suiteTeardown || context.after;
    exports.suite = context.suite || context.describe;
    exports.teardown = context.teardown || context.afterEach;
    exports.test = context.test || context.it;
  ***REMOVED***);
***REMOVED***

/**
 * Enable or disable bailing on the first failure.
 *
 * @param {Boolean***REMOVED*** [bail]
 * @api public
 */

Mocha.prototype.bail = function(bail){
  if (0 == arguments.length) bail = true;
  this.suite.bail(bail);
  return this;
***REMOVED***;

/**
 * Add test `file`.
 *
 * @param {String***REMOVED*** file
 * @api public
 */

Mocha.prototype.addFile = function(file){
  this.files.push(file);
  return this;
***REMOVED***;

/**
 * Set reporter to `reporter`, defaults to "dot".
 *
 * @param {String|Function***REMOVED*** reporter name or constructor
 * @api public
 */

Mocha.prototype.reporter = function(reporter){
  if ('function' == typeof reporter) {
    this._reporter = reporter;
  ***REMOVED*** else {
    reporter = reporter || 'dot';
    var _reporter;
    try { _reporter = require('./reporters/' + reporter); ***REMOVED*** catch (err) {***REMOVED***;
    if (!_reporter) try { _reporter = require(reporter); ***REMOVED*** catch (err) {***REMOVED***;
    if (!_reporter && reporter === 'teamcity')
      console.warn('The Teamcity reporter was moved to a package named ' +
        'mocha-teamcity-reporter ' +
        '(https://npmjs.org/package/mocha-teamcity-reporter).');
    if (!_reporter) throw new Error('invalid reporter "' + reporter + '"');
    this._reporter = _reporter;
  ***REMOVED***
  return this;
***REMOVED***;

/**
 * Set test UI `name`, defaults to "bdd".
 *
 * @param {String***REMOVED*** bdd
 * @api public
 */

Mocha.prototype.ui = function(name){
  name = name || 'bdd';
  this._ui = exports.interfaces[name];
  if (!this._ui) try { this._ui = require(name); ***REMOVED*** catch (err) {***REMOVED***;
  if (!this._ui) throw new Error('invalid interface "' + name + '"');
  this._ui = this._ui(this.suite);
  return this;
***REMOVED***;

/**
 * Load registered files.
 *
 * @api private
 */

Mocha.prototype.loadFiles = function(fn){
  var self = this;
  var suite = this.suite;
  var pending = this.files.length;
  this.files.forEach(function(file){
    file = path.resolve(file);
    suite.emit('pre-require', global, file, self);
    suite.emit('require', require(file), file, self);
    suite.emit('post-require', global, file, self);
    --pending || (fn && fn());
  ***REMOVED***);
***REMOVED***;

/**
 * Enable growl support.
 *
 * @api private
 */

Mocha.prototype._growl = function(runner, reporter) {
  var notify = require('growl');

  runner.on('end', function(){
    var stats = reporter.stats;
    if (stats.failures) {
      var msg = stats.failures + ' of ' + runner.total + ' tests failed';
      notify(msg, { name: 'mocha', title: 'Failed', image: image('error') ***REMOVED***);
    ***REMOVED*** else {
      notify(stats.passes + ' tests passed in ' + stats.duration + 'ms', {
          name: 'mocha'
        , title: 'Passed'
        , image: image('ok')
      ***REMOVED***);
    ***REMOVED***
  ***REMOVED***);
***REMOVED***;

/**
 * Add regexp to grep, if `re` is a string it is escaped.
 *
 * @param {RegExp|String***REMOVED*** re
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.grep = function(re){
  this.options.grep = 'string' == typeof re
    ? new RegExp(utils.escapeRegexp(re))
    : re;
  return this;
***REMOVED***;

/**
 * Invert `.grep()` matches.
 *
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.invert = function(){
  this.options.invert = true;
  return this;
***REMOVED***;

/**
 * Ignore global leaks.
 *
 * @param {Boolean***REMOVED*** ignore
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.ignoreLeaks = function(ignore){
  this.options.ignoreLeaks = !!ignore;
  return this;
***REMOVED***;

/**
 * Enable global leak checking.
 *
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.checkLeaks = function(){
  this.options.ignoreLeaks = false;
  return this;
***REMOVED***;

/**
 * Enable growl support.
 *
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.growl = function(){
  this.options.growl = true;
  return this;
***REMOVED***;

/**
 * Ignore `globals` array or string.
 *
 * @param {Array|String***REMOVED*** globals
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.globals = function(globals){
  this.options.globals = (this.options.globals || []).concat(globals);
  return this;
***REMOVED***;

/**
 * Emit color output.
 *
 * @param {Boolean***REMOVED*** colors
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.useColors = function(colors){
  this.options.useColors = arguments.length && colors != undefined
    ? colors
    : true;
  return this;
***REMOVED***;

/**
 * Use inline diffs rather than +/-.
 *
 * @param {Boolean***REMOVED*** inlineDiffs
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.useInlineDiffs = function(inlineDiffs) {
  this.options.useInlineDiffs = arguments.length && inlineDiffs != undefined
  ? inlineDiffs
  : false;
  return this;
***REMOVED***;

/**
 * Set the timeout in milliseconds.
 *
 * @param {Number***REMOVED*** timeout
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.timeout = function(timeout){
  this.suite.timeout(timeout);
  return this;
***REMOVED***;

/**
 * Set slowness threshold in milliseconds.
 *
 * @param {Number***REMOVED*** slow
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.slow = function(slow){
  this.suite.slow(slow);
  return this;
***REMOVED***;

/**
 * Makes all tests async (accepting a callback)
 *
 * @return {Mocha***REMOVED***
 * @api public
 */

Mocha.prototype.asyncOnly = function(){
  this.options.asyncOnly = true;
  return this;
***REMOVED***;

/**
 * Run tests and invoke `fn()` when complete.
 *
 * @param {Function***REMOVED*** fn
 * @return {Runner***REMOVED***
 * @api public
 */

Mocha.prototype.run = function(fn){
  if (this.files.length) this.loadFiles();
  var suite = this.suite;
  var options = this.options;
  var runner = new exports.Runner(suite);
  var reporter = new this._reporter(runner);
  runner.ignoreLeaks = false !== options.ignoreLeaks;
  runner.asyncOnly = options.asyncOnly;
  if (options.grep) runner.grep(options.grep, options.invert);
  if (options.globals) runner.globals(options.globals);
  if (options.growl) this._growl(runner, reporter);
  exports.reporters.Base.useColors = options.useColors;
  exports.reporters.Base.inlineDiffs = options.useInlineDiffs;
  return runner.run(fn);
***REMOVED***;

***REMOVED***); // module: mocha.js

require.register("ms.js", function(module, exports, require){
/**
 * Helpers.
 */

var s = 1000;
var m = s * 60;
var h = m * 60;
var d = h * 24;
var y = d * 365.25;

/**
 * Parse or format the given `val`.
 *
 * Options:
 *
 *  - `long` verbose formatting [false]
 *
 * @param {String|Number***REMOVED*** val
 * @param {Object***REMOVED*** options
 * @return {String|Number***REMOVED***
 * @api public
 */

module.exports = function(val, options){
  options = options || {***REMOVED***;
  if ('string' == typeof val) return parse(val);
  return options.long ? longFormat(val) : shortFormat(val);
***REMOVED***;

/**
 * Parse the given `str` and return milliseconds.
 *
 * @param {String***REMOVED*** str
 * @return {Number***REMOVED***
 * @api private
 */

function parse(str) {
  var match = /^((?:\d+)?\.?\d+) *(ms|seconds?|s|minutes?|m|hours?|h|days?|d|years?|y)?$/i.exec(str);
  if (!match) return;
  var n = parseFloat(match[1]);
  var type = (match[2] || 'ms').toLowerCase();
  switch (type) {
    case 'years':
    case 'year':
    case 'y':
      return n * y;
    case 'days':
    case 'day':
    case 'd':
      return n * d;
    case 'hours':
    case 'hour':
    case 'h':
      return n * h;
    case 'minutes':
    case 'minute':
    case 'm':
      return n * m;
    case 'seconds':
    case 'second':
    case 's':
      return n * s;
    case 'ms':
      return n;
  ***REMOVED***
***REMOVED***

/**
 * Short format for `ms`.
 *
 * @param {Number***REMOVED*** ms
 * @return {String***REMOVED***
 * @api private
 */

function shortFormat(ms) {
  if (ms >= d) return Math.round(ms / d) + 'd';
  if (ms >= h) return Math.round(ms / h) + 'h';
  if (ms >= m) return Math.round(ms / m) + 'm';
  if (ms >= s) return Math.round(ms / s) + 's';
  return ms + 'ms';
***REMOVED***

/**
 * Long format for `ms`.
 *
 * @param {Number***REMOVED*** ms
 * @return {String***REMOVED***
 * @api private
 */

function longFormat(ms) {
  return plural(ms, d, 'day')
    || plural(ms, h, 'hour')
    || plural(ms, m, 'minute')
    || plural(ms, s, 'second')
    || ms + ' ms';
***REMOVED***

/**
 * Pluralization helper.
 */

function plural(ms, n, name) {
  if (ms < n) return;
  if (ms < n * 1.5) return Math.floor(ms / n) + ' ' + name;
  return Math.ceil(ms / n) + ' ' + name + 's';
***REMOVED***

***REMOVED***); // module: ms.js

require.register("reporters/base.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var tty = require('browser/tty')
  , diff = require('browser/diff')
  , ms = require('../ms')
  , utils = require('../utils');

/**
 * Save timer references to avoid Sinon interfering (see GH-237).
 */

var Date = global.Date
  , setTimeout = global.setTimeout
  , setInterval = global.setInterval
  , clearTimeout = global.clearTimeout
  , clearInterval = global.clearInterval;

/**
 * Check if both stdio streams are associated with a tty.
 */

var isatty = tty.isatty(1) && tty.isatty(2);

/**
 * Expose `Base`.
 */

exports = module.exports = Base;

/**
 * Enable coloring by default.
 */

exports.useColors = isatty || (process.env.MOCHA_COLORS !== undefined);

/**
 * Inline diffs instead of +/-
 */

exports.inlineDiffs = false;

/**
 * Default color map.
 */

exports.colors = {
    'pass': 90
  , 'fail': 31
  , 'bright pass': 92
  , 'bright fail': 91
  , 'bright yellow': 93
  , 'pending': 36
  , 'suite': 0
  , 'error title': 0
  , 'error message': 31
  , 'error stack': 90
  , 'checkmark': 32
  , 'fast': 90
  , 'medium': 33
  , 'slow': 31
  , 'green': 32
  , 'light': 90
  , 'diff gutter': 90
  , 'diff added': 42
  , 'diff removed': 41
***REMOVED***;

/**
 * Default symbol map.
 */

exports.symbols = {
  ok: '✓',
  err: '✖',
  dot: '․'
***REMOVED***;

// With node.js on Windows: use symbols available in terminal default fonts
if ('win32' == process.platform) {
  exports.symbols.ok = '\u221A';
  exports.symbols.err = '\u00D7';
  exports.symbols.dot = '.';
***REMOVED***

/**
 * Color `str` with the given `type`,
 * allowing colors to be disabled,
 * as well as user-defined color
 * schemes.
 *
 * @param {String***REMOVED*** type
 * @param {String***REMOVED*** str
 * @return {String***REMOVED***
 * @api private
 */

var color = exports.color = function(type, str) {
  if (!exports.useColors) return str;
  return '\u001b[' + exports.colors[type] + 'm' + str + '\u001b[0m';
***REMOVED***;

/**
 * Expose term window size, with some
 * defaults for when stderr is not a tty.
 */

exports.window = {
  width: isatty
    ? process.stdout.getWindowSize
      ? process.stdout.getWindowSize(1)[0]
      : tty.getWindowSize()[1]
    : 75
***REMOVED***;

/**
 * Expose some basic cursor interactions
 * that are common among reporters.
 */

exports.cursor = {
  hide: function(){
    isatty && process.stdout.write('\u001b[?25l');
  ***REMOVED***,

  show: function(){
    isatty && process.stdout.write('\u001b[?25h');
  ***REMOVED***,

  deleteLine: function(){
    isatty && process.stdout.write('\u001b[2K');
  ***REMOVED***,

  beginningOfLine: function(){
    isatty && process.stdout.write('\u001b[0G');
  ***REMOVED***,

  CR: function(){
    if (isatty) {
      exports.cursor.deleteLine();
      exports.cursor.beginningOfLine();
    ***REMOVED*** else {
      process.stdout.write('\r');
    ***REMOVED***
  ***REMOVED***
***REMOVED***;

/**
 * Outut the given `failures` as a list.
 *
 * @param {Array***REMOVED*** failures
 * @api public
 */

exports.list = function(failures){
  console.error();
  failures.forEach(function(test, i){
    // format
    var fmt = color('error title', '  %s) %s:\n')
      + color('error message', '     %s')
      + color('error stack', '\n%s\n');

    // msg
    var err = test.err
      , message = err.message || ''
      , stack = err.stack || message
      , index = stack.indexOf(message) + message.length
      , msg = stack.slice(0, index)
      , actual = err.actual
      , expected = err.expected
      , escape = true;

    // uncaught
    if (err.uncaught) {
      msg = 'Uncaught ' + msg;
    ***REMOVED***

    // explicitly show diff
    if (err.showDiff && sameType(actual, expected)) {
      escape = false;
      err.actual = actual = stringify(canonicalize(actual));
      err.expected = expected = stringify(canonicalize(expected));
    ***REMOVED***

    // actual / expected diff
    if ('string' == typeof actual && 'string' == typeof expected) {
      fmt = color('error title', '  %s) %s:\n%s') + color('error stack', '\n%s\n');
      var match = message.match(/^([^:]+): expected/);
      msg = '\n      ' + color('error message', match ? match[1] : msg);

      if (exports.inlineDiffs) {
        msg += inlineDiff(err, escape);
      ***REMOVED*** else {
        msg += unifiedDiff(err, escape);
      ***REMOVED***
    ***REMOVED***

    // indent stack trace without msg
    stack = stack.slice(index ? index + 1 : index)
      .replace(/^/gm, '  ');

    console.error(fmt, (i + 1), test.fullTitle(), msg, stack);
  ***REMOVED***);
***REMOVED***;

/**
 * Initialize a new `Base` reporter.
 *
 * All other reporters generally
 * inherit from this reporter, providing
 * stats such as test duration, number
 * of tests passed / failed etc.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function Base(runner) {
  var self = this
    , stats = this.stats = { suites: 0, tests: 0, passes: 0, pending: 0, failures: 0 ***REMOVED***
    , failures = this.failures = [];

  if (!runner) return;
  this.runner = runner;

  runner.stats = stats;

  runner.on('start', function(){
    stats.start = new Date;
  ***REMOVED***);

  runner.on('suite', function(suite){
    stats.suites = stats.suites || 0;
    suite.root || stats.suites++;
  ***REMOVED***);

  runner.on('test end', function(test){
    stats.tests = stats.tests || 0;
    stats.tests++;
  ***REMOVED***);

  runner.on('pass', function(test){
    stats.passes = stats.passes || 0;

    var medium = test.slow() / 2;
    test.speed = test.duration > test.slow()
      ? 'slow'
      : test.duration > medium
        ? 'medium'
        : 'fast';

    stats.passes++;
  ***REMOVED***);

  runner.on('fail', function(test, err){
    stats.failures = stats.failures || 0;
    stats.failures++;
    test.err = err;
    failures.push(test);
  ***REMOVED***);

  runner.on('end', function(){
    stats.end = new Date;
    stats.duration = new Date - stats.start;
  ***REMOVED***);

  runner.on('pending', function(){
    stats.pending++;
  ***REMOVED***);
***REMOVED***

/**
 * Output common epilogue used by many of
 * the bundled reporters.
 *
 * @api public
 */

Base.prototype.epilogue = function(){
  var stats = this.stats;
  var tests;
  var fmt;

  console.log();

  // passes
  fmt = color('bright pass', ' ')
    + color('green', ' %d passing')
    + color('light', ' (%s)');

  console.log(fmt,
    stats.passes || 0,
    ms(stats.duration));

  // pending
  if (stats.pending) {
    fmt = color('pending', ' ')
      + color('pending', ' %d pending');

    console.log(fmt, stats.pending);
  ***REMOVED***

  // failures
  if (stats.failures) {
    fmt = color('fail', '  %d failing');

    console.error(fmt,
      stats.failures);

    Base.list(this.failures);
    console.error();
  ***REMOVED***

  console.log();
***REMOVED***;

/**
 * Pad the given `str` to `len`.
 *
 * @param {String***REMOVED*** str
 * @param {String***REMOVED*** len
 * @return {String***REMOVED***
 * @api private
 */

function pad(str, len) {
  str = String(str);
  return Array(len - str.length + 1).join(' ') + str;
***REMOVED***


/**
 * Returns an inline diff between 2 strings with coloured ANSI output
 *
 * @param {Error***REMOVED*** Error with actual/expected
 * @return {String***REMOVED*** Diff
 * @api private
 */

function inlineDiff(err, escape) {
  var msg = errorDiff(err, 'WordsWithSpace', escape);

  // linenos
  var lines = msg.split('\n');
  if (lines.length > 4) {
    var width = String(lines.length).length;
    msg = lines.map(function(str, i){
      return pad(++i, width) + ' |' + ' ' + str;
    ***REMOVED***).join('\n');
  ***REMOVED***

  // legend
  msg = '\n'
    + color('diff removed', 'actual')
    + ' '
    + color('diff added', 'expected')
    + '\n\n'
    + msg
    + '\n';

  // indent
  msg = msg.replace(/^/gm, '      ');
  return msg;
***REMOVED***

/**
 * Returns a unified diff between 2 strings
 *
 * @param {Error***REMOVED*** Error with actual/expected
 * @return {String***REMOVED*** Diff
 * @api private
 */

function unifiedDiff(err, escape) {
  var indent = '      ';
  function cleanUp(line) {
    if (escape) {
      line = escapeInvisibles(line);
    ***REMOVED***
    if (line[0] === '+') return indent + colorLines('diff added', line);
    if (line[0] === '-') return indent + colorLines('diff removed', line);
    if (line.match(/\@\@/)) return null;
    if (line.match(/\\ No newline/)) return null;
    else return indent + line;
  ***REMOVED***
  function notBlank(line) {
    return line != null;
  ***REMOVED***
  msg = diff.createPatch('string', err.actual, err.expected);
  var lines = msg.split('\n').splice(4);
  return '\n      '
         + colorLines('diff added',   '+ expected') + ' '
         + colorLines('diff removed', '- actual')
         + '\n\n'
         + lines.map(cleanUp).filter(notBlank).join('\n');
***REMOVED***

/**
 * Return a character diff for `err`.
 *
 * @param {Error***REMOVED*** err
 * @return {String***REMOVED***
 * @api private
 */

function errorDiff(err, type, escape) {
  var actual   = escape ? escapeInvisibles(err.actual)   : err.actual;
  var expected = escape ? escapeInvisibles(err.expected) : err.expected;
  return diff['diff' + type](actual, expected).map(function(str){
    if (str.added) return colorLines('diff added', str.value);
    if (str.removed) return colorLines('diff removed', str.value);
    return str.value;
  ***REMOVED***).join('');
***REMOVED***

/**
 * Returns a string with all invisible characters in plain text
 *
 * @param {String***REMOVED*** line
 * @return {String***REMOVED***
 * @api private
 */
function escapeInvisibles(line) {
    return line.replace(/\t/g, '<tab>')
               .replace(/\r/g, '<CR>')
               .replace(/\n/g, '<LF>\n');
***REMOVED***

/**
 * Color lines for `str`, using the color `name`.
 *
 * @param {String***REMOVED*** name
 * @param {String***REMOVED*** str
 * @return {String***REMOVED***
 * @api private
 */

function colorLines(name, str) {
  return str.split('\n').map(function(str){
    return color(name, str);
  ***REMOVED***).join('\n');
***REMOVED***

/**
 * Stringify `obj`.
 *
 * @param {Object***REMOVED*** obj
 * @return {String***REMOVED***
 * @api private
 */

function stringify(obj) {
  if (obj instanceof RegExp) return obj.toString();
  return JSON.stringify(obj, null, 2);
***REMOVED***

/**
 * Return a new object that has the keys in sorted order.
 * @param {Object***REMOVED*** obj
 * @return {Object***REMOVED***
 * @api private
 */

 function canonicalize(obj, stack) {
   stack = stack || [];

   if (utils.indexOf(stack, obj) !== -1) return obj;

   var canonicalizedObj;

   if ('[object Array]' == {***REMOVED***.toString.call(obj)) {
     stack.push(obj);
     canonicalizedObj = utils.map(obj, function(item) {
       return canonicalize(item, stack);
     ***REMOVED***);
     stack.pop();
   ***REMOVED*** else if (typeof obj === 'object' && obj !== null) {
     stack.push(obj);
     canonicalizedObj = {***REMOVED***;
     utils.forEach(utils.keys(obj).sort(), function(key) {
       canonicalizedObj[key] = canonicalize(obj[key], stack);
     ***REMOVED***);
     stack.pop();
   ***REMOVED*** else {
     canonicalizedObj = obj;
   ***REMOVED***

   return canonicalizedObj;
 ***REMOVED***

/**
 * Check that a / b have the same type.
 *
 * @param {Object***REMOVED*** a
 * @param {Object***REMOVED*** b
 * @return {Boolean***REMOVED***
 * @api private
 */

function sameType(a, b) {
  a = Object.prototype.toString.call(a);
  b = Object.prototype.toString.call(b);
  return a == b;
***REMOVED***


***REMOVED***); // module: reporters/base.js

require.register("reporters/doc.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , utils = require('../utils');

/**
 * Expose `Doc`.
 */

exports = module.exports = Doc;

/**
 * Initialize a new `Doc` reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function Doc(runner) {
  Base.call(this, runner);

  var self = this
    , stats = this.stats
    , total = runner.total
    , indents = 2;

  function indent() {
    return Array(indents).join('  ');
  ***REMOVED***

  runner.on('suite', function(suite){
    if (suite.root) return;
    ++indents;
    console.log('%s<section class="suite">', indent());
    ++indents;
    console.log('%s<h1>%s</h1>', indent(), utils.escape(suite.title));
    console.log('%s<dl>', indent());
  ***REMOVED***);

  runner.on('suite end', function(suite){
    if (suite.root) return;
    console.log('%s</dl>', indent());
    --indents;
    console.log('%s</section>', indent());
    --indents;
  ***REMOVED***);

  runner.on('pass', function(test){
    console.log('%s  <dt>%s</dt>', indent(), utils.escape(test.title));
    var code = utils.escape(utils.clean(test.fn.toString()));
    console.log('%s  <dd><pre><code>%s</code></pre></dd>', indent(), code);
  ***REMOVED***);
***REMOVED***

***REMOVED***); // module: reporters/doc.js

require.register("reporters/dot.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , color = Base.color;

/**
 * Expose `Dot`.
 */

exports = module.exports = Dot;

/**
 * Initialize a new `Dot` matrix test reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function Dot(runner) {
  Base.call(this, runner);

  var self = this
    , stats = this.stats
    , width = Base.window.width * .75 | 0
    , n = 0;

  runner.on('start', function(){
    process.stdout.write('\n  ');
  ***REMOVED***);

  runner.on('pending', function(test){
    process.stdout.write(color('pending', Base.symbols.dot));
  ***REMOVED***);

  runner.on('pass', function(test){
    if (++n % width == 0) process.stdout.write('\n  ');
    if ('slow' == test.speed) {
      process.stdout.write(color('bright yellow', Base.symbols.dot));
    ***REMOVED*** else {
      process.stdout.write(color(test.speed, Base.symbols.dot));
    ***REMOVED***
  ***REMOVED***);

  runner.on('fail', function(test, err){
    if (++n % width == 0) process.stdout.write('\n  ');
    process.stdout.write(color('fail', Base.symbols.dot));
  ***REMOVED***);

  runner.on('end', function(){
    console.log();
    self.epilogue();
  ***REMOVED***);
***REMOVED***

/**
 * Inherit from `Base.prototype`.
 */

function F(){***REMOVED***;
F.prototype = Base.prototype;
Dot.prototype = new F;
Dot.prototype.constructor = Dot;

***REMOVED***); // module: reporters/dot.js

require.register("reporters/html-cov.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var JSONCov = require('./json-cov')
  , fs = require('browser/fs');

/**
 * Expose `HTMLCov`.
 */

exports = module.exports = HTMLCov;

/**
 * Initialize a new `JsCoverage` reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function HTMLCov(runner) {
  var jade = require('jade')
    , file = __dirname + '/templates/coverage.jade'
    , str = fs.readFileSync(file, 'utf8')
    , fn = jade.compile(str, { filename: file ***REMOVED***)
    , self = this;

  JSONCov.call(this, runner, false);

  runner.on('end', function(){
    process.stdout.write(fn({
        cov: self.cov
      , coverageClass: coverageClass
    ***REMOVED***));
  ***REMOVED***);
***REMOVED***

/**
 * Return coverage class for `n`.
 *
 * @return {String***REMOVED***
 * @api private
 */

function coverageClass(n) {
  if (n >= 75) return 'high';
  if (n >= 50) return 'medium';
  if (n >= 25) return 'low';
  return 'terrible';
***REMOVED***
***REMOVED***); // module: reporters/html-cov.js

require.register("reporters/html.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , utils = require('../utils')
  , Progress = require('../browser/progress')
  , escape = utils.escape;

/**
 * Save timer references to avoid Sinon interfering (see GH-237).
 */

var Date = global.Date
  , setTimeout = global.setTimeout
  , setInterval = global.setInterval
  , clearTimeout = global.clearTimeout
  , clearInterval = global.clearInterval;

/**
 * Expose `HTML`.
 */

exports = module.exports = HTML;

/**
 * Stats template.
 */

var statsTemplate = '<ul id="mocha-stats">'
  + '<li class="progress"><canvas width="40" height="40"></canvas></li>'
  + '<li class="passes"><a href="#">passes:</a> <em>0</em></li>'
  + '<li class="failures"><a href="#">failures:</a> <em>0</em></li>'
  + '<li class="duration">duration: <em>0</em>s</li>'
  + '</ul>';

/**
 * Initialize a new `HTML` reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function HTML(runner, root) {
  Base.call(this, runner);

  var self = this
    , stats = this.stats
    , total = runner.total
    , stat = fragment(statsTemplate)
    , items = stat.getElementsByTagName('li')
    , passes = items[1].getElementsByTagName('em')[0]
    , passesLink = items[1].getElementsByTagName('a')[0]
    , failures = items[2].getElementsByTagName('em')[0]
    , failuresLink = items[2].getElementsByTagName('a')[0]
    , duration = items[3].getElementsByTagName('em')[0]
    , canvas = stat.getElementsByTagName('canvas')[0]
    , report = fragment('<ul id="mocha-report"></ul>')
    , stack = [report]
    , progress
    , ctx

  root = root || document.getElementById('mocha');

  if (canvas.getContext) {
    var ratio = window.devicePixelRatio || 1;
    canvas.style.width = canvas.width;
    canvas.style.height = canvas.height;
    canvas.width *= ratio;
    canvas.height *= ratio;
    ctx = canvas.getContext('2d');
    ctx.scale(ratio, ratio);
    progress = new Progress;
  ***REMOVED***

  if (!root) return error('#mocha div missing, add it to your document');

  // pass toggle
  on(passesLink, 'click', function(){
    unhide();
    var name = /pass/.test(report.className) ? '' : ' pass';
    report.className = report.className.replace(/fail|pass/g, '') + name;
    if (report.className.trim()) hideSuitesWithout('test pass');
  ***REMOVED***);

  // failure toggle
  on(failuresLink, 'click', function(){
    unhide();
    var name = /fail/.test(report.className) ? '' : ' fail';
    report.className = report.className.replace(/fail|pass/g, '') + name;
    if (report.className.trim()) hideSuitesWithout('test fail');
  ***REMOVED***);

  root.appendChild(stat);
  root.appendChild(report);

  if (progress) progress.size(40);

  runner.on('suite', function(suite){
    if (suite.root) return;

    // suite
    var url = self.suiteURL(suite);
    var el = fragment('<li class="suite"><h1><a href="%s">%s</a></h1></li>', url, escape(suite.title));

    // container
    stack[0].appendChild(el);
    stack.unshift(document.createElement('ul'));
    el.appendChild(stack[0]);
  ***REMOVED***);

  runner.on('suite end', function(suite){
    if (suite.root) return;
    stack.shift();
  ***REMOVED***);

  runner.on('fail', function(test, err){
    if ('hook' == test.type) runner.emit('test end', test);
  ***REMOVED***);

  runner.on('test end', function(test){
    // TODO: add to stats
    var percent = stats.tests / this.total * 100 | 0;
    if (progress) progress.update(percent).draw(ctx);

    // update stats
    var ms = new Date - stats.start;
    text(passes, stats.passes);
    text(failures, stats.failures);
    text(duration, (ms / 1000).toFixed(2));

    // test
    if ('passed' == test.state) {
      var url = self.testURL(test);
      var el = fragment('<li class="test pass %e"><h2>%e<span class="duration">%ems</span> <a href="%s" class="replay">‣</a></h2></li>', test.speed, test.title, test.duration, url);
    ***REMOVED*** else if (test.pending) {
      var el = fragment('<li class="test pass pending"><h2>%e</h2></li>', test.title);
    ***REMOVED*** else {
      var el = fragment('<li class="test fail"><h2>%e <a href="?grep=%e" class="replay">‣</a></h2></li>', test.title, encodeURIComponent(test.fullTitle()));
      var str = test.err.stack || test.err.toString();

      // FF / Opera do not add the message
      if (!~str.indexOf(test.err.message)) {
        str = test.err.message + '\n' + str;
      ***REMOVED***

      // <=IE7 stringifies to [Object Error]. Since it can be overloaded, we
      // check for the result of the stringifying.
      if ('[object Error]' == str) str = test.err.message;

      // Safari doesn't give you a stack. Let's at least provide a source line.
      if (!test.err.stack && test.err.sourceURL && test.err.line !== undefined) {
        str += "\n(" + test.err.sourceURL + ":" + test.err.line + ")";
      ***REMOVED***

      el.appendChild(fragment('<pre class="error">%e</pre>', str));
    ***REMOVED***

    // toggle code
    // TODO: defer
    if (!test.pending) {
      var h2 = el.getElementsByTagName('h2')[0];

      on(h2, 'click', function(){
        pre.style.display = 'none' == pre.style.display
          ? 'block'
          : 'none';
      ***REMOVED***);

      var pre = fragment('<pre><code>%e</code></pre>', utils.clean(test.fn.toString()));
      el.appendChild(pre);
      pre.style.display = 'none';
    ***REMOVED***

    // Don't call .appendChild if #mocha-report was already .shift()'ed off the stack.
    if (stack[0]) stack[0].appendChild(el);
  ***REMOVED***);
***REMOVED***

/**
 * Provide suite URL
 *
 * @param {Object***REMOVED*** [suite]
 */

HTML.prototype.suiteURL = function(suite){
  return '?grep=' + encodeURIComponent(suite.fullTitle());
***REMOVED***;

/**
 * Provide test URL
 *
 * @param {Object***REMOVED*** [test]
 */

HTML.prototype.testURL = function(test){
  return '?grep=' + encodeURIComponent(test.fullTitle());
***REMOVED***;

/**
 * Display error `msg`.
 */

function error(msg) {
  document.body.appendChild(fragment('<div id="mocha-error">%s</div>', msg));
***REMOVED***

/**
 * Return a DOM fragment from `html`.
 */

function fragment(html) {
  var args = arguments
    , div = document.createElement('div')
    , i = 1;

  div.innerHTML = html.replace(/%([se])/g, function(_, type){
    switch (type) {
      case 's': return String(args[i++]);
      case 'e': return escape(args[i++]);
    ***REMOVED***
  ***REMOVED***);

  return div.firstChild;
***REMOVED***

/**
 * Check for suites that do not have elements
 * with `classname`, and hide them.
 */

function hideSuitesWithout(classname) {
  var suites = document.getElementsByClassName('suite');
  for (var i = 0; i < suites.length; i++) {
    var els = suites[i].getElementsByClassName(classname);
    if (0 == els.length) suites[i].className += ' hidden';
  ***REMOVED***
***REMOVED***

/**
 * Unhide .hidden suites.
 */

function unhide() {
  var els = document.getElementsByClassName('suite hidden');
  for (var i = 0; i < els.length; ++i) {
    els[i].className = els[i].className.replace('suite hidden', 'suite');
  ***REMOVED***
***REMOVED***

/**
 * Set `el` text to `str`.
 */

function text(el, str) {
  if (el.textContent) {
    el.textContent = str;
  ***REMOVED*** else {
    el.innerText = str;
  ***REMOVED***
***REMOVED***

/**
 * Listen on `event` with callback `fn`.
 */

function on(el, event, fn) {
  if (el.addEventListener) {
    el.addEventListener(event, fn, false);
  ***REMOVED*** else {
    el.attachEvent('on' + event, fn);
  ***REMOVED***
***REMOVED***

***REMOVED***); // module: reporters/html.js

require.register("reporters/index.js", function(module, exports, require){

exports.Base = require('./base');
exports.Dot = require('./dot');
exports.Doc = require('./doc');
exports.TAP = require('./tap');
exports.JSON = require('./json');
exports.HTML = require('./html');
exports.List = require('./list');
exports.Min = require('./min');
exports.Spec = require('./spec');
exports.Nyan = require('./nyan');
exports.XUnit = require('./xunit');
exports.Markdown = require('./markdown');
exports.Progress = require('./progress');
exports.Landing = require('./landing');
exports.JSONCov = require('./json-cov');
exports.HTMLCov = require('./html-cov');
exports.JSONStream = require('./json-stream');

***REMOVED***); // module: reporters/index.js

require.register("reporters/json-cov.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base');

/**
 * Expose `JSONCov`.
 */

exports = module.exports = JSONCov;

/**
 * Initialize a new `JsCoverage` reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @param {Boolean***REMOVED*** output
 * @api public
 */

function JSONCov(runner, output) {
  var self = this
    , output = 1 == arguments.length ? true : output;

  Base.call(this, runner);

  var tests = []
    , failures = []
    , passes = [];

  runner.on('test end', function(test){
    tests.push(test);
  ***REMOVED***);

  runner.on('pass', function(test){
    passes.push(test);
  ***REMOVED***);

  runner.on('fail', function(test){
    failures.push(test);
  ***REMOVED***);

  runner.on('end', function(){
    var cov = global._$jscoverage || {***REMOVED***;
    var result = self.cov = map(cov);
    result.stats = self.stats;
    result.tests = tests.map(clean);
    result.failures = failures.map(clean);
    result.passes = passes.map(clean);
    if (!output) return;
    process.stdout.write(JSON.stringify(result, null, 2 ));
  ***REMOVED***);
***REMOVED***

/**
 * Map jscoverage data to a JSON structure
 * suitable for reporting.
 *
 * @param {Object***REMOVED*** cov
 * @return {Object***REMOVED***
 * @api private
 */

function map(cov) {
  var ret = {
      instrumentation: 'node-jscoverage'
    , sloc: 0
    , hits: 0
    , misses: 0
    , coverage: 0
    , files: []
  ***REMOVED***;

  for (var filename in cov) {
    var data = coverage(filename, cov[filename]);
    ret.files.push(data);
    ret.hits += data.hits;
    ret.misses += data.misses;
    ret.sloc += data.sloc;
  ***REMOVED***

  ret.files.sort(function(a, b) {
    return a.filename.localeCompare(b.filename);
  ***REMOVED***);

  if (ret.sloc > 0) {
    ret.coverage = (ret.hits / ret.sloc) * 100;
  ***REMOVED***

  return ret;
***REMOVED***;

/**
 * Map jscoverage data for a single source file
 * to a JSON structure suitable for reporting.
 *
 * @param {String***REMOVED*** filename name of the source file
 * @param {Object***REMOVED*** data jscoverage coverage data
 * @return {Object***REMOVED***
 * @api private
 */

function coverage(filename, data) {
  var ret = {
    filename: filename,
    coverage: 0,
    hits: 0,
    misses: 0,
    sloc: 0,
    source: {***REMOVED***
  ***REMOVED***;

  data.source.forEach(function(line, num){
    num++;

    if (data[num] === 0) {
      ret.misses++;
      ret.sloc++;
    ***REMOVED*** else if (data[num] !== undefined) {
      ret.hits++;
      ret.sloc++;
    ***REMOVED***

    ret.source[num] = {
        source: line
      , coverage: data[num] === undefined
        ? ''
        : data[num]
    ***REMOVED***;
  ***REMOVED***);

  ret.coverage = ret.hits / ret.sloc * 100;

  return ret;
***REMOVED***

/**
 * Return a plain-object representation of `test`
 * free of cyclic properties etc.
 *
 * @param {Object***REMOVED*** test
 * @return {Object***REMOVED***
 * @api private
 */

function clean(test) {
  return {
      title: test.title
    , fullTitle: test.fullTitle()
    , duration: test.duration
  ***REMOVED***
***REMOVED***

***REMOVED***); // module: reporters/json-cov.js

require.register("reporters/json-stream.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , color = Base.color;

/**
 * Expose `List`.
 */

exports = module.exports = List;

/**
 * Initialize a new `List` test reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function List(runner) {
  Base.call(this, runner);

  var self = this
    , stats = this.stats
    , total = runner.total;

  runner.on('start', function(){
    console.log(JSON.stringify(['start', { total: total ***REMOVED***]));
  ***REMOVED***);

  runner.on('pass', function(test){
    console.log(JSON.stringify(['pass', clean(test)]));
  ***REMOVED***);

  runner.on('fail', function(test, err){
    console.log(JSON.stringify(['fail', clean(test)]));
  ***REMOVED***);

  runner.on('end', function(){
    process.stdout.write(JSON.stringify(['end', self.stats]));
  ***REMOVED***);
***REMOVED***

/**
 * Return a plain-object representation of `test`
 * free of cyclic properties etc.
 *
 * @param {Object***REMOVED*** test
 * @return {Object***REMOVED***
 * @api private
 */

function clean(test) {
  return {
      title: test.title
    , fullTitle: test.fullTitle()
    , duration: test.duration
  ***REMOVED***
***REMOVED***
***REMOVED***); // module: reporters/json-stream.js

require.register("reporters/json.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , cursor = Base.cursor
  , color = Base.color;

/**
 * Expose `JSON`.
 */

exports = module.exports = JSONReporter;

/**
 * Initialize a new `JSON` reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function JSONReporter(runner) {
  var self = this;
  Base.call(this, runner);

  var tests = []
    , failures = []
    , passes = [];

  runner.on('test end', function(test){
    tests.push(test);
  ***REMOVED***);

  runner.on('pass', function(test){
    passes.push(test);
  ***REMOVED***);

  runner.on('fail', function(test){
    failures.push(test);
  ***REMOVED***);

  runner.on('end', function(){
    var obj = {
        stats: self.stats
      , tests: tests.map(clean)
      , failures: failures.map(clean)
      , passes: passes.map(clean)
    ***REMOVED***;

    process.stdout.write(JSON.stringify(obj, null, 2));
  ***REMOVED***);
***REMOVED***

/**
 * Return a plain-object representation of `test`
 * free of cyclic properties etc.
 *
 * @param {Object***REMOVED*** test
 * @return {Object***REMOVED***
 * @api private
 */

function clean(test) {
  return {
      title: test.title
    , fullTitle: test.fullTitle()
    , duration: test.duration
  ***REMOVED***
***REMOVED***
***REMOVED***); // module: reporters/json.js

require.register("reporters/landing.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , cursor = Base.cursor
  , color = Base.color;

/**
 * Expose `Landing`.
 */

exports = module.exports = Landing;

/**
 * Airplane color.
 */

Base.colors.plane = 0;

/**
 * Airplane crash color.
 */

Base.colors['plane crash'] = 31;

/**
 * Runway color.
 */

Base.colors.runway = 90;

/**
 * Initialize a new `Landing` reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function Landing(runner) {
  Base.call(this, runner);

  var self = this
    , stats = this.stats
    , width = Base.window.width * .75 | 0
    , total = runner.total
    , stream = process.stdout
    , plane = color('plane', '✈')
    , crashed = -1
    , n = 0;

  function runway() {
    var buf = Array(width).join('-');
    return '  ' + color('runway', buf);
  ***REMOVED***

  runner.on('start', function(){
    stream.write('\n  ');
    cursor.hide();
  ***REMOVED***);

  runner.on('test end', function(test){
    // check if the plane crashed
    var col = -1 == crashed
      ? width * ++n / total | 0
      : crashed;

    // show the crash
    if ('failed' == test.state) {
      plane = color('plane crash', '✈');
      crashed = col;
    ***REMOVED***

    // render landing strip
    stream.write('\u001b[4F\n\n');
    stream.write(runway());
    stream.write('\n  ');
    stream.write(color('runway', Array(col).join('⋅')));
    stream.write(plane)
    stream.write(color('runway', Array(width - col).join('⋅') + '\n'));
    stream.write(runway());
    stream.write('\u001b[0m');
  ***REMOVED***);

  runner.on('end', function(){
    cursor.show();
    console.log();
    self.epilogue();
  ***REMOVED***);
***REMOVED***

/**
 * Inherit from `Base.prototype`.
 */

function F(){***REMOVED***;
F.prototype = Base.prototype;
Landing.prototype = new F;
Landing.prototype.constructor = Landing;

***REMOVED***); // module: reporters/landing.js

require.register("reporters/list.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , cursor = Base.cursor
  , color = Base.color;

/**
 * Expose `List`.
 */

exports = module.exports = List;

/**
 * Initialize a new `List` test reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function List(runner) {
  Base.call(this, runner);

  var self = this
    , stats = this.stats
    , n = 0;

  runner.on('start', function(){
    console.log();
  ***REMOVED***);

  runner.on('test', function(test){
    process.stdout.write(color('pass', '    ' + test.fullTitle() + ': '));
  ***REMOVED***);

  runner.on('pending', function(test){
    var fmt = color('checkmark', '  -')
      + color('pending', ' %s');
    console.log(fmt, test.fullTitle());
  ***REMOVED***);

  runner.on('pass', function(test){
    var fmt = color('checkmark', '  '+Base.symbols.dot)
      + color('pass', ' %s: ')
      + color(test.speed, '%dms');
    cursor.CR();
    console.log(fmt, test.fullTitle(), test.duration);
  ***REMOVED***);

  runner.on('fail', function(test, err){
    cursor.CR();
    console.log(color('fail', '  %d) %s'), ++n, test.fullTitle());
  ***REMOVED***);

  runner.on('end', self.epilogue.bind(self));
***REMOVED***

/**
 * Inherit from `Base.prototype`.
 */

function F(){***REMOVED***;
F.prototype = Base.prototype;
List.prototype = new F;
List.prototype.constructor = List;


***REMOVED***); // module: reporters/list.js

require.register("reporters/markdown.js", function(module, exports, require){
/**
 * Module dependencies.
 */

var Base = require('./base')
  , utils = require('../utils');

/**
 * Expose `Markdown`.
 */

exports = module.exports = Markdown;

/**
 * Initialize a new `Markdown` reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function Markdown(runner) {
  Base.call(this, runner);

  var self = this
    , stats = this.stats
    , level = 0
    , buf = '';

  function title(str) {
    return Array(level).join('#') + ' ' + str;
  ***REMOVED***

  function indent() {
    return Array(level).join('  ');
  ***REMOVED***

  function mapTOC(suite, obj) {
    var ret = obj;
    obj = obj[suite.title] = obj[suite.title] || { suite: suite ***REMOVED***;
    suite.suites.forEach(function(suite){
      mapTOC(suite, obj);
    ***REMOVED***);
    return ret;
  ***REMOVED***

  function stringifyTOC(obj, level) {
    ++level;
    var buf = '';
    var link;
    for (var key in obj) {
      if ('suite' == key) continue;
      if (key) link = ' - [' + key + '](#' + utils.slug(obj[key].suite.fullTitle()) + ')\n';
      if (key) buf += Array(level).join('  ') + link;
      buf += stringifyTOC(obj[key], level);
    ***REMOVED***
    --level;
    return buf;
  ***REMOVED***

  function generateTOC(suite) {
    var obj = mapTOC(suite, {***REMOVED***);
    return stringifyTOC(obj, 0);
  ***REMOVED***

  generateTOC(runner.suite);

  runner.on('suite', function(suite){
    ++level;
    var slug = utils.slug(suite.fullTitle());
    buf += '<a name="' + slug + '"></a>' + '\n';
    buf += title(suite.title) + '\n';
  ***REMOVED***);

  runner.on('suite end', function(suite){
    --level;
  ***REMOVED***);

  runner.on('pass', function(test){
    var code = utils.clean(test.fn.toString());
    buf += test.title + '.\n';
    buf += '\n```js\n';
    buf += code + '\n';
    buf += '```\n\n';
  ***REMOVED***);

  runner.on('end', function(){
    process.stdout.write('# TOC\n');
    process.stdout.write(generateTOC(runner.suite));
    process.stdout.write(buf);
  ***REMOVED***);
***REMOVED***
***REMOVED***); // module: reporters/markdown.js

require.register("reporters/min.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base');

/**
 * Expose `Min`.
 */

exports = module.exports = Min;

/**
 * Initialize a new `Min` minimal test reporter (best used with --watch).
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function Min(runner) {
  Base.call(this, runner);

  runner.on('start', function(){
    // clear screen
    process.stdout.write('\u001b[2J');
    // set cursor position
    process.stdout.write('\u001b[1;3H');
  ***REMOVED***);

  runner.on('end', this.epilogue.bind(this));
***REMOVED***

/**
 * Inherit from `Base.prototype`.
 */

function F(){***REMOVED***;
F.prototype = Base.prototype;
Min.prototype = new F;
Min.prototype.constructor = Min;


***REMOVED***); // module: reporters/min.js

require.register("reporters/nyan.js", function(module, exports, require){
/**
 * Module dependencies.
 */

var Base = require('./base')
  , color = Base.color;

/**
 * Expose `Dot`.
 */

exports = module.exports = NyanCat;

/**
 * Initialize a new `Dot` matrix test reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function NyanCat(runner) {
  Base.call(this, runner);
  var self = this
    , stats = this.stats
    , width = Base.window.width * .75 | 0
    , rainbowColors = this.rainbowColors = self.generateColors()
    , colorIndex = this.colorIndex = 0
    , numerOfLines = this.numberOfLines = 4
    , trajectories = this.trajectories = [[], [], [], []]
    , nyanCatWidth = this.nyanCatWidth = 11
    , trajectoryWidthMax = this.trajectoryWidthMax = (width - nyanCatWidth)
    , scoreboardWidth = this.scoreboardWidth = 5
    , tick = this.tick = 0
    , n = 0;

  runner.on('start', function(){
    Base.cursor.hide();
    self.draw();
  ***REMOVED***);

  runner.on('pending', function(test){
    self.draw();
  ***REMOVED***);

  runner.on('pass', function(test){
    self.draw();
  ***REMOVED***);

  runner.on('fail', function(test, err){
    self.draw();
  ***REMOVED***);

  runner.on('end', function(){
    Base.cursor.show();
    for (var i = 0; i < self.numberOfLines; i++) write('\n');
    self.epilogue();
  ***REMOVED***);
***REMOVED***

/**
 * Draw the nyan cat
 *
 * @api private
 */

NyanCat.prototype.draw = function(){
  this.appendRainbow();
  this.drawScoreboard();
  this.drawRainbow();
  this.drawNyanCat();
  this.tick = !this.tick;
***REMOVED***;

/**
 * Draw the "scoreboard" showing the number
 * of passes, failures and pending tests.
 *
 * @api private
 */

NyanCat.prototype.drawScoreboard = function(){
  var stats = this.stats;
  var colors = Base.colors;

  function draw(color, n) {
    write(' ');
    write('\u001b[' + color + 'm' + n + '\u001b[0m');
    write('\n');
  ***REMOVED***

  draw(colors.green, stats.passes);
  draw(colors.fail, stats.failures);
  draw(colors.pending, stats.pending);
  write('\n');

  this.cursorUp(this.numberOfLines);
***REMOVED***;

/**
 * Append the rainbow.
 *
 * @api private
 */

NyanCat.prototype.appendRainbow = function(){
  var segment = this.tick ? '_' : '-';
  var rainbowified = this.rainbowify(segment);

  for (var index = 0; index < this.numberOfLines; index++) {
    var trajectory = this.trajectories[index];
    if (trajectory.length >= this.trajectoryWidthMax) trajectory.shift();
    trajectory.push(rainbowified);
  ***REMOVED***
***REMOVED***;

/**
 * Draw the rainbow.
 *
 * @api private
 */

NyanCat.prototype.drawRainbow = function(){
  var self = this;

  this.trajectories.forEach(function(line, index) {
    write('\u001b[' + self.scoreboardWidth + 'C');
    write(line.join(''));
    write('\n');
  ***REMOVED***);

  this.cursorUp(this.numberOfLines);
***REMOVED***;

/**
 * Draw the nyan cat
 *
 * @api private
 */

NyanCat.prototype.drawNyanCat = function() {
  var self = this;
  var startWidth = this.scoreboardWidth + this.trajectories[0].length;
  var color = '\u001b[' + startWidth + 'C';
  var padding = '';

  write(color);
  write('_,------,');
  write('\n');

  write(color);
  padding = self.tick ? '  ' : '   ';
  write('_|' + padding + '/\\_/\\ ');
  write('\n');

  write(color);
  padding = self.tick ? '_' : '__';
  var tail = self.tick ? '~' : '^';
  var face;
  write(tail + '|' + padding + this.face() + ' ');
  write('\n');

  write(color);
  padding = self.tick ? ' ' : '  ';
  write(padding + '""  "" ');
  write('\n');

  this.cursorUp(this.numberOfLines);
***REMOVED***;

/**
 * Draw nyan cat face.
 *
 * @return {String***REMOVED***
 * @api private
 */

NyanCat.prototype.face = function() {
  var stats = this.stats;
  if (stats.failures) {
    return '( x .x)';
  ***REMOVED*** else if (stats.pending) {
    return '( o .o)';
  ***REMOVED*** else if(stats.passes) {
    return '( ^ .^)';
  ***REMOVED*** else {
    return '( - .-)';
  ***REMOVED***
***REMOVED***

/**
 * Move cursor up `n`.
 *
 * @param {Number***REMOVED*** n
 * @api private
 */

NyanCat.prototype.cursorUp = function(n) {
  write('\u001b[' + n + 'A');
***REMOVED***;

/**
 * Move cursor down `n`.
 *
 * @param {Number***REMOVED*** n
 * @api private
 */

NyanCat.prototype.cursorDown = function(n) {
  write('\u001b[' + n + 'B');
***REMOVED***;

/**
 * Generate rainbow colors.
 *
 * @return {Array***REMOVED***
 * @api private
 */

NyanCat.prototype.generateColors = function(){
  var colors = [];

  for (var i = 0; i < (6 * 7); i++) {
    var pi3 = Math.floor(Math.PI / 3);
    var n = (i * (1.0 / 6));
    var r = Math.floor(3 * Math.sin(n) + 3);
    var g = Math.floor(3 * Math.sin(n + 2 * pi3) + 3);
    var b = Math.floor(3 * Math.sin(n + 4 * pi3) + 3);
    colors.push(36 * r + 6 * g + b + 16);
  ***REMOVED***

  return colors;
***REMOVED***;

/**
 * Apply rainbow to the given `str`.
 *
 * @param {String***REMOVED*** str
 * @return {String***REMOVED***
 * @api private
 */

NyanCat.prototype.rainbowify = function(str){
  var color = this.rainbowColors[this.colorIndex % this.rainbowColors.length];
  this.colorIndex += 1;
  return '\u001b[38;5;' + color + 'm' + str + '\u001b[0m';
***REMOVED***;

/**
 * Stdout helper.
 */

function write(string) {
  process.stdout.write(string);
***REMOVED***

/**
 * Inherit from `Base.prototype`.
 */

function F(){***REMOVED***;
F.prototype = Base.prototype;
NyanCat.prototype = new F;
NyanCat.prototype.constructor = NyanCat;


***REMOVED***); // module: reporters/nyan.js

require.register("reporters/progress.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , cursor = Base.cursor
  , color = Base.color;

/**
 * Expose `Progress`.
 */

exports = module.exports = Progress;

/**
 * General progress bar color.
 */

Base.colors.progress = 90;

/**
 * Initialize a new `Progress` bar test reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @param {Object***REMOVED*** options
 * @api public
 */

function Progress(runner, options) {
  Base.call(this, runner);

  var self = this
    , options = options || {***REMOVED***
    , stats = this.stats
    , width = Base.window.width * .50 | 0
    , total = runner.total
    , complete = 0
    , max = Math.max;

  // default chars
  options.open = options.open || '[';
  options.complete = options.complete || '▬';
  options.incomplete = options.incomplete || Base.symbols.dot;
  options.close = options.close || ']';
  options.verbose = false;

  // tests started
  runner.on('start', function(){
    console.log();
    cursor.hide();
  ***REMOVED***);

  // tests complete
  runner.on('test end', function(){
    complete++;
    var incomplete = total - complete
      , percent = complete / total
      , n = width * percent | 0
      , i = width - n;

    cursor.CR();
    process.stdout.write('\u001b[J');
    process.stdout.write(color('progress', '  ' + options.open));
    process.stdout.write(Array(n).join(options.complete));
    process.stdout.write(Array(i).join(options.incomplete));
    process.stdout.write(color('progress', options.close));
    if (options.verbose) {
      process.stdout.write(color('progress', ' ' + complete + ' of ' + total));
    ***REMOVED***
  ***REMOVED***);

  // tests are complete, output some stats
  // and the failures if any
  runner.on('end', function(){
    cursor.show();
    console.log();
    self.epilogue();
  ***REMOVED***);
***REMOVED***

/**
 * Inherit from `Base.prototype`.
 */

function F(){***REMOVED***;
F.prototype = Base.prototype;
Progress.prototype = new F;
Progress.prototype.constructor = Progress;


***REMOVED***); // module: reporters/progress.js

require.register("reporters/spec.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , cursor = Base.cursor
  , color = Base.color;

/**
 * Expose `Spec`.
 */

exports = module.exports = Spec;

/**
 * Initialize a new `Spec` test reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function Spec(runner) {
  Base.call(this, runner);

  var self = this
    , stats = this.stats
    , indents = 0
    , n = 0;

  function indent() {
    return Array(indents).join('  ')
  ***REMOVED***

  runner.on('start', function(){
    console.log();
  ***REMOVED***);

  runner.on('suite', function(suite){
    ++indents;
    console.log(color('suite', '%s%s'), indent(), suite.title);
  ***REMOVED***);

  runner.on('suite end', function(suite){
    --indents;
    if (1 == indents) console.log();
  ***REMOVED***);

  runner.on('pending', function(test){
    var fmt = indent() + color('pending', '  - %s');
    console.log(fmt, test.title);
  ***REMOVED***);

  runner.on('pass', function(test){
    if ('fast' == test.speed) {
      var fmt = indent()
        + color('checkmark', '  ' + Base.symbols.ok)
        + color('pass', ' %s ');
      cursor.CR();
      console.log(fmt, test.title);
    ***REMOVED*** else {
      var fmt = indent()
        + color('checkmark', '  ' + Base.symbols.ok)
        + color('pass', ' %s ')
        + color(test.speed, '(%dms)');
      cursor.CR();
      console.log(fmt, test.title, test.duration);
    ***REMOVED***
  ***REMOVED***);

  runner.on('fail', function(test, err){
    cursor.CR();
    console.log(indent() + color('fail', '  %d) %s'), ++n, test.title);
  ***REMOVED***);

  runner.on('end', self.epilogue.bind(self));
***REMOVED***

/**
 * Inherit from `Base.prototype`.
 */

function F(){***REMOVED***;
F.prototype = Base.prototype;
Spec.prototype = new F;
Spec.prototype.constructor = Spec;


***REMOVED***); // module: reporters/spec.js

require.register("reporters/tap.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , cursor = Base.cursor
  , color = Base.color;

/**
 * Expose `TAP`.
 */

exports = module.exports = TAP;

/**
 * Initialize a new `TAP` reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function TAP(runner) {
  Base.call(this, runner);

  var self = this
    , stats = this.stats
    , n = 1
    , passes = 0
    , failures = 0;

  runner.on('start', function(){
    var total = runner.grepTotal(runner.suite);
    console.log('%d..%d', 1, total);
  ***REMOVED***);

  runner.on('test end', function(){
    ++n;
  ***REMOVED***);

  runner.on('pending', function(test){
    console.log('ok %d %s # SKIP -', n, title(test));
  ***REMOVED***);

  runner.on('pass', function(test){
    passes++;
    console.log('ok %d %s', n, title(test));
  ***REMOVED***);

  runner.on('fail', function(test, err){
    failures++;
    console.log('not ok %d %s', n, title(test));
    if (err.stack) console.log(err.stack.replace(/^/gm, '  '));
  ***REMOVED***);

  runner.on('end', function(){
    console.log('# tests ' + (passes + failures));
    console.log('# pass ' + passes);
    console.log('# fail ' + failures);
  ***REMOVED***);
***REMOVED***

/**
 * Return a TAP-safe title of `test`
 *
 * @param {Object***REMOVED*** test
 * @return {String***REMOVED***
 * @api private
 */

function title(test) {
  return test.fullTitle().replace(/#/g, '');
***REMOVED***

***REMOVED***); // module: reporters/tap.js

require.register("reporters/xunit.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Base = require('./base')
  , utils = require('../utils')
  , escape = utils.escape;

/**
 * Save timer references to avoid Sinon interfering (see GH-237).
 */

var Date = global.Date
  , setTimeout = global.setTimeout
  , setInterval = global.setInterval
  , clearTimeout = global.clearTimeout
  , clearInterval = global.clearInterval;

/**
 * Expose `XUnit`.
 */

exports = module.exports = XUnit;

/**
 * Initialize a new `XUnit` reporter.
 *
 * @param {Runner***REMOVED*** runner
 * @api public
 */

function XUnit(runner) {
  Base.call(this, runner);
  var stats = this.stats
    , tests = []
    , self = this;

  runner.on('pending', function(test){
    tests.push(test);
  ***REMOVED***);

  runner.on('pass', function(test){
    tests.push(test);
  ***REMOVED***);

  runner.on('fail', function(test){
    tests.push(test);
  ***REMOVED***);

  runner.on('end', function(){
    console.log(tag('testsuite', {
        name: 'Mocha Tests'
      , tests: stats.tests
      , failures: stats.failures
      , errors: stats.failures
      , skipped: stats.tests - stats.failures - stats.passes
      , timestamp: (new Date).toUTCString()
      , time: (stats.duration / 1000) || 0
    ***REMOVED***, false));

    tests.forEach(test);
    console.log('</testsuite>');
  ***REMOVED***);
***REMOVED***

/**
 * Inherit from `Base.prototype`.
 */

function F(){***REMOVED***;
F.prototype = Base.prototype;
XUnit.prototype = new F;
XUnit.prototype.constructor = XUnit;


/**
 * Output tag for the given `test.`
 */

function test(test) {
  var attrs = {
      classname: test.parent.fullTitle()
    , name: test.title
    , time: (test.duration / 1000) || 0
  ***REMOVED***;

  if ('failed' == test.state) {
    var err = test.err;
    attrs.message = escape(err.message);
    console.log(tag('testcase', attrs, false, tag('failure', attrs, false, cdata(err.stack))));
  ***REMOVED*** else if (test.pending) {
    console.log(tag('testcase', attrs, false, tag('skipped', {***REMOVED***, true)));
  ***REMOVED*** else {
    console.log(tag('testcase', attrs, true) );
  ***REMOVED***
***REMOVED***

/**
 * HTML tag helper.
 */

function tag(name, attrs, close, content) {
  var end = close ? '/>' : '>'
    , pairs = []
    , tag;

  for (var key in attrs) {
    pairs.push(key + '="' + escape(attrs[key]) + '"');
  ***REMOVED***

  tag = '<' + name + (pairs.length ? ' ' + pairs.join(' ') : '') + end;
  if (content) tag += content + '</' + name + end;
  return tag;
***REMOVED***

/**
 * Return cdata escaped CDATA `str`.
 */

function cdata(str) {
  return '<![CDATA[' + escape(str) + ']]>';
***REMOVED***

***REMOVED***); // module: reporters/xunit.js

require.register("runnable.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var EventEmitter = require('browser/events').EventEmitter
  , debug = require('browser/debug')('mocha:runnable')
  , milliseconds = require('./ms');

/**
 * Save timer references to avoid Sinon interfering (see GH-237).
 */

var Date = global.Date
  , setTimeout = global.setTimeout
  , setInterval = global.setInterval
  , clearTimeout = global.clearTimeout
  , clearInterval = global.clearInterval;

/**
 * Object#toString().
 */

var toString = Object.prototype.toString;

/**
 * Expose `Runnable`.
 */

module.exports = Runnable;

/**
 * Initialize a new `Runnable` with the given `title` and callback `fn`.
 *
 * @param {String***REMOVED*** title
 * @param {Function***REMOVED*** fn
 * @api private
 */

function Runnable(title, fn) {
  this.title = title;
  this.fn = fn;
  this.async = fn && fn.length;
  this.sync = ! this.async;
  this._timeout = 2000;
  this._slow = 75;
  this.timedOut = false;
***REMOVED***

/**
 * Inherit from `EventEmitter.prototype`.
 */

function F(){***REMOVED***;
F.prototype = EventEmitter.prototype;
Runnable.prototype = new F;
Runnable.prototype.constructor = Runnable;


/**
 * Set & get timeout `ms`.
 *
 * @param {Number|String***REMOVED*** ms
 * @return {Runnable|Number***REMOVED*** ms or self
 * @api private
 */

Runnable.prototype.timeout = function(ms){
  if (0 == arguments.length) return this._timeout;
  if ('string' == typeof ms) ms = milliseconds(ms);
  debug('timeout %d', ms);
  this._timeout = ms;
  if (this.timer) this.resetTimeout();
  return this;
***REMOVED***;

/**
 * Set & get slow `ms`.
 *
 * @param {Number|String***REMOVED*** ms
 * @return {Runnable|Number***REMOVED*** ms or self
 * @api private
 */

Runnable.prototype.slow = function(ms){
  if (0 === arguments.length) return this._slow;
  if ('string' == typeof ms) ms = milliseconds(ms);
  debug('timeout %d', ms);
  this._slow = ms;
  return this;
***REMOVED***;

/**
 * Return the full title generated by recursively
 * concatenating the parent's full title.
 *
 * @return {String***REMOVED***
 * @api public
 */

Runnable.prototype.fullTitle = function(){
  return this.parent.fullTitle() + ' ' + this.title;
***REMOVED***;

/**
 * Clear the timeout.
 *
 * @api private
 */

Runnable.prototype.clearTimeout = function(){
  clearTimeout(this.timer);
***REMOVED***;

/**
 * Inspect the runnable void of private properties.
 *
 * @return {String***REMOVED***
 * @api private
 */

Runnable.prototype.inspect = function(){
  return JSON.stringify(this, function(key, val){
    if ('_' == key[0]) return;
    if ('parent' == key) return '#<Suite>';
    if ('ctx' == key) return '#<Context>';
    return val;
  ***REMOVED***, 2);
***REMOVED***;

/**
 * Reset the timeout.
 *
 * @api private
 */

Runnable.prototype.resetTimeout = function(){
  var self = this;
  var ms = this.timeout() || 1e9;

  this.clearTimeout();
  this.timer = setTimeout(function(){
    self.callback(new Error('timeout of ' + ms + 'ms exceeded'));
    self.timedOut = true;
  ***REMOVED***, ms);
***REMOVED***;

/**
 * Whitelist these globals for this test run
 *
 * @api private
 */
Runnable.prototype.globals = function(arr){
  var self = this;
  this._allowedGlobals = arr;
***REMOVED***;

/**
 * Run the test and invoke `fn(err)`.
 *
 * @param {Function***REMOVED*** fn
 * @api private
 */

Runnable.prototype.run = function(fn){
  var self = this
    , ms = this.timeout()
    , start = new Date
    , ctx = this.ctx
    , finished
    , emitted;

  if (ctx) ctx.runnable(this);

  // timeout
  if (this.async) {
    if (ms) {
      this.timer = setTimeout(function(){
        done(new Error('timeout of ' + ms + 'ms exceeded'));
        self.timedOut = true;
      ***REMOVED***, ms);
    ***REMOVED***
  ***REMOVED***

  // called multiple times
  function multiple(err) {
    if (emitted) return;
    emitted = true;
    self.emit('error', err || new Error('done() called multiple times'));
  ***REMOVED***

  // finished
  function done(err) {
    if (self.timedOut) return;
    if (finished) return multiple(err);
    self.clearTimeout();
    self.duration = new Date - start;
    finished = true;
    fn(err);
  ***REMOVED***

  // for .resetTimeout()
  this.callback = done;

  // async
  if (this.async) {
    try {
      this.fn.call(ctx, function(err){
        if (err instanceof Error || toString.call(err) === "[object Error]") return done(err);
        if (null != err) return done(new Error('done() invoked with non-Error: ' + err));
        done();
      ***REMOVED***);
    ***REMOVED*** catch (err) {
      done(err);
    ***REMOVED***
    return;
  ***REMOVED***

  if (this.asyncOnly) {
    return done(new Error('--async-only option in use without declaring `done()`'));
  ***REMOVED***

  // sync
  try {
    if (!this.pending) this.fn.call(ctx);
    this.duration = new Date - start;
    fn();
  ***REMOVED*** catch (err) {
    fn(err);
  ***REMOVED***
***REMOVED***;

***REMOVED***); // module: runnable.js

require.register("runner.js", function(module, exports, require){
/**
 * Module dependencies.
 */

var EventEmitter = require('browser/events').EventEmitter
  , debug = require('browser/debug')('mocha:runner')
  , Test = require('./test')
  , utils = require('./utils')
  , filter = utils.filter
  , keys = utils.keys;

/**
 * Non-enumerable globals.
 */

var globals = [
  'setTimeout',
  'clearTimeout',
  'setInterval',
  'clearInterval',
  'XMLHttpRequest',
  'Date'
];

/**
 * Expose `Runner`.
 */

module.exports = Runner;

/**
 * Initialize a `Runner` for the given `suite`.
 *
 * Events:
 *
 *   - `start`  execution started
 *   - `end`  execution complete
 *   - `suite`  (suite) test suite execution started
 *   - `suite end`  (suite) all tests (and sub-suites) have finished
 *   - `test`  (test) test execution started
 *   - `test end`  (test) test completed
 *   - `hook`  (hook) hook execution started
 *   - `hook end`  (hook) hook complete
 *   - `pass`  (test) test passed
 *   - `fail`  (test, err) test failed
 *   - `pending`  (test) test pending
 *
 * @api public
 */

function Runner(suite) {
  var self = this;
  this._globals = [];
  this._abort = false;
  this.suite = suite;
  this.total = suite.total();
  this.failures = 0;
  this.on('test end', function(test){ self.checkGlobals(test); ***REMOVED***);
  this.on('hook end', function(hook){ self.checkGlobals(hook); ***REMOVED***);
  this.grep(/.*/);
  this.globals(this.globalProps().concat(extraGlobals()));
***REMOVED***

/**
 * Wrapper for setImmediate, process.nextTick, or browser polyfill.
 *
 * @param {Function***REMOVED*** fn
 * @api private
 */

Runner.immediately = global.setImmediate || process.nextTick;

/**
 * Inherit from `EventEmitter.prototype`.
 */

function F(){***REMOVED***;
F.prototype = EventEmitter.prototype;
Runner.prototype = new F;
Runner.prototype.constructor = Runner;


/**
 * Run tests with full titles matching `re`. Updates runner.total
 * with number of tests matched.
 *
 * @param {RegExp***REMOVED*** re
 * @param {Boolean***REMOVED*** invert
 * @return {Runner***REMOVED*** for chaining
 * @api public
 */

Runner.prototype.grep = function(re, invert){
  debug('grep %s', re);
  this._grep = re;
  this._invert = invert;
  this.total = this.grepTotal(this.suite);
  return this;
***REMOVED***;

/**
 * Returns the number of tests matching the grep search for the
 * given suite.
 *
 * @param {Suite***REMOVED*** suite
 * @return {Number***REMOVED***
 * @api public
 */

Runner.prototype.grepTotal = function(suite) {
  var self = this;
  var total = 0;

  suite.eachTest(function(test){
    var match = self._grep.test(test.fullTitle());
    if (self._invert) match = !match;
    if (match) total++;
  ***REMOVED***);

  return total;
***REMOVED***;

/**
 * Return a list of global properties.
 *
 * @return {Array***REMOVED***
 * @api private
 */

Runner.prototype.globalProps = function() {
  var props = utils.keys(global);

  // non-enumerables
  for (var i = 0; i < globals.length; ++i) {
    if (~utils.indexOf(props, globals[i])) continue;
    props.push(globals[i]);
  ***REMOVED***

  return props;
***REMOVED***;

/**
 * Allow the given `arr` of globals.
 *
 * @param {Array***REMOVED*** arr
 * @return {Runner***REMOVED*** for chaining
 * @api public
 */

Runner.prototype.globals = function(arr){
  if (0 == arguments.length) return this._globals;
  debug('globals %j', arr);
  this._globals = this._globals.concat(arr);
  return this;
***REMOVED***;

/**
 * Check for global variable leaks.
 *
 * @api private
 */

Runner.prototype.checkGlobals = function(test){
  if (this.ignoreLeaks) return;
  var ok = this._globals;

  var globals = this.globalProps();
  var isNode = process.kill;
  var leaks;

  if (test) {
    ok = ok.concat(test._allowedGlobals || []);
  ***REMOVED***

  if(this.prevGlobalsLength == globals.length) return;
  this.prevGlobalsLength = globals.length;

  leaks = filterLeaks(ok, globals);
  this._globals = this._globals.concat(leaks);

  if (leaks.length > 1) {
    this.fail(test, new Error('global leaks detected: ' + leaks.join(', ') + ''));
  ***REMOVED*** else if (leaks.length) {
    this.fail(test, new Error('global leak detected: ' + leaks[0]));
  ***REMOVED***
***REMOVED***;

/**
 * Fail the given `test`.
 *
 * @param {Test***REMOVED*** test
 * @param {Error***REMOVED*** err
 * @api private
 */

Runner.prototype.fail = function(test, err){
  ++this.failures;
  test.state = 'failed';

  if ('string' == typeof err) {
    err = new Error('the string "' + err + '" was thrown, throw an Error :)');
  ***REMOVED***

  this.emit('fail', test, err);
***REMOVED***;

/**
 * Fail the given `hook` with `err`.
 *
 * Hook failures work in the following pattern:
 * - If bail, then exit
 * - Failed `before` hook skips all tests in a suite and subsuites,
 *   but jumps to corresponding `after` hook
 * - Failed `before each` hook skips remaining tests in a
 *   suite and jumps to corresponding `after each` hook,
 *   which is run only once
 * - Failed `after` hook does not alter
 *   execution order
 * - Failed `after each` hook skips remaining tests in a
 *   suite and subsuites, but executes other `after each`
 *   hooks
 *
 * @param {Hook***REMOVED*** hook
 * @param {Error***REMOVED*** err
 * @api private
 */

Runner.prototype.failHook = function(hook, err){
  this.fail(hook, err);
  if (this.suite.bail()) {
    this.emit('end');
  ***REMOVED***
***REMOVED***;

/**
 * Run hook `name` callbacks and then invoke `fn()`.
 *
 * @param {String***REMOVED*** name
 * @param {Function***REMOVED*** function
 * @api private
 */

Runner.prototype.hook = function(name, fn){
  var suite = this.suite
    , hooks = suite['_' + name]
    , self = this
    , timer;

  function next(i) {
    var hook = hooks[i];
    if (!hook) return fn();
    if (self.failures && suite.bail()) return fn();
    self.currentRunnable = hook;

    hook.ctx.currentTest = self.test;

    self.emit('hook', hook);

    hook.on('error', function(err){
      self.failHook(hook, err);
    ***REMOVED***);

    hook.run(function(err){
      hook.removeAllListeners('error');
      var testError = hook.error();
      if (testError) self.fail(self.test, testError);
      if (err) {
        self.failHook(hook, err);

        // stop executing hooks, notify callee of hook err
        return fn(err);
      ***REMOVED***
      self.emit('hook end', hook);
      delete hook.ctx.currentTest;
      next(++i);
    ***REMOVED***);
  ***REMOVED***

  Runner.immediately(function(){
    next(0);
  ***REMOVED***);
***REMOVED***;

/**
 * Run hook `name` for the given array of `suites`
 * in order, and callback `fn(err, errSuite)`.
 *
 * @param {String***REMOVED*** name
 * @param {Array***REMOVED*** suites
 * @param {Function***REMOVED*** fn
 * @api private
 */

Runner.prototype.hooks = function(name, suites, fn){
  var self = this
    , orig = this.suite;

  function next(suite) {
    self.suite = suite;

    if (!suite) {
      self.suite = orig;
      return fn();
    ***REMOVED***

    self.hook(name, function(err){
      if (err) {
        var errSuite = self.suite;
        self.suite = orig;
        return fn(err, errSuite);
      ***REMOVED***

      next(suites.pop());
    ***REMOVED***);
  ***REMOVED***

  next(suites.pop());
***REMOVED***;

/**
 * Run hooks from the top level down.
 *
 * @param {String***REMOVED*** name
 * @param {Function***REMOVED*** fn
 * @api private
 */

Runner.prototype.hookUp = function(name, fn){
  var suites = [this.suite].concat(this.parents()).reverse();
  this.hooks(name, suites, fn);
***REMOVED***;

/**
 * Run hooks from the bottom up.
 *
 * @param {String***REMOVED*** name
 * @param {Function***REMOVED*** fn
 * @api private
 */

Runner.prototype.hookDown = function(name, fn){
  var suites = [this.suite].concat(this.parents());
  this.hooks(name, suites, fn);
***REMOVED***;

/**
 * Return an array of parent Suites from
 * closest to furthest.
 *
 * @return {Array***REMOVED***
 * @api private
 */

Runner.prototype.parents = function(){
  var suite = this.suite
    , suites = [];
  while (suite = suite.parent) suites.push(suite);
  return suites;
***REMOVED***;

/**
 * Run the current test and callback `fn(err)`.
 *
 * @param {Function***REMOVED*** fn
 * @api private
 */

Runner.prototype.runTest = function(fn){
  var test = this.test
    , self = this;

  if (this.asyncOnly) test.asyncOnly = true;

  try {
    test.on('error', function(err){
      self.fail(test, err);
    ***REMOVED***);
    test.run(fn);
  ***REMOVED*** catch (err) {
    fn(err);
  ***REMOVED***
***REMOVED***;

/**
 * Run tests in the given `suite` and invoke
 * the callback `fn()` when complete.
 *
 * @param {Suite***REMOVED*** suite
 * @param {Function***REMOVED*** fn
 * @api private
 */

Runner.prototype.runTests = function(suite, fn){
  var self = this
    , tests = suite.tests.slice()
    , test;


  function hookErr(err, errSuite, after) {
    // before/after Each hook for errSuite failed:
    var orig = self.suite;

    // for failed 'after each' hook start from errSuite parent,
    // otherwise start from errSuite itself
    self.suite = after ? errSuite.parent : errSuite;

    if (self.suite) {
      // call hookUp afterEach
      self.hookUp('afterEach', function(err2, errSuite2) {
        self.suite = orig;
        // some hooks may fail even now
        if (err2) return hookErr(err2, errSuite2, true);
        // report error suite
        fn(errSuite);
      ***REMOVED***);
    ***REMOVED*** else {
      // there is no need calling other 'after each' hooks
      self.suite = orig;
      fn(errSuite);
    ***REMOVED***
  ***REMOVED***

  function next(err, errSuite) {
    // if we bail after first err
    if (self.failures && suite._bail) return fn();

    if (self._abort) return fn();

    if (err) return hookErr(err, errSuite, true);

    // next test
    test = tests.shift();

    // all done
    if (!test) return fn();

    // grep
    var match = self._grep.test(test.fullTitle());
    if (self._invert) match = !match;
    if (!match) return next();

    // pending
    if (test.pending) {
      self.emit('pending', test);
      self.emit('test end', test);
      return next();
    ***REMOVED***

    // execute test and hook(s)
    self.emit('test', self.test = test);
    self.hookDown('beforeEach', function(err, errSuite){

      if (err) return hookErr(err, errSuite, false);

      self.currentRunnable = self.test;
      self.runTest(function(err){
        test = self.test;

        if (err) {
          self.fail(test, err);
          self.emit('test end', test);
          return self.hookUp('afterEach', next);
        ***REMOVED***

        test.state = 'passed';
        self.emit('pass', test);
        self.emit('test end', test);
        self.hookUp('afterEach', next);
      ***REMOVED***);
    ***REMOVED***);
  ***REMOVED***

  this.next = next;
  next();
***REMOVED***;

/**
 * Run the given `suite` and invoke the
 * callback `fn()` when complete.
 *
 * @param {Suite***REMOVED*** suite
 * @param {Function***REMOVED*** fn
 * @api private
 */

Runner.prototype.runSuite = function(suite, fn){
  var total = this.grepTotal(suite)
    , self = this
    , i = 0;

  debug('run suite %s', suite.fullTitle());

  if (!total) return fn();

  this.emit('suite', this.suite = suite);

  function next(errSuite) {
    if (errSuite) {
      // current suite failed on a hook from errSuite
      if (errSuite == suite) {
        // if errSuite is current suite
        // continue to the next sibling suite
        return done();
      ***REMOVED*** else {
        // errSuite is among the parents of current suite
        // stop execution of errSuite and all sub-suites
        return done(errSuite);
      ***REMOVED***
    ***REMOVED***

    if (self._abort) return done();

    var curr = suite.suites[i++];
    if (!curr) return done();
    self.runSuite(curr, next);
  ***REMOVED***

  function done(errSuite) {
    self.suite = suite;
    self.hook('afterAll', function(){
      self.emit('suite end', suite);
      fn(errSuite);
    ***REMOVED***);
  ***REMOVED***

  this.hook('beforeAll', function(err){
    if (err) return done();
    self.runTests(suite, next);
  ***REMOVED***);
***REMOVED***;

/**
 * Handle uncaught exceptions.
 *
 * @param {Error***REMOVED*** err
 * @api private
 */

Runner.prototype.uncaught = function(err){
  debug('uncaught exception %s', err.message);
  var runnable = this.currentRunnable;
  if (!runnable || 'failed' == runnable.state) return;
  runnable.clearTimeout();
  err.uncaught = true;
  this.fail(runnable, err);

  // recover from test
  if ('test' == runnable.type) {
    this.emit('test end', runnable);
    this.hookUp('afterEach', this.next);
    return;
  ***REMOVED***

  // bail on hooks
  this.emit('end');
***REMOVED***;

/**
 * Run the root suite and invoke `fn(failures)`
 * on completion.
 *
 * @param {Function***REMOVED*** fn
 * @return {Runner***REMOVED*** for chaining
 * @api public
 */

Runner.prototype.run = function(fn){
  var self = this
    , fn = fn || function(){***REMOVED***;

  function uncaught(err){
    self.uncaught(err);
  ***REMOVED***

  debug('start');

  // callback
  this.on('end', function(){
    debug('end');
    process.removeListener('uncaughtException', uncaught);
    fn(self.failures);
  ***REMOVED***);

  // run suites
  this.emit('start');
  this.runSuite(this.suite, function(){
    debug('finished running');
    self.emit('end');
  ***REMOVED***);

  // uncaught exception
  process.on('uncaughtException', uncaught);

  return this;
***REMOVED***;

/**
 * Cleanly abort execution
 *
 * @return {Runner***REMOVED*** for chaining
 * @api public
 */
Runner.prototype.abort = function(){
  debug('aborting');
  this._abort = true;
***REMOVED***

/**
 * Filter leaks with the given globals flagged as `ok`.
 *
 * @param {Array***REMOVED*** ok
 * @param {Array***REMOVED*** globals
 * @return {Array***REMOVED***
 * @api private
 */

function filterLeaks(ok, globals) {
  return filter(globals, function(key){
    // Firefox and Chrome exposes iframes as index inside the window object
    if (/^d+/.test(key)) return false;

    // in firefox
    // if runner runs in an iframe, this iframe's window.getInterface method not init at first
    // it is assigned in some seconds
    if (global.navigator && /^getInterface/.test(key)) return false;

    // an iframe could be approached by window[iframeIndex]
    // in ie6,7,8 and opera, iframeIndex is enumerable, this could cause leak
    if (global.navigator && /^\d+/.test(key)) return false;

    // Opera and IE expose global variables for HTML element IDs (issue #243)
    if (/^mocha-/.test(key)) return false;

    var matched = filter(ok, function(ok){
      if (~ok.indexOf('*')) return 0 == key.indexOf(ok.split('*')[0]);
      return key == ok;
    ***REMOVED***);
    return matched.length == 0 && (!global.navigator || 'onerror' !== key);
  ***REMOVED***);
***REMOVED***

/**
 * Array of globals dependent on the environment.
 *
 * @return {Array***REMOVED***
 * @api private
 */

 function extraGlobals() {
  if (typeof(process) === 'object' &&
      typeof(process.version) === 'string') {

    var nodeVersion = process.version.split('.').reduce(function(a, v) {
      return a << 8 | v;
    ***REMOVED***);

    // 'errno' was renamed to process._errno in v0.9.11.

    if (nodeVersion < 0x00090B) {
      return ['errno'];
    ***REMOVED***
  ***REMOVED***

  return [];
 ***REMOVED***

***REMOVED***); // module: runner.js

require.register("suite.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var EventEmitter = require('browser/events').EventEmitter
  , debug = require('browser/debug')('mocha:suite')
  , milliseconds = require('./ms')
  , utils = require('./utils')
  , Hook = require('./hook');

/**
 * Expose `Suite`.
 */

exports = module.exports = Suite;

/**
 * Create a new `Suite` with the given `title`
 * and parent `Suite`. When a suite with the
 * same title is already present, that suite
 * is returned to provide nicer reporter
 * and more flexible meta-testing.
 *
 * @param {Suite***REMOVED*** parent
 * @param {String***REMOVED*** title
 * @return {Suite***REMOVED***
 * @api public
 */

exports.create = function(parent, title){
  var suite = new Suite(title, parent.ctx);
  suite.parent = parent;
  if (parent.pending) suite.pending = true;
  title = suite.fullTitle();
  parent.addSuite(suite);
  return suite;
***REMOVED***;

/**
 * Initialize a new `Suite` with the given
 * `title` and `ctx`.
 *
 * @param {String***REMOVED*** title
 * @param {Context***REMOVED*** ctx
 * @api private
 */

function Suite(title, ctx) {
  this.title = title;
  this.ctx = ctx;
  this.suites = [];
  this.tests = [];
  this.pending = false;
  this._beforeEach = [];
  this._beforeAll = [];
  this._afterEach = [];
  this._afterAll = [];
  this.root = !title;
  this._timeout = 2000;
  this._slow = 75;
  this._bail = false;
***REMOVED***

/**
 * Inherit from `EventEmitter.prototype`.
 */

function F(){***REMOVED***;
F.prototype = EventEmitter.prototype;
Suite.prototype = new F;
Suite.prototype.constructor = Suite;


/**
 * Return a clone of this `Suite`.
 *
 * @return {Suite***REMOVED***
 * @api private
 */

Suite.prototype.clone = function(){
  var suite = new Suite(this.title);
  debug('clone');
  suite.ctx = this.ctx;
  suite.timeout(this.timeout());
  suite.slow(this.slow());
  suite.bail(this.bail());
  return suite;
***REMOVED***;

/**
 * Set timeout `ms` or short-hand such as "2s".
 *
 * @param {Number|String***REMOVED*** ms
 * @return {Suite|Number***REMOVED*** for chaining
 * @api private
 */

Suite.prototype.timeout = function(ms){
  if (0 == arguments.length) return this._timeout;
  if ('string' == typeof ms) ms = milliseconds(ms);
  debug('timeout %d', ms);
  this._timeout = parseInt(ms, 10);
  return this;
***REMOVED***;

/**
 * Set slow `ms` or short-hand such as "2s".
 *
 * @param {Number|String***REMOVED*** ms
 * @return {Suite|Number***REMOVED*** for chaining
 * @api private
 */

Suite.prototype.slow = function(ms){
  if (0 === arguments.length) return this._slow;
  if ('string' == typeof ms) ms = milliseconds(ms);
  debug('slow %d', ms);
  this._slow = ms;
  return this;
***REMOVED***;

/**
 * Sets whether to bail after first error.
 *
 * @parma {Boolean***REMOVED*** bail
 * @return {Suite|Number***REMOVED*** for chaining
 * @api private
 */

Suite.prototype.bail = function(bail){
  if (0 == arguments.length) return this._bail;
  debug('bail %s', bail);
  this._bail = bail;
  return this;
***REMOVED***;

/**
 * Run `fn(test[, done])` before running tests.
 *
 * @param {Function***REMOVED*** fn
 * @return {Suite***REMOVED*** for chaining
 * @api private
 */

Suite.prototype.beforeAll = function(fn){
  if (this.pending) return this;
  var hook = new Hook('"before all" hook', fn);
  hook.parent = this;
  hook.timeout(this.timeout());
  hook.slow(this.slow());
  hook.ctx = this.ctx;
  this._beforeAll.push(hook);
  this.emit('beforeAll', hook);
  return this;
***REMOVED***;

/**
 * Run `fn(test[, done])` after running tests.
 *
 * @param {Function***REMOVED*** fn
 * @return {Suite***REMOVED*** for chaining
 * @api private
 */

Suite.prototype.afterAll = function(fn){
  if (this.pending) return this;
  var hook = new Hook('"after all" hook', fn);
  hook.parent = this;
  hook.timeout(this.timeout());
  hook.slow(this.slow());
  hook.ctx = this.ctx;
  this._afterAll.push(hook);
  this.emit('afterAll', hook);
  return this;
***REMOVED***;

/**
 * Run `fn(test[, done])` before each test case.
 *
 * @param {Function***REMOVED*** fn
 * @return {Suite***REMOVED*** for chaining
 * @api private
 */

Suite.prototype.beforeEach = function(fn){
  if (this.pending) return this;
  var hook = new Hook('"before each" hook', fn);
  hook.parent = this;
  hook.timeout(this.timeout());
  hook.slow(this.slow());
  hook.ctx = this.ctx;
  this._beforeEach.push(hook);
  this.emit('beforeEach', hook);
  return this;
***REMOVED***;

/**
 * Run `fn(test[, done])` after each test case.
 *
 * @param {Function***REMOVED*** fn
 * @return {Suite***REMOVED*** for chaining
 * @api private
 */

Suite.prototype.afterEach = function(fn){
  if (this.pending) return this;
  var hook = new Hook('"after each" hook', fn);
  hook.parent = this;
  hook.timeout(this.timeout());
  hook.slow(this.slow());
  hook.ctx = this.ctx;
  this._afterEach.push(hook);
  this.emit('afterEach', hook);
  return this;
***REMOVED***;

/**
 * Add a test `suite`.
 *
 * @param {Suite***REMOVED*** suite
 * @return {Suite***REMOVED*** for chaining
 * @api private
 */

Suite.prototype.addSuite = function(suite){
  suite.parent = this;
  suite.timeout(this.timeout());
  suite.slow(this.slow());
  suite.bail(this.bail());
  this.suites.push(suite);
  this.emit('suite', suite);
  return this;
***REMOVED***;

/**
 * Add a `test` to this suite.
 *
 * @param {Test***REMOVED*** test
 * @return {Suite***REMOVED*** for chaining
 * @api private
 */

Suite.prototype.addTest = function(test){
  test.parent = this;
  test.timeout(this.timeout());
  test.slow(this.slow());
  test.ctx = this.ctx;
  this.tests.push(test);
  this.emit('test', test);
  return this;
***REMOVED***;

/**
 * Return the full title generated by recursively
 * concatenating the parent's full title.
 *
 * @return {String***REMOVED***
 * @api public
 */

Suite.prototype.fullTitle = function(){
  if (this.parent) {
    var full = this.parent.fullTitle();
    if (full) return full + ' ' + this.title;
  ***REMOVED***
  return this.title;
***REMOVED***;

/**
 * Return the total number of tests.
 *
 * @return {Number***REMOVED***
 * @api public
 */

Suite.prototype.total = function(){
  return utils.reduce(this.suites, function(sum, suite){
    return sum + suite.total();
  ***REMOVED***, 0) + this.tests.length;
***REMOVED***;

/**
 * Iterates through each suite recursively to find
 * all tests. Applies a function in the format
 * `fn(test)`.
 *
 * @param {Function***REMOVED*** fn
 * @return {Suite***REMOVED***
 * @api private
 */

Suite.prototype.eachTest = function(fn){
  utils.forEach(this.tests, fn);
  utils.forEach(this.suites, function(suite){
    suite.eachTest(fn);
  ***REMOVED***);
  return this;
***REMOVED***;

***REMOVED***); // module: suite.js

require.register("test.js", function(module, exports, require){

/**
 * Module dependencies.
 */

var Runnable = require('./runnable');

/**
 * Expose `Test`.
 */

module.exports = Test;

/**
 * Initialize a new `Test` with the given `title` and callback `fn`.
 *
 * @param {String***REMOVED*** title
 * @param {Function***REMOVED*** fn
 * @api private
 */

function Test(title, fn) {
  Runnable.call(this, title, fn);
  this.pending = !fn;
  this.type = 'test';
***REMOVED***

/**
 * Inherit from `Runnable.prototype`.
 */

function F(){***REMOVED***;
F.prototype = Runnable.prototype;
Test.prototype = new F;
Test.prototype.constructor = Test;


***REMOVED***); // module: test.js

require.register("utils.js", function(module, exports, require){
/**
 * Module dependencies.
 */

var fs = require('browser/fs')
  , path = require('browser/path')
  , join = path.join
  , debug = require('browser/debug')('mocha:watch');

/**
 * Ignored directories.
 */

var ignore = ['node_modules', '.git'];

/**
 * Escape special characters in the given string of html.
 *
 * @param  {String***REMOVED*** html
 * @return {String***REMOVED***
 * @api private
 */

exports.escape = function(html){
  return String(html)
    .replace(/&/g, '&amp;')
    .replace(/"/g, '&quot;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');
***REMOVED***;

/**
 * Array#forEach (<=IE8)
 *
 * @param {Array***REMOVED*** array
 * @param {Function***REMOVED*** fn
 * @param {Object***REMOVED*** scope
 * @api private
 */

exports.forEach = function(arr, fn, scope){
  for (var i = 0, l = arr.length; i < l; i++)
    fn.call(scope, arr[i], i);
***REMOVED***;

/**
 * Array#map (<=IE8)
 *
 * @param {Array***REMOVED*** array
 * @param {Function***REMOVED*** fn
 * @param {Object***REMOVED*** scope
 * @api private
 */

exports.map = function(arr, fn, scope){
  var result = [];
  for (var i = 0, l = arr.length; i < l; i++)
    result.push(fn.call(scope, arr[i], i));
  return result;
***REMOVED***;

/**
 * Array#indexOf (<=IE8)
 *
 * @parma {Array***REMOVED*** arr
 * @param {Object***REMOVED*** obj to find index of
 * @param {Number***REMOVED*** start
 * @api private
 */

exports.indexOf = function(arr, obj, start){
  for (var i = start || 0, l = arr.length; i < l; i++) {
    if (arr[i] === obj)
      return i;
  ***REMOVED***
  return -1;
***REMOVED***;

/**
 * Array#reduce (<=IE8)
 *
 * @param {Array***REMOVED*** array
 * @param {Function***REMOVED*** fn
 * @param {Object***REMOVED*** initial value
 * @api private
 */

exports.reduce = function(arr, fn, val){
  var rval = val;

  for (var i = 0, l = arr.length; i < l; i++) {
    rval = fn(rval, arr[i], i, arr);
  ***REMOVED***

  return rval;
***REMOVED***;

/**
 * Array#filter (<=IE8)
 *
 * @param {Array***REMOVED*** array
 * @param {Function***REMOVED*** fn
 * @api private
 */

exports.filter = function(arr, fn){
  var ret = [];

  for (var i = 0, l = arr.length; i < l; i++) {
    var val = arr[i];
    if (fn(val, i, arr)) ret.push(val);
  ***REMOVED***

  return ret;
***REMOVED***;

/**
 * Object.keys (<=IE8)
 *
 * @param {Object***REMOVED*** obj
 * @return {Array***REMOVED*** keys
 * @api private
 */

exports.keys = Object.keys || function(obj) {
  var keys = []
    , has = Object.prototype.hasOwnProperty // for `window` on <=IE8

  for (var key in obj) {
    if (has.call(obj, key)) {
      keys.push(key);
    ***REMOVED***
  ***REMOVED***

  return keys;
***REMOVED***;

/**
 * Watch the given `files` for changes
 * and invoke `fn(file)` on modification.
 *
 * @param {Array***REMOVED*** files
 * @param {Function***REMOVED*** fn
 * @api private
 */

exports.watch = function(files, fn){
  var options = { interval: 100 ***REMOVED***;
  files.forEach(function(file){
    debug('file %s', file);
    fs.watchFile(file, options, function(curr, prev){
      if (prev.mtime < curr.mtime) fn(file);
    ***REMOVED***);
  ***REMOVED***);
***REMOVED***;

/**
 * Ignored files.
 */

function ignored(path){
  return !~ignore.indexOf(path);
***REMOVED***

/**
 * Lookup files in the given `dir`.
 *
 * @return {Array***REMOVED***
 * @api private
 */

exports.files = function(dir, ret){
  ret = ret || [];

  fs.readdirSync(dir)
  .filter(ignored)
  .forEach(function(path){
    path = join(dir, path);
    if (fs.statSync(path).isDirectory()) {
      exports.files(path, ret);
    ***REMOVED*** else if (path.match(/\.(js|coffee|litcoffee|coffee.md)$/)) {
      ret.push(path);
    ***REMOVED***
  ***REMOVED***);

  return ret;
***REMOVED***;

/**
 * Compute a slug from the given `str`.
 *
 * @param {String***REMOVED*** str
 * @return {String***REMOVED***
 * @api private
 */

exports.slug = function(str){
  return str
    .toLowerCase()
    .replace(/ +/g, '-')
    .replace(/[^-\w]/g, '');
***REMOVED***;

/**
 * Strip the function definition from `str`,
 * and re-indent for pre whitespace.
 */

exports.clean = function(str) {
  str = str
    .replace(/\r\n?|[\n\u2028\u2029]/g, "\n").replace(/^\uFEFF/, '')
    .replace(/^function *\(.*\) *{/, '')
    .replace(/\s+\***REMOVED***$/, '');

  var spaces = str.match(/^\n?( *)/)[1].length
    , tabs = str.match(/^\n?(\t*)/)[1].length
    , re = new RegExp('^\n?' + (tabs ? '\t' : ' ') + '{' + (tabs ? tabs : spaces) + '***REMOVED***', 'gm');

  str = str.replace(re, '');

  return exports.trim(str);
***REMOVED***;

/**
 * Escape regular expression characters in `str`.
 *
 * @param {String***REMOVED*** str
 * @return {String***REMOVED***
 * @api private
 */

exports.escapeRegexp = function(str){
  return str.replace(/[-\\^$*+?.()|[\]{***REMOVED***]/g, "\\$&");
***REMOVED***;

/**
 * Trim the given `str`.
 *
 * @param {String***REMOVED*** str
 * @return {String***REMOVED***
 * @api private
 */

exports.trim = function(str){
  return str.replace(/^\s+|\s+$/g, '');
***REMOVED***;

/**
 * Parse the given `qs`.
 *
 * @param {String***REMOVED*** qs
 * @return {Object***REMOVED***
 * @api private
 */

exports.parseQuery = function(qs){
  return exports.reduce(qs.replace('?', '').split('&'), function(obj, pair){
    var i = pair.indexOf('=')
      , key = pair.slice(0, i)
      , val = pair.slice(++i);

    obj[key] = decodeURIComponent(val);
    return obj;
  ***REMOVED***, {***REMOVED***);
***REMOVED***;

/**
 * Highlight the given string of `js`.
 *
 * @param {String***REMOVED*** js
 * @return {String***REMOVED***
 * @api private
 */

function highlight(js) {
  return js
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/\/\/(.*)/gm, '<span class="comment">//$1</span>')
    .replace(/('.*?')/gm, '<span class="string">$1</span>')
    .replace(/(\d+\.\d+)/gm, '<span class="number">$1</span>')
    .replace(/(\d+)/gm, '<span class="number">$1</span>')
    .replace(/\bnew *(\w+)/gm, '<span class="keyword">new</span> <span class="init">$1</span>')
    .replace(/\b(function|new|throw|return|var|if|else)\b/gm, '<span class="keyword">$1</span>')
***REMOVED***

/**
 * Highlight the contents of tag `name`.
 *
 * @param {String***REMOVED*** name
 * @api private
 */

exports.highlightTags = function(name) {
  var code = document.getElementsByTagName(name);
  for (var i = 0, len = code.length; i < len; ++i) {
    code[i].innerHTML = highlight(code[i].innerHTML);
  ***REMOVED***
***REMOVED***;

***REMOVED***); // module: utils.js
// The global object is "self" in Web Workers.
global = (function() { return this; ***REMOVED***)();

/**
 * Save timer references to avoid Sinon interfering (see GH-237).
 */

var Date = global.Date;
var setTimeout = global.setTimeout;
var setInterval = global.setInterval;
var clearTimeout = global.clearTimeout;
var clearInterval = global.clearInterval;

/**
 * Node shims.
 *
 * These are meant only to allow
 * mocha.js to run untouched, not
 * to allow running node code in
 * the browser.
 */

var process = {***REMOVED***;
process.exit = function(status){***REMOVED***;
process.stdout = {***REMOVED***;

var uncaughtExceptionHandlers = [];

/**
 * Remove uncaughtException listener.
 */

process.removeListener = function(e, fn){
  if ('uncaughtException' == e) {
    global.onerror = function() {***REMOVED***;
    var i = Mocha.utils.indexOf(uncaughtExceptionHandlers, fn);
    if (i != -1) { uncaughtExceptionHandlers.splice(i, 1); ***REMOVED***
  ***REMOVED***
***REMOVED***;

/**
 * Implements uncaughtException listener.
 */

process.on = function(e, fn){
  if ('uncaughtException' == e) {
    global.onerror = function(err, url, line){
      fn(new Error(err + ' (' + url + ':' + line + ')'));
      return true;
    ***REMOVED***;
    uncaughtExceptionHandlers.push(fn);
  ***REMOVED***
***REMOVED***;

/**
 * Expose mocha.
 */

var Mocha = global.Mocha = require('mocha'),
    mocha = global.mocha = new Mocha({ reporter: 'html' ***REMOVED***);

// The BDD UI is registered by default, but no UI will be functional in the
// browser without an explicit call to the overridden `mocha.ui` (see below).
// Ensure that this default UI does not expose its methods to the global scope.
mocha.suite.removeAllListeners('pre-require');

var immediateQueue = []
  , immediateTimeout;

function timeslice() {
  var immediateStart = new Date().getTime();
  while (immediateQueue.length && (new Date().getTime() - immediateStart) < 100) {
    immediateQueue.shift()();
  ***REMOVED***
  if (immediateQueue.length) {
    immediateTimeout = setTimeout(timeslice, 0);
  ***REMOVED*** else {
    immediateTimeout = null;
  ***REMOVED***
***REMOVED***

/**
 * High-performance override of Runner.immediately.
 */

Mocha.Runner.immediately = function(callback) {
  immediateQueue.push(callback);
  if (!immediateTimeout) {
    immediateTimeout = setTimeout(timeslice, 0);
  ***REMOVED***
***REMOVED***;

/**
 * Function to allow assertion libraries to throw errors directly into mocha.
 * This is useful when running tests in a browser because window.onerror will
 * only receive the 'message' attribute of the Error.
 */
mocha.throwError = function(err) {
  Mocha.utils.forEach(uncaughtExceptionHandlers, function (fn) {
    fn(err);
  ***REMOVED***);
  throw err;
***REMOVED***;

/**
 * Override ui to ensure that the ui functions are initialized.
 * Normally this would happen in Mocha.prototype.loadFiles.
 */

mocha.ui = function(ui){
  Mocha.prototype.ui.call(this, ui);
  this.suite.emit('pre-require', global, null, this);
  return this;
***REMOVED***;

/**
 * Setup mocha with the given setting options.
 */

mocha.setup = function(opts){
  if ('string' == typeof opts) opts = { ui: opts ***REMOVED***;
  for (var opt in opts) this[opt](opts[opt]);
  return this;
***REMOVED***;

/**
 * Run mocha, returning the Runner.
 */

mocha.run = function(fn){
  var options = mocha.options;
  mocha.globals('location');

  var query = Mocha.utils.parseQuery(global.location.search || '');
  if (query.grep) mocha.grep(query.grep);
  if (query.invert) mocha.invert();

  return Mocha.prototype.run.call(mocha, function(){
    // The DOM Document is not available in Web Workers.
    if (global.document) {
      Mocha.utils.highlightTags('code');
    ***REMOVED***
    if (fn) fn();
  ***REMOVED***);
***REMOVED***;

/**
 * Expose the process shim.
 */

Mocha.process = process;
***REMOVED***)();