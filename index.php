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

		<?php echo get_icon_svg( '7x24h-svgrepo-com' ); ?>
		<?php echo get_icon_svg( 'port-detection-svgrepo-com' ); ?>
		<?php echo get_icon_svg( 'donuts-cake-svgrepo-com' ); ?>
		<?php echo get_icon_svg( 'hat-chef-svgrepo-com' ); ?>



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
