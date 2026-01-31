import fs from 'node:fs/promises';
import config from './config.js';

import { resolvePaths } from './paths.js';
import { readSvgFiles } from './readSvgFiles.js';
import { processSvg } from './processSvg.js';
import { buildSprite } from './buildSprite.js';
import { buildPreview } from './buildPreview.js';

async function run() {
  const paths = resolvePaths(config);

  await fs.mkdir(paths.out, { recursive: true });

  const mono = await readSvgFiles(paths.monoSrc);
  const colored = await readSvgFiles(paths.coloredSrc);

  const monoProcessed = processSvg(mono, config, 'mono');
  const coloredProcessed = processSvg(colored, config, 'colored');

  await buildSprite(monoProcessed, paths.spriteMono);
  await buildSprite(coloredProcessed, paths.spriteColored);

  await buildPreview(monoProcessed, paths.previewMono, 'mono');
  await buildPreview(coloredProcessed, paths.previewColored, 'colored');

  console.log('✔ SVG build completed');
}

run().catch(err => {
  console.error('✖ SVG build failed');
  console.error(err);
  process.exitCode = 1;
});
