GMaps.prototype.on = function(event_name, handler) {
  return GMaps.on(event_name, this, handler);
***REMOVED***;

GMaps.prototype.off = function(event_name) {
  GMaps.off(event_name, this);
***REMOVED***;

GMaps.custom_events = ['marker_added', 'marker_removed', 'polyline_added', 'polyline_removed', 'polygon_added', 'polygon_removed', 'geolocated', 'geolocation_failed'];

GMaps.on = function(event_name, object, handler) {
  if (GMaps.custom_events.indexOf(event_name) == -1) {
    if(object instanceof GMaps) object = object.map; 
    return google.maps.event.addListener(object, event_name, handler);
  ***REMOVED***
  else {
    var registered_event = {
      handler : handler,
      eventName : event_name
    ***REMOVED***;

    object.registered_events[event_name] = object.registered_events[event_name] || [];
    object.registered_events[event_name].push(registered_event);

    return registered_event;
  ***REMOVED***
***REMOVED***;

GMaps.off = function(event_name, object) {
  if (GMaps.custom_events.indexOf(event_name) == -1) {
    if(object instanceof GMaps) object = object.map; 
    google.maps.event.clearListeners(object, event_name);
  ***REMOVED***
  else {
    object.registered_events[event_name] = [];
  ***REMOVED***
***REMOVED***;

GMaps.fire = function(event_name, object, scope) {
  if (GMaps.custom_events.indexOf(event_name) == -1) {
    google.maps.event.trigger(object, event_name, Array.prototype.slice.apply(arguments).slice(2));
  ***REMOVED***
  else {
    if(event_name in scope.registered_events) {
      var firing_events = scope.registered_events[event_name];

      for(var i = 0; i < firing_events.length; i++) {
        (function(handler, scope, object) {
          handler.apply(scope, [object]);
        ***REMOVED***)(firing_events[i]['handler'], scope, object);
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***
***REMOVED***;
