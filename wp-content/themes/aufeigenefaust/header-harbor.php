<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

get_header('base');

$post_id = get_the_ID();

$post_meta_data = new TwthemeGetPostMeta($post_id);
$post_meta = $post_meta_data->get_post_meta();
$options = get_option('twtheme_harbor_options');
$title = get_the_title($post_id);
$toc = [];
$full_map = [];
$html = '';
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
$section_prolog = $post_meta_data->get_section('prolog');
if ($section_prolog) :
?>
<section id="einleitung" class="py-spacer">
	<div class="container">
		<?php if ($section_prolog['prolog']['value']) : ?>
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
					$harbor_quickinfos = $post_meta_data->get_group('harbor-quick-infos');
					
					if ($harbor_quickinfos) : ?>
				<div class="bg-gray-100 p-gutter bg-light mx-ngutter mt-spacer">
					<ul class="icon-list" style="--columns: 3">
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
								case 'visa':
									$icon = 'passport';
									$value .= $quickinfo['value'];
									break;
								default:
									$icon = 'circle-small';
									$value .= $quickinfo['value'];
									break;
							}
							echo '<li class="' . $name . '"><i class="fal fa-' . $icon .'"></i><strong class="d-block">' . $quickinfo['label'] . '</strong>' . $value;
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
<?php ob_start(); ?>
<?php $section_harbor = $post_meta_data->get_section('about'); ?>
<?php if ($section_harbor) : ?>
<section id="einleitung" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
					$harbor_headline = sprintf(twtheme_get_value($section_harbor['headline']), $title);
					$id = sanitize_title($harbor_headline);
					
					echo '<h2>' . $harbor_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $harbor_headline,
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<div class="container mb-spacer">
		<div class="row">
			<div class="col-6 offset-lg-1 pe-lg-0">
				<div class="ratio ratio-16x11">
					<?= wp_get_attachment_image(twtheme_get_value($section_harbor['gallery']), 'large', false, ['class' => 'img-fluid']);?>
				</div>
			</div>
			<div class="col-4 ps-lg-0">
				<?php
				$harbor_map_data = [];
				
				if (twtheme_get_value($section_harbor['address-coords'])) {
					$harbor_map_data[] = [
						'address' => twtheme_get_value($section_harbor['address']),
						'coords' => twtheme_get_value($section_harbor['address-coords']),
						'title' => $harbor_headline,
						'icon' => $options['icons']['harbor-icon'],
						'color' => $options['icons']['harbor-color'],
					];
				}
				
				foreach ($section_harbor['landing-stages'] as $landingstage) {
					if (!twtheme_get_value($landingstage['address-coords'])) {
						continue;
					}
					
					$harbor_map_data[] = [
						'address' => twtheme_get_value($landingstage['address']),
						'coords' => twtheme_get_value($landingstage['address-coords']),
						'title' => twtheme_get_value($landingstage['name']),
						'icon' => $options['icons']['landing-stage-icon'],
						'color' => $options['icons']['landing-stage-color'],
					];
				}
				
				$full_map[] = $harbor_map_data;
				?>
				<?= twtheme_map($harbor_map_data, ['zoom' => '14']) ?>
			</div>
		</div>
	</div>

	<?php $harbor_arrivals = $post_meta_data->get_group('harbor-arrivals'); ?>
	<?php if ($harbor_arrivals) : ?>
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
				$toc_key = array_key_last($toc);
				foreach ($harbor_arrivals as $arrival) {
					if ($arrival['label'] != 'Text') {
						$id = sanitize_title($arrival['label']);
						echo '<h3>' . $arrival['label'] . '</h3>';
						$toc[$toc_key]['childs'][] = [
							'id' => $id,
							'title' => $arrival['label'],
						];
					}
					echo wpautop($arrival['value']);
				}
				?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
<?php endif; ?>
<?php $section_mobility = $post_meta_data->get_section('mobility'); ?>
<?php if ($section_mobility) : ?>
<section id="mobilitaet" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
					$mobility_headline = sprintf(twtheme_get_value($section_mobility['headline']), $title);
					$id = sanitize_title($mobility_headline);
				
					echo '<h2 id="' . $id . '">' . $mobility_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $mobility_headline,
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<?php $mobilities = $post_meta_data->get_group('mobility'); ?>
	<?php if ($mobilities) : ?>
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
				$toc_key = array_key_last($toc);
				foreach ($mobilities as $key => $mobility) {
					if (!empty($mobility['value'])) {
						$id = sanitize_title($mobility['label']);
						if ($mobility['label'] != 'Introtext') {
							echo '<h3 id="' . $id .'">' . $mobility['label'] . '</h3>';
							$toc[$toc_key]['childs'][] = [
								'id' => $id,
								'title' => $mobility['label']
							];
						}
						echo wpautop($mobility['value']);
					}
				} ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
<?php endif;
$html .= ob_get_contents();
ob_end_clean();
echo $html;

//print_rpre($toc);

//print_rpre($section_harbor);?>