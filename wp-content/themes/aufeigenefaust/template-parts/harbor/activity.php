<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$map = get_query_var('map');
$toc = get_query_var('toc');

$section_activity = $args->get_section('activity');

$options = get_option('twtheme_harbor_options');
$the_title = get_the_title();

if (
	!empty($section_activity['list'][0]['title']['value']) ||
	!empty($section_activity['beaches'][0]['title']['value']) ||
	!empty($section_activity['restaurants'][0]['title']['value'])
	) :
		
	$activity_headline = sprintf(twtheme_get_value($section_activity['headline']), $the_title);
	$id = sanitize_title($activity_headline);
?>
<section id="<?= $id ?>" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<?php
					echo '<h2>' . $activity_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $activity_headline,
						'short' => $section_activity['headline']['title'],
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<!-- ALLGEMEINE AKTIVITÄTEN -->
				<?php
				$toc_key = array_key_last($toc);
				if (!empty($section_activity['list'][0]['title']['value'])) {
					foreach ($section_activity['list'] as $key => $activitiy) {
						if (empty($activitiy['title']['value'])) {
							continue;
						}
					
						$activitiy_child_headline = twtheme_get_value($activitiy['title']);
						$id = sanitize_title($activitiy_child_headline);
					
						$toc[$toc_key]['childs'][] = [
						'id' => $id,
						'title' => $activitiy_child_headline,
					];
					
						echo '<h3 id="' . $id .'">' . $activitiy_child_headline . '</h3>';
					
						if (!empty(twtheme_get_value($activitiy['text']))) {
							echo wpautop(find_hyperlinks(twtheme_get_value($activitiy['text'])));
						}
					
						if (!empty(twtheme_get_value($activitiy['gallery']))) {
							echo '<div class="ratio ratio-16x11">' . wp_get_attachment_image(twtheme_get_value($activitiy['gallery']), 'medium-large') . '</div>';
						}
					}
				}
				?>

				<!-- BEACHES -->
				<?php
				if (!empty($section_activity['beaches'][0]['title']['value'])) {
					$beach_headline = sprintf(twtheme_get_value($section_activity['beaches-headline']), $the_title);
					$id = sanitize_title($beach_headline);
					
					$toc[$toc_key]['childs'][] = [
						'id' => $id,
						'title' => $beach_headline,
					];
					
					echo '<h3 id="' . $id .'">' . $beach_headline . '</h3>';
					
					$beach_map_data = [];
					
					foreach ($section_activity['beaches'] as $key => $beach) {
						if (empty($beach['title']['value'])) {
							continue;
						}
						
						echo '<h4>' . twtheme_get_value($beach['title']) . '</h4>';
						
						if (!empty(twtheme_get_value($beach['text']))) {
							echo wpautop(find_hyperlinks(twtheme_get_value($beach['text'])));
						}
						
						if (!empty(twtheme_get_value($beach['address-coords']))) {
							$beach_map_data[] = [
								'address' => twtheme_get_value($beach['address']),
								'coords' => twtheme_get_value($beach['address-coords']),
								'title' => twtheme_get_value($beach['title']),
								'icon' => $options['icons']['beach-icon'],
								'color' => $options['icons']['beach-color'],
							];
							
							$map = array_merge($map, $beach_map_data);
						}
					}
					
					if (!empty($beach_map_data)) {
						echo '<div class="mx-ngutter">';
						echo twtheme_map($beach_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
						echo '</div>';
					}
				}
				?>

				<!-- RESTAURANT -->
				<?php
				if (!empty($section_activity['restaurants'][0]['title']['value'])) {
					$restaurant_headline = sprintf(twtheme_get_value($section_activity['restaurants-headline']), $the_title);
					$id = sanitize_title($restaurant_headline);
					
					$toc[$toc_key]['childs'][] = [
						'id' => $id,
						'title' => $restaurant_headline,
					];
					
					echo '<h3 id="' . $id .'">' . $restaurant_headline . '</h3>';
					
					$restaurant_map_data = [];
					
					foreach ($activitiys_restaurants as $key => $restaurant) {
						if (empty($restaurant['title']['value'])) {
							continue;
						}
						
						echo '<h4>' . twtheme_get_value($restaurant['title']) . '</h4>';
						
						if (!empty(twtheme_get_value($restaurant['text']))) {
							echo wpautop(find_hyperlinks(twtheme_get_value($beach['text'])));
						}
						
						if (!empty(twtheme_get_value($restaurant['address-coords']))) {
							$restaurant_map_data[] = [
								'address' => twtheme_get_value($restaurant['address']),
								'coords' => twtheme_get_value($restaurant['address-coords']),
								'title' => twtheme_get_value($restaurant['title']),
								'icon' => $options['icons']['restaurant-icon'],
								'color' => $options['icons']['restaurant-color'],
							];
							
							$map = array_merge($map, $restaurant_map_data);
						}
					}
					
					if (!empty($restaurant_map_data)) {
						echo '<div class="mx-ngutter">';
						echo twtheme_map($restaurant_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
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