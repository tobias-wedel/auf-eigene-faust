<?php
// Exit if accessed directly.
defined('ABSPATH') || exit();

/**
* Shortcode i
* Place a fontawesome icon
*
* Example: [i icon="times" style="far"]
*
* @param string $icon Icon ID without the fa- prefix
* @param string $style Icons style class like far, fas,...
* @param string $class Custom CSS Class
*
* @return string
*/

add_shortcode('i', 'twtheme_icon_shortcode');
function twtheme_icon_shortcode($atts = [])
{
	$a = shortcode_atts(
		[
			'icon' => '',
			'class' => '',
			'style' => 'fal',
		],
		$atts
	);

	$icon = $a['icon'];

	if (!empty(trim($icon))) {
		return '<i class="' . $a['style'] . ' fa-' . $icon . ' ' . $a['class'] . '"></i>';
	}
}
