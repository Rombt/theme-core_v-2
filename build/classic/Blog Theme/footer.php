<?php

/**
 * Footer
 *
 * Displays the site footer.
 */

?>

<footer class="site-footer">
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

    <?php

/**
 * Copyright
 *
 * Displays site copyright information.
 */

?>

<p class="site-copyright">

    &copy;
    <?php echo esc_html(wp_date('Y')); ?>

    <a href="<?php echo esc_url(home_url('/')); ?>">
        <?php bloginfo('name'); ?>
    </a>

    <?php esc_html_e('All rights reserved.', 'theme'); ?>

</p>

</footer>
