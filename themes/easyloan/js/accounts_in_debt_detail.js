(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.applications = {
    attach: function(context, settings){

      var status_li = $('<li />').addClass('ui-list-status');
      var status_p = $('<p />').addClass('color-gray-text');
      var loading = status_li.clone().append(status_p.clone().append('加载中...'));
      var empty = status_li.clone().append(status_p.clone().append('没有记录'));

      $(window).bind('hashchange', function(){
        var hash = window.location.hash;
        var id = 0;
        var start = "";
        if (hash.length > 1){
          hash = hash.slice(1);
          var params = hash.split("&");
          for (var i = 0; i < params.length; i++){
            var pairs = params[i].split("=");
            if (pairs[0] == "id"){
              id = Number(pairs[1]);
            }
            else if (pairs[0] == "start"){
              start = pairs[1];
            }
          }
        }
        $('#btn_transactions').attr('href', Drupal.settings.basePath + 'capital_management/deals/' + id);

        var list = '#debt-list';

        var header = $(list).children().get(0);
        $(list).empty().append(header).append(loading);

        $.getJSON( Drupal.settings.basePath + "api/m_owned_user?id=" + id + "&start=" + start, function(d) {
          if (d.result != null && d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else {
            $(list).empty().append(header);
            var li = $('<li/>').addClass('ui-list-item color-gray-text fn-clear');
            var span = $('<span />').addClass('ui-list-field fn-left ph5');
            var a = $('<a />').attr('target', '_blank');
            var btn = $('<a />').attr('target', '_blank').addClass('ui-button ui-button-small ui-button-blue').append("查看");

            if (d.transcations.length > 0){
              $('#debt-total').html(d.total).parent().show();

              for (var i = 0; i < d.transcations.length; i++){
                var w = d.transcations[i];
                var row = li.clone()
                  .append(span.clone().addClass('w80 text-center').append(w.time.slice(0,10)))
                  .append(span.clone().addClass('w90 text-center').append(map_id_name(transaction_types, w.type)));
                switch (w.type)
                {
                  case 1:
                  case 4:
                  case 5:
                    row = row
                      .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                      .append(span.clone().addClass('w90 text-right').append('0.00'));
                    break;
                  case 2:
                  case 3:
                  case 6:
                  case 8:
                  case 9:
                  case 10:
                    row = row
                      .append(span.clone().addClass('w85 text-right').append('0.00'))
                      .append(span.clone().addClass('w90 text-right').append(w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
                    break;
                  case 7:
                    row = row
                      .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                      .append(span.clone().addClass('w90 text-right').append(w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
                    break;
                }
                row = row
                  .append(span.clone().addClass('w90 text-right').append(w.available.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
                if (w.owned > 0){
                  row = row
                    .append(span.clone().addClass('w90 text-right').append(w.owned.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w85 text-right').append(w.fine.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
                }
                else{
                  row = row
                    .append(span.clone().addClass('w90 text-right').append('0.00'))
                    .append(span.clone().addClass('w85 text-right').append('0.00'));
                }
                row = row
                  .append(span.clone().addClass('w50 text-right').append(Number(w.note == null ? 0 : w.note).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
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