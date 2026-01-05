import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  root: 'src',

  build: {
    outDir: '../dist',
    emptyOutDir: true,
    manifest: 'manifest.json',

    rollupOptions: {
      input: {
        front: path.resolve(__dirname, 'src/js/front.js'),
        editor: path.resolve(__dirname, 'src/js/editor.js'),
      },
      output: {
        entryFileNames: '[name].js',
        assetFileNames: '[name].[ext]',
      },
    },
  },

  css: {
    devSourcemap: true,
  },

  server: {
    strictPort: true,
    port: 5173,
    cors: true,

    hmr: {
      host: 'localhost',  // нужно для hot reload
    },

  },
});
