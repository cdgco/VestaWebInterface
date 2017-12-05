/* Flot plugin for automatically redrawing plots as the placeholder resizes.

Copyright (c) 2007-2014 IOLA and Ole Laursen.
Licensed under the MIT license.

It works by listening for changes on the placeholder div (through the jQuery
resize event plugin) - if the size changes, it will redraw the plot.

There are no options. If you need to disable the plugin for some plots, you
can just fix the size of their placeholders.

*/

/* Inline dependency:
 * jQuery resize event - v1.1 - 3/14/2010
 * http://benalman.com/projects/jquery-resize-plugin/
 *
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($,e,t){"$:nomunge";var i=[],n=$.resize=$.extend($.resize,{***REMOVED***),a,r=false,s="setTimeout",u="resize",m=u+"-special-event",o="pendingDelay",l="activeDelay",f="throttleWindow";n[o]=200;n[l]=20;n[f]=true;$.event.special[u]={setup:function(){if(!n[f]&&this[s]){return false***REMOVED***var e=$(this);i.push(this);e.data(m,{w:e.width(),h:e.height()***REMOVED***);if(i.length===1){a=t;h()***REMOVED******REMOVED***,teardown:function(){if(!n[f]&&this[s]){return false***REMOVED***var e=$(this);for(var t=i.length-1;t>=0;t--){if(i[t]==this){i.splice(t,1);break***REMOVED******REMOVED***e.removeData(m);if(!i.length){if(r){cancelAnimationFrame(a)***REMOVED******REMOVED***clearTimeout(a)***REMOVED***a=null***REMOVED******REMOVED***,add:function(e){if(!n[f]&&this[s]){return false***REMOVED***var i;function a(e,n,a){var r=$(this),s=r.data(m)||{***REMOVED***;s.w=n!==t?n:r.width();s.h=a!==t?a:r.height();i.apply(this,arguments)***REMOVED***if($.isFunction(e)){i=e;return a***REMOVED******REMOVED***i=e.handler;e.handler=a***REMOVED******REMOVED******REMOVED***;function h(t){if(r===true){r=t||1***REMOVED***for(var s=i.length-1;s>=0;s--){var l=$(i[s]);if(l[0]==e||l.is(":visible")){var f=l.width(),c=l.height(),d=l.data(m);if(d&&(f!==d.w||c!==d.h)){l.trigger(u,[d.w=f,d.h=c]);r=t||true***REMOVED******REMOVED******REMOVED***d=l.data(m);d.w=0;d.h=0***REMOVED******REMOVED***if(a!==null){if(r&&(t==null||t-r<1e3)){a=e.requestAnimationFrame(h)***REMOVED******REMOVED***a=setTimeout(h,n[o]);r=false***REMOVED******REMOVED******REMOVED***if(!e.requestAnimationFrame){e.requestAnimationFrame=function(){return e.webkitRequestAnimationFrame||e.mozRequestAnimationFrame||e.oRequestAnimationFrame||e.msRequestAnimationFrame||function(t,i){return e.setTimeout(function(){t((new Date).getTime())***REMOVED***,n[l])***REMOVED******REMOVED***()***REMOVED***if(!e.cancelAnimationFrame){e.cancelAnimationFrame=function(){return e.webkitCancelRequestAnimationFrame||e.mozCancelRequestAnimationFrame||e.oCancelRequestAnimationFrame||e.msCancelRequestAnimationFrame||clearTimeout***REMOVED***()***REMOVED******REMOVED***)(jQuery,this);

(function ($) {
    var options = { ***REMOVED***; // no options

    function init(plot) {
        function onResize() {
            var placeholder = plot.getPlaceholder();

            // somebody might have hidden us and we can't plot
            // when we don't have the dimensions
            if (placeholder.width() == 0 || placeholder.height() == 0)
                return;

            plot.resize();
            plot.setupGrid();
            plot.draw();
        ***REMOVED***
        
        function bindEvents(plot, eventHolder) {
            plot.getPlaceholder().resize(onResize);
        ***REMOVED***

        function shutdown(plot, eventHolder) {
            plot.getPlaceholder().unbind("resize", onResize);
        ***REMOVED***
        
        plot.hooks.bindEvents.push(bindEvents);
        plot.hooks.shutdown.push(shutdown);
    ***REMOVED***
    
    $.plot.plugins.push({
        init: init,
        options: options,
        name: 'resize',
        version: '1.0'
    ***REMOVED***);
***REMOVED***)(jQuery);
