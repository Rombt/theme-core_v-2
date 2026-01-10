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

	private static $categories_data = array();

	/**
	 * Инициализация
	 */
	public static function init() {

		$file_categories = __DIR__ . '/../BlockCategories.json';
		if ( ! file_exists( $file_categories ) ) {
			trigger_error(
				sprintf(
					'File of categories block is absent to this path "%s"',
					$file_categories
				),
				E_USER_WARNING
			);
			return;
		}

		self::$categories_data = json_decode( file_get_contents( $file_categories ), true );

		self::register_categories();

		add_action( 'init', array( __CLASS__, 'register_blocks' ) );
	}


	/**
	 * Регистрирует кастомные категории блоков Gutenberg из JSON-файла.
	 *
	 * Загружает категории из '../BlockCategories.json' и добавляет их через фильтр
	 * 'block_categories_all'.
	 *
	 * @return void
	 */
	public static function register_categories() {

		if ( empty( self::$categories_data ) || ! is_array( self::$categories_data ) ) {
			return;
		}

		add_filter(
			'block_categories_all',
			function ( $categories ) {
				foreach ( self::$categories_data as $slug => $data ) {

					$category_slug = strtolower( str_replace( array( ' ', '_' ), '-', THEME_NAME ) ) . '-' . $slug;
					/* translators: %1$s = theme name, %2$s = category title */
					$category_title = __( sprintf( '%s – %s', THEME_NAME, $data['title'] ), THEME_NAME );

					if ( ! in_array( $category_slug, wp_list_pluck( $categories, 'slug' ), true ) ) {
						$categories[] = array(
							'slug'  => $category_slug,
							'title' => $category_title,
							'icon'  => $data['icon'] ?? 'admin-post',
						);
					}
				}
				return $categories;
			},
			10
		);
	}

	private static function validate_block_category( array $block_data ): bool {

		if ( empty( $block_data['category'] ) ) {
			trigger_error(
				sprintf( 'Block "%s" has no category defined.', $block_data['name'] ),
				E_USER_WARNING
			);
			return false;
		}

		if ( ! isset( self::$categories_data[ $block_data['category'] ] ) ) {
			trigger_error(
				sprintf(
					'Block "%s" uses undefined category "%s".',
					$block_data['name'],
					$block_data['category']
				),
				E_USER_WARNING
			);
			return false;
		}

		return true;
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

		error_log( '$dirs = ' . print_r( $dirs, true ) );        // !!--!!

		foreach ( $dirs as $block ) {

			$block_path = $blocks_dir . '/' . $block;
			$block_json = $block_path . '/block.json';

			if ( ! is_dir( $block_path ) || ! file_exists( $block_json ) ) {
				continue;
			}

			$file_contents = file_get_contents( $block_json );
			if ( $file_contents === false ) {
				error_log( "Cannot read block.json: $block_json" );
				continue;
			}
			$block_data = json_decode( $file_contents, true );
			if ( json_last_error() !== JSON_ERROR_NONE ) {
				error_log( "JSON error in $block_json: " . json_last_error_msg() );
				continue;
			}
			if ( ! is_array( $block_data ) ) {
				error_log( "Block data is not an array in $block_json" );
				continue;
			}

			// Добавляем namespace темы к slug.
			// не вручную для того что бы блоки переносились бы в другие темы простым копированием папок.
			if ( isset( $block_data['name'] ) ) {

				$block_name = strtolower( basename( $block_data['name'] ) );
				$block_name = preg_replace( '#[\\\\/]#', '', $block_name );
				$block_name = preg_replace( '/[^a-z0-9]+/', '-', $block_name );
				$block_name = trim( $block_name, '-' );

				$block_data['name'] = THEME_NAME . '/' . $block_name;
				file_put_contents( $block_json, wp_json_encode( $block_data, JSON_PRETTY_PRINT ) );
			}

			if ( ! self::validate_block_category( $block_data ) ) {
				continue;
			}

			error_log( '$block_path = ' . print_r( $block_path, true ) );        // !!--!!

			register_block_type( $block_path );
		}
	}
}

Blocks::init();
