(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.applications = {
    attach: function(context, settings){

      var max_pages = 50;
      var per_page = 20;

      var show_pages = 11;
      var show_pages_mid = 7; // show_pages == (show_pages_mid + 4)

      var total_1 = 0;
      var total_pages_1 = 0;
      var total_2 = 0;
      var total_pages_2 = 0;

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
          showTab("checking");
        }
        else { // show tab 2
          type = 2;
          showTab("checked");
        }

        $.getJSON( Drupal.settings.basePath + "api/m_loan_applications?type=" + type + "&page=" + page, 
          function(d) {
            var list_title = '';
            var list = '';
            var pagination = '<ul>';
            if (page == 1){
              var total = d.total;
              var total_pages = total == 0 ? 0 : Math.floor((total - 1) / per_page) + 1;
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
            $('#check-list-pagination-'+ type).html(pagination);
            $('#check-total-'+type).html("共"+total+"条");

            if (type == 1){ // checking
              list_title = '<li class="ui-list-header color-gray-text fn-clear"><span class="ui-list-title w260 ph5 fn-left title">借款标题</span><span class="ui-list-title w50 ph5 fn-left">借款人</span><span class="ui-list-title w85 ph5 fn-left text-right">计划用款</span><span class="ui-list-title w30 ph5 fn-left">月数</span><span class="ui-list-title w30 ph5 fn-left">状态</span><span class="ui-list-title w80 ph5 fn-left">申请日期</span><span class="ui-list-title w60 ph5 fn-left">备注</span><span class="ui-list-title w60 ph5 fn-left">审核</span></li>';
              for (var i = 0; i < d.applications.length; i++){
                var w = d.applications[i];
                list += '<li class="ui-list-item fn-clear';
                if (i % 2 == 0){
                  list += ' dark';
                }
                list += '"><span class="ui-list-field w260 ph5 fn-left" style="display:block;overflow:hidden"><a href="/loanapp_view#id='
                  + w.app_id + '" target="blank" title="' + w.title + '">' + cats[w.category] + w.title + '</a></span><span class="ui-list-field w50 ph5 fn-left"><a href="/user/'
                  + w.user_id + '" target="blank" title="' + w.nick + '">' + w.name + '</a></span><span class="ui-list-field w85 ph5 fn-left text-right">' 
                  + w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w30 ph5 fn-left text-right">' 
                  + w.duration.toFixed(0) + '</span><span class="ui-list-field w30 ph5 fn-left">' 
                  + map_id_name(application_status, w.status) + '</span><span class="ui-list-field w80 ph5 fn-left text-center">'
                  + w.applied.slice(0,10) + '</span><span class="ui-list-field w60 ph5 fn-left text-center">';
                  if (w.comment != null && w.comment.length > 0){
                    list += '<a class="ui-button ui-button-small ui-button-green comment" data-comment="' + w.comment + '">查看</a>';
                  }
                  list += '</span><span class="ui-list-field w60 ph5 fn-left text-center"><a class="ui-button ui-button-small ui-button-green check" data-app-id="'
                  + w.app_id + '" data-status="' + w.status + '" data-comment="' + (w.comment == null ? '' : w.comment) + '">审核</a></span></li>';
              }
              $('#check-list-1').html(list_title + list);
            }
            else{ // checked
              list_title = '<li class="ui-list-header color-gray-text fn-clear"><span class="ui-list-title w300 ph5 fn-left title">借款标题</span><span class="ui-list-title w50 ph5 fn-left">借款人</span><span class="ui-list-title w85 ph5 fn-left text-right">计划用款</span><span class="ui-list-title w30 ph5 fn-left">月数</span><span class="ui-list-title w30 ph5 fn-left">状态</span><span class="ui-list-title w80 ph5 fn-left">申请日期</span><span class="ui-list-title w60 ph5 fn-left">备注</span></li>';
              for (var i = 0; i < d.applications.length; i++){
                var w = d.applications[i];
                list += '<li class="ui-list-item fn-clear';
                if (i % 2 == 0){
                  list += ' dark';
                }
                list += '"><span class="ui-list-field w300 ph5 fn-left" style="display:block;overflow:hidden"><a href="/loanapp_view#id='
                  + w.app_id + '" target="blank" title="' + w.title + '">' + cats[w.category] + w.title + '</a></span><span class="ui-list-field w50 ph5 fn-left"><a href="/user/'
                  + w.user_id + '" target="blank" title="' + w.nick + '">' + w.name + '</a></span><span class="ui-list-field w85 ph5 fn-left text-right">'
                  + w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w30 ph5 fn-left text-right">'
                  + w.duration.toFixed(0) + '</span><span class="ui-list-field w30 ph5 fn-left">'
                  + map_id_name(application_status, w.status) + '</span><span class="ui-list-field w80 ph5 fn-left text-center">'
                  + w.applied.slice(0,10) + '</span><span class="ui-list-field w60 ph5 fn-left text-center">';
                  if (w.comment != null && w.comment.length > 0){
                    list += '<a class="ui-button ui-button-small ui-button-green comment" data-comment="' + w.comment + '">查看</a>';
                  }
                  list += '</span></li>';
              }
              $('#check-list-2').html(list_title + list);
            }

            // set up buttons: comment, check-status
            $('.comment').click(function(event){
              $('body').append('<div id="dialog-form" title="审核备注">' + $(this).attr("data-comment") + '</div>');
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

            $('.check').click(function(event){
              var app_id = $(this).attr("data-app-id");
              var comment = $(this).attr("data-comment");
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