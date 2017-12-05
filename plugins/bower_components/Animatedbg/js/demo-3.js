(function() {

    var width, height, largeHeader, canvas, ctx, triangles, target, animateHeader = true;
    var colors = ['72,35,68', '43,81,102', '66,152,103', '250,178,67', '224,33,48'];

    // Main
    initHeader();
    addListeners();
    initAnimation();

    function initHeader() {
        width = window.innerWidth;
        height = window.innerHeight;
        target = {x: 0, y: height***REMOVED***;

        largeHeader = document.getElementById('large-header');
        largeHeader.style.height = height+'px';

        canvas = document.getElementById('demo-canvas');
        canvas.width = width;
        canvas.height = height;
        ctx = canvas.getContext('2d');

        // create particles
        triangles = [];
        for(var x = 0; x < 480; x++) {
            addTriangle(x*10);
        ***REMOVED***
    ***REMOVED***

    function addTriangle(delay) {
        setTimeout(function() {
            var t = new Triangle();
            triangles.push(t);
            tweenTriangle(t);
        ***REMOVED***, delay);
    ***REMOVED***

    function initAnimation() {
        animate();
    ***REMOVED***

    function tweenTriangle(tri) {
        var t = Math.random()*(2*Math.PI);
        var x = (200+Math.random()*100)*Math.cos(t) + width*0.5;
        var y = (200+Math.random()*100)*Math.sin(t) + height*0.5-20;
        var time = 4+3*Math.random();

        TweenLite.to(tri.pos, time, {x: x,
            y: y, ease:Circ.easeOut,
            onComplete: function() {
                tri.init();
                tweenTriangle(tri);
        ***REMOVED******REMOVED***);
    ***REMOVED***

    // Event handling
    function addListeners() {
        window.addEventListener('scroll', scrollCheck);
        window.addEventListener('resize', resize);
    ***REMOVED***

    function scrollCheck() {
        if(document.body.scrollTop > height) animateHeader = false;
        else animateHeader = true;
    ***REMOVED***

    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        largeHeader.style.height = height+'px';
        canvas.width = width;
        canvas.height = height;
    ***REMOVED***

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,width,height);
            for(var i in triangles) {
                triangles[i].draw();
            ***REMOVED***
        ***REMOVED***
        requestAnimationFrame(animate);
    ***REMOVED***

    // Canvas manipulation
    function Triangle() {
        var _this = this;

        // constructor
        (function() {
            _this.coords = [{***REMOVED***,{***REMOVED***,{***REMOVED***];
            _this.pos = {***REMOVED***;
            init();
        ***REMOVED***)();

        function init() {
            _this.pos.x = width*0.5;
            _this.pos.y = height*0.5-20;
            _this.coords[0].x = -10+Math.random()*40;
            _this.coords[0].y = -10+Math.random()*40;
            _this.coords[1].x = -10+Math.random()*40;
            _this.coords[1].y = -10+Math.random()*40;
            _this.coords[2].x = -10+Math.random()*40;
            _this.coords[2].y = -10+Math.random()*40;
            _this.scale = 0.1+Math.random()*0.3;
            _this.color = colors[Math.floor(Math.random()*colors.length)];
            setTimeout(function() { _this.alpha = 0.8; ***REMOVED***, 10);
        ***REMOVED***

        this.draw = function() {
            if(_this.alpha >= 0.005) _this.alpha -= 0.005;
            else _this.alpha = 0;
            ctx.beginPath();
            ctx.moveTo(_this.coords[0].x+_this.pos.x, _this.coords[0].y+_this.pos.y);
            ctx.lineTo(_this.coords[1].x+_this.pos.x, _this.coords[1].y+_this.pos.y);
            ctx.lineTo(_this.coords[2].x+_this.pos.x, _this.coords[2].y+_this.pos.y);
            ctx.closePath();
            ctx.fillStyle = 'rgba('+_this.color+','+ _this.alpha+')';
            ctx.fill();
        ***REMOVED***;

        this.init = init;
    ***REMOVED***
    
***REMOVED***)();