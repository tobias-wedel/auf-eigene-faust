// This checks if livecanvas is fully loaded
function init_livecanvas() {
	let livecanvas_is_ready = document.querySelector('#lc-main');

	if (!livecanvas_is_ready) {
		setTimeout(() => {
			init_livecanvas();
		}, 200);
	} else {
		setTimeout(() => {
			livecanvas_action();
		}, 3000);
	}
}
init_livecanvas();

// Do all actions for livecanvas here
function livecanvas_action() {
	// Do livecanvas action here
}
