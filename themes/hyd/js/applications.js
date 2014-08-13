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

      $("#check-list-pagination-1").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#type=1&page=', 
        displayedPages: display_pages, 
      }); 

      $("#check-list-pagination-2").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#type=2&page=', 
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
          var pagesCount = $("#check-list-pagination-" + type).pagination('getPagesCount');
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
          Drupal.behaviors.utils.showTab("checking");
        }
        else { // show tab 2
          type = 2;
          Drupal.behaviors.utils.showTab("checked");
        }

        var list = '#check-list-' + type;

        var header = $(list).children().get(0);
        $(list).empty().append(header).append(loading);

        $.getJSON( Drupal.settings.basePath + "api/m_loan_applications?type=" + type + "&page=" + page, function(d) {
          if (d.result != null && d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else {
            if (page == 1){
              var total = d.total;
              $("#check-list-pagination-" + type).pagination('updateItems', total < max_items ? total : max_items); 
              $('#check-total-'+type).html(total).parent().show();
            }

            $("#check-list-pagination-" + type).pagination('selectPage', page);

            $(list).empty().append(header);
            var li = $('<li/>').addClass('ui-list-item text fn-clear');
            var span = $('<span />').addClass('ui-list-field fn-left ph5');
            var a = $('<a />').attr('target', '_blank');
            var btn1 = $('<a />').addClass('ui-button ui-button-small ui-button-green comment').append("查看");
            var btn2 = $('<a />').addClass('ui-button ui-button-small ui-button-green check').append("审核");

            if (type == 1){ // checking
              if (d.applications.length > 0){
                for (var i = 0; i < d.applications.length; i++){
                  var w = d.applications[i];
                  var row = li.clone()
                    .append(span.clone().addClass('w260 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'loanapp_view#id=' + w.app_id).attr('title', w.title).append(cats[w.category] + w.title)));
                  if (w.user_id != null && w.user_id > 0){
                    row = row
                      .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).attr('title', w.nick).append(w.name)));
                  }
                  else {
                    row = row
                      .append(span.clone().addClass('w50').append(a.clone().attr('title', w.nick).append(w.name)));
                  }
                  row = row
                    .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w30 text-right').append(w.duration.toFixed(0)))
                    .append(span.clone().addClass('w30 text-center').append(map_id_name(application_status, w.status)))
                    .append(span.clone().addClass('w80 text-center').append(w.applied.slice(0,10)));
                  if (w.comment != null && w.comment.length > 0){
                    row = row
                      .append(span.clone().addClass('w60 text-center').append(btn1.clone().attr('data-comment', w.comment)))
                      .append(span.clone().addClass('w60 text-center').append(btn2.clone().attr('data-app-id', w.app_id).attr('data-status', w.status).attr('data-comment', w.comment)));
                  }
                  else {
                    row = row
                      .append(span.clone().addClass('w60 text-center').append(''))
                      .append(span.clone().addClass('w60 text-center').append(btn2.clone().attr('data-app-id', w.app_id).attr('data-status', w.status).attr('data-comment', '')));
                  }
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
            else { // checked
              if (d.applications.length > 0){
                for (var i = 0; i < d.applications.length; i++){
                  var w = d.applications[i];
                  var row = li.clone()
                    .append(span.clone().addClass('w300 fn-text-overflow').append(a.clone().attr('href', Drupal.settings.basePath + 'loanapp_view#id=' + w.app_id).attr('title', w.title).append(cats[w.category] + w.title)));
                  if (w.user_id != null && w.user_id > 0){
                    row = row
                      .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).attr('title', w.nick).append(w.name)))
                  }
                  else {
                    row = row
                      .append(span.clone().addClass('w50').append(a.clone().attr('title', w.nick).append(w.name)));
                  }
                  row = row
                    .append(span.clone().addClass('w85 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w30 text-right').append(w.duration.toFixed(0)))
                    .append(span.clone().addClass('w30 text-center').append(map_id_name(application_status, w.status)))
                    .append(span.clone().addClass('w80 text-center').append(w.applied.slice(0,10)));
                  if (w.comment != null && w.comment.length > 0){
                    row = row.append(span.clone().addClass('w60 text-center').append(btn1.clone().attr('data-comment', w.comment)))
                  }
                  else {
                    row = row.append(span.clone().addClass('w60 text-center').append(''));
                  }
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
                height: 320,
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

            $('.check').click(function(event){
              var app_id = $(this).attr("data-app-id");
              var comment = $(this).attr("data-comment").replace(/<br\/>/g, "\n");
              var status = Number($(this).attr("data-status"));

              var html = '<div id="dialog-form" title="审核借款申请"><form class="ui-form"><fieldset><div class="inputs"><div class="ui-form-item"><label class="ui-label">借款编号</label><span id="app_id">' + app_id + '</span></div><div class="ui-form-item"><label class="ui-label">选择状态</label><select name="statusId" style="width:80px" id="status">';
              var options = '';
              for (var i = 0; i < application_status.length; i++){
                options += '<option value="' + application_status[i].id + '"';
                if (status == application_status[i].id){
                  options += ' selected="selected"';
                }
                options += '>' + application_status[i].name + '</option>';
              }
              html += options + '</select></div><div class="ui-form-item"><label class="ui-label">备注</label><textarea class="ui-textarea" id="comment" row="6" style="width:90%;height:160px">' + (comment == null ? '' : comment) + '</textarea></div></div></fieldset></form></div>';

              $('body').append(html);

              $('#dialog-form').dialog({
                autoOpen: false,
                height: 410,
                width: 650,
                modal: true,
                closeText: "关闭本框",
                buttons: {
                  "提 交": function() {
                    $.post(Drupal.settings.basePath + "api/m_loan_applications", 
                      {
                        app_id: $('#app_id').text(),
                        status: $('#status').val(),
                        comment: $('#comment').val(),
                      },
                      function(d) {
                        if (d.result == 1){
                          location.reload();
                        }
                        else{
                          alert( "设置出现问题，请重新设置。" );
                        }
                    }, "json")
                    .fail(function( jqxhr, textStatus, error ) {
                      var err = textStatus + ", " + error;
                      alert( "网络出现问题，请刷新页面。" );
                    });
                    $( this ).dialog( "close" );
                  },
                  "取 消": function() {
                    $( this ).dialog( "close" );
                  }
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

      $(".ui-tab-item[data-name=checking]").click(function(event){
        if (window.location.hash.indexOf("#type=1") < 0 && window.location.hash != ""){
          var current_page_type_1 = $("#check-list-pagination-1").pagination('getCurrentPage');
          if (current_page_type_1 > 1){
            window.location.hash = "#type=1&page=" + current_page_type_1;
          } else {
            window.location.hash = "#type=1";  
          }
        }
      });
      $(".ui-tab-item[data-name=checked]").click(function(event){
        if (window.location.hash.indexOf("#type=2") < 0){
          var current_page_type_2 = $("#check-list-pagination-2").pagination('getCurrentPage');
          if (current_page_type_2 > 1){
            window.location.hash = "#type=2&page=" + current_page_type_2;
          } else {
            window.location.hash = "#type=2";
          }
        }
      });

    }
  };
})(jQuery, Drupal, this, this.document);