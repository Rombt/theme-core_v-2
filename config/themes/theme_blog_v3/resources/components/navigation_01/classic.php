<?php

/**
 * Primary Navigation
 *
 * Displays the primary site navigation.
 */

if (has_nav_menu('primary')) :
    ?>

    <nav class="primary-navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'theme'); ?>">

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
?>
