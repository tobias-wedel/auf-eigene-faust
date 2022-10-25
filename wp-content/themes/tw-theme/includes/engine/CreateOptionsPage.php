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
		$this->filter_post_data();
		
		$this->page_title = $page_title;
		$this->menu_title = $menu_title;
		$this->capability = $capability;
		$this->menu_slug = $menu_slug;
		$this->icon_url = $icon_url;
		$this->position = $position;
		$this->fields = $fields;
		
		add_action('admin_menu', [$this, 'add_theme_page']);
		add_action('admin_init', [$this, 'page_init']);
	}
	
	public function filter_post_data($post_data = [])
	{
		if (empty($_POST) || !is_admin() || !current_user_can('manage-options')) {
			return;
		}
		
		return apply_filters('twtheme_options_post_data', $_POST);
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
		$fields = $this->fields;
		$slug = $this->menu_slug;
		
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
		echo TwthemeFieldBuilder::output($fields, 'option', $slug);
		echo '				</div>';
		echo '			</div>';
		echo '		</div>';
		settings_fields($slug);
		do_settings_sections($slug);
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
