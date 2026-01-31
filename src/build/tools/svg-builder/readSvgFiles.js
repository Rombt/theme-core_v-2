import fs from 'node:fs/promises';
import path from 'node:path';

export async function readSvgFiles(dir) {
  const files = await fs.readdir(dir);

  return Promise.all(
    files
      .filter(f => f.endsWith('.svg'))
      .map(async file => ({
        id: path.basename(file, '.svg'),
        content: await fs.readFile(path.join(dir, file), 'utf8')
      }))
  );
}
