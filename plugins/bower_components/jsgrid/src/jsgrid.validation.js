(function(jsGrid, $, undefined) {

    function Validation(config) {
        this._init(config);
    ***REMOVED***

    Validation.prototype = {

        _init: function(config) {
            $.extend(true, this, config);
        ***REMOVED***,

        validate: function(args) {
            var errors = [];

            $.each(this._normalizeRules(args.rules), function(_, rule) {
                if(rule.validator(args.value, args.item, rule.param))
                    return;

                var errorMessage = $.isFunction(rule.message) ? rule.message(args.value, args.item) : rule.message;
                errors.push(errorMessage);
            ***REMOVED***);

            return errors;
        ***REMOVED***,

        _normalizeRules: function(rules) {
            if(!$.isArray(rules))
                rules = [rules];

            return $.map(rules, $.proxy(function(rule) {
                return this._normalizeRule(rule);
            ***REMOVED***, this));
        ***REMOVED***,

        _normalizeRule: function(rule) {
            if(typeof rule === "string")
                rule = { validator: rule ***REMOVED***;

            if($.isFunction(rule))
                rule = { validator: rule ***REMOVED***;

            if($.isPlainObject(rule))
                rule = $.extend({***REMOVED***, rule);
            else
                throw Error("wrong validation config specified");

            if($.isFunction(rule.validator))
                return rule;

            return this._applyNamedValidator(rule, rule.validator);
        ***REMOVED***,

        _applyNamedValidator: function(rule, validatorName) {
            delete rule.validator;

            var validator = validators[validatorName];
            if(!validator)
                throw Error("unknown validator \"" + validatorName + "\"");

            if($.isFunction(validator)) {
                validator = { validator: validator ***REMOVED***;
            ***REMOVED***

            return $.extend({***REMOVED***, validator, rule);
        ***REMOVED***
    ***REMOVED***;

    jsGrid.Validation = Validation;


    var validators = {
        required: {
            message: "Field is required",
            validator: function(value) {
                return value !== undefined && value !== null && value !== "";
            ***REMOVED***
        ***REMOVED***,

        rangeLength: {
            message: "Field value length is out of the defined range",
            validator: function(value, _, param) {
                return value.length >= param[0] && value.length <= param[1];
            ***REMOVED***
        ***REMOVED***,

        minLength: {
            message: "Field value is too long",
            validator: function(value, _, param) {
                return value.length >= param;
            ***REMOVED***
        ***REMOVED***,

        maxLength: {
            message: "Field value is too short",
            validator: function(value, _, param) {
                return value.length <= param;
            ***REMOVED***
        ***REMOVED***,

        pattern: {
            message: "Field value is not matching the defined pattern",
            validator: function(value, _, param) {
                if(typeof param === "string") {
                    param = new RegExp("^(?:" + param + ")$");
                ***REMOVED***
                return param.test(value);
            ***REMOVED***
        ***REMOVED***,

        range: {
            message: "Field value is out of the defined range",
            validator: function(value, _, param) {
                return value >= param[0] && value <= param[1];
            ***REMOVED***
        ***REMOVED***,

        min: {
            message: "Field value is too large",
            validator: function(value, _, param) {
                return value >= param;
            ***REMOVED***
        ***REMOVED***,

        max: {
            message: "Field value is too small",
            validator: function(value, _, param) {
                return value <= param;
            ***REMOVED***
        ***REMOVED***
    ***REMOVED***;

    jsGrid.validators = validators;

***REMOVED***(jsGrid, jQuery));
