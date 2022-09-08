<?php
// Exit if accessed directly.
defined('ABSPATH') || exit();

$livecanvas_files = [
	'_support',
	'_livecanvas_custom_view',
];
 
foreach ($livecanvas_files as $file) {
	require_once TWTHEME__DIR . '/includes/livecanvas/' . $file . '.php';
}

add_action('wp_enqueue_scripts', 'twtheme_wp_enqueue_scripts_livecanvas');
function twtheme_wp_enqueue_scripts_livecanvas($post)
{
	// Check if we are in the livecanvas live editor
	if (isset($_REQUEST['lc_page_editing_mode']) && true == $_REQUEST['lc_page_editing_mode']) {
		// Enqueue script that only fired in the livecanvas editor
		wp_enqueue_script('livecanvas-js', TWTHEME__PATH . '/includes/livecanvas/js/livecanvas.js', '', TWTHEME__VERSION, true);
	}
}
