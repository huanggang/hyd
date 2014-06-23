/**
 * @file
 * A JavaScript file for the theme.
 *
 */
(function($, Drupal, window, document, undefined) {
  Drupal.behaviors.borrow_credit = {
    attach: function(context, settings) {

      var v = $("#borrowForm").validate({
        errorPlacement: function(error, element) {
          element.parent().append(error); // default function
        }, 
        rules: { 
          title: {required: true, minlength:2, maxlength:25},
          amount: {required: true, digits: true, min:1000, max:99999999},
          duration: {required: true, digits: true, min:1, max:36},
          certificate: "required",
          purpose: {required: true, minlength:8, maxlength:256},
          asset_description: {required: true, minlength:8, maxlength:1024},
          organization: {required: true, minlength:2, maxlength:64},
          position: {required: true, minlength:2, maxlength:64},
          years: {required: true, digits: true, min:0, max:50},
          months: {required: true, digits: true, min:0, max:12},
          income: {required: true, digits: true, min:2000, max:99999999},
        },
        messages: {
          title: {
            required: "请填写借款标题",
            minlength: "标题过于简短",
            maxlength: "标题超过25字"
          },
          amount: {
            required: "请填写借款金额",
            digits: "请填写整数",
            min: "必须大于等于1,000",
            max: "必须小于等于99,999,999"
          },
          duration: {
            required: "请填写借款期限",
            digits: "请填写整数",
            min: "至少1个月",
            max: "最多36个月"
          },
          certificate: {
            required: "请选择是否有工作凭证",
          },
          purpose: {
            required: "请填写借款描述",
            minlength: "描述过于简短",
            maxlength: "描述超过256字"
          },
          asset_description: {
            required: "请填写信用说明",
            minlength: "说明过于简短",
            maxlength: "说明超过1024字"
          },
          organization: {
            required: "请填写现工作单位",
            minlength: "工作单位过于简短",
            maxlength: "工作单位不能超过64字"
          },
          position: {
            required: "请填写当前职务",
            minlength: "职务过于简短",
            maxlength: "职务不能超过64字"
          },
          years: {
            required: "请填写现单位工龄年数",
            digits: "请填写正整数",
            min: "年数过少",
            max: "年数过多"
          },
          months: {
            required: "请填写现单位工龄所余月数",
            digits: "请填写正整数",
            min: "月数过少",
            max: "月数过多"
          },
          income: {
            required: "请填写平均月收入",
            digits: "请填写正整数",
            min: "必须大于等于2000",
            max: "必须小于等于99,999,999"
          },
        }
      });

      $('#borrowForm').submit(function(event){
        event.preventDefault();
      });

      $('#apply').click(function(event){
        if(v.form()){
          $.post(Drupal.settings.basePath + "api/apply", 
            {
              category: 4,
              title: $('#title').val(),
              amount: $('#amount').val(),
              duration: $('#duration').val(),
              certificate: $('.certificate:checked').val(),
              purpose: $('#purpose').val(),
              asset_description: $('#asset_description').val(),
              organization: $('#organization').val(),
              position: $('#position').val(),
              years: $('#years').val(),
              months: $('#months').val(),
              income: $('#income').val(),
            },
            function(d) {
              if (d.result == 0){
                if (d.message == 'DB write failure') {
                  alert('申请借款失败，请重试。');
                  location.reload();
                }
                else if (d.message == 'Holding investments') {
                  alert('尚有投资项目，不可申请借款。');
                  window.location.href = Drupal.settings.basePath + 'invest_management';
                }
                else if (d.message == 'Unfinished loan') {
                  alert('尚有未还清借款，不可再申请借款。');
                  window.location.href = Drupal.settings.basePath + 'loan_management';
                }
                else if (d.message == 'Under processing loan application') {
                  alert('尚有借款申请，不可再申请借款。');
                  window.location.href = Drupal.settings.basePath + 'loan_management#type=2';
                }
                else if (d.message == 'Not certified yet'){
                  alert('尚未认证，不可申请借款。');
                  window.location.href = Drupal.settings.basePath + "account_management/security";
                }
                else{
                  alert('请登录。');
                  window.location.href = Drupal.settings.basePath + "user/login";
                }
              }
              else if (d.result == 1){
                window.location.href = Drupal.settings.basePath + 'loan_management#type=2';
              }
          }, "json")
          .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            alert( "网络出现问题，请重新刷新页面。" );
          });
        }
      });

    }
  };
})(jQuery, Drupal, this, this.document);