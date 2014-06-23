/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {

// To understand behaviors, see https://drupal.org/node/756722#behaviors
Drupal.behaviors.tab = {
  attach: function(context, settings) {

    $('.ui-tab-item').click(function(){
      var tabname = $(this).addClass('ui-tab-item-current').attr('data-name');
      $('.ui-tab-item').not(this).removeClass('ui-tab-item-current');

      $('div.ui-tab-content').removeClass('ui-tab-content-current').filter(function(index){
        return tabname == $(this).attr('data-name');
      }).addClass('ui-tab-content-current');
    });
  }
};


})(jQuery, Drupal, this, this.document);
