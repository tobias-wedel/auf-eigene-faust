<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$map = get_query_var('map');
$toc = get_query_var('toc');

$section_harbor = $args->get_section('about');

$options = get_option('twtheme_harbor_options');

if (!empty($section_harbor)) :
	$page_title = get_the_title();
	$harbor_headline = sprintf(twtheme_get_value($section_harbor['headline']), $page_title);
	$id = sanitize_title($harbor_headline);
?>
<section id="<?= $id ?>" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<?php
					echo '<h2>' . $harbor_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $harbor_headline,
						'short' => $section_harbor['headline']['title'],
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<div class="container mb-spacer mt-5">
		<div class="row">
			<?php if (twtheme_get_value($section_harbor['gallery'])) : ?>
			<div class="col-6 offset-lg-1 pe-lg-0">
				<?= do_shortcode('[splide images="' . twtheme_get_value($section_harbor['gallery']) . '" thumbnails="false" title="Galerie über ' . $harbor_headline . '" id="' . $id . '" caption="true" class="mb-0"]'); ?>
			</div>
			<div class="col-4 ps-lg-0">
				<?php
				$harbor_map_data = [];
				
				foreach ($section_harbor['landing-stages'] as $landingstage) {
					if (!twtheme_get_value($landingstage['address-coords'])) {
						continue;
					}
					
					$harbor_map_data[] = [
						'address' => twtheme_get_value($landingstage['address']),
						'coords' => twtheme_get_value($landingstage['address-coords']),
						'title' => 'Anlegestelle: ' . twtheme_get_value($landingstage['name']),
						'icon' => $options['icons']['landing-stage-icon'],
						'color' => $options['icons']['landing-stage-color'],
					];
				}
				
				$map = array_merge($map, $harbor_map_data);
				echo twtheme_map($harbor_map_data, ['zoom' => '14', 'wrapper' => false]);
				?>
			</div>
			<?php else : ?>
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<?php
					$harbor_map_data = [];
					
					foreach ($section_harbor['landing-stages'] as $landingstage) {
						if (!twtheme_get_value($landingstage['address-coords'])) {
							continue;
						}
						
						$harbor_map_data[] = [
							'address' => twtheme_get_value($landingstage['address']),
							'coords' => twtheme_get_value($landingstage['address-coords']),
							'title' => 'Anlegestelle: ' . twtheme_get_value($landingstage['name']),
							'icon' => $options['icons']['landing-stage-icon'],
							'color' => $options['icons']['landing-stage-color'],
						];
					}
					
					$map = array_merge($map, $harbor_map_data);
					
					echo '<div class="mx-ngutter">';
					echo twtheme_map($harbor_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
					echo '</div>';
				?>
			</div>
			<?php endif; ?>

		</div>
		<div class="row mt-5">
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<?php
				echo wpautop(find_hyperlinks(twtheme_get_value($section_harbor['text'])));
				$harbor_arrivals = $args->get_group('harbor-arrivals');
				
				if ($harbor_arrivals) {
					$toc_key = array_key_last($toc);
					foreach ($harbor_arrivals as $key => $arrival) {
						if (!empty($arrival[$key]['value'])) {
							$harbor_arrivals_child_headline = sprintf(twtheme_get_title($arrival[$key]), $page_title);
							$id = sanitize_title($harbor_arrivals_child_headline);
							echo '<h3 id="' . $id . '">' . sprintf($harbor_arrivals_child_headline, $page_title) . '</h3>';
								
							echo wpautop(find_hyperlinks(twtheme_get_value($arrival[$key])));
							
							if (isset($arrival[$key . '-image']['value']) && twtheme_get_value($arrival[$key . '-image'])) {
								echo do_shortcode('[splide images="' . twtheme_get_value($arrival[$key . '-image']) . '" thumbnails="false" title="Galerie über ' . $harbor_arrivals_child_headline . '" id="' . $id . '" caption="true" class="mb-0 mx-ngutter"]');
							}
							
							$arrival_map_data = [];
								
							if ($key == 'shuttle') {
								if (!empty($arrival[$key . '-address-coords']['value'])) {
									$arrival_map_data[] = [
										'address' => twtheme_get_value($arrival[$key . '-address']),
										'coords' => twtheme_get_value($arrival[$key . '-address-coords']),
										'title' => twtheme_get_title($arrival[$key . '-address']),
										'icon' => $options['icons'][$key . '-icon'],
										'color' => $options['icons'][$key . '-color'],
									];
											
									$map = array_merge($map, $arrival_map_data);
								}
								
								if (!empty($arrival[$key . '-address-coords-arrival']['value'])) {
									$arrival_map_data[] = [
										'address' => twtheme_get_value($arrival[$key . '-address-arrival']),
										'coords' => twtheme_get_value($arrival[$key . '-address-coords-arrival']),
										'title' => twtheme_get_title($arrival[$key . '-address-arrival']),
										'icon' => $options['icons'][$key . '-icon'],
										'color' => $options['icons'][$key . '-color'],
									];
											
									$map = array_merge($map, $arrival_map_data);
								}
								
								if (!empty($arrival_map_data)) {
									echo '<div class="mx-ngutter">';
									echo twtheme_map($arrival_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
									echo '</div>';
								}
							} else {
								if (!empty($arrival[$key . '-address-coords']['value'])) {
									$arrival_map_data[] = [
										'address' => twtheme_get_value($arrival[$key . '-address']),
										'coords' => twtheme_get_value($arrival[$key . '-address-coords']),
										'title' => twtheme_get_title($arrival[$key . '-address']),
										'icon' => $options['icons'][$key . '-icon'],
										'color' => $options['icons'][$key . '-color'],
									];
											
									$map = array_merge($map, $arrival_map_data);
									echo '<div class="mx-ngutter">';
									echo twtheme_map($arrival_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
									echo '</div>';
								}
							}
							$toc[$toc_key]['childs'][] = [
								'id' => $id,
								'title' => $harbor_arrivals_child_headline,
							];
						}
					}
				} ?>
			</div>

		</div>
</section>
<?php endif;

set_query_var('map', $map);
set_query_var('toc', $toc);

?>