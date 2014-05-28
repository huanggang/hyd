(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.recharge = {
    attach: function(context, settings){

      $('#bankId').val('');
      $('#amountModified').val('0');

      $('#banks').empty().append('<dt>充值银行</dt>');
      var len = banks.length;
      for (var i = 0; i < len; i++){
        var id = banks[i].id;
        var name = banks[i].name;
        var dd = '<dd><input type="radio" name="bank" data-type="QUICKPAY" value="' + id + '" id="bank_' + id +'"><label for="bank_' + id + '"><img alt="' + name + '" title="' + name + '" src="' + image_path + 'bank_' + id + '.jpg"></label></dd>';
        $('#banks').append(dd);
      }
      
      $('#tips').hover(function(event){
        $('#tipCon').show();
      }, function(event){
        $('#tipCon').hide();
      });

      $("input[name='bank']").click(function(event){
        $('#bankId').val($(this).val());
        $("label[for='bank']").hide();
      });

      $('#rechargeAmount').ready(updateAmount).keyup(updateAmount2).focusout(updateAmount);

      $('#sub-recharge').click(function(event){
        var flag = true;
        var bankid = $('#bankId').val();
        if (!(Number(bankid) > 0)){
          $("label[for='bank']").show();
          flag = false;
        }
        var amount = $('#rechargeAmount').val();
        if (!(Number(amount) > 0)){
          showAmountError();
          flag = false;
        }
        var fee = $('#rechargePoundage').text();
        if (!(Number(fee) > 0)){
          flag = false;
        }
        if (!flag) return;

        $.getJSON(Drupal.settings.basePath + "api/recharge?type=2&bank="+bankid+"&amount="+amount+"&fee="+fee,
          function(d) {
            if (d.result==1) {
              dialogGuiding();
              // open a new window, which redirect to the recharge page of the third party

            }
          }, "json"
        )
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
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
            $('#rechargeRemain').text(d.available.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          }
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "网络出现问题，请重新刷新页面。" );
      });


      function updateAmount2(event){
        $('#amountModified').val("1");
        updateAmount(event);
      }

      function updateAmount(event){
        var value = $('#rechargeAmount').val();
        if (Number(value) >= 1 && Number(value) <= 300000) {
          value = Number(value);
          var fee = value * 0.5;
          if (fee > 10000) fee = 10000;
          else fee = Math.ceil(fee);
          fee = fee / 100;
          $('#rechargePoundage').text(fee.toFixed(2));
          var num = value + fee;
          $('#rechargePay').text(num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          $("label[for='rechargeAmount']").hide();
        }
        else {
          var amountModified = $('#amountModified').val();
          if (Number(amountModified) == 0) {
            $("label[for='rechargeAmount']").hide();
          }
          else {
            showAmountError();
          }
        }
      }

      function showAmountError(){
        var value = $('#rechargeAmount').val();
        var error = "";
        if (value.length == 0) {
          error = "充值金额不能为空";
        }
        else if (!(Number(value) >= 0)) {
          error = "请输入正确的金额";
        }
        else if (Number(value) < 1 || Number(value) > 300000) {
          error = "单笔充值金额应大于或等于1元且小于或等于30万元";
        }
        $("label[for='rechargeAmount']").show().text(error);
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

        $('#sub-recharge').hide();
      }


      function dialogGuiding(){
        var html = '<div data-widget-cid="widget-0" class="ui-mask" style="position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; z-index: 99998; opacity: 0.85; background-color: rgb(255, 255, 255); display: block;"></div><div class="ui-dialog" tabindex="-1" data-widget-cid="widget-3" style="width: 500px; z-index: 99999; position: absolute; left: 0px; top: 0px;"><div data-role="close" title="关闭本框" class="ui-dialog-close" style="display: block;">×</div><div data-role="content" class="ui-dialog-content" style="background: none repeat scroll 0% 0% rgb(255, 255, 255); height: 100%;"><div class="afterSub" id="afterSub"><h3>请您在新打开的网上银行页面上完成付款</h3><p>付款完成前请不要关闭此窗口。</p><p>完成付款后请根据您的情况点击下面的按钮：</p><a id="finishRecharge" class="ui-button ui-button-mid ui-button-green">已完成付款</a> <a id="troubleRecharge" class="ui-button ui-button-mid ui-button-green">付款遇到问题</a></div></div></div>';
        $('body').append(html);
        $( window ).resize(function() {
          $('.ui-dialog').position({
            my: "center",
            at: "center",
            of: window
          });
        });
        $(window).resize();

        $('#finishRecharge').click(function(){
          $('.ui-mask').remove();
          $('.ui-dialog').remove();

          location.reload();
        });

        $('#troubleRecharge').click(function(){
          $('.ui-mask').remove();
          $('.ui-dialog').remove();

          location.reload();
        });

      }

    }
  };
})(jQuery, Drupal, this, this.document);