<?php

define('TWTHEME__VERSION', '1.0');
define('TWTHEME__DOMAIN', 'https://auf-eigene-faust.com');
define('TWTHEME__DIR', dirname(__FILE__));
define('TWTHEME__PATH', get_stylesheet_directory_uri());
define('TWTHEME__ENGINE_PATH', TWTHEME__PATH . '/includes/engine');
define('TWTHEME__OPTIONS', get_option('twtheme'));

if (!function_exists('include_theme_files')) {
	function include_theme_files($files, $path)
	{
		foreach ($files as $file) {
			require_once TWTHEME__DIR . '/' . $path . $file . '.php';
		}
	}
}

include_theme_files(
	[
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
		'engine/engine',
		'admin/admin',
		'posttypes/posttypes',
	],
	'includes/'
);
