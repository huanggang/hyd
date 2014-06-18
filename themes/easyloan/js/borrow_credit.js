/**
 * @file
 * A JavaScript file for the theme.
 *
 */
(function($, Drupal, window, document, undefined) {
  Drupal.behaviors.vali = {
    attach: function(context, settings) {

      var this_year = (new Date()).getFullYear();

      var v = $("#borrowForm").validate({
        errorPlacement: function(error, element) {
          element.parent().append(error); // default function
        }, 
        rules: { 
          title: {required: true, minlength:2, maxlength:25},
          amount: {required: true, digits: true, min:1000, max:99999999},
          duration: {required: true, digits: true, min:1, max:36},
          certificate: "required",
          income: {required: true, digits: true, min:100, max:99999999},
          company: {required: true, minlength:8, maxlength:256},
          purpose: {required: true, minlength:8, maxlength:256},
          brand: {required: true, minlength:2, maxlength:32},
          year: {required: true, digits: true, min:0, max:50},
          month: {required: true, digits: true, min:1, max:12},
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
          income: {
            required: "请填写平均月收入",
            digits: "请填写整数",
            min: "必须大于等于100",
            max: "必须小于等于99,999,999"
          },
          company: {
            required: "请填写工作单位",
            minlength: "工作单位过于简短",
            maxlength: "工作单位不能超过256字"
          },
          purpose: {
            required: "请填写借款描述",
            minlength: "描述过于简短",
            maxlength: "描述超过256字"
          },
          brand: {
            required: "请填写机动车品牌",
            minlength: "机动车品牌至少2字",
            maxlength: "机动车品牌超过32字"
          },
          year: {
            required: "请完整填写工龄年数",
            digits: "请填写整数年数",
            min: "请正确填写年数",
            max: "请正确填写年数"
          },
          month: {
            required: "请完整填写工龄月份",
            digits: "请填写整数月份",
            min: "请正确填写月份",
            max: "请正确填写月份"
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
              category: 5,
              title: $('#title').val(),
              amount: $('#amount').val(),
              duration: $('#duration').val(),
              certificate: $('.certificate:checked').val(),
              purpose: $('#purpose').val(),
              asset_description: $('#asset_description').val(),

              company: $('#company').val(),
              income: $('#income').val(),
              year: $('#year').val(),
              month: $('#month').val(),
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