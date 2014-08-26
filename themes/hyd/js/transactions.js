(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.myloan = {
    attach: function(context, settings){

      var max_pages = 50;
      var per_page = 20;
      var display_pages = 7;
      var max_items = max_pages * per_page;
      
      var status_li = $('<li />').addClass('ui-list-status');
      var status_p = $('<p />').addClass('color-gray-text');
      var loading = status_li.clone().append(status_p.clone().append('加载中...'));
      var empty = status_li.clone().append(status_p.clone().append('没有记录'));
      var init = status_li.clone().append(status_p.clone().append('尚未查询'));

      var href = window.location.href;
      var index = href.lastIndexOf("/");
      var id = Number(href.substr(index+1));

      var targetUrl = Drupal.settings.basePath + "api/transaction_summary";
      if (id > 0){
        targetUrl += "?id=" + id;
      }
      $.getJSON( targetUrl, 
        function(d) {
          if (d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else {
            $('#available').text(d.available.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#frozen').text(d.frozen.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#savings').text(d.sv_amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#withdraws').text(d.wth_amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#sv_fee').text(d.sv_fee.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#wth_fee').text(d.wth_fee.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          }
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "获取信息出现问题，请刷新页面。");
      });

      var option = $('<option />');
      for (var i = 0; i < transaction_types.length; i++){
        var t = transaction_types[i];
        $('#transaction_type').append(option.clone().attr('value', t.id).append(t.name));
      }
      for (var i = 0; i < transaction_time_ranges.length; i++){
        var t = transaction_time_ranges[i];
        $('#transaction_range').append(option.clone().attr('value', t.id).append(t.name));
      }

      var type = 0;
      var range = 1;

      $('#query-submit').click(function(event){
        type = Number($('#transaction_type option:selected').val());
        range = Number($('#transaction_range option:selected').val());
        getResults(1);
      });

      $("#transaction-list-pagination").pagination({
        items: 0,      // total items 
        itemsOnPage: per_page,  // items per page
        hrefTextPrefix: '#page=', 
        displayedPages: display_pages, 
      });

      var header = $('#transaction-list').children().get(0);
      $('#transaction-list').empty().append(header).append(init);

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
          var pagesCount = $("#transaction-list-pagination").pagination('getPagesCount');
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
        getResults(page);
      });


      function getResults(page){
        var list = '#transaction-list';

        var header = $(list).children().get(0);
        $(list).empty().append(header).append(loading);
        
        var targetUrl = Drupal.settings.basePath + "api/transactions?type=" + type + "&range=" + range + "&page=" + page;
        if (id > 0){
          targetUrl += "&id=" + id;
        }
        $.getJSON( targetUrl).done(function(d) {
          if (d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else {
            if (page == 1){
              var total = d.total;
              $("#transaction-list-pagination").pagination('updateItems', total < max_items ? total : max_items); 
              $('#transaction-total').html(total).parent().show();
            }

            $("#transaction-list-pagination").pagination('selectPage', page);
            
            $(list).empty().append(header);
            var li = $('<li/>').addClass('ui-list-item text fn-clear');
            var span = $('<span />').addClass('ui-list-field fn-left');
            if(d.transactions.length > 0){
              for (var i = 0; i <= d.transactions.length - 1; i++) {
                var w = d.transactions[i];
                var row = li.clone()
                  .append(span.clone().addClass('w120 text-center').append(w.time.slice(0,16)))
                  .append(span.clone().addClass('w90 text-center ph5').append(map_id_name(transaction_types, w.type)));
                switch (w.type)
                {
                  case 1:
                  case 4:
                  case 5:
                  case 6:
                  case 11:
                    row = row
                      .append(span.clone().addClass('w85 text-right ph5').append(w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                      .append(span.clone().addClass('w85 text-right ph5').append('0.00'));
                    break;
                  case 2:
                  case 3:
                  case 8:
                  case 9:
                  case 10:
                  case 12:
                    row = row
                      .append(span.clone().addClass('w85 text-right ph5').append('0.00'))
                      .append(span.clone().addClass('w85 text-right ph5').append(w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
                    break;
                  case 7:
                    row = row
                      .append(span.clone().addClass('w85 text-right ph5').append(w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                      .append(span.clone().addClass('w85 text-right ph5').append(w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
                    break;
                }
                row = row
                  .append(span.clone().addClass('w85 text-right ph5').append(w.available.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
                if (w.owned > 0){
                  row = row
                    .append(span.clone().addClass('w85 text-right ph5').append(w.owned.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w80 text-right ph5').append(w.fine.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
                }
                else{
                  row = row
                    .append(span.clone().addClass('w85 text-right ph5').append('0.00'))
                    .append(span.clone().addClass('w80 text-right ph5').append('0.00'));
                }
                row = row
                  .append(span.clone().addClass('w50 text-right').append(Number(w.note == null ? 0 : w.note).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
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
        })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "获取信息出现问题，请刷新页面。");
        });
      }

    }
  };
})(jQuery, Drupal, this, this.document);