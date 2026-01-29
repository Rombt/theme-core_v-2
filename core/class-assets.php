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


	protected static array $static_assets = array(
		'styles'  => array(
			'fonts' => '/assets/css/fonts.css',
		),
		'scripts' => array(),
	);

	public static function enqueue_static_assets() {

		// Styles
		foreach ( self::$static_assets['styles'] ?? array() as $handle => $path ) {
			if ( file_exists( get_theme_file_path( $path ) ) ) {
				wp_enqueue_style(
					THEME_NAME . '-static-' . $handle,
					get_theme_file_uri( $path ),
					array(),
					null
				);
			}
		}

		// Scripts
		foreach ( self::$static_assets['scripts'] ?? array() as $handle => $path ) {
			if ( file_exists( get_theme_file_path( $path ) ) ) {
				wp_enqueue_script(
					THEME_NAME . '-static-' . $handle,
					get_theme_file_uri( $path ),
					array(),
					null,
					true
				);
			}
		}
	}


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
			} else {
				throw new \InvalidArgumentException( 'Проблемы с файлом манифеста  ' . self::$manifest_path );
			}
		}

		add_action( 'wp_enqueue_scripts', array( self::class, 'enqueue_static_assets' ), 5 );
		add_action( 'wp_enqueue_scripts', array( self::class, 'enqueue_front_assets' ) );
		add_action( 'enqueue_block_editor_assets', array( self::class, 'enqueue_editor_assets' ) );
	}

	private static function enqueue_asset() {
		global $template;
		self::$resolved_template = $template;

		if ( is_admin() ) {
			$manifest_keys_glob_style = self::find_manifest_entries( 'editor' );
			self::enqueue_assets_from_manifest( $manifest_keys_glob_style );
		} else {
			$manifest_keys_glob_style = self::find_manifest_entries( 'front' );
			self::enqueue_assets_from_manifest( $manifest_keys_glob_style );
		}

			$name          = basename( self::$resolved_template, '.php' );
			$manifest_keys = self::find_manifest_entries( $name );
			self::enqueue_assets_from_manifest( $manifest_keys );
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
	 * Enqueue theme assets described in build manifest.
	 *
	 * Accepts an array of manifest entries and enqueues all supported assets
	 * (currently CSS and JS) that exist in the theme directory.
	 *
	 * @param array $manifest_keys Array of manifest entries. Each entry must contain 'file' key.
	 *
	 * @return void
	 */
	public static function enqueue_assets_from_manifest( $manifest_keys ) {

		foreach ( $manifest_keys as $i => $asset ) {

			if ( empty( $asset['file'] ) || ! is_string( $asset['file'] ) ) {
				continue;
			}

			$path_info_asset = pathinfo( $asset['file'] );
			$path_asset      = str_replace( '\\', '/', $asset['file'] );
			$handle_asset    = THEME_NAME . '-' . sanitize_title( str_replace( '/', '-', $path_asset ) );
			if ( str_contains( $path_asset, '..' ) ) {
				continue;
			}

			if ( file_exists( get_theme_file_path( $path_asset ) ) ) {
				if ( $path_info_asset['extension'] === 'css' ) {
					wp_enqueue_style( $handle_asset, get_theme_file_uri( $path_asset ) );
				} elseif ( $path_info_asset['extension'] === 'js' ) {
					wp_enqueue_script( $handle_asset, get_theme_file_uri( $path_asset ) );
				}
			}
		}
	}

	/**
	 * Find first manifest entry whose key contains a given substring.
	 *
	 * @param string $contains Substring to search for in manifest keys.
	 *
	 * @return array|null Manifest entry if found, null otherwise.
	 */
	public static function find_manifest_entries( string $contains ): ?array {

		$result = array();

		foreach ( self::$manifest_json as $key => $value ) {
			if ( pathinfo( $key, PATHINFO_FILENAME ) === $contains ) {
				$result[] = $value;
			}
		}

		return $result;
	}
}


Assets::init();
