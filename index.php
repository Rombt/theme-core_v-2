<?php
/**
 * Main template file.
 *
 * @package theme-core
 */

defined( 'ABSPATH' ) || exit; ?>

<?php get_header(); ?>



<main id="primary" class="site-main">
	<div class="wp-site-blocks">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		endif;
		?>
	</div>
</main>

<?php get_footer(); ?>
