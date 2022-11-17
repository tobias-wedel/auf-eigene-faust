<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;


// Set Yoast SEO Box to low prio
add_filter('wpseo_metabox_prio', 'wpm_seo_metabox_priority');
function wpm_seo_metabox_priority()
{
	//* Accepts 'high', 'default', 'low'. Default is 'high'.
	return 'low';
}
