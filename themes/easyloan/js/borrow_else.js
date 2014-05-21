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
					name: "required",
					amount: "required",
					duration: "required",
				},
				messages: {
					name: {
						required: "请填写物品名称",
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