import path from 'node:path';

export function resolvePaths(config) {
  const ROOT = process.cwd();

  return {
    ROOT,
    out: path.join(ROOT, config.out),

    monoSrc: path.join(ROOT, config.src, 'mono'),
    coloredSrc: path.join(ROOT, config.src, 'colored'),

    sprite: path.join(ROOT, config.sprite),
    preview: path.join(ROOT, config.preview),
  };
}
