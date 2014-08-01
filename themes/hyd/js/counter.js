/**
 * @file
 * A JavaScript file for count down effect
 */
(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.counter = {
  attach: function(context, settings) {

  	var countdownStart = function (){
		    var sec = 60
		    //$('#resend').disable();
			var timer = setInterval(function() { 
			   $('#seconds').text(sec--);
			   if (sec == -1) {
			   	$('#countdown').hide();
			   	//$('#resend').enable();
			      clearInterval(timer);
			   } 
			}, 1000);
  	}

  	countdownStart();

  }
};	
})(jQuery, Drupal, this, this.document);