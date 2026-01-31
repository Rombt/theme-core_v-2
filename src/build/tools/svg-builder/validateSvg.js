export function validateSvg($svg) {
    if (!$svg.length) {
      throw new Error('SVG root element not found');
    }


    const viewBox = $svg.attr('viewBox');
    if (!viewBox) {
      throw new Error('SVG has no viewBox');
    }

    const parts = viewBox.split(/\s+/).map(Number);
    if (parts.length !== 4 || parts.some(n => !Number.isFinite(n))) {
      throw new Error('Invalid viewBox format');
    }

    if (parts[2] <= 0 || parts[3] <= 0) {
      throw new Error('Invalid viewBox dimensions');
    }
  }
