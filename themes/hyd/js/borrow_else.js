/**
 * @file
 * A JavaScript file for the theme.
 *
 */
(function($, Drupal, window, document, undefined) {
  Drupal.behaviors.borrow_else = {
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
          name: {required: true, minlength:2, maxlength:32},
          bought: {required: true, date: true},
          price: {required: true, number: true, min:1000, max:99999999},
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
            required: "请选择是否有房产证",
          },
          purpose: {
            required: "请填写借款描述",
            minlength: "描述过于简短",
            maxlength: "描述超过256字"
          },
          asset_description: {
            required: "请填写抵押资产说明",
            minlength: "说明过于简短",
            maxlength: "说明超过1024字"
          },
          name: {
            required: "请填写物品名称",
            minlength: "物品名称过于简短",
            maxlength: "物品名称超过32字"
          },
          bought: {
            required: "请填写购买日期",
            date: "日期格式错误"
          },
          price: {
          	required: "请填写购买价格",
            number: "含非法字符，必须输入数字",
            min: "价格不低于1,000元", 
            max: "价格不高于99,999,999元"
          },
        }
      });

      $('#borrowForm').submit(function(event){
        event.preventDefault();
      });

      $('#apply').click(function(event){
        if(v.form()){
          var features = '';
          $('input[name=features]:checked').each(function(){ features += this.value + ','; });

          $.post(Drupal.settings.basePath + "api/apply", 
            {
              category: 5,
              title: $('#title').val(),
              amount: $('#amount').val(),
              duration: $('#duration').val(),
              certificate: $('.certificate:checked').val(),
              purpose: $('#purpose').val(),
              asset_description: $('#asset_description').val(),
              name: $('#name').val(),
              bought: $('#bought').val().replace(/\//g,"-"),
              price: $('#price').val(),
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
            alert( "网络出现问题，请刷新页面。" );
          });
        }
      });

    }
  };
})(jQuery, Drupal, this, this.document);