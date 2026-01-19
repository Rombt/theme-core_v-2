import { defineConfig } from 'vite';
import { viteStaticCopy } from 'vite-plugin-static-copy';
// import wordpress from 'vite-plugin-wordpress';   // разобраться!!

import path  from './path.js';
import plugins from './plugins.js';

/**
 *
 * что такое режим Library Mode
 *
 * Как это работает
 *  Условные фичи (Feature Flags): В темах для Envato часто бывают разные версии: "Lite" и "Pro". Через define можно создать флаг __IS_PRO__: true.
 *  При сборке Vite просто удалит недоступный код (Tree-shaking), уменьшая вес файла.
 *  Нужны подробности об этом:  Manifest.json — мост между Vite и PHP. Как именно это используется в WP и насколько это необходимо

  !!!
  $script_asset = require( get_template_directory() . '/build/index.asset.php' );

  wp_enqueue_script(
      'my-theme-script',
      get_template_directory_uri() . '/build/index.js',
      $script_asset['dependencies'], // Автоматический список зависимостей
      $script_asset['version'],      // Автоматическая версия для кэша
      true
  );

*/

console.log("path = ", path);
// console.log("cleanupByManifest()");
// console.log("cleanBeforeBuild()");

function cleanAllDestinationDirs(dirs = []) {

  console.log("**********************cleanAllDestinationDirs*********************");
  console.log("dirs = ", dirs);

  dirs.forEach(dir => {
    const absPath = plugins.nodePath.resolve(process.cwd(), dir);
    console.log("absPath = ", absPath);

    if (plugins.fs.existsSync(absPath)) {
      plugins.fs.rmSync(absPath, { recursive: true, force: true });
      console.log(`✅ Cleared: ${absPath}`);
    }
  });
}




export default defineConfig({
  root: path.srcRoot,

  build: {
    outDir: path.themeRoot,
    emptyOutDir: false,
    assetsDir: '',
    // manifest: true,
    manifest: 'core/manifest.json',

    rollupOptions: {
        input: path.Entries,
      output: {

        globals: {
          '@wordpress/blocks': 'wp.blocks',
          '@wordpress/element': 'wp.element',
          '@wordpress/block-editor': 'wp.blockEditor',
          '@wordpress/components': 'wp.components',
          '@wordpress/i18n': 'wp.i18n',
          'react': 'React',
          'react-dom': 'ReactDOM'
        },
      },

    external: [
      '@wordpress/blocks',
      '@wordpress/element',
      '@wordpress/block-editor',
      '@wordpress/components',
      '@wordpress/i18n',
      'react', // React в WP тоже внешний
      'react-dom'
    ],
    },
  },

  server: {
    strictPort: true,
    port: 5173,

    headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Methods': 'GET, OPTIONS',
      'Access-Control-Allow-Headers': '*',
    },

    hmr: {
      host: 'localhost',
    },

  },

  plugins: [

    viteStaticCopy({
      targets: [
        {
          src: `${path.blocksSrc}/**/*.php`,
          dest: `${path.blocksDist}`,
          rename: (name, extension, fullPath) => {
             return plugins.nodePath.relative(path.blocksSrc, fullPath);
          }
        },
        {
          src: `${path.blocksSrc}/**/*.json`,
          dest: `${path.blocksDist}`,
          rename: (name, extension, fullPath) => {
             return plugins.nodePath.relative(path.blocksSrc, fullPath);
          }
        }
      ]
    }),
    {
      name: 'clean-before-build',

      buildStart() {
        cleanAllDestinationDirs(path.dist); // заглушка
      },
    },

    // wordpress({
    //   // 1. Где искать входные файлы (JS/CSS)
    //   input: path.assetsSrs,

    //   // 2. URL вашего локального сайта (для работы Hot Module Replacement)
    //   url: 'http://tc-1.multisite/',

    //   // 3. Куда сохранять PHP-файл с зависимостями
    //   output: 'core/assets.php',

    //   // 4. Пространство имен (префикс для скриптов в WP)
    //   bundleName: 'tc-1'
    // })

  ],
});