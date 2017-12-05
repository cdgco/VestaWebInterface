/*
 *  Bootstrap TouchSpin - v3.0.1
 *  A mobile and touch friendly input spinner component for Bootstrap 3.
 *  http://www.virtuosoft.eu/code/bootstrap-touchspin/
 *
 *  Made by István Ujj-Mészáros
 *  Under Apache License v2.0 License
 */
(function($) {
  'use strict';

  var _currentSpinnerId = 0;

  function _scopedEventName(name, id) {
    return name + '.touchspin_' + id;
  ***REMOVED***

  function _scopeEventNames(names, id) {
    return $.map(names, function(name) {
      return _scopedEventName(name, id);
    ***REMOVED***);
  ***REMOVED***

  $.fn.TouchSpin = function(options) {

    if (options === 'destroy') {
      this.each(function() {
        var originalinput = $(this),
            originalinput_data = originalinput.data();
        $(document).off(_scopeEventNames([
          'mouseup',
          'touchend',
          'touchcancel',
          'mousemove',
          'touchmove',
          'scroll',
          'scrollstart'], originalinput_data.spinnerid).join(' '));
      ***REMOVED***);
      return;
    ***REMOVED***

    var defaults = {
      min: 0,
      max: 100,
      initval: '',
      step: 1,
      decimals: 0,
      stepinterval: 100,
      forcestepdivisibility: 'round', // none | floor | round | ceil
      stepintervaldelay: 500,
      verticalbuttons: false,
      verticalupclass: 'glyphicon glyphicon-chevron-up',
      verticaldownclass: 'glyphicon glyphicon-chevron-down',
      prefix: '',
      postfix: '',
      prefix_extraclass: '',
      postfix_extraclass: '',
      booster: true,
      boostat: 10,
      maxboostedstep: false,
      mousewheel: true,
      buttondown_class: 'btn btn-default',
      buttonup_class: 'btn btn-default'
    ***REMOVED***;

    var attributeMap = {
      min: 'min',
      max: 'max',
      initval: 'init-val',
      step: 'step',
      decimals: 'decimals',
      stepinterval: 'step-interval',
      verticalbuttons: 'vertical-buttons',
      verticalupclass: 'vertical-up-class',
      verticaldownclass: 'vertical-down-class',
      forcestepdivisibility: 'force-step-divisibility',
      stepintervaldelay: 'step-interval-delay',
      prefix: 'prefix',
      postfix: 'postfix',
      prefix_extraclass: 'prefix-extra-class',
      postfix_extraclass: 'postfix-extra-class',
      booster: 'booster',
      boostat: 'boostat',
      maxboostedstep: 'max-boosted-step',
      mousewheel: 'mouse-wheel',
      buttondown_class: 'button-down-class',
      buttonup_class: 'button-up-class'
    ***REMOVED***;

    return this.each(function() {

      var settings,
          originalinput = $(this),
          originalinput_data = originalinput.data(),
          container,
          elements,
          value,
          downSpinTimer,
          upSpinTimer,
          downDelayTimeout,
          upDelayTimeout,
          spincount = 0,
          spinning = false;

      init();


      function init() {
        if (originalinput.data('alreadyinitialized')) {
          return;
        ***REMOVED***

        originalinput.data('alreadyinitialized', true);
        _currentSpinnerId += 1;
        originalinput.data('spinnerid', _currentSpinnerId);


        if (!originalinput.is('input')) {
          console.log('Must be an input.');
          return;
        ***REMOVED***

        _initSettings();
        _setInitval();
        _checkValue();
        _buildHtml();
        _initElements();
        _hideEmptyPrefixPostfix();
        _bindEvents();
        _bindEventsInterface();
        elements.input.css('display', 'block');
      ***REMOVED***

      function _setInitval() {
        if (settings.initval !== '' && originalinput.val() === '') {
          originalinput.val(settings.initval);
        ***REMOVED***
      ***REMOVED***

      function changeSettings(newsettings) {
        _updateSettings(newsettings);
        _checkValue();

        var value = elements.input.val();

        if (value !== '') {
          value = Number(elements.input.val());
          elements.input.val(value.toFixed(settings.decimals));
        ***REMOVED***
      ***REMOVED***

      function _initSettings() {
        settings = $.extend({***REMOVED***, defaults, originalinput_data, _parseAttributes(), options);
      ***REMOVED***

      function _parseAttributes() {
        var data = {***REMOVED***;
        $.each(attributeMap, function(key, value) {
          var attrName = 'bts-' + value + '';
          if (originalinput.is('[data-' + attrName + ']')) {
            data[key] = originalinput.data(attrName);
          ***REMOVED***
        ***REMOVED***);
        return data;
      ***REMOVED***

      function _updateSettings(newsettings) {
        settings = $.extend({***REMOVED***, settings, newsettings);
      ***REMOVED***

      function _buildHtml() {
        var initval = originalinput.val(),
            parentelement = originalinput.parent();

        if (initval !== '') {
          initval = Number(initval).toFixed(settings.decimals);
        ***REMOVED***

        originalinput.data('initvalue', initval).val(initval);
        originalinput.addClass('form-control');

        if (parentelement.hasClass('input-group')) {
          _advanceInputGroup(parentelement);
        ***REMOVED***
        else {
          _buildInputGroup();
        ***REMOVED***
      ***REMOVED***

      function _advanceInputGroup(parentelement) {
        parentelement.addClass('bootstrap-touchspin');

        var prev = originalinput.prev(),
            next = originalinput.next();

        var downhtml,
            uphtml,
            prefixhtml = '<span class="input-group-addon bootstrap-touchspin-prefix">' + settings.prefix + '</span>',
            postfixhtml = '<span class="input-group-addon bootstrap-touchspin-postfix">' + settings.postfix + '</span>';

        if (prev.hasClass('input-group-btn')) {
          downhtml = '<button class="' + settings.buttondown_class + ' bootstrap-touchspin-down" type="button">-</button>';
          prev.append(downhtml);
        ***REMOVED***
        else {
          downhtml = '<span class="input-group-btn"><button class="' + settings.buttondown_class + ' bootstrap-touchspin-down" type="button">-</button></span>';
          $(downhtml).insertBefore(originalinput);
        ***REMOVED***

        if (next.hasClass('input-group-btn')) {
          uphtml = '<button class="' + settings.buttonup_class + ' bootstrap-touchspin-up" type="button">+</button>';
          next.prepend(uphtml);
        ***REMOVED***
        else {
          uphtml = '<span class="input-group-btn"><button class="' + settings.buttonup_class + ' bootstrap-touchspin-up" type="button">+</button></span>';
          $(uphtml).insertAfter(originalinput);
        ***REMOVED***

        $(prefixhtml).insertBefore(originalinput);
        $(postfixhtml).insertAfter(originalinput);

        container = parentelement;
      ***REMOVED***

      function _buildInputGroup() {
        var html;

        if (settings.verticalbuttons) {
          html = '<div class="input-group bootstrap-touchspin"><span class="input-group-addon bootstrap-touchspin-prefix">' + settings.prefix + '</span><span class="input-group-addon bootstrap-touchspin-postfix">' + settings.postfix + '</span><span class="input-group-btn-vertical"><button class="' + settings.buttondown_class + ' bootstrap-touchspin-up" type="button"><i class="' + settings.verticalupclass + '"></i></button><button class="' + settings.buttonup_class + ' bootstrap-touchspin-down" type="button"><i class="' + settings.verticaldownclass + '"></i></button></span></div>';
        ***REMOVED***
        else {
          html = '<div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="' + settings.buttondown_class + ' bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix">' + settings.prefix + '</span><span class="input-group-addon bootstrap-touchspin-postfix">' + settings.postfix + '</span><span class="input-group-btn"><button class="' + settings.buttonup_class + ' bootstrap-touchspin-up" type="button">+</button></span></div>';
        ***REMOVED***

        container = $(html).insertBefore(originalinput);

        $('.bootstrap-touchspin-prefix', container).after(originalinput);

        if (originalinput.hasClass('input-sm')) {
          container.addClass('input-group-sm');
        ***REMOVED***
        else if (originalinput.hasClass('input-lg')) {
          container.addClass('input-group-lg');
        ***REMOVED***
      ***REMOVED***

      function _initElements() {
        elements = {
          down: $('.bootstrap-touchspin-down', container),
          up: $('.bootstrap-touchspin-up', container),
          input: $('input', container),
          prefix: $('.bootstrap-touchspin-prefix', container).addClass(settings.prefix_extraclass),
          postfix: $('.bootstrap-touchspin-postfix', container).addClass(settings.postfix_extraclass)
        ***REMOVED***;
      ***REMOVED***

      function _hideEmptyPrefixPostfix() {
        if (settings.prefix === '') {
          elements.prefix.hide();
        ***REMOVED***

        if (settings.postfix === '') {
          elements.postfix.hide();
        ***REMOVED***
      ***REMOVED***

      function _bindEvents() {
        originalinput.on('keydown', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 38) {
            if (spinning !== 'up') {
              upOnce();
              startUpSpin();
            ***REMOVED***
            ev.preventDefault();
          ***REMOVED***
          else if (code === 40) {
            if (spinning !== 'down') {
              downOnce();
              startDownSpin();
            ***REMOVED***
            ev.preventDefault();
          ***REMOVED***
        ***REMOVED***);

        originalinput.on('keyup', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 38) {
            stopSpin();
          ***REMOVED***
          else if (code === 40) {
            stopSpin();
          ***REMOVED***
        ***REMOVED***);

        originalinput.on('blur', function() {
          _checkValue();
        ***REMOVED***);

        elements.down.on('keydown', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            if (spinning !== 'down') {
              downOnce();
              startDownSpin();
            ***REMOVED***
            ev.preventDefault();
          ***REMOVED***
        ***REMOVED***);

        elements.down.on('keyup', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            stopSpin();
          ***REMOVED***
        ***REMOVED***);

        elements.up.on('keydown', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            if (spinning !== 'up') {
              upOnce();
              startUpSpin();
            ***REMOVED***
            ev.preventDefault();
          ***REMOVED***
        ***REMOVED***);

        elements.up.on('keyup', function(ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            stopSpin();
          ***REMOVED***
        ***REMOVED***);

        elements.down.on('mousedown.touchspin', function(ev) {
          elements.down.off('touchstart.touchspin');  // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          ***REMOVED***

          downOnce();
          startDownSpin();

          ev.preventDefault();
          ev.stopPropagation();
        ***REMOVED***);

        elements.down.on('touchstart.touchspin', function(ev) {
          elements.down.off('mousedown.touchspin');  // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          ***REMOVED***

          downOnce();
          startDownSpin();

          ev.preventDefault();
          ev.stopPropagation();
        ***REMOVED***);

        elements.up.on('mousedown.touchspin', function(ev) {
          elements.up.off('touchstart.touchspin');  // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          ***REMOVED***

          upOnce();
          startUpSpin();

          ev.preventDefault();
          ev.stopPropagation();
        ***REMOVED***);

        elements.up.on('touchstart.touchspin', function(ev) {
          elements.up.off('mousedown.touchspin');  // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          ***REMOVED***

          upOnce();
          startUpSpin();

          ev.preventDefault();
          ev.stopPropagation();
        ***REMOVED***);

        elements.up.on('mouseout touchleave touchend touchcancel', function(ev) {
          if (!spinning) {
            return;
          ***REMOVED***

          ev.stopPropagation();
          stopSpin();
        ***REMOVED***);

        elements.down.on('mouseout touchleave touchend touchcancel', function(ev) {
          if (!spinning) {
            return;
          ***REMOVED***

          ev.stopPropagation();
          stopSpin();
        ***REMOVED***);

        elements.down.on('mousemove touchmove', function(ev) {
          if (!spinning) {
            return;
          ***REMOVED***

          ev.stopPropagation();
          ev.preventDefault();
        ***REMOVED***);

        elements.up.on('mousemove touchmove', function(ev) {
          if (!spinning) {
            return;
          ***REMOVED***

          ev.stopPropagation();
          ev.preventDefault();
        ***REMOVED***);

        $(document).on(_scopeEventNames(['mouseup', 'touchend', 'touchcancel'], _currentSpinnerId).join(' '), function(ev) {
          if (!spinning) {
            return;
          ***REMOVED***

          ev.preventDefault();
          stopSpin();
        ***REMOVED***);

        $(document).on(_scopeEventNames(['mousemove', 'touchmove', 'scroll', 'scrollstart'], _currentSpinnerId).join(' '), function(ev) {
          if (!spinning) {
            return;
          ***REMOVED***

          ev.preventDefault();
          stopSpin();
        ***REMOVED***);

        originalinput.on('mousewheel DOMMouseScroll', function(ev) {
          if (!settings.mousewheel || !originalinput.is(':focus')) {
            return;
          ***REMOVED***

          var delta = ev.originalEvent.wheelDelta || -ev.originalEvent.deltaY || -ev.originalEvent.detail;

          ev.stopPropagation();
          ev.preventDefault();

          if (delta < 0) {
            downOnce();
          ***REMOVED***
          else {
            upOnce();
          ***REMOVED***
        ***REMOVED***);
      ***REMOVED***

      function _bindEventsInterface() {
        originalinput.on('touchspin.uponce', function() {
          stopSpin();
          upOnce();
        ***REMOVED***);

        originalinput.on('touchspin.downonce', function() {
          stopSpin();
          downOnce();
        ***REMOVED***);

        originalinput.on('touchspin.startupspin', function() {
          startUpSpin();
        ***REMOVED***);

        originalinput.on('touchspin.startdownspin', function() {
          startDownSpin();
        ***REMOVED***);

        originalinput.on('touchspin.stopspin', function() {
          stopSpin();
        ***REMOVED***);

        originalinput.on('touchspin.updatesettings', function(e, newsettings) {
          changeSettings(newsettings);
        ***REMOVED***);
      ***REMOVED***

      function _forcestepdivisibility(value) {
        switch (settings.forcestepdivisibility) {
          case 'round':
            return (Math.round(value / settings.step) * settings.step).toFixed(settings.decimals);
          case 'floor':
            return (Math.floor(value / settings.step) * settings.step).toFixed(settings.decimals);
          case 'ceil':
            return (Math.ceil(value / settings.step) * settings.step).toFixed(settings.decimals);
          default:
            return value;
        ***REMOVED***
      ***REMOVED***

      function _checkValue() {
        var val, parsedval, returnval;

        val = originalinput.val();

        if (val === '') {
          return;
        ***REMOVED***

        if (settings.decimals > 0 && val === '.') {
          return;
        ***REMOVED***

        parsedval = parseFloat(val);

        if (isNaN(parsedval)) {
          parsedval = 0;
        ***REMOVED***

        returnval = parsedval;

        if (parsedval.toString() !== val) {
          returnval = parsedval;
        ***REMOVED***

        if (parsedval < settings.min) {
          returnval = settings.min;
        ***REMOVED***

        if (parsedval > settings.max) {
          returnval = settings.max;
        ***REMOVED***

        returnval = _forcestepdivisibility(returnval);

        if (Number(val).toString() !== returnval.toString()) {
          originalinput.val(returnval);
          originalinput.trigger('change');
        ***REMOVED***
      ***REMOVED***

      function _getBoostedStep() {
        if (!settings.booster) {
          return settings.step;
        ***REMOVED***
        else {
          var boosted = Math.pow(2, Math.floor(spincount / settings.boostat)) * settings.step;

          if (settings.maxboostedstep) {
            if (boosted > settings.maxboostedstep) {
              boosted = settings.maxboostedstep;
              value = Math.round((value / boosted)) * boosted;
            ***REMOVED***
          ***REMOVED***

          return Math.max(settings.step, boosted);
        ***REMOVED***
      ***REMOVED***

      function upOnce() {
        _checkValue();

        value = parseFloat(elements.input.val());
        if (isNaN(value)) {
          value = 0;
        ***REMOVED***

        var initvalue = value,
            boostedstep = _getBoostedStep();

        value = value + boostedstep;

        if (value > settings.max) {
          value = settings.max;
          originalinput.trigger('touchspin.on.max');
          stopSpin();
        ***REMOVED***

        elements.input.val(Number(value).toFixed(settings.decimals));

        if (initvalue !== value) {
          originalinput.trigger('change');
        ***REMOVED***
      ***REMOVED***

      function downOnce() {
        _checkValue();

        value = parseFloat(elements.input.val());
        if (isNaN(value)) {
          value = 0;
        ***REMOVED***

        var initvalue = value,
            boostedstep = _getBoostedStep();

        value = value - boostedstep;

        if (value < settings.min) {
          value = settings.min;
          originalinput.trigger('touchspin.on.min');
          stopSpin();
        ***REMOVED***

        elements.input.val(value.toFixed(settings.decimals));

        if (initvalue !== value) {
          originalinput.trigger('change');
        ***REMOVED***
      ***REMOVED***

      function startDownSpin() {
        stopSpin();

        spincount = 0;
        spinning = 'down';

        originalinput.trigger('touchspin.on.startspin');
        originalinput.trigger('touchspin.on.startdownspin');

        downDelayTimeout = setTimeout(function() {
          downSpinTimer = setInterval(function() {
            spincount++;
            downOnce();
          ***REMOVED***, settings.stepinterval);
        ***REMOVED***, settings.stepintervaldelay);
      ***REMOVED***

      function startUpSpin() {
        stopSpin();

        spincount = 0;
        spinning = 'up';

        originalinput.trigger('touchspin.on.startspin');
        originalinput.trigger('touchspin.on.startupspin');

        upDelayTimeout = setTimeout(function() {
          upSpinTimer = setInterval(function() {
            spincount++;
            upOnce();
          ***REMOVED***, settings.stepinterval);
        ***REMOVED***, settings.stepintervaldelay);
      ***REMOVED***

      function stopSpin() {
        clearTimeout(downDelayTimeout);
        clearTimeout(upDelayTimeout);
        clearInterval(downSpinTimer);
        clearInterval(upSpinTimer);

        switch (spinning) {
          case 'up':
            originalinput.trigger('touchspin.on.stopupspin');
            originalinput.trigger('touchspin.on.stopspin');
            break;
          case 'down':
            originalinput.trigger('touchspin.on.stopdownspin');
            originalinput.trigger('touchspin.on.stopspin');
            break;
        ***REMOVED***

        spincount = 0;
        spinning = false;
      ***REMOVED***

    ***REMOVED***);

  ***REMOVED***;

***REMOVED***)(jQuery);
