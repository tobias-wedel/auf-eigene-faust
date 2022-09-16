jQuery(document).ready(function ($) {
	/***** Colour picker *****/

	$('.colorpicker').hide();
	$('.colorpicker').each(function () {
		$(this).farbtastic($(this).closest('.color-picker').find('.color'));
	});

	$('.color').click(function () {
		$(this).closest('.color-picker').find('.colorpicker').fadeIn();
	});

	$(document).mousedown(function () {
		$('.colorpicker').each(function () {
			var display = $(this).css('display');
			if (display == 'block') $(this).fadeOut();
		});
	});

	/*
	 * A custom function that checks if element is in array, we'll need it later
	 */
	function in_array(el, arr) {
		for (var i in arr) {
			if (arr[i] == el) return true;
		}
		return false;
	}

	/***** Uploading images *****/
	jQuery(document).on('click', '.image_upload_button', function (e) {
		e.preventDefault();

		var button = jQuery(this),
			file_frame,
			hiddenfield = button.next(),
			gallery = button.prev('ul'),
			hiddenfieldvalue = hiddenfield.val().split(',') /* the array of added image IDs */,
			parent_wrapper = button.closest('td');

		// If the media frame already exists, reopen it.
		if (file_frame) {
			file_frame.open();
			return;
		}

		let multiple = button.attr('multiple') ? true : false;

		// Create the media frame.
		file_frame = wp.media({
			title: jQuery(this).data('uploader_title'),
			library: {type: 'image'},
			button: {
				text: jQuery(this).data('uploader_button_text'),
			},
			multiple: multiple,
		});

		// if you have IDs of previously selected files you can set them checked
		file_frame.on('open', function () {
			let selection = file_frame.state().get('selection');
			let ids = hiddenfieldvalue; // array of IDs of previously selected files. You're gonna build it dynamically
			ids.forEach(function (id) {
				let attachment = wp.media.attachment(id);
				selection.add(attachment ? [attachment] : []);
			}); // would be probably a good idea to check if it is indeed a non-empty array
		});

		// When an image is selected, run a callback.
		file_frame.on('select', function () {
			var attachments = file_frame
					.state()
					.get('selection')
					.map(function (a) {
						a.toJSON();
						return a;
					}),
				thesamepicture = false,
				i;

			for (i = 0; i < attachments.length; ++i) {
				/* if you don't want the same images to be added multiple time */
				if (!in_array(attachments[i].id, hiddenfieldvalue)) {
					/* add HTML element with an image */
					if (multiple) {
						gallery.append('<li data-id="' + attachments[i].id + '"><span style="background-image:url(' + attachments[i].attributes.url + ')"></span><a href="#" class="tw_gallery_remove">&times;</a></li>');

						hiddenfieldvalue.push(attachments[i].id);
					} else {
						gallery.html('<li data-id="' + attachments[i].id + '"><span style="background-image:url(' + attachments[i].attributes.url + ')"></span><a href="#" class="tw_gallery_remove">&times;</a></li>');

						hiddenfieldvalue[0] = attachments[i].id;
					}
				} else {
					thesamepicture = true;
				}
			}

			parent_wrapper.find('input').val(hiddenfieldvalue.join());

			/* add the IDs to the hidden field value */
			hiddenfield.val(hiddenfieldvalue.join());
			/* you can print a message for users if you want to let you know about the same images */
			if (thesamepicture == true) alert('Die gleichen Bilder sind nicht erlaubt!');
		});

		// Finally, open the modal
		file_frame.open();
	});

	jQuery('.image_delete_button').click(function () {
		jQuery(this).closest('td').find('.image_data_field').val('');
		jQuery(this).closest('td').find('.image_preview').attr('src', '');
		return false;
	});

	/*
	 * Remove certain images
	 */
	$('body').on('click', '.tw_gallery_remove', function () {
		var id = $(this).parent().attr('data-id'),
			gallery = $(this).parent().parent(),
			hiddenfield = gallery.parent().find('input[type="hidden"]'),
			hiddenfieldvalue = hiddenfield.val().split(','),
			i = hiddenfieldvalue.indexOf(id);

		$(this).parent().remove();

		/* remove certain array element */
		if (i != -1) {
			hiddenfieldvalue.splice(i, 1);
		}

		/* add the IDs to the hidden field value */
		hiddenfield.val(hiddenfieldvalue.join());

		return false;
	});
});

check_tab_in_url();
function check_tab_in_url() {
	let current_url = new URL(window.location.href);
	let tab_param_exists = current_url.searchParams.get('eftab');

	// If tab aprams exists open it
	if (tab_param_exists) {
		openTab('', tab_param_exists);
	}
}

function openTab(event, tab_name) {
	if (event) {
		event.preventDefault();
	}

	let target = document.querySelector('[data-tabid="' + tab_name + '"');

	// Update new url with tab param
	let current_url = new URL(window.location.href);
	current_url.searchParams.set('eftab', tab_name);
	window.history.replaceState('', '', current_url);

	// Declare all variables
	var i, tabcontent, tablinks;

	// Get all elements with class="tabcontent" and hide them
	tabcontent = document.getElementsByClassName('tabcontent');
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = 'none';
	}

	// Get all elements with class="tablinks" and remove the class "active"
	tablinks = document.querySelectorAll('.tablink');

	tablinks.forEach(function (tablink) {
		tablink.classList.remove('active');
	});

	// Show the current tab, and add an "active" class to the button that opened the tab
	document.getElementById(tab_name).style.display = 'block';
	target.classList.add('active');

	// Update _wp_http_referer value (Save URL)
	let wp_http_referer = document.querySelector('[name="_wp_http_referer"]');
	let wp_http_referer_value = wp_http_referer.value;

	if (wp_http_referer) {
		let wp_http_referer_url = new URL(easyform_vars.home_url + wp_http_referer_value);

		wp_http_referer_url.searchParams.set('eftab', tab_name);
		wp_http_referer.value = wp_http_referer_url.href.replace(easyform_vars.home_url, '');
	}
}

// Code Mirror
// TODO: Code Mirror sollte schon beim pageload laden "autoRefresh" scheint nicht zuverlässig zu funktionieren!
codemirror_action();
function codemirror_action() {
	document.querySelectorAll('.codemirror-htmlmixed').forEach(function (textarea) {
		if (textarea.nextElementSibling == null || (textarea.nextElementSibling != null && !textarea.nextElementSibling.classList.contains('CodeMirror'))) {
			var myCodeMirror = CodeMirror.fromTextArea(textarea, {
				name: 'htmlmixed',
				tags: {
					style: [
						['type', /^text\/(x-)?scss$/, 'text/x-scss'],
						[null, null, 'css'],
					],
					custom: [[null, null, 'customMode']],
				},
				autoRefresh: true,
				styleActiveLine: true,
				lineNumbers: true,
				lineWrapping: true,
				foldGutter: true,
				gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
			});
		}
	});
	document.querySelectorAll('.codemirror-javascript').forEach(function (textarea) {
		var myCodeMirror = CodeMirror.fromTextArea(textarea, {
			mode: 'javascript',
			autoRefresh: true,
			styleActiveLine: true,
			lineNumbers: true,
			lineWrapping: true,
			foldGutter: true,
			gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
		});
	});
}

function repeater_fields() {
	let repeater_groups_holder = document.querySelectorAll('.repeater-groups-holder');

	repeater_groups_holder.forEach(repeater_group_holder => {
		repeater_block_btn = repeater_group_holder.querySelector('.add-block');

		// Change the key
		repeater_block_btn.addEventListener('click', event => {
			event.preventDefault();

			add_repeater_block(repeater_group_holder);
			repeater_fields_refresh_keys(repeater_group_holder);
		});
	});

	remove_repeater_block();
}
repeater_fields();

function repeater_fields_refresh_keys(repeater_group_holder) {
	let repeater_groups = repeater_group_holder.querySelectorAll('.repeater-group');
	let repeater_groups_count = repeater_groups.length;

	repeater_groups.forEach((group, index) => {
		group.dataset.repeatergroupkey = index;

		group.querySelectorAll('*').forEach(element => {
			let attributes = element.getAttributeNames();

			attributes.forEach(attribute => {
				element.setAttribute(attribute, element.getAttribute(attribute).replace(/\[\d\]/gm, '[' + index + ']'));

				// Check for wp_editor and the ids because there're sanitized
				if (attribute == 'class' && element.classList.contains('wp-editor-area')) {
					element.setAttribute('id', element.getAttribute('id').replace(/\d/g, index));
					// Refresh Editor
					refresh_wp_editor(element.getAttribute('id'));
				}
			});
		});
	});
}

function add_repeater_block(repeater_group_holder) {
	repeater_group_holder.querySelectorAll('.wp-editor-area').forEach((textarea, i) => {
		let editor_id = textarea.id;
		wp.editor.remove(editor_id);
	});

	let repeater_block_html = repeater_group_holder.querySelector('.repeater-group').outerHTML;

	// Clear all values
	let placed_block = repeater_group_holder.querySelector('.drag-fields').insertAdjacentHTML('beforeend', repeater_block_html);

	repeater_group_holder
		.querySelector('.repeater-group:last-child')
		.querySelectorAll('input, select, textarea, .tw_gallery_mtb')
		.forEach(element => {
			switch (element.tagName) {
				case 'INPUT':
					element.value = '';
					break;
				case 'TEXTAREA':
				case 'UL':
					element.innerHTML = '';
					break;
			}
		});

	repeater_group_holder.querySelectorAll('.wp-editor-area').forEach((textarea, i) => {
		let editor_id = textarea.id;
		refresh_wp_editor(editor_id);
	});
}

function remove_repeater_block() {
	document.addEventListener('click', e => {
		let target = e.target;

		if (!target.classList.contains('dashicons-trash')) {
			return;
		}

		let repeater_holder = target.closest('.repeater-groups-holder');

		target.closest('.repeater-group').remove();
		repeater_fields_refresh_keys(repeater_holder);
	});
}

function handle_integrations() {
	document.addEventListener('change', event => {
		element = event.target;
		if (element.hasAttribute('data-integration')) {
			let integration_field = JSON.parse(element.dataset.integration);
			if (integration_field.tool == 'gmaps') {
				function initMap() {}

				if (integration_field.service == 'geocoding') {
					geocoder = new google.maps.Geocoder();
					geocoder.geocode({address: event.target.value}, function (results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							var latitude = results[0].geometry.location.lat();
							var longitude = results[0].geometry.location.lng();

							element.closest('tr').nextElementSibling.querySelector('input').value = latitude + ', ' + longitude;
						} else {
							console.log('Geocode was not successful for the following reason: ' + status);
						}
					});
				}

				function geocode(address) {}
			}
		}
	});
}
handle_integrations();

// List with handle
do_sortable();
function do_sortable(action) {
	if (action == 'refresh') {
		Sortable.destroy();
	}

	document.querySelectorAll('.drag-fields').forEach(drag_field => {
		let table_wrapper = drag_field.querySelector('.table-wrapper');
		let drag_field_holder = drag_field.closest('.repeater-groups-holder');

		// Set height to table_wrapper
		// We need this to make the transition
		drag_field.querySelectorAll('.drag').forEach((element, i) => {
			let table_wrapper = element.closest('.table-wrapper');

			element.addEventListener('mouseenter', e => {
				//	drag_field_holder.style.setProperty('--height', table_wrapper.getBoundingClientRect().height + 'px');
			});

			// Reset height
			//element.addEventListener('mouseleave', e => {
			//	drag_field.style.removeProperty('--height');
			//	table_wrapper.classList.remove('active');
			//});
		});

		Sortable.create(drag_field, {
			handle: '.drag',
			animation: 150,
			onChoose: function (e) {
				drag_field.classList.add('dragging');
				drag_field_holder.style.setProperty('--height', table_wrapper.getBoundingClientRect().height + 'px');
				drag_field.insertAdjacentHTML('afterend', '<div class="repeater-group-spacer"></div>');
				e.item.querySelector('.table-wrapper').classList.add('active');
			},
			onStart: function (e) {
				// Reindex the fields
				drag_field
					.closest('.repeater-groups-holder')
					.querySelectorAll('.wp-editor-area')
					.forEach((textarea, i) => {
						let editor_id = textarea.id;
						wp.editor.remove(editor_id);
					});
			},
			onUnchoose: function (e) {
				// Reindex the fields
				repeater_fields_refresh_keys(drag_field.closest('.repeater-groups-holder'));
				drag_field_holder.style.removeProperty('--height');
				drag_field_holder.querySelector('.repeater-group-spacer').remove();
				drag_field.classList.remove('dragging');
				e.item.querySelector('.table-wrapper').classList.remove('active');
			},
		});
	});
}

function refresh_wp_editor(editor_id) {
	wp.editor.remove(editor_id);

	var settings = {
		tinymce: {
			wpautop: true,
			toolbar1: 'formatselect, bold, italic, bullist, numlist, blockquote, hr, alignleft, aligncenter, alignright, link, unlink, wp_more, spellchecker, fullscreen, wp_adv',
			toolbar2: 'strikethrough, underline, alignjustify, forecolor, pastetext, removeformat, charmap, outdent, indent, undo, redo, wp_help',
		},
		quicktags: {
			buttons: 'strong,em,link,block,ins,img,ul,ol,li,code,more,close',
		},
	};

	wp.editor.initialize(editor_id, settings);
}

make_field_editable();
function make_field_editable() {
	document.querySelectorAll('.button.make-editable').forEach((button, i) => {
		button.addEventListener('click', e => {
			e.preventDefault();

			e.target.previousElementSibling.removeAttribute('readonly');
			e.target.previousElementSibling.removeAttribute('disabled');
		});
	});
}
