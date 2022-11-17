<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$post = $args['post'];
$post_id = $post->ID;
$heading_tag = !empty($args['heading_tag']) ? $args['heading_tag'] : 'h2';
$excerpt_length = !empty($args['excerpt_length']) ? $args['excerpt_length'] : '20';

$html = '<article role="article" id="post-242" class="card border-0 click-dummy">';
$html .= '<div class="card-image ratio ratio-16x9">';
$html .= get_the_post_thumbnail($post_id, 'vollbach-listing', ['class' => 'card-img-top']);
$html .= '</div>';
$html .= '<div class="card-body">';
$html .= '<header><' . $heading_tag . ' class="card-title"> <a href="' . get_the_permalink($post_id) . '">' . $post->post_title . '</a></' . $heading_tag . '></header>';
$html .= '<p>' . wp_trim_words(wp_strip_all_tags($post->post_content, true), 20, '...') . '</p>';
$html .= '<a class="btn btn-link" role="button"><span editable="inline" class="">Weiterlesen</span><span><i class="fal fa-long-arrow-right fa-lg"></i></span></a>';
$html .= '</div>';
$html .= '</article>';

echo $html;
