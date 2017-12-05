'use strict';

module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        // Metadata.
        pkg: grunt.file.readJSON('package.json'),
        banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %>\n' + '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' + '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' + ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
        // Task configuration.

        // -- clean config ----------------------------------------------------------=
        clean: {
            files: ['dist']
        ***REMOVED***,

        // -- concat config ----------------------------------------------------------
        concat: {
            options: {
                banner: '<%= banner %>',
                stripBanners: true,
                process: true
            ***REMOVED***,
            dist: {
                src: [
                    'src/intro.js',
                    'src/support.js',
                    'src/setup.js',
                    'src/util.js',
                    'src/defaults.js',
                    'src/step.js',
                    'src/public.js',
                    'src/bind.js',
                    'src/outro.js'
                ],
                dest: 'dist/jquery-wizard.js'
            ***REMOVED***
        ***REMOVED***,

        // -- uglify config ----------------------------------------------------------
        uglify: {
            options: {
                banner: '<%= banner %>'
            ***REMOVED***,
            dist: {
                src: '<%= concat.dist.dest %>',
                dest: 'dist/jquery-wizard.min.js'
            ***REMOVED***,
        ***REMOVED***,

        // -- jshint config ----------------------------------------------------------
        jshint: {
            gruntfile: {
                options: {
                    jshintrc: '.jshintrc'
                ***REMOVED***,
                src: 'Gruntfile.js'
            ***REMOVED***,
            dist: {
                options: {
                    jshintrc: 'src/.jshintrc'
                ***REMOVED***,
                src: ["<%= concat.dist.dest %>"]
            ***REMOVED***
        ***REMOVED***,

        // -- jsbeautifier config -----------------------------------------------------
        jsbeautifier: {
            dist: {
                src: ["<%= concat.dist.dest %>"]
            ***REMOVED***,
            source: {
                src: ['Gruntfile.js', "src/*.js"],
            ***REMOVED***,
            options: {
                "indent_size": 4,
                "indent_char": " ",
                "indent_level": 0,
                "indent_with_tabs": false,
                "preserve_newlines": true,
                "max_preserve_newlines": 10,
                "jslint_happy": false,
                "brace_style": "collapse",
                "keep_array_indentation": false,
                "keep_function_indentation": false,
                "space_before_conditional": true,
                "eval_code": false,
                "indent_case": false,
                "unescape_strings": false
            ***REMOVED***
        ***REMOVED***,

        // -- less config ----------------------------------------------------------
        less: {
            dist: {
                files: {
                    'css/wizard.css': ['less/wizard.less']
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***,

        // -- autoprefixer config ----------------------------------------------------------
        autoprefixer: {
            options: {
                browsers: [
                    "Android 2.3",
                    "Android >= 4",
                    "Chrome >= 20",
                    "Firefox >= 24",
                    "Explorer >= 8",
                    "iOS >= 6",
                    "Opera >= 12",
                    "Safari >= 6"
                ]
            ***REMOVED***,
            src: {
                expand: true,
                cwd: 'css/',
                src: ['*.css', '!*.min.css'],
                dest: 'css/'
            ***REMOVED***
        ***REMOVED***,

        // -- watch config ------------------------------------------------------------
        watch: {
            gruntfile: {
                files: '<%= jshint.gruntfile.src %>',
                tasks: ['jshint:gruntfile']
            ***REMOVED***,
            src: {
                files: '<%= concat.dist.src %>',
                tasks: ['dist']
            ***REMOVED***
        ***REMOVED***,

        // -- csscomb config ---------------------------------------------------------
        csscomb: {
            options: {
              config: '.csscomb.json'
            ***REMOVED***,
            dist: {
                files: {
                    'css/wizard.css': ['css/wizard.css'],
                ***REMOVED***,
            ***REMOVED***
        ***REMOVED***,

        // -- replace config ---------------------------------------------------------
        replace: {
            bower: {
                src: ['bower.json'],
                overwrite: true, // overwrite matched source files
                replacements: [{
                    from: /("version": ")([0-9\.]+)(")/g,
                    to: "$1<%= pkg.version %>$3"
                ***REMOVED***]
            ***REMOVED***
        ***REMOVED***
    ***REMOVED***);

    // Load npm plugins to provide necessary tasks.
    require('load-grunt-tasks')(grunt, {
        pattern: ['grunt-*']
    ***REMOVED***);

    // Default task.
    grunt.registerTask('default', ['dist', 'jshint']);

    grunt.registerTask('dist', ['clean', 'concat', 'jsbeautifier:dist', 'uglify']);
    grunt.registerTask('js', ['jsbeautifier', 'jshint']);

    grunt.registerTask('version', [
        'replace:bower'
    ]);

    grunt.registerTask('css', ['less', 'csscomb', 'autoprefixer']);
***REMOVED***;
