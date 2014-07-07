(function ($, Drupal, window, document, undefined) {

// To understand behaviors, see https://drupal.org/node/756722#behaviors
Drupal.behaviors.manage_users = {
  attach: function(context, settings) {

    var max_pages = 50;
    var per_page = 2;
    var display_pages = 7;
    var max_items = max_pages * per_page;
    var pagination = '#users-list-pagination';

    var status_li = $('<li />').addClass('ui-list-status');
    var status_p = $('<p />').addClass('color-gray-text');
    var loading = status_li.clone().append(status_p.clone().append('加载中...'));
    var empty = status_li.clone().append(status_p.clone().append('没有记录'));

    var f = function formatMoney(money){
      if (typeof money === 'number'){
        return money.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      }
      return money;
    }

    var f_err = function(error, element) { 
      element.parent().append(error); // default function
    };

    var f_submit = function(form) { 
      $('#queryBtn').prop('disabled', true);

      var params = {};
      var t = $('#by').val();

      if(t == 'byphone'){
        params = {
          mobile: $('#query').val(),
          type: 2,
        }
      } else {
        params = {
          ssn: $('#query').val(),
          type: 3,
        }
      }

      $.get(
        Drupal.settings.basePath + 'api/manage_user', 
        params,
        function(d) {
          var setIdBtn = $('#queryBtn');
          if (d.result==1) {
            setIdBtn.prop('disabled', false);
            if (d.users.length > 0 && d.users[0].id > 0){
              window.open(Drupal.settings.basePath + "user/" + d.users[0].id);
            } else {
              var msg = $('<span class="ui-form-required pl5">该用户不存在</span>');  
              setIdBtn.after(msg.delay(1000).fadeOut());
            }
          } else {
            var msg = $('<span class="ui-form-required pl5">获取信息失败，请重试</span>');  
            setIdBtn.prop('disabled', false).after(msg.delay(1000).fadeOut());
          }
        }, 
        "json"
      )
      .fail(function(jqxhr, textStatus, error) {
        var err = textStatus + ", " + error;
        alert("加载基本信息出现问题，请重新刷新页面");
        $('#queryBtn').prop('enabled', true);
      });
    }

    $('#query').keypress(function(event) {
      if (event.which == 13) {
        $('#queryBtn').trigger('click');
      }
    });

    $('#by').change(function(event) {
      // validate the search form 
      $("#query-user-form").validate({
        errorPlacement: f_err,
        submitHandler: f_submit,
        rules: {},
        messages: {},
      });

      $('#query').rules('remove');

      var value = $(this).val();
      switch(value){
        case 'byssn': 
          $('#query').rules('add', { 
                        required: true,
                        isIdCardNo: true,
                        messages: {
                          isRealName:"请填写正确的二代身份证号码",
                          required:"身份证号码不能为空",
                        }
          })
          break;
        default: 
          $('#query').rules('add', { 
                        required: true,
                        isMobile: true,
                        messages: {
                          isMobile:"请填写正确的手机号码",
                          required:"手机号码不能为空",
                        }
          })
      }
    })
    .trigger('change'); 

  	var type = 1, page = 1, order = 2;
    $(pagination).pagination({ 
        items: 0,         // total items  
        itemsOnPage: per_page,  // items per page  
        hrefTextPrefix: '#type=' + type + '&order=' + order + "&page=", 
        displayedPages: display_pages, 
    }); 

    function getHashVal(hash){ 
      var data = {}; 
      if (hash.length > 1){ 
        data.hasHash = 1;
        hash = hash.slice(1); 
        var params = hash.split("&"); 
        for (var i = 0; i < params.length; i++){ 
          var pairs = params[i].split("="); 
          data[pairs[0]] = pairs[1];  
        }
      }
      return data;
    }


    $(window).bind('hashchange', function(){
      var hash = window.location.hash;
      var data = getHashVal(hash);
      
      if (hash.length > 0) { 
        type = Number(data['type']);
        page = Number(data['page']);
        order = Number(data['order']);
      }

      if (typeof type !== 'number'){
        type = 1;
      }
      if (typeof page !== 'number'){
        page = 1;
      }
      if (typeof order !== 'number'){
        order = 2;
      }

      if (order > 2 || order < 1){
        order = 1;
      }
      if (type > 3 || type < 1){
        type = 1;
      }

      var pagesCount = $(pagination).pagination('getPagesCount');
      if (page > 1){
        if (pagesCount > 0){
          if (page > pagesCount) {
            page = pagesCount;
          } 
        } else{
          page = 1;
        }
      } 

      $(pagination).pagination('updatePrefix', '#type=' + type + '&order=' + order + "&page=");
      loadUsers();
    });

    function titleSort(target, theType){
      $('#' + target).click(function(event) {
        type = theType, order = order == 1 ? 2: 1;
        window.location.hash = '#type=' + type + '&order=' + order + "&page=" 
          + $(pagination).pagination('getCurrentPage');
      });
    }

    titleSort('registerSort', 1);
    titleSort('totalMoneySort', 2);
    titleSort('loginSort', 3);

    function loadUsers(){
      var apiUrl = Drupal.settings.basePath + "api/manage_users?type=" + type 
                    + "&page=" + page + "&order=" + order; 

      var list = $('#transactions');
      var header = list.children().get(0);
      $(header).nextAll().remove();
      list.append(loading);

      $.getJSON(apiUrl,
        function(d) { 
          if (d.result == 0){
            alert( "获取信息出现问题，请刷新页面。");
          }
          else {
            $(header).nextAll().remove();

            if (page == 1){
              var total = d.total;
              $(pagination).pagination('updateItems', total < max_items ? total : max_items); 
              $('#users-total').html(total).parent().show();
            }

            $(pagination).pagination('selectPage', page);
            
            var li = $('<li/>').addClass('ui-list-item text fn-clear');
            var span = $('<span />').addClass('ui-list-field fn-left');

            if (d.users.length > 0){
              for (var i = 0; i <= d.users.length - 1; i++) {
                var u = d.users[i];
                var row = li.clone()
                          .append(span.clone().addClass('w50 ph5 type').append(
                            '<a title="' + u.nick + '" target="_blank" href="' + Drupal.settings.basePath 
                            + 'user/' + u.id + '" >' + u.name + '</a>'))
                          .append(span.clone().addClass('w85 ph5 credit text-right').append(f(u.amount_total)))
                          .append(span.clone().addClass('w85 ph5 debit text-right').append(f(u.amount_available)))
                          .append(span.clone().addClass('w85 ph5 balance text-right').append(f(u.amount_owned)))
                          .append(span.clone().addClass('w85 ph5 text-right').append(f(u.amount_frozen)))
                          .append(span.clone().addClass('w135 ph5 text-right').append(u.registered))
                          .append(span.clone().addClass('w135 ph5 text-right').append(u.logined));

                if (i % 2 == 0){
                  row.addClass('dark');
                }
                row.appendTo('#transactions');
              }
            }else {
              // no results
              $(list).append(empty);
            };
        	} 
        })
      .fail(function() {
        alert( "加载基本信息出现问题，请重新刷新页面" );
      });
    }


    $(window).trigger('hashchange');
  }
};


})(jQuery, Drupal, this, this.document);