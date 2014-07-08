(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.applications = {
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

      $("#debtor-list-pagination").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#page=', 
        displayedPages: display_pages, 
      }); 

      $(window).bind('hashchange', function(){
        var hash = window.location.hash;
        var page = 1;
        if (hash.length > 1){
          hash = hash.slice(1);
          var params = hash.split("&");
          for (var i = 0; i < params.length; i++){
            var pairs = params[i].split("=");
            if (pairs[0] == "page"){
              page = Number(pairs[1]);
              if (page > max_pages) {
                page = max_pages;
              }
              else if (page < 1) {
                page = 1;
              }
            }
          }
          var pagesCount = $("#debtor-list-pagination").pagination('getPagesCount');
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

        var list = '#debtor-list';

        var header = $(list).children().get(0);
        $(list).empty().append(header).append(loading);

        $.getJSON( Drupal.settings.basePath + "api/m_owned_users?page=" + page, function(d) {
          if (d.result != null && d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else {
            if (page == 1){
              var total = d.total;
              $("#debtor-list-pagination").pagination('updateItems', total < max_items ? total : max_items); 
              $('#debtor-total').html(total).parent().show();
            }

            $("#debtor-list-pagination").pagination('selectPage', page);

            $(list).empty().append(header);
            var li = $('<li/>').addClass('ui-list-item color-gray-text fn-clear');
            var span = $('<span />').addClass('ui-list-field fn-left ph5');
            var a = $('<a />').attr('target', '_blank');
            var btn = $('<a />').attr('target', '_blank').addClass('ui-button ui-button-small ui-button-blue').append("查看");

            if (d.users.length > 0){
              for (var i = 0; i < d.users.length; i++){
                var w = d.users[i];
                var row = li.clone()
                  .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).attr('title', w.nick).append(w.name)))
                  .append(span.clone().addClass('w95 text-right').append(w.owned.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                  .append(span.clone().addClass('w85 text-right').append(w.fine.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                  .append(span.clone().addClass('w210 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'loan_view#id=' + w.app_id).attr('title', w.title).append(cats[w.category] + w.title)))
                  .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                  .append(span.clone().addClass('w80 text-center').append(w.end.slice(0,10)))
                  .append(span.clone().addClass('w60 text-center').append(btn.clone().attr('href', Drupal.settings.basePath + 'management/accountsindebt/detail#id=' + w.user_id + '&start=' + w.start.slice(0,10))));
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
        })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "获取信息出现问题，请刷新页面。");
        });

      });
      $(window).trigger('hashchange');

    }
  };
})(jQuery, Drupal, this, this.document);