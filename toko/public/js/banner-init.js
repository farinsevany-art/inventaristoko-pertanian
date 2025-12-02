/**
 * banner-init.js
 * Initializes the homepage banner/carousel.
 * Comments explain purpose and fallbacks so future maintainers understand choices.
 *
 * Behavior implemented:
 *  - If jQuery + Bootstrap (v4) present, use jQuery initializer
 *  - Else if Bootstrap 5 JS is present as `bootstrap`, use its JS API
 *  - Configure interval and pause-on-hover
 *
 * This file is intentionally small and only wires up the carousel.
 */

(function () {
  'use strict';

  // Settings used for the carousel initialization
  var CAROUSEL_ID = 'bannerCarousel';
  var INTERVAL = 4500; // ms between slide changes

  // Helper: safe DOM ready
  function ready(fn) {
    if (document.readyState !== 'loading') {
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }

  // Initialize depending on available libraries
  ready(function () {
    var el = document.getElementById(CAROUSEL_ID);
    if (!el) return; // nothing to do if the element is missing

    // If jQuery is available, prefer jQuery initializer (common with Bootstrap 4)
    if (window.jQuery && typeof window.jQuery.fn.carousel === 'function') {
      try {
        window.jQuery(function ($) {
          $('#' + CAROUSEL_ID).carousel({ interval: INTERVAL, pause: 'hover' });
        });
        return;
      } catch (e) {
        /* fallthrough to other init methods if jQuery init fails */
        console.warn('banner-init: jQuery init failed, trying native bootstrap API', e);
      }
    }

    // If Bootstrap 5+ JS is loaded as `bootstrap`, use its API
    if (window.bootstrap && typeof window.bootstrap.Carousel === 'function') {
      try {
        new window.bootstrap.Carousel(el, { interval: INTERVAL, pause: 'hover' });
        return;
      } catch (e) {
        console.warn('banner-init: bootstrap.Carousel init failed', e);
      }
    }

    // As a final fallback, do nothing — the site may include a lightweight slider
    // or banner-slider.js that manages its own initialization.
    console.info('banner-init: no compatible carousel initializer found; skipping automatic init');
  });

})();
