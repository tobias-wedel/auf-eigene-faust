<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$post = $args['post'];
$post_id = $post->ID;
$heading_tag = !empty($args['heading_tag']) ? $args['heading_tag'] : 'h2';

$product = wc_get_product($post->ID);

$html = '<article role="article" class="card border-0 click-dummy">';
$html .= '<div class="card-image ratio ratio-16x9">';
$html .= get_the_post_thumbnail($post, 'vollbach-listing', ['class' => 'card-img-top']);
$html .= '</div>';
$html .= '<div class="card-body">';
$html .= '<header><' . $heading_tag . ' class="text-uppercase card-title"> <a href="' . get_the_permalink($post) . '">' . get_the_title($post) . '</a></' . $heading_tag . '></header>';

$html .= get_price($product);
//$product->get_regular_price() . $product->get_sale_price() . $product->get_price();
$html .= '</div>';
$html .= '</article>';

echo $html;
