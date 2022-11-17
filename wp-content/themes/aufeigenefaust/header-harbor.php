<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

get_header('base');

$post_id = get_the_ID();

$prolog_data = get_post_meta($post_id, 'prolog');
$harbor_data = get_post_meta($post_id, 'about');
$mobility_data = get_post_meta($post_id, 'mobility');
$highlights_data = get_post_meta($post_id, 'highlights');
$activity_data = get_post_meta($post_id, 'activity');
$locals_data = get_post_meta($post_id, 'locals');
$faq_data = get_post_meta($post_id, 'faq');
$affiliates_data = get_post_meta($post_id, 'affiliates');

$get_post_meta = new TwthemeGetPostMeta($post_id);
$post_meta = $get_post_meta->get_post_meta();

$title = get_the_title($post_id);
?>

<header class="cinematic">
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
<?php
$section_prolog = $get_post_meta->get_section('prolog');
if ($section_prolog) : ?>
<section id="einleitung" class="py-spacer">
	<div class="container">
		<?php if ($prolog_data[0]['prolog']) : ?>
		<div class="row">
			<div class="col-6 m-auto">
				<?php
				$gallery = do_shortcode('[splide images="' . $section_prolog['gallery']['value'] . '" thumbnails="true" title="Galerie über ' . $title . '" id="' . $title . '" caption="true" class="mx-ngutter"]');
				$prolog = wpautop($section_prolog['prolog']['value']);
				
				// Add gallery to prolog after first paragraph
				if (!empty($section_prolog['gallery']['value'])) {
					$prolog = preg_replace('/(.*?)\n/', '$1' . $gallery, $prolog, 1);
				}
				
				echo $prolog;?>
			</div>
		</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-6 m-auto">
				<?php
					$harbor_quickinfos = $get_post_meta->get_group('harbor-quick-infos');
					
					if ($harbor_quickinfos) : ?>
				<div class="bg-gray-100 p-gutter bg-light mx-ngutter mt-spacer">
					<ul class="icon-list columns-3" style="--columns: 3">
						<?php
					foreach ($harbor_quickinfos as $name => $quickinfo) {
						if (!empty($quickinfo['value'])) {
							$value = '';
							switch ($name) {
								case 'country':
									$icon = 'location-dot';
									$value .= data_countries($quickinfo['value']);
									break;
								case 'language':
									$icon = 'comments';
									foreach ($quickinfo['value'] as $language) {
										$value .= data_languages($language);
									}
									break;
								case 'currency':
									$icon = 'money-bill';
									$value .= data_currencies($quickinfo['value']);
									break;
								case 'season':
									$icon = 'calendar-range';
									$value .= $quickinfo['value'];
									break;
								case 'visum':
									$icon = 'passport';
									$value .= $quickinfo['value'];
									break;
								default:
									$icon = 'circle-small';
									$value .= $quickinfo['value'];
									break;
							}
							
							echo '<li><i class="fal fa-' . $icon .'"></i><strong class="d-block">' . $quickinfo['label'] . '</strong>' . $value;
							echo '</li>';
						}
					}
					?>
					</ul>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>