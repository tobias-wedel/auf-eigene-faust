<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

// Required files
$shortcode_files = [
	'_support',
];
 
foreach ($shortcode_files as $file) {
	require_once TWTHEME__DIR . '/includes/woocommerce/' . $file . '.php';
}

// Disable default WooCommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Enqueue scripts
add_action('wp_enqueue_scripts', 'twtheme_wp_enqueue_scripts_woocommerce', 20);
function twtheme_wp_enqueue_scripts_woocommerce()
{
	if (class_exists('woocommerce') && is_woocommerce()) {
		wp_enqueue_style('woocommerce');
		wp_enqueue_script('woocommerce', TWTHEME__PATH . '/assets/js/woocommerce.js', '', TWTHEME__VERSION, true);
	}
}
