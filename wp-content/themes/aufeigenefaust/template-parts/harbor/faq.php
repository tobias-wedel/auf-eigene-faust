<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

$map = get_query_var('map');
$toc = get_query_var('toc');

$section_faq = $args->get_section('faq');

$options = get_option('twtheme_harbor_options');

if (!empty($section_faq['faqs'][0]['question']['value'])) : ?>
<section id="faqs" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
					$faqs_headline = sprintf(twtheme_get_value($section_faq['headline']), get_the_title());
					$id = sanitize_title($faqs_headline);
				
					echo '<h2 id="' . $id . '">' . $faqs_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $faqs_headline,
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
				$toc_key = array_key_last($toc);
				foreach ($section_faq['faqs'] as $key => $faq) {
					if (empty($faq['question']['value'])) {
						continue;
					}
					
					$faq_child_headline = twtheme_get_value($faq['question']);
					$id = sanitize_title($faq_child_headline);
					
					$toc[$toc_key]['childs'][] = [
						'id' => $id,
						'title' => $faq_child_headline,
					];
					
					echo '<h3 id="' . $id .'">' . $faq_child_headline . '</h3>';
					
					if (!empty(twtheme_get_value($faq['answer']))) {
						echo wpautop(twtheme_get_value($faq['answer']));
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