import Swal from 'sweetalert2';

('use strict');

(function () {
	// Get all the required DOM element.
	const postType = document.getElementById('post-type'),
		placeholder = document.getElementById('placeholder'),
		editLinks = document.querySelectorAll('.ethc-wrap .edit a'),
		deleteLinks = document.querySelectorAll('.ethc-wrap .delete a');

	// Add event listener to all the edit link.
	editLinks.forEach((link) => {
		link.addEventListener('click', handleEditLink);
	});

	// Add event listener to all the delete link.
	deleteLinks.forEach((link) => {
		link.addEventListener('click', handleDeleteLink);
	});

	// Event handler to handle all the edit link
	function handleEditLink(e) {
		e.preventDefault();

		Swal.fire({
			title: 'Change Placeholder',
			inputLabel: `for ${e.target.getAttribute('data-post-type')}`,
			input: 'text',
			inputValue: e.target.getAttribute('data-placeholder'),
			showCancelButton: true,
			confirmButtonText: 'Edit',
		}).then((confirm) => {
			if (confirm.isConfirmed) {
				// @todo It seem this code is repeated. Use DRY principle
				const request = new XMLHttpRequest();

				request.responseType = 'json';

				request.open('POST', ETHC.ajax_url, true);

				request.setRequestHeader(
					'Content-Type',
					'application/x-www-form-urlencoded; charset=UTF-8'
				);

				// @todo Add nonce
				const query = `action=ethc_handle_add_placeholder&post-type=${e.target.getAttribute(
					'data-post-type'
				)}&placeholder=${confirm.value}&ethc-action=edit&ajax=1`;

				request.send(query);

				Swal.fire({
					title: 'Updating Placeholder',
					closeOnEsc: false,
					allowOutsideClick: false,
					onOpen: () => {
						Swal.showLoading();
					},
				});

				request.onload = () => {
					if (request.response.status === true) {
						Swal.fire({
							title: 'Update Successfully',
							icon: 'success',
						});

						// @todo Update the value dynamically
						location.reload();
					} else if (request.response.status === false) {
						Swal.fire({
							title: 'An Error Occurred!',
							icon: 'error',
							text: 'Something wrong happened',
						});
					}
				};
				request.onerror = () => {
					Swal.fire({
						title: 'Stop!',
						text: 'An error has occurred',
						icon: 'error',
					});
				};
			}
		});
	}

	// Event handler to handle all the delete link
	function handleDeleteLink(e) {
		e.preventDefault();

		Swal.fire({
			title: 'Are you sure?',
			text: 'Do you want to delete this placeholder?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete',
			showLoaderOnConfirm: true,
		}).then((confirm) => {
			if (confirm.isConfirmed) {
				const request = new XMLHttpRequest();

				request.responseType = 'json';

				request.open('POST', ETHC.ajax_url, true);

				request.setRequestHeader(
					'Content-Type',
					'application/x-www-form-urlencoded; charset=UTF-8'
				);

				// @todo Add Nonce
				const query = `action=ethc_handle_delete_placeholder&post-type=${e.target.getAttribute(
					'data-post-type'
				)}&ethc-action=delete&ajax=1`;

				request.send(query);

				Swal.fire({
					title: 'Deleting Placeholder',
					closeOnEsc: false,
					allowOutsideClick: false,
					onOpen: () => {
						Swal.showLoading();
					},
				});

				request.onload = function () {
					if (request.response.status === true) {
						Swal.fire({
							title: 'Delete Successfully!',
							icon: 'success',
						});

						// @todo Update the value dynamically
						location.reload();
					} else if (request.response.status === false) {
						Swal.fire({
							title: 'An Error Occurred!',
							icon: 'error',
							text: 'Something wrong happened',
						});
					}
				};

				request.onerror = function () {
					Swal.fire({
						title: 'Stop!',
						text: 'An error has occurred',
						icon: 'error',
					});
				};
			}
		});
	}
})();
