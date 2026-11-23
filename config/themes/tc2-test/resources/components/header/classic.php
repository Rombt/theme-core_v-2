<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div class="rmbt-page-wrap">
        <div class="rmbt-full-width rmbt-hero-block-1-full-width">
            <section class="rmbt-container rmbt-hero-block-1-top-row">
                <div class="rmbt-hero-block-1-top-row__row rmbt-hero-block-1-top-row">
                    <div class="rmbt-hero-block-1-top-row__col rmbt-hero-block-1-top-row-col-left">
                        @slot_1
                    </div>
                    <div class="rmbt-hero-block-1-top-row__col rmbt-hero-block-1-top-row-col-center">
                        @slot_2
                    </div>
                </div>
            </section>
        </div>
