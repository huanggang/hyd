(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.loanapp_view = {
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
          $.getJSON( Drupal.settings.basePath + "api/loanapp?id="+id, 
            function(d) {
              if (d.result == 0){
                alert( "获取信息出现问题，请刷新页面。");
              }
              else{
                var category = "";
                switch (d.category){
                  case 1:
                    category = "房屋商铺抵押";
                    $('#address-1').text(d.address);
                    $('#area-1').text(d.area);
                    $('#floor-1').text(d.floor);
                    $('#height-1').text(d.height);
                    $('#facing-1').text(map_id_name(facing, d.facing));
                    $('#year-1').text(d.year);
                    $('#usage-1').text(d.usage);
                    $('#has_loan-1').text(d.has_loan == 1 ? '是' : '否');
                    $('#certificate-1').text(d.has_certificate == 1 ? '是' : '否');
                    break;
                  case 2:
                    category = "机动车抵押";
                    var features = '';
                    var fa = d.features.split(',');
                    for (var i = 0; i < fa.length; i++){
                      features += map_id_name(vehicle_features, fa[i]) + '，';
                    }
                    $('#brand-2').text(d.brand);
                    $('#year-2').text(d.year);
                    $('#vin-2').text(d.vin);
                    $('#made-2').text(d.made);
                    $('#violations-2').text(d.violations);
                    $('#register-2').text(d.register);
                    $('#price-2').text(d.price.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#color-2').text(d.color);
                    $('#features-2').text(features.slice(0,-1));
                    $('#mileage-2').text(d.mileage.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#transfers-2').text(d.transfers.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#oversea-2').text(d.oversea == 1 ? '进口' : '国产');
                    $('#status-2').text(map_id_name(vehicle_status, d.vstatus));
                    $('#certificate-2').text(d.has_certificate == 1 ? '是' : '否');
                    break;
                  case 3:
                    category = "黄金抵押";
                    $('#name-3').text(d.name);
                    $('#weight-3').text(d.weight.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#purity-3').text(d.purity.toFixed(6));
                    $('#certificate-3').text(d.has_certificate == 1 ? '是' : '否');
                    break;
                  case 4:
                    category = "信用贷";
                    $('#organization-4').text(d.organization);
                    $('#position-4').text(d.position);
                    $('#years-4').text(d.years);
                    $('#months-4').text(d.months);
                    $('#income-4').text(d.income);
                    break;
                  case 5:
                    category = "其他抵押";
                    $('#name-5').text(d.name);
                    $('#bought-5').text(d.bought);
                    $('#price-5').text(d.price.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#certificate-5').text(d.has_certificate == 1 ? '是' : '否');
                    break;
                }
                $('#category').text(category);
                for (var i = 1; i <= 5; i++){
                  if (i == d.category){
                    $('#category-'+i).show();
                  }
                  else{
                    $('#category-'+i).hide();
                  }
                }
                $('#title').text(d.title);
                $('#amount').text(d.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#duration').text(d.duration.toFixed(0));
                $('#purpose').text(d.purpose);
                $('#asset_description').text(d.description);
                $('#status').text(map_id_name(application_status, d.status));
                if (d.is_loaned == null){
                  $('#is_loaned-div').hide();
                }
                else {
                  $('#is_loaned-div').show();
                  $('#is_loaned').text(d.is_loaned == 1 ? '是' : '否');
                }
                if (d.is_done == null){
                  $('#is_done-div').hide();
                }
                else {
                  $('#is_done-div').show();
                  $('#is_done').text(d.is_done == 1 ? '是' : '否');
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