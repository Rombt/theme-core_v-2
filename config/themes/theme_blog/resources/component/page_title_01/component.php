<?php

/**
 * Page Title
 *
 * Отображает заголовок текущей страницы.
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
