// LICENSE BELOW IS FOR ACCESSIBILITY FUNCTIONS
/*

 ============================================
 License for Application
 ============================================

 This license is governed by United States copyright law, and with respect to matters
 of tort, contract, and other causes of action it is governed by North Carolina law,
 without regard to North Carolina choice of law provisions.  The forum for any dispute
 resolution shall be in Wake County, North Carolina.

 Redistribution and use in source and binary forms, with or without modification, are
 permitted provided that the following conditions are met:

 1. Redistributions of source code must retain the above copyright notice, this list
 of conditions and the following disclaimer.

 2. Redistributions in binary form must reproduce the above copyright notice, this
 list of conditions and the following disclaimer in the documentation and/or other
 materials provided with the distribution.

 3. The name of the author may not be used to endorse or promote products derived from
 this software without specific prior written permission.

 THIS SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND ANY EXPRESS OR IMPLIED
 WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE
 LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

 */


// jQuery formatted selector to search for focusable items
var focusableElementsString = 'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]';

// store the item that has focus before opening the modal window
var focusedElementBeforeModal;

var modal = $('.modal'),
  modalOverlay = $('#modal-overlay'),
  modalTrigger = '.modal-trigger',
  modalClose = $('.modal-close'),
  modalContent = $('.modal-content'),
  galleryModalContent = $('#gallery-modal .modal-content'),
  modalVideo = $('.modal-video');

$(document).ready(function () {
  //Open appropriate modal after closing all other modals, and create modal bkg.
  $(document).on('click', modalTrigger, function (e) {
    e.preventDefault();
    openModal(this);
  });

  // Close modal on close button click or overlay click
  $(modalClose).on('click', function (e) {
    resetModal(e);
  });

  $(modalOverlay).on('click', function (e) {
    resetModal(e);
  });

  $(modalClose).on('touchstart', function (e) {
    resetModal(e);
  });

  $(modalOverlay).on('touchstart', function (e) {
    resetModal(e);
  });

  $(document).keyup(function (e) {
    if (e.keyCode == 27) { // escape key maps to keycode `27`
      resetModal(e);
    }
  });


  $('.modal').keydown(function (event) {
    trapTabKey($(this), event);
  })

  $('.modal').keydown(function (event) {
    trapEscapeKey($(this), event);
  })

});

function openModal(that) {
  $(modal).removeClass('open');
  var modalToOpen = '#' + $(that).data('open-modal');
  $('body').addClass('no-scroll');
  $(modalToOpen).addClass('open');
  if (!$(that).hasClass('collections-modal')) {
    $(modalOverlay).addClass('open');
  }
  $('section').attr('aria-hidden', 'true');
  $(modal).attr('aria-hidden', 'false'); // mark the modal window as visible

  /* BEGIN GALLERY MODAL WITH SLIDER */
  if (modalToOpen === '#gallery-modal' && $('#gallery-modal .modal-item').length > 1) {
    var itemIndex = $(that).index() - 1,
        galleryPrev = '<a role="button" href="#" class="prev"><svg class="icon-chevron"><use xlink:href="#chevron-right"></use></svg></a>',
        galleryNext = '<a role="button" href="#" class="next"><svg class="icon-chevron"><use xlink:href="#chevron-right"></use></svg></a>';
    $(galleryModalContent).slick({
      dots: false,
      arrows: true,
      infinite: true,
      speed: 500,
      prevArrow: galleryPrev,
      nextArrow: galleryNext,
      slidesToShow: 1,
      slidesToScroll: 1,
      swipe: true,
      adaptiveHeight: true,
      initialSlide: itemIndex
    });
  }

  $(galleryModalContent).on('afterChange', function(event, slick, currentSlide) {
    var galleryModal = document.getElementById('gallery-modal'),
        video = galleryModal.querySelector('video');
    if (video) {
      video.pause();
    }
  });
  /* ENDs GALLERY MODAL WITH SLIDER */

  // attach a listener to redirect the tab to the modal window if the user somehow gets out of the modal window
  $('body').one('focusin', 'section', function() {
    $('.modal-close').focus();
  });

  // save current focus
  focusedElementBeforeModal = $(':focus');
}

function resetModal(e) {
  e.preventDefault();
  if($(modalVideo).length) {
    $(modalVideo).attr('src', '');
  }
  $('body').removeClass('no-scroll');
  $(modal).removeClass('open').attr('aria-hidden', 'true');
  $(modalOverlay).removeClass('open');
  $('section').attr('aria-hidden', 'false');
  $('body').off('focusin', 'section');
  if ($(galleryModalContent).children().length > 0) {
    setTimeout(function() {
      $(galleryModalContent).slick('unslick');
    }, 500);
  }
  focusedElementBeforeModal.focus();
}

function trapEscapeKey(obj, evt) {

  // if escape pressed
  if (evt.which == 27) {

    // get list of all children elements in given object
    var o = obj.find('*');

    // get list of focusable items
    var cancelElement;
    cancelElement = o.filter("#cancel")

    // close the modal window
    cancelElement.click();
    evt.preventDefault();
  }

}

function trapTabKey(obj, evt) {

  // if tab or shift-tab pressed
  if (evt.which == 9) {

    // get list of all children elements in given object
    var o = obj.find('*');

    // get list of focusable items
    var focusableItems;
    focusableItems = o.filter(focusableElementsString).filter(':visible')

    // get currently focused item
    var focusedItem;
    focusedItem = jQuery(':focus');

    // get the number of focusable items
    var numberOfFocusableItems;
    numberOfFocusableItems = focusableItems.length

    // get the index of the currently focused item
    var focusedItemIndex;
    focusedItemIndex = focusableItems.index(focusedItem);

    if (evt.shiftKey) {
      //back tab
      // if focused on first item and user preses back-tab, go to the last focusable item
      if (focusedItemIndex == 0) {
        focusableItems.get(numberOfFocusableItems - 1).focus();
        evt.preventDefault();
      }

    } else {
      //forward tab
      // if focused on the last item and user preses tab, go to the first focusable item
      if (focusedItemIndex == numberOfFocusableItems - 1) {
        focusableItems.get(0).focus();
        evt.preventDefault();
      }
    }
  }

}
