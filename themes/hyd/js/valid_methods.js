(function ($, Drupal, window, document, undefined) {

Drupal.behaviors.valid_methods = {
  attach: function(context, settings) {

	function isDate(a, b, c) {
	      if (isNaN(a) || isNaN(b) || isNaN(c)) return !1;
	      if (b > 12 || 1 > b) return !1;
	      if (1 > c || c > 31) return !1;
	      if ((4 == b || 6 == b || 9 == b || 11 == b) && c > 30) return !1;
	      if (2 == b) {
	          if (c > 29) return !1;
	          if ((0 === a % 100 && 0 !== a % 400 || 0 !== a % 4) && c > 28) return !1
	      }
	      return !0
	    }

    $.validator.addMethod("isRealName", function (value, element) {
        return this.optional(element) || /^[\u4E00-\u9FA5]+$/.test(value);
    }, "包含非法字符");

    $.validator.addMethod("isIdCardNo", function (value, element) {
      if (18 != value.length) return this.optional(element) || !1;
      var b;
      if (b = /^\d{17}(\d|x|X)$/, !b.exec(value)) return this.optional(element) || !1;
      if (!isDate(value.substring(6, 10), value.substring(10, 12), value.substring(12, 14))) return this.optional(element) || !1;

      for (var c = ["1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2"], 
              d = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1], 
              f = 0, g = 0; g < value.length - 1; g++) f += value.substring(g, g + 1) * d[g];
      return this.optional(element) || (f %= 11, value.substring(value.length - 1, value.length).toUpperCase() != c[f] ? !1 : !0)

    }, "请输入正确的二代身份证号码");
    
	/*
	    $.validator.addMethod("isEmail", function (value, element) {
	        return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
	    }, "包含非法字符");
	*/

    $.validator.addMethod("isPassWord", function (value, element) {
        return /^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{1,}$/.test(value);
    }, "包含非法字符");


    $.validator.addMethod("noSpace", function(value, element) { 
        return value.indexOf(" ") < 0 && value != ""; 
    }, "不允许输入空格");

    $.validator.addMethod("isNickname", function(value, element) {
      var length = value.length;
      var nickname = /^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9_-]){2,}$/;
      return nickname.exec(value);
    }, "请正确填写您的昵称");

    $.validator.addMethod("isMobile", function(value, element) {
      var length = value.length;
      var mobile = /^1[3458]\d{9}$/;
      return this.optional(element) || length == 11 && mobile.exec(value);
    }, "请正确填写您的手机号码");
  }
};

})(jQuery, Drupal, this, this.document);
