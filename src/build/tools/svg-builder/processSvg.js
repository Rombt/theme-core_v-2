import * as cheerio from 'cheerio';
import { normalizeSvg } from './normalizeSvg.js';
import { optimizeSvg } from './optimizeSvg.js';
import { validateSvg } from './validateSvg.js';

export function processSvg(items, config, type) {

  return items.map(({ id, content }) => {

    const $ = cheerio.load(content, { xmlMode: true });
    const $svg = $('svg');

    validateSvg($svg);
    // превращаем Cheerio-объект в строку
    let svg = normalizeSvg($.xml($svg), config.dimensions);


    $('metadata, title, desc').remove();

    if (type === 'mono') {
      if (config.mono.removeFill) $('[fill]').removeAttr('fill');
      if (config.mono.removeStroke) $('[stroke]').removeAttr('stroke');
    }

    svg = optimizeSvg($.xml(), config.svgo);

    return { id, svg };
  });
}
