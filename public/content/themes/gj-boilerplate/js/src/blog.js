$(document).ready(function() {

  setTimeout(function() {
    $('.post').addClass('show');
  }, 50);

  var next_page = 2;

  // Handles ajax lazy load of content on the blog
  $('#load-posts a').on('click', function(e) {
    var $button, request;
    e.preventDefault();

    $button = $(this);
    request = ajaxVars.blog_url + 'page/' + next_page;

    $button.html('Loading...');

    var myContent;
    $.get(request, function(data) {
      var tempData = $('<output>').append($.parseHTML(data)).find('#blog-posts');
      myContent = tempData.html();
      $('#blog-posts').append(myContent);
      setTimeout(function() {
        $('.post').addClass('show');
      }, 50);
      next_page++;

      if(next_page > ajaxVars.num_pages){
        $button.addClass('disabled').html('No More Posts').off('click').removeAttr('href');
      } else {
        $button.html('Older Posts');
      }
    }, 'text');
  });

});