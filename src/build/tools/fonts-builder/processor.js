import fs from "fs-extra";
import path from "path";
import Fontmin from "fontmin";
import { readFontMeta } from "./meta.js";

function convertToWoff2(srcFile, outDir, outName) {
  return new Promise((resolve, reject) => {
    const fontmin = new Fontmin()
      .src(srcFile)
      .use(Fontmin.ttf2woff2())
      .dest(outDir);

    fontmin.run((err, files) => {
      if (err) return reject(err);

      const generated = files[0].path;
      const finalPath = path.join(outDir, outName);

      fs.moveSync(generated, finalPath, { overwrite: true });
      resolve(finalPath);
    });
  });
}

export async function processFamily(family, srcRoot, outRoot) {
  const srcDir = path.join(srcRoot, family.family);
  const outDir = path.join(outRoot, family.family);

  await fs.ensureDir(outDir);

  const results = [];

  for (const entry of family.entries) {
    const srcPath = path.join(srcDir, entry.file);

    let finalPath;

    if (entry.ext === ".woff2") {
      finalPath = path.join(outDir, entry.file);
      await fs.copy(srcPath, finalPath);
    } else {
      const outName = entry.base + ".woff2";
      finalPath = await convertToWoff2(srcPath, outDir, outName);
    }

    const meta = readFontMeta(finalPath);

    results.push({
      family: meta.family,
      weight: meta.weight,
      style: meta.style,
      filePath: finalPath,
      fileName: path.basename(finalPath),
      familyDir: family.family,
    });
  }

  return results;
}
