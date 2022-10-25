<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class ThemeOptionsPage
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct()
	{
		$this->init();
		add_action('admin_menu', [$this, 'add_theme_page']);
		add_action('admin_init', [$this, 'page_init']);
	}

	/**
	 * Add options page
	 */
	public function add_theme_page()
	{
		// This page will be under "Settings"
		add_menu_page('Theme Einstellungen', 'TW Theme', 'manage_options', 'twtheme', [$this, 'create_admin_page'], TWTHEME__PATH . '/assets/images/favicons/favicon-16x16.png');
	}

	public function init()
	{
		// Optimize Post Data to make it valid for the slider JS
		if (!empty($_POST) && is_admin() && isset($_GET['page']) && $_GET['page'] == 'twtheme-options') {
			// Make int
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
	}

	public function form_tabs()
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
				],
			],
		];

		return $form_data;
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		if (isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated'] === 'true') {
			echo '<div class="updated fade">';
			echo '	<p><strong>Einstellungen aktualisiert</strong></p>';
			echo '</div>';
		}

		echo '<div class="wrap">';
		echo '	<h1>TW Theme Einstellungen</h1>';
		echo '	<form method="post" action="options.php">';
		echo '		<div id="poststuff">';
		echo '			<div class="postbox">';
		echo '				<div class="inside">';
		echo TwthemeFieldBuilder::output($this->form_tabs(), 'option', 'twtheme');
		echo '				</div>';
		echo '			</div>';
		echo '		</div>';
		settings_fields('twtheme');
		do_settings_sections('twtheme');
		submit_button();
		echo '	</form>';
		echo '</div>';
	}

	/**
	 * Register and add settings
	 */
	public function page_init()
	{
		register_setting(
			'twtheme', // Option group
			'twtheme' // Option name
		);
	}
}
