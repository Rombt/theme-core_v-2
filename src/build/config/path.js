
import plugins from './plugins.js';

const themeRoot = plugins.nodePath.resolve(__dirname, '../../../');
const srcRoot = plugins.nodePath.resolve(themeRoot, 'src');
const blocksDist = 'blocks';
const assetsSrs =  plugins.nodePath.resolve(srcRoot, 'assets');
const blocksSrc = plugins.nodePath.resolve(srcRoot, blocksDist);

const globalEntries = getAssetEntries(assetsSrs);
const blockEntries = getBlockEntries(blocksSrc);


const path = {
  Entries: {
    ...globalEntries,
    ...blockEntries,
  },
  themeRoot: themeRoot,
  srcRoot:srcRoot,

}

export default path;


//----------------------------  helpers -------------------------

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