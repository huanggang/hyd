(function ($, Drupal, window, document, undefined) {

Drupal.behaviors.findpwd = {
  attach: function(context, settings) {

    /*
     * A count down method for a input button getting validation mobile code 
    */
    function btnCountDown(target, seconds){
      if (typeof seconds !== "number"){
        return;
      }
      var btnObj = $("input#" + target);
      
      // count down to make sure that client won't send sms so frequently 
      var countdown = setInterval(function(){
        if (seconds > -1){ 
          btnObj.val(seconds-- + '秒重新获取');
        } else { 
          clearInterval(countdown);
          btnObj.prop('disabled', false).removeClass('ui-button-disabled').val('获取验证码');          
        }
      }, 1000);
    }

    var errPlace = function(error, element) {
        element.parent().append(error); // default function
    }

    $('#getMobileCode').click(function(){
      var phone = $('#phone').val(); 
      if (!/^1[34578]\d{9}$/.test(phone) || phone.length!==11) {
        // invalid phone number, trigger form submit to display errors
        $("#user-pass").submit();
        return; 
      }

      var getMobileCodeBtn = $("#getMobileCode");
      getMobileCodeBtn.prop('disabled', true).addClass('ui-button-disabled');

      $.post(
        Drupal.settings.basePath + 'api/findpwd',
        {
          mobile: phone, 
          type: 1,
        },
        function(d) {
            if (d.result==1) {
            var msg = $('<br /><span class="ui-form-required pl5">恭喜您，您的手机号码已成功发送，请注意查收验证码。</span>');
            getMobileCodeBtn.after(msg.delay(1000).fadeOut().queue(
                function() { 
                  $(this).remove();
                }
              )
            )
            btnCountDown("getMobileCode", 59);
          } else {
            var msg = $('<span class="ui-form-required pl5">验证码发送失败，请重试</span>');
            getMobileCodeBtn.after(msg.delay(1000).fadeOut());
            getMobileCodeBtn.prop('disabled', false).removeClass('ui-button-disabled');
          } 
        }, 
        "json"
      )
      .fail(function(jqxhr, textStatus, error) {
        var err = textStatus + ", " + error;
        alert( "绑定手机请求出现问题，请重试" );
        getMobileCodeBtn.prop('disabled', false).removeClass('ui-button-disabled');
      });
    })

    $("#user-pass").validate({ 
      errorPlacement: errPlace, 
      submitHandler: function(form) { 
          $('#subNotLoginFindPswByMobileFormBt').prop('disabled', true).addClass('ui-button-disabled');

          $.post(
            Drupal.settings.basePath + 'api/findpwd', 
            {
              mobile: $('#phone').val(), 
              code: $('#validateCode').val(), 
              type: 2,
            },
            function(d) {
              var setMobileCodeBtn = $("#subNotLoginFindPswByMobileFormBt");
              if (d.result==1) {
                var msg = $('<br /><span class="ui-form-required pl5">恭喜您，您的手机号码已成功绑定</span>');
                
                $("#phone").html($('#phone').val()).removeClass('red');
                
                setMobileCodeBtn.after(msg.delay(2000).fadeOut().queue(
                    function() { 
                      $(this).remove();

                      location.reload();
                    }
                  )
                )
                // $('#setmobile').trigger('click');
              } else {
                var msg = $('<span class="ui-form-required pl5">绑定手机失败，请重试</span>');
                setMobileCodeBtn.after(msg.delay(1000).fadeOut());
                setMobileCodeBtn.prop('disabled', false).removeClass('ui-button-disabled');
              } 
            }, 
            "json"
          )
          .fail(function( jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            alert( "绑定手机请求出现问题，请重试" );
            $('#subNotLoginFindPswByMobileFormBt').prop('disabled', false).removeClass('ui-button-disabled');
          });
      },
      rules: {
        phone: {
          isMobile: !0,
          required: !0,
        },
        validateCode:{
          number:!0,
          required: !0,
          minlength: 6,
          maxlength: 6,
        }
      },
      messages: {
        phone: {
          isMobile: "请正确填写您的手机号码",
          required: "手机号码不能为空",
        },
        validateCode:{
          number: "验证码只能为数字",
          required: "验证码不能为空",
          minlength: "验证码长度为6位",
          maxlength: "验证码长度为6位",
        }
      },
    });


  }
};
})(jQuery, Drupal, this, this.document);
