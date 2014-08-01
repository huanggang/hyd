(function ($, Drupal, window, document, undefined) {
// To understand behaviors, see https://drupal.org/node/756722#behaviors
Drupal.behaviors.slider = {
  attach: function(context, settings) {
  		$('div.view-content li:not(.ui-slide01)').remove();
      $('div.view-id-slideshow').addClass('ui-slides');
      $('div.view-content ul li').css('style', 'repeat-y; width: 200px;');
  		$('div.view-content li').each(function(){
  			//alert($(this).find('img').attr('src'));
  			$(this).css('background-image', 'url(' + $(this).find('img').attr('src') + ')');
  			$(this).css('background-position', '50% 50%');
  			$(this).find('img').remove();
  		});
		$('div.view-content').addClass('slides').attr('id', 'slidebox').bjqs({
            height      : 356,
            width       : 1351,
            responsive  : true,
            showcontrols: false,
            usecaptions : false,
        });
    
    $('.bjqs-markers')
      .addClass('slider-nav-pointer')
    	.css('margin-top', "-30px")
    	.css('padding', 3)
      .css('left', "50%")
      .css('margin-left', "-30px")
      .css('position', 'absolute')
    	.css('z-index', 99999);
  }
};





})(jQuery, Drupal, this, this.document);
