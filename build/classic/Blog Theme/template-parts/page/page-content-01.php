<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php the_content(); ?>

    <?php
    wp_link_pages([
        'before' => '<nav class="page-links">',
        'after'  => '</nav>',
    ]);
?>

</article>
