<?php

if (have_posts()) :
    while (have_posts()) :
        the_post();
        ?>

        @slot_1

        <?php
    endwhile;

    the_posts_navigation();
else :
    ?>

    @slot_2

    <?php
endif;
