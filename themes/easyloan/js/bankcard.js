(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.bankcard = {
    attach: function(context, settings){

      $.getJSON( Drupal.settings.basePath + "api/banks", 
        function(d) {
          var html = '';
          if (d.total > 0) {
            for (var i = 0; i < d.total; i++) {
              var card = d.numbers[i];
              var bankId = card.bank;
              var number = card.number;
              html += '<li><img alt="" title="" src="' + image_path + 'bank_' + bankId + '.jpg"><div>' + number + '</div><div class="card"><a class="link mod openLink" tabindex="-1" data-card="' + number + '">修改</a><a class="link del" data-card="' + number + '">删除</a></div></li>';
            }
          }
          $('#banklis ul').prepend(html);
          
          $('.mod').click(function(event){

          });
          $('.del').click(function(event){
            if (confirm("确定要删除该银行卡吗？")) {

            }

          });
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "网络出现问题，请重新刷新页面。");
      });

    }
  };
})(jQuery, Drupal, this, this.document);