import { optimize } from 'svgo';

export function optimizeSvg(svg, svgoConfig) {
  return optimize(svg, {
    multipass: true,
    ...svgoConfig
  }).data;
}
