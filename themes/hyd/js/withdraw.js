(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.withdraw = {
    attach: function(context, settings){

      $('#bankId').val('');
      $('#cardNumber').val('');
      $('#amountModified').val('0');
      $('#cashPassModified').val('0');

      $('#tips').hover(function(event){
        $('#tipCon').show();
      }, function(event){
        $('#tipCon').hide();
      });

      $('#moreBank').click(function(event) {
        var style = $('#banklis').attr('style');
        if (style == 'height:auto'){
          $('#banklis').removeAttr('style');
          $(this).text('更多银行卡');
        }
        else {
          $('#banklis').attr("style","height:auto");
          $(this).text('隐藏部分银行卡');
        }
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

      $('#cashPassword').ready(valiadateCashPass).keyup(valiadateCashPass2).focusout(valiadateCashPass);

      $('#subWithdraw').click(function(event){
        var flag = true;
        var bankid = $('#bankId').val();
        if (!(Number(bankid) > 0)){
          $("label[for='bankId']").show();
          flag = false;
        }
        var number = $('#cardNumber').val();

        var available = Number($('#withdrawRemain').text().replace(/,/g, ""));
        var amount = Number($('#withdrawAmount').val());
        var fee = Number($('#withdrawFee').text());
        if (!(fee > 0)){
          flag = false;
        }
        if (!(amount >= 1 && amount <= 1000000 && (amount+fee) <= available)){
          showAmountError();
          flag = false;
        }
        var cash_pass = $('#cashPassword').val();
        if (!valiadateCashPass2()) {
          flag = false;
        }
        if (!flag) return;

        $.getJSON(Drupal.settings.basePath + "api/withdraw?number="+number+"&amount="+amount+"&fee="+fee+"&cash_pass="+cash_pass,
          function(d) {
            if (d.result==1) {
              location.reload();
            }
            else {
              var message = "后台验证出现问题，请稍后重试";
              if (d.message == "Not enough money")
              {
                message = "可用资金不足";
              }
              else if (d.message == "Invalid bank card number")
              {
                message = "银行卡卡号错误";
              }
              else if (d.message == "Invalid cash password")
              {
                message = "提现密码错误";
              }
              alert(message);
            }
          }, "json"
        )
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "后台验证出现问题，请刷新页面" );
        });

      });

      $.getJSON( Drupal.settings.basePath + "api/recharge", 
        function(d) {
          if (d.result == 0) {
            if (d.message == "Overtime") {
              var message = '充值服务时间：9:00 ~ 23:00。';
              dialogError(message);
            } else {
              var message = '尚未完成<em>实名认证</em>，请前往<a href="/account_management/security">安全信息</a>认证。';
              dialogError(message);
            }
          } else {
            $('#withdrawRemain').text(d.available.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            if (d.has_cash_pass == 0){
              var message = '尚未设置<em>提现密码</em>，请前往<a href="/account_management/security">安全信息</a>设置。';
              dialogError(message);
            }
          }
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "网络出现问题，请刷新页面。" );
      });

      $.getJSON( Drupal.settings.basePath + "api/banks", 
        function(d) {
          var html = '';
          if (d.total > 0) {
            for (var i = 0; i < d.total; i++) {
              var card = d.numbers[i];
              var bankId = card.bank;
              var number = card.number;
              html += '<li class="bankli" data-bank="' + bankId + '" data-number="' + number + '"><img alt="" title="" src="' + image_path + 'bank_' + bankId + '.jpg"><div class="card">' + number + '</div><em></em></li>';
            }
          }
          var addCard = $('#banklis ul').children().last();
          $(addCard).prevAll().remove();
          $('#banklis ul').prepend(html);
          
          $('.bankli').click(function(event) {
            $("label[for='bankId']").hide();
            $('.bankli').removeClass('checked');
            $(this).addClass('checked');
            $('#bankId').val($(this).attr('data-bank'));
            $('#cardNumber').val($(this).attr('data-number'));
          });
          if (d.total <= 3) {
            $('#moreBank').hide();
          }
          else {
            $('#moreBank').show();
          }
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "网络出现问题，请刷新页面。");
      });
    

      function updateAmount2(event){
        $('#amountModified').val("1");
        updateAmount(event);
      }

      function updateAmount(event){
        var available = Number($('#withdrawRemain').text().replace(/,/g, ""));
        var value = Number($('#withdrawAmount').val());
        if (value >= 1 && value <= 1000000 && value < available) {
          var fee = 1;
          if (value >= 50000) fee = 5;
          else if (value >= 20000) fee = 3;
          $('#withdrawFee').text(fee.toFixed(2));
          var num = value + fee;
          $('#withdrawReal').text(num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          $("label[for='withdrawAmount']").hide();
          if (available < num){
            error = "您的账户余额不足";
            $("label[for='withdrawAmount']").show().text(error);
          }
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
        else if (!(Number(value) >= 0)) {
          error = "请输入正确的金额";
        }
        else if (Number(value) < 1) {
          error = "提现金额不能小于1元";
        }
        else if (Number(value) > 1000000) {
          error = "提现金额不能大于100万元";
        }
        else {
          error = "您的账户余额不足";
        }
        $("label[for='withdrawAmount']").show().text(error);
      }

      function valiadateCashPass2(event){
        $('#cashPassModified').val("1");
        return valiadateCashPass(event);
      }

      function valiadateCashPass(event){
        var cash_pass = $('#cashPassword').val();
        var error = "";
        var flag = true;
        var regex = /^[a-z0-9~`!@#\$%\^&\*\-_\+=\(\)\{\}\[\]\|:;\"\'\<\>\.,\?\/]{1,40}$/i;
        if (cash_pass.length == 0){
          error = "提现密码不能为空";
          flag = false;
        }
        else if (!regex.test(cash_pass)) {
          error = "包含非法字符";
          flag = false;
        }
        if (!flag) {
          var cashPassModified = $('#cashPassModified').val();
          if (Number(cashPassModified) == 0) {
            $("label[for='cashPassword']").hide();
          }
          else {
            $("label[for='cashPassword']").show().text(error);
          }
        }
        else {
          $("label[for='cashPassword']").hide();
        }
        return flag;
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