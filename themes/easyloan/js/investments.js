(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.investments = {
    attach: function(context, settings){

      var max_pages = 50;
      var per_page = 20;

      var show_pages = 11;
      var show_pages_mid = 7; // show_pages == (show_pages_mid + 4)

      var total_1 = 0;
      var total_pages_1 = 0;
      var total_2 = 0;
      var total_pages_2 = 0;
      var total_3 = 0;
      var total_pages_3 = 0;

      var cats = ['','(房产) ','(机车) ','(黄金) ','(信用) ','(其他) '];

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
          Drupal.behaviors.utils.showTab("notyet");
        }
        else if (type == 2){ // show tab 2
          Drupal.behaviors.utils.showTab("investing");
        }
        else { // show tab 3
          type = 3;
          Drupal.behaviors.utils.showTab("finished");
        }

        $.getJSON( Drupal.settings.basePath + "api/m_investments?type=" + type + "&page=" + page, 
          function(d) {
            var list_title = '';
            var list = '';
            var pagination = '<ul>';
            if (page == 1){
              var total = d.total;
              var total_pages = total == 0 ? 0 : Math.floor((total - 1)/ per_page) + 1;
              if (type == 1){
                total_1 = total;
                total_pages_1 = total_pages;
              }
              else if (type == 2){
                total_2 = total;
                total_pages_2 = total_pages;
              }
              else{
                total_3 = total;
                total_pages_3 = total_pages;
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
            $('#investment-list-pagination-'+ type).html(pagination);
            $('#investment-total-'+type).html("共"+total+"条");

            if (type == 1){ // not yet
              list_title = '<li class="ui-list-header color-gray-text fn-clear"><span class="ui-list-title w260 ph5 fn-left">借款标题</span><span class="ui-list-title w50 ph5 fn-left">借款人</span><span class="ui-list-title w85 ph5 fn-left">借款金额</span><span class="ui-list-title w55 ph5 fn-left">年利率</span><span class="ui-list-title w30 ph5 fn-left">月数</span><span class="ui-list-title w80 ph5 fn-left">放款日期</span><span class="ui-list-title w110 ph5 fn-left">募集资金</span></li>';
              for (var i = 0; i < d.investments.length; i++){
                var w = d.investments[i];
                list += '<li class="ui-list-item fn-clear';
                if (i % 2 == 0){
                  list += ' dark';
                }
                list += '"><span class="ui-list-field w260 ph5 fn-left fn-text-overflow"><a href="/loan_view#id='
                  + w.app_id + '" target="_blank" title="' + w.title + '">' + cats[w.category] + w.title + '</a></span><span class="ui-list-field w50 ph5 fn-left"><a href="/user/'
                  + w.user_id + '" target="_blank" title="' + w.nick + '">' + w.name + '</a></span><span class="ui-list-field w85 ph5 fn-left text-right">' 
                  + w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w55 ph5 fn-left text-right">'
                  + (w.rate * 100).toFixed(2) + '%</span><span class="ui-list-field w30 ph5 fn-left text-right">' 
                  + w.duration.toFixed(0) + '</span><span class="ui-list-field w80 ph5 fn-left text-center">' 
                  + w.created.slice(0,10) + '</span><span class="ui-list-field w50 ph5 fn-left"><a class="ui-button ui-button-small ui-button-blue reject" data-app-id="' 
                  + w.app_id + '">取消</a></span><span class="ui-list-field w50 ph5 fn-left"><a class="ui-button ui-button-small ui-button-green" href="investments/set#app_id=' + w.app_id + '&title=' + w.title + '&user_id=' + w.user_id + '&name=' + w.name + '&nick=' + w.nick + '&category=' + w.category + '&amount=' + w.amount + '&interest=' + w.interest + '&rate=' + w.rate + '&method=' + w.method + '&duration=' + w.duration + '&start=' + w.start + '&end=' + w.end + '&fine_rate=' + w.fine_rate + '&fine_is_single=' + w.fine_is_single + '&created=' + w.created + '" class="ui-button ui-button-small ui-button-green" target="_blank">发布</a></span></li>';
              }
              $('#investment-list-1').html(list_title + list);
            }
            else if (type == 2){ // investing
              list_title = '<li class="ui-list-header color-gray-text fn-clear"><span class="ui-list-title w130 ph5 fn-left">借款标题</span><span class="ui-list-title w50 ph5 fn-left">借款人</span><span class="ui-list-title w85 ph5 fn-left">计划金额</span><span class="ui-list-title w85 ph5 fn-left">募集金额</span><span class="ui-list-title w55 ph5 fn-left">年利率</span><span class="ui-list-title w30 ph5 fn-left">月数</span><span class="ui-list-title w80 ph5 fn-left">到期日期</span><span class="ui-list-title w80 ph5 fn-left">发布日期</span><span class="ui-list-title w50 ph5 fn-left">详细</span></li>';
              for (var i = 0; i < d.investments.length; i++){
                var w = d.investments[i];
                list += '<li class="ui-list-item fn-clear';
                if (i % 2 == 0){
                  list += ' dark';
                }
                list += '"><span class="ui-list-field w130 ph5 fn-left fn-text-overflow"><a href="/loan_view#id='
                  + w.app_id + '" target="_blank" title="' + w.title + '"';
                if (w.loan_fine > 0){
                  list += ' style="color:red"';
                }
                list += '>' + cats[w.category] + w.title + '</a></span><span class="ui-list-field w50 ph5 fn-left"><a href="/user/'
                  + w.user_id + '" target="_blank" title="' + w.nick + '">' + w.name + '</a></span><span class="ui-list-field w85 ph5 fn-left text-right">'
                  + w.investment_amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w85 ph5 fn-left text-right">'
                  + w.investment.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w55 ph5 fn-left text-right">'
                  + (w.investment_rate * 100).toFixed(2) + '%</span><span class="ui-list-field w30 ph5 fn-left text-right">'
                  + w.investment_duration.toFixed(0) + '</span><span class="ui-list-field w80 ph5 fn-left text-center">'
                  + w.investment_end.slice(0,10) + '</span><span class="ui-list-field w80 ph5 fn-left text-center">'
                  + w.investment_created.slice(0,10) + '</span><span class="ui-list-field w50 ph5 fn-left"><a class="ui-button ui-button-small ui-button-green" href="/invest/'
                  + w.app_id + '" target="_blank">查看</a></span></li>';
              }
              $('#investment-list-2').html(list_title + list);
            }
            else{ // finished
              list_title = '<li class="ui-list-header color-gray-text fn-clear"><span class="ui-list-title w130 ph5 fn-left">借款标题</span><span class="ui-list-title w50 ph5 fn-left">借款人</span><span class="ui-list-title w85 ph5 fn-left">计划金额</span><span class="ui-list-title w85 ph5 fn-left">募集金额</span><span class="ui-list-title w55 ph5 fn-left">年利率</span><span class="ui-list-title w30 ph5 fn-left">月数</span><span class="ui-list-title w80 ph5 fn-left">到期日期</span><span class="ui-list-title w80 ph5 fn-left">发布日期</span><span class="ui-list-title w50 ph5 fn-left">详细</span></li>';
              for (var i = 0; i < d.investments.length; i++){
                var w = d.investments[i];
                list += '<li class="ui-list-item fn-clear';
                if (i % 2 == 0){
                  list += ' dark';
                }
                list += '"><span class="ui-list-field w130 ph5 fn-left fn-text-overflow"><a href="/loan_view#id='
                  + w.app_id + '" target="_blank" title="' + w.title + '">' + cats[w.category] + w.title + '</a></span><span class="ui-list-field w50 ph5 fn-left"><a href="/user/'
                  + w.user_id + '" target="_blank" title="' + w.nick + '">' + w.name + '</a></span><span class="ui-list-field w85 ph5 fn-left text-right">'
                  + w.investment_amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w85 ph5 fn-left text-right">'
                  + w.investment.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w55 ph5 fn-left text-right">'
                  + (w.investment_rate * 100).toFixed(2) + '%</span><span class="ui-list-field w30 ph5 fn-left text-right">'
                  + w.investment_duration.toFixed(0) + '</span><span class="ui-list-field w80 ph5 fn-left text-center">'
                  + w.investment_end.slice(0,10) + '</span><span class="ui-list-field w80 ph5 fn-left text-center">'
                  + w.investment_created.slice(0,10) + '</span><span class="ui-list-field w50 ph5 fn-left"><a class="ui-button ui-button-small ui-button-green" href="/invest/'
                  + w.app_id + '" target="_blank">查看</a></span></li>';
              }
              $('#investment-list-3').html(list_title + list);
            }

            // set up buttons: reject
            $('.reject').click(function(event){
              if (confirm("确定要取消募集资金?")){
                var app_id = $(this).attr("data-app-id");
                $.getJSON( Drupal.settings.basePath + "api/m_set_investment?type=0&app_id=" + app_id, 
                  function(d) {
                    if (d.result == 1){
                      location.reload();
                    }
                    else{
                      alert( "设置出现问题，请重新设置。");
                    }
                })
                .fail(function( jqxhr, textStatus, error ) {
                  var err = textStatus + ", " + error;
                  alert( "获取信息出现问题，请刷新页面。");
                });
              }
            });

        })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "获取信息出现问题，请刷新页面。");
        });

      });
      $(window).trigger('hashchange');

      $(".ui-tab-item[data-name=notyet]").click(function(event){
        if (window.location.hash != "#type=1" && window.location.hash != ""){
          window.location.hash = "#type=1";
        }
      });
      $(".ui-tab-item[data-name=investing]").click(function(event){
        if (window.location.hash != "#type=2") {
          window.location.hash = "#type=2";
        }
      });
      $(".ui-tab-item[data-name=finished]").click(function(event){
        if (window.location.hash != "#type=3") {
          window.location.hash = "#type=3";
        }
      });

    }
  };
})(jQuery, Drupal, this, this.document);