! function(document, window, $) {
    "use strict";
    var Site = window.Site;
    $(document).ready(function($) {
            
        ***REMOVED***), jsGrid.setDefaults({
            tableClass: "jsgrid-table table table-striped table-hover"
        ***REMOVED***), jsGrid.setDefaults("text", {
            _createTextBox: function() {
                return $("<input>").attr("type", "text").attr("class", "form-control input-sm");
            ***REMOVED***
        ***REMOVED***), jsGrid.setDefaults("number", {
            _createTextBox: function() {
                return $("<input>").attr("type", "number").attr("class", "form-control input-sm");
            ***REMOVED***
        ***REMOVED***), jsGrid.setDefaults("textarea", {
            _createTextBox: function() {
                return $("<input>").attr("type", "textarea").attr("class", "form-control");
            ***REMOVED***
        ***REMOVED***), jsGrid.setDefaults("control", {
            _createGridButton: function(cls, tooltip, clickHandler) {
                var grid = this._grid;
                return $("<button>").addClass(this.buttonClass).addClass(cls).attr({
                    type: "button",
                    title: tooltip
                ***REMOVED***).on("click", function(e) {
                    clickHandler(grid, e);
                ***REMOVED***);
            ***REMOVED***
        ***REMOVED***), jsGrid.setDefaults("select", {
            _createSelect: function() {
                var $result = $("<select>").attr("class", "form-control input-sm"),
                    valueField = this.valueField,
                    textField = this.textField,
                    selectedIndex = this.selectedIndex;
                return $.each(this.items, function(index, item) {
                    var value = valueField ? item[valueField] : index,
                        text = textField ? item[textField] : item,
                        $option = $("<option>").attr("value", value).text(text).appendTo($result);
                    $option.prop("selected", selectedIndex === index);
                ***REMOVED***), $result;
            ***REMOVED***
        ***REMOVED***),
        function() {
            $("#basicgrid").jsGrid({
                height: "500px",
                width: "100%",
                filtering: !0,
                editing: !0,
                sorting: !0,
                paging: !0,
                autoload: !0,
                pageSize: 15,
                pageButtonCount: 5,
                deleteConfirm: "Do you really want to delete the client?",
                controller: db,
                fields: [{
                    name: "Name",
                    type: "text",
                    width: 150
                ***REMOVED***, {
                    name: "Age",
                    type: "number",
                    width: 70
                ***REMOVED***, {
                    name: "Address",
                    type: "text",
                    width: 200
                ***REMOVED***, {
                    name: "Country",
                    type: "select",
                    items: db.countries,
                    valueField: "Id",
                    textField: "Name"
                ***REMOVED***, {
                    name: "Married",
                    type: "checkbox",
                    title: "Is Married",
                    sorting: !1
                ***REMOVED***, {
                    type: "control"
                ***REMOVED***]
            ***REMOVED***)
        ***REMOVED***(),
        function() {
            $("#staticgrid").jsGrid({
                height: "500px",
                width: "100%",
                sorting: !0,
                paging: !0,
                data: db.clients,
                fields: [{
                    name: "Name",
                    type: "text",
                    width: 150
                ***REMOVED***, {
                    name: "Age",
                    type: "number",
                    width: 70
                ***REMOVED***, {
                    name: "Address",
                    type: "text",
                    width: 200
                ***REMOVED***, {
                    name: "Country",
                    type: "select",
                    items: db.countries,
                    valueField: "Id",
                    textField: "Name"
                ***REMOVED***, {
                    name: "Married",
                    type: "checkbox",
                    title: "Is Married"
                ***REMOVED***]
            ***REMOVED***)
        ***REMOVED***(),
        
        function() {
            $("#exampleSorting").jsGrid({
                height: "500px",
                width: "100%",
                autoload: !0,
                selecting: !1,
                controller: db,
                fields: [{
                    name: "Name",
                    type: "text",
                    width: 150
                ***REMOVED***, {
                    name: "Age",
                    type: "number",
                    width: 50
                ***REMOVED***, {
                    name: "Address",
                    type: "text",
                    width: 200
                ***REMOVED***, {
                    name: "Country",
                    type: "select",
                    items: db.countries,
                    valueField: "Id",
                    textField: "Name"
                ***REMOVED***, {
                    name: "Married",
                    type: "checkbox",
                    title: "Is Married"
                ***REMOVED***]
            ***REMOVED***), $("#sortingField").on("change", function() {
                var field = $(this).val();
                $("#exampleSorting").jsGrid("sort", field)
            ***REMOVED***);
        ***REMOVED***(),
        
        function() {
            var MyDateField = function(config) {
                jsGrid.Field.call(this, config);
            ***REMOVED***;
            MyDateField.prototype = new jsGrid.Field({
                sorter: function(date1, date2) {
                    return new Date(date1) - new Date(date2);
                ***REMOVED***,
                itemTemplate: function(value) {
                    return new Date(value).toDateString();
                ***REMOVED***,
                insertTemplate: function() {
                    if (!this.inserting) { return ""; ***REMOVED***
                    var $result = this.insertControl = this._createTextBox();
                    return $result
                ***REMOVED***,
                editTemplate: function(value) {
                    if (!this.editing) return this.itemTemplate(value);
                    var $result = this.editControl = this._createTextBox();
                    return $result.val(value), $result;
                ***REMOVED***,
                insertValue: function() {
                    return this.insertControl.datepicker("getDate");
                ***REMOVED***,
                editValue: function() {
                    return this.editControl.datepicker("getDate");
                ***REMOVED***,
                _createTextBox: function() {
                    return $("<input>").attr("type", "text").addClass("form-control input-sm").datepicker({
                        autoclose: !0
                    ***REMOVED***);
                ***REMOVED***
            ***REMOVED***), jsGrid.fields.myDateField = MyDateField, $("#exampleCustomGridField").jsGrid({
                height: "500px",
                width: "100%",
                inserting: !0,
                editing: !0,
                sorting: !0,
                paging: !0,
                data: db.users,
                fields: [{
                    name: "Account",
                    width: 150,
                    align: "center"
                ***REMOVED***, {
                    name: "Name",
                    type: "text"
                ***REMOVED***, {
                    name: "RegisterDate",
                    type: "myDateField",
                    width: 100,
                    align: "center"
                ***REMOVED***, {
                    type: "control",
                    editButton: !1,
                    modeSwitchButton: !1
                ***REMOVED***]
            ***REMOVED***)
        ***REMOVED***();
***REMOVED***(document, window, jQuery);
