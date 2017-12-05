/*
Holder.js - client side image placeholders
© 2012-2014 Ivan Malopinsky - http://imsky.co
*/
(function(register, global, undefined) {

	//Constants and definitions

	var SVG_NS = 'http://www.w3.org/2000/svg';
	var document = global.document;

	var Holder = {
		/**
		 * Adds a theme to default settings
		 *
		 * @param {string***REMOVED*** name Theme name
		 * @param {Object***REMOVED*** theme Theme object, with foreground, background, size, font, and fontweight properties.
		 */
		addTheme: function(name, theme) {
			name != null && theme != null && (App.settings.themes[name] = theme);
			delete App.vars.cache.themeKeys;
			return this;
		***REMOVED***,

		/**
		 * Appends a placeholder to an element
		 *
		 * @param {string***REMOVED*** src Placeholder URL string
		 * @param {string***REMOVED*** el Selector of target element(s)
		 */
		addImage: function(src, el) {
			var node = document.querySelectorAll(el);
			if (node.length) {
				for (var i = 0, l = node.length; i < l; i++) {
					var img = newEl('img');
					setAttr(img, {
						'data-src': src
					***REMOVED***);
					node[i].appendChild(img);
				***REMOVED***
			***REMOVED***
			return this;
		***REMOVED***,

		/**
		 * Runs Holder with options. By default runs Holder on all images with "holder.js" in their source attributes.
		 *
		 * @param {Object***REMOVED*** userOptions Options object, can contain domain, themes, images, and bgnodes properties
		 */
		run: function(userOptions) {
			userOptions = userOptions || {***REMOVED***;
			var renderSettings = {***REMOVED***;

			App.vars.preempted = true;

			var options = extend(App.settings, userOptions);

			renderSettings.renderer = options.renderer ? options.renderer : App.setup.renderer;
			if (App.setup.renderers.join(',').indexOf(renderSettings.renderer) === -1) {
				renderSettings.renderer = App.setup.supportsSVG ? 'svg' : (App.setup.supportsCanvas ? 'canvas' : 'html');
			***REMOVED***

			//< v2.4 API compatibility
			if (options.use_canvas) {
				renderSettings.renderer = 'canvas';
			***REMOVED*** else if (options.use_svg) {
				renderSettings.renderer = 'svg';
			***REMOVED***

			var images = getNodeArray(options.images);
			var bgnodes = getNodeArray(options.bgnodes);
			var stylenodes = getNodeArray(options.stylenodes);
			var objects = getNodeArray(options.objects);

			renderSettings.stylesheets = [];
			renderSettings.svgXMLStylesheet = true;
			renderSettings.noFontFallback = options.noFontFallback ? options.noFontFallback : false;

			for (var i = 0; i < stylenodes.length; i++) {
				var styleNode = stylenodes[i];
				if (styleNode.attributes.rel && styleNode.attributes.href && styleNode.attributes.rel.value == 'stylesheet') {
					var href = styleNode.attributes.href.value;
					//todo: write isomorphic relative-to-absolute URL function
					var proxyLink = newEl('a');
					proxyLink.href = href;
					var stylesheetURL = proxyLink.protocol + '//' + proxyLink.host + proxyLink.pathname + proxyLink.search;
					renderSettings.stylesheets.push(stylesheetURL);
				***REMOVED***
			***REMOVED***

			for (i = 0; i < bgnodes.length; i++) {
				var backgroundImage = global.getComputedStyle(bgnodes[i], null).getPropertyValue('background-image');
				var dataBackgroundImage = bgnodes[i].getAttribute('data-background-src');
				var rawURL = null;

				if (dataBackgroundImage == null) {
					rawURL = backgroundImage;
				***REMOVED*** else {
					rawURL = dataBackgroundImage;
				***REMOVED***

				var holderURL = null;
				var holderString = '?' + options.domain + '/';

				if (rawURL.indexOf(holderString) === 0) {
					holderURL = rawURL.slice(1);
				***REMOVED*** else if (rawURL.indexOf(holderString) != -1) {
					var fragment = rawURL.substr(rawURL.indexOf(holderString)).slice(1);
					var fragmentMatch = fragment.match(/([^\"]*)"?\)/);

					if (fragmentMatch != null) {
						holderURL = fragmentMatch[1];
					***REMOVED***
				***REMOVED***

				if (holderURL != null) {
					var holderFlags = parseURL(holderURL, options);
					if (holderFlags) {
						prepareDOMElement('background', bgnodes[i], holderFlags, renderSettings);
					***REMOVED***
				***REMOVED***
			***REMOVED***

			for (i = 0; i < objects.length; i++) {
				var object = objects[i];
				var objectAttr = {***REMOVED***;

				try {
					objectAttr.data = object.getAttribute('data');
					objectAttr.dataSrc = object.getAttribute('data-src');
				***REMOVED*** catch (e) {***REMOVED***

				var objectHasSrcURL = objectAttr.data != null && objectAttr.data.indexOf(options.domain) === 0;
				var objectHasDataSrcURL = objectAttr.dataSrc != null && objectAttr.dataSrc.indexOf(options.domain) === 0;

				if (objectHasSrcURL) {
					prepareImageElement(options, renderSettings, objectAttr.data, object);
				***REMOVED*** else if (objectHasDataSrcURL) {
					prepareImageElement(options, renderSettings, objectAttr.dataSrc, object);
				***REMOVED***
			***REMOVED***

			for (i = 0; i < images.length; i++) {
				var image = images[i];
				var imageAttr = {***REMOVED***;

				try {
					imageAttr.src = image.getAttribute('src');
					imageAttr.dataSrc = image.getAttribute('data-src');
					imageAttr.rendered = image.getAttribute('data-holder-rendered');
				***REMOVED*** catch (e) {***REMOVED***

				var imageHasSrc = imageAttr.src != null;
				var imageHasDataSrcURL = imageAttr.dataSrc != null && imageAttr.dataSrc.indexOf(options.domain) === 0;
				var imageRendered = imageAttr.rendered != null && imageAttr.rendered == 'true';

				if (imageHasSrc) {
					if (imageAttr.src.indexOf(options.domain) === 0) {
						prepareImageElement(options, renderSettings, imageAttr.src, image);
					***REMOVED*** else if (imageHasDataSrcURL) {
						//Image has a valid data-src and an invalid src
						if (imageRendered) {
							//If the placeholder has already been render, re-render it
							prepareImageElement(options, renderSettings, imageAttr.dataSrc, image);
						***REMOVED*** else {
							//If the placeholder has not been rendered, check if the image exists and render a fallback if it doesn't
              (function(src, options, renderSettings, dataSrc, image){
                imageExists(src, function(exists){
                  if(!exists){
                    prepareImageElement(options, renderSettings, dataSrc, image);
                  ***REMOVED***
                ***REMOVED***);
              ***REMOVED***)(imageAttr.src, options, renderSettings, imageAttr.dataSrc, image);
						***REMOVED***
					***REMOVED***
				***REMOVED*** else if (imageHasDataSrcURL) {
					prepareImageElement(options, renderSettings, imageAttr.dataSrc, image);
				***REMOVED***
			***REMOVED***

			return this;
		***REMOVED***,
		//todo: remove invisibleErrorFn for 2.5
		invisibleErrorFn: function(fn) {
			return function(el) {
				if (el.hasAttribute('data-holder-invisible')) {
					throw 'Holder: invisible placeholder';
				***REMOVED***
			***REMOVED***;
		***REMOVED***
	***REMOVED***;

	//< v2.4 API compatibility

	Holder.add_theme = Holder.addTheme;
	Holder.add_image = Holder.addImage;
	Holder.invisible_error_fn = Holder.invisibleErrorFn;

	var App = {
		settings: {
			domain: 'holder.js',
			images: 'img',
			objects: 'object',
			bgnodes: 'body .holderjs',
			stylenodes: 'head link.holderjs',
			stylesheets: [],
			themes: {
				'gray': {
					background: '#EEEEEE',
					foreground: '#AAAAAA'
				***REMOVED***,
				'social': {
					background: '#3a5a97',
					foreground: '#FFFFFF'
				***REMOVED***,
				'industrial': {
					background: '#434A52',
					foreground: '#C2F200'
				***REMOVED***,
				'sky': {
					background: '#0D8FDB',
					foreground: '#FFFFFF'
				***REMOVED***,
				'vine': {
					background: '#39DBAC',
					foreground: '#1E292C'
				***REMOVED***,
				'lava': {
					background: '#F8591A',
					foreground: '#1C2846'
				***REMOVED***
			***REMOVED***
		***REMOVED***,
    defaults: {
      size: 10,
      units: 'pt',
      scale: 1/16
    ***REMOVED***,
		flags: {
			dimensions: {
				regex: /^(\d+)x(\d+)$/,
				output: function(val) {
					var exec = this.regex.exec(val);
					return {
						width: +exec[1],
						height: +exec[2]
					***REMOVED***;
				***REMOVED***
			***REMOVED***,
			fluid: {
				regex: /^([0-9]+%?)x([0-9]+%?)$/,
				output: function(val) {
					var exec = this.regex.exec(val);
					return {
						width: exec[1],
						height: exec[2]
					***REMOVED***;
				***REMOVED***
			***REMOVED***,
			colors: {
				regex: /(?:#|\^)([0-9a-f]{3,***REMOVED***)\:(?:#|\^)([0-9a-f]{3,***REMOVED***)/i,
				output: function(val) {
					var exec = this.regex.exec(val);
					return {
						foreground: '#' + exec[2],
						background: '#' + exec[1]
					***REMOVED***;
				***REMOVED***
			***REMOVED***,
			text: {
				regex: /text\:(.*)/,
				output: function(val) {
					return this.regex.exec(val)[1].replace('\\/', '/');
				***REMOVED***
			***REMOVED***,
			font: {
				regex: /font\:(.*)/,
				output: function(val) {
					return this.regex.exec(val)[1];
				***REMOVED***
			***REMOVED***,
			auto: {
				regex: /^auto$/
			***REMOVED***,
			textmode: {
				regex: /textmode\:(.*)/,
				output: function(val) {
					return this.regex.exec(val)[1];
				***REMOVED***
			***REMOVED***,
			random: {
				regex: /^random$/
			***REMOVED***
		***REMOVED***
	***REMOVED***;

	/**
	 * Processes provided source attribute and sets up the appropriate rendering workflow
	 *
	 * @private
	 * @param options Instance options from Holder.run
	 * @param renderSettings Instance configuration
	 * @param src Image URL
	 * @param el Image DOM element
	 */
	function prepareImageElement(options, renderSettings, src, el) {
		var holderFlags = parseURL(src.substr(src.lastIndexOf(options.domain)), options);
		if (holderFlags) {
			prepareDOMElement(null, el, holderFlags, renderSettings);
		***REMOVED***
	***REMOVED***

	/**
	 * Processes a Holder URL and extracts flags
	 *
	 * @private
	 * @param url URL
	 * @param options Instance options from Holder.run
	 */
	function parseURL(url, options) {
		var ret = {
			theme: extend(App.settings.themes.gray, null),
			stylesheets: options.stylesheets,
			holderURL: []
		***REMOVED***;
		var render = false;
		var vtab = String.fromCharCode(11);
		var flags = url.replace(/([^\\])\//g, '$1' + vtab).split(vtab);
		var uriRegex = /%[0-9a-f]{2***REMOVED***/gi;
		for (var fl = flags.length, j = 0; j < fl; j++) {
			var flag = flags[j];
			if (flag.match(uriRegex)) {
				try {
					flag = decodeURIComponent(flag);
				***REMOVED*** catch (e) {
					flag = flags[j];
				***REMOVED***
			***REMOVED***

			var push = false;

			if (App.flags.dimensions.match(flag)) {
				render = true;
				ret.dimensions = App.flags.dimensions.output(flag);
				push = true;
			***REMOVED*** else if (App.flags.fluid.match(flag)) {
				render = true;
				ret.dimensions = App.flags.fluid.output(flag);
				ret.fluid = true;
				push = true;
			***REMOVED*** else if (App.flags.textmode.match(flag)) {
				ret.textmode = App.flags.textmode.output(flag);
				push = true;
			***REMOVED*** else if (App.flags.colors.match(flag)) {
				var colors = App.flags.colors.output(flag);
				ret.theme = extend(ret.theme, colors);
				//todo: convert implicit theme use to a theme: flag
				push = true;
			***REMOVED*** else if (options.themes[flag]) {
				//If a theme is specified, it will override custom colors
				if (options.themes.hasOwnProperty(flag)) {
					ret.theme = extend(options.themes[flag], null);
				***REMOVED***
				push = true;
			***REMOVED*** else if (App.flags.font.match(flag)) {
				ret.font = App.flags.font.output(flag);
				push = true;
			***REMOVED*** else if (App.flags.auto.match(flag)) {
				ret.auto = true;
				push = true;
			***REMOVED*** else if (App.flags.text.match(flag)) {
				ret.text = App.flags.text.output(flag);
				push = true;
			***REMOVED*** else if (App.flags.random.match(flag)) {
				if (App.vars.cache.themeKeys == null) {
					App.vars.cache.themeKeys = Object.keys(options.themes);
				***REMOVED***
				var theme = App.vars.cache.themeKeys[0 | Math.random() * App.vars.cache.themeKeys.length];
				ret.theme = extend(options.themes[theme], null);
				push = true;
			***REMOVED***

			if (push) {
				ret.holderURL.push(flag);
			***REMOVED***
		***REMOVED***
		ret.holderURL.unshift(options.domain);
		ret.holderURL = ret.holderURL.join('/');
		return render ? ret : false;
	***REMOVED***

	/**
	 * Modifies the DOM to fit placeholders and sets up resizable image callbacks (for fluid and automatically sized placeholders)
	 *
	 * @private
	 * @param el Image DOM element
	 * @param flags Placeholder-specific configuration
	 * @param _renderSettings Instance configuration
	 */
	function prepareDOMElement(mode, el, flags, _renderSettings) {
		var dimensions = flags.dimensions,
			theme = flags.theme;
		var dimensionsCaption = dimensions.width + 'x' + dimensions.height;
		mode = mode == null ? (flags.fluid ? 'fluid' : 'image') : mode;

		if (flags.text != null) {
			theme.text = flags.text;

			//<object> SVG embedding doesn't parse Unicode properly
			if (el.nodeName.toLowerCase() === 'object') {
				var textLines = theme.text.split('\\n');
				for (var k = 0; k < textLines.length; k++) {
					textLines[k] = encodeHtmlEntity(textLines[k]);
				***REMOVED***
				theme.text = textLines.join('\\n');
			***REMOVED***
		***REMOVED***

		var holderURL = flags.holderURL;
		var renderSettings = extend(_renderSettings, null);

		if (flags.font) {
			theme.font = flags.font;
			//Only run the <canvas> webfont fallback if noFontFallback is false, if the node is not an image, and if canvas is supported
			if (!renderSettings.noFontFallback && el.nodeName.toLowerCase() === 'img' && App.setup.supportsCanvas && renderSettings.renderer === 'svg') {
				renderSettings = extend(renderSettings, {
					renderer: 'canvas'
				***REMOVED***);
			***REMOVED***
		***REMOVED***

		//Chrome and Opera require a quick 10ms re-render if web fonts are used with canvas
		if (flags.font && renderSettings.renderer == 'canvas') {
			renderSettings.reRender = true;
		***REMOVED***

		if (mode == 'background') {
			if (el.getAttribute('data-background-src') == null) {
				setAttr(el, {
					'data-background-src': holderURL
				***REMOVED***);
			***REMOVED***
		***REMOVED*** else {
			setAttr(el, {
				'data-src': holderURL
			***REMOVED***);
		***REMOVED***

		flags.theme = theme;

		el.holderData = {
			flags: flags,
			renderSettings: renderSettings
		***REMOVED***;

		if (mode == 'image' || mode == 'fluid') {
			setAttr(el, {
				'alt': (theme.text ? (theme.text.length > 16 ? theme.text.substring(0, 16) + '…' : theme.text) + ' [' + dimensionsCaption + ']' : dimensionsCaption)
			***REMOVED***);
		***REMOVED***

		if (mode == 'image') {
			if (renderSettings.renderer == 'html' || !flags.auto) {
				el.style.width = dimensions.width + 'px';
				el.style.height = dimensions.height + 'px';
			***REMOVED***
			if (renderSettings.renderer == 'html') {
				el.style.backgroundColor = theme.background;
			***REMOVED*** else {
				render(mode, {
					dimensions: dimensions,
					theme: theme,
					flags: flags
				***REMOVED***, el, renderSettings);

				if (flags.textmode && flags.textmode == 'exact') {
					App.vars.resizableImages.push(el);
					updateResizableElements(el);
				***REMOVED***
			***REMOVED***
		***REMOVED*** else if (mode == 'background' && renderSettings.renderer != 'html') {
			render(mode, {
					dimensions: dimensions,
					theme: theme,
					flags: flags
				***REMOVED***,
				el, renderSettings);
		***REMOVED*** else if (mode == 'fluid') {
			if (dimensions.height.slice(-1) == '%') {
				el.style.height = dimensions.height;
			***REMOVED*** else if (flags.auto == null || !flags.auto) {
				el.style.height = dimensions.height + 'px';
			***REMOVED***
			if (dimensions.width.slice(-1) == '%') {
				el.style.width = dimensions.width;
			***REMOVED*** else if (flags.auto == null || !flags.auto) {
				el.style.width = dimensions.width + 'px';
			***REMOVED***
			if (el.style.display == 'inline' || el.style.display === '' || el.style.display == 'none') {
				el.style.display = 'block';
			***REMOVED***

			setInitialDimensions(el);

			if (renderSettings.renderer == 'html') {
				el.style.backgroundColor = theme.background;
			***REMOVED*** else {
				App.vars.resizableImages.push(el);
				updateResizableElements(el);
			***REMOVED***
		***REMOVED***
	***REMOVED***

	/**
	 * Core function that takes output from renderers and sets it as the source or background-image of the target element
	 *
	 * @private
	 * @param mode Placeholder mode, either background or image
	 * @param params Placeholder-specific parameters
	 * @param el Image DOM element
	 * @param renderSettings Instance configuration
	 */

	function render(mode, params, el, renderSettings) {
		var image = null;

		switch (renderSettings.renderer) {
			case 'svg':
				if (!App.setup.supportsSVG) return;
				break;
			case 'canvas':
				if (!App.setup.supportsCanvas) return;
				break;
			default:
				return;
		***REMOVED***

		//todo: move generation of scene up to flag generation to reduce extra object creation
		var scene = {
			width: params.dimensions.width,
			height: params.dimensions.height,
			theme: params.theme,
			flags: params.flags
		***REMOVED***;

		var sceneGraph = buildSceneGraph(scene);

		var rendererParams = {
			text: scene.text,
			width: scene.width,
			height: scene.height,
			textHeight: scene.font.size,
			font: scene.font.family,
			fontWeight: scene.font.weight,
			template: scene.theme
		***REMOVED***;

		function getRenderedImage() {
			var image = null;
			switch (renderSettings.renderer) {
				case 'canvas':
					image = sgCanvasRenderer(sceneGraph);
					break;
				case 'svg':
					image = sgSVGRenderer(sceneGraph, renderSettings);
					break;
				default:
					throw 'Holder: invalid renderer: ' + renderSettings.renderer;
			***REMOVED***
			return image;
		***REMOVED***

		image = getRenderedImage();

		if (image == null) {
			throw 'Holder: couldn\'t render placeholder';
		***REMOVED***

		//todo: add <object> canvas rendering
		if (mode == 'background') {
			el.style.backgroundImage = 'url(' + image + ')';
			el.style.backgroundSize = scene.width + 'px ' + scene.height + 'px';
		***REMOVED*** else {
			if (el.nodeName.toLowerCase() === 'img') {
				setAttr(el, {
					'src': image
				***REMOVED***);
			***REMOVED*** else if (el.nodeName.toLowerCase() === 'object') {
				setAttr(el, {
					'data': image
				***REMOVED***);
				setAttr(el, {
					'type': 'image/svg+xml'
				***REMOVED***);
			***REMOVED***
			if (renderSettings.reRender) {
				setTimeout(function() {
					var image = getRenderedImage();
					if (image == null) {
						throw 'Holder: couldn\'t render placeholder';
					***REMOVED***
					if (el.nodeName.toLowerCase() === 'img') {
						setAttr(el, {
							'src': image
						***REMOVED***);
					***REMOVED*** else if (el.nodeName.toLowerCase() === 'object') {
						setAttr(el, {
							'data': image
						***REMOVED***);
						setAttr(el, {
							'type': 'image/svg+xml'
						***REMOVED***);
					***REMOVED***
				***REMOVED***, 100);
			***REMOVED***
		***REMOVED***
		setAttr(el, {
			'data-holder-rendered': true
		***REMOVED***);
	***REMOVED***

	/**
	 * Core function that takes a Holder scene description and builds a scene graph
	 *
	 * @private
	 * @param scene Holder scene object
	 */
	function buildSceneGraph(scene) {
		scene.font = {
			family: scene.theme.font ? scene.theme.font : 'Arial, Helvetica, Open Sans, sans-serif',
			size: textSize(scene.width, scene.height, scene.theme.size ? scene.theme.size : App.defaults.size),
      units: scene.theme.units ? scene.theme.units : App.defaults.units,
			weight: scene.theme.fontweight ? scene.theme.fontweight : 'bold'
		***REMOVED***;
		scene.text = scene.theme.text ? scene.theme.text : Math.floor(scene.width) + 'x' + Math.floor(scene.height);

		switch (scene.flags.textmode) {
			case 'literal':
				scene.text = scene.flags.dimensions.width + 'x' + scene.flags.dimensions.height;
				break;
			case 'exact':
				if (!scene.flags.exactDimensions) break;
				scene.text = Math.floor(scene.flags.exactDimensions.width) + 'x' + Math.floor(scene.flags.exactDimensions.height);
				break;
		***REMOVED***

		var sceneGraph = new SceneGraph({
			width: scene.width,
			height: scene.height
		***REMOVED***);

		var Shape = sceneGraph.Shape;

		var holderBg = new Shape.Rect('holderBg', {
			fill: scene.theme.background
		***REMOVED***);

		holderBg.resize(scene.width, scene.height);
		sceneGraph.root.add(holderBg);

		var holderTextGroup = new Shape.Group('holderTextGroup', {
			text: scene.text,
			align: 'center',
			font: scene.font,
			fill: scene.theme.foreground
		***REMOVED***);

		holderTextGroup.moveTo(null, null, 1);
		sceneGraph.root.add(holderTextGroup);

		var tpdata = holderTextGroup.textPositionData = stagingRenderer(sceneGraph);
		if (!tpdata) {
			throw 'Holder: staging fallback not supported yet.';
		***REMOVED***
		holderTextGroup.properties.leading = tpdata.boundingBox.height;

		//todo: alignment: TL, TC, TR, CL, CR, BL, BC, BR
		var textNode = null;
		var line = null;

		function finalizeLine(parent, line, width, height) {
			line.width = width;
			line.height = height;
			parent.width = Math.max(parent.width, line.width);
			parent.height += line.height;
			parent.add(line);
		***REMOVED***

		if (tpdata.lineCount > 1) {
			var offsetX = 0;
			var offsetY = 0;
			var maxLineWidth = scene.width * App.setup.lineWrapRatio;
			var lineIndex = 0;
			line = new Shape.Group('line' + lineIndex);

			for (var i = 0; i < tpdata.words.length; i++) {
				var word = tpdata.words[i];
				textNode = new Shape.Text(word.text);
				var newline = word.text == '\\n';
				if (offsetX + word.width >= maxLineWidth || newline === true) {
					finalizeLine(holderTextGroup, line, offsetX, holderTextGroup.properties.leading);
					offsetX = 0;
					offsetY += holderTextGroup.properties.leading;
					lineIndex += 1;
					line = new Shape.Group('line' + lineIndex);
					line.y = offsetY;
				***REMOVED***
				if (newline === true) {
					continue;
				***REMOVED***
				textNode.moveTo(offsetX, 0);
				offsetX += tpdata.spaceWidth + word.width;
				line.add(textNode);
			***REMOVED***

			finalizeLine(holderTextGroup, line, offsetX, holderTextGroup.properties.leading);

			for (var lineKey in holderTextGroup.children) {
				line = holderTextGroup.children[lineKey];
				line.moveTo(
					(holderTextGroup.width - line.width) / 2,
					null,
					null);
			***REMOVED***

			holderTextGroup.moveTo(
				(scene.width - holderTextGroup.width) / 2, (scene.height - holderTextGroup.height) / 2,
				null);

			//If the text exceeds vertical space, move it down so the first line is visible
			if ((scene.height - holderTextGroup.height) / 2 < 0) {
				holderTextGroup.moveTo(null, 0, null);
			***REMOVED***
		***REMOVED*** else {
			textNode = new Shape.Text(scene.text);
			line = new Shape.Group('line0');
			line.add(textNode);
			holderTextGroup.add(line);

			holderTextGroup.moveTo(
				(scene.width - tpdata.boundingBox.width) / 2, (scene.height - tpdata.boundingBox.height) / 2,
				null);
		***REMOVED***

		//todo: renderlist

		return sceneGraph;
	***REMOVED***

	/**
	 * Adaptive text sizing function
	 *
	 * @private
	 * @param width Parent width
	 * @param height Parent height
	 * @param fontSize Requested text size
	 */
	function textSize(width, height, fontSize) {
		height = parseInt(height, 10);
		width = parseInt(width, 10);
		var bigSide = Math.max(height, width);
		var smallSide = Math.min(height, width);
		var scale = App.defaults.scale;
		var newHeight = Math.min(smallSide * 0.75, 0.75 * bigSide * scale);
		return Math.round(Math.max(fontSize, newHeight));
	***REMOVED***

	/**
	 * Iterates over resizable (fluid or auto) placeholders and renders them
	 *
	 * @private
	 * @param element Optional element selector, specified only if a specific element needs to be re-rendered
	 */
	function updateResizableElements(element) {
		var images;
		if (element == null || element.nodeType == null) {
			images = App.vars.resizableImages;
		***REMOVED*** else {
			images = [element];
		***REMOVED***
		for (var i in images) {
			if (!images.hasOwnProperty(i)) {
				continue;
			***REMOVED***
			var el = images[i];
			if (el.holderData) {
				var flags = el.holderData.flags;
				var dimensions = dimensionCheck(el, Holder.invisibleErrorFn(updateResizableElements));
				if (dimensions) {
					if (flags.fluid && flags.auto) {
						var fluidConfig = el.holderData.fluidConfig;
						switch (fluidConfig.mode) {
							case 'width':
								dimensions.height = dimensions.width / fluidConfig.ratio;
								break;
							case 'height':
								dimensions.width = dimensions.height * fluidConfig.ratio;
								break;
						***REMOVED***
					***REMOVED***

					var drawParams = {
						dimensions: dimensions,
						theme: flags.theme,
						flags: flags
					***REMOVED***;

					if (flags.textmode && flags.textmode == 'exact') {
						flags.exactDimensions = dimensions;
						drawParams.dimensions = flags.dimensions;
					***REMOVED***

					render('image', drawParams, el, el.holderData.renderSettings);
				***REMOVED***
			***REMOVED***
		***REMOVED***
	***REMOVED***

	/**
	 * Checks if an element is visible
	 *
	 * @private
	 * @param el DOM element
	 * @param callback Callback function executed if the element is invisible
	 */
	function dimensionCheck(el, callback) {
		var dimensions = {
			height: el.clientHeight,
			width: el.clientWidth
		***REMOVED***;
		if (!dimensions.height && !dimensions.width) {
			setAttr(el, {
				'data-holder-invisible': true
			***REMOVED***);
			callback.call(this, el);
		***REMOVED*** else {
			el.removeAttribute('data-holder-invisible');
			return dimensions;
		***REMOVED***
	***REMOVED***

	/**
	 * Sets up aspect ratio metadata for fluid placeholders, in order to preserve proportions when resizing
	 *
	 * @private
	 * @param el Image DOM element
	 */
	function setInitialDimensions(el) {
		if (el.holderData) {
			var dimensions = dimensionCheck(el, Holder.invisibleErrorFn(setInitialDimensions));
			if (dimensions) {
				var flags = el.holderData.flags;

				var fluidConfig = {
					fluidHeight: flags.dimensions.height.slice(-1) == '%',
					fluidWidth: flags.dimensions.width.slice(-1) == '%',
					mode: null,
					initialDimensions: dimensions
				***REMOVED***;

				if (fluidConfig.fluidWidth && !fluidConfig.fluidHeight) {
					fluidConfig.mode = 'width';
					fluidConfig.ratio = fluidConfig.initialDimensions.width / parseFloat(flags.dimensions.height);
				***REMOVED*** else if (!fluidConfig.fluidWidth && fluidConfig.fluidHeight) {
					fluidConfig.mode = 'height';
					fluidConfig.ratio = parseFloat(flags.dimensions.width) / fluidConfig.initialDimensions.height;
				***REMOVED***

				el.holderData.fluidConfig = fluidConfig;
			***REMOVED***
		***REMOVED***
	***REMOVED***

	//todo: see if possible to convert stagingRenderer to use HTML only
	var stagingRenderer = (function() {
		var svg = null,
			stagingText = null,
			stagingTextNode = null;
		return function(graph) {
			var rootNode = graph.root;
			if (App.setup.supportsSVG) {
				var firstTimeSetup = false;
				var tnode = function(text) {
					return document.createTextNode(text);
				***REMOVED***;
				if (svg == null) {
					firstTimeSetup = true;
				***REMOVED***
				svg = initSVG(svg, rootNode.properties.width, rootNode.properties.height);
				if (firstTimeSetup) {
					stagingText = newEl('text', SVG_NS);
					stagingTextNode = tnode(null);
					setAttr(stagingText, {
						x: 0
					***REMOVED***);
					stagingText.appendChild(stagingTextNode);
					svg.appendChild(stagingText);
					document.body.appendChild(svg);
					svg.style.visibility = 'hidden';
					svg.style.position = 'absolute';
					svg.style.top = '-100%';
					svg.style.left = '-100%';
					//todo: workaround for zero-dimension <svg> tag in Opera 12
					//svg.setAttribute('width', 0);
					//svg.setAttribute('height', 0);
				***REMOVED***

				var holderTextGroup = rootNode.children.holderTextGroup;
				var htgProps = holderTextGroup.properties;
				setAttr(stagingText, {
					'y': htgProps.font.size,
					'style': cssProps({
						'font-weight': htgProps.font.weight,
						'font-size': htgProps.font.size + htgProps.font.units,
						'font-family': htgProps.font.family,
						'dominant-baseline': 'middle'
					***REMOVED***)
				***REMOVED***);

				//Get bounding box for the whole string (total width and height)
				stagingTextNode.nodeValue = htgProps.text;
				var stagingTextBBox = stagingText.getBBox();

				//Get line count and split the string into words
				var lineCount = Math.ceil(stagingTextBBox.width / (rootNode.properties.width * App.setup.lineWrapRatio));
				var words = htgProps.text.split(' ');
				var newlines = htgProps.text.match(/\\n/g);
				lineCount += newlines == null ? 0 : newlines.length;

				//Get bounding box for the string with spaces removed
				stagingTextNode.nodeValue = htgProps.text.replace(/[ ]+/g, '');
				var computedNoSpaceLength = stagingText.getComputedTextLength();

				//Compute average space width
				var diffLength = stagingTextBBox.width - computedNoSpaceLength;
				var spaceWidth = Math.round(diffLength / Math.max(1, words.length - 1));

				//Get widths for every word with space only if there is more than one line
				var wordWidths = [];
				if (lineCount > 1) {
					stagingTextNode.nodeValue = '';
					for (var i = 0; i < words.length; i++) {
						if (words[i].length === 0) continue;
						stagingTextNode.nodeValue = decodeHtmlEntity(words[i]);
						var bbox = stagingText.getBBox();
						wordWidths.push({
							text: words[i],
							width: bbox.width
						***REMOVED***);
					***REMOVED***
				***REMOVED***

				return {
					spaceWidth: spaceWidth,
					lineCount: lineCount,
					boundingBox: stagingTextBBox,
					words: wordWidths
				***REMOVED***;
			***REMOVED*** else {
				//todo: canvas fallback for measuring text on android 2.3
				return false;
			***REMOVED***
		***REMOVED***;
	***REMOVED***)();

	var sgCanvasRenderer = (function() {
		var canvas = newEl('canvas');
		var ctx = null;

		return function(sceneGraph) {
			if (ctx == null) {
				ctx = canvas.getContext('2d');
			***REMOVED***
			var root = sceneGraph.root;
			canvas.width = App.dpr(root.properties.width);
			canvas.height = App.dpr(root.properties.height);
			ctx.textBaseline = 'middle';

			ctx.fillStyle = root.children.holderBg.properties.fill;
			ctx.fillRect(0, 0, App.dpr(root.children.holderBg.width), App.dpr(root.children.holderBg.height));

			var textGroup = root.children.holderTextGroup;
			var tgProps = textGroup.properties;
			ctx.font = textGroup.properties.font.weight + ' ' + App.dpr(textGroup.properties.font.size) + textGroup.properties.font.units + ' ' + textGroup.properties.font.family + ', monospace';
			ctx.fillStyle = textGroup.properties.fill;

			for (var lineKey in textGroup.children) {
				var line = textGroup.children[lineKey];
				for (var wordKey in line.children) {
					var word = line.children[wordKey];
					var x = App.dpr(textGroup.x + line.x + word.x);
					var y = App.dpr(textGroup.y + line.y + word.y + (textGroup.properties.leading / 2));

					ctx.fillText(word.properties.text, x, y);
				***REMOVED***
			***REMOVED***

			return canvas.toDataURL('image/png');
		***REMOVED***;
	***REMOVED***)();

	var sgSVGRenderer = (function() {
		//Prevent IE <9 from initializing SVG renderer
		if (!global.XMLSerializer) return;
		var svg = initSVG(null, 0, 0);
		var bgEl = newEl('rect', SVG_NS);
		svg.appendChild(bgEl);

		//todo: create a reusable pool for textNodes, resize if more words present

		return function(sceneGraph, renderSettings) {
			var root = sceneGraph.root;

			initSVG(svg, root.properties.width, root.properties.height);
			var groups = svg.querySelectorAll('g');

			for (var i = 0; i < groups.length; i++) {
				groups[i].parentNode.removeChild(groups[i]);
			***REMOVED***

			setAttr(bgEl, {
				'width': root.children.holderBg.width,
				'height': root.children.holderBg.height,
				'fill': root.children.holderBg.properties.fill
			***REMOVED***);

			var textGroup = root.children.holderTextGroup;
			var tgProps = textGroup.properties;
			var textGroupEl = newEl('g', SVG_NS);
			svg.appendChild(textGroupEl);

			for (var lineKey in textGroup.children) {
				var line = textGroup.children[lineKey];
				for (var wordKey in line.children) {
					var word = line.children[wordKey];
					var x = textGroup.x + line.x + word.x;
					var y = textGroup.y + line.y + word.y + (textGroup.properties.leading / 2);

					var textEl = newEl('text', SVG_NS);
					var textNode = document.createTextNode(null);

					setAttr(textEl, {
						'x': x,
						'y': y,
						'style': cssProps({
							'fill': tgProps.fill,
							'font-weight': tgProps.font.weight,
							'font-family': tgProps.font.family + ', monospace',
							'font-size': tgProps.font.size + tgProps.font.units,
							'dominant-baseline': 'central'
						***REMOVED***)
					***REMOVED***);

					textNode.nodeValue = word.properties.text;
					textEl.appendChild(textNode);
					textGroupEl.appendChild(textEl);
				***REMOVED***
			***REMOVED***

			var svgString = 'data:image/svg+xml;base64,' +
				btoa(unescape(encodeURIComponent(serializeSVG(svg, renderSettings))));
			return svgString;
		***REMOVED***;
	***REMOVED***)();

	//Helpers

	/**
	 * Generic new DOM element function
	 *
	 * @private
	 * @param tag Tag to create
	 * @param namespace Optional namespace value
	 */
	function newEl(tag, namespace) {
		if (namespace == null) {
			return document.createElement(tag);
		***REMOVED*** else {
			return document.createElementNS(namespace, tag);
		***REMOVED***
	***REMOVED***

	/**
	 * Generic setAttribute function
	 *
	 * @private
	 * @param el Reference to DOM element
	 * @param attrs Object with attribute keys and values
	 */
	function setAttr(el, attrs) {
		for (var a in attrs) {
			el.setAttribute(a, attrs[a]);
		***REMOVED***
	***REMOVED***

	/**
	 * Generic SVG element creation function
	 *
	 * @private
	 * @param svg SVG context, set to null if new
	 * @param width Document width
	 * @param height Document height
	 */
	function initSVG(svg, width, height) {
		if (svg == null) {
			svg = newEl('svg', SVG_NS);
			var defs = newEl('defs', SVG_NS);
			svg.appendChild(defs);
		***REMOVED***
		//IE throws an exception if this is set and Chrome requires it to be set
		if (svg.webkitMatchesSelector) {
			svg.setAttribute('xmlns', SVG_NS);
		***REMOVED***

		setAttr(svg, {
			'width': width,
			'height': height,
			'viewBox': '0 0 ' + width + ' ' + height,
			'preserveAspectRatio': 'none'
		***REMOVED***);
		return svg;
	***REMOVED***

	/**
	 * Generic SVG serialization function
	 *
	 * @private
	 * @param svg SVG context
	 * @param stylesheets CSS stylesheets to include
	 */
	function serializeSVG(svg, renderSettings) {
		if (!global.XMLSerializer) return;
		var serializer = new XMLSerializer();
		var svgCSS = '';
		var stylesheets = renderSettings.stylesheets;
		var defs = svg.querySelector('defs');

		//External stylesheets: Processing Instruction method
		if (renderSettings.svgXMLStylesheet) {
			var xml = new DOMParser().parseFromString('<xml />', 'application/xml');
			//Add <?xml-stylesheet ***REMOVED*** directives
			for (var i = stylesheets.length - 1; i >= 0; i--) {
				var csspi = xml.createProcessingInstruction('xml-stylesheet', 'href="' + stylesheets[i] + '" rel="stylesheet"');
				xml.insertBefore(csspi, xml.firstChild);
			***REMOVED***

			//Add <?xml ... ***REMOVED*** UTF-8 directive
			var xmlpi = xml.createProcessingInstruction('xml', 'version="1.0" encoding="UTF-8" standalone="yes"');
			xml.insertBefore(xmlpi, xml.firstChild);
			xml.removeChild(xml.documentElement);
			svgCSS = serializer.serializeToString(xml);
		***REMOVED***

		/*

		//External stylesheets: <link> method
		if (renderSettings.svgLinkStylesheet) {

			defs.removeChild(defs.firstChild);
			for (i = 0; i < stylesheets.length; i++) {
				var link = document.createElementNS('http://www.w3.org/1999/xhtml', 'link');
				link.setAttribute('href', stylesheets[i]);
				link.setAttribute('rel', 'stylesheet');
				link.setAttribute('type', 'text/css');
				defs.appendChild(link);
			***REMOVED***
		***REMOVED***

		//External stylesheets: <style> and @import method
		if (renderSettings.svgImportStylesheet) {
			var style = document.createElementNS(SVG_NS, 'style');
			var styleText = [];

			for (i = 0; i < stylesheets.length; i++) {
				styleText.push('@import url(' + stylesheets[i] + ');');
			***REMOVED***

			var styleTextNode = document.createTextNode(styleText.join('\n'));
			style.appendChild(styleTextNode);
			defs.appendChild(style);
		***REMOVED***

		*/

		var svgText = serializer.serializeToString(svg);
		svgText = svgText.replace(/\&amp;(\#[0-9]{2,***REMOVED***\;)/g, '&$1');
		return svgCSS + svgText;
	***REMOVED***

	/**
	 * Shallow object clone and merge
	 *
	 * @param a Object A
	 * @param b Object B
	 * @returns {Object***REMOVED*** New object with all of A's properties, and all of B's properties, overwriting A's properties
	 */
	function extend(a, b) {
		var c = {***REMOVED***;
		for (var x in a) {
			if (a.hasOwnProperty(x)) {
				c[x] = a[x];
			***REMOVED***
		***REMOVED***
		if (b != null) {
			for (var y in b) {
				if (b.hasOwnProperty(y)) {
					c[y] = b[y];
				***REMOVED***
			***REMOVED***
		***REMOVED***
		return c;
	***REMOVED***

	/**
	 * Takes a k/v list of CSS properties and returns a rule
	 *
	 * @param props CSS properties object
	 */
	function cssProps(props) {
		var ret = [];
		for (var p in props) {
			if (props.hasOwnProperty(p)) {
				ret.push(p + ':' + props[p]);
			***REMOVED***
		***REMOVED***
		return ret.join(';');
	***REMOVED***

	/**
	 * Prevents a function from being called too often, waits until a timer elapses to call it again
	 *
	 * @param fn Function to call
	 */
	function debounce(fn) {
		if (!App.vars.debounceTimer) fn.call(this);
		if (App.vars.debounceTimer) clearTimeout(App.vars.debounceTimer);
		App.vars.debounceTimer = setTimeout(function() {
			App.vars.debounceTimer = null;
			fn.call(this);
		***REMOVED***, App.setup.debounce);
	***REMOVED***

	/**
	 * Holder-specific resize/orientation change callback, debounced to prevent excessive execution
	 */
	function resizeEvent() {
		debounce(function() {
			updateResizableElements(null);
		***REMOVED***);
	***REMOVED***

	/**
	 * Converts a value into an array of DOM nodes
	 *
	 * @param val A string, a NodeList, a Node, or an HTMLCollection
	 */
	function getNodeArray(val) {
		var retval = null;
		if (typeof(val) == 'string') {
			retval = document.querySelectorAll(val);
		***REMOVED*** else if (global.NodeList && val instanceof global.NodeList) {
			retval = val;
		***REMOVED*** else if (global.Node && val instanceof global.Node) {
			retval = [val];
		***REMOVED*** else if (global.HTMLCollection && val instanceof global.HTMLCollection) {
			retval = val;
		***REMOVED*** else if (val === null) {
			retval = [];
		***REMOVED***
		return retval;
	***REMOVED***

	/**
	 * Checks if an image exists
	 *
	 * @param params Configuration object, must specify at least a src key
	 * @param callback Callback to call once image status has been found
	 */
	function imageExists(src, callback) {
		var image = new Image();
		image.onerror = function() {
			callback.call(this, false);
		***REMOVED***;
		image.onload = function() {
			callback.call(this, true);
		***REMOVED***;
		image.src = src;
	***REMOVED***

	/**
	 * Encodes HTML entities in a string
	 *
	 * @param str Input string
	 */
	function encodeHtmlEntity(str) {
		var buf = [];
		var charCode = 0;
		for (var i = str.length - 1; i >= 0; i--) {
			charCode = str.charCodeAt(i);
			if (charCode > 128) {
				buf.unshift(['&#', charCode, ';'].join(''));
			***REMOVED*** else {
				buf.unshift(str[i]);
			***REMOVED***
		***REMOVED***
		return buf.join('');
	***REMOVED***

	/**
	 * Decodes HTML entities in a stirng
	 *
	 * @param str Input string
	 */
	function decodeHtmlEntity(str) {
		return str.replace(/&#(\d+);/g, function(match, dec) {
			return String.fromCharCode(dec);
		***REMOVED***);
	***REMOVED***

	// Scene graph

	var SceneGraph = function(sceneProperties) {
		var nodeCount = 1;

		//todo: move merge to helpers section
		function merge(parent, child) {
			for (var prop in child) {
				parent[prop] = child[prop];
			***REMOVED***
			return parent;
		***REMOVED***

		var SceneNode = augment.defclass({
			constructor: function(name) {
				nodeCount++;
				this.parent = null;
				this.children = {***REMOVED***;
				this.id = nodeCount;
				this.name = 'n' + nodeCount;
				if (name != null) {
					this.name = name;
				***REMOVED***
				this.x = 0;
				this.y = 0;
				this.z = 0;
				this.width = 0;
				this.height = 0;
			***REMOVED***,
			resize: function(width, height) {
				if (width != null) {
					this.width = width;
				***REMOVED***
				if (height != null) {
					this.height = height;
				***REMOVED***
			***REMOVED***,
			moveTo: function(x, y, z) {
				this.x = x != null ? x : this.x;
				this.y = y != null ? y : this.y;
				this.z = z != null ? z : this.z;
			***REMOVED***,
			add: function(child) {
					var name = child.name;
					if (this.children[name] == null) {
						this.children[name] = child;
						child.parent = this;
					***REMOVED*** else {
						throw 'SceneGraph: child with that name already exists: ' + name;
					***REMOVED***
				***REMOVED***
				/*,	// probably unnecessary in Holder
				remove: function(name){
					if(this.children[name] == null){
						throw 'SceneGraph: child with that name doesn\'t exist: '+name;
					***REMOVED***
					***REMOVED***
						child.parent = null;
						delete this.children[name];
					***REMOVED***
				***REMOVED***,
				removeAll: function(){
					for(var child in this.children){
						this.remove(child);
					***REMOVED***
				***REMOVED****/
		***REMOVED***);

		var RootNode = augment(SceneNode, function(uber) {
			this.constructor = function() {
				uber.constructor.call(this, 'root');
				this.properties = sceneProperties;
			***REMOVED***;
		***REMOVED***);

		var Shape = augment(SceneNode, function(uber) {
			function constructor(name, props) {
				uber.constructor.call(this, name);
				this.properties = {
					fill: '#000'
				***REMOVED***;
				if (props != null) {
					merge(this.properties, props);
				***REMOVED*** else if (name != null && typeof name !== 'string') {
					throw 'SceneGraph: invalid node name';
				***REMOVED***
			***REMOVED***

			this.Group = augment.extend(this, {
				constructor: constructor,
				type: 'group'
			***REMOVED***);

			this.Rect = augment.extend(this, {
				constructor: constructor,
				type: 'rect'
			***REMOVED***);

			this.Text = augment.extend(this, {
				constructor: function(text) {
					constructor.call(this);
					this.properties.text = text;
				***REMOVED***,
				type: 'text'
			***REMOVED***);
		***REMOVED***);

		var root = new RootNode();

		this.Shape = Shape;
		this.root = root;

		return this;
	***REMOVED***;

	//Set up flags

	for (var flag in App.flags) {
		if (!App.flags.hasOwnProperty(flag)) continue;
		App.flags[flag].match = function(val) {
			return val.match(this.regex);
		***REMOVED***;
	***REMOVED***

	//Properties set once on setup

	App.setup = {
		renderer: 'html',
		debounce: 100,
		ratio: 1,
		supportsCanvas: false,
		supportsSVG: false,
		lineWrapRatio: 0.9,
		renderers: ['html', 'canvas', 'svg']
	***REMOVED***;

	App.dpr = function(val) {
		return val * App.setup.ratio;
	***REMOVED***;

	//Properties modified during runtime

	App.vars = {
		preempted: false,
		resizableImages: [],
		debounceTimer: null,
		cache: {***REMOVED***
	***REMOVED***;

	//Pre-flight

	(function() {
		var devicePixelRatio = 1,
			backingStoreRatio = 1;

		var canvas = newEl('canvas');
		var ctx = null;

		if (canvas.getContext) {
			if (canvas.toDataURL('image/png').indexOf('data:image/png') != -1) {
				App.setup.renderer = 'canvas';
				ctx = canvas.getContext('2d');
				App.setup.supportsCanvas = true;
			***REMOVED***
		***REMOVED***

		if (App.setup.supportsCanvas) {
			devicePixelRatio = global.devicePixelRatio || 1;
			backingStoreRatio = ctx.webkitBackingStorePixelRatio || ctx.mozBackingStorePixelRatio || ctx.msBackingStorePixelRatio || ctx.oBackingStorePixelRatio || ctx.backingStorePixelRatio || 1;
		***REMOVED***

		App.setup.ratio = devicePixelRatio / backingStoreRatio;

		if (!!document.createElementNS && !!document.createElementNS(SVG_NS, 'svg').createSVGRect) {
			App.setup.renderer = 'svg';
			App.setup.supportsSVG = true;
		***REMOVED***
	***REMOVED***)();

	//Exposing to environment and setting up listeners
	register(Holder, 'Holder', global);

	if (global.onDomReady) {
		global.onDomReady(function() {
			if (!App.vars.preempted) {
				Holder.run();
			***REMOVED***
			if (global.addEventListener) {
				global.addEventListener('resize', resizeEvent, false);
				global.addEventListener('orientationchange', resizeEvent, false);
			***REMOVED*** else {
				global.attachEvent('onresize', resizeEvent);
			***REMOVED***

			if (typeof global.Turbolinks == 'object') {
				global.document.addEventListener('page:change', function() {
					Holder.run();
				***REMOVED***);
			***REMOVED***
		***REMOVED***);
	***REMOVED***

***REMOVED***)(function(fn, name, global) {
	var isAMD = (typeof define === 'function' && define.amd);
	var isNode = (typeof exports === 'object');
	var isWeb = !isNode;

	if (isAMD) {
		define(fn);
	***REMOVED*** else {
		//todo: npm/browserify registration
		global[name] = fn;
	***REMOVED***
***REMOVED***, this);