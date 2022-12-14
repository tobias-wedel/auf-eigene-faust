<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$map = get_query_var('map');
$toc = get_query_var('toc');

$section_highlights = $args->get_section('highlights');

$options = get_option('twtheme_harbor_options');
if ($section_highlights['list'][0]['title']['value']) :
	$highlights_headline = sprintf(twtheme_get_value($section_highlights['headline']), get_the_title());
	$id = sanitize_title($highlights_headline);
?>
<section id="<?= $id ?>" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<?php
					echo '<h2>' . $highlights_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $highlights_headline,
						'short' => $section_highlights['headline']['title'],
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<?php $highlights = $section_highlights['list']; ?>
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<?php
				$toc_key = array_key_last($toc);
				foreach ($highlights as $key => $highlight) {
					if (empty($highlight['title']['value'])) {
						continue;
					}
					
					$highlight_child_headline = twtheme_get_value($highlight['title']);
					$id = sanitize_title($highlight_child_headline);
					
					$toc[$toc_key]['childs'][] = [
						'id' => $id,
						'title' => $highlight_child_headline,
					];
					
					echo '<h3 id="' . $id .'">' . $highlight_child_headline . '</h3>';
					
					if (!empty(twtheme_get_value($highlight['text']))) {
						echo wpautop(find_hyperlinks(twtheme_get_value($highlight['text'])));
					}
					
					if (!empty(twtheme_get_value($highlight['gallery']))) {
						echo do_shortcode('[splide images="' . twtheme_get_value($highlight['gallery']) . '" thumbnails="false" title="Galerie über ' . $highlight_child_headline . '" id="' . $id . '" caption="true" class="mb-0 mx-ngutter"]');
					}
					
					if (!empty(twtheme_get_value($highlight['address-coords']))) {
						$highlight_map_data = [];
						$highlight_map_data[] = [
							'address' => twtheme_get_value($highlight['address']),
							'coords' => twtheme_get_value($highlight['address-coords']),
							'title' => twtheme_get_value($highlight['title']),
							'icon' => $options['icons']['highlights-icon'],
							'color' => $options['icons']['highlights-color'],
						];
						
						$map = array_merge($map, $highlight_map_data);
						
						echo '<div class="mx-ngutter">';
						echo twtheme_map($highlight_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
						echo '</div>';
					}
					
					if (!empty(twtheme_get_value($highlight['direction'])) || !empty(twtheme_get_value($highlight['tickets']))) {
						echo '<div class="bg-gray-100 p-gutter bg-light mx-ngutter">';
						echo '<ul class="icon-list" style="--columns: 1">';
						if (!empty(twtheme_get_value($highlight['direction']))) {
							echo '<li class="direction"><i class="fal fa-location-dot"></i><strong class="d-block">' . $highlight['direction']['label'] . '</strong>' . twtheme_get_value($highlight['direction']) . '</li>';
						}
						if (!empty(twtheme_get_value($highlight['tickets']))) {
							echo '<li class="direction"><i class="fal fa-ticket"></i><strong class="d-block">' . $highlight['tickets']['label'] . '</strong>' . get_hyperlink(twtheme_get_value($highlight['tickets'])) . '</li>';
						}
						echo '</ul>';
						echo '</div>';
					}
				}
				?>
			</div>
		</div>
	</div>
</section>
<?php endif;

set_query_var('map', $map);
set_query_var('toc', $toc);

?>