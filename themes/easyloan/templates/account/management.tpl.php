<?php

drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/itemlist.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/jquery.validate.min.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/valid_methods.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/jquery.simplePagination.js');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/manage_users.js');

global $base_url;
?>
<div class="p20bs color-white-bg">
  <div class="fn-clear" id="query-form">
    <div class="fn-left">
      <form id="query-user-form" class="ui-form" method="GET">
        <div class="ui-form-item"> 
          <label class="ui-label">查询条件</label>
          <select class="fn-left mr10" name="by" id="by">
            <option value="byphone" selected="selected">手机</option>
            <option value="byssn">身份证</option>
          </select>
          <input id="query" name="query" class="w120 mr10"/>
          <input type="submit" class="ui-button ui-button-small ui-button-blue" id="queryBtn" value="查看用户" />
        </div>
      </form>
    </div>
  </div>
  <hr class="mt20">
  <div class="mt10 fn-clear">
    <ul class="ui-list ui-list-s mt10" id="transactions">
      <li class="ui-list-header text fn-clear">
        <span class="ui-list-title w60 fn-left type">姓名</span>
        <span class="ui-list-title w95 fn-left credit ui-list-title-sortable sortable" id="totalMoneySort">净资产</span>
        <span class="ui-list-title w95 fn-left debit">账户余额</span>
        <span class="ui-list-title w95 fn-left balance">账户欠款</span>
        <span class="ui-list-title w95 fn-left note">冻结资金</span>
        <span class="ui-list-title w140 fn-left note ui-list-title-sortable sortable" id="registerSort">注册时间</span>
        <span class="ui-list-title w140 fn-left note ui-list-title-sortable sortable" id="loginSort">登录时间</span>
      </li>
    </ul>
    <div class="fn-left mt10 fn-hide">共<span id="users-total">0</span>条</div>
    <div class="fn-right mt10 ui-pagination simple-pagination" id="users-list-pagination">
    </div>
  </div>
</div>