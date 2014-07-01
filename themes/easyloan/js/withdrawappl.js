(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.withdrawappl = {
    attach: function(context, settings){

      var max_pages = 50;
      var per_page = 20;
      var display_pages = 7;
      var max_items = max_pages * per_page;

      var status_li = $('<li />').addClass('ui-list-status');
      var status_p = $('<p />').addClass('color-gray-text');
      var loading = status_li.clone().append(status_p.clone().append('加载中...'));
      var empty = status_li.clone().append(status_p.clone().append('没有记录'));

      $("#withdrawapp-list-pagination-1").pagination({
        items: 0,
        itemsOnPage: per_page,
        hrefTextPrefix: '#type=1&page=', 
        displayedPages: display_pages, 
      });

      $("#withdrawapp-list-pagination-2").pagination({
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
          var pagesCount = $("#withdrawapp-list-pagination-" + type).pagination('getPagesCount');
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

        var list = '#withdrawapp-list-' + type;

        var header = $(list).children().get(0);
        $(list).empty().append(header).append(loading);

        $.getJSON( Drupal.settings.basePath + "api/m_withdraws?type=" + type + "&page=" + page, function(d) {
          if (d.result != null && d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else{
            if (page == 1){
              var total = d.total;
              $("#withdrawapp-list-pagination-" + type).pagination('updateItems', total < max_items ? total : max_items); 
              $('#withdrawapp-total-'+type).html(total).parent().show();
            }

            $("#withdrawapp-list-pagination-" + type).pagination('selectPage', page);

            $(list).empty().append(header);
            var li = $('<li/>').addClass('ui-list-item text fn-clear');
            var span = $('<span />').addClass('ui-list-field fn-left ph5');
            var a = $('<a />').attr('target', '_blank');
            var btn1 = $('<a />').addClass('ui-button ui-button-small ui-button-green transfer').append("转账");
            var btn2 = $('<a />').addClass('ui-button ui-button-small ui-button-green reject').append("拒绝");
            var div1 = $('<div />').addClass('ui-poptip fn-hide').attr('data-widget-cid', 'widget-2').css('z-index', '99').css('position', 'absolute').css('left', '320px').css('display', 'none');
            var div2 = $('<div />').addClass('ui-poptip-shadow');
            var div3 = $('<div />').addClass('ui-poptip-container');
            var div4 = $('<div />').addClass('ui-poptip-arrow ui-poptip-arrow-10').append($('<em />')).append($('<span />'));
            var div5 = $('<div />').addClass('ui-poptip-content').attr('data-role', 'content');
            var div6 = $('<div />').addClass('fn-clear');
            var label = $('<label />').addClass('font-nm w80 fn-left text-right');
            var div7 = $('<div />').addClass('w150 ph10 fn-left');
            var div8 = $('<div />').addClass('w230 ph10 fn-left');

            if (type == 1){ // checking
              if (d.withdraws.length > 0) {
                for (var i = 0; i < d.withdraws.length; i++){
                  var w = d.withdraws[i];
                  var div = div1.clone().css('top', (i * 35 + 36).toString() + 'px').append(div2.clone().append(div3.clone().append(div4.clone()).append(div5.clone()
                    .append(div6.clone().append(label.clone().append('开户行')).append(div7.clone().append( w.branch)))
                    .append(div6.clone().append(label.clone().append('开户行所在地')).append(div7.clone().append(w.address)))
                    .append(div6.clone().append(label.clone().append('银行卡号')).append(div7.clone().append(w.number.replace(/\B(?=(\d{4})+(?!\d))/g, " "))))
                    .append(div6.clone().append(label.clone().append('申请日期')).append(div7.clone().append(w.time)))
                    )));
                  var row = li.clone()
                    .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).append(w.name)))
                    .append(span.clone().addClass('w90 text-right').addClass(w.is_owned ? 'red' : '').append(w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w40 text-right').addClass(w.is_owned ? 'red' : '').append(w.fee.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w100 text-center').append(map_id_name(banks, w.bank)))
                    .append(span.clone().addClass('w180').append(w.number.replace(/\B(?=(\d{4})+(?!\d))/g, " ")))
                    .append(span.clone().addClass('w80 text-center').append(w.time.slice(0,10)))
                    .append(span.clone().addClass('w60 text-center').append(btn1.clone().attr('data-user-id', w.user_id).attr('data-number', w.number).attr('data-amount', w.amount).attr('data-fee', w.fee)))
                    .append(span.clone().addClass('w60 text-center').append(btn2.clone().attr('data-user-id', w.user_id).attr('data-number', w.number).attr('data-amount', w.amount).attr('data-fee', w.fee)))
                    .append(div);
                  if (i % 2 == 0){
                    row.addClass('dark');
                  }
                  row.appendTo(list);
                }

                $('.transfer').click(function(event){
                  if (confirm("确定转账吗？")) {
                    var user_id = $(this).attr("data-user-id");
                    var number = $(this).attr("data-number");
                    var amount = $(this).attr("data-amount");
                    var fee = $(this).attr("data-fee");
                    var time = (new Date()).format("yyyy-MM-dd hh:mm:ss.S");
                    $.getJSON( Drupal.settings.basePath + "api/m_set_withdraw?type=1&id=" + user_id + '&time=' + time + '&number=' + number + '&amount=' + amount + '&fee=' + fee, 
                      function(d) {
                        if (d.result == 1){
                          location.reload();
                        }
                        else {
                          alert( "设置出现问题，请重新设置。");
                        }
                    })
                    .fail(function( jqxhr, textStatus, error ) {
                      var err = textStatus + ", " + error;
                      alert( "设置出现问题，请刷新页面。");
                    });
                  }
                });

                $('.reject').click(function(event){
                  if (confirm("确定拒绝吗？")) {
                    var user_id = $(this).attr("data-user-id");
                    var number = $(this).attr("data-number");
                    var amount = $(this).attr("data-amount");
                    var fee = $(this).attr("data-fee");
                    var time = (new Date()).format("yyyy-MM-dd hh:mm:ss.S");
                    $.getJSON( Drupal.settings.basePath + "api/m_set_withdraw?type=0&id=" + user_id + '&time=' + time + '&number=' + number + '&amount=' + amount + '&fee=' + fee, 
                      function(d) {
                        if (d.result == 1){
                          location.reload();
                        }
                        else {
                          alert( "设置出现问题，请重新设置。");
                        }
                    })
                    .fail(function( jqxhr, textStatus, error ) {
                      var err = textStatus + ", " + error;
                      alert( "设置出现问题，请刷新页面。");
                    });
                  }
                });
              }
              else {
                $(list).append(empty);
              }
            }
            else{ // checked
              if (d.withdraws.length > 0) {
                for (var i = 0; i < d.withdraws.length; i++){
                  var w = d.withdraws[i];
                  var div = div1.clone().css('top', (i * 35 + 36).toString() + 'px').append(div2.clone().append(div3.clone().append(div4.clone()).append(div5.clone()
                    .append(div6.clone().append(label.clone().append('开户行')).append(div8.clone().append( w.branch)))
                    .append(div6.clone().append(label.clone().append('开户行所在地')).append(div8.clone().append(w.address)))
                    .append(div6.clone().append(label.clone().append('银行卡号')).append(div8.clone().append(w.number.replace(/\B(?=(\d{4})+(?!\d))/g, " "))))
                    .append(div6.clone().append(label.clone().append('申请日期')).append(div8.clone().append(w.time)))
                    .append(div6.clone().append(label.clone().append('转账日期')).append(div8.clone().append(w.done)))
                    )));
                  var row = li.clone()
                    .append(span.clone().addClass('w50').append(a.clone().attr('href', Drupal.settings.basePath + 'user/' + w.user_id).append(w.name)))
                    .append(span.clone().addClass('w90 text-right').append(w.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w40 text-right').append(w.fee.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")))
                    .append(span.clone().addClass('w100 text-center').append(map_id_name(banks, w.bank)))
                    .append(span.clone().addClass('w180').append(w.number.replace(/\B(?=(\d{4})+(?!\d))/g, " ")))
                    .append(span.clone().addClass('w80 text-center').append(w.time.slice(0,10)))
                    .append(span.clone().addClass('w80 text-center').append(w.done.slice(0,10)))
                    .append(span.clone().addClass('w40 text-center').append((w.is_done ? '是' : '否')))
                    .append(div);
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

            $(".ui-list-item").hover(function(event){
              $(this).find('.ui-poptip').show();
            }, function(event){
              $(this).find('.ui-poptip').hide();
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
          var current_page_type_1 = $("#withdrawapp-list-pagination-1").pagination('getCurrentPage');
          if (current_page_type_1 > 1){
            window.location.hash = "#type=1&page=" + current_page_type_1;
          } else {
            window.location.hash = "#type=1";  
          }
        }
      });
      $(".ui-tab-item[data-name=checked]").click(function(event){
        if (window.location.hash.indexOf("#type=2") < 0){
          var current_page_type_2 = $("#withdrawapp-list-pagination-2").pagination('getCurrentPage');
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