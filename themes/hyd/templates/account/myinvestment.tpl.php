<?php
global $base_url;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/itemlist.css');
drupal_add_css($theme_path . '/css/myinvestment.css');

drupal_add_library('system', 'ui.dialog');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/repayment_methods.js');
drupal_add_js($theme_path . '/js/jquery.simplePagination.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/myinvestment.js');
?>
<div class="p20bs color-orange-bg fn-clear">
  <div class="fn-left box-summary-left w250">
    <h3 class="text-xl">投资已赚总额</h3>
    <p class="num color-orange-text"><em id="investment_earnings"></em>元</p>
    <p class="text-small">
      <span class="pr5">加权平均年利率</span>
      <span class="num-s"><em id="investment_rate"></em>%</span>
    </p>
    <p class="text-small">
      <span class="pr5">加权平均投资期限</span>
      <span class="num-s"><em id="investment_duration"></em>个月</span>
    </p>
  </div>
  <div class="fn-left box-summary-right last">
    <div class="fn-clear mt10 color-dimgray-text">
      <div class="grid_2 alpha">
        <h5 class="text-big">持有投资产品数</h5>
        <p class="num-s"><em id="investment_holdings"></em>个</p>
      </div>
      <div class="grid_2 omega">
        <h5 class="text-big">已结束投资产品数</h5>
        <p class="num-s"><em id="investment_closed"></em>个</p>
      </div>
    </div>
  </div>
</div>

<div class="mt20">
  <div class="ui-tab ui-tab-transparent">
    <ul class="ui-tab-items">
      <li class="ui-tab-item ui-tab-item-current" data-name="open">
        <a class="ui-tab-item-link">募集中投资产品</a>
      </li>
      <li class="ui-tab-item" data-name="holding">
        <a class="ui-tab-item-link">持有投资产品</a>
      </li>
      <li class="ui-tab-item" data-name="closed">
        <a class="ui-tab-item-link">已结束投资产品</a>
      </li>
    </ul>
  </div>

  <div class="p20bs color-white-bg">
    <div>
      <div class="ui-tab-content fn-clear ui-tab-content-current" data-name="open">
        <ul class="ui-list ui-list-s" id="investment-list-2">
          <li class="ui-list-header color-gray-text fn-clear">
            <span class="ui-list-title fn-left w180 ph5">借款标题</span>
            <span class="ui-list-title fn-left w85 ph5">投资金额</span>
            <span class="ui-list-title fn-left w115 ph5">还款方式</span>
            <span class="ui-list-title fn-left w55 ph5">年利率</span>
            <span class="ui-list-title fn-left w30 ph5">月数</span>
            <span class="ui-list-title fn-left w80 ph5">成立日期</span>
            <span class="ui-list-title fn-left w80 ph5">到期日期</span>
          </li>
        </ul>
        <div class="fn-left mt10 fn-hide">共<span id="investment-total-2">0</span>条</div>
        <div class="fn-right mt10 ui-pagination simple-pagination" id="investment-list-pagination-2"></div>
      </div>

      <div class="ui-tab-content fn-clear" data-name="holding">
        <ul class="ui-list ui-list-s" id="investment-list-3">
          <li class="ui-list-header color-gray-text fn-clear">
            <span class="ui-list-title fn-left w140 ph5">借款标题</span>
            <span class="ui-list-title fn-left w85 ph5">投资金额</span>
            <span class="ui-list-title fn-left w85 ph5">预期收益</span>
            <span class="ui-list-title fn-left w55 ph5">年利率</span>
            <span class="ui-list-title fn-left w30 ph5">月数</span>
            <span class="ui-list-title fn-left w80 ph5">成立日期</span>
            <span class="ui-list-title fn-left w80 ph5">到期日期</span>
            <span class="ui-list-title fn-left w30 ph5">进度</span>
            <span class="ui-list-title fn-left w60 ph5"></span>
          </li>
        </ul>
        <div class="fn-left mt10 fn-hide">共<span id="investment-total-3">0</span>条</div>
        <div class="fn-right mt10 ui-pagination simple-pagination" id="investment-list-pagination-3"></div>
      </div>

      <div class="ui-tab-content fn-clear" data-name="closed">
        <ul class="ui-list ui-list-s" id="investment-list-4">
          <li class="ui-list-header color-gray-text fn-clear">
            <span class="ui-list-title fn-left w180 ph5">借款标题</span>
            <span class="ui-list-title fn-left w85 ph5">投资金额</span>
            <span class="ui-list-title fn-left w85 ph5">已赚金额</span>
            <span class="ui-list-title fn-left w55 ph5">年利率</span>
            <span class="ui-list-title fn-left w30 ph5">月数</span>
            <span class="ui-list-title fn-left w80 ph5">成立日期</span>
            <span class="ui-list-title fn-left w80 ph5">到期日期</span>
            <span class="ui-list-title fn-left w60 ph5"></span>
          </li>
        </ul>
        <div class="fn-left mt10 fn-hide">共<span id="investment-total-4">0</span>条</div>
        <div class="fn-right mt10 ui-pagination simple-pagination" id="investment-list-pagination-4"></div>
      </div>
    </div>
  </div>
</div>