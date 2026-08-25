<?php

/**
 * Widget Area
 *
 * Отображает основную область виджетов.
 */

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
