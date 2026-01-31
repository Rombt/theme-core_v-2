import path from 'node:path';

const src = 'src/static/svg/src';
const out = 'src/static/svg/build';
export default {

    src,
    out,

  dimensions: {
    width: 24,
    height: 24,
    normalizeViewBox: true
  },

  sprite: path.join(out, 'sprite.svg'),
  preview: path.join(out, 'preview.html'),

  // precision: 2,

  // colored: {
  //   preserveColors: true
  // },

  svgo: {
    plugins: [
      'preset-default',
      {
        name: 'removeViewBox',
        active: false,
      },
      'removeDimensions',
      'cleanupIds',
    ],
  },

};
