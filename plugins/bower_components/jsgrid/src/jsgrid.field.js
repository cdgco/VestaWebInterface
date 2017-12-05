(function(jsGrid, $, undefined) {

    function Field(config) {
        $.extend(true, this, config);
        this.sortingFunc = this._getSortingFunc();
    ***REMOVED***

    Field.prototype = {
        name: "",
        title: null,
        css: "",
        align: "",
        width: 100,

        visible: true,
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        sorter: "string", // name of SortStrategy or function to compare elements

        headerTemplate: function() {
            return (this.title === undefined || this.title === null) ? this.name : this.title;
        ***REMOVED***,

        itemTemplate: function(value, item) {
            return value;
        ***REMOVED***,

        filterTemplate: function() {
            return "";
        ***REMOVED***,

        insertTemplate: function() {
            return "";
        ***REMOVED***,

        editTemplate: function(value, item) {
            this._value = value;
            return this.itemTemplate(value, item);
        ***REMOVED***,

        filterValue: function() {
            return "";
        ***REMOVED***,

        insertValue: function() {
            return "";
        ***REMOVED***,

        editValue: function() {
            return this._value;
        ***REMOVED***,

        _getSortingFunc: function() {
            var sorter = this.sorter;

            if($.isFunction(sorter)) {
                return sorter;
            ***REMOVED***

            if(typeof sorter === "string") {
                return jsGrid.sortStrategies[sorter];
            ***REMOVED***

            throw Error("wrong sorter for the field \"" + this.name + "\"!");
        ***REMOVED***
    ***REMOVED***;

    jsGrid.Field = Field;

***REMOVED***(jsGrid, jQuery));
