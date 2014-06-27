<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/account.css');
drupal_add_css($theme_path . '/css/tab.css');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/jquery.simplePagination.js');
drupal_add_js($theme_path . '/js/myinvestment.js');
?>
<div class="p20bs color-orange-bg fn-clear">
  <div class="fn-left box-summary-left">
    <h3 class="text-xl">投资计划已赚总额</h3>
    <p class="num color-orange-text"><em>0.00</em>元</p>
    <p class="text-small">
      <span class="pr5">账户总资产</span>
      <span class="num-s"><em>0.00</em>元</span>
    </p>
    <p class="text-small">
      <span class="pr5">平均年收益率</span>
      <span class="num-s"><em>0.00</em>%</span>
    </p>
  </div>
  <div class="fn-left box-summary-right last">
    <div class="fn-clear mt10 color-dimgray-text">
      <div class="grid_2 alpha">
        <h5 class="text-big">持有中的投资产品数量</h5>
        <p class="num-s"><em>0</em>个</p>
      </div>
      <div class="grid_2 omega">
        <h5 class="text-big">已结束的投资产品数量</h5>
        <p class="num-s"><em>0</em>个</p>
      </div>
    </div>
  </div>
</div>
<div class="mt20">
  <div class="ui-tab ui-tab-transparent" id="plans-tab">
    <ul class="ui-tab-items">
      <li class="ui-tab-item ui-tab-item-current" data-name="holding">
        <a class="ui-tab-item-link">持有中的投资产品</a>
      </li>
      <li class="ui-tab-item" data-name="exited">
        <a class="ui-tab-item-link">已结束的投资产品</a>
      </li>
    </ul>
  </div>
  <div class="p20bs color-white-bg">
  <div id="plans-tab-content">
  <div class="ui-tab-content fn-clear ui-tab-content-current" data-name="holding">
  <ul class="ui-list ui-list-s" id="holding-list">
  <li class="ui-list-header color-gray-text fn-clear">
  <span class="ui-list-title w70 fn-left fn-text-overflow">借款标题</span>
  <span class="ui-list-title w70 fn-left">抵押类型</span>
  <span class="ui-list-title w70 fn-left">投资金额</span>
  <span class="ui-list-title w70 fn-left">预期收益</span>
  <span class="ui-list-title w70 fn-left">年利率</span>
  <span class="ui-list-title w70 fn-left">还款方式</span>
  <span class="ui-list-title w70 fn-left">投资期限</span>
  <span class="ui-list-title w70 fn-left">成立日期</span>
  <span class="ui-list-title w70 fn-left">到期日期</span>
  <span class="ui-list-title w70 fn-left last">进度</span>
  </li>

  <li class="ui-list-status">
  <p class="color-gray-text">没有持有中的投资产品</p>
  </li>

  </ul>
  <div class="fn-right mt10" id="holding-list-pagination"></div>
  </div>
  <div class="ui-tab-content fn-clear" data-name="exited">
    <ul class="ui-list ui-list-s" id="exited-list">
      <li class="ui-list-header color-gray-text fn-clear">
        <span class="ui-list-title w70 fn-left fn-text-overflow">借款标题</span>
        <span class="ui-list-title w70 fn-left">抵押类型</span>
        <span class="ui-list-title w70 fn-left">投资金额</span>
        <span class="ui-list-title w70 fn-left">已赚金额</span>
        <span class="ui-list-title w70 fn-left">年利率</span>
        <span class="ui-list-title w70 fn-left">还款方式</span>
        <span class="ui-list-title w70 fn-left">投资期限</span>
        <span class="ui-list-title w70 fn-left">成立日期</span>
        <span class="ui-list-title w70 fn-left">到期日期</span>
        <span class="ui-list-title w70 fn-left">结束日期</span>
      </li>
      <li class="ui-list-status">
        <p class="color-gray-text">没有已结束的投资产品</p>
      </li>
    </ul>
    <div class="fn-right mt10" id="exited-list-pagination"></div>
  </div>
  </div>
  </div>
</div>