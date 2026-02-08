<?php
defined( 'ABSPATH' ) || exit;

/**
 * Dynamic Button Block render template
 *
 * Available variables:
 *
 * @var array    $attributes
 * @var string   $content
 * @var WP_Block $block
 */

// 1. Нормализация атрибутов
$text   = isset( $attributes['text'] ) ? trim( $attributes['text'] ) : '';
$url    = isset( $attributes['url'] ) ? trim( $attributes['url'] ) : '';
$target = $attributes['target'] ?? '_self';
$rel    = $attributes['rel'] ?? '';
$style  = $attributes['style'] ?? 'primary';
$align  = $attributes['align'] ?? '';

// 2. Защитные условия
// if ( $text === '' || $url === '' ) {
// return '';
// }


// 3. Классы блока (через WP API)
$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => trim(
			implode(
				' ',
				array_filter(
					array(
						'wp-block-my-button',
						'is-style-' . $style,
						$align ? 'align' . $align : '',
					)
				)
			)
		),
	)
);
?>

<div <?php echo $wrapper_attributes; ?>>
	<a
		href="<?php echo esc_url( $url ); ?>"
		class="wp-block-my-button__link"
		target="<?php echo esc_attr( $target ); ?>"
		<?php echo $rel ? 'rel="' . esc_attr( $rel ) . '"' : ''; ?>
	>
		<?php echo esc_html( $text ); ?>
	</a>
</div>
