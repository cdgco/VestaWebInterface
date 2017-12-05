
!function($) {
    "use strict";

    var SweetAlert = function() {***REMOVED***;

    //examples 
    SweetAlert.prototype.init = function() {
        
    //Basic
    $('#sa-basic').click(function(){
        swal("Here's a message!");
    ***REMOVED***);

    //A title with a text under
    $('#sa-title').click(function(){
        swal("Here's a message!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.")
    ***REMOVED***);

    //Success Message
    $('#sa-success').click(function(){
        swal("Good job!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.", "success")
    ***REMOVED***);

    //Warning Message
    $('#sa-warning').click(function(){
        swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            closeOnConfirm: false 
        ***REMOVED***, function(){   
            swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
        ***REMOVED***);
    ***REMOVED***);

    //Parameter
    $('#sa-params').click(function(){
        swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            cancelButtonText: "No, cancel plx!",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        ***REMOVED***, function(isConfirm){   
            if (isConfirm) {     
                swal("Deleted!", "Your imaginary file has been deleted.", "success");   
            ***REMOVED*** else {     
                swal("Cancelled", "Your imaginary file is safe :)", "error");   
            ***REMOVED*** 
        ***REMOVED***);
    ***REMOVED***);

    //Custom Image
    $('#sa-image').click(function(){
        swal({   
            title: "Govinda!",   
            text: "Recently joined twitter",   
            imageUrl: "../plugins/images/users/govinda.jpg" 
        ***REMOVED***);
    ***REMOVED***);

    //Auto Close Timer
    $('#sa-close').click(function(){
         swal({   
            title: "Auto close alert!",   
            text: "I will close in 2 seconds.",   
            timer: 2000,   
            showConfirmButton: false 
        ***REMOVED***);
    ***REMOVED***);


    ***REMOVED***,
    //init
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
***REMOVED***(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.SweetAlert.init()
***REMOVED***(window.jQuery);