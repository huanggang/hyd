<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/itemlist.css');

drupal_add_library('system', 'ui.dialog');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/application_status.js');
drupal_add_js($theme_path . '/js/jquery.simplePagination.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/applications.js');
?>
<div class="color-white-bg">
  <div class="ui-tab ui-tab-transparent">
    <ul class="ui-tab-items">
      <li class="ui-tab-item ui-tab-item-current" data-name="checking">
        <a class="ui-tab-item-link">审核中</a>
      </li>
      <li class="ui-tab-item" data-name="checked">
        <a class="ui-tab-item-link">已审核</a>
      </li>
    </ul>
  </div>
  <div class="p20bs color-white-bg">
    <div class="ui-tab-content ui-tab-content-current fn-clear" data-name="checking">
      <ul class="ui-list ui-list-s" id="check-list-1">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w260 ph5 fn-left">借款标题</span>
          <span class="ui-list-title w50 ph5 fn-left">借款人</span>
          <span class="ui-list-title w85 ph5 fn-left">计划用款</span>
          <span class="ui-list-title w30 ph5 fn-left">月数</span>
          <span class="ui-list-title w30 ph5 fn-left">状态</span>
          <span class="ui-list-title w80 ph5 fn-left">申请日期</span>
          <span class="ui-list-title w60 ph5 fn-left">备注</span>
          <span class="ui-list-title w60 ph5 fn-left"></span>
        </li>
      </ul>
      <div class="fn-left mt10 fn-hide">共<span id="check-total-1">0</span>条</div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="check-list-pagination-1">
      </div>
    </div>
    <div class="ui-tab-content fn-clear" data-name="checked">
      <ul class="ui-list ui-list-s" id="check-list-2">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w300 ph5 fn-left">借款标题</span>
          <span class="ui-list-title w50 ph5 fn-left">借款人</span>
          <span class="ui-list-title w85 ph5 fn-left">计划用款</span>
          <span class="ui-list-title w30 ph5 fn-left">月数</span>
          <span class="ui-list-title w30 ph5 fn-left">状态</span>
          <span class="ui-list-title w80 ph5 fn-left">申请日期</span>
          <span class="ui-list-title w60 ph5 fn-left">备注</span>
        </li>
      </ul>
      <div class="fn-left mt10 fn-hide">共<span id="check-total-2">0</span>条</div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="check-list-pagination-2">
      </div>
    </div>
  </div>
</div>