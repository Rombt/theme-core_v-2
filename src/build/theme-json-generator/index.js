import fs from 'node:fs';
import path from 'node:path';
import { generateThemeJson } from './theme-json.js';

const themeJson = generateThemeJson();

const outputPath = path.resolve(process.cwd(), 'theme.json');

fs.writeFileSync(outputPath, JSON.stringify(themeJson, null, 2), 'utf-8');

console.log('theme.json успешно создан:', outputPath);
