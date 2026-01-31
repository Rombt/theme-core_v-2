import fg from 'fast-glob';
import fs from 'fs-extra';
import path from 'path';
import sharp from 'sharp';
import crypto from 'crypto';

const SRC_DIR = 'src/static/images';
const OUT_DIR = 'assets/images';

const WIDTHS = [320, 640, 1024];
const QUALITY = 80;

export default function imagesPlugin() {
  return {
    name: 'vite:images-sharp',
    apply: 'build', // выполняется только при build

    async buildStart() {
      const files = await fg(`${SRC_DIR}/**/*.{jpg,png}`);

      for (const file of files) {
        const input = path.resolve(file);
        const buffer = await fs.readFile(input);

        for (const width of WIDTHS) {
          const image = sharp(buffer)
            .resize({ width })
            .webp({ quality: QUALITY })
            .withMetadata(false);

          const outputBuffer = await image.toBuffer();
          const hash = crypto
            .createHash('md5')
            .update(outputBuffer)
            .digest('hex')
            .slice(0, 8);

          // const name = `${path.parse(file).name}-${width}-${hash}.webp`;
          const name = `${path.parse(file).name}-${width}.webp`;
          const outputPath = path.join(OUT_DIR, name);

          await fs.ensureDir(path.dirname(outputPath));
          await fs.writeFile(outputPath, outputBuffer);
        }
      }
    },
  };
}
