<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

$theme_options = new TwthemeCreateMenuPage('', 'Theme Einstellungen', 'TW Theme', 'manage_options', 'twtheme', TWTHEME__PATH . '/assets/images/favicons/favicon-16x16.png', 100, theme_options_fields());

add_filter('twtheme_options_post_data', 'twtheme_options_page_post_data', 10, 1);
function twtheme_options_page_post_data($post_data)
{
	// Optimize Post Data to make it valid for the slider JS
	$_POST['twtheme']['slider']['perPage'] = $_POST['twtheme']['slider']['perPage'] * 1;
	$_POST['twtheme']['slider']['perMove'] = $_POST['twtheme']['slider']['perMove'] * 1;
	$_POST['twtheme']['slider']['breakpoints'][576]['perPage'] = $_POST['twtheme']['slider']['breakpoints'][576]['perPage'] * 1;
	$_POST['twtheme']['slider']['breakpoints'][576]['perMove'] = $_POST['twtheme']['slider']['breakpoints'][576]['perMove'] * 1;
	$_POST['twtheme']['slider']['breakpoints'][768]['perPage'] = $_POST['twtheme']['slider']['breakpoints'][768]['perPage'] * 1;
	$_POST['twtheme']['slider']['breakpoints'][768]['perMove'] = $_POST['twtheme']['slider']['breakpoints'][768]['perMove'] * 1;
	$_POST['twtheme']['slider']['breakpoints'][992]['perPage'] = $_POST['twtheme']['slider']['breakpoints'][992]['perPage'] * 1;
	$_POST['twtheme']['slider']['breakpoints'][992]['perMove'] = $_POST['twtheme']['slider']['breakpoints'][992]['perMove'] * 1;
	
	// Make boolean
	$_POST['twtheme']['slider']['arrows'] = filter_var($_POST['twtheme']['slider']['arrows'], FILTER_VALIDATE_BOOLEAN);
	$_POST['twtheme']['slider']['pagination'] = filter_var($_POST['twtheme']['slider']['pagination'], FILTER_VALIDATE_BOOLEAN);
	$_POST['twtheme']['slider']['breakpoints'][576]['arrows'] = filter_var($_POST['twtheme']['slider']['breakpoints'][576]['arrows'], FILTER_VALIDATE_BOOLEAN);
	$_POST['twtheme']['slider']['breakpoints'][576]['pagination'] = filter_var($_POST['twtheme']['slider']['breakpoints'][576]['pagination'], FILTER_VALIDATE_BOOLEAN);
	$_POST['twtheme']['slider']['breakpoints'][768]['arrows'] = filter_var($_POST['twtheme']['slider']['breakpoints'][768]['arrows'], FILTER_VALIDATE_BOOLEAN);
	$_POST['twtheme']['slider']['breakpoints'][768]['pagination'] = filter_var($_POST['twtheme']['slider']['breakpoints'][768]['pagination'], FILTER_VALIDATE_BOOLEAN);
	$_POST['twtheme']['slider']['breakpoints'][992]['arrows'] = filter_var($_POST['twtheme']['slider']['breakpoints'][992]['arrows'], FILTER_VALIDATE_BOOLEAN);
	$_POST['twtheme']['slider']['breakpoints'][992]['pagination'] = filter_var($_POST['twtheme']['slider']['breakpoints'][992]['pagination'], FILTER_VALIDATE_BOOLEAN);
}

function theme_options_fields()
{
	// prettier-ignore
	$form_data = [
		[
			'title' => 'Allgemein',
			'id' => 'general',
			'fields' => [
				[
					'id' => 'logo',
					'name' => 'logo',
					'type' => 'image',
					'label' => 'Logo'
				],
				[
					'id' => 'mark',
					'name' => 'mark',
					'type' => 'image',
					'label' => 'Bildmarke'
				],
				
			],
		],
		[
			'title' => 'Kontakt',
			'id' => 'contact',
			'fields' => [
				[
					'id' => 'phone',
					'name' => 'phone',
					'type' => 'text',
					'label' => 'Telefonnummer',
					'description' => 'Shortcode: [phone]'
				],
				[
					'id' => 'email',
					'name' => 'email',
					'type' => 'text',
					'label' => 'E-Mail',
					'description' => 'Shortcode: [email]'
				],
			],
		],
		[
			'title' => 'Social Media',
			'id' => 'social',
			'fields' => [
					[
						'id' => 'channel-repeater',
						'name' => 'channel-repeater',
						'type' => 'repeater',
						'fields' => [
							[
								[
									'id' => 'channel-name',
									'name' => 'channel-name',
									'type' => 'text',
									'label' => 'Kanal'
								],
								[
									'id' => 'channel-url',
									'name' => 'channel-url',
									'type' => 'text',
									'label' => 'URL'
								],
								[
									'id' => 'channel-icon',
									'name' => 'channel-icon',
									'type' => 'text',
									'label' => 'Icon',
									'description' => '(Font Awesome Brand ID)'
								],
						]
					]
				]
			],
		],
		//[
		//	'title' => 'Slider',
		//	'id' => 'slider',
		//	'fields' => slider_config_fields(),
		//],
		[
			'title' => 'Affiliate Links',
			'id' => 'affiliate',
			'fields' => [
				[
					'id' => 'list',
					'name' => 'list',
					'type' => 'repeater',
					'fields' => [
						[
							[
								'id' => 'domain',
								'name' => 'domain',
								'type' => 'text',
								'label' => 'Domain',
								'description' => 'Beispiel: www.check24.de'
							],
						]
					]
				],
				[
					'id' => 'hint',
					'name' => 'hint',
					'type' => 'text',
					'label' => 'Hinweis (HTML)',
					'data-filter' => 'htmlentities',
				],
				[
					'id' => 'hint-disclaimer',
					'name' => 'hint-disclaimer',
					'type' => 'textarea',
					'label' => 'Hinweis Disclaimer',
					'data-filter' => 'htmlentities',
				],
			],
		],
		[
			'title' => 'Integration',
			'id' => 'integration',
			'fields' => [
				[
					'type' => 'headline',
					'label' => 'Google Maps',
				],
				[
					'id' => 'gmaps-api-key',
					'name' => 'gmaps-api-key',
					'type' => 'text',
					'label' => 'API-Schlüssel',
				],
				[
					'id' => 'gmaps-id',
					'name' => 'gmaps-id',
					'type' => 'text',
					'label' => 'Map ID',
				],
				[
					'id' => 'gmaps-image-placeholder',
					'name' => 'gmaps-image-placeholder',
					'type' => 'image',
					'label' => 'Platzhalter Bild',
				],
			],
		],
	];

	return $form_data;
}
