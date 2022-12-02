<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$map = get_query_var('map');
$toc = get_query_var('toc');

$section_harbor = $args->get_section('about');

$options = get_option('twtheme_harbor_options');

if (!empty($section_harbor)) : ?>
<section id="hafen" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
					$harbor_headline = sprintf(twtheme_get_value($section_harbor['headline']), get_the_title());
					$id = sanitize_title($harbor_headline);
					
					echo '<h2 id="' . $id . '">' . $harbor_headline . '</h2>';
				
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
				
				$map = array_merge($map, $harbor_map_data);
				echo twtheme_map($harbor_map_data, ['zoom' => '14', 'wrapper' => false]);
				?>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col-6 m-auto">
				<?php
				echo wpautop(twtheme_get_value($section_harbor['text']));
				$harbor_arrivals = $args->get_group('harbor-arrivals');
				if ($harbor_arrivals) {
					$toc_key = array_key_last($toc);
					foreach ($harbor_arrivals as $key => $arrival) {
						if (!empty($arrival[$key]['value'])) {
							$harbor_arrivals_child_headline = twtheme_get_title($arrival[$key]);
							$id = sanitize_title($harbor_arrivals_child_headline);
							echo '<h3 id="' . $id . '">' . $harbor_arrivals_child_headline . '</h3>';
							
							echo wpautop(twtheme_get_value($arrival[$key]));
							
							if (!empty($arrival[$key . '-address-coords']['value'])) {
								$arrival_map_data = [];
								$arrival_map_data[] = [
									'address' => twtheme_get_value($arrival[$key . '-address']),
									'coords' => twtheme_get_value($arrival[$key . '-address-coords']),
									'title' => twtheme_get_title($arrival[$key]),
									'icon' => $options['icons'][$key . '-icon'],
									'color' => $options['icons'][$key . '-color'],
								];
								
								$map = array_merge($map, $arrival_map_data);
								echo '<div class="mx-ngutter">';
								echo twtheme_map($arrival_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
								echo '</div>';
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