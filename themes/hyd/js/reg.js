(function($, Drupal, window, document, undefined) {
	Drupal.behaviors.reg = {
		attach: function(context, settings) {
			var validateConfig = {
				errorPlacement: function(error, element) {
					element.parent().append(error); // default function
				},
				rules: {
					name: {
						required: true,
						minlength: 2,
						maxlength: 20,
						isNickname: true,
						remote: {
							url: "../exists",
							type: "post",
							data: {
								name: function() {
									return $("#edit-name").val();
								}
							}
						},
					},
					"pass[pass1]": {
						required: true,
						minlength: 6,
						maxlength: 16
					},
					"pass[pass2]": {
						required: true,
						equalTo: "#edit-pass-pass1"
					},
					captcha_response: {
						required: true,
						minlength: 4,
						maxlength: 4,
						remote: {
							url: "../captcha_check", 
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
					agree: "required",
				},
				messages: {
					name: {
						required: "2-20位字符，可包含中文，英文，数字和字符\"-\"与\"_\"。注册完成后不可修改",
						minlength: "注册名需包含至少两个字符",
						maxlength: "注册名不能超过20个字符",
						remote: "该昵称已经存在",
						isNickname: "昵称只能由中文、英文字母、数字、下划线(_)和连词符(-)组成"
					},
					"pass[pass1]": {
						required: "密码须为6-16位英文字母、数字和符号(不包括空格)",
						minlength: "密码至少为6个字符",
						maxlength: "密码不要超过16个字符"
					},
					"pass[pass2]": {
						required: "请重复输入密码",
						equalTo: "请输入相同的密码",
					},
					captcha_response: {
						required: "请输入4位验证码",
						minlength: "请输入4位验证码",
						maxlength: "请输入4位验证码",
						remote: "验证码错误",
					},
					agree: "请同意条款",
				}
			};

			$("#user-register-form").validate(validateConfig);

	      	$('div.captcha').append('&nbsp;<span id="refresh"><img id="refreshCode" align="top" src="' 
	      		+ Drupal.settings.basePath   
	      		+ 'sites/all/themes/hyd/images/refresh.png" alt="刷新验证码" /></span>');
		}
	};
})(jQuery, Drupal, this, this.document);