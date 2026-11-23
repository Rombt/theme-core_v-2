<?php if (has_nav_menu('header_nav')) : ?>
    <div class="rmbt-menu-horizontal">
        <?php
        wp_nav_menu([
            'theme_location' => 'header_nav',
            'container' => 'nav',
        ]);
        ?>
    </div>
<?php endif; ?>
