<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$map = get_query_var('map');
$toc = get_query_var('toc');

$section_activity = $args->get_section('activity');

$options = get_option('twtheme_harbor_options');

if (!empty($section_activity['list'][0]['title']['value'])) :
	$activity_headline = sprintf(twtheme_get_value($section_activity['headline']), get_the_title());
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
	<?php $activitiys = $section_activity['list']; ?>
	<?php if ($activitiys) : ?>
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<?php
				$toc_key = array_key_last($toc);
				foreach ($activitiys as $key => $activitiy) {
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
						echo wpautop(check_hyperlinks(twtheme_get_value($activitiy['text'])));
					}
					
					if (!empty(twtheme_get_value($activitiy['gallery']))) {
						echo '<div class="ratio ratio-16x11">' . wp_get_attachment_image(twtheme_get_value($activitiy['gallery']), 'medium-large') . '</div>';
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