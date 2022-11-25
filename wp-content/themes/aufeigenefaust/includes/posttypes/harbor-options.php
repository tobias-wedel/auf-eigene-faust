<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

new TwthemeCreateMenuPage('edit.php?post_type=harbor', 'Hafen Einstellungen', 'Optionen', 'manage_options', 'twtheme_harbor_options', TWTHEME__PATH . '/assets/images/favicons/favicon-16x16.png', 100, harbor_option_fields());

function harbor_option_fields()
{
	// prettier-ignore
	$form_data = [
		[
			'title' => 'Icons',
			'id' => 'icons',
			'fields' => [
				[
					'type' => 'headline',
					'label' => 'Hafen',
				],
				[
					'id' => 'landing-stage-icon',
					'name' => 'landing-stage-icon',
					'type' => 'text',
					'label' => 'Anlegestellen',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'landing-stage-color',
					'name' => 'landing-stage-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'shuttle-icon',
					'name' => 'shuttle-icon',
					'type' => 'text',
					'label' => 'Hafenshuttle',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'shuttle-color',
					'name' => 'shuttle-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'arrival-airport-icon',
					'name' => 'arrival-airport-icon',
					'type' => 'text',
					'label' => 'Flughafen',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'arrival-airport-color',
					'name' => 'arrival-airport-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'type' => 'headline',
					'label' => 'Mobilität',
				],
				[
					'id' => 'foot-icon',
					'name' => 'foot-icon',
					'type' => 'text',
					'label' => 'Zu Fuß',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'foot-color',
					'name' => 'foot-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'bicycle-icon',
					'name' => 'bicycle-icon',
					'type' => 'text',
					'label' => 'Fahrrad',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'bicycle-color',
					'name' => 'bicycle-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'e-scooter-icon',
					'name' => 'e-scooter-icon',
					'type' => 'text',
					'label' => 'E-Scooter',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'e-scooter-color',
					'name' => 'e-scooter-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'taxi-icon',
					'name' => 'taxi-icon',
					'type' => 'text',
					'label' => 'Taxi',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'taxi-color',
					'name' => 'taxi-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'rental-car-icon',
					'name' => 'rental-car-icon',
					'type' => 'text',
					'label' => 'Mietwagen',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'rental-car-color',
					'name' => 'rental-car-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'bus-icon',
					'name' => 'bus-icon',
					'type' => 'text',
					'label' => 'Bus',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'bus-color',
					'name' => 'bus-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'hop-on-bus-icon',
					'name' => 'hop-on-bus-icon',
					'type' => 'text',
					'label' => 'Hop-On-Hop-Off Bus',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'hop-on-bus-color',
					'name' => 'hop-on-bus-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'light-railroad-icon',
					'name' => 'light-railroad-icon',
					'type' => 'text',
					'label' => 'Bimmelbahn',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'light-railroad-color',
					'name' => 'light-railroad-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'tuk-tuk-icon',
					'name' => 'tuk-tuk-icon',
					'type' => 'text',
					'label' => 'Tuk Tuk (Autorikscha)',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'tuk-tuk-color',
					'name' => 'tuk-tuk-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'metro-icon',
					'name' => 'metro-icon',
					'type' => 'text',
					'label' => 'Metro / U-Bahn',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'metro-color',
					'name' => 'metro-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'train-icon',
					'name' => 'train-icon',
					'type' => 'text',
					'label' => 'Zug',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'train-color',
					'name' => 'train-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
			],
		],
	];

	return $form_data;
}
