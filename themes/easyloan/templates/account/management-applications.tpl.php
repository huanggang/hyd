<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/itemlist.css');

drupal_add_library('system', 'ui.dialog');

drupal_add_js($theme_path . '/js/application_status.js');
drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/tab.js');
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
      </ul>
      <div class="fn-left mt10" id="check-total-1"></div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="check-list-pagination-1">
      </div>
    </div>
    <div class="ui-tab-content fn-clear" data-name="checked">
      <ul class="ui-list ui-list-s" id="check-list-2">
      </ul>
      <div class="fn-left mt10" id="check-total-2"></div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="check-list-pagination-2">
      </div>
    </div>
  </div>
</div>