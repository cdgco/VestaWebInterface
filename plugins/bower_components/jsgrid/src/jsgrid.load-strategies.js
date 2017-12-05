(function(jsGrid, $, undefined) {

    function DirectLoadingStrategy(grid) {
        this._grid = grid;
    ***REMOVED***

    DirectLoadingStrategy.prototype = {

        firstDisplayIndex: function() {
            var grid = this._grid;
            return grid.option("paging") ? (grid.option("pageIndex") - 1) * grid.option("pageSize") : 0;
        ***REMOVED***,

        lastDisplayIndex: function() {
            var grid = this._grid;
            var itemsCount = grid.option("data").length;

            return grid.option("paging")
                ? Math.min(grid.option("pageIndex") * grid.option("pageSize"), itemsCount)
                : itemsCount;
        ***REMOVED***,

        itemsCount: function() {
            return this._grid.option("data").length;
        ***REMOVED***,

        openPage: function(index) {
            this._grid.refresh();
        ***REMOVED***,

        loadParams: function() {
            return {***REMOVED***;
        ***REMOVED***,

        sort: function() {
            this._grid._sortData();
            this._grid.refresh();
            return $.Deferred().resolve().promise();
        ***REMOVED***,

        finishLoad: function(loadedData) {
            this._grid.option("data", loadedData);
        ***REMOVED***,

        finishInsert: function(insertedItem) {
            var grid = this._grid;
            grid.option("data").push(insertedItem);
            grid.refresh();
        ***REMOVED***,

        finishDelete: function(deletedItem, deletedItemIndex) {
            var grid = this._grid;
            grid.option("data").splice(deletedItemIndex, 1);
            grid.reset();
        ***REMOVED***
    ***REMOVED***;


    function PageLoadingStrategy(grid) {
        this._grid = grid;
        this._itemsCount = 0;
    ***REMOVED***

    PageLoadingStrategy.prototype = {
        firstDisplayIndex: function() {
            return 0;
        ***REMOVED***,

        lastDisplayIndex: function() {
            return this._grid.option("data").length;
        ***REMOVED***,

        itemsCount: function() {
            return this._itemsCount;
        ***REMOVED***,

        openPage: function(index) {
            this._grid.loadData();
        ***REMOVED***,

        loadParams: function() {
            var grid = this._grid;
            return {
                pageIndex: grid.option("pageIndex"),
                pageSize: grid.option("pageSize")
            ***REMOVED***;
        ***REMOVED***,

        sort: function() {
            return this._grid.loadData();
        ***REMOVED***,

        finishLoad: function(loadedData) {
            this._itemsCount = loadedData.itemsCount;
            this._grid.option("data", loadedData.data);
        ***REMOVED***,

        finishInsert: function(insertedItem) {
            this._grid.search();
        ***REMOVED***,

        finishDelete: function(deletedItem, deletedItemIndex) {
            this._grid.search();
        ***REMOVED***
    ***REMOVED***;

    jsGrid.loadStrategies = {
        DirectLoadingStrategy: DirectLoadingStrategy,
        PageLoadingStrategy: PageLoadingStrategy
    ***REMOVED***;

***REMOVED***(jsGrid, jQuery));
