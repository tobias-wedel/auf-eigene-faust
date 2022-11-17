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
				const href = e.target.getAttribute('href');

				if (href == '#') {
					zenscroll.stop();
				} else {
					e.preventDefault();
					scrollToElement = document.querySelector(href);

					let offset = link.dataset.zenoffset ? link.dataset.zenoffset : 50;

					zenscroll.setup(500, offset);
					zenscroll.to(scrollToElement);
				}
			},
			false,
		);
	});
}
smooth_anchor_scrolling();

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

		console.log(scalable[i].getBoundingClientRect().width);
		console.log(scalableContainer.getBoundingClientRect().width);

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

	if (!map_data) {
		return;
	}

	el.classList.add('loaded');

	let first_el_coords = map_data[0].coords.split(','),
		first_el_latlng = {lat: parseFloat(first_el_coords[0].trim()), lng: parseFloat(first_el_coords[1].trim())};

	const map = new google.maps.Map(document.getElementById(el_id), {
		center: first_el_latlng,
		zoom: 12,
	});

	for (const [key, map_el] of Object.entries(map_data)) {
		let coords = map_el.coords.split(','),
			latlng = {lat: parseFloat(coords[0].trim()), lng: parseFloat(coords[1].trim())},
			icon = themepath + '/assets/fontawesome/js/light.min.js';
		const priceTag = document.createElement('div');

		priceTag.className = 'price-tag';
		priceTag.textContent = '$2.5M';
		new google.maps.marker.AdvancedMarkerView({
			position: latlng,
			map,
			content: priceTag,
			//icon: {
			//	path: SQUARE_ROUNDED,
			//	fillColor: '#ffffff',
			//	fillOpacity: 1,
			//	strokeColor: '',
			//	strokeWeight: 0,
			//},
			//map_icon_label: '<i class="fal fa-location-dot"></i>',
		});
	}

	return map;
}

window.addEventListener('resize', myScaleFunction);

document.addEventListener('DOMContentLoaded', function (event) {
	set_current_viewport_on_body();
	set_css_vars();
	click_dummies();

	// Window resize action
	window.onresize = function () {
		set_current_viewport_on_body();
		set_css_vars();
	};
});
