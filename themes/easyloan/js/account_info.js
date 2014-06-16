(function ($, Drupal, window, document, undefined) {


// To understand behaviors, see https://drupal.org/node/756722#behaviors
Drupal.behaviors.account_info = {
  attach: function(context, settings) {
	var apiUrl;
  	if (is_my_page){
  		apiUrl = Drupal.settings.basePath + "api/account_status?type=1&id=" + uid;	
  	} else {
  		apiUrl = Drupal.settings.basePath + "api/manage_user?type=1&id=4";// + uid;	
  	}
  	
	$.getJSON(apiUrl,
      function(d) { 
      	if (is_my_page){
      		if (d.has_ssn === 1){
	      		$('#icon-ssn').addClass('light').children().addClass('light').attr('title', "实名认证，已设置");
	      	}
	      	if (d.has_mobile === 1){
	      		$('#icon-mobile').addClass('light').children().addClass('light').attr('title', "绑定手机，已绑定");
	      	}
	      	if (d.has_cash_password === 1){
	      		$('#icon-cash-pass').addClass('light').children().addClass('light').attr('title', "提现密码，已设置");
	      	}
	      	if (d.has_email === 1){
	      		$('#icon-email').addClass('light').children().addClass('light').attr('title', "绑定邮箱，已绑定");
	      	}

	      	$("#amount_total").html(d.amount_total);
	      	$("#amount_available").html(d.amount_available);
	      	$("#amount_frozen").html(d.amount_frozen);
	      	$("#amount_frozen_0").html(d.amount_frozen);
	      	$("#amount_owned").html(d.amount_owned);
	      	$("#amount_owned_0").html(d.amount_owned);
	      	$("#amount_fine").html(d.amount_fine);
	      	$("#amount_fine_0").html(d.amount_fine);
	      	$("#amount_investment").html(d.amount_investment);
	      	$("#amount_loaned").html(d.amount_loaned);
	      	$("#amount_available").html(d.amount_available);
	      	$("#amount_interest").html(d.amount_interest);

	      	$("#i_interest").html(d.investment.interest);
	      	$("#i_fine").html(d.investment.fine);
	      	$("#i_rate").html(d.investment.rate);

	      	$("#w_amount").html(d.loan.w_amount);
	      	$("#w_interest").html(d.loan.w_interest);
	      	$("#w_owned").html(d.loan.w_owned);
	      	$("#w_fine").html(d.loan.w_fine);

	      	$("#l_interest").html(d.loan.interest);
	      	$("#l_fine").html(d.loan.fine);
	      	$("#l_rate").html(d.loan.rate);
      	} else {
      		var user = d.users[0];
      		if (user.ssn_status === 1){
	      		$('#icon-ssn').addClass('light').children().addClass('light').attr('title', user.name + ": " + user.ssn);
	      	}
	      	if (user.mobile_status === 1){
	      		$('#icon-mobile').addClass('light').children().addClass('light').attr('title', user.mobile);
	      	}
	      	if (user.email_status === 1){
	      		$('#icon-email').addClass('light').children().addClass('light').attr('title', user.email);
	      	}

	      	$("#amount_total").html(user.amount_total);
	      	$("#amount_available").html(user.amount_available);
	      	$("#amount_available_0").html(user.amount_available);
	      	$("#amount_frozen").html(user.amount_frozen);
	      	$("#amount_frozen_0").html(user.amount_frozen);
	      	$("#amount_owned").html(user.amount_owned);
	      	$("#amount_owned_0").html(user.amount_owned);
	      	$("#amount_fine").html(user.amount_fine);
	      	$("#amount_fine_0").html(user.amount_fine);
	      	$("#amount_investment").html(user.amount_investment);
	      	$("#amount_loaned").html(user.amount_loaned);
	      	$("#amount_available").html(user.amount_available);
	      	$("#amount_interest").html(user.amount_interest);

	      	$("#i_interest").html(user.inv_interest);
	      	$("#i_fine").html(user.inv_fine);
	      	$("#i_rate").html(user.inv_rate);

	      	$("#w_amount").html(user.ln_w_amount);
	      	$("#w_interest").html(user.ln_w_interest);

	      	$("#l_interest").html(user.ln_interest);
	      	$("#l_fine").html(user.ln_fine);
	      	$("#l_rate").html(user.ln_rate);

      		console.log(user.name);
	      	console.log(user.gender);
	      	console.log(user.dob);
	      	console.log(user.education);
	      	console.log(user.marital);
	      	console.log(user.province);
	      	console.log(user.city);
	      	console.log(user.address);
      	}
      })
    .done(function(){ 
    })
    .fail(function() {
      alert( "加载基本信息出现问题，请重新刷新页面" );
    });

  }
};

})(jQuery, Drupal, this, this.document);
