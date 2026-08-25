<?php

declare(strict_types=1);

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

    <?php get_template_part('post_loop_01'); ?>
    <?php get_sidebar(); ?>
</main>

<?php
