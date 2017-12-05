/*
 * jquery.flot.tooltip
 * 
 * description: easy-to-use tooltips for Flot charts
 * version: 0.8.5
 * authors: Krzysztof Urbas @krzysu [myviews.pl],Evan Steinkerchner @Roundaround
 * website: https://github.com/krzysu/flot.tooltip
 * 
 * build on 2015-05-11
 * released under MIT License, 2012
*/ 
(function ($) {
    // plugin options, default values
    var defaultOptions = {
        tooltip: {
            show: false,
            cssClass: "flotTip",
            content: "%s | X: %x | Y: %y",
            // allowed templates are:
            // %s -> series label,
            // %c -> series color,
            // %lx -> x axis label (requires flot-axislabels plugin https://github.com/markrcote/flot-axislabels),
            // %ly -> y axis label (requires flot-axislabels plugin https://github.com/markrcote/flot-axislabels),
            // %x -> X value,
            // %y -> Y value,
            // %x.2 -> precision of X value,
            // %p -> percent
            xDateFormat: null,
            yDateFormat: null,
            monthNames: null,
            dayNames: null,
            shifts: {
                x: 10,
                y: 20
            ***REMOVED***,
            defaultTheme: true,
            lines: false,

            // callbacks
            onHover: function (flotItem, $tooltipEl) {***REMOVED***,

            $compat: false
        ***REMOVED***
    ***REMOVED***;

    // dummy default options object for legacy code (<0.8.5) - is deleted later
    defaultOptions.tooltipOpts = defaultOptions.tooltip;

    // object
    var FlotTooltip = function (plot) {
        // variables
        this.tipPosition = {x: 0, y: 0***REMOVED***;

        this.init(plot);
    ***REMOVED***;

    // main plugin function
    FlotTooltip.prototype.init = function (plot) {
        var that = this;

        // detect other flot plugins
        var plotPluginsLength = $.plot.plugins.length;
        this.plotPlugins = [];

        if (plotPluginsLength) {
            for (var p = 0; p < plotPluginsLength; p++) {
                this.plotPlugins.push($.plot.plugins[p].name);
            ***REMOVED***
        ***REMOVED***

        plot.hooks.bindEvents.push(function (plot, eventHolder) {

            // get plot options
            that.plotOptions = plot.getOptions();

            // for legacy (<0.8.5) implementations
            if (typeof(that.plotOptions.tooltip) === 'boolean') {
                that.plotOptions.tooltipOpts.show = that.plotOptions.tooltip;
                that.plotOptions.tooltip = that.plotOptions.tooltipOpts;
                delete that.plotOptions.tooltipOpts;
            ***REMOVED***

            // if not enabled return
            if (that.plotOptions.tooltip.show === false || typeof that.plotOptions.tooltip.show === 'undefined') return;

            // shortcut to access tooltip options
            that.tooltipOptions = that.plotOptions.tooltip;

            if (that.tooltipOptions.$compat) {
                that.wfunc = 'width';
                that.hfunc = 'height';
            ***REMOVED*** else {
                that.wfunc = 'innerWidth';
                that.hfunc = 'innerHeight';
            ***REMOVED***

            // create tooltip DOM element
            var $tip = that.getDomElement();

            // bind event
            $( plot.getPlaceholder() ).bind("plothover", plothover);

            $(eventHolder).bind('mousemove', mouseMove);
        ***REMOVED***);

        plot.hooks.shutdown.push(function (plot, eventHolder){
            $(plot.getPlaceholder()).unbind("plothover", plothover);
            $(eventHolder).unbind("mousemove", mouseMove);
        ***REMOVED***);

        function mouseMove(e){
            var pos = {***REMOVED***;
            pos.x = e.pageX;
            pos.y = e.pageY;
            plot.setTooltipPosition(pos);
        ***REMOVED***

        function plothover(event, pos, item) {
            // Simple distance formula.
            var lineDistance = function (p1x, p1y, p2x, p2y) {
                return Math.sqrt((p2x - p1x) * (p2x - p1x) + (p2y - p1y) * (p2y - p1y));
            ***REMOVED***;

            // Here is some voodoo magic for determining the distance to a line form a given point {x, y***REMOVED***.
            var dotLineLength = function (x, y, x0, y0, x1, y1, o) {
                if (o && !(o =
                    function (x, y, x0, y0, x1, y1) {
                        if (typeof x0 !== 'undefined') return { x: x0, y: y ***REMOVED***;
                        else if (typeof y0 !== 'undefined') return { x: x, y: y0 ***REMOVED***;

                        var left,
                            tg = -1 / ((y1 - y0) / (x1 - x0));

                        return {
                            x: left = (x1 * (x * tg - y + y0) + x0 * (x * -tg + y - y1)) / (tg * (x1 - x0) + y0 - y1),
                            y: tg * left - tg * x + y
                        ***REMOVED***;
                    ***REMOVED*** (x, y, x0, y0, x1, y1),
                    o.x >= Math.min(x0, x1) && o.x <= Math.max(x0, x1) && o.y >= Math.min(y0, y1) && o.y <= Math.max(y0, y1))
                ) {
                    var l1 = lineDistance(x, y, x0, y0), l2 = lineDistance(x, y, x1, y1);
                    return l1 > l2 ? l2 : l1;
                ***REMOVED*** else {
                    var a = y0 - y1, b = x1 - x0, c = x0 * y1 - y0 * x1;
                    return Math.abs(a * x + b * y + c) / Math.sqrt(a * a + b * b);
                ***REMOVED***
            ***REMOVED***;

            if (item) {
                plot.showTooltip(item, pos);
            ***REMOVED*** else if (that.plotOptions.series.lines.show && that.tooltipOptions.lines === true) {
                var maxDistance = that.plotOptions.grid.mouseActiveRadius;

                var closestTrace = {
                    distance: maxDistance + 1
                ***REMOVED***;

                $.each(plot.getData(), function (i, series) {
                    var xBeforeIndex = 0,
                        xAfterIndex = -1;

                    // Our search here assumes our data is sorted via the x-axis.
                    // TODO: Improve efficiency somehow - search smaller sets of data.
                    for (var j = 1; j < series.data.length; j++) {
                        if (series.data[j - 1][0] <= pos.x && series.data[j][0] >= pos.x) {
                            xBeforeIndex = j - 1;
                            xAfterIndex = j;
                        ***REMOVED***
                    ***REMOVED***

                    if (xAfterIndex === -1) {
                        plot.hideTooltip();
                        return;
                    ***REMOVED***

                    var pointPrev = { x: series.data[xBeforeIndex][0], y: series.data[xBeforeIndex][1] ***REMOVED***,
                        pointNext = { x: series.data[xAfterIndex][0], y: series.data[xAfterIndex][1] ***REMOVED***;

                    var distToLine = dotLineLength(series.xaxis.p2c(pos.x), series.yaxis.p2c(pos.y), series.xaxis.p2c(pointPrev.x),
                        series.yaxis.p2c(pointPrev.y), series.xaxis.p2c(pointNext.x), series.yaxis.p2c(pointNext.y), false);

                    if (distToLine < closestTrace.distance) {

                        var closestIndex = lineDistance(pointPrev.x, pointPrev.y, pos.x, pos.y) <
                            lineDistance(pos.x, pos.y, pointNext.x, pointNext.y) ? xBeforeIndex : xAfterIndex;

                        var pointSize = series.datapoints.pointsize;

                        // Calculate the point on the line vertically closest to our cursor.
                        var pointOnLine = [
                            pos.x,
                            pointPrev.y + ((pointNext.y - pointPrev.y) * ((pos.x - pointPrev.x) / (pointNext.x - pointPrev.x)))
                        ];

                        var item = {
                            datapoint: pointOnLine,
                            dataIndex: closestIndex,
                            series: series,
                            seriesIndex: i
                        ***REMOVED***;

                        closestTrace = {
                            distance: distToLine,
                            item: item
                        ***REMOVED***;
                    ***REMOVED***
                ***REMOVED***);

                if (closestTrace.distance < maxDistance + 1)
                    plot.showTooltip(closestTrace.item, pos);
                else
                    plot.hideTooltip();
            ***REMOVED*** else {
                plot.hideTooltip();
            ***REMOVED***
        ***REMOVED***

        // Quick little function for setting the tooltip position.
        plot.setTooltipPosition = function (pos) {
            var $tip = that.getDomElement();

            var totalTipWidth = $tip.outerWidth() + that.tooltipOptions.shifts.x;
            var totalTipHeight = $tip.outerHeight() + that.tooltipOptions.shifts.y;
            if ((pos.x - $(window).scrollLeft()) > ($(window)[that.wfunc]() - totalTipWidth)) {
                pos.x -= totalTipWidth;
            ***REMOVED***
            if ((pos.y - $(window).scrollTop()) > ($(window)[that.hfunc]() - totalTipHeight)) {
                pos.y -= totalTipHeight;
            ***REMOVED***
            that.tipPosition.x = pos.x;
            that.tipPosition.y = pos.y;
        ***REMOVED***;

        // Quick little function for showing the tooltip.
        plot.showTooltip = function (target, position) {
            var $tip = that.getDomElement();

            // convert tooltip content template to real tipText
            var tipText = that.stringFormat(that.tooltipOptions.content, target);
            if (tipText === '')
            	return;

            $tip.html(tipText);
            plot.setTooltipPosition({ x: position.pageX, y: position.pageY ***REMOVED***);
            $tip.css({
                left: that.tipPosition.x + that.tooltipOptions.shifts.x,
                top: that.tipPosition.y + that.tooltipOptions.shifts.y
            ***REMOVED***).show();

            // run callback
            if (typeof that.tooltipOptions.onHover === 'function') {
                that.tooltipOptions.onHover(target, $tip);
            ***REMOVED***
        ***REMOVED***;

        // Quick little function for hiding the tooltip.
        plot.hideTooltip = function () {
            that.getDomElement().hide().html('');
        ***REMOVED***;
    ***REMOVED***;

    /**
     * get or create tooltip DOM element
     * @return jQuery object
     */
    FlotTooltip.prototype.getDomElement = function () {
        var $tip = $('.' + this.tooltipOptions.cssClass);

        if( $tip.length === 0 ){
            $tip = $('<div />').addClass(this.tooltipOptions.cssClass);
            $tip.appendTo('body').hide().css({position: 'absolute'***REMOVED***);

            if(this.tooltipOptions.defaultTheme) {
                $tip.css({
                    'background': '#fff',
                    'z-index': '1040',
                    'padding': '0.4em 0.6em',
                    'border-radius': '0.5em',
                    'font-size': '0.8em',
                    'border': '1px solid #111',
                    'display': 'none',
                    'white-space': 'nowrap'
                ***REMOVED***);
            ***REMOVED***
        ***REMOVED***

        return $tip;
    ***REMOVED***;

    /**
     * core function, create tooltip content
     * @param  {string***REMOVED*** content - template with tooltip content
     * @param  {object***REMOVED*** item - Flot item
     * @return {string***REMOVED*** real tooltip content for current item
     */
    FlotTooltip.prototype.stringFormat = function (content, item) {

        var percentPattern = /%p\.{0,1***REMOVED***(\d{0,***REMOVED***)/;
        var seriesPattern = /%s/;
        var colorPattern = /%c/;
        var xLabelPattern = /%lx/; // requires flot-axislabels plugin https://github.com/markrcote/flot-axislabels, will be ignored if plugin isn't loaded
        var yLabelPattern = /%ly/; // requires flot-axislabels plugin https://github.com/markrcote/flot-axislabels, will be ignored if plugin isn't loaded
        var xPattern = /%x\.{0,1***REMOVED***(\d{0,***REMOVED***)/;
        var yPattern = /%y\.{0,1***REMOVED***(\d{0,***REMOVED***)/;
        var xPatternWithoutPrecision = "%x";
        var yPatternWithoutPrecision = "%y";
        var customTextPattern = "%ct";

        var x, y, customText, p;

        // for threshold plugin we need to read data from different place
        if (typeof item.series.threshold !== "undefined") {
            x = item.datapoint[0];
            y = item.datapoint[1];
            customText = item.datapoint[2];
        ***REMOVED*** else if (typeof item.series.lines !== "undefined" && item.series.lines.steps) {
            x = item.series.datapoints.points[item.dataIndex * 2];
            y = item.series.datapoints.points[item.dataIndex * 2 + 1];
            // TODO: where to find custom text in this variant?
            customText = "";
        ***REMOVED*** else {
            x = item.series.data[item.dataIndex][0];
            y = item.series.data[item.dataIndex][1];
            customText = item.series.data[item.dataIndex][2];
        ***REMOVED***

        // I think this is only in case of threshold plugin
        if (item.series.label === null && item.series.originSeries) {
            item.series.label = item.series.originSeries.label;
        ***REMOVED***

        // if it is a function callback get the content string
        if (typeof(content) === 'function') {
            content = content(item.series.label, x, y, item);
        ***REMOVED***

        // the case where the passed content is equal to false
        if (typeof(content) === 'boolean' && !content) {
            return '';
        ***REMOVED***

        // percent match for pie charts and stacked percent
        if (typeof (item.series.percent) !== 'undefined') {
            p = item.series.percent;
        ***REMOVED*** else if (typeof (item.series.percents) !== 'undefined') {
            p = item.series.percents[item.dataIndex];
        ***REMOVED***        
        if (typeof p === 'number') {
            content = this.adjustValPrecision(percentPattern, content, p);
        ***REMOVED***

        // series match
        if (typeof(item.series.label) !== 'undefined') {
            content = content.replace(seriesPattern, item.series.label);
        ***REMOVED*** else {
            //remove %s if label is undefined
            content = content.replace(seriesPattern, "");
        ***REMOVED***
        
        // color match
        if (typeof(item.series.color) !== 'undefined') {
            content = content.replace(colorPattern, item.series.color);
        ***REMOVED*** else {
            //remove %s if color is undefined
            content = content.replace(colorPattern, "");
        ***REMOVED***

        // x axis label match
        if (this.hasAxisLabel('xaxis', item)) {
            content = content.replace(xLabelPattern, item.series.xaxis.options.axisLabel);
        ***REMOVED*** else {
            //remove %lx if axis label is undefined or axislabels plugin not present
            content = content.replace(xLabelPattern, "");
        ***REMOVED***

        // y axis label match
        if (this.hasAxisLabel('yaxis', item)) {
            content = content.replace(yLabelPattern, item.series.yaxis.options.axisLabel);
        ***REMOVED*** else {
            //remove %ly if axis label is undefined or axislabels plugin not present
            content = content.replace(yLabelPattern, "");
        ***REMOVED***

        // time mode axes with custom dateFormat
        if (this.isTimeMode('xaxis', item) && this.isXDateFormat(item)) {
            content = content.replace(xPattern, this.timestampToDate(x, this.tooltipOptions.xDateFormat, item.series.xaxis.options));
        ***REMOVED***
        if (this.isTimeMode('yaxis', item) && this.isYDateFormat(item)) {
            content = content.replace(yPattern, this.timestampToDate(y, this.tooltipOptions.yDateFormat, item.series.yaxis.options));
        ***REMOVED***

        // set precision if defined
        if (typeof x === 'number') {
            content = this.adjustValPrecision(xPattern, content, x);
        ***REMOVED***
        if (typeof y === 'number') {
            content = this.adjustValPrecision(yPattern, content, y);
        ***REMOVED***

        // change x from number to given label, if given
        if (typeof item.series.xaxis.ticks !== 'undefined') {

            var ticks;
            if (this.hasRotatedXAxisTicks(item)) {
                // xaxis.ticks will be an empty array if tickRotor is being used, but the values are available in rotatedTicks
                ticks = 'rotatedTicks';
            ***REMOVED*** else {
                ticks = 'ticks';
            ***REMOVED***

            // see https://github.com/krzysu/flot.tooltip/issues/65
            var tickIndex = item.dataIndex + item.seriesIndex;

            for (var index in item.series.xaxis[ticks]) {
                if (item.series.xaxis[ticks].hasOwnProperty(tickIndex) && !this.isTimeMode('xaxis', item)) {
                    var valueX = (this.isCategoriesMode('xaxis', item)) ? item.series.xaxis[ticks][tickIndex].label : item.series.xaxis[ticks][tickIndex].v;
                    if (valueX === x) {
                        content = content.replace(xPattern, item.series.xaxis[ticks][tickIndex].label);
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***

        // change y from number to given label, if given
        if (typeof item.series.yaxis.ticks !== 'undefined') {
            for (var index in item.series.yaxis.ticks) {
                if (item.series.yaxis.ticks.hasOwnProperty(index)) {
                    var valueY = (this.isCategoriesMode('yaxis', item)) ? item.series.yaxis.ticks[index].label : item.series.yaxis.ticks[index].v;
                    if (valueY === y) {
                        content = content.replace(yPattern, item.series.yaxis.ticks[index].label);
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***

        // if no value customization, use tickFormatter by default
        if (typeof item.series.xaxis.tickFormatter !== 'undefined') {
            //escape dollar
            content = content.replace(xPatternWithoutPrecision, item.series.xaxis.tickFormatter(x, item.series.xaxis).replace(/\$/g, '$$'));
        ***REMOVED***
        if (typeof item.series.yaxis.tickFormatter !== 'undefined') {
            //escape dollar
            content = content.replace(yPatternWithoutPrecision, item.series.yaxis.tickFormatter(y, item.series.yaxis).replace(/\$/g, '$$'));
        ***REMOVED***

        if (customText)
            content = content.replace(customTextPattern, customText);

        return content;
    ***REMOVED***;

    // helpers just for readability
    FlotTooltip.prototype.isTimeMode = function (axisName, item) {
        return (typeof item.series[axisName].options.mode !== 'undefined' && item.series[axisName].options.mode === 'time');
    ***REMOVED***;

    FlotTooltip.prototype.isXDateFormat = function (item) {
        return (typeof this.tooltipOptions.xDateFormat !== 'undefined' && this.tooltipOptions.xDateFormat !== null);
    ***REMOVED***;

    FlotTooltip.prototype.isYDateFormat = function (item) {
        return (typeof this.tooltipOptions.yDateFormat !== 'undefined' && this.tooltipOptions.yDateFormat !== null);
    ***REMOVED***;

    FlotTooltip.prototype.isCategoriesMode = function (axisName, item) {
        return (typeof item.series[axisName].options.mode !== 'undefined' && item.series[axisName].options.mode === 'categories');
    ***REMOVED***;

    //
    FlotTooltip.prototype.timestampToDate = function (tmst, dateFormat, options) {
        var theDate = $.plot.dateGenerator(tmst, options);
        return $.plot.formatDate(theDate, dateFormat, this.tooltipOptions.monthNames, this.tooltipOptions.dayNames);
    ***REMOVED***;

    //
    FlotTooltip.prototype.adjustValPrecision = function (pattern, content, value) {

        var precision;
        var matchResult = content.match(pattern);
        if( matchResult !== null ) {
            if(RegExp.$1 !== '') {
                precision = RegExp.$1;
                value = value.toFixed(precision);

                // only replace content if precision exists, in other case use thickformater
                content = content.replace(pattern, value);
            ***REMOVED***
        ***REMOVED***
        return content;
    ***REMOVED***;

    // other plugins detection below

    // check if flot-axislabels plugin (https://github.com/markrcote/flot-axislabels) is used and that an axis label is given
    FlotTooltip.prototype.hasAxisLabel = function (axisName, item) {
        return ($.inArray(this.plotPlugins, 'axisLabels') !== -1 && typeof item.series[axisName].options.axisLabel !== 'undefined' && item.series[axisName].options.axisLabel.length > 0);
    ***REMOVED***;

    // check whether flot-tickRotor, a plugin which allows rotation of X-axis ticks, is being used
    FlotTooltip.prototype.hasRotatedXAxisTicks = function (item) {
        return ($.inArray(this.plotPlugins, 'tickRotor') !== -1 && typeof item.series.xaxis.rotatedTicks !== 'undefined');
    ***REMOVED***;

    //
    var init = function (plot) {
      new FlotTooltip(plot);
    ***REMOVED***;

    // define Flot plugin
    $.plot.plugins.push({
        init: init,
        options: defaultOptions,
        name: 'tooltip',
        version: '0.8.5'
    ***REMOVED***);

***REMOVED***)(jQuery);
