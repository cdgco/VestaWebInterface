GMaps.geolocate = function(options) {
  var complete_callback = options.always || options.complete;

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      options.success(position);

      if (complete_callback) {
        complete_callback();
      ***REMOVED***
    ***REMOVED***, function(error) {
      options.error(error);

      if (complete_callback) {
        complete_callback();
      ***REMOVED***
    ***REMOVED***, options.options);
  ***REMOVED***
  else {
    options.not_supported();

    if (complete_callback) {
      complete_callback();
    ***REMOVED***
  ***REMOVED***
***REMOVED***;

GMaps.geocode = function(options) {
  this.geocoder = new google.maps.Geocoder();
  var callback = options.callback;
  if (options.hasOwnProperty('lat') && options.hasOwnProperty('lng')) {
    options.latLng = new google.maps.LatLng(options.lat, options.lng);
  ***REMOVED***

  delete options.lat;
  delete options.lng;
  delete options.callback;
  
  this.geocoder.geocode(options, function(results, status) {
    callback(results, status);
  ***REMOVED***);
***REMOVED***;
