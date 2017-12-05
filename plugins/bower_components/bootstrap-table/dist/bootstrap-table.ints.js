 var data = [
    {
        "name": "bootstrap-table",
        "stargazers_count": "526",
        "forks_count": "122",
        "description": "An extended Bootstrap table with radio, checkbox, sort, pagination, and other added features. (supports twitter bootstrap v2 and v3) "
    ***REMOVED***,
    {
        "name": "multiple-select",
        "stargazers_count": "288",
        "forks_count": "150",
        "description": "A jQuery plugin to select multiple elements with checkboxes :)"
    ***REMOVED***,
    {
        "name": "bootstrap-show-password",
        "stargazers_count": "32",
        "forks_count": "11",
        "description": "Show/hide password plugin for twitter bootstrap."
    ***REMOVED***,
    {
        "name": "blog",
        "stargazers_count": "13",
        "forks_count": "4",
        "description": "my blog"
    ***REMOVED***,
    {
        "name": "scutech-redmine",
        "stargazers_count": "6",
        "forks_count": "3",
        "description": "Redmine notification tools for chrome extension."
    ***REMOVED***
];

$(function () {
    $('#smptable').bootstrapTable({
        data: data
    ***REMOVED***);
***REMOVED***);


/*table column*/

function buildTable($el, cells, rows) {
    var i, j, row,
        columns = [],
        data = [];

    for (i = 0; i < cells; i++) {
        columns.push({
            field: 'field' + i,
            title: 'Cell' + i
        ***REMOVED***);
    ***REMOVED***
    for (i = 0; i < rows; i++) {
        row = {***REMOVED***;
        for (j = 0; j < cells; j++) {
            row['field' + j] = 'Row-' + i + '-' + j;
        ***REMOVED***
        data.push(row);
    ***REMOVED***
    $el.bootstrapTable('destroy').bootstrapTable({
        columns: columns,
        data: data
    ***REMOVED***);
***REMOVED***

$(function () {
    buildTable($('#clmtable'), 50, 50);
***REMOVED***);

