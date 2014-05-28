(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.withdraw = {
    attach: function(context, settings){

    	$('#tips').hover(function(event){
        $('#tipCon').show();
      }, function(event){
        $('#tipCon').hide();
      });

      var date = new Date();
      var day = date.getDay();
      var days = 2;
      switch (day){
      	case 4: // thursday
      	case 5: // friday
      	  days = 4;
      	  break;
      	case 6: // saturday
      	  days = 3;
      	  break;
      }
      date = new Date(date.getTime() + days*24*3600*1000);
      $('#withdrawDate').text(date.getFullYear().toString() + '-' + (date.getMonth()+1).toString() + '-' + date.getDate().toString());

      $('#withdrawAmount').ready(updateAmount).keyup(updateAmount2).focusout(updateAmount);

      $('#subWithdraw').click(function(event){
        var flag = true;
        var bankid = $('#bankId').val();
        if (!(Number(bankid) > 0)){
          $("label[for='bankId']").show();
          flag = false;
        }
        var number = $('#cardNumber').val();
        var amount = $('#withdrawAmount').val();
        if (!(Number(amount) > 0)){
          showAmountError();
          flag = false;
        }
        var fee = $('#withdrawFee').text();
        if (!(Number(fee) > 0)){
          flag = false;
        }
        var cash_pass = $('#cashPassword').val();
        if (!flag) return;

        $.getJSON(Drupal.settings.basePath + "api/withdraw?number="+number+"&amount="+amount+"&fee="+fee+"&cash_pass="+cash_pass,
          function(d) {
            if (d.result==1) {

            }
            else {

            }
          }, "json"
        )
        .fail(function() {
          alert( "后台验证出现问题，请重新刷新页面" );
        });

      });

      $.getJSON( Drupal.settings.basePath + "api/recharge", 
        function(d) {
          if (d.result == 0) {
            if (d.message == "Overtime") {
              var message = '充值服务时间：9:00 ~ 23:00。';
              dialogError(message);
            } else {
              var message = '尚未完成<em>实名认证</em>，请前往<a href="/account_management/security">安全信息</a>进行认证。';
              dialogError(message);
            }
          } else {
	          $('#withdrawRemain').text(d.available.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
	        }
      })
      .fail(function() {
        alert( "网络出现问题，请重新刷新页面。" );
      });


      function updateAmount2(event){
        $('#amountModified').val("1");
        updateAmount(event);
      }

      function updateAmount(event){
        var value = $('#withdrawAmount').val();
        if (Number(value) > 0) {
          value = Number(value);
          var fee = 1;
          if (value >= 50000) fee = 5;
          else if (value >= 20000) fee = 3;
          $('#withdrawFee').text(fee.toFixed(2));
          var num = value + fee;
          $('#withdrawReal').text(num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          $("label[for='withdrawAmount']").hide();
        }
        else {
          var amountModified = $('#amountModified').val();
          if (Number(amountModified) == 0) {
            $("label[for='withdrawAmount']").hide();
          }
          else {
            showAmountError();
          }
        }
      }

      function showAmountError(){
        var value = $('#withdrawAmount').val();
        var error = "";
        if (value.length == 0) {
          error = "提现金额不能为空";
        }
        else if (!(Number(value) > 0)) {
          error = "请输入正确的金额";
        }
        $("label[for='withdrawAmount']").show().text(error);
      }


      function dialogError(message){
        var html = '<div data-widget-cid="widget-0" class="ui-mask" style="position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; z-index: 99998; opacity: 0.85; background-color: rgb(255, 255, 255);"></div><div class="ui-dialog" tabindex="-1" data-widget-cid="widget-1" style="width: 500px; z-index: 99999; position: absolute; left: 0px; top: 0px;"><div style="display: block;" class="ui-dialog-close" title="关闭本框" data-role="close">×</div><div style="background: none repeat scroll 0% 0% rgb(255, 255, 255); height: 100%;" class="ui-dialog-content" data-role="content"><div class="ui-message-content"><div class="fn-clear"><div class="ui-message-icon fn-left"><i class="iconfont fn-left error" title="错误"></i></div><div class="ui-message-text fn-left"><p class="text-big">'
        + message
        + '</p></div></div><div class="ui-message-operation text-center mt20"><a class="ui-button ui-button-blue ui-button-mid ui-message-close-button">关闭</a></div></div></div></div>';
        $('body').append(html);
        $( window ).resize(function() {
          $('.ui-dialog').position({
            my: "center",
            at: "center",
            of: window
          });
        });
        $(window).resize();

        $('.ui-mask').click(function(){
          $(this).remove();
          $('.ui-dialog').remove();
        });

        $('.ui-dialog-close').click(function(){
          $('.ui-mask').click();
        });

        $('.ui-message-close-button').click(function(){
          $('.ui-mask').click();
        });

        $('#subWithdraw').hide();
      }

    }
  };
})(jQuery, Drupal, this, this.document);