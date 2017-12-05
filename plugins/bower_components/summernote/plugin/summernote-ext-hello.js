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
  // template
  var tmpl = $.summernote.renderer.getTemplate();

  /**
   * @class plugin.hello 
   * 
   * Hello Plugin  
   */
  $.summernote.addPlugin({
    /** @property {String***REMOVED*** name name of plugin */
    name: 'hello',
    /** 
     * @property {Object***REMOVED*** buttons 
     * @property {Function***REMOVED*** buttons.hello   function to make button
     * @property {Function***REMOVED*** buttons.helloDropdown   function to make button
     * @property {Function***REMOVED*** buttons.helloImage   function to make button
     */
    buttons: { // buttons
      hello: function (lang, options) {

        return tmpl.iconButton(options.iconPrefix + 'header', {
          event : 'hello',
          title: 'hello',
          hide: true
        ***REMOVED***);
      ***REMOVED***,
      helloDropdown: function (lang, options) {


        var list = '<li><a data-event="helloDropdown" href="#" data-value="summernote">summernote</a></li>';
        list += '<li><a data-event="helloDropdown" href="#" data-value="codemirror">Code Mirror</a></li>';
        var dropdown = '<ul class="dropdown-menu">' + list + '</ul>';

        return tmpl.iconButton(options.iconPrefix + 'header', {
          title: 'hello',
          hide: true,
          dropdown : dropdown
        ***REMOVED***);
      ***REMOVED***,
      helloImage : function (lang, options) {
        return tmpl.iconButton(options.iconPrefix + 'file-image-o', {
          event : 'helloImage',
          title: 'helloImage',
          hide: true
        ***REMOVED***);
      ***REMOVED***

    ***REMOVED***,

    /**
     * @property {Object***REMOVED*** events 
     * @property {Function***REMOVED*** events.hello  run function when button that has a 'hello' event name  fires click
     * @property {Function***REMOVED*** events.helloDropdown run function when button that has a 'helloDropdown' event name  fires click
     * @property {Function***REMOVED*** events.helloImage run function when button that has a 'helloImage' event name  fires click
     */
    events: { // events
      hello: function (event, editor, layoutInfo) {
        // Get current editable node
        var $editable = layoutInfo.editable();

        // Call insertText with 'hello'
        editor.insertText($editable, 'hello ');
      ***REMOVED***,
      helloDropdown: function (event, editor, layoutInfo, value) {
        // Get current editable node
        var $editable = layoutInfo.editable();

        // Call insertText with 'hello'
        editor.insertText($editable, 'hello ' + value + '!!!!');
      ***REMOVED***,
      helloImage : function (event, editor, layoutInfo) {
        var $editable = layoutInfo.editable();

        var img = $('<img src="http://upload.wikimedia.org/wikipedia/commons/b/b0/NewTux.svg" />');
        editor.insertNode($editable, img[0]);
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***);
***REMOVED***));
