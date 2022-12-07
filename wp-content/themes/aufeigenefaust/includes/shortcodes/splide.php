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
		
		
	wp_enqueue_style('splide', TWTHEME__PATH . '/assets/css/splide.css', '', TWTHEME__VERSION);
	wp_enqueue_script('splide', TWTHEME__PATH . '/assets/js/splide.js', '', TWTHEME__VERSION);
	wp_enqueue_script('splide-intersection', TWTHEME__PATH . '/assets/js/splide-extension-intersection.min.js', ['splide'], TWTHEME__VERSION);
	
	$slider_id = 'slider_' . str_replace('-', '_', sanitize_title($attributes['id']));
		
	$html = '';
	$html .= '<section id="' . $slider_id . '-slider-wrapper" class="' . $slider_id . '-slider-wrapper slider-wrapper" class="' . $attributes['class'] . '" aria-label="' . $attributes['title'] . '">';
	$html .= '<div class="fullscreen-trigger" data-fullscreen="' . $slider_id . '-slider-wrapper"><i class="fal fa-expand expand"></i><i class="fal fa-compress compress" style="display: none;"></i></div>';
	$html .= '<div id="' . $slider_id . '" class="slider slider-main splide">';
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
			rewind: true,
			intersection: {
				inView: {
					keyboard: true,
				},
				outView: {
				},
			  },
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
			let splide_nav_options = {
				isNavigation: true,
				gap: 10,
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
			};
			
			if(document.querySelectorAll("#' . $slider_id .'-nav .splide__slide").length > 5) {
				splide_nav_options.focus = "center";
			} else {
				splide_nav_options.focus = "left";
			}
			
			var ' . $slider_id . '_slider_nav = new Splide("#' . $slider_id .'-nav", splide_nav_options);
			' . $slider_id . '_slider.sync( ' . $slider_id . '_slider_nav );
			' . $slider_id . '_slider.mount(window.splide.Extensions);
			' . $slider_id . '_slider_nav.mount();
		';
	} else {
		$splide_javascript .= $slider_id . '_slider.mount(window.splide.Extensions);';
	}
	
	$html .= '</section>';
	
	wp_add_inline_script('splide-intersection', $splide_javascript, 'after');

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
