/**
 * @file
 * A JavaScript file for the theme.
 *
 */
(function($, Drupal, window, document, undefined) {
	Drupal.behaviors.vali = {
		attach: function(context, settings) {
			$("#borrowForm").validate({
				errorPlacement: function(error, element) {
					element.parent().append(error); // default function
				}, 
				rules: { 
					address: "required",
					area: "required",
					amount: "required",
					duration: "required",
				},
				messages: {
					address: {
						required: "请填写房产坐落",
					},
					area: {
						required: "请填写房产面积",
					},
					amount: {
						required: "请填写借款金额",
					},
					duration: {
						required: "请填写借款期限",
					},
				}
			});
		}
	};
})(jQuery, Drupal, this, this.document);