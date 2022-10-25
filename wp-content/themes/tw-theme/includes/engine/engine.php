<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

function twtheme_scripts($type)
{
	add_action('admin_enqueue_scripts', 'twtheme_admin_scripts');
}

function twtheme_admin_scripts($hook)
{
	wp_enqueue_style('twtheme-admin-css', TWTHEME__ENGINE_PATH . '/assets/css/twtheme-admin.css', [], TWTHEME__VERSION, 'all');
	wp_enqueue_script('twtheme-sortable', TWTHEME__ENGINE_PATH . '/assets/js/sortable.min.js', [], TWTHEME__VERSION, true);
	wp_enqueue_script('twtheme-admin', TWTHEME__ENGINE_PATH . '/assets/js/twtheme-admin.js', [], TWTHEME__VERSION, true);
	
	// Enqueue tom select script and styling
	wp_enqueue_script('tom', TWTHEME__ENGINE_PATH . '/assets/js/tom-select.complete.min.js', [], TWTHEME__VERSION, false);
	wp_enqueue_style('tom', TWTHEME__ENGINE_PATH . '/assets/css/tom-select.default.css', [], TWTHEME__VERSION, 'all');
	
	wp_enqueue_media();
	wp_enqueue_editor();

	// Localize scripts
	wp_localize_script('twtheme-admin', 'twtheme_vars', [
		'home_url' => home_url(),
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}

include_theme_files(
	[
		'helper/helper',
	//	'ThemeOptionsPage',
		'FieldBuilder',
		'CreatePostType',
		'CreateTaxonomy',
		'CreateOptionsPage',
	],
	'includes/engine/'
);

if (is_admin()) {
	//	new ThemeOptionsPage();
	new TwthemeFieldBuilder();
}
