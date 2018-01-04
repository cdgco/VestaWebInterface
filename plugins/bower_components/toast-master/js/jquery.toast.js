;
// jQuery toast plugin created by Kamran Ahmed copyright MIT license 2015
if ( typeof Object.create !== 'function' ) {
    Object.create = function( obj ) {
        function F() {***REMOVED***
        F.prototype = obj;
        return new F();
    ***REMOVED***;
***REMOVED***

(function( $, window, document, undefined ) {

    "use strict";
    
    var Toast = {

        _positionClasses : ['bottom-left', 'bottom-right', 'top-right', 'top-left', 'bottom-center', 'top-center', 'mid-center'],
        _defaultIcons : ['success', 'error', 'info', 'warning'],

        init: function (options, elem) {
            this.prepareOptions(options, $.toast.options);
            this.process();
        ***REMOVED***,

        prepareOptions: function(options, options_to_extend) {
            var _options = {***REMOVED***;
            if ( ( typeof options === 'string' ) || ( options instanceof Array ) ) {
                _options.text = options;
            ***REMOVED*** else {
                _options = options;
            ***REMOVED***
            this.options = $.extend( {***REMOVED***, options_to_extend, _options );
        ***REMOVED***,

        process: function () {
            this.setup();
            this.addToDom();
            this.position();
            this.bindToast();
            this.animate();
        ***REMOVED***,

        setup: function () {
            
            var _toastContent = '';
            
            this._toastEl = this._toastEl || $('<div></div>', {
                class : 'jq-toast-single'
            ***REMOVED***);

            // For the loader on top
            _toastContent += '<span class="jq-toast-loader"></span>';            

            if ( this.options.allowToastClose ) {
                _toastContent += '<span class="close-jq-toast-single">&times;</span>';
            ***REMOVED***;

            if ( this.options.text instanceof Array ) {

                if ( this.options.heading ) {
                    _toastContent +='<h2 class="jq-toast-heading">' + this.options.heading + '</h2>';
                ***REMOVED***;

                _toastContent += '<ul class="jq-toast-ul">';
                for (var i = 0; i < this.options.text.length; i++) {
                    _toastContent += '<li class="jq-toast-li" id="jq-toast-item-' + i + '">' + this.options.text[i] + '</li>';
                ***REMOVED***
                _toastContent += '</ul>';

            ***REMOVED*** else {
                if ( this.options.heading ) {
                    _toastContent +='<h2 class="jq-toast-heading">' + this.options.heading + '</h2>';
                ***REMOVED***;
                _toastContent += this.options.text;
            ***REMOVED***

            this._toastEl.html( _toastContent );

            if ( this.options.bgColor !== false ) {
                this._toastEl.css("background-color", this.options.bgColor);
            ***REMOVED***;

            if ( this.options.textColor !== false ) {
                this._toastEl.css("color", this.options.textColor);
            ***REMOVED***;

            if ( this.options.textAlign ) {
                this._toastEl.css('text-align', this.options.textAlign);
            ***REMOVED***

            if ( this.options.icon !== false ) {
                this._toastEl.addClass('jq-has-icon');

                if ( $.inArray(this.options.icon, this._defaultIcons) !== -1 ) {
                    this._toastEl.addClass('jq-icon-' + this.options.icon);
                ***REMOVED***;
            ***REMOVED***;
        ***REMOVED***,

        position: function () {
            if ( ( typeof this.options.position === 'string' ) && ( $.inArray( this.options.position, this._positionClasses) !== -1 ) ) {

                if ( this.options.position === 'bottom-center' ) {
                    this._container.css({
                        left: ( $(window).outerWidth() / 2 ) - this._container.outerWidth()/2,
                        bottom: 20
                    ***REMOVED***);
                ***REMOVED*** else if ( this.options.position === 'top-center' ) {
                    this._container.css({
                        left: ( $(window).outerWidth() / 2 ) - this._container.outerWidth()/2,
                        top: 20
                    ***REMOVED***);
                ***REMOVED*** else if ( this.options.position === 'mid-center' ) {
                    this._container.css({
                        left: ( $(window).outerWidth() / 2 ) - this._container.outerWidth()/2,
                        top: ( $(window).outerHeight() / 2 ) - this._container.outerHeight()/2
                    ***REMOVED***);
                ***REMOVED*** else {
                    this._container.addClass( this.options.position );
                ***REMOVED***

            ***REMOVED*** else if ( typeof this.options.position === 'object' ) {
                this._container.css({
                    top : this.options.position.top ? this.options.position.top : 'auto',
                    bottom : this.options.position.bottom ? this.options.position.bottom : 'auto',
                    left : this.options.position.left ? this.options.position.left : 'auto',
                    right : this.options.position.right ? this.options.position.right : 'auto'
                ***REMOVED***);
            ***REMOVED*** else {
                this._container.addClass( 'bottom-left' );
            ***REMOVED***
        ***REMOVED***,

        bindToast: function () {

            var that = this;

            this._toastEl.on('afterShown', function () {
                that.processLoader();
            ***REMOVED***);

            this._toastEl.find('.close-jq-toast-single').on('click', function ( e ) {

                e.preventDefault();

                if( that.options.showHideTransition === 'fade') {
                    that._toastEl.trigger('beforeHide');
                    that._toastEl.fadeOut(function () {
                        that._toastEl.trigger('afterHidden');
                    ***REMOVED***);
                ***REMOVED*** else if ( that.options.showHideTransition === 'slide' ) {
                    that._toastEl.trigger('beforeHide');
                    that._toastEl.slideUp(function () {
                        that._toastEl.trigger('afterHidden');
                    ***REMOVED***);
                ***REMOVED*** else {
                    that._toastEl.trigger('beforeHide');
                    that._toastEl.hide(function () {
                        that._toastEl.trigger('afterHidden');
                    ***REMOVED***);
                ***REMOVED***
            ***REMOVED***);

            if ( typeof this.options.beforeShow == 'function' ) {
                this._toastEl.on('beforeShow', function () {
                    that.options.beforeShow();
                ***REMOVED***);
            ***REMOVED***;

            if ( typeof this.options.afterShown == 'function' ) {
                this._toastEl.on('afterShown', function () {
                    that.options.afterShown();
                ***REMOVED***);
            ***REMOVED***;

            if ( typeof this.options.beforeHide == 'function' ) {
                this._toastEl.on('beforeHide', function () {
                    that.options.beforeHide();
                ***REMOVED***);
            ***REMOVED***;

            if ( typeof this.options.afterHidden == 'function' ) {
                this._toastEl.on('afterHidden', function () {
                    that.options.afterHidden();
                ***REMOVED***);
            ***REMOVED***;          
        ***REMOVED***,

        addToDom: function () {

             var _container = $('.jq-toast-wrap');
             
             if ( _container.length === 0 ) {
                
                _container = $('<div></div>',{
                    class: "jq-toast-wrap"
                ***REMOVED***);

                $('body').append( _container );

             ***REMOVED*** else if ( !this.options.stack || isNaN( parseInt(this.options.stack, 10) ) ) {
                _container.empty();
             ***REMOVED***

             _container.find('.jq-toast-single:hidden').remove();

             _container.append( this._toastEl );

            if ( this.options.stack && !isNaN( parseInt( this.options.stack ), 10 ) ) {
                
                var _prevToastCount = _container.find('.jq-toast-single').length,
                    _extToastCount = _prevToastCount - this.options.stack;

                if ( _extToastCount > 0 ) {
                    $('.jq-toast-wrap').find('.jq-toast-single').slice(0, _extToastCount).remove();
                ***REMOVED***;

            ***REMOVED***

            this._container = _container;
        ***REMOVED***,

        canAutoHide: function () {
            return ( this.options.hideAfter !== false ) && !isNaN( parseInt( this.options.hideAfter, 10 ) );
        ***REMOVED***,

        processLoader: function () {
            // Show the loader only, if auto-hide is on and loader is demanded
            if (!this.canAutoHide() || this.options.loader === false) {
                return false;
            ***REMOVED***

            var loader = this._toastEl.find('.jq-toast-loader');

            // 400 is the default time that jquery uses for fade/slide
            // Divide by 1000 for milliseconds to seconds conversion
            var transitionTime = (this.options.hideAfter - 400) / 1000 + 's';
            var loaderBg = this.options.loaderBg;

            var style = loader.attr('style') || '';
            style = style.substring(0, style.indexOf('-webkit-transition')); // Remove the last transition definition

            style += '-webkit-transition: width ' + transitionTime + ' ease-in; \
                      -o-transition: width ' + transitionTime + ' ease-in; \
                      transition: width ' + transitionTime + ' ease-in; \
                      background-color: ' + loaderBg + ';';


            loader.attr('style', style).addClass('jq-toast-loaded');
        ***REMOVED***,

        animate: function () {

            var that = this;

            this._toastEl.hide();

            this._toastEl.trigger('beforeShow');

            if ( this.options.showHideTransition.toLowerCase() === 'fade' ) {
                this._toastEl.fadeIn(function ( ){
                    that._toastEl.trigger('afterShown');
                ***REMOVED***);
            ***REMOVED*** else if ( this.options.showHideTransition.toLowerCase() === 'slide' ) {
                this._toastEl.slideDown(function ( ){
                    that._toastEl.trigger('afterShown');
                ***REMOVED***);
            ***REMOVED*** else {
                this._toastEl.show(function ( ){
                    that._toastEl.trigger('afterShown');
                ***REMOVED***);
            ***REMOVED***

            if (this.canAutoHide()) {

                var that = this;

                window.setTimeout(function(){
                    
                    if ( that.options.showHideTransition.toLowerCase() === 'fade' ) {
                        that._toastEl.trigger('beforeHide');
                        that._toastEl.fadeOut(function () {
                            that._toastEl.trigger('afterHidden');
                        ***REMOVED***);
                    ***REMOVED*** else if ( that.options.showHideTransition.toLowerCase() === 'slide' ) {
                        that._toastEl.trigger('beforeHide');
                        that._toastEl.slideUp(function () {
                            that._toastEl.trigger('afterHidden');
                        ***REMOVED***);
                    ***REMOVED*** else {
                        that._toastEl.trigger('beforeHide');
                        that._toastEl.hide(function () {
                            that._toastEl.trigger('afterHidden');
                        ***REMOVED***);
                    ***REMOVED***

                ***REMOVED***, this.options.hideAfter);
            ***REMOVED***;
        ***REMOVED***,

        reset: function ( resetWhat ) {

            if ( resetWhat === 'all' ) {
                $('.jq-toast-wrap').remove();
            ***REMOVED*** else {
                this._toastEl.remove();
            ***REMOVED***

        ***REMOVED***,

        update: function(options) {
            this.prepareOptions(options, this.options);
            this.setup();
            this.bindToast();
        ***REMOVED***
    ***REMOVED***;
    
    $.toast = function(options) {
        var toast = Object.create(Toast);
        toast.init(options, this);

        return {
            
            reset: function ( what ) {
                toast.reset( what );
            ***REMOVED***,

            update: function( options ) {
                toast.update( options );
            ***REMOVED***
        ***REMOVED***
    ***REMOVED***;

    $.toast.options = {
        text: '',
        heading: '',
        showHideTransition: 'fade',
        allowToastClose: true,
        hideAfter: 3000,
        loader: true,
        loaderBg: '#9EC600',
        stack: 5,
        position: 'bottom-left',
        bgColor: false,
        textColor: false,
        textAlign: 'left',
        icon: false,
        beforeShow: function () {***REMOVED***,
        afterShown: function () {***REMOVED***,
        beforeHide: function () {***REMOVED***,
        afterHidden: function () {***REMOVED***
    ***REMOVED***;

***REMOVED***)( jQuery, window, document );
