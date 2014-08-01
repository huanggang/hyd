<?php
global $base_url;

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/account.css');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/transaction_types.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/accounts_in_debt_detail.js');
?>
<div class="p20bs color-white-bg">
  <div class="fn-clear">
    <h3 class="text-xl">还款记录</h3>
    <div class="fn-right"><a href="" target="_blank" class="ui-button ui-button-small ui-button-blue" id="btn_transactions">查看交易记录</a></div><div class="fn-clear"></div>

    <ul class="ui-list ui-list-s mt10" id="debt-list">
      <li class="ui-list-header color-gray-text fn-clear">
        <span class="ui-list-title w80 ph5 fn-left">日期</span>
        <span class="ui-list-title w90 ph5 fn-left">类型明细</span>
        <span class="ui-list-title w85 ph5 fn-left">收入</span>
        <span class="ui-list-title w90 ph5 fn-left">支出</span>
        <span class="ui-list-title w90 ph5 fn-left">账户余额</span>
        <span class="ui-list-title w90 ph5 fn-left">所欠金额</span>
        <span class="ui-list-title w85 ph5 fn-left">所欠罚金</span>
        <span class="ui-list-title w50 ph5 fn-left">手续费</span>
      </li>
    </ul>
    <div class="fn-left mt10 fn-hide">共<span id="debt-total">0</span>条</div>
  </div>
</div>