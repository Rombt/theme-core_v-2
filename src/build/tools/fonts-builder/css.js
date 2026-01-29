import path from "path";

function makeKey(f) {
  return `${f.family}__${f.style}__${f.fileName}`;
}

export function generateCSS(fonts) {
  const map = new Map();

  for (const f of fonts) {
    const key = `${f.family}__${f.style}__${f.fileName}`;
    if (!map.has(key)) {
      map.set(key, f);
    }
  }

  const unique = Array.from(map.values());

  unique.sort((a, b) => {
    if (a.family !== b.family) return a.family.localeCompare(b.family);
    if (a.style !== b.style) return a.style.localeCompare(b.style);
    return a.fileName.localeCompare(b.fileName);
  });

  const blocks = unique.map(f => {
    // const rel = path.posix.join("..", "fonts", f.familyDir, f.fileName);
    const rel = path.posix.join("..", "fonts", f.fileName);

    // если variable font — пишем диапазон
    const weight =
      f.fileName.toLowerCase().includes("variablefont")
        ? "100 900"
        : f.weight;

    return `@font-face {
  font-family: "${f.family}";
  src: url("${rel}") format("woff2");
  font-weight: ${weight};
  font-style: ${f.style};
  font-display: swap;
}`;
  });

  return blocks.join("\n\n");
}

