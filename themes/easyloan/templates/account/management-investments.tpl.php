<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/itemlist.css');

drupal_add_library('system', 'ui.dialog');

drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/investments.js');
?>
<div class="color-white-bg">
  <div class="ui-tab ui-tab-transparent">
    <ul class="ui-tab-items">
      <li class="ui-tab-item ui-tab-item-current" data-name="notyet">
        <a class="ui-tab-item-link">未发布</a>
      </li>
      <li class="ui-tab-item" data-name="investing">
        <a class="ui-tab-item-link">投资中</a>
      </li>
      <li class="ui-tab-item" data-name="finished">
        <a class="ui-tab-item-link">已结束</a>
      </li>
    </ul>
  </div>
  <div class="p20bs color-white-bg">
    <div class="ui-tab-content ui-tab-content-current fn-clear" data-name="notyet">
      <ul class="ui-list ui-list-s" id="investment-list-1">
      </ul>
      <div class="fn-left mt10" id="investment-total-1"></div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="investment-list-pagination-1">
      </div>
    </div>
    <div class="ui-tab-content fn-clear" data-name="investing">
      <ul class="ui-list ui-list-s" id="investment-list-2">
      </ul>
      <div class="fn-left mt10" id="investment-total-2"></div>
      <div class="fn-right mt10" id="investment-list-pagination-2">
      </div>
    </div>
    <div class="ui-tab-content fn-clear" data-name="finished">
      <ul class="ui-list ui-list-s" id="investment-list-3">
      </ul>
      <div class="fn-left mt10" id="investment-total-3"></div>
      <div class="fn-right mt10" id="investment-list-pagination-3">
      </div>
    </div>
  </div>
</div>