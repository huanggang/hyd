(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.bankcard = {
    attach: function(context, settings){

      $.getJSON( Drupal.settings.basePath + "api/banks", 
        function(d) {
          var html = '';
          if (d.total > 0) {
            for (var i = 0; i < d.total; i++) {
              var card = d.numbers[i];
              var bankId = card.bank;
              var number = card.number;
              var branch = card.branch;
              var address = card.address;
              html += '<li><img alt="" title="" src="' + image_path + 'bank_' + bankId + '.jpg"><div>' + number + '</div><div class="card"><a class="link mod openLink" tabindex="-1" data-card="' + number + '" data-bank="' + bankId + '" data-branch="' + branch + '" data-address="' + address + '">修改</a><a class="link del" data-card="' + number + '">删除</a></div></li>';
            }
          }
          $('#banklis ul').prepend(html);

          $('.mod').click(function(event){
            var number = $(this).attr("data-card");
            var bankId = $(this).attr("data-bank");
            var branch = $(this).attr("data-branch");
            var address = $(this).attr("data-address");
            var html = '<div data-widget-cid="widget-0" class="ui-mask" style="position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; z-index: 99998; opacity: 0.85; background-color: rgb(255, 255, 255); display: block;"></div><div class="ui-dialog" tabindex="-1" data-widget-cid="widget-2" style="height: 410px; width: 650px; z-index: 99999; position: absolute; left: 0px; top: 0px;"><div data-role="close" title="关闭本框" class="ui-dialog-close" style="display: block;">×</div><div style="border: medium none; width: 100%; display: block; height: 100%; overflow: hidden;"><div data-role="content" class="ui-dialog-content" style="background: none repeat scroll 0% 0% rgb(255, 255, 255); height: 100%; overflow: hidden"><div id="pg-addcard"><form id="addcardForm" method="post" class="ui-form" data-name="addcard" novalidate="novalidate"><h3 class="title" style="margin-top: -10px">修改银行卡</h3><div class="inputs"><div class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>开户名</label><em id="account_name"></em> <span class="info">请添加相同开户名的银行卡</span></div><div class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>银行卡号</label><span id="cardId">'
              + number + 
              '</span></div><div class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>选择银行</label><select name="bankDataId" style="width:160px" id="selBankType"><option value="-1">请选择</option>';
            var options = '';
            for (var i = 0; i < banks.length; i++){
              options += '<option value="' + banks[i].id + '">' + banks[i].name + '</option>';
            }
            html += options + '</select><label for="selBankType" class="error" style="display: none;"></label></div><div style="*z-index:19;" class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>开户行</label><input type="text" id="cardDeposit" value="'
              + branch + '" name="deposit" class="ui-input"><label for="cardDeposit" class="error" style="display: none;"></label></div><div style="position: relative;" class="ui-form-item"><label class="ui-label"><span class="ui-form-required">*</span>开户行所在地</label><input type="text" disableautocomplete="" autocomplete="off" id="bank_area" value="'
              + address + '" name="address" class="ui-input"><label for="bank_area" class="error" style="display: none;"></label></div></div><div class="serverMsg" id="serverMsg"></div><div class="bts"><input type="button" value="保 存" class="ui-button ui-button-mid ui-button-green" id="save-card-button"><input type="reset" value="取 消" class="ui-button ui-button-mid ui-button-gray" id="close"></div></form><div class="notice"><div class="title">温馨提示</div><ol><li>1、如果您填写的开户行支行不正确，提现交易将无法成功，提现费用不予返还。 </li><li>2、如果您不确定开户行支行名称，可打电话到当地所在银行的营业网点询问或上网查询。 </li><li>3、提现时，不能选择将资金利息等提到信用卡账户中。</li></ol></div></div></div></div></div>';
            $('body').append(html);
            $( window ).resize(function() {
              $('.ui-dialog').position({
                my: "center",
                at: "center",
                of: window
              });
            });
            $(window).resize();

            $("#selBankType option").removeAttr("selected");
             $("#selBankType option[value=" + bankId + "]").attr("selected", "selected");

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

            $('#save-card-button').click(function(event){
              var flag = validBank();
              flag = validCardDeposit() && flag;
              flag = validBankArea() && flag;
              if (flag){
                $.post(Drupal.settings.basePath + "api/banks", 
                  {
                    type: 2,
                    number: $('#cardId').text(),
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
          $('.del').click(function(event){
            var number = $(this).attr("data-card");
            if (confirm("确定要删除该银行卡吗？")) {
              $.post(Drupal.settings.basePath + "api/banks", 
                {
                  type: 3,
                  number: number,
                },
                function(d) {
                  if (d.result == 1){
                    location.reload();
                  }
                  else {
                    alert( "后台出现问题，请稍后重试" );
                  }
              }, "json")
              .fail(function( jqxhr, textStatus, error ) {
                var err = textStatus + ", " + error;
                alert( "网络出现问题，请重新刷新页面。");
              });
            }
          });
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "网络出现问题，请重新刷新页面。");
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

    }
  };
})(jQuery, Drupal, this, this.document);