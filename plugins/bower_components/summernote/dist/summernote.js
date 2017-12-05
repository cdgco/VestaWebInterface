/**
 * Super simple wysiwyg editor on Bootstrap v0.6.16
 * http://summernote.org/
 *
 * summernote.js
 * Copyright 2013-2015 Alan Hong. and other contributors
 * summernote may be freely distributed under the MIT license./
 *
 * Date: 2015-08-03T16:41Z
 */
(function (factory) {
  /* global define */
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  ***REMOVED*** else {
    // Browser globals: jQuery
    factory(window.jQuery);
  ***REMOVED***
***REMOVED***(function ($) {
  


  if (!Array.prototype.reduce) {
    /**
     * Array.prototype.reduce polyfill
     *
     * @param {Function***REMOVED*** callback
     * @param {Value***REMOVED*** [initialValue]
     * @return {Value***REMOVED***
     *
     * @see http://goo.gl/WNriQD
     */
    Array.prototype.reduce = function (callback) {
      var t = Object(this), len = t.length >>> 0, k = 0, value;
      if (arguments.length === 2) {
        value = arguments[1];
      ***REMOVED*** else {
        while (k < len && !(k in t)) {
          k++;
        ***REMOVED***
        if (k >= len) {
          throw new TypeError('Reduce of empty array with no initial value');
        ***REMOVED***
        value = t[k++];
      ***REMOVED***
      for (; k < len; k++) {
        if (k in t) {
          value = callback(value, t[k], k, t);
        ***REMOVED***
      ***REMOVED***
      return value;
    ***REMOVED***;
  ***REMOVED***

  if ('function' !== typeof Array.prototype.filter) {
    /**
     * Array.prototype.filter polyfill
     *
     * @param {Function***REMOVED*** func
     * @return {Array***REMOVED***
     *
     * @see http://goo.gl/T1KFnq
     */
    Array.prototype.filter = function (func) {
      var t = Object(this), len = t.length >>> 0;

      var res = [];
      var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
      for (var i = 0; i < len; i++) {
        if (i in t) {
          var val = t[i];
          if (func.call(thisArg, val, i, t)) {
            res.push(val);
          ***REMOVED***
        ***REMOVED***
      ***REMOVED***
  
      return res;
    ***REMOVED***;
  ***REMOVED***

  if (!Array.prototype.map) {
    /**
     * Array.prototype.map polyfill
     *
     * @param {Function***REMOVED*** callback
     * @return {Array***REMOVED***
     *
     * @see https://goo.gl/SMWaMK
     */
    Array.prototype.map = function (callback, thisArg) {
      var T, A, k;
      if (this === null) {
        throw new TypeError(' this is null or not defined');
      ***REMOVED***

      var O = Object(this);
      var len = O.length >>> 0;
      if (typeof callback !== 'function') {
        throw new TypeError(callback + ' is not a function');
      ***REMOVED***
  
      if (arguments.length > 1) {
        T = thisArg;
      ***REMOVED***
  
      A = new Array(len);
      k = 0;
  
      while (k < len) {
        var kValue, mappedValue;
        if (k in O) {
          kValue = O[k];
          mappedValue = callback.call(T, kValue, k, O);
          A[k] = mappedValue;
        ***REMOVED***
        k++;
      ***REMOVED***
      return A;
    ***REMOVED***;
  ***REMOVED***

  var isSupportAmd = typeof define === 'function' && define.amd;

  /**
   * returns whether font is installed or not.
   *
   * @param {String***REMOVED*** fontName
   * @return {Boolean***REMOVED***
   */
  var isFontInstalled = function (fontName) {
    var testFontName = fontName === 'Comic Sans MS' ? 'Courier New' : 'Comic Sans MS';
    var $tester = $('<div>').css({
      position: 'absolute',
      left: '-9999px',
      top: '-9999px',
      fontSize: '200px'
    ***REMOVED***).text('mmmmmmmmmwwwwwww').appendTo(document.body);

    var originalWidth = $tester.css('fontFamily', testFontName).width();
    var width = $tester.css('fontFamily', fontName + ',' + testFontName).width();

    $tester.remove();

    return originalWidth !== width;
  ***REMOVED***;

  var userAgent = navigator.userAgent;
  var isMSIE = /MSIE|Trident/i.test(userAgent);
  var browserVersion;
  if (isMSIE) {
    var matches = /MSIE (\d+[.]\d+)/.exec(userAgent);
    if (matches) {
      browserVersion = parseFloat(matches[1]);
    ***REMOVED***
    matches = /Trident\/.*rv:([0-9]{1,***REMOVED***[\.0-9]{0,***REMOVED***)/.exec(userAgent);
    if (matches) {
      browserVersion = parseFloat(matches[1]);
    ***REMOVED***
  ***REMOVED***

  /**
   * @class core.agent
   *
   * Object which check platform and agent
   *
   * @singleton
   * @alternateClassName agent
   */
  var agent = {
    /** @property {Boolean***REMOVED*** [isMac=false] true if this agent is Mac  */
    isMac: navigator.appVersion.indexOf('Mac') > -1,
    /** @property {Boolean***REMOVED*** [isMSIE=false] true if this agent is a Internet Explorer  */
    isMSIE: isMSIE,
    /** @property {Boolean***REMOVED*** [isFF=false] true if this agent is a Firefox  */
    isFF: /firefox/i.test(userAgent),
    isWebkit: /webkit/i.test(userAgent),
    /** @property {Boolean***REMOVED*** [isSafari=false] true if this agent is a Safari  */
    isSafari: /safari/i.test(userAgent),
    /** @property {Float***REMOVED*** browserVersion current browser version  */
    browserVersion: browserVersion,
    /** @property {String***REMOVED*** jqueryVersion current jQuery version string  */
    jqueryVersion: parseFloat($.fn.jquery),
    isSupportAmd: isSupportAmd,
    hasCodeMirror: isSupportAmd ? require.specified('CodeMirror') : !!window.CodeMirror,
    isFontInstalled: isFontInstalled,
    isW3CRangeSupport: !!document.createRange
  ***REMOVED***;

  /**
   * @class core.func
   *
   * func utils (for high-order func's arg)
   *
   * @singleton
   * @alternateClassName func
   */
  var func = (function () {
    var eq = function (itemA) {
      return function (itemB) {
        return itemA === itemB;
      ***REMOVED***;
    ***REMOVED***;

    var eq2 = function (itemA, itemB) {
      return itemA === itemB;
    ***REMOVED***;

    var peq2 = function (propName) {
      return function (itemA, itemB) {
        return itemA[propName] === itemB[propName];
      ***REMOVED***;
    ***REMOVED***;

    var ok = function () {
      return true;
    ***REMOVED***;

    var fail = function () {
      return false;
    ***REMOVED***;

    var not = function (f) {
      return function () {
        return !f.apply(f, arguments);
      ***REMOVED***;
    ***REMOVED***;

    var and = function (fA, fB) {
      return function (item) {
        return fA(item) && fB(item);
      ***REMOVED***;
    ***REMOVED***;

    var self = function (a) {
      return a;
    ***REMOVED***;

    var idCounter = 0;

    /**
     * generate a globally-unique id
     *
     * @param {String***REMOVED*** [prefix]
     */
    var uniqueId = function (prefix) {
      var id = ++idCounter + '';
      return prefix ? prefix + id : id;
    ***REMOVED***;

    /**
     * returns bnd (bounds) from rect
     *
     * - IE Compatability Issue: http://goo.gl/sRLOAo
     * - Scroll Issue: http://goo.gl/sNjUc
     *
     * @param {Rect***REMOVED*** rect
     * @return {Object***REMOVED*** bounds
     * @return {Number***REMOVED*** bounds.top
     * @return {Number***REMOVED*** bounds.left
     * @return {Number***REMOVED*** bounds.width
     * @return {Number***REMOVED*** bounds.height
     */
    var rect2bnd = function (rect) {
      var $document = $(document);
      return {
        top: rect.top + $document.scrollTop(),
        left: rect.left + $document.scrollLeft(),
        width: rect.right - rect.left,
        height: rect.bottom - rect.top
      ***REMOVED***;
    ***REMOVED***;

    /**
     * returns a copy of the object where the keys have become the values and the values the keys.
     * @param {Object***REMOVED*** obj
     * @return {Object***REMOVED***
     */
    var invertObject = function (obj) {
      var inverted = {***REMOVED***;
      for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
          inverted[obj[key]] = key;
        ***REMOVED***
      ***REMOVED***
      return inverted;
    ***REMOVED***;

    /**
     * @param {String***REMOVED*** namespace
     * @param {String***REMOVED*** [prefix]
     * @return {String***REMOVED***
     */
    var namespaceToCamel = function (namespace, prefix) {
      prefix = prefix || '';
      return prefix + namespace.split('.').map(function (name) {
        return name.substring(0, 1).toUpperCase() + name.substring(1);
      ***REMOVED***).join('');
    ***REMOVED***;

    return {
      eq: eq,
      eq2: eq2,
      peq2: peq2,
      ok: ok,
      fail: fail,
      self: self,
      not: not,
      and: and,
      uniqueId: uniqueId,
      rect2bnd: rect2bnd,
      invertObject: invertObject,
      namespaceToCamel: namespaceToCamel
    ***REMOVED***;
  ***REMOVED***)();

  /**
   * @class core.list
   *
   * list utils
   *
   * @singleton
   * @alternateClassName list
   */
  var list = (function () {
    /**
     * returns the first item of an array.
     *
     * @param {Array***REMOVED*** array
     */
    var head = function (array) {
      return array[0];
    ***REMOVED***;

    /**
     * returns the last item of an array.
     *
     * @param {Array***REMOVED*** array
     */
    var last = function (array) {
      return array[array.length - 1];
    ***REMOVED***;

    /**
     * returns everything but the last entry of the array.
     *
     * @param {Array***REMOVED*** array
     */
    var initial = function (array) {
      return array.slice(0, array.length - 1);
    ***REMOVED***;

    /**
     * returns the rest of the items in an array.
     *
     * @param {Array***REMOVED*** array
     */
    var tail = function (array) {
      return array.slice(1);
    ***REMOVED***;

    /**
     * returns item of array
     */
    var find = function (array, pred) {
      for (var idx = 0, len = array.length; idx < len; idx ++) {
        var item = array[idx];
        if (pred(item)) {
          return item;
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***;

    /**
     * returns true if all of the values in the array pass the predicate truth test.
     */
    var all = function (array, pred) {
      for (var idx = 0, len = array.length; idx < len; idx ++) {
        if (!pred(array[idx])) {
          return false;
        ***REMOVED***
      ***REMOVED***
      return true;
    ***REMOVED***;

    /**
     * returns index of item
     */
    var indexOf = function (array, item) {
      return $.inArray(item, array);
    ***REMOVED***;

    /**
     * returns true if the value is present in the list.
     */
    var contains = function (array, item) {
      return indexOf(array, item) !== -1;
    ***REMOVED***;

    /**
     * get sum from a list
     *
     * @param {Array***REMOVED*** array - array
     * @param {Function***REMOVED*** fn - iterator
     */
    var sum = function (array, fn) {
      fn = fn || func.self;
      return array.reduce(function (memo, v) {
        return memo + fn(v);
      ***REMOVED***, 0);
    ***REMOVED***;
  
    /**
     * returns a copy of the collection with array type.
     * @param {Collection***REMOVED*** collection - collection eg) node.childNodes, ...
     */
    var from = function (collection) {
      var result = [], idx = -1, length = collection.length;
      while (++idx < length) {
        result[idx] = collection[idx];
      ***REMOVED***
      return result;
    ***REMOVED***;
  
    /**
     * cluster elements by predicate function.
     *
     * @param {Array***REMOVED*** array - array
     * @param {Function***REMOVED*** fn - predicate function for cluster rule
     * @param {Array[]***REMOVED***
     */
    var clusterBy = function (array, fn) {
      if (!array.length) { return []; ***REMOVED***
      var aTail = tail(array);
      return aTail.reduce(function (memo, v) {
        var aLast = last(memo);
        if (fn(last(aLast), v)) {
          aLast[aLast.length] = v;
        ***REMOVED*** else {
          memo[memo.length] = [v];
        ***REMOVED***
        return memo;
      ***REMOVED***, [[head(array)]]);
    ***REMOVED***;
  
    /**
     * returns a copy of the array with all falsy values removed
     *
     * @param {Array***REMOVED*** array - array
     * @param {Function***REMOVED*** fn - predicate function for cluster rule
     */
    var compact = function (array) {
      var aResult = [];
      for (var idx = 0, len = array.length; idx < len; idx ++) {
        if (array[idx]) { aResult.push(array[idx]); ***REMOVED***
      ***REMOVED***
      return aResult;
    ***REMOVED***;

    /**
     * produces a duplicate-free version of the array
     *
     * @param {Array***REMOVED*** array
     */
    var unique = function (array) {
      var results = [];

      for (var idx = 0, len = array.length; idx < len; idx ++) {
        if (!contains(results, array[idx])) {
          results.push(array[idx]);
        ***REMOVED***
      ***REMOVED***

      return results;
    ***REMOVED***;

    /**
     * returns next item.
     * @param {Array***REMOVED*** array
     */
    var next = function (array, item) {
      var idx = indexOf(array, item);
      if (idx === -1) { return null; ***REMOVED***

      return array[idx + 1];
    ***REMOVED***;

    /**
     * returns prev item.
     * @param {Array***REMOVED*** array
     */
    var prev = function (array, item) {
      var idx = indexOf(array, item);
      if (idx === -1) { return null; ***REMOVED***

      return array[idx - 1];
    ***REMOVED***;
  
    return { head: head, last: last, initial: initial, tail: tail,
             prev: prev, next: next, find: find, contains: contains,
             all: all, sum: sum, from: from,
             clusterBy: clusterBy, compact: compact, unique: unique ***REMOVED***;
  ***REMOVED***)();


  var NBSP_CHAR = String.fromCharCode(160);
  var ZERO_WIDTH_NBSP_CHAR = '\ufeff';

  /**
   * @class core.dom
   *
   * Dom functions
   *
   * @singleton
   * @alternateClassName dom
   */
  var dom = (function () {
    /**
     * @method isEditable
     *
     * returns whether node is `note-editable` or not.
     *
     * @param {Node***REMOVED*** node
     * @return {Boolean***REMOVED***
     */
    var isEditable = function (node) {
      return node && $(node).hasClass('note-editable');
    ***REMOVED***;

    /**
     * @method isControlSizing
     *
     * returns whether node is `note-control-sizing` or not.
     *
     * @param {Node***REMOVED*** node
     * @return {Boolean***REMOVED***
     */
    var isControlSizing = function (node) {
      return node && $(node).hasClass('note-control-sizing');
    ***REMOVED***;

    /**
     * @method  buildLayoutInfo
     *
     * build layoutInfo from $editor(.note-editor)
     *
     * @param {jQuery***REMOVED*** $editor
     * @return {Object***REMOVED***
     * @return {Function***REMOVED*** return.editor
     * @return {Node***REMOVED*** return.dropzone
     * @return {Node***REMOVED*** return.toolbar
     * @return {Node***REMOVED*** return.editable
     * @return {Node***REMOVED*** return.codable
     * @return {Node***REMOVED*** return.popover
     * @return {Node***REMOVED*** return.handle
     * @return {Node***REMOVED*** return.dialog
     */
    var buildLayoutInfo = function ($editor) {
      var makeFinder;

      // air mode
      if ($editor.hasClass('note-air-editor')) {
        var id = list.last($editor.attr('id').split('-'));
        makeFinder = function (sIdPrefix) {
          return function () { return $(sIdPrefix + id); ***REMOVED***;
        ***REMOVED***;

        return {
          editor: function () { return $editor; ***REMOVED***,
          holder : function () { return $editor.data('holder'); ***REMOVED***,
          editable: function () { return $editor; ***REMOVED***,
          popover: makeFinder('#note-popover-'),
          handle: makeFinder('#note-handle-'),
          dialog: makeFinder('#note-dialog-')
        ***REMOVED***;

        // frame mode
      ***REMOVED*** else {
        makeFinder = function (className, $base) {
          $base = $base || $editor;
          return function () { return $base.find(className); ***REMOVED***;
        ***REMOVED***;

        var options = $editor.data('options');
        var $dialogHolder = (options && options.dialogsInBody) ? $(document.body) : null;

        return {
          editor: function () { return $editor; ***REMOVED***,
          holder : function () { return $editor.data('holder'); ***REMOVED***,
          dropzone: makeFinder('.note-dropzone'),
          toolbar: makeFinder('.note-toolbar'),
          editable: makeFinder('.note-editable'),
          codable: makeFinder('.note-codable'),
          statusbar: makeFinder('.note-statusbar'),
          popover: makeFinder('.note-popover'),
          handle: makeFinder('.note-handle'),
          dialog: makeFinder('.note-dialog', $dialogHolder)
        ***REMOVED***;
      ***REMOVED***
    ***REMOVED***;

    /**
     * returns makeLayoutInfo from editor's descendant node.
     *
     * @private
     * @param {Node***REMOVED*** descendant
     * @return {Object***REMOVED***
     */
    var makeLayoutInfo = function (descendant) {
      var $target = $(descendant).closest('.note-editor, .note-air-editor, .note-air-layout');

      if (!$target.length) {
        return null;
      ***REMOVED***

      var $editor;
      if ($target.is('.note-editor, .note-air-editor')) {
        $editor = $target;
      ***REMOVED*** else {
        $editor = $('#note-editor-' + list.last($target.attr('id').split('-')));
      ***REMOVED***

      return buildLayoutInfo($editor);
    ***REMOVED***;

    /**
     * @method makePredByNodeName
     *
     * returns predicate which judge whether nodeName is same
     *
     * @param {String***REMOVED*** nodeName
     * @return {Function***REMOVED***
     */
    var makePredByNodeName = function (nodeName) {
      nodeName = nodeName.toUpperCase();
      return function (node) {
        return node && node.nodeName.toUpperCase() === nodeName;
      ***REMOVED***;
    ***REMOVED***;

    /**
     * @method isText
     *
     *
     *
     * @param {Node***REMOVED*** node
     * @return {Boolean***REMOVED*** true if node's type is text(3)
     */
    var isText = function (node) {
      return node && node.nodeType === 3;
    ***REMOVED***;

    /**
     * ex) br, col, embed, hr, img, input, ...
     * @see http://www.w3.org/html/wg/drafts/html/master/syntax.html#void-elements
     */
    var isVoid = function (node) {
      return node && /^BR|^IMG|^HR|^IFRAME|^BUTTON/.test(node.nodeName.toUpperCase());
    ***REMOVED***;

    var isPara = function (node) {
      if (isEditable(node)) {
        return false;
      ***REMOVED***

      // Chrome(v31.0), FF(v25.0.1) use DIV for paragraph
      return node && /^DIV|^P|^LI|^H[1-7]/.test(node.nodeName.toUpperCase());
    ***REMOVED***;

    var isLi = makePredByNodeName('LI');

    var isPurePara = function (node) {
      return isPara(node) && !isLi(node);
    ***REMOVED***;

    var isTable = makePredByNodeName('TABLE');

    var isInline = function (node) {
      return !isBodyContainer(node) &&
             !isList(node) &&
             !isHr(node) &&
             !isPara(node) &&
             !isTable(node) &&
             !isBlockquote(node);
    ***REMOVED***;

    var isList = function (node) {
      return node && /^UL|^OL/.test(node.nodeName.toUpperCase());
    ***REMOVED***;

    var isHr = makePredByNodeName('HR');

    var isCell = function (node) {
      return node && /^TD|^TH/.test(node.nodeName.toUpperCase());
    ***REMOVED***;

    var isBlockquote = makePredByNodeName('BLOCKQUOTE');

    var isBodyContainer = function (node) {
      return isCell(node) || isBlockquote(node) || isEditable(node);
    ***REMOVED***;

    var isAnchor = makePredByNodeName('A');

    var isParaInline = function (node) {
      return isInline(node) && !!ancestor(node, isPara);
    ***REMOVED***;

    var isBodyInline = function (node) {
      return isInline(node) && !ancestor(node, isPara);
    ***REMOVED***;

    var isBody = makePredByNodeName('BODY');

    /**
     * returns whether nodeB is closest sibling of nodeA
     *
     * @param {Node***REMOVED*** nodeA
     * @param {Node***REMOVED*** nodeB
     * @return {Boolean***REMOVED***
     */
    var isClosestSibling = function (nodeA, nodeB) {
      return nodeA.nextSibling === nodeB ||
             nodeA.previousSibling === nodeB;
    ***REMOVED***;

    /**
     * returns array of closest siblings with node
     *
     * @param {Node***REMOVED*** node
     * @param {function***REMOVED*** [pred] - predicate function
     * @return {Node[]***REMOVED***
     */
    var withClosestSiblings = function (node, pred) {
      pred = pred || func.ok;

      var siblings = [];
      if (node.previousSibling && pred(node.previousSibling)) {
        siblings.push(node.previousSibling);
      ***REMOVED***
      siblings.push(node);
      if (node.nextSibling && pred(node.nextSibling)) {
        siblings.push(node.nextSibling);
      ***REMOVED***
      return siblings;
    ***REMOVED***;

    /**
     * blank HTML for cursor position
     * - [workaround] old IE only works with &nbsp;
     * - [workaround] IE11 and other browser works with bogus br
     */
    var blankHTML = agent.isMSIE && agent.browserVersion < 11 ? '&nbsp;' : '<br>';

    /**
     * @method nodeLength
     *
     * returns #text's text size or element's childNodes size
     *
     * @param {Node***REMOVED*** node
     */
    var nodeLength = function (node) {
      if (isText(node)) {
        return node.nodeValue.length;
      ***REMOVED***

      return node.childNodes.length;
    ***REMOVED***;

    /**
     * returns whether node is empty or not.
     *
     * @param {Node***REMOVED*** node
     * @return {Boolean***REMOVED***
     */
    var isEmpty = function (node) {
      var len = nodeLength(node);

      if (len === 0) {
        return true;
      ***REMOVED*** else if (!isText(node) && len === 1 && node.innerHTML === blankHTML) {
        // ex) <p><br></p>, <span><br></span>
        return true;
      ***REMOVED*** else if (list.all(node.childNodes, isText) && node.innerHTML === '') {
        // ex) <p></p>, <span></span>
        return true;
      ***REMOVED***

      return false;
    ***REMOVED***;

    /**
     * padding blankHTML if node is empty (for cursor position)
     */
    var paddingBlankHTML = function (node) {
      if (!isVoid(node) && !nodeLength(node)) {
        node.innerHTML = blankHTML;
      ***REMOVED***
    ***REMOVED***;

    /**
     * find nearest ancestor predicate hit
     *
     * @param {Node***REMOVED*** node
     * @param {Function***REMOVED*** pred - predicate function
     */
    var ancestor = function (node, pred) {
      while (node) {
        if (pred(node)) { return node; ***REMOVED***
        if (isEditable(node)) { break; ***REMOVED***

        node = node.parentNode;
      ***REMOVED***
      return null;
    ***REMOVED***;

    /**
     * find nearest ancestor only single child blood line and predicate hit
     *
     * @param {Node***REMOVED*** node
     * @param {Function***REMOVED*** pred - predicate function
     */
    var singleChildAncestor = function (node, pred) {
      node = node.parentNode;

      while (node) {
        if (nodeLength(node) !== 1) { break; ***REMOVED***
        if (pred(node)) { return node; ***REMOVED***
        if (isEditable(node)) { break; ***REMOVED***

        node = node.parentNode;
      ***REMOVED***
      return null;
    ***REMOVED***;

    /**
     * returns new array of ancestor nodes (until predicate hit).
     *
     * @param {Node***REMOVED*** node
     * @param {Function***REMOVED*** [optional] pred - predicate function
     */
    var listAncestor = function (node, pred) {
      pred = pred || func.fail;

      var ancestors = [];
      ancestor(node, function (el) {
        if (!isEditable(el)) {
          ancestors.push(el);
        ***REMOVED***

        return pred(el);
      ***REMOVED***);
      return ancestors;
    ***REMOVED***;

    /**
     * find farthest ancestor predicate hit
     */
    var lastAncestor = function (node, pred) {
      var ancestors = listAncestor(node);
      return list.last(ancestors.filter(pred));
    ***REMOVED***;

    /**
     * returns common ancestor node between two nodes.
     *
     * @param {Node***REMOVED*** nodeA
     * @param {Node***REMOVED*** nodeB
     */
    var commonAncestor = function (nodeA, nodeB) {
      var ancestors = listAncestor(nodeA);
      for (var n = nodeB; n; n = n.parentNode) {
        if ($.inArray(n, ancestors) > -1) { return n; ***REMOVED***
      ***REMOVED***
      return null; // difference document area
    ***REMOVED***;

    /**
     * listing all previous siblings (until predicate hit).
     *
     * @param {Node***REMOVED*** node
     * @param {Function***REMOVED*** [optional] pred - predicate function
     */
    var listPrev = function (node, pred) {
      pred = pred || func.fail;

      var nodes = [];
      while (node) {
        if (pred(node)) { break; ***REMOVED***
        nodes.push(node);
        node = node.previousSibling;
      ***REMOVED***
      return nodes;
    ***REMOVED***;

    /**
     * listing next siblings (until predicate hit).
     *
     * @param {Node***REMOVED*** node
     * @param {Function***REMOVED*** [pred] - predicate function
     */
    var listNext = function (node, pred) {
      pred = pred || func.fail;

      var nodes = [];
      while (node) {
        if (pred(node)) { break; ***REMOVED***
        nodes.push(node);
        node = node.nextSibling;
      ***REMOVED***
      return nodes;
    ***REMOVED***;

    /**
     * listing descendant nodes
     *
     * @param {Node***REMOVED*** node
     * @param {Function***REMOVED*** [pred] - predicate function
     */
    var listDescendant = function (node, pred) {
      var descendents = [];
      pred = pred || func.ok;

      // start DFS(depth first search) with node
      (function fnWalk(current) {
        if (node !== current && pred(current)) {
          descendents.push(current);
        ***REMOVED***
        for (var idx = 0, len = current.childNodes.length; idx < len; idx++) {
          fnWalk(current.childNodes[idx]);
        ***REMOVED***
      ***REMOVED***)(node);

      return descendents;
    ***REMOVED***;

    /**
     * wrap node with new tag.
     *
     * @param {Node***REMOVED*** node
     * @param {Node***REMOVED*** tagName of wrapper
     * @return {Node***REMOVED*** - wrapper
     */
    var wrap = function (node, wrapperName) {
      var parent = node.parentNode;
      var wrapper = $('<' + wrapperName + '>')[0];

      parent.insertBefore(wrapper, node);
      wrapper.appendChild(node);

      return wrapper;
    ***REMOVED***;

    /**
     * insert node after preceding
     *
     * @param {Node***REMOVED*** node
     * @param {Node***REMOVED*** preceding - predicate function
     */
    var insertAfter = function (node, preceding) {
      var next = preceding.nextSibling, parent = preceding.parentNode;
      if (next) {
        parent.insertBefore(node, next);
      ***REMOVED*** else {
        parent.appendChild(node);
      ***REMOVED***
      return node;
    ***REMOVED***;

    /**
     * append elements.
     *
     * @param {Node***REMOVED*** node
     * @param {Collection***REMOVED*** aChild
     */
    var appendChildNodes = function (node, aChild) {
      $.each(aChild, function (idx, child) {
        node.appendChild(child);
      ***REMOVED***);
      return node;
    ***REMOVED***;

    /**
     * returns whether boundaryPoint is left edge or not.
     *
     * @param {BoundaryPoint***REMOVED*** point
     * @return {Boolean***REMOVED***
     */
    var isLeftEdgePoint = function (point) {
      return point.offset === 0;
    ***REMOVED***;

    /**
     * returns whether boundaryPoint is right edge or not.
     *
     * @param {BoundaryPoint***REMOVED*** point
     * @return {Boolean***REMOVED***
     */
    var isRightEdgePoint = function (point) {
      return point.offset === nodeLength(point.node);
    ***REMOVED***;

    /**
     * returns whether boundaryPoint is edge or not.
     *
     * @param {BoundaryPoint***REMOVED*** point
     * @return {Boolean***REMOVED***
     */
    var isEdgePoint = function (point) {
      return isLeftEdgePoint(point) || isRightEdgePoint(point);
    ***REMOVED***;

    /**
     * returns wheter node is left edge of ancestor or not.
     *
     * @param {Node***REMOVED*** node
     * @param {Node***REMOVED*** ancestor
     * @return {Boolean***REMOVED***
     */
    var isLeftEdgeOf = function (node, ancestor) {
      while (node && node !== ancestor) {
        if (position(node) !== 0) {
          return false;
        ***REMOVED***
        node = node.parentNode;
      ***REMOVED***

      return true;
    ***REMOVED***;

    /**
     * returns whether node is right edge of ancestor or not.
     *
     * @param {Node***REMOVED*** node
     * @param {Node***REMOVED*** ancestor
     * @return {Boolean***REMOVED***
     */
    var isRightEdgeOf = function (node, ancestor) {
      while (node && node !== ancestor) {
        if (position(node) !== nodeLength(node.parentNode) - 1) {
          return false;
        ***REMOVED***
        node = node.parentNode;
      ***REMOVED***

      return true;
    ***REMOVED***;

    /**
     * returns whether point is left edge of ancestor or not.
     * @param {BoundaryPoint***REMOVED*** point
     * @param {Node***REMOVED*** ancestor
     * @return {Boolean***REMOVED***
     */
    var isLeftEdgePointOf = function (point, ancestor) {
      return isLeftEdgePoint(point) && isLeftEdgeOf(point.node, ancestor);
    ***REMOVED***;

    /**
     * returns whether point is right edge of ancestor or not.
     * @param {BoundaryPoint***REMOVED*** point
     * @param {Node***REMOVED*** ancestor
     * @return {Boolean***REMOVED***
     */
    var isRightEdgePointOf = function (point, ancestor) {
      return isRightEdgePoint(point) && isRightEdgeOf(point.node, ancestor);
    ***REMOVED***;

    /**
     * returns offset from parent.
     *
     * @param {Node***REMOVED*** node
     */
    var position = function (node) {
      var offset = 0;
      while ((node = node.previousSibling)) {
        offset += 1;
      ***REMOVED***
      return offset;
    ***REMOVED***;

    var hasChildren = function (node) {
      return !!(node && node.childNodes && node.childNodes.length);
    ***REMOVED***;

    /**
     * returns previous boundaryPoint
     *
     * @param {BoundaryPoint***REMOVED*** point
     * @param {Boolean***REMOVED*** isSkipInnerOffset
     * @return {BoundaryPoint***REMOVED***
     */
    var prevPoint = function (point, isSkipInnerOffset) {
      var node, offset;

      if (point.offset === 0) {
        if (isEditable(point.node)) {
          return null;
        ***REMOVED***

        node = point.node.parentNode;
        offset = position(point.node);
      ***REMOVED*** else if (hasChildren(point.node)) {
        node = point.node.childNodes[point.offset - 1];
        offset = nodeLength(node);
      ***REMOVED*** else {
        node = point.node;
        offset = isSkipInnerOffset ? 0 : point.offset - 1;
      ***REMOVED***

      return {
        node: node,
        offset: offset
      ***REMOVED***;
    ***REMOVED***;

    /**
     * returns next boundaryPoint
     *
     * @param {BoundaryPoint***REMOVED*** point
     * @param {Boolean***REMOVED*** isSkipInnerOffset
     * @return {BoundaryPoint***REMOVED***
     */
    var nextPoint = function (point, isSkipInnerOffset) {
      var node, offset;

      if (nodeLength(point.node) === point.offset) {
        if (isEditable(point.node)) {
          return null;
        ***REMOVED***

        node = point.node.parentNode;
        offset = position(point.node) + 1;
      ***REMOVED*** else if (hasChildren(point.node)) {
        node = point.node.childNodes[point.offset];
        offset = 0;
      ***REMOVED*** else {
        node = point.node;
        offset = isSkipInnerOffset ? nodeLength(point.node) : point.offset + 1;
      ***REMOVED***

      return {
        node: node,
        offset: offset
      ***REMOVED***;
    ***REMOVED***;

    /**
     * returns whether pointA and pointB is same or not.
     *
     * @param {BoundaryPoint***REMOVED*** pointA
     * @param {BoundaryPoint***REMOVED*** pointB
     * @return {Boolean***REMOVED***
     */
    var isSamePoint = function (pointA, pointB) {
      return pointA.node === pointB.node && pointA.offset === pointB.offset;
    ***REMOVED***;

    /**
     * returns whether point is visible (can set cursor) or not.
     * 
     * @param {BoundaryPoint***REMOVED*** point
     * @return {Boolean***REMOVED***
     */
    var isVisiblePoint = function (point) {
      if (isText(point.node) || !hasChildren(point.node) || isEmpty(point.node)) {
        return true;
      ***REMOVED***

      var leftNode = point.node.childNodes[point.offset - 1];
      var rightNode = point.node.childNodes[point.offset];
      if ((!leftNode || isVoid(leftNode)) && (!rightNode || isVoid(rightNode))) {
        return true;
      ***REMOVED***

      return false;
    ***REMOVED***;

    /**
     * @method prevPointUtil
     *
     * @param {BoundaryPoint***REMOVED*** point
     * @param {Function***REMOVED*** pred
     * @return {BoundaryPoint***REMOVED***
     */
    var prevPointUntil = function (point, pred) {
      while (point) {
        if (pred(point)) {
          return point;
        ***REMOVED***

        point = prevPoint(point);
      ***REMOVED***

      return null;
    ***REMOVED***;

    /**
     * @method nextPointUntil
     *
     * @param {BoundaryPoint***REMOVED*** point
     * @param {Function***REMOVED*** pred
     * @return {BoundaryPoint***REMOVED***
     */
    var nextPointUntil = function (point, pred) {
      while (point) {
        if (pred(point)) {
          return point;
        ***REMOVED***

        point = nextPoint(point);
      ***REMOVED***

      return null;
    ***REMOVED***;

    /**
     * returns whether point has character or not.
     *
     * @param {Point***REMOVED*** point
     * @return {Boolean***REMOVED***
     */
    var isCharPoint = function (point) {
      if (!isText(point.node)) {
        return false;
      ***REMOVED***

      var ch = point.node.nodeValue.charAt(point.offset - 1);
      return ch && (ch !== ' ' && ch !== NBSP_CHAR);
    ***REMOVED***;

    /**
     * @method walkPoint
     *
     * @param {BoundaryPoint***REMOVED*** startPoint
     * @param {BoundaryPoint***REMOVED*** endPoint
     * @param {Function***REMOVED*** handler
     * @param {Boolean***REMOVED*** isSkipInnerOffset
     */
    var walkPoint = function (startPoint, endPoint, handler, isSkipInnerOffset) {
      var point = startPoint;

      while (point) {
        handler(point);

        if (isSamePoint(point, endPoint)) {
          break;
        ***REMOVED***

        var isSkipOffset = isSkipInnerOffset &&
                           startPoint.node !== point.node &&
                           endPoint.node !== point.node;
        point = nextPoint(point, isSkipOffset);
      ***REMOVED***
    ***REMOVED***;

    /**
     * @method makeOffsetPath
     *
     * return offsetPath(array of offset) from ancestor
     *
     * @param {Node***REMOVED*** ancestor - ancestor node
     * @param {Node***REMOVED*** node
     */
    var makeOffsetPath = function (ancestor, node) {
      var ancestors = listAncestor(node, func.eq(ancestor));
      return ancestors.map(position).reverse();
    ***REMOVED***;

    /**
     * @method fromOffsetPath
     *
     * return element from offsetPath(array of offset)
     *
     * @param {Node***REMOVED*** ancestor - ancestor node
     * @param {array***REMOVED*** offsets - offsetPath
     */
    var fromOffsetPath = function (ancestor, offsets) {
      var current = ancestor;
      for (var i = 0, len = offsets.length; i < len; i++) {
        if (current.childNodes.length <= offsets[i]) {
          current = current.childNodes[current.childNodes.length - 1];
        ***REMOVED*** else {
          current = current.childNodes[offsets[i]];
        ***REMOVED***
      ***REMOVED***
      return current;
    ***REMOVED***;

    /**
     * @method splitNode
     *
     * split element or #text
     *
     * @param {BoundaryPoint***REMOVED*** point
     * @param {Object***REMOVED*** [options]
     * @param {Boolean***REMOVED*** [options.isSkipPaddingBlankHTML] - default: false
     * @param {Boolean***REMOVED*** [options.isNotSplitEdgePoint] - default: false
     * @return {Node***REMOVED*** right node of boundaryPoint
     */
    var splitNode = function (point, options) {
      var isSkipPaddingBlankHTML = options && options.isSkipPaddingBlankHTML;
      var isNotSplitEdgePoint = options && options.isNotSplitEdgePoint;

      // edge case
      if (isEdgePoint(point) && (isText(point.node) || isNotSplitEdgePoint)) {
        if (isLeftEdgePoint(point)) {
          return point.node;
        ***REMOVED*** else if (isRightEdgePoint(point)) {
          return point.node.nextSibling;
        ***REMOVED***
      ***REMOVED***

      // split #text
      if (isText(point.node)) {
        return point.node.splitText(point.offset);
      ***REMOVED*** else {
        var childNode = point.node.childNodes[point.offset];
        var clone = insertAfter(point.node.cloneNode(false), point.node);
        appendChildNodes(clone, listNext(childNode));

        if (!isSkipPaddingBlankHTML) {
          paddingBlankHTML(point.node);
          paddingBlankHTML(clone);
        ***REMOVED***

        return clone;
      ***REMOVED***
    ***REMOVED***;

    /**
     * @method splitTree
     *
     * split tree by point
     *
     * @param {Node***REMOVED*** root - split root
     * @param {BoundaryPoint***REMOVED*** point
     * @param {Object***REMOVED*** [options]
     * @param {Boolean***REMOVED*** [options.isSkipPaddingBlankHTML] - default: false
     * @param {Boolean***REMOVED*** [options.isNotSplitEdgePoint] - default: false
     * @return {Node***REMOVED*** right node of boundaryPoint
     */
    var splitTree = function (root, point, options) {
      // ex) [#text, <span>, <p>]
      var ancestors = listAncestor(point.node, func.eq(root));

      if (!ancestors.length) {
        return null;
      ***REMOVED*** else if (ancestors.length === 1) {
        return splitNode(point, options);
      ***REMOVED***

      return ancestors.reduce(function (node, parent) {
        if (node === point.node) {
          node = splitNode(point, options);
        ***REMOVED***

        return splitNode({
          node: parent,
          offset: node ? dom.position(node) : nodeLength(parent)
        ***REMOVED***, options);
      ***REMOVED***);
    ***REMOVED***;

    /**
     * split point
     *
     * @param {Point***REMOVED*** point
     * @param {Boolean***REMOVED*** isInline
     * @return {Object***REMOVED***
     */
    var splitPoint = function (point, isInline) {
      // find splitRoot, container
      //  - inline: splitRoot is a child of paragraph
      //  - block: splitRoot is a child of bodyContainer
      var pred = isInline ? isPara : isBodyContainer;
      var ancestors = listAncestor(point.node, pred);
      var topAncestor = list.last(ancestors) || point.node;

      var splitRoot, container;
      if (pred(topAncestor)) {
        splitRoot = ancestors[ancestors.length - 2];
        container = topAncestor;
      ***REMOVED*** else {
        splitRoot = topAncestor;
        container = splitRoot.parentNode;
      ***REMOVED***

      // if splitRoot is exists, split with splitTree
      var pivot = splitRoot && splitTree(splitRoot, point, {
        isSkipPaddingBlankHTML: isInline,
        isNotSplitEdgePoint: isInline
      ***REMOVED***);

      // if container is point.node, find pivot with point.offset
      if (!pivot && container === point.node) {
        pivot = point.node.childNodes[point.offset];
      ***REMOVED***

      return {
        rightNode: pivot,
        container: container
      ***REMOVED***;
    ***REMOVED***;

    var create = function (nodeName) {
      return document.createElement(nodeName);
    ***REMOVED***;

    var createText = function (text) {
      return document.createTextNode(text);
    ***REMOVED***;

    /**
     * @method remove
     *
     * remove node, (isRemoveChild: remove child or not)
     *
     * @param {Node***REMOVED*** node
     * @param {Boolean***REMOVED*** isRemoveChild
     */
    var remove = function (node, isRemoveChild) {
      if (!node || !node.parentNode) { return; ***REMOVED***
      if (node.removeNode) { return node.removeNode(isRemoveChild); ***REMOVED***

      var parent = node.parentNode;
      if (!isRemoveChild) {
        var nodes = [];
        var i, len;
        for (i = 0, len = node.childNodes.length; i < len; i++) {
          nodes.push(node.childNodes[i]);
        ***REMOVED***

        for (i = 0, len = nodes.length; i < len; i++) {
          parent.insertBefore(nodes[i], node);
        ***REMOVED***
      ***REMOVED***

      parent.removeChild(node);
    ***REMOVED***;

    /**
     * @method removeWhile
     *
     * @param {Node***REMOVED*** node
     * @param {Function***REMOVED*** pred
     */
    var removeWhile = function (node, pred) {
      while (node) {
        if (isEditable(node) || !pred(node)) {
          break;
        ***REMOVED***

        var parent = node.parentNode;
        remove(node);
        node = parent;
      ***REMOVED***
    ***REMOVED***;

    /**
     * @method replace
     *
     * replace node with provided nodeName
     *
     * @param {Node***REMOVED*** node
     * @param {String***REMOVED*** nodeName
     * @return {Node***REMOVED*** - new node
     */
    var replace = function (node, nodeName) {
      if (node.nodeName.toUpperCase() === nodeName.toUpperCase()) {
        return node;
      ***REMOVED***

      var newNode = create(nodeName);

      if (node.style.cssText) {
        newNode.style.cssText = node.style.cssText;
      ***REMOVED***

      appendChildNodes(newNode, list.from(node.childNodes));
      insertAfter(newNode, node);
      remove(node);

      return newNode;
    ***REMOVED***;

    var isTextarea = makePredByNodeName('TEXTAREA');

    /**
     * @param {jQuery***REMOVED*** $node
     * @param {Boolean***REMOVED*** [stripLinebreaks] - default: false
     */
    var value = function ($node, stripLinebreaks) {
      var val = isTextarea($node[0]) ? $node.val() : $node.html();
      if (stripLinebreaks) {
        return val.replace(/[\n\r]/g, '');
      ***REMOVED***
      return val;
    ***REMOVED***;

    /**
     * @method html
     *
     * get the HTML contents of node
     *
     * @param {jQuery***REMOVED*** $node
     * @param {Boolean***REMOVED*** [isNewlineOnBlock]
     */
    var html = function ($node, isNewlineOnBlock) {
      var markup = value($node);

      if (isNewlineOnBlock) {
        var regexTag = /<(\/?)(\b(?!!)[^>\s]*)(.*?)(\s*\/***REMOVED***)/g;
        markup = markup.replace(regexTag, function (match, endSlash, name) {
          name = name.toUpperCase();
          var isEndOfInlineContainer = /^DIV|^TD|^TH|^P|^LI|^H[1-7]/.test(name) &&
                                       !!endSlash;
          var isBlockNode = /^BLOCKQUOTE|^TABLE|^TBODY|^TR|^HR|^UL|^OL/.test(name);

          return match + ((isEndOfInlineContainer || isBlockNode) ? '\n' : '');
        ***REMOVED***);
        markup = $.trim(markup);
      ***REMOVED***

      return markup;
    ***REMOVED***;

    return {
      /** @property {String***REMOVED*** NBSP_CHAR */
      NBSP_CHAR: NBSP_CHAR,
      /** @property {String***REMOVED*** ZERO_WIDTH_NBSP_CHAR */
      ZERO_WIDTH_NBSP_CHAR: ZERO_WIDTH_NBSP_CHAR,
      /** @property {String***REMOVED*** blank */
      blank: blankHTML,
      /** @property {String***REMOVED*** emptyPara */
      emptyPara: '<p>' + blankHTML + '</p>',
      makePredByNodeName: makePredByNodeName,
      isEditable: isEditable,
      isControlSizing: isControlSizing,
      buildLayoutInfo: buildLayoutInfo,
      makeLayoutInfo: makeLayoutInfo,
      isText: isText,
      isVoid: isVoid,
      isPara: isPara,
      isPurePara: isPurePara,
      isInline: isInline,
      isBlock: func.not(isInline),
      isBodyInline: isBodyInline,
      isBody: isBody,
      isParaInline: isParaInline,
      isList: isList,
      isTable: isTable,
      isCell: isCell,
      isBlockquote: isBlockquote,
      isBodyContainer: isBodyContainer,
      isAnchor: isAnchor,
      isDiv: makePredByNodeName('DIV'),
      isLi: isLi,
      isBR: makePredByNodeName('BR'),
      isSpan: makePredByNodeName('SPAN'),
      isB: makePredByNodeName('B'),
      isU: makePredByNodeName('U'),
      isS: makePredByNodeName('S'),
      isI: makePredByNodeName('I'),
      isImg: makePredByNodeName('IMG'),
      isTextarea: isTextarea,
      isEmpty: isEmpty,
      isEmptyAnchor: func.and(isAnchor, isEmpty),
      isClosestSibling: isClosestSibling,
      withClosestSiblings: withClosestSiblings,
      nodeLength: nodeLength,
      isLeftEdgePoint: isLeftEdgePoint,
      isRightEdgePoint: isRightEdgePoint,
      isEdgePoint: isEdgePoint,
      isLeftEdgeOf: isLeftEdgeOf,
      isRightEdgeOf: isRightEdgeOf,
      isLeftEdgePointOf: isLeftEdgePointOf,
      isRightEdgePointOf: isRightEdgePointOf,
      prevPoint: prevPoint,
      nextPoint: nextPoint,
      isSamePoint: isSamePoint,
      isVisiblePoint: isVisiblePoint,
      prevPointUntil: prevPointUntil,
      nextPointUntil: nextPointUntil,
      isCharPoint: isCharPoint,
      walkPoint: walkPoint,
      ancestor: ancestor,
      singleChildAncestor: singleChildAncestor,
      listAncestor: listAncestor,
      lastAncestor: lastAncestor,
      listNext: listNext,
      listPrev: listPrev,
      listDescendant: listDescendant,
      commonAncestor: commonAncestor,
      wrap: wrap,
      insertAfter: insertAfter,
      appendChildNodes: appendChildNodes,
      position: position,
      hasChildren: hasChildren,
      makeOffsetPath: makeOffsetPath,
      fromOffsetPath: fromOffsetPath,
      splitTree: splitTree,
      splitPoint: splitPoint,
      create: create,
      createText: createText,
      remove: remove,
      removeWhile: removeWhile,
      replace: replace,
      html: html,
      value: value
    ***REMOVED***;
  ***REMOVED***)();


  var range = (function () {

    /**
     * return boundaryPoint from TextRange, inspired by Andy Na's HuskyRange.js
     *
     * @param {TextRange***REMOVED*** textRange
     * @param {Boolean***REMOVED*** isStart
     * @return {BoundaryPoint***REMOVED***
     *
     * @see http://msdn.microsoft.com/en-us/library/ie/ms535872(v=vs.85).aspx
     */
    var textRangeToPoint = function (textRange, isStart) {
      var container = textRange.parentElement(), offset;
  
      var tester = document.body.createTextRange(), prevContainer;
      var childNodes = list.from(container.childNodes);
      for (offset = 0; offset < childNodes.length; offset++) {
        if (dom.isText(childNodes[offset])) {
          continue;
        ***REMOVED***
        tester.moveToElementText(childNodes[offset]);
        if (tester.compareEndPoints('StartToStart', textRange) >= 0) {
          break;
        ***REMOVED***
        prevContainer = childNodes[offset];
      ***REMOVED***
  
      if (offset !== 0 && dom.isText(childNodes[offset - 1])) {
        var textRangeStart = document.body.createTextRange(), curTextNode = null;
        textRangeStart.moveToElementText(prevContainer || container);
        textRangeStart.collapse(!prevContainer);
        curTextNode = prevContainer ? prevContainer.nextSibling : container.firstChild;
  
        var pointTester = textRange.duplicate();
        pointTester.setEndPoint('StartToStart', textRangeStart);
        var textCount = pointTester.text.replace(/[\r\n]/g, '').length;
  
        while (textCount > curTextNode.nodeValue.length && curTextNode.nextSibling) {
          textCount -= curTextNode.nodeValue.length;
          curTextNode = curTextNode.nextSibling;
        ***REMOVED***
  
        /* jshint ignore:start */
        var dummy = curTextNode.nodeValue; // enforce IE to re-reference curTextNode, hack
        /* jshint ignore:end */
  
        if (isStart && curTextNode.nextSibling && dom.isText(curTextNode.nextSibling) &&
            textCount === curTextNode.nodeValue.length) {
          textCount -= curTextNode.nodeValue.length;
          curTextNode = curTextNode.nextSibling;
        ***REMOVED***
  
        container = curTextNode;
        offset = textCount;
      ***REMOVED***
  
      return {
        cont: container,
        offset: offset
      ***REMOVED***;
    ***REMOVED***;
    
    /**
     * return TextRange from boundary point (inspired by google closure-library)
     * @param {BoundaryPoint***REMOVED*** point
     * @return {TextRange***REMOVED***
     */
    var pointToTextRange = function (point) {
      var textRangeInfo = function (container, offset) {
        var node, isCollapseToStart;
  
        if (dom.isText(container)) {
          var prevTextNodes = dom.listPrev(container, func.not(dom.isText));
          var prevContainer = list.last(prevTextNodes).previousSibling;
          node =  prevContainer || container.parentNode;
          offset += list.sum(list.tail(prevTextNodes), dom.nodeLength);
          isCollapseToStart = !prevContainer;
        ***REMOVED*** else {
          node = container.childNodes[offset] || container;
          if (dom.isText(node)) {
            return textRangeInfo(node, 0);
          ***REMOVED***
  
          offset = 0;
          isCollapseToStart = false;
        ***REMOVED***
  
        return {
          node: node,
          collapseToStart: isCollapseToStart,
          offset: offset
        ***REMOVED***;
      ***REMOVED***;
  
      var textRange = document.body.createTextRange();
      var info = textRangeInfo(point.node, point.offset);
  
      textRange.moveToElementText(info.node);
      textRange.collapse(info.collapseToStart);
      textRange.moveStart('character', info.offset);
      return textRange;
    ***REMOVED***;
    
    /**
     * Wrapped Range
     *
     * @constructor
     * @param {Node***REMOVED*** sc - start container
     * @param {Number***REMOVED*** so - start offset
     * @param {Node***REMOVED*** ec - end container
     * @param {Number***REMOVED*** eo - end offset
     */
    var WrappedRange = function (sc, so, ec, eo) {
      this.sc = sc;
      this.so = so;
      this.ec = ec;
      this.eo = eo;
  
      // nativeRange: get nativeRange from sc, so, ec, eo
      var nativeRange = function () {
        if (agent.isW3CRangeSupport) {
          var w3cRange = document.createRange();
          w3cRange.setStart(sc, so);
          w3cRange.setEnd(ec, eo);

          return w3cRange;
        ***REMOVED*** else {
          var textRange = pointToTextRange({
            node: sc,
            offset: so
          ***REMOVED***);

          textRange.setEndPoint('EndToEnd', pointToTextRange({
            node: ec,
            offset: eo
          ***REMOVED***));

          return textRange;
        ***REMOVED***
      ***REMOVED***;

      this.getPoints = function () {
        return {
          sc: sc,
          so: so,
          ec: ec,
          eo: eo
        ***REMOVED***;
      ***REMOVED***;

      this.getStartPoint = function () {
        return {
          node: sc,
          offset: so
        ***REMOVED***;
      ***REMOVED***;

      this.getEndPoint = function () {
        return {
          node: ec,
          offset: eo
        ***REMOVED***;
      ***REMOVED***;

      /**
       * select update visible range
       */
      this.select = function () {
        var nativeRng = nativeRange();
        if (agent.isW3CRangeSupport) {
          var selection = document.getSelection();
          if (selection.rangeCount > 0) {
            selection.removeAllRanges();
          ***REMOVED***
          selection.addRange(nativeRng);
        ***REMOVED*** else {
          nativeRng.select();
        ***REMOVED***
        
        return this;
      ***REMOVED***;

      /**
       * @return {WrappedRange***REMOVED***
       */
      this.normalize = function () {

        /**
         * @param {BoundaryPoint***REMOVED*** point
         * @param {Boolean***REMOVED*** isLeftToRight
         * @return {BoundaryPoint***REMOVED***
         */
        var getVisiblePoint = function (point, isLeftToRight) {
          if ((dom.isVisiblePoint(point) && !dom.isEdgePoint(point)) ||
              (dom.isVisiblePoint(point) && dom.isRightEdgePoint(point) && !isLeftToRight) ||
              (dom.isVisiblePoint(point) && dom.isLeftEdgePoint(point) && isLeftToRight) ||
              (dom.isVisiblePoint(point) && dom.isBlock(point.node) && dom.isEmpty(point.node))) {
            return point;
          ***REMOVED***

          // point on block's edge
          var block = dom.ancestor(point.node, dom.isBlock);
          if (((dom.isLeftEdgePointOf(point, block) || dom.isVoid(dom.prevPoint(point).node)) && !isLeftToRight) ||
              ((dom.isRightEdgePointOf(point, block) || dom.isVoid(dom.nextPoint(point).node)) && isLeftToRight)) {

            // returns point already on visible point
            if (dom.isVisiblePoint(point)) {
              return point;
            ***REMOVED***
            // reverse direction 
            isLeftToRight = !isLeftToRight;
          ***REMOVED***

          var nextPoint = isLeftToRight ? dom.nextPointUntil(dom.nextPoint(point), dom.isVisiblePoint) :
                                          dom.prevPointUntil(dom.prevPoint(point), dom.isVisiblePoint);
          return nextPoint || point;
        ***REMOVED***;

        var endPoint = getVisiblePoint(this.getEndPoint(), false);
        var startPoint = this.isCollapsed() ? endPoint : getVisiblePoint(this.getStartPoint(), true);

        return new WrappedRange(
          startPoint.node,
          startPoint.offset,
          endPoint.node,
          endPoint.offset
        );
      ***REMOVED***;

      /**
       * returns matched nodes on range
       *
       * @param {Function***REMOVED*** [pred] - predicate function
       * @param {Object***REMOVED*** [options]
       * @param {Boolean***REMOVED*** [options.includeAncestor]
       * @param {Boolean***REMOVED*** [options.fullyContains]
       * @return {Node[]***REMOVED***
       */
      this.nodes = function (pred, options) {
        pred = pred || func.ok;

        var includeAncestor = options && options.includeAncestor;
        var fullyContains = options && options.fullyContains;

        // TODO compare points and sort
        var startPoint = this.getStartPoint();
        var endPoint = this.getEndPoint();

        var nodes = [];
        var leftEdgeNodes = [];

        dom.walkPoint(startPoint, endPoint, function (point) {
          if (dom.isEditable(point.node)) {
            return;
          ***REMOVED***

          var node;
          if (fullyContains) {
            if (dom.isLeftEdgePoint(point)) {
              leftEdgeNodes.push(point.node);
            ***REMOVED***
            if (dom.isRightEdgePoint(point) && list.contains(leftEdgeNodes, point.node)) {
              node = point.node;
            ***REMOVED***
          ***REMOVED*** else if (includeAncestor) {
            node = dom.ancestor(point.node, pred);
          ***REMOVED*** else {
            node = point.node;
          ***REMOVED***

          if (node && pred(node)) {
            nodes.push(node);
          ***REMOVED***
        ***REMOVED***, true);

        return list.unique(nodes);
      ***REMOVED***;

      /**
       * returns commonAncestor of range
       * @return {Element***REMOVED*** - commonAncestor
       */
      this.commonAncestor = function () {
        return dom.commonAncestor(sc, ec);
      ***REMOVED***;

      /**
       * returns expanded range by pred
       *
       * @param {Function***REMOVED*** pred - predicate function
       * @return {WrappedRange***REMOVED***
       */
      this.expand = function (pred) {
        var startAncestor = dom.ancestor(sc, pred);
        var endAncestor = dom.ancestor(ec, pred);

        if (!startAncestor && !endAncestor) {
          return new WrappedRange(sc, so, ec, eo);
        ***REMOVED***

        var boundaryPoints = this.getPoints();

        if (startAncestor) {
          boundaryPoints.sc = startAncestor;
          boundaryPoints.so = 0;
        ***REMOVED***

        if (endAncestor) {
          boundaryPoints.ec = endAncestor;
          boundaryPoints.eo = dom.nodeLength(endAncestor);
        ***REMOVED***

        return new WrappedRange(
          boundaryPoints.sc,
          boundaryPoints.so,
          boundaryPoints.ec,
          boundaryPoints.eo
        );
      ***REMOVED***;

      /**
       * @param {Boolean***REMOVED*** isCollapseToStart
       * @return {WrappedRange***REMOVED***
       */
      this.collapse = function (isCollapseToStart) {
        if (isCollapseToStart) {
          return new WrappedRange(sc, so, sc, so);
        ***REMOVED*** else {
          return new WrappedRange(ec, eo, ec, eo);
        ***REMOVED***
      ***REMOVED***;

      /**
       * splitText on range
       */
      this.splitText = function () {
        var isSameContainer = sc === ec;
        var boundaryPoints = this.getPoints();

        if (dom.isText(ec) && !dom.isEdgePoint(this.getEndPoint())) {
          ec.splitText(eo);
        ***REMOVED***

        if (dom.isText(sc) && !dom.isEdgePoint(this.getStartPoint())) {
          boundaryPoints.sc = sc.splitText(so);
          boundaryPoints.so = 0;

          if (isSameContainer) {
            boundaryPoints.ec = boundaryPoints.sc;
            boundaryPoints.eo = eo - so;
          ***REMOVED***
        ***REMOVED***

        return new WrappedRange(
          boundaryPoints.sc,
          boundaryPoints.so,
          boundaryPoints.ec,
          boundaryPoints.eo
        );
      ***REMOVED***;

      /**
       * delete contents on range
       * @return {WrappedRange***REMOVED***
       */
      this.deleteContents = function () {
        if (this.isCollapsed()) {
          return this;
        ***REMOVED***

        var rng = this.splitText();
        var nodes = rng.nodes(null, {
          fullyContains: true
        ***REMOVED***);

        // find new cursor point
        var point = dom.prevPointUntil(rng.getStartPoint(), function (point) {
          return !list.contains(nodes, point.node);
        ***REMOVED***);

        var emptyParents = [];
        $.each(nodes, function (idx, node) {
          // find empty parents
          var parent = node.parentNode;
          if (point.node !== parent && dom.nodeLength(parent) === 1) {
            emptyParents.push(parent);
          ***REMOVED***
          dom.remove(node, false);
        ***REMOVED***);

        // remove empty parents
        $.each(emptyParents, function (idx, node) {
          dom.remove(node, false);
        ***REMOVED***);

        return new WrappedRange(
          point.node,
          point.offset,
          point.node,
          point.offset
        ).normalize();
      ***REMOVED***;
      
      /**
       * makeIsOn: return isOn(pred) function
       */
      var makeIsOn = function (pred) {
        return function () {
          var ancestor = dom.ancestor(sc, pred);
          return !!ancestor && (ancestor === dom.ancestor(ec, pred));
        ***REMOVED***;
      ***REMOVED***;
  
      // isOnEditable: judge whether range is on editable or not
      this.isOnEditable = makeIsOn(dom.isEditable);
      // isOnList: judge whether range is on list node or not
      this.isOnList = makeIsOn(dom.isList);
      // isOnAnchor: judge whether range is on anchor node or not
      this.isOnAnchor = makeIsOn(dom.isAnchor);
      // isOnAnchor: judge whether range is on cell node or not
      this.isOnCell = makeIsOn(dom.isCell);

      /**
       * @param {Function***REMOVED*** pred
       * @return {Boolean***REMOVED***
       */
      this.isLeftEdgeOf = function (pred) {
        if (!dom.isLeftEdgePoint(this.getStartPoint())) {
          return false;
        ***REMOVED***

        var node = dom.ancestor(this.sc, pred);
        return node && dom.isLeftEdgeOf(this.sc, node);
      ***REMOVED***;

      /**
       * returns whether range was collapsed or not
       */
      this.isCollapsed = function () {
        return sc === ec && so === eo;
      ***REMOVED***;

      /**
       * wrap inline nodes which children of body with paragraph
       *
       * @return {WrappedRange***REMOVED***
       */
      this.wrapBodyInlineWithPara = function () {
        if (dom.isBodyContainer(sc) && dom.isEmpty(sc)) {
          sc.innerHTML = dom.emptyPara;
          return new WrappedRange(sc.firstChild, 0, sc.firstChild, 0);
        ***REMOVED***

        /**
         * [workaround] firefox often create range on not visible point. so normalize here.
         *  - firefox: |<p>text</p>|
         *  - chrome: <p>|text|</p>
         */
        var rng = this.normalize();
        if (dom.isParaInline(sc) || dom.isPara(sc)) {
          return rng;
        ***REMOVED***

        // find inline top ancestor
        var topAncestor;
        if (dom.isInline(rng.sc)) {
          var ancestors = dom.listAncestor(rng.sc, func.not(dom.isInline));
          topAncestor = list.last(ancestors);
          if (!dom.isInline(topAncestor)) {
            topAncestor = ancestors[ancestors.length - 2] || rng.sc.childNodes[rng.so];
          ***REMOVED***
        ***REMOVED*** else {
          topAncestor = rng.sc.childNodes[rng.so > 0 ? rng.so - 1 : 0];
        ***REMOVED***

        // siblings not in paragraph
        var inlineSiblings = dom.listPrev(topAncestor, dom.isParaInline).reverse();
        inlineSiblings = inlineSiblings.concat(dom.listNext(topAncestor.nextSibling, dom.isParaInline));

        // wrap with paragraph
        if (inlineSiblings.length) {
          var para = dom.wrap(list.head(inlineSiblings), 'p');
          dom.appendChildNodes(para, list.tail(inlineSiblings));
        ***REMOVED***

        return this.normalize();
      ***REMOVED***;

      /**
       * insert node at current cursor
       *
       * @param {Node***REMOVED*** node
       * @return {Node***REMOVED***
       */
      this.insertNode = function (node) {
        var rng = this.wrapBodyInlineWithPara().deleteContents();
        var info = dom.splitPoint(rng.getStartPoint(), dom.isInline(node));

        if (info.rightNode) {
          info.rightNode.parentNode.insertBefore(node, info.rightNode);
        ***REMOVED*** else {
          info.container.appendChild(node);
        ***REMOVED***

        return node;
      ***REMOVED***;

      /**
       * insert html at current cursor
       */
      this.pasteHTML = function (markup) {
        var contentsContainer = $('<div></div>').html(markup)[0];
        var childNodes = list.from(contentsContainer.childNodes);

        var rng = this.wrapBodyInlineWithPara().deleteContents();

        return childNodes.reverse().map(function (childNode) {
          return rng.insertNode(childNode);
        ***REMOVED***).reverse();
      ***REMOVED***;
  
      /**
       * returns text in range
       *
       * @return {String***REMOVED***
       */
      this.toString = function () {
        var nativeRng = nativeRange();
        return agent.isW3CRangeSupport ? nativeRng.toString() : nativeRng.text;
      ***REMOVED***;

      /**
       * returns range for word before cursor
       *
       * @param {Boolean***REMOVED*** [findAfter] - find after cursor, default: false
       * @return {WrappedRange***REMOVED***
       */
      this.getWordRange = function (findAfter) {
        var endPoint = this.getEndPoint();

        if (!dom.isCharPoint(endPoint)) {
          return this;
        ***REMOVED***

        var startPoint = dom.prevPointUntil(endPoint, function (point) {
          return !dom.isCharPoint(point);
        ***REMOVED***);

        if (findAfter) {
          endPoint = dom.nextPointUntil(endPoint, function (point) {
            return !dom.isCharPoint(point);
          ***REMOVED***);
        ***REMOVED***

        return new WrappedRange(
          startPoint.node,
          startPoint.offset,
          endPoint.node,
          endPoint.offset
        );
      ***REMOVED***;
  
      /**
       * create offsetPath bookmark
       *
       * @param {Node***REMOVED*** editable
       */
      this.bookmark = function (editable) {
        return {
          s: {
            path: dom.makeOffsetPath(editable, sc),
            offset: so
          ***REMOVED***,
          e: {
            path: dom.makeOffsetPath(editable, ec),
            offset: eo
          ***REMOVED***
        ***REMOVED***;
      ***REMOVED***;

      /**
       * create offsetPath bookmark base on paragraph
       *
       * @param {Node[]***REMOVED*** paras
       */
      this.paraBookmark = function (paras) {
        return {
          s: {
            path: list.tail(dom.makeOffsetPath(list.head(paras), sc)),
            offset: so
          ***REMOVED***,
          e: {
            path: list.tail(dom.makeOffsetPath(list.last(paras), ec)),
            offset: eo
          ***REMOVED***
        ***REMOVED***;
      ***REMOVED***;

      /**
       * getClientRects
       * @return {Rect[]***REMOVED***
       */
      this.getClientRects = function () {
        var nativeRng = nativeRange();
        return nativeRng.getClientRects();
      ***REMOVED***;
    ***REMOVED***;

  /**
   * @class core.range
   *
   * Data structure
   *  * BoundaryPoint: a point of dom tree
   *  * BoundaryPoints: two boundaryPoints corresponding to the start and the end of the Range
   *
   * See to http://www.w3.org/TR/DOM-Level-2-Traversal-Range/ranges.html#Level-2-Range-Position
   *
   * @singleton
   * @alternateClassName range
   */
    return {
      /**
       * @method
       * 
       * create Range Object From arguments or Browser Selection
       *
       * @param {Node***REMOVED*** sc - start container
       * @param {Number***REMOVED*** so - start offset
       * @param {Node***REMOVED*** ec - end container
       * @param {Number***REMOVED*** eo - end offset
       * @return {WrappedRange***REMOVED***
       */
      create : function (sc, so, ec, eo) {
        if (!arguments.length) { // from Browser Selection
          if (agent.isW3CRangeSupport) {
            var selection = document.getSelection();
            if (!selection || selection.rangeCount === 0) {
              return null;
            ***REMOVED*** else if (dom.isBody(selection.anchorNode)) {
              // Firefox: returns entire body as range on initialization. We won't never need it.
              return null;
            ***REMOVED***
  
            var nativeRng = selection.getRangeAt(0);
            sc = nativeRng.startContainer;
            so = nativeRng.startOffset;
            ec = nativeRng.endContainer;
            eo = nativeRng.endOffset;
          ***REMOVED*** else { // IE8: TextRange
            var textRange = document.selection.createRange();
            var textRangeEnd = textRange.duplicate();
            textRangeEnd.collapse(false);
            var textRangeStart = textRange;
            textRangeStart.collapse(true);
  
            var startPoint = textRangeToPoint(textRangeStart, true),
            endPoint = textRangeToPoint(textRangeEnd, false);

            // same visible point case: range was collapsed.
            if (dom.isText(startPoint.node) && dom.isLeftEdgePoint(startPoint) &&
                dom.isTextNode(endPoint.node) && dom.isRightEdgePoint(endPoint) &&
                endPoint.node.nextSibling === startPoint.node) {
              startPoint = endPoint;
            ***REMOVED***

            sc = startPoint.cont;
            so = startPoint.offset;
            ec = endPoint.cont;
            eo = endPoint.offset;
          ***REMOVED***
        ***REMOVED*** else if (arguments.length === 2) { //collapsed
          ec = sc;
          eo = so;
        ***REMOVED***
        return new WrappedRange(sc, so, ec, eo);
      ***REMOVED***,

      /**
       * @method 
       * 
       * create WrappedRange from node
       *
       * @param {Node***REMOVED*** node
       * @return {WrappedRange***REMOVED***
       */
      createFromNode: function (node) {
        var sc = node;
        var so = 0;
        var ec = node;
        var eo = dom.nodeLength(ec);

        // browsers can't target a picture or void node
        if (dom.isVoid(sc)) {
          so = dom.listPrev(sc).length - 1;
          sc = sc.parentNode;
        ***REMOVED***
        if (dom.isBR(ec)) {
          eo = dom.listPrev(ec).length - 1;
          ec = ec.parentNode;
        ***REMOVED*** else if (dom.isVoid(ec)) {
          eo = dom.listPrev(ec).length;
          ec = ec.parentNode;
        ***REMOVED***

        return this.create(sc, so, ec, eo);
      ***REMOVED***,

      /**
       * create WrappedRange from node after position
       *
       * @param {Node***REMOVED*** node
       * @return {WrappedRange***REMOVED***
       */
      createFromNodeBefore: function (node) {
        return this.createFromNode(node).collapse(true);
      ***REMOVED***,

      /**
       * create WrappedRange from node after position
       *
       * @param {Node***REMOVED*** node
       * @return {WrappedRange***REMOVED***
       */
      createFromNodeAfter: function (node) {
        return this.createFromNode(node).collapse();
      ***REMOVED***,

      /**
       * @method 
       * 
       * create WrappedRange from bookmark
       *
       * @param {Node***REMOVED*** editable
       * @param {Object***REMOVED*** bookmark
       * @return {WrappedRange***REMOVED***
       */
      createFromBookmark : function (editable, bookmark) {
        var sc = dom.fromOffsetPath(editable, bookmark.s.path);
        var so = bookmark.s.offset;
        var ec = dom.fromOffsetPath(editable, bookmark.e.path);
        var eo = bookmark.e.offset;
        return new WrappedRange(sc, so, ec, eo);
      ***REMOVED***,

      /**
       * @method 
       *
       * create WrappedRange from paraBookmark
       *
       * @param {Object***REMOVED*** bookmark
       * @param {Node[]***REMOVED*** paras
       * @return {WrappedRange***REMOVED***
       */
      createFromParaBookmark: function (bookmark, paras) {
        var so = bookmark.s.offset;
        var eo = bookmark.e.offset;
        var sc = dom.fromOffsetPath(list.head(paras), bookmark.s.path);
        var ec = dom.fromOffsetPath(list.last(paras), bookmark.e.path);

        return new WrappedRange(sc, so, ec, eo);
      ***REMOVED***
    ***REMOVED***;
  ***REMOVED***)();

  /**
   * @class defaults 
   * 
   * @singleton
   */
  var defaults = {
    /** @property */
    version: '0.6.16',

    /**
     * 
     * for event options, reference to EventHandler.attach
     * 
     * @property {Object***REMOVED*** options 
     * @property {String/Number***REMOVED*** [options.width=null] set editor width 
     * @property {String/Number***REMOVED*** [options.height=null] set editor height, ex) 300
     * @property {String/Number***REMOVED*** options.minHeight set minimum height of editor
     * @property {String/Number***REMOVED*** options.maxHeight
     * @property {String/Number***REMOVED*** options.focus 
     * @property {Number***REMOVED*** options.tabsize 
     * @property {Boolean***REMOVED*** options.styleWithSpan
     * @property {Object***REMOVED*** options.codemirror
     * @property {Object***REMOVED*** [options.codemirror.mode='text/html']
     * @property {Object***REMOVED*** [options.codemirror.htmlMode=true]
     * @property {Object***REMOVED*** [options.codemirror.lineNumbers=true]
     * @property {String***REMOVED*** [options.lang=en-US] language 'en-US', 'ko-KR', ...
     * @property {String***REMOVED*** [options.direction=null] text direction, ex) 'rtl'
     * @property {Array***REMOVED*** [options.toolbar]
     * @property {Boolean***REMOVED*** [options.airMode=false]
     * @property {Array***REMOVED*** [options.airPopover]
     * @property {Fucntion***REMOVED*** [options.onInit] initialize
     * @property {Fucntion***REMOVED*** [options.onsubmit]
     */
    options: {
      width: null,                  // set editor width
      height: null,                 // set editor height, ex) 300

      minHeight: null,              // set minimum height of editor
      maxHeight: null,              // set maximum height of editor

      focus: false,                 // set focus to editable area after initializing summernote

      tabsize: 4,                   // size of tab ex) 2 or 4
      styleWithSpan: true,          // style with span (Chrome and FF only)

      disableLinkTarget: false,     // hide link Target Checkbox
      disableDragAndDrop: false,    // disable drag and drop event
      disableResizeEditor: false,   // disable resizing editor
      disableResizeImage: false,    // disable resizing image

      shortcuts: true,              // enable keyboard shortcuts

      textareaAutoSync: true,       // enable textarea auto sync

      placeholder: false,           // enable placeholder text
      prettifyHtml: true,           // enable prettifying html while toggling codeview

      iconPrefix: 'fa fa-',         // prefix for css icon classes

      icons: {
        font: {
          bold: 'bold',
          italic: 'italic',
          underline: 'underline',
          clear: 'eraser',
          height: 'text-height',
          strikethrough: 'strikethrough',
          superscript: 'superscript',
          subscript: 'subscript'
        ***REMOVED***,
        image: {
          image: 'picture-o',
          floatLeft: 'align-left',
          floatRight: 'align-right',
          floatNone: 'align-justify',
          shapeRounded: 'square',
          shapeCircle: 'circle-o',
          shapeThumbnail: 'picture-o',
          shapeNone: 'times',
          remove: 'trash-o'
        ***REMOVED***,
        link: {
          link: 'link',
          unlink: 'unlink',
          edit: 'edit'
        ***REMOVED***,
        table: {
          table: 'table'
        ***REMOVED***,
        hr: {
          insert: 'minus'
        ***REMOVED***,
        style: {
          style: 'magic'
        ***REMOVED***,
        lists: {
          unordered: 'list-ul',
          ordered: 'list-ol'
        ***REMOVED***,
        options: {
          help: 'question',
          fullscreen: 'arrows-alt',
          codeview: 'code'
        ***REMOVED***,
        paragraph: {
          paragraph: 'align-left',
          outdent: 'outdent',
          indent: 'indent',
          left: 'align-left',
          center: 'align-center',
          right: 'align-right',
          justify: 'align-justify'
        ***REMOVED***,
        color: {
          recent: 'font'
        ***REMOVED***,
        history: {
          undo: 'undo',
          redo: 'repeat'
        ***REMOVED***,
        misc: {
          check: 'check'
        ***REMOVED***
      ***REMOVED***,

      dialogsInBody: false,          // false will add dialogs into editor

      codemirror: {                 // codemirror options
        mode: 'text/html',
        htmlMode: true,
        lineNumbers: true
      ***REMOVED***,

      // language
      lang: 'en-US',                // language 'en-US', 'ko-KR', ...
      direction: null,              // text direction, ex) 'rtl'

      // toolbar
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'hr']],
        ['view', ['fullscreen', 'codeview']],
        ['help', ['help']]
      ],

      plugin : { ***REMOVED***,

      // air mode: inline editor
      airMode: false,
      // airPopover: [
      //   ['style', ['style']],
      //   ['font', ['bold', 'italic', 'underline', 'clear']],
      //   ['fontname', ['fontname']],
      //   ['color', ['color']],
      //   ['para', ['ul', 'ol', 'paragraph']],
      //   ['height', ['height']],
      //   ['table', ['table']],
      //   ['insert', ['link', 'picture']],
      //   ['help', ['help']]
      // ],
      airPopover: [
        ['color', ['color']],
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture']]
      ],

      // style tag
      styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],

      // default fontName
      defaultFontName: 'Helvetica Neue',

      // fontName
      fontNames: [
        'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
        'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande',
        'Tahoma', 'Times New Roman', 'Verdana'
      ],
      fontNamesIgnoreCheck: [],

      fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36'],

      // pallete colors(n x n)
      colors: [
        ['#000000', '#424242', '#636363', '#9C9C94', '#CEC6CE', '#EFEFEF', '#F7F7F7', '#FFFFFF'],
        ['#FF0000', '#FF9C00', '#FFFF00', '#00FF00', '#00FFFF', '#0000FF', '#9C00FF', '#FF00FF'],
        ['#F7C6CE', '#FFE7CE', '#FFEFC6', '#D6EFD6', '#CEDEE7', '#CEE7F7', '#D6D6E7', '#E7D6DE'],
        ['#E79C9C', '#FFC69C', '#FFE79C', '#B5D6A5', '#A5C6CE', '#9CC6EF', '#B5A5D6', '#D6A5BD'],
        ['#E76363', '#F7AD6B', '#FFD663', '#94BD7B', '#73A5AD', '#6BADDE', '#8C7BC6', '#C67BA5'],
        ['#CE0000', '#E79439', '#EFC631', '#6BA54A', '#4A7B8C', '#3984C6', '#634AA5', '#A54A7B'],
        ['#9C0000', '#B56308', '#BD9400', '#397B21', '#104A5A', '#085294', '#311873', '#731842'],
        ['#630000', '#7B3900', '#846300', '#295218', '#083139', '#003163', '#21104A', '#4A1031']
      ],

      // lineHeight
      lineHeights: ['1.0', '1.2', '1.4', '1.5', '1.6', '1.8', '2.0', '3.0'],

      // insertTable max size
      insertTableMaxSize: {
        col: 10,
        row: 10
      ***REMOVED***,

      // image
      maximumImageFileSize: null, // size in bytes, null = no limit

      // callbacks
      oninit: null,             // initialize
      onfocus: null,            // editable has focus
      onblur: null,             // editable out of focus
      onenter: null,            // enter key pressed
      onkeyup: null,            // keyup
      onkeydown: null,          // keydown
      onImageUpload: null,      // imageUpload
      onImageUploadError: null, // imageUploadError
      onMediaDelete: null,      // media delete
      onToolbarClick: null,
      onsubmit: null,

      /**
       * manipulate link address when user create link
       * @param {String***REMOVED*** sLinkUrl
       * @return {String***REMOVED***
       */
      onCreateLink: function (sLinkUrl) {
        if (sLinkUrl.indexOf('@') !== -1 && sLinkUrl.indexOf(':') === -1) {
          sLinkUrl =  'mailto:' + sLinkUrl;
        ***REMOVED***

        return sLinkUrl;
      ***REMOVED***,

      keyMap: {
        pc: {
          'ENTER': 'insertParagraph',
          'CTRL+Z': 'undo',
          'CTRL+Y': 'redo',
          'TAB': 'tab',
          'SHIFT+TAB': 'untab',
          'CTRL+B': 'bold',
          'CTRL+I': 'italic',
          'CTRL+U': 'underline',
          'CTRL+SHIFT+S': 'strikethrough',
          'CTRL+BACKSLASH': 'removeFormat',
          'CTRL+SHIFT+L': 'justifyLeft',
          'CTRL+SHIFT+E': 'justifyCenter',
          'CTRL+SHIFT+R': 'justifyRight',
          'CTRL+SHIFT+J': 'justifyFull',
          'CTRL+SHIFT+NUM7': 'insertUnorderedList',
          'CTRL+SHIFT+NUM8': 'insertOrderedList',
          'CTRL+LEFTBRACKET': 'outdent',
          'CTRL+RIGHTBRACKET': 'indent',
          'CTRL+NUM0': 'formatPara',
          'CTRL+NUM1': 'formatH1',
          'CTRL+NUM2': 'formatH2',
          'CTRL+NUM3': 'formatH3',
          'CTRL+NUM4': 'formatH4',
          'CTRL+NUM5': 'formatH5',
          'CTRL+NUM6': 'formatH6',
          'CTRL+ENTER': 'insertHorizontalRule',
          'CTRL+K': 'showLinkDialog'
        ***REMOVED***,

        mac: {
          'ENTER': 'insertParagraph',
          'CMD+Z': 'undo',
          'CMD+SHIFT+Z': 'redo',
          'TAB': 'tab',
          'SHIFT+TAB': 'untab',
          'CMD+B': 'bold',
          'CMD+I': 'italic',
          'CMD+U': 'underline',
          'CMD+SHIFT+S': 'strikethrough',
          'CMD+BACKSLASH': 'removeFormat',
          'CMD+SHIFT+L': 'justifyLeft',
          'CMD+SHIFT+E': 'justifyCenter',
          'CMD+SHIFT+R': 'justifyRight',
          'CMD+SHIFT+J': 'justifyFull',
          'CMD+SHIFT+NUM7': 'insertUnorderedList',
          'CMD+SHIFT+NUM8': 'insertOrderedList',
          'CMD+LEFTBRACKET': 'outdent',
          'CMD+RIGHTBRACKET': 'indent',
          'CMD+NUM0': 'formatPara',
          'CMD+NUM1': 'formatH1',
          'CMD+NUM2': 'formatH2',
          'CMD+NUM3': 'formatH3',
          'CMD+NUM4': 'formatH4',
          'CMD+NUM5': 'formatH5',
          'CMD+NUM6': 'formatH6',
          'CMD+ENTER': 'insertHorizontalRule',
          'CMD+K': 'showLinkDialog'
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***,

    // default language: en-US
    lang: {
      'en-US': {
        font: {
          bold: 'Bold',
          italic: 'Italic',
          underline: 'Underline',
          clear: 'Remove Font Style',
          height: 'Line Height',
          name: 'Font Family',
          strikethrough: 'Strikethrough',
          subscript: 'Subscript',
          superscript: 'Superscript',
          size: 'Font Size'
        ***REMOVED***,
        image: {
          image: 'Picture',
          insert: 'Insert Image',
          resizeFull: 'Resize Full',
          resizeHalf: 'Resize Half',
          resizeQuarter: 'Resize Quarter',
          floatLeft: 'Float Left',
          floatRight: 'Float Right',
          floatNone: 'Float None',
          shapeRounded: 'Shape: Rounded',
          shapeCircle: 'Shape: Circle',
          shapeThumbnail: 'Shape: Thumbnail',
          shapeNone: 'Shape: None',
          dragImageHere: 'Drag image or text here',
          dropImage: 'Drop image or Text',
          selectFromFiles: 'Select from files',
          maximumFileSize: 'Maximum file size',
          maximumFileSizeError: 'Maximum file size exceeded.',
          url: 'Image URL',
          remove: 'Remove Image'
        ***REMOVED***,
        link: {
          link: 'Link',
          insert: 'Insert Link',
          unlink: 'Unlink',
          edit: 'Edit',
          textToDisplay: 'Text to display',
          url: 'To what URL should this link go?',
          openInNewWindow: 'Open in new window'
        ***REMOVED***,
        table: {
          table: 'Table'
        ***REMOVED***,
        hr: {
          insert: 'Insert Horizontal Rule'
        ***REMOVED***,
        style: {
          style: 'Style',
          normal: 'Normal',
          blockquote: 'Quote',
          pre: 'Code',
          h1: 'Header 1',
          h2: 'Header 2',
          h3: 'Header 3',
          h4: 'Header 4',
          h5: 'Header 5',
          h6: 'Header 6'
        ***REMOVED***,
        lists: {
          unordered: 'Unordered list',
          ordered: 'Ordered list'
        ***REMOVED***,
        options: {
          help: 'Help',
          fullscreen: 'Full Screen',
          codeview: 'Code View'
        ***REMOVED***,
        paragraph: {
          paragraph: 'Paragraph',
          outdent: 'Outdent',
          indent: 'Indent',
          left: 'Align left',
          center: 'Align center',
          right: 'Align right',
          justify: 'Justify full'
        ***REMOVED***,
        color: {
          recent: 'Recent Color',
          more: 'More Color',
          background: 'Background Color',
          foreground: 'Foreground Color',
          transparent: 'Transparent',
          setTransparent: 'Set transparent',
          reset: 'Reset',
          resetToDefault: 'Reset to default'
        ***REMOVED***,
        shortcut: {
          shortcuts: 'Keyboard shortcuts',
          close: 'Close',
          textFormatting: 'Text formatting',
          action: 'Action',
          paragraphFormatting: 'Paragraph formatting',
          documentStyle: 'Document Style',
          extraKeys: 'Extra keys'
        ***REMOVED***,
        history: {
          undo: 'Undo',
          redo: 'Redo'
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***;

  /**
   * @class core.async
   *
   * Async functions which returns `Promise`
   *
   * @singleton
   * @alternateClassName async
   */
  var async = (function () {
    /**
     * @method readFileAsDataURL
     *
     * read contents of file as representing URL
     *
     * @param {File***REMOVED*** file
     * @return {Promise***REMOVED*** - then: sDataUrl
     */
    var readFileAsDataURL = function (file) {
      return $.Deferred(function (deferred) {
        $.extend(new FileReader(), {
          onload: function (e) {
            var sDataURL = e.target.result;
            deferred.resolve(sDataURL);
          ***REMOVED***,
          onerror: function () {
            deferred.reject(this);
          ***REMOVED***
        ***REMOVED***).readAsDataURL(file);
      ***REMOVED***).promise();
    ***REMOVED***;
  
    /**
     * @method createImage
     *
     * create `<image>` from url string
     *
     * @param {String***REMOVED*** sUrl
     * @param {String***REMOVED*** filename
     * @return {Promise***REMOVED*** - then: $image
     */
    var createImage = function (sUrl, filename) {
      return $.Deferred(function (deferred) {
        var $img = $('<img>');

        $img.one('load', function () {
          $img.off('error abort');
          deferred.resolve($img);
        ***REMOVED***).one('error abort', function () {
          $img.off('load').detach();
          deferred.reject($img);
        ***REMOVED***).css({
          display: 'none'
        ***REMOVED***).appendTo(document.body).attr({
          'src': sUrl,
          'data-filename': filename
        ***REMOVED***);
      ***REMOVED***).promise();
    ***REMOVED***;

    return {
      readFileAsDataURL: readFileAsDataURL,
      createImage: createImage
    ***REMOVED***;
  ***REMOVED***)();

  /**
   * @class core.key
   *
   * Object for keycodes.
   *
   * @singleton
   * @alternateClassName key
   */
  var key = (function () {
    var keyMap = {
      'BACKSPACE': 8,
      'TAB': 9,
      'ENTER': 13,
      'SPACE': 32,

      // Number: 0-9
      'NUM0': 48,
      'NUM1': 49,
      'NUM2': 50,
      'NUM3': 51,
      'NUM4': 52,
      'NUM5': 53,
      'NUM6': 54,
      'NUM7': 55,
      'NUM8': 56,

      // Alphabet: a-z
      'B': 66,
      'E': 69,
      'I': 73,
      'J': 74,
      'K': 75,
      'L': 76,
      'R': 82,
      'S': 83,
      'U': 85,
      'V': 86,
      'Y': 89,
      'Z': 90,

      'SLASH': 191,
      'LEFTBRACKET': 219,
      'BACKSLASH': 220,
      'RIGHTBRACKET': 221
    ***REMOVED***;

    return {
      /**
       * @method isEdit
       *
       * @param {Number***REMOVED*** keyCode
       * @return {Boolean***REMOVED***
       */
      isEdit: function (keyCode) {
        return list.contains([8, 9, 13, 32], keyCode);
      ***REMOVED***,
      /**
       * @method isMove
       *
       * @param {Number***REMOVED*** keyCode
       * @return {Boolean***REMOVED***
       */
      isMove: function (keyCode) {
        return list.contains([37, 38, 39, 40], keyCode);
      ***REMOVED***,
      /**
       * @property {Object***REMOVED*** nameFromCode
       * @property {String***REMOVED*** nameFromCode.8 "BACKSPACE"
       */
      nameFromCode: func.invertObject(keyMap),
      code: keyMap
    ***REMOVED***;
  ***REMOVED***)();

  /**
   * @class editing.History
   *
   * Editor History
   *
   */
  var History = function ($editable) {
    var stack = [], stackOffset = -1;
    var editable = $editable[0];

    var makeSnapshot = function () {
      var rng = range.create();
      var emptyBookmark = {s: {path: [], offset: 0***REMOVED***, e: {path: [], offset: 0***REMOVED******REMOVED***;

      return {
        contents: $editable.html(),
        bookmark: (rng ? rng.bookmark(editable) : emptyBookmark)
      ***REMOVED***;
    ***REMOVED***;

    var applySnapshot = function (snapshot) {
      if (snapshot.contents !== null) {
        $editable.html(snapshot.contents);
      ***REMOVED***
      if (snapshot.bookmark !== null) {
        range.createFromBookmark(editable, snapshot.bookmark).select();
      ***REMOVED***
    ***REMOVED***;

    /**
     * undo
     */
    this.undo = function () {
      // Create snap shot if not yet recorded
      if ($editable.html() !== stack[stackOffset].contents) {
        this.recordUndo();
      ***REMOVED***

      if (0 < stackOffset) {
        stackOffset--;
        applySnapshot(stack[stackOffset]);
      ***REMOVED***
    ***REMOVED***;

    /**
     * redo
     */
    this.redo = function () {
      if (stack.length - 1 > stackOffset) {
        stackOffset++;
        applySnapshot(stack[stackOffset]);
      ***REMOVED***
    ***REMOVED***;

    /**
     * recorded undo
     */
    this.recordUndo = function () {
      stackOffset++;

      // Wash out stack after stackOffset
      if (stack.length > stackOffset) {
        stack = stack.slice(0, stackOffset);
      ***REMOVED***

      // Create new snapshot and push it to the end
      stack.push(makeSnapshot());
    ***REMOVED***;

    // Create first undo stack
    this.recordUndo();
  ***REMOVED***;

  /**
   * @class editing.Style
   *
   * Style
   *
   */
  var Style = function () {
    /**
     * @method jQueryCSS
     *
     * [workaround] for old jQuery
     * passing an array of style properties to .css()
     * will result in an object of property-value pairs.
     * (compability with version < 1.9)
     *
     * @private
     * @param  {jQuery***REMOVED*** $obj
     * @param  {Array***REMOVED*** propertyNames - An array of one or more CSS properties.
     * @return {Object***REMOVED***
     */
    var jQueryCSS = function ($obj, propertyNames) {
      if (agent.jqueryVersion < 1.9) {
        var result = {***REMOVED***;
        $.each(propertyNames, function (idx, propertyName) {
          result[propertyName] = $obj.css(propertyName);
        ***REMOVED***);
        return result;
      ***REMOVED***
      return $obj.css.call($obj, propertyNames);
    ***REMOVED***;

    /**
     * returns style object from node
     *
     * @param {jQuery***REMOVED*** $node
     * @return {Object***REMOVED***
     */
    this.fromNode = function ($node) {
      var properties = ['font-family', 'font-size', 'text-align', 'list-style-type', 'line-height'];
      var styleInfo = jQueryCSS($node, properties) || {***REMOVED***;
      styleInfo['font-size'] = parseInt(styleInfo['font-size'], 10);
      return styleInfo;
    ***REMOVED***;

    /**
     * paragraph level style
     *
     * @param {WrappedRange***REMOVED*** rng
     * @param {Object***REMOVED*** styleInfo
     */
    this.stylePara = function (rng, styleInfo) {
      $.each(rng.nodes(dom.isPara, {
        includeAncestor: true
      ***REMOVED***), function (idx, para) {
        $(para).css(styleInfo);
      ***REMOVED***);
    ***REMOVED***;

    /**
     * insert and returns styleNodes on range.
     *
     * @param {WrappedRange***REMOVED*** rng
     * @param {Object***REMOVED*** [options] - options for styleNodes
     * @param {String***REMOVED*** [options.nodeName] - default: `SPAN`
     * @param {Boolean***REMOVED*** [options.expandClosestSibling] - default: `false`
     * @param {Boolean***REMOVED*** [options.onlyPartialContains] - default: `false`
     * @return {Node[]***REMOVED***
     */
    this.styleNodes = function (rng, options) {
      rng = rng.splitText();

      var nodeName = options && options.nodeName || 'SPAN';
      var expandClosestSibling = !!(options && options.expandClosestSibling);
      var onlyPartialContains = !!(options && options.onlyPartialContains);

      if (rng.isCollapsed()) {
        return [rng.insertNode(dom.create(nodeName))];
      ***REMOVED***

      var pred = dom.makePredByNodeName(nodeName);
      var nodes = rng.nodes(dom.isText, {
        fullyContains: true
      ***REMOVED***).map(function (text) {
        return dom.singleChildAncestor(text, pred) || dom.wrap(text, nodeName);
      ***REMOVED***);

      if (expandClosestSibling) {
        if (onlyPartialContains) {
          var nodesInRange = rng.nodes();
          // compose with partial contains predication
          pred = func.and(pred, function (node) {
            return list.contains(nodesInRange, node);
          ***REMOVED***);
        ***REMOVED***

        return nodes.map(function (node) {
          var siblings = dom.withClosestSiblings(node, pred);
          var head = list.head(siblings);
          var tails = list.tail(siblings);
          $.each(tails, function (idx, elem) {
            dom.appendChildNodes(head, elem.childNodes);
            dom.remove(elem);
          ***REMOVED***);
          return list.head(siblings);
        ***REMOVED***);
      ***REMOVED*** else {
        return nodes;
      ***REMOVED***
    ***REMOVED***;

    /**
     * get current style on cursor
     *
     * @param {WrappedRange***REMOVED*** rng
     * @return {Object***REMOVED*** - object contains style properties.
     */
    this.current = function (rng) {
      var $cont = $(dom.isText(rng.sc) ? rng.sc.parentNode : rng.sc);
      var styleInfo = this.fromNode($cont);

      // document.queryCommandState for toggle state
      styleInfo['font-bold'] = document.queryCommandState('bold') ? 'bold' : 'normal';
      styleInfo['font-italic'] = document.queryCommandState('italic') ? 'italic' : 'normal';
      styleInfo['font-underline'] = document.queryCommandState('underline') ? 'underline' : 'normal';
      styleInfo['font-strikethrough'] = document.queryCommandState('strikeThrough') ? 'strikethrough' : 'normal';
      styleInfo['font-superscript'] = document.queryCommandState('superscript') ? 'superscript' : 'normal';
      styleInfo['font-subscript'] = document.queryCommandState('subscript') ? 'subscript' : 'normal';

      // list-style-type to list-style(unordered, ordered)
      if (!rng.isOnList()) {
        styleInfo['list-style'] = 'none';
      ***REMOVED*** else {
        var aOrderedType = ['circle', 'disc', 'disc-leading-zero', 'square'];
        var isUnordered = $.inArray(styleInfo['list-style-type'], aOrderedType) > -1;
        styleInfo['list-style'] = isUnordered ? 'unordered' : 'ordered';
      ***REMOVED***

      var para = dom.ancestor(rng.sc, dom.isPara);
      if (para && para.style['line-height']) {
        styleInfo['line-height'] = para.style.lineHeight;
      ***REMOVED*** else {
        var lineHeight = parseInt(styleInfo['line-height'], 10) / parseInt(styleInfo['font-size'], 10);
        styleInfo['line-height'] = lineHeight.toFixed(1);
      ***REMOVED***

      styleInfo.anchor = rng.isOnAnchor() && dom.ancestor(rng.sc, dom.isAnchor);
      styleInfo.ancestors = dom.listAncestor(rng.sc, dom.isEditable);
      styleInfo.range = rng;

      return styleInfo;
    ***REMOVED***;
  ***REMOVED***;


  /**
   * @class editing.Bullet
   *
   * @alternateClassName Bullet
   */
  var Bullet = function () {
    /**
     * @method insertOrderedList
     *
     * toggle ordered list
     *
     * @type command
     */
    this.insertOrderedList = function () {
      this.toggleList('OL');
    ***REMOVED***;

    /**
     * @method insertUnorderedList
     *
     * toggle unordered list
     *
     * @type command
     */
    this.insertUnorderedList = function () {
      this.toggleList('UL');
    ***REMOVED***;

    /**
     * @method indent
     *
     * indent
     *
     * @type command
     */
    this.indent = function () {
      var self = this;
      var rng = range.create().wrapBodyInlineWithPara();

      var paras = rng.nodes(dom.isPara, { includeAncestor: true ***REMOVED***);
      var clustereds = list.clusterBy(paras, func.peq2('parentNode'));

      $.each(clustereds, function (idx, paras) {
        var head = list.head(paras);
        if (dom.isLi(head)) {
          self.wrapList(paras, head.parentNode.nodeName);
        ***REMOVED*** else {
          $.each(paras, function (idx, para) {
            $(para).css('marginLeft', function (idx, val) {
              return (parseInt(val, 10) || 0) + 25;
            ***REMOVED***);
          ***REMOVED***);
        ***REMOVED***
      ***REMOVED***);

      rng.select();
    ***REMOVED***;

    /**
     * @method outdent
     *
     * outdent
     *
     * @type command
     */
    this.outdent = function () {
      var self = this;
      var rng = range.create().wrapBodyInlineWithPara();

      var paras = rng.nodes(dom.isPara, { includeAncestor: true ***REMOVED***);
      var clustereds = list.clusterBy(paras, func.peq2('parentNode'));

      $.each(clustereds, function (idx, paras) {
        var head = list.head(paras);
        if (dom.isLi(head)) {
          self.releaseList([paras]);
        ***REMOVED*** else {
          $.each(paras, function (idx, para) {
            $(para).css('marginLeft', function (idx, val) {
              val = (parseInt(val, 10) || 0);
              return val > 25 ? val - 25 : '';
            ***REMOVED***);
          ***REMOVED***);
        ***REMOVED***
      ***REMOVED***);

      rng.select();
    ***REMOVED***;

    /**
     * @method toggleList
     *
     * toggle list
     *
     * @param {String***REMOVED*** listName - OL or UL
     */
    this.toggleList = function (listName) {
      var self = this;
      var rng = range.create().wrapBodyInlineWithPara();

      var paras = rng.nodes(dom.isPara, { includeAncestor: true ***REMOVED***);
      var bookmark = rng.paraBookmark(paras);
      var clustereds = list.clusterBy(paras, func.peq2('parentNode'));

      // paragraph to list
      if (list.find(paras, dom.isPurePara)) {
        var wrappedParas = [];
        $.each(clustereds, function (idx, paras) {
          wrappedParas = wrappedParas.concat(self.wrapList(paras, listName));
        ***REMOVED***);
        paras = wrappedParas;
      // list to paragraph or change list style
      ***REMOVED*** else {
        var diffLists = rng.nodes(dom.isList, {
          includeAncestor: true
        ***REMOVED***).filter(function (listNode) {
          return !$.nodeName(listNode, listName);
        ***REMOVED***);

        if (diffLists.length) {
          $.each(diffLists, function (idx, listNode) {
            dom.replace(listNode, listName);
          ***REMOVED***);
        ***REMOVED*** else {
          paras = this.releaseList(clustereds, true);
        ***REMOVED***
      ***REMOVED***

      range.createFromParaBookmark(bookmark, paras).select();
    ***REMOVED***;

    /**
     * @method wrapList
     *
     * @param {Node[]***REMOVED*** paras
     * @param {String***REMOVED*** listName
     * @return {Node[]***REMOVED***
     */
    this.wrapList = function (paras, listName) {
      var head = list.head(paras);
      var last = list.last(paras);

      var prevList = dom.isList(head.previousSibling) && head.previousSibling;
      var nextList = dom.isList(last.nextSibling) && last.nextSibling;

      var listNode = prevList || dom.insertAfter(dom.create(listName || 'UL'), last);

      // P to LI
      paras = paras.map(function (para) {
        return dom.isPurePara(para) ? dom.replace(para, 'LI') : para;
      ***REMOVED***);

      // append to list(<ul>, <ol>)
      dom.appendChildNodes(listNode, paras);

      if (nextList) {
        dom.appendChildNodes(listNode, list.from(nextList.childNodes));
        dom.remove(nextList);
      ***REMOVED***

      return paras;
    ***REMOVED***;

    /**
     * @method releaseList
     *
     * @param {Array[]***REMOVED*** clustereds
     * @param {Boolean***REMOVED*** isEscapseToBody
     * @return {Node[]***REMOVED***
     */
    this.releaseList = function (clustereds, isEscapseToBody) {
      var releasedParas = [];

      $.each(clustereds, function (idx, paras) {
        var head = list.head(paras);
        var last = list.last(paras);

        var headList = isEscapseToBody ? dom.lastAncestor(head, dom.isList) :
                                         head.parentNode;
        var lastList = headList.childNodes.length > 1 ? dom.splitTree(headList, {
          node: last.parentNode,
          offset: dom.position(last) + 1
        ***REMOVED***, {
          isSkipPaddingBlankHTML: true
        ***REMOVED***) : null;

        var middleList = dom.splitTree(headList, {
          node: head.parentNode,
          offset: dom.position(head)
        ***REMOVED***, {
          isSkipPaddingBlankHTML: true
        ***REMOVED***);

        paras = isEscapseToBody ? dom.listDescendant(middleList, dom.isLi) :
                                  list.from(middleList.childNodes).filter(dom.isLi);

        // LI to P
        if (isEscapseToBody || !dom.isList(headList.parentNode)) {
          paras = paras.map(function (para) {
            return dom.replace(para, 'P');
          ***REMOVED***);
        ***REMOVED***

        $.each(list.from(paras).reverse(), function (idx, para) {
          dom.insertAfter(para, headList);
        ***REMOVED***);

        // remove empty lists
        var rootLists = list.compact([headList, middleList, lastList]);
        $.each(rootLists, function (idx, rootList) {
          var listNodes = [rootList].concat(dom.listDescendant(rootList, dom.isList));
          $.each(listNodes.reverse(), function (idx, listNode) {
            if (!dom.nodeLength(listNode)) {
              dom.remove(listNode, true);
            ***REMOVED***
          ***REMOVED***);
        ***REMOVED***);

        releasedParas = releasedParas.concat(paras);
      ***REMOVED***);

      return releasedParas;
    ***REMOVED***;
  ***REMOVED***;


  /**
   * @class editing.Typing
   *
   * Typing
   *
   */
  var Typing = function () {

    // a Bullet instance to toggle lists off
    var bullet = new Bullet();

    /**
     * insert tab
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {WrappedRange***REMOVED*** rng
     * @param {Number***REMOVED*** tabsize
     */
    this.insertTab = function ($editable, rng, tabsize) {
      var tab = dom.createText(new Array(tabsize + 1).join(dom.NBSP_CHAR));
      rng = rng.deleteContents();
      rng.insertNode(tab, true);

      rng = range.create(tab, tabsize);
      rng.select();
    ***REMOVED***;

    /**
     * insert paragraph
     */
    this.insertParagraph = function () {
      var rng = range.create();

      // deleteContents on range.
      rng = rng.deleteContents();

      // Wrap range if it needs to be wrapped by paragraph
      rng = rng.wrapBodyInlineWithPara();

      // finding paragraph
      var splitRoot = dom.ancestor(rng.sc, dom.isPara);

      var nextPara;
      // on paragraph: split paragraph
      if (splitRoot) {
        // if it is an empty line with li
        if (dom.isEmpty(splitRoot) && dom.isLi(splitRoot)) {
          // disable UL/OL and escape!
          bullet.toggleList(splitRoot.parentNode.nodeName);
          return;
        // if new line has content (not a line break)
        ***REMOVED*** else {
          nextPara = dom.splitTree(splitRoot, rng.getStartPoint());

          var emptyAnchors = dom.listDescendant(splitRoot, dom.isEmptyAnchor);
          emptyAnchors = emptyAnchors.concat(dom.listDescendant(nextPara, dom.isEmptyAnchor));

          $.each(emptyAnchors, function (idx, anchor) {
            dom.remove(anchor);
          ***REMOVED***);
        ***REMOVED***
      // no paragraph: insert empty paragraph
      ***REMOVED*** else {
        var next = rng.sc.childNodes[rng.so];
        nextPara = $(dom.emptyPara)[0];
        if (next) {
          rng.sc.insertBefore(nextPara, next);
        ***REMOVED*** else {
          rng.sc.appendChild(nextPara);
        ***REMOVED***
      ***REMOVED***

      range.create(nextPara, 0).normalize().select();

    ***REMOVED***;

  ***REMOVED***;

  /**
   * @class editing.Table
   *
   * Table
   *
   */
  var Table = function () {
    /**
     * handle tab key
     *
     * @param {WrappedRange***REMOVED*** rng
     * @param {Boolean***REMOVED*** isShift
     */
    this.tab = function (rng, isShift) {
      var cell = dom.ancestor(rng.commonAncestor(), dom.isCell);
      var table = dom.ancestor(cell, dom.isTable);
      var cells = dom.listDescendant(table, dom.isCell);

      var nextCell = list[isShift ? 'prev' : 'next'](cells, cell);
      if (nextCell) {
        range.create(nextCell, 0).select();
      ***REMOVED***
    ***REMOVED***;

    /**
     * create empty table element
     *
     * @param {Number***REMOVED*** rowCount
     * @param {Number***REMOVED*** colCount
     * @return {Node***REMOVED***
     */
    this.createTable = function (colCount, rowCount) {
      var tds = [], tdHTML;
      for (var idxCol = 0; idxCol < colCount; idxCol++) {
        tds.push('<td>' + dom.blank + '</td>');
      ***REMOVED***
      tdHTML = tds.join('');

      var trs = [], trHTML;
      for (var idxRow = 0; idxRow < rowCount; idxRow++) {
        trs.push('<tr>' + tdHTML + '</tr>');
      ***REMOVED***
      trHTML = trs.join('');
      return $('<table class="table table-bordered">' + trHTML + '</table>')[0];
    ***REMOVED***;
  ***REMOVED***;


  var KEY_BOGUS = 'bogus';

  /**
   * @class editing.Editor
   *
   * Editor
   *
   */
  var Editor = function (handler) {

    var self = this;
    var style = new Style();
    var table = new Table();
    var typing = new Typing();
    var bullet = new Bullet();

    /**
     * @method createRange
     *
     * create range
     *
     * @param {jQuery***REMOVED*** $editable
     * @return {WrappedRange***REMOVED***
     */
    this.createRange = function ($editable) {
      this.focus($editable);
      return range.create();
    ***REMOVED***;

    /**
     * @method saveRange
     *
     * save current range
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {Boolean***REMOVED*** [thenCollapse=false]
     */
    this.saveRange = function ($editable, thenCollapse) {
      this.focus($editable);
      $editable.data('range', range.create());
      if (thenCollapse) {
        range.create().collapse().select();
      ***REMOVED***
    ***REMOVED***;

    /**
     * @method saveRange
     *
     * save current node list to $editable.data('childNodes')
     *
     * @param {jQuery***REMOVED*** $editable
     */
    this.saveNode = function ($editable) {
      // copy child node reference
      var copy = [];
      for (var key  = 0, len = $editable[0].childNodes.length; key < len; key++) {
        copy.push($editable[0].childNodes[key]);
      ***REMOVED***
      $editable.data('childNodes', copy);
    ***REMOVED***;

    /**
     * @method restoreRange
     *
     * restore lately range
     *
     * @param {jQuery***REMOVED*** $editable
     */
    this.restoreRange = function ($editable) {
      var rng = $editable.data('range');
      if (rng) {
        rng.select();
        this.focus($editable);
      ***REMOVED***
    ***REMOVED***;

    /**
     * @method restoreNode
     *
     * restore lately node list
     *
     * @param {jQuery***REMOVED*** $editable
     */
    this.restoreNode = function ($editable) {
      $editable.html('');
      var child = $editable.data('childNodes');
      for (var index = 0, len = child.length; index < len; index++) {
        $editable[0].appendChild(child[index]);
      ***REMOVED***
    ***REMOVED***;

    /**
     * @method currentStyle
     *
     * current style
     *
     * @param {Node***REMOVED*** target
     * @return {Object|Boolean***REMOVED*** unfocus
     */
    this.currentStyle = function (target) {
      var rng = range.create();
      var styleInfo =  rng && rng.isOnEditable() ? style.current(rng.normalize()) : {***REMOVED***;
      if (dom.isImg(target)) {
        styleInfo.image = target;
      ***REMOVED***
      return styleInfo;
    ***REMOVED***;

    /**
     * style from node
     *
     * @param {jQuery***REMOVED*** $node
     * @return {Object***REMOVED***
     */
    this.styleFromNode = function ($node) {
      return style.fromNode($node);
    ***REMOVED***;

    var triggerOnBeforeChange = function ($editable) {
      var $holder = dom.makeLayoutInfo($editable).holder();
      handler.bindCustomEvent(
        $holder, $editable.data('callbacks'), 'before.command'
      )($editable.html(), $editable);
    ***REMOVED***;

    var triggerOnChange = function ($editable) {
      var $holder = dom.makeLayoutInfo($editable).holder();
      handler.bindCustomEvent(
        $holder, $editable.data('callbacks'), 'change'
      )($editable.html(), $editable);
    ***REMOVED***;

    /**
     * @method undo
     * undo
     * @param {jQuery***REMOVED*** $editable
     */
    this.undo = function ($editable) {
      triggerOnBeforeChange($editable);
      $editable.data('NoteHistory').undo();
      triggerOnChange($editable);
    ***REMOVED***;

    /**
     * @method redo
     * redo
     * @param {jQuery***REMOVED*** $editable
     */
    this.redo = function ($editable) {
      triggerOnBeforeChange($editable);
      $editable.data('NoteHistory').redo();
      triggerOnChange($editable);
    ***REMOVED***;

    /**
     * @method beforeCommand
     * before command
     * @param {jQuery***REMOVED*** $editable
     */
    var beforeCommand = this.beforeCommand = function ($editable) {
      triggerOnBeforeChange($editable);
      // keep focus on editable before command execution
      self.focus($editable);
    ***REMOVED***;

    /**
     * @method afterCommand
     * after command
     * @param {jQuery***REMOVED*** $editable
     * @param {Boolean***REMOVED*** isPreventTrigger
     */
    var afterCommand = this.afterCommand = function ($editable, isPreventTrigger) {
      $editable.data('NoteHistory').recordUndo();
      if (!isPreventTrigger) {
        triggerOnChange($editable);
      ***REMOVED***
    ***REMOVED***;

    /**
     * @method bold
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method italic
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method underline
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method strikethrough
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method formatBlock
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method superscript
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method subscript
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method justifyLeft
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method justifyCenter
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method justifyRight
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method justifyFull
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method formatBlock
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method removeFormat
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method backColor
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method foreColor
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method insertHorizontalRule
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /**
     * @method fontName
     *
     * change font name
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {Mixed***REMOVED*** value
     */

    /* jshint ignore:start */
    // native commands(with execCommand), generate function for execCommand
    var commands = ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript',
                    'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull',
                    'formatBlock', 'removeFormat',
                    'backColor', 'foreColor', 'fontName'];

    for (var idx = 0, len = commands.length; idx < len; idx ++) {
      this[commands[idx]] = (function (sCmd) {
        return function ($editable, value) {
          beforeCommand($editable);

          document.execCommand(sCmd, false, value);

          afterCommand($editable, true);
        ***REMOVED***;
      ***REMOVED***)(commands[idx]);
    ***REMOVED***
    /* jshint ignore:end */

    /**
     * @method tab
     *
     * handle tab key
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {Object***REMOVED*** options
     */
    this.tab = function ($editable, options) {
      var rng = this.createRange($editable);
      if (rng.isCollapsed() && rng.isOnCell()) {
        table.tab(rng);
      ***REMOVED*** else {
        beforeCommand($editable);
        typing.insertTab($editable, rng, options.tabsize);
        afterCommand($editable);
      ***REMOVED***
    ***REMOVED***;

    /**
     * @method untab
     *
     * handle shift+tab key
     *
     */
    this.untab = function ($editable) {
      var rng = this.createRange($editable);
      if (rng.isCollapsed() && rng.isOnCell()) {
        table.tab(rng, true);
      ***REMOVED***
    ***REMOVED***;

    /**
     * @method insertParagraph
     *
     * insert paragraph
     *
     * @param {Node***REMOVED*** $editable
     */
    this.insertParagraph = function ($editable) {
      beforeCommand($editable);
      typing.insertParagraph($editable);
      afterCommand($editable);
    ***REMOVED***;

    /**
     * @method insertOrderedList
     *
     * @param {jQuery***REMOVED*** $editable
     */
    this.insertOrderedList = function ($editable) {
      beforeCommand($editable);
      bullet.insertOrderedList($editable);
      afterCommand($editable);
    ***REMOVED***;

    /**
     * @param {jQuery***REMOVED*** $editable
     */
    this.insertUnorderedList = function ($editable) {
      beforeCommand($editable);
      bullet.insertUnorderedList($editable);
      afterCommand($editable);
    ***REMOVED***;

    /**
     * @param {jQuery***REMOVED*** $editable
     */
    this.indent = function ($editable) {
      beforeCommand($editable);
      bullet.indent($editable);
      afterCommand($editable);
    ***REMOVED***;

    /**
     * @param {jQuery***REMOVED*** $editable
     */
    this.outdent = function ($editable) {
      beforeCommand($editable);
      bullet.outdent($editable);
      afterCommand($editable);
    ***REMOVED***;

    /**
     * insert image
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {String***REMOVED*** sUrl
     */
    this.insertImage = function ($editable, sUrl, filename) {
      async.createImage(sUrl, filename).then(function ($image) {
        beforeCommand($editable);
        $image.css({
          display: '',
          width: Math.min($editable.width(), $image.width())
        ***REMOVED***);
        range.create().insertNode($image[0]);
        range.createFromNodeAfter($image[0]).select();
        afterCommand($editable);
      ***REMOVED***).fail(function () {
        var $holder = dom.makeLayoutInfo($editable).holder();
        handler.bindCustomEvent(
          $holder, $editable.data('callbacks'), 'image.upload.error'
        )();
      ***REMOVED***);
    ***REMOVED***;

    /**
     * @method insertNode
     * insert node
     * @param {Node***REMOVED*** $editable
     * @param {Node***REMOVED*** node
     */
    this.insertNode = function ($editable, node) {
      beforeCommand($editable);
      range.create().insertNode(node);
      range.createFromNodeAfter(node).select();
      afterCommand($editable);
    ***REMOVED***;

    /**
     * insert text
     * @param {Node***REMOVED*** $editable
     * @param {String***REMOVED*** text
     */
    this.insertText = function ($editable, text) {
      beforeCommand($editable);
      var textNode = range.create().insertNode(dom.createText(text));
      range.create(textNode, dom.nodeLength(textNode)).select();
      afterCommand($editable);
    ***REMOVED***;

    /**
     * paste HTML
     * @param {Node***REMOVED*** $editable
     * @param {String***REMOVED*** markup
     */
    this.pasteHTML = function ($editable, markup) {
      beforeCommand($editable);
      var contents = range.create().pasteHTML(markup);
      range.createFromNodeAfter(list.last(contents)).select();
      afterCommand($editable);
    ***REMOVED***;

    /**
     * formatBlock
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {String***REMOVED*** tagName
     */
    this.formatBlock = function ($editable, tagName) {
      beforeCommand($editable);
      // [workaround] for MSIE, IE need `<`
      tagName = agent.isMSIE ? '<' + tagName + '>' : tagName;
      document.execCommand('FormatBlock', false, tagName);
      afterCommand($editable);
    ***REMOVED***;

    this.formatPara = function ($editable) {
      beforeCommand($editable);
      this.formatBlock($editable, 'P');
      afterCommand($editable);
    ***REMOVED***;

    /* jshint ignore:start */
    for (var idx = 1; idx <= 6; idx ++) {
      this['formatH' + idx] = function (idx) {
        return function ($editable) {
          this.formatBlock($editable, 'H' + idx);
        ***REMOVED***;
      ***REMOVED***(idx);
    ***REMOVED***;
    /* jshint ignore:end */

    /**
     * fontSize
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {String***REMOVED*** value - px
     */
    this.fontSize = function ($editable, value) {
      var rng = range.create();

      if (rng.isCollapsed()) {
        var spans = style.styleNodes(rng);
        var firstSpan = list.head(spans);

        $(spans).css({
          'font-size': value + 'px'
        ***REMOVED***);

        // [workaround] added styled bogus span for style
        //  - also bogus character needed for cursor position
        if (firstSpan && !dom.nodeLength(firstSpan)) {
          firstSpan.innerHTML = dom.ZERO_WIDTH_NBSP_CHAR;
          range.createFromNodeAfter(firstSpan.firstChild).select();
          $editable.data(KEY_BOGUS, firstSpan);
        ***REMOVED***
      ***REMOVED*** else {
        beforeCommand($editable);
        $(style.styleNodes(rng)).css({
          'font-size': value + 'px'
        ***REMOVED***);
        afterCommand($editable);
      ***REMOVED***
    ***REMOVED***;

    /**
     * insert horizontal rule
     * @param {jQuery***REMOVED*** $editable
     */
    this.insertHorizontalRule = function ($editable) {
      beforeCommand($editable);

      var rng = range.create();
      var hrNode = rng.insertNode($('<HR/>')[0]);
      if (hrNode.nextSibling) {
        range.create(hrNode.nextSibling, 0).normalize().select();
      ***REMOVED***

      afterCommand($editable);
    ***REMOVED***;

    /**
     * remove bogus node and character
     */
    this.removeBogus = function ($editable) {
      var bogusNode = $editable.data(KEY_BOGUS);
      if (!bogusNode) {
        return;
      ***REMOVED***

      var textNode = list.find(list.from(bogusNode.childNodes), dom.isText);

      var bogusCharIdx = textNode.nodeValue.indexOf(dom.ZERO_WIDTH_NBSP_CHAR);
      if (bogusCharIdx !== -1) {
        textNode.deleteData(bogusCharIdx, 1);
      ***REMOVED***

      if (dom.isEmpty(bogusNode)) {
        dom.remove(bogusNode);
      ***REMOVED***

      $editable.removeData(KEY_BOGUS);
    ***REMOVED***;

    /**
     * lineHeight
     * @param {jQuery***REMOVED*** $editable
     * @param {String***REMOVED*** value
     */
    this.lineHeight = function ($editable, value) {
      beforeCommand($editable);
      style.stylePara(range.create(), {
        lineHeight: value
      ***REMOVED***);
      afterCommand($editable);
    ***REMOVED***;

    /**
     * unlink
     *
     * @type command
     *
     * @param {jQuery***REMOVED*** $editable
     */
    this.unlink = function ($editable) {
      var rng = this.createRange($editable);
      if (rng.isOnAnchor()) {
        var anchor = dom.ancestor(rng.sc, dom.isAnchor);
        rng = range.createFromNode(anchor);
        rng.select();

        beforeCommand($editable);
        document.execCommand('unlink');
        afterCommand($editable);
      ***REMOVED***
    ***REMOVED***;

    /**
     * create link (command)
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {Object***REMOVED*** linkInfo
     * @param {Object***REMOVED*** options
     */
    this.createLink = function ($editable, linkInfo, options) {
      var linkUrl = linkInfo.url;
      var linkText = linkInfo.text;
      var isNewWindow = linkInfo.isNewWindow;
      var rng = linkInfo.range || this.createRange($editable);
      var isTextChanged = rng.toString() !== linkText;

      options = options || dom.makeLayoutInfo($editable).editor().data('options');

      beforeCommand($editable);

      if (options.onCreateLink) {
        linkUrl = options.onCreateLink(linkUrl);
      ***REMOVED***

      var anchors = [];
      if (isTextChanged) {
        // Create a new link when text changed.
        var anchor = rng.insertNode($('<A>' + linkText + '</A>')[0]);
        anchors.push(anchor);
      ***REMOVED*** else {
        anchors = style.styleNodes(rng, {
          nodeName: 'A',
          expandClosestSibling: true,
          onlyPartialContains: true
        ***REMOVED***);
      ***REMOVED***

      $.each(anchors, function (idx, anchor) {
        $(anchor).attr('href', linkUrl);
        if (isNewWindow) {
          $(anchor).attr('target', '_blank');
        ***REMOVED*** else {
          $(anchor).removeAttr('target');
        ***REMOVED***
      ***REMOVED***);

      var startRange = range.createFromNodeBefore(list.head(anchors));
      var startPoint = startRange.getStartPoint();
      var endRange = range.createFromNodeAfter(list.last(anchors));
      var endPoint = endRange.getEndPoint();

      range.create(
        startPoint.node,
        startPoint.offset,
        endPoint.node,
        endPoint.offset
      ).select();

      afterCommand($editable);
    ***REMOVED***;

    /**
     * returns link info
     *
     * @return {Object***REMOVED***
     * @return {WrappedRange***REMOVED*** return.range
     * @return {String***REMOVED*** return.text
     * @return {Boolean***REMOVED*** [return.isNewWindow=true]
     * @return {String***REMOVED*** [return.url=""]
     */
    this.getLinkInfo = function ($editable) {
      this.focus($editable);

      var rng = range.create().expand(dom.isAnchor);

      // Get the first anchor on range(for edit).
      var $anchor = $(list.head(rng.nodes(dom.isAnchor)));

      return {
        range: rng,
        text: rng.toString(),
        isNewWindow: $anchor.length ? $anchor.attr('target') === '_blank' : false,
        url: $anchor.length ? $anchor.attr('href') : ''
      ***REMOVED***;
    ***REMOVED***;

    /**
     * setting color
     *
     * @param {Node***REMOVED*** $editable
     * @param {Object***REMOVED*** sObjColor  color code
     * @param {String***REMOVED*** sObjColor.foreColor foreground color
     * @param {String***REMOVED*** sObjColor.backColor background color
     */
    this.color = function ($editable, sObjColor) {
      var oColor = JSON.parse(sObjColor);
      var foreColor = oColor.foreColor, backColor = oColor.backColor;

      beforeCommand($editable);

      if (foreColor) { document.execCommand('foreColor', false, foreColor); ***REMOVED***
      if (backColor) { document.execCommand('backColor', false, backColor); ***REMOVED***

      afterCommand($editable);
    ***REMOVED***;

    /**
     * insert Table
     *
     * @param {Node***REMOVED*** $editable
     * @param {String***REMOVED*** sDim dimension of table (ex : "5x5")
     */
    this.insertTable = function ($editable, sDim) {
      var dimension = sDim.split('x');
      beforeCommand($editable);

      var rng = range.create().deleteContents();
      rng.insertNode(table.createTable(dimension[0], dimension[1]));
      afterCommand($editable);
    ***REMOVED***;

    /**
     * float me
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {String***REMOVED*** value
     * @param {jQuery***REMOVED*** $target
     */
    this.floatMe = function ($editable, value, $target) {
      beforeCommand($editable);
      // bootstrap
      $target.removeClass('pull-left pull-right');
      if (value && value !== 'none') {
        $target.addClass('pull-' + value);
      ***REMOVED***

      // fallback for non-bootstrap
      $target.css('float', value);
      afterCommand($editable);
    ***REMOVED***;

    /**
     * change image shape
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {String***REMOVED*** value css class
     * @param {Node***REMOVED*** $target
     */
    this.imageShape = function ($editable, value, $target) {
      beforeCommand($editable);

      $target.removeClass('img-rounded img-circle img-thumbnail');

      if (value) {
        $target.addClass(value);
      ***REMOVED***

      afterCommand($editable);
    ***REMOVED***;

    /**
     * resize overlay element
     * @param {jQuery***REMOVED*** $editable
     * @param {String***REMOVED*** value
     * @param {jQuery***REMOVED*** $target - target element
     */
    this.resize = function ($editable, value, $target) {
      beforeCommand($editable);

      $target.css({
        width: value * 100 + '%',
        height: ''
      ***REMOVED***);

      afterCommand($editable);
    ***REMOVED***;

    /**
     * @param {Position***REMOVED*** pos
     * @param {jQuery***REMOVED*** $target - target element
     * @param {Boolean***REMOVED*** [bKeepRatio] - keep ratio
     */
    this.resizeTo = function (pos, $target, bKeepRatio) {
      var imageSize;
      if (bKeepRatio) {
        var newRatio = pos.y / pos.x;
        var ratio = $target.data('ratio');
        imageSize = {
          width: ratio > newRatio ? pos.x : pos.y / ratio,
          height: ratio > newRatio ? pos.x * ratio : pos.y
        ***REMOVED***;
      ***REMOVED*** else {
        imageSize = {
          width: pos.x,
          height: pos.y
        ***REMOVED***;
      ***REMOVED***

      $target.css(imageSize);
    ***REMOVED***;

    /**
     * remove media object
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {String***REMOVED*** value - dummy argument (for keep interface)
     * @param {jQuery***REMOVED*** $target - target element
     */
    this.removeMedia = function ($editable, value, $target) {
      beforeCommand($editable);
      $target.detach();

      handler.bindCustomEvent(
        $(), $editable.data('callbacks'), 'media.delete'
      )($target, $editable);

      afterCommand($editable);
    ***REMOVED***;

    /**
     * set focus
     *
     * @param $editable
     */
    this.focus = function ($editable) {
      $editable.focus();

      // [workaround] for firefox bug http://goo.gl/lVfAaI
      if (agent.isFF && !range.create().isOnEditable()) {
        range.createFromNode($editable[0])
             .normalize()
             .collapse()
             .select();
      ***REMOVED***
    ***REMOVED***;

    /**
     * returns whether contents is empty or not.
     *
     * @param {jQuery***REMOVED*** $editable
     * @return {Boolean***REMOVED***
     */
    this.isEmpty = function ($editable) {
      return dom.isEmpty($editable[0]) || dom.emptyPara === $editable.html();
    ***REMOVED***;
  ***REMOVED***;

  /**
   * @class module.Button
   *
   * Button
   */
  var Button = function () {
    /**
     * update button status
     *
     * @param {jQuery***REMOVED*** $container
     * @param {Object***REMOVED*** styleInfo
     */
    this.update = function ($container, styleInfo) {
      /**
       * handle dropdown's check mark (for fontname, fontsize, lineHeight).
       * @param {jQuery***REMOVED*** $btn
       * @param {Number***REMOVED*** value
       */
      var checkDropdownMenu = function ($btn, value) {
        $btn.find('.dropdown-menu li a').each(function () {
          // always compare string to avoid creating another func.
          var isChecked = ($(this).data('value') + '') === (value + '');
          this.className = isChecked ? 'checked' : '';
        ***REMOVED***);
      ***REMOVED***;

      /**
       * update button state(active or not).
       *
       * @private
       * @param {String***REMOVED*** selector
       * @param {Function***REMOVED*** pred
       */
      var btnState = function (selector, pred) {
        var $btn = $container.find(selector);
        $btn.toggleClass('active', pred());
      ***REMOVED***;

      if (styleInfo.image) {
        var $img = $(styleInfo.image);

        btnState('button[data-event="imageShape"][data-value="img-rounded"]', function () {
          return $img.hasClass('img-rounded');
        ***REMOVED***);
        btnState('button[data-event="imageShape"][data-value="img-circle"]', function () {
          return $img.hasClass('img-circle');
        ***REMOVED***);
        btnState('button[data-event="imageShape"][data-value="img-thumbnail"]', function () {
          return $img.hasClass('img-thumbnail');
        ***REMOVED***);
        btnState('button[data-event="imageShape"]:not([data-value])', function () {
          return !$img.is('.img-rounded, .img-circle, .img-thumbnail');
        ***REMOVED***);

        var imgFloat = $img.css('float');
        btnState('button[data-event="floatMe"][data-value="left"]', function () {
          return imgFloat === 'left';
        ***REMOVED***);
        btnState('button[data-event="floatMe"][data-value="right"]', function () {
          return imgFloat === 'right';
        ***REMOVED***);
        btnState('button[data-event="floatMe"][data-value="none"]', function () {
          return imgFloat !== 'left' && imgFloat !== 'right';
        ***REMOVED***);

        var style = $img.attr('style');
        btnState('button[data-event="resize"][data-value="1"]', function () {
          return !!/(^|\s)(max-)?width\s*:\s*100%/.test(style);
        ***REMOVED***);
        btnState('button[data-event="resize"][data-value="0.5"]', function () {
          return !!/(^|\s)(max-)?width\s*:\s*50%/.test(style);
        ***REMOVED***);
        btnState('button[data-event="resize"][data-value="0.25"]', function () {
          return !!/(^|\s)(max-)?width\s*:\s*25%/.test(style);
        ***REMOVED***);
        return;
      ***REMOVED***

      // fontname
      var $fontname = $container.find('.note-fontname');
      if ($fontname.length) {
        var selectedFont = styleInfo['font-family'];
        if (!!selectedFont) {

          var list = selectedFont.split(',');
          for (var i = 0, len = list.length; i < len; i++) {
            selectedFont = list[i].replace(/[\'\"]/g, '').replace(/\s+$/, '').replace(/^\s+/, '');
            if (agent.isFontInstalled(selectedFont)) {
              break;
            ***REMOVED***
          ***REMOVED***
          
          $fontname.find('.note-current-fontname').text(selectedFont);
          checkDropdownMenu($fontname, selectedFont);

        ***REMOVED***
      ***REMOVED***

      // fontsize
      var $fontsize = $container.find('.note-fontsize');
      $fontsize.find('.note-current-fontsize').text(styleInfo['font-size']);
      checkDropdownMenu($fontsize, parseFloat(styleInfo['font-size']));

      // lineheight
      var $lineHeight = $container.find('.note-height');
      checkDropdownMenu($lineHeight, parseFloat(styleInfo['line-height']));

      btnState('button[data-event="bold"]', function () {
        return styleInfo['font-bold'] === 'bold';
      ***REMOVED***);
      btnState('button[data-event="italic"]', function () {
        return styleInfo['font-italic'] === 'italic';
      ***REMOVED***);
      btnState('button[data-event="underline"]', function () {
        return styleInfo['font-underline'] === 'underline';
      ***REMOVED***);
      btnState('button[data-event="strikethrough"]', function () {
        return styleInfo['font-strikethrough'] === 'strikethrough';
      ***REMOVED***);
      btnState('button[data-event="superscript"]', function () {
        return styleInfo['font-superscript'] === 'superscript';
      ***REMOVED***);
      btnState('button[data-event="subscript"]', function () {
        return styleInfo['font-subscript'] === 'subscript';
      ***REMOVED***);
      btnState('button[data-event="justifyLeft"]', function () {
        return styleInfo['text-align'] === 'left' || styleInfo['text-align'] === 'start';
      ***REMOVED***);
      btnState('button[data-event="justifyCenter"]', function () {
        return styleInfo['text-align'] === 'center';
      ***REMOVED***);
      btnState('button[data-event="justifyRight"]', function () {
        return styleInfo['text-align'] === 'right';
      ***REMOVED***);
      btnState('button[data-event="justifyFull"]', function () {
        return styleInfo['text-align'] === 'justify';
      ***REMOVED***);
      btnState('button[data-event="insertUnorderedList"]', function () {
        return styleInfo['list-style'] === 'unordered';
      ***REMOVED***);
      btnState('button[data-event="insertOrderedList"]', function () {
        return styleInfo['list-style'] === 'ordered';
      ***REMOVED***);
    ***REMOVED***;

    /**
     * update recent color
     *
     * @param {Node***REMOVED*** button
     * @param {String***REMOVED*** eventName
     * @param {Mixed***REMOVED*** value
     */
    this.updateRecentColor = function (button, eventName, value) {
      var $color = $(button).closest('.note-color');
      var $recentColor = $color.find('.note-recent-color');
      var colorInfo = JSON.parse($recentColor.attr('data-value'));
      colorInfo[eventName] = value;
      $recentColor.attr('data-value', JSON.stringify(colorInfo));
      var sKey = eventName === 'backColor' ? 'background-color' : 'color';
      $recentColor.find('i').css(sKey, value);
    ***REMOVED***;
  ***REMOVED***;

  /**
   * @class module.Toolbar
   *
   * Toolbar
   */
  var Toolbar = function () {
    var button = new Button();

    this.update = function ($toolbar, styleInfo) {
      button.update($toolbar, styleInfo);
    ***REMOVED***;

    /**
     * @param {Node***REMOVED*** button
     * @param {String***REMOVED*** eventName
     * @param {String***REMOVED*** value
     */
    this.updateRecentColor = function (buttonNode, eventName, value) {
      button.updateRecentColor(buttonNode, eventName, value);
    ***REMOVED***;

    /**
     * activate buttons exclude codeview
     * @param {jQuery***REMOVED*** $toolbar
     */
    this.activate = function ($toolbar) {
      $toolbar.find('button')
              .not('button[data-event="codeview"]')
              .removeClass('disabled');
    ***REMOVED***;

    /**
     * deactivate buttons exclude codeview
     * @param {jQuery***REMOVED*** $toolbar
     */
    this.deactivate = function ($toolbar) {
      $toolbar.find('button')
              .not('button[data-event="codeview"]')
              .addClass('disabled');
    ***REMOVED***;

    /**
     * @param {jQuery***REMOVED*** $container
     * @param {Boolean***REMOVED*** [bFullscreen=false]
     */
    this.updateFullscreen = function ($container, bFullscreen) {
      var $btn = $container.find('button[data-event="fullscreen"]');
      $btn.toggleClass('active', bFullscreen);
    ***REMOVED***;

    /**
     * @param {jQuery***REMOVED*** $container
     * @param {Boolean***REMOVED*** [isCodeview=false]
     */
    this.updateCodeview = function ($container, isCodeview) {
      var $btn = $container.find('button[data-event="codeview"]');
      $btn.toggleClass('active', isCodeview);

      if (isCodeview) {
        this.deactivate($container);
      ***REMOVED*** else {
        this.activate($container);
      ***REMOVED***
    ***REMOVED***;

    /**
     * get button in toolbar 
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {String***REMOVED*** name
     * @return {jQuery***REMOVED***
     */
    this.get = function ($editable, name) {
      var $toolbar = dom.makeLayoutInfo($editable).toolbar();

      return $toolbar.find('[data-name=' + name + ']');
    ***REMOVED***;

    /**
     * set button state
     * @param {jQuery***REMOVED*** $editable
     * @param {String***REMOVED*** name
     * @param {Boolean***REMOVED*** [isActive=true]
     */
    this.setButtonState = function ($editable, name, isActive) {
      isActive = (isActive === false) ? false : true;

      var $button = this.get($editable, name);
      $button.toggleClass('active', isActive);
    ***REMOVED***;
  ***REMOVED***;

  var EDITABLE_PADDING = 24;

  var Statusbar = function () {
    var $document = $(document);

    this.attach = function (layoutInfo, options) {
      if (!options.disableResizeEditor) {
        layoutInfo.statusbar().on('mousedown', hStatusbarMousedown);
      ***REMOVED***
    ***REMOVED***;

    /**
     * `mousedown` event handler on statusbar
     *
     * @param {MouseEvent***REMOVED*** event
     */
    var hStatusbarMousedown = function (event) {
      event.preventDefault();
      event.stopPropagation();

      var $editable = dom.makeLayoutInfo(event.target).editable();
      var editableTop = $editable.offset().top - $document.scrollTop();

      var layoutInfo = dom.makeLayoutInfo(event.currentTarget || event.target);
      var options = layoutInfo.editor().data('options');

      $document.on('mousemove', function (event) {
        var nHeight = event.clientY - (editableTop + EDITABLE_PADDING);

        nHeight = (options.minHeight > 0) ? Math.max(nHeight, options.minHeight) : nHeight;
        nHeight = (options.maxHeight > 0) ? Math.min(nHeight, options.maxHeight) : nHeight;

        $editable.height(nHeight);
      ***REMOVED***).one('mouseup', function () {
        $document.off('mousemove');
      ***REMOVED***);
    ***REMOVED***;
  ***REMOVED***;

  /**
   * @class module.Popover
   *
   * Popover (http://getbootstrap.com/javascript/#popovers)
   *
   */
  var Popover = function () {
    var button = new Button();

    /**
     * returns position from placeholder
     *
     * @private
     * @param {Node***REMOVED*** placeholder
     * @param {Object***REMOVED*** options
     * @param {Boolean***REMOVED*** options.isAirMode
     * @return {Position***REMOVED***
     */
    var posFromPlaceholder = function (placeholder, options) {
      var isAirMode = options && options.isAirMode;
      var isLeftTop = options && options.isLeftTop;

      var $placeholder = $(placeholder);
      var pos = isAirMode ? $placeholder.offset() : $placeholder.position();
      var height = isLeftTop ? 0 : $placeholder.outerHeight(true); // include margin

      // popover below placeholder.
      return {
        left: pos.left,
        top: pos.top + height
      ***REMOVED***;
    ***REMOVED***;

    /**
     * show popover
     *
     * @private
     * @param {jQuery***REMOVED*** popover
     * @param {Position***REMOVED*** pos
     */
    var showPopover = function ($popover, pos) {
      $popover.css({
        display: 'block',
        left: pos.left,
        top: pos.top
      ***REMOVED***);
    ***REMOVED***;

    var PX_POPOVER_ARROW_OFFSET_X = 20;

    /**
     * update current state
     * @param {jQuery***REMOVED*** $popover - popover container
     * @param {Object***REMOVED*** styleInfo - style object
     * @param {Boolean***REMOVED*** isAirMode
     */
    this.update = function ($popover, styleInfo, isAirMode) {
      button.update($popover, styleInfo);

      var $linkPopover = $popover.find('.note-link-popover');
      if (styleInfo.anchor) {
        var $anchor = $linkPopover.find('a');
        var href = $(styleInfo.anchor).attr('href');
        var target = $(styleInfo.anchor).attr('target');
        $anchor.attr('href', href).html(href);
        if (!target) {
          $anchor.removeAttr('target');
        ***REMOVED*** else {
          $anchor.attr('target', '_blank');
        ***REMOVED***
        showPopover($linkPopover, posFromPlaceholder(styleInfo.anchor, {
          isAirMode: isAirMode
        ***REMOVED***));
      ***REMOVED*** else {
        $linkPopover.hide();
      ***REMOVED***

      var $imagePopover = $popover.find('.note-image-popover');
      if (styleInfo.image) {
        showPopover($imagePopover, posFromPlaceholder(styleInfo.image, {
          isAirMode: isAirMode,
          isLeftTop: true
        ***REMOVED***));
      ***REMOVED*** else {
        $imagePopover.hide();
      ***REMOVED***

      var $airPopover = $popover.find('.note-air-popover');
      if (isAirMode && styleInfo.range && !styleInfo.range.isCollapsed()) {
        var rect = list.last(styleInfo.range.getClientRects());
        if (rect) {
          var bnd = func.rect2bnd(rect);
          showPopover($airPopover, {
            left: Math.max(bnd.left + bnd.width / 2 - PX_POPOVER_ARROW_OFFSET_X, 0),
            top: bnd.top + bnd.height
          ***REMOVED***);
        ***REMOVED***
      ***REMOVED*** else {
        $airPopover.hide();
      ***REMOVED***
    ***REMOVED***;

    /**
     * @param {Node***REMOVED*** button
     * @param {String***REMOVED*** eventName
     * @param {String***REMOVED*** value
     */
    this.updateRecentColor = function (button, eventName, value) {
      button.updateRecentColor(button, eventName, value);
    ***REMOVED***;

    /**
     * hide all popovers
     * @param {jQuery***REMOVED*** $popover - popover container
     */
    this.hide = function ($popover) {
      $popover.children().hide();
    ***REMOVED***;
  ***REMOVED***;

  /**
   * @class module.Handle
   *
   * Handle
   */
  var Handle = function (handler) {
    var $document = $(document);

    /**
     * `mousedown` event handler on $handle
     *  - controlSizing: resize image
     *
     * @param {MouseEvent***REMOVED*** event
     */
    var hHandleMousedown = function (event) {
      if (dom.isControlSizing(event.target)) {
        event.preventDefault();
        event.stopPropagation();

        var layoutInfo = dom.makeLayoutInfo(event.target),
            $handle = layoutInfo.handle(),
            $popover = layoutInfo.popover(),
            $editable = layoutInfo.editable(),
            $editor = layoutInfo.editor();

        var target = $handle.find('.note-control-selection').data('target'),
            $target = $(target), posStart = $target.offset(),
            scrollTop = $document.scrollTop();

        var isAirMode = $editor.data('options').airMode;

        $document.on('mousemove', function (event) {
          handler.invoke('editor.resizeTo', {
            x: event.clientX - posStart.left,
            y: event.clientY - (posStart.top - scrollTop)
          ***REMOVED***, $target, !event.shiftKey);

          handler.invoke('handle.update', $handle, {image: target***REMOVED***, isAirMode);
          handler.invoke('popover.update', $popover, {image: target***REMOVED***, isAirMode);
        ***REMOVED***).one('mouseup', function () {
          $document.off('mousemove');
          handler.invoke('editor.afterCommand', $editable);
        ***REMOVED***);

        if (!$target.data('ratio')) { // original ratio.
          $target.data('ratio', $target.height() / $target.width());
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***;

    this.attach = function (layoutInfo) {
      layoutInfo.handle().on('mousedown', hHandleMousedown);
    ***REMOVED***;

    /**
     * update handle
     * @param {jQuery***REMOVED*** $handle
     * @param {Object***REMOVED*** styleInfo
     * @param {Boolean***REMOVED*** isAirMode
     */
    this.update = function ($handle, styleInfo, isAirMode) {
      var $selection = $handle.find('.note-control-selection');
      if (styleInfo.image) {
        var $image = $(styleInfo.image);
        var pos = isAirMode ? $image.offset() : $image.position();

        // include margin
        var imageSize = {
          w: $image.outerWidth(true),
          h: $image.outerHeight(true)
        ***REMOVED***;

        $selection.css({
          display: 'block',
          left: pos.left,
          top: pos.top,
          width: imageSize.w,
          height: imageSize.h
        ***REMOVED***).data('target', styleInfo.image); // save current image element.
        var sizingText = imageSize.w + 'x' + imageSize.h;
        $selection.find('.note-control-selection-info').text(sizingText);
      ***REMOVED*** else {
        $selection.hide();
      ***REMOVED***
    ***REMOVED***;

    /**
     * hide
     *
     * @param {jQuery***REMOVED*** $handle
     */
    this.hide = function ($handle) {
      $handle.children().hide();
    ***REMOVED***;
  ***REMOVED***;

  var Fullscreen = function (handler) {
    var $window = $(window);
    var $scrollbar = $('html, body');

    /**
     * toggle fullscreen
     *
     * @param {Object***REMOVED*** layoutInfo
     */
    this.toggle = function (layoutInfo) {

      var $editor = layoutInfo.editor(),
          $toolbar = layoutInfo.toolbar(),
          $editable = layoutInfo.editable(),
          $codable = layoutInfo.codable();

      var resize = function (size) {
        $editable.css('height', size.h);
        $codable.css('height', size.h);
        if ($codable.data('cmeditor')) {
          $codable.data('cmeditor').setsize(null, size.h);
        ***REMOVED***
      ***REMOVED***;

      $editor.toggleClass('fullscreen');
      var isFullscreen = $editor.hasClass('fullscreen');
      if (isFullscreen) {
        $editable.data('orgheight', $editable.css('height'));

        $window.on('resize', function () {
          resize({
            h: $window.height() - $toolbar.outerHeight()
          ***REMOVED***);
        ***REMOVED***).trigger('resize');

        $scrollbar.css('overflow', 'hidden');
      ***REMOVED*** else {
        $window.off('resize');
        resize({
          h: $editable.data('orgheight')
        ***REMOVED***);
        $scrollbar.css('overflow', 'visible');
      ***REMOVED***

      handler.invoke('toolbar.updateFullscreen', $toolbar, isFullscreen);
    ***REMOVED***;
  ***REMOVED***;


  var CodeMirror;
  if (agent.hasCodeMirror) {
    if (agent.isSupportAmd) {
      require(['CodeMirror'], function (cm) {
        CodeMirror = cm;
      ***REMOVED***);
    ***REMOVED*** else {
      CodeMirror = window.CodeMirror;
    ***REMOVED***
  ***REMOVED***

  /**
   * @class Codeview
   */
  var Codeview = function (handler) {

    this.sync = function (layoutInfo) {
      var isCodeview = handler.invoke('codeview.isActivated', layoutInfo);
      if (isCodeview && agent.hasCodeMirror) {
        layoutInfo.codable().data('cmEditor').save();
      ***REMOVED***
    ***REMOVED***;

    /**
     * @param {Object***REMOVED*** layoutInfo
     * @return {Boolean***REMOVED***
     */
    this.isActivated = function (layoutInfo) {
      var $editor = layoutInfo.editor();
      return $editor.hasClass('codeview');
    ***REMOVED***;

    /**
     * toggle codeview
     *
     * @param {Object***REMOVED*** layoutInfo
     */
    this.toggle = function (layoutInfo) {
      if (this.isActivated(layoutInfo)) {
        this.deactivate(layoutInfo);
      ***REMOVED*** else {
        this.activate(layoutInfo);
      ***REMOVED***
    ***REMOVED***;

    /**
     * activate code view
     *
     * @param {Object***REMOVED*** layoutInfo
     */
    this.activate = function (layoutInfo) {
      var $editor = layoutInfo.editor(),
          $toolbar = layoutInfo.toolbar(),
          $editable = layoutInfo.editable(),
          $codable = layoutInfo.codable(),
          $popover = layoutInfo.popover(),
          $handle = layoutInfo.handle();

      var options = $editor.data('options');

      $codable.val(dom.html($editable, options.prettifyHtml));
      $codable.height($editable.height());

      handler.invoke('toolbar.updateCodeview', $toolbar, true);
      handler.invoke('popover.hide', $popover);
      handler.invoke('handle.hide', $handle);

      $editor.addClass('codeview');

      $codable.focus();

      // activate CodeMirror as codable
      if (agent.hasCodeMirror) {
        var cmEditor = CodeMirror.fromTextArea($codable[0], options.codemirror);

        // CodeMirror TernServer
        if (options.codemirror.tern) {
          var server = new CodeMirror.TernServer(options.codemirror.tern);
          cmEditor.ternServer = server;
          cmEditor.on('cursorActivity', function (cm) {
            server.updateArgHints(cm);
          ***REMOVED***);
        ***REMOVED***

        // CodeMirror hasn't Padding.
        cmEditor.setSize(null, $editable.outerHeight());
        $codable.data('cmEditor', cmEditor);
      ***REMOVED***
    ***REMOVED***;

    /**
     * deactivate code view
     *
     * @param {Object***REMOVED*** layoutInfo
     */
    this.deactivate = function (layoutInfo) {
      var $holder = layoutInfo.holder(),
          $editor = layoutInfo.editor(),
          $toolbar = layoutInfo.toolbar(),
          $editable = layoutInfo.editable(),
          $codable = layoutInfo.codable();

      var options = $editor.data('options');

      // deactivate CodeMirror as codable
      if (agent.hasCodeMirror) {
        var cmEditor = $codable.data('cmEditor');
        $codable.val(cmEditor.getValue());
        cmEditor.toTextArea();
      ***REMOVED***

      var value = dom.value($codable, options.prettifyHtml) || dom.emptyPara;
      var isChange = $editable.html() !== value;

      $editable.html(value);
      $editable.height(options.height ? $codable.height() : 'auto');
      $editor.removeClass('codeview');

      if (isChange) {
        handler.bindCustomEvent(
          $holder, $editable.data('callbacks'), 'change'
        )($editable.html(), $editable);
      ***REMOVED***

      $editable.focus();

      handler.invoke('toolbar.updateCodeview', $toolbar, false);
    ***REMOVED***;
  ***REMOVED***;

  var DragAndDrop = function (handler) {
    var $document = $(document);

    /**
     * attach Drag and Drop Events
     *
     * @param {Object***REMOVED*** layoutInfo - layout Informations
     * @param {Object***REMOVED*** options
     */
    this.attach = function (layoutInfo, options) {
      if (options.airMode || options.disableDragAndDrop) {
        // prevent default drop event
        $document.on('drop', function (e) {
          e.preventDefault();
        ***REMOVED***);
      ***REMOVED*** else {
        this.attachDragAndDropEvent(layoutInfo, options);
      ***REMOVED***
    ***REMOVED***;

    /**
     * attach Drag and Drop Events
     *
     * @param {Object***REMOVED*** layoutInfo - layout Informations
     * @param {Object***REMOVED*** options
     */
    this.attachDragAndDropEvent = function (layoutInfo, options) {
      var collection = $(),
          $editor = layoutInfo.editor(),
          $dropzone = layoutInfo.dropzone(),
          $dropzoneMessage = $dropzone.find('.note-dropzone-message');

      // show dropzone on dragenter when dragging a object to document
      // -but only if the editor is visible, i.e. has a positive width and height
      $document.on('dragenter', function (e) {
        var isCodeview = handler.invoke('codeview.isActivated', layoutInfo);
        var hasEditorSize = $editor.width() > 0 && $editor.height() > 0;
        if (!isCodeview && !collection.length && hasEditorSize) {
          $editor.addClass('dragover');
          $dropzone.width($editor.width());
          $dropzone.height($editor.height());
          $dropzoneMessage.text(options.langInfo.image.dragImageHere);
        ***REMOVED***
        collection = collection.add(e.target);
      ***REMOVED***).on('dragleave', function (e) {
        collection = collection.not(e.target);
        if (!collection.length) {
          $editor.removeClass('dragover');
        ***REMOVED***
      ***REMOVED***).on('drop', function () {
        collection = $();
        $editor.removeClass('dragover');
      ***REMOVED***);

      // change dropzone's message on hover.
      $dropzone.on('dragenter', function () {
        $dropzone.addClass('hover');
        $dropzoneMessage.text(options.langInfo.image.dropImage);
      ***REMOVED***).on('dragleave', function () {
        $dropzone.removeClass('hover');
        $dropzoneMessage.text(options.langInfo.image.dragImageHere);
      ***REMOVED***);

      // attach dropImage
      $dropzone.on('drop', function (event) {

        var dataTransfer = event.originalEvent.dataTransfer;
        var layoutInfo = dom.makeLayoutInfo(event.currentTarget || event.target);

        if (dataTransfer && dataTransfer.files && dataTransfer.files.length) {
          event.preventDefault();
          layoutInfo.editable().focus();
          handler.insertImages(layoutInfo, dataTransfer.files);
        ***REMOVED*** else {
          var insertNodefunc = function () {
            layoutInfo.holder().summernote('insertNode', this);
          ***REMOVED***;

          for (var i = 0, len = dataTransfer.types.length; i < len; i++) {
            var type = dataTransfer.types[i];
            var content = dataTransfer.getData(type);

            if (type.toLowerCase().indexOf('text') > -1) {
              layoutInfo.holder().summernote('pasteHTML', content);
            ***REMOVED*** else {
              $(content).each(insertNodefunc);
            ***REMOVED***
          ***REMOVED***
        ***REMOVED***
      ***REMOVED***).on('dragover', false); // prevent default dragover event
    ***REMOVED***;
  ***REMOVED***;

  var Clipboard = function (handler) {
    var $paste;

    this.attach = function (layoutInfo) {
      // [workaround] getting image from clipboard
      //  - IE11 and Firefox: CTRL+v hook
      //  - Webkit: event.clipboardData
      if ((agent.isMSIE && agent.browserVersion > 10) || agent.isFF) {
        $paste = $('<div />').attr('contenteditable', true).css({
          position : 'absolute',
          left : -100000,
          opacity : 0
        ***REMOVED***);

        layoutInfo.editable().on('keydown', function (e) {
          if (e.ctrlKey && e.keyCode === key.code.V) {
            handler.invoke('saveRange', layoutInfo.editable());
            $paste.focus();

            setTimeout(function () {
              pasteByHook(layoutInfo);
            ***REMOVED***, 0);
          ***REMOVED***
        ***REMOVED***);

        layoutInfo.editable().before($paste);
      ***REMOVED*** else {
        layoutInfo.editable().on('paste', pasteByEvent);
      ***REMOVED***
    ***REMOVED***;

    var pasteByHook = function (layoutInfo) {
      var $editable = layoutInfo.editable();
      var node = $paste[0].firstChild;

      if (dom.isImg(node)) {
        var dataURI = node.src;
        var decodedData = atob(dataURI.split(',')[1]);
        var array = new Uint8Array(decodedData.length);
        for (var i = 0; i < decodedData.length; i++) {
          array[i] = decodedData.charCodeAt(i);
        ***REMOVED***

        var blob = new Blob([array], { type : 'image/png' ***REMOVED***);
        blob.name = 'clipboard.png';

        handler.invoke('restoreRange', $editable);
        handler.invoke('focus', $editable);
        handler.insertImages(layoutInfo, [blob]);
      ***REMOVED*** else {
        var pasteContent = $('<div />').html($paste.html()).html();
        handler.invoke('restoreRange', $editable);
        handler.invoke('focus', $editable);

        if (pasteContent) {
          handler.invoke('pasteHTML', $editable, pasteContent);
        ***REMOVED***
      ***REMOVED***

      $paste.empty();
    ***REMOVED***;

    /**
     * paste by clipboard event
     *
     * @param {Event***REMOVED*** event
     */
    var pasteByEvent = function (event) {
      var clipboardData = event.originalEvent.clipboardData;
      var layoutInfo = dom.makeLayoutInfo(event.currentTarget || event.target);
      var $editable = layoutInfo.editable();

      if (clipboardData && clipboardData.items && clipboardData.items.length) {
        var item = list.head(clipboardData.items);
        if (item.kind === 'file' && item.type.indexOf('image/') !== -1) {
          handler.insertImages(layoutInfo, [item.getAsFile()]);
        ***REMOVED***
        handler.invoke('editor.afterCommand', $editable);
      ***REMOVED***
    ***REMOVED***;
  ***REMOVED***;

  var LinkDialog = function (handler) {

    /**
     * toggle button status
     *
     * @private
     * @param {jQuery***REMOVED*** $btn
     * @param {Boolean***REMOVED*** isEnable
     */
    var toggleBtn = function ($btn, isEnable) {
      $btn.toggleClass('disabled', !isEnable);
      $btn.attr('disabled', !isEnable);
    ***REMOVED***;

    /**
     * bind enter key
     *
     * @private
     * @param {jQuery***REMOVED*** $input
     * @param {jQuery***REMOVED*** $btn
     */
    var bindEnterKey = function ($input, $btn) {
      $input.on('keypress', function (event) {
        if (event.keyCode === key.code.ENTER) {
          $btn.trigger('click');
        ***REMOVED***
      ***REMOVED***);
    ***REMOVED***;

    /**
     * Show link dialog and set event handlers on dialog controls.
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {jQuery***REMOVED*** $dialog
     * @param {Object***REMOVED*** linkInfo
     * @return {Promise***REMOVED***
     */
    this.showLinkDialog = function ($editable, $dialog, linkInfo) {
      return $.Deferred(function (deferred) {
        var $linkDialog = $dialog.find('.note-link-dialog');

        var $linkText = $linkDialog.find('.note-link-text'),
        $linkUrl = $linkDialog.find('.note-link-url'),
        $linkBtn = $linkDialog.find('.note-link-btn'),
        $openInNewWindow = $linkDialog.find('input[type=checkbox]');

        $linkDialog.one('shown.bs.modal', function () {
          $linkText.val(linkInfo.text);

          $linkText.on('input', function () {
            toggleBtn($linkBtn, $linkText.val() && $linkUrl.val());
            // if linktext was modified by keyup,
            // stop cloning text from linkUrl
            linkInfo.text = $linkText.val();
          ***REMOVED***);

          // if no url was given, copy text to url
          if (!linkInfo.url) {
            linkInfo.url = linkInfo.text || 'http://';
            toggleBtn($linkBtn, linkInfo.text);
          ***REMOVED***

          $linkUrl.on('input', function () {
            toggleBtn($linkBtn, $linkText.val() && $linkUrl.val());
            // display same link on `Text to display` input
            // when create a new link
            if (!linkInfo.text) {
              $linkText.val($linkUrl.val());
            ***REMOVED***
          ***REMOVED***).val(linkInfo.url).trigger('focus').trigger('select');

          bindEnterKey($linkUrl, $linkBtn);
          bindEnterKey($linkText, $linkBtn);

          $openInNewWindow.prop('checked', linkInfo.isNewWindow);

          $linkBtn.one('click', function (event) {
            event.preventDefault();

            deferred.resolve({
              range: linkInfo.range,
              url: $linkUrl.val(),
              text: $linkText.val(),
              isNewWindow: $openInNewWindow.is(':checked')
            ***REMOVED***);
            $linkDialog.modal('hide');
          ***REMOVED***);
        ***REMOVED***).one('hidden.bs.modal', function () {
          // detach events
          $linkText.off('input keypress');
          $linkUrl.off('input keypress');
          $linkBtn.off('click');

          if (deferred.state() === 'pending') {
            deferred.reject();
          ***REMOVED***
        ***REMOVED***).modal('show');
      ***REMOVED***).promise();
    ***REMOVED***;

    /**
     * @param {Object***REMOVED*** layoutInfo
     */
    this.show = function (layoutInfo) {
      var $editor = layoutInfo.editor(),
          $dialog = layoutInfo.dialog(),
          $editable = layoutInfo.editable(),
          $popover = layoutInfo.popover(),
          linkInfo = handler.invoke('editor.getLinkInfo', $editable);

      var options = $editor.data('options');

      handler.invoke('editor.saveRange', $editable);
      this.showLinkDialog($editable, $dialog, linkInfo).then(function (linkInfo) {
        handler.invoke('editor.restoreRange', $editable);
        handler.invoke('editor.createLink', $editable, linkInfo, options);
        // hide popover after creating link
        handler.invoke('popover.hide', $popover);
      ***REMOVED***).fail(function () {
        handler.invoke('editor.restoreRange', $editable);
      ***REMOVED***);
    ***REMOVED***;
  ***REMOVED***;

  var ImageDialog = function (handler) {
    /**
     * toggle button status
     *
     * @private
     * @param {jQuery***REMOVED*** $btn
     * @param {Boolean***REMOVED*** isEnable
     */
    var toggleBtn = function ($btn, isEnable) {
      $btn.toggleClass('disabled', !isEnable);
      $btn.attr('disabled', !isEnable);
    ***REMOVED***;

    /**
     * bind enter key
     *
     * @private
     * @param {jQuery***REMOVED*** $input
     * @param {jQuery***REMOVED*** $btn
     */
    var bindEnterKey = function ($input, $btn) {
      $input.on('keypress', function (event) {
        if (event.keyCode === key.code.ENTER) {
          $btn.trigger('click');
        ***REMOVED***
      ***REMOVED***);
    ***REMOVED***;

    this.show = function (layoutInfo) {
      var $dialog = layoutInfo.dialog(),
          $editable = layoutInfo.editable();

      handler.invoke('editor.saveRange', $editable);
      this.showImageDialog($editable, $dialog).then(function (data) {
        handler.invoke('editor.restoreRange', $editable);

        if (typeof data === 'string') {
          // image url
          handler.invoke('editor.insertImage', $editable, data);
        ***REMOVED*** else {
          // array of files
          handler.insertImages(layoutInfo, data);
        ***REMOVED***
      ***REMOVED***).fail(function () {
        handler.invoke('editor.restoreRange', $editable);
      ***REMOVED***);
    ***REMOVED***;

    /**
     * show image dialog
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {jQuery***REMOVED*** $dialog
     * @return {Promise***REMOVED***
     */
    this.showImageDialog = function ($editable, $dialog) {
      return $.Deferred(function (deferred) {
        var $imageDialog = $dialog.find('.note-image-dialog');

        var $imageInput = $dialog.find('.note-image-input'),
            $imageUrl = $dialog.find('.note-image-url'),
            $imageBtn = $dialog.find('.note-image-btn');

        $imageDialog.one('shown.bs.modal', function () {
          // Cloning imageInput to clear element.
          $imageInput.replaceWith($imageInput.clone()
            .on('change', function () {
              deferred.resolve(this.files || this.value);
              $imageDialog.modal('hide');
            ***REMOVED***)
            .val('')
          );

          $imageBtn.click(function (event) {
            event.preventDefault();

            deferred.resolve($imageUrl.val());
            $imageDialog.modal('hide');
          ***REMOVED***);

          $imageUrl.on('keyup paste', function (event) {
            var url;
            
            if (event.type === 'paste') {
              url = event.originalEvent.clipboardData.getData('text');
            ***REMOVED*** else {
              url = $imageUrl.val();
            ***REMOVED***
            
            toggleBtn($imageBtn, url);
          ***REMOVED***).val('').trigger('focus');
          bindEnterKey($imageUrl, $imageBtn);
        ***REMOVED***).one('hidden.bs.modal', function () {
          $imageInput.off('change');
          $imageUrl.off('keyup paste keypress');
          $imageBtn.off('click');

          if (deferred.state() === 'pending') {
            deferred.reject();
          ***REMOVED***
        ***REMOVED***).modal('show');
      ***REMOVED***);
    ***REMOVED***;
  ***REMOVED***;

  var HelpDialog = function (handler) {
    /**
     * show help dialog
     *
     * @param {jQuery***REMOVED*** $editable
     * @param {jQuery***REMOVED*** $dialog
     * @return {Promise***REMOVED***
     */
    this.showHelpDialog = function ($editable, $dialog) {
      return $.Deferred(function (deferred) {
        var $helpDialog = $dialog.find('.note-help-dialog');

        $helpDialog.one('hidden.bs.modal', function () {
          deferred.resolve();
        ***REMOVED***).modal('show');
      ***REMOVED***).promise();
    ***REMOVED***;

    /**
     * @param {Object***REMOVED*** layoutInfo
     */
    this.show = function (layoutInfo) {
      var $dialog = layoutInfo.dialog(),
          $editable = layoutInfo.editable();

      handler.invoke('editor.saveRange', $editable, true);
      this.showHelpDialog($editable, $dialog).then(function () {
        handler.invoke('editor.restoreRange', $editable);
      ***REMOVED***);
    ***REMOVED***;
  ***REMOVED***;


  /**
   * @class EventHandler
   *
   * EventHandler
   *  - TODO: new instance per a editor
   */
  var EventHandler = function () {
    var self = this;

    /**
     * Modules
     */
    var modules = this.modules = {
      editor: new Editor(this),
      toolbar: new Toolbar(this),
      statusbar: new Statusbar(this),
      popover: new Popover(this),
      handle: new Handle(this),
      fullscreen: new Fullscreen(this),
      codeview: new Codeview(this),
      dragAndDrop: new DragAndDrop(this),
      clipboard: new Clipboard(this),
      linkDialog: new LinkDialog(this),
      imageDialog: new ImageDialog(this),
      helpDialog: new HelpDialog(this)
    ***REMOVED***;

    /**
     * invoke module's method
     *
     * @param {String***REMOVED*** moduleAndMethod - ex) 'editor.redo'
     * @param {...****REMOVED*** arguments - arguments of method
     * @return {****REMOVED***
     */
    this.invoke = function () {
      var moduleAndMethod = list.head(list.from(arguments));
      var args = list.tail(list.from(arguments));

      var splits = moduleAndMethod.split('.');
      var hasSeparator = splits.length > 1;
      var moduleName = hasSeparator && list.head(splits);
      var methodName = hasSeparator ? list.last(splits) : list.head(splits);

      var module = this.getModule(moduleName);
      var method = module[methodName];

      return method && method.apply(module, args);
    ***REMOVED***;

    /**
     * returns module
     *
     * @param {String***REMOVED*** moduleName - name of module
     * @return {Module***REMOVED*** - defaults is editor
     */
    this.getModule = function (moduleName) {
      return this.modules[moduleName] || this.modules.editor;
    ***REMOVED***;

    /**
     * @param {jQuery***REMOVED*** $holder
     * @param {Object***REMOVED*** callbacks
     * @param {String***REMOVED*** eventNamespace
     * @returns {Function***REMOVED***
     */
    var bindCustomEvent = this.bindCustomEvent = function ($holder, callbacks, eventNamespace) {
      return function () {
        var callback = callbacks[func.namespaceToCamel(eventNamespace, 'on')];
        if (callback) {
          callback.apply($holder[0], arguments);
        ***REMOVED***
        return $holder.trigger('summernote.' + eventNamespace, arguments);
      ***REMOVED***;
    ***REMOVED***;

    /**
     * insert Images from file array.
     *
     * @private
     * @param {Object***REMOVED*** layoutInfo
     * @param {File[]***REMOVED*** files
     */
    this.insertImages = function (layoutInfo, files) {
      var $editor = layoutInfo.editor(),
          $editable = layoutInfo.editable(),
          $holder = layoutInfo.holder();

      var callbacks = $editable.data('callbacks');
      var options = $editor.data('options');

      // If onImageUpload options setted
      if (callbacks.onImageUpload) {
        bindCustomEvent($holder, callbacks, 'image.upload')(files);
      // else insert Image as dataURL
      ***REMOVED*** else {
        $.each(files, function (idx, file) {
          var filename = file.name;
          if (options.maximumImageFileSize && options.maximumImageFileSize < file.size) {
            bindCustomEvent($holder, callbacks, 'image.upload.error')(options.langInfo.image.maximumFileSizeError);
          ***REMOVED*** else {
            async.readFileAsDataURL(file).then(function (sDataURL) {
              modules.editor.insertImage($editable, sDataURL, filename);
            ***REMOVED***).fail(function () {
              bindCustomEvent($holder, callbacks, 'image.upload.error')(options.langInfo.image.maximumFileSizeError);
            ***REMOVED***);
          ***REMOVED***
        ***REMOVED***);
      ***REMOVED***
    ***REMOVED***;

    var commands = {
      /**
       * @param {Object***REMOVED*** layoutInfo
       */
      showLinkDialog: function (layoutInfo) {
        modules.linkDialog.show(layoutInfo);
      ***REMOVED***,

      /**
       * @param {Object***REMOVED*** layoutInfo
       */
      showImageDialog: function (layoutInfo) {
        modules.imageDialog.show(layoutInfo);
      ***REMOVED***,

      /**
       * @param {Object***REMOVED*** layoutInfo
       */
      showHelpDialog: function (layoutInfo) {
        modules.helpDialog.show(layoutInfo);
      ***REMOVED***,

      /**
       * @param {Object***REMOVED*** layoutInfo
       */
      fullscreen: function (layoutInfo) {
        modules.fullscreen.toggle(layoutInfo);
      ***REMOVED***,

      /**
       * @param {Object***REMOVED*** layoutInfo
       */
      codeview: function (layoutInfo) {
        modules.codeview.toggle(layoutInfo);
      ***REMOVED***
    ***REMOVED***;

    var hMousedown = function (event) {
      //preventDefault Selection for FF, IE8+
      if (dom.isImg(event.target)) {
        event.preventDefault();
      ***REMOVED***
    ***REMOVED***;

    var hKeyupAndMouseup = function (event) {
      var layoutInfo = dom.makeLayoutInfo(event.currentTarget || event.target);
      modules.editor.removeBogus(layoutInfo.editable());
      hToolbarAndPopoverUpdate(event);
    ***REMOVED***;

    /**
     * update sytle info
     * @param {Object***REMOVED*** styleInfo
     * @param {Object***REMOVED*** layoutInfo
     */
    this.updateStyleInfo = function (styleInfo, layoutInfo) {
      if (!styleInfo) {
        return;
      ***REMOVED***
      var isAirMode = layoutInfo.editor().data('options').airMode;
      if (!isAirMode) {
        modules.toolbar.update(layoutInfo.toolbar(), styleInfo);
      ***REMOVED***

      modules.popover.update(layoutInfo.popover(), styleInfo, isAirMode);
      modules.handle.update(layoutInfo.handle(), styleInfo, isAirMode);
    ***REMOVED***;

    var hToolbarAndPopoverUpdate = function (event) {
      var target = event.target;
      // delay for range after mouseup
      setTimeout(function () {
        var layoutInfo = dom.makeLayoutInfo(target);
        var styleInfo = modules.editor.currentStyle(target);
        self.updateStyleInfo(styleInfo, layoutInfo);
      ***REMOVED***, 0);
    ***REMOVED***;

    var hScroll = function (event) {
      var layoutInfo = dom.makeLayoutInfo(event.currentTarget || event.target);
      //hide popover and handle when scrolled
      modules.popover.hide(layoutInfo.popover());
      modules.handle.hide(layoutInfo.handle());
    ***REMOVED***;

    var hToolbarAndPopoverMousedown = function (event) {
      // prevent default event when insertTable (FF, Webkit)
      var $btn = $(event.target).closest('[data-event]');
      if ($btn.length) {
        event.preventDefault();
      ***REMOVED***
    ***REMOVED***;

    var hToolbarAndPopoverClick = function (event) {
      var $btn = $(event.target).closest('[data-event]');

      if (!$btn.length) {
        return;
      ***REMOVED***

      var eventName = $btn.attr('data-event'),
          value = $btn.attr('data-value'),
          hide = $btn.attr('data-hide');

      var layoutInfo = dom.makeLayoutInfo(event.target);

      // before command: detect control selection element($target)
      var $target;
      if ($.inArray(eventName, ['resize', 'floatMe', 'removeMedia', 'imageShape']) !== -1) {
        var $selection = layoutInfo.handle().find('.note-control-selection');
        $target = $($selection.data('target'));
      ***REMOVED***

      // If requested, hide the popover when the button is clicked.
      // Useful for things like showHelpDialog.
      if (hide) {
        $btn.parents('.popover').hide();
      ***REMOVED***

      if ($.isFunction($.summernote.pluginEvents[eventName])) {
        $.summernote.pluginEvents[eventName](event, modules.editor, layoutInfo, value);
      ***REMOVED*** else if (modules.editor[eventName]) { // on command
        var $editable = layoutInfo.editable();
        $editable.focus();
        modules.editor[eventName]($editable, value, $target);
        event.preventDefault();
      ***REMOVED*** else if (commands[eventName]) {
        commands[eventName].call(this, layoutInfo);
        event.preventDefault();
      ***REMOVED***

      // after command
      if ($.inArray(eventName, ['backColor', 'foreColor']) !== -1) {
        var options = layoutInfo.editor().data('options', options);
        var module = options.airMode ? modules.popover : modules.toolbar;
        module.updateRecentColor(list.head($btn), eventName, value);
      ***REMOVED***

      hToolbarAndPopoverUpdate(event);
    ***REMOVED***;

    var PX_PER_EM = 18;
    var hDimensionPickerMove = function (event, options) {
      var $picker = $(event.target.parentNode); // target is mousecatcher
      var $dimensionDisplay = $picker.next();
      var $catcher = $picker.find('.note-dimension-picker-mousecatcher');
      var $highlighted = $picker.find('.note-dimension-picker-highlighted');
      var $unhighlighted = $picker.find('.note-dimension-picker-unhighlighted');

      var posOffset;
      // HTML5 with jQuery - e.offsetX is undefined in Firefox
      if (event.offsetX === undefined) {
        var posCatcher = $(event.target).offset();
        posOffset = {
          x: event.pageX - posCatcher.left,
          y: event.pageY - posCatcher.top
        ***REMOVED***;
      ***REMOVED*** else {
        posOffset = {
          x: event.offsetX,
          y: event.offsetY
        ***REMOVED***;
      ***REMOVED***

      var dim = {
        c: Math.ceil(posOffset.x / PX_PER_EM) || 1,
        r: Math.ceil(posOffset.y / PX_PER_EM) || 1
      ***REMOVED***;

      $highlighted.css({ width: dim.c + 'em', height: dim.r + 'em' ***REMOVED***);
      $catcher.attr('data-value', dim.c + 'x' + dim.r);

      if (3 < dim.c && dim.c < options.insertTableMaxSize.col) {
        $unhighlighted.css({ width: dim.c + 1 + 'em'***REMOVED***);
      ***REMOVED***

      if (3 < dim.r && dim.r < options.insertTableMaxSize.row) {
        $unhighlighted.css({ height: dim.r + 1 + 'em'***REMOVED***);
      ***REMOVED***

      $dimensionDisplay.html(dim.c + ' x ' + dim.r);
    ***REMOVED***;
    
    /**
     * bind KeyMap on keydown
     *
     * @param {Object***REMOVED*** layoutInfo
     * @param {Object***REMOVED*** keyMap
     */
    this.bindKeyMap = function (layoutInfo, keyMap) {
      var $editor = layoutInfo.editor();
      var $editable = layoutInfo.editable();

      $editable.on('keydown', function (event) {
        var keys = [];

        // modifier
        if (event.metaKey) { keys.push('CMD'); ***REMOVED***
        if (event.ctrlKey && !event.altKey) { keys.push('CTRL'); ***REMOVED***
        if (event.shiftKey) { keys.push('SHIFT'); ***REMOVED***

        // keycode
        var keyName = key.nameFromCode[event.keyCode];
        if (keyName) {
          keys.push(keyName);
        ***REMOVED***

        var pluginEvent;
        var keyString = keys.join('+');
        var eventName = keyMap[keyString];
        if (eventName) {
          // FIXME Summernote doesn't support event pipeline yet.
          //  - Plugin -> Base Code
          pluginEvent = $.summernote.pluginEvents[keyString];
          if ($.isFunction(pluginEvent)) {
            if (pluginEvent(event, modules.editor, layoutInfo)) {
              return false;
            ***REMOVED***
          ***REMOVED***

          pluginEvent = $.summernote.pluginEvents[eventName];

          if ($.isFunction(pluginEvent)) {
            pluginEvent(event, modules.editor, layoutInfo);
          ***REMOVED*** else if (modules.editor[eventName]) {
            modules.editor[eventName]($editable, $editor.data('options'));
            event.preventDefault();
          ***REMOVED*** else if (commands[eventName]) {
            commands[eventName].call(this, layoutInfo);
            event.preventDefault();
          ***REMOVED***
        ***REMOVED*** else if (key.isEdit(event.keyCode)) {
          modules.editor.afterCommand($editable);
        ***REMOVED***
      ***REMOVED***);
    ***REMOVED***;

    /**
     * attach eventhandler
     *
     * @param {Object***REMOVED*** layoutInfo - layout Informations
     * @param {Object***REMOVED*** options - user options include custom event handlers
     */
    this.attach = function (layoutInfo, options) {
      // handlers for editable
      if (options.shortcuts) {
        this.bindKeyMap(layoutInfo, options.keyMap[agent.isMac ? 'mac' : 'pc']);
      ***REMOVED***
      layoutInfo.editable().on('mousedown', hMousedown);
      layoutInfo.editable().on('keyup mouseup', hKeyupAndMouseup);
      layoutInfo.editable().on('scroll', hScroll);

      // handler for clipboard
      modules.clipboard.attach(layoutInfo, options);

      // handler for handle and popover
      modules.handle.attach(layoutInfo, options);
      layoutInfo.popover().on('click', hToolbarAndPopoverClick);
      layoutInfo.popover().on('mousedown', hToolbarAndPopoverMousedown);

      // handler for drag and drop
      modules.dragAndDrop.attach(layoutInfo, options);

      // handlers for frame mode (toolbar, statusbar)
      if (!options.airMode) {
        // handler for toolbar
        layoutInfo.toolbar().on('click', hToolbarAndPopoverClick);
        layoutInfo.toolbar().on('mousedown', hToolbarAndPopoverMousedown);

        // handler for statusbar
        modules.statusbar.attach(layoutInfo, options);
      ***REMOVED***

      // handler for table dimension
      var $catcherContainer = options.airMode ? layoutInfo.popover() :
                                                layoutInfo.toolbar();
      var $catcher = $catcherContainer.find('.note-dimension-picker-mousecatcher');
      $catcher.css({
        width: options.insertTableMaxSize.col + 'em',
        height: options.insertTableMaxSize.row + 'em'
      ***REMOVED***).on('mousemove', function (event) {
        hDimensionPickerMove(event, options);
      ***REMOVED***);

      // save options on editor
      layoutInfo.editor().data('options', options);

      // ret styleWithCSS for backColor / foreColor clearing with 'inherit'.
      if (!agent.isMSIE) {
        // [workaround] for Firefox
        //  - protect FF Error: NS_ERROR_FAILURE: Failure
        setTimeout(function () {
          document.execCommand('styleWithCSS', 0, options.styleWithSpan);
        ***REMOVED***, 0);
      ***REMOVED***

      // History
      var history = new History(layoutInfo.editable());
      layoutInfo.editable().data('NoteHistory', history);

      // All editor status will be saved on editable with jquery's data
      // for support multiple editor with singleton object.
      layoutInfo.editable().data('callbacks', {
        onInit: options.onInit,
        onFocus: options.onFocus,
        onBlur: options.onBlur,
        onKeydown: options.onKeydown,
        onKeyup: options.onKeyup,
        onMousedown: options.onMousedown,
        onEnter: options.onEnter,
        onPaste: options.onPaste,
        onBeforeCommand: options.onBeforeCommand,
        onChange: options.onChange,
        onImageUpload: options.onImageUpload,
        onImageUploadError: options.onImageUploadError,
        onMediaDelete: options.onMediaDelete,
        onToolbarClick: options.onToolbarClick
      ***REMOVED***);

      var styleInfo = modules.editor.styleFromNode(layoutInfo.editable());
      this.updateStyleInfo(styleInfo, layoutInfo);
    ***REMOVED***;

    /**
     * attach jquery custom event
     *
     * @param {Object***REMOVED*** layoutInfo - layout Informations
     */
    this.attachCustomEvent = function (layoutInfo, options) {
      var $holder = layoutInfo.holder();
      var $editable = layoutInfo.editable();
      var callbacks = $editable.data('callbacks');

      $editable.focus(bindCustomEvent($holder, callbacks, 'focus'));
      $editable.blur(bindCustomEvent($holder, callbacks, 'blur'));

      $editable.keydown(function (event) {
        if (event.keyCode === key.code.ENTER) {
          bindCustomEvent($holder, callbacks, 'enter').call(this, event);
        ***REMOVED***
        bindCustomEvent($holder, callbacks, 'keydown').call(this, event);
      ***REMOVED***);
      $editable.keyup(bindCustomEvent($holder, callbacks, 'keyup'));

      $editable.on('mousedown', bindCustomEvent($holder, callbacks, 'mousedown'));
      $editable.on('mouseup', bindCustomEvent($holder, callbacks, 'mouseup'));
      $editable.on('scroll', bindCustomEvent($holder, callbacks, 'scroll'));

      $editable.on('paste', bindCustomEvent($holder, callbacks, 'paste'));
      
      // [workaround] IE doesn't have input events for contentEditable
      //  - see: https://goo.gl/4bfIvA
      var changeEventName = agent.isMSIE ? 'DOMCharacterDataModified DOMSubtreeModified DOMNodeInserted' : 'input';
      $editable.on(changeEventName, function () {
        bindCustomEvent($holder, callbacks, 'change')($editable.html(), $editable);
      ***REMOVED***);

      if (!options.airMode) {
        layoutInfo.toolbar().click(bindCustomEvent($holder, callbacks, 'toolbar.click'));
        layoutInfo.popover().click(bindCustomEvent($holder, callbacks, 'popover.click'));
      ***REMOVED***

      // Textarea: auto filling the code before form submit.
      if (dom.isTextarea(list.head($holder))) {
        $holder.closest('form').submit(function (e) {
          layoutInfo.holder().val(layoutInfo.holder().code());
          bindCustomEvent($holder, callbacks, 'submit').call(this, e, $holder.code());
        ***REMOVED***);
      ***REMOVED***

      // textarea auto sync
      if (dom.isTextarea(list.head($holder)) && options.textareaAutoSync) {
        $holder.on('summernote.change', function () {
          layoutInfo.holder().val(layoutInfo.holder().code());
        ***REMOVED***);
      ***REMOVED***

      // fire init event
      bindCustomEvent($holder, callbacks, 'init')(layoutInfo);

      // fire plugin init event
      for (var i = 0, len = $.summernote.plugins.length; i < len; i++) {
        if ($.isFunction($.summernote.plugins[i].init)) {
          $.summernote.plugins[i].init(layoutInfo);
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***;
      
    this.detach = function (layoutInfo, options) {
      layoutInfo.holder().off();
      layoutInfo.editable().off();

      layoutInfo.popover().off();
      layoutInfo.handle().off();
      layoutInfo.dialog().off();

      if (!options.airMode) {
        layoutInfo.dropzone().off();
        layoutInfo.toolbar().off();
        layoutInfo.statusbar().off();
      ***REMOVED***
    ***REMOVED***;
  ***REMOVED***;

  /**
   * @class Renderer
   *
   * renderer
   *
   * rendering toolbar and editable
   */
  var Renderer = function () {

    /**
     * bootstrap button template
     * @private
     * @param {String***REMOVED*** label button name
     * @param {Object***REMOVED*** [options] button options
     * @param {String***REMOVED*** [options.event] data-event
     * @param {String***REMOVED*** [options.className] button's class name
     * @param {String***REMOVED*** [options.value] data-value
     * @param {String***REMOVED*** [options.title] button's title for popup
     * @param {String***REMOVED*** [options.dropdown] dropdown html
     * @param {String***REMOVED*** [options.hide] data-hide
     */
    var tplButton = function (label, options) {
      var event = options.event;
      var value = options.value;
      var title = options.title;
      var className = options.className;
      var dropdown = options.dropdown;
      var hide = options.hide;

      return (dropdown ? '<div class="btn-group' +
               (className ? ' ' + className : '') + '">' : '') +
               '<button type="button"' +
                 ' class="btn btn-default btn-sm' +
                   ((!dropdown && className) ? ' ' + className : '') +
                   (dropdown ? ' dropdown-toggle' : '') +
                 '"' +
                 (dropdown ? ' data-toggle="dropdown"' : '') +
                 (title ? ' title="' + title + '"' : '') +
                 (event ? ' data-event="' + event + '"' : '') +
                 (value ? ' data-value=\'' + value + '\'' : '') +
                 (hide ? ' data-hide=\'' + hide + '\'' : '') +
                 ' tabindex="-1">' +
                 label +
                 (dropdown ? ' <span class="caret"></span>' : '') +
               '</button>' +
               (dropdown || '') +
             (dropdown ? '</div>' : '');
    ***REMOVED***;

    /**
     * bootstrap icon button template
     * @private
     * @param {String***REMOVED*** iconClassName
     * @param {Object***REMOVED*** [options]
     * @param {String***REMOVED*** [options.event]
     * @param {String***REMOVED*** [options.value]
     * @param {String***REMOVED*** [options.title]
     * @param {String***REMOVED*** [options.dropdown]
     */
    var tplIconButton = function (iconClassName, options) {
      var label = '<i class="' + iconClassName + '"></i>';
      return tplButton(label, options);
    ***REMOVED***;

    /**
     * bootstrap popover template
     * @private
     * @param {String***REMOVED*** className
     * @param {String***REMOVED*** content
     */
    var tplPopover = function (className, content) {
      var $popover = $('<div class="' + className + ' popover bottom in" style="display: none;">' +
               '<div class="arrow"></div>' +
               '<div class="popover-content">' +
               '</div>' +
             '</div>');

      $popover.find('.popover-content').append(content);
      return $popover;
    ***REMOVED***;

    /**
     * bootstrap dialog template
     *
     * @param {String***REMOVED*** className
     * @param {String***REMOVED*** [title='']
     * @param {String***REMOVED*** body
     * @param {String***REMOVED*** [footer='']
     */
    var tplDialog = function (className, title, body, footer) {
      return '<div class="' + className + ' modal" aria-hidden="false">' +
               '<div class="modal-dialog">' +
                 '<div class="modal-content">' +
                   (title ?
                   '<div class="modal-header">' +
                     '<button type="button" class="close" aria-hidden="true" tabindex="-1">&times;</button>' +
                     '<h4 class="modal-title">' + title + '</h4>' +
                   '</div>' : ''
                   ) +
                   '<div class="modal-body">' + body + '</div>' +
                   (footer ?
                   '<div class="modal-footer">' + footer + '</div>' : ''
                   ) +
                 '</div>' +
               '</div>' +
             '</div>';
    ***REMOVED***;

    /**
     * bootstrap dropdown template
     *
     * @param {String|String[]***REMOVED*** contents
     * @param {String***REMOVED*** [className='']
     * @param {String***REMOVED*** [nodeName='']
     */
    var tplDropdown = function (contents, className, nodeName) {
      var classes = 'dropdown-menu' + (className ? ' ' + className : '');
      nodeName = nodeName || 'ul';
      if (contents instanceof Array) {
        contents = contents.join('');
      ***REMOVED***

      return '<' + nodeName + ' class="' + classes + '">' + contents + '</' + nodeName + '>';
    ***REMOVED***;

    var tplButtonInfo = {
      picture: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.image.image, {
          event: 'showImageDialog',
          title: lang.image.image,
          hide: true
        ***REMOVED***);
      ***REMOVED***,
      link: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.link.link, {
          event: 'showLinkDialog',
          title: lang.link.link,
          hide: true
        ***REMOVED***);
      ***REMOVED***,
      table: function (lang, options) {
        var dropdown = [
          '<div class="note-dimension-picker">',
          '<div class="note-dimension-picker-mousecatcher" data-event="insertTable" data-value="1x1"></div>',
          '<div class="note-dimension-picker-highlighted"></div>',
          '<div class="note-dimension-picker-unhighlighted"></div>',
          '</div>',
          '<div class="note-dimension-display"> 1 x 1 </div>'
        ];

        return tplIconButton(options.iconPrefix + options.icons.table.table, {
          title: lang.table.table,
          dropdown: tplDropdown(dropdown, 'note-table')
        ***REMOVED***);
      ***REMOVED***,
      style: function (lang, options) {
        var items = options.styleTags.reduce(function (memo, v) {
          var label = lang.style[v === 'p' ? 'normal' : v];
          return memo + '<li><a data-event="formatBlock" href="#" data-value="' + v + '">' +
                   (
                     (v === 'p' || v === 'pre') ? label :
                     '<' + v + '>' + label + '</' + v + '>'
                   ) +
                 '</a></li>';
        ***REMOVED***, '');

        return tplIconButton(options.iconPrefix + options.icons.style.style, {
          title: lang.style.style,
          dropdown: tplDropdown(items)
        ***REMOVED***);
      ***REMOVED***,
      fontname: function (lang, options) {
        var realFontList = [];
        var items = options.fontNames.reduce(function (memo, v) {
          if (!agent.isFontInstalled(v) && !list.contains(options.fontNamesIgnoreCheck, v)) {
            return memo;
          ***REMOVED***
          realFontList.push(v);
          return memo + '<li><a data-event="fontName" href="#" data-value="' + v + '" style="font-family:\'' + v + '\'">' +
                          '<i class="' + options.iconPrefix + options.icons.misc.check + '"></i> ' + v +
                        '</a></li>';
        ***REMOVED***, '');

        var hasDefaultFont = agent.isFontInstalled(options.defaultFontName);
        var defaultFontName = (hasDefaultFont) ? options.defaultFontName : realFontList[0];

        var label = '<span class="note-current-fontname">' +
                        defaultFontName +
                     '</span>';
        return tplButton(label, {
          title: lang.font.name,
          className: 'note-fontname',
          dropdown: tplDropdown(items, 'note-check')
        ***REMOVED***);
      ***REMOVED***,
      fontsize: function (lang, options) {
        var items = options.fontSizes.reduce(function (memo, v) {
          return memo + '<li><a data-event="fontSize" href="#" data-value="' + v + '">' +
                          '<i class="' + options.iconPrefix + options.icons.misc.check + '"></i> ' + v +
                        '</a></li>';
        ***REMOVED***, '');

        var label = '<span class="note-current-fontsize">11</span>';
        return tplButton(label, {
          title: lang.font.size,
          className: 'note-fontsize',
          dropdown: tplDropdown(items, 'note-check')
        ***REMOVED***);
      ***REMOVED***,
      color: function (lang, options) {
        var colorButtonLabel = '<i class="' +
                                  options.iconPrefix + options.icons.color.recent +
                                '" style="color:black;background-color:yellow;"></i>';

        var colorButton = tplButton(colorButtonLabel, {
          className: 'note-recent-color',
          title: lang.color.recent,
          event: 'color',
          value: '{"backColor":"yellow"***REMOVED***'
        ***REMOVED***);

        var items = [
          '<li><div class="btn-group">',
          '<div class="note-palette-title">' + lang.color.background + '</div>',
          '<div class="note-color-reset" data-event="backColor"',
          ' data-value="inherit" title="' + lang.color.transparent + '">' + lang.color.setTransparent + '</div>',
          '<div class="note-color-palette" data-target-event="backColor"></div>',
          '</div><div class="btn-group">',
          '<div class="note-palette-title">' + lang.color.foreground + '</div>',
          '<div class="note-color-reset" data-event="foreColor" data-value="inherit" title="' + lang.color.reset + '">',
          lang.color.resetToDefault,
          '</div>',
          '<div class="note-color-palette" data-target-event="foreColor"></div>',
          '</div></li>'
        ];

        var moreButton = tplButton('', {
          title: lang.color.more,
          dropdown: tplDropdown(items)
        ***REMOVED***);

        return colorButton + moreButton;
      ***REMOVED***,
      bold: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.font.bold, {
          event: 'bold',
          title: lang.font.bold
        ***REMOVED***);
      ***REMOVED***,
      italic: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.font.italic, {
          event: 'italic',
          title: lang.font.italic
        ***REMOVED***);
      ***REMOVED***,
      underline: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.font.underline, {
          event: 'underline',
          title: lang.font.underline
        ***REMOVED***);
      ***REMOVED***,
      strikethrough: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.font.strikethrough, {
          event: 'strikethrough',
          title: lang.font.strikethrough
        ***REMOVED***);
      ***REMOVED***,
      superscript: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.font.superscript, {
          event: 'superscript',
          title: lang.font.superscript
        ***REMOVED***);
      ***REMOVED***,
      subscript: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.font.subscript, {
          event: 'subscript',
          title: lang.font.subscript
        ***REMOVED***);
      ***REMOVED***,
      clear: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.font.clear, {
          event: 'removeFormat',
          title: lang.font.clear
        ***REMOVED***);
      ***REMOVED***,
      ul: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.lists.unordered, {
          event: 'insertUnorderedList',
          title: lang.lists.unordered
        ***REMOVED***);
      ***REMOVED***,
      ol: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.lists.ordered, {
          event: 'insertOrderedList',
          title: lang.lists.ordered
        ***REMOVED***);
      ***REMOVED***,
      paragraph: function (lang, options) {
        var leftButton = tplIconButton(options.iconPrefix + options.icons.paragraph.left, {
          title: lang.paragraph.left,
          event: 'justifyLeft'
        ***REMOVED***);
        var centerButton = tplIconButton(options.iconPrefix + options.icons.paragraph.center, {
          title: lang.paragraph.center,
          event: 'justifyCenter'
        ***REMOVED***);
        var rightButton = tplIconButton(options.iconPrefix + options.icons.paragraph.right, {
          title: lang.paragraph.right,
          event: 'justifyRight'
        ***REMOVED***);
        var justifyButton = tplIconButton(options.iconPrefix + options.icons.paragraph.justify, {
          title: lang.paragraph.justify,
          event: 'justifyFull'
        ***REMOVED***);

        var outdentButton = tplIconButton(options.iconPrefix + options.icons.paragraph.outdent, {
          title: lang.paragraph.outdent,
          event: 'outdent'
        ***REMOVED***);
        var indentButton = tplIconButton(options.iconPrefix + options.icons.paragraph.indent, {
          title: lang.paragraph.indent,
          event: 'indent'
        ***REMOVED***);

        var dropdown = [
          '<div class="note-align btn-group">',
          leftButton + centerButton + rightButton + justifyButton,
          '</div><div class="note-list btn-group">',
          indentButton + outdentButton,
          '</div>'
        ];

        return tplIconButton(options.iconPrefix + options.icons.paragraph.paragraph, {
          title: lang.paragraph.paragraph,
          dropdown: tplDropdown(dropdown, '', 'div')
        ***REMOVED***);
      ***REMOVED***,
      height: function (lang, options) {
        var items = options.lineHeights.reduce(function (memo, v) {
          return memo + '<li><a data-event="lineHeight" href="#" data-value="' + parseFloat(v) + '">' +
                          '<i class="' + options.iconPrefix + options.icons.misc.check + '"></i> ' + v +
                        '</a></li>';
        ***REMOVED***, '');

        return tplIconButton(options.iconPrefix + options.icons.font.height, {
          title: lang.font.height,
          dropdown: tplDropdown(items, 'note-check')
        ***REMOVED***);

      ***REMOVED***,
      help: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.options.help, {
          event: 'showHelpDialog',
          title: lang.options.help,
          hide: true
        ***REMOVED***);
      ***REMOVED***,
      fullscreen: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.options.fullscreen, {
          event: 'fullscreen',
          title: lang.options.fullscreen
        ***REMOVED***);
      ***REMOVED***,
      codeview: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.options.codeview, {
          event: 'codeview',
          title: lang.options.codeview
        ***REMOVED***);
      ***REMOVED***,
      undo: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.history.undo, {
          event: 'undo',
          title: lang.history.undo
        ***REMOVED***);
      ***REMOVED***,
      redo: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.history.redo, {
          event: 'redo',
          title: lang.history.redo
        ***REMOVED***);
      ***REMOVED***,
      hr: function (lang, options) {
        return tplIconButton(options.iconPrefix + options.icons.hr.insert, {
          event: 'insertHorizontalRule',
          title: lang.hr.insert
        ***REMOVED***);
      ***REMOVED***
    ***REMOVED***;

    var tplPopovers = function (lang, options) {
      var tplLinkPopover = function () {
        var linkButton = tplIconButton(options.iconPrefix + options.icons.link.edit, {
          title: lang.link.edit,
          event: 'showLinkDialog',
          hide: true
        ***REMOVED***);
        var unlinkButton = tplIconButton(options.iconPrefix + options.icons.link.unlink, {
          title: lang.link.unlink,
          event: 'unlink'
        ***REMOVED***);
        var content = '<a href="http://www.google.com" target="_blank">www.google.com</a>&nbsp;&nbsp;' +
                      '<div class="note-insert btn-group">' +
                        linkButton + unlinkButton +
                      '</div>';
        return tplPopover('note-link-popover', content);
      ***REMOVED***;

      var tplImagePopover = function () {
        var fullButton = tplButton('<span class="note-fontsize-10">100%</span>', {
          title: lang.image.resizeFull,
          event: 'resize',
          value: '1'
        ***REMOVED***);
        var halfButton = tplButton('<span class="note-fontsize-10">50%</span>', {
          title: lang.image.resizeHalf,
          event: 'resize',
          value: '0.5'
        ***REMOVED***);
        var quarterButton = tplButton('<span class="note-fontsize-10">25%</span>', {
          title: lang.image.resizeQuarter,
          event: 'resize',
          value: '0.25'
        ***REMOVED***);

        var leftButton = tplIconButton(options.iconPrefix + options.icons.image.floatLeft, {
          title: lang.image.floatLeft,
          event: 'floatMe',
          value: 'left'
        ***REMOVED***);
        var rightButton = tplIconButton(options.iconPrefix + options.icons.image.floatRight, {
          title: lang.image.floatRight,
          event: 'floatMe',
          value: 'right'
        ***REMOVED***);
        var justifyButton = tplIconButton(options.iconPrefix + options.icons.image.floatNone, {
          title: lang.image.floatNone,
          event: 'floatMe',
          value: 'none'
        ***REMOVED***);

        var roundedButton = tplIconButton(options.iconPrefix + options.icons.image.shapeRounded, {
          title: lang.image.shapeRounded,
          event: 'imageShape',
          value: 'img-rounded'
        ***REMOVED***);
        var circleButton = tplIconButton(options.iconPrefix + options.icons.image.shapeCircle, {
          title: lang.image.shapeCircle,
          event: 'imageShape',
          value: 'img-circle'
        ***REMOVED***);
        var thumbnailButton = tplIconButton(options.iconPrefix + options.icons.image.shapeThumbnail, {
          title: lang.image.shapeThumbnail,
          event: 'imageShape',
          value: 'img-thumbnail'
        ***REMOVED***);
        var noneButton = tplIconButton(options.iconPrefix + options.icons.image.shapeNone, {
          title: lang.image.shapeNone,
          event: 'imageShape',
          value: ''
        ***REMOVED***);

        var removeButton = tplIconButton(options.iconPrefix + options.icons.image.remove, {
          title: lang.image.remove,
          event: 'removeMedia',
          value: 'none'
        ***REMOVED***);

        var content = (options.disableResizeImage ? '' : '<div class="btn-group">' + fullButton + halfButton + quarterButton + '</div>') +
                      '<div class="btn-group">' + leftButton + rightButton + justifyButton + '</div><br>' +
                      '<div class="btn-group">' + roundedButton + circleButton + thumbnailButton + noneButton + '</div>' +
                      '<div class="btn-group">' + removeButton + '</div>';
        return tplPopover('note-image-popover', content);
      ***REMOVED***;

      var tplAirPopover = function () {
        var $content = $('<div />');
        for (var idx = 0, len = options.airPopover.length; idx < len; idx ++) {
          var group = options.airPopover[idx];

          var $group = $('<div class="note-' + group[0] + ' btn-group">');
          for (var i = 0, lenGroup = group[1].length; i < lenGroup; i++) {
            var $button = $(tplButtonInfo[group[1][i]](lang, options));

            $button.attr('data-name', group[1][i]);

            $group.append($button);
          ***REMOVED***
          $content.append($group);
        ***REMOVED***

        return tplPopover('note-air-popover', $content.children());
      ***REMOVED***;

      var $notePopover = $('<div class="note-popover" />');

      $notePopover.append(tplLinkPopover());
      $notePopover.append(tplImagePopover());

      if (options.airMode) {
        $notePopover.append(tplAirPopover());
      ***REMOVED***

      return $notePopover;
    ***REMOVED***;

    var tplHandles = function (options) {
      return '<div class="note-handle">' +
               '<div class="note-control-selection">' +
                 '<div class="note-control-selection-bg"></div>' +
                 '<div class="note-control-holder note-control-nw"></div>' +
                 '<div class="note-control-holder note-control-ne"></div>' +
                 '<div class="note-control-holder note-control-sw"></div>' +
                 '<div class="' +
                 (options.disableResizeImage ? 'note-control-holder' : 'note-control-sizing') +
                 ' note-control-se"></div>' +
                 (options.disableResizeImage ? '' : '<div class="note-control-selection-info"></div>') +
               '</div>' +
             '</div>';
    ***REMOVED***;

    /**
     * shortcut table template
     * @param {String***REMOVED*** title
     * @param {String***REMOVED*** body
     */
    var tplShortcut = function (title, keys) {
      var keyClass = 'note-shortcut-col col-xs-6 note-shortcut-';
      var body = [];

      for (var i in keys) {
        if (keys.hasOwnProperty(i)) {
          body.push(
            '<div class="' + keyClass + 'key">' + keys[i].kbd + '</div>' +
            '<div class="' + keyClass + 'name">' + keys[i].text + '</div>'
            );
        ***REMOVED***
      ***REMOVED***

      return '<div class="note-shortcut-row row"><div class="' + keyClass + 'title col-xs-offset-6">' + title + '</div></div>' +
             '<div class="note-shortcut-row row">' + body.join('</div><div class="note-shortcut-row row">') + '</div>';
    ***REMOVED***;

    var tplShortcutText = function (lang) {
      var keys = [
        { kbd: '⌘ + B', text: lang.font.bold ***REMOVED***,
        { kbd: '⌘ + I', text: lang.font.italic ***REMOVED***,
        { kbd: '⌘ + U', text: lang.font.underline ***REMOVED***,
        { kbd: '⌘ + \\', text: lang.font.clear ***REMOVED***
      ];

      return tplShortcut(lang.shortcut.textFormatting, keys);
    ***REMOVED***;

    var tplShortcutAction = function (lang) {
      var keys = [
        { kbd: '⌘ + Z', text: lang.history.undo ***REMOVED***,
        { kbd: '⌘ + ⇧ + Z', text: lang.history.redo ***REMOVED***,
        { kbd: '⌘ + ]', text: lang.paragraph.indent ***REMOVED***,
        { kbd: '⌘ + [', text: lang.paragraph.outdent ***REMOVED***,
        { kbd: '⌘ + ENTER', text: lang.hr.insert ***REMOVED***
      ];

      return tplShortcut(lang.shortcut.action, keys);
    ***REMOVED***;

    var tplShortcutPara = function (lang) {
      var keys = [
        { kbd: '⌘ + ⇧ + L', text: lang.paragraph.left ***REMOVED***,
        { kbd: '⌘ + ⇧ + E', text: lang.paragraph.center ***REMOVED***,
        { kbd: '⌘ + ⇧ + R', text: lang.paragraph.right ***REMOVED***,
        { kbd: '⌘ + ⇧ + J', text: lang.paragraph.justify ***REMOVED***,
        { kbd: '⌘ + ⇧ + NUM7', text: lang.lists.ordered ***REMOVED***,
        { kbd: '⌘ + ⇧ + NUM8', text: lang.lists.unordered ***REMOVED***
      ];

      return tplShortcut(lang.shortcut.paragraphFormatting, keys);
    ***REMOVED***;

    var tplShortcutStyle = function (lang) {
      var keys = [
        { kbd: '⌘ + NUM0', text: lang.style.normal ***REMOVED***,
        { kbd: '⌘ + NUM1', text: lang.style.h1 ***REMOVED***,
        { kbd: '⌘ + NUM2', text: lang.style.h2 ***REMOVED***,
        { kbd: '⌘ + NUM3', text: lang.style.h3 ***REMOVED***,
        { kbd: '⌘ + NUM4', text: lang.style.h4 ***REMOVED***,
        { kbd: '⌘ + NUM5', text: lang.style.h5 ***REMOVED***,
        { kbd: '⌘ + NUM6', text: lang.style.h6 ***REMOVED***
      ];

      return tplShortcut(lang.shortcut.documentStyle, keys);
    ***REMOVED***;

    var tplExtraShortcuts = function (lang, options) {
      var extraKeys = options.extraKeys;
      var keys = [];

      for (var key in extraKeys) {
        if (extraKeys.hasOwnProperty(key)) {
          keys.push({ kbd: key, text: extraKeys[key] ***REMOVED***);
        ***REMOVED***
      ***REMOVED***

      return tplShortcut(lang.shortcut.extraKeys, keys);
    ***REMOVED***;

    var tplShortcutTable = function (lang, options) {
      var colClass = 'class="note-shortcut note-shortcut-col col-sm-6 col-xs-12"';
      var template = [
        '<div ' + colClass + '>' + tplShortcutAction(lang, options) + '</div>' +
        '<div ' + colClass + '>' + tplShortcutText(lang, options) + '</div>',
        '<div ' + colClass + '>' + tplShortcutStyle(lang, options) + '</div>' +
        '<div ' + colClass + '>' + tplShortcutPara(lang, options) + '</div>'
      ];

      if (options.extraKeys) {
        template.push('<div ' + colClass + '>' + tplExtraShortcuts(lang, options) + '</div>');
      ***REMOVED***

      return '<div class="note-shortcut-row row">' +
               template.join('</div><div class="note-shortcut-row row">') +
             '</div>';
    ***REMOVED***;

    var replaceMacKeys = function (sHtml) {
      return sHtml.replace(/⌘/g, 'Ctrl').replace(/⇧/g, 'Shift');
    ***REMOVED***;

    var tplDialogInfo = {
      image: function (lang, options) {
        var imageLimitation = '';
        if (options.maximumImageFileSize) {
          var unit = Math.floor(Math.log(options.maximumImageFileSize) / Math.log(1024));
          var readableSize = (options.maximumImageFileSize / Math.pow(1024, unit)).toFixed(2) * 1 +
                             ' ' + ' KMGTP'[unit] + 'B';
          imageLimitation = '<small>' + lang.image.maximumFileSize + ' : ' + readableSize + '</small>';
        ***REMOVED***

        var body = '<div class="form-group row note-group-select-from-files">' +
                     '<label>' + lang.image.selectFromFiles + '</label>' +
                     '<input class="note-image-input form-control" type="file" name="files" accept="image/*" multiple="multiple" />' +
                     imageLimitation +
                   '</div>' +
                   '<div class="form-group row">' +
                     '<label>' + lang.image.url + '</label>' +
                     '<input class="note-image-url form-control col-md-12" type="text" />' +
                   '</div>';
        var footer = '<button href="#" class="btn btn-primary note-image-btn disabled" disabled>' + lang.image.insert + '</button>';
        return tplDialog('note-image-dialog', lang.image.insert, body, footer);
      ***REMOVED***,

      link: function (lang, options) {
        var body = '<div class="form-group row">' +
                     '<label>' + lang.link.textToDisplay + '</label>' +
                     '<input class="note-link-text form-control col-md-12" type="text" />' +
                   '</div>' +
                   '<div class="form-group row">' +
                     '<label>' + lang.link.url + '</label>' +
                     '<input class="note-link-url form-control col-md-12" type="text" value="http://" />' +
                   '</div>' +
                   (!options.disableLinkTarget ?
                     '<div class="checkbox">' +
                       '<label>' + '<input type="checkbox" checked> ' +
                         lang.link.openInNewWindow +
                       '</label>' +
                     '</div>' : ''
                   );
        var footer = '<button href="#" class="btn btn-primary note-link-btn disabled" disabled>' + lang.link.insert + '</button>';
        return tplDialog('note-link-dialog', lang.link.insert, body, footer);
      ***REMOVED***,

      help: function (lang, options) {
        var body = '<a class="modal-close pull-right" aria-hidden="true" tabindex="-1">' + lang.shortcut.close + '</a>' +
                   '<div class="title">' + lang.shortcut.shortcuts + '</div>' +
                   (agent.isMac ? tplShortcutTable(lang, options) : replaceMacKeys(tplShortcutTable(lang, options))) +
                   '<p class="text-center">' +
                     '<a href="//summernote.org/" target="_blank">Summernote 0.6.16</a> · ' +
                     '<a href="//github.com/summernote/summernote" target="_blank">Project</a> · ' +
                     '<a href="//github.com/summernote/summernote/issues" target="_blank">Issues</a>' +
                   '</p>';
        return tplDialog('note-help-dialog', '', body, '');
      ***REMOVED***
    ***REMOVED***;

    var tplDialogs = function (lang, options) {
      var dialogs = '';

      $.each(tplDialogInfo, function (idx, tplDialog) {
        dialogs += tplDialog(lang, options);
      ***REMOVED***);

      return '<div class="note-dialog">' + dialogs + '</div>';
    ***REMOVED***;

    var tplStatusbar = function () {
      return '<div class="note-resizebar">' +
               '<div class="note-icon-bar"></div>' +
               '<div class="note-icon-bar"></div>' +
               '<div class="note-icon-bar"></div>' +
             '</div>';
    ***REMOVED***;

    var representShortcut = function (str) {
      if (agent.isMac) {
        str = str.replace('CMD', '⌘').replace('SHIFT', '⇧');
      ***REMOVED***

      return str.replace('BACKSLASH', '\\')
                .replace('SLASH', '/')
                .replace('LEFTBRACKET', '[')
                .replace('RIGHTBRACKET', ']');
    ***REMOVED***;

    /**
     * createTooltip
     *
     * @param {jQuery***REMOVED*** $container
     * @param {Object***REMOVED*** keyMap
     * @param {String***REMOVED*** [sPlacement]
     */
    var createTooltip = function ($container, keyMap, sPlacement) {
      var invertedKeyMap = func.invertObject(keyMap);
      var $buttons = $container.find('button');

      $buttons.each(function (i, elBtn) {
        var $btn = $(elBtn);
        var sShortcut = invertedKeyMap[$btn.data('event')];
        if (sShortcut) {
          $btn.attr('title', function (i, v) {
            return v + ' (' + representShortcut(sShortcut) + ')';
          ***REMOVED***);
        ***REMOVED***
      // bootstrap tooltip on btn-group bug
      // https://github.com/twbs/bootstrap/issues/5687
      ***REMOVED***).tooltip({
        container: 'body',
        trigger: 'hover',
        placement: sPlacement || 'top'
      ***REMOVED***).on('click', function () {
        $(this).tooltip('hide');
      ***REMOVED***);
    ***REMOVED***;

    // createPalette
    var createPalette = function ($container, options) {
      var colorInfo = options.colors;
      $container.find('.note-color-palette').each(function () {
        var $palette = $(this), eventName = $palette.attr('data-target-event');
        var paletteContents = [];
        for (var row = 0, lenRow = colorInfo.length; row < lenRow; row++) {
          var colors = colorInfo[row];
          var buttons = [];
          for (var col = 0, lenCol = colors.length; col < lenCol; col++) {
            var color = colors[col];
            buttons.push(['<button type="button" class="note-color-btn" style="background-color:', color,
                           ';" data-event="', eventName,
                           '" data-value="', color,
                           '" title="', color,
                           '" data-toggle="button" tabindex="-1"></button>'].join(''));
          ***REMOVED***
          paletteContents.push('<div class="note-color-row">' + buttons.join('') + '</div>');
        ***REMOVED***
        $palette.html(paletteContents.join(''));
      ***REMOVED***);
    ***REMOVED***;

    /**
     * create summernote layout (air mode)
     *
     * @param {jQuery***REMOVED*** $holder
     * @param {Object***REMOVED*** options
     */
    this.createLayoutByAirMode = function ($holder, options) {
      var langInfo = options.langInfo;
      var keyMap = options.keyMap[agent.isMac ? 'mac' : 'pc'];
      var id = func.uniqueId();

      $holder.addClass('note-air-editor note-editable panel-body');
      $holder.attr({
        'id': 'note-editor-' + id,
        'contentEditable': true
      ***REMOVED***);

      var body = document.body;

      // create Popover
      var $popover = $(tplPopovers(langInfo, options));
      $popover.addClass('note-air-layout');
      $popover.attr('id', 'note-popover-' + id);
      $popover.appendTo(body);
      createTooltip($popover, keyMap);
      createPalette($popover, options);

      // create Handle
      var $handle = $(tplHandles(options));
      $handle.addClass('note-air-layout');
      $handle.attr('id', 'note-handle-' + id);
      $handle.appendTo(body);

      // create Dialog
      var $dialog = $(tplDialogs(langInfo, options));
      $dialog.addClass('note-air-layout');
      $dialog.attr('id', 'note-dialog-' + id);
      $dialog.find('button.close, a.modal-close').click(function () {
        $(this).closest('.modal').modal('hide');
      ***REMOVED***);
      $dialog.appendTo(body);
    ***REMOVED***;

    /**
     * create summernote layout (normal mode)
     *
     * @param {jQuery***REMOVED*** $holder
     * @param {Object***REMOVED*** options
     */
    this.createLayoutByFrame = function ($holder, options) {
      var langInfo = options.langInfo;

      //01. create Editor
      var $editor = $('<div class="note-editor panel panel-default" />');
      if (options.width) {
        $editor.width(options.width);
      ***REMOVED***

      //02. statusbar (resizebar)
      if (options.height > 0) {
        $('<div class="note-statusbar">' + (options.disableResizeEditor ? '' : tplStatusbar()) + '</div>').prependTo($editor);
      ***REMOVED***

      //03 editing area
      var $editingArea = $('<div class="note-editing-area" />');
      //03. create editable
      var isContentEditable = !$holder.is(':disabled');
      var $editable = $('<div class="note-editable panel-body" contentEditable="' + isContentEditable + '"></div>').prependTo($editingArea);
      
      if (options.height) {
        $editable.height(options.height);
      ***REMOVED***
      if (options.direction) {
        $editable.attr('dir', options.direction);
      ***REMOVED***
      var placeholder = $holder.attr('placeholder') || options.placeholder;
      if (placeholder) {
        $editable.attr('data-placeholder', placeholder);
      ***REMOVED***

      $editable.html(dom.html($holder) || dom.emptyPara);

      //031. create codable
      $('<textarea class="note-codable"></textarea>').prependTo($editingArea);

      //04. create Popover
      var $popover = $(tplPopovers(langInfo, options)).prependTo($editingArea);
      createPalette($popover, options);
      createTooltip($popover, keyMap);

      //05. handle(control selection, ...)
      $(tplHandles(options)).prependTo($editingArea);

      $editingArea.prependTo($editor);

      //06. create Toolbar
      var $toolbar = $('<div class="note-toolbar panel-heading" />');
      for (var idx = 0, len = options.toolbar.length; idx < len; idx ++) {
        var groupName = options.toolbar[idx][0];
        var groupButtons = options.toolbar[idx][1];

        var $group = $('<div class="note-' + groupName + ' btn-group" />');
        for (var i = 0, btnLength = groupButtons.length; i < btnLength; i++) {
          var buttonInfo = tplButtonInfo[groupButtons[i]];
          // continue creating toolbar even if a button doesn't exist
          if (!$.isFunction(buttonInfo)) { continue; ***REMOVED***

          var $button = $(buttonInfo(langInfo, options));
          $button.attr('data-name', groupButtons[i]);  // set button's alias, becuase to get button element from $toolbar
          $group.append($button);
        ***REMOVED***
        $toolbar.append($group);
      ***REMOVED***

      var keyMap = options.keyMap[agent.isMac ? 'mac' : 'pc'];
      createPalette($toolbar, options);
      createTooltip($toolbar, keyMap, 'bottom');
      $toolbar.prependTo($editor);

      //07. create Dropzone
      $('<div class="note-dropzone"><div class="note-dropzone-message"></div></div>').prependTo($editor);

      //08. create Dialog
      var $dialogContainer = options.dialogsInBody ? $(document.body) : $editor;
      var $dialog = $(tplDialogs(langInfo, options)).prependTo($dialogContainer);
      $dialog.find('button.close, a.modal-close').click(function () {
        $(this).closest('.modal').modal('hide');
      ***REMOVED***);

      //09. Editor/Holder switch
      $editor.insertAfter($holder);
      $holder.hide();
    ***REMOVED***;

    this.hasNoteEditor = function ($holder) {
      return this.noteEditorFromHolder($holder).length > 0;
    ***REMOVED***;

    this.noteEditorFromHolder = function ($holder) {
      if ($holder.hasClass('note-air-editor')) {
        return $holder;
      ***REMOVED*** else if ($holder.next().hasClass('note-editor')) {
        return $holder.next();
      ***REMOVED*** else {
        return $();
      ***REMOVED***
    ***REMOVED***;

    /**
     * create summernote layout
     *
     * @param {jQuery***REMOVED*** $holder
     * @param {Object***REMOVED*** options
     */
    this.createLayout = function ($holder, options) {
      if (options.airMode) {
        this.createLayoutByAirMode($holder, options);
      ***REMOVED*** else {
        this.createLayoutByFrame($holder, options);
      ***REMOVED***
    ***REMOVED***;

    /**
     * returns layoutInfo from holder
     *
     * @param {jQuery***REMOVED*** $holder - placeholder
     * @return {Object***REMOVED***
     */
    this.layoutInfoFromHolder = function ($holder) {
      var $editor = this.noteEditorFromHolder($holder);
      if (!$editor.length) {
        return;
      ***REMOVED***

      // connect $holder to $editor
      $editor.data('holder', $holder);

      return dom.buildLayoutInfo($editor);
    ***REMOVED***;

    /**
     * removeLayout
     *
     * @param {jQuery***REMOVED*** $holder - placeholder
     * @param {Object***REMOVED*** layoutInfo
     * @param {Object***REMOVED*** options
     *
     */
    this.removeLayout = function ($holder, layoutInfo, options) {
      if (options.airMode) {
        $holder.removeClass('note-air-editor note-editable')
               .removeAttr('id contentEditable');

        layoutInfo.popover().remove();
        layoutInfo.handle().remove();
        layoutInfo.dialog().remove();
      ***REMOVED*** else {
        $holder.html(layoutInfo.editable().html());

        if (options.dialogsInBody) {
          layoutInfo.dialog().remove();
        ***REMOVED***
        layoutInfo.editor().remove();
        $holder.show();
      ***REMOVED***
    ***REMOVED***;

    /**
     *
     * @return {Object***REMOVED***
     * @return {function(label, options=):string***REMOVED*** return.button {@link #tplButton function to make text button***REMOVED***
     * @return {function(iconClass, options=):string***REMOVED*** return.iconButton {@link #tplIconButton function to make icon button***REMOVED***
     * @return {function(className, title=, body=, footer=):string***REMOVED*** return.dialog {@link #tplDialog function to make dialog***REMOVED***
     */
    this.getTemplate = function () {
      return {
        button: tplButton,
        iconButton: tplIconButton,
        dialog: tplDialog
      ***REMOVED***;
    ***REMOVED***;

    /**
     * add button information
     *
     * @param {String***REMOVED*** name button name
     * @param {Function***REMOVED*** buttonInfo function to make button, reference to {@link #tplButton***REMOVED***,{@link #tplIconButton***REMOVED***
     */
    this.addButtonInfo = function (name, buttonInfo) {
      tplButtonInfo[name] = buttonInfo;
    ***REMOVED***;

    /**
     *
     * @param {String***REMOVED*** name
     * @param {Function***REMOVED*** dialogInfo function to make dialog, reference to {@link #tplDialog***REMOVED***
     */
    this.addDialogInfo = function (name, dialogInfo) {
      tplDialogInfo[name] = dialogInfo;
    ***REMOVED***;
  ***REMOVED***;


  // jQuery namespace for summernote
  /**
   * @class $.summernote 
   * 
   * summernote attribute  
   * 
   * @mixin defaults
   * @singleton  
   * 
   */
  $.summernote = $.summernote || {***REMOVED***;

  // extends default settings
  //  - $.summernote.version
  //  - $.summernote.options
  //  - $.summernote.lang
  $.extend($.summernote, defaults);

  var renderer = new Renderer();
  var eventHandler = new EventHandler();

  $.extend($.summernote, {
    /** @property {Renderer***REMOVED*** */
    renderer: renderer,
    /** @property {EventHandler***REMOVED*** */
    eventHandler: eventHandler,
    /** 
     * @property {Object***REMOVED*** core 
     * @property {core.agent***REMOVED*** core.agent 
     * @property {core.dom***REMOVED*** core.dom
     * @property {core.range***REMOVED*** core.range 
     */
    core: {
      agent: agent,
      list : list,
      dom: dom,
      range: range
    ***REMOVED***,
    /** 
     * @property {Object***REMOVED*** 
     * pluginEvents event list for plugins
     * event has name and callback function.
     * 
     * ``` 
     * $.summernote.addPlugin({
     *     events : {
     *          'hello' : function(layoutInfo, value, $target) {
     *              console.log('event name is hello, value is ' + value );
     *          ***REMOVED***
     *     ***REMOVED***     
     * ***REMOVED***)
     * ```
     * 
     * * event name is data-event property.
     * * layoutInfo is a summernote layout information.
     * * value is data-value property.
     */
    pluginEvents: {***REMOVED***,

    plugins : []
  ***REMOVED***);

  /**
   * @method addPlugin
   *
   * add Plugin in Summernote 
   * 
   * Summernote can make a own plugin.
   *
   * ### Define plugin
   * ```
   * // get template function  
   * var tmpl = $.summernote.renderer.getTemplate();
   * 
   * // add a button   
   * $.summernote.addPlugin({
   *     buttons : {
   *        // "hello"  is button's namespace.      
   *        "hello" : function(lang, options) {
   *            // make icon button by template function          
   *            return tmpl.iconButton(options.iconPrefix + 'header', {
   *                // callback function name when button clicked 
   *                event : 'hello',
   *                // set data-value property                 
   *                value : 'hello',                
   *                hide : true
   *            ***REMOVED***);           
   *        ***REMOVED***
   *     
   *     ***REMOVED***, 
   *     
   *     events : {
   *        "hello" : function(layoutInfo, value) {
   *            // here is event code 
   *        ***REMOVED***
   *     ***REMOVED***     
   * ***REMOVED***);
   * ``` 
   * ### Use a plugin in toolbar
   * 
   * ``` 
   *    $("#editor").summernote({
   *    ...
   *    toolbar : [
   *        // display hello plugin in toolbar     
   *        ['group', [ 'hello' ]]
   *    ]
   *    ...    
   *    ***REMOVED***);
   * ```
   *  
   *  
   * @param {Object***REMOVED*** plugin
   * @param {Object***REMOVED*** [plugin.buttons] define plugin button. for detail, see to Renderer.addButtonInfo
   * @param {Object***REMOVED*** [plugin.dialogs] define plugin dialog. for detail, see to Renderer.addDialogInfo
   * @param {Object***REMOVED*** [plugin.events] add event in $.summernote.pluginEvents 
   * @param {Object***REMOVED*** [plugin.langs] update $.summernote.lang
   * @param {Object***REMOVED*** [plugin.options] update $.summernote.options
   */
  $.summernote.addPlugin = function (plugin) {

    // save plugin list
    $.summernote.plugins.push(plugin);

    if (plugin.buttons) {
      $.each(plugin.buttons, function (name, button) {
        renderer.addButtonInfo(name, button);
      ***REMOVED***);
    ***REMOVED***

    if (plugin.dialogs) {
      $.each(plugin.dialogs, function (name, dialog) {
        renderer.addDialogInfo(name, dialog);
      ***REMOVED***);
    ***REMOVED***

    if (plugin.events) {
      $.each(plugin.events, function (name, event) {
        $.summernote.pluginEvents[name] = event;
      ***REMOVED***);
    ***REMOVED***

    if (plugin.langs) {
      $.each(plugin.langs, function (locale, lang) {
        if ($.summernote.lang[locale]) {
          $.extend($.summernote.lang[locale], lang);
        ***REMOVED***
      ***REMOVED***);
    ***REMOVED***

    if (plugin.options) {
      $.extend($.summernote.options, plugin.options);
    ***REMOVED***
  ***REMOVED***;

  /*
   * extend $.fn
   */
  $.fn.extend({
    /**
     * @method
     * Initialize summernote
     *  - create editor layout and attach Mouse and keyboard events.
     * 
     * ```
     * $("#summernote").summernote( { options ..***REMOVED*** );
     * ```
     *   
     * @member $.fn
     * @param {Object|String***REMOVED*** options reference to $.summernote.options
     * @return {this***REMOVED***
     */
    summernote: function () {
      // check first argument's type
      //  - {String***REMOVED***: External API call {{module***REMOVED******REMOVED***.{{method***REMOVED******REMOVED***
      //  - {Object***REMOVED***: init options
      var type = $.type(list.head(arguments));
      var isExternalAPICalled = type === 'string';
      var hasInitOptions = type === 'object';

      // extend default options with custom user options
      var options = hasInitOptions ? list.head(arguments) : {***REMOVED***;

      options = $.extend({***REMOVED***, $.summernote.options, options);
      options.icons = $.extend({***REMOVED***, $.summernote.options.icons, options.icons);

      // Include langInfo in options for later use, e.g. for image drag-n-drop
      // Setup language info with en-US as default
      options.langInfo = $.extend(true, {***REMOVED***, $.summernote.lang['en-US'], $.summernote.lang[options.lang]);

      // override plugin options
      if (!isExternalAPICalled && hasInitOptions) {
        for (var i = 0, len = $.summernote.plugins.length; i < len; i++) {
          var plugin = $.summernote.plugins[i];

          if (options.plugin[plugin.name]) {
            $.summernote.plugins[i] = $.extend(true, plugin, options.plugin[plugin.name]);
          ***REMOVED***
        ***REMOVED***
      ***REMOVED***

      this.each(function (idx, holder) {
        var $holder = $(holder);

        // if layout isn't created yet, createLayout and attach events
        if (!renderer.hasNoteEditor($holder)) {
          renderer.createLayout($holder, options);

          var layoutInfo = renderer.layoutInfoFromHolder($holder);
          $holder.data('layoutInfo', layoutInfo);

          eventHandler.attach(layoutInfo, options);
          eventHandler.attachCustomEvent(layoutInfo, options);
        ***REMOVED***
      ***REMOVED***);

      var $first = this.first();
      if ($first.length) {
        var layoutInfo = renderer.layoutInfoFromHolder($first);

        // external API
        if (isExternalAPICalled) {
          var moduleAndMethod = list.head(list.from(arguments));
          var args = list.tail(list.from(arguments));

          // TODO now external API only works for editor
          var params = [moduleAndMethod, layoutInfo.editable()].concat(args);
          return eventHandler.invoke.apply(eventHandler, params);
        ***REMOVED*** else if (options.focus) {
          // focus on first editable element for initialize editor
          layoutInfo.editable().focus();
        ***REMOVED***
      ***REMOVED***

      return this;
    ***REMOVED***,

    /**
     * @method 
     * 
     * get the HTML contents of note or set the HTML contents of note.
     *
     * * get contents 
     * ```
     * var content = $("#summernote").code();
     * ```
     * * set contents 
     *
     * ```
     * $("#summernote").code(html);
     * ```
     *
     * @member $.fn 
     * @param {String***REMOVED*** [html] - HTML contents(optional, set)
     * @return {this|String***REMOVED*** - context(set) or HTML contents of note(get).
     */
    code: function (html) {
      // get the HTML contents of note
      if (html === undefined) {
        var $holder = this.first();
        if (!$holder.length) {
          return;
        ***REMOVED***

        var layoutInfo = renderer.layoutInfoFromHolder($holder);
        var $editable = layoutInfo && layoutInfo.editable();

        if ($editable && $editable.length) {
          var isCodeview = eventHandler.invoke('codeview.isActivated', layoutInfo);
          eventHandler.invoke('codeview.sync', layoutInfo);
          return isCodeview ? layoutInfo.codable().val() :
                              layoutInfo.editable().html();
        ***REMOVED***
        return dom.value($holder);
      ***REMOVED***

      // set the HTML contents of note
      this.each(function (i, holder) {
        var layoutInfo = renderer.layoutInfoFromHolder($(holder));
        var $editable = layoutInfo && layoutInfo.editable();
        if ($editable) {
          $editable.html(html);
        ***REMOVED***
      ***REMOVED***);

      return this;
    ***REMOVED***,

    /**
     * @method
     * 
     * destroy Editor Layout and detach Key and Mouse Event
     *
     * @member $.fn
     * @return {this***REMOVED***
     */
    destroy: function () {
      this.each(function (idx, holder) {
        var $holder = $(holder);

        if (!renderer.hasNoteEditor($holder)) {
          return;
        ***REMOVED***

        var info = renderer.layoutInfoFromHolder($holder);
        var options = info.editor().data('options');

        eventHandler.detach(info, options);
        renderer.removeLayout($holder, info, options);
      ***REMOVED***);

      return this;
    ***REMOVED***
  ***REMOVED***);
***REMOVED***));
