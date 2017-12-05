/**
 * A global unique id count.
 *
 * @static
 * @private
 * @property _uniqueId
 * @type Integer
 **/
var _uniqueId = 0;

/**
 * The plugin prefix for cookies.
 *
 * @final
 * @private
 * @property _cookiePrefix
 * @type String
 **/
var _cookiePrefix = "jQu3ry_5teps_St@te_";

/**
 * Suffix for the unique tab id.
 *
 * @final
 * @private
 * @property _tabSuffix
 * @type String
 * @since 0.9.7
 **/
var _tabSuffix = "-t-";

/**
 * Suffix for the unique tabpanel id.
 *
 * @final
 * @private
 * @property _tabpanelSuffix
 * @type String
 * @since 0.9.7
 **/
var _tabpanelSuffix = "-p-";

/**
 * Suffix for the unique title id.
 *
 * @final
 * @private
 * @property _titleSuffix
 * @type String
 * @since 0.9.7
 **/
var _titleSuffix = "-h-";

/**
 * An error message for an "index out of range" error.
 *
 * @final
 * @private
 * @property _indexOutOfRangeErrorMessage
 * @type String
 **/
var _indexOutOfRangeErrorMessage = "Index out of range.";

/**
 * An error message for an "missing corresponding element" error.
 *
 * @final
 * @private
 * @property _missingCorrespondingElementErrorMessage
 * @type String
 **/
var _missingCorrespondingElementErrorMessage = "One or more corresponding step {0***REMOVED*** are missing.";

/**
 * Adds a step to the cache.
 *
 * @static
 * @private
 * @method addStepToCache
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param step {Object***REMOVED*** The step object to add
 **/
function addStepToCache(wizard, step)
{
    getSteps(wizard).push(step);
***REMOVED***

function analyzeData(wizard, options, state)
{
    var stepTitles = wizard.children(options.headerTag),
        stepContents = wizard.children(options.bodyTag);

    // Validate content
    if (stepTitles.length > stepContents.length)
    {
        throwError(_missingCorrespondingElementErrorMessage, "contents");
    ***REMOVED***
    else if (stepTitles.length < stepContents.length)
    {
        throwError(_missingCorrespondingElementErrorMessage, "titles");
    ***REMOVED***
        
    var startIndex = options.startIndex;

    state.stepCount = stepTitles.length;

    // Tries to load the saved state (step position)
    if (options.saveState && $.cookie)
    {
        var savedState = $.cookie(_cookiePrefix + getUniqueId(wizard));
        // Sets the saved position to the start index if not undefined or out of range 
        var savedIndex = parseInt(savedState, 0);
        if (!isNaN(savedIndex) && savedIndex < state.stepCount)
        {
            startIndex = savedIndex;
        ***REMOVED***
    ***REMOVED***

    state.currentIndex = startIndex;

    stepTitles.each(function (index)
    {
        var item = $(this), // item == header
            content = stepContents.eq(index),
            modeData = content.data("mode"),
            mode = (modeData == null) ? contentMode.html : getValidEnumValue(contentMode,
                (/^\s*$/.test(modeData) || isNaN(modeData)) ? modeData : parseInt(modeData, 0)),
            contentUrl = (mode === contentMode.html || content.data("url") === undefined) ?
                "" : content.data("url"),
            contentLoaded = (mode !== contentMode.html && content.data("loaded") === "1"),
            step = $.extend({***REMOVED***, stepModel, {
                title: item.html(),
                content: (mode === contentMode.html) ? content.html() : "",
                contentUrl: contentUrl,
                contentMode: mode,
                contentLoaded: contentLoaded
            ***REMOVED***);

        addStepToCache(wizard, step);
    ***REMOVED***);
***REMOVED***

/**
 * Triggers the onCanceled event.
 *
 * @static
 * @private
 * @method cancel
 * @param wizard {Object***REMOVED*** The jQuery wizard object
 **/
function cancel(wizard)
{
    wizard.triggerHandler("canceled");
***REMOVED***

function decreaseCurrentIndexBy(state, decreaseBy)
{
    return state.currentIndex - decreaseBy;
***REMOVED***

/**
 * Removes the control functionality completely and transforms the current state to the initial HTML structure.
 *
 * @static
 * @private
 * @method destroy
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 **/
function destroy(wizard, options)
{
    var eventNamespace = getEventNamespace(wizard);

    // Remove virtual data objects from the wizard
    wizard.unbind(eventNamespace).removeData("uid").removeData("options")
        .removeData("state").removeData("steps").removeData("eventNamespace")
        .find(".actions a").unbind(eventNamespace);

    // Remove attributes and CSS classes from the wizard
    wizard.removeClass(options.clearFixCssClass + " vertical");

    var contents = wizard.find(".content > *");

    // Remove virtual data objects from panels and their titles
    contents.removeData("loaded").removeData("mode").removeData("url");

    // Remove attributes, CSS classes and reset inline styles on all panels and their titles
    contents.removeAttr("id").removeAttr("role").removeAttr("tabindex")
        .removeAttr("class").removeAttr("style")._removeAria("labelledby")
        ._removeAria("hidden");

    // Empty panels if the mode is set to 'async' or 'iframe'
    wizard.find(".content > [data-mode='async'],.content > [data-mode='iframe']").empty();

    var wizardSubstitute = $("<{0***REMOVED*** class=\"{1***REMOVED***\"></{0***REMOVED***>".format(wizard.get(0).tagName, wizard.attr("class")));

    var wizardId = wizard._id();
    if (wizardId != null && wizardId !== "")
    {
        wizardSubstitute._id(wizardId);
    ***REMOVED***

    wizardSubstitute.html(wizard.find(".content").html());
    wizard.after(wizardSubstitute);
    wizard.remove();

    return wizardSubstitute;
***REMOVED***

/**
 * Triggers the onFinishing and onFinished event.
 *
 * @static
 * @private
 * @method finishStep
 * @param wizard {Object***REMOVED*** The jQuery wizard object
 * @param state {Object***REMOVED*** The state container of the current wizard
 **/
function finishStep(wizard, state)
{
    var currentStep = wizard.find(".steps li").eq(state.currentIndex);

    if (wizard.triggerHandler("finishing", [state.currentIndex]))
    {
        currentStep.addClass("done").removeClass("error");
        wizard.triggerHandler("finished", [state.currentIndex]);
    ***REMOVED***
    else
    {
        currentStep.addClass("error");
    ***REMOVED***
***REMOVED***

/**
 * Gets or creates if not exist an unique event namespace for the given wizard instance.
 *
 * @static
 * @private
 * @method getEventNamespace
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @return {String***REMOVED*** Returns the unique event namespace for the given wizard
 */
function getEventNamespace(wizard)
{
    var eventNamespace = wizard.data("eventNamespace");

    if (eventNamespace == null)
    {
        eventNamespace = "." + getUniqueId(wizard);
        wizard.data("eventNamespace", eventNamespace);
    ***REMOVED***

    return eventNamespace;
***REMOVED***

function getStepAnchor(wizard, index)
{
    var uniqueId = getUniqueId(wizard);

    return wizard.find("#" + uniqueId + _tabSuffix + index);
***REMOVED***

function getStepPanel(wizard, index)
{
    var uniqueId = getUniqueId(wizard);

    return wizard.find("#" + uniqueId + _tabpanelSuffix + index);
***REMOVED***

function getStepTitle(wizard, index)
{
    var uniqueId = getUniqueId(wizard);

    return wizard.find("#" + uniqueId + _titleSuffix + index);
***REMOVED***

function getOptions(wizard)
{
    return wizard.data("options");
***REMOVED***

function getState(wizard)
{
    return wizard.data("state");
***REMOVED***

function getSteps(wizard)
{
    return wizard.data("steps");
***REMOVED***

/**
 * Gets a specific step object by index.
 *
 * @static
 * @private
 * @method getStep
 * @param index {Integer***REMOVED*** An integer that belongs to the position of a step
 * @return {Object***REMOVED*** A specific step object
 **/
function getStep(wizard, index)
{
    var steps = getSteps(wizard);

    if (index < 0 || index >= steps.length)
    {
        throwError(_indexOutOfRangeErrorMessage);
    ***REMOVED***

    return steps[index];
***REMOVED***

/**
 * Gets or creates if not exist an unique id from the given wizard instance.
 *
 * @static
 * @private
 * @method getUniqueId
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @return {String***REMOVED*** Returns the unique id for the given wizard
 */
function getUniqueId(wizard)
{
    var uniqueId = wizard.data("uid");

    if (uniqueId == null)
    {
        uniqueId = wizard._id();
        if (uniqueId == null)
        {
            uniqueId = "steps-uid-".concat(_uniqueId);
            wizard._id(uniqueId);
        ***REMOVED***

        _uniqueId++;
        wizard.data("uid", uniqueId);
    ***REMOVED***

    return uniqueId;
***REMOVED***

/**
 * Gets a valid enum value by checking a specific enum key or value.
 * 
 * @static
 * @private
 * @method getValidEnumValue
 * @param enumType {Object***REMOVED*** Type of enum
 * @param keyOrValue {Object***REMOVED*** Key as `String` or value as `Integer` to check for
 */
function getValidEnumValue(enumType, keyOrValue)
{
    validateArgument("enumType", enumType);
    validateArgument("keyOrValue", keyOrValue);

    // Is key
    if (typeof keyOrValue === "string")
    {
        var value = enumType[keyOrValue];
        if (value === undefined)
        {
            throwError("The enum key '{0***REMOVED***' does not exist.", keyOrValue);
        ***REMOVED***

        return value;
    ***REMOVED***
    // Is value
    else if (typeof keyOrValue === "number")
    {
        for (var key in enumType)
        {
            if (enumType[key] === keyOrValue)
            {
                return keyOrValue;
            ***REMOVED***
        ***REMOVED***

        throwError("Invalid enum value '{0***REMOVED***'.", keyOrValue);
    ***REMOVED***
    // Type is not supported
    else
    {
        throwError("Invalid key or value type.");
    ***REMOVED***
***REMOVED***

/**
 * Routes to the next step.
 *
 * @static
 * @private
 * @method goToNextStep
 * @param wizard {Object***REMOVED*** The jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 * @return {Boolean***REMOVED*** Indicates whether the action executed
 **/
function goToNextStep(wizard, options, state)
{
    return paginationClick(wizard, options, state, increaseCurrentIndexBy(state, 1));
***REMOVED***

/**
 * Routes to the previous step.
 *
 * @static
 * @private
 * @method goToPreviousStep
 * @param wizard {Object***REMOVED*** The jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 * @return {Boolean***REMOVED*** Indicates whether the action executed
 **/
function goToPreviousStep(wizard, options, state)
{
    return paginationClick(wizard, options, state, decreaseCurrentIndexBy(state, 1));
***REMOVED***

/**
 * Routes to a specific step by a given index.
 *
 * @static
 * @private
 * @method goToStep
 * @param wizard {Object***REMOVED*** The jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 * @param index {Integer***REMOVED*** The position (zero-based) to route to
 * @return {Boolean***REMOVED*** Indicates whether the action succeeded or failed
 **/
function goToStep(wizard, options, state, index)
{
    if (index < 0 || index >= state.stepCount)
    {
        throwError(_indexOutOfRangeErrorMessage);
    ***REMOVED***

    if (options.forceMoveForward && index < state.currentIndex)
    {
        return;
    ***REMOVED***

    var oldIndex = state.currentIndex;
    if (wizard.triggerHandler("stepChanging", [state.currentIndex, index]))
    {
        // Save new state
        state.currentIndex = index;
        saveCurrentStateToCookie(wizard, options, state);

        // Change visualisation
        refreshStepNavigation(wizard, options, state, oldIndex);
        refreshPagination(wizard, options, state);
        loadAsyncContent(wizard, options, state);
        startTransitionEffect(wizard, options, state, index, oldIndex, function()
        {
            wizard.triggerHandler("stepChanged", [index, oldIndex]);
        ***REMOVED***);
    ***REMOVED***
    else
    {
        wizard.find(".steps li").eq(oldIndex).addClass("error");
    ***REMOVED***

    return true;
***REMOVED***

function increaseCurrentIndexBy(state, increaseBy)
{
    return state.currentIndex + increaseBy;
***REMOVED***

/**
 * Initializes the component.
 *
 * @static
 * @private
 * @method initialize
 * @param options {Object***REMOVED*** The component settings
 **/
function initialize(options)
{
    /*jshint -W040 */
    var opts = $.extend(true, {***REMOVED***, defaults, options);

    return this.each(function ()
    {
        var wizard = $(this);
        var state = {
            currentIndex: opts.startIndex,
            currentStep: null,
            stepCount: 0,
            transitionElement: null
        ***REMOVED***;

        // Create data container
        wizard.data("options", opts);
        wizard.data("state", state);
        wizard.data("steps", []);

        analyzeData(wizard, opts, state);
        render(wizard, opts, state);
        registerEvents(wizard, opts);

        // Trigger focus
        if (opts.autoFocus && _uniqueId === 0)
        {
            getStepAnchor(wizard, opts.startIndex).focus();
        ***REMOVED***

        wizard.triggerHandler("init", [opts.startIndex]);
    ***REMOVED***);
***REMOVED***

/**
 * Inserts a new step to a specific position.
 *
 * @static
 * @private
 * @method insertStep
 * @param wizard {Object***REMOVED*** The jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
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
function insertStep(wizard, options, state, index, step)
{
    if (index < 0 || index > state.stepCount)
    {
        throwError(_indexOutOfRangeErrorMessage);
    ***REMOVED***

    // TODO: Validate step object

    // Change data
    step = $.extend({***REMOVED***, stepModel, step);
    insertStepToCache(wizard, index, step);
    if (state.currentIndex !== state.stepCount && state.currentIndex >= index)
    {
        state.currentIndex++;
        saveCurrentStateToCookie(wizard, options, state);
    ***REMOVED***
    state.stepCount++;

    var contentContainer = wizard.find(".content"),
        header = $("<{0***REMOVED***>{1***REMOVED***</{0***REMOVED***>".format(options.headerTag, step.title)),
        body = $("<{0***REMOVED***></{0***REMOVED***>".format(options.bodyTag));

    if (step.contentMode == null || step.contentMode === contentMode.html)
    {
        body.html(step.content);
    ***REMOVED***

    if (index === 0)
    {
        contentContainer.prepend(body).prepend(header);
    ***REMOVED***
    else
    {
        getStepPanel(wizard, (index - 1)).after(body).after(header);
    ***REMOVED***

    renderBody(wizard, state, body, index);
    renderTitle(wizard, options, state, header, index);
    refreshSteps(wizard, options, state, index);
    if (index === state.currentIndex)
    {
        refreshStepNavigation(wizard, options, state);
    ***REMOVED***
    refreshPagination(wizard, options, state);

    return wizard;
***REMOVED***

/**
 * Inserts a step object to the cache at a specific position.
 *
 * @static
 * @private
 * @method insertStepToCache
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param index {Integer***REMOVED*** The position (zero-based) to add
 * @param step {Object***REMOVED*** The step object to add
 **/
function insertStepToCache(wizard, index, step)
{
    getSteps(wizard).splice(index, 0, step);
***REMOVED***

/**
 * Handles the keyup DOM event for pagination.
 *
 * @static
 * @private
 * @event keyup
 * @param event {Object***REMOVED*** An event object
 */
function keyUpHandler(event)
{
    var wizard = $(this),
        options = getOptions(wizard),
        state = getState(wizard);

    if (options.suppressPaginationOnFocus && wizard.find(":focus").is(":input"))
    {
        event.preventDefault();
        return false;
    ***REMOVED***

    var keyCodes = { left: 37, right: 39 ***REMOVED***;
    if (event.keyCode === keyCodes.left)
    {
        event.preventDefault();
        goToPreviousStep(wizard, options, state);
    ***REMOVED***
    else if (event.keyCode === keyCodes.right)
    {
        event.preventDefault();
        goToNextStep(wizard, options, state);
    ***REMOVED***
***REMOVED***

/**
 * Loads and includes async content.
 *
 * @static
 * @private
 * @method loadAsyncContent
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 */
function loadAsyncContent(wizard, options, state)
{
    if (state.stepCount > 0)
    {
        var currentIndex = state.currentIndex,
            currentStep = getStep(wizard, currentIndex);

        if (!options.enableContentCache || !currentStep.contentLoaded)
        {
            switch (getValidEnumValue(contentMode, currentStep.contentMode))
            {
                case contentMode.iframe:
                    wizard.find(".content > .body").eq(state.currentIndex).empty()
                        .html("<iframe src=\"" + currentStep.contentUrl + "\" frameborder=\"0\" scrolling=\"no\" />")
                        .data("loaded", "1");
                    break;

                case contentMode.async:
                    var currentStepContent = getStepPanel(wizard, currentIndex)._aria("busy", "true")
                        .empty().append(renderTemplate(options.loadingTemplate, { text: options.labels.loading ***REMOVED***));

                    $.ajax({ url: currentStep.contentUrl, cache: false ***REMOVED***).done(function (data)
                    {
                        currentStepContent.empty().html(data)._aria("busy", "false").data("loaded", "1");
                        wizard.triggerHandler("contentLoaded", [currentIndex]);
                    ***REMOVED***);
                    break;
            ***REMOVED***
        ***REMOVED***
    ***REMOVED***
***REMOVED***

/**
 * Fires the action next or previous click event.
 *
 * @static
 * @private
 * @method paginationClick
 * @param wizard {Object***REMOVED*** The jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 * @param index {Integer***REMOVED*** The position (zero-based) to route to
 * @return {Boolean***REMOVED*** Indicates whether the event fired successfully or not
 **/
function paginationClick(wizard, options, state, index)
{
    var oldIndex = state.currentIndex;

    if (index >= 0 && index < state.stepCount && !(options.forceMoveForward && index < state.currentIndex))
    {
        var anchor = getStepAnchor(wizard, index),
            parent = anchor.parent(),
            isDisabled = parent.hasClass("disabled");

        // Enable the step to make the anchor clickable!
        parent._enableAria();
        anchor.click();

        // An error occured
        if (oldIndex === state.currentIndex && isDisabled)
        {
            // Disable the step again if current index has not changed; prevents click action.
            parent._enableAria(false);
            return false;
        ***REMOVED***

        return true;
    ***REMOVED***

    return false;
***REMOVED***

/**
 * Fires when a pagination click happens.
 *
 * @static
 * @private
 * @event click
 * @param event {Object***REMOVED*** An event object
 */
function paginationClickHandler(event)
{
    event.preventDefault();

    var anchor = $(this),
        wizard = anchor.parent().parent().parent().parent(),
        options = getOptions(wizard),
        state = getState(wizard),
        href = anchor.attr("href");

    switch (href.substring(href.lastIndexOf("#") + 1))
    {
        case "cancel":
            cancel(wizard);
            break;

        case "finish":
            finishStep(wizard, state);
            break;

        case "next":
            goToNextStep(wizard, options, state);
            break;

        case "previous":
            goToPreviousStep(wizard, options, state);
            break;
    ***REMOVED***
***REMOVED***

/**
 * Refreshs the visualization state for the entire pagination.
 *
 * @static
 * @private
 * @method refreshPagination
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 */
function refreshPagination(wizard, options, state)
{
    if (options.enablePagination)
    {
        var finish = wizard.find(".actions a[href$='#finish']").parent(),
            next = wizard.find(".actions a[href$='#next']").parent();

        if (!options.forceMoveForward)
        {
            var previous = wizard.find(".actions a[href$='#previous']").parent();
            previous._enableAria(state.currentIndex > 0);
        ***REMOVED***

        if (options.enableFinishButton && options.showFinishButtonAlways)
        {
            finish._enableAria(state.stepCount > 0);
            next._enableAria(state.stepCount > 1 && state.stepCount > (state.currentIndex + 1));
        ***REMOVED***
        else
        {
            finish._showAria(options.enableFinishButton && state.stepCount === (state.currentIndex + 1));
            next._showAria(state.stepCount === 0 || state.stepCount > (state.currentIndex + 1)).
                _enableAria(state.stepCount > (state.currentIndex + 1) || !options.enableFinishButton);
        ***REMOVED***
    ***REMOVED***
***REMOVED***

/**
 * Refreshs the visualization state for the step navigation (tabs).
 *
 * @static
 * @private
 * @method refreshStepNavigation
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 * @param [oldIndex] {Integer***REMOVED*** The index of the prior step
 */
function refreshStepNavigation(wizard, options, state, oldIndex)
{
    var currentOrNewStepAnchor = getStepAnchor(wizard, state.currentIndex),
        currentInfo = $("<span class=\"current-info audible\">" + options.labels.current + " </span>"),
        stepTitles = wizard.find(".content > .title");

    if (oldIndex != null)
    {
        var oldStepAnchor = getStepAnchor(wizard, oldIndex);
        oldStepAnchor.parent().addClass("done").removeClass("error")._selectAria(false);
        stepTitles.eq(oldIndex).removeClass("current").next(".body").removeClass("current");
        currentInfo = oldStepAnchor.find(".current-info");
        currentOrNewStepAnchor.focus();
    ***REMOVED***

    currentOrNewStepAnchor.prepend(currentInfo).parent()._selectAria().removeClass("done")._enableAria();
    stepTitles.eq(state.currentIndex).addClass("current").next(".body").addClass("current");
***REMOVED***

/**
 * Refreshes step buttons and their related titles beyond a certain position.
 *
 * @static
 * @private
 * @method refreshSteps
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 * @param index {Integer***REMOVED*** The start point for refreshing ids
 */
function refreshSteps(wizard, options, state, index)
{
    var uniqueId = getUniqueId(wizard);

    for (var i = index; i < state.stepCount; i++)
    {
        var uniqueStepId = uniqueId + _tabSuffix + i,
            uniqueBodyId = uniqueId + _tabpanelSuffix + i,
            uniqueHeaderId = uniqueId + _titleSuffix + i,
            title = wizard.find(".title").eq(i)._id(uniqueHeaderId);

        wizard.find(".steps a").eq(i)._id(uniqueStepId)
            ._aria("controls", uniqueBodyId).attr("href", "#" + uniqueHeaderId)
            .html(renderTemplate(options.titleTemplate, { index: i + 1, title: title.html() ***REMOVED***));
        wizard.find(".body").eq(i)._id(uniqueBodyId)
            ._aria("labelledby", uniqueHeaderId);
    ***REMOVED***
***REMOVED***

function registerEvents(wizard, options)
{
    var eventNamespace = getEventNamespace(wizard);

    wizard.bind("canceled" + eventNamespace, options.onCanceled);
    wizard.bind("contentLoaded" + eventNamespace, options.onContentLoaded);
    wizard.bind("finishing" + eventNamespace, options.onFinishing);
    wizard.bind("finished" + eventNamespace, options.onFinished);
    wizard.bind("init" + eventNamespace, options.onInit);
    wizard.bind("stepChanging" + eventNamespace, options.onStepChanging);
    wizard.bind("stepChanged" + eventNamespace, options.onStepChanged);

    if (options.enableKeyNavigation)
    {
        wizard.bind("keyup" + eventNamespace, keyUpHandler);
    ***REMOVED***

    wizard.find(".actions a").bind("click" + eventNamespace, paginationClickHandler);
***REMOVED***

/**
 * Removes a specific step by an given index.
 *
 * @static
 * @private
 * @method removeStep
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 * @param index {Integer***REMOVED*** The position (zero-based) of the step to remove
 * @return Indecates whether the item is removed.
 **/
function removeStep(wizard, options, state, index)
{
    // Index out of range and try deleting current item will return false.
    if (index < 0 || index >= state.stepCount || state.currentIndex === index)
    {
        return false;
    ***REMOVED***

    // Change data
    removeStepFromCache(wizard, index);
    if (state.currentIndex > index)
    {
        state.currentIndex--;
        saveCurrentStateToCookie(wizard, options, state);
    ***REMOVED***
    state.stepCount--;

    getStepTitle(wizard, index).remove();
    getStepPanel(wizard, index).remove();
    getStepAnchor(wizard, index).parent().remove();

    // Set the "first" class to the new first step button 
    if (index === 0)
    {
        wizard.find(".steps li").first().addClass("first");
    ***REMOVED***

    // Set the "last" class to the new last step button 
    if (index === state.stepCount)
    {
        wizard.find(".steps li").eq(index).addClass("last");
    ***REMOVED***

    refreshSteps(wizard, options, state, index);
    refreshPagination(wizard, options, state);

    return true;
***REMOVED***

function removeStepFromCache(wizard, index)
{
    getSteps(wizard).splice(index, 1);
***REMOVED***

/**
 * Transforms the base html structure to a more sensible html structure.
 *
 * @static
 * @private
 * @method render
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 **/
function render(wizard, options, state)
{
    // Create a content wrapper and copy HTML from the intial wizard structure
    var wrapperTemplate = "<{0***REMOVED*** class=\"{1***REMOVED***\">{2***REMOVED***</{0***REMOVED***>",
        orientation = getValidEnumValue(stepsOrientation, options.stepsOrientation),
        verticalCssClass = (orientation === stepsOrientation.vertical) ? " vertical" : "",
        contentWrapper = $(wrapperTemplate.format(options.contentContainerTag, "content " + options.clearFixCssClass, wizard.html())),
        stepsWrapper = $(wrapperTemplate.format(options.stepsContainerTag, "steps " + options.clearFixCssClass, "<ul role=\"tablist\"></ul>")),
        stepTitles = contentWrapper.children(options.headerTag),
        stepContents = contentWrapper.children(options.bodyTag);

    // Transform the wizard wrapper and remove the inner HTML
    wizard.attr("role", "application").empty().append(stepsWrapper).append(contentWrapper)
        .addClass(options.cssClass + " " + options.clearFixCssClass + verticalCssClass);

    // Add WIA-ARIA support
    stepContents.each(function (index)
    {
        renderBody(wizard, state, $(this), index);
    ***REMOVED***);

    stepTitles.each(function (index)
    {
        renderTitle(wizard, options, state, $(this), index);
    ***REMOVED***);

    refreshStepNavigation(wizard, options, state);
    renderPagination(wizard, options, state);
***REMOVED***

/**
 * Transforms the body to a proper tabpanel.
 *
 * @static
 * @private
 * @method renderBody
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param body {Object***REMOVED*** A jQuery body object
 * @param index {Integer***REMOVED*** The position of the body
 */
function renderBody(wizard, state, body, index)
{
    var uniqueId = getUniqueId(wizard),
        uniqueBodyId = uniqueId + _tabpanelSuffix + index,
        uniqueHeaderId = uniqueId + _titleSuffix + index;

    body._id(uniqueBodyId).attr("role", "tabpanel")._aria("labelledby", uniqueHeaderId)
        .addClass("body")._showAria(state.currentIndex === index);
***REMOVED***

/**
 * Renders a pagination if enabled.
 *
 * @static
 * @private
 * @method renderPagination
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 */
function renderPagination(wizard, options, state)
{
    if (options.enablePagination)
    {
        var pagination = "<{0***REMOVED*** class=\"actions {1***REMOVED***\"><ul role=\"menu\" aria-label=\"{2***REMOVED***\">{3***REMOVED***</ul></{0***REMOVED***>",
            buttonTemplate = "<li><a href=\"#{0***REMOVED***\" role=\"menuitem\">{1***REMOVED***</a></li>",
            buttons = "";

        if (!options.forceMoveForward)
        {
            buttons += buttonTemplate.format("previous", options.labels.previous);
        ***REMOVED***

        buttons += buttonTemplate.format("next", options.labels.next);

        if (options.enableFinishButton)
        {
            buttons += buttonTemplate.format("finish", options.labels.finish);
        ***REMOVED***

        if (options.enableCancelButton)
        {
            buttons += buttonTemplate.format("cancel", options.labels.cancel);
        ***REMOVED***

        wizard.append(pagination.format(options.actionContainerTag, options.clearFixCssClass,
            options.labels.pagination, buttons));

        refreshPagination(wizard, options, state);
        loadAsyncContent(wizard, options, state);
    ***REMOVED***
***REMOVED***

/**
 * Renders a template and replaces all placeholder.
 *
 * @static
 * @private
 * @method renderTemplate
 * @param template {String***REMOVED*** A template
 * @param substitutes {Object***REMOVED*** A list of substitute
 * @return {String***REMOVED*** The rendered template
 */
function renderTemplate(template, substitutes)
{
    var matches = template.match(/#([a-z]*)#/gi);

    for (var i = 0; i < matches.length; i++)
    {
        var match = matches[i], 
            key = match.substring(1, match.length - 1);

        if (substitutes[key] === undefined)
        {
            throwError("The key '{0***REMOVED***' does not exist in the substitute collection!", key);
        ***REMOVED***

        template = template.replace(match, substitutes[key]);
    ***REMOVED***

    return template;
***REMOVED***

/**
 * Transforms the title to a step item button.
 *
 * @static
 * @private
 * @method renderTitle
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 * @param header {Object***REMOVED*** A jQuery header object
 * @param index {Integer***REMOVED*** The position of the header
 */
function renderTitle(wizard, options, state, header, index)
{
    var uniqueId = getUniqueId(wizard),
        uniqueStepId = uniqueId + _tabSuffix + index,
        uniqueBodyId = uniqueId + _tabpanelSuffix + index,
        uniqueHeaderId = uniqueId + _titleSuffix + index,
        stepCollection = wizard.find(".steps > ul"),
        title = renderTemplate(options.titleTemplate, {
            index: index + 1,
            title: header.html()
        ***REMOVED***),
        stepItem = $("<li role=\"tab\"><a id=\"" + uniqueStepId + "\" href=\"#" + uniqueHeaderId + 
            "\" aria-controls=\"" + uniqueBodyId + "\">" + title + "</a></li>");
        
    stepItem._enableAria(options.enableAllSteps || state.currentIndex > index);

    if (state.currentIndex > index)
    {
        stepItem.addClass("done");
    ***REMOVED***

    header._id(uniqueHeaderId).attr("tabindex", "-1").addClass("title");

    if (index === 0)
    {
        stepCollection.prepend(stepItem);
    ***REMOVED***
    else
    {
        stepCollection.find("li").eq(index - 1).after(stepItem);
    ***REMOVED***

    // Set the "first" class to the new first step button
    if (index === 0)
    {
        stepCollection.find("li").removeClass("first").eq(index).addClass("first");
    ***REMOVED***

    // Set the "last" class to the new last step button
    if (index === (state.stepCount - 1))
    {
        stepCollection.find("li").removeClass("last").eq(index).addClass("last");
    ***REMOVED***

    // Register click event
    stepItem.children("a").bind("click" + getEventNamespace(wizard), stepClickHandler);
***REMOVED***

/**
 * Saves the current state to a cookie.
 *
 * @static
 * @private
 * @method saveCurrentStateToCookie
 * @param wizard {Object***REMOVED*** A jQuery wizard object
 * @param options {Object***REMOVED*** Settings of the current wizard
 * @param state {Object***REMOVED*** The state container of the current wizard
 */
function saveCurrentStateToCookie(wizard, options, state)
{
    if (options.saveState && $.cookie)
    {
        $.cookie(_cookiePrefix + getUniqueId(wizard), state.currentIndex);
    ***REMOVED***
***REMOVED***

function startTransitionEffect(wizard, options, state, index, oldIndex, doneCallback)
{
    var stepContents = wizard.find(".content > .body"),
        effect = getValidEnumValue(transitionEffect, options.transitionEffect),
        effectSpeed = options.transitionEffectSpeed,
        newStep = stepContents.eq(index),
        currentStep = stepContents.eq(oldIndex);

    switch (effect)
    {
        case transitionEffect.fade:
        case transitionEffect.slide:
            var hide = (effect === transitionEffect.fade) ? "fadeOut" : "slideUp",
                show = (effect === transitionEffect.fade) ? "fadeIn" : "slideDown";

            state.transitionElement = newStep;
            currentStep[hide](effectSpeed, function ()
            {
                var wizard = $(this)._showAria(false).parent().parent(),
                    state = getState(wizard);

                if (state.transitionElement)
                {
                    state.transitionElement[show](effectSpeed, function ()
                    {
                        $(this)._showAria();
                    ***REMOVED***).promise().done(doneCallback);
                    state.transitionElement = null;
                ***REMOVED***
            ***REMOVED***);
            break;

        case transitionEffect.slideLeft:
            var outerWidth = currentStep.outerWidth(true),
                posFadeOut = (index > oldIndex) ? -(outerWidth) : outerWidth,
                posFadeIn = (index > oldIndex) ? outerWidth : -(outerWidth);

            $.when(currentStep.animate({ left: posFadeOut ***REMOVED***, effectSpeed, 
                    function () { $(this)._showAria(false); ***REMOVED***),
                newStep.css("left", posFadeIn + "px")._showAria()
                    .animate({ left: 0 ***REMOVED***, effectSpeed)).done(doneCallback);
            break;

        default:
            $.when(currentStep._showAria(false), newStep._showAria())
                .done(doneCallback);
            break;
    ***REMOVED***
***REMOVED***

/**
 * Fires when a step click happens.
 *
 * @static
 * @private
 * @event click
 * @param event {Object***REMOVED*** An event object
 */
function stepClickHandler(event)
{
    event.preventDefault();

    var anchor = $(this),
        wizard = anchor.parent().parent().parent().parent(),
        options = getOptions(wizard),
        state = getState(wizard),
        oldIndex = state.currentIndex;

    if (anchor.parent().is(":not(.disabled):not(.current)"))
    {
        var href = anchor.attr("href"),
            position = parseInt(href.substring(href.lastIndexOf("-") + 1), 0);

        goToStep(wizard, options, state, position);
    ***REMOVED***

    // If nothing has changed
    if (oldIndex === state.currentIndex)
    {
        getStepAnchor(wizard, oldIndex).focus();
        return false;
    ***REMOVED***
***REMOVED***

function throwError(message)
{
    if (arguments.length > 1)
    {
        message = message.format(Array.prototype.slice.call(arguments, 1));
    ***REMOVED***

    throw new Error(message);
***REMOVED***

/**
 * Checks an argument for null or undefined and throws an error if one check applies.
 *
 * @static
 * @private
 * @method validateArgument
 * @param argumentName {String***REMOVED*** The name of the given argument
 * @param argumentValue {Object***REMOVED*** The argument itself
 */
function validateArgument(argumentName, argumentValue)
{
    if (argumentValue == null)
    {
        throwError("The argument '{0***REMOVED***' is null or undefined.", argumentName);
    ***REMOVED***
***REMOVED***