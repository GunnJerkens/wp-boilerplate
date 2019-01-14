$(document).ready(function(){

  var winWidth = $(window).width();

  /* == Parallax == */

  function parallax() {
    $('.parallax').each( function(){
      var speed = $(this).data('parallax');
      $(this).jarallax({
        type: 'element',
        speed: String(speed)
      });
    });
  }

  if(Modernizr.mq('(min-width: 768px)')) {
    parallax();
  }

  $(window).on('resize', function() {
    if(winWidth < 768) {
      $('.parallax').jarallax('destroy');
    } else {
      parallax();
    }
  });


  $('.parallax-bg').jarallax({
      imgElement: '.parallax-bg-image'
  });


  /* == Fade ins == */

  $.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
  };

  function fadeIn(element) {
    if (winWidth > 767) {
      if ($(element).isInViewport()) {
        $(element).addClass('visible');
      } else {
        $(element).removeClass('visible');
      }
    }
  }

  // First load
  $('.fadein').each(function(){
    fadeIn(this);
  });

  // Resize and Scroll
  $(window).on('resize scroll', function() {
    $('.fadein').each(function(){
      fadeIn(this);
    });
  });

  // Mobile scroll
  $('body').on('scroll', function() {
    $('.fadein').each(function(){
      fadeIn(this);
    });
  });

});
