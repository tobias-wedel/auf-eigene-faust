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
	add_meta_box('twtheme_harbor_page_options', 'Hafen Inhalte', 'twtheme_harbor_options', 'harbor', 'normal', 'high', null);
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
			'title' => 'Einleitung',
			'id' => 'prolog',
			'fields' => [
				[
					'id' => 'gallery',
					'name' => 'gallery',
					'type' => 'gallery',
					'label' => 'Galerie',
				],
				[
					'id' => 'prolog',
					'name' => 'prolog',
					'type' => 'editor',
					'label' => 'Einleitungstext'
				],
				[
					'id' => 'country',
					'name' => 'country',
					'type' => 'text',
					'label' => 'Land'
				],
				[
					'id' => 'language',
					'name' => 'language',
					'type' => 'text',
					'label' => 'Sprache'
				],
				[
					'id' => 'currency',
					'name' => 'currency',
					'type' => 'text',
					'label' => 'Währung'
				],
				[
					'id' => 'season',
					'name' => 'season',
					'type' => 'text',
					'label' => 'Beste Reisezeit'
				],
				[
					'id' => 'visa',
					'name' => 'visa',
					'type' => 'text',
					'label' => 'Reisepass / Visum'
				],
			],
		],
		[
			'title' => 'Über den Hafen',
			'id' => 'about',
			'fields' => [
				[
					'id' => 'gallery',
					'name' => 'gallery',
					'type' => 'gallery',
					'label' => 'Galerie',
				],
				[
					'id' => 'address',
					'name' => 'address',
					'type' => 'integration',
					'label' => 'Adresse',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'target' => 'address-coords'
					]
				],
				[
					'id' => 'address-coords',
					'name' => 'address-coords',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.'
				],
				[
					'id' => 'text',
					'name' => 'text',
					'type' => 'editor',
					'label' => 'Text',
				],
				[
					'id' => 'shuttle',
					'name' => 'shuttle',
					'type' => 'textarea',
					'label' => 'Hafenshuttle'
				],
				[
					'id' => 'arrival-airport',
					'name' => 'arrival-airport',
					'type' => 'textarea',
					'label' => 'Anfahrt Flughafen'
				],
			],
		],
		[
			'title' => 'Mobilität',
			'id' => 'mobility',
			'fields' => [
				[
					'id' => 'list',
					'name' => 'list',
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
								'id' => 'gallery',
								'name' => 'gallery',
								'type' => 'gallery',
								'label' => 'Galerie',
							],
							[
								'id' => 'text',
								'name' => 'text',
								'type' => 'editor',
								'label' => 'Text',
							],
						]
					],
				],
			],
		],
		[
			'title' => 'Highlights',
			'id' => 'highlights',
			'fields' => [
				[
					'id' => 'list',
					'name' => 'list',
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
								'id' => 'gallery',
								'name' => 'gallery',
								'type' => 'gallery',
								'label' => 'Galerie',
							],
							[
								'id' => 'address',
								'name' => 'address',
								'type' => 'integration',
								'label' => 'Adresse',
								'integration' => [
									'tool' => 'gmaps',
									'service' => 'geocoding',
								]
							],
							[
								'id' => 'address-coords',
								'name' => 'address-coords',
								'type' => 'text',
								'readonly' => true,
								'editable' => true,
								'label' => 'Koordinaten',
								'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.'
							],
							[
								'id' => 'direction',
								'name' => 'direction',
								'type' => 'text',
								'label' => 'Wegbeschreibung',
							],
							[
								'id' => 'tickets',
								'name' => 'tickets',
								'type' => 'text',
								'label' => 'Tickets',
							],
							[
								'id' => 'text',
								'name' => 'text',
								'type' => 'editor',
								'label' => 'Text',
							],
						]
					],
				],
			],
		],
		[
			'title' => 'Aktivitäten',
			'id' => 'activity',
			'fields' => [
				[
					'id' => 'list',
					'name' => 'list',
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
								'id' => 'gallery',
								'name' => 'gallery',
								'type' => 'gallery',
								'label' => 'Galerie',
							],
							[
								'id' => 'text',
								'name' => 'text',
								'type' => 'editor',
								'label' => 'Text',
							],
						]
					],
				],
			],
		],
		[
			'title' => 'Lokale Anbieter',
			'id' => 'locals',
			'fields' => [
				[
					'id' => 'list',
					'name' => 'list',
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
								'id' => 'gallery',
								'name' => 'gallery',
								'type' => 'gallery',
								'label' => 'Galerie',
							],
							[
								'id' => 'text',
								'name' => 'text',
								'type' => 'editor',
								'label' => 'Text',
							],
							[
								'id' => 'facebook',
								'name' => 'facebook',
								'type' => 'text',
								'label' => 'Facebook',
							],
							[
								'id' => 'instagram',
								'name' => 'instagram',
								'type' => 'text',
								'label' => 'Instagram',
							],
							[
								'id' => 'website',
								'name' => 'website',
								'type' => 'text',
								'label' => 'Website',
							],
							[
								'id' => 'booking',
								'name' => 'booking',
								'type' => 'text',
								'label' => 'Buchen URL',
							],
						]
					],
				],
			],
		],
		[
			'title' => 'FAQ',
			'id' => 'faq',
			'fields' => [
				[
					'id' => 'faqs',
					'name' => 'faqs',
					'type' => 'repeater',
					'fields' => [
						[
							[
								'id' => 'question',
								'name' => 'question',
								'type' => 'text',
								'label' => 'Frage',
							],
							[
								'id' => 'answer',
								'name' => 'answer',
								'type' => 'textarea',
								'label' => 'Antwort',
							],
						]
					],
				],
			],
		],
		[
			'title' => 'Affiliates',
			'id' => 'affiliates',
			'fields' => [
				[
					'id' => 'affiliates',
					'name' => 'affiliates',
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
								'id' => 'widget',
								'name' => 'widget',
								'type' => 'textarea',
								'label' => 'Widget',
							],
						],
					],
				],
			],
		],
	];
}
