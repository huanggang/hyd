(function ($, Drupal, window, document, undefined) {


// To understand behaviors, see https://drupal.org/node/756722#behaviors
Drupal.behaviors.account = {
  attach: function(context, settings) {
  	// remove those parent menu's link 
  	$('li.ui-side-item').has('ul').find('a.ui-side-item-link').attr('href','javascript:void(0)');

  	$('a.ui-side-item-link').click(function(){
  		$(this).parent().find('ul.ui-side-sub-list').toggle();
  	})
  }
};

})(jQuery, Drupal, this, this.document);
