(function ($, Drupal, window, document, undefined) {

Drupal.behaviors.findpwd = {
  attach: function(context, settings) {
    var delaytime = 3000;

    function showInfo(text, newline){
      var pre = '<span class="ui-form-required pl5">';
      if (newline){
        pre = '<br />' + pre;
      }
      var app = '</span>';
      return $(pre + text + app);
    }

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
            var m = showInfo('恭喜您，您的手机号码已成功发送，请注意查收验证码', true);
            getMobileCodeBtn.after(m.delay(delaytime).fadeOut().queue(
                function() { 
                  $(this).remove();
                  $('div.vcode').show();
                }
              )
            )
            btnCountDown("getMobileCode", 59);
          } else {
            var m = showInfo(msg[d.message]);
            getMobileCodeBtn.after(m.delay(delaytime).fadeOut());
            getMobileCodeBtn.prop('disabled', false).removeClass('ui-button-disabled');
          } 
        }, 
        "json"
      )
      .fail(function(jqxhr, textStatus, error) {
        var err = textStatus + ", " + error;
        alert( "发送验证码请求出现问题，请重试" );
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
                var m = showInfo('恭喜您，密码已发送至手机，请用收到的密码登录', true);
                $("#phone").html($('#phone').val()).removeClass('red');
                setMobileCodeBtn.after(m.delay(delaytime).fadeOut().queue(
                    function() { 
                      $(this).remove();

                      window.location.href = Drupal.settings.basePath + 'user/login';
                    }
                  )
                )
              } else {
                var m = showInfo(msg[d.message]);
                setMobileCodeBtn.after(m.delay(delaytime).fadeOut());
                setMobileCodeBtn.prop('disabled', false).removeClass('ui-button-disabled');
              } 
            }, 
            "json"
          )
          .fail(function( jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            alert( "找回密码请求失败，请重试" );
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
