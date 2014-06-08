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
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/withdrawappl.js');
?>
<div class="color-white-bg" id="withdrawappl">
  <div class="ui-tab ui-tab-transparent" id="withdrawappl-tab">
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
    <div id="repayments-tab-content">
      <div class="ui-tab-content ui-tab-content-current fn-clear" data-name="checking">
        <ul class="ui-list ui-list-s" id="repaid-list-1">
        </ul>
        <div class="fn-left mt10" id="repaid-total-1"></div>
        <div class="fn-right mt10 ui-pagination simple-pagination" id="repaid-list-pagination-1">
        </div>
      </div>
      <div class="ui-tab-content fn-clear" data-name="checked">
        <ul class="ui-list ui-list-s" id="repaid-list-2">
        </ul>
        <div class="fn-left mt10" id="repaid-total-2"></div>
        <div class="fn-right mt10 ui-pagination simple-pagination" id="repaid-list-pagination-2">
        </div>
      </div>
    </div>
  </div>
</div>