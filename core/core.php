<?php

/**
 * Theme Core Bootstrap
 *
 * Центральная точка инициализации темы.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class MyTheme_Core {

	/**
	 * Инициализация ядра
	 */
	public static function init() {

		self::define_constants();
		self::load_files();
		self::register_hooks();
	}

	/**
	 * Константы путей и версий
	 */
	private static function define_constants() {

		define( 'MYTHEME_PATH', get_template_directory() );
		define( 'MYTHEME_URI', get_template_directory_uri() );
		define( 'MYTHEME_CORE_PATH', MYTHEME_PATH . '/core' );
		define( 'MYTHEME_VERSION', wp_get_theme()->get( 'Version' ) );
	}

	/**
	 * Подключение файлов ядра
	 */
	private static function load_files() {

		require_once MYTHEME_CORE_PATH . '/helpers.php';
		require_once MYTHEME_CORE_PATH . '/assets.php';
		require_once MYTHEME_CORE_PATH . '/blocks.php';
		require_once MYTHEME_CORE_PATH . '/wp-global-styles.php';
	}

	/**
	 * Регистрация хуков
	 */
	private static function register_hooks() {

		add_action( 'after_setup_theme', array( __CLASS__, 'setup_theme' ) );
	}

	/**
	 * Базовая настройка темы
	 */
	public static function setup_theme() {

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );

		add_editor_style( 'dist/editor.css' );
	}
}


// Запуск ядра
MyTheme_Core::init();
