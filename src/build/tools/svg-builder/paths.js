import path from 'node:path';

export function resolvePaths(config) {
  const ROOT = process.cwd();

  return {
    ROOT,
    out: path.join(ROOT, config.out),

    monoSrc: path.join(ROOT, config.src, 'mono'),
    coloredSrc: path.join(ROOT, config.src, 'colored'),

    spriteMono: path.join(ROOT, config.spriteMono),
    spriteColored: path.join(ROOT, config.spriteColored),

    previewMono: path.join(ROOT, config.previewMono),
    previewColored: path.join(ROOT, config.previewColored)
  };
}
