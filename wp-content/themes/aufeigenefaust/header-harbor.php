<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

get_header('base');

$post_id = get_the_ID();
$title = get_the_title($post_id);

?>

<body <?php body_class('position-relative'); ?> data-spy="scroll" data-target="#toc-scroller" data-offset="0">
	<header class="cinematic set-h[self|header]">
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