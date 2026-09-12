<?php

if (have_posts()):
    while (have_posts()):
        the_post(); ?>

    <?php get_template_part('post/post-title-01'); ?>

<?php
    endwhile;

    the_posts_navigation();
else:
     ?>

    <?php get_template_part('common/no-posts-01'); ?>

    <?php
endif;
