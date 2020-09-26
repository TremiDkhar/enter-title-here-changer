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
		console.log(e.target.getAttribute("data-post-type"));
	}
})();
