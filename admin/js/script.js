"use strict";

(function () {
	var editLinks = document.querySelectorAll(".ethc-wrap .edit a");
	var deleteLinks = document.querySelectorAll(".ethc-wrap .delete a");

	editLinks.forEach((link) => {
		link.addEventListener("click", handleEditLink);
	});

	deleteLinks.forEach((link) => {
		link.addEventListener("click", handleDeleteLink);
	});

	function handleEditLink(e) {
		console.log(e.target.getAttribute("data-post-type"));
		e.preventDefault();
	}

	function handleDeleteLink(e) {
		e.preventDefault();
		console.log(e.target.getAttribute("data-post-type"));
	}
})();
