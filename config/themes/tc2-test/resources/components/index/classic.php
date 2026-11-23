<?php

/**
 * Classic Basic index template body.
 * Header and footer are separate Theme Core compositions and are
 * inserted through the standard Classic WordPress template calls.
 */
?>
@slot_1

<main>
    <div class="wrapper-section">
        <div class="rmbt-full-width rmbt-blog-full-width">
            <section class="rmbt-container rmbt-blog welcome">
                <div class="rmbt-blog__row">
                    <header class="page-header"></header>
                    <div class="rmbt-blog__col">
                        <div class="welcome__content">
                            <span class="welcome__version">Version 0.1.0</span>
                            <h1 class="welcome__title">Welcome to Classic Basic!</h1>
                            <p class="welcome__description">
                                Your WordPress theme development starts here. A clean foundation, ready for your ideas.
                            </p>
                        </div>
                        <?php echo get_icon_svg('cart'); ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

@slot_10
