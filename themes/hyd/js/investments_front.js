(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.investments_front = {
    attach: function(context, settings){

      var cats = ['','(房产) ','(机车) ','(黄金) ','(信用) ','(其他) '];

      $.getJSON( Drupal.settings.basePath + "api/investments?front=1", 
        function(d) {
          if (d.result == 0){
            alert( "获取投资列表出现问题，请刷新页面。");
          }
          else {
            var li = $('<li/>').addClass('ui-list-item fn-clear');
            var span = $('<span />').addClass('ui-list-field fn-left');
            var a = $('<a />').addClass('fn-left w250 rrd-dimgray fn-text-overflow').attr('target', '_blank');
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
                var today = new Date();
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
                .append(span.clone().addClass('text-big w250 pl15 pr20').append(a.clone().attr('href', Drupal.settings.basePath + 'invest/' + p.id).attr('title', p.title).append(cats[p.category] + p.title)))
                .append(span.clone().addClass('num text-right w60 pr20').append(em.clone().append((p.rate * 100).toFixed(2))).append('%'))
                .append(span.clone().addClass('num text-right w100 pr20').append(em.clone().append(p.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","))).append('元'))
                .append(span.clone().addClass('num text-right w50 pr20').append(em.clone().append(p.duration)).append('个月'))
                .append(span.clone().addClass('w80 pr20').append(p.start.slice(0,10)))
                .append(span.clone().addClass('w80 pr20').append(p.end.slice(0,10)))
                .append(span.clone().addClass('w70 pr20').append(strong.clone().addClass('ui-progressbar-mid-' + progress).append(em2.clone().append(progress)).append('%')))
                .append(span.clone().addClass('w90').append(btns.clone().addClass(btnClass).attr('href', Drupal.settings.basePath + 'invest/' + p.id)));

                $('#products').before(row);
            }
          }
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "获取投资列表出现问题，请刷新页面。");
      });

    }
  };
})(jQuery, Drupal, this, this.document);