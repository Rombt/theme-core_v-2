(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const navigation = document.querySelector('.wp-block-navigation');

        if (!navigation) {
            return;
        }

        navigation.querySelectorAll('.wp-block-navigation-item__content').forEach(function (link) {
            link.addEventListener('click', function () {
                navigation.classList.remove('is-open');
            });
        });
    });
})();
