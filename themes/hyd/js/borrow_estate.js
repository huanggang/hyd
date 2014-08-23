/**
 * @file
 * A JavaScript file for the theme.
 *
 */
(function($, Drupal, window, document, undefined) {
  Drupal.behaviors.borrow_estate = {
    attach: function(context, settings) {

      var this_year = (new Date()).getFullYear();

      var html = '<option value="-1"></option>';
      for (var i = 0; i < facing.length; i++){
        html += '<option value="' + facing[i].id + '">' + facing[i].name + '</option>';
      }
      $("#facing").html(html);

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
          address: {required: true, minlength:4, maxlength:256},
          area: {required: true, number: true, min:5, max:999999},
          year: {required: true, digits: true, min:(this_year - 200), max:(this_year + 1)},
          floor: {required: false, digits: true, min:-10, max:999},
          height: {required: false, digits: true, min:1, max:999},
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
          address: {
            required: "请填写房产坐落地址",
            minlength: "地址过于简短",
            maxlength: "地址超过256字"
          },
          area: {
            required: "请填写房产产权面积",
            number: "含非法字符，必须输入数字",
            min: "面积小于5平米",
            max: "面积不超过999,999平米"
          },
          year: {
            required: "请填写建成年份",
            digits: "请填写整数",
            min: "年代过于久远",
            max: "不可超过明年"
          },
          floor: {
            digits: "请填写整数",
            min: "所在楼层过低",
            max: "所在楼层过高"
          },
          height: {
            digits: "请填写整数",
            min: "总楼层数过低",
            max: "总楼层数过高"
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
              category: 1,
              title: $('#title').val(),
              amount: $('#amount').val(),
              duration: $('#duration').val(),
              certificate: $('.certificate:checked').val(),
              purpose: $('#purpose').val(),
              asset_description: $('#asset_description').val(),
              address: $('#address').val(),
              area: $('#area').val(),
              floor: $('#floor').val(),
              height: $('#height').val(),
              facing: $('#facing option:selected').val(),
              year: $('#year').val(),
              usage: $('#usage').val(),
              has_loan: $('.has_loan:checked').val(),
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
                else if (d.message == 'Not certified yet') {
                  alert('尚未认证，不可申请借款。');
                  window.location.href = Drupal.settings.basePath + "account_management/security";
                }
                else if (d.message == 'Overtime') {
                  alert('申请借款时间段（北京时间）: 上午9:00 ~ 晚上11:00。');
                  window.location.href = Drupal.settings.basePath + "borrow";
                }
                else {
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