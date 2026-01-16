import path from 'path';
import fs from 'fs';
import fg from 'fast-glob'




const plugins = {
    nodePath: path,
    fs: fs,
    fg: fg,

}


export default plugins;