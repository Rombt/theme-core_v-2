import { defineConfig } from 'vite';
import path from 'path';
import { glob } from 'glob';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import WordPressDependencyExtraction from '@wordpress/dependency-extraction-vite-plugin';

export default defineConfig({
  plugins: [
    // Магия для WordPress: делает "externals" и генерирует .asset.php
    WordPressDependencyExtraction(),
    // Копируем файлы, которые не нужно компилировать
    viteStaticCopy({
      targets: [
        {
          src: 'src/blocks/**/*.php', // Все PHP файлы
          dest: 'blocks',
          rename: (name, extension, fullPath) => {
             // Сохраняем структуру папок: src/blocks/my-block/render.php -> blocks/my-block/render.php
             return path.relative('src/blocks', fullPath);
          }
        },
        {
          src: 'src/blocks/**/*.json', // Все block.json
          dest: 'blocks',
          rename: (name, extension, fullPath) => {
             return path.relative('src/blocks', fullPath);
          }
        }
      ]
    })
  ],
  build: {
    outDir: 'blocks', // Базовая папка в корне темы
    rollupOptions: {
      // 3. Автоматический поиск всех точек входа
      input: glob.sync('./src/blocks/*/index.{js,jsx,ts,tsx}').reduce((acc, file) => {
        // Создаем имя ключа как название папки блока (например, 'my-hero-block')
        const entryName = path.basename(path.dirname(file));
        acc[entryName] = file;
        return acc;
      }, {}),

      output: {
        // 4. Формируем структуру: blocks/имя-блока/index.js
        entryFileNames: '[name]/index.js',
        chunkFileNames: 'common/[name].js', // Общие зависимости, если будут
        assetFileNames: (assetInfo) => {
          // Стили кладем рядом с JS: blocks/имя-блока/index.css
          if (assetInfo.name.endsWith('.css')) {
            const blockName = path.basename(path.dirname(assetInfo.originalFileName));
            return `${blockName}/style.css`;
          }
          return 'assets/[name].[ext]';
        },
      }
    },
    minify: false, // Для отладки движка лучше выключить
    emptyOutDir: false, // Чтобы не удалить случайно важные файлы в корне
  }
});