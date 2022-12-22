<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$map = get_query_var('map');
$toc = get_query_var('toc');

$section_mobility = $args->get_section('mobility');

$options = get_option('twtheme_harbor_options');

if ($section_mobility) :
	$mobility_headline = sprintf(twtheme_get_value($section_mobility['headline']), get_the_title());
	$id = sanitize_title($mobility_headline);
?>
<section id="<?= $id ?>" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<?php
				
					echo '<h2>' . $mobility_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $mobility_headline,
						'short' => $section_mobility['headline']['title'],
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<?php $mobilities = $args->get_group('mobility'); ?>
	<?php if ($mobilities) : ?>
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<?php if (!empty(($section_mobility['intro']))) : ?>
				<div class="mt-5">
					<?php echo wpautop(find_hyperlinks(twtheme_get_value($section_mobility['intro']))); ?>
				</div>
				<?php endif; ?>
				<?php
				$toc_key = array_key_last($toc);
				foreach ($mobilities as $key => $mobility) {
					if (empty($mobility[$key]['value'])) {
						continue;
					}
					
					$mobility_child_headline = twtheme_get_title($mobility[$key]);
					$id = sanitize_title($mobility_child_headline);
					
					$toc[$toc_key]['childs'][] = [
						'id' => $id,
						'title' => $mobility_child_headline,
					];
					
					echo '<h3 id="' . $id .'">' . $mobility_child_headline . '</h3>';
					
					echo wpautop(find_hyperlinks(($mobility[$key]['value'])));
					
					if (!empty($mobility[$key . '-image']['value'])) {
						echo do_shortcode('[splide images="' . twtheme_get_value($mobility[$key . '-image']) . '" thumbnails="false" title="Galerie über ' . $mobility_child_headline . '" id="' . $id . '" caption="true" class="mb-0 mx-ngutter"]');
					}
					
					if (!empty($mobility[$key . '-address-coords']['value'])) {
						$mobility_map_data = [];
						$mobility_map_data[] = [
							'address' => twtheme_get_value($mobility[$key . '-address']),
							'coords' => twtheme_get_value($mobility[$key . '-address-coords']),
							'title' => twtheme_get_title($mobility[$key . '-address']),
							'icon' => $options['icons'][$key . '-icon'],
							'color' => $options['icons'][$key . '-color'],
						];
						
						$map = array_merge($map, $mobility_map_data);
						echo '<div class="mx-ngutter">';
						echo twtheme_map($mobility_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
						echo '</div>';
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