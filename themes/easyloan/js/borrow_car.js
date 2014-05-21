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
					brand: "required",
					year: "required",
					vin: "required",
					mileage: "required",
					amount: "required",
					duration: "required",
				},
				messages: {
					brand: {
						required: "请填写机动车品牌",
					},
					year: {
						required: "请填写生产年份",
					},
					vin: {
						required: "请填写车辆识别代码",
					},
					mileage: {
						required: "请填写车辆行驶里程",
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