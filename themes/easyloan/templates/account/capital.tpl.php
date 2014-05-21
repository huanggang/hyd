<?php
drupal_add_css(drupal_get_path('theme','easyloan') . '/css/account.css');
drupal_add_js(drupal_get_path('theme','easyloan') . '/js/account.js');
global $base_url;
?>
<div class="fn-clear p20bs color-orange-bg">
  <div class="fn-left box-summary-left">
    <h3 class="text-xl">账户余额</h3>
    <p class="num color-orange-text"><em>0.00</em>元</p>
  </div>
  <div class="fn-left box-summary-right last mt10">
    <div class="fn-clear color-dimgray-text">
      <div class="grid_2 alpha">
        <h5 class="text-big">可用资金</h5>
        <p class="num-s"><em>0.00</em>元</p>
      </div>
      <div class="grid_2">
        <h5 class="text-big">已充值总额</h5>
        <p class="num-s"><em>0.00</em>元</p>
      </div>
      <div class="grid_2 omega">
        <a class="summary-button ui-button ui-button-small ui-button-green" href="<?php print $base_url;?>/capital_management/recharge">充值</a>
      </div>
    </div>
    <hr class="mt10">
    <div class="fn-clear color-dimgray-text mt10">
      <div class="grid_2 alpha">
        <h5 class="text-big">冻结资金</h5>
        <p class="num-s"><em>0.00</em>元</p>
      </div>
      <div class="grid_2">
        <h5 class="text-big">已提现总额</h5>
        <p class="num-s"><em>0.00</em>元</p>
      </div>
      <div class="grid_2 omega">
        <a class="summary-button ui-button ui-button-small ui-button-blue" href="<?php print $base_url;?>/capital_management/withdraw">提现</a>
      </div>
    </div>
  </div>
</div>
<div class="mt20 p20bs color-white-bg">
  <div class="fn-clear" id="query-form">
    <div class="fn-left">
      <div class="fn-left pr10">查询类型</div>
      <select class="fn-left mr20" name="type" autocomplete="off">
        <option value="ALL">所有</option>
        <option value="RECHARGE">充值</option>
        <option value="CASH_DRAW">提现</option>
        <option value="CHECKOUT">投资</option>
        <option value="REPAID">本金回收</option>
        <option value="REPAY">投资利息</option>
        <option value="OVER_DUE_FEE">投资逾期罚金</option>
        <option value="BORROW">借款</option>
        <option value="PAYBACK">还款本息</option>
        <option value="OVER_DUE_PAY">逾期罚款</option>
      </select>
      <div class="fn-left pr10">查询时间</div>
      <div class="fn-left mr20" id="query-normal">
        <select name="time" autocomplete="off">
          <option value="THREE_DAYS">三天以内</option>
          <option value="ONE_WEEK">一周以内</option>
          <option value="ONE_MONTH" selected="selected">一个月以内</option>
          <option value="THREE_MONTH">三个月以内</option>
          <option value="ONE_YEAR">一年以内</option>
        </select>
      </div>
      <div class="fn-left mr20" id="query-advanced" style="display: none;">
        <select name="year" autocomplete="off">
          <option value="2014" selected="selected">2014</option>
        <option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option></select>
        <span class="text">年</span>
        <select name="startMonth" autocomplete="off"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select>
        <span class="text">月 到 </span>
        <select name="endMonth" autocomplete="off"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select>
        <span class="text">月</span>
      </div>
      <a class="fn-left ui-button ui-button-small ui-button-blue" id="query-submit">查询</a>
    </div>
  </div>
  <hr class="mt20">
  <div class="mt10 fn-clear">
    <ul class="ui-list ui-list-s mt10" id="transactions">
      <li class="ui-list-header text fn-clear">
        <span class="ui-list-title w100 fn-left time">时间</span>
        <span class="ui-list-title w170 fn-left type">类型明细</span>
        <span class="ui-list-title w90 fn-left credit">收入</span>
        <span class="ui-list-title w90 fn-left debit">支出</span>
        <span class="ui-list-title w110 fn-left balance">结余</span>
        <span class="ui-list-title w160 fn-left note last">备注</span>
      </li>
      <li class="ui-list-status">
        <p class="color-gray-text">没有记录</p>
      </li>
    </ul>
    <div class="fn-right mt10 ui-pagination" id="transactions-pagination"></div>
  </div>
</div>