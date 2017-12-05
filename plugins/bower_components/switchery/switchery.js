/**
 * Switchery 0.8.1
 * http://abpetkov.github.io/switchery/
 *
 * Authored by Alexander Petkov
 * https://github.com/abpetkov
 *
 * Copyright 2013-2015, Alexander Petkov
 * License: The MIT License (MIT)
 * http://opensource.org/licenses/MIT
 *
 */

/**
 * External dependencies.
 */

var transitionize = require('transitionize')
  , fastclick = require('fastclick')
  , classes = require('classes')
  , events = require('events');

/**
 * Expose `Switchery`.
 */

module.exports = Switchery;

/**
 * Set Switchery default values.
 *
 * @api public
 */

var defaults = {
    color             : '#64bd63'
  , secondaryColor    : '#dfdfdf'
  , jackColor         : '#fff'
  , jackSecondaryColor: null
  , className         : 'switchery'
  , disabled          : false
  , disabledOpacity   : 0.5
  , speed             : '0.4s'
  , size              : 'default'
***REMOVED***;

/**
 * Create Switchery object.
 *
 * @param {Object***REMOVED*** element
 * @param {Object***REMOVED*** options
 * @api public
 */

function Switchery(element, options) {
  if (!(this instanceof Switchery)) return new Switchery(element, options);

  this.element = element;
  this.options = options || {***REMOVED***;

  for (var i in defaults) {
    if (this.options[i] == null) {
      this.options[i] = defaults[i];
    ***REMOVED***
  ***REMOVED***

  if (this.element != null && this.element.type == 'checkbox') this.init();
  if (this.isDisabled() === true) this.disable();
***REMOVED***

/**
 * Hide the target element.
 *
 * @api private
 */

Switchery.prototype.hide = function() {
  this.element.style.display = 'none';
***REMOVED***;

/**
 * Show custom switch after the target element.
 *
 * @api private
 */

Switchery.prototype.show = function() {
  var switcher = this.create();
  this.insertAfter(this.element, switcher);
***REMOVED***;

/**
 * Create custom switch.
 *
 * @returns {Object***REMOVED*** this.switcher
 * @api private
 */

Switchery.prototype.create = function() {
  this.switcher = document.createElement('span');
  this.jack = document.createElement('small');
  this.switcher.appendChild(this.jack);
  this.switcher.className = this.options.className;
  this.events = events(this.switcher, this);

  return this.switcher;
***REMOVED***;

/**
 * Insert after element after another element.
 *
 * @param {Object***REMOVED*** reference
 * @param {Object***REMOVED*** target
 * @api private
 */

Switchery.prototype.insertAfter = function(reference, target) {
  reference.parentNode.insertBefore(target, reference.nextSibling);
***REMOVED***;

/**
 * Set switch jack proper position.
 *
 * @param {Boolean***REMOVED*** clicked - we need this in order to uncheck the input when the switch is clicked
 * @api private
 */

Switchery.prototype.setPosition = function (clicked) {
  var checked = this.isChecked()
    , switcher = this.switcher
    , jack = this.jack;

  if (clicked && checked) checked = false;
  else if (clicked && !checked) checked = true;

  if (checked === true) {
    this.element.checked = true;

    if (window.getComputedStyle) jack.style.left = parseInt(window.getComputedStyle(switcher).width) - parseInt(window.getComputedStyle(jack).width) + 'px';
    else jack.style.left = parseInt(switcher.currentStyle['width']) - parseInt(jack.currentStyle['width']) + 'px';

    if (this.options.color) this.colorize();
    this.setSpeed();
  ***REMOVED*** else {
    jack.style.left = 0;
    this.element.checked = false;
    this.switcher.style.boxShadow = 'inset 0 0 0 0 ' + this.options.secondaryColor;
    this.switcher.style.borderColor = this.options.secondaryColor;
    this.switcher.style.backgroundColor = (this.options.secondaryColor !== defaults.secondaryColor) ? this.options.secondaryColor : '#fff';
    this.jack.style.backgroundColor = (this.options.jackSecondaryColor !== this.options.jackColor) ? this.options.jackSecondaryColor : this.options.jackColor;
    this.setSpeed();
  ***REMOVED***
***REMOVED***;

/**
 * Set speed.
 *
 * @api private
 */

Switchery.prototype.setSpeed = function() {
  var switcherProp = {***REMOVED***
    , jackProp = {
        'background-color': this.options.speed
      , 'left': this.options.speed.replace(/[a-z]/, '') / 2 + 's'
    ***REMOVED***;

  if (this.isChecked()) {
    switcherProp = {
        'border': this.options.speed
      , 'box-shadow': this.options.speed
      , 'background-color': this.options.speed.replace(/[a-z]/, '') * 3 + 's'
    ***REMOVED***;
  ***REMOVED*** else {
    switcherProp = {
        'border': this.options.speed
      , 'box-shadow': this.options.speed
    ***REMOVED***;
  ***REMOVED***

  transitionize(this.switcher, switcherProp);
  transitionize(this.jack, jackProp);
***REMOVED***;

/**
 * Set switch size.
 *
 * @api private
 */

Switchery.prototype.setSize = function() {
  var small = 'switchery-small'
    , normal = 'switchery-default'
    , large = 'switchery-large';

  switch (this.options.size) {
    case 'small':
      classes(this.switcher).add(small)
      break;
    case 'large':
      classes(this.switcher).add(large)
      break;
    default:
      classes(this.switcher).add(normal)
      break;
  ***REMOVED***
***REMOVED***;

/**
 * Set switch color.
 *
 * @api private
 */

Switchery.prototype.colorize = function() {
  var switcherHeight = this.switcher.offsetHeight / 2;

  this.switcher.style.backgroundColor = this.options.color;
  this.switcher.style.borderColor = this.options.color;
  this.switcher.style.boxShadow = 'inset 0 0 0 ' + switcherHeight + 'px ' + this.options.color;
  this.jack.style.backgroundColor = this.options.jackColor;
***REMOVED***;

/**
 * Handle the onchange event.
 *
 * @param {Boolean***REMOVED*** state
 * @api private
 */

Switchery.prototype.handleOnchange = function(state) {
  if (document.dispatchEvent) {
    var event = document.createEvent('HTMLEvents');
    event.initEvent('change', true, true);
    this.element.dispatchEvent(event);
  ***REMOVED*** else {
    this.element.fireEvent('onchange');
  ***REMOVED***
***REMOVED***;

/**
 * Handle the native input element state change.
 * A `change` event must be fired in order to detect the change.
 *
 * @api private
 */

Switchery.prototype.handleChange = function() {
  var self = this
    , el = this.element;

  if (el.addEventListener) {
    el.addEventListener('change', function() {
      self.setPosition();
    ***REMOVED***);
  ***REMOVED*** else {
    el.attachEvent('onchange', function() {
      self.setPosition();
    ***REMOVED***);
  ***REMOVED***
***REMOVED***;

/**
 * Handle the switch click event.
 *
 * @api private
 */

Switchery.prototype.handleClick = function() {
  var switcher = this.switcher;

  fastclick(switcher);
  this.events.bind('click', 'bindClick');
***REMOVED***;

/**
 * Attach all methods that need to happen on switcher click.
 *
 * @api private
 */

Switchery.prototype.bindClick = function() {
  var parent = this.element.parentNode.tagName.toLowerCase()
    , labelParent = (parent === 'label') ? false : true;

  this.setPosition(labelParent);
  this.handleOnchange(this.element.checked);
***REMOVED***;

/**
 * Mark an individual switch as already handled.
 *
 * @api private
 */

Switchery.prototype.markAsSwitched = function() {
  this.element.setAttribute('data-switchery', true);
***REMOVED***;

/**
 * Check if an individual switch is already handled.
 *
 * @api private
 */

Switchery.prototype.markedAsSwitched = function() {
  return this.element.getAttribute('data-switchery');
***REMOVED***;

/**
 * Initialize Switchery.
 *
 * @api private
 */

Switchery.prototype.init = function() {
  this.hide();
  this.show();
  this.setSize();
  this.setPosition();
  this.markAsSwitched();
  this.handleChange();
  this.handleClick();
***REMOVED***;

/**
 * See if input is checked.
 *
 * @returns {Boolean***REMOVED***
 * @api public
 */

Switchery.prototype.isChecked = function() {
  return this.element.checked;
***REMOVED***;

/**
 * See if switcher should be disabled.
 *
 * @returns {Boolean***REMOVED***
 * @api public
 */

Switchery.prototype.isDisabled = function() {
  return this.options.disabled || this.element.disabled || this.element.readOnly;
***REMOVED***;

/**
 * Destroy all event handlers attached to the switch.
 *
 * @api public
 */

Switchery.prototype.destroy = function() {
  this.events.unbind();
***REMOVED***;

/**
 * Enable disabled switch element.
 *
 * @api public
 */

Switchery.prototype.enable = function() {
  if (this.options.disabled) this.options.disabled = false;
  if (this.element.disabled) this.element.disabled = false;
  if (this.element.readOnly) this.element.readOnly = false;
  this.switcher.style.opacity = 1;
  this.events.bind('click', 'bindClick');
***REMOVED***;

/**
 * Disable switch element.
 *
 * @api public
 */

Switchery.prototype.disable = function() {
  if (!this.options.disabled) this.options.disabled = true;
  if (!this.element.disabled) this.element.disabled = true;
  if (!this.element.readOnly) this.element.readOnly = true;
  this.switcher.style.opacity = this.options.disabledOpacity;
  this.destroy();
***REMOVED***;
