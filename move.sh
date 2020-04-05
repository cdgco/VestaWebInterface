#! /bin/bash
copyfiles -u 1 node_modules/animate.css/animate.min.css node_modules/bootstrap/dist/css/* node_modules/bootstrap/dist/fonts/* node_modules/bootstrap/dist/js/* node_modules/bootstrap/less/* node_modules/bootstrap/less/mixins/* node_modules/font-awesome/css/* node_modules/font-awesome/fonts/* node_modules/jquery-overlaps/jquery.overlaps.js node_modules/jquery-slimscroll/jquery.slimscroll.js node_modules/jquery-slimscroll/jquery.slimscroll.min.js node_modules/metismenu/dist/* node_modules/metismenu/dist/modules/* node_modules/metismenu/dist/cjs/* node_modules/metismenu/src/* node_modules/themify-icons/css/* node_modules/themify-icons/fonts/* plugins/components
copyfiles -u 3 node_modules/bootstrap-colorpicker/dist/**/*.* node_modules/bootstrap-colorpicker/dist/**/**/*.* plugins/components/bootstrap-colorpicker 
copyfiles -u 4 node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.standalone.min.css node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js plugins/components/bootstrap-datepicker
copyfiles -u 4 node_modules/bootstrapvalidator/dist/css/bootstrapValidator.css node_modules/bootstrapvalidator/dist/js/bootstrapValidator.js plugins/components/bootstrapvalidator
copyfiles -f -u 1 node_modules/footable-v3/compiled/footable.bootstrap.css node_modules/footable-v3/compiled/footable.bootstrap.min.css node_modules/footable-v3/compiled/footable.min.js plugins/components/footable
copyfiles -f -u 1 node_modules/hotkeys-js/dist/hotkeys.min.js plugins/components/hotkeysjs
copyfiles -f -u 1 node_modules/jquery/dist/* plugins/components/jquery
copyfiles -f -u 1 node_modules/moment/min/moment.min.js plugins/components/moment
copyfiles -u 2 node_modules/PHPMailer/* node_modules/PHPMailer/language/* node_modules/PHPMailer/src/* plugins/components/phpmailer
copyfiles -f -u 1 node_modules/popper.js/dist/umd/popper.js plugins/components/popper.js 
copyfiles -f -u 1 node_modules/select2/dist/css/select2.min.css node_modules/select2/dist/js/select2.min.js plugins/components/select2 
copyfiles -f -u 1 node_modules/sweetalert2/dist/sweetalert2.min.css node_modules/sweetalert2/dist/sweetalert2.min.js plugins/components/sweetalert2
copyfiles -f -u 1 node_modules/node-waves/dist/waves.css node_modules/node-waves/dist/waves.js plugins/components/waves
copyfiles -u 3 node_modules/bootstrap-select/dist/css/* node_modules/bootstrap-select/dist/js/* node_modules/bootstrap-select/dist/js/i18n/* plugins/components/bootstrap-select
copyfiles -f -u 1 node_modules/bootstrap-brand-buttons/dist/* plugins/components/bootstrap-brand-buttons
chmod 777 plugins/components -R
