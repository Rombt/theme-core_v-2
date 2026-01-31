import fs from 'node:fs/promises';

export async function buildSprite(icons, outFile) {
  const symbols = icons.map(({ id, svg }) =>
    svg
      .replace('<svg', `<symbol id="${id}"`)
      .replace('</svg>', '</symbol>')
  );

  const sprite = `<svg xmlns="http://www.w3.org/2000/svg" style="display:none">${symbols.join('\n')}</svg>
`;

  await fs.writeFile(outFile, sprite.trim());
}
