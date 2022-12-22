<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

function affiliate_content($post_data)
{
	$post_meta = get_post_meta($post_data['post_ID']);
	$affiliates = maybe_unserialize($post_meta['affiliates'][0]);
	
	$dynamic_key = $post_data['dynamic_key'];
	
	$key = array_search($dynamic_key, array_column($affiliates['affiliates'], 'title'));
	
	// Find script tag and separate it for executing
	$html = $affiliates['affiliates'][$key]['widget'];
	
	preg_match('/<script.*<\/script>/', $html, $script);
	
	// Remove script from HTML
	$html = str_replace($script, '', $html);
	
	$output = [
		'html' => $html,
		'script' => $script,
	];
	
	echo json_encode($output);
}
