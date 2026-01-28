import path from "path";

export function isFontFile(file) {
  return [".ttf", ".otf", ".woff", ".woff2"].includes(path.extname(file).toLowerCase());
}

export function getExtPriority(ext) {
  switch (ext) {
    case ".woff2": return 4;
    case ".woff": return 3;
    case ".otf": return 2;
    case ".ttf": return 1;
    default: return 0;
  }
}
