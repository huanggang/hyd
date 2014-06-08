<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/tab.css');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/tab.js');
?>
<div class="fn-clear p20bs color-orange-bg">
  <div class="fn-left box-summary-left">
    <h3 class="text-xl">已还利息总额</h3>
    <p class="num color-orange-text"><em>25,998.00</em>元</p>
    <p class="text-small">
      <span class="pr5">加权平均年利率</span>
      <span class="num-s"><em>12.88</em>%</span>
    </p>
    <h3 class="text-xl mt20">待还本息</h3>
    <p class="num color-orange-text"><em>39,888.45</em>元</p>
  </div>
  <div class="fn-left box-summary-right ph20">
    <div>
      <div class="fn-left">
        <h3 class="text-xl">已还逾期罚金总额</h3>
        <p class="num color-orange-text"><em>5,700.98</em>元</p>
        <p class="text-small">
          <span class="pr5">加权平均借款期限</span>
          <span class="num-s"><em>3.52</em>月</span>
        </p>
      </div>
      <div class="fn-left ph20">
        <h3 class="text-xl">借款总额</h3>
        <p class="num color-orange-text"><em>5,700.98</em>元</p>
        <p class="text-small">
          <span class="pr5">借款总次数</span>
          <span class="num-s"><em>5</em>次</span>
        </p>
      </div>
      <div class="fn-clear"></div>
    </div>
    <hr class="mt20">
    <p class="em-box color-dimgray-text mt20">下次还款日期 <em>2014-05-18</em>，应还本息 <em>5700.98</em>元</p>
  </div>
</div>
<div class="mt20">
  <div class="ui-tab ui-tab-transparent" id="loans-tab">
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
    <div id="loans-tab-content">
      <div class="ui-tab-content fn-clear ui-tab-content-current" data-name="loan">
        <ul class="ui-list ui-list-s" id="loan-list-2">
          <li class="ui-list-header color-gray-text fn-clear">
            <span class="ui-list-title w200 ph5 fn-left">借款标题</span>
            <span class="ui-list-title w70 ph5 fn-left">借款金额</span>
            <span class="ui-list-title w70 ph5 fn-left">借款利息</span>
            <span class="ui-list-title w55 ph5 fn-left">年利率</span>
            <span class="ui-list-title w30 ph5 fn-left">月数</span>
            <span class="ui-list-title w80 ph5 fn-left">借款日期</span>
            <span class="ui-list-title w80 ph5 fn-left">到期日期</span>
            <span class="ui-list-title w80 fn-left">还清日期</span>
          </li>
          <li class="ui-list-item fn-clear dark">
            <span class="ui-list-field w200 ph5 fn-left">(房) 借款标题借款标题借款标题</span>
            <span class="ui-list-field w70 ph5 fn-left text-right">1,000,000</span>
            <span class="ui-list-field w70 ph5 fn-left text-right">100,000</span>
            <span class="ui-list-field w55 ph5 fn-left text-right">12.50%</span>
            <span class="ui-list-field w30 ph5 fn-left text-right">3</span>
            <span class="ui-list-field w80 ph5 fn-left text-center">2014-01-01</span>
            <span class="ui-list-field w80 ph5 fn-left text-center">2014-04-09</span>
            <span class="ui-list-field w80 fn-left text-center">2014-04-09</span>
          </li>
          <li class="ui-list-status">
            <p class="color-gray-text">没有记录</p>
          </li>
        </ul>
        <div class="fn-left mt10" id="loan-total-2"></div>
        <div class="fn-right mt10" id="loan-list-pagination-2">
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
          <li class="ui-list-item fn-clear dark">
            <span class="ui-list-field w300 ph5 fn-left">(房) 借款标题借款标题借款标题</span>
            <span class="ui-list-field w80 ph5 fn-left text-right">1,000,000</span>
            <span class="ui-list-field w30 ph5 fn-left text-right">3</span>
            <span class="ui-list-field w60 ph5 fn-left text-center">申请</span>
            <span class="ui-list-field w60 ph5 fn-left text-center">否</span>
            <span class="ui-list-field w60 ph5 fn-left text-center">是</span>
            <span class="ui-list-field w80 fn-left text-center">2014-04-09</span>
          </li>
          <li class="ui-list-status">
            <p class="color-gray-text">没有记录</p>
          </li>
        </ul>
        <div class="fn-left mt10" id="loan-total-3"></div>
        <div class="fn-right mt10" id="loan-list-pagination-3">
        </div>
      </div>
    </div>
  </div>
</div>