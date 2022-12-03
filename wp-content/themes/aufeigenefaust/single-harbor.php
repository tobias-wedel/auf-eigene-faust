<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header('harbor');

$post_id = get_the_ID();

$post_meta_data = new TwthemeGetPostMeta($post_id);
$post_meta = $post_meta_data->get_post_meta();
$options = get_option('twtheme_harbor_options');
$title = get_the_title($post_id);
$toc = [];
$map = [];
set_query_var('map', $map);
set_query_var('toc', $toc);

ob_start();
get_template_part('template-parts/harbor/about', '', $post_meta_data);
get_template_part('template-parts/harbor/mobility', '', $post_meta_data);
get_template_part('template-parts/harbor/highlights', '', $post_meta_data);
get_template_part('template-parts/harbor/activity', '', $post_meta_data);
get_template_part('template-parts/harbor/locals', '', $post_meta_data);
get_template_part('template-parts/harbor/faq', '', $post_meta_data);
get_template_part('template-parts/harbor/affiliates', '', $post_meta_data);
$template_parts .= ob_get_contents();
ob_end_clean();

// TOC
$map = get_query_var('map', $map);
$toc = get_query_var('toc', $toc);
set_query_var('map', false);
set_query_var('toc', false);
?>
<nav id="toc-scroller" class="navbar navbar-expand bg-white sticky-top justify-content-center border-bottom p-0">
	<ul class="nav navbar-nav">
		<li class="nav-item"><a class="nav-link active" href="#einleitung">Einleitung</a></li>
		<li class="nav-item"><a class="nav-link" href="#inhaltsverzeichnis">Inhalt</a></li>
		<?php
			foreach ($toc as $chapter) {
				echo '<li class="nav-item"><a class="nav-link" href="#' . $chapter['id'] . '">' . $chapter['short'] . '</a></li>';
			}
		?>
	</ul>
</nav>

<?php
$section_prolog = $post_meta_data->get_section('prolog');
if ($section_prolog) :
?>
<section id="einleitung" class="pt-spacer">
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
	<div class="container pt-spacer">
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<?php
				echo twtheme_map($map, ['zoom' => '14', 'wrapper-class' => 'ratio ratio-16x9']);
				?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
<section id="inhaltsverzeichnis">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="bg-gray-100 p-gutter bg-light mb-spacer">
					<div class="row">
						<div class="col-lg-8 m-auto">
							<div class="py-6 px-gutter">
								<h2>Inhaltsverzeichnis</h2>
								<ol class="toc">
									<?php
								foreach ($toc as $chapter) {
									echo '<li><a href="#' . $chapter['id'] . '">' . $chapter['title'] . '</a>';
									
									if (isset($chapter['childs'])) {
										echo '<ol>';
										
										foreach ($chapter['childs'] as $child_chapter) {
											echo '<li><a href="#' . $child_chapter['id'] . '">' . $child_chapter['title'] . '</a></li>';
										}
										
										echo '</ol>';
									}
									echo '</li>';
								}
								?>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php echo $template_parts; ?>
<?php
get_footer();
