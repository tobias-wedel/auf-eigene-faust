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
		mapId: twtheme.gmaps_id,
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
