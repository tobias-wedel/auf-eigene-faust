<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

$harbor_destination = new TwthemeCreateTaxonomy('destination', 'harbor', harbor_destionation_args(), harbor_destination_fields());

function harbor_destionation_args()
{
	return [
		'hierarchical' => true,
		'labels' => [
			'name' => 'Destination',
			'singular_name' => 'Destination',
			'search_items' =>  'Suche Destination',
			'all_items' => 'Alle Destinationen',
			'parent_item' => 'Übergeordnete Destination',
			'edit_item' => 'Destination bearbeiten',
			'update_item' => 'Destination aktualisieren',
			'add_new_item' => 'Neue Destination erstellen',
			'new_item_name' => 'Neuer Titel',
			'menu_name' => 'Destinationen',
		],
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'destination' ),
	];
}

function harbor_destination_fields()
{
	return [
		[
			'title' => '',
			'id' => 'destination',
			'fields' => [
				[
					'id' => 'featured-image',
					'name' => 'featured-image',
					'type' => 'image',
					'label' => 'Bild',
				],
				[
					'id' => 'description',
					'name' => 'description',
					'type' => 'editor',
					'label' => 'SEO Text',
					'settings' => [
						'textarea_rows' => '6',
					]
				],
			]
		]
	];
}
