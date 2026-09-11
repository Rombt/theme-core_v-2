<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header
    id="masthead"
    class="site-header"
>

    <div class="site-header__inner">

        /**
 * Site Title
 *
 * Displays the site title.
 */

$tag = is_front_page() && is_home()
    ? 'h1'
    : 'p';

?>

<<?php 
echo esc_html($tag);
?> class="wp-block-site-title my-custom-class">

    <a
        href="<?php 
echo esc_url(home_url('/'));
?>"
        rel="home"
    >
        <?php 
bloginfo('name');
?>
    </a>

</<?php 
echo esc_html($tag);
?>>
?>

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
?>

    </div>

</header>
?>