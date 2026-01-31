<?php
defined( 'ABSPATH' ) || exit;


/**
 *
 * Generates an <svg> element with a <use> tag that references an icon
 * from an external SVG sprite file.
 *
 * The sprite URL includes a version parameter based on the file modification
 * time to prevent cache issues. The function also supports optional color mod
 * variants and custom CSS classes.
 *
 * @param string $id      The ID of the icon within the SVG sprite.
 * @param bool   $color   Optional. If true, uses the colored sprite variant. Default false.
 * @param string $classes Optional. Additional CSS classes to add to the <svg> tag. Default empty string.
 * @return string SVG markup for the requested icon.
 */
function get_icon_svg( $id, $color = false, $classes = '' ) {
	$sprite_name = $color ? 'sprite-colored.svg' : 'sprite-mono.svg';
	$sprite_rel  = '/assets/icons/svg/';
	$file_path   = get_theme_file_path( $sprite_rel . $sprite_name );
	$base_url    = get_theme_file_uri( $sprite_rel . $sprite_name );

	error_log( '$file_path = ' . print_r( $file_path, true ) );        // !!--!!
	error_log( '$base_url = ' . print_r( $base_url, true ) );        // !!--!!

	// D:\web\multisite/wp-content/themes/tc-1/assets/icons/svgsprite-mono.svg
	// D:\web\multisite\wp-content\themes\tc-1\assets\icons\svg\sprite-mono.svg
	if ( ! file_exists( $file_path ) ) {
		return '';
	}

	$ver  = filemtime( $file_path );
	$url  = esc_url( add_query_arg( 'ver', $ver, $base_url ) );
	$id   = sanitize_key( $id );
	$href = esc_url( $url . '#' . $id );

	$class_attr = '';
	if ( ! empty( $classes ) ) {
		$class_attr = ' class="' . esc_attr( $classes ) . '"';
	}

	return sprintf(
		'<svg%s role="img" aria-hidden="true">
			<use href="%s" xlink:href="%s"></use>
		</svg>',
		$class_attr,
		$href,
		$href
	);
}
