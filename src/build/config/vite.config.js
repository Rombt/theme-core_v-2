import { defineConfig } from 'vite';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import  imagesPlugin    from '../tools/images';

import path  from './path.js';
import plugins from './plugins.js';


function wrapBlocks() {
  return {
    name: 'wrap-blocks',
    renderChunk(code, chunk) {
      if (!chunk.facadeModuleId) return null
        if (chunk.facadeModuleId.includes('/blocks/')) {
          return {
            code: `(function(){\n${code}\n})();`,
            map: null
          }
        }
      return null
    }
  }
}

function cleanAllDestinationDirs(dirs = []) {
  dirs.forEach(dir => {
    const absPath = plugins.nodePath.resolve(process.cwd(), dir);

    if (plugins.fs.existsSync(absPath)) {
      plugins.fs.rmSync(absPath, { recursive: true, force: true });
    }
  });
}

console.log("path.staticCssImg = ", path.staticCssImg);


export default defineConfig({
  root: path.srcRoot,

  build: {
    outDir: path.themeRoot,
    emptyOutDir: false,
    assetsDir: '',
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
        'react',
        'react-dom'
      ],
      },
  },

  plugins: [
    cleanAllDestinationDirs(path.dest),
    wrapBlocks(),
    viteStaticCopy({
      targets: [
        {
          src: `${path.blocksSrc}/**/*.php`,
          dest: `${path.blocksDest}`,
          rename: (name, extension, fullPath) => {
             return plugins.nodePath.relative(path.blocksSrc, fullPath);
          }
        },
        {
          src: `${path.blocksSrc}/**/*.json`,
          dest: `${path.blocksDest}`,
          rename: (name, extension, fullPath) => {
             return plugins.nodePath.relative(path.blocksSrc, fullPath);
          }
        },
        {
          src: `${path.staticCssSrc}/**/*.css`,
          dest: `${path.staticCssDest}`,
        },
        {
          src: `${path.fontsSrc}/**/*.woff2`,
          dest: `${path.fontsDest}`,
        },
        {
          src: `${path.staticSvgSrc}/**/*.svg`,
          dest: `${path.staticSvgDest}`,
        },
      ]
    }),
    imagesPlugin(),

  ],
});