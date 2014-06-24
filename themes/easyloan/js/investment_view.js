(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.investment_view = {
    attach: function(context, settings){

      var cats = ['','(房产) ','(机车) ','(黄金) ','(信用) ','(其他) '];

      $(window).bind('hashchange', function(){
        var href = window.location.href;
        var index = href.lastIndexOf("/");
        var id = Number(href.substr(index+1));

        if (id > 0) {
          $.getJSON( Drupal.settings.basePath + "api/investment?id="+id, 
            function(d) {
              if (d.result == 0){
                if (d.message == "Not found"){
                  alert( "投资项目不存在。");
                }
                else {
                  alert( "获取投资项目信息出现问题，请刷新页面。");
                }
              }
              else{
                $('#title').text(cats[d.category] + d.title);
                $('#amount').text(d.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#rate').text((d.rate * 100).toFixed(2));
                $('#duration').text(d.duration.toFixed(0));
                $('#repayment_method').text(map_id_name(repayment_methods, d.repayment_method));
                $('#created').text(d.created.slice(0,10));
                $('#start').text(d.start.slice(0,10));
                $('#end').text(d.end.slice(0,10));
                $('#minimum').text(d.minimum.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#step').text(d.step.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                if (d.fine_is_single != null && d.fine_rate > 0){
                  $('#has_fine').show();
                  $('#fine_rate').text((d.fine_rate * 100).toFixed(2));
                  $('#fine_is_single').text(d.fine_is_single == 1 ? "单利" : "复利");
                }
                else{
                  $('#no_fine').show();
                }
                if (d.is_done == null) {// not start yet
                  $('#is_apply').show();
                  var progress = (d.investment / d.amount * 100).toFixed(0);
                  $('#apply_progress_1').attr("style", "width: " + progress + "%");
                  $('#apply_progress_2').text(progress + "%");

                  $('#panel_invest').show();
                  $('#invest_left').text("￥" + (d.amount - d.investment).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")).attr("data-amount", (d.amount - d.investment).toFixed(0));
                  
                }
                else if (d.is_done == 0){ // start, but not finished

                }
                else if (d.is_done == 1){ // finished

                }

              }
          })
          .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            alert( "获取信息出现问题，请刷新页面。");
          });
        }

      });
      $(window).trigger('hashchange');

    }
  };
})(jQuery, Drupal, this, this.document);