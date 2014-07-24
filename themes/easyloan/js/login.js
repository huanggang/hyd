(function($, Drupal, window, document, undefined) {
	Drupal.behaviors.login = {
		attach: function(context, settings) {
			var validateConfig = {
				errorPlacement: function(error, element) {
					element.parent().append(error); // default function
				},
/*
				submitHandler: function(form) {
			        $.post(
			          Drupal.settings.basePath, 
			          {
			            name : $('#edit-user-login').val(),
			            pass : $('#pass').val(),
			            captcha_sid : function() {
							return $('[name="captcha_sid"]').val();
						},
			            captcha_token : function() { 
							return $('[name="captcha_token"]').val();
						}, 
			            captcha_response : function() { 
							return $("#edit-captcha-response").val();
						}, 
			            submit : '登录', 
			            form_build_id : $('[name="form_build_id"]').val(), 
			            form_id : 'user_login', 
			          },
			          function(d) {
			            alert(d);
			          }, 
			          "json"
			        ) 
			        .fail(function( jqxhr, textStatus, error ) {
			          var err = textStatus + ", " + error;
			          alert( "加载基本信息出现问题，请重新刷新页面" );
			        });

			      },
			      */
				rules: {
					name: {
						required: true,
						minlength: 2,
						maxlength: 20,
						isNickname: true,
					},
					"pass": {
						required: true,
						minlength: 6
					},
					captcha_response: {
						required: true,
						minlength: 4,
						maxlength: 4,
						remote: {
							url: Drupal.settings.basePath + "captcha_check", 
							type: "post",
							data: { 
								token: function() { 
									return $('[name="captcha_token"]').val();
								},
								sid: function() { 
									return $('[name="captcha_sid"]').val();
								},
								captcha: function() { 
									return $("#edit-captcha-response").val();
								}, 
							} 
						}, 
					}, 
				}, 
				messages: { 
					name: { 
						required: "请输入您的昵称",
						minlength: "请输入正确的昵称",
						maxlength: "请输入正确的昵称",
						isNickname: "请输入正确的昵称"
					}, 
					"pass": { 
						required: "请输入您的密码",
						minlength: "密码至少为6个字符",
					}, 
					captcha_response: { 
						required: "请输入验证码", 
						minlength: "请输入4位验证码", 
						maxlength: "请输入4位验证码", 
						remote: "验证码错误", 
					}, 
				}, 
			}; 

			$("#user-login").validate(validateConfig);

	      	$('div.captcha').append('&nbsp;<span id="refresh"><img id="refreshCode" align="top" src="' 
	      		+ Drupal.settings.basePath   
	      		+ 'sites/all/themes/easyloan/images/refresh.png" alt="刷新验证码" /></span>');

		}
	};
})(jQuery, Drupal, this, this.document);