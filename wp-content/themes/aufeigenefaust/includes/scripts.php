<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

// Enqueue scripts
add_action('wp_enqueue_scripts', 'twtheme_wp_enqueue_scripts', 20);
function twtheme_wp_enqueue_scripts()
{
	// Remove WP Scripts from frontend
	if (!current_user_can('edit_posts')) {
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action('admin_print_styles', 'print_emoji_styles');
		remove_filter('the_content_feed', 'wp_staticize_emoji');
		remove_filter('comment_text_rss', 'wp_staticize_emoji');
		remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
		wp_deregister_style('dashicons'); // Dashicons
		wp_deregister_style('wp-block-library'); // Gutenberg Styles
		wp_deregister_script('jquery'); // Remove jQuery
	}
	
	// ZEN SCROLL
	// Disable zenscroll. We'll init it manually
	wp_register_script('zenscroll-disable', '');
	wp_enqueue_script('zenscroll-disable');
	wp_add_inline_script('zenscroll-disable', "window.noZensmooth = true");
	wp_enqueue_script('zenscroll', TWTHEME__PATH . '/assets/js/zenscroll.js', '', TWTHEME__VERSION);
	
	// FONT AWESOME
	wp_enqueue_script('fontawesome', TWTHEME__PATH.'/assets/fontawesome/js/fontawesome.min.js', '', TWTHEME__VERSION, true);
	//wp_enqueue_script('fontawesome-thin', TWTHEME__PATH . '/node_modules/@fontawesome/fontawesome-pro/js/thin.min.js', '', TWTHEME__VERSION, true);
	wp_enqueue_script('fontawesome-light', TWTHEME__PATH . '/assets/fontawesome/js/light.min.js', '', TWTHEME__VERSION, true);
	wp_enqueue_script('fontawesome-brands', TWTHEME__PATH . '/assets/fontawesome/js/brands.min.js', '', TWTHEME__VERSION, true);
	// wp_enqueue_script('fontawesome-regular', TWTHEME__PATH . '/node_modules/@fontawesome/fontawesome-pro/js/regular.min.js', '', TWTHEME__VERSION, true);
	// wp_enqueue_script('fontawesome-solid', TWTHEME__PATH . '/node_modules/@fontawesome/fontawesome-pro/js/solid.min.js', '', TWTHEME__VERSION, true);
	
	// BOOTSTRAP
	wp_enqueue_script('bootstrap', TWTHEME__PATH . '/assets/js/bootstrap.js', '', TWTHEME__VERSION);
	
	// THEME
	wp_enqueue_style('twtheme', get_stylesheet_uri(), '', TWTHEME__VERSION, 'all');
	wp_enqueue_script('twtheme', TWTHEME__PATH . '/assets/js/twtheme.js', '', TWTHEME__VERSION);
	
	// Localize scripts
	wp_localize_script('twtheme', 'twtheme', [
		'basedomain' => home_url(),
		'livedomain' => TWTHEME__DOMAIN,
		'ajaxurl' => admin_url('admin-ajax.php'),
		'themepath' => TWTHEME__PATH,
	]);
}
