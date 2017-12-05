"use strict";

module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON("package.json"),

    banner: "/*\n" +
    " * <%= pkg.title || pkg.name %> - v<%= pkg.version %>\n" +
    " * <%= pkg.description %>\n" +
    " * <%= pkg.homepage %>\n" +
    " *\n" +
    " * Made by <%= pkg.author.name %>\n" +
    " * Under <%= pkg.license %> License\n" +
    " */\n",

    jshint: {
      options: {
        jshintrc: ".jshintrc"
      ***REMOVED***,
      all: [
      "Gruntfile.js",
      "src/metisMenu.js"
      ]
    ***REMOVED***,
    concat: {
      plugin: {
        src: ["src/metisMenu.js"],
        dest: "dist/metisMenu.js"
      ***REMOVED***,
      css: {
        src: ["src/metisMenu.css"],
        dest: "dist/metisMenu.css"
      ***REMOVED***,
      options: {
        banner: "<%= banner %>"
      ***REMOVED***
    ***REMOVED***,
    uglify: {
      plugin: {
        src: ["dist/metisMenu.js"],
        dest: "dist/metisMenu.min.js"
      ***REMOVED***,
      options: {
        banner: "<%= banner %>"
      ***REMOVED***
    ***REMOVED***,
    cssmin: {
      options: {
        banner: "<%= banner %>"
      ***REMOVED***,
      menucss: {
        src: ["src/metisMenu.css"],
        dest: "dist/metisMenu.min.css"
      ***REMOVED***
    ***REMOVED***
  ***REMOVED***);

  grunt.loadNpmTasks("grunt-contrib-jshint");
  grunt.loadNpmTasks("grunt-contrib-concat");
  grunt.loadNpmTasks("grunt-contrib-uglify");
  grunt.loadNpmTasks("grunt-contrib-cssmin");

  grunt.registerTask("travis", ["jshint"]);
  grunt.registerTask("default", ["jshint", "concat", "uglify", "cssmin"]);
***REMOVED***;
