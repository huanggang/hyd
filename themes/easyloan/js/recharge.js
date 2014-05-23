(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.recharge = {
    attach: function(context, settings){

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
      });

      $('#rechargeAmount').ready(updateAmount).keyup(updateAmount).focusout(updateAmount);

      $('#sub-recharge').click(function(event){

      });

      $.getJSON( Drupal.settings.basePath + "api/recharge", 
        function(d) { 
          if (d.result == 0)
          {
            if (d.message == "Overtime")
            {
              var message = '充值服务时间：9:00 ~ 23:00。';
              dialogError(message);
            }
            else
            {
              var message = '尚未完成<em>实名认证</em>，请前往<a href="/account_management/security">安全信息</a>进行认证。';
              dialogError(message);
            }
          }
          else
          {
            $('#rechargeRemain').text(d.available.toFixed(2));
          }
      })
      .fail(function() {
        alert( "网络出现问题，请重新刷新页面。" );
      });


      function updateAmount(event){
        var value = $('#rechargeAmount').val();
        if (value.length == 0) {
          var error = "充值金额不能为空";
        }
        else if (Number(value) > 0) {
          value = Number(value);
          var fee = value * 0.5;
          if (fee > 10000) fee = 10000;
          else fee = Math.ceil(fee);
          fee = fee / 100;
          $('#rechargePoundage').text(fee.toFixed(2));
          var num = value + fee;
          $('#rechargePay').text(num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
        else {
          var error = "请输入正确的金额";
        }
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
        })

        $('.ui-message-close-button').click(function(){
          $('.ui-mask').click();
        })

        $('#sub-recharge').hide();
      }

    }
  };
})(jQuery, Drupal, this, this.document);