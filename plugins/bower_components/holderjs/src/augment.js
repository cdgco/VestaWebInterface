(function (global, factory) {
	global.augment = factory();
***REMOVED***(this, function () {
    "use strict";

    var Factory = function () {***REMOVED***;
    var slice = Array.prototype.slice;

    var augment = function (base, body) {
        var uber = Factory.prototype = typeof base === "function" ? base.prototype : base;
        var prototype = new Factory(), properties = body.apply(prototype, slice.call(arguments, 2).concat(uber));
        if (typeof properties === "object") for (var key in properties) prototype[key] = properties[key];
        if (!prototype.hasOwnProperty("constructor")) return prototype;
        var constructor = prototype.constructor;
        constructor.prototype = prototype;
        return constructor;
    ***REMOVED***;

    augment.defclass = function (prototype) {
        var constructor = prototype.constructor;
        constructor.prototype = prototype;
        return constructor;
    ***REMOVED***;

    augment.extend = function (base, body) {
        return augment(base, function (uber) {
            this.uber = uber;
            return body;
        ***REMOVED***);
    ***REMOVED***;

    return augment;
***REMOVED***));
