/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */
(function($, Drupal, window, document, undefined) {
	Drupal.behaviors.vali = {
		attach: function(context, settings) {

			$.validator.addMethod("isNickname", function(value, element) {
				var length = value.length;
				var nickname = /^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9]){2,}$/;
				return nickname.exec(value);
			}, "请正确填写您的昵称");

			$.validator.addMethod("isMobile", function(value, element) {
				var length = value.length;
				var mobile = /^1[3458]\d{9}$/;
				return length == 11 && mobile.exec(value);
			}, "请正确填写您的手机号码");

			var validateForm = function(){
				$("#form-easyloan-wizard").validate({
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
								url: "../namexists",
								type: "post",
								data: {
									name: function() {
										return $("#edit-name").val();
									}
								}
							},
						},
						phone: {
							required: true,
							isMobile: true,
							remote: {
								url: "../phonexists",
								type: "post",
								data: {
									phone: function() {
										return $("#edit-phone").val();
									}
								}
							},
						},
						"pass[pass1]": {
							required: true,
							minlength: 6
						},
						"pass[pass2]": {
							required: true,
							minlength: 6,
							equalTo: "#edit-pass-pass1"
						},
						captcha_response: {
							required: true,
							minlength: 4,
							maxlength: 4,
						},
						agree: "required"
					},
					messages: {
						name: {
							required: "2-20位字符，可包含中文，英文，数字和字符\"-\"与\"_\"。注册完成后不可修改",
							minlength: "注册名需包含至少两个字符",
							remote: "该昵称已经存在",
							isNickname: "昵称只能由中文、英文字母、数字、下划线(_)和连词符(-)组成"
						},
						phone: {
							required: "请填入11位手机号",
							minlength: "手机号太短",
							maxlength: "手机号太长",
							isMobile: "请输入正确的手机号",
							remote: "该号码已经存在",
						},
						"pass[pass1]": {
							required: "密码须为6-16位英文字母、数字和符号(不包括空格)",
							minlength: "密码至少为6个字符",
						},
						"pass[pass2]": {
							required: "请重复输入密码",
							minlength: "密码至少为6个字符",
							equalTo: "请输入相同的密码",
						},
						captcha_response: {
							required: "请输入4位验证码",
							minlength: "请输入4位验证码",
							maxlength: "请输入4位验证码",
						},
						agree: "请同意我们的条款",
					}
				});
			};

		    $("#reg").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "fade",
                autoFocus: true,
                enableCancelButton: false, 
                //enableFinishButton: false, 
                showFinishButtonAlways: false,
                
                /* Labels */
			    labels: {
			        cancel: "取消",
			        current: "当前步骤:",
			        pagination: "分页",
			        finish: "验证",
			        next:'立即注册',
			        previous: "返回",
			        loading: "加载中 ..."
			    },
			    /* Events */
			    onStepChanging: function (event, currentIndex, newIndex) { 
			    	$("#form-easyloan-wizard").validate().settings.ignore = ":disabled,:hidden"; 
			    	return $("#form-easyloan-wizard").validate({
							rules: {
								name: {
									required: true,
									},
								},
							messages: {
								name: {
									required: "2-20位字符，可包含中文，英文，数字和字符\"-\"与\"_\"。注册完成后不可修改",
									},
								}
					    	});
                    // return $("#form-easyloan-wizard").valid(); 
			    },
			    onStepChanged: function (event, currentIndex, priorIndex) { 
			    	if (currentIndex == 1){
			    		// enable finished button
			    		$('div.actions li').last().show();
			    	} else {
			    		$('div.actions li').last().hide();
			    	}
			    }, 
			    onCanceled: function (event) { },
			    onFinishing: function (event, currentIndex) { return true; }, 
			    onFinished: function (event, currentIndex) { $("#form-easyloan-wizard").submit();},
                /*
                // Disables the finish button (required if pagination is enabled)
			    enableFinishButton: false, 
			    // Disables the next and previous buttons (optional)
			    enablePagination: false, 
			    // Enables all steps from the begining
			    enableAllSteps: true, */
			    // Removes the number from the title
			    titleTemplate: "#title#" 
            });
			$('div.actions a').addClass('ui-button ui-button-blue ui-button-mid form-submit');
			$('div.actions ul').addClass('ui-form-item');
			$('div.actions li').last().hide();
			
		}
	};
})(jQuery, Drupal, this, this.document);