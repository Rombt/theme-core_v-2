<?php
/**
 * Theme bootstrap
 *
 * @package my_theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme constants
 */
define( 'THEME_PATH', get_template_directory() );
define( 'THEME_URI', get_template_directory_uri() );

/**
 * Theme setup
 */
function theme_setup() {

	load_theme_textdomain(
		'my_theme',
		THEME_PATH . '/languages'
	);

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'block-templates' );

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
}
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Theme core bootstrap
 */
require_once THEME_PATH . '/core/class-core.php';

// todo перенести в core как часть dev режима
// !!!!  только на время разработки!!!
add_action(
	'admin_init',
	function () {
		wp_deregister_script( 'autosave' );
	}
);
