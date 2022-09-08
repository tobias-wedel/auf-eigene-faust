<?php
// Exit if accessed directly.
defined('ABSPATH') || exit();

/**
* Shortcode button
* Place a button element
*
* Example: [btn text="Button Text" url="/url/" target="_blank"]
*
* @param string $text Button test
* @param string $url URL
* @param string $target Target action
* @param string $class Custom CSS classes
* @param string $icon Font Awesome Icon without the -fa prefix
* @return string
*/

add_shortcode('button', 'twtheme_buttom_shortcode');
function twtheme_buttom_shortcode($atts = [])
{
	$a = shortcode_atts(
		[
			'text' => '',
			'url' => '',
			'target' => '',
			'class' => '',
			'icon' => 'arrow-right',
		],
		$atts
	);

	// target definition
	$target = '';
	$target_action = $a['target'];
	if (!empty($target)) {
		$target = 'target="' . $target_action . '"';

		// if target == _blank set the rel tag
		if ($target == '_blank') {
			$target = $target . ' rel="noopener noreferrer"';
		}
	}

	return ' <a class="btn ' . $a['class'] . '" href="' . $a['url'] . '" ' . $target . '><i class="far fa-' . $a['icon'] . '"></i><span class="text">' . $a['text'] . '</span></a>';
}
