GMaps.prototype.toImage = function(options) {
  var options = options || {***REMOVED***,
      static_map_options = {***REMOVED***;

  static_map_options['size'] = options['size'] || [this.el.clientWidth, this.el.clientHeight];
  static_map_options['lat'] = this.getCenter().lat();
  static_map_options['lng'] = this.getCenter().lng();

  if (this.markers.length > 0) {
    static_map_options['markers'] = [];
    
    for (var i = 0; i < this.markers.length; i++) {
      static_map_options['markers'].push({
        lat: this.markers[i].getPosition().lat(),
        lng: this.markers[i].getPosition().lng()
      ***REMOVED***);
    ***REMOVED***
  ***REMOVED***

  if (this.polylines.length > 0) {
    var polyline = this.polylines[0];
    
    static_map_options['polyline'] = {***REMOVED***;
    static_map_options['polyline']['path'] = google.maps.geometry.encoding.encodePath(polyline.getPath());
    static_map_options['polyline']['strokeColor'] = polyline.strokeColor
    static_map_options['polyline']['strokeOpacity'] = polyline.strokeOpacity
    static_map_options['polyline']['strokeWeight'] = polyline.strokeWeight
  ***REMOVED***

  return GMaps.staticMapURL(static_map_options);
***REMOVED***;

GMaps.staticMapURL = function(options){
  var parameters = [],
      data,
      static_root = (location.protocol === 'file:' ? 'http:' : location.protocol ) + '//maps.googleapis.com/maps/api/staticmap';

  if (options.url) {
    static_root = options.url;
    delete options.url;
  ***REMOVED***

  static_root += '?';

  var markers = options.markers;
  
  delete options.markers;

  if (!markers && options.marker) {
    markers = [options.marker];
    delete options.marker;
  ***REMOVED***

  var styles = options.styles;

  delete options.styles;

  var polyline = options.polyline;
  delete options.polyline;

  /** Map options **/
  if (options.center) {
    parameters.push('center=' + options.center);
    delete options.center;
  ***REMOVED***
  else if (options.address) {
    parameters.push('center=' + options.address);
    delete options.address;
  ***REMOVED***
  else if (options.lat) {
    parameters.push(['center=', options.lat, ',', options.lng].join(''));
    delete options.lat;
    delete options.lng;
  ***REMOVED***
  else if (options.visible) {
    var visible = encodeURI(options.visible.join('|'));
    parameters.push('visible=' + visible);
  ***REMOVED***

  var size = options.size;
  if (size) {
    if (size.join) {
      size = size.join('x');
    ***REMOVED***
    delete options.size;
  ***REMOVED***
  else {
    size = '630x300';
  ***REMOVED***
  parameters.push('size=' + size);

  if (!options.zoom && options.zoom !== false) {
    options.zoom = 15;
  ***REMOVED***

  var sensor = options.hasOwnProperty('sensor') ? !!options.sensor : true;
  delete options.sensor;
  parameters.push('sensor=' + sensor);

  for (var param in options) {
    if (options.hasOwnProperty(param)) {
      parameters.push(param + '=' + options[param]);
    ***REMOVED***
  ***REMOVED***

  /** Markers **/
  if (markers) {
    var marker, loc;

    for (var i = 0; data = markers[i]; i++) {
      marker = [];

      if (data.size && data.size !== 'normal') {
        marker.push('size:' + data.size);
        delete data.size;
      ***REMOVED***
      else if (data.icon) {
        marker.push('icon:' + encodeURI(data.icon));
        delete data.icon;
      ***REMOVED***

      if (data.color) {
        marker.push('color:' + data.color.replace('#', '0x'));
        delete data.color;
      ***REMOVED***

      if (data.label) {
        marker.push('label:' + data.label[0].toUpperCase());
        delete data.label;
      ***REMOVED***

      loc = (data.address ? data.address : data.lat + ',' + data.lng);
      delete data.address;
      delete data.lat;
      delete data.lng;

      for(var param in data){
        if (data.hasOwnProperty(param)) {
          marker.push(param + ':' + data[param]);
        ***REMOVED***
      ***REMOVED***

      if (marker.length || i === 0) {
        marker.push(loc);
        marker = marker.join('|');
        parameters.push('markers=' + encodeURI(marker));
      ***REMOVED***
      // New marker without styles
      else {
        marker = parameters.pop() + encodeURI('|' + loc);
        parameters.push(marker);
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***

  /** Map Styles **/
  if (styles) {
    for (var i = 0; i < styles.length; i++) {
      var styleRule = [];
      if (styles[i].featureType){
        styleRule.push('feature:' + styles[i].featureType.toLowerCase());
      ***REMOVED***

      if (styles[i].elementType) {
        styleRule.push('element:' + styles[i].elementType.toLowerCase());
      ***REMOVED***

      for (var j = 0; j < styles[i].stylers.length; j++) {
        for (var p in styles[i].stylers[j]) {
          var ruleArg = styles[i].stylers[j][p];
          if (p == 'hue' || p == 'color') {
            ruleArg = '0x' + ruleArg.substring(1);
          ***REMOVED***
          styleRule.push(p + ':' + ruleArg);
        ***REMOVED***
      ***REMOVED***

      var rule = styleRule.join('|');
      if (rule != '') {
        parameters.push('style=' + rule);
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***

  /** Polylines **/
  function parseColor(color, opacity) {
    if (color[0] === '#'){
      color = color.replace('#', '0x');

      if (opacity) {
        opacity = parseFloat(opacity);
        opacity = Math.min(1, Math.max(opacity, 0));
        if (opacity === 0) {
          return '0x00000000';
        ***REMOVED***
        opacity = (opacity * 255).toString(16);
        if (opacity.length === 1) {
          opacity += opacity;
        ***REMOVED***

        color = color.slice(0,8) + opacity;
      ***REMOVED***
    ***REMOVED***
    return color;
  ***REMOVED***

  if (polyline) {
    data = polyline;
    polyline = [];

    if (data.strokeWeight) {
      polyline.push('weight:' + parseInt(data.strokeWeight, 10));
    ***REMOVED***

    if (data.strokeColor) {
      var color = parseColor(data.strokeColor, data.strokeOpacity);
      polyline.push('color:' + color);
    ***REMOVED***

    if (data.fillColor) {
      var fillcolor = parseColor(data.fillColor, data.fillOpacity);
      polyline.push('fillcolor:' + fillcolor);
    ***REMOVED***

    var path = data.path;
    if (path.join) {
      for (var j=0, pos; pos=path[j]; j++) {
        polyline.push(pos.join(','));
      ***REMOVED***
    ***REMOVED***
    else {
      polyline.push('enc:' + path);
    ***REMOVED***

    polyline = polyline.join('|');
    parameters.push('path=' + encodeURI(polyline));
  ***REMOVED***

  /** Retina support **/
  var dpi = window.devicePixelRatio || 1;
  parameters.push('scale=' + dpi);

  parameters = parameters.join('&');
  return static_root + parameters;
***REMOVED***;
