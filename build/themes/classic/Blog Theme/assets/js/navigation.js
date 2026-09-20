(function () {
    'use strict';

    const navigation = document.querySelector('.main-navigation');

    if (!navigation) {
        return;
    }

    const links = navigation.querySelectorAll('.menu-item-has-children > a');

    links.forEach(function (link) {
        link.addEventListener('click', function (event) {
            const parent = link.parentElement;

            if (!parent) {
                return;
            }

            const submenu = parent.querySelector(':scope > .sub-menu');

            if (!submenu) {
                return;
            }

            event.preventDefault();

            parent.classList.toggle('is-open');
        });
    });
})();
