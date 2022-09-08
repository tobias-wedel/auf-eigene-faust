<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

// Live Canvas Custom View
function lc_get_posts_mycustom_view($the_posts, $get_posts_shortcode_atts)
{
	extract($get_posts_shortcode_atts);
	
	$posts_per_page = $get_posts_shortcode_atts['posts_per_page'];
	$heading_tag = $get_posts_shortcode_atts['output_heading_tag'];
	$output_excerpt_text = $get_posts_shortcode_atts['output_excerpt_text'];
	$output_excerpt_length = $get_posts_shortcode_atts['output_excerpt_length'];
	$post_type = $get_posts_shortcode_atts['post_type'];
	$columns = $get_posts_shortcode_atts['output_number_of_columns'];
	
	$col_size_class = 'col-lg-' . 12 / $columns;

	if ($posts_per_page == 3) {
		$col_size_class .= ' col-md-8 offset-md-2 offset-lg-0';
	} else {
		$col_size_class .= ' col-md-6';
	}

	$out = '';

	$out .= '<div class="row ' . $post_type . ' card-listing">';
	switch ($post_type) {
		case 'product':
			foreach ($the_posts as $post):
				$product = wc_get_product($post->ID);
				$out .= '<div class="' . $col_size_class . '">';
				ob_start();
				get_template_part('template-parts/cards/card', $post_type, ['post' => $post, 'heading_tag' => $heading_tag]);
				$out .= ob_get_contents();
				ob_clean();
				$out .= '</div>';
			endforeach;
			break;
		default:
			foreach ($the_posts as $post):
				$out .= '<div class="' . $col_size_class . '">';
				ob_start();
				get_template_part('template-parts/cards/card', $post_type, ['post' => $post, 'heading_tag' => $heading_tag]);
				$out .= ob_get_contents();
				ob_clean();
				$out .= '</div>';
			endforeach;
			break;
	}
	$out .= '</div>';
	
	wp_reset_postdata();
	
	return $out;
}
