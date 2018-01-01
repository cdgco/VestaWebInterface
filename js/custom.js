/*!
Template Name : Ample Admin - The Ultimate Dashboad Template
Author : WrapPixel (http://www.wrappixel.com)
 */
$(window).load(function(){
    $(function () {
        $(".preloader").fadeOut();
        $('#side-menu').metisMenu();
    ***REMOVED***);
    // Theme settings
    $(".open-close").click(function () {
        $("body").toggleClass("show-sidebar");
    ***REMOVED***);
    //Open-Close-right sidebar
    $(".right-side-toggle").click(function () {
        $(".right-sidebar").slideDown(50);
        $(".right-sidebar").toggleClass("shw-rside");
        // Fix header
        $(".fxhdr").click(function () {
            $("body").toggleClass("fix-header");
        ***REMOVED***);
        // Fix sidebar
        $(".fxsdr").click(function () {
            $("body").toggleClass("fix-sidebar");
        ***REMOVED***);
        // Service panel js
        if ($("body").hasClass("fix-header")) {
            $('.fxhdr').attr('checked', true);
        ***REMOVED***
        else {
            $('.fxhdr').attr('checked', false);
        ***REMOVED***
       
    ***REMOVED***);
    //Loads the correct sidebar on window load,
    //collapses the sidebar on window resize.
    // Sets the min-height of #page-wrapper to window size
    $(function () {
        $(window).bind("load resize", function () {
            topOffset = 60;
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 768) {
                $('div.navbar-collapse').addClass('collapse');
                topOffset = 100; // 2-row-menu
            ***REMOVED***
            else {
                $('div.navbar-collapse').removeClass('collapse');
            ***REMOVED***
            height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
            height = height - topOffset;
            if (height < 1) height = 1;
            if (height > topOffset) {
                $("#page-wrapper").css("min-height", (height) + "px");
            ***REMOVED***
        ***REMOVED***);
        var url = window.location;
        var element = $('ul.nav a').filter(function () {
            return this.href == url || url.href.indexOf(this.href) == 0;
        ***REMOVED***).addClass('active').parent().parent().addClass('in').parent();
        if (element.is('li')) {
            element.addClass('active');
        ***REMOVED***
    ***REMOVED***);
    // This is for resize window
    $(function () {
        $(window).bind("load resize", function () {
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 1170) {
                $('body').addClass('content-wrapper');
                $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
                
            ***REMOVED***
            else {
                $('body').removeClass('content-wrapper');
                
            ***REMOVED***
        ***REMOVED***);
    ***REMOVED***);
    
    // Collapse Panels
    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-collapse"]';
        $(panelSelector).each(function () {
            var $this = $(this)
                , parent = $this.closest('.panel')
                , wrapper = parent.find('.panel-wrapper')
                , collapseOpts = {
                    toggle: false
                ***REMOVED***;
            if (!wrapper.length) {
                wrapper = parent.children('.panel-heading').nextAll().wrapAll('<div/>').parent().addClass('panel-wrapper');
                collapseOpts = {***REMOVED***;
            ***REMOVED***
            wrapper.collapse(collapseOpts).on('hide.bs.collapse', function () {
                $this.children('i').removeClass('ti-minus').addClass('ti-plus');
            ***REMOVED***).on('show.bs.collapse', function () {
                $this.children('i').removeClass('ti-plus').addClass('ti-minus');
            ***REMOVED***);
        ***REMOVED***);
        $(document).on('click', panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest('.panel');
            var wrapper = parent.find('.panel-wrapper');
            wrapper.collapse('toggle');
        ***REMOVED***);
    ***REMOVED***(jQuery, window, document));
    // Remove Panels
    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-dismiss"]';
        $(document).on('click', panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest('.panel');
            removeElement();

            function removeElement() {
                var col = parent.parent();
                parent.remove();
                col.filter(function () {
                    var el = $(this);
                    return (el.is('[class*="col-"]') && el.children('*').length === 0);
                ***REMOVED***).remove();
            ***REMOVED***
        ***REMOVED***);
    ***REMOVED***(jQuery, window, document));
    //tooltip
    $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        ***REMOVED***)
        //Popover
    $(function () {
            $('[data-toggle="popover"]').popover()
        ***REMOVED***)
        // Task
    $(".list-task li label").click(function () {
        $(this).toggleClass("task-done");
    ***REMOVED***);
    $(".settings_box a").click(function () {
        $("ul.theme_color").toggleClass("theme_block");
    ***REMOVED***);
***REMOVED***);
//Colepsible toggle
$(".collapseble").click(function () {
    $(".collapseblebox").fadeToggle(350);
***REMOVED***);
// Sidebar
$('.slimscrollright').slimScroll({
    height: '100%'
    , position: 'right'
    , size: "5px"
    , color: '#dcdcdc'
    , opacity: 0
***REMOVED***).mouseover(function() {
    $(this).next('.slimScrollBar').css('opacity', 0.4);
***REMOVED***);
$('.slimscrollsidebar').slimScroll({
    height: '100%'
    , position: 'left'
    , size: "6px"
    , color: 'rgba(0,0,0,0.5)'
    , opacity: 0
***REMOVED***).mouseover(function() {
$(this).next('.slimScrollBar').css('opacity', 0.4);
***REMOVED***);
// Resize all elements
$("body").trigger("resize");
// visited ul li
$('.visited li a').click(function (e) {
    $('.visited li').removeClass('active');
    var $parent = $(this).parent();
    if (!$parent.hasClass('active')) {
        $parent.addClass('active');
    ***REMOVED***
    e.preventDefault();
***REMOVED***);
// Login and recover password
$('#to-recover').click(function () {
    $("#loginform").slideUp();
    $("#recoverform").fadeIn();
***REMOVED***);
// Update 1.5
// this is for close icon when navigation open in mobile view
$(".navbar-toggle").click(function () {
    $(".navbar-toggle i").toggleClass("ti-menu");
    $(".navbar-toggle i").addClass("ti-close");
***REMOVED***);
// Update 1.6
