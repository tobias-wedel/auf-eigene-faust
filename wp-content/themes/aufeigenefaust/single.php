<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php

			/* Start the Loop */
			while (have_posts()) :
				the_post();

				the_content();

				// If comments are open or we have at least one comment, load up the comment template.
				if (comments_open() || get_comments_number())
				{
					comments_template();
				}

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->
<?php
get_footer();
