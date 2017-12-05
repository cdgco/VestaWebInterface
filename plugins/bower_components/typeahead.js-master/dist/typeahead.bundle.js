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

(function(root, factory) {
    if (typeof define === "function" && define.amd) {
        define("typeahead.js", [ "jquery" ], function(a0) {
            return factory(a0);
        ***REMOVED***);
    ***REMOVED*** else if (typeof exports === "object") {
        module.exports = factory(require("jquery"));
    ***REMOVED*** else {
        factory(jQuery);
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
    var WWW = function() {
        "use strict";
        var defaultClassNames = {
            wrapper: "twitter-typeahead",
            input: "tt-input",
            hint: "tt-hint",
            menu: "tt-menu",
            dataset: "tt-dataset",
            suggestion: "tt-suggestion",
            selectable: "tt-selectable",
            empty: "tt-empty",
            open: "tt-open",
            cursor: "tt-cursor",
            highlight: "tt-highlight"
        ***REMOVED***;
        return build;
        function build(o) {
            var www, classes;
            classes = _.mixin({***REMOVED***, defaultClassNames, o);
            www = {
                css: buildCss(),
                classes: classes,
                html: buildHtml(classes),
                selectors: buildSelectors(classes)
            ***REMOVED***;
            return {
                css: www.css,
                html: www.html,
                classes: www.classes,
                selectors: www.selectors,
                mixin: function(o) {
                    _.mixin(o, www);
                ***REMOVED***
            ***REMOVED***;
        ***REMOVED***
        function buildHtml(c) {
            return {
                wrapper: '<span class="' + c.wrapper + '"></span>',
                menu: '<div class="' + c.menu + '"></div>'
            ***REMOVED***;
        ***REMOVED***
        function buildSelectors(classes) {
            var selectors = {***REMOVED***;
            _.each(classes, function(v, k) {
                selectors[k] = "." + v;
            ***REMOVED***);
            return selectors;
        ***REMOVED***
        function buildCss() {
            var css = {
                wrapper: {
                    position: "relative",
                    display: "inline-block"
                ***REMOVED***,
                hint: {
                    position: "absolute",
                    top: "0",
                    left: "0",
                    borderColor: "transparent",
                    boxShadow: "none",
                    opacity: "1"
                ***REMOVED***,
                input: {
                    position: "relative",
                    verticalAlign: "top",
                    backgroundColor: "transparent"
                ***REMOVED***,
                inputWithNoHint: {
                    position: "relative",
                    verticalAlign: "top"
                ***REMOVED***,
                menu: {
                    position: "absolute",
                    top: "100%",
                    left: "0",
                    zIndex: "100",
                    display: "none"
                ***REMOVED***,
                ltr: {
                    left: "0",
                    right: "auto"
                ***REMOVED***,
                rtl: {
                    left: "auto",
                    right: " 0"
                ***REMOVED***
            ***REMOVED***;
            if (_.isMsie()) {
                _.mixin(css.input, {
                    backgroundImage: "url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)"
                ***REMOVED***);
            ***REMOVED***
            return css;
        ***REMOVED***
    ***REMOVED***();
    var EventBus = function() {
        "use strict";
        var namespace, deprecationMap;
        namespace = "typeahead:";
        deprecationMap = {
            render: "rendered",
            cursorchange: "cursorchanged",
            select: "selected",
            autocomplete: "autocompleted"
        ***REMOVED***;
        function EventBus(o) {
            if (!o || !o.el) {
                $.error("EventBus initialized without el");
            ***REMOVED***
            this.$el = $(o.el);
        ***REMOVED***
        _.mixin(EventBus.prototype, {
            _trigger: function(type, args) {
                var $e;
                $e = $.Event(namespace + type);
                (args = args || []).unshift($e);
                this.$el.trigger.apply(this.$el, args);
                return $e;
            ***REMOVED***,
            before: function(type) {
                var args, $e;
                args = [].slice.call(arguments, 1);
                $e = this._trigger("before" + type, args);
                return $e.isDefaultPrevented();
            ***REMOVED***,
            trigger: function(type) {
                var deprecatedType;
                this._trigger(type, [].slice.call(arguments, 1));
                if (deprecatedType = deprecationMap[type]) {
                    this._trigger(deprecatedType, [].slice.call(arguments, 1));
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***);
        return EventBus;
    ***REMOVED***();
    var EventEmitter = function() {
        "use strict";
        var splitter = /\s+/, nextTick = getNextTick();
        return {
            onSync: onSync,
            onAsync: onAsync,
            off: off,
            trigger: trigger
        ***REMOVED***;
        function on(method, types, cb, context) {
            var type;
            if (!cb) {
                return this;
            ***REMOVED***
            types = types.split(splitter);
            cb = context ? bindContext(cb, context) : cb;
            this._callbacks = this._callbacks || {***REMOVED***;
            while (type = types.shift()) {
                this._callbacks[type] = this._callbacks[type] || {
                    sync: [],
                    async: []
                ***REMOVED***;
                this._callbacks[type][method].push(cb);
            ***REMOVED***
            return this;
        ***REMOVED***
        function onAsync(types, cb, context) {
            return on.call(this, "async", types, cb, context);
        ***REMOVED***
        function onSync(types, cb, context) {
            return on.call(this, "sync", types, cb, context);
        ***REMOVED***
        function off(types) {
            var type;
            if (!this._callbacks) {
                return this;
            ***REMOVED***
            types = types.split(splitter);
            while (type = types.shift()) {
                delete this._callbacks[type];
            ***REMOVED***
            return this;
        ***REMOVED***
        function trigger(types) {
            var type, callbacks, args, syncFlush, asyncFlush;
            if (!this._callbacks) {
                return this;
            ***REMOVED***
            types = types.split(splitter);
            args = [].slice.call(arguments, 1);
            while ((type = types.shift()) && (callbacks = this._callbacks[type])) {
                syncFlush = getFlush(callbacks.sync, this, [ type ].concat(args));
                asyncFlush = getFlush(callbacks.async, this, [ type ].concat(args));
                syncFlush() && nextTick(asyncFlush);
            ***REMOVED***
            return this;
        ***REMOVED***
        function getFlush(callbacks, context, args) {
            return flush;
            function flush() {
                var cancelled;
                for (var i = 0, len = callbacks.length; !cancelled && i < len; i += 1) {
                    cancelled = callbacks[i].apply(context, args) === false;
                ***REMOVED***
                return !cancelled;
            ***REMOVED***
        ***REMOVED***
        function getNextTick() {
            var nextTickFn;
            if (window.setImmediate) {
                nextTickFn = function nextTickSetImmediate(fn) {
                    setImmediate(function() {
                        fn();
                    ***REMOVED***);
                ***REMOVED***;
            ***REMOVED*** else {
                nextTickFn = function nextTickSetTimeout(fn) {
                    setTimeout(function() {
                        fn();
                    ***REMOVED***, 0);
                ***REMOVED***;
            ***REMOVED***
            return nextTickFn;
        ***REMOVED***
        function bindContext(fn, context) {
            return fn.bind ? fn.bind(context) : function() {
                fn.apply(context, [].slice.call(arguments, 0));
            ***REMOVED***;
        ***REMOVED***
    ***REMOVED***();
    var highlight = function(doc) {
        "use strict";
        var defaults = {
            node: null,
            pattern: null,
            tagName: "strong",
            className: null,
            wordsOnly: false,
            caseSensitive: false
        ***REMOVED***;
        return function hightlight(o) {
            var regex;
            o = _.mixin({***REMOVED***, defaults, o);
            if (!o.node || !o.pattern) {
                return;
            ***REMOVED***
            o.pattern = _.isArray(o.pattern) ? o.pattern : [ o.pattern ];
            regex = getRegex(o.pattern, o.caseSensitive, o.wordsOnly);
            traverse(o.node, hightlightTextNode);
            function hightlightTextNode(textNode) {
                var match, patternNode, wrapperNode;
                if (match = regex.exec(textNode.data)) {
                    wrapperNode = doc.createElement(o.tagName);
                    o.className && (wrapperNode.className = o.className);
                    patternNode = textNode.splitText(match.index);
                    patternNode.splitText(match[0].length);
                    wrapperNode.appendChild(patternNode.cloneNode(true));
                    textNode.parentNode.replaceChild(wrapperNode, patternNode);
                ***REMOVED***
                return !!match;
            ***REMOVED***
            function traverse(el, hightlightTextNode) {
                var childNode, TEXT_NODE_TYPE = 3;
                for (var i = 0; i < el.childNodes.length; i++) {
                    childNode = el.childNodes[i];
                    if (childNode.nodeType === TEXT_NODE_TYPE) {
                        i += hightlightTextNode(childNode) ? 1 : 0;
                    ***REMOVED*** else {
                        traverse(childNode, hightlightTextNode);
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***;
        function getRegex(patterns, caseSensitive, wordsOnly) {
            var escapedPatterns = [], regexStr;
            for (var i = 0, len = patterns.length; i < len; i++) {
                escapedPatterns.push(_.escapeRegExChars(patterns[i]));
            ***REMOVED***
            regexStr = wordsOnly ? "\\b(" + escapedPatterns.join("|") + ")\\b" : "(" + escapedPatterns.join("|") + ")";
            return caseSensitive ? new RegExp(regexStr) : new RegExp(regexStr, "i");
        ***REMOVED***
    ***REMOVED***(window.document);
    var Input = function() {
        "use strict";
        var specialKeyCodeMap;
        specialKeyCodeMap = {
            9: "tab",
            27: "esc",
            37: "left",
            39: "right",
            13: "enter",
            38: "up",
            40: "down"
        ***REMOVED***;
        function Input(o, www) {
            o = o || {***REMOVED***;
            if (!o.input) {
                $.error("input is missing");
            ***REMOVED***
            www.mixin(this);
            this.$hint = $(o.hint);
            this.$input = $(o.input);
            this.query = this.$input.val();
            this.queryWhenFocused = this.hasFocus() ? this.query : null;
            this.$overflowHelper = buildOverflowHelper(this.$input);
            this._checkLanguageDirection();
            if (this.$hint.length === 0) {
                this.setHint = this.getHint = this.clearHint = this.clearHintIfInvalid = _.noop;
            ***REMOVED***
        ***REMOVED***
        Input.normalizeQuery = function(str) {
            return _.toStr(str).replace(/^\s*/g, "").replace(/\s{2,***REMOVED***/g, " ");
        ***REMOVED***;
        _.mixin(Input.prototype, EventEmitter, {
            _onBlur: function onBlur() {
                this.resetInputValue();
                this.trigger("blurred");
            ***REMOVED***,
            _onFocus: function onFocus() {
                this.queryWhenFocused = this.query;
                this.trigger("focused");
            ***REMOVED***,
            _onKeydown: function onKeydown($e) {
                var keyName = specialKeyCodeMap[$e.which || $e.keyCode];
                this._managePreventDefault(keyName, $e);
                if (keyName && this._shouldTrigger(keyName, $e)) {
                    this.trigger(keyName + "Keyed", $e);
                ***REMOVED***
            ***REMOVED***,
            _onInput: function onInput() {
                this._setQuery(this.getInputValue());
                this.clearHintIfInvalid();
                this._checkLanguageDirection();
            ***REMOVED***,
            _managePreventDefault: function managePreventDefault(keyName, $e) {
                var preventDefault;
                switch (keyName) {
                  case "up":
                  case "down":
                    preventDefault = !withModifier($e);
                    break;

                  default:
                    preventDefault = false;
                ***REMOVED***
                preventDefault && $e.preventDefault();
            ***REMOVED***,
            _shouldTrigger: function shouldTrigger(keyName, $e) {
                var trigger;
                switch (keyName) {
                  case "tab":
                    trigger = !withModifier($e);
                    break;

                  default:
                    trigger = true;
                ***REMOVED***
                return trigger;
            ***REMOVED***,
            _checkLanguageDirection: function checkLanguageDirection() {
                var dir = (this.$input.css("direction") || "ltr").toLowerCase();
                if (this.dir !== dir) {
                    this.dir = dir;
                    this.$hint.attr("dir", dir);
                    this.trigger("langDirChanged", dir);
                ***REMOVED***
            ***REMOVED***,
            _setQuery: function setQuery(val, silent) {
                var areEquivalent, hasDifferentWhitespace;
                areEquivalent = areQueriesEquivalent(val, this.query);
                hasDifferentWhitespace = areEquivalent ? this.query.length !== val.length : false;
                this.query = val;
                if (!silent && !areEquivalent) {
                    this.trigger("queryChanged", this.query);
                ***REMOVED*** else if (!silent && hasDifferentWhitespace) {
                    this.trigger("whitespaceChanged", this.query);
                ***REMOVED***
            ***REMOVED***,
            bind: function() {
                var that = this, onBlur, onFocus, onKeydown, onInput;
                onBlur = _.bind(this._onBlur, this);
                onFocus = _.bind(this._onFocus, this);
                onKeydown = _.bind(this._onKeydown, this);
                onInput = _.bind(this._onInput, this);
                this.$input.on("blur.tt", onBlur).on("focus.tt", onFocus).on("keydown.tt", onKeydown);
                if (!_.isMsie() || _.isMsie() > 9) {
                    this.$input.on("input.tt", onInput);
                ***REMOVED*** else {
                    this.$input.on("keydown.tt keypress.tt cut.tt paste.tt", function($e) {
                        if (specialKeyCodeMap[$e.which || $e.keyCode]) {
                            return;
                        ***REMOVED***
                        _.defer(_.bind(that._onInput, that, $e));
                    ***REMOVED***);
                ***REMOVED***
                return this;
            ***REMOVED***,
            focus: function focus() {
                this.$input.focus();
            ***REMOVED***,
            blur: function blur() {
                this.$input.blur();
            ***REMOVED***,
            getLangDir: function getLangDir() {
                return this.dir;
            ***REMOVED***,
            getQuery: function getQuery() {
                return this.query || "";
            ***REMOVED***,
            setQuery: function setQuery(val, silent) {
                this.setInputValue(val);
                this._setQuery(val, silent);
            ***REMOVED***,
            hasQueryChangedSinceLastFocus: function hasQueryChangedSinceLastFocus() {
                return this.query !== this.queryWhenFocused;
            ***REMOVED***,
            getInputValue: function getInputValue() {
                return this.$input.val();
            ***REMOVED***,
            setInputValue: function setInputValue(value) {
                this.$input.val(value);
                this.clearHintIfInvalid();
                this._checkLanguageDirection();
            ***REMOVED***,
            resetInputValue: function resetInputValue() {
                this.setInputValue(this.query);
            ***REMOVED***,
            getHint: function getHint() {
                return this.$hint.val();
            ***REMOVED***,
            setHint: function setHint(value) {
                this.$hint.val(value);
            ***REMOVED***,
            clearHint: function clearHint() {
                this.setHint("");
            ***REMOVED***,
            clearHintIfInvalid: function clearHintIfInvalid() {
                var val, hint, valIsPrefixOfHint, isValid;
                val = this.getInputValue();
                hint = this.getHint();
                valIsPrefixOfHint = val !== hint && hint.indexOf(val) === 0;
                isValid = val !== "" && valIsPrefixOfHint && !this.hasOverflow();
                !isValid && this.clearHint();
            ***REMOVED***,
            hasFocus: function hasFocus() {
                return this.$input.is(":focus");
            ***REMOVED***,
            hasOverflow: function hasOverflow() {
                var constraint = this.$input.width() - 2;
                this.$overflowHelper.text(this.getInputValue());
                return this.$overflowHelper.width() >= constraint;
            ***REMOVED***,
            isCursorAtEnd: function() {
                var valueLength, selectionStart, range;
                valueLength = this.$input.val().length;
                selectionStart = this.$input[0].selectionStart;
                if (_.isNumber(selectionStart)) {
                    return selectionStart === valueLength;
                ***REMOVED*** else if (document.selection) {
                    range = document.selection.createRange();
                    range.moveStart("character", -valueLength);
                    return valueLength === range.text.length;
                ***REMOVED***
                return true;
            ***REMOVED***,
            destroy: function destroy() {
                this.$hint.off(".tt");
                this.$input.off(".tt");
                this.$overflowHelper.remove();
                this.$hint = this.$input = this.$overflowHelper = $("<div>");
            ***REMOVED***
        ***REMOVED***);
        return Input;
        function buildOverflowHelper($input) {
            return $('<pre aria-hidden="true"></pre>').css({
                position: "absolute",
                visibility: "hidden",
                whiteSpace: "pre",
                fontFamily: $input.css("font-family"),
                fontSize: $input.css("font-size"),
                fontStyle: $input.css("font-style"),
                fontVariant: $input.css("font-variant"),
                fontWeight: $input.css("font-weight"),
                wordSpacing: $input.css("word-spacing"),
                letterSpacing: $input.css("letter-spacing"),
                textIndent: $input.css("text-indent"),
                textRendering: $input.css("text-rendering"),
                textTransform: $input.css("text-transform")
            ***REMOVED***).insertAfter($input);
        ***REMOVED***
        function areQueriesEquivalent(a, b) {
            return Input.normalizeQuery(a) === Input.normalizeQuery(b);
        ***REMOVED***
        function withModifier($e) {
            return $e.altKey || $e.ctrlKey || $e.metaKey || $e.shiftKey;
        ***REMOVED***
    ***REMOVED***();
    var Dataset = function() {
        "use strict";
        var keys, nameGenerator;
        keys = {
            val: "tt-selectable-display",
            obj: "tt-selectable-object"
        ***REMOVED***;
        nameGenerator = _.getIdGenerator();
        function Dataset(o, www) {
            o = o || {***REMOVED***;
            o.templates = o.templates || {***REMOVED***;
            o.templates.notFound = o.templates.notFound || o.templates.empty;
            if (!o.source) {
                $.error("missing source");
            ***REMOVED***
            if (!o.node) {
                $.error("missing node");
            ***REMOVED***
            if (o.name && !isValidName(o.name)) {
                $.error("invalid dataset name: " + o.name);
            ***REMOVED***
            www.mixin(this);
            this.highlight = !!o.highlight;
            this.name = o.name || nameGenerator();
            this.limit = o.limit || 5;
            this.displayFn = getDisplayFn(o.display || o.displayKey);
            this.templates = getTemplates(o.templates, this.displayFn);
            this.source = o.source.__ttAdapter ? o.source.__ttAdapter() : o.source;
            this.async = _.isUndefined(o.async) ? this.source.length > 2 : !!o.async;
            this._resetLastSuggestion();
            this.$el = $(o.node).addClass(this.classes.dataset).addClass(this.classes.dataset + "-" + this.name);
        ***REMOVED***
        Dataset.extractData = function extractData(el) {
            var $el = $(el);
            if ($el.data(keys.obj)) {
                return {
                    val: $el.data(keys.val) || "",
                    obj: $el.data(keys.obj) || null
                ***REMOVED***;
            ***REMOVED***
            return null;
        ***REMOVED***;
        _.mixin(Dataset.prototype, EventEmitter, {
            _overwrite: function overwrite(query, suggestions) {
                suggestions = suggestions || [];
                if (suggestions.length) {
                    this._renderSuggestions(query, suggestions);
                ***REMOVED*** else if (this.async && this.templates.pending) {
                    this._renderPending(query);
                ***REMOVED*** else if (!this.async && this.templates.notFound) {
                    this._renderNotFound(query);
                ***REMOVED*** else {
                    this._empty();
                ***REMOVED***
                this.trigger("rendered", this.name, suggestions, false);
            ***REMOVED***,
            _append: function append(query, suggestions) {
                suggestions = suggestions || [];
                if (suggestions.length && this.$lastSuggestion.length) {
                    this._appendSuggestions(query, suggestions);
                ***REMOVED*** else if (suggestions.length) {
                    this._renderSuggestions(query, suggestions);
                ***REMOVED*** else if (!this.$lastSuggestion.length && this.templates.notFound) {
                    this._renderNotFound(query);
                ***REMOVED***
                this.trigger("rendered", this.name, suggestions, true);
            ***REMOVED***,
            _renderSuggestions: function renderSuggestions(query, suggestions) {
                var $fragment;
                $fragment = this._getSuggestionsFragment(query, suggestions);
                this.$lastSuggestion = $fragment.children().last();
                this.$el.html($fragment).prepend(this._getHeader(query, suggestions)).append(this._getFooter(query, suggestions));
            ***REMOVED***,
            _appendSuggestions: function appendSuggestions(query, suggestions) {
                var $fragment, $lastSuggestion;
                $fragment = this._getSuggestionsFragment(query, suggestions);
                $lastSuggestion = $fragment.children().last();
                this.$lastSuggestion.after($fragment);
                this.$lastSuggestion = $lastSuggestion;
            ***REMOVED***,
            _renderPending: function renderPending(query) {
                var template = this.templates.pending;
                this._resetLastSuggestion();
                template && this.$el.html(template({
                    query: query,
                    dataset: this.name
                ***REMOVED***));
            ***REMOVED***,
            _renderNotFound: function renderNotFound(query) {
                var template = this.templates.notFound;
                this._resetLastSuggestion();
                template && this.$el.html(template({
                    query: query,
                    dataset: this.name
                ***REMOVED***));
            ***REMOVED***,
            _empty: function empty() {
                this.$el.empty();
                this._resetLastSuggestion();
            ***REMOVED***,
            _getSuggestionsFragment: function getSuggestionsFragment(query, suggestions) {
                var that = this, fragment;
                fragment = document.createDocumentFragment();
                _.each(suggestions, function getSuggestionNode(suggestion) {
                    var $el, context;
                    context = that._injectQuery(query, suggestion);
                    $el = $(that.templates.suggestion(context)).data(keys.obj, suggestion).data(keys.val, that.displayFn(suggestion)).addClass(that.classes.suggestion + " " + that.classes.selectable);
                    fragment.appendChild($el[0]);
                ***REMOVED***);
                this.highlight && highlight({
                    className: this.classes.highlight,
                    node: fragment,
                    pattern: query
                ***REMOVED***);
                return $(fragment);
            ***REMOVED***,
            _getFooter: function getFooter(query, suggestions) {
                return this.templates.footer ? this.templates.footer({
                    query: query,
                    suggestions: suggestions,
                    dataset: this.name
                ***REMOVED***) : null;
            ***REMOVED***,
            _getHeader: function getHeader(query, suggestions) {
                return this.templates.header ? this.templates.header({
                    query: query,
                    suggestions: suggestions,
                    dataset: this.name
                ***REMOVED***) : null;
            ***REMOVED***,
            _resetLastSuggestion: function resetLastSuggestion() {
                this.$lastSuggestion = $();
            ***REMOVED***,
            _injectQuery: function injectQuery(query, obj) {
                return _.isObject(obj) ? _.mixin({
                    _query: query
                ***REMOVED***, obj) : obj;
            ***REMOVED***,
            update: function update(query) {
                var that = this, canceled = false, syncCalled = false, rendered = 0;
                this.cancel();
                this.cancel = function cancel() {
                    canceled = true;
                    that.cancel = $.noop;
                    that.async && that.trigger("asyncCanceled", query);
                ***REMOVED***;
                this.source(query, sync, async);
                !syncCalled && sync([]);
                function sync(suggestions) {
                    if (syncCalled) {
                        return;
                    ***REMOVED***
                    syncCalled = true;
                    suggestions = (suggestions || []).slice(0, that.limit);
                    rendered = suggestions.length;
                    that._overwrite(query, suggestions);
                    if (rendered < that.limit && that.async) {
                        that.trigger("asyncRequested", query);
                    ***REMOVED***
                ***REMOVED***
                function async(suggestions) {
                    suggestions = suggestions || [];
                    if (!canceled && rendered < that.limit) {
                        that.cancel = $.noop;
                        rendered += suggestions.length;
                        that._append(query, suggestions.slice(0, that.limit - rendered));
                        that.async && that.trigger("asyncReceived", query);
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
            cancel: $.noop,
            clear: function clear() {
                this._empty();
                this.cancel();
                this.trigger("cleared");
            ***REMOVED***,
            isEmpty: function isEmpty() {
                return this.$el.is(":empty");
            ***REMOVED***,
            destroy: function destroy() {
                this.$el = $("<div>");
            ***REMOVED***
        ***REMOVED***);
        return Dataset;
        function getDisplayFn(display) {
            display = display || _.stringify;
            return _.isFunction(display) ? display : displayFn;
            function displayFn(obj) {
                return obj[display];
            ***REMOVED***
        ***REMOVED***
        function getTemplates(templates, displayFn) {
            return {
                notFound: templates.notFound && _.templatify(templates.notFound),
                pending: templates.pending && _.templatify(templates.pending),
                header: templates.header && _.templatify(templates.header),
                footer: templates.footer && _.templatify(templates.footer),
                suggestion: templates.suggestion || suggestionTemplate
            ***REMOVED***;
            function suggestionTemplate(context) {
                return $("<div>").text(displayFn(context));
            ***REMOVED***
        ***REMOVED***
        function isValidName(str) {
            return /^[_a-zA-Z0-9-]+$/.test(str);
        ***REMOVED***
    ***REMOVED***();
    var Menu = function() {
        "use strict";
        function Menu(o, www) {
            var that = this;
            o = o || {***REMOVED***;
            if (!o.node) {
                $.error("node is required");
            ***REMOVED***
            www.mixin(this);
            this.$node = $(o.node);
            this.query = null;
            this.datasets = _.map(o.datasets, initializeDataset);
            function initializeDataset(oDataset) {
                var node = that.$node.find(oDataset.node).first();
                oDataset.node = node.length ? node : $("<div>").appendTo(that.$node);
                return new Dataset(oDataset, www);
            ***REMOVED***
        ***REMOVED***
        _.mixin(Menu.prototype, EventEmitter, {
            _onSelectableClick: function onSelectableClick($e) {
                this.trigger("selectableClicked", $($e.currentTarget));
            ***REMOVED***,
            _onRendered: function onRendered(type, dataset, suggestions, async) {
                this.$node.toggleClass(this.classes.empty, this._allDatasetsEmpty());
                this.trigger("datasetRendered", dataset, suggestions, async);
            ***REMOVED***,
            _onCleared: function onCleared() {
                this.$node.toggleClass(this.classes.empty, this._allDatasetsEmpty());
                this.trigger("datasetCleared");
            ***REMOVED***,
            _propagate: function propagate() {
                this.trigger.apply(this, arguments);
            ***REMOVED***,
            _allDatasetsEmpty: function allDatasetsEmpty() {
                return _.every(this.datasets, isDatasetEmpty);
                function isDatasetEmpty(dataset) {
                    return dataset.isEmpty();
                ***REMOVED***
            ***REMOVED***,
            _getSelectables: function getSelectables() {
                return this.$node.find(this.selectors.selectable);
            ***REMOVED***,
            _removeCursor: function _removeCursor() {
                var $selectable = this.getActiveSelectable();
                $selectable && $selectable.removeClass(this.classes.cursor);
            ***REMOVED***,
            _ensureVisible: function ensureVisible($el) {
                var elTop, elBottom, nodeScrollTop, nodeHeight;
                elTop = $el.position().top;
                elBottom = elTop + $el.outerHeight(true);
                nodeScrollTop = this.$node.scrollTop();
                nodeHeight = this.$node.height() + parseInt(this.$node.css("paddingTop"), 10) + parseInt(this.$node.css("paddingBottom"), 10);
                if (elTop < 0) {
                    this.$node.scrollTop(nodeScrollTop + elTop);
                ***REMOVED*** else if (nodeHeight < elBottom) {
                    this.$node.scrollTop(nodeScrollTop + (elBottom - nodeHeight));
                ***REMOVED***
            ***REMOVED***,
            bind: function() {
                var that = this, onSelectableClick;
                onSelectableClick = _.bind(this._onSelectableClick, this);
                this.$node.on("click.tt", this.selectors.selectable, onSelectableClick);
                _.each(this.datasets, function(dataset) {
                    dataset.onSync("asyncRequested", that._propagate, that).onSync("asyncCanceled", that._propagate, that).onSync("asyncReceived", that._propagate, that).onSync("rendered", that._onRendered, that).onSync("cleared", that._onCleared, that);
                ***REMOVED***);
                return this;
            ***REMOVED***,
            isOpen: function isOpen() {
                return this.$node.hasClass(this.classes.open);
            ***REMOVED***,
            open: function open() {
                this.$node.addClass(this.classes.open);
            ***REMOVED***,
            close: function close() {
                this.$node.removeClass(this.classes.open);
                this._removeCursor();
            ***REMOVED***,
            setLanguageDirection: function setLanguageDirection(dir) {
                this.$node.attr("dir", dir);
            ***REMOVED***,
            selectableRelativeToCursor: function selectableRelativeToCursor(delta) {
                var $selectables, $oldCursor, oldIndex, newIndex;
                $oldCursor = this.getActiveSelectable();
                $selectables = this._getSelectables();
                oldIndex = $oldCursor ? $selectables.index($oldCursor) : -1;
                newIndex = oldIndex + delta;
                newIndex = (newIndex + 1) % ($selectables.length + 1) - 1;
                newIndex = newIndex < -1 ? $selectables.length - 1 : newIndex;
                return newIndex === -1 ? null : $selectables.eq(newIndex);
            ***REMOVED***,
            setCursor: function setCursor($selectable) {
                this._removeCursor();
                if ($selectable = $selectable && $selectable.first()) {
                    $selectable.addClass(this.classes.cursor);
                    this._ensureVisible($selectable);
                ***REMOVED***
            ***REMOVED***,
            getSelectableData: function getSelectableData($el) {
                return $el && $el.length ? Dataset.extractData($el) : null;
            ***REMOVED***,
            getActiveSelectable: function getActiveSelectable() {
                var $selectable = this._getSelectables().filter(this.selectors.cursor).first();
                return $selectable.length ? $selectable : null;
            ***REMOVED***,
            getTopSelectable: function getTopSelectable() {
                var $selectable = this._getSelectables().first();
                return $selectable.length ? $selectable : null;
            ***REMOVED***,
            update: function update(query) {
                var isValidUpdate = query !== this.query;
                if (isValidUpdate) {
                    this.query = query;
                    _.each(this.datasets, updateDataset);
                ***REMOVED***
                return isValidUpdate;
                function updateDataset(dataset) {
                    dataset.update(query);
                ***REMOVED***
            ***REMOVED***,
            empty: function empty() {
                _.each(this.datasets, clearDataset);
                this.query = null;
                this.$node.addClass(this.classes.empty);
                function clearDataset(dataset) {
                    dataset.clear();
                ***REMOVED***
            ***REMOVED***,
            destroy: function destroy() {
                this.$node.off(".tt");
                this.$node = $("<div>");
                _.each(this.datasets, destroyDataset);
                function destroyDataset(dataset) {
                    dataset.destroy();
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***);
        return Menu;
    ***REMOVED***();
    var DefaultMenu = function() {
        "use strict";
        var s = Menu.prototype;
        function DefaultMenu() {
            Menu.apply(this, [].slice.call(arguments, 0));
        ***REMOVED***
        _.mixin(DefaultMenu.prototype, Menu.prototype, {
            open: function open() {
                !this._allDatasetsEmpty() && this._show();
                return s.open.apply(this, [].slice.call(arguments, 0));
            ***REMOVED***,
            close: function close() {
                this._hide();
                return s.close.apply(this, [].slice.call(arguments, 0));
            ***REMOVED***,
            _onRendered: function onRendered() {
                if (this._allDatasetsEmpty()) {
                    this._hide();
                ***REMOVED*** else {
                    this.isOpen() && this._show();
                ***REMOVED***
                return s._onRendered.apply(this, [].slice.call(arguments, 0));
            ***REMOVED***,
            _onCleared: function onCleared() {
                if (this._allDatasetsEmpty()) {
                    this._hide();
                ***REMOVED*** else {
                    this.isOpen() && this._show();
                ***REMOVED***
                return s._onCleared.apply(this, [].slice.call(arguments, 0));
            ***REMOVED***,
            setLanguageDirection: function setLanguageDirection(dir) {
                this.$node.css(dir === "ltr" ? this.css.ltr : this.css.rtl);
                return s.setLanguageDirection.apply(this, [].slice.call(arguments, 0));
            ***REMOVED***,
            _hide: function hide() {
                this.$node.hide();
            ***REMOVED***,
            _show: function show() {
                this.$node.css("display", "block");
            ***REMOVED***
        ***REMOVED***);
        return DefaultMenu;
    ***REMOVED***();
    var Typeahead = function() {
        "use strict";
        function Typeahead(o, www) {
            var onFocused, onBlurred, onEnterKeyed, onTabKeyed, onEscKeyed, onUpKeyed, onDownKeyed, onLeftKeyed, onRightKeyed, onQueryChanged, onWhitespaceChanged;
            o = o || {***REMOVED***;
            if (!o.input) {
                $.error("missing input");
            ***REMOVED***
            if (!o.menu) {
                $.error("missing menu");
            ***REMOVED***
            if (!o.eventBus) {
                $.error("missing event bus");
            ***REMOVED***
            www.mixin(this);
            this.eventBus = o.eventBus;
            this.minLength = _.isNumber(o.minLength) ? o.minLength : 1;
            this.input = o.input;
            this.menu = o.menu;
            this.enabled = true;
            this.active = false;
            this.input.hasFocus() && this.activate();
            this.dir = this.input.getLangDir();
            this._hacks();
            this.menu.bind().onSync("selectableClicked", this._onSelectableClicked, this).onSync("asyncRequested", this._onAsyncRequested, this).onSync("asyncCanceled", this._onAsyncCanceled, this).onSync("asyncReceived", this._onAsyncReceived, this).onSync("datasetRendered", this._onDatasetRendered, this).onSync("datasetCleared", this._onDatasetCleared, this);
            onFocused = c(this, "activate", "open", "_onFocused");
            onBlurred = c(this, "deactivate", "_onBlurred");
            onEnterKeyed = c(this, "isActive", "isOpen", "_onEnterKeyed");
            onTabKeyed = c(this, "isActive", "isOpen", "_onTabKeyed");
            onEscKeyed = c(this, "isActive", "_onEscKeyed");
            onUpKeyed = c(this, "isActive", "open", "_onUpKeyed");
            onDownKeyed = c(this, "isActive", "open", "_onDownKeyed");
            onLeftKeyed = c(this, "isActive", "isOpen", "_onLeftKeyed");
            onRightKeyed = c(this, "isActive", "isOpen", "_onRightKeyed");
            onQueryChanged = c(this, "_openIfActive", "_onQueryChanged");
            onWhitespaceChanged = c(this, "_openIfActive", "_onWhitespaceChanged");
            this.input.bind().onSync("focused", onFocused, this).onSync("blurred", onBlurred, this).onSync("enterKeyed", onEnterKeyed, this).onSync("tabKeyed", onTabKeyed, this).onSync("escKeyed", onEscKeyed, this).onSync("upKeyed", onUpKeyed, this).onSync("downKeyed", onDownKeyed, this).onSync("leftKeyed", onLeftKeyed, this).onSync("rightKeyed", onRightKeyed, this).onSync("queryChanged", onQueryChanged, this).onSync("whitespaceChanged", onWhitespaceChanged, this).onSync("langDirChanged", this._onLangDirChanged, this);
        ***REMOVED***
        _.mixin(Typeahead.prototype, {
            _hacks: function hacks() {
                var $input, $menu;
                $input = this.input.$input || $("<div>");
                $menu = this.menu.$node || $("<div>");
                $input.on("blur.tt", function($e) {
                    var active, isActive, hasActive;
                    active = document.activeElement;
                    isActive = $menu.is(active);
                    hasActive = $menu.has(active).length > 0;
                    if (_.isMsie() && (isActive || hasActive)) {
                        $e.preventDefault();
                        $e.stopImmediatePropagation();
                        _.defer(function() {
                            $input.focus();
                        ***REMOVED***);
                    ***REMOVED***
                ***REMOVED***);
                $menu.on("mousedown.tt", function($e) {
                    $e.preventDefault();
                ***REMOVED***);
            ***REMOVED***,
            _onSelectableClicked: function onSelectableClicked(type, $el) {
                this.select($el);
            ***REMOVED***,
            _onDatasetCleared: function onDatasetCleared() {
                this._updateHint();
            ***REMOVED***,
            _onDatasetRendered: function onDatasetRendered(type, dataset, suggestions, async) {
                this._updateHint();
                this.eventBus.trigger("render", suggestions, async, dataset);
            ***REMOVED***,
            _onAsyncRequested: function onAsyncRequested(type, dataset, query) {
                this.eventBus.trigger("asyncrequest", query, dataset);
            ***REMOVED***,
            _onAsyncCanceled: function onAsyncCanceled(type, dataset, query) {
                this.eventBus.trigger("asynccancel", query, dataset);
            ***REMOVED***,
            _onAsyncReceived: function onAsyncReceived(type, dataset, query) {
                this.eventBus.trigger("asyncreceive", query, dataset);
            ***REMOVED***,
            _onFocused: function onFocused() {
                this._minLengthMet() && this.menu.update(this.input.getQuery());
            ***REMOVED***,
            _onBlurred: function onBlurred() {
                if (this.input.hasQueryChangedSinceLastFocus()) {
                    this.eventBus.trigger("change", this.input.getQuery());
                ***REMOVED***
            ***REMOVED***,
            _onEnterKeyed: function onEnterKeyed(type, $e) {
                var $selectable;
                if ($selectable = this.menu.getActiveSelectable()) {
                    this.select($selectable) && $e.preventDefault();
                ***REMOVED***
            ***REMOVED***,
            _onTabKeyed: function onTabKeyed(type, $e) {
                var $selectable;
                if ($selectable = this.menu.getActiveSelectable()) {
                    this.select($selectable) && $e.preventDefault();
                ***REMOVED*** else if ($selectable = this.menu.getTopSelectable()) {
                    this.autocomplete($selectable) && $e.preventDefault();
                ***REMOVED***
            ***REMOVED***,
            _onEscKeyed: function onEscKeyed() {
                this.close();
            ***REMOVED***,
            _onUpKeyed: function onUpKeyed() {
                this.moveCursor(-1);
            ***REMOVED***,
            _onDownKeyed: function onDownKeyed() {
                this.moveCursor(+1);
            ***REMOVED***,
            _onLeftKeyed: function onLeftKeyed() {
                if (this.dir === "rtl" && this.input.isCursorAtEnd()) {
                    this.autocomplete(this.menu.getTopSelectable());
                ***REMOVED***
            ***REMOVED***,
            _onRightKeyed: function onRightKeyed() {
                if (this.dir === "ltr" && this.input.isCursorAtEnd()) {
                    this.autocomplete(this.menu.getTopSelectable());
                ***REMOVED***
            ***REMOVED***,
            _onQueryChanged: function onQueryChanged(e, query) {
                this._minLengthMet(query) ? this.menu.update(query) : this.menu.empty();
            ***REMOVED***,
            _onWhitespaceChanged: function onWhitespaceChanged() {
                this._updateHint();
            ***REMOVED***,
            _onLangDirChanged: function onLangDirChanged(e, dir) {
                if (this.dir !== dir) {
                    this.dir = dir;
                    this.menu.setLanguageDirection(dir);
                ***REMOVED***
            ***REMOVED***,
            _openIfActive: function openIfActive() {
                this.isActive() && this.open();
            ***REMOVED***,
            _minLengthMet: function minLengthMet(query) {
                query = _.isString(query) ? query : this.input.getQuery() || "";
                return query.length >= this.minLength;
            ***REMOVED***,
            _updateHint: function updateHint() {
                var $selectable, data, val, query, escapedQuery, frontMatchRegEx, match;
                $selectable = this.menu.getTopSelectable();
                data = this.menu.getSelectableData($selectable);
                val = this.input.getInputValue();
                if (data && !_.isBlankString(val) && !this.input.hasOverflow()) {
                    query = Input.normalizeQuery(val);
                    escapedQuery = _.escapeRegExChars(query);
                    frontMatchRegEx = new RegExp("^(?:" + escapedQuery + ")(.+$)", "i");
                    match = frontMatchRegEx.exec(data.val);
                    match && this.input.setHint(val + match[1]);
                ***REMOVED*** else {
                    this.input.clearHint();
                ***REMOVED***
            ***REMOVED***,
            isEnabled: function isEnabled() {
                return this.enabled;
            ***REMOVED***,
            enable: function enable() {
                this.enabled = true;
            ***REMOVED***,
            disable: function disable() {
                this.enabled = false;
            ***REMOVED***,
            isActive: function isActive() {
                return this.active;
            ***REMOVED***,
            activate: function activate() {
                if (this.isActive()) {
                    return true;
                ***REMOVED*** else if (!this.isEnabled() || this.eventBus.before("active")) {
                    return false;
                ***REMOVED*** else {
                    this.active = true;
                    this.eventBus.trigger("active");
                    return true;
                ***REMOVED***
            ***REMOVED***,
            deactivate: function deactivate() {
                if (!this.isActive()) {
                    return true;
                ***REMOVED*** else if (this.eventBus.before("idle")) {
                    return false;
                ***REMOVED*** else {
                    this.active = false;
                    this.close();
                    this.eventBus.trigger("idle");
                    return true;
                ***REMOVED***
            ***REMOVED***,
            isOpen: function isOpen() {
                return this.menu.isOpen();
            ***REMOVED***,
            open: function open() {
                if (!this.isOpen() && !this.eventBus.before("open")) {
                    this.menu.open();
                    this._updateHint();
                    this.eventBus.trigger("open");
                ***REMOVED***
                return this.isOpen();
            ***REMOVED***,
            close: function close() {
                if (this.isOpen() && !this.eventBus.before("close")) {
                    this.menu.close();
                    this.input.clearHint();
                    this.input.resetInputValue();
                    this.eventBus.trigger("close");
                ***REMOVED***
                return !this.isOpen();
            ***REMOVED***,
            setVal: function setVal(val) {
                this.input.setQuery(_.toStr(val));
            ***REMOVED***,
            getVal: function getVal() {
                return this.input.getQuery();
            ***REMOVED***,
            select: function select($selectable) {
                var data = this.menu.getSelectableData($selectable);
                if (data && !this.eventBus.before("select", data.obj)) {
                    this.input.setQuery(data.val, true);
                    this.eventBus.trigger("select", data.obj);
                    this.close();
                    return true;
                ***REMOVED***
                return false;
            ***REMOVED***,
            autocomplete: function autocomplete($selectable) {
                var query, data, isValid;
                query = this.input.getQuery();
                data = this.menu.getSelectableData($selectable);
                isValid = data && query !== data.val;
                if (isValid && !this.eventBus.before("autocomplete", data.obj)) {
                    this.input.setQuery(data.val);
                    this.eventBus.trigger("autocomplete", data.obj);
                    return true;
                ***REMOVED***
                return false;
            ***REMOVED***,
            moveCursor: function moveCursor(delta) {
                var query, $candidate, data, payload, cancelMove;
                query = this.input.getQuery();
                $candidate = this.menu.selectableRelativeToCursor(delta);
                data = this.menu.getSelectableData($candidate);
                payload = data ? data.obj : null;
                cancelMove = this._minLengthMet() && this.menu.update(query);
                if (!cancelMove && !this.eventBus.before("cursorchange", payload)) {
                    this.menu.setCursor($candidate);
                    if (data) {
                        this.input.setInputValue(data.val);
                    ***REMOVED*** else {
                        this.input.resetInputValue();
                        this._updateHint();
                    ***REMOVED***
                    this.eventBus.trigger("cursorchange", payload);
                    return true;
                ***REMOVED***
                return false;
            ***REMOVED***,
            destroy: function destroy() {
                this.input.destroy();
                this.menu.destroy();
            ***REMOVED***
        ***REMOVED***);
        return Typeahead;
        function c(ctx) {
            var methods = [].slice.call(arguments, 1);
            return function() {
                var args = [].slice.call(arguments);
                _.each(methods, function(method) {
                    return ctx[method].apply(ctx, args);
                ***REMOVED***);
            ***REMOVED***;
        ***REMOVED***
    ***REMOVED***();
    (function() {
        "use strict";
        var old, keys, methods;
        old = $.fn.typeahead;
        keys = {
            www: "tt-www",
            attrs: "tt-attrs",
            typeahead: "tt-typeahead"
        ***REMOVED***;
        methods = {
            initialize: function initialize(o, datasets) {
                var www;
                datasets = _.isArray(datasets) ? datasets : [].slice.call(arguments, 1);
                o = o || {***REMOVED***;
                www = WWW(o.classNames);
                return this.each(attach);
                function attach() {
                    var $input, $wrapper, $hint, $menu, defaultHint, defaultMenu, eventBus, input, menu, typeahead, MenuConstructor;
                    _.each(datasets, function(d) {
                        d.highlight = !!o.highlight;
                    ***REMOVED***);
                    $input = $(this);
                    $wrapper = $(www.html.wrapper);
                    $hint = $elOrNull(o.hint);
                    $menu = $elOrNull(o.menu);
                    defaultHint = o.hint !== false && !$hint;
                    defaultMenu = o.menu !== false && !$menu;
                    defaultHint && ($hint = buildHintFromInput($input, www));
                    defaultMenu && ($menu = $(www.html.menu).css(www.css.menu));
                    $hint && $hint.val("");
                    $input = prepInput($input, www);
                    if (defaultHint || defaultMenu) {
                        $wrapper.css(www.css.wrapper);
                        $input.css(defaultHint ? www.css.input : www.css.inputWithNoHint);
                        $input.wrap($wrapper).parent().prepend(defaultHint ? $hint : null).append(defaultMenu ? $menu : null);
                    ***REMOVED***
                    MenuConstructor = defaultMenu ? DefaultMenu : Menu;
                    eventBus = new EventBus({
                        el: $input
                    ***REMOVED***);
                    input = new Input({
                        hint: $hint,
                        input: $input
                    ***REMOVED***, www);
                    menu = new MenuConstructor({
                        node: $menu,
                        datasets: datasets
                    ***REMOVED***, www);
                    typeahead = new Typeahead({
                        input: input,
                        menu: menu,
                        eventBus: eventBus,
                        minLength: o.minLength
                    ***REMOVED***, www);
                    $input.data(keys.www, www);
                    $input.data(keys.typeahead, typeahead);
                ***REMOVED***
            ***REMOVED***,
            isEnabled: function isEnabled() {
                var enabled;
                ttEach(this.first(), function(t) {
                    enabled = t.isEnabled();
                ***REMOVED***);
                return enabled;
            ***REMOVED***,
            enable: function enable() {
                ttEach(this, function(t) {
                    t.enable();
                ***REMOVED***);
                return this;
            ***REMOVED***,
            disable: function disable() {
                ttEach(this, function(t) {
                    t.disable();
                ***REMOVED***);
                return this;
            ***REMOVED***,
            isActive: function isActive() {
                var active;
                ttEach(this.first(), function(t) {
                    active = t.isActive();
                ***REMOVED***);
                return active;
            ***REMOVED***,
            activate: function activate() {
                ttEach(this, function(t) {
                    t.activate();
                ***REMOVED***);
                return this;
            ***REMOVED***,
            deactivate: function deactivate() {
                ttEach(this, function(t) {
                    t.deactivate();
                ***REMOVED***);
                return this;
            ***REMOVED***,
            isOpen: function isOpen() {
                var open;
                ttEach(this.first(), function(t) {
                    open = t.isOpen();
                ***REMOVED***);
                return open;
            ***REMOVED***,
            open: function open() {
                ttEach(this, function(t) {
                    t.open();
                ***REMOVED***);
                return this;
            ***REMOVED***,
            close: function close() {
                ttEach(this, function(t) {
                    t.close();
                ***REMOVED***);
                return this;
            ***REMOVED***,
            select: function select(el) {
                var success = false, $el = $(el);
                ttEach(this.first(), function(t) {
                    success = t.select($el);
                ***REMOVED***);
                return success;
            ***REMOVED***,
            autocomplete: function autocomplete(el) {
                var success = false, $el = $(el);
                ttEach(this.first(), function(t) {
                    success = t.autocomplete($el);
                ***REMOVED***);
                return success;
            ***REMOVED***,
            moveCursor: function moveCursoe(delta) {
                var success = false;
                ttEach(this.first(), function(t) {
                    success = t.moveCursor(delta);
                ***REMOVED***);
                return success;
            ***REMOVED***,
            val: function val(newVal) {
                var query;
                if (!arguments.length) {
                    ttEach(this.first(), function(t) {
                        query = t.getVal();
                    ***REMOVED***);
                    return query;
                ***REMOVED*** else {
                    ttEach(this, function(t) {
                        t.setVal(newVal);
                    ***REMOVED***);
                    return this;
                ***REMOVED***
            ***REMOVED***,
            destroy: function destroy() {
                ttEach(this, function(typeahead, $input) {
                    revert($input);
                    typeahead.destroy();
                ***REMOVED***);
                return this;
            ***REMOVED***
        ***REMOVED***;
        $.fn.typeahead = function(method) {
            if (methods[method]) {
                return methods[method].apply(this, [].slice.call(arguments, 1));
            ***REMOVED*** else {
                return methods.initialize.apply(this, arguments);
            ***REMOVED***
        ***REMOVED***;
        $.fn.typeahead.noConflict = function noConflict() {
            $.fn.typeahead = old;
            return this;
        ***REMOVED***;
        function ttEach($els, fn) {
            $els.each(function() {
                var $input = $(this), typeahead;
                (typeahead = $input.data(keys.typeahead)) && fn(typeahead, $input);
            ***REMOVED***);
        ***REMOVED***
        function buildHintFromInput($input, www) {
            return $input.clone().addClass(www.classes.hint).removeData().css(www.css.hint).css(getBackgroundStyles($input)).prop("readonly", true).removeAttr("id name placeholder required").attr({
                autocomplete: "off",
                spellcheck: "false",
                tabindex: -1
            ***REMOVED***);
        ***REMOVED***
        function prepInput($input, www) {
            $input.data(keys.attrs, {
                dir: $input.attr("dir"),
                autocomplete: $input.attr("autocomplete"),
                spellcheck: $input.attr("spellcheck"),
                style: $input.attr("style")
            ***REMOVED***);
            $input.addClass(www.classes.input).attr({
                autocomplete: "off",
                spellcheck: false
            ***REMOVED***);
            try {
                !$input.attr("dir") && $input.attr("dir", "auto");
            ***REMOVED*** catch (e) {***REMOVED***
            return $input;
        ***REMOVED***
        function getBackgroundStyles($el) {
            return {
                backgroundAttachment: $el.css("background-attachment"),
                backgroundClip: $el.css("background-clip"),
                backgroundColor: $el.css("background-color"),
                backgroundImage: $el.css("background-image"),
                backgroundOrigin: $el.css("background-origin"),
                backgroundPosition: $el.css("background-position"),
                backgroundRepeat: $el.css("background-repeat"),
                backgroundSize: $el.css("background-size")
            ***REMOVED***;
        ***REMOVED***
        function revert($input) {
            var www, $wrapper;
            www = $input.data(keys.www);
            $wrapper = $input.parent().filter(www.selectors.wrapper);
            _.each($input.data(keys.attrs), function(val, key) {
                _.isUndefined(val) ? $input.removeAttr(key) : $input.attr(key, val);
            ***REMOVED***);
            $input.removeData(keys.typeahead).removeData(keys.www).removeData(keys.attr).removeClass(www.classes.input);
            if ($wrapper.length) {
                $input.detach().insertAfter($wrapper);
                $wrapper.remove();
            ***REMOVED***
        ***REMOVED***
        function $elOrNull(obj) {
            var isValid, $el;
            isValid = _.isJQuery(obj) || _.isElement(obj);
            $el = isValid ? $(obj).first() : [];
            return $el.length ? $el : null;
        ***REMOVED***
    ***REMOVED***)();
***REMOVED***);