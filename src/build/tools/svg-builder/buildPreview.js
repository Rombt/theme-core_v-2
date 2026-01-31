import fs from 'node:fs/promises';

export async function buildPreview(icons, outFile) {

  const items = icons.map(i => `
    <div class="item"> ${i.svg}
    <div class="name">${i.id}</div>
    </div>
    `).join('');


  const html = `
<!doctype html>
<html>
<head>
<style>
body {
font-family: sans-serif;
font-size: 12px;
}
.svg-preview {
  display: grid;
  grid-template-columns: repeat(auto-fill, 100px);
  gap: 30px;
  padding: 30px;
}
svg {
  width: 64px;
  height: 64px;
}
.item{
    text-align: center;
}
</style>
</head>
<body>
<div class="svg-preview">

${items}
</div>
</body>
</html>
`;

  await fs.writeFile(outFile, html.trim());
}
