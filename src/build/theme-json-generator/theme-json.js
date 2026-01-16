import colors from '../../tokens/colors.json' with { type: 'json' };
import gradients from '../../tokens/gradients.json' with { type: 'json' };
import typography from '../../tokens/typography.json' with { type: 'json' };
import spacing from '../../tokens/spacing.json' with { type: 'json' };
import radius from '../../tokens/radius.json' with { type: 'json' };    // !! только разрешения значения свойств нужно добавлять отдельно через генерацию CSS переменных
import layout from '../../tokens/policies/layout.json' with { type: 'json' };
import dimensions from '../../tokens/policies/dimensions.json' with { type: 'json' };
import border from '../../tokens/policies/border.json' with { type: 'json' };
import supports from '../../tokens/policies/supports.json' with { type: 'json' };


// кастомные названия (override для отдельных токенов)
const customColorNames = {
  "brand-primary": "Brand Main",
  "brand-secondary": "Brand Accent",
  "text-primary": "Primary Text"
  // добавляй сюда по необходимости
};

const customFontNames = {
  "sm": "Small",
  "md": "Medium",
  "lg": "Large",
  "xl": "Extra Large",
  "2xl": "2X Large"
};

function mapColorsToPalette(colors) {
    const palette = [];

    Object.entries(colors).forEach(([group, values]) => {
      if (typeof values === 'string') {
        const slug = group;
        palette.push({
          slug,
          name: customColorNames[slug] || titleCase(slug),
          color: values
        });
      } else {
        Object.entries(values).forEach(([name, value]) => {
          const slug = `${group}-${name}`;
          palette.push({
            slug,
            name: customColorNames[slug] || titleCase(slug),
            color: value
          });
        });
      }
    });

    return palette;
  }

function mapGradients(gradients) {    // !! проверить качество кода через GPT
  return Object.entries(gradients).map(([slug, gradient]) => ({
    slug,
    name: slug,
    gradient
  }));
}

function mapFontSizes(fontSize) {

  return Object.entries(fontSize).map(([slug, size]) => ({
    slug,
    name: customFontNames[slug] || titleCase(slug),
    size
  }));
}

function mapSpacing(spacing) {
  return Object.entries(spacing)
    .filter(([slug, value]) => {
      if (slug === 'units') return false;

      if (typeof value !== 'string') {
        console.warn(`[tokens][spacing] "${slug}" skipped: invalid value`);
        return false;
      }

      return true;
    })
    .map(([slug, size]) => ({
      slug,
      name: slug,
      size
    }));
}

function mapBorderSettings(border) {
  if (!border) return undefined;

  return {
    color: border.color ?? false,
    radius: border.radius ?? false,
    width: border.width ?? false,
    style: border.style ?? false,
    ...(border.defaultControls
      ? { defaultControls: border.defaultControls }
      : {})
  };
}

function applyPolicySupports(settings, policy) {
  Object.entries(policy).forEach(([section, values]) => {
    settings[section] = {
      ...(settings[section] || {}),
      ...values
    };
  });
}

export function generateThemeJson() {

  const settings = {

    color: {
      palette: mapColorsToPalette(colors),
      gradients: mapGradients(gradients),
      link: {
        color: true
      }
    },

    typography: {
      fontFamilies: [
        {
          slug: 'base',
          name: 'Base',
          fontFamily: typography.fontFamily?.base || 'sans-serif'
        },
        {
          slug: 'heading',
          name: 'Heading',
          fontFamily: typography.fontFamily?.heading || 'sans-serif'
        },
        {
          slug: 'mono',
          name: 'Mono',
          fontFamily: typography.fontFamily?.mono || 'monospace'
        }
      ],
      fontSizes: mapFontSizes(typography.fontSize)
    },

    spacing: {
      spacingSizes: mapSpacing(spacing),
      units: spacing.units ?? ['px']
    },

    layout: {
      contentSize: layout.content,
      wideSize: layout.wide
    },

    dimensions: {
      minHeight: dimensions.minHeight ?? false,
      aspectRatio: dimensions.aspectRatio ?? false
    },

    border: mapBorderSettings(border),

    custom: {}
  };

  applyPolicySupports(settings, supports);

  return {
    $schema: 'https://schemas.wp.org/trunk/theme.json',
    version: 2,
    settings
  };
}



function titleCase(str) {
    return str
      .split('-')
      .map(word => word[0].toUpperCase() + word.slice(1))
      .join(' ');
}
