(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.investments_list = {
    attach: function(context, settings){

      var max_pages = 50;
      var per_page = 20;
      var display_pages = 7;
      var max_items = max_pages * per_page;

      var cats = ['','(房产) ','(机车) ','(黄金) ','(信用) ','(其他) '];

      var search_conditions = [0, 0, 1]; // search condition: duration, status, page

      var status_li = $('<li />').addClass('ui-list-status');
      var status_p = $('<p />').addClass('color-gray-text');
      var loading = status_li.clone().append(status_p.clone().append('加载中...'));
      var empty = status_li.clone().append(status_p.clone().append('没有投资项目记录'));

      // set up duration-ranges
      setConditions(duration_ranges, 'duration_conditions', 'duration', 0);
      // set up investment-status
      setConditions(investment_status, 'status_conditions', 'status', 1);

      $('li.ui-filter-tag').click(function(event){
        var input = $(this).find('input');
        if (input.attr('name') == 'duration'){
          index = 0;
        }
        else {
          index = 1;
        }
        search_conditions[index] = input.val();
        getResults();
      });

      Drupal.behaviors.list.init();

      $("#investment-list-pagination").pagination({
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
          var pagesCount = $("#investment-list-pagination").pagination('getPagesCount');
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
        search_conditions[2] = page;
        getResults();
      });
      $(window).trigger('hashchange');

      function setConditions(conditions, ul_id, input_name, index){
        var ul = $('#' + ul_id);
        var li = $('<li />').addClass('ui-filter-tag rrdcolor-dimgray-text category-tag condition');
        var input = $('<input />').attr('type', 'checkbox').attr('name', input_name);
        var span = $('<span />');

        for (var i = 0; i < conditions.length; i++){
          var c = conditions[i];
          var row = li.clone().append(input.clone().attr('value', c.id)).append(span.clone().append(c.name));
          ul.append(row);
        }
      }

      function getResults(){
        var header = $("#investment-list").children().get(0);
        $("#investment-list").empty().append(header).append(loading);

        $.getJSON( Drupal.settings.basePath + "api/investments?duration=" + search_conditions[0] + "&status=" + search_conditions[1] + "&page=" + search_conditions[2], 
          function(d) {
            if (d.result == 0){
              alert( "获取投资列表出现问题，请刷新页面。");
            }
            else {
	            $("#investment-list").empty().append(header);

	            var page = search_conditions[2];
	            if (page == 1){
		            var total = d.total;
	              $("#investment-list-pagination").pagination('updateItems', total < max_items ? total : max_items);
	              $('#investment-total').html(total).parent().show();
		          }

              if (d.products.length > 0) {
                var li = $('<li/>').addClass('ui-list-item fn-clear');
                var span = $('<span />').addClass('ui-list-field fn-left');
                var a = $('<a />').addClass('fn-left w230 rrd-dimgray fn-text-overflow').attr('target', '_blank');
                var em = $('<em />').addClass('value');
                var em2 = $('<em />');
                var strong = $('<strong />').addClass('ui-progressbar-mid');
                var btns = $('<a />').addClass('ui-button ui-button-mid ui-button-blue ui-list-invest-button').attr('target', '_blank').append('<span class="OPEN">投&nbsp;&nbsp;&nbsp;&nbsp;标</span><span class="READY FIRST_READY">已满标</span><span class="IN_PROGRESS">还款中</span><span class="CLOSED">已结束</span>');
                for (var i = 0; i < d.products.length; i++){
                  var p = d.products[i];
                  var progress = p.is_done == null ? (Math.round(p.investment / p.amount * 100)) : 100;
                  var btnClass = '';
                  if (p.is_done == null){
                    btnClass = 'ui-list-invest-button-OPEN';
                  }
                  else if (p.is_done == 0){
                    var today = new Date(d.today);
                    var start = new Date(Date.parse(p.start.replace(/-/g, "/")));
                    if (today >= start){
                      btnClass = 'ui-list-invest-button-IN_PROGRESS';
                    }
                    else {
                      btnClass = 'ui-list-invest-button-FIRST_READY';
                    }
                  }
                  else if (p.is_done == 1){
                    btnClass = 'ui-list-invest-button-CLOSED';
                  }
                  var row = li.clone()
                    .append(span.clone().addClass('text-big w230 pl15 pr20').append(a.clone().attr('href', Drupal.settings.basePath + 'invest/' + p.id).attr('title', p.title).append(cats[p.category] + p.title)))
                    .append(span.clone().addClass('num text-right w60 pr20').append(em.clone().append((p.rate * 100).toFixed(2))).append('%'))
                    .append(span.clone().addClass('num text-right w100 pr20').append(em.clone().append(p.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append('元'))
                    .append(span.clone().addClass('num text-right w50 pr20').append(em.clone().append(p.duration)).append('个月'))
                    .append(span.clone().addClass('w80 pr20').append(p.start.slice(0,10)))
                    .append(span.clone().addClass('w80 pr20').append(p.end.slice(0,10)))
                    .append(span.clone().addClass('w70 pr20').append(strong.clone().addClass('ui-progressbar-mid-' + progress).append(em2.clone().append(progress)).append('%')))
                    .append(span.clone().addClass('w90').append(btns.clone().addClass(btnClass).attr('href', Drupal.settings.basePath + 'invest/' + p.id)));

                  $('#investment-list').append(row);
                }
              }
              else{
                $('#investment-list').append(empty);
              }
            }
        })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "获取投资列表出现问题，请刷新页面。");
        });
      }

    }
  };
})(jQuery, Drupal, this, this.document);