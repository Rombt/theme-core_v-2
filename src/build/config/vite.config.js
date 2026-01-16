import { defineConfig } from 'vite';

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
 */


console.log("plugins = ", plugins);







export default defineConfig({
  root: path.srcRoot,

  build: {
    outDir: path.themeRoot,
    emptyOutDir: false,
    assetsDir: '',

    rollupOptions: {
        input: path.Entries,
      output: {
        // [name] подставит ключ из объекта (например, 'assets/js/front') т.е. сохранит файл по тому же пути что он в
        entryFileNames: `[name].js`,
        chunkFileNames: `assets/js/chunks/[name].js`,

      },
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


  ],
});