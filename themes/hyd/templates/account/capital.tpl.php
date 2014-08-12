<?php
global $base_url;
global $user;

$current_user = $variables["elements"]["#account"];

$is_my_page = ($current_user->uid == $user->uid);

$theme_path = drupal_get_path('theme','hyd');

drupal_add_css($theme_path . '/css/account.css');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/transaction_types.js');
drupal_add_js($theme_path . '/js/transaction_time_ranges.js');
drupal_add_js($theme_path . '/js/jquery.simplePagination.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/transactions.js');
?>

<div class="fn-clear p20bs color-orange-bg">
  <div class="fn-left box-summary-left">
    <h3 class="text-xl">账户余额</h3>
    <p class="num color-orange-text"><em id="available"></em>元</p>
    <h3 class="text-xl">冻结资金</h3>
    <p class="num color-orange-text"><em id="frozen"></em>元</p>
  </div>
  <div class="fn-left box-summary-right last mt10">
    <div class="fn-clear color-dimgray-text">
      <div class="grid_2 alpha">
        <h5 class="text-big">已充值总额</h5>
        <p class="num-s"><em id="savings"></em>元</p>
      </div>
      <div class="grid_2">
        <h5 class="text-big">充值总费用</h5>
        <p class="num-s"><em id="sv_fee"></em>元</p>
      </div>
      <div class="grid_2 omega">
        <?php if ($is_my_page){ ?>
        <a class="summary-button ui-button ui-button-small ui-button-green" href="<?php print $base_url;?>/capital_management/recharge">充值</a>
        <?php } ?>
      </div>
    </div>
    <hr class="mt10">
    <div class="fn-clear color-dimgray-text mt10">
      <div class="grid_2 alpha">
        <h5 class="text-big">已提现总额</h5>
        <p class="num-s"><em id="withdraws"></em>元</p>
      </div>
      <div class="grid_2">
        <h5 class="text-big">提现总费用</h5>
        <p class="num-s"><em id="wth_fee"></em>元</p>
      </div>
      <div class="grid_2 omega">
        <?php if ($is_my_page){ ?>
        <a class="summary-button ui-button ui-button-small ui-button-blue" href="<?php print $base_url;?>/capital_management/withdraw">提现</a>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<div class="mt20 p20bs color-white-bg">
  <div class="fn-clear">
    <div class="fn-left">
      <div class="fn-left pr10">查询类型</div>
      <select class="fn-left mr20" name="type" autocomplete="off" id="transaction_type">
        <option value="-1">所有</option>
      </select>
      <div class="fn-left pr10">查询时间</div>
      <div class="fn-left mr20">
        <select name="time" autocomplete="off" id="transaction_range">
        </select>
      </div>
      <a class="fn-left ui-button ui-button-small ui-button-blue" id="query-submit">查询</a>
    </div>
  </div>
  <hr class="mt20">
  <div class="mt10 fn-clear">
    <ul class="ui-list ui-list-s mt10" id="transaction-list">
      <li class="ui-list-header text fn-clear">
        <span class="ui-list-title w120 fn-left">时间</span>
        <span class="ui-list-title w90 ph5 fn-left">类型明细</span>
        <span class="ui-list-title w85 ph5 fn-left">收入</span>
        <span class="ui-list-title w85 ph5 fn-left">支出</span>
        <span class="ui-list-title w85 ph5 fn-left">账户余额</span>
        <span class="ui-list-title w85 ph5 fn-left">所欠金额</span>
        <span class="ui-list-title w80 ph5 fn-left">所欠罚金</span>
        <span class="ui-list-title w50 fn-left">手续费</span>
      </li>
    </ul>
    <div class="fn-left mt10 fn-hide">共<span id="transaction-total">0</span>条</div>
    <div class="fn-right mt10 ui-pagination" id="transaction-list-pagination"></div>
  </div>
</div>