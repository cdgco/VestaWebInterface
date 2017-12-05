/*!
 * Bootstrap Grunt task for parsing Less docstrings
 * http://getbootstrap.com
 * Copyright 2014-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

'use strict';

var Markdown = require('markdown-it');

function markdown2html(markdownString) {
  var md = new Markdown();

  // the slice removes the <p>...</p> wrapper output by Markdown processor
  return md.render(markdownString.trim()).slice(3, -5);
***REMOVED***


/*
Mini-language:
  //== This is a normal heading, which starts a section. Sections group variables together.
  //## Optional description for the heading

  //=== This is a subheading.

  //** Optional description for the following variable. You **can** use Markdown in descriptions to discuss `<html>` stuff.
  @foo: #fff;

  //-- This is a heading for a section whose variables shouldn't be customizable

  All other lines are ignored completely.
*/


var CUSTOMIZABLE_HEADING = /^[/]{2***REMOVED***={2***REMOVED***(.*)$/;
var UNCUSTOMIZABLE_HEADING = /^[/]{2***REMOVED***-{2***REMOVED***(.*)$/;
var SUBSECTION_HEADING = /^[/]{2***REMOVED***={3***REMOVED***(.*)$/;
var SECTION_DOCSTRING = /^[/]{2***REMOVED***#{2***REMOVED***(.+)$/;
var VAR_ASSIGNMENT = /^(@[a-zA-Z0-9_-]+):[ ]*([^ ;][^;]*);[ ]*$/;
var VAR_DOCSTRING = /^[/]{2***REMOVED***[*]{2***REMOVED***(.+)$/;

function Section(heading, customizable) {
  this.heading = heading.trim();
  this.id = this.heading.replace(/\s+/g, '-').toLowerCase();
  this.customizable = customizable;
  this.docstring = null;
  this.subsections = [];
***REMOVED***

Section.prototype.addSubSection = function (subsection) {
  this.subsections.push(subsection);
***REMOVED***;

function SubSection(heading) {
  this.heading = heading.trim();
  this.id = this.heading.replace(/\s+/g, '-').toLowerCase();
  this.variables = [];
***REMOVED***

SubSection.prototype.addVar = function (variable) {
  this.variables.push(variable);
***REMOVED***;

function VarDocstring(markdownString) {
  this.html = markdown2html(markdownString);
***REMOVED***

function SectionDocstring(markdownString) {
  this.html = markdown2html(markdownString);
***REMOVED***

function Variable(name, defaultValue) {
  this.name = name;
  this.defaultValue = defaultValue;
  this.docstring = null;
***REMOVED***

function Tokenizer(fileContent) {
  this._lines = fileContent.split('\n');
  this._next = undefined;
***REMOVED***

Tokenizer.prototype.unshift = function (token) {
  if (this._next !== undefined) {
    throw new Error('Attempted to unshift twice!');
  ***REMOVED***
  this._next = token;
***REMOVED***;

Tokenizer.prototype._shift = function () {
  // returning null signals EOF
  // returning undefined means the line was ignored
  if (this._next !== undefined) {
    var result = this._next;
    this._next = undefined;
    return result;
  ***REMOVED***
  if (this._lines.length <= 0) {
    return null;
  ***REMOVED***
  var line = this._lines.shift();
  var match = null;
  match = SUBSECTION_HEADING.exec(line);
  if (match !== null) {
    return new SubSection(match[1]);
  ***REMOVED***
  match = CUSTOMIZABLE_HEADING.exec(line);
  if (match !== null) {
    return new Section(match[1], true);
  ***REMOVED***
  match = UNCUSTOMIZABLE_HEADING.exec(line);
  if (match !== null) {
    return new Section(match[1], false);
  ***REMOVED***
  match = SECTION_DOCSTRING.exec(line);
  if (match !== null) {
    return new SectionDocstring(match[1]);
  ***REMOVED***
  match = VAR_DOCSTRING.exec(line);
  if (match !== null) {
    return new VarDocstring(match[1]);
  ***REMOVED***
  var commentStart = line.lastIndexOf('//');
  var varLine = commentStart === -1 ? line : line.slice(0, commentStart);
  match = VAR_ASSIGNMENT.exec(varLine);
  if (match !== null) {
    return new Variable(match[1], match[2]);
  ***REMOVED***
  return undefined;
***REMOVED***;

Tokenizer.prototype.shift = function () {
  while (true) {
    var result = this._shift();
    if (result === undefined) {
      continue;
    ***REMOVED***
    return result;
  ***REMOVED***
***REMOVED***;

function Parser(fileContent) {
  this._tokenizer = new Tokenizer(fileContent);
***REMOVED***

Parser.prototype.parseFile = function () {
  var sections = [];
  while (true) {
    var section = this.parseSection();
    if (section === null) {
      if (this._tokenizer.shift() !== null) {
        throw new Error('Unexpected unparsed section of file remains!');
      ***REMOVED***
      return sections;
    ***REMOVED***
    sections.push(section);
  ***REMOVED***
***REMOVED***;

Parser.prototype.parseSection = function () {
  var section = this._tokenizer.shift();
  if (section === null) {
    return null;
  ***REMOVED***
  if (!(section instanceof Section)) {
    throw new Error('Expected section heading; got: ' + JSON.stringify(section));
  ***REMOVED***
  var docstring = this._tokenizer.shift();
  if (docstring instanceof SectionDocstring) {
    section.docstring = docstring;
  ***REMOVED*** else {
    this._tokenizer.unshift(docstring);
  ***REMOVED***
  this.parseSubSections(section);

  return section;
***REMOVED***;

Parser.prototype.parseSubSections = function (section) {
  while (true) {
    var subsection = this.parseSubSection();
    if (subsection === null) {
      if (section.subsections.length === 0) {
        // Presume an implicit initial subsection
        subsection = new SubSection('');
        this.parseVars(subsection);
      ***REMOVED*** else {
        break;
      ***REMOVED***
    ***REMOVED***
    section.addSubSection(subsection);
  ***REMOVED***

  if (section.subsections.length === 1 && !section.subsections[0].heading && section.subsections[0].variables.length === 0) {
    // Ignore lone empty implicit subsection
    section.subsections = [];
  ***REMOVED***
***REMOVED***;

Parser.prototype.parseSubSection = function () {
  var subsection = this._tokenizer.shift();
  if (subsection instanceof SubSection) {
    this.parseVars(subsection);
    return subsection;
  ***REMOVED***
  this._tokenizer.unshift(subsection);
  return null;
***REMOVED***;

Parser.prototype.parseVars = function (subsection) {
  while (true) {
    var variable = this.parseVar();
    if (variable === null) {
      return;
    ***REMOVED***
    subsection.addVar(variable);
  ***REMOVED***
***REMOVED***;

Parser.prototype.parseVar = function () {
  var docstring = this._tokenizer.shift();
  if (!(docstring instanceof VarDocstring)) {
    this._tokenizer.unshift(docstring);
    docstring = null;
  ***REMOVED***
  var variable = this._tokenizer.shift();
  if (variable instanceof Variable) {
    variable.docstring = docstring;
    return variable;
  ***REMOVED***
  this._tokenizer.unshift(variable);
  return null;
***REMOVED***;


module.exports = Parser;
