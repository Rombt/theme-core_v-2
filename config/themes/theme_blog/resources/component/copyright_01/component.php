<?php

/**
 * Copyright
 *
 * Отображает информацию об авторских правах.
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
