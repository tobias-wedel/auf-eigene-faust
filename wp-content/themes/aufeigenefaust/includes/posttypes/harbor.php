<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

$harbor_posttype = new TwthemeCreatePostType('harbor', 'Hafen Details', harbor_register_post_type_args(), twtheme_harbor_fields());

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
					'label' => 'Einleitungstext',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'country',
					'name' => 'country',
					'type' => 'select',
					'group' => 'harbor-quick-infos',
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
					'group' => 'harbor-quick-infos',
					'multiple' => true,
					'label' => 'Sprache(n)',
					'options_from_data' => get_language_list()
				],
				[
					'id' => 'currency',
					'name' => 'currency',
					'type' => 'select',
					'group' => 'harbor-quick-infos',
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
					'group' => 'harbor-quick-infos',
					'label' => 'Beste Reisezeit'
				],
				[
					'id' => 'visa',
					'name' => 'visa',
					'type' => 'text',
					'group' => 'harbor-quick-infos',
					'label' => 'Reisepass / Visum'
				],
			],
		],
		[
			'title' => 'Der Hafen',
			'id' => 'about',
			'hide-title' => true,
			'fields' => [
				[
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => 'Der Kreuzfahrthafen %s',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
				],
				[
					'type' => 'headline',
					'label' => 'Der Hafen',
				],
				[
					'id' => 'gallery',
					'name' => 'gallery',
					'type' => 'gallery',
					'label' => 'Galerie',
				],
				//[
				//	'id' => 'address',
				//	'name' => 'address',
				//	'group' => 'gmaps',
				//	'type' => 'text',
				//	'label' => 'Adresse'
				//],
				//[
				//	'id' => 'address-coords',
				//	'name' => 'address-coords',
				//	'group' => 'gmaps',
				//	'type' => 'text',
				//	'readonly' => true,
				//	'editable' => true,
				//	'label' => 'Koordinaten',
				//	'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
				//	'integration' => [
				//		'tool' => 'gmaps',
				//		'service' => 'geocoding',
				//		'source' => 'address'
				//	]
				//],
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
								'id' => 'name',
								'name' => 'name',
								'type' => 'text',
								'label' => 'Name'
							],
							[
								'id' => 'address',
								'name' => 'address',
								'type' => 'textarea',
								'label' => 'Adresse'
							],
							[
								'id' => 'address-coords',
								'name' => 'address-coords',
					'group' => 'gmaps',
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
					'group' => 'harbor-arrivals',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'shuttle',
					'name' => 'shuttle',
					'type' => 'editor',
					'label' => 'Hafenshuttle',
					'group' => 'harbor-arrivals',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'id' => 'arrival-airport',
					'name' => 'arrival-airport',
					'type' => 'editor',
					'label' => 'Anfahrt Flughafen',
					'group' => 'harbor-arrivals',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
			],
		],
		[
			'title' => 'Mobilität',
			'id' => 'mobility',
			'hide-title' => true,
			'fields' => [
				[
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => 'Unterwegs in %s auf eigene Faust',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
				],
				[
					'id' => 'intro',
					'name' => 'intro',
					'type' => 'editor',
					'label' => 'Introtext',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
				[
					'type' => 'headline',
					'label' => 'Zu Fuß'
				],
				[
					'id' => 'foot',
					'name' => 'foot',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'foot-address',
					'name' => 'foot-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'foot-address-coords',
					'name' => 'foot-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'foot-address'
					]
				],
				[
					'id' => 'foot-image',
					'name' => 'foot-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
				[
					'type' => 'headline',
					'label' => 'Fahrrad'
				],
				[
					'id' => 'bicycle',
					'name' => 'bicycle',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'bicycle-address',
					'name' => 'bicycle-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'bicycle-address-coords',
					'name' => 'bicycle-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'bicycle-address'
					]
				],
				[
					'id' => 'bicycle-image',
					'name' => 'bicycle-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
				[
					'type' => 'headline',
					'label' => 'E-Scooter'
				],
				[
					'id' => 'e-scooter',
					'name' => 'e-scooter',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'e-scooter-address',
					'name' => 'e-scooter-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'e-scooter-address-coords',
					'name' => 'e-scooter-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'e-scooter-address'
					]
				],
				[
					'id' => 'e-scooter-image',
					'name' => 'e-scooter-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
				[
					'type' => 'headline',
					'label' => 'Taxi'
				],
				[
					'id' => 'taxi',
					'name' => 'taxi',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'taxi-address',
					'name' => 'taxi-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'taxi-address-coords',
					'name' => 'taxi-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'taxi-address'
					]
				],
				[
					'id' => 'taxi-image',
					'name' => 'taxi-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
				[
					'type' => 'headline',
					'label' => 'Mietwagen'
				],
				[
					'id' => 'rental-car',
					'name' => 'rental-car',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'rental-car-address',
					'name' => 'rental-car-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'rental-car-address-coords',
					'name' => 'rental-car-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'rental-car-address'
					]
				],
				[
					'id' => 'rental-car-image',
					'name' => 'rental-car-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
				[
					'type' => 'headline',
					'label' => 'Bus'
				],
				[
					'id' => 'bus',
					'name' => 'bus',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'bus-address',
					'name' => 'bus-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'bus-address-coords',
					'name' => 'bus-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'bus-address'
					]
				],
				[
					'id' => 'bus-image',
					'name' => 'bus-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
				[
					'type' => 'headline',
					'label' => 'Hop-On-Hop-Off Bus'
				],
				[
					'id' => 'hop-on-bus',
					'name' => 'hop-on-bus',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'hop-on-bus-address',
					'name' => 'hop-on-bus-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'hop-on-bus-address-coords',
					'name' => 'hop-on-bus-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'hop-on-bus-address'
					]
				],
				[
					'id' => 'hop-on-bus-image',
					'name' => 'hop-on-bus-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
				[
					'type' => 'headline',
					'label' => 'Bimmelbahn'
				],
				[
					'id' => 'light-railroad',
					'name' => 'light-railroad',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'light-railroad-address',
					'name' => 'light-railroad-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'light-railroad-address-coords',
					'name' => 'light-railroad-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'light-railroad-address'
					]
				],
				[
					'id' => 'light-railroad-image',
					'name' => 'light-railroad-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
				[
					'type' => 'headline',
					'label' => 'Tuk Tuk (Autorikscha)'
				],
				[
					'id' => 'tuk-tuk',
					'name' => 'tuk-tuk',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'tuk-tuk-address',
					'name' => 'tuk-tuk-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'tuk-tuk-address-coords',
					'name' => 'tuk-tuk-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'tuk-tuk-address'
					]
				],
				[
					'id' => 'tuk-tuk-image',
					'name' => 'tuk-tuk-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
				[
					'type' => 'headline',
					'label' => 'Metro / U-Bahn'
				],
				[
					'id' => 'metro',
					'name' => 'metro',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'metro-address',
					'name' => 'metro-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'metro-address-coords',
					'name' => 'metro-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'metro-address'
					]
				],
				[
					'id' => 'metro-image',
					'name' => 'metro-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
				[
					'type' => 'headline',
					'label' => 'Zug'
				],
				[
					'id' => 'train',
					'name' => 'train',
					'type' => 'editor',
					'label' => 'Text',
					'group' => 'mobility',
					'settings' => [
						'textarea_rows' => '6',
					],
				],
				[
					'id' => 'train-address',
					'name' => 'train-address',
					'type' => 'textarea',
					'label' => 'Adresse'
				],
				[
					'id' => 'train-address-coords',
					'name' => 'train-address-coords',
					'group' => 'gmaps',
					'type' => 'text',
					'readonly' => true,
					'editable' => true,
					'label' => 'Koordinaten',
					'description' => 'Die Koordinaten werden automatisch, nach ändern der Adresse, generiert.',
					'integration' => [
						'tool' => 'gmaps',
						'service' => 'geocoding',
						'source' => 'train-address'
					]
				],
				[
					'id' => 'train-image',
					'name' => 'train-image',
					'type' => 'image',
					'label' => 'Bild',
					'group' => 'mobility',
				],
			],
		],
		[
			'title' => 'Highlights',
			'id' => 'highlights',
			'hide-title' => true,
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
					'type' => 'headline',
					'label' => 'Highlights'
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
								'type' => 'textarea',
								'label' => 'Adresse'
							],
							[
								'id' => 'address-coords',
								'name' => 'address-coords',
					'group' => 'gmaps',
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
			'hide-title' => true,
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
					'label' => 'Aktiviäten'
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
			'title' => 'Anbieter',
			'id' => 'locals',
			'hide-title' => true,
			'fields' => [
				[
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => 'Lokale Anbieter in %s',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
				],
				[
					'type' => 'headline',
					'label' => 'Lokale Anbieter'
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
								'type' => 'textarea',
								'label' => 'Adresse',
							],
							[
								'id' => 'address-coords',
								'name' => 'address-coords',
					'group' => 'gmaps',
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
			'hide-title' => true,
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
			'hide-title' => true,
			'fields' => [
				[
					'id' => 'headline',
					'name' => 'headline',
					'type' => 'text',
					'label' => 'Headline',
					'placeholder' => 'Landausflüge in %s buchen',
					'description' => 'Verwende %s als Titel (Hafenname) Platzhalter.'
				],
				[
					'id' => 'intro',
					'name' => 'intro',
					'type' => 'editor',
					'label' => 'Beschreibung',
					'settings' => [
						'textarea_rows' => '6',
					]
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
