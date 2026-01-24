<?php
/**
 * Assets loader.
 *
 * Handles enqueuing theme front-end and editor assets.
 *
 * @package ThemeCore
 */

defined( 'ABSPATH' ) || exit;


/**
 * Class Assets
 *
 * Handles theme assets loading.
 */
final class Assets {

	/**
	 * Path to Vite manifest file.
	 *
	 * @var string
	 */
	private static $manifest_path     = THEME_PATH . '/core/manifest.json';
	private static $manifest_json     = array();
	private static $resolved_template = '';

	/**
	 * Initializes the assets by hooking into WordPress actions.
	 *
	 * @return void
	 */
	public static function init() {

		if ( is_readable( self::$manifest_path ) ) {
			$manifest_content = file_get_contents( self::$manifest_path );

			if ( false !== $manifest_content ) {
				$decoded = json_decode( $manifest_content, true );
				if ( is_array( $decoded ) ) {
					self::$manifest_json = $decoded;
				}
			}
		}

		if ( empty( self::$manifest_json ) ) {
			throw new \InvalidArgumentException( 'Проблемы с файлом манифеста  ' . self::$manifest_path );
		}

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_front_assets' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_editor_assets' ) );
	}

	private static function enqueue_asset() {

		global $template;
		self::$resolved_template = $template;

		if ( defined( 'THEME_DEV_MODE' ) && THEME_DEV_MODE ) {
			// $vite_url = 'http://localhost:5173';
			// $file     = str_replace( 'src/', '', $key ); // front.js / editor.js.
			// wp_enqueue_script( $handle, $vite_url . '/' . $file, array(), null, true );

			// // Важно: чтобы работали import.meta.glob и ESM.
			// add_filter(
			// 'script_loader_tag',
			// function ( $tag, $handle_name ) use ( $handle ) {
			// if ( $handle_name === $handle ) {
			// $tag = str_replace( '<script ', '<script type="module" ', $tag );
			// }
			// return $tag;
			// },
			// 10,
			// 2
			// );

			// return;
		} else {
			$name         = basename( self::$resolved_template, '.php' );
			$manifest_key = self::find_manifest_entry( self::$manifest_json, $name );
			$name_style   = basename( $manifest_key['file'], '.css' );
			$handle_style = THEME_NAME . '-' . sanitize_title( $name );
			$path_style   = '/assets/styles/pages/' . $name_style . '.css';

			if ( file_exists( get_theme_file_path( $path_style ) ) ) {
				wp_enqueue_style( $handle_style, get_theme_file_uri( $path_style ) );
			}
		}
	}

	/**
	 * Enqueues front-end assets for the theme.
	 *
	 * @return void
	 */
	public static function enqueue_front_assets() {
		self::enqueue_asset();
	}

	/**
	 * Enqueues editor (block editor) assets for the theme.
	 *
	 * @return void
	 */
	public static function enqueue_editor_assets() {
		self::enqueue_asset();
	}

	/**
	 * Find first manifest entry whose key contains a given substring.
	 *
	 * @param array  $manifest_json Manifest array (e.g. Vite build manifest).
	 * @param string $contains Substring to search for in manifest keys.
	 *
	 * @return array|null Manifest entry if found, null otherwise.
	 */
	public static function find_manifest_entry( array $manifest_json, string $contains ): ?array {

		foreach ( $manifest_json as $key => $value ) {
			if ( strpos( $key, $contains ) !== false ) {
				return $value;
			}
		}
		return null;
	}
}


Assets::init();
