GMaps.prototype.createMarker = function(options) {
  if (options.lat == undefined && options.lng == undefined && options.position == undefined) {
    throw 'No latitude or longitude defined.';
  ***REMOVED***

  var self = this,
      details = options.details,
      fences = options.fences,
      outside = options.outside,
      base_options = {
        position: new google.maps.LatLng(options.lat, options.lng),
        map: null
      ***REMOVED***,
      marker_options = extend_object(base_options, options);

  delete marker_options.lat;
  delete marker_options.lng;
  delete marker_options.fences;
  delete marker_options.outside;

  var marker = new google.maps.Marker(marker_options);

  marker.fences = fences;

  if (options.infoWindow) {
    marker.infoWindow = new google.maps.InfoWindow(options.infoWindow);

    var info_window_events = ['closeclick', 'content_changed', 'domready', 'position_changed', 'zindex_changed'];

    for (var ev = 0; ev < info_window_events.length; ev++) {
      (function(object, name) {
        if (options.infoWindow[name]) {
          google.maps.event.addListener(object, name, function(e){
            options.infoWindow[name].apply(this, [e]);
          ***REMOVED***);
        ***REMOVED***
      ***REMOVED***)(marker.infoWindow, info_window_events[ev]);
    ***REMOVED***
  ***REMOVED***

  var marker_events = ['animation_changed', 'clickable_changed', 'cursor_changed', 'draggable_changed', 'flat_changed', 'icon_changed', 'position_changed', 'shadow_changed', 'shape_changed', 'title_changed', 'visible_changed', 'zindex_changed'];

  var marker_events_with_mouse = ['dblclick', 'drag', 'dragend', 'dragstart', 'mousedown', 'mouseout', 'mouseover', 'mouseup'];

  for (var ev = 0; ev < marker_events.length; ev++) {
    (function(object, name) {
      if (options[name]) {
        google.maps.event.addListener(object, name, function(){
          options[name].apply(this, [this]);
        ***REMOVED***);
      ***REMOVED***
    ***REMOVED***)(marker, marker_events[ev]);
  ***REMOVED***

  for (var ev = 0; ev < marker_events_with_mouse.length; ev++) {
    (function(map, object, name) {
      if (options[name]) {
        google.maps.event.addListener(object, name, function(me){
          if(!me.pixel){
            me.pixel = map.getProjection().fromLatLngToPoint(me.latLng)
          ***REMOVED***
          
          options[name].apply(this, [me]);
        ***REMOVED***);
      ***REMOVED***
    ***REMOVED***)(this.map, marker, marker_events_with_mouse[ev]);
  ***REMOVED***

  google.maps.event.addListener(marker, 'click', function() {
    this.details = details;

    if (options.click) {
      options.click.apply(this, [this]);
    ***REMOVED***

    if (marker.infoWindow) {
      self.hideInfoWindows();
      marker.infoWindow.open(self.map, marker);
    ***REMOVED***
  ***REMOVED***);

  google.maps.event.addListener(marker, 'rightclick', function(e) {
    e.marker = this;

    if (options.rightclick) {
      options.rightclick.apply(this, [e]);
    ***REMOVED***

    if (window.context_menu[self.el.id]['marker'] != undefined) {
      self.buildContextMenu('marker', e);
    ***REMOVED***
  ***REMOVED***);

  if (marker.fences) {
    google.maps.event.addListener(marker, 'dragend', function() {
      self.checkMarkerGeofence(marker, function(m, f) {
        outside(m, f);
      ***REMOVED***);
    ***REMOVED***);
  ***REMOVED***

  return marker;
***REMOVED***;

GMaps.prototype.addMarker = function(options) {
  var marker;
  if(options.hasOwnProperty('gm_accessors_')) {
    // Native google.maps.Marker object
    marker = options;
  ***REMOVED***
  else {
    if ((options.hasOwnProperty('lat') && options.hasOwnProperty('lng')) || options.position) {
      marker = this.createMarker(options);
    ***REMOVED***
    else {
      throw 'No latitude or longitude defined.';
    ***REMOVED***
  ***REMOVED***

  marker.setMap(this.map);

  if(this.markerClusterer) {
    this.markerClusterer.addMarker(marker);
  ***REMOVED***

  this.markers.push(marker);

  GMaps.fire('marker_added', marker, this);

  return marker;
***REMOVED***;

GMaps.prototype.addMarkers = function(array) {
  for (var i = 0, marker; marker=array[i]; i++) {
    this.addMarker(marker);
  ***REMOVED***

  return this.markers;
***REMOVED***;

GMaps.prototype.hideInfoWindows = function() {
  for (var i = 0, marker; marker = this.markers[i]; i++){
    if (marker.infoWindow) {
      marker.infoWindow.close();
    ***REMOVED***
  ***REMOVED***
***REMOVED***;

GMaps.prototype.removeMarker = function(marker) {
  for (var i = 0; i < this.markers.length; i++) {
    if (this.markers[i] === marker) {
      this.markers[i].setMap(null);
      this.markers.splice(i, 1);

      if(this.markerClusterer) {
        this.markerClusterer.removeMarker(marker);
      ***REMOVED***

      GMaps.fire('marker_removed', marker, this);

      break;
    ***REMOVED***
  ***REMOVED***

  return marker;
***REMOVED***;

GMaps.prototype.removeMarkers = function (collection) {
  var new_markers = [];

  if (typeof collection == 'undefined') {
    for (var i = 0; i < this.markers.length; i++) {
      var marker = this.markers[i];
      marker.setMap(null);

      if(this.markerClusterer) {
        this.markerClusterer.removeMarker(marker);
      ***REMOVED***

      GMaps.fire('marker_removed', marker, this);
    ***REMOVED***
    
    this.markers = new_markers;
  ***REMOVED***
  else {
    for (var i = 0; i < collection.length; i++) {
      var index = this.markers.indexOf(collection[i]);

      if (index > -1) {
        var marker = this.markers[index];
        marker.setMap(null);

        if(this.markerClusterer) {
          this.markerClusterer.removeMarker(marker);
        ***REMOVED***

        GMaps.fire('marker_removed', marker, this);
      ***REMOVED***
    ***REMOVED***

    for (var i = 0; i < this.markers.length; i++) {
      var marker = this.markers[i];
      if (marker.getMap() != null) {
        new_markers.push(marker);
      ***REMOVED***
    ***REMOVED***

    this.markers = new_markers;
  ***REMOVED***
***REMOVED***;
