/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */

/* eslint-disable no-console */
console.log('Hello World! (from create-block-literati-example-carousel block)');
/* eslint-enable no-console */

import Swiper from 'swiper/bundle';

import 'swiper/css/bundle';
document.addEventListener('DOMContentLoaded', () => {
  const container = document.querySelector('.wp-block-literati-example-carousel');
  if (container) {

    const transitionTimerValue = container.getAttribute('data-transition-timer');


    const swiper = new Swiper('.swiper-container', {
      loop: true,
      autoplay: {
        delay: transitionTimerValue,
        disableOnInteraction: true,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      slidesPerView: 'auto',
      centeredSlides: true,
      loop: true,
      slidesPerGroup: 1,
      initialSlide: 2,

      paginationClickable: true,
      spaceBetween: 0,
      breakpoints: {
        640: {
          slidesPerView: 1.5,
        },
        768: {
          slidesPerView: 'auto',
        },
        1024: {
          slidesPerView: 'auto',
        }
      },
    });

  }

});
