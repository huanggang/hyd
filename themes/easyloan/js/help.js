// Using the closure to map jQuery to $.
(function ($) {
// Store our function as a property of Drupal.behaviors.
Drupal.behaviors.helpcenter = {
  attach: function (context, settings) {
    // Find all the secure links inside context that do not have our processed
    // class.
	$(".pg-help-main h2.h4").click(function(){
		//console.log($(this).parent().find('dl').html());
		$(this).parent().find('dl').toggle();
	});

  }
};
/*
	// You could add additional behaviors here.
	Drupal.behaviors.myModuleMagic = {
	  attach: function (context, settings) { },
	  detach: function (context, settings) { }
	};
*/
}(jQuery));