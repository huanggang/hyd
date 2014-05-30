(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.bankcard = {
    attach: function(context, settings){

      var account_name = null;

      $('.addBank').click(function addCard(event) {
        var html = '<div data-widget-cid="widget-0" class="ui-mask" style="position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; z-index: 99998; opacity: 0.85; background-color: rgb(255, 255, 255);"></div><div class="ui-dialog" tabindex="-1" data-widget-cid="widget-1" style="height: 468px; width: 650px; z-index: 99999; position: absolute; left: 0x; top: 0px;"><div data-role="close" title="关闭本框" class="ui-dialog-close" style="display: block;">×</div><div style="border: medium none; width: 100%; display: block; height: 100%; overflow: hidden;"><div data-role="content" class="ui-dialog-content" style="background: none repeat scroll 0% 0% rgb(255, 255, 255); height: 100%; overflow: hidden"><div class="ui-confirm" id="pg-addcard"><form id="addcardForm" method="post" class="ui-form" data-name="addcard" novalidate="novalidate"><h3 class="ui-confirm-title" style="margin-top: -10px">添加银行卡</h3><div class="inputs"><div class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>开户名</label><em id="account_name"></em> <span class="info">请添加相同开户名的银行卡</span></div><div class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>选择银行</label><select name="bankDataId" style="width:160px" id="selBankType"><option value="-1">请选择</option>';
        var options = '';
        for (var i = 0; i < banks.length; i++){
          options += '<option value="' + banks[i].id + '">' + banks[i].name + '</option>';
        }
        html += options + '</select><label for="selBankType" class="error" style="display: none;"></label></div><div style="z-index:19;" class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>开户行</label><input type="text" id="cardDeposit" name="deposit" class="ui-input"><label for="cardDeposit" class="error" style="display: none;"></label></div><div style="position: relative;" class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>开户行所在地</label><input type="text" disableautocomplete="" autocomplete="off" id="bank_area" name="address" class="ui-input"><label for="bank_area" class="error" style="display: none;"></label></div><div class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>银行卡号</label><input type="text" data-is="isBankCard" id="cardId" name="cardId" class="ui-input"><label for="cardId" class="error" style="display: none;"></label></div><div class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>确认卡号</label><input type="text" onpaste="return false" data-is="isBankCard" id="cardReId" name="reBankCard" class="ui-input"><label for="cardReId" class="error" style="display: none;"></label></div></div><div class="serverMsg" id="serverMsg"></div><div class="bts"><input type="button" value="新 增" id="add-card-button" class="ui-button ui-button-mid ui-button-green"><input type="reset" value="取 消" class="ui-button ui-button-mid ui-button-gray" id="close"></div></form><div class="notice"><div class="title">温馨提示</div><ol><li>1、如果您填写的开户行支行不正确，可能将无法成功提现，由此产生的提现费用将不予返还。 </li><li>2、如果您不确定开户行支行名称，可打电话到所在地银行的营业网点询问或上网查询。 </li><li>3、不支持提现至信用卡账户。</li></ol></div></div></div></div>';
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

        $('#close').click(function(){
          $('.ui-mask').click();
        });

        $('#selBankType').change(validBank);
        $('#cardDeposit').keyup(validCardDeposit);
        $('#bank_area').keyup(validBankArea);
        $('#cardId').focusout(validCardId).keyup(function(event){
          var cardId = $('#cardId').val();
          if (cardId.length == 0){
            $('label[for=cardId]').show().text("银行卡号不能为空");
          }
          else{
            var regex = /^\d+$/i;
            if (regex.test(cardId)){
              $('label[for=cardId]').hide();
            }
            else{
              $('label[for=cardId]').show().text("银行卡号须为16-19位数字");
            }
          }
        });
        $('#cardReId').focusout(validCardReId).keyup(function(event){
          var cardId = $('#cardId').val();
          var cardReId = $('#cardReId').val();
          if (cardReId.length == 0){
            $('label[for=cardReId]').show().text("确认卡号不能为空");
          }
          else{
            var regex = /^\d+$/i;
            var reg = new RegExp("^" + cardReId);
            if (regex.test(cardReId) && reg.test(cardId)) {
                $('label[for=cardReId]').hide();
            }
            else{
              $('label[for=cardReId]').show().text("您输入的银行卡号不一致");
            }
          }
        });


        $('#add-card-button').click(function(event){
          var flag = validBank();
          flag = validCardDeposit() && flag;
          flag = validBankArea() && flag;
          flag = validCardId() && flag;
          flag = validCardReId() && flag;
          if (flag){
						$.post(Drupal.settings.basePath + "api/banks", 
							{
								type: 1,
								number: $('#cardId').val(),
								bank: $('#selBankType').val(),
								branch: $('#cardDeposit').val(),
								address: $('#bank_area').val(),
							},
							function(d) {
								if (d.result==1) {
									$('.ui-mask').click();
									location.reload();
								}
								else{
									$('#serverMsg').show().text("保存信息出现问题，请稍后重试");
								}
							}, "json") 
						.fail(function() {
							$('#serverMsg').show().text( "保存信息出现问题，请重新刷新页面" );
						});

          }
        });

        // get card holder's name
        if (account_name == null){
          $.getJSON(Drupal.settings.basePath + "api/basic",
            function(d) {
              if (d.name != null) {
                account_name = d.name;
                $('#account_name').text(account_name);
              }
            }, "json");
        }
        else {
          $('#account_name').text(account_name);
        }

      });

      function validBank(){
        var bankId = Number($('#selBankType').val());
        if (bankId > 0){
          $('label[for=selBankType]').hide();
          return true;
        }
        else{
          $('label[for=selBankType]').show().text("请选择银行");
        }
        return false;
      }

      function validCardDeposit(){
        var cardDeposit = $('#cardDeposit').val();
        if (cardDeposit.length == 0){
          $('label[for=cardDeposit]').show().text("开户行不能为空");
        }
        else{
          $('label[for=cardDeposit]').hide();
          return true;
        }
        return false;
      }

      function validBankArea(){
        var bank_area = $('#bank_area').val();
        if (bank_area.length == 0){
          $('label[for=bank_area]').show().text("开户行所在地不能为空");
        }
        else{
          $('label[for=bank_area]').hide();
          return true;
        }
        return false;
      }

      function validCardId(){
        var cardId = $('#cardId').val();
        if (cardId.length == 0){
          $('label[for=cardId]').show().text("银行卡号不能为空");
        }
        else{
          var regex = /^\d{16,19}$/i;
          if (regex.test(cardId)){
            $('label[for=cardId]').hide();
            return true;
          }
          else{
            $('label[for=cardId]').show().text("银行卡号须为16-19位数字");
          }
        }
        return false;
      }

      function validCardReId(){
        var cardId = $('#cardId').val();
        var cardReId = $('#cardReId').val();
        if (cardReId.length == 0){
          $('label[for=cardReId]').show().text("确认卡号不能为空");
        }
        else{
          if (cardId == cardReId){
            $('label[for=cardReId]').hide();
            return true;
          }
          else{
            $('label[for=cardReId]').show().text("您输入的银行卡号不一致");
          }
        }
        return false;
      }

    }
  };
})(jQuery, Drupal, this, this.document);