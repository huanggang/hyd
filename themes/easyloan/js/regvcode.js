/**
 * @file
 * A JavaScript file for the theme.
 *
 */
(function($, Drupal, window, document, undefined) {
	Drupal.behaviors.vali = {
		attach: function(context, settings) {
			$("#form-easyloan-wizard").validate({
				rules: {
					vcode: {
						required: true,
						minlength: 4,
						maxlength: 4,
					},
				},
				messages: {
					vcode: {
						required: "请输入4位验证码",
						minlength: "请输入4位验证码",
						maxlength: "请输入4位验证码",
					},
				}
			});

			$("#edit-prev").prop('type', 'button').bind('click', function(){
				// $("#edit-prev").submit();
			});
		}
	};
})(jQuery, Drupal, this, this.document);