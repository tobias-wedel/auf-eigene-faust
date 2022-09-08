<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

// Customer IP hide
add_action('woocommerce_checkout_update_order_meta', 'twtheme_woocommerce_checkout_update_order_meta', 1);
function twtheme_woocommerce_checkout_update_order_meta($order_id)
{
	update_post_meta(
		$order_id,
		'_customer_ip_address',
		0
	);
}

// Makes the theme support woocommerce
add_theme_support('woocommerce');
