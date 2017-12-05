$(window).load(function () {

var size = 1;
var button = 1;
var button_class = "gallery-header-center-right-links-current";
var normal_size_class = "gallery-content-center-normal";
var full_size_class = "gallery-content-center-full";
var $container = $('#gallery-content-center');
    
$container.isotope({itemSelector : 'img'***REMOVED***);


function check_button(){
	$('.gallery-header-center-right-links').removeClass(button_class);
	if(button==1){
		$("#filter-all").addClass(button_class);
		$("#gallery-header-center-left-title").html('All Galleries');
		***REMOVED***
	if(button==2){
		$("#filter-studio").addClass(button_class);
		$("#gallery-header-center-left-title").html('Studio Gallery');
		***REMOVED***
	if(button==3){
		$("#filter-landscape").addClass(button_class);
		$("#gallery-header-center-left-title").html('Landscape Gallery');
		***REMOVED***	
***REMOVED***
	
function check_size(){
	$("#gallery-content-center").removeClass(normal_size_class).removeClass(full_size_class);
	if(size==0){
		$("#gallery-content-center").addClass(normal_size_class); 
		$("#gallery-header-center-left-icon").html('<span class="iconb" data-icon="&#xe23a;"></span>');
		***REMOVED***
	if(size==1){
		$("#gallery-content-center").addClass(full_size_class); 
		$("#gallery-header-center-left-icon").html('<span class="iconb" data-icon="&#xe23b;"></span>');
		***REMOVED***
	$container.isotope({itemSelector : 'img'***REMOVED***);
***REMOVED***


	
$("#filter-all").click(function() { $container.isotope({ filter: '.all' ***REMOVED***); button = 1; check_button(); ***REMOVED***);
$("#filter-studio").click(function() {  $container.isotope({ filter: '.studio' ***REMOVED***); button = 2; check_button();  ***REMOVED***);
$("#filter-landscape").click(function() {  $container.isotope({ filter: '.landscape' ***REMOVED***); button = 3; check_button();  ***REMOVED***);
$("#gallery-header-center-left-icon").click(function() { if(size==0){size=1;***REMOVED***else if(size==1){size=0;***REMOVED*** check_size(); ***REMOVED***);


check_button();
check_size();
***REMOVED***);