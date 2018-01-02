  $(document).ready(function() {
    $('#contact_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        ***REMOVED***,
        fields: {
            first_name: {
                validators: {
                        stringLength: {
                        min: 2,
                    ***REMOVED***,
                        notEmpty: {
                        message: 'Please supply your first name'
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
             last_name: {
                validators: {
                     stringLength: {
                        min: 2,
                    ***REMOVED***,
                    notEmpty: {
                        message: 'Please supply your last name'
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your email address'
                    ***REMOVED***,
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
            phone: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your phone number'
                    ***REMOVED***,
                    phone: {
                        country: 'US',
                        message: 'Please supply a vaild phone number with area code'
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
            address: {
                validators: {
                     stringLength: {
                        min: 8,
                    ***REMOVED***,
                    notEmpty: {
                        message: 'Please supply your street address'
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
            city: {
                validators: {
                     stringLength: {
                        min: 4,
                    ***REMOVED***,
                    notEmpty: {
                        message: 'Please supply your city'
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
            state: {
                validators: {
                    notEmpty: {
                        message: 'Please select your state'
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
            zip: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your zip code'
                    ***REMOVED***,
                    zipCode: {
                        country: 'US',
                        message: 'Please supply a vaild zip code'
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***,
            comment: {
                validators: {
                      stringLength: {
                        min: 10,
                        max: 200,
                        message:'Please enter at least 10 characters and no more than 200'
                    ***REMOVED***,
                    notEmpty: {
                        message: 'Please supply a description of your project'
                    ***REMOVED***
                    ***REMOVED***
                ***REMOVED***
            ***REMOVED***
        ***REMOVED***)
        .on('success.form.bv', function(e) {
            $('#success_message').slideDown({ opacity: "show" ***REMOVED***, "slow") // Do something ...
                $('#contact_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            ***REMOVED***, 'json');
        ***REMOVED***);
***REMOVED***);