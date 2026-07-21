<?php

/**
 * Primary Navigation
 *
 * Отображает основное меню сайта.
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
