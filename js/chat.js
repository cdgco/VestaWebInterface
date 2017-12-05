$('.chat-left-inner > .chatonline').slimScroll({
    height: '100%',
    position: 'right',
    size: "0px",
    color: '#dcdcdc',

***REMOVED***);
 $(function(){
            $(window).load(function(){ // On load
                $('.chat-list').css({'height':(($(window).height())-470)+'px'***REMOVED***);
            ***REMOVED***);
            $(window).resize(function(){ // On resize
                $('.chat-list').css({'height':(($(window).height())-470)+'px'***REMOVED***);
            ***REMOVED***);
    ***REMOVED***);

// this is for the left-aside-fix in content area with scroll

$(function() {
    $(window).load(function() { // On load
        $('.chat-left-inner').css({
            'height': (($(window).height()) - 240) + 'px'
        ***REMOVED***);
    ***REMOVED***);
    $(window).resize(function() { // On resize
        $('.chat-left-inner').css({
            'height': (($(window).height()) - 240) + 'px'
        ***REMOVED***);
    ***REMOVED***);
***REMOVED***);


$(".open-panel").click(function() {
    $(".chat-left-aside").toggleClass("open-pnl");
    $(".open-panel i").toggleClass("ti-angle-left");
***REMOVED***);

