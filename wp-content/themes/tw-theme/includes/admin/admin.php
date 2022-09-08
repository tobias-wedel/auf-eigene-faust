<?php

add_action('admin_enqueue_scripts', 'admin_scripts');
function admin_scripts($hook)
{
	// Check allowed hooks and post_type
	if ('toplevel_page_twtheme' != $hook && get_current_post_type() != 'harbor') {
		return;
	}

	wp_enqueue_style('twtheme-admin-css', TWTHEME__PATH . '/includes/admin/assets/css/twtheme-admin.css', [], TWTHEME__VERSION, 'all');

	wp_enqueue_media();
	wp_enqueue_script('twtheme-sortable', TWTHEME__PATH . '/includes/admin/assets/js/sortable.min.js', [], TWTHEME__VERSION, true);
	wp_enqueue_script('twtheme-admin', TWTHEME__PATH . '/includes/admin/assets/js/twtheme-admin.js', [], TWTHEME__VERSION, true);

	// Localize scripts
	wp_localize_script('twtheme-admin', 'easyform_vars', [
		'home_url' => home_url(),
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}

// Add defer to google maps script
add_filter('script_loader_tag', 'twtheme_add_defer_attribute_to_script_tag', 10, 2);
function twtheme_add_defer_attribute_to_script_tag($tag, $handle)
{
	if ('twtheme-gmaps' !== $handle) {
		return $tag;
	}
	return str_replace(' src', ' defer src', $tag);
}

include_theme_files(
	[
		'helper',
		'ThemeOptionsPage',
		'ThemeFieldBuilder',
	],
	'includes/admin/'
);

new ThemeOptionsPage();

if (is_admin()) {
	new ThemeFieldBuilder();
}
