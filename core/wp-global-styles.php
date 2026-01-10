<?php
/**
 * Overrides WordPress global styles.
 *
 * Removes default global styles and adds custom global styles for front-end and editor.
 *
 * @package ThemeCore
 */

add_action(
	'init',
	function () {

		remove_action(
			'wp_enqueue_scripts',
			'wp_enqueue_global_styles'
		);

		remove_action(
			'wp_footer',
			'wp_enqueue_global_styles',
			1
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_register_style( 'engine-wp-layer', false );
		wp_enqueue_style( 'engine-wp-layer' );

		$layered_css = "@layer wp {\n" . wp_get_global_stylesheet() . "\n}";
		wp_add_inline_style( 'engine-wp-layer', $layered_css );
	},
	0
);

add_action(
	'enqueue_block_editor_assets',
	function () {

		remove_action(
			'enqueue_block_editor_assets',
			'wp_enqueue_global_styles'
		);

		remove_action(
			'enqueue_block_editor_assets',
			'wp_enqueue_global_styles_custom_css'
		);

		$css = wp_get_global_stylesheet();

		if ( empty( $css ) ) {
			return;
		}

		wp_register_style(
			'engine-wp-layer-editor',
			false,
			array(),
			null
		);

		wp_enqueue_style( 'engine-wp-layer-editor' );

		wp_add_inline_style(
			'engine-wp-layer-editor',
			"@layer wp {\n{$css}\n}"
		);
	},
	0
);
