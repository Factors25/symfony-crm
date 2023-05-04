/*                          *\
   ------------------------
      Importing packages
   ------------------------
\*                          */

/* jQuery */
let $ = require('jquery');

/* Bootstrap 5 */
window.bootstrap = require('bootstrap');

/* Datatables */
require('datatables.net-bs5');
require('datatables.net-responsive-bs5');
require('datatables.net-select-bs5');

/* Fontawesome */
require('@fortawesome/fontawesome-free/js/all.min');

/* Toast */
require('jquery-toast-plugin');

/* Extensions */
require('./extension/datatable');
require('./extension/form_modal');

/* Default */
import '../scss/app.scss';
