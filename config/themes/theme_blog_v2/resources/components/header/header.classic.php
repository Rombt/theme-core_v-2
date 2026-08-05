<?php

/**
 * Header
 *
 * Defines the overall site header structure.
 */

declare(strict_types=1);

?><!DOCTYPE html>
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

        <!-- @slot_1 -->

        <!-- @slot_2 -->

    </div>

</header>
