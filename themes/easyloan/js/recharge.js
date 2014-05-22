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

    }
  };
})(jQuery, Drupal, this, this.document);