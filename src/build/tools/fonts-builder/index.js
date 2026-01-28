import fs from "fs-extra";
import path from "path";
import { FONTS_SRC, FONTS_BUILD, CSS_OUT } from "./config.js";
import { scanFamilies } from "./scanner.js";
import { processFamily } from "./processor.js";
import { generateCSS } from "./css.js";

async function run() {
  console.log("▶ Fonts builder started");

  await fs.ensureDir(FONTS_SRC);
  await fs.emptyDir(FONTS_BUILD);

  const families = await scanFamilies(FONTS_SRC);

  let allFonts = [];

  for (const family of families) {
    console.log(`• Processing: ${family.family}`);
    const res = await processFamily(family, FONTS_SRC, FONTS_BUILD);
    allFonts.push(...res);
  }

  const css = generateCSS(allFonts);

  await fs.ensureDir(path.dirname(CSS_OUT));
  await fs.writeFile(CSS_OUT, css, "utf8");

  console.log("✔ Fonts build complete");
  console.log(`✔ Written: ${CSS_OUT}`);
}

run().catch(err => {
  console.error("✖ Fonts build failed");
  console.error(err);
  process.exit(1);
});
