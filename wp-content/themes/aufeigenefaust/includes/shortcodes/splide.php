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
		'image_size' => 'large',
		'thumbnails' => '',
		'caption' => 'false',
		'wrap' => '<figure class="ratio ratio-16x11">%s</figure>',
		'style' => 'fit',
	), $atts);
		
	$slider_id = 'slider_' . sanitize_title($attributes['id']);
		
	$html = '';
	$html .= '<section class="' . $slider_id . '-slider-wrapper slider-wrapper" class="' . $attributes['class'] . '" aria-label="' . $attributes['title'] . '">';
	$html .= '<div id="' . $slider_id . '" class="slider splide">';
	$html .= '<div class="splide__track">';
	$html .= '<div class="splide__list">';
	$html .= twtheme_splide_slide($attributes['images'], $attributes);
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	
	$splide_javascript = '
		var ' . $slider_id . '_slider = new Splide("#' . $slider_id .'", {
			pagination: false,
			lazyLoad: "nearby",
			//arrowPath: "M148.7 411.3l-144-144C1.563 264.2 0 260.1 0 256s1.562-8.188 4.688-11.31l144-144c6.25-6.25 16.38-6.25 22.62 0s6.25 16.38 0 22.62L54.63 240H496C504.8 240 512 247.2 512 256s-7.156 16-16 16H54.63l116.7 116.7c6.25 6.25 6.25 16.38 0 22.62S154.9 417.6 148.7 411.3z",
		});
	';
	
	if ($attributes['thumbnails']) {
		$html .= '<div id="' . $slider_id . '-nav" class="slider slider-nav splide">';
		$html .= '<div class="splide__track">';
		$html .= '<div class="splide__list">';
		
		// Remove Caption for thumbnails
		$attributes['caption'] = false;
		$attributes['image_size'] = 'medium';
		
		$html .= twtheme_splide_slide($attributes['images'], $attributes);
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		
		$splide_javascript .= '
			var ' . $slider_id . '_slider_nav = new Splide("#' . $slider_id .'-nav", {
				isNavigation: true,
				gap: 10,
				focus: "left",
				pagination: false,
				perPage: 5,
				arrows: false,
				lazyLoad: "nearby",
				dragMinThreshold: {
					mouse: 4,
					touch: 10,
				},
				breakpoints : {
					640: {
						fixedWidth  : 66,
						fixedHeight : 38,
					},
				},
			});
			
			' . $slider_id . '_slider.sync( ' . $slider_id . '_slider_nav );
			' . $slider_id . '_slider.mount();
			' . $slider_id . '_slider_nav.mount();
		';
	} else {
		$splide_javascript .= $slider_id . '_slider.mount();';
	}
	
	$html .= '</section>';
	
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
		$image = wp_get_attachment_image($image_id, $attributes['image_size'], false, ['class' => $image_class]);
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
