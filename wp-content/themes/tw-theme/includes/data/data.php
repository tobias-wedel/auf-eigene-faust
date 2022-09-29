<?php
// Exit if accessed directly.
defined('ABSPATH') || exit();

// Required files
include_theme_files(
	[
		'languages',
		'currencies',
		'countries',
	],
	'includes/data/'
);
