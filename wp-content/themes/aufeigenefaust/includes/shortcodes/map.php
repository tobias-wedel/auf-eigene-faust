<?php
// Exit if accessed directly.
defined('ABSPATH') || exit();

add_shortcode('map', 'twtheme_map_shortcode');
function twtheme_map_shortcode($atts = [])
{
	$a = shortcode_atts(
		[
			'icon' => '',
			'id' => '',
			'class' => '',
			'style' => 'fal',
		],
		$atts
	);
	

	return '<div id="' . $id . '"></div>';
}

function twtheme_map($map_data, $args = [])
{
	if (empty(TWTHEME__OPTIONS['integration']['gmaps-api-key']) || !is_array($map_data)) {
		return false;
	}
	
	wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . TWTHEME__OPTIONS['integration']['gmaps-api-key'] . '&v=beta&libraries=marker', '', '', true);
	wp_enqueue_script('google-maps-icons', TWTHEME__PATH . '/assets/js/gmaps-icons.js', '', TWTHEME__VERSION, true);

	$id = !empty($args['id']) ? $args['id'] : 'map-' . get_custom_id();
	
	return "<div id='" . $id . "' class='twtheme-map' data-map='" . json_encode($map_data) . "' onclick='init_gmap(this)' style='background: red'></div>";
}
