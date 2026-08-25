<?php

/**
 * Footer Navigation
 *
 * Displays the site footer navigation.
 */

if (has_nav_menu('footer')) :
    ?>

    <nav
        class="footer-navigation"
        aria-label="<?php esc_attr_e('Footer Navigation', 'theme'); ?>"
    >

        <?php
        wp_nav_menu([
            'theme_location' => 'footer',
            'container'      => false,
            'menu_class'     => 'menu',
            'fallback_cb'    => false,
        ]);
        ?>

    </nav>

    <?php
endif;
