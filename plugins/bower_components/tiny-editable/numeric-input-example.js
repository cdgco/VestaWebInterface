/* global $ */
/* this is an example for validation and change events */
$.fn.numericInputExample = function () {
	'use strict';
	var element = $(this),
		footer = element.find('tfoot tr'),
		dataRows = element.find('tbody tr'),
		initialTotal = function () {
			var column, total;
			for (column = 1; column < footer.children().size(); column++) {
				total = 0;
				dataRows.each(function () {
					var row = $(this);
					total += parseFloat(row.children().eq(column).text());
				***REMOVED***);
				footer.children().eq(column).text(total);
			***REMOVED***;
		***REMOVED***;
	element.find('td').on('change', function (evt) {
		var cell = $(this),
			column = cell.index(),
			total = 0;
		if (column === 0) {
			return;
		***REMOVED***
		element.find('tbody tr').each(function () {
			var row = $(this);
			total += parseFloat(row.children().eq(column).text());
		***REMOVED***);
		if (column === 1 && total > 5000) {
			$('.alert').show();
			return false; // changes can be rejected
		***REMOVED*** else {
			$('.alert').hide();
			footer.children().eq(column).text(total);
		***REMOVED***
	***REMOVED***).on('validate', function (evt, value) {
		var cell = $(this),
			column = cell.index();
		if (column === 0) {
			return !!value && value.trim().length > 0;
		***REMOVED*** else {
			return !isNaN(parseFloat(value)) && isFinite(value);
		***REMOVED***
	***REMOVED***);
	initialTotal();
	return this;
***REMOVED***;
