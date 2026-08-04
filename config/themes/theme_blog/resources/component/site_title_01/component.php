<?php

/**
 * Site Title
 *
 * Отображает название сайта.
 */

declare(strict_types=1);

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
