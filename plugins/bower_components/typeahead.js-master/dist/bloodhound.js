/*!
 * typeahead.js 0.11.1
 * https://github.com/twitter/typeahead.js
 * Copyright 2013-2015 Twitter, Inc. and other contributors; Licensed MIT
 */

(function(root, factory) {
    if (typeof define === "function" && define.amd) {
        define("bloodhound", [ "jquery" ], function(a0) {
            return root["Bloodhound"] = factory(a0);
        ***REMOVED***);
    ***REMOVED*** else if (typeof exports === "object") {
        module.exports = factory(require("jquery"));
    ***REMOVED*** else {
        root["Bloodhound"] = factory(jQuery);
    ***REMOVED***
***REMOVED***)(this, function($) {
    var _ = function() {
        "use strict";
        return {
            isMsie: function() {
                return /(msie|trident)/i.test(navigator.userAgent) ? navigator.userAgent.match(/(msie |rv:)(\d+(.\d+)?)/i)[2] : false;
            ***REMOVED***,
            isBlankString: function(str) {
                return !str || /^\s*$/.test(str);
            ***REMOVED***,
            escapeRegExChars: function(str) {
                return str.replace(/[\-\[\]\/\{\***REMOVED***\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
            ***REMOVED***,
            isString: function(obj) {
                return typeof obj === "string";
            ***REMOVED***,
            isNumber: function(obj) {
                return typeof obj === "number";
            ***REMOVED***,
            isArray: $.isArray,
            isFunction: $.isFunction,
            isObject: $.isPlainObject,
            isUndefined: function(obj) {
                return typeof obj === "undefined";
            ***REMOVED***,
            isElement: function(obj) {
                return !!(obj && obj.nodeType === 1);
            ***REMOVED***,
            isJQuery: function(obj) {
                return obj instanceof $;
            ***REMOVED***,
            toStr: function toStr(s) {
                return _.isUndefined(s) || s === null ? "" : s + "";
            ***REMOVED***,
            bind: $.proxy,
            each: function(collection, cb) {
                $.each(collection, reverseArgs);
                function reverseArgs(index, value) {
                    return cb(value, index);
                ***REMOVED***
            ***REMOVED***,
            map: $.map,
            filter: $.grep,
            every: function(obj, test) {
                var result = true;
                if (!obj) {
                    return result;
                ***REMOVED***
                $.each(obj, function(key, val) {
                    if (!(result = test.call(null, val, key, obj))) {
                        return false;
                    ***REMOVED***
                ***REMOVED***);
                return !!result;
            ***REMOVED***,
            some: function(obj, test) {
                var result = false;
                if (!obj) {
                    return result;
                ***REMOVED***
                $.each(obj, function(key, val) {
                    if (result = test.call(null, val, key, obj)) {
                        return false;
                    ***REMOVED***
                ***REMOVED***);
                return !!result;
            ***REMOVED***,
            mixin: $.extend,
            identity: function(x) {
                return x;
            ***REMOVED***,
            clone: function(obj) {
                return $.extend(true, {***REMOVED***, obj);
            ***REMOVED***,
            getIdGenerator: function() {
                var counter = 0;
                return function() {
                    return counter++;
                ***REMOVED***;
            ***REMOVED***,
            templatify: function templatify(obj) {
                return $.isFunction(obj) ? obj : template;
                function template() {
                    return String(obj);
                ***REMOVED***
            ***REMOVED***,
            defer: function(fn) {
                setTimeout(fn, 0);
            ***REMOVED***,
            debounce: function(func, wait, immediate) {
                var timeout, result;
                return function() {
                    var context = this, args = arguments, later, callNow;
                    later = function() {
                        timeout = null;
                        if (!immediate) {
                            result = func.apply(context, args);
                        ***REMOVED***
                    ***REMOVED***;
                    callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) {
                        result = func.apply(context, args);
                    ***REMOVED***
                    return result;
                ***REMOVED***;
            ***REMOVED***,
            throttle: function(func, wait) {
                var context, args, timeout, result, previous, later;
                previous = 0;
                later = function() {
                    previous = new Date();
                    timeout = null;
                    result = func.apply(context, args);
                ***REMOVED***;
                return function() {
                    var now = new Date(), remaining = wait - (now - previous);
                    context = this;
                    args = arguments;
                    if (remaining <= 0) {
                        clearTimeout(timeout);
                        timeout = null;
                        previous = now;
                        result = func.apply(context, args);
                    ***REMOVED*** else if (!timeout) {
                        timeout = setTimeout(later, remaining);
                    ***REMOVED***
                    return result;
                ***REMOVED***;
            ***REMOVED***,
            stringify: function(val) {
                return _.isString(val) ? val : JSON.stringify(val);
            ***REMOVED***,
            noop: function() {***REMOVED***
        ***REMOVED***;
    ***REMOVED***();
    var VERSION = "0.11.1";
    var tokenizers = function() {
        "use strict";
        return {
            nonword: nonword,
            whitespace: whitespace,
            obj: {
                nonword: getObjTokenizer(nonword),
                whitespace: getObjTokenizer(whitespace)
            ***REMOVED***
        ***REMOVED***;
        function whitespace(str) {
            str = _.toStr(str);
            return str ? str.split(/\s+/) : [];
        ***REMOVED***
        function nonword(str) {
            str = _.toStr(str);
            return str ? str.split(/\W+/) : [];
        ***REMOVED***
        function getObjTokenizer(tokenizer) {
            return function setKey(keys) {
                keys = _.isArray(keys) ? keys : [].slice.call(arguments, 0);
                return function tokenize(o) {
                    var tokens = [];
                    _.each(keys, function(k) {
                        tokens = tokens.concat(tokenizer(_.toStr(o[k])));
                    ***REMOVED***);
                    return tokens;
                ***REMOVED***;
            ***REMOVED***;
        ***REMOVED***
    ***REMOVED***();
    var LruCache = function() {
        "use strict";
        function LruCache(maxSize) {
            this.maxSize = _.isNumber(maxSize) ? maxSize : 100;
            this.reset();
            if (this.maxSize <= 0) {
                this.set = this.get = $.noop;
            ***REMOVED***
        ***REMOVED***
        _.mixin(LruCache.prototype, {
            set: function set(key, val) {
                var tailItem = this.list.tail, node;
                if (this.size >= this.maxSize) {
                    this.list.remove(tailItem);
                    delete this.hash[tailItem.key];
                    this.size--;
                ***REMOVED***
                if (node = this.hash[key]) {
                    node.val = val;
                    this.list.moveToFront(node);
                ***REMOVED*** else {
                    node = new Node(key, val);
                    this.list.add(node);
                    this.hash[key] = node;
                    this.size++;
                ***REMOVED***
            ***REMOVED***,
            get: function get(key) {
                var node = this.hash[key];
                if (node) {
                    this.list.moveToFront(node);
                    return node.val;
                ***REMOVED***
            ***REMOVED***,
            reset: function reset() {
                this.size = 0;
                this.hash = {***REMOVED***;
                this.list = new List();
            ***REMOVED***
        ***REMOVED***);
        function List() {
            this.head = this.tail = null;
        ***REMOVED***
        _.mixin(List.prototype, {
            add: function add(node) {
                if (this.head) {
                    node.next = this.head;
                    this.head.prev = node;
                ***REMOVED***
                this.head = node;
                this.tail = this.tail || node;
            ***REMOVED***,
            remove: function remove(node) {
                node.prev ? node.prev.next = node.next : this.head = node.next;
                node.next ? node.next.prev = node.prev : this.tail = node.prev;
            ***REMOVED***,
            moveToFront: function(node) {
                this.remove(node);
                this.add(node);
            ***REMOVED***
        ***REMOVED***);
        function Node(key, val) {
            this.key = key;
            this.val = val;
            this.prev = this.next = null;
        ***REMOVED***
        return LruCache;
    ***REMOVED***();
    var PersistentStorage = function() {
        "use strict";
        var LOCAL_STORAGE;
        try {
            LOCAL_STORAGE = window.localStorage;
            LOCAL_STORAGE.setItem("~~~", "!");
            LOCAL_STORAGE.removeItem("~~~");
        ***REMOVED*** catch (err) {
            LOCAL_STORAGE = null;
        ***REMOVED***
        function PersistentStorage(namespace, override) {
            this.prefix = [ "__", namespace, "__" ].join("");
            this.ttlKey = "__ttl__";
            this.keyMatcher = new RegExp("^" + _.escapeRegExChars(this.prefix));
            this.ls = override || LOCAL_STORAGE;
            !this.ls && this._noop();
        ***REMOVED***
        _.mixin(PersistentStorage.prototype, {
            _prefix: function(key) {
                return this.prefix + key;
            ***REMOVED***,
            _ttlKey: function(key) {
                return this._prefix(key) + this.ttlKey;
            ***REMOVED***,
            _noop: function() {
                this.get = this.set = this.remove = this.clear = this.isExpired = _.noop;
            ***REMOVED***,
            _safeSet: function(key, val) {
                try {
                    this.ls.setItem(key, val);
                ***REMOVED*** catch (err) {
                    if (err.name === "QuotaExceededError") {
                        this.clear();
                        this._noop();
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
            get: function(key) {
                if (this.isExpired(key)) {
                    this.remove(key);
                ***REMOVED***
                return decode(this.ls.getItem(this._prefix(key)));
            ***REMOVED***,
            set: function(key, val, ttl) {
                if (_.isNumber(ttl)) {
                    this._safeSet(this._ttlKey(key), encode(now() + ttl));
                ***REMOVED*** else {
                    this.ls.removeItem(this._ttlKey(key));
                ***REMOVED***
                return this._safeSet(this._prefix(key), encode(val));
            ***REMOVED***,
            remove: function(key) {
                this.ls.removeItem(this._ttlKey(key));
                this.ls.removeItem(this._prefix(key));
                return this;
            ***REMOVED***,
            clear: function() {
                var i, keys = gatherMatchingKeys(this.keyMatcher);
                for (i = keys.length; i--; ) {
                    this.remove(keys[i]);
                ***REMOVED***
                return this;
            ***REMOVED***,
            isExpired: function(key) {
                var ttl = decode(this.ls.getItem(this._ttlKey(key)));
                return _.isNumber(ttl) && now() > ttl ? true : false;
            ***REMOVED***
        ***REMOVED***);
        return PersistentStorage;
        function now() {
            return new Date().getTime();
        ***REMOVED***
        function encode(val) {
            return JSON.stringify(_.isUndefined(val) ? null : val);
        ***REMOVED***
        function decode(val) {
            return $.parseJSON(val);
        ***REMOVED***
        function gatherMatchingKeys(keyMatcher) {
            var i, key, keys = [], len = LOCAL_STORAGE.length;
            for (i = 0; i < len; i++) {
                if ((key = LOCAL_STORAGE.key(i)).match(keyMatcher)) {
                    keys.push(key.replace(keyMatcher, ""));
                ***REMOVED***
            ***REMOVED***
            return keys;
        ***REMOVED***
    ***REMOVED***();
    var Transport = function() {
        "use strict";
        var pendingRequestsCount = 0, pendingRequests = {***REMOVED***, maxPendingRequests = 6, sharedCache = new LruCache(10);
        function Transport(o) {
            o = o || {***REMOVED***;
            this.cancelled = false;
            this.lastReq = null;
            this._send = o.transport;
            this._get = o.limiter ? o.limiter(this._get) : this._get;
            this._cache = o.cache === false ? new LruCache(0) : sharedCache;
        ***REMOVED***
        Transport.setMaxPendingRequests = function setMaxPendingRequests(num) {
            maxPendingRequests = num;
        ***REMOVED***;
        Transport.resetCache = function resetCache() {
            sharedCache.reset();
        ***REMOVED***;
        _.mixin(Transport.prototype, {
            _fingerprint: function fingerprint(o) {
                o = o || {***REMOVED***;
                return o.url + o.type + $.param(o.data || {***REMOVED***);
            ***REMOVED***,
            _get: function(o, cb) {
                var that = this, fingerprint, jqXhr;
                fingerprint = this._fingerprint(o);
                if (this.cancelled || fingerprint !== this.lastReq) {
                    return;
                ***REMOVED***
                if (jqXhr = pendingRequests[fingerprint]) {
                    jqXhr.done(done).fail(fail);
                ***REMOVED*** else if (pendingRequestsCount < maxPendingRequests) {
                    pendingRequestsCount++;
                    pendingRequests[fingerprint] = this._send(o).done(done).fail(fail).always(always);
                ***REMOVED*** else {
                    this.onDeckRequestArgs = [].slice.call(arguments, 0);
                ***REMOVED***
                function done(resp) {
                    cb(null, resp);
                    that._cache.set(fingerprint, resp);
                ***REMOVED***
                function fail() {
                    cb(true);
                ***REMOVED***
                function always() {
                    pendingRequestsCount--;
                    delete pendingRequests[fingerprint];
                    if (that.onDeckRequestArgs) {
                        that._get.apply(that, that.onDeckRequestArgs);
                        that.onDeckRequestArgs = null;
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
            get: function(o, cb) {
                var resp, fingerprint;
                cb = cb || $.noop;
                o = _.isString(o) ? {
                    url: o
                ***REMOVED*** : o || {***REMOVED***;
                fingerprint = this._fingerprint(o);
                this.cancelled = false;
                this.lastReq = fingerprint;
                if (resp = this._cache.get(fingerprint)) {
                    cb(null, resp);
                ***REMOVED*** else {
                    this._get(o, cb);
                ***REMOVED***
            ***REMOVED***,
            cancel: function() {
                this.cancelled = true;
            ***REMOVED***
        ***REMOVED***);
        return Transport;
    ***REMOVED***();
    var SearchIndex = window.SearchIndex = function() {
        "use strict";
        var CHILDREN = "c", IDS = "i";
        function SearchIndex(o) {
            o = o || {***REMOVED***;
            if (!o.datumTokenizer || !o.queryTokenizer) {
                $.error("datumTokenizer and queryTokenizer are both required");
            ***REMOVED***
            this.identify = o.identify || _.stringify;
            this.datumTokenizer = o.datumTokenizer;
            this.queryTokenizer = o.queryTokenizer;
            this.reset();
        ***REMOVED***
        _.mixin(SearchIndex.prototype, {
            bootstrap: function bootstrap(o) {
                this.datums = o.datums;
                this.trie = o.trie;
            ***REMOVED***,
            add: function(data) {
                var that = this;
                data = _.isArray(data) ? data : [ data ];
                _.each(data, function(datum) {
                    var id, tokens;
                    that.datums[id = that.identify(datum)] = datum;
                    tokens = normalizeTokens(that.datumTokenizer(datum));
                    _.each(tokens, function(token) {
                        var node, chars, ch;
                        node = that.trie;
                        chars = token.split("");
                        while (ch = chars.shift()) {
                            node = node[CHILDREN][ch] || (node[CHILDREN][ch] = newNode());
                            node[IDS].push(id);
                        ***REMOVED***
                    ***REMOVED***);
                ***REMOVED***);
            ***REMOVED***,
            get: function get(ids) {
                var that = this;
                return _.map(ids, function(id) {
                    return that.datums[id];
                ***REMOVED***);
            ***REMOVED***,
            search: function search(query) {
                var that = this, tokens, matches;
                tokens = normalizeTokens(this.queryTokenizer(query));
                _.each(tokens, function(token) {
                    var node, chars, ch, ids;
                    if (matches && matches.length === 0) {
                        return false;
                    ***REMOVED***
                    node = that.trie;
                    chars = token.split("");
                    while (node && (ch = chars.shift())) {
                        node = node[CHILDREN][ch];
                    ***REMOVED***
                    if (node && chars.length === 0) {
                        ids = node[IDS].slice(0);
                        matches = matches ? getIntersection(matches, ids) : ids;
                    ***REMOVED*** else {
                        matches = [];
                        return false;
                    ***REMOVED***
                ***REMOVED***);
                return matches ? _.map(unique(matches), function(id) {
                    return that.datums[id];
                ***REMOVED***) : [];
            ***REMOVED***,
            all: function all() {
                var values = [];
                for (var key in this.datums) {
                    values.push(this.datums[key]);
                ***REMOVED***
                return values;
            ***REMOVED***,
            reset: function reset() {
                this.datums = {***REMOVED***;
                this.trie = newNode();
            ***REMOVED***,
            serialize: function serialize() {
                return {
                    datums: this.datums,
                    trie: this.trie
                ***REMOVED***;
            ***REMOVED***
        ***REMOVED***);
        return SearchIndex;
        function normalizeTokens(tokens) {
            tokens = _.filter(tokens, function(token) {
                return !!token;
            ***REMOVED***);
            tokens = _.map(tokens, function(token) {
                return token.toLowerCase();
            ***REMOVED***);
            return tokens;
        ***REMOVED***
        function newNode() {
            var node = {***REMOVED***;
            node[IDS] = [];
            node[CHILDREN] = {***REMOVED***;
            return node;
        ***REMOVED***
        function unique(array) {
            var seen = {***REMOVED***, uniques = [];
            for (var i = 0, len = array.length; i < len; i++) {
                if (!seen[array[i]]) {
                    seen[array[i]] = true;
                    uniques.push(array[i]);
                ***REMOVED***
            ***REMOVED***
            return uniques;
        ***REMOVED***
        function getIntersection(arrayA, arrayB) {
            var ai = 0, bi = 0, intersection = [];
            arrayA = arrayA.sort();
            arrayB = arrayB.sort();
            var lenArrayA = arrayA.length, lenArrayB = arrayB.length;
            while (ai < lenArrayA && bi < lenArrayB) {
                if (arrayA[ai] < arrayB[bi]) {
                    ai++;
                ***REMOVED*** else if (arrayA[ai] > arrayB[bi]) {
                    bi++;
                ***REMOVED*** else {
                    intersection.push(arrayA[ai]);
                    ai++;
                    bi++;
                ***REMOVED***
            ***REMOVED***
            return intersection;
        ***REMOVED***
    ***REMOVED***();
    var Prefetch = function() {
        "use strict";
        var keys;
        keys = {
            data: "data",
            protocol: "protocol",
            thumbprint: "thumbprint"
        ***REMOVED***;
        function Prefetch(o) {
            this.url = o.url;
            this.ttl = o.ttl;
            this.cache = o.cache;
            this.prepare = o.prepare;
            this.transform = o.transform;
            this.transport = o.transport;
            this.thumbprint = o.thumbprint;
            this.storage = new PersistentStorage(o.cacheKey);
        ***REMOVED***
        _.mixin(Prefetch.prototype, {
            _settings: function settings() {
                return {
                    url: this.url,
                    type: "GET",
                    dataType: "json"
                ***REMOVED***;
            ***REMOVED***,
            store: function store(data) {
                if (!this.cache) {
                    return;
                ***REMOVED***
                this.storage.set(keys.data, data, this.ttl);
                this.storage.set(keys.protocol, location.protocol, this.ttl);
                this.storage.set(keys.thumbprint, this.thumbprint, this.ttl);
            ***REMOVED***,
            fromCache: function fromCache() {
                var stored = {***REMOVED***, isExpired;
                if (!this.cache) {
                    return null;
                ***REMOVED***
                stored.data = this.storage.get(keys.data);
                stored.protocol = this.storage.get(keys.protocol);
                stored.thumbprint = this.storage.get(keys.thumbprint);
                isExpired = stored.thumbprint !== this.thumbprint || stored.protocol !== location.protocol;
                return stored.data && !isExpired ? stored.data : null;
            ***REMOVED***,
            fromNetwork: function(cb) {
                var that = this, settings;
                if (!cb) {
                    return;
                ***REMOVED***
                settings = this.prepare(this._settings());
                this.transport(settings).fail(onError).done(onResponse);
                function onError() {
                    cb(true);
                ***REMOVED***
                function onResponse(resp) {
                    cb(null, that.transform(resp));
                ***REMOVED***
            ***REMOVED***,
            clear: function clear() {
                this.storage.clear();
                return this;
            ***REMOVED***
        ***REMOVED***);
        return Prefetch;
    ***REMOVED***();
    var Remote = function() {
        "use strict";
        function Remote(o) {
            this.url = o.url;
            this.prepare = o.prepare;
            this.transform = o.transform;
            this.transport = new Transport({
                cache: o.cache,
                limiter: o.limiter,
                transport: o.transport
            ***REMOVED***);
        ***REMOVED***
        _.mixin(Remote.prototype, {
            _settings: function settings() {
                return {
                    url: this.url,
                    type: "GET",
                    dataType: "json"
                ***REMOVED***;
            ***REMOVED***,
            get: function get(query, cb) {
                var that = this, settings;
                if (!cb) {
                    return;
                ***REMOVED***
                query = query || "";
                settings = this.prepare(query, this._settings());
                return this.transport.get(settings, onResponse);
                function onResponse(err, resp) {
                    err ? cb([]) : cb(that.transform(resp));
                ***REMOVED***
            ***REMOVED***,
            cancelLastRequest: function cancelLastRequest() {
                this.transport.cancel();
            ***REMOVED***
        ***REMOVED***);
        return Remote;
    ***REMOVED***();
    var oParser = function() {
        "use strict";
        return function parse(o) {
            var defaults, sorter;
            defaults = {
                initialize: true,
                identify: _.stringify,
                datumTokenizer: null,
                queryTokenizer: null,
                sufficient: 5,
                sorter: null,
                local: [],
                prefetch: null,
                remote: null
            ***REMOVED***;
            o = _.mixin(defaults, o || {***REMOVED***);
            !o.datumTokenizer && $.error("datumTokenizer is required");
            !o.queryTokenizer && $.error("queryTokenizer is required");
            sorter = o.sorter;
            o.sorter = sorter ? function(x) {
                return x.sort(sorter);
            ***REMOVED*** : _.identity;
            o.local = _.isFunction(o.local) ? o.local() : o.local;
            o.prefetch = parsePrefetch(o.prefetch);
            o.remote = parseRemote(o.remote);
            return o;
        ***REMOVED***;
        function parsePrefetch(o) {
            var defaults;
            if (!o) {
                return null;
            ***REMOVED***
            defaults = {
                url: null,
                ttl: 24 * 60 * 60 * 1e3,
                cache: true,
                cacheKey: null,
                thumbprint: "",
                prepare: _.identity,
                transform: _.identity,
                transport: null
            ***REMOVED***;
            o = _.isString(o) ? {
                url: o
            ***REMOVED*** : o;
            o = _.mixin(defaults, o);
            !o.url && $.error("prefetch requires url to be set");
            o.transform = o.filter || o.transform;
            o.cacheKey = o.cacheKey || o.url;
            o.thumbprint = VERSION + o.thumbprint;
            o.transport = o.transport ? callbackToDeferred(o.transport) : $.ajax;
            return o;
        ***REMOVED***
        function parseRemote(o) {
            var defaults;
            if (!o) {
                return;
            ***REMOVED***
            defaults = {
                url: null,
                cache: true,
                prepare: null,
                replace: null,
                wildcard: null,
                limiter: null,
                rateLimitBy: "debounce",
                rateLimitWait: 300,
                transform: _.identity,
                transport: null
            ***REMOVED***;
            o = _.isString(o) ? {
                url: o
            ***REMOVED*** : o;
            o = _.mixin(defaults, o);
            !o.url && $.error("remote requires url to be set");
            o.transform = o.filter || o.transform;
            o.prepare = toRemotePrepare(o);
            o.limiter = toLimiter(o);
            o.transport = o.transport ? callbackToDeferred(o.transport) : $.ajax;
            delete o.replace;
            delete o.wildcard;
            delete o.rateLimitBy;
            delete o.rateLimitWait;
            return o;
        ***REMOVED***
        function toRemotePrepare(o) {
            var prepare, replace, wildcard;
            prepare = o.prepare;
            replace = o.replace;
            wildcard = o.wildcard;
            if (prepare) {
                return prepare;
            ***REMOVED***
            if (replace) {
                prepare = prepareByReplace;
            ***REMOVED*** else if (o.wildcard) {
                prepare = prepareByWildcard;
            ***REMOVED*** else {
                prepare = idenityPrepare;
            ***REMOVED***
            return prepare;
            function prepareByReplace(query, settings) {
                settings.url = replace(settings.url, query);
                return settings;
            ***REMOVED***
            function prepareByWildcard(query, settings) {
                settings.url = settings.url.replace(wildcard, encodeURIComponent(query));
                return settings;
            ***REMOVED***
            function idenityPrepare(query, settings) {
                return settings;
            ***REMOVED***
        ***REMOVED***
        function toLimiter(o) {
            var limiter, method, wait;
            limiter = o.limiter;
            method = o.rateLimitBy;
            wait = o.rateLimitWait;
            if (!limiter) {
                limiter = /^throttle$/i.test(method) ? throttle(wait) : debounce(wait);
            ***REMOVED***
            return limiter;
            function debounce(wait) {
                return function debounce(fn) {
                    return _.debounce(fn, wait);
                ***REMOVED***;
            ***REMOVED***
            function throttle(wait) {
                return function throttle(fn) {
                    return _.throttle(fn, wait);
                ***REMOVED***;
            ***REMOVED***
        ***REMOVED***
        function callbackToDeferred(fn) {
            return function wrapper(o) {
                var deferred = $.Deferred();
                fn(o, onSuccess, onError);
                return deferred;
                function onSuccess(resp) {
                    _.defer(function() {
                        deferred.resolve(resp);
                    ***REMOVED***);
                ***REMOVED***
                function onError(err) {
                    _.defer(function() {
                        deferred.reject(err);
                    ***REMOVED***);
                ***REMOVED***
            ***REMOVED***;
        ***REMOVED***
    ***REMOVED***();
    var Bloodhound = function() {
        "use strict";
        var old;
        old = window && window.Bloodhound;
        function Bloodhound(o) {
            o = oParser(o);
            this.sorter = o.sorter;
            this.identify = o.identify;
            this.sufficient = o.sufficient;
            this.local = o.local;
            this.remote = o.remote ? new Remote(o.remote) : null;
            this.prefetch = o.prefetch ? new Prefetch(o.prefetch) : null;
            this.index = new SearchIndex({
                identify: this.identify,
                datumTokenizer: o.datumTokenizer,
                queryTokenizer: o.queryTokenizer
            ***REMOVED***);
            o.initialize !== false && this.initialize();
        ***REMOVED***
        Bloodhound.noConflict = function noConflict() {
            window && (window.Bloodhound = old);
            return Bloodhound;
        ***REMOVED***;
        Bloodhound.tokenizers = tokenizers;
        _.mixin(Bloodhound.prototype, {
            __ttAdapter: function ttAdapter() {
                var that = this;
                return this.remote ? withAsync : withoutAsync;
                function withAsync(query, sync, async) {
                    return that.search(query, sync, async);
                ***REMOVED***
                function withoutAsync(query, sync) {
                    return that.search(query, sync);
                ***REMOVED***
            ***REMOVED***,
            _loadPrefetch: function loadPrefetch() {
                var that = this, deferred, serialized;
                deferred = $.Deferred();
                if (!this.prefetch) {
                    deferred.resolve();
                ***REMOVED*** else if (serialized = this.prefetch.fromCache()) {
                    this.index.bootstrap(serialized);
                    deferred.resolve();
                ***REMOVED*** else {
                    this.prefetch.fromNetwork(done);
                ***REMOVED***
                return deferred.promise();
                function done(err, data) {
                    if (err) {
                        return deferred.reject();
                    ***REMOVED***
                    that.add(data);
                    that.prefetch.store(that.index.serialize());
                    deferred.resolve();
                ***REMOVED***
            ***REMOVED***,
            _initialize: function initialize() {
                var that = this, deferred;
                this.clear();
                (this.initPromise = this._loadPrefetch()).done(addLocalToIndex);
                return this.initPromise;
                function addLocalToIndex() {
                    that.add(that.local);
                ***REMOVED***
            ***REMOVED***,
            initialize: function initialize(force) {
                return !this.initPromise || force ? this._initialize() : this.initPromise;
            ***REMOVED***,
            add: function add(data) {
                this.index.add(data);
                return this;
            ***REMOVED***,
            get: function get(ids) {
                ids = _.isArray(ids) ? ids : [].slice.call(arguments);
                return this.index.get(ids);
            ***REMOVED***,
            search: function search(query, sync, async) {
                var that = this, local;
                local = this.sorter(this.index.search(query));
                sync(this.remote ? local.slice() : local);
                if (this.remote && local.length < this.sufficient) {
                    this.remote.get(query, processRemote);
                ***REMOVED*** else if (this.remote) {
                    this.remote.cancelLastRequest();
                ***REMOVED***
                return this;
                function processRemote(remote) {
                    var nonDuplicates = [];
                    _.each(remote, function(r) {
                        !_.some(local, function(l) {
                            return that.identify(r) === that.identify(l);
                        ***REMOVED***) && nonDuplicates.push(r);
                    ***REMOVED***);
                    async && async(nonDuplicates);
                ***REMOVED***
            ***REMOVED***,
            all: function all() {
                return this.index.all();
            ***REMOVED***,
            clear: function clear() {
                this.index.reset();
                return this;
            ***REMOVED***,
            clearPrefetchCache: function clearPrefetchCache() {
                this.prefetch && this.prefetch.clear();
                return this;
            ***REMOVED***,
            clearRemoteCache: function clearRemoteCache() {
                Transport.resetCache();
                return this;
            ***REMOVED***,
            ttAdapter: function ttAdapter() {
                return this.__ttAdapter();
            ***REMOVED***
        ***REMOVED***);
        return Bloodhound;
    ***REMOVED***();
    return Bloodhound;
***REMOVED***);