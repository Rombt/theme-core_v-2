<?php

/**
 * Hero Navigation
 *
 * Отображает меню Hero-блока сайта.
 */

declare(strict_types=1);

if (has_nav_menu('hero')) :
    ?>

    <nav
        class="hero-navigation"
        aria-label="<?php esc_attr_e('Hero Navigation', 'theme'); ?>"
    >

        <?php
        wp_nav_menu([
            'theme_location' => 'hero',
            'container'      => false,
            'menu_class'     => 'menu',
            'fallback_cb'    => false,
        ]);
        ?>

    </nav>

    <?php
endif;
