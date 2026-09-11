<?php

/**
 * Post Title
 *
 * Displays the title of the current post.
 */

if (is_singular()) :
    ?>

    <header class="entry-header">

        <h1 class="wp-block-post-title">
            <?php the_title(); ?>
        </h1>

    </header>

    <?php
endif;
