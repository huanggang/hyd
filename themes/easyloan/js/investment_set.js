(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.investment_set = {
    attach: function(context, settings){

      var app_id = null, title = null, user_id = null, name = null, nick = null;
      var hash = window.location.hash;
      if (hash.length > 1){
        hash = hash.slice(1);
        var params = hash.split("&");
        for (var i = 0; i < params.length; i++){
          var pairs = params[i].split("=");
          switch (pairs[0]){
            case "app_id":
              app_id = pairs[1];
              break;
            case "title":
              title = pairs[1];
              break;
            case "user_id":
              user_id = pairs[1];
              break;
            case "name":
              name = pairs[1];
              break;
            case "nick":
              nick = pairs[1];
              break;
            case "category":
              $("#app_category").text(map_id_name(loan_categories, Number(pairs[1])));
              break;
            case "amount":
              $("#app_amount").text(Number(pairs[1]).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
              break;
            case "interest":
              $("#app_interest").text(Number(pairs[1]).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
              break;
            case "rate":
              $("#app_rate").text((Number(pairs[1]) * 100).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
              break;
            case "method":
              $("#app_method").text(map_id_name(repayment_methods, Number(pairs[1])));
              break;
            case "duration":
              $("#app_duration").text(pairs[1]);
              break;
            case "start":
              $("#app_start").text(pairs[1].slice(0,10));
              break;
            case "end":
              $("#app_end").text(pairs[1].slice(0,10));
              break;
            case "fine_rate":
              $("#app_fine_rate").text((Number(pairs[1]) * 100).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
              break;
            case "fine_is_single":
              $("#app_fine_is_single").text(Number(pairs[1]) == 1 ? "单利" : "复利");
              break;
            case "created":
              $("#app_created").text(pairs[1].slice(0,10));
              break;
          }
        }
      }
      $("#app_title").html('<a href="/loan_view#id=' + app_id + '" target="_blank" title="' + title + '">' + title + '</a>');
      $("#app_name").html('<a href="/user/' + user_id + '" target="_blank" title="' + nick + '">' + name + '</a>');

      var html = '';
      for (var i = 0; i < repayment_methods.length; i++){
        html += '<option value="' + repayment_methods[i].id + '">' + repayment_methods[i].name + '</option>';
      }
      $("#method").html(html);

      var v = $("#setForm").validate({
        errorPlacement: function(error, element) {
          element.parent().append(error); // default function
        }, 
        rules: { 
          amount: {required: true, digits: true, min:1000, max:99999999},
          rate: {required: true, number: true, min:0, max:100},
          minimum: {required: true, digits: true, min:1000, max:99999999},
          step: {required: true, digits: true, min:1000, max:99999999},
          start:  {required: true, date: true},
          end:  {required: true, date: true},
          fine_rate: {required: true, number: true, min:0, max:100},
        },
        messages: {
          amount: {
            required: "请填写募集金额",
            digits: "请填写整数",
            min: "必须大于等于1,000",
            max: "必须小于等于99,999,999"
          },
          rate: {
            required: "请填写投资年利率",
            number: "含非法字符，必须输入数字",
            min: "利率不低于0%", 
            max: "利率不高于100%"
          },
          minimum: {
            required: "请填写投资起点金额",
            digits: "请填写整数",
            min: "必须大于等于1,000",
            max: "必须小于等于99,999,999"
          },
          step: {
            required: "请填写追加投资起点金额",
            digits: "请填写整数",
            min: "必须大于等于1,000",
            max: "必须小于等于99,999,999"
          },
          start: {
            required: "请填写成立日期",
            date: "日期格式错误"
          },
          end: {
            required: "请填写到期日期",
            date: "日期格式错误"
          },
          fine_rate: {
            required: "请填写逾期日利率",
            number: "含非法字符，必须输入数字",
            min: "利率不低于0%", 
            max: "利率不高于100%元"
          }
        }
      });

      $('#setForm').submit(function(event){
        event.preventDefault();
      });

      $('#apply').click(function(event){
        if(v.form()){
          var amount = $("#amount").val();
          var rate = $("#rate").val() / 100.0;
          var method = $("#method option:selected").val();
          var minimum = $("#minimum").val();
          var step = $("#step").val();
          var start = $("#start").val().replace(/\//g,"-");
          var end = $("#end").val().replace(/\//g,"-");
          var fine_rate = $("#fine_rate").val() / 100.0;
          var fine_rate_is_single = $("input[name=fine_rate_is_single]:checked").val();

          $.getJSON(Drupal.settings.basePath + "api/m_set_investment?type=1&app_id=" + app_id + "&amount=" + amount + "&rate=" + rate + "&method=" + method + "&minimum=" + minimum + "&step=" + step + "&start=" + start + "&end=" + end + "&fine_rate=" + fine_rate + "&fine_is_single=" + fine_rate_is_single,
            function(d) {
              if (d.result==1) {
                window.close();
              }
              else{
                alert("投资项目发布失败，请重新发布");
              }
            }, "json"
          )
          .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            alert( "后台验证出现问题，请刷新页面");
          });
         }
      });

    }
  };
})(jQuery, Drupal, this, this.document);