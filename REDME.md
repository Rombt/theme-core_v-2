# ThemeCore WordPress Theme

**Hybrid: Classic + Blocks** — премиум-подход к разработке тем WordPress.
Эта тема построена на ядре **ThemeCore**, которое обеспечивает повторяемую логику для линейки тем.

---

## 📦 Структура проекта

tc-1/
├── style.css
├── functions.php
├── theme.json
├── screenshot.png
├── core/
│ ├── core.php # Bootstrap, инициализация ядра
│ ├── assets.php # Подключение Vite-ассетов
│ ├── blocks.php # Регистрация Gutenberg-блоков
│ └── helpers.php # Общие утилиты
├── blocks/
│ └── hero/
│ ├── block.json
│ └── render.php
├── templates/
│ └── page-landing.php
├── src/
│ ├── js/
│ │ ├── front.js
│ │ └── editor.js
│ └── scss/
│ ├── front.scss
│ └── editor.scss
├── dist/
│ ├── front.css
│ ├── front.js
│ ├── editor.css
│ └── editor.js
├── package.json
└── vite.config.js




---

## ⚙️ Назначение

### ThemeCore (core/)
- Запускает и инициализирует тему
- Подключает CSS и JS через Vite (`assets.php`)
- Регистрирует Gutenberg-блоки (`blocks.php`)
- Предоставляет общие утилиты (`helpers.php`)
- Служит базой для всех последующих тем на этой архитектуре

### Тема (tc-1)
- Содержит уникальный дизайн, стили, JS и блоки
- Подключает ThemeCore
- Минимизирует дублирование кода
- Позволяет быстро создавать новые демо и темы на базе ядра

---

## 🛠 Установка и разработка

1. Скопировать тему в `wp-content/themes/`.
2. Убедиться, что Node.js установлен.
3. Установить зависимости:

```bash
npm install
Для разработки с hot-reload:

bash

npm run dev
Для сборки production:

bash

npm run build
В WordPress активировать тему через админку.

🧩 Архитектурные принципы
Hybrid — классическая тема + блоки Gutenberg там, где нужно.

ThemeCore — единственная точка подключения логики и ассетов.

src/ — исходники для Vite, сборка попадает в dist/.

blocks/ — только блоки специфичные для темы.

templates/ — кастомные PHP-шаблоны для страниц/страниц-демо.

dist/ — скомпилированные ассеты, подключаемые в фронтенде и редакторе.

📌 Особенности
Готовность к CI/CD и тестам

Масштабируемость для нескольких тем

Минимальный дублирующийся код

Поддержка modern JS (ES6+) и SCSS через Vite