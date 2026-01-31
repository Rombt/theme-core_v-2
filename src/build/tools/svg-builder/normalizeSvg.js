import * as cheerio from 'cheerio';

export function normalizeSvg(svg, dimensions) {
  const $ = cheerio.load(svg, { xmlMode: true });
  const $svg = $('svg');

  $svg.removeAttr('width').removeAttr('height');

  if (dimensions.normalizeViewBox) {
    $svg.attr(
      'viewBox',
      `0 0 ${dimensions.width} ${dimensions.height}`
    );
  }

  return $.xml();
}
