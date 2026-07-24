<?php

/**
 * Post Title
 *
 * Отображает заголовок текущей записи.
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
