<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

function register_custom_sidebars()
{
	/* Register the 'primary' sidebar. */
	register_sidebar(
		array(
			'id' => 'primary',
			'name' => 'Primary sidebar',
			'description' => 'A short description of the sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
	/* Repeat register_sidebar() code for additional sidebars. */
}

add_action('widgets_init', 'register_custom_sidebars');
