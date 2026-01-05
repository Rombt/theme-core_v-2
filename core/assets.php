<?php

final class MyTheme_Assets {

	static $manifest_path = MYTHEME_PATH . '/dist/manifest.json';

	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_front_assets' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_editor_assets' ) );
	}


	private static function enqueue_asset( $handle, $key ) {

		if ( defined( 'THEME_DEV_MODE' ) && THEME_DEV_MODE ) {
			$vite_url = 'http://localhost:5173';
			$file     = str_replace( 'src/', '', $key ); // front.js / editor.js
			wp_enqueue_script( $handle, $vite_url . '/' . $file, array(), null, true );

			// Важно: чтобы работали import.meta.glob и ESM
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

			// CSS
			if ( ! empty( $asset['css'] ) ) {
				foreach ( $asset['css'] as $i => $css_file ) {
					wp_enqueue_style( "{$handle}-css-{$i}", MYTHEME_URI . '/dist/' . $css_file, array(), MYTHEME_VERSION );
				}
			}

			// JS + imports (shared chunks)
			$deps = array();
			if ( ! empty( $asset['imports'] ) ) {
				foreach ( $asset['imports'] as $import ) {
					$deps[] = $import;
					wp_enqueue_script( "{$handle}-import-{$import}", MYTHEME_URI . '/dist/' . $import, array(), MYTHEME_VERSION, true );
				}
			}

			wp_enqueue_script( $handle, MYTHEME_URI . '/dist/' . $asset['file'], $deps, MYTHEME_VERSION, true );
		}
	}


	public static function enqueue_front_assets() {
		self::enqueue_asset( 'mytheme-front', 'src/js/front.js' );
	}

	public static function enqueue_editor_assets() {
		self::enqueue_asset( 'mytheme-editor', 'src/js/editor.js' );
	}
}


MyTheme_Assets::init();
