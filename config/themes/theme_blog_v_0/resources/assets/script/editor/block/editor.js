(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        if (!document.body.classList.contains('wp-admin')) {
            return;
        }

        document.documentElement.classList.add('theme-editor-ready');
    });
})();
