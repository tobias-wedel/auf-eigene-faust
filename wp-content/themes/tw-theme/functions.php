<?php

define('TWTHEME__VERSION', '1.0');
define('TWTHEME__DOMAIN', 'https://endlosweit.com');
define('TWTHEME__DIR', dirname(__FILE__));
define('TWTHEME__PATH', get_stylesheet_directory_uri());

$files = [
	'scripts',
	'helper',
	'comments',
	'menus',
	'sidebars',
	'theme',
	'useragent',
	'shortcodes/shortcodes',
	'livecanvas/livecanvas',
	'woocommerce/woocommerce',
];
 
foreach ($files as $file) {
	require_once TWTHEME__DIR . '/includes/' . $file . '.php';
}
