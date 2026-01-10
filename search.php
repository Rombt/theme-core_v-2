<?php
/**
 * Template for search results
 *
 * @package theme-core
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
	<div class="wp-site-blocks">
		<h1><?php printf( esc_html__( 'Search results for: %s', 'theme-core' ), get_search_query() ); ?></h1>

		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<h2>
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					</h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found.', 'theme-core' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
