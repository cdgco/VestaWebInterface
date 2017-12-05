$.fn.extend({
    _aria: function (name, value)
    {
        return this.attr("aria-" + name, value);
    ***REMOVED***,

    _removeAria: function (name)
    {
        return this.removeAttr("aria-" + name);
    ***REMOVED***,

    _enableAria: function (enable)
    {
        return (enable == null || enable) ? 
            this.removeClass("disabled")._aria("disabled", "false") : 
            this.addClass("disabled")._aria("disabled", "true");
    ***REMOVED***,

    _showAria: function (show)
    {
        return (show == null || show) ? 
            this.show()._aria("hidden", "false") : 
            this.hide()._aria("hidden", "true");
    ***REMOVED***,

    _selectAria: function (select)
    {
        return (select == null || select) ? 
            this.addClass("current")._aria("selected", "true") : 
            this.removeClass("current")._aria("selected", "false");
    ***REMOVED***,

    _id: function (id)
    {
        return (id) ? this.attr("id", id) : this.attr("id");
    ***REMOVED***
***REMOVED***);

if (!String.prototype.format)
{
    String.prototype.format = function()
    {
        var args = (arguments.length === 1 && $.isArray(arguments[0])) ? arguments[0] : arguments;
        var formattedString = this;
        for (var i = 0; i < args.length; i++)
        {
            var pattern = new RegExp("\\{" + i + "\\***REMOVED***", "gm");
            formattedString = formattedString.replace(pattern, args[i]);
        ***REMOVED***
        return formattedString;
    ***REMOVED***;
***REMOVED***