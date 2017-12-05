$.fn.easyPieChart = function(options) {
	return this.each(function() {
		var instanceOptions;

		if (!$.data(this, 'easyPieChart')) {
			instanceOptions = $.extend({***REMOVED***, options, $(this).data());
			$.data(this, 'easyPieChart', new EasyPieChart(this, instanceOptions));
		***REMOVED***
	***REMOVED***);
***REMOVED***;
