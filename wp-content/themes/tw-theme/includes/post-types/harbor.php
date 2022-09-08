<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

add_action('init', 'twtheme_create_post_type_harbor', 0);
function twtheme_create_post_type_harbor()
{
	// Set UI labels for Custom Post Type
	$labels = [
		'name' => 'Hafen',
		'singular_name' => 'Hafen',
		'menu_name' => 'Häfen',
	];

	$args = [
		'label' => 'Hafen',
		'labels' => $labels,
		'supports' => ['title', 'author', 'revisions', 'thumbnail'],
		'hierarchical' => true,
		'public' => true,
		'rewrite' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => 0,
		'show_in_nav_menus' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-palmtree',
		'can_export' => true,
		'has_archive' => true,
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'rewrite' => ['slug' => 'hafen', 'with_front' => true],
		'show_in_rest' => false,
		'query_var'=> true,
	];

	// Registering your Custom Post Type
	register_post_type('harbor', $args);
}

add_action('add_meta_boxes', 'twtheme_harbor_pages_meta_boxes');
function twtheme_harbor_pages_meta_boxes()
{
	add_meta_box('twtheme_harbor_page_options', 'Store Inhalte', 'twtheme_harbor_options', 'harbor', 'normal', 'high', null);
}

function twtheme_harbor_options($post)
{
	$html = '';
	$html_tabs_menu = '';
	$html_tabs_content = '';
	
	
	// Add a nonce field so we can check for it later.
	wp_nonce_field('twtheme_harbor_data', '_twtheme_harbor_data_nonce');
	
	echo ThemeFieldBuilder::output(twtheme_harbor_fields(), $post->ID);
}

add_action('save_post', 'save_twtheme_harbor_pages_meta_boxes');
function save_twtheme_harbor_pages_meta_boxes($post_id)
{
	global $pagenow;
	
	// Bail out on creating a new post
	if ($pagenow === 'post-new.php') {
		return;
	}
	
	// Bail out if this is an autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	
	if (isset($_POST['_inline_edit']) && wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) {
		return;
	}
	
	// Bail out if this is not an harbor item
	if (!isset($_REQUEST['post_type']) || 'harbor' !== $_REQUEST['post_type']) {
		return;
	}
	
	// Bail out on delete
	if (isset($_GET['action']) && $_GET['action'] == 'trash') {
		return;
	}
	
	// Verify nonce
	if (isset($_REQUEST['_twtheme_harbor_data_nonce']) && !wp_verify_nonce($_REQUEST['_twtheme_harbor_data_nonce'], 'twtheme_harbor_data')) {
		return;
	}
	// Save into DB
	
	foreach (twtheme_harbor_fields() as $tab) {
		if (!empty($tab['fields'])) {
			update_post_meta($post_id, $tab['id'], $_POST[$tab['id']], false);
		}
	}
}

function twtheme_harbor_fields()
{
	return [
		[
			'title' => 'Store Infos',
			'id' => 'info',
			'fields' => [
				[
					'id' => 'info-repeater',
					'name' => 'info-repeater',
					'type' => 'repeater',
					'fields' => [
						[
							[
								'id' => 'free-text',
								'name' => 'free-text',
								'type' => 'text',
								'label' => 'Freitext',
								'description' => 'Mögliche Shortcodes: [phone], [email], [address]'
							],
						]
					]
				],
				[
					'type' => 'headline',
					'label' => 'Öffnungszeiten',
				],
				[
					'id' => 'monday',
					'name' => 'monday',
					'type' => 'text',
					'label' => 'Montag',
					'placeholder' => 'hh:mm'
				],
				[
					'id' => 'tuesday',
					'name' => 'tuesday',
					'type' => 'text',
					'label' => 'Dienstag',
					'placeholder' => 'hh:mm'
				],
				[
					'id' => 'wednesday',
					'name' => 'wednesday',
					'type' => 'text',
					'label' => 'Mittwoch',
					'placeholder' => 'hh:mm'
				],
				[
					'id' => 'thursday',
					'name' => 'thursday',
					'type' => 'text',
					'label' => 'Donnerstag',
					'placeholder' => 'hh:mm'
				],
				[
					'id' => 'friday',
					'name' => 'friday',
					'type' => 'text',
					'label' => 'Freitag',
					'placeholder' => 'hh:mm'
				],
				[
					'id' => 'saturday',
					'name' => 'saturday',
					'type' => 'text',
					'label' => 'Samstag',
					'placeholder' => 'hh:mm',
				],
				[
					'id' => 'sunday',
					'name' => 'sunday',
					'type' => 'text',
					'label' => 'Sonntag',
					'placeholder' => 'hh:mm'
				],
				[
					'type' => 'headline',
					'label' => 'Button',
				],
				[
					'id' => 'button-enabled',
					'name' => 'button-enabled',
					'type' => 'radio',
					'label' => 'Button anzeigen',
					'options' => [
						[
							'value' => true,
							'label' => 'Ja',
							'checked' => true,
						],
						[
							'value' => false,
							'label' => 'Nein',
						],
					]
				],
				[
					'id' => 'button-custom-url',
					'name' => 'button-custom-url',
					'type' => 'text',
					'label' => 'Eigene URL',
					'description' => 'Überschreibt die ausgewählte Seite!',
				],
				[
					'id' => 'button-url-parameter',
					'name' => 'button-url-parameter',
					'type' => 'text',
					'label' => 'URL Parameter',
					'placeholder' => '?store=storename',
					'description' => 'Verwende %s um den Titel einzufügen.'
				],
				[
					'id' => 'button-text',
					'name' => 'button-text',
					'type' => 'text',
					'label' => 'Text',
					'description' => 'Verwende %s um den Titel einzufügen.'
				],
				[
					'type' => 'headline',
					'label' => 'Google Maps',
				],
				[
					'id' => 'address',
					'name' => 'address',
					'type' => 'integration',
					'label' => 'Adresse',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'location',
						'type' => 'text',
						'target' => 'gmaps-coords'
					]
				],
				[
					'id' => 'gmaps-coords',
					'name' => 'gmaps-coords',
					'type' => 'text',
					'readonly' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.'
				],
				[
					'id' => 'approach',
					'name' => 'approach',
					'type' => 'editor',
					'label' => 'Anfahrts&shy;beschreibung',
				],
			],
		],
		[
			'title' => 'Über den Store',
			'id' => 'about',
			'fields' => [
				[
					'id' => 'about-text',
					'name' => 'about-text',
					'type' => 'editor',
					'label' => 'Über den Store',
				],
				[
					'id' => 'about-benefit',
					'name' => 'about-benefit',
					'type' => 'textarea',
					'label' => 'Leistungen',
					'description' => 'Jede Zeile ergibt einen Listenpunkt',
				],
			],
		],
		[
			'title' => 'Galerie',
			'id' => 'gallery',
			'fields' => [
				[
					'id' => 'store-impression',
					'name' => 'store-impression',
					'type' => 'gallery',
					'label' => 'Store Impressionen',
				],
			],
		],
		[
			'title' => 'SEO Text',
			'id' => 'seo-text',
			'fields' => [
				[
					'id' => 'text',
					'name' => 'text',
					'type' => 'editor',
					'label' => 'Text',
				],
			],
		],
		[
			'title' => 'Services',
			'id' => 'services',
			'fields' => [
				[
					'id' => 'service-repeater',
					'name' => 'service-repeater',
					'type' => 'repeater',
					'label' => 'Über den Store',
					'fields' => [
						[
							[
								'id' => 'title',
								'name' => 'title',
								'type' => 'text',
								'label' => 'Titel',
							],
							[
								'id' => 'image',
								'name' => 'image',
								'type' => 'image',
								'label' => 'Bild',
							],
							[
								'id' => 'list',
								'name' => 'list',
								'type' => 'textarea',
								'label' => 'Liste',
								'description' => 'Jede Zeile ergibt einen Listenpunkt'
							],
							[
								'id' => 'button-url',
								'name' => 'button-url',
								'type' => 'text',
								'label' => 'Button URL',
							],
							[
								'id' => 'button-text',
								'name' => 'button-text',
								'type' => 'text',
								'label' => 'Button Text',
							],
						]
					],
				],
			],
		],
	];
}
