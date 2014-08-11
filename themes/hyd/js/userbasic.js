(function ($, Drupal, window, document, undefined) {
/// assing options to a select input
///
///  json   - the json string
///  target - id of the select input 
///  value  - the default value
function setSelectOptions(json, target, value){
  var len = json.length;
  $('#' + target).empty().append('<option value="">-</option>');
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

      var a = $("#userInfoForm"); // the user info form
      var c = {};                 // this is gonna be a clone of a
    
      $.cachedScript = function( url, options ) {
        // Allow user to set any option except for dataType, cache, and url
        options = $.extend( options || {}, {
          dataType: "script",
          cache: false,
          url: url,
          async: false,
        });
        return $.ajax( options );
      };

      var cityCache = {}; // cache the city lists so it won't send another request 

      /// assing options to the 'city' select input
      ///
      ///  provinceid - the id of the province
      ///  value      - the default city value
      function setCities(provinceid, value, async){ 
        if (provinceid == null){
          return;
        }
        if (async == undefined) { async = true; } 
        var url = js_path + 'city/cities_' + provinceid + '.js'; 

        $.cachedScript(url, {async:async}).done(function(data, textStatus) { 
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

    $.getJSON( Drupal.settings.basePath + "api/basic", 
      function(d) { 
        $("span#nickname").html(d.nick); 

        if (d.ssn_status == 1){
          $("span#name").html(d.name).parent().find('span.pass').addClass('icon-status').end()
                                              .find('span.noauth').removeClass('icon-status');
          $("span#ssn").html(d.ssn).parent().find('span.pass').addClass('icon-status').end()
                                              .find('span.noauth').removeClass('icon-status');
        }
        if (d.mobile_status == 1){
          $("span#mobile").html(d.mobile).parent().find('span.pass').addClass('icon-status').end()
                                              .find('span.noauth').removeClass('icon-status');
        }
        if (d.email_status == 1){
          $("span#email").html(d.email).parent().find('span.pass').addClass('icon-status').end()
                                              .find('span.noauth').removeClass('icon-status');
        }

        if (d.gender){
          $("span#gender").html(d.gender==1?"男":"女");
        }
        $("span#dob").html(d.dob);
        $("#address").val(d.address);

        setSelectOptions(educations, 'education', d.education);
        setSelectOptions(marital_status, 'marital', d.marital);
        setSelectOptions(provinces, 'province', d.province);
        // use 'false' to make sure that all cities have been loaded before 'done()' 
        setCities(d.province, d.city, false); 
      })
    .done(function(){ 
          if ($('form').size() < 3){ 
            // 3 is for one image upload form, and two info forms
            // to prevent from adding much more forms caused by ctools modal's bug.

            // we have to clone the form here, must before the cities are loaded 
            c = a.clone();

            c.find("input,select").each(function () {
              if ("submit" == this.type || "hidden" == this.type) $(this).remove();
              else if ("text" == this.type) {var a = $(this).val(); $(this).after(a).remove();}
              else {var a = $(this).find("option:selected").text(); $(this).after(a).remove();}
            });
            a.hide().after(c);
        }
    })
    .fail(function() {
      alert( "加载基本信息出现问题，请重新刷新页面" );
    });
   
    $("#modiForm").click(function () {
        var imglink = $('.user-picture a');
        "修改信息" != $(this).text() ? 
            (c.show(), a.hide(), $(this).html("修改信息"), imglink.prop("href", imglink.prop("data")))
          : (c.hide(), a.show(), $(this).html("取消修改"),  imglink.prop('data', imglink.prop("href")), imglink.prop("href", '#'))
    });


    $('#savebt').click(function(event) {
        $('#savebt').prop('disabled', true).removeClass('.ui-button-green:hover');
        $.post(Drupal.settings.basePath + "api/basic", 
              {
                education: $('#education').val(),
                marital: $('#marital').val(),
                province: $('#province').val(),
                city: $('#city').val(),
                address: $('#address').val(),
              },
              function(d) {
                if (d.result==1) {
                  var msg = $('<span class="ui-form-required pl5">成功保存用户消息</span>');
                  $('#savebt').after(msg.show().delay(1000).fadeOut().queue(function() { $(this).remove(); location.reload();}));
                  $('#savebt').prop('enabled', true);
                }
            }, "json") 
        .fail(function() {
          alert( "保存信息出现问题，请重新刷新页面" );
          $('#savebt').prop('enabled', true);
        });
    });

    if ($('.user-picture a').size() == 0){
      // to fix the bug that drupal has no view profile 
      $('.user-picture img').wrap('<a href="' + Drupal.settings.basePath + 'user"><a/>');
    }

    $('.user-picture a').click(function(){
        if ($(this).prop('href').indexOf('#') !== -1){
          $("#uploadPhoto").dialog({
            modal: true,
            title: '更换用户照片',
            width: 585,
            height: 230,
            minHeight: 220,
            autoResize:false,
          }).css('overflow', 'hidden');
        }
    }); 

    $('#edit-picture-upload').change(function(e){
      $('#filevalue').text($(this).val());
    });

    $('#buttonClose').click(function(event) {
      /* Act on the event */
      $("#uploadPhoto").dialog("close");
      $('#filevalue').text('');
    });
    $('#edit-submit').click(function(event) {
      var filename = $('#edit-picture-upload').val();
      
      if (filename == ''){
        alert('请选择图片');
      } else {
        var ext = filename.split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            alert('请上传JPG、GIF或PNG格式的图片!');
            return;
        }
        $("#easyloan_changeimg_form").submit();
      }
    });
  }
};

})(jQuery, Drupal, this, this.document);
