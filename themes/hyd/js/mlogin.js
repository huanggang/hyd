(function($, Drupal, window, document, undefined) {
	Drupal.behaviors.login = {
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
					},
					"pass": {
						required: true,
						minlength: 6
					},
					captcha_response: {
						required: true,
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
					}, 
				}, 
			}; 

			$("#user-login").validate(validateConfig);
		}
	};
})(jQuery, Drupal, this, this.document);