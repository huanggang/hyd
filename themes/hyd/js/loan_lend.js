(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.loan_lend = {
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
            case "duration":
              $("#app_duration").text(pairs[1]);
              break;
            case "applied":
              $("#app_applied").text(pairs[1].slice(0,10));
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
      $("#repayment_method").html(html);

      var v = $("#lendForm").validate({
        errorPlacement: function(error, element) {
          element.parent().append(error); // default function
        }, 
        rules: { 
          loaned: {required: true, date: true},
          amount: {required: true, digits: true, min:1000, max:99999999},
          rate: {required: true, number: true, min:0, max:100},
          start:  {required: true, date: true},
          end:  {required: true, date: true},
          fine_rate: {required: true, number: true, min:0, max:100},
        },
        messages: {
          loaned: {
            required: "请填写放款日期",
            date: "日期格式错误"
          },
          amount: {
            required: "请填写借款金额",
            digits: "请填写整数",
            min: "必须大于等于1,000",
            max: "必须小于等于99,999,999"
          },
          rate: {
            required: "请填写借款年利率",
            number: "含非法字符，必须输入数字",
            min: "利率不低于0%", 
            max: "利率不高于100%"
          },
          start: {
            required: "请填写借款日期",
            date: "日期格式错误"
          },
          end: {
            required: "请填写还款日期",
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

      $('#lendForm').submit(function(event){
        event.preventDefault();
      });

      $('#apply').click(function(event){
        if(v.form()){
          var loaned = $("#loaned").val().replace(/\//g,"-");
          var amount = Number($("#amount").val());
          var rate = Number($("#rate").val()) / 100.0;
          var repayment_method = $("#repayment_method option:selected").val();
          var start = $("#start").val().replace(/\//g,"-");
          var end = $("#end").val().replace(/\//g,"-");
          var fine_rate = Number($("#fine_rate").val()) / 100.0;
          var fine_rate_is_single = $("input[name=fine_rate_is_single]:checked").val();

          // check end-date > today, start-date < end-date, loaned-date < end-date, today - start-date < 1 month
          var dtoday = new Date();
          var dloaned = new Date(loaned);
          var dstart = new Date(start);
          var dend = new Date(end);
          if (dloaned.getTime() >= dend.getTime()) {
            alert('还款日期必须在放款日期之后');
            return;
          }
          if (dstart.getTime() >= dend.getTime()) {
            alert('还款日期必须在借款日期之后');
            return;
          }
          if (dend.getTime() <= dtoday.getTime()) {
            alert('还款日期必须在今日之后');
            return;
          }
          if (dtoday.getTime() - dstart.getTime() >= (28 * 24 * 3600 * 1000)) {
            alert('借款日期必须在今日之前的28日内');
            return;
          }
          if (repayment_method == 1) {
            if (dend.getTime() - dstart.getTime() < (3 * 24 * 3600 * 1000)){
              alert('借款期限必须在3日以上');
              return;
            }
          }
          else if (repayment_method == 2 || repayment_method == 3) {
            if (dend.getTime() - dstart.getTime() < (59 * 24 * 3600 * 1000)){
              alert('借款期限必须在2月以上');
              return;
            }
          }
          else if (repayment_method == 4 || repayment_method == 5) {
            if (dend.getTime() - dstart.getTime() < (89 * 24 * 3600 * 1000)){
              alert('借款期限必须在3月以上');
              return;
            }
          }

          $.getJSON(Drupal.settings.basePath + "api/m_set_loan?app_id=" + app_id + "&loaned=" + loaned + "&amount=" + amount + "&rate=" + rate + "&repayment_method=" + repayment_method + "&start=" + start + "&end=" + end + "&fine_rate=" + fine_rate + "&fine_rate_is_single=" + fine_rate_is_single,
            function(d) {
              if (d.result==1) {
                window.close();
              }
              else{
                alert("放款设置失败，请重新设置");
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