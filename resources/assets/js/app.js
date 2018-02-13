
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
});