(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.bankcard = {
    attach: function(context, settings){

      $(window).bind('hashchange', function(){
        var id = 0;
        var hash = window.location.hash;
        if (hash.length > 1){
          hash = hash.slice(1);
          var params = hash.split("&");
          for (var i = 0; i < params.length; i++){
            var pairs = params[i].split("=");
            if (pairs[0] === "id") {
              id = Number(pairs[1]);
            }
          }
        }

        if (id > 0) {
          $.getJSON( Drupal.settings.basePath + "api/loan?id="+id, 
            function(d) {
              if (d.result == 0){
                alert( "获取信息出现问题，请刷新页面。");
              }
              else{
                var category = "";
                switch (d.category){
                  case 1:
                    category = "房屋商铺";
                    break;
                  case 2:
                    category = "机动车";
                    break;
                  case 3:
                    category = "黄金";
                    break;
                  case 4:
                    category = "其他";
                    break;
                }
                $('#category').text(category);
                $('#title').text(d.title);
                $('#amount').text(d.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#interest').text(d.interest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#rate').text((d.rate * 100).toFixed(2));
                $('#method').text(map_id_name(repayment_methods, d.method));
                $('#fine_rate').text((d.fine_rate * 100).toFixed(2));
                $('#fine_is_single').text(d.fine_is_single == 1 ? '单利' : '复利');
                $('#fine').text(d.fine.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#duration').text(d.duration.toFixed(0));
                $('#start').text(d.start.slice(0,10));
                $('#end').text(d.end.slice(0,10));
                if (d.is_done == 1){
                  $('#finished-div').show();
                  $('finished').text(d.finished.slice(0,10));
                  $('#wait-div').hide();
                }
                else{
                  $('#finished-div').hide();
                  $('#wait-div').show();
                  $('#w_amount').text(d.w_amount == null ? "0.00" : d.w_amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                  $('#w_interest').text(d.w_interest == null ? "0.00" : d.w_interest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                  $('#w_owned').text(d.w_owned == null ? "0.00" : d.w_owned.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                  $('#w_fine').text(d.w_fine == null ? "0.00" : d.w_fine.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
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