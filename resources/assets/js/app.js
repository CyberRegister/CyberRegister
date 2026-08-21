
/**
 * First we will load all of this project's JavaScript dependencies, then
 * wire up the behaviour the Blade templates rely on.
 */

import './bootstrap';
import Dropzone from 'dropzone';

window.Dropzone = Dropzone;
Dropzone.prototype.defaultOptions.maxFiles = 1;
Dropzone.prototype.defaultOptions.acceptedFiles = '.png,.jpg,.gif,.bmp,.jpeg';
Dropzone.prototype.defaultOptions.autoProcessQueue = false;
Dropzone.prototype.defaultOptions.uploadMultiple = false;
Dropzone.prototype.defaultOptions.previewsContainer = '.dz-default';
Dropzone.prototype.defaultOptions.init = function () {
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
