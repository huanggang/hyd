(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.withdrawappl = {
    attach: function(context, settings){

      var max_pages = 50;
      var per_page = 20;

      var show_pages = 11;
      var show_pages_mid = 7; // show_pages == (show_pages_mid + 4)

      var total_1 = 0;
      var total_pages_1 = 0;
      var total_2 = 0;
      var total_pages_2 = 0;

      $(window).bind('hashchange', function(){
        var hash = window.location.hash;
        var type = 1;
        var page = 1;
        if (hash.length > 1){
          hash = hash.slice(1);
          var params = hash.split("&");
          for (var i = 0; i < params.length; i++){
            var pairs = params[i].split("=");
            if (pairs[0] === "type") {
              type = Number(pairs[1]);
            }
            else if (pairs[0] == "page"){
              page = Number(pairs[1]);
              if (page > max_pages) {
                page = max_pages;
              }
              else if (page < 1) {
                page = 1;
              }
            }
          }
        }

        if (type == 1){ // show tab 1
          $(".ui-tab-item[data-name=checking]").click();
        }
        else { // show tab 2
          type = 2;
          $(".ui-tab-item[data-name=checked]").click();
        }

        $.getJSON( Drupal.settings.basePath + "api/m_withdraws?type=" + type + "&page=" + page, 
          function(d) {
            var list_title = '';
            var list = '';
            var pagination = '<ul>';
            if (page == 1){
              var total = d.total;
              var total_pages = total == 0 ? 0 : Math.round(total / per_page) + 1;
              if (type == 1){
                total_1 = total;
                total_pages_1 = total_pages;
              }
              else{
                total_2 = total;
                total_pages_2 = total_pages;
              }

              if (total == 0){
                list += '<li class="ui-list-status"><p class="color-gray-text">没有记录</p></li>';
              }
              else{
                if (total_pages > max_pages) {
                  total_pages = max_pages;
                }
                if (total_pages == 1){
                  pagination += '<li class="active"><span class="current">1</span></li>';
                }
                else if (total_pages <= show_pages){
                  pagination += '<li class="active"><span class="current">1</span></li>';
                  for (var i = 2 ; i <= total_pages; i++){
                    pagination += '<li><a href="#type=' + type + '&page=' + i + '" class="page-link">' + i + '</a></li>';
                  }
                }
                else{
                  pagination += '<li class="active"><span class="current prev">前页</span></li><li class="active"><span class="current">1</span></li>';
                  for (var i = 2 ; i <= (show_pages_mid+2); i++){
                    pagination += '<li><a href="#type=' + type + '&page=' + i + '" class="page-link">' + i + '</a></li>';
                  }
                  pagination += '<li class="disabled"><span class="ellipse">…</span></li><li><a href="#type='
                    + type + '&page=' + total_pages + '" class="page-link">' + total_pages + '</a></li><li><a href="#type='
                    + type + '&page=2" class="page-link next">后页</a></li>';
                }
              }
            }
            else{ // page > 1
              var total = 0;
              var total_pages = 0;
              if (type == 1){
                total = total_1;
                total_pages = total_pages_1;
              }
              else{
                total = total_2;
                total_pages = total_pages_2;
              }
              if (total_pages <= show_pages){
                for (var i = 1; i < page; i++){
                  pagination += '<li><a href="#type=' + type + '&page=' + i + '" class="page-link">' + i + '</a></li>';
                }
                pagination += '<li class="active"><span class="current">' + page + '</span></li>';
                for (var i = (page+1); i <= total_pages; i++){
                  pagination += '<li><a href="#type=' + type + '&page=' + i + '" class="page-link">' + i + '</a></li>';
                }
              }
              else{
                pagination += '<li><a href="#type=' + type + '&page=' + (page-1).toString() + '" class="page-link prev">前页</span></li>';
                if (page <= show_pages_mid){
                  for (var i = 1; i < page; i++){
                    pagination += '<li><a href="#type=' + type + '&page=' + i + '" class="page-link">' + i + '</a></li>';
                  }
                  pagination += '<li class="active"><span class="current">' + page + '</span></li>';
                  for (var i = (page+1); i <= (show_pages_mid+2); i++){
                    pagination += '<li><a href="#type=' + type + '&page=' + i + '" class="page-link">' + i + '</a></li>';
                  }
                  pagination += '<li class="disabled"><span class="ellipse">…</span></li><li><a href="#type='
                    + type + '&page=' + total_pages + '" class="page-link">' + total_pages + '</a></li><li><a href="#type='
                    + type + '&page=' + (page+1).toString() + '" class="page-link next">后页</a></li>';
                }
                else if (page >= (total_pages - show_pages_mid)){
                  pagination += '<li><a href="#type=' + type + '&page=1" class="page-link">1</a></li><li class="disabled"><span class="ellipse">…</span></li>';
                  for (var i = (total_pages - show_pages_mid - 2); i < page; i++){
                    pagination += '<li><a href="#type=' + type + '&page=' + i + '" class="page-link">' + i + '</a></li>';
                  }
                  pagination += '<li class="active"><span class="current">' + page + '</span></li>';
                  for (var i = (page+1); i <= total_pages; i++){
                    pagination += '<li><a href="#type=' + type + '&page=' + i + '" class="page-link">' + i + '</a></li>';
                  }
                  if (page == total_pages){
                    pagination += '<li class="active"><span class="current next">后页</span></li>';
                  }
                  else{
                    pagination += '<li><a href="#type='  + type + '&page=' + (page+1).toString() + '" class="page-link next">后页</a></li>';
                  }
                }
                else{// page in the middle
                  pagination += '<li><a href="#type=' + type + '&page=1" class="page-link">1</a></li><li class="disabled"><span class="ellipse">…</span></li>';
                  var delta = Math.floor(show_pages_mid / 2.0);
                  for (var i = (page-delta); i < page; i++){
                    pagination += '<li><a href="#type=' + type + '&page=' + i + '" class="page-link">' + i + '</a></li>';
                  }
                  pagination += '<li class="active"><span class="current">' + page + '</span></li>';
                  for (var i = (page+1); i <= (page+delta); i++){
                    pagination += '<li><a href="#type=' + type + '&page=' + i + '" class="page-link">' + i + '</a></li>';
                  }
                  pagination += '<li class="disabled"><span class="ellipse">…</span></li><li><a href="#type=' + type + '&page=' + total_pages + '" class="page-link">' + total_pages + '</a></li><li><a href="#type='  + type + '&page=' + (page+1).toString() + '" class="page-link next">后页</a></li>';
                }
              }
            }
            pagination += '</ul>';
            $('#withdrawapp-list-pagination-'+ type).html(pagination);
            $('#withdrawapp-total-'+type).html("共"+total+"条");

            if (type == 1){ // checking
              list_title = '<li class="ui-list-header color-gray-text fn-clear"><span class="ui-list-title w50 ph5 fn-left title">开户名</span><span class="ui-list-title w90 ph5 fn-left">提现金额</span><span class="ui-list-title w40 ph5 fn-left">费用</span><span class="ui-list-title w100 ph5 fn-left">银行</span><span class="ui-list-title w180 ph5 fn-left">卡号</span><span class="ui-list-title w80 ph5 fn-left">申请日期</span><span class="ui-list-title w60 ph5 fn-left">转账</span><span class="ui-list-title w60 ph5 fn-left">拒绝</span></li>';
              for (var i = 0; i < d.withdraws.length; i++){
                var w = d.withdraws[i];
                list += '<li class="ui-list-item fn-clear';
                if (i % 2 == 0){
                  list += ' dark';
                }
                list += '"><span class="ui-list-field w50 ph5 fn-left"><a href="/user/'
                  + w.user_id + '" target="blank">' + w.name + '</a></span><span class="ui-list-field w90 ph5 fn-left text-right';
                if (w.is_owned){
                  list += ' red';
                }
                list += '">' + w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w40 ph5 fn-left text-right';
                if (w.is_owned){
                  list += ' red';
                }
                list += '">' + w.fee.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w100 ph5 fn-left text-center">' 
                  + map_id_name(banks, w.bank) + '</span><span class="ui-list-field w180 ph5 fn-left">' 
                  + w.number.replace(/\B(?=(\d{4})+(?!\d))/g, " ") + '</span><span class="ui-list-field w80 ph5 fn-left">'
                  + w.time.slice(0, 10) + '</span><span class="ui-list-title w60 ph5 fn-left"><a class="ui-button ui-button-small ui-button-green transfer" data-user-id="'
                  + w.user_id + '" data-number="'
                  + w.number + '" data-amount="'
                  + w.amount + '" data-fee="'
                  + w.fee + '">转账</a></span><span class="ui-list-title w60 ph5 fn-left"><a class="ui-button ui-button-small ui-button-green reject" data-user-id="'
                  + w.user_id + '" data-number="'
                  + w.number + '" data-amount="'
                  + w.amount + '" data-fee="'
                  + w.fee + '">拒绝</a></span><div class="ui-poptip fn-hide" id="tipCon" data-widget-cid="widget-2" style="z-index: 99; position: absolute; left: 320px; top: '
                  + (i * 35 + 36).toString() + 'px; display: none;"><div class="ui-poptip-shadow"><div class="ui-poptip-container"><div class="ui-poptip-arrow ui-poptip-arrow-10"><em></em><span></span></div><div class="ui-poptip-content" data-role="content"><div class="fn-clear"><label class="font-nm w80 fn-left text-right">开户行</label><div class="w150 ph10 fn-left">'
                  + w.branch + '</div></div><div class="fn-clear"><label class="font-nm w80 fn-left text-right">开户行所在地</label><div class="w150 ph10 fn-left">'
                  + w.address + '</div></div><div class="fn-clear"><label class="font-nm w80 fn-left text-right">银行卡号</label><div class="w150 ph10 fn-left">'
                  + w.number.replace(/\B(?=(\d{4})+(?!\d))/g, " ") + '</div></div><div class="fn-clear"><label class="font-nm w80 fn-left text-right">申请日期</label><div class="w150 ph10 fn-left">'
                  + w.time + '</div></div></div></div></div></div></li>';
              }
              $('#withdrawapp-list-1').html(list_title + list);

              $('.transfer').click(function(event){
                if (confirm("确定转账吗？")) {
                  var user_id = $(this).attr("data-user-id");
                  var number = $(this).attr("data-number");
                  var amount = $(this).attr("data-amount");
                  var fee = $(this).attr("data-fee");
                  var time = (new Date()).format("yyyy-MM-dd hh:mm:ss.S");
                  $.getJSON( Drupal.settings.basePath + "api/m_set_withdraw?type=1&id=" + user_id + '&time=' + time + '&number=' + number + '&amount=' + amount + '&fee=' + fee, 
                    function(d) {
                      if (d.result == 1){
                        location.reload();
                      }
                      else {
                        alert( "设置出现问题，请重新设置。");
                      }
                  })
                  .fail(function( jqxhr, textStatus, error ) {
                    var err = textStatus + ", " + error;
                    alert( "设置出现问题，请刷新页面。");
                  });
                }
              });

              $('.reject').click(function(event){
                if (confirm("确定拒绝吗？")) {
                  var user_id = $(this).attr("data-user-id");
                  var number = $(this).attr("data-number");
                  var amount = $(this).attr("data-amount");
                  var fee = $(this).attr("data-fee");
                  var time = (new Date()).format("yyyy-MM-dd hh:mm:ss.S");
                  $.getJSON( Drupal.settings.basePath + "api/m_set_withdraw?type=0&id=" + user_id + '&time=' + time + '&number=' + number + '&amount=' + amount + '&fee=' + fee, 
                    function(d) {
                      if (d.result == 1){
                        location.reload();
                      }
                      else {
                        alert( "设置出现问题，请重新设置。");
                      }
                  })
                  .fail(function( jqxhr, textStatus, error ) {
                    var err = textStatus + ", " + error;
                    alert( "设置出现问题，请刷新页面。");
                  });
                }
              });
            }
            else{ // checked
              list_title = '<li class="ui-list-header color-gray-text fn-clear"><span class="ui-list-title w50 ph5 fn-left title">开户名</span><span class="ui-list-title w90 ph5 fn-left">提现金额</span><span class="ui-list-title w40 ph5 fn-left">费用</span><span class="ui-list-title w100 ph5 fn-left">银行</span><span class="ui-list-title w180 ph5 fn-left">卡号</span><span class="ui-list-title w80 ph5 fn-left">申请日期</span><span class="ui-list-title w80 ph5 fn-left">转账日期</span><span class="ui-list-field w40 ph5 fn-left">转账</span></li>';
              for (var i = 0; i < d.withdraws.length; i++){
                var w = d.withdraws[i];
                list += '<li class="ui-list-item fn-clear';
                if (i % 2 == 0){
                  list += ' dark';
                }
                list += '"><span class="ui-list-field w50 ph5 fn-left"><a href="/user/'
                  + w.user_id + '" target="blank">' + w.name + '</a></span><span class="ui-list-field w90 ph5 fn-left text-right">'
                  + w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w40 ph5 fn-left text-right">'
                  + w.fee.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w100 ph5 fn-left text-center">'
                  + map_id_name(banks, w.bank) + '</span><span class="ui-list-field w180 ph5 fn-left">'
                  + w.number.replace(/\B(?=(\d{4})+(?!\d))/g, " ") + '</span><span class="ui-list-field w80 ph5 fn-left">'
                  + w.time.slice(0, 10) + '</span><span class="ui-list-field w80 ph5 fn-left">'
                  + w.done.slice(0, 10) + '</span><span class="ui-list-field w40 ph5 fn-left">'
                  + (w.is_done ? '是' : '否') + '</span><div class="ui-poptip fn-hide" id="tipCon" data-widget-cid="widget-2" style="z-index: 99; position: absolute; left: 320px; top: '
                  + (i * 35 + 36).toString() + 'px; display: none;"><div class="ui-poptip-shadow"><div class="ui-poptip-container"><div class="ui-poptip-arrow ui-poptip-arrow-10"><em></em><span></span></div><div class="ui-poptip-content" data-role="content"><div class="fn-clear"><label class="font-nm w80 fn-left text-right">开户行</label><div class="w230 ph10 fn-left">'
                  + w.branch + '</div></div><div class="fn-clear"><label class="font-nm w80 fn-left text-right">开户行所在地</label><div class="w230 ph10 fn-left">'
                  + w.address + '</div></div><div class="fn-clear"><label class="font-nm w80 fn-left text-right">银行卡号</label><div class="w230 ph10 fn-left">'
                  + w.number.replace(/\B(?=(\d{4})+(?!\d))/g, " ") + '</div></div><div class="fn-clear"><label class="font-nm w80 fn-left text-right">申请日期</label><div class="w230 ph10 fn-left">'
                  + w.time + '</div></div><div class="fn-clear"><label class="font-nm w80 fn-left text-right">转账日期</label><div class="w230 ph10 fn-left">'
                  + w.done + '</div></div></div></div></div></div></li>';
              }
              $('#withdrawapp-list-2').html(list_title + list);
            }

            $(".ui-list-item").hover(function(event){
              $(this).find('.ui-poptip').show();
            }, function(event){
              $(this).find('.ui-poptip').hide();
            });

        })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "获取信息出现问题，请刷新页面。");
        });

      });
      $(window).trigger('hashchange');

      $(".ui-tab-item[data-name=checking]").click(function(event){
        if (window.location.hash != "#type=1" && window.location.hash != ""){
          window.location.hash = "#type=1";
        }
      });
      $(".ui-tab-item[data-name=checked]").click(function(event){
        if (window.location.hash != "#type=2") {
          window.location.hash = "#type=2";
        }
      });

    }
  };
})(jQuery, Drupal, this, this.document);