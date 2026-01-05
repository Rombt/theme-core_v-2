<?php

/**
 * Gutenberg blocks registration
 */

if (! defined('ABSPATH')) {
    exit;
}

final class MyTheme_Blocks
{
    /**
     * Инициализация
     */
    public static function init()
    {
        add_action('init', [ __CLASS__, 'register_blocks' ]);
    }

    /**
     * Регистрация всех блоков темы
     */
    public static function register_blocks()
    {

        $blocks_dir = MYTHEME_PATH . '/blocks';

        if (! is_dir($blocks_dir)) {
            return;
        }

        $blocks = scandir($blocks_dir);

        foreach ($blocks as $block) {
            if ($block === '.' || $block === '..') {
                continue;
            }

            $block_path = $blocks_dir . '/' . $block;

            if (! is_dir($block_path)) {
                continue;
            }

            $block_json = $block_path . '/block.json';

            if (! file_exists($block_json)) {
                continue;
            }

            register_block_type($block_path);
        }
    }
}

MyTheme_Blocks::init();
