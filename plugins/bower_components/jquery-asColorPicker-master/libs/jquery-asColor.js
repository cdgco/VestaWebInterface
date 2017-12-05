/*! asColor - v0.2.1 - 2014-08-27
* https://github.com/amazingSurge/asColor
* Copyright (c) 2014 amazingSurge; Licensed GPL */
(function(window, document, $, undefined) {
    'use strict';

    function expandHex(hex) {
        if (!hex) {
            return null;
        ***REMOVED***
        if (hex.length === 3) {
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        ***REMOVED***
        return hex.length === 6 ? hex : null;
    ***REMOVED***

    function shrinkHex(hex) {
        if (hex.length === 6 && hex[0] === hex[1] && hex[2] === hex[3] && hex[4] === hex[5]) {
            return hex[0] + hex[2] + hex[4];
        ***REMOVED*** else {
            return hex;
        ***REMOVED***
    ***REMOVED***

    function parseIntFromHex(val) {
        return parseInt(val, 16);
    ***REMOVED***

    function isPercentage(n) {
        return typeof n === 'string' && n.indexOf('%') != -1;
    ***REMOVED***

    function conventPercentageToRgb(n) {
        return parseInt(n.slice(0, -1) * 2.55, 10);
    ***REMOVED***

    function convertPercentageToFloat(n) {
        return parseFloat(n.slice(0, -1) / 100, 10);
    ***REMOVED***

    function flip(o) {
        var flipped = {***REMOVED***;
        for (var i in o) {
            if (o.hasOwnProperty(i)) {
                flipped[o[i]] = i;
            ***REMOVED***
        ***REMOVED***
        return flipped;
    ***REMOVED***

    var CssColorStrings = (function() {
        var CSS_INTEGER = '[-\\+]?\\d+%?';
        var CSS_NUMBER = '[-\\+]?\\d*\\.\\d+%?';
        var CSS_UNIT = '(?:' + CSS_NUMBER + ')|(?:' + CSS_INTEGER + ')';

        var PERMISSIVE_MATCH3 = '[\\s|\\(]+(' + CSS_UNIT + ')[,|\\s]+(' + CSS_UNIT + ')[,|\\s]+(' + CSS_UNIT + ')\\s*\\)';
        var PERMISSIVE_MATCH4 = '[\\s|\\(]+(' + CSS_UNIT + ')[,|\\s]+(' + CSS_UNIT + ')[,|\\s]+(' + CSS_UNIT + ')[,|\\s]+(' + CSS_UNIT + ')\\s*\\)';

        return {
            RGB: {
                match: new RegExp('^rgb' + PERMISSIVE_MATCH3 +'$', 'i'),
                parse: function(result) {
                    return {
                        r: isPercentage(result[1]) ? conventPercentageToRgb(result[1]) : parseInt(result[1], 10),
                        g: isPercentage(result[2]) ? conventPercentageToRgb(result[2]) : parseInt(result[2], 10),
                        b: isPercentage(result[3]) ? conventPercentageToRgb(result[3]) : parseInt(result[3], 10),
                        a: 1
                    ***REMOVED***;
                ***REMOVED***,
                to: function(color) {
                    return 'rgb(' + color.r + ', ' + color.g + ', ' + color.b + ')';
                ***REMOVED***
            ***REMOVED***,
            RGBA: {
                match: new RegExp('^rgba' + PERMISSIVE_MATCH4 +'$', 'i'),
                parse: function(result) {
                    return {
                        r: isPercentage(result[1]) ? conventPercentageToRgb(result[1]) : parseInt(result[1], 10),
                        g: isPercentage(result[2]) ? conventPercentageToRgb(result[2]) : parseInt(result[2], 10),
                        b: isPercentage(result[3]) ? conventPercentageToRgb(result[3]) : parseInt(result[3], 10),
                        a: parseFloat(result[4])
                    ***REMOVED***;
                ***REMOVED***,
                to: function(color) {
                    return 'rgba(' + color.r + ', ' + color.g + ', ' + color.b + ', ' + color.a + ')';
                ***REMOVED***
            ***REMOVED***,
            HSL: {
                match: new RegExp('^hsl' + PERMISSIVE_MATCH3 +'$', 'i'),
                parse: function(result) {
                    var hsl = {
                        h: ((result[1] % 360) + 360) % 360,
                        s: isPercentage(result[2]) ? convertPercentageToFloat(result[2]) : parseFloat(result[2], 10),
                        l: isPercentage(result[3]) ? convertPercentageToFloat(result[3]) : parseFloat(result[3], 10),
                        a: 1
                    ***REMOVED***;

                    return AsColor.HSLToRGB(hsl);
                ***REMOVED***,
                to: function(color) {
                    var hsl = AsColor.RGBToHSL(color);
                    return 'hsl(' + parseInt(hsl.h, 10) + ', ' + Math.round(hsl.s * 100) + '%, ' + Math.round(hsl.l * 100) + '%)';
                ***REMOVED***
            ***REMOVED***,
            HSLA: {
                match: new RegExp('^hsla' + PERMISSIVE_MATCH4 +'$', 'i'),
                parse: function(result) {
                    var hsla = {
                        h: ((result[1] % 360) + 360) % 360,
                        s: isPercentage(result[2]) ? convertPercentageToFloat(result[2]) : parseFloat(result[2], 10),
                        l: isPercentage(result[3]) ? convertPercentageToFloat(result[3]) : parseFloat(result[3], 10),
                        a: parseFloat(result[4])
                    ***REMOVED***;

                    return AsColor.HSLToRGB(hsla);
                ***REMOVED***,
                to: function(color) {
                    var hsl = AsColor.RGBToHSL(color);
                    return 'hsla(' + parseInt(hsl.h, 10) + ', ' + Math.round(hsl.s * 100) + '%, ' + Math.round(hsl.l * 100) + '%, ' + color.a + ')';
                ***REMOVED***
            ***REMOVED***,
            HEX: {
                match: /^#([a-f0-9]{6***REMOVED***|[a-f0-9]{3***REMOVED***)$/i,
                parse: function(result) {
                    var hex = result[1], rgb = AsColor.HEXtoRGB(hex);
                    return {
                        r: rgb.r,
                        g: rgb.g,
                        b: rgb.b,
                        a: 1
                    ***REMOVED***;
                ***REMOVED***,
                to: function(color, instance) {
                    var hex = [color.r.toString(16), color.g.toString(16), color.b.toString(16)];
                    $.each(hex, function(nr, val) {
                        if (val.length === 1) {
                            hex[nr] = '0' + val;
                        ***REMOVED***
                    ***REMOVED***);
                    hex = hex.join('');
                    if (instance) {
                        if (instance.options.hexUseName) {
                            var hasName = AsColor.hasNAME(color);
                            if (hasName) {
                                return hasName;
                            ***REMOVED***
                        ***REMOVED***
                        if (instance.options.shortenHex) {
                            hex = shrinkHex(hex);
                        ***REMOVED***
                    ***REMOVED***
                    return '#' + hex;
                ***REMOVED***
            ***REMOVED***,
            TRANSPARENT: {
                match: /^transparent$/i,
                parse: function() {
                    return {
                        r: 0,
                        g: 0,
                        b: 0,
                        a: 0
                    ***REMOVED***;
                ***REMOVED***,
                to: function() {
                    return 'transparent';
                ***REMOVED***
            ***REMOVED***,
            NAME: {
                match: /^\w+$/i,
                parse: function(result) {
                    var rgb = AsColor.NAMEtoRGB(result[0]);
                    if(rgb) {
                        return {
                            r: rgb.r,
                            g: rgb.g,
                            b: rgb.b,
                            a: 1
                        ***REMOVED***;
                    ***REMOVED***
                ***REMOVED***,
                to: function(color, instance) {
                    return AsColor.RGBtoNAME(color, instance ? instance.options.nameDegradation : undefined);
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***;
    ***REMOVED***)();

    var AsColor = $.asColor = function(string, options) {
        if (typeof string === 'object' && typeof options === 'undefined') {
            options = string;
            string = undefined;
        ***REMOVED***
        if(typeof options === 'string'){
            options = {
                format: options
            ***REMOVED***;
        ***REMOVED***
        this.options = $.extend(true, {***REMOVED***, AsColor.defaults, options);
        this.value = {
            r: 0,
            g: 0,
            b: 0,
            h: 0,
            s: 0,
            v: 0,
            a: 1
        ***REMOVED***;
        this._format = false;
        this._matchFormat = 'HEX';
        this._valid = true;

        this.init(string);
    ***REMOVED***;

    AsColor.prototype = {
        constructor: AsColor,
        init: function(string) {
            this.format(this.options.format);         
            this.fromString(string);
        ***REMOVED***,
        isValid: function() {
            return this._valid;
        ***REMOVED***,
        val: function(value) {
            if (typeof value === 'undefined') {
                return this.toString();
            ***REMOVED*** else {
                this.fromString(value);
                return this;
            ***REMOVED***
        ***REMOVED***,
        alpha: function(value) {
            if (typeof value === 'undefined' || isNaN(value)) {
                return this.value.a;
            ***REMOVED*** else {
                value = parseFloat(value);

                if (value > 1) {
                    value = 1;
                ***REMOVED*** else if (value < 0) {
                    value = 0;
                ***REMOVED***
                this.value.a = value;
            ***REMOVED***
        ***REMOVED***,
        matchString: function(string){
            return AsColor.matchString(string);
        ***REMOVED***,
        fromString: function(string, updateFormat) {
            if (typeof string === 'string') {
                string = $.trim(string);
                var matched = null,
                    rgb;
                this._valid = false;
                for (var i in CssColorStrings) {
                    if ((matched = CssColorStrings[i].match.exec(string)) != null) {
                        rgb = CssColorStrings[i].parse(matched);

                        if (rgb) {
                            this.set(rgb);
                            if(i === 'TRANSPARENT'){
                                i = 'HEX';
                            ***REMOVED***
                            this._matchFormat = i;
                            if (updateFormat === true) {
                                this.format(i);
                            ***REMOVED***
                            break;
                        ***REMOVED***
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED*** else if (typeof string === 'object') {
                this.set(string);
            ***REMOVED***
        ***REMOVED***,
        format: function(format) {
            if (typeof format === 'string' && (format = format.toUpperCase()) && typeof CssColorStrings[format] !== 'undefined') {
                if (format !== 'TRANSPARENT') {
                    this._format = format;
                ***REMOVED*** else {
                    this._format = 'HEX';
                ***REMOVED***
            ***REMOVED*** else if(format === false) {
                this._format = false;
            ***REMOVED*** else {
                if(this._format === false){
                    return this._matchFormat;
                ***REMOVED*** else {
                    return this._format;
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***,
        toRGBA: function() {
            return CssColorStrings.RGBA.to(this.value, this);
        ***REMOVED***,
        toRGB: function() {
            return CssColorStrings.RGB.to(this.value, this);
        ***REMOVED***,
        toHSLA: function() {
            return CssColorStrings.HSLA.to(this.value, this);
        ***REMOVED***,
        toHSL: function() {
            return CssColorStrings.HSL.to(this.value, this);
        ***REMOVED***,
        toHEX: function() {
            return CssColorStrings.HEX.to(this.value, this);
        ***REMOVED***,
        toNAME: function() {
            return CssColorStrings.NAME.to(this.value, this);
        ***REMOVED***,
        to: function(format) {
            if (typeof format === 'string' && (format = format.toUpperCase()) && typeof CssColorStrings[format] !== 'undefined') {
                return CssColorStrings[format].to(this.value, this);
            ***REMOVED***
            return this.toString();
        ***REMOVED***,
        toString: function() {
            var value = this.value;
            if (!this._valid) {
                value = this.options.invalidValue;

                if (typeof value === 'string') {
                    return value;
                ***REMOVED***
            ***REMOVED***

            if (value.a === 0 && this.options.zeroAlphaAsTransparent) {
                return CssColorStrings.TRANSPARENT.to(value, this);
            ***REMOVED***

            var format;
            if(this._format === false){
                format = this._matchFormat;
            ***REMOVED*** else {
                format = this._format;
            ***REMOVED***

            if (this.options.reduceAlpha && value.a === 1) {
                switch (format) {
                    case 'RGBA':
                        format = 'RGB';
                        break;
                    case 'HSLA':
                        format = 'HSL';
                        break;
                ***REMOVED***
            ***REMOVED***

            if (value.a !== 1 && format!=='RGBA' && format !=='HSLA' && this.options.alphaConvert){
                if(typeof this.options.alphaConvert === 'string'){
                    format = this.options.alphaConvert;
                ***REMOVED***
                if(typeof this.options.alphaConvert[format] !== 'undefined'){
                    format = this.options.alphaConvert[format];
                ***REMOVED***
            ***REMOVED***
            return CssColorStrings[format].to(value, this);
        ***REMOVED***,
        get: function() {
            return this.value;
        ***REMOVED***,
        set: function(color) {
            this._valid = true;
            var fromRgb = 0,
                fromHsv = 0,
                hsv,
                rgb;

            for (var i in color) {
                if ('hsv'.indexOf(i) !== -1) {
                    fromHsv++;
                    this.value[i] = color[i];
                ***REMOVED*** else if ('rgb'.indexOf(i) !== -1) {
                    fromRgb++;
                    this.value[i] = color[i];
                ***REMOVED*** else if (i === 'a') {
                    this.value.a = color.a;
                ***REMOVED***
            ***REMOVED***
            if (fromRgb > fromHsv) {
                hsv = AsColor.RGBtoHSV(this.value);
                if (this.value.r === 0 && this.value.g === 0 && this.value.b === 0) {
                    // this.value.h = color.h;
                ***REMOVED*** else {
                    this.value.h = hsv.h;
                ***REMOVED***

                this.value.s = hsv.s;
                this.value.v = hsv.v;
            ***REMOVED*** else if (fromHsv > fromRgb) {
                rgb = AsColor.HSVtoRGB(this.value);
                this.value.r = rgb.r;
                this.value.g = rgb.g;
                this.value.b = rgb.b;
            ***REMOVED***
        ***REMOVED***
    ***REMOVED***;
    AsColor.HSLToRGB = function(hsl) {
        var h = hsl.h / 360,
            s = hsl.s,
            l = hsl.l,
            m1, m2, rgb;
        if (l <= 0.5) {
            m2 = l * (s + 1);
        ***REMOVED*** else {
            m2 = l + s - (l * s);
        ***REMOVED***
        m1 = l * 2 - m2;
        rgb = {
            r: AsColor.hueToRGB(m1, m2, h + 1 / 3),
            g: AsColor.hueToRGB(m1, m2, h),
            b: AsColor.hueToRGB(m1, m2, h - 1 / 3)
        ***REMOVED***;
        if (typeof hsl.a !== 'undefined') {
            rgb.a = hsl.a;
        ***REMOVED***
        if (hsl.l === 0) {
            rgb.h = hsl.h;
        ***REMOVED***
        return rgb;
    ***REMOVED***;
    AsColor.hueToRGB = function(m1, m2, h) {
        var v;
        if (h < 0) {
            h = h + 1;
        ***REMOVED*** else if (h > 1) {
            h = h - 1;
        ***REMOVED***
        if ((h * 6) < 1) {
            v = m1 + (m2 - m1) * h * 6;
        ***REMOVED*** else if ((h * 2) < 1) {
            v = m2;
        ***REMOVED*** else if ((h * 3) < 2) {
            v = m1 + (m2 - m1) * (2 / 3 - h) * 6;
        ***REMOVED*** else {
            v = m1;
        ***REMOVED***
        return Math.round(v * 255);
    ***REMOVED***;
    AsColor.RGBToHSL = function(rgb) {
        var r = rgb.r / 255,
            g = rgb.g / 255,
            b = rgb.b / 255,
            min = Math.min(r, g, b),
            max = Math.max(r, g, b),
            diff = max - min,
            add = max + min,
            l = add * 0.5,
            h, s;

        if (min === max) {
            h = 0;
        ***REMOVED*** else if (r === max) {
            h = (60 * (g - b) / diff) + 360;
        ***REMOVED*** else if (g === max) {
            h = (60 * (b - r) / diff) + 120;
        ***REMOVED*** else {
            h = (60 * (r - g) / diff) + 240;
        ***REMOVED***
        if (diff === 0) {
            s = 0;
        ***REMOVED*** else if (l <= 0.5) {
            s = diff / add;
        ***REMOVED*** else {
            s = diff / (2 - add);
        ***REMOVED***

        return {
            h: Math.round(h) % 360,
            s: s,
            l: l
        ***REMOVED***;
    ***REMOVED***;
    AsColor.RGBToHEX = function(rgb) {
        return CssColorStrings.HEX.to(rgb);
    ***REMOVED***;
    AsColor.HSLToHEX = function(hsl) {
        var rgb = AsColor.HSLToRGB(hsl);
        return CssColorStrings.HEX.to(rgb);
    ***REMOVED***;
    AsColor.HSVtoHEX = function(hsv) {
        var rgb = AsColor.HSVtoRGB(hsv);
        return CssColorStrings.HEX.to(rgb);
    ***REMOVED***;
    AsColor.RGBtoHSV = function(rgb) {
        var r = rgb.r / 255,
            g = rgb.g / 255,
            b = rgb.b / 255,
            max = Math.max(r, g, b),
            min = Math.min(r, g, b),
            h, s, v = max,
            diff = max - min;
        s = (max === 0) ? 0 : diff / max;
        if (max === min) {
            h = 0;
        ***REMOVED*** else {
            switch (max) {
                case r:
                    h = (g - b) / diff + (g < b ? 6 : 0);
                    break;
                case g:
                    h = (b - r) / diff + 2;
                    break;
                case b:
                    h = (r - g) / diff + 4;
                    break;
            ***REMOVED***
            h /= 6;
        ***REMOVED***

        return {
            h: Math.round(h * 360),
            s: s,
            v: v
        ***REMOVED***;
    ***REMOVED***;
    AsColor.HSVtoRGB = function(hsv) {
        var r, g, b, h = (hsv.h % 360) / 60,
            s = hsv.s,
            v = hsv.v,
            c = v * s,
            x = c * (1 - Math.abs(h % 2 - 1));

        r = g = b = v - c;
        h = ~~h;

        r += [c, x, 0, 0, x, c][h];
        g += [x, c, c, x, 0, 0][h];
        b += [0, 0, x, c, c, x][h];

        return {
            r: Math.round(r * 255),
            g: Math.round(g * 255),
            b: Math.round(b * 255)
        ***REMOVED***;
    ***REMOVED***;
    AsColor.HEXtoRGB = function(hex) {
        if (hex.indexOf('#') === 0) {
            hex = hex.substr(1);
        ***REMOVED***
        if (hex.length === 3) {
            hex = expandHex(hex);
        ***REMOVED***
        return {
            r: parseIntFromHex(hex.substr(0, 2)),
            g: parseIntFromHex(hex.substr(2, 2)),
            b: parseIntFromHex(hex.substr(4, 2))
        ***REMOVED***;
    ***REMOVED***;
    AsColor.isNAME = function(string) {
        if (AsColor.names.hasOwnProperty(string)) {
            return true;
        ***REMOVED*** else {
            return false;
        ***REMOVED***
    ***REMOVED***;
    AsColor.NAMEtoHEX = function(name) {
        if (AsColor.names.hasOwnProperty(name)) {
            return '#' + AsColor.names[name];
        ***REMOVED***
    ***REMOVED***;
    AsColor.NAMEtoRGB = function(name) {
        var hex = AsColor.NAMEtoHEX(name);
        if (hex) {
            return AsColor.HEXtoRGB(hex);
        ***REMOVED***
    ***REMOVED***;
    AsColor.hasNAME = function(rgb) {
        var hex = AsColor.RGBToHEX(rgb);

        if (hex.indexOf('#') === 0) {
            hex = hex.substr(1);
        ***REMOVED***
        hex = shrinkHex(hex);

        if (AsColor.hexNames.hasOwnProperty(hex)) {
            return AsColor.hexNames[hex];
        ***REMOVED*** else {
            return false;
        ***REMOVED***
    ***REMOVED***,
    AsColor.RGBtoNAME = function(rgb, degradation) {
        var hasName = AsColor.hasNAME(rgb);
        if (hasName) {
            return hasName;
        ***REMOVED*** else {
            if (typeof degradation === 'undefined') {
                degradation = AsColor.defaults.nameDegradation;
            ***REMOVED***
            return CssColorStrings[degradation.toUpperCase()].to(rgb);
        ***REMOVED***
    ***REMOVED***;

    AsColor.matchString = function(string){
        if (typeof string === 'string') {
            string = $.trim(string);
            var matched = null,
                rgb;
            for (var i in CssColorStrings) {
                if ((matched = CssColorStrings[i].match.exec(string)) != null) {
                    rgb = CssColorStrings[i].parse(matched);

                    if (rgb) {
                        return true;
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***
        return false;
    ***REMOVED***;
    AsColor.defaults = {
        format: false,
        shortenHex: false,
        hexUseName: false,
        reduceAlpha: false,
        alphaConvert: { // or false will disable convert
            'RGB': 'RGBA',
            'HSL': 'HSLA',
            'HEX': 'RGBA',
            'NAME': 'RGBA',
        ***REMOVED***,
        nameDegradation: 'HEX',
        invalidValue: '',
        zeroAlphaAsTransparent: true
    ***REMOVED***;
    AsColor.names = {
        aliceblue: 'f0f8ff',
        antiquewhite: 'faebd7',
        aqua: '0ff',
        aquamarine: '7fffd4',
        azure: 'f0ffff',
        beige: 'f5f5dc',
        bisque: 'ffe4c4',
        black: '000',
        blanchedalmond: 'ffebcd',
        blue: '00f',
        blueviolet: '8a2be2',
        brown: 'a52a2a',
        burlywood: 'deb887',
        burntsienna: 'ea7e5d',
        cadetblue: '5f9ea0',
        chartreuse: '7fff00',
        chocolate: 'd2691e',
        coral: 'ff7f50',
        cornflowerblue: '6495ed',
        cornsilk: 'fff8dc',
        crimson: 'dc143c',
        cyan: '0ff',
        darkblue: '00008b',
        darkcyan: '008b8b',
        darkgoldenrod: 'b8860b',
        darkgray: 'a9a9a9',
        darkgreen: '006400',
        darkgrey: 'a9a9a9',
        darkkhaki: 'bdb76b',
        darkmagenta: '8b008b',
        darkolivegreen: '556b2f',
        darkorange: 'ff8c00',
        darkorchid: '9932cc',
        darkred: '8b0000',
        darksalmon: 'e9967a',
        darkseagreen: '8fbc8f',
        darkslateblue: '483d8b',
        darkslategray: '2f4f4f',
        darkslategrey: '2f4f4f',
        darkturquoise: '00ced1',
        darkviolet: '9400d3',
        deeppink: 'ff1493',
        deepskyblue: '00bfff',
        dimgray: '696969',
        dimgrey: '696969',
        dodgerblue: '1e90ff',
        firebrick: 'b22222',
        floralwhite: 'fffaf0',
        forestgreen: '228b22',
        fuchsia: 'f0f',
        gainsboro: 'dcdcdc',
        ghostwhite: 'f8f8ff',
        gold: 'ffd700',
        goldenrod: 'daa520',
        gray: '808080',
        green: '008000',
        greenyellow: 'adff2f',
        grey: '808080',
        honeydew: 'f0fff0',
        hotpink: 'ff69b4',
        indianred: 'cd5c5c',
        indigo: '4b0082',
        ivory: 'fffff0',
        khaki: 'f0e68c',
        lavender: 'e6e6fa',
        lavenderblush: 'fff0f5',
        lawngreen: '7cfc00',
        lemonchiffon: 'fffacd',
        lightblue: 'add8e6',
        lightcoral: 'f08080',
        lightcyan: 'e0ffff',
        lightgoldenrodyellow: 'fafad2',
        lightgray: 'd3d3d3',
        lightgreen: '90ee90',
        lightgrey: 'd3d3d3',
        lightpink: 'ffb6c1',
        lightsalmon: 'ffa07a',
        lightseagreen: '20b2aa',
        lightskyblue: '87cefa',
        lightslategray: '789',
        lightslategrey: '789',
        lightsteelblue: 'b0c4de',
        lightyellow: 'ffffe0',
        lime: '0f0',
        limegreen: '32cd32',
        linen: 'faf0e6',
        magenta: 'f0f',
        maroon: '800000',
        mediumaquamarine: '66cdaa',
        mediumblue: '0000cd',
        mediumorchid: 'ba55d3',
        mediumpurple: '9370db',
        mediumseagreen: '3cb371',
        mediumslateblue: '7b68ee',
        mediumspringgreen: '00fa9a',
        mediumturquoise: '48d1cc',
        mediumvioletred: 'c71585',
        midnightblue: '191970',
        mintcream: 'f5fffa',
        mistyrose: 'ffe4e1',
        moccasin: 'ffe4b5',
        navajowhite: 'ffdead',
        navy: '000080',
        oldlace: 'fdf5e6',
        olive: '808000',
        olivedrab: '6b8e23',
        orange: 'ffa500',
        orangered: 'ff4500',
        orchid: 'da70d6',
        palegoldenrod: 'eee8aa',
        palegreen: '98fb98',
        paleturquoise: 'afeeee',
        palevioletred: 'db7093',
        papayawhip: 'ffefd5',
        peachpuff: 'ffdab9',
        peru: 'cd853f',
        pink: 'ffc0cb',
        plum: 'dda0dd',
        powderblue: 'b0e0e6',
        purple: '800080',
        red: 'f00',
        rosybrown: 'bc8f8f',
        royalblue: '4169e1',
        saddlebrown: '8b4513',
        salmon: 'fa8072',
        sandybrown: 'f4a460',
        seagreen: '2e8b57',
        seashell: 'fff5ee',
        sienna: 'a0522d',
        silver: 'c0c0c0',
        skyblue: '87ceeb',
        slateblue: '6a5acd',
        slategray: '708090',
        slategrey: '708090',
        snow: 'fffafa',
        springgreen: '00ff7f',
        steelblue: '4682b4',
        tan: 'd2b48c',
        teal: '008080',
        thistle: 'd8bfd8',
        tomato: 'ff6347',
        turquoise: '40e0d0',
        violet: 'ee82ee',
        wheat: 'f5deb3',
        white: 'fff',
        whitesmoke: 'f5f5f5',
        yellow: 'ff0',
        yellowgreen: '9acd32'
    ***REMOVED***;
    AsColor.hexNames = flip(AsColor.names);
***REMOVED***(window, document, jQuery));
