<?php
global $base_url;

$theme_path = drupal_get_path('theme','easyloan');

drupal_add_css($theme_path . '/css/account.css');

drupal_add_js($theme_path . '/js/account.js');
drupal_add_js($theme_path . '/js/jquery.validate.min.js');
drupal_add_js($theme_path . '/js/loan_categories.js');
drupal_add_js($theme_path . '/js/repayment_methods.js');
drupal_add_js($theme_path . '/js/utils.js');
drupal_add_js($theme_path . '/js/loan_lend.js');
?>
<div class="loanapp loanapp p20bs color-white-bg">
  <div class="loanboder">
    <h3 class="text-xl">审定放款</h3>
    <div class="ui-form-item mt10">
      <label class="ui-label">借款标题</label>
      <span id="app_title"><a href="" target="blank" title=""></a></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label">借款人</label>
      <span id="app_name"><a href="" target="blank" title=""></a></span>
    </div>
    <div class="ui-form-item">
      <label class="ui-label">抵押类型</label>
      <span id="app_category"></span>
    </div>
  <div class="ui-form-item">
    <label class="ui-label">计划用款</label>
    <span id="app_amount"></span> 元
  </div>
  <div class="ui-form-item">
    <label class="ui-label">计划用款时间</label>
    <span id="app_duration"></span> 个月
  </div>
  <div class="ui-form-item">
    <label class="ui-label">申请日期</label>
    <span id="app_applied"></span>
  </div>
  <hr />
  <form class="ui-form" method="post" id="lendForm">
    <fieldset>
      <div class="ui-form-item mt20">
        <label class="ui-label">放款日期</label>
        <input class="ui-input" type="text" value="" name="loaned" id="loaned"> (例如: 2007/03/26)
      </div>
      <div class="ui-form-item">
        <label class="ui-label">借款金额</label>
        <input class="ui-input" type="text" value="" name="amount" id="amount"> 元
      </div>
      <div class="ui-form-item">
        <label class="ui-label">年利率</label>
        <input class="ui-input" type="text" value="" name="rate" id="rate"> %
      </div>
      <div class="ui-form-item">
        <label class="ui-label">还款方式</label>
        <select name="repayment_method" id="repayment_method">
        </select>
      </div>
      <div class="ui-form-item">
        <label class="ui-label">借款日期</label>
        <input class="ui-input" type="text" value="" name="start" id="start"> (例如: 2007/03/26)
      </div>
      <div class="ui-form-item">
        <label class="ui-label">还款日期</label>
        <input class="ui-input" type="text" value="" name="end" id="end"> (例如: 2007/03/26)
      </div>
      <div class="ui-form-item">
        <label class="ui-label">逾期日利率</label>
        <input class="ui-input" type="text" value="" name="fine_rate" id="fine_rate"> %
      </div>
      <div class="ui-form-item">
        <label class="ui-label">逾期日利率计算方式</label>
        <input type="radio" class="fine_rate_is_single" name="fine_rate_is_single" value="1" checked="checked">单利
        <input type="radio" class="fine_rate_is_single" name="fine_rate_is_single" value="0">复利
      </div>
      <div class="ui-form-item">
        <input type="submit" class="ui-button ui-button-blue ui-button-mid" value="审定放款" id="apply">
      </div>
    </fieldset>
  </form>
</div>