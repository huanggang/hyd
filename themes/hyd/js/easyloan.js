// Using the closure to map jQuery to $.
(function ($) {
// Store our function as a property of Drupal.behaviors.
Drupal.behaviors.headermenu = {
  attach: function (context, settings) {
    // Find all the secure links inside context that do not have our processed
    // class.
  	$("#user-menu").hover(
      function(){
      	$('#user-menu .ui-nav-dropdown').removeClass('fn-hide');
      },
      function(){
        $('#user-menu .ui-nav-dropdown').addClass('fn-hide');
      }
    );

    $("#borrow-menu").hover(
      function(){
        $('#borrow-menu .ui-nav-dropdown').removeClass('fn-hide');
      },
      function(){
        $('#borrow-menu .ui-nav-dropdown').addClass('fn-hide');
      }
    );
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