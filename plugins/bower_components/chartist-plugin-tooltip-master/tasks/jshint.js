/**
 * jshint
 * ======
 *
 * Make sure code styles are up to par and there are no obvious mistakes.
 *
 * Link: https://github.com/gruntjs/grunt-contrib-jshint
 */

'use strict';

module.exports = function (grunt) {
  return {
    options: {
      jshintrc: '.jshintrc',
      reporter: require('jshint-stylish')
    ***REMOVED***,
    all: [
      'Gruntfile.js',
      '<%= pkg.config.src %>/{,*/***REMOVED****.js',
      '<%= pkg.config.site %>/scripts/{,*/***REMOVED****.js'
    ],
    test: {
      options: {
        jshintrc: '<%= pkg.config.test %>/.jshintrc'
      ***REMOVED***,
      src: ['<%= pkg.config.test %>/spec/{,*/***REMOVED****.js']
    ***REMOVED***
  ***REMOVED***;
***REMOVED***;
