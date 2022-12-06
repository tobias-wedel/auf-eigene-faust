<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

get_header('base');

$post_id = get_the_ID();
$title = get_the_title($post_id);

?>

<body <?php body_class('position-relative'); ?> data-offset="0">
	<header class="cinematic set-h[self|header]">
		<div class="top-bar">
			<div class="container-fluid mt-4">
				<div class="row">
					<div class="col-auto">
						<?php echo wp_get_attachment_image(TWTHEME__OPTIONS['general']['logo'], 'full', '', ['class' => 'logo']); ?>
					</div>
					<div class="col-auto">
						<?php echo get_search_form(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php the_post_thumbnail() ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<?php
					$title = get_the_title();
					$title_count_chars = strlen($title);
					$title_class  = '';
					if ($title_count_chars > 16) {
						$title_class = 'xxl';
					} elseif ($title_count_chars > 9) {
						$title_class = 'lg';
					}
					?>
					<h1 class="text-uppercase display-1"><span class="<?= $title_class ?>"><?= $title ?></span> <span class="display-5">auf eigene Faust</span></h1>
				</div>
			</div>
		</div>
	</header>