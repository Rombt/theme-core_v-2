<?php
/**
 * Template for 404 page
 *
 * @package theme-core
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
	<div class="wp-site-blocks">
		<h1>404</h1>
		<p><?php esc_html_e( 'Page not found.', 'theme-core' ); ?></p>
	</div>
</main>
<?php get_footer(); ?>
