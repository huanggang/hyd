(function ($, Drupal, window, document, undefined) {


// To understand behaviors, see https://drupal.org/node/756722#behaviors
Drupal.behaviors.borrow_validate = {
  attach: function(context, settings) {

    $.getJSON(Drupal.settings.basePath + "api/account_status?type=1&id=" + uid,
      function(d) { 
        if (d.has_ssn != 1 || d.has_mobile != 1){
        	var msg = "";
        	if (d.has_ssn != 1 && d.has_mobile != 1){
        		msg = "请认证身份、绑定手机号后，再申请贷款";
        	}
        	else if (d.has_ssn != 1){
        		msg = "请认证身份后，再申请贷款";
        	}
        	else if (d.has_mobile != 1){
        		msg = "请绑定手机号后，再申请贷款";
        	}
        	if (confirm(msg)){
        		window.location.href = Drupal.settings.basePath + "account_management/security";
        	}
        }
    });
  }
};

})(jQuery, Drupal, this, this.document);
