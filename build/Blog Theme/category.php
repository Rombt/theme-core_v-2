<?php

/**
 * Site Title
 *
 * Displays the site title.
 */

declare(strict_types=1);

$tag = is_front_page() && is_home()
    ? 'h1'
    : 'p';

?>

<<?php echo esc_html($tag); ?> class="wp-block-site-title my-custom-class">

    <a
        href="<?php echo esc_url(home_url('/')); ?>"
        rel="home"
    >
        <?php bloginfo('name'); ?>
    </a>

</<?php echo esc_html($tag); ?>>

<?php

/**
 * Primary Navigation
 *
 * Displays the primary site navigation.
 */

declare(strict_types=1);

if (has_nav_menu('primary')) :
    ?>

    <nav
        class="primary-navigation"
        aria-label="<?php esc_attr_e('Primary Navigation', 'theme'); ?>"
    >

        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'menu',
            'fallback_cb'    => false,
        ]);
        ?>

    </nav>

    <?php
endif;

<?php

declare(strict_types=1);

get_header();

?>

<main id="primary" class="site-main">
    <?php

/**
 * Archive Title
 *
 * Displays the current archive title and description.
 */

declare(strict_types=1);

if (is_archive() || is_home() || is_search()) :
    ?>

    <header class="page-header">

        <h1 class="wp-block-query-title">
            <?php the_archive_title(); ?>
        </h1>

        <?php the_archive_description('<div class="archive-description">', '</div>'); ?>

    </header>

    <?php
endif;

    <?php

/**
 * Post Title
 *
 * Displays the title of the current post.
 */

declare(strict_types=1);

if (is_singular()) :
    ?>

    <header class="entry-header">

        <h1 class="wp-block-post-title">
            <?php the_title(); ?>
        </h1>

    </header>

    <?php
endif;

<?php

/**
 * No Posts
 *
 * Displays a message when no posts are available.
 */

declare(strict_types=1);

?>

<p class="no-posts">
    <?php esc_html_e('No posts found.', 'theme'); ?>
</p>

    <?php

/**
 * Widget Area
 *
 * Displays the primary widget area.
 */

declare(strict_types=1);

if (is_active_sidebar('primary-sidebar')) :
    ?>

    <aside
        class="widget-area"
        aria-label="<?php esc_attr_e('Sidebar', 'theme'); ?>"
    >

        <?php dynamic_sidebar('primary-sidebar'); ?>

    </aside>

    <?php
endif;

</main>

<?php

get_footer();

<?php

/**
 * Copyright
 *
 * Displays site copyright information.
 */

declare(strict_types=1);

?>

<p class="site-copyright">

    &copy;
    <?php echo esc_html(wp_date('Y')); ?>

    <a href="<?php echo esc_url(home_url('/')); ?>">
        <?php bloginfo('name'); ?>
    </a>

    <?php esc_html_e('All rights reserved.', 'theme'); ?>

</p>
