(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.list = {
    init: function(){
      // remove those parent menu's link 
      $('li.ui-filter-tag').click(function(){
        $(this).siblings().removeClass('active').find('input[checked]').attr('checked', null).end().end()
          .addClass('active').find('input').attr('checked', 'checked');
      });
    }
  };
})(jQuery, Drupal, this, this.document);
