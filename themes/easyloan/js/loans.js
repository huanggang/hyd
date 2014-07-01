(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.loans = {
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

      $("#loan-list-pagination-1").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#type=1&page=', 
        displayedPages: display_pages, 
      }); 

      $("#loan-list-pagination-2").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#type=2&page=', 
        displayedPages: display_pages, 
      });

      $("#loan-list-pagination-3").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#type=3&page=', 
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
          var pagesCount = $("#loan-list-pagination-" + type).pagination('getPagesCount');
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
          Drupal.behaviors.utils.showTab("lending");
        }
        else { // show tab 3
          type = 3;
          Drupal.behaviors.utils.showTab("finished");
        }

        var list = '#loan-list-' + type;

        var header = $(list).children().get(0);
        $(list).empty().append(header).append(loading);

        $.getJSON( Drupal.settings.basePath + "api/m_loans?type=" + type + "&page=" + page, function(d) {
          if (d.result != null && d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else{
            if (page == 1){
              var total = d.total;
              $("#loan-list-pagination-" + type).pagination('updateItems', total < max_items ? total : max_items); 
              $('#loan-total-'+type).html(total).parent().show();
            }

            $("#loan-list-pagination-" + type).pagination('selectPage', page);

            $(list).empty().append(header);
            var li = $('<li/>').addClass('ui-list-item text fn-clear');
            var span = $('<span />').addClass('ui-list-field fn-left ph5');
            var a = $('<a />').attr('target', '_blank');
            var btn1 = $('<a />').addClass('ui-button ui-button-small ui-button-blue comment').append("查看");
            var btn2 = $('<a />').addClass('ui-button ui-button-small ui-button-blue').attr('target', '_blank').append("放款");

            if (type == 1){ // not yet
              if (d.loans.length > 0){
                for (var i = 0; i < d.loans.length; i++){
                  var w = d.loans[i];
                  var row = li.clone()
                    .append(span.clone().addClass('w300 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'loan_view#id=' + w.app_id).attr('title', w.title).append(cats[w.category] + w.title)))
                    .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).attr('title', w.nick).append(w.name)))
                    .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w30 text-right').append(w.duration.toFixed(0)))
                    .append(span.clone().addClass('w80 text-center').append(w.applied.slice(0,10)))
                    .append(span.clone().addClass('w60 text-center').append((w.comment != null && w.comment.length > 0) ? btn1.clone().attr('data-comment', w.comment) : ""))
                    .append(span.clone().addClass('w60 text-center').append(btn2.clone().attr('href', 'loans/lend#app_id=' + w.app_id + '&title=' + w.title + '&user_id=' + w.user_id + '&name=' + w.name + '&nick=' + w.nick + '&category=' + w.category + '&amount=' + w.amount + '&duration=' + w.duration + '&applied=' + w.applied)));
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
            else if (type == 2){ // lending
              if (d.loans.length > 0){
                for (var i = 0; i < d.loans.length; i++){
                  var w = d.loans[i];
                  var row = li.clone()
                    .append(span.clone().addClass('w195 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'loan_view#id=' + w.app_id).attr('title', w.title).attr('style', w.fine > 0 ? 'color:red' : '').append(cats[w.category] + w.title)))
                    .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).attr('title', w.nick).append(w.name)))
                    .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w85 text-right').append(w.interest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w55 text-right').append((w.rate * 100).toFixed(2) + '%'))
                    .append(span.clone().addClass('w30 text-right').append(w.duration.toFixed(0)))
                    .append(span.clone().addClass('w80 text-center').append(w.end.slice(0,10)))
                    .append(span.clone().addClass('w80 text-center').append(w.created.slice(0,10)))
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
              if (d.loans.length > 0){
                for (var i = 0; i < d.loans.length; i++){
                  var w = d.loans[i];
                  var row = li.clone()
                    .append(span.clone().addClass('w195 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'loan_view#id=' + w.app_id).attr('title', w.title).append(cats[w.category] + w.title)))
                    .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).attr('title', w.nick).append(w.name)))
                    .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w85 text-right').append(w.interest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w55 text-right').append((w.rate * 100).toFixed(2) + '%'))
                    .append(span.clone().addClass('w30 text-right').append(w.duration.toFixed(0)))
                    .append(span.clone().addClass('w80 text-center').append(w.end.slice(0,10)))
                    .append(span.clone().addClass('w80 text-center').append(w.created.slice(0,10)));
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

            // set up buttons: comment, check-status
            $('.comment').click(function(event){
              var dialog = $('<div />').attr('id', 'dialog-form').attr('title', '审核备注').append($('<div />').addClass('comment').append($(this).attr("data-comment")));
              $('body').append(dialog);
              $('#dialog-form').dialog({
                autoOpen: false,
                height: 410,
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

      $(".ui-tab-item[data-name=notyet]").click(function(event){
        if (window.location.hash.indexOf("#type=1") < 0 && window.location.hash != ""){
          var current_page_type_1 = $("#loan-list-pagination-1").pagination('getCurrentPage');
          if (current_page_type_1 > 1){
            window.location.hash = "#type=1&page=" + current_page_type_1;
          } else {
            window.location.hash = "#type=1";  
          }
        }
      });
      $(".ui-tab-item[data-name=lending]").click(function(event){
        if (window.location.hash.indexOf("#type=2") < 0){
          var current_page_type_2 = $("#loan-list-pagination-2").pagination('getCurrentPage');
          if (current_page_type_2 > 1){
            window.location.hash = "#type=2&page=" + current_page_type_2;
          } else {
            window.location.hash = "#type=2";
          }
        }
      });
      $(".ui-tab-item[data-name=finished]").click(function(event){
        if (window.location.hash.indexOf("#type=3") < 0){
          var current_page_type_3 = $("#loan-list-pagination-3").pagination('getCurrentPage');
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