// Real Time chart
        

        var data = [],
            totalPoints = 300;

        function getRandomData() {

            if (data.length > 0)
                data = data.slice(1);

            // Do a random walk

            while (data.length < totalPoints) {

                var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;

                if (y < 0) {
                    y = 0;
                ***REMOVED*** else if (y > 100) {
                    y = 100;
                ***REMOVED***

                data.push(y);
            ***REMOVED***

            // Zip the generated y values with the x values

            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]])
            ***REMOVED***

            return res;
        ***REMOVED***

        // Set up the control widget

        var updateInterval = 30;
        $("#updateInterval").val(updateInterval).change(function () {
            var v = $(this).val();
            if (v && !isNaN(+v)) {
                updateInterval = +v;
                if (updateInterval < 1) {
                    updateInterval = 1;
                ***REMOVED*** else if (updateInterval > 3000) {
                    updateInterval = 3000;
                ***REMOVED***
                $(this).val("" + updateInterval);
            ***REMOVED***
        ***REMOVED***);

        var plot = $.plot("#placeholder", [ getRandomData() ], {
            series: {
                shadowSize: 0   // Drawing is faster without shadows
            ***REMOVED***,
            yaxis: {
                min: 0,
                max: 100
            ***REMOVED***,
            xaxis: {
                show: false
            ***REMOVED***,
            colors: ["#fb9678"],
            grid: {
                color: "#AFAFAF",
                hoverable: true,
                borderWidth: 0,
                backgroundColor: '#FFF'
            ***REMOVED***,
            tooltip: true,
            tooltipOpts: {
                content: "Y: %y",
                defaultTheme: false
            ***REMOVED***
        

        ***REMOVED***);

        function update() {

            plot.setData([getRandomData()]);

            // Since the axes don't change, we don't need to call plot.setupGrid()

            plot.draw();
            setTimeout(update, updateInterval);
        ***REMOVED***

        update();

  //Flot Line Chart
$(document).ready(function() {
    console.log("document ready");
    var offset = 0;
    plot();

    function plot() {
        var sin = [],
            cos = [];
        for (var i = 0; i < 12; i += 0.2) {
            sin.push([i, Math.sin(i + offset)]);
            cos.push([i, Math.cos(i + offset)]);
        ***REMOVED***

        var options = {
            series: {
                lines: {
                    show: true
                ***REMOVED***,
                points: {
                    show: true
                ***REMOVED***
            ***REMOVED***,

            grid: {
                hoverable: true //IMPORTANT! this is needed for tooltip to work
            ***REMOVED***,
            yaxis: {
                min: -1.2,
                max: 1.2
            ***REMOVED***,
              colors: ["#fb9678", "#01c0c8"],   
            grid: {
                color: "#AFAFAF",
                hoverable: true,
                borderWidth: 0,
                backgroundColor: '#FFF'
            ***REMOVED***,
            tooltip: true,
            tooltipOpts: {
                content: "'%s' of %x.1 is %y.4",
                shifts: {
                    x: -60,
                    y: 25
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***;

        var plotObj = $.plot($("#flot-line-chart"), [{
                data: sin,
                label: "sin(x)",
               
            ***REMOVED***, {
                data: cos,
                label: "cos(x)"
            ***REMOVED***],
            options);
    ***REMOVED***
***REMOVED***);      
//Flot Pie Chart
$(function() {

    var data = [{
        label: "Series 0",
        data: 10,
        color: "#4f5467",
        
    ***REMOVED***, {
        label: "Series 1",
        data: 1,
        color: "#00c292",
    ***REMOVED***, {
        label: "Series 2",
        data: 3,
        color:"#01c0c8",
    ***REMOVED***, {
        label: "Series 3",
        data: 1,
        color:"#fb9678",
    ***REMOVED***];

    var plotObj = $.plot($("#flot-pie-chart"), data, {
        series: {
            pie: {
                innerRadius: 0.5,
                show: true
            ***REMOVED***
        ***REMOVED***,
        grid: {
            hoverable: true
        ***REMOVED***,
        color: null,
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20,
                y: 0
            ***REMOVED***,
            defaultTheme: false
        ***REMOVED***
    ***REMOVED***);

***REMOVED***);
//Flot Moving Line Chart

$(function() {

    var container = $("#flot-line-chart-moving");

    // Determine how many data points to keep based on the placeholder's initial size;
    // this gives us a nice high-res plot while avoiding more than one point per pixel.

    var maximum = container.outerWidth() / 2 || 300;

    //

    var data = [];

    function getRandomData() {

        if (data.length) {
            data = data.slice(1);
        ***REMOVED***

        while (data.length < maximum) {
            var previous = data.length ? data[data.length - 1] : 50;
            var y = previous + Math.random() * 10 - 5;
            data.push(y < 0 ? 0 : y > 100 ? 100 : y);
        ***REMOVED***

        // zip the generated y values with the x values

        var res = [];
        for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]])
        ***REMOVED***

        return res;
    ***REMOVED***

    //

    series = [{
        data: getRandomData(),

        lines: {
            fill: true
        ***REMOVED***
    ***REMOVED***];

    //

    var plot = $.plot(container, series, {
        colors: ["#01c0c8"],
        grid: {
            borderWidth: 0,
            minBorderMargin: 20,
            labelMargin: 10,
            backgroundColor: {
                colors: ["#fff", "#fff"]
            ***REMOVED***,
            margin: {
                top: 8,
                bottom: 20,
                left: 20
            ***REMOVED***,

            markings: function(axes) {
                var markings = [];
                var xaxis = axes.xaxis;
                for (var x = Math.floor(xaxis.min); x < xaxis.max; x += xaxis.tickSize * 1) {
                    markings.push({
                        xaxis: {
                            from: x,
                            to: x + xaxis.tickSize
                        ***REMOVED***,
                        color: "#fff"
                    ***REMOVED***);
                ***REMOVED***
                return markings;
            ***REMOVED***
        ***REMOVED***,
        xaxis: {
            tickFormatter: function() {
                return "";
            ***REMOVED***
        ***REMOVED***,
        yaxis: {
            min: 0,
            max: 110
        ***REMOVED***,
        legend: {
            show: true
        ***REMOVED***
    ***REMOVED***);

    // Update the random dataset at 25FPS for a smoothly-animating chart

    setInterval(function updateRandom() {
        series[0].data = getRandomData();
        plot.setData(series);
        plot.draw();
    ***REMOVED***, 40);

***REMOVED***);

//Flot Bar Chart

$(function() {

    var barOptions = {
        series: {
            bars: {
                show: true,
                barWidth: 43200000
            ***REMOVED***
        ***REMOVED***,
        xaxis: {
            mode: "time",
            timeformat: "%m/%d",
            minTickSize: [2, "day"]
        ***REMOVED***,
        grid: {
            hoverable: true
        ***REMOVED***,
        legend: {
            show: false
        ***REMOVED***,
        grid: {
                color: "#AFAFAF",
                hoverable: true,
                borderWidth: 0,
                backgroundColor: '#FFF'
            ***REMOVED***,
        tooltip: true,
        tooltipOpts: {
            content: "x: %x, y: %y"
        ***REMOVED***
    ***REMOVED***;
    var barData = {
        label: "bar",
        color: "#fb9678",
        data: [
            [1354521600000, 1000],
            [1355040000000, 2000],
            [1355223600000, 3000],
            [1355306400000, 4000],
            [1355487300000, 5000],
            [1355571900000, 6000]
        ]
    ***REMOVED***;
    $.plot($("#flot-bar-chart"), [barData], barOptions);

***REMOVED***);
// sales bar chart

    $(function() {
        //some data
        var d1 = [];
        for (var i = 0; i <= 10; i += 1)
            d1.push([i, parseInt(Math.random() * 60)]);

        var d2 = [];
        for (var i = 0; i <= 10; i += 1)
            d2.push([i, parseInt(Math.random() * 40)]);

        var d3 = [];
        for (var i = 0; i <= 10; i += 1)
            d3.push([i, parseInt(Math.random() * 25)]);

        var ds = new Array();

        ds.push({
            label : "Data One",
            data : d1,
            bars : {
                order : 1
            ***REMOVED***
        ***REMOVED***);
        ds.push({
            label : "Data Two",
            data : d2,
            bars : {
                order : 2
            ***REMOVED***
        ***REMOVED***);
        ds.push({
            label : "Data Three",
            data : d3,
            bars : {
                order : 3
            ***REMOVED***
        ***REMOVED***);

        var stack = 0,
            bars = true,
            lines = true,
            steps = true;

        var options = {
            bars : {
                show : true,
                barWidth : 0.2,
                fill : 1
            ***REMOVED***,
            grid : {
                show : true,
                aboveData : false,
                labelMargin : 5,
                axisMargin : 0,
                borderWidth : 1,
                minBorderMargin : 5,
                clickable : true,
                hoverable : true,
                autoHighlight : false,
                mouseActiveRadius : 20,
                borderColor : '#f5f5f5'
            ***REMOVED***,
            series : {
                stack : stack
            ***REMOVED***,
            legend : {
                position : "ne",
                margin : [0, 0],
                noColumns : 0,
                labelBoxBorderColor : null,
                labelFormatter : function(label, series) {
                    // just add some space to labes
                    return '' + label + '&nbsp;&nbsp;';
                ***REMOVED***,
                width : 30,
                height : 5
            ***REMOVED***,
            yaxis : {
                tickColor : '#f5f5f5',
                font : {
                    color : '#bdbdbd'
                ***REMOVED***
            ***REMOVED***,
            xaxis : {
                tickColor : '#f5f5f5',
                font : {
                    color : '#bdbdbd'
                ***REMOVED***
            ***REMOVED***,
            colors : ["#4F5467", "#01c0c8", "#fb9678"],
            tooltip : true, //activate tooltip
            tooltipOpts : {
                content : "%s : %y.0",
                shifts : {
                    x : -30,
                    y : -50
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***;

        $.plot($(".sales-bars-chart"), ds, options);
    ***REMOVED***);


