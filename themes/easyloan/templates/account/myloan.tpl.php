<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/tab.css');
drupal_add_css($theme_path . '/css/itemlist.css');

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
      </ul>
      <div class="fn-left mt10" id="loan-total-2"></div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="loan-list-pagination-2">
      </div>
    </div>
    <div class="ui-tab-content fn-clear" data-name="loanapp">
      <ul class="ui-list ui-list-s" id="loan-list-3">
      </ul>
      <div class="fn-left mt10" id="loan-total-3"></div>
      <div class="fn-right mt10 ui-pagination simple-pagination" id="loan-list-pagination-3">
      </div>
    </div>
  </div>
</div>