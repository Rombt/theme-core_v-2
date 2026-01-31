import path from 'node:path';

const src = 'src/static/svg/src';
const out = 'src/static/svg/build';
export default {

    src,
    out,

  dimensions: {
    width: 24,
    height: 32,
    normalizeViewBox: true
  },

  spriteMono: path.join(out, 'sprite-mono.svg'),
  spriteColored: path.join(out, 'sprite-colored.svg'),

  previewMono: path.join(out, 'preview-mono.html'),
  previewColored: path.join(out, 'preview-colored.html'),

  precision: 2,

  mono: {
    removeFill: true,
    removeStroke: true
  },

  colored: {
    preserveColors: true
  },

  svgo: {
    plugins: [
      'preset-default',

      // ВАЖНО: явно отключаем удаление viewBox
      {
        name: 'removeViewBox',
        active: false,
      },

      // Убираем width / height
      'removeDimensions',

      // Чистка id (безопасно для sprite)
      'cleanupIds',
    ],
  },

};
