(function () {
    'use strict';

    const menuToggle = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.main-navigation');

    if (!menuToggle || !navigation) {
        return;
    }

    menuToggle.addEventListener('click', function () {
        const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';

        menuToggle.setAttribute('aria-expanded', String(!isExpanded));
        navigation.classList.toggle('is-open', !isExpanded);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') {
            return;
        }

        menuToggle.setAttribute('aria-expanded', 'false');
        navigation.classList.remove('is-open');
    });

    navigation.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            menuToggle.setAttribute('aria-expanded', 'false');
            navigation.classList.remove('is-open');
        });
    });
})();
