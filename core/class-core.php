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

	/**
	 * Инициализация ядра
	 */
	public static function init() {

		self::define_constants();
		self::load_files();
	}

	/**
	 * Константы ядра
	 */
	private static function define_constants() {

		if ( ! defined( 'THEME_CORE_PATH' ) ) {
			define( 'THEME_CORE_PATH', THEME_PATH . '/core' );
		}

		if ( ! defined( 'THEME_VERSION' ) ) {
			define( 'THEME_VERSION', wp_get_theme()->get( 'Version' ) );
		}

		// Enable development mode.
		if ( ! defined( 'THEME_DEV_MODE' ) ) {
			define( 'THEME_DEV_MODE', true );
		}
	}

	/**
	 * Подключение файлов ядра
	 */
	private static function load_files() {

		require_once THEME_CORE_PATH . '/helpers.php';
		require_once THEME_CORE_PATH . '/class-assets.php';
		require_once THEME_CORE_PATH . '/class-blocks.php';
		require_once THEME_CORE_PATH . '/wp-global-styles.php';
	}
}

Core::init();
