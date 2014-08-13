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
                    $('#address-1').text(d.address == null ? "" : d.address);
                    $('#area-1').text(d.area == null ? "" : d.area);
                    $('#floor-1').text(d.floor == null ? "" : d.floor);
                    $('#height-1').text(d.height == null ? "" : d.height);
                    $('#facing-1').text(d.facing == null ? "" : map_id_name(facing, d.facing));
                    $('#year-1').text(d.year == null ? "" : d.year);
                    $('#usage-1').text(d.usage == null ? "" : d.usage);
                    $('#has_loan-1').text(d.has_loan == null ? "" : (d.has_loan == 1 ? '是' : '否'));
                    $('#certificate-1').text(d.has_certificate == null ? "" : (d.has_certificate == 1 ? '是' : '否'));
                    break;
                  case 2:
                    category = "机动车抵押";
                    var features = '';
                    if (d.features != null){
                      var fa = d.features.split(',');
                      for (var i = 0; i < fa.length; i++){
                        features += map_id_name(vehicle_features, fa[i]) + '，';
                      }
                      features = features.substr(0, features.length - 1);
                    }
                    $('#brand-2').text(d.brand == null ? "" : d.brand);
                    $('#year-2').text(d.year == null ? "" : d.year);
                    $('#vin-2').text(d.vin == null ? "" : d.vin);
                    $('#made-2').text(d.made == null ? "" : d.made);
                    $('#violations-2').text(d.violations == null ? "" : d.violations);
                    $('#register-2').text(d.register == null ? "" : d.register);
                    $('#price-2').text(d.price == null ? "" : d.price.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#color-2').text(d.color == null ? "" : d.color);
                    $('#features-2').text(features);
                    $('#mileage-2').text(d.mileage == null ? "" : d.mileage.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#transfers-2').text(d.transfers == null ? 0 : d.transfers.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#oversea-2').text(d.oversea == null ? "" : (d.oversea == 1 ? '进口' : '国产'));
                    $('#status-2').text(d.vstatus == null ? "" : map_id_name(vehicle_status, d.vstatus));
                    $('#certificate-2').text(d.has_certificate == null ? "" : (d.has_certificate == 1 ? '是' : '否'));
                    break;
                  case 3:
                    category = "黄金抵押";
                    $('#name-3').text(d.name == null ? "" : d.name);
                    $('#weight-3').text(d.weight == null ? "" : d.weight.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#purity-3').text(d.purity == null ? "" : d.purity.toFixed(6));
                    $('#certificate-3').text(d.has_certificate == null ? "" : (d.has_certificate == 1 ? '是' : '否'));
                    break;
                  case 4:
                    category = "信用贷";
                    $('#organization-4').text(d.organization == null ? "" : d.organization);
                    $('#position-4').text(d.position == null ? "" : d.position);
                    $('#years-4').text(d.years == null ? "" : d.years);
                    $('#months-4').text(d.months == null ? "" : d.months);
                    $('#income-4').text(d.income == null ? "" : d.income);
                    break;
                  case 5:
                    category = "其他抵押";
                    $('#name-5').text(d.name == null ? "" : d.name);
                    $('#bought-5').text(d.bought == null ? "" : d.bought);
                    $('#price-5').text(d.price == null ? "" : d.price.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    $('#certificate-5').text(d.has_certificate == null ? "" : (d.has_certificate == 1 ? '是' : '否'));
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
                $('#purpose').html(d.purpose);
                $('#asset_description').html(d.description);
                $('#status').text(map_id_name(application_status, d.status));
                if (d.is_loaned == null){
                  $('#is_loaned-div').hide();
                }
                else {
                  $('#is_loaned-div').show();
                  $('#is_loaned').text(d.is_loaned == 1 ? '是' : '否');
                }
              }
          })
          .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            alert( "获取信息出现问题，请刷新页面。" + err);
          });
        }

      });
      $(window).trigger('hashchange');

    }
  };
})(jQuery, Drupal, this, this.document);