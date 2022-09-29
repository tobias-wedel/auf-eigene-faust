<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

add_action('admin_enqueue_scripts', 'admin_scripts');
function admin_scripts($hook)
{
	// Check allowed hooks and post_type
	if ('toplevel_page_twtheme' != $hook && get_current_post_type() != 'harbor') {
		return;
	}

	wp_enqueue_style('twtheme-admin-css', TWTHEME__PATH . '/includes/admin/assets/css/twtheme-admin.css', [], TWTHEME__VERSION, 'all');
	wp_enqueue_script('twtheme-sortable', TWTHEME__PATH . '/includes/admin/assets/js/sortable.min.js', [], TWTHEME__VERSION, true);
	wp_enqueue_script('twtheme-admin', TWTHEME__PATH . '/includes/admin/assets/js/twtheme-admin.js', [], TWTHEME__VERSION, true);
	
	// Enqueue tom select script and styling
	wp_enqueue_script('tom', TWTHEME__ADMIN_PATH . '/assets/js/tom-select.complete.min.js', [], TWTHEME__VERSION, false);
	wp_enqueue_style('tom', TWTHEME__ADMIN_PATH . '/assets/css/tom-select.default.css', [], TWTHEME__VERSION, 'all');
	
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
		'ThemeOptionsPage',
		'ThemeFieldBuilder',
		'CreatePostType',
	],
	'includes/admin/'
);

if (is_admin()) {
	new ThemeOptionsPage();
	new ThemeFieldBuilder();
}
