<?php
// Exit if accessed directly.
defined('ABSPATH') || exit();

// Required files
$shortcode_files = [
	'_icon',
	'_button'
];
 
foreach ($shortcode_files as $file) {
	require_once TWTHEME__DIR . '/includes/shortcodes/' . $file . '.php';
}
