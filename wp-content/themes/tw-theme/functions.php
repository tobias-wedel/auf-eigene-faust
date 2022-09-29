<?php

define('TWTHEME__VERSION', '1.0');
define('TWTHEME__DOMAIN', 'https://auf-eigene-faust.com');
define('TWTHEME__DIR', dirname(__FILE__));
define('TWTHEME__PATH', get_stylesheet_directory_uri());
define('TWTHEME__ADMIN_PATH', TWTHEME__PATH . '/includes/admin');
define('TWTHEME__OPTIONS', get_option('twtheme'));

$files = [
	'scripts',
	'helper',
	'data/data',
	'comments',
	'menus',
	'sidebars',
	'theme',
	'useragent',
	'shortcodes/shortcodes',
	'livecanvas/livecanvas',
	'admin/admin',
	'posttypes/posttypes',
];
 
foreach ($files as $file) {
	require_once TWTHEME__DIR . '/includes/' . $file . '.php';
}
