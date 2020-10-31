"use strict";

(function () {
	const postType = document.getElementById("post-type"),
		placeholder = document.getElementById("placeholder"),
		editLinks = document.querySelectorAll(".ethc-wrap .edit a"),
		deleteLinks = document.querySelectorAll(".ethc-wrap .delete a");

	editLinks.forEach((link) => {
		link.addEventListener("click", handleEditLink);
	});

	deleteLinks.forEach((link) => {
		link.addEventListener("click", handleDeleteLink);
	});

	function handleEditLink(e) {
		e.preventDefault();
		postType.value = e.target.getAttribute("data-post-type");
		placeholder.value = e.target.getAttribute("data-placeholder");
		placeholder.focus();
	}

	function handleDeleteLink(e) {
		e.preventDefault();

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
})();
