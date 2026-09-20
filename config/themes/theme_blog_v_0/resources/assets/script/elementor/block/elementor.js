(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof window.elementorFrontend === 'undefined') {
            return;
        }

        document.documentElement.classList.add('elementor-theme-ready');
    });
})();
