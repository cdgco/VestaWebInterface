/**
 * Represents a jQuery wizard plugin.
 *
 * @class steps
 * @constructor
 * @param [method={***REMOVED***] The name of the method as `String` or an JSON object for initialization
 * @param [params=]* {Array***REMOVED*** Additional arguments for a method call
 * @chainable
 **/
$.fn.steps = function (method)
{
    if ($.fn.steps[method])
    {
        return $.fn.steps[method].apply(this, Array.prototype.slice.call(arguments, 1));
    ***REMOVED***
    else if (typeof method === "object" || !method)
    {
        return initialize.apply(this, arguments);
    ***REMOVED***
    else
    {
        $.error("Method " + method + " does not exist on jQuery.steps");
    ***REMOVED***
***REMOVED***;

/**
 * Adds a new step.
 *
 * @method add
 * @param step {Object***REMOVED*** The step object to add
 * @chainable
 **/
$.fn.steps.add = function (step)
{
    var state = getState(this);
    return insertStep(this, getOptions(this), state, state.stepCount, step);
***REMOVED***;

/**
 * Removes the control functionality completely and transforms the current state to the initial HTML structure.
 *
 * @method destroy
 * @chainable
 **/
$.fn.steps.destroy = function ()
{
    return destroy(this, getOptions(this));
***REMOVED***;

/**
 * Triggers the onFinishing and onFinished event.
 *
 * @method finish
 **/
$.fn.steps.finish = function ()
{
    finishStep(this, getState(this));
***REMOVED***;

/**
 * Gets the current step index.
 *
 * @method getCurrentIndex
 * @return {Integer***REMOVED*** The actual step index (zero-based)
 * @for steps
 **/
$.fn.steps.getCurrentIndex = function ()
{
    return getState(this).currentIndex;
***REMOVED***;

/**
 * Gets the current step object.
 *
 * @method getCurrentStep
 * @return {Object***REMOVED*** The actual step object
 **/
$.fn.steps.getCurrentStep = function ()
{
    return getStep(this, getState(this).currentIndex);
***REMOVED***;

/**
 * Gets a specific step object by index.
 *
 * @method getStep
 * @param index {Integer***REMOVED*** An integer that belongs to the position of a step
 * @return {Object***REMOVED*** A specific step object
 **/
$.fn.steps.getStep = function (index)
{
    return getStep(this, index);
***REMOVED***;

/**
 * Inserts a new step to a specific position.
 *
 * @method insert
 * @param index {Integer***REMOVED*** The position (zero-based) to add
 * @param step {Object***REMOVED*** The step object to add
 * @example
 *     $("#wizard").steps().insert(0, {
 *         title: "Title",
 *         content: "", // optional
 *         contentMode: "async", // optional
 *         contentUrl: "/Content/Step/1" // optional
 *     ***REMOVED***);
 * @chainable
 **/
$.fn.steps.insert = function (index, step)
{
    return insertStep(this, getOptions(this), getState(this), index, step);
***REMOVED***;

/**
 * Routes to the next step.
 *
 * @method next
 * @return {Boolean***REMOVED*** Indicates whether the action executed
 **/
$.fn.steps.next = function ()
{
    return goToNextStep(this, getOptions(this), getState(this));
***REMOVED***;

/**
 * Routes to the previous step.
 *
 * @method previous
 * @return {Boolean***REMOVED*** Indicates whether the action executed
 **/
$.fn.steps.previous = function ()
{
    return goToPreviousStep(this, getOptions(this), getState(this));
***REMOVED***;

/**
 * Removes a specific step by an given index.
 *
 * @method remove
 * @param index {Integer***REMOVED*** The position (zero-based) of the step to remove
 * @return Indecates whether the item is removed.
 **/
$.fn.steps.remove = function (index)
{
    return removeStep(this, getOptions(this), getState(this), index);
***REMOVED***;

/**
 * Sets a specific step object by index.
 *
 * @method setStep
 * @param index {Integer***REMOVED*** An integer that belongs to the position of a step
 * @param step {Object***REMOVED*** The step object to change
 **/
$.fn.steps.setStep = function (index, step)
{
    throw new Error("Not yet implemented!");
***REMOVED***;

/**
 * Skips an certain amount of steps.
 *
 * @method skip
 * @param count {Integer***REMOVED*** The amount of steps that should be skipped
 * @return {Boolean***REMOVED*** Indicates whether the action executed
 **/
$.fn.steps.skip = function (count)
{
    throw new Error("Not yet implemented!");
***REMOVED***;