
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. Both are
 * attached to window because Bootstrap 4 resolves them globally.
 */

import jQuery from 'jquery';
import Popper from 'popper.js';

window.$ = window.jQuery = jQuery;
window.Popper = Popper;

import 'bootstrap';
