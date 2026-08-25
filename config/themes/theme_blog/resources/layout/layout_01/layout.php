<?php

/**
 * Main Layout
 *
 * Базовый layout темы.
 *
 * Отвечает только за общую структуру страницы
 * и не содержит контентных компонентов.
 *
 * Elementor управляет содержимым области <main>.
 */

//

// get_header();

?>

<main id="primary" class="site-main">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
    ?>
</main>

<?php

get_footer();
