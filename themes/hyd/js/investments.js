(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.investments = {
    attach: function(context, settings){

      var max_pages = 50;
      var per_page = 20;
      var display_pages = 7;
      var max_items = max_pages * per_page;

      var cats = ['','(房产) ','(机车) ','(黄金) ','(信用) ','(其他) '];

      var status_li = $('<li />').addClass('ui-list-status');
      var status_p = $('<p />').addClass('color-gray-text');
      var loading = status_li.clone().append(status_p.clone().append('加载中...'));
      var empty = status_li.clone().append(status_p.clone().append('没有记录'));

      $("#investment-list-pagination-1").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#type=1&page=', 
        displayedPages: display_pages, 
      }); 

      $("#investment-list-pagination-2").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#type=2&page=', 
        displayedPages: display_pages, 
      });

      $("#investment-list-pagination-3").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#type=3&page=', 
        displayedPages: display_pages, 
      });

      $("#investment-list-pagination-4").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#type=4&page=', 
        displayedPages: display_pages, 
      });

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
          var pagesCount = $("#investment-list-pagination-" + type).pagination('getPagesCount');
          if (page > 1){
            if (pagesCount > 0){
              if (page > pagesCount) {
                page = pagesCount;
              }
            }
            else{
              page = 1;
            }
          }
        }

        if (type == 1){ // show tab 1
          Drupal.behaviors.utils.showTab("notyet");
        }
        else if (type == 2){ // show tab 2
          Drupal.behaviors.utils.showTab("preinvesting");
        }
        else if (type == 3){ // show tab 3
          Drupal.behaviors.utils.showTab("investing");
        }
        else { // show tab 4
          type = 4;
          Drupal.behaviors.utils.showTab("finished");
        }

        var list = '#investment-list-' + type;

        var header = $(list).children().get(0);
        $(list).empty().append(header).append(loading);

        $.getJSON( Drupal.settings.basePath + "api/m_investments?type=" + type + "&page=" + page, function(d) {
          if (d.result != null && d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else{
            if (page == 1){
              var total = d.total;
              $("#investment-list-pagination-" + type).pagination('updateItems', total < max_items ? total : max_items); 
              $('#investment-total-'+type).html(total).parent().show();
            }

            $("#investment-list-pagination-" + type).pagination('selectPage', page);

            $(list).empty().append(header);
            var li = $('<li/>').addClass('ui-list-item text fn-clear');
            var span = $('<span />').addClass('ui-list-field fn-left ph5');
            var a = $('<a />').attr('target', '_blank');
            var btn1 = $('<a />').addClass('ui-button ui-button-small ui-button-blue reject').append("取消");
            var btn2 = $('<a />').addClass('ui-button ui-button-small ui-button-green').attr('target', '_blank').append("发布");
            var btn3 = $('<a />').addClass('ui-button ui-button-small ui-button-green').attr('target', '_blank').append("查看");

            if (type == 1){ // not yet
              if (d.investments.length > 0){
                for (var i = 0; i < d.investments.length; i++){
                  var w = d.investments[i];
                  var row = li.clone()
                    .append(span.clone().addClass('w260 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'loan_view#id=' + w.app_id).attr('title', w.title).append(cats[w.category] + w.title)))
                    .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).attr('title', w.nick).append(w.name)))
                    .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w55 text-right').append((w.rate * 100).toFixed(2) + '%'))
                    .append(span.clone().addClass('w30 text-right').append(w.duration.toFixed(0)))
                    .append(span.clone().addClass('w80 text-center').append(w.created.slice(0,10)))
                    .append(span.clone().addClass('w50 text-center').append(btn1.clone().attr('data-app-id', w.app_id)))
                    .append(span.clone().addClass('w50 text-center').append(btn2.clone().attr('href', Drupal.settings.basePath + 'management/investments/set#app_id='+ w.app_id + '&title=' + w.title + '&user_id=' + w.user_id + '&name=' + w.name + '&nick=' + w.nick + '&category=' + w.category + '&amount=' + w.amount + '&interest=' + w.interest + '&rate=' + w.rate + '&method=' + w.method + '&duration=' + w.duration + '&start=' + w.start + '&end=' + w.end + '&fine_rate=' + w.fine_rate + '&fine_is_single=' + w.fine_is_single + '&created=' + w.created)));
                  if (i % 2 == 0){
                    row.addClass('dark');
                  }
                  row.appendTo(list);
                }
              }
              else {
                $(list).append(empty);
              }
            }
            else if (type == 2){ // preinvesting
              if (d.investments.length > 0) {
                for (var i = 0; i < d.investments.length; i++){
                  var w = d.investments[i];
                  var row = li.clone()
                    .append(span.clone().addClass('w130 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'loan_view#id=' + w.app_id).attr('title', w.title).attr('style', w.loan_fine > 0 ? 'color:red' : '').append(cats[w.category] + w.title)))
                    .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).attr('title', w.nick).append(w.name)))
                    .append(span.clone().addClass('w85 text-right').append(w.investment_amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w85 text-right').append(w.investment.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w55 text-right').append((w.investment_rate * 100).toFixed(2) + '%'))
                    .append(span.clone().addClass('w30 text-right').append(w.investment_duration.toFixed(0)))
                    .append(span.clone().addClass('w80 text-center').append(w.investment_start.slice(0,10)))
                    .append(span.clone().addClass('w80 text-center').append(w.investment_created.slice(0,10)))
                    .append(span.clone().addClass('w50 text-center').append(btn3.clone().attr('href', Drupal.settings.basePath + 'invest/' + w.app_id)));
                  if (i % 2 == 0){
                    row.addClass('dark');
                  }
                  row.appendTo(list);
                }
              }
              else {
                $(list).append(empty);
              }
            }
            else if (type == 3){ // investing
              if (d.investments.length > 0) {
                for (var i = 0; i < d.investments.length; i++){
                  var w = d.investments[i];
                  var row = li.clone()
                    .append(span.clone().addClass('w130 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'loan_view#id=' + w.app_id).attr('title', w.title).attr('style', w.loan_fine > 0 ? 'color:red' : '').append(cats[w.category] + w.title)))
                    .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).attr('title', w.nick).append(w.name)))
                    .append(span.clone().addClass('w85 text-right').append(w.investment_amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w85 text-right').append(w.investment.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w55 text-right').append((w.investment_rate * 100).toFixed(2) + '%'))
                    .append(span.clone().addClass('w30 text-right').append(w.investment_duration.toFixed(0)))
                    .append(span.clone().addClass('w80 text-center').append(w.investment_end.slice(0,10)))
                    .append(span.clone().addClass('w80 text-center').append(w.investment_created.slice(0,10)))
                    .append(span.clone().addClass('w50 text-center').append(btn3.clone().attr('href', Drupal.settings.basePath + 'invest/' + w.app_id)));
                  if (i % 2 == 0){
                    row.addClass('dark');
                  }
                  row.appendTo(list);
                }
              }
              else {
                $(list).append(empty);
              }
            }
            else{ // finished
              if (d.investments.length > 0) {
                for (var i = 0; i < d.investments.length; i++){
                  var w = d.investments[i];
                  var row = li.clone()
                    .append(span.clone().addClass('w130 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'loan_view#id=' + w.app_id).attr('title', w.title).append(cats[w.category] + w.title)))
                    .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).attr('title', w.nick).append(w.name)))
                    .append(span.clone().addClass('w85 text-right').append(w.investment_amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w85 text-right').append(w.investment.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w55 text-right').append((w.investment_rate * 100).toFixed(2) + '%'))
                    .append(span.clone().addClass('w30 text-right').append(w.investment_duration.toFixed(0)))
                    .append(span.clone().addClass('w80 text-center').append(w.investment_end.slice(0,10)))
                    .append(span.clone().addClass('w80 text-center').append(w.investment_created.slice(0,10)))
                    .append(span.clone().addClass('w50 text-center').append(btn3.clone().attr('href', Drupal.settings.basePath + 'invest/' + w.app_id)));
                  if (i % 2 == 0){
                    row.addClass('dark');
                  }
                  row.appendTo(list);
                }
              }
              else {
                $(list).append(empty);
              }
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
          }
        })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "获取信息出现问题，请刷新页面。");
        });

      });
      $(window).trigger('hashchange');

      $(".ui-tab-item[data-name=notyet]").click(function(event){
        if (window.location.hash.indexOf("#type=1") < 0 && window.location.hash != ""){
          var current_page_type_1 = $("#investment-list-pagination-1").pagination('getCurrentPage');
          if (current_page_type_1 > 1){
            window.location.hash = "#type=1&page=" + current_page_type_1;
          } else {
            window.location.hash = "#type=1";  
          }
        }
      });
      $(".ui-tab-item[data-name=preinvesting]").click(function(event){
        if (window.location.hash.indexOf("#type=2") < 0){
          var current_page_type_2 = $("#investment-list-pagination-2").pagination('getCurrentPage');
          if (current_page_type_2 > 1){
            window.location.hash = "#type=2&page=" + current_page_type_2;
          } else {
            window.location.hash = "#type=2";
          }
        }
      });
      $(".ui-tab-item[data-name=investing]").click(function(event){
        if (window.location.hash.indexOf("#type=3") < 0){
          var current_page_type_3 = $("#investment-list-pagination-3").pagination('getCurrentPage');
          if (current_page_type_3 > 1){
            window.location.hash = "#type=3&page=" + current_page_type_3;
          } else {
            window.location.hash = "#type=3";
          }
        }
      });
      $(".ui-tab-item[data-name=finished]").click(function(event){
        if (window.location.hash.indexOf("#type=4") < 0){
          var current_page_type_4 = $("#investment-list-pagination-4").pagination('getCurrentPage');
          if (current_page_type_4 > 1){
            window.location.hash = "#type=4&page=" + current_page_type_4;
          } else {
            window.location.hash = "#type=4";
          }
        }
      });

    }
  };
})(jQuery, Drupal, this, this.document);