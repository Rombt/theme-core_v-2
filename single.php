<?php
/**
 * Template for single posts
 *
 * @package theme-core
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
	<div class="wp-site-blocks">
	single.php
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</main>
<?php get_footer(); ?>
