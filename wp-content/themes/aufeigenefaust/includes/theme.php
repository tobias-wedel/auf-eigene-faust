<?php
// Exit if accessed directly.
defined('ABSPATH') || exit();

// Show / Hide the admin bar
show_admin_bar(false);

add_action('after_setup_theme', 'twtheme_after_setup_theme');
function twtheme_after_setup_theme()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	//	add_image_size('custom-size', 600, 600, true);
}

/**
 * Choose your custom images sizes in the media manager
 *
 * @param $size_names
 * @return array
 */
add_filter('image_size_names_choose', 'twtheme_image_sizes_for_media');
function twtheme_image_sizes_for_media($size_names)
{
	$ntwtheme_sizes = array(
	//	'custom-size' => 'Custom Size',
	);

	return array_merge($size_names, $ntwtheme_sizes);
}

// Add specific CSS class by filter.
add_filter('body_class', 'twtheme_body_class');
function twtheme_body_class($classes)
{
	$add_ntwtheme_class = [];
	
	return array_merge($classes, $add_ntwtheme_class);
};
