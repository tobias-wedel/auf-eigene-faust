<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$map = get_query_var('map');
$toc = get_query_var('toc');

$section_locals = $args->get_section('locals');

$options = get_option('twtheme_harbor_options');

if (!empty($section_locals['list'][0]['title']['value'])) : ?>
<section id="lokales" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
					$locals_headline = sprintf(twtheme_get_value($section_locals['headline']), get_the_title());
					$id = sanitize_title($locals_headline);
				
					echo '<h2 id="' . $id . '">' . $locals_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $locals_headline,
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<?php $locals = $section_locals['list']; ?>
	<?php if ($locals) : ?>
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
				$toc_key = array_key_last($toc);
				foreach ($locals as $key => $local) {
					if (empty($local['title']['value'])) {
						continue;
					}
					
					$local_child_headline = twtheme_get_value($local['title']);
					$id = sanitize_title($local_child_headline);
					
					$toc[$toc_key]['childs'][] = [
						'id' => $id,
						'title' => $local_child_headline,
					];
					
					echo '<h3 id="' . $id .'">' . $local_child_headline . '</h3>';
					
					if (!empty(twtheme_get_value($local['text']))) {
						echo wpautop(twtheme_get_value($local['text']));
					}
					
					if (!empty(twtheme_get_value($local['gallery']))) {
						echo '<div class="ratio ratio-16x11">' . wp_get_attachment_image(twtheme_get_value($local['gallery']), 'medium-large') . '</div>';
					}
					
					if (!empty(twtheme_get_value($local['address-coords']))) {
						$local_map_data = [];
						$local_map_data[] = [
							'address' => twtheme_get_value($local['address']),
							'coords' => twtheme_get_value($local['address-coords']),
							'title' => twtheme_get_value($local['title']),
							'icon' => $options['icons']['locals-icon'],
							'color' => $options['icons']['locals-color'],
						];
						
						$map = array_merge($map, $local_map_data);
						echo '<div class="mx-ngutter">';
						echo twtheme_map($local_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
						echo '</div>';
					}
					$local_urls = $args->get_group('local-urls');

					echo '<div class="bg-gray-100 p-gutter bg-light mx-ngutter mt-spacer">';
					echo '<ul class="icon-list" style="--columns: 4">';
					
					foreach ($local_urls[$key] as $local_url_key => $url_data) {
						switch ($url_data['id']) {
							case 'facebook':
								$icon = 'fab fa-facebook';
								break;
							case 'instagram':
								$icon = 'fab fa-instagram';
								break;
							case 'website':
								$icon = 'fal fa-arrow-pointer';
								break;
							case 'booking':
								$icon = 'fal fa-ticket';
								break;
						}
						
						echo '<li class="direction ' . $url_data['id'] . '"><i class="' . $icon . '"></i><strong class="d-block">' . $url_data['label'] . '</strong>' . twtheme_get_value($url_data) . '</li>';
					}
					
					echo '</ul>';
					echo '</div>';
				}
				?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
<?php endif;

set_query_var('map', $map);
set_query_var('toc', $toc);

?>