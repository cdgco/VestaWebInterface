(function(window, $, undefined) {

    var JSGRID = "JSGrid",
        JSGRID_DATA_KEY = JSGRID,
        JSGRID_ROW_DATA_KEY = "JSGridItem",
        JSGRID_EDIT_ROW_DATA_KEY = "JSGridEditRow",

        SORT_ORDER_ASC = "asc",
        SORT_ORDER_DESC = "desc",

        FIRST_PAGE_PLACEHOLDER = "{first***REMOVED***",
        PAGES_PLACEHOLDER = "{pages***REMOVED***",
        PREV_PAGE_PLACEHOLDER = "{prev***REMOVED***",
        NEXT_PAGE_PLACEHOLDER = "{next***REMOVED***",
        LAST_PAGE_PLACEHOLDER = "{last***REMOVED***",
        PAGE_INDEX_PLACEHOLDER = "{pageIndex***REMOVED***",
        PAGE_COUNT_PLACEHOLDER = "{pageCount***REMOVED***",
        ITEM_COUNT_PLACEHOLDER = "{itemCount***REMOVED***",

        EMPTY_HREF = "javascript:void(0);";

    var getOrApply = function(value, context) {
        if($.isFunction(value)) {
            return value.apply(context, $.makeArray(arguments).slice(2));
        ***REMOVED***
        return value;
    ***REMOVED***;

    var defaultController = {
        loadData: $.noop,
        insertItem: $.noop,
        updateItem: $.noop,
        deleteItem: $.noop
    ***REMOVED***;


    function Grid(element, config) {
        var $element = $(element);

        $element.data(JSGRID_DATA_KEY, this);

        this._container = $element;

        this.data = [];
        this.fields = [];

        this._editingRow = null;
        this._sortField = null;
        this._sortOrder = SORT_ORDER_ASC;
        this._firstDisplayingPage = 1;

        this._init(config);
        this.render();
    ***REMOVED***

    Grid.prototype = {
        width: "auto",
        height: "auto",
        updateOnResize: true,

        rowClass: $.noop,
        rowRenderer: null,

        rowClick: function(args) {
            if(this.editing) {
                this.editItem($(args.event.target).closest("tr"));
            ***REMOVED***
        ***REMOVED***,
        rowDoubleClick: $.noop,

        noDataContent: "Not found",
        noDataRowClass: "jsgrid-nodata-row",

        heading: true,
        headerRowRenderer: null,
        headerRowClass: "jsgrid-header-row",

        filtering: false,
        filterRowRenderer: null,
        filterRowClass: "jsgrid-filter-row",

        inserting: false,
        insertRowRenderer: null,
        insertRowClass: "jsgrid-insert-row",

        editing: false,
        editRowRenderer: null,
        editRowClass: "jsgrid-edit-row",

        confirmDeleting: true,
        deleteConfirm: "Are you sure?",

        selecting: true,
        selectedRowClass: "jsgrid-selected-row",
        oddRowClass: "jsgrid-row",
        evenRowClass: "jsgrid-alt-row",

        sorting: false,
        sortableClass: "jsgrid-header-sortable",
        sortAscClass: "jsgrid-header-sort jsgrid-header-sort-asc",
        sortDescClass: "jsgrid-header-sort jsgrid-header-sort-desc",

        paging: false,
        pagerContainer: null,
        pageIndex: 1,
        pageSize: 20,
        pageButtonCount: 15,
        pagerFormat: "Pages: {first***REMOVED*** {prev***REMOVED*** {pages***REMOVED*** {next***REMOVED*** {last***REMOVED*** &nbsp;&nbsp; {pageIndex***REMOVED*** of {pageCount***REMOVED***",
        pagePrevText: "Prev",
        pageNextText: "Next",
        pageFirstText: "First",
        pageLastText: "Last",
        pageNavigatorNextText: "...",
        pageNavigatorPrevText: "...",
        pagerContainerClass: "jsgrid-pager-container",
        pagerClass: "jsgrid-pager",
        pagerNavButtonClass: "jsgrid-pager-nav-button",
        pagerNavButtonInactiveClass: "jsgrid-pager-nav-inactive-button",
        pageClass: "jsgrid-pager-page",
        currentPageClass: "jsgrid-pager-current-page",

        customLoading: false,
        pageLoading: false,

        autoload: false,
        controller: defaultController,

        loadIndication: true,
        loadIndicationDelay: 500,
        loadMessage: "Please, wait...",
        loadShading: true,

        invalidMessage: "Invalid data entered!",

        invalidNotify: function(args) {
            var messages = $.map(args.errors, function(error) {
                return error.message || null;
            ***REMOVED***);

            window.alert([this.invalidMessage].concat(messages).join("\n"));
        ***REMOVED***,

        onRefreshing: $.noop,
        onRefreshed: $.noop,
        onItemDeleting: $.noop,
        onItemDeleted: $.noop,
        onItemInserting: $.noop,
        onItemInserted: $.noop,
        onItemEditing: $.noop,
        onItemUpdating: $.noop,
        onItemUpdated: $.noop,
        onItemInvalid: $.noop,
        onDataLoading: $.noop,
        onDataLoaded: $.noop,
        onOptionChanging: $.noop,
        onOptionChanged: $.noop,
        onError: $.noop,

        invalidClass: "jsgrid-invalid",

        containerClass: "jsgrid",
        tableClass: "jsgrid-table",
        gridHeaderClass: "jsgrid-grid-header",
        gridBodyClass: "jsgrid-grid-body",

        _init: function(config) {
            $.extend(this, config);
            this._initLoadStrategy();
            this._initController();
            this._initFields();
            this._attachWindowLoadResize();
            this._attachWindowResizeCallback();
        ***REMOVED***,

        loadStrategy: function() {
            return this.pageLoading
                ? new jsGrid.loadStrategies.PageLoadingStrategy(this)
                : new jsGrid.loadStrategies.DirectLoadingStrategy(this);
        ***REMOVED***,

        _initLoadStrategy: function() {
            this._loadStrategy = getOrApply(this.loadStrategy, this);
        ***REMOVED***,

        _initController: function() {
            this._controller = $.extend({***REMOVED***, defaultController, getOrApply(this.controller, this));
        ***REMOVED***,

        loadIndicator: function(config) {
            return new jsGrid.LoadIndicator(config);
        ***REMOVED***,

        validation: function(config) {
            return jsGrid.Validation && new jsGrid.Validation(config);
        ***REMOVED***,

        _initFields: function() {
            var self = this;
            self.fields = $.map(self.fields, function(field) {
                if($.isPlainObject(field)) {
                    var fieldConstructor = (field.type && jsGrid.fields[field.type]) || jsGrid.Field;
                    field = new fieldConstructor(field);
                ***REMOVED***
                field._grid = self;
                return field;
            ***REMOVED***);
        ***REMOVED***,

        _attachWindowLoadResize: function() {
            $(window).on("load", $.proxy(this._refreshSize, this));
        ***REMOVED***,

        _attachWindowResizeCallback: function() {
            if(this.updateOnResize) {
                $(window).on("resize", $.proxy(this._refreshSize, this));
            ***REMOVED***
        ***REMOVED***,

        _detachWindowResizeCallback: function() {
            $(window).off("resize", this._refreshSize);
        ***REMOVED***,

        option: function(key, value) {
            var optionChangingEventArgs,
                optionChangedEventArgs;

            if(arguments.length === 1)
                return this[key];

            optionChangingEventArgs = {
                option: key,
                oldValue: this[key],
                newValue: value
            ***REMOVED***;
            this._callEventHandler(this.onOptionChanging, optionChangingEventArgs);

            this._handleOptionChange(optionChangingEventArgs.option, optionChangingEventArgs.newValue);

            optionChangedEventArgs = {
                option: optionChangingEventArgs.option,
                value: optionChangingEventArgs.newValue
            ***REMOVED***;
            this._callEventHandler(this.onOptionChanged, optionChangedEventArgs);
        ***REMOVED***,

        fieldOption: function(field, key, value) {
            field = this._normalizeField(field);

            if(arguments.length === 2)
                return field[key];

            field[key] = value;
            this._renderGrid();
        ***REMOVED***,

        _handleOptionChange: function(name, value) {
            this[name] = value;

            switch(name) {
                case "width":
                case "height":
                    this._refreshSize();
                    break;
                case "rowClass":
                case "rowRenderer":
                case "rowClick":
                case "rowDoubleClick":
                case "noDataText":
                case "noDataRowClass":
                case "noDataContent":
                case "selecting":
                case "selectedRowClass":
                case "oddRowClass":
                case "evenRowClass":
                    this._refreshContent();
                    break;
                case "pageButtonCount":
                case "pagerFormat":
                case "pagePrevText":
                case "pageNextText":
                case "pageFirstText":
                case "pageLastText":
                case "pageNavigatorNextText":
                case "pageNavigatorPrevText":
                case "pagerClass":
                case "pagerNavButtonClass":
                case "pageClass":
                case "currentPageClass":
                case "pagerRenderer":
                    this._refreshPager();
                    break;
                case "fields":
                    this._initFields();
                    this.render();
                    break;
                case "data":
                case "editing":
                case "heading":
                case "filtering":
                case "inserting":
                case "paging":
                    this.refresh();
                    break;
                case "loadStrategy":
                case "pageLoading":
                    this._initLoadStrategy();
                    this.search();
                    break;
                case "pageIndex":
                    this.openPage(value);
                    break;
                case "pageSize":
                    this.refresh();
                    this.search();
                    break;
                case "editRowRenderer":
                case "editRowClass":
                    this.cancelEdit();
                    break;
                case "updateOnResize":
                    this._detachWindowResizeCallback();
                    this._attachWindowResizeCallback();
                    break;
                case "invalidNotify":
                case "invalidMessage":
                    break;
                default:
                    this.render();
                    break;
            ***REMOVED***
        ***REMOVED***,

        destroy: function() {
            this._detachWindowResizeCallback();
            this._clear();
            this._container.removeData(JSGRID_DATA_KEY);
        ***REMOVED***,

        render: function() {
            this._renderGrid();
            return this.autoload ? this.loadData() : $.Deferred().resolve().promise();
        ***REMOVED***,

        _renderGrid: function() {
            this._clear();

            this._container.addClass(this.containerClass)
                .css("position", "relative")
                .append(this._createHeader())
                .append(this._createBody());

            this._pagerContainer = this._createPagerContainer();
            this._loadIndicator = this._createLoadIndicator();
            this._validation = this._createValidation();

            this.refresh();
        ***REMOVED***,

        _createLoadIndicator: function() {
            return getOrApply(this.loadIndicator, this, {
                message: this.loadMessage,
                shading: this.loadShading,
                container: this._container
            ***REMOVED***);
        ***REMOVED***,

        _createValidation: function() {
            return getOrApply(this.validation, this);
        ***REMOVED***,

        _clear: function() {
            this.cancelEdit();

            clearTimeout(this._loadingTimer);

            this._pagerContainer && this._pagerContainer.empty();

            this._container.empty()
                .css({ position: "", width: "", height: "" ***REMOVED***);
        ***REMOVED***,

        _createHeader: function() {
            var $headerRow = this._headerRow = this._createHeaderRow(),
                $filterRow = this._filterRow = this._createFilterRow(),
                $insertRow = this._insertRow = this._createInsertRow();

            var $headerGrid = this._headerGrid = $("<table>").addClass(this.tableClass)
                .append($headerRow)
                .append($filterRow)
                .append($insertRow);

            var $header = this._header = $("<div>").addClass(this.gridHeaderClass)
                .addClass(this._scrollBarWidth() ? "jsgrid-header-scrollbar" : "")
                .append($headerGrid);

            return $header;
        ***REMOVED***,

        _createBody: function() {
            var $content = this._content = $("<tbody>");

            var $bodyGrid = this._bodyGrid = $("<table>").addClass(this.tableClass)
                .append($content);

            var $body = this._body = $("<div>").addClass(this.gridBodyClass)
                .append($bodyGrid)
                .on("scroll", $.proxy(function(e) {
                    this._header.scrollLeft(e.target.scrollLeft);
                ***REMOVED***, this));

            return $body;
        ***REMOVED***,

        _createPagerContainer: function() {
            var pagerContainer = this.pagerContainer || $("<div>").appendTo(this._container);
            return $(pagerContainer).addClass(this.pagerContainerClass);
        ***REMOVED***,

        _eachField: function(callBack) {
            var self = this;
            $.each(this.fields, function(index, field) {
                if(field.visible) {
                    callBack.call(self, field, index);
                ***REMOVED***
            ***REMOVED***);
        ***REMOVED***,

        _createHeaderRow: function() {
            if($.isFunction(this.headerRowRenderer))
                return $(this.headerRowRenderer());

            var $result = $("<tr>").addClass(this.headerRowClass);

            this._eachField(function(field, index) {
                var $th = this._prepareCell("<th>", field, "headercss")
                    .append(field.headerTemplate ? field.headerTemplate() : "")
                    .appendTo($result);

                if(this.sorting && field.sorting) {
                    $th.addClass(this.sortableClass)
                        .on("click", $.proxy(function() {
                            this.sort(index);
                        ***REMOVED***, this));
                ***REMOVED***
            ***REMOVED***);

            return $result;
        ***REMOVED***,

        _prepareCell: function(cell, field, cssprop) {
            return $(cell).css("width", field.width)
                .addClass((cssprop && field[cssprop]) || field.css)
                .addClass(field.align ? ("jsgrid-align-" + field.align) : "");
        ***REMOVED***,

        _createFilterRow: function() {
            if($.isFunction(this.filterRowRenderer))
                return $(this.filterRowRenderer());

            var $result = $("<tr>").addClass(this.filterRowClass);

            this._eachField(function(field) {
                this._prepareCell("<td>", field, "filtercss")
                    .append(field.filterTemplate ? field.filterTemplate() : "")
                    .appendTo($result);
            ***REMOVED***);

            return $result;
        ***REMOVED***,

        _createInsertRow: function() {
            if($.isFunction(this.insertRowRenderer))
                return $(this.insertRowRenderer());

            var $result = $("<tr>").addClass(this.insertRowClass);

            this._eachField(function(field) {
                this._prepareCell("<td>", field, "insertcss")
                    .append(field.insertTemplate ? field.insertTemplate() : "")
                    .appendTo($result);
            ***REMOVED***);

            return $result;
        ***REMOVED***,

        _callEventHandler: function(handler, eventParams) {
            handler.call(this, $.extend(eventParams, {
                grid: this
            ***REMOVED***));

            return eventParams;
        ***REMOVED***,

        reset: function() {
            this._resetSorting();
            this._resetPager();
            this.refresh();
        ***REMOVED***,

        _resetPager: function() {
            this._firstDisplayingPage = 1;
            this._setPage(1);
        ***REMOVED***,

        _resetSorting: function() {
            this._sortField = null;
            this._sortOrder = SORT_ORDER_ASC;
            this._clearSortingCss();
        ***REMOVED***,

        refresh: function() {
            this._callEventHandler(this.onRefreshing);

            this.cancelEdit();

            this._refreshHeading();
            this._refreshFiltering();
            this._refreshInserting();
            this._refreshContent();
            this._refreshPager();
            this._refreshSize();

            this._callEventHandler(this.onRefreshed);
        ***REMOVED***,

        _refreshHeading: function() {
            this._headerRow.toggle(this.heading);
        ***REMOVED***,

        _refreshFiltering: function() {
            this._filterRow.toggle(this.filtering);
        ***REMOVED***,

        _refreshInserting: function() {
            this._insertRow.toggle(this.inserting);
        ***REMOVED***,

        _refreshContent: function() {
            var $content = this._content;
            $content.empty();

            if(!this.data.length) {
                $content.append(this._createNoDataRow());
                return this;
            ***REMOVED***

            var indexFrom = this._loadStrategy.firstDisplayIndex();
            var indexTo = this._loadStrategy.lastDisplayIndex();

            for(var itemIndex = indexFrom; itemIndex < indexTo; itemIndex++) {
                var item = this.data[itemIndex];
                $content.append(this._createRow(item, itemIndex));
            ***REMOVED***
        ***REMOVED***,

        _createNoDataRow: function() {
            var noDataContent = getOrApply(this.noDataContent, this);

            var amountOfFields = 0;
            this._eachField(function() {
                amountOfFields++;
            ***REMOVED***);

            return $("<tr>").addClass(this.noDataRowClass)
                .append($("<td>").attr("colspan", amountOfFields).append(noDataContent));
        ***REMOVED***,

        _createNoDataContent: function() {
            return $.isFunction(this.noDataRenderer)
                ? this.noDataRenderer()
                : this.noDataText;
        ***REMOVED***,

        _createRow: function(item, itemIndex) {
            var $result;

            if($.isFunction(this.rowRenderer)) {
                $result = $(this.rowRenderer(item, itemIndex));
            ***REMOVED*** else {
                $result = $("<tr>");
                this._renderCells($result, item);
            ***REMOVED***

            $result.addClass(this._getRowClasses(item, itemIndex))
                .data(JSGRID_ROW_DATA_KEY, item)
                .on("click", $.proxy(function(e) {
                    this.rowClick({
                        item: item,
                        itemIndex: itemIndex,
                        event: e
                    ***REMOVED***);
                ***REMOVED***, this))
                .on("dblclick", $.proxy(function(e) {
                    this.rowDoubleClick({
                        item: item,
                        itemIndex: itemIndex,
                        event: e
                    ***REMOVED***);
                ***REMOVED***, this));

            if(this.selecting) {
                this._attachRowHover($result);
            ***REMOVED***

            return $result;
        ***REMOVED***,

        _getRowClasses: function(item, itemIndex) {
            var classes = [];
            classes.push(((itemIndex + 1) % 2) ? this.oddRowClass : this.evenRowClass);
            classes.push(getOrApply(this.rowClass, this, item, itemIndex));
            return classes.join(" ");
        ***REMOVED***,

        _attachRowHover: function($row) {
            var selectedRowClass = this.selectedRowClass;
            $row.hover(function() {
                    $(this).addClass(selectedRowClass);
                ***REMOVED***,
                function() {
                    $(this).removeClass(selectedRowClass);
                ***REMOVED***
            );
        ***REMOVED***,

        _renderCells: function($row, item) {
            this._eachField(function(field) {
                $row.append(this._createCell(item, field));
            ***REMOVED***);
            return this;
        ***REMOVED***,

        _createCell: function(item, field) {
            var $result;
            var fieldValue = this._getItemFieldValue(item, field);

            if($.isFunction(field.cellRenderer)) {
                $result = $(field.cellRenderer(fieldValue, item));
            ***REMOVED*** else {
                $result = $("<td>").append(field.itemTemplate ? field.itemTemplate(fieldValue, item) : fieldValue);
            ***REMOVED***

            return this._prepareCell($result, field);
        ***REMOVED***,

        _getItemFieldValue: function(item, field) {
            var props = field.name.split('.');
            var result = item[props.shift()];

            while(result && props.length) {
                result = result[props.shift()];
            ***REMOVED***

            return result;
        ***REMOVED***,

        _setItemFieldValue: function(item, field, value) {
            var props = field.name.split('.');
            var current = item;
            var prop = props[0];

            while(current && props.length) {
                item = current;
                prop = props.shift();
                current = item[prop];
            ***REMOVED***

            if(!current) {
                while(props.length) {
                    item = item[prop] = {***REMOVED***;
                    prop = props.shift();
                ***REMOVED***
            ***REMOVED***

            item[prop] = value;
        ***REMOVED***,

        sort: function(field, order) {
            if($.isPlainObject(field)) {
                order = field.order;
                field = field.field;
            ***REMOVED***

            this._clearSortingCss();
            this._setSortingParams(field, order);
            this._setSortingCss();
            return this._loadStrategy.sort();
        ***REMOVED***,

        _clearSortingCss: function() {
            this._headerRow.find("th")
                .removeClass(this.sortAscClass)
                .removeClass(this.sortDescClass);
        ***REMOVED***,

        _setSortingParams: function(field, order) {
            field = this._normalizeField(field);
            order = order || ((this._sortField === field) ? this._reversedSortOrder(this._sortOrder) : SORT_ORDER_ASC);

            this._sortField = field;
            this._sortOrder = order;
        ***REMOVED***,

        _normalizeField: function(field) {
            if($.isNumeric(field)) {
                return this.fields[field];
            ***REMOVED***

            if(typeof field === "string") {
                return $.grep(this.fields, function(f) {
                    return f.name === field;
                ***REMOVED***)[0];
            ***REMOVED***

            return field;
        ***REMOVED***,

        _reversedSortOrder: function(order) {
            return (order === SORT_ORDER_ASC ? SORT_ORDER_DESC : SORT_ORDER_ASC);
        ***REMOVED***,

        _setSortingCss: function() {
            var fieldIndex = $.inArray(this._sortField, $.grep(this.fields, function(f) { return f.visible; ***REMOVED***));

            this._headerRow.find("th").eq(fieldIndex)
                .addClass(this._sortOrder === SORT_ORDER_ASC ? this.sortAscClass : this.sortDescClass);
        ***REMOVED***,

        _sortData: function() {
            var sortFactor = this._sortFactor(),
                sortField = this._sortField;

            if(sortField) {
                this.data.sort(function(item1, item2) {
                    return sortFactor * sortField.sortingFunc(item1[sortField.name], item2[sortField.name]);
                ***REMOVED***);
            ***REMOVED***
        ***REMOVED***,

        _sortFactor: function() {
            return this._sortOrder === SORT_ORDER_ASC ? 1 : -1;
        ***REMOVED***,

        _itemsCount: function() {
            return this._loadStrategy.itemsCount();
        ***REMOVED***,

        _pagesCount: function() {
            var itemsCount = this._itemsCount(),
                pageSize = this.pageSize;
            return Math.floor(itemsCount / pageSize) + (itemsCount % pageSize ? 1 : 0);
        ***REMOVED***,

        _refreshPager: function() {
            var $pagerContainer = this._pagerContainer;
            $pagerContainer.empty();

            if(this.paging) {
                $pagerContainer.append(this._createPager());
            ***REMOVED***

            var showPager = this.paging && this._pagesCount() > 1;
            $pagerContainer.toggle(showPager);
        ***REMOVED***,

        _createPager: function() {
            var $result;

            if($.isFunction(this.pagerRenderer)) {
                $result = $(this.pagerRenderer({
                    pageIndex: this.pageIndex,
                    pageCount: this._pagesCount()
                ***REMOVED***));
            ***REMOVED*** else {
                $result = $("<div>").append(this._createPagerByFormat());
            ***REMOVED***

            $result.addClass(this.pagerClass);

            return $result;
        ***REMOVED***,

        _createPagerByFormat: function() {
            var pageIndex = this.pageIndex,
                pageCount = this._pagesCount(),
                itemCount = this._itemsCount(),
                pagerParts = this.pagerFormat.split(" ");

            return $.map(pagerParts, $.proxy(function(pagerPart) {
                var result = pagerPart;

                if(pagerPart === PAGES_PLACEHOLDER) {
                    result = this._createPages();
                ***REMOVED*** else if(pagerPart === FIRST_PAGE_PLACEHOLDER) {
                    result = this._createPagerNavButton(this.pageFirstText, 1, pageIndex > 1);
                ***REMOVED*** else if(pagerPart === PREV_PAGE_PLACEHOLDER) {
                    result = this._createPagerNavButton(this.pagePrevText, pageIndex - 1, pageIndex > 1);
                ***REMOVED*** else if(pagerPart === NEXT_PAGE_PLACEHOLDER) {
                    result = this._createPagerNavButton(this.pageNextText, pageIndex + 1, pageIndex < pageCount);
                ***REMOVED*** else if(pagerPart === LAST_PAGE_PLACEHOLDER) {
                    result = this._createPagerNavButton(this.pageLastText, pageCount, pageIndex < pageCount);
                ***REMOVED*** else if(pagerPart === PAGE_INDEX_PLACEHOLDER) {
                    result = pageIndex;
                ***REMOVED*** else if(pagerPart === PAGE_COUNT_PLACEHOLDER) {
                    result = pageCount;
                ***REMOVED*** else if(pagerPart === ITEM_COUNT_PLACEHOLDER) {
                    result = itemCount;
                ***REMOVED***

                return $.isArray(result) ? result.concat([" "]) : [result, " "];
            ***REMOVED***, this));
        ***REMOVED***,

        _createPages: function() {
            var pageCount = this._pagesCount(),
                pageButtonCount = this.pageButtonCount,
                firstDisplayingPage = this._firstDisplayingPage,
                pages = [];

            if(firstDisplayingPage > 1) {
                pages.push(this._createPagerPageNavButton(this.pageNavigatorPrevText, this.showPrevPages));
            ***REMOVED***

            for(var i = 0, pageNumber = firstDisplayingPage; i < pageButtonCount && pageNumber <= pageCount; i++, pageNumber++) {
                pages.push(pageNumber === this.pageIndex
                    ? this._createPagerCurrentPage()
                    : this._createPagerPage(pageNumber));
            ***REMOVED***

            if((firstDisplayingPage + pageButtonCount - 1) < pageCount) {
                pages.push(this._createPagerPageNavButton(this.pageNavigatorNextText, this.showNextPages));
            ***REMOVED***

            return pages;
        ***REMOVED***,

        _createPagerNavButton: function(text, pageIndex, isActive) {
            return this._createPagerButton(text, this.pagerNavButtonClass + (isActive ? "" : " " + this.pagerNavButtonInactiveClass),
                isActive ? function() { this.openPage(pageIndex); ***REMOVED*** : $.noop);
        ***REMOVED***,

        _createPagerPageNavButton: function(text, handler) {
            return this._createPagerButton(text, this.pagerNavButtonClass, handler);
        ***REMOVED***,

        _createPagerPage: function(pageIndex) {
            return this._createPagerButton(pageIndex, this.pageClass, function() {
                this.openPage(pageIndex);
            ***REMOVED***);
        ***REMOVED***,

        _createPagerButton: function(text, css, handler) {
            var $link = $("<a>").attr("href", EMPTY_HREF)
                .html(text)
                .on("click", $.proxy(handler, this));

            return $("<span>").addClass(css).append($link);
        ***REMOVED***,

        _createPagerCurrentPage: function() {
            return $("<span>")
                .addClass(this.pageClass)
                .addClass(this.currentPageClass)
                .text(this.pageIndex);
        ***REMOVED***,

        _refreshSize: function() {
            this._refreshHeight();
            this._refreshWidth();
        ***REMOVED***,

        _refreshWidth: function() {
            var $headerGrid = this._headerGrid,
                $bodyGrid = this._bodyGrid,
                width = this.width;

            if(width === "auto") {
                $headerGrid.width("auto");
                width = $headerGrid.outerWidth();
            ***REMOVED***

            $headerGrid.width("");
            $bodyGrid.width("");
            this._container.width(width);
            width = $headerGrid.outerWidth();
            $bodyGrid.width(width);
        ***REMOVED***,

        _scrollBarWidth: (function() {
            var result;

            return function() {
                if(result === undefined) {
                    var $ghostContainer = $("<div style='width:50px;height:50px;overflow:hidden;position:absolute;top:-10000px;left:-10000px;'></div>");
                    var $ghostContent = $("<div style='height:100px;'></div>");
                    $ghostContainer.append($ghostContent).appendTo("body");
                    var width = $ghostContent.innerWidth();
                    $ghostContainer.css("overflow-y", "auto");
                    var widthExcludingScrollBar = $ghostContent.innerWidth();
                    $ghostContainer.remove();
                    result = width - widthExcludingScrollBar;
                ***REMOVED***
                return result;
            ***REMOVED***;
        ***REMOVED***)(),

        _refreshHeight: function() {
            var container = this._container,
                pagerContainer = this._pagerContainer,
                height = this.height,
                nonBodyHeight;

            container.height(height);

            if(height !== "auto") {
                height = container.height();

                nonBodyHeight = this._header.outerHeight(true);
                if(pagerContainer.parents(container).length) {
                    nonBodyHeight += pagerContainer.outerHeight(true);
                ***REMOVED***

                this._body.outerHeight(height - nonBodyHeight);
            ***REMOVED***
        ***REMOVED***,

        showPrevPages: function() {
            var firstDisplayingPage = this._firstDisplayingPage,
                pageButtonCount = this.pageButtonCount;

            this._firstDisplayingPage = (firstDisplayingPage > pageButtonCount) ? firstDisplayingPage - pageButtonCount : 1;

            this._refreshPager();
        ***REMOVED***,

        showNextPages: function() {
            var firstDisplayingPage = this._firstDisplayingPage,
                pageButtonCount = this.pageButtonCount,
                pageCount = this._pagesCount();

            this._firstDisplayingPage = (firstDisplayingPage + 2 * pageButtonCount > pageCount)
                ? pageCount - pageButtonCount + 1
                : firstDisplayingPage + pageButtonCount;

            this._refreshPager();
        ***REMOVED***,

        openPage: function(pageIndex) {
            if(pageIndex < 1 || pageIndex > this._pagesCount())
                return;

            this._setPage(pageIndex);
            this._loadStrategy.openPage(pageIndex);
        ***REMOVED***,

        _setPage: function(pageIndex) {
            var firstDisplayingPage = this._firstDisplayingPage,
                pageButtonCount = this.pageButtonCount;

            this.pageIndex = pageIndex;

            if(pageIndex < firstDisplayingPage) {
                this._firstDisplayingPage = pageIndex;
            ***REMOVED***

            if(pageIndex > firstDisplayingPage + pageButtonCount - 1) {
                this._firstDisplayingPage = pageIndex - pageButtonCount + 1;
            ***REMOVED***
        ***REMOVED***,

        _controllerCall: function(method, param, isCanceled, doneCallback) {
            if(isCanceled)
                return $.Deferred().reject().promise();

            this._showLoading();

            var controller = this._controller;
            if(!controller || !controller[method]) {
                throw Error("controller has no method '" + method + "'");
            ***REMOVED***

            return $.when(controller[method](param))
                .done($.proxy(doneCallback, this))
                .fail($.proxy(this._errorHandler, this))
                .always($.proxy(this._hideLoading, this));
        ***REMOVED***,

        _errorHandler: function() {
            this._callEventHandler(this.onError, {
                args: $.makeArray(arguments)
            ***REMOVED***);
        ***REMOVED***,

        _showLoading: function() {
            if(!this.loadIndication)
                return;

            clearTimeout(this._loadingTimer);

            this._loadingTimer = setTimeout($.proxy(function() {
                this._loadIndicator.show();
            ***REMOVED***, this), this.loadIndicationDelay);
        ***REMOVED***,

        _hideLoading: function() {
            if(!this.loadIndication)
                return;

            clearTimeout(this._loadingTimer);
            this._loadIndicator.hide();
        ***REMOVED***,

        search: function(filter) {
            this._resetSorting();
            this._resetPager();
            return this.loadData(filter);
        ***REMOVED***,

        loadData: function(filter) {
            filter = filter || (this.filtering ? this.getFilter() : {***REMOVED***);

            $.extend(filter, this._loadStrategy.loadParams(), this._sortingParams());

            var args = this._callEventHandler(this.onDataLoading, {
                filter: filter
            ***REMOVED***);

            return this._controllerCall("loadData", filter, args.cancel, function(loadedData) {
                if(!loadedData)
                    return;

                this._loadStrategy.finishLoad(loadedData);

                this._callEventHandler(this.onDataLoaded, {
                    data: loadedData
                ***REMOVED***);
            ***REMOVED***);
        ***REMOVED***,

        getFilter: function() {
            var result = {***REMOVED***;
            this._eachField(function(field) {
                if(field.filtering) {
                    this._setItemFieldValue(result, field, field.filterValue());
                ***REMOVED***
            ***REMOVED***);
            return result;
        ***REMOVED***,

        _sortingParams: function() {
            if(this.sorting && this._sortField) {
                return {
                    sortField: this._sortField.name,
                    sortOrder: this._sortOrder
                ***REMOVED***;
            ***REMOVED***
            return {***REMOVED***;
        ***REMOVED***,

        getSorting: function() {
            var sortingParams = this._sortingParams();
            return {
                field: sortingParams.sortField,
                order: sortingParams.sortOrder
            ***REMOVED***;
        ***REMOVED***,

        clearFilter: function() {
            var $filterRow = this._createFilterRow();
            this._filterRow.replaceWith($filterRow);
            this._filterRow = $filterRow;
            return this.search();
        ***REMOVED***,

        insertItem: function(item) {
            var insertingItem = item || this._getValidatedInsertItem();

            if(!insertingItem)
                return $.Deferred().reject().promise();

            var args = this._callEventHandler(this.onItemInserting, {
                item: insertingItem
            ***REMOVED***);

            return this._controllerCall("insertItem", insertingItem, args.cancel, function(insertedItem) {
                insertedItem = insertedItem || insertingItem;
                this._loadStrategy.finishInsert(insertedItem);

                this._callEventHandler(this.onItemInserted, {
                    item: insertedItem
                ***REMOVED***);
            ***REMOVED***);
        ***REMOVED***,

        _getValidatedInsertItem: function() {
            var item = this._getInsertItem();
            return this._validateItem(item, this._insertRow) ? item : null;
        ***REMOVED***,

        _getInsertItem: function() {
            var result = {***REMOVED***;
            this._eachField(function(field) {
                if(field.inserting) {
                    this._setItemFieldValue(result, field, field.insertValue());
                ***REMOVED***
            ***REMOVED***);
            return result;
        ***REMOVED***,

        _validateItem: function(item, $row) {
            var validationErrors = [];

            var args = {
                item: item,
                itemIndex: this._rowIndex($row),
                row: $row
            ***REMOVED***;

            this._eachField(function(field, index) {
                if(!field.validate)
                    return;

                var errors = this._validation.validate($.extend({
                    value: this._getItemFieldValue(item, field),
                    rules: field.validate
                ***REMOVED***, args));

                this._setCellValidity($row.children().eq(index), errors);

                if(!errors.length)
                    return;

                validationErrors.push.apply(validationErrors,
                    $.map(errors, function(message) {
                        return { field: field, message: message ***REMOVED***;
                    ***REMOVED***));
            ***REMOVED***);

            if(!validationErrors.length)
                return true;

            var invalidArgs = $.extend({
                errors: validationErrors
            ***REMOVED***, args);
            this._callEventHandler(this.onItemInvalid, invalidArgs);
            this.invalidNotify(invalidArgs);

            return false;
        ***REMOVED***,

        _setCellValidity: function($cell, errors) {
            $cell
                .toggleClass(this.invalidClass, !!errors.length)
                .attr("title", errors.join("\n"));
        ***REMOVED***,

        clearInsert: function() {
            var insertRow = this._createInsertRow();
            this._insertRow.replaceWith(insertRow);
            this._insertRow = insertRow;
            this.refresh();
        ***REMOVED***,

        editItem: function(item) {
            var $row = this.rowByItem(item);
            if($row.length) {
                this._editRow($row);
            ***REMOVED***
        ***REMOVED***,

        rowByItem: function(item) {
            if(item.jquery || item.nodeType)
                return $(item);

            return this._content.find("tr").filter(function() {
                return $.data(this, JSGRID_ROW_DATA_KEY) === item;
            ***REMOVED***);
        ***REMOVED***,

        _editRow: function($row) {
            if(!this.editing)
                return;

            var item = $row.data(JSGRID_ROW_DATA_KEY);

            var args = this._callEventHandler(this.onItemEditing, {
                row: $row,
                item: item,
                itemIndex: this._itemIndex(item)
            ***REMOVED***);

            if(args.cancel)
                return;

            if(this._editingRow) {
                this.cancelEdit();
            ***REMOVED***

            var $editRow = this._createEditRow(item);

            this._editingRow = $row;
            $row.hide();
            $editRow.insertBefore($row);
            $row.data(JSGRID_EDIT_ROW_DATA_KEY, $editRow);
        ***REMOVED***,

        _createEditRow: function(item) {
            if($.isFunction(this.editRowRenderer)) {
                return $(this.editRowRenderer(item, this._itemIndex(item)));
            ***REMOVED***

            var $result = $("<tr>").addClass(this.editRowClass);

            this._eachField(function(field) {
                var fieldValue = this._getItemFieldValue(item, field);

                this._prepareCell("<td>", field, "editcss")
                    .append(field.editTemplate ? field.editTemplate(fieldValue, item) : "")
                    .appendTo($result);
            ***REMOVED***);

            return $result;
        ***REMOVED***,

        updateItem: function(item, editedItem) {
            if(arguments.length === 1) {
                editedItem = item;
            ***REMOVED***

            var $row = item ? this.rowByItem(item) : this._editingRow;
            editedItem = editedItem || this._getValidatedEditedItem();

            if(!editedItem)
                return;

            return this._updateRow($row, editedItem);
        ***REMOVED***,

        _getValidatedEditedItem: function() {
            var item = this._getEditedItem();
            return this._validateItem(item, this._getEditRow()) ? item : null;
        ***REMOVED***,

        _updateRow: function($updatingRow, editedItem) {
            var updatingItem = $updatingRow.data(JSGRID_ROW_DATA_KEY),
                updatingItemIndex = this._itemIndex(updatingItem),
                previousItem = $.extend(true, {***REMOVED***, updatingItem);

            $.extend(true, updatingItem, editedItem);

            var args = this._callEventHandler(this.onItemUpdating, {
                row: $updatingRow,
                item: updatingItem,
                itemIndex: updatingItemIndex,
                previousItem: previousItem
            ***REMOVED***);

            return this._controllerCall("updateItem", updatingItem, args.cancel, function(updatedItem) {
                updatedItem = updatedItem || updatingItem;
                var $updatedRow = this._finishUpdate($updatingRow, updatedItem, updatingItemIndex);

                this._callEventHandler(this.onItemUpdated, {
                    row: $updatedRow,
                    item: updatedItem,
                    itemIndex: updatingItemIndex,
                    previousItem: previousItem
                ***REMOVED***);
            ***REMOVED***);
        ***REMOVED***,

        _rowIndex: function(row) {
            return this._content.children().index($(row));
        ***REMOVED***,

        _itemIndex: function(item) {
            return $.inArray(item, this.data);
        ***REMOVED***,

        _finishUpdate: function($updatingRow, updatedItem, updatedItemIndex) {
            this.cancelEdit();
            this.data[updatedItemIndex] = updatedItem;

            var $updatedRow = this._createRow(updatedItem, updatedItemIndex);
            $updatingRow.replaceWith($updatedRow);
            return $updatedRow;
        ***REMOVED***,

        _getEditedItem: function() {
            var result = {***REMOVED***;
            this._eachField(function(field) {
                if(field.editing) {
                    this._setItemFieldValue(result, field, field.editValue());
                ***REMOVED***
            ***REMOVED***);
            return result;
        ***REMOVED***,

        cancelEdit: function() {
            if(!this._editingRow)
                return;

            this._getEditRow().remove();
            this._editingRow.show();
            this._editingRow = null;
        ***REMOVED***,

        _getEditRow: function() {
            return this._editingRow.data(JSGRID_EDIT_ROW_DATA_KEY);
        ***REMOVED***,

        deleteItem: function(item) {
            var $row = this.rowByItem(item);

            if(!$row.length)
                return;

            if(this.confirmDeleting && !window.confirm(getOrApply(this.deleteConfirm, this, $row.data(JSGRID_ROW_DATA_KEY))))
                return;

            return this._deleteRow($row);
        ***REMOVED***,

        _deleteRow: function($row) {
            var deletingItem = $row.data(JSGRID_ROW_DATA_KEY),
                deletingItemIndex = this._itemIndex(deletingItem);

            var args = this._callEventHandler(this.onItemDeleting, {
                row: $row,
                item: deletingItem,
                itemIndex: deletingItemIndex
            ***REMOVED***);

            return this._controllerCall("deleteItem", deletingItem, args.cancel, function() {
                this._loadStrategy.finishDelete(deletingItem, deletingItemIndex);

                this._callEventHandler(this.onItemDeleted, {
                    row: $row,
                    item: deletingItem,
                    itemIndex: deletingItemIndex
                ***REMOVED***);
            ***REMOVED***);
        ***REMOVED***
    ***REMOVED***;

    $.fn.jsGrid = function(config) {
        var args = $.makeArray(arguments),
            methodArgs = args.slice(1),
            result = this;

        this.each(function() {
            var $element = $(this),
                instance = $element.data(JSGRID_DATA_KEY),
                methodResult;

            if(instance) {
                if(typeof config === "string") {
                    methodResult = instance[config].apply(instance, methodArgs);
                    if(methodResult !== undefined && methodResult !== instance) {
                        result = methodResult;
                        return false;
                    ***REMOVED***
                ***REMOVED*** else {
                    instance._detachWindowResizeCallback();
                    instance._init(config);
                    instance.render();
                ***REMOVED***
            ***REMOVED*** else {
                new Grid($element, config);
            ***REMOVED***
        ***REMOVED***);

        return result;
    ***REMOVED***;

    var fields = {***REMOVED***;

    var setDefaults = function(config) {
        var componentPrototype;

        if($.isPlainObject(config)) {
            componentPrototype = Grid.prototype;
        ***REMOVED*** else {
            componentPrototype = fields[config].prototype;
            config = arguments[1] || {***REMOVED***;
        ***REMOVED***

        $.extend(componentPrototype, config);
    ***REMOVED***;

    var locales = {***REMOVED***;

    var locale = function(lang) {
        var localeConfig = $.isPlainObject(lang) ? lang : locales[lang];

        if(!localeConfig)
            throw Error("unknown locale " + lang);

        setLocale(jsGrid, localeConfig);
    ***REMOVED***;

    var setLocale = function(obj, localeConfig) {
        $.each(localeConfig, function(field, value) {
            if($.isPlainObject(value)) {
                setLocale(obj[field] || obj[field[0].toUpperCase() + field.slice(1)], value);
                return;
            ***REMOVED***

            if(obj.hasOwnProperty(field)) {
                obj[field] = value;
            ***REMOVED*** else {
                obj.prototype[field] = value;
            ***REMOVED***
        ***REMOVED***);
    ***REMOVED***;

    window.jsGrid = {
        Grid: Grid,
        fields: fields,
        setDefaults: setDefaults,
        locales: locales,
        locale: locale
    ***REMOVED***;

***REMOVED***(window, jQuery));
