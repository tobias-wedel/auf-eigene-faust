<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

function twtheme_scripts($type)
{
	add_action('admin_enqueue_scripts', 'twtheme_admin_scripts');
}

function twtheme_admin_scripts($hook)
{
	wp_enqueue_style('twtheme-admin-css', TWTHEME__PATH . '/assets/css/twtheme-admin.css', [], TWTHEME__VERSION, 'all');
	wp_enqueue_script('twtheme-sortable', TWTHEME__PATH . '/assets/js/sortable.js', [], TWTHEME__VERSION, true);
	wp_enqueue_script('twtheme-admin', TWTHEME__PATH . '/assets/js/twtheme-admin.js', [], TWTHEME__VERSION, true);
	
	// Enqueue tom select script and styling
	wp_enqueue_script('tom', TWTHEME__PATH . '/assets/js/tom-select.complete.js', [], TWTHEME__VERSION, false);
	wp_enqueue_style('tom', TWTHEME__PATH . '/assets/css/tom-select.default.css', [], TWTHEME__VERSION, 'all');
	
	wp_enqueue_media();
	wp_enqueue_editor();

	// Localize scripts
	wp_localize_script('twtheme-admin', 'twtheme_vars', [
		'home_url' => home_url(),
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}

twtheme_include_theme_files(
	[
		'helper/helper',
		'FieldBuilder',
		'CreatePostType',
		'CreateTaxonomy',
		'CreateOptionsPage',
		'GetData',
	],
	'includes/engine/'
);

if (is_admin()) {
	//	new ThemeOptionsPage();
	new TwthemeFieldBuilder();
}
