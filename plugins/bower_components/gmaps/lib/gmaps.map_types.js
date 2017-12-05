GMaps.prototype.addMapType = function(mapTypeId, options) {
  if (options.hasOwnProperty("getTileUrl") && typeof(options["getTileUrl"]) == "function") {
    options.tileSize = options.tileSize || new google.maps.Size(256, 256);

    var mapType = new google.maps.ImageMapType(options);

    this.map.mapTypes.set(mapTypeId, mapType);
  ***REMOVED***
  else {
    throw "'getTileUrl' function required.";
  ***REMOVED***
***REMOVED***;

GMaps.prototype.addOverlayMapType = function(options) {
  if (options.hasOwnProperty("getTile") && typeof(options["getTile"]) == "function") {
    var overlayMapTypeIndex = options.index;

    delete options.index;

    this.map.overlayMapTypes.insertAt(overlayMapTypeIndex, options);
  ***REMOVED***
  else {
    throw "'getTile' function required.";
  ***REMOVED***
***REMOVED***;

GMaps.prototype.removeOverlayMapType = function(overlayMapTypeIndex) {
  this.map.overlayMapTypes.removeAt(overlayMapTypeIndex);
***REMOVED***;
