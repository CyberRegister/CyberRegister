
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Dropzone = require('dropzone');
window.Dropzone.prototype.defaultOptions.maxFiles = 1;
window.Dropzone.prototype.defaultOptions.acceptedFiles = '.png,.jpg,.gif,.bmp,.jpeg';
window.Dropzone.prototype.defaultOptions.autoProcessQueue = false;
window.Dropzone.prototype.defaultOptions.uploadMultiple = false;
window.Dropzone.prototype.defaultOptions.previewsContainer = '.dz-default';
window.Dropzone.prototype.defaultOptions.init = function () {
	var myDropzone = this;
	// First change the button to actually tell Dropzone to process the queue.
	this.element.querySelector('button[type=submit]').addEventListener(
		'click', function (e) {
			// Make sure that the form isn't actually being sent.
			e.preventDefault();
			e.stopPropagation();
			myDropzone.processQueue();
		}
	);
	this.on(
		'success', function () {
			window.location = '/users';    // nasty hack
		}
	);
	this.on(
		'maxfilesexceeded', function (file) {
			this.removeFile(file);
		}
	);
};

$(document).ready(
	function () {
		// Delete resource
		$('button[name="delete-resource"]').on(
			'click', function (e) {
				e.preventDefault();
				var $form = $(this).closest('form');
				$('#confirm-delete').modal({backdrop: 'static', keyboard: false}).one(
					'click', '#delete', function () {
						$form.trigger('submit');
					}
				);
			}
		);
		$('#logout').click(
			function (event) {
				event.preventDefault();
				document.getElementById('logout-form').submit();
			}
		);
	}
);

window.Vue = require('vue');

window.Vue.component(
	'passport-clients',
	require('./components/passport/Clients.vue')
);

window.Vue.component(
	'passport-authorized-clients',
	require('./components/passport/AuthorizedClients.vue')
);

window.Vue.component(
	'passport-personal-access-tokens',
	require('./components/passport/PersonalAccessTokens.vue')
);

new window.Vue({
	el: '#app'
});

