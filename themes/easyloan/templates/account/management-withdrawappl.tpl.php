<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

$js_path = $base_url . '/' . $theme_path . '/js/';
$image_path = $base_url . '/' . $theme_path . '/images/';

drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/itemlist.css');
drupal_add_css($theme_path . '/css/popuptip.css');
drupal_add_css($theme_path . '/css/withdrawappl.css');

drupal_add_js('var js_path=\'' . $js_path . '\';var image_path=\'' . $image_path . '\';', 'inline');
drupal_add_js($theme_path . '/js/banks.js');
drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/jquery.simplePagination.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/withdrawappl.js');
?>
<div class="color-white-bg" id="withdrawappl">
  <div class="ui-tab ui-tab-transparent">
    <ul class="ui-tab-items">
      <li class="ui-tab-item ui-tab-item-current" data-name="checking">
        <a class="ui-tab-item-link">未处理</a>
      </li>
      <li class="ui-tab-item" data-name="checked">
        <a class="ui-tab-item-link">已处理</a>
      </li>
    </ul>
  </div>
  <div class="p20bs color-white-bg">
    <div class="ui-tab-content ui-tab-content-current fn-clear" data-name="checking">
      <ul class="ui-list ui-list-s" id="withdrawapp-list-1">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w50 ph5 fn-left title">开户名</span>
          <span class="ui-list-title w90 ph5 fn-left">提现金额</span>
          <span class="ui-list-title w40 ph5 fn-left">费用</span>
          <span class="ui-list-title w100 ph5 fn-left">银行</span>
          <span class="ui-list-title w180 ph5 fn-left">卡号</span>
          <span class="ui-list-title w80 ph5 fn-left">申请日期</span>
          <span class="ui-list-title w60 ph5 fn-left"></span>
          <span class="ui-list-title w60 ph5 fn-left"></span>
        </li>
      </ul>
      <div class="fn-left mt10 fn-hide">共<span id="withdrawapp-total-1">0</span>条</div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="withdrawapp-list-pagination-1">
      </div>
    </div>
    <div class="ui-tab-content fn-clear" data-name="checked">
      <ul class="ui-list ui-list-s" id="withdrawapp-list-2">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w50 ph5 fn-left title">开户名</span>
          <span class="ui-list-title w90 ph5 fn-left">提现金额</span>
          <span class="ui-list-title w40 ph5 fn-left">费用</span>
          <span class="ui-list-title w100 ph5 fn-left">银行</span>
          <span class="ui-list-title w180 ph5 fn-left">卡号</span>
          <span class="ui-list-title w80 ph5 fn-left">申请日期</span>
          <span class="ui-list-title w80 ph5 fn-left">转账日期</span>
          <span class="ui-list-field w40 ph5 fn-left">转账</span>
        </li>
      </ul>
      <div class="fn-left mt10 fn-hide">共<span id="withdrawapp-total-2">0</span>条</div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="withdrawapp-list-pagination-2">
      </div>
    </div>
  </div>
</div>