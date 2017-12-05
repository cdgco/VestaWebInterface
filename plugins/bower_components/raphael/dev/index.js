var core = require('./raphael.core');
if(core.svg){
  require('./raphael.svg');
***REMOVED***
if(core.vml){
  require('./raphael.vml');
***REMOVED***
module.exports = core;