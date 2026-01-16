import { defineConfig } from 'vite';
import { resolve, extname, relative } from 'path';
import { fileURLToPath } from 'node:url';
import { glob } from 'glob';

export default defineConfig({
  build: {
    // Указываем выходную папку в корне темы
    outDir: 'blocks',
    emptyOutDir: true, // Очищать папке перед сборкой
    minify: true,
    rollupOptions: {
      // 1. Динамически ищем все JS/TS/JSX/TSX файлы в src/blocks
      input: Object.fromEntries(
        glob.sync('src/blocks/**/*.{js,jsx,ts,tsx}').map(file => [
          // Ключ — это относительный путь без расширения (например, "my-block/view")
          relative(
            'src/blocks',
            file.slice(0, file.length - extname(file).length)
          ),
          // Значение — полный путь к файлу
          fileURLToPath(new URL(file, import.meta.url))
        ])
      ),
      output: {
        // 2. Сохраняем структуру папок: [name] подставит путь из ключа input
        format: 'iife',
        entryFileNames: `[name].js`,
        chunkFileNames: `[name].js`,
        assetFileNames: `[name].[ext]`, // Для CSS файлов блоков
      },
    },
  },
  // Настройка для работы с JSX (React), если используете его в блоках
  esbuild: {
    jsxInject: `import { createElement } from '@wordpress/element'`,
    jsxFactory: 'createElement',
    jsxFragment: 'Fragment',
  },
});