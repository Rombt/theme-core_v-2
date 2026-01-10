<?php
/**
 * Hero block render
 *
 * @var array  $attributes Block attributes.
 * @var string $content    Block content (not used).
 * @var WP_Block $block    Block instance.
 */

if (! defined('ABSPATH')) {
    exit;
}

// Атрибуты
$title          = $attributes['title'] ?? '';
$text           = $attributes['text'] ?? '';
$background_id  = $attributes['backgroundImage'] ?? 0;

// Получаем URL фонового изображения
$background_url = '';
if ($background_id) {
    $image = wp_get_attachment_image_src($background_id, 'full');
    if ($image) {
        $background_url = $image[0];
    }
}

// CSS-классы блока
$classes = [
    'hero',
];

if (! empty($block->context['align'])) {
    $classes[] = 'align' . esc_attr($block->context['align']);
}
?>

<section
    class="<?php echo esc_attr(implode(' ', $classes)); ?>"
    <?php if ($background_url) : ?>
        style="background-image: url('<?php echo esc_url($background_url); ?>');"
    <?php endif; ?>
>
    <div class="hero__inner">
        <?php if ($title) : ?>
            <h1 class="hero__title">
                <?php echo esc_html($title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($text) : ?>
            <div class="hero__text">
                <?php echo wp_kses_post(wpautop($text)); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
