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
function is_in_viewport(element, correction, action) {
	console.log(action);
	if (!action) {
		action = 'between';
	}

	if (!correction) {
		correction = 0;
	}

	let position;
	let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

	if (element.nodeType === 1) {
		let element_client = element.getBoundingClientRect();
		let element_height = element_client.height;

		let position_start = element_client.top + scrollTop + correction;

		if (action == 'between') {
			position_end = element_client.top + scrollTop + element_height + correction;
			return scrollTop >= position_start && scrollTop < position_end ? true : false;
		} else if (action == 'after') {
			return scrollTop >= position_start ? true : false;
		}
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
					if (document.exitFullscreen) {
						document.exitFullscreen();
					} else if (document.mozCancelFullScreen) {
						document.mozCancelFullScreen();
					} else if (document.webkitCancelFullScreen) {
						document.webkitCancelFullScreen();
					}
				} else {
					trigger_button.classList.add('active');
					trigger_button.querySelector('.expand').style.display = 'none';
					trigger_button.querySelector('.compress').style.display = 'block';
					fullscreen_element.classList.add('is_fullscreen');
					globalreqfullscreen.call(fullscreen_element);
				}

				document.addEventListener('fullscreenchange', exitHandler);
				document.addEventListener('webkitfullscreenchange', exitHandler);
				document.addEventListener('mozfullscreenchange', exitHandler);
				document.addEventListener('MSFullscreenChange', exitHandler);

				function exitHandler() {
					if (!document.fullscreenElement && !document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
						trigger_button.classList.remove('active');
						trigger_button.querySelector('.expand').style.display = 'block';
						trigger_button.querySelector('.compress').style.display = 'none';
						fullscreen_element.classList.remove('is_fullscreen');

						document.removeEventListener('fullscreenchange', exitHandler);
						document.removeEventListener('webkitfullscreenchange', exitHandler);
						document.removeEventListener('mozfullscreenchange', exitHandler);
						document.removeEventListener('MSFullscreenChange', exitHandler);
					}
				}
			}
		},
		false,
	);
}

function dynamic_content() {
	document.querySelectorAll('[data-dynamic_fn]').forEach(dynamic_element => {
		const dynamic_fn = dynamic_element.dataset.dynamic_fn,
			dynamic_key = dynamic_element.dataset.dynamic_key ? dynamic_element.dataset.dynamic_key : '',
			dynamic_action = dynamic_element.dataset.dynamic_action ? dynamic_element.dataset.dynamic_action : '';

		if (!dynamic_fn) {
			return false;
		}

		handle_the_dynamic_content_request(dynamic_element, dynamic_fn, dynamic_key, dynamic_action);
	});

	function handle_the_dynamic_content_request(dynamic_element, dynamic_fn, dynamic_key, dynamic_action) {
		var formData = new FormData();
		formData.append('action', 'dynamic_content');
		formData.append('post_ID', twtheme.post_ID);
		formData.append('dynamic_fn', dynamic_fn);

		if (dynamic_key != '') {
			formData.append('dynamic_key', dynamic_key);
		}
		if (dynamic_action) {
			if (dynamic_action == 'lazy' && dynamic_key) {
				dynamic_content_lazy_load(dynamic_element, dynamic_key, formData);
			}
		} else {
			do_the_ajax(formData);
		}
	}

	function dynamic_content_lazy_load(dynamic_element, dynamic_key, formData) {
		window.addEventListener('scroll', load_content);

		function load_content() {
			if (is_in_viewport(dynamic_element, -(window.innerHeight * 2), 'after')) {
				do_the_ajax(formData, ajax_response => {
					let response = JSON.parse(ajax_response);

					dynamic_element.innerHTML = response.html;

					// If script is given, add it to head section
					if (response.script != '') {
						// Get all attributes from the script and build it new
						let script_split = response.script[0].split(' ');

						let the_script = document.createElement('script');
						script_split.forEach(el => {
							let atts = /(.*?)="(.*?)"|[a-z]+/.exec(el);

							// Skip script tag
							if (atts[0] == 'script') {
								return;
							}

							if (!atts[1]) {
								the_script.setAttribute(atts[0], atts[0]);
							} else {
								the_script.setAttribute(atts[1], atts[2]);
							}
						});

						document.head.appendChild(the_script);
					}
				});

				window.removeEventListener('scroll', load_content);
			}
		}
	}

	function do_the_ajax(formData, action) {
		/** HTTP Request */
		var httpRequest = new XMLHttpRequest();
		httpRequest.onload = function () {
			if (httpRequest.status >= 200 && httpRequest.status < 300) {
				action(httpRequest.responseText);
			} else {
			}
		};

		httpRequest.open('POST', ajax_url);
		httpRequest.send(formData);
	}
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
	dynamic_content();

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
