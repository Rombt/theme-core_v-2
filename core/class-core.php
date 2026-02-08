<?php
/**
 * Theme core bootstrap file.
 *
 * Initializes theme core, defines constants and loads core files.
 *
 * @package ThemeCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Core
 *
 * Boots and initializes the theme core.
 */
final class Core {

	private static $theme_name;

	// private static $manifest_file_path = 'core/manifest.json';       // отключил потому что не нужен.

	/**
	 * Инициализация ядра
	 */
	public static function init() {

		self::$theme_name = self::get_theme_name_from_style();

		self::define_constants();
		self::load_files();
	}

	/**
	 * Константы ядра
	 */
	private static function define_constants() {

		// Enable development mode.
		// TODO брать это значение из wp-config.php.
		if ( ! defined( 'THEME_DEV_MODE' ) ) {
			define( 'THEME_DEV_MODE', true );
		}

		if ( ! defined( 'THEME_CORE_PATH' ) ) {
			define( 'THEME_CORE_PATH', THEME_PATH . '/core' );
		}

		if ( ! defined( 'THEME_VERSION' ) ) {
			define( 'THEME_VERSION', wp_get_theme()->get( 'Version' ) );
		}

		if ( ! defined( 'THEME_NAME' ) ) {
			define( 'THEME_NAME', self::$theme_name );
		}

		if ( ! defined( 'MANIFEST_JSON' ) ) {
			define( 'MANIFEST_JSON', self::get_manifest() );
		}
	}

	/**
	 * Подключение файлов ядра
	 */
	private static function load_files() {

		require_once THEME_CORE_PATH . '/helpers.php';
		require_once THEME_CORE_PATH . '/class-assets.php';
		require_once THEME_CORE_PATH . '/class-blocks.php';
		require_once THEME_CORE_PATH . '/wp-global-styles.php';     // todo что за стили, почему не через class-assets?
	}


	/**
	 * Получает Theme Name из style.css темы.
	 *
	 * @return string|null Название темы или null если не найдено.
	 */
	private static function get_theme_name_from_style() {

		$file_path = THEME_PATH . DIRECTORY_SEPARATOR . 'style.css';

		if ( ! file_exists( $file_path ) ) {
			return null;
		}

		$contents = file( $file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

		foreach ( $contents as $line ) {
			if ( stripos( $line, 'Theme Name:' ) === 0 ) {

				return strtolower( trim( substr( $line, strlen( 'Theme Name:' ) ) ) );
			}
		}

		return null;
	}


	private static function get_manifest() {

		$path = '';
		if ( ! empty( self::$manifest_file_path ) ) {
			$path = get_theme_file_path( self::$manifest_file_path );
		}

		if ( ! is_file( $path ) || ! is_readable( $path ) ) {
			return null;
		}

		$json = file_get_contents( $path );
		$data = json_decode( $json, true );

		return json_last_error() === JSON_ERROR_NONE
			? $data
			: null;
	}
}

Core::init();
