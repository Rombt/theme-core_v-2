import * as cheerio from 'cheerio';
import { normalizeSvg } from './normalizeSvg.js';
import { optimizeSvg } from './optimizeSvg.js';
import { validateSvg } from './validateSvg.js';

export function processSvg(items, config, type='') {

  return items.map(({ id, content }) => {

    const $ = cheerio.load(content, { xmlMode: true });
    const $svg = $('svg');

    validateSvg($svg);
    // превращаем Cheerio-объект в строку
    let svg = normalizeSvg($.xml($svg), config.dimensions);


    $('metadata, title, desc').remove();

    if (type === 'mono') {
      const normalizeColor = (attr) => {
        $(`[${attr}]`).each((_, el) => {
          const $el = $(el);
          const value = $el.attr(attr);

          if (!value) return;

          if (
            value === 'none' ||
            value === 'currentColor' ||
            value.startsWith('url(')
          ) {
            return;
          }

          $el.attr(attr, 'currentColor');
        });
      };

      normalizeColor('fill');
      normalizeColor('stroke');
    }


    svg = optimizeSvg($.xml(), config.svgo);

    return { id, svg };
  });
}
