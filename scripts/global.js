
require(['jquery','headroom'],
	function($) {

		var header = new Headroom(document.querySelector("#task-toolbar"), {
			tolerance: 5,
			offset : 100,
			classes: {
			  initial: "animated",
			  pinned: "slideDown",
			  unpinned: "slideUp"
			}
		});
		header.init();
});