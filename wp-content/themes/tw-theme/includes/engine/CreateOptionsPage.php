<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class TwthemeCreateOptionsPage
{
	private $page_title;
	private $menu_title;
	private $capability;
	private $menu_slug;
	private $icon_url;
	private $position;
	private $fields;
	
	public function __construct($page_title, $menu_title, $capability, $menu_slug, $icon_url, $position, $fields)
	{
		$this->init();
		add_action('admin_menu', [$this, 'add_theme_page']);
		add_action('admin_init', [$this, 'page_init']);
	}
	
	public function init($data)
	{
		return $data;
	}
	
	/**
	 * Add options page
	 */
	public function add_theme_page()
	{
		// This page will be under "Settings"
		add_menu_page($this->page_title, $this->menu_title, $this->capability, $this->menu_slug, [$this, 'create_option_page'], $this->icon_url, $this->position);
	}
	
	/**
	 * Options page callback
	 */
	public function create_option_page()
	{
		if (isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated'] === 'true') {
			echo '<div class="updated fade">';
			echo '	<p><strong>Einstellungen aktualisiert</strong></p>';
			echo '</div>';
		}
	
		echo '<div class="wrap">';
		echo '	<h1>' . $this->page_title . '</h1>';
		echo '	<form method="post" action="options.php">';
		echo '		<div id="poststuff">';
		echo '			<div class="postbox">';
		echo '				<div class="inside">';
		echo TwthemeFieldBuilder::output($this->$fields, 'option', $this->menu_slug);
		echo '				</div>';
		echo '			</div>';
		echo '		</div>';
		settings_fields($this->menu_slug);
		do_settings_sections($this->menu_slug);
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
			$this->menu_slug, // Option group
			$this->menu_slug // Option name
		);
	}
}
