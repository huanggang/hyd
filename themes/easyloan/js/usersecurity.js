(function ($, Drupal, window, document, undefined) {

Drupal.behaviors.usersecurity = {
  attach: function(context, settings) {

    function loadInfo(){
      $.getJSON( Drupal.settings.basePath + "api/basic", 
        function(d) { 
          if (d.ssn_status == 1){
            $("#name").html(d.name);
            $("#ssn").html(d.ssn).removeClass('red');
            $('#pg-account-security-ssn').remove();
          } 
          if (d.mobile_status == 1){
            $("#mobile").html(d.mobile).removeClass('red');
          } 
          if (d.email_status == 1){
            $("#email").html(d.email).removeClass('red');
          } 
        })
      .fail(function() {
        alert( "加载基本信息出现问题，请重新刷新页面" );
      });  
    }
    
    loadInfo();

    function toggleForm(trigger, target, hideText, showText){
      $("#" + trigger).click(function(){
        showText != $(this).text() ? $(this).text(showText): $(this).text(hideText);
        $("#" + target).slideToggle( "slow" );
      });
    }

    toggleForm("setname", "pg-account-security-ssn", "取消设置", "设置");
    toggleForm("setemail", "pg-account-security-email", "取消设置", "设置");
    toggleForm("setmobile", "pg-account-security-mobile", "取消修改", "修改");
    toggleForm("setpass", "pg-account-security-pass", "取消修改", "修改");


    $("#modCashPswLink").click(function(){
      "取消修改" != $(this).text() ? $(this).text("取消修改"): $(this).text("修改");
      
      if ("找回" != $("#findCashPswLink").text()){
        $("#pg-account-security-find-cash-pass").hide( "slow" );  
        $("#findCashPswLink").text("找回");
      }
      $("#pg-account-security-cash-pass").slideToggle( "slow" );
    }); 

    $("#findCashPswLink").click(function(){
      "取消找回" != $(this).text() ? $(this).text("取消找回"): $(this).text("找回");

      if ("修改" != $("#modCashPswLink").text()){
        $("#pg-account-security-cash-pass").hide( "slow" );  
        $("#modCashPswLink").text("修改");
      }
      $("#pg-account-security-find-cash-pass").slideToggle( "slow" );

    }); 




    function isDate(a, b, c) {
      if (isNaN(a) || isNaN(b) || isNaN(c)) return !1;
      if (b > 12 || 1 > b) return !1;
      if (1 > c || c > 31) return !1;
      if ((4 == b || 6 == b || 9 == b || 11 == b) && c > 30) return !1;
      if (2 == b) {
          if (c > 29) return !1;
          if ((0 === a % 100 && 0 !== a % 400 || 0 !== a % 4) && c > 28) return !1
      }
      return !0
    }


    $.validator.addMethod("isIdCardNo", function (value, element) {
        return this.optional(element) || isIdCardNo(value);
    }, "请正确输入您的身份证号码");

    $.validator.addMethod("isRealName", function (value, element) {
        return /^[\u4E00-\u9FA5]+$/.test(value);
    }, "包含非法字符");

    $.validator.addMethod("isIdCardNo", function (value, element) {
      if (18 != value.length) return !1;
      var b;
      if (b = /^\d{17}(\d|x|X)$/, !b.exec(value)) return !1;
      if (!isDate(value.substring(6, 10), value.substring(10, 12), value.substring(12, 14))) return !1;

      for (var c = ["1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2"], 
              d = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1], 
              f = 0, g = 0; g < value.length - 1; g++) f += value.substring(g, g + 1) * d[g];
      return f %= 11, value.substring(value.length - 1, value.length).toUpperCase() != c[f] ? !1 : !0

    }, "请输入正确的二代身份证号码");

    $("#setIdForm").validate({
      errorPlacement: function(error, element) {
        element.parent().append(error); // default function
      },
      submitHandler: function(form) {
        $('#subSetIdBt').prop('disabled', true);

        $.post(
          Drupal.settings.basePath + 'api/security', 
          {
            name: $('#realName').val(),
            ssn: $('#idNo').val(),
            type: 1,
          },
          function(d) {
            var setIdBtn = $('#subSetIdBt');
            if (d.result==1) {
              var msg = $('<span class="ui-form-required pl5">成功保存用户消息</span>');
              setIdBtn.after(msg.delay(1000).fadeOut().queue(
                  function() { 
                    $(this).remove();
                    loadInfo();
                  }
                )
              );

            } else {
              if (d.verified < 2) {
                var msg = $('<span class="ui-form-required pl5">认证失败，您还可以免费认证' + (2 - d.verified) + '次</span>');  
                setIdBtn.prop('disabled', false).after(msg.delay(1000).fadeOut());
              } else {
                var msg = $('<span class="ui-form-required pl5">您已两次认证失败，请联系客服: 400-***-****</span>');  
                setIdBtn.after(msg).prop('disabled', true);
              }
            }
          }, 
          "json"
        )
        .fail(function() {
          alert( "加载基本信息出现问题，请重新刷新页面" );
          $('#subSetIdBt').prop('enabled', true);
        });
      },
      rules: {
        realName: {
          required: true,
          isRealName: true,
          minlength: 2,
        },
        idNo: {
          required: true,
          isIdCardNo: true,
        },
      },
      messages: {
        realName: {
          required: "真实姓名不能为空",
          isRealName: "包含非法字符",
          minlength: "请输入完整的真实姓名",
        },
        idNo: {
          required: "身份证号不能为空",
          isIdCardNo: "请正确输入您的二代身份证号码",
        },
      },
    });















  }
};

})(jQuery, Drupal, this, this.document);
