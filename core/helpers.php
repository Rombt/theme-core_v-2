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
function get_icon_svg( $id, $classes = '' ) {
	$sprite_rel = '/assets/icons/svg/sprite.svg';
	$file_path  = get_theme_file_path( $sprite_rel );
	$base_url   = get_theme_file_uri( $sprite_rel );

	if ( ! file_exists( $file_path ) ) {
		return '';
	}

	$ver  = filemtime( $file_path );
	$url  = esc_url( add_query_arg( 'ver', $ver, $base_url ) );
	$id   = sanitize_key( $id );
	$href = esc_url( $url . '#' . $id );

	$class_attr = $classes ? ' class="' . esc_attr( $classes ) . '"' : '';

	return sprintf(
		'<svg%s role="img" aria-hidden="true">
			<use href="%s" xlink:href="%s"></use>
		</svg>',
		$class_attr,
		$href,
		$href
	);
}
