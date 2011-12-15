jQuery(document).ready(function($){

  $.fn.proxyFade = function() {
    return $(this).each(function() {
      if(Modernizr.history) {
        event.preventDefault();
        if( this.href == location.href ) return false;
        history.pushState({ path: this.path }, '', this.href);
        $('#primary').animate({'opacity':0.4}, 200);
        $.get(this.href, function(data){
          $data = $(data);
          $data.find('#commentform').addClass('form-stacked'); // [todo] see below

          $('#primary').stop().replaceWith($data.find('#primary').hide().fadeIn(200))
            .css('opacity',1);
          
          var old_img = $('a.banner').children('img');
          var new_img = $data.find('a.banner').children('img').hide();

          if( old_img.attr('src') != new_img.attr('src') ) {
            new_img.bind('load', function() { 
              $(this).unbind('load');
              $('.banner').append(new_img)
                .children('img').first()
                .fadeOut(200, function() {
                  $(this).remove();
                });
              $(this).fadeIn(200);
            });
          }

        });
        return false;
      }
  });
  };

  /* Left navigation - 
   *   clones a link as the first link in 
   *   the accordion
   */
  var menu = $('#leftNav').find('.menu'), clicked = [], classname = '';
  menu.find('li')
    .first().addClass('selectedAccordion navSectionHead')
      .end()
    .filter( function() {
      var $this = $(this),
          ul = $this.children('ul');
      classname = ( menu.attr('id') == 'menu-custom-menu' ) ? 'current-menu-item' : 'current_page_item';

      if( $this.hasClass(classname) ) {
        var el = ($this.closest('ul').closest('li').length > 0 ) ? $this.closest('ul').closest('li') : $this;
        el.removeClass(classname).addClass('trikiti');
      }
      if (ul.length == 1) {
        var el = $this.clone().removeClass('trikiti');
        if ( $this.closest('li').hasClass('trikiti') ) {
          ul.show(); 
        }
        el.children('ul').remove().end().prependTo(ul);
        return true;
      }
    }).addClass('selectedArrow')
    .children('a')
      .click(function(){
        var $this = $(this);
        if ( $this.parent().hasClass('trikiti')) return false;
        $this.parent()
          .toggleClass('trikiti').children('ul').slideToggle(200)
           .end()
          .siblings('.trikiti').toggleClass('trikiti').children('ul').slideToggle(200)

        return false;
      })
    /* popstate */
    .end().end()
    .find('a')
    .filter(function() {
      return $(this).siblings('ul').length === 0 
    })
    .click( function() {
      $(this).proxyFade()
        .parent().closest('li').siblings('.trikiti').removeClass('trikiti').children('ul').slideToggle(200);
    });

    $('.banner').click(function() { $(this).proxyFade(); });
    $('.entry-title a').live('click', function() { $(this).proxyFade(); });

/*----- handle back navigation -----*/
  var popped = ('state' in window.history), initialURL = location.href
  $(window).bind('popstate', function() {
      var initialPop = !popped && location.href == initialURL
      popped = true
      if ( initialPop ) return
    
      $.get(location.pathname, function(data){
        $data = $(data);
        $('#primary').fadeOut(200, function() {
          $(this).html($data.find('#primary'))
          .fadeIn(200);
        });
      });
  });
   

/* --------- Search box clear --------- */
	$(".wTextInput").focus(function () {
		if ($(this).val() === $(this).attr("title")) {
			$(this).val("");
		}
	}).blur(function () {
		if ($(this).val() === "") {
			$(this).val($(this).attr("title"));
		}
	});

/* ---- Weather widget ----- */
  $('#weather').weather();

/* ---- Comment form [TODO] will change when WP gives the option to do so with php ---- */
  $('#commentform').addClass('form-stacked');

});
