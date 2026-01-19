
import plugins from './plugins.js';

const themeRoot = plugins.nodePath.resolve(__dirname, '../../../');
const srcRoot = plugins.nodePath.resolve(themeRoot, 'src');
const blocksDist = 'blocks';
const assetsDist = 'assets';

const assetsSrs =  plugins.nodePath.resolve(srcRoot, 'assets');
const blocksSrc = plugins.nodePath.resolve(srcRoot, 'blocks');

const globalEntries = getAssetEntries(assetsSrs);
const blockEntries = getBlockEntries(blocksSrc);


const path = normalizePaths({
  Entries: {
    ...globalEntries,
    ...blockEntries,
  },
  themeRoot: themeRoot,
  srcRoot: srcRoot,
  assetsSrs: assetsSrs,
  blocksSrc: blocksSrc,
  blocksDist: blocksDist,

  dist: [
    blocksDist,
    assetsDist
  ]
});




export default path;


//----------------------------  helpers -------------------------

// Нормализации путей
/**
 * Рекурсивно нормализует все строковые пути в объекте
 * @param {object} obj — исходный объект с путями
 * @returns {object} — объект с нормализованными путями
 */
function normalizePaths(obj) {
  if (typeof obj === 'string') {
    return plugins.normalizePath(obj);
  }

  if (Array.isArray(obj)) {
    return obj.map(normalizePaths);
  }

  if (obj && typeof obj === 'object') {
    return Object.fromEntries(
      Object.entries(obj).map(([key, value]) => [key, normalizePaths(value)])
    );
  }

  // если не строка и не объект — возвращаем как есть
  return obj;
}


//TODO объединить getAssetEntries() и getBlockEntries() в одну функцию
function getBlockEntries(blocksSrc) {
  const blockEntries = [];

  plugins.fs.readdirSync(blocksSrc).forEach((block) => {
    const jsFile = plugins.nodePath.join(blocksSrc, block, 'index.jsx');
    const blockFolder = plugins.nodePath.join(blocksDist, block, 'index');

    if (plugins.fs.existsSync(jsFile)) {
      blockEntries[blockFolder] = jsFile;
    }
  });

  return blockEntries;
}

function getAssetEntries(targetDir) {
  const root = plugins.nodePath.resolve(targetDir); // Фиксируем корень для каждой папки отдельно
  const result = {};

  function scan(currentPath) {

    const entries = plugins.fs.readdirSync(currentPath, { withFileTypes: true });

    for (const entry of entries) {
      const fullPath = plugins.nodePath.join(currentPath, entry.name);

      if (entry.isDirectory()) {
        scan(fullPath);
      } else {
          const relPath = plugins.nodePath.relative(root, fullPath);
          const pathData = plugins.nodePath.parse(relPath);
          const rootFolder = plugins.nodePath.parse(root);
          const key = plugins.nodePath.join(rootFolder.name, pathData.dir, pathData.name);
          result[key] = fullPath;
      }
    }
  }

  scan(root);
  return result;
}