
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(document).ready(function () {
	// Delete resource
	$('button[name="delete-resource"]').on('click', function (e) {
		e.preventDefault();
		var $form = $(this).closest('form');
		$('#confirm-delete').modal({backdrop: 'static', keyboard: false}).one('click', '#delete', function () {
			$form.trigger('submit');
		});
	});
	$('#logout').click(function (event) {
		event.preventDefault();
		document.getElementById('logout-form').submit();
	});
});

let u2f = require('./u2f').default;

/**
 * Based on code by arnaud 21/05/15.
 */
/* eslint-disable no-unused-vars */
u2fClient = {
	login: function (request, errors) {
		setTimeout(function () {

			u2f.sign(request, function (data) {
				var alert = null;

				if (data.errorCode) {
					alert = document.getElementById('error');
					alert.innerHTML = errors[data.errorCode];
					alert.style.display = 'block';

					return;
				}

				var form = document.getElementById('form');
				var auth = document.getElementById('authentication');

				alert = document.getElementById('success');
				alert.style.display = 'block';
				auth.value = JSON.stringify(data);
				form.submit();
			});
		}, 1000);
	},

	register: function (request, keys, errors) {
		setTimeout(function () {
			u2f.register([request], keys, function (data) {
				var form = document.getElementById('form');
				var reg = document.getElementById('register');
				var alert = null;

				if (data.errorCode) {
					alert = document.getElementById('error');
					alert.innerHTML = errors[data.errorCode];
					alert.style.display = 'block';

					return;
				}

				alert = document.getElementById('success');
				alert.style.display = 'block';

				reg.value = JSON.stringify(data);
				form.submit();
			});
		}, 1000);
	}
};
/* eslint-enable no-unused-vars */
