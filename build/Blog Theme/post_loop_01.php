<?php

declare(strict_types=1);

if (have_posts()) :
    while (have_posts()) :
        the_post();

        ?>

        <?php get_template_part('post_title_01'); ?>

        <?php
    endwhile;

    the_posts_navigation();
else :
    ?>

    <?php get_template_part('no_posts_01'); ?>

    <?php
endif;
