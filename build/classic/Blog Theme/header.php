<?php

/**
 * Site Title
 *
 * Displays the site title.
 */

$tag = is_front_page() && is_home()
    ? 'h1'
    : 'p';

?>

<<?php echo esc_html($tag); ?> class="wp-block-site-title my-custom-class">

    <a
        href="<?php echo esc_url(home_url('/')); ?>"
        rel="home"
    >
        <?php bloginfo('name'); ?>
    </a>

</<?php echo esc_html($tag); ?>>


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
