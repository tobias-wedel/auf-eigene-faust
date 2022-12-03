<?php

// Exit if accessed directly.
defined('ABSPATH') || exit(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<!-- Favicon generator @ https://realfavicongenerator.net/ -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?= TWTHEME__PATH ?>/assets/images/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= TWTHEME__PATH ?>/assets/images/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= TWTHEME__PATH ?>/assets/images/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?= TWTHEME__PATH ?>/assets/images/favicons/site.webmanifest">
	<link rel="mask-icon" href="<?= TWTHEME__PATH ?>/assets/images/favicons/safari-pinned-tab.svg" color="#000000">
	<meta name="msapplication-TileColor" content="#ffc40d">
	<meta name="theme-color" content="#ffffff">
	<?php wp_head(); ?>
</head>