<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

add_action('init', 'register_custom_nav_menus');
function register_custom_nav_menus()
{
	register_nav_menus(
		array(
			'main-menu' => __('Hauptmenü')
		)
	);
}
