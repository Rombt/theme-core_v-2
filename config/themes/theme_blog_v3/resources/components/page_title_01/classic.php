<?php

/**
 * Page Title
 *
 * Displays the title of the current page.
 */

declare(strict_types=1);

if (is_page()) :
    ?>

    <header class="entry-header">

        <h1 class="wp-block-post-title">
            <?php the_title(); ?>
        </h1>

    </header>

    <?php
endif;
