$(function () {

  'use strict';

  var console = window.console || { log: function () {***REMOVED*** ***REMOVED***;
  var $image = $('#image');
  var $download = $('#download');
  var $dataX = $('#dataX');
  var $dataY = $('#dataY');
  var $dataHeight = $('#dataHeight');
  var $dataWidth = $('#dataWidth');
  var $dataRotate = $('#dataRotate');
  var $dataScaleX = $('#dataScaleX');
  var $dataScaleY = $('#dataScaleY');
  var options = {
        aspectRatio: 16 / 9,
        preview: '.img-preview',
        crop: function (e) {
          $dataX.val(Math.round(e.x));
          $dataY.val(Math.round(e.y));
          $dataHeight.val(Math.round(e.height));
          $dataWidth.val(Math.round(e.width));
          $dataRotate.val(e.rotate);
          $dataScaleX.val(e.scaleX);
          $dataScaleY.val(e.scaleY);
        ***REMOVED***
      ***REMOVED***;


  // Tooltip
  $('[data-toggle="tooltip"]').tooltip();


  // Cropper
  $image.on({
    'build.cropper': function (e) {
      console.log(e.type);
    ***REMOVED***,
    'built.cropper': function (e) {
      console.log(e.type);
    ***REMOVED***,
    'cropstart.cropper': function (e) {
      console.log(e.type, e.action);
    ***REMOVED***,
    'cropmove.cropper': function (e) {
      console.log(e.type, e.action);
    ***REMOVED***,
    'cropend.cropper': function (e) {
      console.log(e.type, e.action);
    ***REMOVED***,
    'crop.cropper': function (e) {
      console.log(e.type, e.x, e.y, e.width, e.height, e.rotate, e.scaleX, e.scaleY);
    ***REMOVED***,
    'zoom.cropper': function (e) {
      console.log(e.type, e.ratio);
    ***REMOVED***
  ***REMOVED***).cropper(options);


  // Buttons
  if (!$.isFunction(document.createElement('canvas').getContext)) {
    $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
  ***REMOVED***

  if (typeof document.createElement('cropper').style.transition === 'undefined') {
    $('button[data-method="rotate"]').prop('disabled', true);
    $('button[data-method="scale"]').prop('disabled', true);
  ***REMOVED***


  // Download
  if (typeof $download[0].download === 'undefined') {
    $download.addClass('disabled');
  ***REMOVED***


  // Options
  $('.docs-toggles').on('change', 'input', function () {
    var $this = $(this);
    var name = $this.attr('name');
    var type = $this.prop('type');
    var cropBoxData;
    var canvasData;

    if (!$image.data('cropper')) {
      return;
    ***REMOVED***

    if (type === 'checkbox') {
      options[name] = $this.prop('checked');
      cropBoxData = $image.cropper('getCropBoxData');
      canvasData = $image.cropper('getCanvasData');

      options.built = function () {
        $image.cropper('setCropBoxData', cropBoxData);
        $image.cropper('setCanvasData', canvasData);
      ***REMOVED***;
    ***REMOVED*** else if (type === 'radio') {
      options[name] = $this.val();
    ***REMOVED***

    $image.cropper('destroy').cropper(options);
  ***REMOVED***);


  // Methods
  $('.docs-buttons').on('click', '[data-method]', function () {
    var $this = $(this);
    var data = $this.data();
    var $target;
    var result;

    if ($this.prop('disabled') || $this.hasClass('disabled')) {
      return;
    ***REMOVED***

    if ($image.data('cropper') && data.method) {
      data = $.extend({***REMOVED***, data); // Clone a new one

      if (typeof data.target !== 'undefined') {
        $target = $(data.target);

        if (typeof data.option === 'undefined') {
          try {
            data.option = JSON.parse($target.val());
          ***REMOVED*** catch (e) {
            console.log(e.message);
          ***REMOVED***
        ***REMOVED***
      ***REMOVED***

      if (data.method === 'rotate') {
        $image.cropper('clear');
      ***REMOVED***

      result = $image.cropper(data.method, data.option, data.secondOption);

      if (data.method === 'rotate') {
        $image.cropper('crop');
      ***REMOVED***

      switch (data.method) {
        case 'scaleX':
        case 'scaleY':
          $(this).data('option', -data.option);
          break;

        case 'getCroppedCanvas':
          if (result) {

            // Bootstrap's Modal
            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

            if (!$download.hasClass('disabled')) {
              $download.attr('href', result.toDataURL('image/jpeg'));
            ***REMOVED***
          ***REMOVED***

          break;
      ***REMOVED***

      if ($.isPlainObject(result) && $target) {
        try {
          $target.val(JSON.stringify(result));
        ***REMOVED*** catch (e) {
          console.log(e.message);
        ***REMOVED***
      ***REMOVED***

    ***REMOVED***
  ***REMOVED***);


  // Keyboard
  $(document.body).on('keydown', function (e) {

    if (!$image.data('cropper') || this.scrollTop > 300) {
      return;
    ***REMOVED***

    switch (e.which) {
      case 37:
        e.preventDefault();
        $image.cropper('move', -1, 0);
        break;

      case 38:
        e.preventDefault();
        $image.cropper('move', 0, -1);
        break;

      case 39:
        e.preventDefault();
        $image.cropper('move', 1, 0);
        break;

      case 40:
        e.preventDefault();
        $image.cropper('move', 0, 1);
        break;
    ***REMOVED***

  ***REMOVED***);


  // Import image
  var $inputImage = $('#inputImage');
  var URL = window.URL || window.webkitURL;
  var blobURL;

  if (URL) {
    $inputImage.change(function () {
      var files = this.files;
      var file;

      if (!$image.data('cropper')) {
        return;
      ***REMOVED***

      if (files && files.length) {
        file = files[0];

        if (/^image\/\w+$/.test(file.type)) {
          blobURL = URL.createObjectURL(file);
          $image.one('built.cropper', function () {

            // Revoke when load complete
            URL.revokeObjectURL(blobURL);
          ***REMOVED***).cropper('reset').cropper('replace', blobURL);
          $inputImage.val('');
        ***REMOVED*** else {
          window.alert('Please choose an image file.');
        ***REMOVED***
      ***REMOVED***
    ***REMOVED***);
  ***REMOVED*** else {
    $inputImage.prop('disabled', true).parent().addClass('disabled');
  ***REMOVED***

***REMOVED***);