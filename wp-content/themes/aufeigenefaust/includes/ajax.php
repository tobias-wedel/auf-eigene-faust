<?php
// Exit if accessed directly.
defined('ABSPATH') || exit();

add_action('wp_ajax_dynamic_content', 'dynamic_content');
add_action('wp_ajax_nopriv_dynamic_content', 'dynamic_content');
function dynamic_content()
{
	if (!isset($_POST['dynamic_fn'])) {
		return;
	}

	call_user_func($_POST['dynamic_fn'], $_POST);

	wp_die();
}
