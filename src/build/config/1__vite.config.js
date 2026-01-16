import { defineConfig } from 'vite';
import path from 'path';
import fs from 'fs';
import fg from 'fast-glob'

const themeRoot = path.resolve(__dirname, '../../');
const srcRoot = path.resolve(themeRoot, 'src');
const blocksRoot = path.resolve(srcRoot, 'blocks');

const globalEntries = {
  front: path.resolve(srcRoot, 'js/front.js'),
  editor: path.resolve(srcRoot, 'js/editor.js'),
};

// Автоматически формируем input для каждого блока
const blockEntries = {};
fs.readdirSync(blocksRoot).forEach((block) => {
  const jsFile = path.join(blocksRoot, block, 'index.jsx');

  if (fs.existsSync(jsFile)) {
    blockEntries[block] = jsFile;
  }
});


function copyFiles(rules) {
  const copyAll = () => {
    for (const { src, dest, ignore = [] } of rules) {
      const files = fg.sync('**/*', {
        cwd: src,
        ignore,
        dot: true,
      })

      for (const file of files) {
        const from = path.join(src, file)
        const to = path.join(dest, file)
        fs.mkdirSync(path.dirname(to), { recursive: true })
        fs.copyFileSync(from, to)
      }
    }
  }

  return {
    name: 'copy-files',
    buildStart: copyAll,
    configureServer(server) {
      copyAll()
      rules.forEach(r => server.watcher.add(r.src))
      server.watcher.on('all', copyAll)
    },
  }
}

console.log("srcRoot = ", srcRoot);
console.log("themeRoot = ", themeRoot);
export default defineConfig({
  root: srcRoot,

  build: {
    outDir: path.resolve(themeRoot, 'blocks'),
    emptyOutDir: false, // чтобы не удалять весь blocks
    rollupOptions: {
      input: {
        ...globalEntries,
        ...blockEntries,
      },
      output: {
        entryFileNames: '[name]/index.js',
        assetFileNames: ({ name }) => {
          if (name && name.endsWith('.css')) {
            // CSS для каждого блока в blocks/<block>/build
            const blockName = name.split('/')[0];
            const cssFile = name.includes('editor') ? 'editor.css' : 'style.css';
            return `${blockName}/${cssFile}`;
          }
          return '[name].[ext]';
        },

        globals: {
          '@wordpress/blocks': 'wp.blocks',
          '@wordpress/element': 'wp.element',
          '@wordpress/block-editor': 'wp.blockEditor',
          '@wordpress/components': 'wp.components',
          '@wordpress/data': 'wp.data',
          '@wordpress/i18n': 'wp.i18n',
          '@wordpress/editor': 'wp.editor',
        },
      },
      external: [
        '@wordpress/blocks',
        '@wordpress/element',
        '@wordpress/block-editor',
        '@wordpress/components',
        '@wordpress/data',
        '@wordpress/i18n',
        '@wordpress/editor'
      ],
    },
  },

  css: {
    devSourcemap: true,
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
    copyFiles([
      { src: `${srcRoot}/blocks`, dest: `${themeRoot}/blocks`, ignore: ['**/*.jsx', '**/*.scss'] },
    ]),
  ],
});
