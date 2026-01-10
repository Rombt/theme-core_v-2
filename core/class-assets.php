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
	private static $manifest_path = THEME_PATH . '/dist/manifest.json';

	/**
	 * Initializes the assets by hooking into WordPress actions.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_front_assets' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_editor_assets' ) );
	}

	/**
	 * Enqueues a front-end or editor asset.
	 *
	 * Loads JS and CSS either from Vite dev server or from the manifest file.
	 *
	 * @param string $handle Handle for the script or style.
	 * @param string $key    Path/key in manifest or dev server.
	 *
	 * @return void
	 */
	private static function enqueue_asset( $handle, $key ) {

		if ( defined( 'THEME_DEV_MODE' ) && THEME_DEV_MODE ) {
			$vite_url = 'http://localhost:5173';
			$file     = str_replace( 'src/', '', $key ); // front.js / editor.js.
			wp_enqueue_script( $handle, $vite_url . '/' . $file, array(), null, true );

			// Важно: чтобы работали import.meta.glob и ESM.
			add_filter(
				'script_loader_tag',
				function ( $tag, $handle_name ) use ( $handle ) {
					if ( $handle_name === $handle ) {
						$tag = str_replace( '<script ', '<script type="module" ', $tag );
					}
					return $tag;
				},
				10,
				2
			);

			return;
		} else {

			$manifest = json_decode( file_get_contents( self::$manifest_path ), true );
			if ( ! isset( $manifest[ $key ] ) ) {
				return;
			}

			$asset = $manifest[ $key ];

			if ( ! empty( $asset['css'] ) ) {
				foreach ( $asset['css'] as $i => $css_file ) {
					wp_enqueue_style( "{$handle}-css-{$i}", THEME_URI . '/dist/' . $css_file, array(), THEME_VERSION );
				}
			}

			// JS + imports (shared chunks).
			$deps = array();
			if ( ! empty( $asset['imports'] ) ) {
				foreach ( $asset['imports'] as $import ) {
					$deps[] = $import;
					wp_enqueue_script( "{$handle}-import-{$import}", THEME_URI . '/dist/' . $import, array(), THEME_VERSION, true );
				}
			}

			wp_enqueue_script( $handle, THEME_URI . '/dist/' . $asset['file'], $deps, THEME_VERSION, true );
		}
	}

	/**
	 * Enqueues front-end assets for the theme.
	 *
	 * @return void
	 */
	public static function enqueue_front_assets() {
		self::enqueue_asset( 'mytheme-front', 'src/js/front.js' );
	}

	/**
	 * Enqueues editor (block editor) assets for the theme.
	 *
	 * @return void
	 */
	public static function enqueue_editor_assets() {
		self::enqueue_asset( 'mytheme-editor', 'src/js/editor.js' );
	}
}


Assets::init();
