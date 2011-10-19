jQuery(document).ready(function($){
  var body = $('body');

  //setup css
 // slider.css({
 //   position:'relative',
 //   marginTop: '52px'
 // });

  $.fn.slideBlog = function(direction) {
    var slider = $('#slider');
    var el = $(this);
    var comments = $('#comments');
    var article = $('#slider article');
    var article_width = article.width();

    comments.fadeOut(function() {
    article.css({
        position:'absolute',
        'width':article_width
    });

    $('#content').css({
      overflow:'hidden'
    });

    slider.css({
       height: article.height(),
       width: '200%', 
       position: 'relative' 
    });
});
    
    $.get(this.attr('href'), function(data){
      body.removeClass('getting-post');
      var $data = $(data);


      $('#nav-single').replaceWith($data.find('#nav-single'));

      var new_el = $data.find('#slider article').css({
        position:'absolute',
        'left': (direction == 'next' ) ? 2 * article_width : -1 * article_width,
        'width':article_width
      });

      slider.append(new_el).height(new_el.height())
        .animate({
          left: (direction == 'next' ) ?-2 * article_width : article_width 
        }, 300, function() {
         $(this).removeAttr('style').css({
           position:'relative',
           marginTop: '52px'
         }).find('article').removeAttr('style').not(new_el).remove();
         comments.stop().replaceWith($data.find('#comments').hide().fadeIn());
        })
  
    }); 

  };

  $('#bgSliceMiddle #nav-single a').live('click', function() {
      if(Modernizr.history) {
        event.preventDefault();
        if( this.href == location.href ) return false;
        body.addClass('getting-post');
        history.pushState({ path: this.path }, '', this.href);
        $(this).slideBlog(this.rel)
        return false;
      }
  });

});
