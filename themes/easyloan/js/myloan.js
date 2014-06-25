(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.myloan = {
    attach: function(context, settings){

      var cats = ['','(房产) ','(机车) ','(黄金) ','(信用) ','(其他) '];

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

      var page_total2 = $('#loan-total-2').html();
      page_total2 = page_total2 > 0 ? page_total2 : 0;
      var page_total3 = $('#loan-total-3').html();
      page_total3 = page_total3 > 0 ? page_total3 : 0;
      
      $("#loan-list-pagination-2").pagination({
        items: page_total2,      // total items 
        itemsOnPage: 2,  // items per page
        hrefTextPrefix: '#type=2&page=', 
        displayedPages:3, 
      }); 

      $("#loan-list-pagination-3").pagination({
        items: page_total3,      // total items 
        itemsOnPage: 2,  // items per page
        hrefTextPrefix: '#type=3&page=', 
        displayedPages:3, 
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
          Drupal.behaviors.utils.showTab("loan");
        }
        else { // show tab 2
          type = 3;
          Drupal.behaviors.utils.showTab("loanapp");
        }

        $.getJSON( Drupal.settings.basePath + "api/loans?type=" + type + "&page=" + page, 
          function(d) {
            var total = d.total;
            if (total > 0){
              $("#loan-list-pagination-" + type).pagination('updateItems', total); 
              $('#loan-total-'+type).html(total);
            }

            var list_title = ''; 
            var list = ''; 
            if (type == 2){ // loans
              var header = $('#loan-list-2').children().get(0);

              if(d.loans.length > 0){
                $('#loan-list-2').empty().append(header);
                
                for (var i = 0; i <= d.loans.length - 1; i++) {
                  var w = d.loans[i];
                  var li = $('<li/>').addClass('ui-list-item text fn-clear');
                  var span = $('<span />').addClass('ui-list-field fn-left');
                  var row = li.clone()
                            .append(span.clone().addClass('w220 ph5').css({display: 'block', overflow: 'hidden'})
                                .append('<a href="' + Drupal.settings.basePath + 'loan_view#id=' + w.id + '" target="blank" title="' + w.title + '">' 
                                  + cats[w.category] + w.title + '</a>'))
                            .append(span.clone().addClass('w85 ph5 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                            .append(span.clone().addClass('w85 ph5 text-right').append(w.interest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                            .append(span.clone().addClass('w55 ph5 text-right').append((w.rate * 100).toFixed(2)))
                            .append(span.clone().addClass('w30 ph5 text-right').append(w.duration.toFixed(0)))
                            .append(span.clone().addClass('w80 ph5 text-center').append(w.start.slice(0, 10)))
                            .append(span.clone().addClass('w80 ph5 text-center').append(w.end.slice(0, 10)))
                            .append(span.clone().addClass('w30 text-center').append((w.is_done == null ? '' : (w.is_done == 1 ? '是' : '否'))))
                  if (i % 2 == 0){
                    row.addClass('dark');
                  }
                  row.appendTo('#loan-list-2');
                }
              }
            } else {
              var header = $('#loan-list-3').children().get(0);
              if(d.applications.length > 0){
                $('#loan-list-3').empty().append(header);

                for (var i = 0; i <= d.applications.length - 1; i++) {
                  var w = d.applications[i];
                  var li = $('<li/>').addClass('ui-list-item text fn-clear');
                  var span = $('<span />').addClass('ui-list-field fn-left ph5');
                  var row = li.clone()
                            .append(span.clone().addClass('w300').css({display: 'block', overflow: 'hidden'})
                                .append('<a href="' + Drupal.settings.basePath + 'loanapp_view#id=' + w.id + '" target="blank" title="' + w.title + '">' 
                                  + cats[w.category] + w.title + '</a>'))
                            .append(span.clone().addClass('w80 text-right').append(w.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                            .append(span.clone().addClass('w30 text-right').append(w.duration.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                            .append(span.clone().addClass('w60 text-center').append(map_id_name(application_status, w.status)))
                            .append(span.clone().addClass('w60 text-center').append((w.is_loaned == null ? '' : (w.is_loaned == 1 ? '是' : '否'))))
                            .append(span.clone().addClass('w60 text-center').append((w.is_done == null ? '' : (w.is_done == 1 ? '是' : '否'))))
                            .append(span.clone().addClass('w80 text-center').append(w.applied.slice(0, 10)))
                  if (i % 2 == 0){
                    row.addClass('dark');
                  }
                  row.appendTo('#loan-list-3');
                }
              }
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