"use strict";

(function () {

	// Get all the required DOM element.
	const postType = document.getElementById("post-type"),
		placeholder = document.getElementById("placeholder"),
		editLinks = document.querySelectorAll(".ethc-wrap .edit a"),
		deleteLinks = document.querySelectorAll(".ethc-wrap .delete a");

	// Add event listener to all the edit link.
	editLinks.forEach((link) => {
		link.addEventListener("click", handleEditLink);
	});

	// Add event listener to all the delete link.
	deleteLinks.forEach((link) => {
		link.addEventListener("click", handleDeleteLink);
	});

	// Event handler to handle all the edit link
	function handleEditLink(e) {
		e.preventDefault();
		postType.value = e.target.getAttribute("data-post-type");
		placeholder.value = e.target.getAttribute("data-placeholder");
		placeholder.focus();
	}

	// Event handler to handle all the delete link
	function handleDeleteLink(e) {
		e.preventDefault();

		swal({
			title: 'Are you sure?',
			text: 'Do you want to delete this placeholder?',
			icon: 'warning',
			buttons: {
				cancel: true,
				confirm: "Confirm",
			}
		}).then( (confirm ) => {
			if ( confirm ) {
				const request = new XMLHttpRequest(),
				postType = e.target.getAttribute("data-post-type"),
				data = {
					action: ETHC.action,
					postType: postType,
				};

				request.open("POST", ETHC.ajax_url, true);
				request.setRequestHeader(
					"Content-Type",
					"application/x-www-form-urlencoded; charset=UTF-8"
				);

				request.onload = function () {
					console.log(request.response);
				};

				request.onerror = function () {
					console.log("error");
				};

				const query = `action=ethc_handle_delete_placeholder&post-type=${e.target.getAttribute(
					"data-post-type"
				)}&ethc-action=delete&ajax=1`;
				console.log(query);
				request.send(query);

				console.log(e.target.getAttribute("data-post-type"));
			}
		});


	}
})();
