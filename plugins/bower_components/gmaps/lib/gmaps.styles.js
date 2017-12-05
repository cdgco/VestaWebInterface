GMaps.prototype.addStyle = function(options) {
  var styledMapType = new google.maps.StyledMapType(options.styles, { name: options.styledMapName ***REMOVED***);

  this.map.mapTypes.set(options.mapTypeId, styledMapType);
***REMOVED***;

GMaps.prototype.setStyle = function(mapTypeId) {
  this.map.setMapTypeId(mapTypeId);
***REMOVED***;
