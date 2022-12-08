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
	$wrapper_type = isset($args['wrapper']) ? $args['wrapper'] : 'div';
	$wrapper = '%s';
	
	if (empty(TWTHEME__OPTIONS['integration']['gmaps-api-key']) || !is_array($map_data)) {
		return false;
	}
	
	wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . TWTHEME__OPTIONS['integration']['gmaps-api-key'] . '&v=beta&libraries=marker', '', '', true);
	wp_enqueue_script('map', TWTHEME__PATH . '/assets/js/map.js', '', TWTHEME__VERSION, true);

	$id = !empty($args['id']) ? $args['id'] : 'map-' . get_custom_id();
	
	if ($wrapper_type !== false) {
		$wrapper = '<' . $wrapper_type . ' ' . (isset($args['wrapper-class']) ? ' class="' . $args['wrapper-class'] . '"' : '') . '>%s</' . $wrapper_type . '>';
	}
	
	return sprintf($wrapper, "<div id='" . $id . "' class='twtheme-map' data-map='" . json_encode($map_data) . "' data-args='" . json_encode($args) . "' onclick='init_gmap(this)' style='background-image: url(\"" . wp_get_attachment_url(TWTHEME__OPTIONS['integration']['gmaps-image-placeholder']) .  "\")'><div><i class='fal fa-map-location-dot'></i><strong>Karte laden</strong></div></div>");
}
