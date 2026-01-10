import fs from 'node:fs';
import path from 'node:path';
import { generateThemeJson } from './theme-json.js';

// Генерируем JSON
const themeJson = generateThemeJson();

// Определяем путь к файлу в корне проекта
const outputPath = path.resolve(process.cwd(), 'theme.json');

// Записываем файл
fs.writeFileSync(outputPath, JSON.stringify(themeJson, null, 2), 'utf-8');

console.log('theme.json успешно создан:', outputPath);
