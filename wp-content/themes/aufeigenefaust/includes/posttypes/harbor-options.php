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
					'label' => 'Google Maps',
				],
				[
					'id' => 'harbor-icon',
					'name' => 'harbor-icon',
					'type' => 'text',
					'label' => 'Hafen',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'harbor-color',
					'name' => 'harbor-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
				[
					'id' => 'landing-stage-icon',
					'name' => 'landing-stage-icon',
					'type' => 'text',
					'label' => 'Anlegestellen',
					'description' => 'FontAwesome SVG Path',
					'column' => 'first'
				],
				[
					'id' => 'landing-stage-color',
					'name' => 'landing-stage-color',
					'type' => 'color',
					'label' => false,
					'column' => 'last'
				],
			],
		],
	];

	return $form_data;
}
