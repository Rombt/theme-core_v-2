/*
 *
 * 	Simple spoiler
 *	The styles in the file spoiler.less
 *
 */

function spoiler() {
  const spoilers = document.querySelectorAll('.spoilers__title');

  spoilers.forEach(spoiler => {
    spoiler.addEventListener('click', e => {
      const spoilerBody = e.target
        .closest('.spoilers__item')
        .querySelector('.spoilers__body');

      spoilerBody.classList.toggle('spoilers__body_open');
      e.target.classList.toggle('spoilers__title_open');

      if (typeof gsap !== 'undefined') {
        if (spoilerBody.classList.contains('open')) {
          if (spoilerBody) {
            gsap.to(spoilerBody, {
              duration: 0.5,
              ease: 'power1.in',
              height: 'auto',
              overflow: 'visible',
              pointerEvents: 'auto',
              opacity: 1,
            });
          }
        } else {
          gsap.to(spoilerBody, {
            duration: 0.5,
            ease: 'power1.in',
            height: '0px',
            overflow: 'hidden',
            pointerEvents: 'none',
            opacity: 0,
          });
        }
      }
    });
  });
}

spoiler();
