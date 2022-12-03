<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$map = get_query_var('map');
$toc = get_query_var('toc');

$section_affiliates = $args->get_section('affiliates');

$options = get_option('twtheme_harbor_options');

if (!empty(twtheme_get_value($section_affiliates['intro'])) || !empty(twtheme_get_value($section_affiliates['affiliates'][0]['title']))) :
	$affiliates_headline = sprintf(twtheme_get_value($section_affiliates['headline']), get_the_title());
	$id = sanitize_title($affiliates_headline);
?>
<section id="<?= $id ?>" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11 m-auto">
				<?php
				
					echo '<h2>' . $affiliates_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $affiliates_headline,
						'short' => $section_affiliates['headline']['title'],
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 m-auto">
				<?php echo wpautop(twtheme_get_value($section_affiliates['intro'])); ?>

				<?php
				$toc_key = array_key_last($toc);
				foreach ($section_affiliates['affiliates'] as $key => $affiliates) {
					if (empty($affiliates['widget']['value'])) {
						continue;
					}
					
					$affiliates_child_headline = twtheme_get_value($affiliates['title']);
					$id = sanitize_title($affiliates_child_headline);
					
					$toc[$toc_key]['childs'][] = [
						'id' => $id,
						'title' => $affiliates_child_headline,
					];
					
					echo '<h3 id="' . $id .'">' . $affiliates_child_headline . '</h3>';
					
					if (!empty(twtheme_get_value($affiliates['widget']))) {
						echo wpautop(twtheme_get_value($affiliates['widget']));
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