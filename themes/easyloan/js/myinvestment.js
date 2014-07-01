(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.myloan = {
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
      
      $.getJSON( Drupal.settings.basePath + "api/myinvestments", 
        function(d) {
          if (d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else {
            $('#investment_earnings').text((d.interest + d.fine).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#investment_rate').text((d.rate * 100).toFixed(2));
            $('#investment_duration').text(d.duration.toFixed(2));
            $('#investment_holdings').text(d.holdings);
            $('#investment_closed').text(d.total);
          }
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "获取信息出现问题，请刷新页面。");
      });

      $("#investment-list-pagination-2").pagination({
        items: 0,      // total items 
        itemsOnPage: per_page,  // items per page
        hrefTextPrefix: '#type=2&page=', 
        displayedPages: display_pages, 
      }); 

      $("#investment-list-pagination-3").pagination({
        items: 0,      // total items 
        itemsOnPage: per_page,  // items per page
        hrefTextPrefix: '#type=3&page=', 
        displayedPages: display_pages, 
      });

      $(window).bind('hashchange', function(){
        var hash = window.location.hash;
        var type = 2;
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
        if (type == 2){ // show tab 1
          Drupal.behaviors.utils.showTab("holding");
        }
        else { // show tab 2
          type = 3;
          Drupal.behaviors.utils.showTab("closed");
        }
        var list = '#investment-list-' + type;

        var header = $(list).children().get(0);
        $(list).empty().append(header).append(loading);
        
        var targetUrl = Drupal.settings.basePath + "api/myinvestments?type=" + type + "&page=" + page;
        $.getJSON( targetUrl).done(function(d) {
          if (d.result != null && d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else {
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
            var btn = $('<a />').addClass('ui-button ui-button-small ui-button-green check').append("查看");
            var today = new Date();
            if (type == 2){ // holding investments
              if(d.investments.length > 0){
                for (var i = 0; i <= d.investments.length - 1; i++) {
                  var w = d.investments[i];
                  var start = new Date(Date.parse(p.start.replace(/-/g, "/")));
                  var progress = w.is_done == null ? "募集" : (w.is_done == 1 ? "结束" : (w.is_done == 0 && today < start ? "满标" : "还款"));
                  var row = li.clone()
                    .append(span.clone().addClass('w140 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'invest/' + w.id).attr('title', w.title).append(cats[w.category] + w.title)))
                    .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w85 text-right').append((w.r_interest + w.w_interest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w55 text-right').append((w.rate * 100).toFixed(2) + '%'))
                    .append(span.clone().addClass('w30 text-right').append(w.duration.toFixed(0)))
                    .append(span.clone().addClass('w80 text-center').append(w.start.slice(0, 10)))
                    .append(span.clone().addClass('w80 text-center').append(w.end.slice(0, 10)))
                    .append(span.clone().addClass('w30 text-center').append(progress))
                    .append(span.clone().addClass('w60 text-center').append(btn.clone().attr('inv_id',w.id).attr('inv_progress',progress).attr('inv_title', cats[w.category] + w.title).attr('amount',w.amount).attr('r_amount',w.r_amount).attr('r_interest',w.r_interest).attr('w_amount',w.w_amount).attr('w_interest',w.w_interest).attr('a_amount',w.a_amount).attr('a_interest',w.a_interest).attr('r_fine',w.r_fine).attr('n_date',w.n_date.slice(0, 10)).attr('n_amount',w.n_amount).attr('n_interest',w.n_interest).attr('w_owned',w.w_owned).attr('w_fine',w.w_fine).attr('rate', (w.rate * 100).toFixed(2)).attr('method',map_id_name(repayment_methods,w.method)).attr('duration',w.duration).attr('start',w.start.slice(0, 10)).attr('end',w.end.slice(0, 10))));
                  if (i % 2 == 0){
                    row.addClass('dark');
                  }
                  row.appendTo(list);
                }
              } else {
                // no results
                $(list).append(empty);
              }
            } else {
              if(d.investments.length > 0){
                for (var i = 0; i <= d.investments.length - 1; i++) {
                  var w = d.investments[i];
                  var row = li.clone()
                    .append(span.clone().addClass('w180 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'invest/' + w.id).attr('title', w.title).append(cats[w.category] + w.title)))
                    .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w85 text-right').append(w.r_interest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w55 text-right').append((w.rate * 100).toFixed(2) + '%'))
                    .append(span.clone().addClass('w30 text-right').append(w.duration.toFixed(0)))
                    .append(span.clone().addClass('w80 text-center').append(w.start.slice(0, 10)))
                    .append(span.clone().addClass('w80 text-center').append(w.end.slice(0, 10)))
                    .append(span.clone().addClass('w60 text-center').append(btn.clone().attr('inv_id',w.id).attr('inv_title', cats[w.category] + w.title).attr('amount',w.amount).attr('r_amount',w.r_amount).attr('r_interest',w.r_interest).attr('a_amount',w.a_amount).attr('a_interest',w.a_interest).attr('r_fine',w.r_fine).attr('rate', (w.rate * 100).toFixed(2)).attr('method',map_id_name(repayment_methods,w.method)).attr('duration',w.duration).attr('start',w.start.slice(0,10)).attr('end',w.end.slice(0,10)).attr('finished',w.finished.slice(0,10))));
                  if (i % 2 == 0){
                    row.addClass('dark');
                  }
                  row.appendTo(list);
                }
              } else {
                // no results
                $(list).append(empty);
              }
            }
            // set up click event for check-button
            $('.check').click(function(event){
              var div = $('<div />').addClass('ui-form-item');
              var label = $('<label />').addClass('ui-label');
              var span = $('<span />');
              var dialog = null;
              var height = null;
              if ($(this).attr('n_date') == null){
                height = 400;
                dialog = $('<div />').attr('id', 'dialog-form').attr('title', '投资详情').append($('<div />').addClass('info')
                  .append(div.clone().append(label.clone().append('借款标题')).append(span.clone().append($(this).attr('inv_title'))))
                  .append(div.clone().append(label.clone().append('投资金额')).append(span.clone().append(Number($(this).attr('amount')).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('预期收益')).append(span.clone().append(Number($(this).attr('r_interest')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('年利率')).append(span.clone().append($(this).attr('rate'))).append(' %'))
                  .append(div.clone().append(label.clone().append('投资期限')).append(span.clone().append($(this).attr('duration'))).append(' 个月'))
                  .append(div.clone().append(label.clone().append('成立日期')).append(span.clone().append($(this).attr('start'))))
                  .append(div.clone().append(label.clone().append('到期日期')).append(span.clone().append($(this).attr('end'))))
                  .append(div.clone().append(label.clone().append('结束日期')).append(span.clone().append($(this).attr('finished'))))
                  .append(div.clone().append(label.clone().append('已收本金')).append(span.clone().append(Number($(this).attr('a_amount')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('已收利息')).append(span.clone().append(Number($(this).attr('a_interest')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('已获罚金')).append(span.clone().append(Number($(this).attr('r_fine')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                );
              }
              else{
                height = 450;
                dialog = $('<div />').attr('id', 'dialog-form').attr('title', '投资详情').append($('<div />').addClass('info')
                  .append(div.clone().append(label.clone().append('借款标题')).append(span.clone().append($(this).attr('inv_title'))))
                  .append(div.clone().append(label.clone().append('投资金额')).append(span.clone().append(Number($(this).attr('amount')).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('预期收益')).append(span.clone().append((Number($(this).attr('r_interest')) + Number($(this).attr('w_interest'))).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('年利率')).append(span.clone().append($(this).attr('rate'))).append(' %'))
                  .append(div.clone().append(label.clone().append('投资期限')).append(span.clone().append($(this).attr('duration'))).append(' 个月'))
                  .append(div.clone().append(label.clone().append('成立日期')).append(span.clone().append($(this).attr('start'))))
                  .append(div.clone().append(label.clone().append('到期日期')).append(span.clone().append($(this).attr('end'))))
                  .append(div.clone().append(label.clone().append('进度')).append(span.clone().append($(this).attr('inv_progress'))))
                  .append(div.clone().append(label.clone().append('下次收款日期')).append(span.clone().append($(this).attr('n_date'))))
                  .append(div.clone().append(label.clone().append('下次收款本金')).append(span.clone().append(Number($(this).attr('n_amount')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('下次收款利息')).append(span.clone().append(Number($(this).attr('n_interest')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('已收本金')).append(span.clone().append(Number($(this).attr('a_amount')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('已收利息')).append(span.clone().append(Number($(this).attr('a_interest')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('已获罚金')).append(span.clone().append(Number($(this).attr('r_fine')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('待收本金')).append(span.clone().append(Number($(this).attr('w_amount')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('待收利息')).append(span.clone().append(Number($(this).attr('w_interest')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('欠款金额')).append(span.clone().append(Number($(this).attr('w_owned')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                  .append(div.clone().append(label.clone().append('欠款罚金')).append(span.clone().append(Number($(this).attr('w_fine')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append(' 元'))
                );
              }
              $('body').append(dialog);
              $('#dialog-form').dialog({
                autoOpen: false,
                height: height,
                width: 650,
                modal: true,
                closeText: "关闭本框",
                buttons: {
                  "确 定": function() {
                    $( this ).dialog( "close" );
                  },
                },
                close: function() {
                  $(this).remove();
                }
              });
              $('.ui-dialog').css("z-index","99999");
              $('#dialog-form').dialog("open");
            });

          }
        })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "获取信息出现问题，请刷新页面。");
        });
      });

      $(window).trigger('hashchange');

      $(".ui-tab-item[data-name=holding]").click(function(event){
        if (window.location.hash.indexOf("#type=2") < 0 && window.location.hash != ""){
          var current_page_type_2 = $("#investment-list-pagination-2").pagination('getCurrentPage');
          if (current_page_type_2 > 1){
            window.location.hash = "#type=2&page=" + current_page_type_2;  
          } else {
            window.location.hash = "#type=2";  
          }
        }
      });
      $(".ui-tab-item[data-name=closed]").click(function(event){
        if (window.location.hash.indexOf("#type=3") < 0) {
          var current_page_type_3 = $("#investment-list-pagination-3").pagination('getCurrentPage');
          if (current_page_type_3 > 1){
            window.location.hash = "#type=3&page=" + current_page_type_3;  
          } else {
            window.location.hash = "#type=3";
          }
        }
      });
    }
  };
})(jQuery, Drupal, this, this.document);