<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;


function affiliate_content($post_data)
{
	$post_meta = get_post_meta($post_data['post_ID']);
	print_rpre(maybe_unserialize($post_meta['affiliates'][0]));
}
