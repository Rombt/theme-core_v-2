/**
 * watchAndCopy — универсальный Vite / Rollup плагин для синхронизации
 * файлов вне dependency graph с поддержкой зеркалирования структуры.
 *
 * Назначение
 * ---------------------------------------------------------------------------
 * Плагин предназначен для копирования и синхронизации файлов, которые:
 * - не импортируются в JS / CSS
 * - не попадают в dependency graph Vite
 * - должны присутствовать в сборке рядом с ассетами
 *
 * Типичные кейсы:
 * - WordPress темы и Gutenberg-блоки (php, block.json, render.php)
 * - backend-шаблоны и конфигурационные файлы
 * - svg, json, txt и другие статические ресурсы
 *
 *
 * Ключевая особенность
 * ---------------------------------------------------------------------------
 * Плагин работает в режиме `vite build --watch` и реагирует на:
 * - изменение файлов
 * - создание новых файлов
 * - удаление файлов
 *
 * При этом копируется ТОЛЬКО затронутый файл, без полной пересборки.
 *
 *
 * Режимы работы
 * ---------------------------------------------------------------------------
 * Поведение плагина определяется на уровне каждого правила через флаг `mirror`.
 *
 * 1) mirror: true (по умолчанию)
 * ---------------------------------------------------------------------------
 * Сохраняет относительную структуру директорий исходных файлов.
 *
 * Пример:
 *   src/blocks/button/render.php
 *   → blocks/button/render.php
 *
 *
 * 2) mirror: false
 * ---------------------------------------------------------------------------
 * Используется плоское копирование:
 * - `src` используется только как фильтр и источник событий
 * - `dest` является фактической директорией назначения
 * - структура `src` не воспроизводится
 *
 * Пример:
 *   src/meta/config.json
 *   → build/meta/config.json
 *
 *
 * API
 * ---------------------------------------------------------------------------
 * watchAndCopy({
 *   rules: [
 *     {
 *       src: 'src/blocks/<any depth>/*.php',
 *       dest: 'blocks',
 *       mirror: true, // optional, default true
 *     },
 *     {
 *       src: 'src/meta/*.json',
 *       dest: 'build/meta',
 *       mirror: false,
 *     },
 *   ],
 *   debounce: 100,
 * });
 *
 *
 * Параметры
 * ---------------------------------------------------------------------------
 * rules {Array<Object>} — обязательный
 *
 *   src     {string}
 *     Glob-паттерн исходных файлов (относительно корня проекта).
 *     Используется для первичной синхронизации и отслеживания изменений.
 *
 *   dest    {string}
 *     Целевая директория.
 *     В режиме `mirror: true` — корень зеркалирования.
 *     В режиме `mirror: false` — фактический путь копирования.
 *
 *   mirror  {boolean} — необязательный
 *     Управляет формированием пути в `dest`.
 *     true  — сохранять структуру директорий (default)
 *     false — плоское копирование (без структуры src)
 *
 *
 * debounce {number} — необязательный
 *   Задержка (в мс) для группировки частых изменений файлов.
 *   По умолчанию: 100
 *
 *
 * Ограничения и замечания
 * ---------------------------------------------------------------------------
 * - Плагин предназначен для использования в `vite build --watch`
 * - В режиме `vite dev` не применяется
 * - `dest` не должен находиться внутри `src` (во избежание зацикливания)
 * - При `mirror: false` ответственность за уникальность имён файлов
 *   лежит на пользователе
 *
 *
 * Архитектурные заметки
 * ---------------------------------------------------------------------------
 * - Использует Rollup watcher (через Vite)
 * - Не использует chokidar напрямую
 * - Работает только с относительными путями
 * - Не трансформирует файлы — только копирует и удаляет
 *
 */






import fs from 'fs';
import path from 'path';
import fg from 'fast-glob';
import micromatch from 'micromatch';

export function watchAndCopy(options = {}) {
  const {
    rules = [],
    debounce = 100,
    root = process.cwd(),
  } = options;

  let timer = null;
  const queue = new Set();

  function normalize(file) {
    return path
      .relative(root, file)
      .split(path.sep)
      .join('/');
  }

  function matchRule(relPath) {
    return rules.find(rule =>
      micromatch.isMatch(relPath, rule.src)
    );
  }

  function getSrcBase(rule) {
    return rule.src.split('/**')[0];
  }

  function resolveDest(rule, relPath) {
    const destRoot = path.resolve(root, rule.dest);
    const mirror = rule.mirror !== false; // default true

    if (!mirror) {
      return path.join(destRoot, path.basename(relPath));
    }

    const srcBase = getSrcBase(rule);
    const relative = relPath.replace(srcBase + '/', '');
    return path.join(destRoot, relative);
  }

  function copyFile(relPath) {
    const rule = matchRule(relPath);
    if (!rule) return;

    const srcPath = path.resolve(root, relPath);
    if (!fs.existsSync(srcPath)) return;

    const destPath = resolveDest(rule, relPath);
    fs.mkdirSync(path.dirname(destPath), { recursive: true });
    fs.copyFileSync(srcPath, destPath);
  }

  function removeFile(relPath) {
    const rule = matchRule(relPath);
    if (!rule) return;

    const destPath = resolveDest(rule, relPath);
    if (!fs.existsSync(destPath)) return;

    fs.unlinkSync(destPath);

    if (rule.mirror !== false) {
      cleanupEmptyDirs(
        path.dirname(destPath),
        path.resolve(root, rule.dest)
      );
    }
  }

  function cleanupEmptyDirs(dir, stopDir) {
    if (!dir.startsWith(stopDir)) return;
    if (!fs.existsSync(dir)) return;
    if (fs.readdirSync(dir).length > 0) return;

    fs.rmdirSync(dir);
    cleanupEmptyDirs(path.dirname(dir), stopDir);
  }

  function flush() {
    for (const file of queue) {
      copyFile(file);
    }
    queue.clear();
  }

  return {
    name: 'vite-watch-and-mirror',
    apply: 'build',

    buildStart() {
      // 1. Первичная синхронизация
      for (const rule of rules) {
        const files = fg.sync(rule.src, { cwd: root });
        for (const file of files) {
          copyFile(file);
        }

        // 2. Watch корневой директории src
        const dir = getSrcBase(rule);
        this.addWatchFile(path.resolve(root, dir));
      }
    },

    watchChange(id) {
      const rel = normalize(id);
      const rule = matchRule(rel);
      if (!rule) return;

      if (!fs.existsSync(id)) {
        removeFile(rel);
        return;
      }

      queue.add(rel);
      clearTimeout(timer);
      timer = setTimeout(flush, debounce);
    },
  };
}
