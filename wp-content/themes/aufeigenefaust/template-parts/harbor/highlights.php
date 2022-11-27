<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$map = get_query_var('map');
$toc = get_query_var('toc');

$section_highlights = $args->get_section('highlights');

$options = get_option('twtheme_harbor_options');

if ($section_highlights) : ?>
<section id="mobilitaet" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
					$highlights_headline = sprintf(twtheme_get_value($section_highlights['headline']), get_the_title());
					$id = sanitize_title($highlights_headline);
				
					echo '<h2 id="' . $id . '">' . $highlights_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $highlights_headline,
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<?php $highlights = $section_highlights['list']; ?>
	<?php if ($highlights) : ?>
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
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
						echo wpautop(twtheme_get_value($highlight['text']));
					}
					
					if (!empty(twtheme_get_value($highlight['gallery']))) {
						echo '<div class="ratio ratio-16x11">' . wp_get_attachment_image(twtheme_get_value($highlight['gallery']), 'medium-large') . '</div>';
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
						echo twtheme_map($highlight_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
					}
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