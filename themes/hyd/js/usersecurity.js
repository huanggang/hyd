(function ($, Drupal, window, document, undefined) {

Drupal.behaviors.usersecurity = {
  attach: function(context, settings) {
    var delaytime = 3000;
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

    /*
     * Load all the init information of the account
    */
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
            $("#oldMobile, #cashcodephone").html(d.mobile);
            $("#mobileCashPassStep0").addClass('fn-hide');
          } else {
            $("#setmobile").unbind('click').text('设置');
            toggleForm("setmobile", "pg-account-security-mobile", "设置");

            $("#mobileStep1, #mobileCashPassStep1").addClass('fn-hide');
            $("#mobileStep3").removeClass('fn-hide');
          }
          if (d.email_status == 1){
            $("#validemail").html(d.email).removeClass('red');
            $("#setemail").unbind('click').text('修改');
            $("#emailbinding").text(d.email);
            
            toggleForm("setemail", "pg-account-security-email", "修改");
            //$('#emailSettingForm').hide();
            //$('#emailResettingForm').show();
          }
          if (d.act_info_cash_pass== 1) {
			$("#cash_pass").html('已设置').removeClass('red');

          	$("#spModCashPswLink, #modCachePassDiv").removeClass('fn-hide');
          	$("#spSetCashPswLink, #setCachePassDiv").addClass('fn-hide');

          	$("#modCashPswLink").click(function(){
			  "取消修改" != $(this).text() ? $(this).text("取消修改"): $(this).text("修改");
			  if ("找回" != $("#findCashPswLink").text()){
			    $("#pg-account-security-find-cash-pass").hide("slow");  
			    $("#findCashPswLink").text("找回");
			  }
			  $("#pg-account-security-cash-pass").slideToggle("slow");
			}); 

			$("#findCashPswLink").click(function(){
			  "取消找回" != $(this).text() ? $(this).text("取消找回"): $(this).text("找回");
			  if ("修改" != $("#modCashPswLink").text()){
			    $("#pg-account-security-cash-pass").hide("slow");  
			    $("#modCashPswLink").text("修改");
			  }
			  $("#pg-account-security-find-cash-pass").slideToggle("slow");
			});
          } else {
			toggleForm("setCashPswLink", "pg-account-security-cash-pass", "设置");
          }
        })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "加载基本信息出现问题，请重新刷新页面" );
      });
    }
    
    loadInfo();

    /* 
     * Method to toggle a security item 
    */ 
    function toggleForm(trigger, target, showText){
      var hideText = "取消" + showText;
      $("#" + trigger).click(function(){
        showText != $(this).text() ? ($(this).text(showText),$("#" + target + " input:text, " + "#" + target + " input:password ").val("")): $(this).text(hideText);
        $("#" + target).slideToggle( "slow" );
      });
    }

    toggleForm("setname", "pg-account-security-ssn", "设置");
    toggleForm("setemail", "pg-account-security-email", "设置");
    toggleForm("setmobile", "pg-account-security-mobile", "设置");
    toggleForm("setpass", "pg-account-security-pass", "修改");

    var errPlace = function(error, element) {
        element.parent().append(error); // default function
    }

    $("#setIdForm").validate({
      errorPlacement: errPlace,
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
              setIdBtn.after(msg.delay(delaytime).fadeOut().queue(
                  function() { 
                    $(this).remove();
                    loadInfo();
                  }
                )
              );
            } else {
              if (d.verified < 2) {
                var msg = $('<span class="ui-form-required pl5">认证失败，您还可以免费认证' + (2 - d.verified) + '次</span>');  
                setIdBtn.prop('disabled', false).after(msg.delay(delaytime).fadeOut());
              } else {
                var msg = $('<span class="ui-form-required pl5">您已两次认证失败，请联系客服: 400-***-****</span>');  
                setIdBtn.after(msg).prop('disabled', true);
              }
            }
          }, 
          "json"
        )
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
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

    $("#modPswForm").validate({
      errorPlacement: errPlace,
      submitHandler: function(form) {

        $.post(
          Drupal.settings.basePath + 'api/security', 
          {
            password: $('#oldPassword').val(),
            new_password: $('#newPassword').val(),
            type: 2,
          },
          function(d) {
            var setModPswBtn = $('#subModPswBt');
            if (d.result==1) {
              var msg = $('<span class="ui-form-required pl5">成功修改密码</span>');
              setModPswBtn.after(msg.delay(delaytime).fadeOut().queue(
                  function() { 
                    $(this).remove();
                    $('#setpass').trigger('click'); 
                    $('#oldPassword, #newPassword, #newPassword2').val('');
                  }
                )
              )
            } else {
              var m = $('<span class="ui-form-required pl5">' + msg[d.message] + '</span>');  
              setModPswBtn.after(m.delay(delaytime).fadeOut());
            }
          }, 
          "json"
        )
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "修改密码请求出现问题，请重试" );
        });
      },
      rules: {
        oldPassword: {
          isPassWord: !0,
          required: !0,
          minlength: 6,
          maxlength: 16,
        },
        newPassword: {
          isPassWord: !0,
          required: !0,
          minlength: 6,
          maxlength: 16,
        },
        newPassword2: {
          required: !0,
          equalTo: '#newPassword',
        },
      },
      messages: {
        oldPassword: {
          isPassWord: "包含非法字符",
          required: "密码不能为空",
          minlength: "密码长度为6-16位字符",
          maxlength: "密码长度为6-16位字符",
        },
        newPassword: {
          isPassWord: "包含非法字符",
          required: "新密码不能为空",
          minlength: "密码长度为6-16位字符",
          maxlength: "密码长度为6-16位字符",
        },
        newPassword2: {
          required: "确认新密码不能为空",
          equalTo: "您输入的密码不一致",
        },
      },
    });

    function emailSent(){
      var msg = $('<span class="ui-form-required pl5">验证信息已发送,请前往验证!</span>');
      $("#validemail").html('未设置').addClass('red');
      $("#setemail").unbind('click').text('取消设置');
      toggleForm("setemail", "pg-account-security-email", "设置");
      $('#subSetEmailBt').after(msg.delay(delaytime).fadeOut().queue(
          function() { 
            $(this).remove(); 
            $('#setemail').trigger('click'); 
            $('#email').val('');
            $('#pg-account-security-email div.success').slideUp();
          }
        )
      )
    }

    $("#setEmailForm").validate({
      errorPlacement: errPlace,
      submitHandler: function(form) {
        $.ajax(
        {
          type: "POST",
          timeout: 1000,
          url:Drupal.settings.basePath + 'api/security', 
          data: {
                  email: $('#email').val(), 
                  type: 3,
                },
          success: function(d) {
                    var setEmailBtn = $('#subSetEmailBt');
                    if (d.result==1) {
                      emailSent();
                    } else {
                      var msg;
                      if (d.exists){
                        msg = $('<span class="ui-form-required pl5">邮箱地址已存在，请选择其它邮箱。</span>');  
                      } else {
                        msg = $('<span class="ui-form-required pl5">绑定邮箱失败，请重试</span>');  
                      }
                      setEmailBtn.after(msg.delay(delaytime).fadeOut());
                    }
                  }, 
                  dataType: "json"
        })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          if (error == 'timeout'){
            emailSent();
          } else {
            alert( "绑定邮箱失败" );
          }
          $('#subSetEmailBt').prop('enabled', true); 
        });
      },
      rules: {
        email: {
          email: !0,
          required: !0, 
        },
      },
      messages: {
        email: {
          email: "请输入有效的邮箱地址",
          required: "邮箱地址不能为空",
        },
      },
    });


    $('#getMobileCodeWithoutMobile').click(function(){
      $('#getMobileCodeWithoutMobile').prop('disabled', true).addClass('ui-button-disabled');

      $.post(
          Drupal.settings.basePath + 'api/security', 
          {
            mobile: $('#oldMobile').text(), 
            type: 5,
          },
          function(d) {
            var getMobileCodeWithoutMobile = $('#getMobileCodeWithoutMobile');

            if (d.result==1) {
              var msg = $('<br /><span class="ui-form-required pl5">恭喜您，您的手机号码已成功发送，请注意查收验证码。</span>');

              getMobileCodeWithoutMobile.after(msg.delay(delaytime).fadeOut().queue(
                  function() { 
                    $(this).remove(); 
                  }
                )
              )

              btnCountDown("getMobileCodeWithoutMobile", 59);

            } else {
              var m = $('<br /><span class="ui-form-required pl5">' + msg[d.message] + '</span>');  
              getMobileCodeWithoutMobile.after(m.delay(delaytime).fadeOut());
              $('#getMobileCodeWithoutMobile').prop('disabled', false).removeClass('ui-button-disabled');
            }
          }, 
          "json"
        )
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "发送验证码失败，请重试" ); 
          $('#getMobileCodeWithoutMobile').prop('disabled', false).removeClass('ui-button-disabled'); 
        });
    })

    $("#modMobileByPhoneStepOneForm").validate({
      errorPlacement: errPlace,
      submitHandler: function(form) {
        $.post(
          Drupal.settings.basePath + 'api/security', 
          {
            code: $('#validateCode').val(),
            mobile: $('#oldMobile').text(), 
            type: 7,
          },
          function(d) {
            var setModPswBtn = $('#subModMobileByPhoneStepOneBt');
            if (d.result==1) {
              var msg = $('<span class="ui-form-required pl5">成功解绑定手机</span>');
              setModPswBtn.after(msg.delay(delaytime).fadeOut().queue(
                  function() { 
                    $(this).remove();
                    $("#mobile").html("未设置").removeClass('red');
                    $('#mobileStep1').hide();
                    $('#mobileStep2').show();
                  }
                )
              )
            } else {
              var m = $('<span class="ui-form-required pl5">' + msg[d.message] + '</span>');
              setModPswBtn.after(m.delay(delaytime).fadeOut());
            } 
          }, 
          "json"
        )
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "解绑定手机请求出现问题，请重试" );
        });
      },
      rules: {
        validateCode: {
          number: !0,
          required: !0,
          minlength: 6,
          maxlength: 6,
        },
      },
      messages: {
        validateCode: {
          number: "验证码只能为数字",
          required: "验证码不能为空",
          minlength: "验证码长度为6位",
          maxlength: "验证码长度为6位",
        }, 
      }, 
    }); 

    $("#modMobileByPhoneStepTwoForm").validate({ 
      errorPlacement: errPlace, 
      submitHandler: function(form) { 
          $('#subModMobileByPhoneStepTwoBt').prop('disabled', true).addClass('ui-button-disabled');

          $.post(
            Drupal.settings.basePath + 'api/security', 
            {
              mobile: $('#phone').val(), 
              code: $('#validateCode2').val(), 
              type: 6,
            },
            function(d) {
              var setMobileCodeBtn = $("#subModMobileByPhoneStepTwoBt");
              if (d.result==1) {
                var msg = $('<br /><span class="ui-form-required pl5">恭喜您，您的手机号码已成功绑定</span>');
                
                $("#mobile").html($('#phone').val()).removeClass('red');
                
                setMobileCodeBtn.after(msg.delay(delaytime).fadeOut().queue(
                    function() { 
                      $(this).remove();

                      location.reload();
                    }
                  )
                )
                // $('#setmobile').trigger('click');
              } else {
                var m = $('<span class="ui-form-required pl5">' + msg[d.message] + '</span>');
                setMobileCodeBtn.after(m.delay(delaytime).fadeOut());
                setMobileCodeBtn.prop('disabled', false).removeClass('ui-button-disabled');
              } 
            }, 
            "json"
          )
          .fail(function( jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            alert( "绑定手机请求出现问题，请重试" );
            $('#subModMobileByPhoneStepTwoBt').prop('disabled', false).removeClass('ui-button-disabled');
          });
      },
      rules: {
        phone: {
          isMobile: !0,
          required: !0,
        },
        validateCode2:{
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
        validateCode2:{
          number: "验证码只能为数字",
          required: "验证码不能为空",
          minlength: "验证码长度为6位",
          maxlength: "验证码长度为6位",
        }
      },
      
    });

    $('#getMobileCode').click(function(){

      var phone = $('#phone').val(); 
      if (!/^1[3458]\d{9}$/.test(phone) || phone.length!==11) {
        // invalid phone number, trigger form submit to display errors
        $("#modMobileByPhoneStepTwoForm").submit();
        return; 
      }
      var getMobileCodeBtn = $("#getMobileCode");
      getMobileCodeBtn.prop('disabled', true).addClass('ui-button-disabled');

      $.post(
        Drupal.settings.basePath + 'api/security', 
        {
          mobile: phone, 
          type: 5,
        },
        function(d) {
          
          if (d.result==1) {
            var msg = $('<br /><span class="ui-form-required pl5">恭喜您，您的手机号码已成功发送，请注意查收验证码。</span>');
            getMobileCodeBtn.after(msg.delay(delaytime).fadeOut().queue(
                function() { 
                  $(this).remove();
                }
              )
            )
            btnCountDown("getMobileCode", 59);
          } else {
            var m = $('<span class="ui-form-required pl5">' + msg[d.message] + '</span>');
            getMobileCodeBtn.after(m.delay(delaytime).fadeOut());
            getMobileCodeBtn.prop('disabled', false).removeClass('ui-button-disabled');
          } 
        }, 
        "json"
      )
      .fail(function( jqxhr, textStatus, error) {
        var err = textStatus + ", " + error;
        alert( "绑定手机请求出现问题，请重试" );
        getMobileCodeBtn.prop('disabled', false).removeClass('ui-button-disabled');
      });
    })

    $("#modMobileByPhoneStepThreeForm").validate({ 
      errorPlacement: errPlace, 
      submitHandler: function(form) { 
          $('#subModMobileByPhoneStepThreeBt').prop('disabled', true).addClass('ui-button-disabled');

          $.post(
            Drupal.settings.basePath + 'api/security', 
            {
              mobile: $('#newphone').val(), 
              code: $('#validateCode3').val(), 
              type: 6,
            },
            function(d) {
              var setMobileCodeBtn = $("#subModMobileByPhoneStepThreeBt");
              if (d.result==1) {
                var msg = $('<br /><span class="ui-form-required pl5">恭喜您，您的手机号码已成功绑定</span>');
                
                $("#mobile").html($('#newphone').val()).removeClass('red');
                $("#setmobile").unbind('click').text('修改');
                toggleForm("setmobile", "pg-account-security-mobile", "修改");


                setMobileCodeBtn.after(msg.delay(delaytime).fadeOut().queue(
                    function() { 
                      $(this).remove();
                      //$('#setmobile').trigger('click');
                      location.reload();
                    }
                  )
                )

              } else {
                var m = $('<span class="ui-form-required pl5">' + msg[d.message] + '</span>');
                setMobileCodeBtn.after(m.delay(delaytime).fadeOut());
                setMobileCodeBtn.prop('disabled', false).removeClass('ui-button-disabled');
              } 
            }, 
            "json"
          )
          .fail(function( jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            alert( "绑定手机请求出现问题，请重试" );
            $('#subModMobileByPhoneStepThreeBt').prop('disabled', false).removeClass('ui-button-disabled');
          });
      },
      rules: {
        newphone: {
          isMobile: !0,
          required: !0,
        },
        validateCode3:{
          number:!0,
          required: !0,
          minlength: 6,
          maxlength: 6,
        }
      },
      messages: {
        newphone: {
          isMobile: "请正确填写您的手机号码",
          required: "手机号码不能为空",
        },
        validateCode3:{
          number: "验证码只能为数字",
          required: "验证码不能为空",
          minlength: "验证码长度为6位",
          maxlength: "验证码长度为6位",
        }
      },
    });

    $('#getNewMobileCode').click(function(){
      var phone = $('#newphone').val(); 
      if (!/^1[3458]\d{9}$/.test(phone) || phone.length!==11){
        // invalid phone number, trigger form submit to display errors
        $("#modMobileByPhoneStepThreeForm").submit();
        return; 
      }

      $('#getNewMobileCode').prop('disabled', true).addClass('ui-button-disabled');
      $.post(
        Drupal.settings.basePath + 'api/security', 
        {
          mobile: phone, 
          type: 5,
        },
        function(d) {
          var getMobileCodeBtn = $("#getNewMobileCode");
          if (d.result==1) {
            var msg = $('<br /><span class="ui-form-required pl5">恭喜您，您的手机号码已成功发送，请注意查收验证码。</span>');
            getMobileCodeBtn.after(msg.delay(delaytime).fadeOut().queue(
                function() { 
                  $(this).remove();
                }
              )
            )
            btnCountDown("getNewMobileCode", 59);
          } else {
            var m = $('<span class="ui-form-required pl5">' + msg[d.message] + '</span>');
            getMobileCodeBtn.after(m.delay(delaytime).fadeOut());
            getMobileCodeBtn.prop('disabled', false).removeClass('ui-button-disabled');
          } 
        }, 
        "json"
      )
      .fail(function( jqxhr, textStatus, error) {
        var err = textStatus + ", " + error;
        alert( "绑定手机请求出现问题，请重试" );
        $("#getNewMobileCode").prop('disabled', false).removeClass('ui-button-disabled');
      });

    })


    $("#setCashPswForm").validate({ 
      errorPlacement: errPlace, 
      submitHandler: function(form) { 
          $('#subSetCashPswBt').prop('disabled', true).addClass('ui-button-disabled');

          $.post(
            Drupal.settings.basePath + 'api/security', 
            {
              cash_pass: $('#cashPassword').val(), 
              type: 8,
            },
            function(d) {
              var setCashPassBtn = $("#subSetCashPswBt");
              if (d.result==1) {
                var msg = $('<br /><span class="ui-form-required pl5">恭喜您，您的提现密码已成功设置</span>');
                
                $("#cash_pass").html("已设置").removeClass('red');
                $("#spSetCashPswLink").hide();
                $("#spModCashPswLink").show();

                setCashPassBtn.after(msg.delay(delaytime).fadeOut().queue(
                    function() { 
                      $(this).remove();
                      //$('#setmobile').trigger('click');
                      location.reload();
                    }
                  )
                )

              } else {
                var m = $('<span class="ui-form-required pl5">' + msg[d.message] + '</span>');
                setCashPassBtn.after(m.delay(delaytime).fadeOut());
                setCashPassBtn.prop('disabled', false).removeClass('ui-button-disabled');
              } 
            }, 
            "json"
          )
          .fail(function( jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            alert( "设置取现密码出现问题，请重试" );

            $('#subSetCashPswBt').prop('disabled', false).removeClass('ui-button-disabled');
          });
      },
      rules: {
        cashPassword: {
          required: !0,
          isPassWord: !0,
        },
        cashPassword2:{
          equalTo: '#cashPassword'
        }
      },
      messages: {
        cashPassword: {
          required: "提现密码不能为空",
          isPassWord: "密码含有非法字符",
        },
        cashPassword2:{
    		  equalTo: "您输入的密码不一致"
        }
      },
    });

    $("#modCashPswForm").validate({ 
      errorPlacement: errPlace, 
      submitHandler: function(form) { 
          $('#subModCashPswBt').prop('disabled', true).addClass('ui-button-disabled');

          $.post(
            Drupal.settings.basePath + 'api/security', 
            {
              cash_pass: $('#cashPasswordOld').val(), 
              new_cash_pass: $('#newCashPwd').val(), 
              type: 9,
            },
            function(d) {
              var setCashPassBtn = $("#subModCashPswBt");
              if (d.result==1) {
                var msg = $('<br /><span class="ui-form-required pl5">恭喜您，您的提现密码已成功设置</span>');
                
                $("#cash_pass").html("已设置").removeClass('red');
            	$("#spSetCashPswLink").hide();
            	$("#spModCashPswLink").show();

                setCashPassBtn.after(msg.delay(delaytime).fadeOut().queue(
                    function() { 
                      $(this).remove();
                      //$('#setmobile').trigger('click');
                      location.reload();
                    }
                  )
                )

              } else {
                var m = $('<span class="ui-form-required pl5">' + msg[d.message] + '</span>');
                setCashPassBtn.after(m.delay(delaytime).fadeOut());
                setCashPassBtn.prop('disabled', false).removeClass('ui-button-disabled');
              } 
            }, 
            "json"
          )
          .fail(function( jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            alert( "设置取现密码出现问题，请重试" );

            $('#subModCashPswBt').prop('disabled', false).removeClass('ui-button-disabled');
          });
      },
      rules: {
      	cashPasswordOld:{
          isPassWord: !0, 
    			required: !0,
    			minlength: 6,
    			maxlength: 16,
      	},
        newCashPwd: {
          isPassWord: !0, 
        	required: !0,
    			minlength: 6,
    			maxlength: 16,
        },
        newCashPwd2: {
        	equalTo: '#newCashPwd'
        } 
      },
      messages: {
        cashPasswordOld: {
    			required: "密码须为6-16位英文字母、数字和符号(不包括空格)",
          isPassWord: "密码含有非法字符",
    			minlength: "密码长度至少为6个字符",
    			maxlength: "密码长度至少为16个字符",
        },
        newCashPwd: {
    			required: "密码须为6-16位英文字母、数字和符号(不包括空格)",
          isPassWord: "密码含有非法字符",
    			minlength: "密码长度至少为6个字符",
    			maxlength: "密码长度至少为16个字符",
        },
        newCashPwd2:{
      		equalTo: "您输入的密码不一致"
        }
      },
    });


$("#findCashPswFormStepOneForm").validate({ 
      errorPlacement: errPlace, 
      submitHandler: function(form) { 
          $('#subFindCashPswStepOneBt').prop('disabled', true).addClass('ui-button-disabled');

          $.post(
            Drupal.settings.basePath + 'api/security', 
              {
                code: $('#validateCode4').val(),
                new_cash_pass: $('#newFindCashPwd').val(), 
                type: 10,
              },
              function(d) { 
                var setModPswBtn = $('#subFindCashPswStepOneBt');
                if (d.result==1) {
                  var msg = $('<span class="ui-form-required pl5">设置成功</span>');
                  setModPswBtn.after(msg.delay(delaytime).fadeOut().queue(
                      function() { 
                        $(this).remove();
                        location.reload();
                      }
                    )
                  )
                } else {
                  var m = $('<span class="ui-form-required pl5">' + msg[d.message] + '</span>');
                  setModPswBtn.after(m.delay(delaytime).fadeOut());
                  $('#subFindCashPswStepOneBt').prop('disabled', false).removeClass('ui-button-disabled');
                } 
              }, 
              "json"
            )
            .fail(function( jqxhr, textStatus, error ) {
              var err = textStatus + ", " + error;
              alert( "重设密码出现问题，请重试" );
              $('#subFindCashPswStepOneBt').prop('disabled', false).removeClass('ui-button-disabled');
            });
      },
      rules: {
        validateCode4: {
          number: !0,
          required: !0,
          minlength: 6,
          maxlength: 6,
        },
        newFindCashPwd:{
          required: !0,
          isPassWord: !0,
          minlength: 6,
          maxlength: 16,
        },
        newFindCashPwd2:{
          equalTo: "#newFindCashPwd",
        }
      },
      messages: {
        validateCode4: {
          number: "验证码只能为数字",
          required: "验证码不能为空",
          minlength: "验证码长度为6位",
          maxlength: "验证码长度为6位",
        }, 
        newFindCashPwd:{
          required: "取现密码不能为空",
          isPassWord: "包含非法字符",
          minlength: "取现密码长度至少为6位",
          maxlength: "取现密码长度最多为16位",
        },
        newFindCashPwd2:{
          equalTo: "两次输入不一致",
        }
      },
      
    });

    $('#getMobileCodeFindCashPass').click(function(){
      $('#getMobileCodeFindCashPass').prop('disabled', true).addClass('ui-button-disabled');
      $.post(
          Drupal.settings.basePath + 'api/security', 
          {
            mobile: $('#oldMobile').text(), 
            type: 5,
          },
          function(d) {
            var getMobileCodeWithoutMobile = $('#getMobileCodeFindCashPass');

            if (d.result==1) {
              var msg = $('<br /><span class="ui-form-required pl5">恭喜您，您的手机号码已成功发送，请注意查收验证码。</span>');
              btnCountDown("getMobileCodeFindCashPass", 59);
              getMobileCodeWithoutMobile.after(msg.delay(delaytime).fadeOut().queue(
                  function() { 
                    $(this).remove(); 
                  }
                )
              )
            } else {
              var m = $('<br /><span class="ui-form-required pl5">' + msg[d.message] + '</span>');  
              getMobileCodeWithoutMobile.after(m.delay(delaytime).fadeOut());
              $('#getMobileCodeFindCashPass').prop('disabled', false).removeClass('ui-button-disabled');
            }
          }, 
          "json"
        )
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "发送验证码失败，请重试" ); 
          $('#getMobileCodeFindCashPass').prop('disabled', false).removeClass('ui-button-disabled'); 
        });
    })
  }
};
})(jQuery, Drupal, this, this.document);
