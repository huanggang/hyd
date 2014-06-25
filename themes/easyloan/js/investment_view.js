(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.investment_view = {
    attach: function(context, settings){

      var cats = ['','(房产) ','(机车) ','(黄金) ','(信用) ','(其他) '];

      $(window).bind('hashchange', function(){
        var href = window.location.href;
        var index = href.lastIndexOf("/");
        var id = Number(href.substr(index+1));

        if (id > 0) {
          $.getJSON( Drupal.settings.basePath + "api/investment?id="+id, 
            function(d) {
              if (d.result != null && d.result == 0){
                if (d.message == "Not found"){
                  alert( "投资项目不存在。");
                }
                else {
                  alert( "获取投资项目信息出现问题，请刷新页面。");
                }
              }
              else{
                $('#title').text(cats[d.category] + d.title);
                $('#amount').text(d.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#rate').text((d.rate * 100).toFixed(2));
                $('#duration').text(d.duration.toFixed(0));
                $('#repayment_method').text(map_id_name(repayment_methods, d.repayment_method));
                $('#created').text(d.created.slice(0,10));
                $('#start').text(d.start.slice(0,10));
                $('#end').text(d.end.slice(0,10));
                $('#minimum').text(d.minimum.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#step').text(d.step.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                if (d.fine_is_single != null && d.fine_rate > 0){
                  $('#has_fine').show();
                  $('#fine_rate').text((d.fine_rate * 100).toFixed(2));
                  $('#fine_is_single').text(d.fine_is_single == 1 ? "单利" : "复利");
                }
                else{
                  $('#no_fine').show();
                }
                if (d.fine > 0){
                  $('#has_overdue').show();
                  $('#fine').text(d.fine.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
                if (d.is_done == null) {// not start yet
                  $('#is_apply').show();
                  var progress = (d.investment / d.amount * 100).toFixed(0); progress = 89;
                  $('#apply_progress_1').attr("style", "width: " + progress + "%");
                  $('#apply_progress_2').text(progress + "%");

                  $('#panel_invest').show();
                  $('#invest_left').text((d.amount - d.investment).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")).attr("data-amount", (d.amount - d.investment).toFixed(0));

                  if (d.available != null){
                    $('#invest_available').text(d.available.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                  }

                  // apply function
                  $('#invest_amount').focus(function(event){
                    $('.ui-term-placeholder').hide();
                  }).focusout(function(event){
                    var v = Number($(this).val().trim());
                    if (v <= 0 || isNaN(v) || v > d.available || v > (d.amount - d.investment)){
                      $('#invest_error').text("").hide();
                      $(this).val("");
                      $('.ui-term-placeholder').show();
                    }
                    else{
                      var left = v - d.minimum;
                      if (left >= 0){
                        if (left % d.step == 0){
                          $('#invest_error').text("").hide();
                        }
                        else{
                          $('#invest_error').text("不满足追加投资起点金").show();
                        }
                      }
                      else{
                        $('#invest_error').text("少于投资起点金额").show();
                      }
                    }
                  }).keyup(function(event){
                    var t = $(this).val().trim();
                    var v = Number(t);
                    if (v > 0){
                      if (v > d.available){
                        $('#invest_error').text("超出账户余额").show();
                      }
                      else{
                        $('#invest_error').text("").hide();
                        if (v > (d.amount - d.investment)){
                          $('#invest_error').text("超出投资项目可投金额").show();
                        }
                        else{
                          $('#invest_error').text("").hide();
                        }
                      }
                    }
                    else {
                      $(this).val(t.substr(0,t.length-1));
                    }
                  });

                  $('#invest_submit').click(function(event){
                    var v = Number($('#invest_amount').val().trim());
                    if (v <= 0 || isNaN(v) || v > d.available || v > (d.amount - d.investment)){
                      $('#invest_error').text("请输入正确的投资金额").show();
                    }
                    else{
                      var left = v - d.minimum;
                      if (left >= 0){
                        if (left % d.step == 0){
                          $('#invest_error').text("").hide();
                          // submit invest-request
                          $.getJSON( Drupal.settings.basePath + "api/invest?id="+id+"&amount="+v, 
                            function(d) {
                              if (d.result != null && d.result == 0){
                                if (d.message != null){
                                  if (d.message == 'DB write failure') {
                                    alert('投资失败，请重试。');
                                    location.reload();
                                  }
                                  else if (d.message == 'Invalid investing amount of money') {
                                    alert('投资金额有误，请重试。');
                                    location.reload();
                                  }
                                  else if (d.message == 'Investment closed for investing'){
                                    alert('投资已结束，请投资其他项目。');
                                    window.location.href = Drupal.settings.basePath + 'invest';
                                  }
                                  else if (d.message == 'Insufficient money'){
                                    alert('账户余额不足，请充值。');
                                    window.location.href = Drupal.settings.basePath + 'capital_management/recharge';
                                  }
                                  else if (d.message == 'Unfinished loan') {
                                    alert('尚有未还清借款，不可投资。');
                                    window.location.href = Drupal.settings.basePath + 'loan_management';
                                  }
                                  else if (d.message == 'Under processing loan application') {
                                    alert('尚有借款申请，不可投资。');
                                    window.location.href = Drupal.settings.basePath + 'loan_management#type=2';
                                  }
                                  else if (d.message == 'Overtime'){
                                    alert('投资时间段（北京时间）: 上午9:00 ~ 晚上11:00。');
                                    window.location.href = Drupal.settings.basePath + 'invest';
                                  }
                                }
                                else{
                                  alert('请登录。');
                                  window.location.href = Drupal.settings.basePath + "user/login";
                                }
                              }
                              else if (d.result != null && d.result == 1) {
                                window.location.href = Drupal.settings.basePath + "invest_management";
                              }
                          })
                          .fail(function( jqxhr, textStatus, error ) {
                            var err = textStatus + ", " + error;
                            alert( "投标出现问题，请重新投标。");
                          });

                        }
                        else{
                          $('#invest_error').text("不满足追加投资起点金").show();
                        }
                      }
                      else{
                        $('#invest_error').text("少于投资起点金额").show();
                      }
                    }
                  });
                }
                else if (d.is_done == 0){ // start, but not finished
                  var today = new Date();
                  var start = new Date(Date.parse(d.start.replace(/-/g, "/")));
                  if (today < start){ // today < start
                    $('.stamp .READY').show();
                    $('#panel_ready').show();
                    if (d.investments != null){
                      $('#ready_investors').text(d.investments.length);
                    }
                    $('#ready_amount_total').text((d.w_amount + d.w_interest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#ready_months_total').text(d.total);
                  }
                  else{ // today >= start and not finished
                    if (d.w_owned > 0){
                      $('.stamp .OVERDUE').show();
                      $('#panel_overdue').show();
                      $('#overdue_amount').text(d.w_owned.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                      $('#overdue_fine').text(d.w_fine.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                      if ((d.w_amount + d.w_interest) > 0){
                        $('#overdue_amount_left').text((d.w_amount + d.w_interest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $('#overdue_months_left').text(d.total - d.count);
                        if (d.n_date != null){
                          $('#overdue_next_date').text(d.n_date.slice(0,10));
                        }
                      }
                    }
                    else {
                      $('.stamp .REPAYING').show();
                      $('#panel_repaying').show();
                      $('#repaying_amount_left').text((d.w_amount + d.w_interest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                      $('#repaying_months_left').text(d.total - d.count);
                      if (d.n_date != null){
                        $('#repaying_next_date').text(d.n_date.slice(0,10));
                      }
                    }
                  }
                }
                else if (d.is_done == 1){ // finished
                  $('.stamp .CLOSED').show();
                  $('#panel_closed').show();
                  if (d.finished != null){
                    $('#closed_finished').text(d.finished.slice(0,10));
                  }
                }

                if ($('#borrower').length > 0){
                  if (d.user_id != null && d.user_id > 0){
                    $('#borrower').html('<a href="/user/' + d.user_id + '" target="_blank" title="' + d.name + '">' + d.nick + '</a>').attr("title", d.nick);
                  }
                  else {
                    $('#borrower').text(d.nick).attr("title", d.nick);
                  }
                  if ( d.gender == 1){
                    $('#gender').addClass("ui-icon-gender-male").attr("title", "男");
                  }
                  else{
                    $('#gender').addClass("ui-icon-gender-female").attr("title", "女");
                  }
                  $('#age').text(d.age);
                  $('#marital').text(map_id_name(marital_status, d.marital));
                  $('#education').text(map_id_name(educations, d.education));
                  $('#living_place').text(map_id_name(provinces, d.province) + " " + getCity(d.province, d.city));
                }

                $('#check_credit_date').text(d.created.slice(0,10));
                $('#check_id_date').text(d.created.slice(0,10));
                if (d.has_certificate == 1){
                  $('#check_mortgage').addClass("icon-circle-checked");
                }
                $('#check_mortgage_date').text(d.created.slice(0,10));

                $('#purpose').text(d.purpose);
                $('#asset_description').text(d.description);

                if ($('#investors_total').length > 0){
                  $('#investors_total').text(d.investments.length);
                  $('#investors_amount_total').text(d.investment.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                  var html = "";
                  var l = d.investments.length - 1;
                  for (var i = 0; i <= l; i++){
                    var inv = d.investments[i];
                    html += '<tr class="';
                    if (i % 2 == 0){
                      html += 'dark';
                    }
                    if (i ==  l){
                      html += ' last';
                    }
                    html += '"><td><div class="ui-td-bg pl60">' + (i+1) + '</div></td><td><div class="ui-td-bg pl40">';
                    if (inv.user_id != null && inv.user_id > 0){
                      html += '<a href="/user/' + inv.user_id + '" target="_blank" title="' + inv.name + '">' + inv.nick + '</a>';
                    }
                    else {
                      html += inv.nick;
                    }
                    html += '</div></td><td class="text-right"><div class="ui-td-bg pr70"><em>' 
                      + inv.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</em>元</div></td><td class="text-right"><div class="ui-td-bg pr90">'
                      + inv.time + '</div></td></tr>';
                  }
                  $('#investors tbody').html(html);
                }

              }

          })
          .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            alert( "获取信息出现问题，请刷新页面。");
          });
        }

      });
      $(window).trigger('hashchange');

      $.cachedScript = function( url, options ) {
          // Allow user to set any option except for dataType, cache, and url
          options = $.extend( options || {}, {
            dataType: "script",
            cache: false,
            url: url,
            async: false,
          });
          return $.ajax( options );
        };

      var cityCache = {}; // cache the city lists so it won't send another request 

      /// assing options to the 'city' select input
      ///
      ///  provinceid - the id of the province
      ///  value      - the default city value
      function getCity(provinceid, value, async) {
        if (async == undefined) { async = true; }
        var url = js_path + 'city/cities_' + provinceid + '.js';
        var cities = null;
        $.cachedScript(url, {async:async}).done(function(data, textStatus) { 
          cities = eval('cities_' + provinceid);
          cityCache[provinceid] = cities;
        });
        return map_id_name(cities, value);
      }

      function init(){
        $('#title').text("");
        $('#amount').text("");
        $('#rate').text("");
        $('#duration').text("");
        $('#repayment_method').text("");
        $('#created').text("");
        $('#start').text("");
        $('#end').text("");
        $('#minimum').text("");
        $('#step').text("");
        $('#has_fine').hide();
        $('#fine_rate').text("");
        $('#fine_is_single').text("");
        $('#no_fine').hide();
        $('#has_overdue').hide();
        $('#fine').text("");
        $('#is_apply').hide();
        $('#apply_progress_1').attr("style", "");
        $('#apply_progress_2').text("");
        $('#panel_invest').hide();
        $('#invest_left').text("");
        $('#invest_available').text("")

        $('.stamp .READY').hide();
        $('#panel_ready').hide();
        $('#ready_investors').text("");
        $('#ready_amount_total').text("");
        $('#ready_months_total').text("");

        $('.stamp .OVERDUE').hide();
        $('#panel_overdue').hide();
        $('#overdue_amount').text("");
        $('#overdue_fine').text("");
        $('#overdue_amount_left').text("");
        $('#overdue_months_left').text("");
        $('#overdue_next_date').text("");

        $('.stamp .REPAYING').hide();
        $('#panel_repaying').hide();
        $('#repaying_amount_left').text("");
        $('#repaying_months_left').text("");
        $('#repaying_next_date').text("");

        $('.stamp .CLOSED').hide();
        $('#panel_closed').hide();
        $('#closed_finished').text("");

        $('#borrower').text("").attr("title", "");
        $('#gender').removeClass("ui-icon-gender-male").removeClass("ui-icon-gender-female").attr("title", "");
        $('#age').text("");
        $('#marital').text("");
        $('#education').text("");
        $('#living_place').text("");

        $('#check_credit_date').text("");
        $('#check_id_date').text("");
        $('#check_mortgage').removeClass("icon-circle-checked");
        $('#check_mortgage_date').text("");

        $('#purpose').text("");
        $('#asset_description').text("");

        $('#investors_total').text("");
        $('#investors_amount_total').text("");

        $('#investors tbody').html("");

      }

    }
  };
})(jQuery, Drupal, this, this.document);