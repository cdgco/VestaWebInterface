/*!
 * Cropper v0.11.1
 * https://github.com/fengyuanchen/cropper
 *
 * Copyright (c) 2014-2015 Fengyuan Chen and contributors
 * Released under the MIT license
 *
 * Date: 2015-08-22T04:55:04.780Z
 */

(function (factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as anonymous module.
    define(['jquery'], factory);
  ***REMOVED*** else if (typeof exports === 'object') {
    // Node / CommonJS
    factory(require('jquery'));
  ***REMOVED*** else {
    // Browser globals.
    factory(jQuery);
  ***REMOVED***
***REMOVED***)(function ($) {

  'use strict';

  // Globals
  var $window = $(window);
  var $document = $(document);
  var location = window.location;

  // Constants
  var NAMESPACE = 'cropper';
  var PREVIEW = 'preview.' + NAMESPACE;

  // Classes
  var CLASS_MODAL = 'cropper-modal';
  var CLASS_HIDE = 'cropper-hide';
  var CLASS_HIDDEN = 'cropper-hidden';
  var CLASS_INVISIBLE = 'cropper-invisible';
  var CLASS_MOVE = 'cropper-move';
  var CLASS_CROP = 'cropper-crop';
  var CLASS_DISABLED = 'cropper-disabled';
  var CLASS_BG = 'cropper-bg';

  // Events
  var EVENT_MOUSE_DOWN = 'mousedown touchstart pointerdown MSPointerDown';
  var EVENT_MOUSE_MOVE = 'mousemove touchmove pointermove MSPointerMove';
  var EVENT_MOUSE_UP = 'mouseup touchend touchcancel pointerup pointercancel MSPointerUp MSPointerCancel';
  var EVENT_WHEEL = 'wheel mousewheel DOMMouseScroll';
  var EVENT_DBLCLICK = 'dblclick';
  var EVENT_LOAD = 'load.' + NAMESPACE;
  var EVENT_ERROR = 'error.' + NAMESPACE;
  var EVENT_RESIZE = 'resize.' + NAMESPACE; // Bind to window with namespace
  var EVENT_BUILD = 'build.' + NAMESPACE;
  var EVENT_BUILT = 'built.' + NAMESPACE;
  var EVENT_CROP_START = 'cropstart.' + NAMESPACE;
  var EVENT_CROP_MOVE = 'cropmove.' + NAMESPACE;
  var EVENT_CROP_END = 'cropend.' + NAMESPACE;
  var EVENT_CROP = 'crop.' + NAMESPACE;
  var EVENT_ZOOM = 'zoom.' + NAMESPACE;

  // RegExps
  var REGEXP_ACTIONS = /^(e|w|s|n|se|sw|ne|nw|all|crop|move|zoom)$/;

  // Actions
  var ACTION_EAST = 'e';
  var ACTION_WEST = 'w';
  var ACTION_SOUTH = 's';
  var ACTION_NORTH = 'n';
  var ACTION_SOUTH_EAST = 'se';
  var ACTION_SOUTH_WEST = 'sw';
  var ACTION_NORTH_EAST = 'ne';
  var ACTION_NORTH_WEST = 'nw';
  var ACTION_ALL = 'all';
  var ACTION_CROP = 'crop';
  var ACTION_MOVE = 'move';
  var ACTION_ZOOM = 'zoom';
  var ACTION_NONE = 'none';

  // Supports
  var SUPPORT_CANVAS = $.isFunction($('<canvas>')[0].getContext);

  // Maths
  var sqrt = Math.sqrt;
  var min = Math.min;
  var max = Math.max;
  var abs = Math.abs;
  var sin = Math.sin;
  var cos = Math.cos;
  var num = parseFloat;

  // Prototype
  var prototype = {***REMOVED***;

  function isNumber(n) {
    return typeof n === 'number' && !isNaN(n);
  ***REMOVED***

  function isUndefined(n) {
    return typeof n === 'undefined';
  ***REMOVED***

  function toArray(obj, offset) {
    var args = [];

    // This is necessary for IE8
    if (isNumber(offset)) {
      args.push(offset);
    ***REMOVED***

    return args.slice.apply(obj, args);
  ***REMOVED***

  // Custom proxy to avoid jQuery's guid
  function proxy(fn, context) {
    var args = toArray(arguments, 2);

    return function () {
      return fn.apply(context, args.concat(toArray(arguments)));
    ***REMOVED***;
  ***REMOVED***

  function isCrossOriginURL(url) {
    var parts = url.match(/^(https?:)\/\/([^\:\/\?#]+):?(\d*)/i);

    return parts && (
      parts[1] !== location.protocol ||
      parts[2] !== location.hostname ||
      parts[3] !== location.port
    );
  ***REMOVED***

  function addTimestamp(url) {
    var timestamp = 'timestamp=' + (new Date()).getTime();

    return (url + (url.indexOf('?') === -1 ? '?' : '&') + timestamp);
  ***REMOVED***

  function getImageData(image) {
    var naturalWidth = image.naturalWidth;
    var naturalHeight = image.naturalHeight;
    var newImage;

    // IE8
    if (!naturalWidth) {
      newImage = new Image();
      newImage.src = image.src;
      naturalWidth = newImage.width;
      naturalHeight = newImage.height;
    ***REMOVED***

    return {
      naturalWidth: naturalWidth,
      naturalHeight: naturalHeight,
      aspectRatio: naturalWidth / naturalHeight
    ***REMOVED***;
  ***REMOVED***

  function getTransform(options) {
    var transforms = [];
    var rotate = options.rotate;
    var scaleX = options.scaleX;
    var scaleY = options.scaleY;

    if (isNumber(rotate)) {
      transforms.push('rotate(' + rotate + 'deg)');
    ***REMOVED***

    if (isNumber(scaleX) && isNumber(scaleY)) {
      transforms.push('scale(' + scaleX + ',' + scaleY + ')');
    ***REMOVED***

    return transforms.length ? transforms.join(' ') : 'none';
  ***REMOVED***

  function getRotatedSizes(data, reverse) {
    var deg = abs(data.degree) % 180;
    var arc = (deg > 90 ? (180 - deg) : deg) * Math.PI / 180;
    var sinArc = sin(arc);
    var cosArc = cos(arc);
    var width = data.width;
    var height = data.height;
    var aspectRatio = data.aspectRatio;
    var newWidth;
    var newHeight;

    if (!reverse) {
      newWidth = width * cosArc + height * sinArc;
      newHeight = width * sinArc + height * cosArc;
    ***REMOVED*** else {
      newWidth = width / (cosArc + sinArc / aspectRatio);
      newHeight = newWidth / aspectRatio;
    ***REMOVED***

    return {
      width: newWidth,
      height: newHeight
    ***REMOVED***;
  ***REMOVED***

  function getSourceCanvas(image, data) {
    var canvas = $('<canvas>')[0];
    var context = canvas.getContext('2d');
    var x = 0;
    var y = 0;
    var width = data.naturalWidth;
    var height = data.naturalHeight;
    var rotate = data.rotate;
    var scaleX = data.scaleX;
    var scaleY = data.scaleY;
    var scalable = isNumber(scaleX) && isNumber(scaleY) && (scaleX !== 1 || scaleY !== 1);
    var rotatable = isNumber(rotate) && rotate !== 0;
    var advanced = rotatable || scalable;
    var canvasWidth = width;
    var canvasHeight = height;
    var translateX;
    var translateY;
    var rotated;

    if (scalable) {
      translateX = width / 2;
      translateY = height / 2;
    ***REMOVED***

    if (rotatable) {
      rotated = getRotatedSizes({
        width: width,
        height: height,
        degree: rotate
      ***REMOVED***);

      canvasWidth = rotated.width;
      canvasHeight = rotated.height;
      translateX = rotated.width / 2;
      translateY = rotated.height / 2;
    ***REMOVED***

    canvas.width = canvasWidth;
    canvas.height = canvasHeight;

    if (advanced) {
      x = -width / 2;
      y = -height / 2;

      context.save();
      context.translate(translateX, translateY);
    ***REMOVED***

    if (rotatable) {
      context.rotate(rotate * Math.PI / 180);
    ***REMOVED***

    // Should call `scale` after rotated
    if (scalable) {
      context.scale(scaleX, scaleY);
    ***REMOVED***

    context.drawImage(image, x, y, width, height);

    if (advanced) {
      context.restore();
    ***REMOVED***

    return canvas;
  ***REMOVED***

  function Cropper(element, options) {
    this.$element = $(element);
    this.options = $.extend({***REMOVED***, Cropper.DEFAULTS, $.isPlainObject(options) && options);
    this.ready = false;
    this.built = false;
    this.complete = false;
    this.rotated = false;
    this.cropped = false;
    this.disabled = false;
    this.replaced = false;
    this.isImg = false;
    this.originalUrl = '';
    this.canvas = null;
    this.cropBox = null;
    this.init();
  ***REMOVED***

  $.extend(prototype, {
    init: function () {
      var $this = this.$element;
      var url;

      if ($this.is('img')) {
        this.isImg = true;

        // Should use `$.fn.attr` here. e.g.: "img/picture.jpg"
        this.originalUrl = url = $this.attr('src');

        // Stop when it's a blank image
        if (!url) {
          return;
        ***REMOVED***

        // Should use `$.fn.prop` here. e.g.: "http://example.com/img/picture.jpg"
        url = $this.prop('src');
      ***REMOVED*** else if ($this.is('canvas') && SUPPORT_CANVAS) {
        url = $this[0].toDataURL();
      ***REMOVED***

      this.load(url);
    ***REMOVED***,

    // A shortcut for triggering custom events
    trigger: function (type, data) {
      var e = $.Event(type, data);

      this.$element.trigger(e);

      return e.isDefaultPrevented();
    ***REMOVED***,

    load: function (url) {
      var options = this.options;
      var $this = this.$element;
      var crossOrigin = '';
      var bustCacheUrl;
      var $clone;

      if (!url) {
        return;
      ***REMOVED***

      this.url = url;

      // Trigger build event first
      $this.one(EVENT_BUILD, options.build);

      if (this.trigger(EVENT_BUILD)) {
        return;
      ***REMOVED***

      if (options.checkImageOrigin && isCrossOriginURL(url)) {
        crossOrigin = ' crossOrigin="anonymous"';

        // Bust cache (#148), only when there was not a "crossOrigin" property
        if (!$this.prop('crossOrigin')) {
          bustCacheUrl = addTimestamp(url);
        ***REMOVED***
      ***REMOVED***

      this.$clone = $clone = $('<img' + crossOrigin + ' src="' + (bustCacheUrl || url) + '">');

      if (this.isImg) {
        if ($this[0].complete) {
          this.start();
        ***REMOVED*** else {
          $this.one(EVENT_LOAD, $.proxy(this.start, this));
        ***REMOVED***
      ***REMOVED*** else {
        $clone.
          one(EVENT_LOAD, $.proxy(this.start, this)).
          one(EVENT_ERROR, $.proxy(this.stop, this)).
          addClass(CLASS_HIDE).
          insertAfter($this);
      ***REMOVED***
    ***REMOVED***,

    start: function () {
      this.image = getImageData(this.isImg ? this.$element[0] : this.$clone[0]);
      this.ready = true;
      this.build();
    ***REMOVED***,

    stop: function () {
      this.$clone.remove();
      this.$clone = null;
    ***REMOVED***
  ***REMOVED***);

  $.extend(prototype, {
    build: function () {
      var options = this.options;
      var $this = this.$element;
      var $clone = this.$clone;
      var $cropper;
      var $cropBox;
      var $face;

      if (!this.ready) {
        return;
      ***REMOVED***

      // Unbuild first when replace
      if (this.built) {
        this.unbuild();
      ***REMOVED***

      // Create cropper elements
      this.$container = $this.parent();
      this.$cropper = $cropper = $(Cropper.TEMPLATE);
      this.$canvas = $cropper.find('.cropper-canvas').append($clone);
      this.$dragBox = $cropper.find('.cropper-drag-box');
      this.$cropBox = $cropBox = $cropper.find('.cropper-crop-box');
      this.$viewBox = $cropper.find('.cropper-view-box');
      this.$face = $face = $cropBox.find('.cropper-face');

      // Hide the original image
      $this.addClass(CLASS_HIDDEN).after($cropper);

      // Show the clone image if is hidden
      if (!this.isImg) {
        $clone.removeClass(CLASS_HIDE);
      ***REMOVED***

      this.initPreview();
      this.bind();

      // Format aspect ratio (0 -> NaN)
      options.aspectRatio = num(options.aspectRatio) || NaN;

      if (options.autoCrop) {
        this.cropped = true;

        if (options.modal) {
          this.$dragBox.addClass(CLASS_MODAL);
        ***REMOVED***
      ***REMOVED*** else {
        $cropBox.addClass(CLASS_HIDDEN);
      ***REMOVED***

      if (!options.guides) {
        $cropBox.find('.cropper-dashed').addClass(CLASS_HIDDEN);
      ***REMOVED***

      if (!options.center) {
        $cropBox.find('.cropper-center').addClass(CLASS_HIDDEN);
      ***REMOVED***

      if (options.cropBoxMovable) {
        $face.addClass(CLASS_MOVE).data('action', ACTION_ALL);
      ***REMOVED***

      if (!options.highlight) {
        $face.addClass(CLASS_INVISIBLE);
      ***REMOVED***

      if (options.background) {
        $cropper.addClass(CLASS_BG);
      ***REMOVED***

      if (!options.cropBoxResizable) {
        $cropBox.find('.cropper-line, .cropper-point').addClass(CLASS_HIDDEN);
      ***REMOVED***

      this.setDragMode(options.dragCrop ? ACTION_CROP : (options.movable ? ACTION_MOVE : ACTION_NONE));

      this.render();
      this.built = true;
      this.setData(options.data);
      $this.one(EVENT_BUILT, options.built);

      // Trigger the built event asynchronously to keep `data('cropper')` is defined
      setTimeout($.proxy(function () {
        this.trigger(EVENT_BUILT);
        this.complete = true;
      ***REMOVED***, this), 0);
    ***REMOVED***,

    unbuild: function () {
      if (!this.built) {
        return;
      ***REMOVED***

      this.built = false;
      this.initialImage = null;

      // Clear `initialCanvas` is necessary when replace
      this.initialCanvas = null;
      this.initialCropBox = null;
      this.container = null;
      this.canvas = null;

      // Clear `cropBox` is necessary when replace
      this.cropBox = null;
      this.unbind();

      this.resetPreview();
      this.$preview = null;

      this.$viewBox = null;
      this.$cropBox = null;
      this.$dragBox = null;
      this.$canvas = null;
      this.$container = null;

      this.$cropper.remove();
      this.$cropper = null;
    ***REMOVED***
  ***REMOVED***);

  $.extend(prototype, {
    render: function () {
      this.initContainer();
      this.initCanvas();
      this.initCropBox();

      this.renderCanvas();

      if (this.cropped) {
        this.renderCropBox();
      ***REMOVED***
    ***REMOVED***,

    initContainer: function () {
      var options = this.options;
      var $this = this.$element;
      var $container = this.$container;
      var $cropper = this.$cropper;

      $cropper.addClass(CLASS_HIDDEN);
      $this.removeClass(CLASS_HIDDEN);

      $cropper.css((this.container = {
        width: max($container.width(), num(options.minContainerWidth) || 200),
        height: max($container.height(), num(options.minContainerHeight) || 100)
      ***REMOVED***));

      $this.addClass(CLASS_HIDDEN);
      $cropper.removeClass(CLASS_HIDDEN);
    ***REMOVED***,

    // Canvas (image wrapper)
    initCanvas: function () {
      var container = this.container;
      var containerWidth = container.width;
      var containerHeight = container.height;
      var image = this.image;
      var aspectRatio = image.aspectRatio;
      var canvas = {
            aspectRatio: aspectRatio,
            width: containerWidth,
            height: containerHeight
          ***REMOVED***;

      if (containerHeight * aspectRatio > containerWidth) {
        canvas.height = containerWidth / aspectRatio;
      ***REMOVED*** else {
        canvas.width = containerHeight * aspectRatio;
      ***REMOVED***

      canvas.oldLeft = canvas.left = (containerWidth - canvas.width) / 2;
      canvas.oldTop = canvas.top = (containerHeight - canvas.height) / 2;

      this.canvas = canvas;
      this.limitCanvas(true, true);
      this.initialImage = $.extend({***REMOVED***, image);
      this.initialCanvas = $.extend({***REMOVED***, canvas);
    ***REMOVED***,

    limitCanvas: function (size, position) {
      var options = this.options;
      var strict = options.strict;
      var container = this.container;
      var containerWidth = container.width;
      var containerHeight = container.height;
      var canvas = this.canvas;
      var aspectRatio = canvas.aspectRatio;
      var cropBox = this.cropBox;
      var cropped = this.cropped && cropBox;
      var initialCanvas = this.initialCanvas || canvas;
      var initialCanvasWidth = initialCanvas.width;
      var initialCanvasHeight = initialCanvas.height;
      var minCanvasWidth;
      var minCanvasHeight;

      if (size) {
        minCanvasWidth = num(options.minCanvasWidth) || 0;
        minCanvasHeight = num(options.minCanvasHeight) || 0;

        if (minCanvasWidth) {
          if (strict) {
            minCanvasWidth = max(cropped ? cropBox.width : initialCanvasWidth, minCanvasWidth);
          ***REMOVED***

          minCanvasHeight = minCanvasWidth / aspectRatio;
        ***REMOVED*** else if (minCanvasHeight) {
          if (strict) {
            minCanvasHeight = max(cropped ? cropBox.height : initialCanvasHeight, minCanvasHeight);
          ***REMOVED***

          minCanvasWidth = minCanvasHeight * aspectRatio;
        ***REMOVED*** else if (strict) {
          if (cropped) {
            minCanvasWidth = cropBox.width;
            minCanvasHeight = cropBox.height;

            if (minCanvasHeight * aspectRatio > minCanvasWidth) {
              minCanvasWidth = minCanvasHeight * aspectRatio;
            ***REMOVED*** else {
              minCanvasHeight = minCanvasWidth / aspectRatio;
            ***REMOVED***
          ***REMOVED*** else {
            minCanvasWidth = initialCanvasWidth;
            minCanvasHeight = initialCanvasHeight;
          ***REMOVED***
        ***REMOVED***

        $.extend(canvas, {
          minWidth: minCanvasWidth,
          minHeight: minCanvasHeight,
          maxWidth: Infinity,
          maxHeight: Infinity
        ***REMOVED***);
      ***REMOVED***

      if (position) {
        if (strict) {
          if (cropped) {
            canvas.minLeft = min(cropBox.left, (cropBox.left + cropBox.width) - canvas.width);
            canvas.minTop = min(cropBox.top, (cropBox.top + cropBox.height) - canvas.height);
            canvas.maxLeft = cropBox.left;
            canvas.maxTop = cropBox.top;
          ***REMOVED*** else {
            canvas.minLeft = min(0, containerWidth - canvas.width);
            canvas.minTop = min(0, containerHeight - canvas.height);
            canvas.maxLeft = max(0, containerWidth - canvas.width);
            canvas.maxTop = max(0, containerHeight - canvas.height);
          ***REMOVED***
        ***REMOVED*** else {
          canvas.minLeft = -canvas.width;
          canvas.minTop = -canvas.height;
          canvas.maxLeft = containerWidth;
          canvas.maxTop = containerHeight;
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***,

    renderCanvas: function (changed) {
      var options = this.options;
      var canvas = this.canvas;
      var image = this.image;
      var aspectRatio;
      var rotated;

      if (this.rotated) {
        this.rotated = false;

        // Computes rotated sizes with image sizes
        rotated = getRotatedSizes({
          width: image.width,
          height: image.height,
          degree: image.rotate
        ***REMOVED***);

        aspectRatio = rotated.width / rotated.height;

        if (aspectRatio !== canvas.aspectRatio) {
          canvas.left -= (rotated.width - canvas.width) / 2;
          canvas.top -= (rotated.height - canvas.height) / 2;
          canvas.width = rotated.width;
          canvas.height = rotated.height;
          canvas.aspectRatio = aspectRatio;
          this.limitCanvas(true, false);
        ***REMOVED***
      ***REMOVED***

      if (canvas.width > canvas.maxWidth || canvas.width < canvas.minWidth) {
        canvas.left = canvas.oldLeft;
      ***REMOVED***

      if (canvas.height > canvas.maxHeight || canvas.height < canvas.minHeight) {
        canvas.top = canvas.oldTop;
      ***REMOVED***

      canvas.width = min(max(canvas.width, canvas.minWidth), canvas.maxWidth);
      canvas.height = min(max(canvas.height, canvas.minHeight), canvas.maxHeight);

      this.limitCanvas(false, true);

      canvas.oldLeft = canvas.left = min(max(canvas.left, canvas.minLeft), canvas.maxLeft);
      canvas.oldTop = canvas.top = min(max(canvas.top, canvas.minTop), canvas.maxTop);

      this.$canvas.css({
        width: canvas.width,
        height: canvas.height,
        left: canvas.left,
        top: canvas.top
      ***REMOVED***);

      this.renderImage();

      if (this.cropped && options.strict) {
        this.limitCropBox(true, true);
      ***REMOVED***

      if (changed) {
        this.output();
      ***REMOVED***
    ***REMOVED***,

    renderImage: function (changed) {
      var canvas = this.canvas;
      var image = this.image;
      var reversed;

      if (image.rotate) {
        reversed = getRotatedSizes({
          width: canvas.width,
          height: canvas.height,
          degree: image.rotate,
          aspectRatio: image.aspectRatio
        ***REMOVED***, true);
      ***REMOVED***

      $.extend(image, reversed ? {
        width: reversed.width,
        height: reversed.height,
        left: (canvas.width - reversed.width) / 2,
        top: (canvas.height - reversed.height) / 2
      ***REMOVED*** : {
        width: canvas.width,
        height: canvas.height,
        left: 0,
        top: 0
      ***REMOVED***);

      this.$clone.css({
        width: image.width,
        height: image.height,
        marginLeft: image.left,
        marginTop: image.top,
        transform: getTransform(image)
      ***REMOVED***);

      if (changed) {
        this.output();
      ***REMOVED***
    ***REMOVED***,

    initCropBox: function () {
      var options = this.options;
      var canvas = this.canvas;
      var aspectRatio = options.aspectRatio;
      var autoCropArea = num(options.autoCropArea) || 0.8;
      var cropBox = {
            width: canvas.width,
            height: canvas.height
          ***REMOVED***;

      if (aspectRatio) {
        if (canvas.height * aspectRatio > canvas.width) {
          cropBox.height = cropBox.width / aspectRatio;
        ***REMOVED*** else {
          cropBox.width = cropBox.height * aspectRatio;
        ***REMOVED***
      ***REMOVED***

      this.cropBox = cropBox;
      this.limitCropBox(true, true);

      // Initialize auto crop area
      cropBox.width = min(max(cropBox.width, cropBox.minWidth), cropBox.maxWidth);
      cropBox.height = min(max(cropBox.height, cropBox.minHeight), cropBox.maxHeight);

      // The width of auto crop area must large than "minWidth", and the height too. (#164)
      cropBox.width = max(cropBox.minWidth, cropBox.width * autoCropArea);
      cropBox.height = max(cropBox.minHeight, cropBox.height * autoCropArea);
      cropBox.oldLeft = cropBox.left = canvas.left + (canvas.width - cropBox.width) / 2;
      cropBox.oldTop = cropBox.top = canvas.top + (canvas.height - cropBox.height) / 2;

      this.initialCropBox = $.extend({***REMOVED***, cropBox);
    ***REMOVED***,

    limitCropBox: function (size, position) {
      var options = this.options;
      var strict = options.strict;
      var container = this.container;
      var containerWidth = container.width;
      var containerHeight = container.height;
      var canvas = this.canvas;
      var cropBox = this.cropBox;
      var aspectRatio = options.aspectRatio;
      var minCropBoxWidth;
      var minCropBoxHeight;

      if (size) {
        minCropBoxWidth = num(options.minCropBoxWidth) || 0;
        minCropBoxHeight = num(options.minCropBoxHeight) || 0;

        // The min/maxCropBoxWidth/Height must less than container width/height
        cropBox.minWidth = min(containerWidth, minCropBoxWidth);
        cropBox.minHeight = min(containerHeight, minCropBoxHeight);
        cropBox.maxWidth = min(containerWidth, strict ? canvas.width : containerWidth);
        cropBox.maxHeight = min(containerHeight, strict ? canvas.height : containerHeight);

        if (aspectRatio) {

          // Compare crop box size with container first
          if (cropBox.maxHeight * aspectRatio > cropBox.maxWidth) {
            cropBox.minHeight = cropBox.minWidth / aspectRatio;
            cropBox.maxHeight = cropBox.maxWidth / aspectRatio;
          ***REMOVED*** else {
            cropBox.minWidth = cropBox.minHeight * aspectRatio;
            cropBox.maxWidth = cropBox.maxHeight * aspectRatio;
          ***REMOVED***
        ***REMOVED***

        // The "minWidth" must be less than "maxWidth", and the "minHeight" too.
        cropBox.minWidth = min(cropBox.maxWidth, cropBox.minWidth);
        cropBox.minHeight = min(cropBox.maxHeight, cropBox.minHeight);
      ***REMOVED***

      if (position) {
        if (strict) {
          cropBox.minLeft = max(0, canvas.left);
          cropBox.minTop = max(0, canvas.top);
          cropBox.maxLeft = min(containerWidth, canvas.left + canvas.width) - cropBox.width;
          cropBox.maxTop = min(containerHeight, canvas.top + canvas.height) - cropBox.height;
        ***REMOVED*** else {
          cropBox.minLeft = 0;
          cropBox.minTop = 0;
          cropBox.maxLeft = containerWidth - cropBox.width;
          cropBox.maxTop = containerHeight - cropBox.height;
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***,

    renderCropBox: function () {
      var options = this.options;
      var container = this.container;
      var containerWidth = container.width;
      var containerHeight = container.height;
      var cropBox = this.cropBox;

      if (cropBox.width > cropBox.maxWidth || cropBox.width < cropBox.minWidth) {
        cropBox.left = cropBox.oldLeft;
      ***REMOVED***

      if (cropBox.height > cropBox.maxHeight || cropBox.height < cropBox.minHeight) {
        cropBox.top = cropBox.oldTop;
      ***REMOVED***

      cropBox.width = min(max(cropBox.width, cropBox.minWidth), cropBox.maxWidth);
      cropBox.height = min(max(cropBox.height, cropBox.minHeight), cropBox.maxHeight);

      this.limitCropBox(false, true);

      cropBox.oldLeft = cropBox.left = min(max(cropBox.left, cropBox.minLeft), cropBox.maxLeft);
      cropBox.oldTop = cropBox.top = min(max(cropBox.top, cropBox.minTop), cropBox.maxTop);

      if (options.movable && options.cropBoxMovable) {

        // Turn to move the canvas when the crop box is equal to the container
        this.$face.data('action', (cropBox.width === containerWidth && cropBox.height === containerHeight) ? ACTION_MOVE : ACTION_ALL);
      ***REMOVED***

      this.$cropBox.css({
        width: cropBox.width,
        height: cropBox.height,
        left: cropBox.left,
        top: cropBox.top
      ***REMOVED***);

      if (this.cropped && options.strict) {
        this.limitCanvas(true, true);
      ***REMOVED***

      if (!this.disabled) {
        this.output();
      ***REMOVED***
    ***REMOVED***,

    output: function () {
      this.preview();

      if (this.complete) {
        this.trigger(EVENT_CROP, this.getData());
      ***REMOVED*** else if (!this.built) {

        // Only trigger one crop event before complete
        this.$element.one(EVENT_BUILT, $.proxy(function () {
          this.trigger(EVENT_CROP, this.getData());
        ***REMOVED***, this));
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***);

  $.extend(prototype, {
    initPreview: function () {
      var url = this.url;

      this.$preview = $(this.options.preview);
      this.$viewBox.html('<img src="' + url + '">');
      this.$preview.each(function () {
        var $this = $(this);

        // Save the original size for recover
        $this.data(PREVIEW, {
          width: $this.width(),
          height: $this.height(),
          original: $this.html()
        ***REMOVED***);

        /**
         * Override img element styles
         * Add `display:block` to avoid margin top issue
         * (Occur only when margin-top <= -height)
         */
        $this.html(
          '<img src="' + url + '" style="display:block;width:100%;' +
          'min-width:0!important;min-height:0!important;' +
          'max-width:none!important;max-height:none!important;' +
          'image-orientation:0deg!important">'
        );
      ***REMOVED***);
    ***REMOVED***,

    resetPreview: function () {
      this.$preview.each(function () {
        var $this = $(this);

        $this.html($this.data(PREVIEW).original).removeData(PREVIEW);
      ***REMOVED***);
    ***REMOVED***,

    preview: function () {
      var image = this.image;
      var canvas = this.canvas;
      var cropBox = this.cropBox;
      var width = image.width;
      var height = image.height;
      var left = cropBox.left - canvas.left - image.left;
      var top = cropBox.top - canvas.top - image.top;

      if (!this.cropped || this.disabled) {
        return;
      ***REMOVED***

      this.$viewBox.find('img').css({
        width: width,
        height: height,
        marginLeft: -left,
        marginTop: -top,
        transform: getTransform(image)
      ***REMOVED***);

      this.$preview.each(function () {
        var $this = $(this);
        var data = $this.data(PREVIEW);
        var ratio = data.width / cropBox.width;
        var newWidth = data.width;
        var newHeight = cropBox.height * ratio;

        if (newHeight > data.height) {
          ratio = data.height / cropBox.height;
          newWidth = cropBox.width * ratio;
          newHeight = data.height;
        ***REMOVED***

        $this.width(newWidth).height(newHeight).find('img').css({
          width: width * ratio,
          height: height * ratio,
          marginLeft: -left * ratio,
          marginTop: -top * ratio,
          transform: getTransform(image)
        ***REMOVED***);
      ***REMOVED***);
    ***REMOVED***
  ***REMOVED***);

  $.extend(prototype, {
    bind: function () {
      var options = this.options;
      var $this = this.$element;
      var $cropper = this.$cropper;

      if ($.isFunction(options.cropstart)) {
        $this.on(EVENT_CROP_START, options.cropstart);
      ***REMOVED***

      if ($.isFunction(options.cropmove)) {
        $this.on(EVENT_CROP_MOVE, options.cropmove);
      ***REMOVED***

      if ($.isFunction(options.cropend)) {
        $this.on(EVENT_CROP_END, options.cropend);
      ***REMOVED***

      if ($.isFunction(options.crop)) {
        $this.on(EVENT_CROP, options.crop);
      ***REMOVED***

      if ($.isFunction(options.zoom)) {
        $this.on(EVENT_ZOOM, options.zoom);
      ***REMOVED***

      $cropper.on(EVENT_MOUSE_DOWN, $.proxy(this.cropStart, this));

      if (options.zoomable && options.mouseWheelZoom) {
        $cropper.on(EVENT_WHEEL, $.proxy(this.wheel, this));
      ***REMOVED***

      if (options.doubleClickToggle) {
        $cropper.on(EVENT_DBLCLICK, $.proxy(this.dblclick, this));
      ***REMOVED***

      $document.
        on(EVENT_MOUSE_MOVE, (this._cropMove = proxy(this.cropMove, this))).
        on(EVENT_MOUSE_UP, (this._cropEnd = proxy(this.cropEnd, this)));

      if (options.responsive) {
        $window.on(EVENT_RESIZE, (this._resize = proxy(this.resize, this)));
      ***REMOVED***
    ***REMOVED***,

    unbind: function () {
      var options = this.options;
      var $this = this.$element;
      var $cropper = this.$cropper;

      if ($.isFunction(options.cropstart)) {
        $this.off(EVENT_CROP_START, options.cropstart);
      ***REMOVED***

      if ($.isFunction(options.cropmove)) {
        $this.off(EVENT_CROP_MOVE, options.cropmove);
      ***REMOVED***

      if ($.isFunction(options.cropend)) {
        $this.off(EVENT_CROP_END, options.cropend);
      ***REMOVED***

      if ($.isFunction(options.crop)) {
        $this.off(EVENT_CROP, options.crop);
      ***REMOVED***

      if ($.isFunction(options.zoom)) {
        $this.off(EVENT_ZOOM, options.zoom);
      ***REMOVED***

      $cropper.off(EVENT_MOUSE_DOWN, this.cropStart);

      if (options.zoomable && options.mouseWheelZoom) {
        $cropper.off(EVENT_WHEEL, this.wheel);
      ***REMOVED***

      if (options.doubleClickToggle) {
        $cropper.off(EVENT_DBLCLICK, this.dblclick);
      ***REMOVED***

      $document.
        off(EVENT_MOUSE_MOVE, this._cropMove).
        off(EVENT_MOUSE_UP, this._cropEnd);

      if (options.responsive) {
        $window.off(EVENT_RESIZE, this._resize);
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***);

  $.extend(prototype, {
    resize: function () {
      var $container = this.$container;
      var container = this.container;
      var canvasData;
      var cropBoxData;
      var ratio;

      // Check `container` is necessary for IE8
      if (this.disabled || !container) {
        return;
      ***REMOVED***

      ratio = $container.width() / container.width;

      // Resize when width changed or height changed
      if (ratio !== 1 || $container.height() !== container.height) {
        canvasData = this.getCanvasData();
        cropBoxData = this.getCropBoxData();

        this.render();
        this.setCanvasData($.each(canvasData, function (i, n) {
          canvasData[i] = n * ratio;
        ***REMOVED***));
        this.setCropBoxData($.each(cropBoxData, function (i, n) {
          cropBoxData[i] = n * ratio;
        ***REMOVED***));
      ***REMOVED***
    ***REMOVED***,

    dblclick: function () {
      if (this.disabled) {
        return;
      ***REMOVED***

      if (this.$dragBox.hasClass(CLASS_CROP)) {
        this.setDragMode(ACTION_MOVE);
      ***REMOVED*** else {
        this.setDragMode(ACTION_CROP);
      ***REMOVED***
    ***REMOVED***,

    wheel: function (event) {
      var originalEvent = event.originalEvent;
      var e = originalEvent;
      var ratio = num(this.options.wheelZoomRatio) || 0.1;
      var delta = 1;

      if (this.disabled) {
        return;
      ***REMOVED***

      event.preventDefault();

      if (e.deltaY) {
        delta = e.deltaY > 0 ? 1 : -1;
      ***REMOVED*** else if (e.wheelDelta) {
        delta = -e.wheelDelta / 120;
      ***REMOVED*** else if (e.detail) {
        delta = e.detail > 0 ? 1 : -1;
      ***REMOVED***

      this.zoom(-delta * ratio, originalEvent);
    ***REMOVED***,

    cropStart: function (event) {
      var options = this.options;
      var originalEvent = event.originalEvent;
      var touches = originalEvent && originalEvent.touches;
      var e = event;
      var touchesLength;
      var action;

      if (this.disabled) {
        return;
      ***REMOVED***

      if (touches) {
        touchesLength = touches.length;

        if (touchesLength > 1) {
          if (options.zoomable && options.touchDragZoom && touchesLength === 2) {
            e = touches[1];
            this.startX2 = e.pageX;
            this.startY2 = e.pageY;
            action = ACTION_ZOOM;
          ***REMOVED*** else {
            return;
          ***REMOVED***
        ***REMOVED***

        e = touches[0];
      ***REMOVED***

      action = action || $(e.target).data('action');

      if (REGEXP_ACTIONS.test(action)) {
        if (this.trigger(EVENT_CROP_START, {
          originalEvent: originalEvent,
          action: action
        ***REMOVED***)) {
          return;
        ***REMOVED***

        event.preventDefault();

        this.action = action;
        this.cropping = false;

        // IE8  has `event.pageX/Y`, but not `event.originalEvent.pageX/Y`
        // IE10 has `event.originalEvent.pageX/Y`, but not `event.pageX/Y`
        this.startX = e.pageX || originalEvent && originalEvent.pageX;
        this.startY = e.pageY || originalEvent && originalEvent.pageY;

        if (action === ACTION_CROP) {
          this.cropping = true;
          this.$dragBox.addClass(CLASS_MODAL);
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***,

    cropMove: function (event) {
      var options = this.options;
      var originalEvent = event.originalEvent;
      var touches = originalEvent && originalEvent.touches;
      var e = event;
      var action = this.action;
      var touchesLength;

      if (this.disabled) {
        return;
      ***REMOVED***

      if (touches) {
        touchesLength = touches.length;

        if (touchesLength > 1) {
          if (options.zoomable && options.touchDragZoom && touchesLength === 2) {
            e = touches[1];
            this.endX2 = e.pageX;
            this.endY2 = e.pageY;
          ***REMOVED*** else {
            return;
          ***REMOVED***
        ***REMOVED***

        e = touches[0];
      ***REMOVED***

      if (action) {
        if (this.trigger(EVENT_CROP_MOVE, {
          originalEvent: originalEvent,
          action: action
        ***REMOVED***)) {
          return;
        ***REMOVED***

        event.preventDefault();

        this.endX = e.pageX || originalEvent && originalEvent.pageX;
        this.endY = e.pageY || originalEvent && originalEvent.pageY;

        this.change(e.shiftKey, action === ACTION_ZOOM ? originalEvent : null);
      ***REMOVED***
    ***REMOVED***,

    cropEnd: function (event) {
      var originalEvent = event.originalEvent;
      var action = this.action;

      if (this.disabled) {
        return;
      ***REMOVED***

      if (action) {
        event.preventDefault();

        if (this.cropping) {
          this.cropping = false;
          this.$dragBox.toggleClass(CLASS_MODAL, this.cropped && this.options.modal);
        ***REMOVED***

        this.action = '';

        this.trigger(EVENT_CROP_END, {
          originalEvent: originalEvent,
          action: action
        ***REMOVED***);
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***);

  $.extend(prototype, {
    change: function (shiftKey, originalEvent) {
      var options = this.options;
      var aspectRatio = options.aspectRatio;
      var action = this.action;
      var container = this.container;
      var canvas = this.canvas;
      var cropBox = this.cropBox;
      var width = cropBox.width;
      var height = cropBox.height;
      var left = cropBox.left;
      var top = cropBox.top;
      var right = left + width;
      var bottom = top + height;
      var minLeft = 0;
      var minTop = 0;
      var maxWidth = container.width;
      var maxHeight = container.height;
      var renderable = true;
      var offset;
      var range;

      // Locking aspect ratio in "free mode" by holding shift key (#259)
      if (!aspectRatio && shiftKey) {
        aspectRatio = width && height ? width / height : 1;
      ***REMOVED***

      if (options.strict) {
        minLeft = cropBox.minLeft;
        minTop = cropBox.minTop;
        maxWidth = minLeft + min(container.width, canvas.width);
        maxHeight = minTop + min(container.height, canvas.height);
      ***REMOVED***

      range = {
        x: this.endX - this.startX,
        y: this.endY - this.startY
      ***REMOVED***;

      if (aspectRatio) {
        range.X = range.y * aspectRatio;
        range.Y = range.x / aspectRatio;
      ***REMOVED***

      switch (action) {
        // Move crop box
        case ACTION_ALL:
          left += range.x;
          top += range.y;
          break;

        // Resize crop box
        case ACTION_EAST:
          if (range.x >= 0 && (right >= maxWidth || aspectRatio &&
            (top <= minTop || bottom >= maxHeight))) {

            renderable = false;
            break;
          ***REMOVED***

          width += range.x;

          if (aspectRatio) {
            height = width / aspectRatio;
            top -= range.Y / 2;
          ***REMOVED***

          if (width < 0) {
            action = ACTION_WEST;
            width = 0;
          ***REMOVED***

          break;

        case ACTION_NORTH:
          if (range.y <= 0 && (top <= minTop || aspectRatio &&
            (left <= minLeft || right >= maxWidth))) {

            renderable = false;
            break;
          ***REMOVED***

          height -= range.y;
          top += range.y;

          if (aspectRatio) {
            width = height * aspectRatio;
            left += range.X / 2;
          ***REMOVED***

          if (height < 0) {
            action = ACTION_SOUTH;
            height = 0;
          ***REMOVED***

          break;

        case ACTION_WEST:
          if (range.x <= 0 && (left <= minLeft || aspectRatio &&
            (top <= minTop || bottom >= maxHeight))) {

            renderable = false;
            break;
          ***REMOVED***

          width -= range.x;
          left += range.x;

          if (aspectRatio) {
            height = width / aspectRatio;
            top += range.Y / 2;
          ***REMOVED***

          if (width < 0) {
            action = ACTION_EAST;
            width = 0;
          ***REMOVED***

          break;

        case ACTION_SOUTH:
          if (range.y >= 0 && (bottom >= maxHeight || aspectRatio &&
            (left <= minLeft || right >= maxWidth))) {

            renderable = false;
            break;
          ***REMOVED***

          height += range.y;

          if (aspectRatio) {
            width = height * aspectRatio;
            left -= range.X / 2;
          ***REMOVED***

          if (height < 0) {
            action = ACTION_NORTH;
            height = 0;
          ***REMOVED***

          break;

        case ACTION_NORTH_EAST:
          if (aspectRatio) {
            if (range.y <= 0 && (top <= minTop || right >= maxWidth)) {
              renderable = false;
              break;
            ***REMOVED***

            height -= range.y;
            top += range.y;
            width = height * aspectRatio;
          ***REMOVED*** else {
            if (range.x >= 0) {
              if (right < maxWidth) {
                width += range.x;
              ***REMOVED*** else if (range.y <= 0 && top <= minTop) {
                renderable = false;
              ***REMOVED***
            ***REMOVED*** else {
              width += range.x;
            ***REMOVED***

            if (range.y <= 0) {
              if (top > minTop) {
                height -= range.y;
                top += range.y;
              ***REMOVED***
            ***REMOVED*** else {
              height -= range.y;
              top += range.y;
            ***REMOVED***
          ***REMOVED***

          if (width < 0 && height < 0) {
            action = ACTION_SOUTH_WEST;
            height = 0;
            width = 0;
          ***REMOVED*** else if (width < 0) {
            action = ACTION_NORTH_WEST;
            width = 0;
          ***REMOVED*** else if (height < 0) {
            action = ACTION_SOUTH_EAST;
            height = 0;
          ***REMOVED***

          break;

        case ACTION_NORTH_WEST:
          if (aspectRatio) {
            if (range.y <= 0 && (top <= minTop || left <= minLeft)) {
              renderable = false;
              break;
            ***REMOVED***

            height -= range.y;
            top += range.y;
            width = height * aspectRatio;
            left += range.X;
          ***REMOVED*** else {
            if (range.x <= 0) {
              if (left > minLeft) {
                width -= range.x;
                left += range.x;
              ***REMOVED*** else if (range.y <= 0 && top <= minTop) {
                renderable = false;
              ***REMOVED***
            ***REMOVED*** else {
              width -= range.x;
              left += range.x;
            ***REMOVED***

            if (range.y <= 0) {
              if (top > minTop) {
                height -= range.y;
                top += range.y;
              ***REMOVED***
            ***REMOVED*** else {
              height -= range.y;
              top += range.y;
            ***REMOVED***
          ***REMOVED***

          if (width < 0 && height < 0) {
            action = ACTION_SOUTH_EAST;
            height = 0;
            width = 0;
          ***REMOVED*** else if (width < 0) {
            action = ACTION_NORTH_EAST;
            width = 0;
          ***REMOVED*** else if (height < 0) {
            action = ACTION_SOUTH_WEST;
            height = 0;
          ***REMOVED***

          break;

        case ACTION_SOUTH_WEST:
          if (aspectRatio) {
            if (range.x <= 0 && (left <= minLeft || bottom >= maxHeight)) {
              renderable = false;
              break;
            ***REMOVED***

            width -= range.x;
            left += range.x;
            height = width / aspectRatio;
          ***REMOVED*** else {
            if (range.x <= 0) {
              if (left > minLeft) {
                width -= range.x;
                left += range.x;
              ***REMOVED*** else if (range.y >= 0 && bottom >= maxHeight) {
                renderable = false;
              ***REMOVED***
            ***REMOVED*** else {
              width -= range.x;
              left += range.x;
            ***REMOVED***

            if (range.y >= 0) {
              if (bottom < maxHeight) {
                height += range.y;
              ***REMOVED***
            ***REMOVED*** else {
              height += range.y;
            ***REMOVED***
          ***REMOVED***

          if (width < 0 && height < 0) {
            action = ACTION_NORTH_EAST;
            height = 0;
            width = 0;
          ***REMOVED*** else if (width < 0) {
            action = ACTION_SOUTH_EAST;
            width = 0;
          ***REMOVED*** else if (height < 0) {
            action = ACTION_NORTH_WEST;
            height = 0;
          ***REMOVED***

          break;

        case ACTION_SOUTH_EAST:
          if (aspectRatio) {
            if (range.x >= 0 && (right >= maxWidth || bottom >= maxHeight)) {
              renderable = false;
              break;
            ***REMOVED***

            width += range.x;
            height = width / aspectRatio;
          ***REMOVED*** else {
            if (range.x >= 0) {
              if (right < maxWidth) {
                width += range.x;
              ***REMOVED*** else if (range.y >= 0 && bottom >= maxHeight) {
                renderable = false;
              ***REMOVED***
            ***REMOVED*** else {
              width += range.x;
            ***REMOVED***

            if (range.y >= 0) {
              if (bottom < maxHeight) {
                height += range.y;
              ***REMOVED***
            ***REMOVED*** else {
              height += range.y;
            ***REMOVED***
          ***REMOVED***

          if (width < 0 && height < 0) {
            action = ACTION_NORTH_WEST;
            height = 0;
            width = 0;
          ***REMOVED*** else if (width < 0) {
            action = ACTION_SOUTH_WEST;
            width = 0;
          ***REMOVED*** else if (height < 0) {
            action = ACTION_NORTH_EAST;
            height = 0;
          ***REMOVED***

          break;

        // Move canvas
        case ACTION_MOVE:
          canvas.left += range.x;
          canvas.top += range.y;
          this.renderCanvas(true);
          renderable = false;
          break;

        // Zoom canvas
        case ACTION_ZOOM:
          this.zoom((function (x1, y1, x2, y2) {
            var z1 = sqrt(x1 * x1 + y1 * y1);
            var z2 = sqrt(x2 * x2 + y2 * y2);

            return (z2 - z1) / z1;
          ***REMOVED***)(
            abs(this.startX - this.startX2),
            abs(this.startY - this.startY2),
            abs(this.endX - this.endX2),
            abs(this.endY - this.endY2)
          ), originalEvent);
          this.startX2 = this.endX2;
          this.startY2 = this.endY2;
          renderable = false;
          break;

        // Create crop box
        case ACTION_CROP:
          if (range.x && range.y) {
            offset = this.$cropper.offset();
            left = this.startX - offset.left;
            top = this.startY - offset.top;
            width = cropBox.minWidth;
            height = cropBox.minHeight;

            if (range.x > 0) {
              if (range.y > 0) {
                action = ACTION_SOUTH_EAST;
              ***REMOVED*** else {
                action = ACTION_NORTH_EAST;
                top -= height;
              ***REMOVED***
            ***REMOVED*** else {
              if (range.y > 0) {
                action = ACTION_SOUTH_WEST;
                left -= width;
              ***REMOVED*** else {
                action = ACTION_NORTH_WEST;
                left -= width;
                top -= height;
              ***REMOVED***
            ***REMOVED***

            // Show the crop box if is hidden
            if (!this.cropped) {
              this.cropped = true;
              this.$cropBox.removeClass(CLASS_HIDDEN);
            ***REMOVED***
          ***REMOVED***

          break;

        // No default
      ***REMOVED***

      if (renderable) {
        cropBox.width = width;
        cropBox.height = height;
        cropBox.left = left;
        cropBox.top = top;
        this.action = action;

        this.renderCropBox();
      ***REMOVED***

      // Override
      this.startX = this.endX;
      this.startY = this.endY;
    ***REMOVED***
  ***REMOVED***);

  $.extend(prototype, {

    // Show the crop box manually
    crop: function () {
      if (!this.built || this.disabled) {
        return;
      ***REMOVED***

      if (!this.cropped) {
        this.cropped = true;
        this.limitCropBox(true, true);

        if (this.options.modal) {
          this.$dragBox.addClass(CLASS_MODAL);
        ***REMOVED***

        this.$cropBox.removeClass(CLASS_HIDDEN);
      ***REMOVED***

      this.setCropBoxData(this.initialCropBox);
    ***REMOVED***,

    // Reset the image and crop box to their initial states
    reset: function () {
      if (!this.built || this.disabled) {
        return;
      ***REMOVED***

      this.image = $.extend({***REMOVED***, this.initialImage);
      this.canvas = $.extend({***REMOVED***, this.initialCanvas);

      // Required for strict mode
      this.cropBox = $.extend({***REMOVED***, this.initialCropBox);

      this.renderCanvas();

      if (this.cropped) {
        this.renderCropBox();
      ***REMOVED***
    ***REMOVED***,

    // Clear the crop box
    clear: function () {
      if (!this.cropped || this.disabled) {
        return;
      ***REMOVED***

      $.extend(this.cropBox, {
        left: 0,
        top: 0,
        width: 0,
        height: 0
      ***REMOVED***);

      this.cropped = false;
      this.renderCropBox();

      this.limitCanvas();

      // Render canvas after crop box rendered
      this.renderCanvas();

      this.$dragBox.removeClass(CLASS_MODAL);
      this.$cropBox.addClass(CLASS_HIDDEN);
    ***REMOVED***,

    /**
     * Replace the image's src and rebuild the cropper
     *
     * @param {String***REMOVED*** url
     */
    replace: function (url) {
      if (!this.disabled && url) {
        if (this.isImg) {
          this.$element.attr('src', url);
        ***REMOVED***

        // Clear previous data
        this.options.data = null;
        this.load(url);
      ***REMOVED***
    ***REMOVED***,

    // Enable (unfreeze) the cropper
    enable: function () {
      if (this.built) {
        this.disabled = false;
        this.$cropper.removeClass(CLASS_DISABLED);
      ***REMOVED***
    ***REMOVED***,

    // Disable (freeze) the cropper
    disable: function () {
      if (this.built) {
        this.disabled = true;
        this.$cropper.addClass(CLASS_DISABLED);
      ***REMOVED***
    ***REMOVED***,

    // Destroy the cropper and remove the instance from the image
    destroy: function () {
      var $this = this.$element;

      if (this.ready) {
        if (this.isImg) {
          $this.attr('src', this.originalUrl);
        ***REMOVED***

        this.unbuild();
        $this.removeClass(CLASS_HIDDEN);
      ***REMOVED*** else {
        if (this.isImg) {
          $this.off(EVENT_LOAD, this.start);
        ***REMOVED*** else if (this.$clone) {
          this.$clone.remove();
        ***REMOVED***
      ***REMOVED***

      $this.removeData(NAMESPACE);
    ***REMOVED***,

    /**
     * Move the canvas
     *
     * @param {Number***REMOVED*** offsetX
     * @param {Number***REMOVED*** offsetY (optional)
     */
    move: function (offsetX, offsetY) {
      var canvas = this.canvas;

      // If "offsetY" is not present, its default value is "offsetX"
      if (isUndefined(offsetY)) {
        offsetY = offsetX;
      ***REMOVED***

      offsetX = num(offsetX);
      offsetY = num(offsetY);

      if (this.built && !this.disabled && this.options.movable) {
        canvas.left += isNumber(offsetX) ? offsetX : 0;
        canvas.top += isNumber(offsetY) ? offsetY : 0;
        this.renderCanvas(true);
      ***REMOVED***
    ***REMOVED***,

    /**
     * Zoom the canvas
     *
     * @param {Number***REMOVED*** ratio
     * @param {Event***REMOVED*** _originalEvent (private)
     */
    zoom: function (ratio, _originalEvent) {
      var canvas = this.canvas;
      var width;
      var height;

      ratio = num(ratio);

      if (ratio && this.built && !this.disabled && this.options.zoomable) {
        if (this.trigger(EVENT_ZOOM, {
          originalEvent: _originalEvent,
          ratio: ratio
        ***REMOVED***)) {
          return;
        ***REMOVED***

        if (ratio < 0) {
          ratio =  1 / (1 - ratio);
        ***REMOVED*** else {
          ratio = 1 + ratio;
        ***REMOVED***

        width = canvas.width * ratio;
        height = canvas.height * ratio;
        canvas.left -= (width - canvas.width) / 2;
        canvas.top -= (height - canvas.height) / 2;
        canvas.width = width;
        canvas.height = height;
        this.renderCanvas(true);
        this.setDragMode(ACTION_MOVE);
      ***REMOVED***
    ***REMOVED***,

    /**
     * Rotate the canvas
     * https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function#rotate()
     *
     * @param {Number***REMOVED*** degree
     */
    rotate: function (degree) {
      var image = this.image;
      var rotate = image.rotate || 0;

      degree = num(degree) || 0;

      if (this.built && !this.disabled && this.options.rotatable) {
        image.rotate = (rotate + degree) % 360;
        this.rotated = true;
        this.renderCanvas(true);
      ***REMOVED***
    ***REMOVED***,

    /**
     * Scale the image
     * https://developer.mozilla.org/en-US/docs/Web/CSS/transform-function#scale()
     *
     * @param {Number***REMOVED*** scaleX
     * @param {Number***REMOVED*** scaleY (optional)
     */
    scale: function (scaleX, scaleY) {
      var image = this.image;

      // If "scaleY" is not present, its default value is "scaleX"
      if (isUndefined(scaleY)) {
        scaleY = scaleX;
      ***REMOVED***

      scaleX = num(scaleX);
      scaleY = num(scaleY);

      if (this.built && !this.disabled && this.options.scalable) {
        image.scaleX = isNumber(scaleX) ? scaleX : 1;
        image.scaleY = isNumber(scaleY) ? scaleY : 1;
        this.renderImage(true);
      ***REMOVED***
    ***REMOVED***,

    /**
     * Get the cropped area position and size data (base on the original image)
     *
     * @param {Boolean***REMOVED*** rounded (optional)
     * @return {Object***REMOVED*** data
     */
    getData: function (rounded) {
      var options = this.options;
      var image = this.image;
      var canvas = this.canvas;
      var cropBox = this.cropBox;
      var ratio;
      var data;

      if (this.built && this.cropped) {
        data = {
          x: cropBox.left - canvas.left,
          y: cropBox.top - canvas.top,
          width: cropBox.width,
          height: cropBox.height
        ***REMOVED***;

        ratio = image.width / image.naturalWidth;

        $.each(data, function (i, n) {
          n = n / ratio;
          data[i] = rounded ? Math.round(n) : n;
        ***REMOVED***);

      ***REMOVED*** else {
        data = {
          x: 0,
          y: 0,
          width: 0,
          height: 0
        ***REMOVED***;
      ***REMOVED***

      if (options.rotatable) {
        data.rotate = image.rotate || 0;
      ***REMOVED***

      if (options.scalable) {
        data.scaleX = image.scaleX || 1;
        data.scaleY = image.scaleY || 1;
      ***REMOVED***

      return data;
    ***REMOVED***,

    /**
     * Set the cropped area position and size with new data
     *
     * @param {Object***REMOVED*** data
     */
    setData: function (data) {
      var image = this.image;
      var canvas = this.canvas;
      var cropBoxData = {***REMOVED***;
      var ratio;

      if ($.isFunction(data)) {
        data = data.call(this.$element);
      ***REMOVED***

      if (this.built && !this.disabled && $.isPlainObject(data)) {
        if (isNumber(data.rotate) && data.rotate !== image.rotate &&
          this.options.rotatable) {

          image.rotate = data.rotate;
          this.rotated = true;
          this.renderCanvas(true);
        ***REMOVED***

        ratio = image.width / image.naturalWidth;

        if (isNumber(data.x)) {
          cropBoxData.left = data.x * ratio + canvas.left;
        ***REMOVED***

        if (isNumber(data.y)) {
          cropBoxData.top = data.y * ratio + canvas.top;
        ***REMOVED***

        if (isNumber(data.width)) {
          cropBoxData.width = data.width * ratio;
        ***REMOVED***

        if (isNumber(data.height)) {
          cropBoxData.height = data.height * ratio;
        ***REMOVED***

        this.setCropBoxData(cropBoxData);
      ***REMOVED***
    ***REMOVED***,

    /**
     * Get the container size data
     *
     * @return {Object***REMOVED*** data
     */
    getContainerData: function () {
      return this.built ? this.container : {***REMOVED***;
    ***REMOVED***,

    /**
     * Get the image position and size data
     *
     * @return {Object***REMOVED*** data
     */
    getImageData: function () {
      return this.ready ? this.image : {***REMOVED***;
    ***REMOVED***,

    /**
     * Get the canvas position and size data
     *
     * @return {Object***REMOVED*** data
     */
    getCanvasData: function () {
      var canvas = this.canvas;
      var data;

      if (this.built) {
        data = {
          left: canvas.left,
          top: canvas.top,
          width: canvas.width,
          height: canvas.height
        ***REMOVED***;
      ***REMOVED***

      return data || {***REMOVED***;
    ***REMOVED***,

    /**
     * Set the canvas position and size with new data
     *
     * @param {Object***REMOVED*** data
     */
    setCanvasData: function (data) {
      var canvas = this.canvas;
      var aspectRatio = canvas.aspectRatio;

      if ($.isFunction(data)) {
        data = data.call(this.$element);
      ***REMOVED***

      if (this.built && !this.disabled && $.isPlainObject(data)) {
        if (isNumber(data.left)) {
          canvas.left = data.left;
        ***REMOVED***

        if (isNumber(data.top)) {
          canvas.top = data.top;
        ***REMOVED***

        if (isNumber(data.width)) {
          canvas.width = data.width;
          canvas.height = data.width / aspectRatio;
        ***REMOVED*** else if (isNumber(data.height)) {
          canvas.height = data.height;
          canvas.width = data.height * aspectRatio;
        ***REMOVED***

        this.renderCanvas(true);
      ***REMOVED***
    ***REMOVED***,

    /**
     * Get the crop box position and size data
     *
     * @return {Object***REMOVED*** data
     */
    getCropBoxData: function () {
      var cropBox = this.cropBox;
      var data;

      if (this.built && this.cropped) {
        data = {
          left: cropBox.left,
          top: cropBox.top,
          width: cropBox.width,
          height: cropBox.height
        ***REMOVED***;
      ***REMOVED***

      return data || {***REMOVED***;
    ***REMOVED***,

    /**
     * Set the crop box position and size with new data
     *
     * @param {Object***REMOVED*** data
     */
    setCropBoxData: function (data) {
      var cropBox = this.cropBox;
      var aspectRatio = this.options.aspectRatio;
      var widthChanged;
      var heightChanged;

      if ($.isFunction(data)) {
        data = data.call(this.$element);
      ***REMOVED***

      if (this.built && this.cropped && !this.disabled && $.isPlainObject(data)) {

        if (isNumber(data.left)) {
          cropBox.left = data.left;
        ***REMOVED***

        if (isNumber(data.top)) {
          cropBox.top = data.top;
        ***REMOVED***

        if (isNumber(data.width) && data.width !== cropBox.width) {
          widthChanged = true;
          cropBox.width = data.width;
        ***REMOVED***

        if (isNumber(data.height) && data.height !== cropBox.height) {
          heightChanged = true;
          cropBox.height = data.height;
        ***REMOVED***

        if (aspectRatio) {
          if (widthChanged) {
            cropBox.height = cropBox.width / aspectRatio;
          ***REMOVED*** else if (heightChanged) {
            cropBox.width = cropBox.height * aspectRatio;
          ***REMOVED***
        ***REMOVED***

        this.renderCropBox();
      ***REMOVED***
    ***REMOVED***,

    /**
     * Get a canvas drawn the cropped image
     *
     * @param {Object***REMOVED*** options (optional)
     * @return {HTMLCanvasElement***REMOVED*** canvas
     */
    getCroppedCanvas: function (options) {
      var originalWidth;
      var originalHeight;
      var canvasWidth;
      var canvasHeight;
      var scaledWidth;
      var scaledHeight;
      var scaledRatio;
      var aspectRatio;
      var canvas;
      var context;
      var data;

      if (!this.built || !this.cropped || !SUPPORT_CANVAS) {
        return;
      ***REMOVED***

      if (!$.isPlainObject(options)) {
        options = {***REMOVED***;
      ***REMOVED***

      data = this.getData();
      originalWidth = data.width;
      originalHeight = data.height;
      aspectRatio = originalWidth / originalHeight;

      if ($.isPlainObject(options)) {
        scaledWidth = options.width;
        scaledHeight = options.height;

        if (scaledWidth) {
          scaledHeight = scaledWidth / aspectRatio;
          scaledRatio = scaledWidth / originalWidth;
        ***REMOVED*** else if (scaledHeight) {
          scaledWidth = scaledHeight * aspectRatio;
          scaledRatio = scaledHeight / originalHeight;
        ***REMOVED***
      ***REMOVED***

      canvasWidth = scaledWidth || originalWidth;
      canvasHeight = scaledHeight || originalHeight;

      canvas = $('<canvas>')[0];
      canvas.width = canvasWidth;
      canvas.height = canvasHeight;
      context = canvas.getContext('2d');

      if (options.fillColor) {
        context.fillStyle = options.fillColor;
        context.fillRect(0, 0, canvasWidth, canvasHeight);
      ***REMOVED***

      // https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D.drawImage
      context.drawImage.apply(context, (function () {
        var source = getSourceCanvas(this.$clone[0], this.image);
        var sourceWidth = source.width;
        var sourceHeight = source.height;
        var args = [source];

        // Source canvas
        var srcX = data.x;
        var srcY = data.y;
        var srcWidth;
        var srcHeight;

        // Destination canvas
        var dstX;
        var dstY;
        var dstWidth;
        var dstHeight;

        if (srcX <= -originalWidth || srcX > sourceWidth) {
          srcX = srcWidth = dstX = dstWidth = 0;
        ***REMOVED*** else if (srcX <= 0) {
          dstX = -srcX;
          srcX = 0;
          srcWidth = dstWidth = min(sourceWidth, originalWidth + srcX);
        ***REMOVED*** else if (srcX <= sourceWidth) {
          dstX = 0;
          srcWidth = dstWidth = min(originalWidth, sourceWidth - srcX);
        ***REMOVED***

        if (srcWidth <= 0 || srcY <= -originalHeight || srcY > sourceHeight) {
          srcY = srcHeight = dstY = dstHeight = 0;
        ***REMOVED*** else if (srcY <= 0) {
          dstY = -srcY;
          srcY = 0;
          srcHeight = dstHeight = min(sourceHeight, originalHeight + srcY);
        ***REMOVED*** else if (srcY <= sourceHeight) {
          dstY = 0;
          srcHeight = dstHeight = min(originalHeight, sourceHeight - srcY);
        ***REMOVED***

        args.push(srcX, srcY, srcWidth, srcHeight);

        // Scale destination sizes
        if (scaledRatio) {
          dstX *= scaledRatio;
          dstY *= scaledRatio;
          dstWidth *= scaledRatio;
          dstHeight *= scaledRatio;
        ***REMOVED***

        // Avoid "IndexSizeError" in IE and Firefox
        if (dstWidth > 0 && dstHeight > 0) {
          args.push(dstX, dstY, dstWidth, dstHeight);
        ***REMOVED***

        return args;
      ***REMOVED***).call(this));

      return canvas;
    ***REMOVED***,

    /**
     * Change the aspect ratio of the crop box
     *
     * @param {Number***REMOVED*** aspectRatio
     */
    setAspectRatio: function (aspectRatio) {
      var options = this.options;

      if (!this.disabled && !isUndefined(aspectRatio)) {

        // 0 -> NaN
        options.aspectRatio = num(aspectRatio) || NaN;

        if (this.built) {
          this.initCropBox();

          if (this.cropped) {
            this.renderCropBox();
          ***REMOVED***
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***,

    /**
     * Change the drag mode
     *
     * @param {String***REMOVED*** mode (optional)
     */
    setDragMode: function (mode) {
      var options = this.options;
      var croppable;
      var movable;

      if (this.ready && !this.disabled) {
        croppable = options.dragCrop && mode === ACTION_CROP;
        movable = options.movable && mode === ACTION_MOVE;
        mode = (croppable || movable) ? mode : ACTION_NONE;

        this.$dragBox.
          data('action', mode).
          toggleClass(CLASS_CROP, croppable).
          toggleClass(CLASS_MOVE, movable);

        if (!options.cropBoxMovable) {

          // Sync drag mode to crop box when it is not movable(#300)
          this.$face.
            data('action', mode).
            toggleClass(CLASS_CROP, croppable).
            toggleClass(CLASS_MOVE, movable);
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***);

  $.extend(Cropper.prototype, prototype);

  Cropper.DEFAULTS = {

    // Define the aspect ratio of the crop box
    aspectRatio: NaN,

    // An object with the previous cropping result data
    data: null,

    // A jQuery selector for adding extra containers to preview
    preview: '',

    // Strict mode, the image cannot zoom out less than the container
    strict: true,

    // Rebuild when resize the window
    responsive: true,

    // Check if the target image is cross origin
    checkImageOrigin: true,

    // Show the black modal
    modal: true,

    // Show the dashed lines for guiding
    guides: true,

    // Show the center indicator for guiding
    center: true,

    // Show the white modal to highlight the crop box
    highlight: true,

    // Show the grid background
    background: true,

    // Enable to crop the image automatically when initialize
    autoCrop: true,

    // Define the percentage of automatic cropping area when initializes
    autoCropArea: 0.8,

    // Enable to create new crop box by dragging over the image
    dragCrop: true,

    // Enable to move the image
    movable: true,

    // Enable to rotate the image
    rotatable: true,

    // Enable to scale the image
    scalable: true,

    // Enable to zoom the image
    zoomable: true,

    // Enable to zoom the image by wheeling mouse
    mouseWheelZoom: true,

    // Define zoom ratio when zoom the image by wheeling mouse
    wheelZoomRatio: 0.1,

    // Enable to zoom the image by dragging touch
    touchDragZoom: true,

    // Enable to move the crop box
    cropBoxMovable: true,

    // Enable to resize the crop box
    cropBoxResizable: true,

    // Toggle drag mode between "crop" and "move" when double click on the cropper
    doubleClickToggle: true,

    // Size limitation
    minCanvasWidth: 0,
    minCanvasHeight: 0,
    minCropBoxWidth: 0,
    minCropBoxHeight: 0,
    minContainerWidth: 200,
    minContainerHeight: 100,

    // Shortcuts of events
    build: null,
    built: null,
    cropstart: null,
    cropmove: null,
    cropend: null,
    crop: null,
    zoom: null
  ***REMOVED***;

  Cropper.setDefaults = function (options) {
    $.extend(Cropper.DEFAULTS, options);
  ***REMOVED***;

  Cropper.TEMPLATE = (
    '<div class="cropper-container">' +
      '<div class="cropper-canvas"></div>' +
      '<div class="cropper-drag-box"></div>' +
      '<div class="cropper-crop-box">' +
        '<span class="cropper-view-box"></span>' +
        '<span class="cropper-dashed dashed-h"></span>' +
        '<span class="cropper-dashed dashed-v"></span>' +
        '<span class="cropper-center"></span>' +
        '<span class="cropper-face"></span>' +
        '<span class="cropper-line line-e" data-action="e"></span>' +
        '<span class="cropper-line line-n" data-action="n"></span>' +
        '<span class="cropper-line line-w" data-action="w"></span>' +
        '<span class="cropper-line line-s" data-action="s"></span>' +
        '<span class="cropper-point point-e" data-action="e"></span>' +
        '<span class="cropper-point point-n" data-action="n"></span>' +
        '<span class="cropper-point point-w" data-action="w"></span>' +
        '<span class="cropper-point point-s" data-action="s"></span>' +
        '<span class="cropper-point point-ne" data-action="ne"></span>' +
        '<span class="cropper-point point-nw" data-action="nw"></span>' +
        '<span class="cropper-point point-sw" data-action="sw"></span>' +
        '<span class="cropper-point point-se" data-action="se"></span>' +
      '</div>' +
    '</div>'
  );

  // Save the other cropper
  Cropper.other = $.fn.cropper;

  // Register as jQuery plugin
  $.fn.cropper = function (options) {
    var args = toArray(arguments, 1);
    var result;

    this.each(function () {
      var $this = $(this);
      var data = $this.data(NAMESPACE);
      var fn;

      if (!data) {
        if (/destroy/.test(options)) {
          return;
        ***REMOVED***

        $this.data(NAMESPACE, (data = new Cropper(this, options)));
      ***REMOVED***

      if (typeof options === 'string' && $.isFunction(fn = data[options])) {
        result = fn.apply(data, args);
      ***REMOVED***
    ***REMOVED***);

    return isUndefined(result) ? this : result;
  ***REMOVED***;

  $.fn.cropper.Constructor = Cropper;
  $.fn.cropper.setDefaults = Cropper.setDefaults;

  // No conflict
  $.fn.cropper.noConflict = function () {
    $.fn.cropper = Cropper.other;
    return this;
  ***REMOVED***;

***REMOVED***);
