<?php

// Exit if accessed directly
if (! defined('ABSPATH')) {
	exit;
}

add_shortcode('splide', 'twtheme_splide_shortcode');
function twtheme_splide_shortcode($atts)
{
	$attributes = shortcode_atts(array(
		'id' => '',
		'title' => '',
		'class' => '',
		'images' => '',
		'thumbnails' => '',
		'caption' => 'false',
		'wrap' => '<figure class="ratio ratio-16x11">%s</figure>',
		'style' => 'fit',
	), $atts);
		
	$slider_id = 'slider-' . sanitize_title($attributes['id']);
		
	$html = '';
	$html .= '<section id="' . $slider_id . '" class="slider splide '. $attributes['class'] . '" aria-label="' . $attributes['title'] . '">';
	$html .= '<div class="splide__track">';
	$html .= '<ul class="splide__list">';
	$html .= twtheme_splide_slide($attributes['images'], $attributes);
	$html .= '</ul>';
	$html .= '</div>';
	
	if ($attributes['thumbnails']) {
	}
	
	$html .= '</section>';
	
	$splide_javascript = '
		new Splide("#' . $slider_id .'").mount();
	';
	
	wp_enqueue_style('splide', TWTHEME__PATH . '/assets/css/splide.css', '', TWTHEME__VERSION);
	wp_enqueue_script('splide', TWTHEME__PATH . '/assets/js/splide.js', '', TWTHEME__VERSION);
	wp_add_inline_script('splide', $splide_javascript, 'after');

	return $html;
}

function twtheme_splide_slide($images, $attributes)
{
	$image_class = '';
	
	switch (trim($attributes['style'])) {
		case 'fit':
			$image_class = 'object-fit-cover object-position-center';
			break;
	}
	
	$html = '';
	
	foreach (array_map('trim', explode(',', $images)) as $image_id) {
		$image = wp_get_attachment_image($image_id, 'large', false, ['class' => $image_class]);
		$html .= '<div class="splide__slide">';
		$caption = '';
		
		if ($attributes['caption'] === 'true') {
			$caption = wp_get_attachment_caption($image_id);
			if ($caption) {
				$caption = '<figcaption>' . $caption . '</figcaption>';
			}
		}
		
		$image = $image . $caption;
		
		if ($attributes['wrap']) {
			$html .= sprintf($attributes['wrap'], $image);
		} else {
			$html .= $image;
		}
		
		$html .= '</div>';
	}
	
	return $html;
}
