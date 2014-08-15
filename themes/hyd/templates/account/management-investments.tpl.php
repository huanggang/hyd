<?php
global $base_url;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/itemlist.css');

drupal_add_library('system', 'ui.dialog');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/jquery.simplePagination.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/investments.js');
?>
<div class="color-white-bg">
  <div class="ui-tab ui-tab-transparent">
    <ul class="ui-tab-items">
      <li class="ui-tab-item ui-tab-item-current" data-name="notyet">
        <a class="ui-tab-item-link">未发布</a>
      </li>
      <li class="ui-tab-item" data-name="preinvesting">
        <a class="ui-tab-item-link">募集中</a>
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
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w260 ph5 fn-left">借款标题</span>
          <span class="ui-list-title w50 ph5 fn-left">借款人</span>
          <span class="ui-list-title w85 ph5 fn-left">借款金额</span>
          <span class="ui-list-title w55 ph5 fn-left">年利率</span>
          <span class="ui-list-title w30 ph5 fn-left">月数</span>
          <span class="ui-list-title w80 ph5 fn-left">放款日期</span>
          <span class="ui-list-title w50 ph5 fn-left"></span>
          <span class="ui-list-title w50 ph5 fn-left"></span>
        </li>
      </ul>
      <div class="fn-left mt10 fn-hide">共<span id="investment-total-1">0</span>条</div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="investment-list-pagination-1">
      </div>
    </div>
    <div class="ui-tab-content fn-clear" data-name="preinvesting">
      <ul class="ui-list ui-list-s" id="investment-list-2">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w130 ph5 fn-left">借款标题</span>
          <span class="ui-list-title w50 ph5 fn-left">借款人</span>
          <span class="ui-list-title w85 ph5 fn-left">计划金额</span>
          <span class="ui-list-title w85 ph5 fn-left">募集金额</span>
          <span class="ui-list-title w55 ph5 fn-left">年利率</span>
          <span class="ui-list-title w30 ph5 fn-left">月数</span>
          <span class="ui-list-title w80 ph5 fn-left">成立日期</span>
          <span class="ui-list-title w80 ph5 fn-left">发布日期</span>
          <span class="ui-list-title w50 ph5 fn-left">详细</span>
        </li>
      </ul>
      <div class="fn-left mt10 fn-hide">共<span id="investment-total-2">0</span>条</div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="investment-list-pagination-2">
      </div>
    </div>
    <div class="ui-tab-content fn-clear" data-name="investing">
      <ul class="ui-list ui-list-s" id="investment-list-3">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w130 ph5 fn-left">借款标题</span>
          <span class="ui-list-title w50 ph5 fn-left">借款人</span>
          <span class="ui-list-title w85 ph5 fn-left">计划金额</span>
          <span class="ui-list-title w85 ph5 fn-left">募集金额</span>
          <span class="ui-list-title w55 ph5 fn-left">年利率</span>
          <span class="ui-list-title w30 ph5 fn-left">月数</span>
          <span class="ui-list-title w80 ph5 fn-left">到期日期</span>
          <span class="ui-list-title w80 ph5 fn-left">发布日期</span>
          <span class="ui-list-title w50 ph5 fn-left">详细</span>
        </li>
      </ul>
      <div class="fn-left mt10 fn-hide">共<span id="investment-total-3">0</span>条</div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="investment-list-pagination-3">
      </div>
    </div>
    <div class="ui-tab-content fn-clear" data-name="finished">
      <ul class="ui-list ui-list-s" id="investment-list-4">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w130 ph5 fn-left">借款标题</span>
          <span class="ui-list-title w50 ph5 fn-left">借款人</span>
          <span class="ui-list-title w85 ph5 fn-left">计划金额</span>
          <span class="ui-list-title w85 ph5 fn-left">募集金额</span>
          <span class="ui-list-title w55 ph5 fn-left">年利率</span>
          <span class="ui-list-title w30 ph5 fn-left">月数</span>
          <span class="ui-list-title w80 ph5 fn-left">到期日期</span>
          <span class="ui-list-title w80 ph5 fn-left">发布日期</span>
          <span class="ui-list-title w50 ph5 fn-left">详细</span>
        </li>
      </ul>
      <div class="fn-left mt10 fn-hide">共<span id="investment-total-4">0</span>条</div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="investment-list-pagination-4">
      </div>
    </div>
  </div>
</div>