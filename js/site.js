jQuery(document).ready(function($){

  var menu = $('#leftNav').find('.pagenav')
  menu.find('li')
    .filter( function() {
      return $(this).children('ul').length == 1
    }).addClass('selectedArrow')
    .children('a')
      .click(function(){
        $(this).parent()
          .toggleClass('trikiti').children('ul').slideToggle(200)
        return false;
      })

});

/* --------- Search box clear --------- */

jQuery(document).ready(function($) {
	$(".wTextInput").focus(function () {
		if ($(this).val() === $(this).attr("title")) {
			$(this).val("");
		}
	}).blur(function () {
		if ($(this).val() === "") {
			$(this).val($(this).attr("title"));
		}
	});
});
