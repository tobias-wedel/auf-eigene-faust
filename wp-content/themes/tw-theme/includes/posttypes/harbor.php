<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

$harbor_posttype = new TwthemeCreatePostType('harbor', 'Hafen Details', harbor_register_post_type_args(), harbor_fields());

function harbor_register_post_type_args()
{
	return [
		'label' => 'Hafen',
		'labels' => [
			'name' => 'Hafen',
			'singular_name' => 'Hafen',
			'menu_name' => 'Häfen',
		],
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
		'taxonomies' => array('post_tag'),
	];
}

function harbor_fields()
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
					'label' => 'Einleitungstext',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'country',
					'name' => 'country',
					'type' => 'select',
					'label' => 'Land',
					'options' => [
						[
							'value' => '',
							'label' => 'Bitte wählen',
						],
					],
					'options_from_data' => get_country_list()
				],
				[
					'id' => 'language',
					'name' => 'language',
					'type' => 'select',
					'multiple' => true,
					'label' => 'Sprache(n)',
					'options_from_data' => get_language_list()
				],
				[
					'id' => 'currency',
					'name' => 'currency',
					'type' => 'select',
					'label' => 'Währung',
					'options' => [
						[
							'value' => '',
							'label' => 'Bitte wählen',
						],
					],
					'options_from_data' => get_currency_list()
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
			'title' => 'Der Hafen',
			'id' => 'about',
			'fields' => [
				[
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => 'Hafen %s',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
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
					'type' => 'text',
					'label' => 'Adresse'
				],
				[
					'id' => 'address-coords',
					'name' => 'address-coords',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'address'
					]
				],
				[
					'type' => 'headline',
					'label' => 'Anlegestellen',
				],
				[
					'id' => 'landing-stages',
					'name' => 'landing-stages',
					'type' => 'repeater',
					'label' => 'Anlegestellen',
					'fields' => [
						[
							
							[
								'id' => 'address',
								'name' => 'address',
								'type' => 'text',
								'label' => 'Adresse'
							],
							[
								'id' => 'address-coords',
								'name' => 'address-coords',
								'type' => 'text',
								'readonly' => true,
								'editable' => true,
								'label' => 'Koordinaten',
								'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
								'integration' => [
									'tool' => 'gmaps',
									'service' => 'geocoding',
									'source' => 'address'
								]
							],
						]
					]
				],
				[
					'type' => 'headline',
					'label' => 'Beschreibungen',
				],
				[
					'id' => 'text',
					'name' => 'text',
					'type' => 'editor',
					'label' => 'Text',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'shuttle',
					'name' => 'shuttle',
					'type' => 'editor',
					'label' => 'Hafenshuttle',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'arrival-airport',
					'name' => 'arrival-airport',
					'type' => 'editor',
					'label' => 'Anfahrt Flughafen',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
			],
		],
		[
			'title' => 'Mobilität',
			'id' => 'mobility',
			'fields' => [
				[
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => 'Unterwegs in %s',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
				],
				[
					'id' => 'intro',
					'name' => 'intro',
					'type' => 'editor',
					'label' => 'Introtext',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'foot',
					'name' => 'foot',
					'type' => 'editor',
					'label' => 'Zu Fuß',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'bicycle',
					'name' => 'bicycle',
					'type' => 'editor',
					'label' => 'Fahrrad',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'e-scooter',
					'name' => 'e-scooter',
					'type' => 'editor',
					'label' => 'E-Scooter',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'taxi',
					'name' => 'taxi',
					'type' => 'editor',
					'label' => 'Taxi',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'rental-car',
					'name' => 'rental-car',
					'type' => 'editor',
					'label' => 'Mietwagen',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'bus',
					'name' => 'bus',
					'type' => 'editor',
					'label' => 'Bus',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'hop-on-bus',
					'name' => 'hop-on-bus',
					'type' => 'editor',
					'label' => 'Hop-On-Hop-Off Bus',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'metro',
					'name' => 'metro',
					'type' => 'editor',
					'label' => 'Metro / U-Bahn',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'train',
					'name' => 'train',
					'type' => 'editor',
					'label' => 'Zug',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
			],
		],
		[
			'title' => 'Highlights',
			'id' => 'highlights',
			'fields' => [
				[
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => '%s Seheswürdigkeiten',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
				],
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
								'settings' => [
									'textarea_rows' => '6',
								]
							],
							[
								'id' => 'address',
								'name' => 'address',
								'type' => 'text',
								'label' => 'Adresse'
							],
							[
								'id' => 'address-coords',
								'name' => 'address-coords',
								'type' => 'text',
								'readonly' => true,
								'editable' => true,
								'label' => 'Koordinaten',
								'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
								'integration' => [
									'tool' => 'gmaps',
									'service' => 'geocoding',
									'source' => 'address'
								]
							],
							[
								'id' => 'direction',
								'name' => 'direction',
								'type' => 'editor',
								'label' => 'Wegbeschreibung',
								'settings' => [
									'textarea_rows' => '6',
								]
							],
							[
								'id' => 'tickets',
								'name' => 'tickets',
								'type' => 'text',
								'label' => 'Tickets',
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
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => 'Aktivitäten in %s',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
				],
				[
					'type' => 'headline',
					'label' => 'Orte'
				],
				[
					'id' => 'list',
					'name' => 'list',
					'type' => 'repeater',
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
								'settings' => [
									'textarea_rows' => '6',
								]
							],
						]
					],
				],
			],
		],
		[
			'title' => 'Angebote',
			'id' => 'locals',
			'fields' => [
				[
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => 'Lokale Angebote in %s',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
				],
				[
					'type' => 'headline',
					'label' => 'Lokale Angebote'
				],
				[
					'id' => 'list',
					'name' => 'list',
					'type' => 'repeater',
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
								'settings' => [
									'textarea_rows' => '6',
								]
							],
							[
								'id' => 'address',
								'name' => 'address',
								'type' => 'text',
								'label' => 'Adresse',
							],
							[
								'id' => 'address-coords',
								'name' => 'address-coords',
								'type' => 'text',
								'readonly' => true,
								'editable' => true,
								'label' => 'Koordinaten',
								'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
								'integration' => [
									'tool' => 'gmaps',
									'service' => 'geocoding',
									'source' => 'address'
								]
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
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => 'Häufige Fragen zu %s',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
				],
				[
					'type' => 'headline',
					'label' => 'Fragen und Antworten'
				],
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
								'type' => 'editor',
								'label' => 'Antwort',
								'settings' => [
									'textarea_rows' => '6',
								]
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
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => 'Jetzt in %s buchen',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
				],
				[
					'type' => 'headline',
					'label' => 'Buchungsmöglichkeiten'
				],
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
								'label' => 'Widget (HTML)',
							],
						],
					],
				],
			],
		],
	];
}
