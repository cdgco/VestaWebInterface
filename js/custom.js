$(window).load(function () {
    $(function () {
        $(".preloader").fadeOut();
        $("#side-menu").metisMenu();
    ***REMOVED***);
    $(".open-close").click(function () {
        $("body").toggleClass("show-sidebar");
    ***REMOVED***);
    $(".right-side-toggle").click(function () {
        $(".right-sidebar").slideDown(50);
        $(".right-sidebar").toggleClass("shw-rside");
        $(".fxhdr").click(function () {
            $("body").toggleClass("fix-header");
        ***REMOVED***);
        $(".fxsdr").click(function () {
            $("body").toggleClass("fix-sidebar");
        ***REMOVED***);
        if ($("body").hasClass("fix-header")) {
            $(".fxhdr").attr("checked", true);
        ***REMOVED*** else {
            $(".fxhdr").attr("checked", false);
        ***REMOVED***
    ***REMOVED***);
    $(function () {
        $(window).bind("load resize", function () {
            topOffset = 60;
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 768) {
                $("div.navbar-collapse").addClass("collapse");
                topOffset = 100; // 2-row-menu
            ***REMOVED*** else {
                $("div.navbar-collapse").removeClass("collapse");
            ***REMOVED***
            height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
            height = height - topOffset;
            if (height < 1) { height = 1; ***REMOVED***
            if (height > topOffset) {
                $("#page-wrapper").css("min-height", (height) + "px");
            ***REMOVED***
        ***REMOVED***);
        var url = window.location;
        var element = $("ul.nav a").filter(function () {
            return this.href === url || url.href.indexOf(this.href) === 0;
        ***REMOVED***).addClass("active").parent().parent().addClass("in").parent();
        if (element.is("li")) {
            element.addClass("active");
        ***REMOVED***
    ***REMOVED***);
    $(function () {
        $(window).bind("load resize", function () {
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 1170) {
                $('body').addClass('content-wrapper');
                $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
                
            ***REMOVED*** else {
                $("body").removeClass("content-wrapper");
            ***REMOVED***
        ***REMOVED***);
    ***REMOVED***);
    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-collapse"]';
        $(panelSelector).each(function () {
            var $this = $(this),
                parent = $this.closest(".panel"),
                wrapper = parent.find(".panel-wrapper"),
                collapseOpts = {
                    toggle: false
                ***REMOVED***;
            if (!wrapper.length) {
                wrapper = parent.children(".panel-heading").nextAll().wrapAll("<div/>").parent().addClass("panel-wrapper");
                collapseOpts = {***REMOVED***;
            ***REMOVED***
            wrapper.collapse(collapseOpts).on("hide.bs.collapse", function () {
                $this.children("i").removeClass("ti-minus").addClass("ti-plus");
            ***REMOVED***).on("show.bs.collapse", function () {
                $this.children("i").removeClass("ti-plus").addClass("ti-minus");
            ***REMOVED***);
        ***REMOVED***);
        $(document).on("click", panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest(".panel");
            var wrapper = parent.find(".panel-wrapper");
            wrapper.collapse("toggle");
        ***REMOVED***);
    ***REMOVED***(jQuery, window, document));
    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-dismiss"]';
        $(document).on("click", panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest(".panel");
            function removeElement() {
                var col = parent.parent();
                parent.remove();
                col.filter(function () {
                    var el = $(this);
                    return (el.is('[class*="col-"]') && el.children("*").length === 0);
                ***REMOVED***).remove();
            ***REMOVED***
            removeElement();
        ***REMOVED***);
    ***REMOVED***(jQuery, window, document));
    //tooltip
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    ***REMOVED***);
    $(function () {
        $('[data-toggle="popover"]').popover();
    ***REMOVED***);
    $(".list-task li label").click(function () {
        $(this).toggleClass("task-done");
    ***REMOVED***);
    $(".settings_box a").click(function () {
        $("ul.theme_color").toggleClass("theme_block");
    ***REMOVED***);
***REMOVED***);
$(".collapseble").click(function () {
    $(".collapseblebox").fadeToggle(350);
***REMOVED***);
$(".slimscrollright").slimScroll({
    height: "100%",
    position: "right",
    size: "5px",
    color: "#dcdcdc",
    opacity: 0
***REMOVED***).mouseover(function () {
    $(this).next(".slimScrollBar").css("opacity", 0.4);
***REMOVED***);
$(".slimscrollsidebar").slimScroll({
    height: "100%",
    position: "left",
    size: "6px",
    color: "rgba(0,0,0,0.5)",
    opacity: 0
***REMOVED***).mouseover(function () {
    $(this).next(".slimScrollBar").css("opacity", 0.4);
***REMOVED***);
$("body").trigger("resize");
// visited ul li
$(".visited li a").click(function (e) {
    $(".visited li").removeClass("active");
    var $parent = $(this).parent();
    if (!$parent.hasClass("active")) {
        $parent.addClass("active");
    ***REMOVED***
    e.preventDefault();
***REMOVED***);
$("#to-recover").click(function () {
    $("#loginform").fadeOut("fast", function () {$("#recoverform").fadeIn(); ***REMOVED***);
***REMOVED***);
$('#to-login').click(function () {
    $("#recoverform").fadeOut("fast", function () {$("#loginform").fadeIn(); ***REMOVED***);
***REMOVED***);
$(".navbar-toggle").click(function () {
    $(".navbar-toggle i").toggleClass("ti-menu");
    $(".navbar-toggle i").addClass("ti-close");
***REMOVED***);
