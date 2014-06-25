<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');
drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/itemlist.css');

drupal_add_js($theme_path . '/js/jquery.simplePagination.js');
drupal_add_js($theme_path . '/js/application_status.js');
drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/tab.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/myloan.js');

?>
<div class="fn-clear p20bs color-orange-bg">
  <div class="fn-left box-summary-left">
    <h3 class="text-xl">已还利息总额</h3>
    <p class="num color-orange-text"><em id="paid-interest"></em>元</p>
    <p class="text-small">
      <span class="pr5">加权平均年利率</span>
      <span class="num-s"><em id="average-rate"></em>%</span>
    </p>
    <h3 class="text-xl mt20">待还本息罚金</h3>
    <p class="num color-orange-text"><em id="owned-total"></em>元</p>
  </div>
  <div class="fn-left box-summary-right ph20">
    <div>
      <div class="fn-left">
        <h3 class="text-xl">已还逾期罚金总额</h3>
        <p class="num color-orange-text"><em id="paid-fine"></em>元</p>
        <p class="text-small">
          <span class="pr5">加权平均借款期限</span>
          <span class="num-s"><em id="average-duration"></em>月</span>
        </p>
      </div>
      <div class="fn-left ph20">
        <h3 class="text-xl">借款总额</h3>
        <p class="num color-orange-text"><em id="loan-total"></em>元</p>
        <p class="text-small">
          <span class="pr5">借款总次数</span>
          <span class="num-s"><em id="loan-times"></em>次</span>
        </p>
      </div>
      <div class="fn-clear"></div>
    </div>
    <hr class="mt20">
    <p class="em-box color-dimgray-text mt10" id="next-pay"></p>
    <p class="em-box color-dimgray-text" id="owned-now"></p>
  </div>
</div>
<div class="mt20">
  <div class="ui-tab ui-tab-transparent">
    <ul class="ui-tab-items">
      <li class="ui-tab-item ui-tab-item-current" data-name="loan">
        <a class="ui-tab-item-link">我的借款</a>
      </li>
      <li class="ui-tab-item" data-name="loanapp">
        <a class="ui-tab-item-link">借款申请</a>
      </li>
    </ul>
  </div>
  <div class="p20bs color-white-bg">
    <div class="ui-tab-content fn-clear ui-tab-content-current" data-name="loan">
      <ul class="ui-list ui-list-s" id="loan-list-2">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w220 ph5 fn-left">借款标题</span>
          <span class="ui-list-title w85 ph5 fn-left">借款金额</span>
          <span class="ui-list-title w85 ph5 fn-left">借款利息</span>
          <span class="ui-list-title w55 ph5 fn-left">年利率</span>
          <span class="ui-list-title w30 ph5 fn-left">月数</span
          ><span class="ui-list-title w80 ph5 fn-left">借款日期</span>
          <span class="ui-list-title w80 ph5 fn-left">到期日期</span>
          <span class="ui-list-title w30 fn-left">还清</span>
        </li>
        <li class="ui-list-status" id="rowempty2">
          <p class="color-gray-text">没有记录</p>
        </li>
      </ul>
      <div class="fn-left mt10">共<span id="loan-total-2">0</span>条</div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="loan-list-pagination-2">
      </div>
    </div>
    <div class="ui-tab-content fn-clear" data-name="loanapp">
      <ul class="ui-list ui-list-s" id="loan-list-3">
        <li class="ui-list-header color-gray-text fn-clear">
          <span class="ui-list-title w300 ph5 fn-left">借款标题</span>
          <span class="ui-list-title w80 ph5 fn-left">计划用款</span>
          <span class="ui-list-title w30 ph5 fn-left">月数</span>
          <span class="ui-list-title w60 ph5 fn-left">申请状态</span>
          <span class="ui-list-title w60 ph5 fn-left">是否放款</span>
          <span class="ui-list-title w60 ph5 fn-left">是否结束</span>
          <span class="ui-list-title w80 ph5 fn-left">申请时间</span>
        </li>
        <li class="ui-list-status" id="rowempty3">
          <p class="color-gray-text">没有记录</p>
        </li>
      </ul>
      <div class="fn-left mt10">共<span id="loan-total-3">0</span>条</div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="loan-list-pagination-3">
      </div>
    </div>
  </div>
</div>