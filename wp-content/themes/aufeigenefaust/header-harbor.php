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
$map = [];
set_query_var('map', $map);
set_query_var('toc', $toc);
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
<?php
ob_start();

get_template_part('template-parts/harbor/about', '', $post_meta_data);
get_template_part('template-parts/harbor/mobility', '', $post_meta_data);
get_template_part('template-parts/harbor/highlights', '', $post_meta_data);
get_template_part('template-parts/harbor/activity', '', $post_meta_data);
get_template_part('template-parts/harbor/locals', '', $post_meta_data);

$template_parts .= ob_get_contents();
ob_end_clean();

// TOC
$map = get_query_var('map', $map);
$toc = get_query_var('toc', $toc);
set_query_var('map', false);
set_query_var('toc', false);
?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-9 mx-auto">
				<?php echo twtheme_map($map, ['zoom' => '16', 'wrapper-class' => 'ratio ratio-16x9']); ?>
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
<?php echo $template_parts; ?>