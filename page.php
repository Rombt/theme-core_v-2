<?php
/**
 * Template for pages
 *
 * @package theme-core
 */

defined( 'ABSPATH' ) || exit;
?>

<?php get_header(); ?>
<main id="primary" class="site-main">
	<!-- <div class="wp-site-blocks"> -->

	page.php

	************************************************
<?php


// global $post;
// error_log( 'POST ID: ' . $post->ID );
// error_log( $post->post_content );

?>

*************************************************


	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		endif;
	?>
	<!-- </div> -->
</main>
<?php get_footer(); ?>
