<?php

/**
 * General front settings.
 *
 * @package RMBT_Theme
 */

defined('ABSPATH') || exit;

/**
 * Get SVG icon markup by ID from the theme sprite.
 *
 * This function generates an <svg> element using a sprite file.
 * It supports optional color variant, custom CSS classes, and adds
 * versioning based on the file modification time for cache busting.
 *
 * @param string $id      The ID of the icon within the SVG sprite.
 * @param bool   $color   Optional. If true, uses the colored sprite variant. Default false.
 * @param string $classes Optional. Additional CSS classes to add to the <svg> tag. Default empty string.
 * @return string SVG markup for the requested icon.
 */
function get_icon_svg($id, $color = false, $classes = '')
{
    $sprite_name = $color ? 'sprite_color.svg' : 'sprite.svg';
    $sprite_rel  = '/assets/images/icons/';
    $file_path   = get_theme_file_path($sprite_rel . $sprite_name);
    $base_url    = get_theme_file_uri($sprite_rel . $sprite_name);
    $ver         = file_exists($file_path) ? filemtime($file_path) : time();

    $url  = esc_url(add_query_arg('ver', $ver, $base_url));
    $href = esc_url($url . '#' . sanitize_key($id));

    $class_attr = '';
    if ('' !== $classes) {
        $class_attr = ' class="' . esc_attr($classes) . '"';
    }

    return '<svg' . $class_attr . '><use href="' . $href . '"></use></svg>';
}

/**
 * Create a custom WP_Query instance for a given post type and taxonomy query.
 *
 * This function returns a WP_Query object for the specified post type,
 * with support for custom number of posts per page, current pagination,
 * and optional tax_query parameters.
 *
 * @param string $rmbt_post_type       Post type to query.
 * @param int    $rmbt_posts_per_page  Number of posts per page.
 * @param int    $rmbt_current         Optional. Current page for pagination. Default is calculated from query vars.
 * @param array  $tax_query             Optional. Array of taxonomy query parameters. Default empty array.
 * @return WP_Query WP_Query instance with the requested posts.
 */
function rmbt_custom_wp_query($rmbt_post_type, $rmbt_posts_per_page, $rmbt_current = '', $tax_query = array())
{

    if (empty($rmbt_current)) {
        $rmbt_current = absint(max(1, get_query_var('paged') ? get_query_var('paged') : get_query_var('page')));
    }

    if (0 === count($tax_query)) {
        $params = array(
            'post_type'      => $rmbt_post_type,
            'post_status'    => 'publish',
            'posts_per_page' => $rmbt_posts_per_page,
            'paged'          => $rmbt_current,
        );
    } else {
        $params = $tax_query;
    }

    return new WP_Query($params);
}

/**
 * Sanitize HTML output with allowed tags for theme.
 *
 * @param string $rmbt_string HTML content to sanitize.
 * @return string Sanitized HTML.
 */
function rmbt_wp_kses($rmbt_string)
{
    $allowed_tags = array(
        'img'    => array(
            'src'    => array(),
            'alt'    => array(),
            'width'  => array(),
            'height' => array(),
            'class'  => array(),
        ),
        'a'      => array(
            'href'  => array(),
            'title' => array(),
            'class' => array(),
        ),
        'span'   => array(
            'class' => array(),
        ),
        'div'    => array(
            'class' => array(),
            'id'    => array(),
        ),
        'h1'     => array(
            'class' => array(),
            'id'    => array(),
        ),
        'h2'     => array(
            'class' => array(),
            'id'    => array(),
        ),
        'h3'     => array(
            'class' => array(),
            'id'    => array(),
        ),
        'h4'     => array(
            'class' => array(),
            'id'    => array(),
        ),
        'h5'     => array(
            'class' => array(),
            'id'    => array(),
        ),
        'h6'     => array(
            'class' => array(),
            'id'    => array(),
        ),
        'p'      => array(
            'class' => array(),
            'id'    => array(),
        ),
        'strong' => array(
            'class' => array(),
            'id'    => array(),
        ),
        'i'      => array(
            'class' => array(),
            'id'    => array(),
        ),
        'del'    => array(
            'class' => array(),
            'id'    => array(),
        ),
        'ul'     => array(
            'class' => array(),
            'id'    => array(),
        ),
        'li'     => array(
            'class' => array(),
            'id'    => array(),
        ),
        'ol'     => array(
            'class' => array(),
            'id'    => array(),
        ),
        'label'  => array(
            'for' => array(),
        ),
        'input'  => array(
            'class'   => array(),
            'id'      => array(),
            'type'    => array(),
            'style'   => array(),
            'name'    => array(),
            'value'   => array(),
            'checked' => array(),
        ),
    );
    if (function_exists('wp_kses')) {
        return wp_kses($rmbt_string, $allowed_tags);
    }
}

/**
 * Trim post content or excerpt to a specific number of words.
 *
 * Generates a trimmed excerpt from the post content or an explicitly
 * provided text. Shortcodes and HTML tags are removed, and the excerpt
 * is limited to the specified number of words with an ellipsis appended
 * if the text exceeds the limit.
 *
 * @param int    $length Maximum number of words.
 * @param string $text   Optional. Custom text to trim instead of post content. Default empty.
 * @return string Trimmed excerpt text.
 */
function rmbt_trim_excerpt($length, $text = '')
{

    global $post;

    $explicit_excerpt = $post->post_excerpt;

    if ('' !== $text) {
        $explicit_excerpt = $text;
    } elseif ('' === $explicit_excerpt) {
        $text = get_the_content('');
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]>', $text);
    } else {
        $text = apply_filters('the_content', $explicit_excerpt);
    }

    $text           = strip_shortcodes($text); // optional.
    $text           = wp_strip_all_tags($text, true);
    $excerpt_length = $length;
    $words          = explode(' ', $text, $excerpt_length + 1);
    if (count($words) > $excerpt_length) {
        array_pop($words);
        array_push($words, '[&hellip;]');
        $text = implode(' ', $words);
        $text = apply_filters('the_excerpt', $text);
    }
    return $text;
}

/**
 * Outputs an image from Redux option or falls back to an SVG icon.
 *
 * Retrieves an image URL stored in Redux theme options and returns an `<img>` tag.
 * If the image is not set, an SVG icon is returned instead (when SVG ID is provided).
 *
 * @param string $id_field_pic Redux option ID containing image data.
 * @param string $alt          Alternative text for the image.
 * @param string $id_svg       SVG icon ID used as a fallback.
 * @param bool   $svg_color    Whether to use the colored SVG sprite.
 *
 * @return string|null HTML image or SVG markup on success, null otherwise.
 */
function rmbt_redux_img($id_field_pic, $alt = '', $id_svg = '', $svg_color = false)
{
    global $rmbt_theme_options;

    if (! class_exists('Redux') || ! isset($rmbt_theme_options[ $id_field_pic ])) {
        return;
    }

    if ($rmbt_theme_options[ $id_field_pic ]['url']) {
        return '<img src="' . esc_url($rmbt_theme_options[ $id_field_pic ]['url']) . '" alt="' . esc_attr($alt) . '">';
    } else {
        if ('' === $id_svg) {
            return;
        }
        return get_icon_svg($id_svg, $svg_color);
    }
}

/**
 * Retrieves a value from Redux theme options with optional sanitization.
 *
 * Returns a Redux option value by its ID and applies sanitization
 * depending on the provided flags:
 * - `wp_kses()` with post-allowed tags
 * - no sanitization (raw output)
 * - `esc_html()` by default
 *
 * @param string $id_field         Redux option ID.
 * @param bool   $kses             Whether to allow only post-safe HTML via wp_kses().
 * @param bool   $all_tags_allowed Whether to return the raw value without sanitization.
 *
 * @return string Sanitized option value or empty string if not available.
 */
function rmbt_get_redux_field($id_field, $kses = false, $all_tags_allowed = false)
{
    global $rmbt_theme_options;

    if (! class_exists('Redux')) {
        return;
    } elseif (! isset($rmbt_theme_options[ $id_field ])) {
        return '';
    }

    if ($kses) {
        return wp_kses($rmbt_theme_options[ $id_field ], 'post');
    } elseif ($all_tags_allowed) {
        return $rmbt_theme_options[ $id_field ];
    }

    return esc_html($rmbt_theme_options[ $id_field ]);
}

/**
 * Sanitizes a phone number by removing formatting characters.
 *
 * Strips common formatting symbols such as parentheses, spaces, and hyphens
 * from a phone number string (e.g. for use in `tel:` links).
 *
 * @param string $phone_number Raw phone number value from Redux options.
 *
 * @return string Sanitized phone number containing digits only.
 */
function rmbt_phone_number_clear_redux($phone_number)
{
    $pattern = '/[\)|\(| |-]/';
    return preg_replace($pattern, '', $phone_number);
}

/**
 * Outputs Redux field values as a list or single link (tel/mailto).
 *
 * Supports comma-separated values and renders them either as a <ul> list
 * or a single <a> tag depending on the amount of values.
 *
 * @param string $id_field   Redux field ID.
 * @param string $mod        Link scheme: 'tel' or 'mailto'.
 * @param string $before_str Optional string before value.
 * @param string $after_str  Optional string after value.
 *
 * @return string Rendered HTML markup or empty string on failure.
 */
function rmbt_redux_field_to_ul($id_field, $mod = 'tel', $before_str = '', $after_str = '')
{
    global $rmbt_theme_options;

    if (! class_exists('Redux') || ! isset($rmbt_theme_options[ $id_field ])) {
        return;
    }

    $arr_numbers = explode(',', rmbt_get_redux_field($id_field));

    if (count($arr_numbers) > 1) {
        $html = '<ul>';
        foreach ($arr_numbers as $value) {
            if ('tel' === $mod) {
                $html .= '<li><a href="' . $mod . ':' . rmbt_phone_number_clear_redux($value) . '">' . $before_str . trim($value) . $after_str . '</a></li>';
            } elseif ('mailto' === $mod) {
                $html .= '<li><a href="' . $mod . ':' . $value . '">' . $before_str . trim($value) . $after_str . '</a></li>';
            }
        }

        $html .= '</ul>';
        return $html;
    } elseif ('tel' === $mod) {
            return '<a href="' . $mod . ':' . rmbt_phone_number_clear_redux($arr_numbers[0]) . '">' . $before_str . trim($arr_numbers[0]) . $after_str . '</a>';
    } elseif ('mailto' === $mod) {
        return '<a href="' . $mod . ':' . $arr_numbers[0] . '">' . $before_str . trim($arr_numbers[0]) . $after_str . '</a>';
    }
}

/**
 * Outputs Redux repeater field values as a list or single link.
 *
 * Supports conditional output based on an enabled flag from another
 * repeater field and renders values as tel or mailto links.
 *
 * @param string $id_field        Redux repeater field ID with values.
 * @param string $mod             Link scheme: 'tel' or 'mailto'.
 * @param string $enabled_id      Redux repeater field ID with enable flags.
 * @param string $enabled_option  Key name of the enable flag.
 * @param string $before_str      Optional string before value.
 * @param string $after_str       Optional string after value.
 *
 * @return string Rendered HTML markup or empty string.
 */
function rmbt_redux_repeater_to_ul($id_field, $mod = 'tel', $enabled_id = '', $enabled_option = '', $before_str = '', $after_str = '')
{
    global $rmbt_theme_options;

    if (! class_exists('Redux') || ! isset($rmbt_theme_options[ $id_field ])) {
        return;
    }

    if (count($rmbt_theme_options[ $id_field ]) > 1) {
        $html = '<ul>';
        foreach ($rmbt_theme_options[ $id_field ] as $key => $value) {
            if (isset($rmbt_theme_options[ $enabled_id ][ $key ][ $enabled_option ]) && ! $rmbt_theme_options[ $enabled_id ][ $key ][ $enabled_option ]) {
                continue;
            }
            if ('tel' === $mod) {
                $html .= '<li><a href="' . $mod . ':' . rmbt_phone_number_clear_redux($value) . '">' . $before_str . trim($value) . $after_str . '</a></li>';
            } elseif ('mailto' === $mod) {
                $html .= '<li><a href="' . $mod . ':' . $value . '">' . $before_str . trim($value) . $after_str . '</a></li>';
            }
        }
        $html .= '</ul>';

        return wp_kses_post($html);
    } elseif ('tel' === $mod) {
            return '<a href="' . esc_html($mod) . ':' . esc_html(rmbt_phone_number_clear_redux($rmbt_theme_options[ $id_field ][0])) . '">' . wp_kses_post($before_str) . esc_html(trim($rmbt_theme_options[ $id_field ][0])) . wp_kses_post($after_str) . '</a>';
    } elseif ('mailto' === $mod) {
        return '<a href="' . esc_html($mod) . ':' . esc_html($rmbt_theme_options[ $id_field ][0]) . '">' . wp_kses_post($before_str) . esc_html(trim($rmbt_theme_options[ $id_field ][0])) . wp_kses_post($after_str) . '</a>';
    }
}

/**
 * Recursively searches for files in a directory matching a regex pattern.
 *
 * Traverses all subdirectories and collects full file paths
 * for files whose names match the given regular expression.
 *
 * @param string $directory Absolute path to the directory to search in.
 * @param string $pattern   Regular expression pattern to match filenames.
 * @param array  $results   (Optional) Array to store found file paths (by reference).
 *
 * @return array List of matched file paths.
 */
function file_search_recursive($directory, $pattern, &$results = array())
{

    if (! is_dir($directory) || ! is_readable($directory)) {
        return $results;
    }

    $files = scandir($directory);

    if (false === $files) {
        return $results;
    }

    foreach ($files as $value) {
        if ('.' === $value || '..' === $value) {
            continue;
        }

        $path = realpath($directory . DIRECTORY_SEPARATOR . $value);

        if (false === $path) {
            continue;
        }

        if (is_dir($path)) {
            file_search_recursive($path, $pattern, $results);
            continue;
        }

        if (preg_match($pattern, $value)) {
            $results[] = $path;
        }
    }

    return $results;
}
