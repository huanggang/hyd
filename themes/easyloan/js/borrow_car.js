/**
 * @file
 * A JavaScript file for the theme.
 *
 */
(function($, Drupal, window, document, undefined) {
  Drupal.behaviors.borrow_car = {
    attach: function(context, settings) {

      var this_year = (new Date()).getFullYear();

      var html = '';
      for (var i = 0; i < vehicle_features.length; i++){
        html += '<input class="ui-input" type="checkbox" value="' + vehicle_features[i].id + '" name="features" id="feature' + i + '">' + vehicle_features[i].name;
      }
      $('#features').append(html);

      html = '<option value="-1"></option>';
      for (var i = 0; i < vehicle_status.length; i++){
        html += '<option value="' + vehicle_status[i].id + '">' + vehicle_status[i].name + '</option>';
      }
      $("#status").html(html);

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
          brand: {required: true, minlength:2, maxlength:32},
          year: {required: true, digits: true, min:(this_year - 100), max:this_year},
          vin: {required: true, minlength:17, maxlength:32},
          mileage: {required: true, digits: true, min:1, max:999999},
          made: {required: false, date: true},
          violations: {required: false, digits: true, min:0, max:9999},
          register: {required: false, date: true},
          price: {required: false, number: true, min:1000, max:99999999},
          color: {required: false, maxlength:8},
          tranfers: {required: false, digits: true, min:0, max:99},
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
          brand: {
            required: "请填写机动车品牌",
            minlength: "机动车品牌至少2字",
            maxlength: "机动车品牌超过32字"
          },
          year: {
            required: "请填写生产年份",
            digits: "请填写整数",
            min: "年代过于久远",
            max: "不可超过今年"
          },
          vin: {
            required: "请填写车辆识别代码(车架号/VIN)",
            minlength: "至少17字符",
            maxlength: "最多32字符"
          },
          mileage: {
            required: "请填写车辆行驶里程",
            digits: "请填写整数",
            min: "至少1公里",
            max: "最多999,999公里"
          },
          made: {
            date: "日期格式错误"
          },
          violations: {
            digits: "请填写整数",
            min: "违章次数不少于0次", 
            max: "违章次数不多于9,999次"
          },
          register: {
            date: "日期格式错误"
          },
          price: {
            number: "含非法字符，必须输入数字",
            min: "价格不低于1,000元", 
            max: "价格不高于99,999,999元"
          },
          color: {
            maxlength: "最多8字符"
          },
          tranfers: {
            digits: "请填写整数",
            min: "过户次数不少于0次", 
            max: "过户次数不多于99次"
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
              category: 2,
              title: $('#title').val(),
              amount: $('#amount').val(),
              duration: $('#duration').val(),
              certificate: $('.certificate:checked').val(),
              purpose: $('#purpose').val(),
              asset_description: $('#asset_description').val(),
              brand: $('#brand').val(),
              year: $('#year').val(),
              vin: $('#vin').val(),
              mileage: $('#mileage').val(),
              made: $('#made').val().replace(/\//g,"-"),
              violations: $('#violations').val(),
              register: $('#register').val().replace(/\//g,"-"),
              price: $('#price').val(),
              color: $('#color').val(),
              tranfers: $('#tranfers').val(),
              features: features,
              oversea: $('.oversea:checked').val(),
              status: $('#status option:selected').val(),
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