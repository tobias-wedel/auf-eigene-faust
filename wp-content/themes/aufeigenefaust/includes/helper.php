<?php
// Exit if accessed directly.
defined('ABSPATH') || exit();

/**
 * Short function for print_r with <pre>
 *
 * @param array $array
 */
if (!function_exists('print_rpre')) {
	function print_rpre($array)
	{
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
}

/**
 * This checks the current post type in several ways
 *
 * @return string  Current post type
 */
if (!function_exists('get_current_post_type')) {
	function get_current_post_type()
	{
		global $post, $typenow, $current_screen;
		 
		if ($post && $post->post_type) {
			return $post->post_type;
		} elseif ($typenow) {
			return $typenow;
		} elseif ($current_screen && $current_screen->post_type) {
			return $current_screen->post_type;
		} elseif (isset($_REQUEST['post_type'])) {
			return sanitize_key($_REQUEST['post_type']);
		}
		 
		return null;
	}
}

/**
 * Set the yoast box at the end
 */
add_filter('wpseo_metabox_prio', 'twtheme_wpseo_metabox_prio');
function twtheme_wpseo_metabox_prio()
{
	//* Accepts 'high', 'default', 'low'. Default is 'high'.
	return 'low';
}

/**
 * Removes empty <p>
 *
 * @param $content
 * @return array|string|string[]|null
 */
add_filter('the_content', 'remove_empty_p', 20, 1);
function remove_empty_p($content)
{
	$content = force_balance_tags($content);
	$content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
	$content = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content);

	return $content;
}

function get_country_list()
{
	$options = [];
		
	foreach (data_countries() as $key => $country) {
		$options[] = [
				'value' => $key,
				'label' => $country,
			];
	}
		
	return $options;
}

function get_currency_list()
{
	$options = [];
		
	foreach (data_currencies() as $key => $currency) {
		$options[] = [
				'value' => $key,
				'label' => $currency,
			];
	}
		
	return $options;
}


function get_language_list()
{
	$options = [];
		
	foreach (data_languages() as $key => $language) {
		$options[] = [
				'value' => $key,
				'label' => $language,
			];
	}
		
	return $options;
}
