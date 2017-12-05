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
  // import core class
  var range = $.summernote.core.range;

  var KEY = {
    UP: 38,
    DOWN: 40,
    ENTER: 13
  ***REMOVED***;

  var DROPDOWN_KEYCODES = [KEY.UP, KEY.DOWN, KEY.ENTER];

  /**
   * @class plugin.hint
   *
   * Hint Plugin
   */
  $.summernote.addPlugin({
    /**
     * name name of plugin
     * @property {String***REMOVED***
     **/
    name: 'hint',

    /**
     * @property {Regex***REMOVED***
     * @interface
     */
    match: /[a-z]+/g,

    /**
     * create list item template
     *
     * @interface
     * @param {Object***REMOVED*** search
     * @returns {Array***REMOVED***  created item list
     */
    template: null,

    /**
     * create inserted content to add  in summernote
     *
     * @interface
     * @param {String***REMOVED*** html
     * @param {String***REMOVED*** keyword
     * @return {HTMLEleemnt|String***REMOVED***
     */
    content: null,

    /**
     * load search list
     *
     * @interface
     */
    load: null,

    /**
     * @param {jQuery***REMOVED*** $node
     */
    scrollTo: function ($node) {
      var $parent = $node.parent();
      $parent[0].scrollTop = $node[0].offsetTop - ($parent.innerHeight() / 2);
    ***REMOVED***,

    /**
     * @param {jQuery***REMOVED*** $popover
     */
    moveDown: function ($popover) {
      var index = $popover.find('.active').index();
      this.activate($popover, (index === -1) ? 0 : (index + 1) % $popover.children().length);
    ***REMOVED***,

    /**
     * @param {jQuery***REMOVED*** $popover
     */
    moveUp: function ($popover) {
      var index = $popover.find('.active').index();
      this.activate($popover, (index === -1) ? 0 : (index - 1) % $popover.children().length);
    ***REMOVED***,

    /**
     * @param {jQuery***REMOVED*** $popover
     * @param {Number***REMOVED*** i
     */
    activate: function ($popover, idx) {
      idx = idx || 0;

      if (idx < 0) {
        idx = $popover.children().length - 1;
      ***REMOVED***

      $popover.children().removeClass('active');
      var $activeItem = $popover.children().eq(idx);
      $activeItem.addClass('active');

      this.scrollTo($activeItem);
    ***REMOVED***,

    /**
     * @param {jQuery***REMOVED*** $popover
     */
    replace: function ($popover) {
      var wordRange = $popover.data('wordRange');
      var $activeItem = $popover.find('.active');
      var content = this.content($activeItem.data('item'));

      if (typeof content === 'string') {
        content = document.createTextNode(content);
      ***REMOVED***

      $popover.removeData('wordRange');

      wordRange.insertNode(content);
      range.createFromNode(content).collapse().select();
    ***REMOVED***,

    /**
     * @param {String***REMOVED*** keyword
     * @return {Object|null***REMOVED***
     */
    searchKeyword: function (keyword, callback) {
      if (this.match.test(keyword)) {
        var matches = this.match.exec(keyword);
        this.search(matches[1], callback);
      ***REMOVED*** else {
        callback();
      ***REMOVED***
    ***REMOVED***,


    createTemplate: function (list) {
      var items  = [];
      list = list || [];

      for (var i = 0, len = list.length; i < len; i++) {
        var $item = $('<a class="list-group-item"></a>');
        $item.append(this.template(list[i]));
        $item.data('item', list[i]);
        items.push($item);
      ***REMOVED***

      if (items.length) {
        items[0].addClass('active');
      ***REMOVED***

      return items;
    ***REMOVED***,

    search: function (keyword, callback) {
      keyword = keyword || '';
      callback();
    ***REMOVED***,

    init : function (layoutInfo) {
      var self = this;

      var $note = layoutInfo.holder();
      var $popover = $('<div />').addClass('hint-group').css({
        'position': 'absolute',
        'max-height': 150,
        'z-index' : 999,
        'overflow' : 'hidden',
        'display' : 'none',
        'border' : '1px solid gray',
        'border-radius' : '5px'
      ***REMOVED***);

      $popover.on('click', '.list-group-item', function HintItemClick() {
        self.replace($popover);

        $popover.hide();
        $note.summernote('focus');
      ***REMOVED***);

      $(document).on('click', function HintClick() {
        $popover.hide();
      ***REMOVED***);

      $note.on('summernote.keydown', function HintKeyDown(customEvent, nativeEvent) {
        if ($popover.css('display') !== 'block') {
          return true;
        ***REMOVED***

        if (nativeEvent.keyCode === KEY.DOWN) {
          nativeEvent.preventDefault();
          self.moveDown($popover);
        ***REMOVED*** else if (nativeEvent.keyCode === KEY.UP) {
          nativeEvent.preventDefault();
          self.moveUp($popover);
        ***REMOVED*** else if (nativeEvent.keyCode === KEY.ENTER) {
          nativeEvent.preventDefault();
          self.replace($popover);

          $popover.hide();
          $note.summernote('focus');
        ***REMOVED***
      ***REMOVED***);

      var timer = null;
      $note.on('summernote.keyup', function HintKeyUp(customEvent, nativeEvent) {
        if (DROPDOWN_KEYCODES.indexOf(nativeEvent.keyCode) > -1) {
          if (nativeEvent.keyCode === KEY.ENTER) {
            if ($popover.css('display') === 'block') {
              return false;
            ***REMOVED***
          ***REMOVED***

        ***REMOVED*** else {

          clearTimeout(timer);
          timer = setTimeout(function () {
            var range = $note.summernote('createRange');
            var word = range.getWordRange();

            self.searchKeyword(word.toString(), function (searchList) {
              if (!searchList) {
                $popover.hide();
                return;
              ***REMOVED***

              if (searchList && !searchList.length) {
                $popover.hide();
                return;
              ***REMOVED***

              layoutInfo.popover().append($popover);

              // popover below placeholder.
              var rects = word.getClientRects();
              var rect = rects[rects.length - 1];
              $popover.html(self.createTemplate(searchList)).css({
                left: rect.left,
                top: rect.top + rect.height
              ***REMOVED***).data('wordRange', word).show();
            ***REMOVED***);
          ***REMOVED***, self.throttle);

        ***REMOVED***
      ***REMOVED***);

      this.load($popover);
    ***REMOVED***,

    throttle : 50,

    // FIXME Summernote doesn't support event pipeline yet.
    //  - Plugin -> Base Code
    events: {
      ENTER: function (e, editor, layoutInfo) {

        if (layoutInfo.popover().find('.hint-group').css('display') !== 'block') {
          // apply default enter key
          layoutInfo.holder().summernote('insertParagraph');
        ***REMOVED***

        // prevent ENTER key
        return true;
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***);
***REMOVED***));
