import * as fontkit from "fontkit";

export function readFontMeta(filePath) {
  const font = fontkit.openSync(filePath);

  return {
    family: font.familyName,
    weight: font.weight || 400,
    style: font.italic ? "italic" : "normal",
  };
}
