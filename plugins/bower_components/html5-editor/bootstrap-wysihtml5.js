!function($, wysi) {
    "use strict";

    var tpl = {
        "font-styles": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li class='dropdown'>" +
              "<a class='btn dropdown-toggle" + size + "' data-toggle='dropdown' href='#'>" +
              "<i class='fa fa-font'></i>&nbsp;<span class='current-font'>" + locale.font_styles.normal + "</span>&nbsp;<b class='caret'></b>" +
              "</a>" +
              "<ul class='dropdown-menu'>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='div'>" + locale.font_styles.normal + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h1'>" + locale.font_styles.h1 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h2'>" + locale.font_styles.h2 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h3'>" + locale.font_styles.h3 + "</a></li>" +
              "</ul>" +
            "</li>";
        ***REMOVED***,

        "emphasis": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='btn-group'>" +
                "<a class='btn" + size + "' data-wysihtml5-command='bold' title='CTRL+B'>" + locale.emphasis.bold + "</a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='italic' title='CTRL+I'>" + locale.emphasis.italic + "</a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='underline' title='CTRL+U'>" + locale.emphasis.underline + "</a>" +
              "</div>" +
            "</li>";
        ***REMOVED***,

        "lists": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='btn-group'>" +
                "<a class='btn" + size + "' data-wysihtml5-command='insertUnorderedList' title='" + locale.lists.unordered + "'><i class='fa fa-list'></i></a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='insertOrderedList' title='" + locale.lists.ordered + "'><i class='fa fa-th-list'></i></a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='Outdent' title='" + locale.lists.outdent + "'><i class='fa fa-outdent'></i></a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='Indent' title='" + locale.lists.indent + "'><i class='fa fa-indent'></i></a>" +
              "</div>" +
            "</li>";
        ***REMOVED***,

        "link": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='bootstrap-wysihtml5-insert-link-modal modal fade bs-example-modal-lg'>" +
                "<div class='modal-dialog modal-lg'>" +
					"<div class='modal-content'>" +
				"<div class='modal-header'>" +
                  "<a class='close' data-dismiss='modal'></a>" +
                  "<h3>" + locale.link.insert + "</h3>" +
                "</div>" +
                "<div class='modal-body'>" +
                  "<div class='form-group'>" +
				  "<input value='http://' class='bootstrap-wysihtml5-insert-link-url form-control' type='text'>" +
                "</div>" +
				"</div>" +
                "<div class='modal-footer'>" +
                  "<a href='#' class='btn btn-inverse' data-dismiss='modal'>" + locale.link.cancel + "</a>" +
                  "<a href='#' class='btn btn-primary' data-dismiss='modal'>" + locale.link.insert + "</a>" +
                "</div>" +
              "</div>" +
			  "</div>" +
              "</div>" +
              "<a class='btn" + size + "' data-wysihtml5-command='createLink' title='" + locale.link.insert + "'><i class='fa fa-link'></i></a>" +
            "</li>";
        ***REMOVED***,

        "image": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='bootstrap-wysihtml5-insert-image-modal modal fade bs-example-modal-lg'>" +
                "<div class='modal-dialog modal-lg'>" +
					"<div class='modal-content'>" +
				"<div class='modal-header'>" +
                  "<a class='close' data-dismiss='modal'></a>" +
                  "<h3>" + locale.image.insert + "</h3>" +
                "</div>" +
                "<div class='modal-body'>" +
                 "<div class='form-group'>" +
				  "<input value='http://' class='bootstrap-wysihtml5-insert-image-url  m-wrap large form-control' type='text'>" +
                "</div>" +
				"</div>" +
                "<div class='modal-footer'>" +
                  "<a href='#' class='btn' data-dismiss='modal'>" + locale.image.cancel + "</a>" +
                  "<a href='#' class='btn  green btn-primary' data-dismiss='modal'>" + locale.image.insert + "</a>" +
                "</div>" +
              "</div>" +
			  "</div>" +
              "</div>" +
              "<a class='btn" + size + "' data-wysihtml5-command='insertImage' title='" + locale.image.insert + "'><i class='fa fa-image '></i></a>" +
            "</li>";
        ***REMOVED***,

        "html": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='btn-group'>" + 
                "<a class='btn" + size + "' data-wysihtml5-action='change_view' title='" + locale.html.edit + "'><i class='fa fa-pencil'></i></a>" +
              "</div>" +
            "</li>";
        ***REMOVED***,

        "color": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li class='dropdown'>" +
              "<a class='btn dropdown-toggle" + size + "' data-toggle='dropdown' href='#'>" +
                "<span class='current-color'>" + locale.colours.black + "</span>&nbsp;<b class='caret'></b>" +
              "</a>" +
              "<ul class='dropdown-menu'>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='black'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='black'>" + locale.colours.black + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='silver'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='silver'>" + locale.colours.silver + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='gray'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='gray'>" + locale.colours.gray + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='maroon'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='maroon'>" + locale.colours.maroon + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='red'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='red'>" + locale.colours.red + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='purple'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='purple'>" + locale.colours.purple + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='green'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='green'>" + locale.colours.green + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='olive'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='olive'>" + locale.colours.olive + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='navy'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='navy'>" + locale.colours.navy + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='blue'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='blue'>" + locale.colours.blue + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='orange'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='orange'>" + locale.colours.orange + "</a></li>" +
              "</ul>" +
            "</li>";
        ***REMOVED***
    ***REMOVED***;

    var templates = function(key, locale, options) {
        return tpl[key](locale, options);
    ***REMOVED***;


    var Wysihtml5 = function(el, options) {
        this.el = el;
        var toolbarOpts = options || defaultOptions;
        for(var t in toolbarOpts.customTemplates) {
          tpl[t] = toolbarOpts.customTemplates[t];
        ***REMOVED***
        this.toolbar = this.createToolbar(el, toolbarOpts);
        this.editor =  this.createEditor(options);

        window.editor = this.editor;

        $('iframe.wysihtml5-sandbox').each(function(i, el){
            $(el.contentWindow).off('focus.wysihtml5').on({
                'focus.wysihtml5' : function(){
                    $('li.dropdown').removeClass('open');
                ***REMOVED***
            ***REMOVED***);
        ***REMOVED***);
    ***REMOVED***;

    Wysihtml5.prototype = {

        constructor: Wysihtml5,

        createEditor: function(options) {
            options = options || {***REMOVED***;
            options.toolbar = this.toolbar[0];

            var editor = new wysi.Editor(this.el[0], options);

            if(options && options.events) {
                for(var eventName in options.events) {
                    editor.on(eventName, options.events[eventName]);
                ***REMOVED***
            ***REMOVED***
            return editor;
        ***REMOVED***,

        createToolbar: function(el, options) {
            var self = this;
            var toolbar = $("<ul/>", {
                'class' : "wysihtml5-toolbar",
                'style': "display:none"
            ***REMOVED***);
            var culture = options.locale || defaultOptions.locale || "en";
            for(var key in defaultOptions) {
                var value = false;

                if(options[key] !== undefined) {
                    if(options[key] === true) {
                        value = true;
                    ***REMOVED***
                ***REMOVED*** else {
                    value = defaultOptions[key];
                ***REMOVED***

                if(value === true) {
                    toolbar.append(templates(key, locale[culture], options));

                    if(key === "html") {
                        this.initHtml(toolbar);
                    ***REMOVED***

                    if(key === "link") {
                        this.initInsertLink(toolbar);
                    ***REMOVED***

                    if(key === "image") {
                        this.initInsertImage(toolbar);
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***

            if(options.toolbar) {
                for(key in options.toolbar) {
                    toolbar.append(options.toolbar[key]);
                ***REMOVED***
            ***REMOVED***

            toolbar.find("a[data-wysihtml5-command='formatBlock']").click(function(e) {
                var target = e.target || e.srcElement;
                var el = $(target);
                self.toolbar.find('.current-font').text(el.html());
            ***REMOVED***);

            toolbar.find("a[data-wysihtml5-command='foreColor']").click(function(e) {
                var target = e.target || e.srcElement;
                var el = $(target);
                self.toolbar.find('.current-color').text(el.html());
            ***REMOVED***);

            this.el.before(toolbar);

            return toolbar;
        ***REMOVED***,

        initHtml: function(toolbar) {
            var changeViewSelector = "a[data-wysihtml5-action='change_view']";
            toolbar.find(changeViewSelector).click(function(e) {
                toolbar.find('a.btn').not(changeViewSelector).toggleClass('disabled');
            ***REMOVED***);
        ***REMOVED***,

        initInsertImage: function(toolbar) {
            var self = this;
            var insertImageModal = toolbar.find('.bootstrap-wysihtml5-insert-image-modal');
            var urlInput = insertImageModal.find('.bootstrap-wysihtml5-insert-image-url');
            var insertButton = insertImageModal.find('a.btn-primary');
            var initialValue = urlInput.val();

            var insertImage = function() {
                var url = urlInput.val();
                urlInput.val(initialValue);
                self.editor.currentView.element.focus();
                self.editor.composer.commands.exec("insertImage", url);
            ***REMOVED***;

            urlInput.keypress(function(e) {
                if(e.which == 13) {
                    insertImage();
                    insertImageModal.modal('hide');
                ***REMOVED***
            ***REMOVED***);

            insertButton.click(insertImage);

            insertImageModal.on('shown', function() {
                urlInput.focus();
            ***REMOVED***);

            insertImageModal.on('hide', function() {
                self.editor.currentView.element.focus();
            ***REMOVED***);

            toolbar.find('a[data-wysihtml5-command=insertImage]').click(function() {
                var activeButton = $(this).hasClass("wysihtml5-command-active");

                if (!activeButton) {
                    insertImageModal.modal('show');
                    insertImageModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                        e.stopPropagation();
                    ***REMOVED***);
                    return false;
                ***REMOVED***
                else {
                    return true;
                ***REMOVED***
            ***REMOVED***);
        ***REMOVED***,

        initInsertLink: function(toolbar) {
            var self = this;
            var insertLinkModal = toolbar.find('.bootstrap-wysihtml5-insert-link-modal');
            var urlInput = insertLinkModal.find('.bootstrap-wysihtml5-insert-link-url');
            var insertButton = insertLinkModal.find('a.btn-primary');
            var initialValue = urlInput.val();

            var insertLink = function() {
                var url = urlInput.val();
                urlInput.val(initialValue);
                self.editor.currentView.element.focus();
                self.editor.composer.commands.exec("createLink", {
                    href: url,
                    target: "_blank",
                    rel: "nofollow"
                ***REMOVED***);
            ***REMOVED***;
            var pressedEnter = false;

            urlInput.keypress(function(e) {
                if(e.which == 13) {
                    insertLink();
                    insertLinkModal.modal('hide');
                ***REMOVED***
            ***REMOVED***);

            insertButton.click(insertLink);

            insertLinkModal.on('shown', function() {
                urlInput.focus();
            ***REMOVED***);

            insertLinkModal.on('hide', function() {
                self.editor.currentView.element.focus();
            ***REMOVED***);

            toolbar.find('a[data-wysihtml5-command=createLink]').click(function() {
                var activeButton = $(this).hasClass("wysihtml5-command-active");

                if (!activeButton) {
                    insertLinkModal.appendTo('body').modal('show');
                    insertLinkModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                        e.stopPropagation();
                    ***REMOVED***);
                    return false;
                ***REMOVED***
                else {
                    return true;
                ***REMOVED***
            ***REMOVED***);
        ***REMOVED***
    ***REMOVED***;

    // these define our public api
    var methods = {
        resetDefaults: function() {
            $.fn.wysihtml5.defaultOptions = $.extend(true, {***REMOVED***, $.fn.wysihtml5.defaultOptionsCache);
        ***REMOVED***,
        bypassDefaults: function(options) {
            return this.each(function () {
                var $this = $(this);
                $this.data('wysihtml5', new Wysihtml5($this, options));
            ***REMOVED***);
        ***REMOVED***,
        shallowExtend: function (options) {
            var settings = $.extend({***REMOVED***, $.fn.wysihtml5.defaultOptions, options || {***REMOVED***);
            var that = this;
            return methods.bypassDefaults.apply(that, [settings]);
        ***REMOVED***,
        deepExtend: function(options) {
            var settings = $.extend(true, {***REMOVED***, $.fn.wysihtml5.defaultOptions, options || {***REMOVED***);
            var that = this;
            return methods.bypassDefaults.apply(that, [settings]);
        ***REMOVED***,
        init: function(options) {
            var that = this;
            return methods.shallowExtend.apply(that, [options]);
        ***REMOVED***
    ***REMOVED***;

    $.fn.wysihtml5 = function ( method ) {
        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        ***REMOVED*** else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        ***REMOVED*** else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.wysihtml5' );
        ***REMOVED***    
    ***REMOVED***;

    $.fn.wysihtml5.Constructor = Wysihtml5;

    var defaultOptions = $.fn.wysihtml5.defaultOptions = {
        "font-styles": true,
        "color": false,
        "emphasis": true,
        "lists": true,
        "html": false,
        "link": true,
        "image": true,
        events: {***REMOVED***,
        parserRules: {
            classes: {
                // (path_to_project/lib/css/wysiwyg-color.css)
                "wysiwyg-color-silver" : 1,
                "wysiwyg-color-gray" : 1,
                "wysiwyg-color-white" : 1,
                "wysiwyg-color-maroon" : 1,
                "wysiwyg-color-red" : 1,
                "wysiwyg-color-purple" : 1,
                "wysiwyg-color-fuchsia" : 1,
                "wysiwyg-color-green" : 1,
                "wysiwyg-color-lime" : 1,
                "wysiwyg-color-olive" : 1,
                "wysiwyg-color-yellow" : 1,
                "wysiwyg-color-navy" : 1,
                "wysiwyg-color-blue" : 1,
                "wysiwyg-color-teal" : 1,
                "wysiwyg-color-aqua" : 1,
                "wysiwyg-color-orange" : 1
            ***REMOVED***,
            tags: {
                "b":  {***REMOVED***,
                "i":  {***REMOVED***,
                "br": {***REMOVED***,
                "ol": {***REMOVED***,
                "ul": {***REMOVED***,
                "li": {***REMOVED***,
                "h1": {***REMOVED***,
                "h2": {***REMOVED***,
                "h3": {***REMOVED***,
                "blockquote": {***REMOVED***,
                "u": 1,
                "img": {
                    "check_attributes": {
                        "width": "numbers",
                        "alt": "alt",
                        "src": "url",
                        "height": "numbers"
                    ***REMOVED***
                ***REMOVED***,
                "a":  {
                    set_attributes: {
                        target: "_blank",
                        rel:    "nofollow"
                    ***REMOVED***,
                    check_attributes: {
                        href:   "url" // important to avoid XSS
                    ***REMOVED***
                ***REMOVED***,
                "span": 1,
                "div": 1
            ***REMOVED***
        ***REMOVED***,
        stylesheets: ["./lib/css/wysiwyg-color.css"], // (path_to_project/lib/css/wysiwyg-color.css)
        locale: "en"
    ***REMOVED***;

    if (typeof $.fn.wysihtml5.defaultOptionsCache === 'undefined') {
        $.fn.wysihtml5.defaultOptionsCache = $.extend(true, {***REMOVED***, $.fn.wysihtml5.defaultOptions);
    ***REMOVED***

    var locale = $.fn.wysihtml5.locale = {
        en: {
            font_styles: {
                normal: "Normal text",
                h1: "Heading 1",
                h2: "Heading 2",
                h3: "Heading 3"
            ***REMOVED***,
            emphasis: {
                bold: "Bold",
                italic: "Italic",
                underline: "Underline"
            ***REMOVED***,
            lists: {
                unordered: "Unordered list",
                ordered: "Ordered list",
                outdent: "Outdent",
                indent: "Indent"
            ***REMOVED***,
            link: {
                insert: "Insert link",
                cancel: "Cancel"
            ***REMOVED***,
            image: {
                insert: "Insert image",
                cancel: "Cancel"
            ***REMOVED***,
            html: {
                edit: "Edit HTML"
            ***REMOVED***,
            colours: {
                black: "Black",
                silver: "Silver",
                gray: "Grey",
                maroon: "Maroon",
                red: "Red",
                purple: "Purple",
                green: "Green",
                olive: "Olive",
                navy: "Navy",
                blue: "Blue",
                orange: "Orange"
            ***REMOVED***
        ***REMOVED***
    ***REMOVED***;

***REMOVED***(window.jQuery, window.wysihtml5);