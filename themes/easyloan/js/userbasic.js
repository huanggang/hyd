(function ($, Drupal, window, document, undefined) {
/// assing options to a select input
///
///  json   - the json string
///  target - id of the select input 
///  value  - the default value
function setSelectOptions(json, target, value){
  var len = json.length;
  $('#' + target).empty().append('<option value="">请选择</option>');
  for(var j = 0; j < len; j++) {
      var option = $('<option/>');
      option.attr('value', json[j].id); // fixed typo
      if (value != undefined && value == json[j].id){
        option.attr('selected', 'selected');
      }
      option.append(json[j].name);
      $('#' + target).append(option);
  }
}

Drupal.behaviors.userbasic = {
  attach: function(context, settings) {

      $.cachedScript = function( url, options ) {
        // Allow user to set any option except for dataType, cache, and url
        options = $.extend( options || {}, {
          dataType: "script",
          cache: false,
          url: url,
        });
        return $.ajax( options );
      };

      var cityCache = {}; // cache the city lists so it won't send another request 

      /// assing options to the 'city' select input
      ///
      ///  provinceid - the id of the province
      ///  value      - the default city value
      function setCities(provinceid, value){
        var url = js_path + 'city/cities_' + provinceid + '.js';
        $.cachedScript(url).done(function(data, textStatus) {
          var cities = eval('cities_' + provinceid);
          cityCache[provinceid] = cities;
          setSelectOptions(cities, 'city', value);
        });
      }

      $('#province').change(function(event) {
        var provinceid = $("#province option:selected").val();
        if (provinceid){
            if (cityCache.hasOwnProperty(provinceid)){
              setSelectOptions(cityCache[provinceid], 'city');
            } else {
              setCities(provinceid);
            }
          }
      });

      var validateForm = function(){
        $("#userInfoForm").validate({
          errorPlacement: function(error, element) {
            element.parent().append(error); // default function
          },
          rules: {/*
            education: {
              required: true,
              number:true,
            },
            province: {
              required: true,
              number:true,
            },
            city: {
              required: true,
              number:true,
            },*/
            address:{
              required: true,
            }
          },
          messages: {/*
            education: {
              required: "受教育程度不能为空",
              number: "请选择受教育程度",
            },
            province: {
              required: "省份不能为空",
              number: "请选择省份",
            },
            city: {
              required: "城市不能为空",
              number: "请选择城市",
            },*/
            address: {
              required: "居住地不能为空",
            },
          }
        });
      };

    $.getJSON(
      "http://localhost/d71/api/basic",
      function(d) {
        $("span#nickname").html(d.nick);
        $("span#name").html(d.name);
        $("span#ssn").html(d.ssn);
        $("span#mobile").html(d.mobile);
        $("span#email").html(d.email);
        $("span#gender").html(d.gender==1?"男":"女");
        $("span#dob").html(d.dob);
        $("#address").val(d.address);

        setSelectOptions(educations, 'education', d.education);
        setSelectOptions(marital_status, 'marital', d.marital);
        setSelectOptions(provinces, 'province', d.province);
        setCities(d.province, d.city);
      })
    .fail(function() {
      alert( "网络出现问题，请重新刷新页面" );
    });

    var a = $("#userInfoForm");
    var c = a.clone();
    c.find("input,select,a.photo").each(function () {
        if ("submit" == this.type || "hidden" == this.type) $(this).remove();
        else if ("A" == this.tagName.toUpperCase() && "modUserPhoto" == this.id) $(this).attr("href", "#");
        else {
            var a = $(this).val();
            $(this).after(a).remove();
        }
    }),

    a.hide().after(c), 
    
    $("#modiForm").click(function () {
        "修改信息" != $(this).text() ? (c.show(), a.hide(), $(this).html("修改信息")) : (c.hide(), a.show(), $(this).html("取消修改"))
    });

/*
    new d({
        trigger: "#modUserPhoto",
        width: "550px",
        height: /msie 6/i.test(navigator.userAgent) ? "550px" : "220px"
    }).before("show", function () {
        this.set("content", this.activeTrigger.attr("href"))
    }).after("hide", function () {}), e.validate({
        validateData: {
            submitHandler: function (a) {
                e.ajaxSubmit(b(a), {
                    msgafter: "#" + $(a).find("input[type='submit']")[0].id,
                    success: function (a) {
                        this.msg(a.message, "warn"), 0 === a.status && setTimeout(function () {
                            location.reload()
                        }, 1500)
                    }
                })
            }
        }
    })*/
  }
};

})(jQuery, Drupal, this, this.document);
