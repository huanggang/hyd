(function ($) {


  Drupal.behaviors.imageCaptchaRefresh = {

    attach: function (context) {
      $('#refreshCode', context).bind('click', function () {
        var $form = $(this).parents('form');
        // send post query for getting new captcha data
        var date = new Date();
        var link = $('.reload-captcha');
        var url = link.prop('href') + '?' + date.getTime();
        $.get(
          url,
          {},
          function (response) {
            if(response.status == 1) {
              $('.captcha', $form).find('img').first().attr('src', response.data.url);
              $('input[name=captcha_sid]', $form).val(response.data.sid);
              $('input[name=captcha_token]', $form).val(response.data.token);
            }
            else {
              alert(response.message);
            }
          },
          'json'
          );
        return false;
      });

      $(".reload-captcha-wrapper").hide();
    }


  };



})(jQuery);