<?php

// Exit if accessed directly.
defined('ABSPATH') || exit();

get_header('base');

$post_id = get_the_ID();

$post_meta_data = new TwthemeGetPostMeta($post_id);
$post_meta = $post_meta_data->get_post_meta();
$options = get_option('twtheme_harbor_options');
$title = get_the_title($post_id);
$toc = [];
$full_map = [];
$html = '';
?>

<header class="cinematic">
	<?php the_post_thumbnail() ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<?php
				$title = get_the_title();
				$title_count_chars = strlen($title);
				$title_class  = '';
				if ($title_count_chars > 16) {
					$title_class = 'xxl';
				} elseif ($title_count_chars > 9) {
					$title_class = 'lg';
				}
				?>
				<h1 class="text-uppercase display-1"><span class="<?= $title_class ?>"><?= $title ?></span> <span class="display-5">auf eigene Faust</span></h1>
			</div>
		</div>
	</div>
</header>
<?php
$section_prolog = $post_meta_data->get_section('prolog');
if ($section_prolog) :
?>
<section id="einleitung" class="py-spacer">
	<div class="container">
		<?php if ($section_prolog['prolog']['value']) : ?>
		<div class="row">
			<div class="col-6 m-auto">
				<?php
				$gallery = do_shortcode('[splide images="' . $section_prolog['gallery']['value'] . '" thumbnails="true" title="Galerie über ' . $title . '" id="' . $title . '" caption="true" class="mx-ngutter"]');
				$prolog = wpautop($section_prolog['prolog']['value']);
				
				// Add gallery to prolog after first paragraph
				if (!empty($section_prolog['gallery']['value'])) {
					$prolog = preg_replace('/(.*?)\n/', '$1' . $gallery, $prolog, 1);
				}
				
				echo $prolog;?>
			</div>
		</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-6 m-auto">
				<?php
					$harbor_quickinfos = $post_meta_data->get_group('harbor-quick-infos');
					
					if ($harbor_quickinfos) : ?>
				<div class="bg-gray-100 p-gutter bg-light mx-ngutter mt-spacer">
					<ul class="icon-list" style="--columns: 3">
						<?php
					foreach ($harbor_quickinfos as $name => $quickinfo) {
						if (!empty($quickinfo['value'])) {
							$value = '';
							switch ($name) {
								case 'country':
									$icon = 'location-dot';
									$value .= data_countries($quickinfo['value']);
									break;
								case 'language':
									$icon = 'comments';
									foreach ($quickinfo['value'] as $language) {
										$value .= data_languages($language);
									}
									break;
								case 'currency':
									$icon = 'money-bill';
									$value .= data_currencies($quickinfo['value']);
									break;
								case 'season':
									$icon = 'calendar-range';
									$value .= $quickinfo['value'];
									break;
								case 'visa':
									$icon = 'passport';
									$value .= $quickinfo['value'];
									break;
								default:
									$icon = 'circle-small';
									$value .= $quickinfo['value'];
									break;
							}
							echo '<li class="' . $name . '"><i class="fal fa-' . $icon .'"></i><strong class="d-block">' . $quickinfo['label'] . '</strong>' . $value;
							echo '</li>';
						}
					}
					?>
					</ul>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
<?php ob_start(); ?>
<?php $section_harbor = $post_meta_data->get_section('about'); ?>
<?php if ($section_harbor) : ?>
<section id="einleitung" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
					$harbor_headline = sprintf(twtheme_get_value($section_harbor['headline']), $title);
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
				
				$full_map[] = $harbor_map_data;
				echo twtheme_map($harbor_map_data, ['zoom' => '14', 'wrapper' => false]);
				?>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col-6 m-auto">
				<?php
				echo wpautop(twtheme_get_value($section_harbor['text']));
				$harbor_arrivals = $post_meta_data->get_group('harbor-arrivals');
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
									'title' => twtheme_get_title($arrival[$key . '-address']),
									'icon' => $options['icons'][$key . '-icon'],
									'color' => $options['icons'][$key . '-color'],
								];
								
								$full_map[] = $arrival_map_data;
								echo twtheme_map($arrival_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
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
<?php endif; ?>
<?php $section_mobility = $post_meta_data->get_section('mobility'); ?>
<?php if ($section_mobility) : ?>
<section id="mobilitaet" class="py-spacer">
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
				<?php
					$mobility_headline = sprintf(twtheme_get_value($section_mobility['headline']), $title);
					$id = sanitize_title($mobility_headline);
				
					echo '<h2 id="' . $id . '">' . $mobility_headline . '</h2>';
				
					$toc[] = [
						'id' => $id,
						'title' => $mobility_headline,
					];
				?>
			</div>
		</div>
	</div>
	<hr>
	<?php $mobilities = $post_meta_data->get_group('mobility'); ?>
	<?php if ($mobilities) : ?>
	<div class="container">
		<div class="row">
			<div class="col-6 m-auto">
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
					
					echo wpautop($mobility[$key]['value']);
					
					if (!empty($mobility[$key . '-image']['value'])) {
						echo '<div class="ratio ratio-16x11">' . wp_get_attachment_image($mobility[$key . '-image']['value'], 'medium-large') . '</div>';
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
						
						$full_map[] = $mobility_map_data;
						echo twtheme_map($mobility_map_data, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
					}
				}
				?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
<?php endif;


$html .= ob_get_contents();
ob_end_clean();
// TOC
?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-9 mx-auto">
				<div class="bg-gray-100 p-gutter bg-light mx-ngutter mt-spacer">
					<ol>
						<?php
						foreach ($toc as $chapter) {
							echo '<li><a href="#' . $chapter['id'] . '">' . $chapter['title'] . '</a></li>';
							
							if (isset($chapter['childs'])) {
								echo '<ol>';
								
								foreach ($chapter['childs'] as $child_chapter) {
									echo '<li><a href="#' . $child_chapter['id'] . '">' . $child_chapter['title'] . '</a></li>';
								}
								
								echo '</ol>';
							}
						}
						?>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<?php echo $html;?>