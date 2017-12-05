// Theme color settings
$(document).ready(function(){
function store(name, val) {
    if (typeof (Storage) !== "undefined") {
      localStorage.setItem(name, val);
    ***REMOVED*** else {
      window.alert('Please use a modern browser to properly view this template!');
    ***REMOVED***
  ***REMOVED***
 $("*[theme]").click(function(e){
      e.preventDefault();
        var currentStyle = $(this).attr('theme');
        store('theme', currentStyle);
        $('#theme').attr({href: 'css/colors/'+currentStyle+'.css'***REMOVED***)
    ***REMOVED***);

    var currentTheme = get('theme');
    if(currentTheme)
    {
      $('#theme').attr({href: 'css/colors/'+currentTheme+'.css'***REMOVED***);
    ***REMOVED***
    // color selector
    $('#themecolors').on('click', 'a', function(){
        $('#themecolors li a').removeClass('working');
        $(this).addClass('working')
      ***REMOVED***);

***REMOVED***);
 function get(name) {
    
  ***REMOVED***

$(document).ready(function(){
    $("*[theme]").click(function(e){
      e.preventDefault();
        var currentStyle = $(this).attr('theme');
        store('theme', currentStyle);
        $('#theme').attr({href: 'css/colors/'+currentStyle+'.css'***REMOVED***)
    ***REMOVED***);

    var currentTheme = get('theme');
    if(currentTheme)
    {
      $('#theme').attr({href: 'css/colors/'+currentTheme+'.css'***REMOVED***);
    ***REMOVED***
    // color selector
$('#themecolors').on('click', 'a', function(){
        $('#themecolors li a').removeClass('working');
        $(this).addClass('working')
      ***REMOVED***);
***REMOVED***);
