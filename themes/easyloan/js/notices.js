(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.notices = {
    attach: function(context, settings){

      $('input[type=checkbox]').removeAttr('checked');
      $('input[type=checkbox]').click(function(event){
        if ($(this).attr('checked') == 'checked'){
          $(this).removeAttr('checked');
        }
        else{
          $(this).attr('checked', 'checked');
        }
      });

      $('#subbt').click(function(event){
        var repayment_7 = getNotice('mail_7', 'sm_7');
        var repayment_3 = getNotice('mail_3', 'sm_3');
        var overdue = getNotice('mail_1', 'sm_1');
        var investment = getNotice('mail_inv', 'sm_inv');
        var withdraw = getNotice('mail_wd', 'sm_wd');

        $.getJSON(Drupal.settings.basePath + "api/m_notices?type=2&repayment_7=" + repayment_7 + "&repayment_3=" + repayment_3 + "&overdue=" + overdue + "&investment=" + investment + "&withdraw=" + withdraw,
          function(d) {
            if (d.result != null && d.result == 0) {
              alert("信息设置失败，请刷新页面");
            }
            else{
              alert("设置成功");
            }
          }, "json"
        )
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "后台验证出现问题，请刷新页面");
        });

      });

      $.getJSON(Drupal.settings.basePath + "api/m_notices",
        function(d) {
          if (d.result != null && d.result == 0) {
            alert("信息获取失败，请刷新页面");
          }
          else{
            setNotice(d.repayment_7, 'mail_7', 'sm_7');
            setNotice(d.repayment_3, 'mail_3', 'sm_3');
            setNotice(d.overdue, 'mail_1', 'sm_1');
            setNotice(d.investment, 'mail_inv', 'sm_inv');
            setNotice(d.withdraw, 'mail_wd', 'sm_wd');
          }
        }, "json"
      )
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "后台验证出现问题，请刷新页面");
      });


      function setNotice(val, mail_id, sm_id){
        if (val == 1 || val == 3){
          $('#'+mail_id).click();
        }
        if (val == 2 || val == 3){
          $('#'+sm_id).click();
        }
      }

      function getNotice(mail_id, sm_id){
        var val = 0;
        if ($('#'+mail_id).attr('checked') != null){
          val += 1;
        }
        if ($('#'+sm_id).attr('checked') != null){
          val += 2;
        }
        return val;
      }

    }
  };
})(jQuery, Drupal, this, this.document);