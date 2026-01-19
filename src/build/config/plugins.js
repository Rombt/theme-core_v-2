import path from 'path';
import fs from 'fs';
import fg from 'fast-glob'
import { normalizePath } from 'vite';




const plugins = {
    nodePath: path,
    normalizePath:normalizePath,
    fs: fs,
    fg: fg,

}


export default plugins;