(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.bankcard = {
    attach: function(context, settings){

      var max_pages = 50;
      var per_page = 20;

      var show_pages = 11;
      var show_pages_mid = 7; // show_pages == (show_pages_mid + 4)

      var total_2 = 0;
      var total_pages_2 = 0;
      var total_3 = 0;
      var total_pages_3 = 0;

      var cats = ['','(房产) ','(机车) ','(黄金) ','(其他) '];

      $.getJSON( Drupal.settings.basePath + "api/loans", 
        function(d) {
          if (d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else {
            $('#paid-interest').text((d.interest + d.r_interest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#average-rate').text((d.rate * 100).toFixed(2));
            $('#owned-total').text((d.w_amount + d.w_interest + d.w_owned + d.w_fine).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#paid-fine').text(d.fine.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#average-duration').text(d.duration.toFixed(2));
            $('#loan-total').text((d.amount + d.r_amount + d.w_amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#loan-times').text(d.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            if (d.n_date){
              $('#next-pay').html('下次还款日期 <em>' + d.n_date + '</em>，应还本息 <em>' + (d.n_amount + d.n_interest).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</em>元');
            }
            else{
              $('#next-pay').html('');
            }
            if ((d.w_owned + d.w_fine) > 0) {
              $('#owned-now').html('目前所欠本金 <em>' + d.w_owned.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</em>，逾期罚金 <em>' + d.w_fine.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</em>元');
            }
          }
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "获取信息出现问题，请刷新页面。");
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
        }

        if (type == 2){ // show tab 1
          $(".ui-tab-item[data-name=loan]").click();
        }
        else { // show tab 2
          type = 3;
          $(".ui-tab-item[data-name=loanapp]").click();
        }

        $.getJSON( Drupal.settings.basePath + "api/loans?type=" + type + "&page=" + page, 
          function(d) {
            var list_title = '';
            var list = '';
            var pagination = '<ul>';
            if (page == 1){
              var total = d.total;
              var total_pages = total == 0 ? 0 : Math.round(total / per_page) + 1;
              if (type == 2){
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
              if (type == 2){
                total = total_2;
                total_pages = total_pages_2;
              }
              else{
                total = total_3;
                total_pages = total_pages_3;
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
            $('#loan-list-pagination-'+ type).html(pagination);
            $('#loan-total-'+type).html("共"+total+"条");

            if (type == 2){ // loans
              list_title = '<li class="ui-list-header color-gray-text fn-clear"><span class="ui-list-title w220 ph5 fn-left">借款标题</span><span class="ui-list-title w85 ph5 fn-left">借款金额</span><span class="ui-list-title w85 ph5 fn-left">借款利息</span><span class="ui-list-title w55 ph5 fn-left">年利率</span><span class="ui-list-title w30 ph5 fn-left">月数</span><span class="ui-list-title w80 ph5 fn-left">借款日期</span><span class="ui-list-title w80 ph5 fn-left">到期日期</span><span class="ui-list-title w30 fn-left">还清</span></li>';
              for (var i = 0; i < d.loans.length; i++){
                var w = d.loans[i];
                list += '<li class="ui-list-item fn-clear';
                if (i % 2 == 0){
                  list += ' dark';
                }
                list += '"><span class="ui-list-field w220 ph5 fn-left" style="display: block; overflow: hidden"><a href="/loan_view#id='
                  + w.id + '" target="blank" title="' + w.title + '">' + cats[w.category] + w.title + '</a></span><span class="ui-list-field w85 ph5 fn-left text-right">' 
                  + w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w85 ph5 fn-left text-right">' 
                  + w.interest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w55 ph5 fn-left text-right">' 
                  + (w.rate * 100).toFixed(2) + '%</span><span class="ui-list-field w30 ph5 fn-left text-right">' 
                  + w.duration.toFixed(0) + '</span><span class="ui-list-field w80 ph5 fn-left text-center">'
                  + w.start.slice(0, 10) + '</span><span class="ui-list-field w80 ph5 fn-left text-center">'
                  + w.end.slice(0, 10) + '</span><span class="ui-list-field w30 fn-left text-center">'
                  + (w.is_done == null ? '' : (w.is_done == 1 ? '是' : '否')) + '</span></li>';
              }
              $('#loan-list-2').html(list_title + list);
            }
            else{ // loan-application
              list_title = '<li class="ui-list-header color-gray-text fn-clear"><span class="ui-list-title w300 ph5 fn-left">借款标题</span><span class="ui-list-title w80 ph5 fn-left">计划用款</span><span class="ui-list-title w30 ph5 fn-left">月数</span><span class="ui-list-title w60 ph5 fn-left">申请状态</span><span class="ui-list-title w60 ph5 fn-left">是否放款</span><span class="ui-list-title w60 ph5 fn-left">是否结束</span><span class="ui-list-title w80 ph5 fn-left">申请时间</span></li>';
              for (var i = 0; i < d.applications.length; i++){
                var w = d.applications[i];
                list += '<li class="ui-list-item fn-clear';
                if (i % 2 == 0){
                  list += ' dark';
                }
                list += '"><span class="ui-list-field w300 ph5 fn-left" style="display: block; overflow: hidden"><a href="/loanapp_view#id='
                  + w.id + '" target="blank" title="' + w.title + '">' + cats[w.category] + w.title + '</a></span><span class="ui-list-field w80 ph5 fn-left text-right">'
                  + w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w30 ph5 fn-left text-right">'
                  + w.duration.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span><span class="ui-list-field w60 ph5 fn-left text-center">'
                  + map_id_name(application_status, w.status) + '</span><span class="ui-list-field w60 ph5 fn-left text-center">'
                  + (w.is_loaned == null ? '' : (w.is_loaned == 1 ? '是' : '否')) + '</span><span class="ui-list-field w60 ph5 fn-left text-center">'
                  + (w.is_done == null ? '' : (w.is_done == 1 ? '是' : '否')) + '</span><span class="ui-list-field w80 fn-left text-center">'
                  + w.applied.slice(0, 10) + '</span></li>';
              }
              $('#loan-list-3').html(list_title + list);
            }

        })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "获取信息出现问题，请刷新页面。");
        });

      });
      $(window).trigger('hashchange');

      $(".ui-tab-item[data-name=loan]").click(function(event){
        if (window.location.hash != "#type=2" && window.location.hash != ""){
          window.location.hash = "#type=2";
        }
      });
      $(".ui-tab-item[data-name=loanapp]").click(function(event){
        if (window.location.hash != "#type=3") {
          window.location.hash = "#type=3";
        }
      });

    }
  };
})(jQuery, Drupal, this, this.document);