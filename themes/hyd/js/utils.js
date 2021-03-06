function map_id_name(jsons, id){
  for (var i = 0; i < jsons.length; i++){
    var j = jsons[i];
    if (j.id == id) {
      return j.name;
    }
  }
  return '';
};

Date.prototype.format = function (fmt){
  var o = {
    "M+" : this.getMonth()+1,                 //月份   
    "d+" : this.getDate(),                    //日   
    "h+" : this.getHours(),                   //小时   
    "m+" : this.getMinutes(),                 //分   
    "s+" : this.getSeconds(),                 //秒   
    "q+" : Math.floor((this.getMonth()+3)/3), //季度   
    "S"  : this.getMilliseconds()             //毫秒   
  };
  if(/(y+)/.test(fmt))
    fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
  for(var k in o)
    if(new RegExp("("+ k +")").test(fmt))
      fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
  return fmt;
};

(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.utils = {

    showTab: function (tabname){ // to use this function, you must include tab.js
      if (!$(".ui-tab-item[data-name=" + tabname + "]").hasClass("ui-tab-item-current")){
        $(".ui-tab-item[data-name=" + tabname + "]").addClass('ui-tab-item-current');
        $('.ui-tab-item').not(".ui-tab-item[data-name=" + tabname + "]").removeClass('ui-tab-item-current');

        $('div.ui-tab-content').removeClass('ui-tab-content-current').filter(function(index){
          return tabname == $(this).attr('data-name');
        }).addClass('ui-tab-content-current');
      }
    }
  };
})(jQuery, Drupal, this, this.document);