/* This file is the entry point for all js files */

/* Bootstrap v4.0 */
// import 'bootstrap';

/* You can also import bootstrap modules individually */
// import 'bootstrap/js/dist/util';
// import 'bootstrap/js/dist/dropdown';
// ...

import Jarallax from './libs/jarallax.min.js';
import JarallaxElement from './libs/jarallax-element.min.js';
import Slick from './libs/slick.min.js';
import Modals from './modals';
import Register from './register'; // for sample page - Register

$(document).ready(function() {

  // Non-Bootstrap nav
  var mainNav = $('#main-nav'),
      menuLink = $('.menu-item a');

  $('#menu-toggle').on('click', function() {
    $(mainNav).toggleClass('active');
  });

  $('#menu-close, section, footer', menuLink).on('click', function() {
    $(mainNav).removeClass('active');
  });

  $('#menu-close', menuLink).on('focus', function() {
    $(mainNav).addClass('active');
  });

  $('#menu-close', menuLink).on('focusout', function() {
    $(mainNav).removeClass('active');
  });
});

if ($('#hero-slider').length > 0) {
  $('#hero-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3500,
    dots: false,
    // arrows: false,
    infinite: true,
    speed: 1000,
    fade: true
  });
}

if ($('#hero .slick-initialized').length > 0) {
  $('#hero-slider .slide').addClass('show');
}

window.scrollToElement = function(elTrigger, elTarget, offsetMobile, offset) {
  var offsetCond = $(window).width() < 1024 ? offsetMobile : offset;
  $(elTrigger).on('click',function(e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: ( ($(elTarget).offset().top + offsetCond))
    }, 1500);
  });
  // FOR LANDING PAGES:
  // Reset nav hrefs for pages that are not the home page
  // This sends links to the home page and then scrolls to element there
  if (window.location.pathname !== '/') {
    $(elTrigger).attr('href', '/' + elTarget);
  }
}


var fadeIns =[].slice.call(document.querySelectorAll(".fade-in, .fade"));
var lazyItems =[].slice.call(document.querySelectorAll(".lazy"));

if ("IntersectionObserver" in window) {
  // Trigger fade in elements
  let fadeInsObserver = new IntersectionObserver((entries) => {
    entries.forEach(function(entry) {

      let fadeItem = entry.target;

      if (entry.isIntersecting) {
        window.requestAnimationFrame(function () {
          // Run scroll functions
          fadeItem.classList.add("visible");
        });
      }
    });
  });

  fadeIns.forEach(function(item) {
    fadeInsObserver.observe(item);
  });
  // Trigger lazy load items
  let lazyItemObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        let lazyItem = entry.target;
        if (lazyItem.hasAttribute('src')) {
          lazyItem.src = lazyItem.dataset.src;
        }
        if (lazyItem.hasAttribute('srcset')) {
          lazyItem.srcset = lazyItem.dataset.srcset;
        }
        lazyItem.classList.remove("lazy");
        lazyItem.classList.add("lazy-active");
        lazyItemObserver.unobserve(lazyItem);
      }
    });
  });

  lazyItems.forEach(function(item) {
    lazyItemObserver.observe(item);
  });

} else {
  // Possibly fall back to a more compatible method here
}