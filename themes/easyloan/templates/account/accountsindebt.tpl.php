<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/account.css');
drupal_add_css($theme_path . '/css/itemlist.css');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/jquery.simplePagination.js');
drupal_add_js($theme_path . '/js/accounts_in_debt.js');
?>
<div class="p20bs color-white-bg">
  <div class="fn-clear">
    <h3 class="text-xl">欠款账户</h3>
    <ul class="ui-list ui-list-s mt10" id="debtor-list">
      <li class="ui-list-header color-gray-text fn-clear">
        <span class="ui-list-title fn-left ph5 w50">姓名</span>
        <span class="ui-list-title fn-left ph5 w95">欠款金额</span>
        <span class="ui-list-title fn-left ph5 w85">欠款罚金</span>
        <span class="ui-list-title fn-left ph5 w210">借款标题</span>
        <span class="ui-list-title fn-left ph5 w85">借款金额</span>
        <span class="ui-list-title fn-left ph5 w80">到期日期</span>
        <span class="ui-list-title fn-left ph5 w60">还款记录</span>
      </li>
    </ul>
    <div class="fn-left mt10 fn-hide">共<span id="debtor-total">0</span>条</div>
    <div class="fn-right mt10 ui-pagination simple-pagination" id="debtor-list-pagination">
  </div>
</div>