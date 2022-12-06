// Get localized vars from functions.php
var basedomain = twtheme.basedomain,
	livedomain = twtheme.livedomain,
	ajax_url = twtheme.ajaxurl,
	themepath = twtheme.themepath,
	breakpoints = {
		xs: '0',
		sm: '576px',
		md: '768px',
		lg: '992px',
		xl: '1200px',
		xxl: '1400px',
	};

// Set the current viewport attr on body
function set_current_viewport_on_body() {
	// Iterate the breakpoints object
	for (const [breakpoint, value] of Object.entries(breakpoints)) {
		let media_querie = window.matchMedia('(min-width: ' + value + ')');

		// If the media_querie matches the current viewport set the data-size attr to body
		if (media_querie.matches) {
			document.querySelector('body').setAttribute('data-size', breakpoint);
		}
	}
}

// Get the scroll position from defined element
function is_in_viewport(element, correction) {
	if (!correction) {
		correction = 0;
	}

	let position;
	let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

	if (element.nodeType === 1) {
		let element_client = element.getBoundingClientRect();
		let element_height = element_client.height;
		position_start = element_client.top + scrollTop + correction;
		position_end = element_client.top + scrollTop + element_height + correction;

		return scrollTop >= position_start && scrollTop < position_end ? true : false;
	} else if (!isNaN(element)) {
		position = element;

		return scrollTop >= position ? true : false;
	}
}

function media_query(direction, size) {
	return window.matchMedia('(' + direction + ': ' + breakpoints[size] + ')').matches;
}

/**
 * Click dummies
 */
function click_dummies() {
	const click_dummies = document.getElementsByClassName('click-dummy');

	for (let i = 0; i < click_dummies.length; i++) {
		// Check if there's a dummy trigger first
		// If true stop dummy action on <a> click thats not the dummy trigger
		// If false get the first <a> that is found
		let dummy_trigger = click_dummies[i].querySelector('a.click-dummy-trigger');
		let link = dummy_trigger ? dummy_trigger : click_dummies[i].querySelector('a');

		if (link !== null) {
			click_dummies[i].style.cursor = 'pointer';
			click_dummies[i].addEventListener('click', e => {
				click_dummy_action(e);
			});

			function click_dummy_action(e) {
				e.preventDefault;
				if (dummy_trigger) {
					let clicked_element = e.target;

					if (clicked_element.tagName == 'A' && clicked_element != dummy_trigger) {
						return;
					}
				}
				window.location = link.href;
			}
		}
	}
}

/**
 * ZEN Scroll Stuff
 */
function smooth_anchor_scrolling() {
	const links = document.querySelectorAll('a[href*="#"]');
	links.forEach(function (link) {
		link.addEventListener(
			'click',
			function (e) {
				const href = e.target.getAttribute('href') || e.target.closest('a').getAttribute('href');

				if (href === '#') {
					zenscroll.stop();
				} else {
					e.preventDefault();
					scrollToElement = document.querySelector(href);

					let offset = link.dataset.zenoffset ? link.dataset.zenoffset : getComputedStyle(document.documentElement).getPropertyValue('--toc-slider-height').replace('px', '');

					zenscroll.setup(500, offset);
					zenscroll.to(scrollToElement);
				}
			},
			false,
		);
	});
}

/**
 * This calcs the height of elements and set a css var into defined HTML elements
 * Its useful for CSS calculating
 */
function set_css_vars(element, name, breakpoint) {
	let elements = document.querySelectorAll('[class*=set-h]');

	if (elements) {
		elements.forEach(element => {
			let element_classes = element.classList.value;
			let calc_element = element_classes.match(/set-h\[(.*?)\]/);

			calc_element = calc_element[1].split('|');

			let calc_element_to_find = calc_element[0] == 'self' ? element : element.querySelector(calc_element[0]);
			let calc_name_to_set = calc_element[1];
			let calc_name_breakpoint = calc_element[2];

			let calc_element_height = calc_element_to_find.getBoundingClientRect().height;

			// Write it as css var into html tag
			if (calc_name_breakpoint) {
				if (mediaQuery('min-width', calc_name_breakpoint)) {
					document.documentElement.style.setProperty('--' + calc_name_to_set + '-height', calc_element_height + 'px');
				} else {
					document.documentElement.style.removeProperty('--' + calc_name_to_set + '-height');
				}
			} else {
				document.documentElement.style.setProperty('--' + calc_name_to_set + '-height', calc_element_height + 'px');
			}
		});
	}
}

function scale_header() {
	var scalable = document.querySelectorAll('.scale--js');
	var margin = 40;
	for (var i = 0; i < scalable.length; i++) {
		var scalableContainer = scalable[i].parentNode;

		if (scalable[i].getBoundingClientRect().width < scalableContainer.getBoundingClientRect().width) {
			return;
		}

		scalable[i].style.transform = 'scale(1)';
		var scalableContainerWidth = scalableContainer.offsetWidth - margin;
		var scalableWidth = scalable[i].offsetWidth;
		scalable[i].style.transform = 'scale(' + scalableContainerWidth / scalableWidth + ')';
		scalableContainer.style.height = scalable[i].getBoundingClientRect().height + 'px';
	}
}

// Debounce by David Walsch
// https://davidwalsh.name/javascript-debounce-function

function debounce(func, wait, immediate) {
	var timeout;
	return function () {
		var context = this,
			args = arguments;
		var later = function () {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
}

var myScaleFunction = debounce(function () {
	//scale_header();
}, 100);

//myScaleFunction();

function init_gmap(el) {
	if (el.classList.contains('loaded')) {
		return;
	}

	let el_id = el.id;
	let map_data = JSON.parse(el.dataset.map);
	let args_data = JSON.parse(el.dataset.args);

	if (!map_data) {
		return;
	}

	el.classList.add('loaded');

	let first_el_coords = map_data[0].coords.split(','),
		first_el_latlng = {lat: parseFloat(first_el_coords[0].trim()), lng: parseFloat(first_el_coords[1].trim())};

	const map = new google.maps.Map(document.getElementById(el_id), {
		zoom: args_data.zoom ? parseFloat(args_data.zoom) : 12,
		mapId: '8c92906b2ba3b6a3',
	});

	let bounds = new google.maps.LatLngBounds();

	check_ready();

	// Check if the marker library is ready
	function check_ready() {
		if (typeof google.maps.marker === 'undefined') {
			setTimeout(() => {
				check_ready();
			}, 100);
		} else {
			run_map(() => {
				calc_heights();
			});
		}
	}

	function run_map(callback) {
		for (const property of map_data) {
			if (property.coords == '') {
				return;
			}

			let coords = property.coords.split(','),
				latlng = {lat: parseFloat(coords[0].trim()), lng: parseFloat(coords[1].trim())};

			const advancedMarkerView = new google.maps.marker.AdvancedMarkerView({
				map,
				content: buildContent(property),
				position: latlng,
				title: property.title,
			});

			bounds.extend(advancedMarkerView.position);

			const element = advancedMarkerView.element;

			['focus', 'pointerenter'].forEach(event => {
				element.addEventListener(event, () => {
					highlight(advancedMarkerView, property);
				});
			});
			['blur', 'pointerleave'].forEach(event => {
				element.addEventListener(event, () => {
					unhighlight(advancedMarkerView, property);
				});
			});
			advancedMarkerView.addListener('click', event => {
				unhighlight(advancedMarkerView, property);
			});

			function highlight(markerView, property) {
				markerView.content.classList.add('highlight');
				markerView.element.style.zIndex = 1;
			}

			function unhighlight(markerView, property) {
				markerView.content.classList.remove('highlight');
				markerView.element.style.zIndex = '';
			}

			function buildContent(property) {
				const content = document.createElement('div');

				content.classList.add('gmap-icon');
				content.style.setProperty('--color', property.color);
				content.innerHTML = `
					<div class="icon-wrapper">
						<div class="icon">${property.icon}</div>
						<div class="details">
							<div class="title">${property.title}</div>
							<div class="address">${property.address}</div>
						</div>
					</div>`;

				return content;
			}
		}

		map.fitBounds(bounds);

		var listener = google.maps.event.addListener(map, 'idle', function () {
			const current_zoom = map.zoom;

			if (args_data.zoom && args_data.zoom < current_zoom) {
				map.setZoom(parseFloat(args_data.zoom) - 0.5);
			} else {
				map.setZoom(current_zoom - 0.5);
			}

			google.maps.event.removeListener(listener);
		});

		callback();
	}

	function calc_heights() {
		let gmap_icons = el.querySelectorAll('.gmap-icon');

		if (gmap_icons.length === 0) {
			setTimeout(() => {
				calc_heights();
			}, 100);
		}

		gmap_icons.forEach((element, i) => {
			element.style.setProperty('--height', element.querySelector('.details').getBoundingClientRect().height + 'px');
		});
	}
}

function getreqfullscreen() {
	var root = document.documentElement;
	return root.requestFullscreen || root.webkitRequestFullscreen || root.mozRequestFullScreen || root.msRequestFullscreen;
}

function do_fullscreen() {
	var globalreqfullscreen = getreqfullscreen(); // get supported version of requestFullscreen()
	document.addEventListener(
		'click',
		function (e) {
			var target = e.target;
			let trigger_button = '';

			if (target.classList.contains('fullscreen-trigger')) {
				trigger_button = target;
			} else if (target.closest('.fullscreen-trigger')) {
				trigger_button = target.closest('.fullscreen-trigger');
			}

			if (trigger_button) {
				let fullscreen_id = trigger_button.dataset.fullscreen;
				let fullscreen_element = document.querySelector('#' + fullscreen_id);

				if (trigger_button.classList.contains('active')) {
					if (document.fullscreenElement) {
						document.exitFullscreen().then(() => {
							trigger_button.classList.remove('active');
							trigger_button.querySelector('.expand').style.display = 'block';
							trigger_button.querySelector('.compress').style.display = 'none';
							fullscreen_element.classList.remove('is_fullscreen');
						});
					}
				} else {
					trigger_button.classList.add('active');
					trigger_button.querySelector('.expand').style.display = 'none';
					trigger_button.querySelector('.compress').style.display = 'block';
					fullscreen_element.classList.add('is_fullscreen');
					globalreqfullscreen.call(fullscreen_element);
				}
			}
		},
		false,
	);
}

function toc_scroller() {
	let toc_scroller = document.querySelector('#toc-scroller');
	let window_width = window.innerWidth;

	// Menu item action
	toc_scroller.querySelectorAll('.nav-link').forEach(nav_link => {
		let margin = window.innerHeight * 0.5;
		if (is_in_viewport(document.querySelector(nav_link.hash), -margin)) {
			//	current_scroller_id = nav_link.hash;
			nav_link.classList.add('active');
			nav_link_offset_left = nav_link.scrollLeft + nav_link.offsetLeft;
			nav_link_width = nav_link.offsetWidth;

			// prettier-ignore
			let scroll_pos = nav_link_offset_left - (window_width / 2) + (nav_link_width / 2);
			toc_scroller.scrollTo({left: scroll_pos, behavior: 'smooth'});

			// Center the current nav-link
		} else {
			nav_link.classList.remove('active');
		}
	});
}

window.addEventListener('resize', myScaleFunction);

document.addEventListener('DOMContentLoaded', function (event) {
	set_current_viewport_on_body();
	set_css_vars();
	click_dummies();
	do_fullscreen();
	toc_scroller();
	smooth_anchor_scrolling();

	window.addEventListener('scroll', () => {
		toc_scroller();
	});

	// Window resize action
	window.onresize = function () {
		set_current_viewport_on_body();
		set_css_vars();
		toc_scroller();
	};
});
