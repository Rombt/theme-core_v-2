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

	private static $manifest_file_path = 'core/manifest.json';

	private static $manifest        = array();
	private static $categories_data = array();


	/**
	 * Инициализация
	 */
	public static function init() {

		self::get_manifest();

		$file_categories = THEME_PATH . '/src/blocks/block-categories.json';
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

			if ( isset( $block_data['category'] ) ) {

				// TODO придумать что то лучше!!
				$block_category = strtolower( str_replace( THEME_NAME . '-', '', $block_data['category'] ) );

				$block_data['category'] = THEME_NAME . '-' . $block_category;

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

			// if ( ! self::validate_block_category( $block_data ) ) {
			// continue;
			// }

			add_filter(
				'block_type_metadata',
				function ( $metadata ) use ( $block_data ) {

					if ( isset( $metadata['name'] ) && $block_data['name'] === $metadata['name'] ) {
						if ( isset( $metadata['editorScript'] ) ) {
							$metadata['editorScript'] = self::get_block_asset( $metadata['editorScript'], $metadata['file'] );
						}
						if ( isset( $metadata['editorStyle'] ) ) {
							$metadata['editorStyle'] = self::get_block_asset( $metadata['editorStyle'], $metadata['file'] );
						}
					}

					return $metadata;
				}
			);

			register_block_type( $block_path );

		}
	}


	public static function get_block_asset( string $editor, string $file ): string {

		$pathinfo_editor = pathinfo( str_replace( 'file:./', '', $editor ) );
		$ext_editor      = $pathinfo_editor['extension'];

		if ( 'js' === $ext_editor ) {
			$ext = 'jsx';
		} elseif ( 'css' === $ext_editor ) {
			$ext = 'scss';
		}

		$filename       = $pathinfo_editor['filename'];
		$dir_block_name = basename( dirname( $file ) );
		$key            = 'blocks/' . $dir_block_name . '/' . $filename . '.' . $ext;

		if ( ! isset( self::$manifest[ $key ]['file'] ) ) {

			return $editor;
		}
		$pathinfo_file = pathinfo( self::$manifest[ $key ]['file'] );

		return 'file:./' . $pathinfo_file['filename'] . '.' . $pathinfo_file['extension'];
	}


	public static function get_manifest() {

		if ( ! self::$manifest ) {
			$path           = get_theme_file_path( self::$manifest_file_path );
			self::$manifest = file_exists( $path )
			? json_decode( file_get_contents( $path ), true )
			: array();
		}
	}






















	// public static function manifest_resolve() {

	// if ( ! self::$manifest ) {
	// self::$manifest = json_decode(
	// file_get_contents( get_theme_file_path( self::$manifest_file_path ) ),
	// true
	// );
	// }

	// self::$manifest_file_path = str_replace( 'file:./', '', self::$manifest_file_path );

	// return get_theme_file_uri(
	// self::$manifest[ self::$manifest_file_path ]['file'] ?? self::$manifest_file_path
	// );
	// }
}

Blocks::init();
