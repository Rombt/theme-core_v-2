<?php
/**
 * Gutenberg blocks registration
 *
 * @package ThemeCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Blocks
 *
 * Handles theme blocks registration.
 */
final class Blocks {

	/**
	 * Инициализация
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_blocks' ) );
	}

	/**
	 * Регистрация всех блоков темы
	 */
	public static function register_blocks() {

		$blocks_dir = THEME_PATH . '/blocks';

		if ( ! is_dir( $blocks_dir ) ) {
			return;
		}

		$dirs = array_filter(
			scandir( $blocks_dir ),
			function ( $dir ) {
				return '.' !== $dir && '..' !== $dir;
			}
		);

		sort( $dirs );

		foreach ( $dirs as $block ) {

			$block_path = $blocks_dir . '/' . $block;
			$block_json = $block_path . '/block.json';

			if ( ! is_dir( $block_path ) || ! file_exists( $block_json ) ) {
				continue;
			}

			// Добавляем namespace темы к slug.
			$block_data = json_decode( file_get_contents( $block_json ), true );
			if ( isset( $block_data['name'] ) ) {
				$block_data['name'] = 'mytheme/' . basename( $block_data['name'] );
				file_put_contents( $block_json, wp_json_encode( $block_data, JSON_PRETTY_PRINT ) );
			}

			register_block_type( $block_path );
		}
	}
}

Blocks::init();
