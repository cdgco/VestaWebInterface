$.extend(Wizard.prototype, {
    Constructor: Wizard,
    initialize: function(){
        this.steps = [];
        var self = this;

        this.$steps.each(function(index){
            self.steps.push(new Step(this, self, index));
        ***REMOVED***);

        this._current = 0;
        this.transitioning = null;

        $.each(this.steps, function(i, step){
            step.setup();
        ***REMOVED***);

        this.setup();

        this.$element.on('click', this.options.step, function(e){
            var index = $(this).data('wizard-index');

            if(!self.get(index).is('disabled')){
                self.goTo(index);
            ***REMOVED***

            e.preventDefault();
            e.stopPropagation();
        ***REMOVED***);

        if(this.options.keyboard){
            $(document).on('keyup', $.proxy(this.keydown, this));
        ***REMOVED***

        this.trigger('init');
    ***REMOVED***,

    setup: function(){
        this.$buttons = $(this.options.templates.buttons.call(this));

        this.updateButtons();

        var buttonsAppendTo = this.options.buttonsAppendTo;
        var $to;
        if(buttonsAppendTo ==='this'){
            $to = this.$element;
        ***REMOVED*** else if($.isFunction(buttonsAppendTo)){
            $to = buttonsAppendTo.call(this);
        ***REMOVED*** else {
            $to = this.$element.find(buttonsAppendTo);
        ***REMOVED***
        this.$buttons = this.$buttons.appendTo($to);
    ***REMOVED***,

    updateButtons: function(){
        var classes = this.options.classes.button;
        var $back = this.$buttons.find('[data-wizard="back"]');
        var $next = this.$buttons.find('[data-wizard="next"]');
        var $finish = this.$buttons.find('[data-wizard="finish"]');

        if(this._current === 0){
            $back.addClass(classes.disabled);
        ***REMOVED*** else {
            $back.removeClass(classes.disabled);
        ***REMOVED***

        if(this._current === this.lastIndex()) {
            $next.addClass(classes.hide);
            $finish.removeClass(classes.hide);
        ***REMOVED*** else {
            $next.removeClass(classes.hide);
            $finish.addClass(classes.hide);
        ***REMOVED***
    ***REMOVED***,

    updateSteps: function(){
        var self = this;

        $.each(this.steps, function(i, step){
            
            if(i > self._current){
                step.leave('error');
                step.leave('active');
                step.leave('done');

                if(!self.options.enableWhenVisited ){
                    step.enter('disabled');
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***);
    ***REMOVED***,

    keydown: function(e) {
        if (/input|textarea/i.test(e.target.tagName)) return;
        switch (e.which) {
            case 37: this.back(); break;
            case 39: this.next(); break;
            default: return;
        ***REMOVED***

        e.preventDefault();
    ***REMOVED***,

    trigger: function(eventType){
        var method_arguments = Array.prototype.slice.call(arguments, 1);
        var data = [this].concat(method_arguments);

        this.$element.trigger('wizard::' + eventType, data);

        // callback
        eventType = eventType.replace(/\b\w+\b/g, function(word) {
            return word.substring(0, 1).toUpperCase() + word.substring(1);
        ***REMOVED***);

        var onFunction = 'on' + eventType;
        if (typeof this.options[onFunction] === 'function') {
            this.options[onFunction].apply(this, method_arguments);
        ***REMOVED***
    ***REMOVED***,

    get: function(index) {
        if(typeof index === 'string' && index.substring(0, 1) === '#'){
            var id = index.substring(1);
            for(var i in this.steps){
                if(this.steps[i].$pane.attr('id') === id){
                    return this.steps[i];
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***

        if(index < this.length() && this.steps[index]){
            return this.steps[index];
        ***REMOVED***

        return null;
    ***REMOVED***,

    goTo: function(index, callback) {
        if(index === this._current || this.transitioning === true){
            return false;
        ***REMOVED***

        var current = this.current();
        var to = this.get(index);

        if(index > this._current){
            if(!current.validate()){
                current.leave('done');
                current.enter('error');

                return -1;
            ***REMOVED*** else {
                current.leave('error');

                if(index > this._current) {
                    current.enter('done');
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***     

        var self = this;
        var process = function (){
            self.trigger('beforeChange', current, to);
            self.transitioning = true;
            
            current.hide();
            to.show(function(){
                self._current = index;
                self.transitioning = false;
                this.leave('disabled');

                self.updateButtons();
                self.updateSteps();

                if(self.options.autoFocus){
                    var $input = this.$pane.find(':input');
                    if($input.length > 0) {
                        $input.eq(0).focus();
                    ***REMOVED*** else {
                        this.$pane.focus();
                    ***REMOVED***
                ***REMOVED***

                if($.isFunction(callback)){
                    callback.call(self);
                ***REMOVED***

                self.trigger('afterChange', current, to);
            ***REMOVED***);
        ***REMOVED***;

        if(to.loader){
            to.load(function(){
                process();
            ***REMOVED***);
        ***REMOVED*** else {
            process();
        ***REMOVED***

        return true;
    ***REMOVED***,

    length: function() {
        return this.steps.length;
    ***REMOVED***,

    current: function() {
        return this.get(this._current);
    ***REMOVED***,

    currentIndex: function() {
        return this._current;
    ***REMOVED***,

    lastIndex: function(){
        return this.length() - 1;
    ***REMOVED***,

    next: function() {
        if(this._current < this.lastIndex()){
            var from = this._current, to = this._current + 1;

            this.goTo(to, function(){
                this.trigger('next', this.get(from), this.get(to));
            ***REMOVED***);
        ***REMOVED***

        return false;
    ***REMOVED***,

    back: function() {
        if(this._current > 0) {
            var from = this._current, to = this._current - 1;

            this.goTo(to, function(){
                this.trigger('back', this.get(from), this.get(to));
            ***REMOVED***);
        ***REMOVED***

        return false;
    ***REMOVED***,

    first: function() {
        return this.goTo(0);
    ***REMOVED***,

    finish: function() {
        if(this._current === this.lastIndex()){
            var current = this.current();
            if(current.validate()){
                this.trigger('finish');
                current.leave('error');
                current.enter('done');
            ***REMOVED*** else {
                current.enter('error');
            ***REMOVED***
        ***REMOVED***
    ***REMOVED***,

    reset: function() {
        this._current = 0;

        $.each(this.steps, function(i, step){
            step.reset();
        ***REMOVED***);

        this.trigger('reset');
    ***REMOVED***
***REMOVED***);
