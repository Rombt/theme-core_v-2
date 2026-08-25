<?php

/**
 * Hero Navigation
 *
 * Displays the site hero navigation.
 */

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
