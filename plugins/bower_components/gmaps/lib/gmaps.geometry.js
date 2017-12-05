GMaps.prototype.drawPolyline = function(options) {
  var path = [],
      points = options.path;

  if (points.length) {
    if (points[0][0] === undefined) {
      path = points;
    ***REMOVED***
    else {
      for (var i = 0, latlng; latlng = points[i]; i++) {
        path.push(new google.maps.LatLng(latlng[0], latlng[1]));
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***

  var polyline_options = {
    map: this.map,
    path: path,
    strokeColor: options.strokeColor,
    strokeOpacity: options.strokeOpacity,
    strokeWeight: options.strokeWeight,
    geodesic: options.geodesic,
    clickable: true,
    editable: false,
    visible: true
  ***REMOVED***;

  if (options.hasOwnProperty("clickable")) {
    polyline_options.clickable = options.clickable;
  ***REMOVED***

  if (options.hasOwnProperty("editable")) {
    polyline_options.editable = options.editable;
  ***REMOVED***

  if (options.hasOwnProperty("icons")) {
    polyline_options.icons = options.icons;
  ***REMOVED***

  if (options.hasOwnProperty("zIndex")) {
    polyline_options.zIndex = options.zIndex;
  ***REMOVED***

  var polyline = new google.maps.Polyline(polyline_options);

  var polyline_events = ['click', 'dblclick', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup', 'rightclick'];

  for (var ev = 0; ev < polyline_events.length; ev++) {
    (function(object, name) {
      if (options[name]) {
        google.maps.event.addListener(object, name, function(e){
          options[name].apply(this, [e]);
        ***REMOVED***);
      ***REMOVED***
    ***REMOVED***)(polyline, polyline_events[ev]);
  ***REMOVED***

  this.polylines.push(polyline);

  GMaps.fire('polyline_added', polyline, this);

  return polyline;
***REMOVED***;

GMaps.prototype.removePolyline = function(polyline) {
  for (var i = 0; i < this.polylines.length; i++) {
    if (this.polylines[i] === polyline) {
      this.polylines[i].setMap(null);
      this.polylines.splice(i, 1);

      GMaps.fire('polyline_removed', polyline, this);

      break;
    ***REMOVED***
  ***REMOVED***
***REMOVED***;

GMaps.prototype.removePolylines = function() {
  for (var i = 0, item; item = this.polylines[i]; i++) {
    item.setMap(null);
  ***REMOVED***

  this.polylines = [];
***REMOVED***;

GMaps.prototype.drawCircle = function(options) {
  options =  extend_object({
    map: this.map,
    center: new google.maps.LatLng(options.lat, options.lng)
  ***REMOVED***, options);

  delete options.lat;
  delete options.lng;

  var polygon = new google.maps.Circle(options),
      polygon_events = ['click', 'dblclick', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup', 'rightclick'];

  for (var ev = 0; ev < polygon_events.length; ev++) {
    (function(object, name) {
      if (options[name]) {
        google.maps.event.addListener(object, name, function(e){
          options[name].apply(this, [e]);
        ***REMOVED***);
      ***REMOVED***
    ***REMOVED***)(polygon, polygon_events[ev]);
  ***REMOVED***

  this.polygons.push(polygon);

  return polygon;
***REMOVED***;

GMaps.prototype.drawRectangle = function(options) {
  options = extend_object({
    map: this.map
  ***REMOVED***, options);

  var latLngBounds = new google.maps.LatLngBounds(
    new google.maps.LatLng(options.bounds[0][0], options.bounds[0][1]),
    new google.maps.LatLng(options.bounds[1][0], options.bounds[1][1])
  );

  options.bounds = latLngBounds;

  var polygon = new google.maps.Rectangle(options),
      polygon_events = ['click', 'dblclick', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup', 'rightclick'];

  for (var ev = 0; ev < polygon_events.length; ev++) {
    (function(object, name) {
      if (options[name]) {
        google.maps.event.addListener(object, name, function(e){
          options[name].apply(this, [e]);
        ***REMOVED***);
      ***REMOVED***
    ***REMOVED***)(polygon, polygon_events[ev]);
  ***REMOVED***

  this.polygons.push(polygon);

  return polygon;
***REMOVED***;

GMaps.prototype.drawPolygon = function(options) {
  var useGeoJSON = false;

  if(options.hasOwnProperty("useGeoJSON")) {
    useGeoJSON = options.useGeoJSON;
  ***REMOVED***

  delete options.useGeoJSON;

  options = extend_object({
    map: this.map
  ***REMOVED***, options);

  if (useGeoJSON == false) {
    options.paths = [options.paths.slice(0)];
  ***REMOVED***

  if (options.paths.length > 0) {
    if (options.paths[0].length > 0) {
      options.paths = array_flat(array_map(options.paths, arrayToLatLng, useGeoJSON));
    ***REMOVED***
  ***REMOVED***

  var polygon = new google.maps.Polygon(options),
      polygon_events = ['click', 'dblclick', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup', 'rightclick'];

  for (var ev = 0; ev < polygon_events.length; ev++) {
    (function(object, name) {
      if (options[name]) {
        google.maps.event.addListener(object, name, function(e){
          options[name].apply(this, [e]);
        ***REMOVED***);
      ***REMOVED***
    ***REMOVED***)(polygon, polygon_events[ev]);
  ***REMOVED***

  this.polygons.push(polygon);

  GMaps.fire('polygon_added', polygon, this);

  return polygon;
***REMOVED***;

GMaps.prototype.removePolygon = function(polygon) {
  for (var i = 0; i < this.polygons.length; i++) {
    if (this.polygons[i] === polygon) {
      this.polygons[i].setMap(null);
      this.polygons.splice(i, 1);

      GMaps.fire('polygon_removed', polygon, this);

      break;
    ***REMOVED***
  ***REMOVED***
***REMOVED***;

GMaps.prototype.removePolygons = function() {
  for (var i = 0, item; item = this.polygons[i]; i++) {
    item.setMap(null);
  ***REMOVED***

  this.polygons = [];
***REMOVED***;
