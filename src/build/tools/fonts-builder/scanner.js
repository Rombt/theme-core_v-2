import fs from "fs-extra";
import path from "path";
import { isFontFile, getExtPriority } from "./utils.js";

export async function scanFamilies(srcRoot) {
  const families = [];

  const familyDirs = (await fs.readdir(srcRoot)).sort();

  for (const family of familyDirs) {
    const fullDir = path.join(srcRoot, family);
    const stat = await fs.stat(fullDir);
    if (!stat.isDirectory()) continue;

    const files = (await fs.readdir(fullDir)).filter(isFontFile);

    const groups = {};

    for (const file of files) {
      const ext = path.extname(file);
      const base = path.basename(file, ext);

      groups[base] ??= [];
      groups[base].push(file);
    }

    const entries = [];

    for (const base in groups) {
      const variants = groups[base];

      variants.sort((a, b) => {
        return getExtPriority(path.extname(b)) - getExtPriority(path.extname(a));
      });

      // первый — самый приоритетный (woff2 > woff > otf > ttf)
      const chosen = variants[0];

      entries.push({
        familyDir: family,
        base,
        file: chosen,
        ext: path.extname(chosen).toLowerCase(),
      });
    }

    families.push({
      family,
      entries: entries.sort((a, b) => a.base.localeCompare(b.base)),
    });
  }

  return families;
}
